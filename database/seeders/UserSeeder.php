<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Study programs
        $prodis = ['Teknik Industri', 'Teknik Sipil', 'Informatika', 'Teknik Mesin'];
        
        // Semesters (1-8)
        $semesters = [1, 2, 3, 4, 5, 6, 7, 8];
        
        // Indonesian names for realistic data
        $firstNames = [
            'Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Gita', 'Hadi',
            'Indah', 'Joko', 'Kartika', 'Lina', 'Made', 'Novi', 'Omar', 'Putri',
            'Qori', 'Rina', 'Siti', 'Tono', 'Umar', 'Vina', 'Wati', 'Yanto',
            'Zahra', 'Adi', 'Bella', 'Candra', 'Dian', 'Eka', 'Fajar', 'Gilang',
            'Hana', 'Irfan', 'Jihan', 'Kiki', 'Luki', 'Maya', 'Nanda', 'Oki'
        ];
        
        $lastNames = [
            'Santoso', 'Wijaya', 'Pratama', 'Kusuma', 'Saputra', 'Wibowo',
            'Permana', 'Nugroho', 'Hidayat', 'Setiawan', 'Firmansyah', 'Hakim',
            'Ramadan', 'Maulana', 'Rizki', 'Putra', 'Putri', 'Sari', 'Lestari',
            'Rahayu', 'Anggraini', 'Maharani', 'Purnama', 'Cahaya', 'Surya'
        ];
        
        // ============================================
        // 1. CREATE ADMIN
        // ============================================
        $adminUser = User::create([
            'name' => 'Administrator',
            'email' => 'admin@sijadu.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        
        $this->command->info('✓ Created 1 Admin');
        
        // ============================================
        // 2. CREATE 20 LECTURERS
        // ============================================
        $lecturerTitles = ['Dr.', 'Prof.', 'Ir.', 'S.T., M.T.', 'S.Kom., M.Kom.', 'S.Si., M.Si.'];
        
        for ($i = 1; $i <= 20; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $title = $lecturerTitles[array_rand($lecturerTitles)];
            
            $user = User::create([
                'name' => "$title $firstName $lastName",
                'email' => "dosen$i@sijadu.ac.id",
                'password' => Hash::make('dosen123'),
                'role' => 'dosen',
            ]);
            
            Lecturer::create([
                'user_id' => $user->id,
                'nip' => '19' . str_pad(80 + $i, 2, '0', STR_PAD_LEFT) . '0' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'max_sks' => rand(10, 16),
                'preferred_days' => json_encode(['Senin', 'Rabu', 'Jumat']),
            ]);
        }
        
        $this->command->info('✓ Created 20 Lecturers');
        
        // ============================================
        // 3. CREATE 500 STUDENTS
        // ============================================
        $studentsPerProdi = 125; // 500 / 4 = 125 students per prodi
        $studentCounter = 1;
        
        foreach ($prodis as $prodiIndex => $prodi) {
            // Create students for this prodi
            for ($i = 1; $i <= $studentsPerProdi; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                
                // Determine semester and class
                $semester = $semesters[array_rand($semesters)];
                
                // Class names: A, B, C, D (distribute evenly)
                $classLetter = chr(65 + ($i % 4)); // A, B, C, D
                
                // Prodi code
                $prodiCodes = [
                    'Teknik Industri' => 'TI',
                    'Teknik Sipil' => 'TS',
                    'Informatika' => 'IF',
                    'Teknik Mesin' => 'TM'
                ];
                $prodiCode = $prodiCodes[$prodi];
                
                // Class name format: IF-3A, TI-5B, etc.
                $className = "$prodiCode-$semester$classLetter";
                
                // Generate NIM: 2021 + prodi code + student number
                $year = 2021 + ($semester <= 2 ? 3 : ($semester <= 4 ? 2 : ($semester <= 6 ? 1 : 0)));
                $nim = $year . str_pad($prodiIndex + 1, 2, '0', STR_PAD_LEFT) . str_pad($studentCounter, 4, '0', STR_PAD_LEFT);
                
                $user = User::create([
                    'name' => "$firstName $lastName",
                    'email' => "mahasiswa$studentCounter@sijadu.ac.id",
                    'password' => Hash::make('mahasiswa123'),
                    'role' => 'mahasiswa',
                ]);
                
                Student::create([
                    'user_id' => $user->id,
                    'nim' => $nim,
                    'class_name' => $className,
                    'prodi' => $prodi,
                    'semester' => $semester,
                ]);
                
                $studentCounter++;
            }
            
            $this->command->info("✓ Created $studentsPerProdi students for $prodi");
        }
        
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('DATABASE SEEDING COMPLETED!');
        $this->command->info('========================================');
        $this->command->info('Total Users Created: ' . ($studentCounter + 20));
        $this->command->info('- Admin: 1');
        $this->command->info('- Lecturers: 20');
        $this->command->info('- Students: 500');
        $this->command->info('');
        $this->command->info('Study Programs:');
        foreach ($prodis as $prodi) {
            $this->command->info("  - $prodi: 125 students");
        }
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('Admin: admin@sijadu.ac.id / admin123');
        $this->command->info('Dosen: dosen1@sijadu.ac.id / dosen123 (dosen1-dosen20)');
        $this->command->info('Mahasiswa: mahasiswa1@sijadu.ac.id / mahasiswa123 (mahasiswa1-mahasiswa500)');
        $this->command->info('========================================');
    }
}
