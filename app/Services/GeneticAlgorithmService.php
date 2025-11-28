<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Timeslot;
use Illuminate\Support\Collection;

class GeneticAlgorithmService
{
    protected $courses;
    protected $lecturers;
    protected $rooms;
    protected $timeslots;
    protected $populationSize;
    protected $mutationRate;
    protected $crossoverRate;
    protected $elitismCount;

    public function __construct($populationSize = 50, $mutationRate = 0.1, $crossoverRate = 0.8, $elitismCount = 2)
    {
        $this->populationSize = $populationSize;
        $this->mutationRate = $mutationRate;
        $this->crossoverRate = $crossoverRate;
        $this->elitismCount = $elitismCount;
    }

    public function initializeData()
    {
        $this->courses = Course::all();
        $this->lecturers = Lecturer::all();
        $this->rooms = Room::all();
        $this->timeslots = Timeslot::all();
    }

    public function generatePopulation()
    {
        $population = [];
        for ($i = 0; $i < $this->populationSize; $i++) {
            $population[] = $this->createIndividual();
        }
        return $population;
    }

    protected function createIndividual()
    {
        $schedule = [];
        foreach ($this->courses as $course) {
            // Assign a random lecturer, room, and timeslot
            // In a real scenario, lecturer might be pre-assigned to course
            // For now, we assume course has a designated lecturer or we pick one randomly if not
            // But usually Course-Lecturer is a fixed constraint.
            // Let's assume for now we just pick a random room and timeslot for the course.
            
            // We need to handle classes (e.g. Course A Class A, Course A Class B)
            // For simplicity, let's assume 1 course = 1 class for now, or we iterate classes.
            
            $schedule[] = [
                'course_id' => $course->id,
                'lecturer_id' => $this->lecturers->random()->id, // Should be fixed per course ideally
                'room_id' => $this->rooms->random()->id,
                'timeslot_id' => $this->timeslots->random()->id,
                'class_name' => 'A', // Placeholder
            ];
        }
        return $schedule;
    }

    public function calculateFitness($individual)
    {
        $hardConflicts = 0;
        $softConflicts = 0;

        // Hard Constraints
        $lecturerSlots = [];
        $roomSlots = [];

        foreach ($individual as $gene) {
            $lecturerId = $gene['lecturer_id'];
            $roomId = $gene['room_id'];
            $timeslotId = $gene['timeslot_id'];

            // Check Lecturer Conflict
            if (isset($lecturerSlots[$lecturerId][$timeslotId])) {
                $hardConflicts++;
            }
            $lecturerSlots[$lecturerId][$timeslotId] = true;

            // Check Room Conflict
            if (isset($roomSlots[$roomId][$timeslotId])) {
                $hardConflicts++;
            }
            $roomSlots[$roomId][$timeslotId] = true;

            // Soft Constraints: Lecturer Preferences
            $lecturer = $this->lecturers->find($lecturerId);
            $timeslot = $this->timeslots->find($timeslotId);
            
            if ($lecturer && !empty($lecturer->preferred_days)) {
                if (!in_array($timeslot->day, $lecturer->preferred_days)) {
                    $softConflicts++;
                }
            }
        }

        // Weighted fitness: Hard constraints have high penalty (10), Soft constraints low (1)
        return 1 / (($hardConflicts * 10) + $softConflicts + 1);
    }
    
    public function run($generations = 100)
    {
        $this->initializeData();
        $population = $this->generatePopulation();

        for ($g = 0; $g < $generations; $g++) {
            // Sort by fitness
            usort($population, function ($a, $b) {
                return $this->calculateFitness($b) <=> $this->calculateFitness($a);
            });

            // Check if we have a perfect solution
            if ($this->calculateFitness($population[0]) == 1) {
                break;
            }

            $newPopulation = [];

            // Elitism
            for ($i = 0; $i < $this->elitismCount; $i++) {
                $newPopulation[] = $population[$i];
            }

            // Crossover & Mutation
            while (count($newPopulation) < $this->populationSize) {
                $parent1 = $population[rand(0, $this->populationSize / 2)]; // Pick from top half
                $parent2 = $population[rand(0, $this->populationSize / 2)];

                $child = $this->crossover($parent1, $parent2);
                $child = $this->mutation($child);

                $newPopulation[] = $child;
            }

            $population = $newPopulation;
        }

        // Return best schedule
        usort($population, function ($a, $b) {
            return $this->calculateFitness($b) <=> $this->calculateFitness($a);
        });

        return $population[0];
    }

    protected function crossover($parent1, $parent2)
    {
        $crossoverPoint = rand(0, count($parent1));
        $child = array_merge(
            array_slice($parent1, 0, $crossoverPoint),
            array_slice($parent2, $crossoverPoint)
        );
        return $child;
    }

    protected function mutation($individual)
    {
        if (rand(0, 100) / 100 < $this->mutationRate) {
            $geneIndex = rand(0, count($individual) - 1);
            $individual[$geneIndex]['room_id'] = $this->rooms->random()->id;
            $individual[$geneIndex]['timeslot_id'] = $this->timeslots->random()->id;
        }
        return $individual;
    }
}
