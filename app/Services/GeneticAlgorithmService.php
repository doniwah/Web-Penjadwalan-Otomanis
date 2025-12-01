<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Timeslot;
use App\Models\TeachingAssignment;
use Illuminate\Support\Collection;

class GeneticAlgorithmService
{
    protected $assignments;
    protected $rooms;
    protected $timeslots;
    protected $populationSize;
    protected $mutationRate;
    protected $crossoverRate;
    protected $elitismCount;
    protected $fitnessCache = []; // Cache fitness values

    public function __construct($populationSize = 50, $mutationRate = 0.1, $crossoverRate = 0.8, $elitismCount = 2)
    {
        $this->populationSize = $populationSize;
        $this->mutationRate = $mutationRate;
        $this->crossoverRate = $crossoverRate;
        $this->elitismCount = $elitismCount;
    }

    public function initializeData()
    {
        $this->assignments = TeachingAssignment::with(['course', 'lecturer'])->get();
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
        foreach ($this->assignments as $assignment) {
            $schedule[] = [
                'assignment_id' => $assignment->id,
                'course_id' => $assignment->course_id,
                'lecturer_id_1' => $assignment->lecturer_id_1,
                'lecturer_id_2' => $assignment->lecturer_id_2,
                'class_name' => $assignment->class_name,
                'room_id' => $this->rooms->random()->id,
                'timeslot_id' => $this->timeslots->random()->id,
            ];
        }
        return $schedule;
    }

    public function calculateFitness($individual)
    {
        $hardConflicts = 0;
        $softConflicts = 0;

        $lecturerSlots = [];
        $roomSlots = [];
        $classSlots = [];

        foreach ($individual as $gene) {
            $lecturerId1 = $gene['lecturer_id_1'];
            $lecturerId2 = $gene['lecturer_id_2'] ?? null;
            $roomId = $gene['room_id'];
            $timeslotId = $gene['timeslot_id'];
            $className = $gene['class_name'];

            // 1. Hard Constraint: Lecturer Conflict (for both lecturers)
            if (isset($lecturerSlots[$lecturerId1][$timeslotId])) {
                $hardConflicts++;
            }
            $lecturerSlots[$lecturerId1][$timeslotId] = true;
            
            // Check second lecturer if exists
            if ($lecturerId2) {
                if (isset($lecturerSlots[$lecturerId2][$timeslotId])) {
                    $hardConflicts++;
                }
                $lecturerSlots[$lecturerId2][$timeslotId] = true;
            }

            // 2. Hard Constraint: Room Conflict
            if (isset($roomSlots[$roomId][$timeslotId])) {
                $hardConflicts++;
            }
            $roomSlots[$roomId][$timeslotId] = true;

            // 3. Hard Constraint: Student Group (Class) Conflict
            // Students in Class 'A' cannot have two courses at the same time.
            if (isset($classSlots[$className][$timeslotId])) {
                $hardConflicts++;
            }
            $classSlots[$className][$timeslotId] = true;

            // Soft Constraints
            $lecturer = $this->assignments->firstWhere('id', $gene['assignment_id'])->lecturer;
            $timeslot = $this->timeslots->find($timeslotId);
            
            // Preference: Lecturer Day
            if ($lecturer && !empty($lecturer->preferred_days)) {
                if (!in_array($timeslot->day, $lecturer->preferred_days)) {
                    $softConflicts++;
                }
            }
            
            // Preference: Avoid Friday Prayer time (example)
            if ($timeslot->day == 'Friday' && $timeslot->start_time >= '11:30' && $timeslot->end_time <= '13:00') {
                 $softConflicts += 2;
            }
        }

        // Penalty weights
        $fitness = 1 / (($hardConflicts * 100) + ($softConflicts * 1) + 1);
        return $fitness;
    }

    // Helper method to get fitness with caching
    protected function getFitness($individual)
    {
        $hash = $this->getIndividualHash($individual);
        
        if (!isset($this->fitnessCache[$hash])) {
            $this->fitnessCache[$hash] = $this->calculateFitness($individual);
        }
        
        return $this->fitnessCache[$hash];
    }

    // Generate a unique hash for an individual
    protected function getIndividualHash($individual)
    {
        return md5(json_encode($individual));
    }
    
    public function run($generations = 100)
    {
        $this->initializeData();
        if ($this->assignments->isEmpty() || $this->rooms->isEmpty() || $this->timeslots->isEmpty()) {
            return [];
        }

        $population = $this->generatePopulation();

        for ($g = 0; $g < $generations; $g++) {
            // Sort by fitness (using cached values)
            usort($population, function ($a, $b) {
                return $this->getFitness($b) <=> $this->getFitness($a);
            });

            // Check for perfect solution (fitness close to 1, meaning 0 hard conflicts)
            // It's hard to get exactly 1 if soft conflicts exist.
            // But we definitely want 0 hard conflicts.
            $bestFitness = $this->getFitness($population[0]);
            if ($bestFitness > 0.5) { // Threshold for "good enough" or 0 hard conflicts
                 // If hard conflicts are 0, fitness is 1 / (soft + 1). Max soft is usually low.
                 // If hard conflicts > 0, fitness is < 1/100 = 0.01
                 // So > 0.01 means 0 hard conflicts.
            }

            $newPopulation = [];

            // Elitism
            for ($i = 0; $i < $this->elitismCount; $i++) {
                $newPopulation[] = $population[$i];
            }

            // Selection & Crossover
            while (count($newPopulation) < $this->populationSize) {
                $parent1 = $this->rouletteWheelSelection($population);
                $parent2 = $this->rouletteWheelSelection($population);

                $child = $this->crossover($parent1, $parent2);
                $child = $this->mutation($child);

                $newPopulation[] = $child;
            }

            $population = $newPopulation;
        }

        // Return best schedule (using cached values)
        usort($population, function ($a, $b) {
            return $this->getFitness($b) <=> $this->getFitness($a);
        });

        return $population[0];
    }

    protected function rouletteWheelSelection($population)
    {
        $totalFitness = 0;
        foreach ($population as $individual) {
            $totalFitness += $this->getFitness($individual);
        }

        $random = rand(0, 1000) / 1000 * $totalFitness;
        $currentFitness = 0;

        foreach ($population as $individual) {
            $currentFitness += $this->getFitness($individual);
            if ($currentFitness >= $random) {
                return $individual;
            }
        }

        return $population[0]; // Fallback
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
