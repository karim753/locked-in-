<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keuzedeel;
use App\Models\Period;

class KeuzedeelSeeder extends Seeder
{
    public function run(): void
    {
        $period1 = Period::where('name', 'Periode 1 - 2025')->first();
        $period2 = Period::where('name', 'Periode 2 - 2025')->first();

        $keuzedelen = [
            [
                'title' => 'Web Development Advanced',
                'description' => 'Verdiep je kennis in moderne web development technieken. Leer werken met frameworks zoals React, Vue.js en Angular. Focus op performance, security en best practices. Inclusief projecten waarbij je een complete webapplicatie bouwt van concept tot deployment.',
                'period_id' => $period1->id,
                'min_participants' => 12,
                'max_participants' => 25,
                'is_repeatable' => false,
                'is_active' => true,
                'teacher_name' => 'Dr. Jansen',
                'schedule_info' => 'Maandag en woensdag 13:30-16:30, plus projecturen',
                'credits' => 3,
            ],
            [
                'title' => 'Data Science Fundamentals',
                'description' => 'Introductie tot data science en machine learning. Leer werken met Python, pandas, scikit-learn en data visualisatie tools. Analyseer echte datasets en bouw voorspellende modellen.',
                'period_id' => $period1->id,
                'min_participants' => 15,
                'max_participants' => 30,
                'is_repeatable' => false,
                'is_active' => true,
                'teacher_name' => 'Prof. Smith',
                'schedule_info' => 'Dinsdag en donderdag 09:00-12:00',
                'credits' => 4,
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Ontwikkel mobiele applicaties voor iOS en Android met React Native. Leer de basis van mobile UI/UX, native integraties en app store deployment. Bouw je eigen mobiele app als eindproject.',
                'period_id' => $period1->id,
                'min_participants' => 10,
                'max_participants' => 20,
                'is_repeatable' => false,
                'is_active' => true,
                'teacher_name' => 'Ing. Johnson',
                'schedule_info' => 'Woensdag en vrijdag 13:30-16:30',
                'credits' => 3,
            ],
            [
                'title' => 'Cybersecurity Essentials',
                'description' => 'Leer de fundamenten van cybersecurity: netwerkbeveiliging, cryptography, ethical hacking en security best practices. Werk met real-world scenario\'s en tools.',
                'period_id' => $period1->id,
                'min_participants' => 15,
                'max_participants' => 25,
                'is_repeatable' => false,
                'is_active' => true,
                'teacher_name' => 'Dr. Williams',
                'schedule_info' => 'Maandag en donderdag 15:00-18:00',
                'credits' => 3,
            ],
            [
                'title' => 'Cloud Computing with AWS',
                'description' => 'Introductie tot cloud computing met Amazon Web Services. Leer over EC2, S3, Lambda, en andere AWS services. Bouw en deploy scalable cloud applicaties.',
                'period_id' => $period2->id,
                'min_participants' => 12,
                'max_participants' => 28,
                'is_repeatable' => false,
                'is_active' => true,
                'teacher_name' => 'Ir. Brown',
                'schedule_info' => 'Dinsdag en vrijdag 13:30-16:30',
                'credits' => 4,
            ],
            [
                'title' => 'UI/UX Design Principles',
                'description' => 'Leer de principes van user interface en user experience design. Werk met design tools zoals Figma, leer over user research, prototyping en usability testing.',
                'period_id' => $period2->id,
                'min_participants' => 10,
                'max_participants' => 22,
                'is_repeatable' => false,
                'is_active' => true,
                'teacher_name' => 'Mevr. Davis',
                'schedule_info' => 'Maandag en woensdag 09:00-12:00',
                'credits' => 3,
            ],
            [
                'title' => 'DevOps Engineering',
                'description' => 'Leer over CI/CD pipelines, containerization met Docker, orchestration met Kubernetes, en infrastructure as code. Werk met moderne DevOps tools en practices.',
                'period_id' => $period2->id,
                'min_participants' => 15,
                'max_participants' => 25,
                'is_repeatable' => false,
                'is_active' => true,
                'teacher_name' => 'Mr. Miller',
                'schedule_info' => 'Dinsdag en donderdag 15:00-18:00',
                'credits' => 4,
            ],
            [
                'title' => 'Blockchain Technology',
                'description' => 'Verken de wereld van blockchain en cryptocurrency. Leer over smart contracts, DApps, en de technische fundamenten achter blockchain technologie.',
                'period_id' => $period2->id,
                'min_participants' => 12,
                'max_participants' => 20,
                'is_repeatable' => false,
                'is_active' => true,
                'teacher_name' => 'Dr. Wilson',
                'schedule_info' => 'Woensdag en vrijdag 09:00-12:00',
                'credits' => 3,
            ],
        ];

        foreach ($keuzedelen as $keuzedeel) {
            try {
                Keuzedeel::create($keuzedeel);
            } catch (\Exception $e) {
                $this->command->error('Error creating keuzedeel: ' . $e->getMessage());
                $this->command->error('Data: ' . json_encode($keuzedeel));
            }
        }
    }
}
