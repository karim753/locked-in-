<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PeriodSeeder::class,
            KeuzedeelSeeder::class,
        ]);

        // Create test users with proper passwords (only if they don't exist)
        $users = [
            [
                'name' => 'Student User',
                'email' => 'student@example.com',
                'role' => 'student',
                'study_program' => 'Software Development',
                'password' => \Hash::make('password'),
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => \Hash::make('password'),
            ],
            [
                'name' => 'SLB User',
                'email' => 'slb@example.com',
                'role' => 'slber',
                'password' => \Hash::make('password'),
            ],
            // Additional sample students
            [
                'name' => 'Jan Jansen',
                'email' => 'jan.jansen@student.tcr.nl',
                'role' => 'student',
                'study_program' => 'Software Development',
                'password' => \Hash::make('password'),
            ],
            [
                'name' => 'Pieter de Vries',
                'email' => 'pieter.devries@student.tcr.nl',
                'role' => 'student',
                'study_program' => 'Elektrotechniek',
                'password' => \Hash::make('password'),
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@student.tcr.nl',
                'role' => 'student',
                'study_program' => 'Web Development',
                'password' => \Hash::make('password'),
            ],
            [
                'name' => 'Ahmed Youssef',
                'email' => 'ahmed.youssef@student.tcr.nl',
                'role' => 'student',
                'study_program' => 'Cybersecurity',
                'password' => \Hash::make('password'),
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@student.tcr.nl',
                'role' => 'student',
                'study_program' => 'Data Science',
                'password' => \Hash::make('password'),
            ],
            [
                'name' => 'Tom Bakker',
                'email' => 'tom.bakker@student.tcr.nl',
                'role' => 'student',
                'study_program' => 'Mobile Development',
                'password' => \Hash::make('password'),
            ],
            // Additional SLB staff
            [
                'name' => 'Dr. van den Berg',
                'email' => 'vandenberg.slb@tcr.nl',
                'role' => 'slber',
                'password' => \Hash::make('password'),
            ],
            [
                'name' => 'Mevrouw Jansen',
                'email' => 'jansen.slb@tcr.nl',
                'role' => 'slber',
                'password' => \Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            \App\Models\User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
