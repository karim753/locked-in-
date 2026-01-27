<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Period;

class PeriodSeeder extends Seeder
{
    public function run(): void
    {
        $periods = [
            [
                'name' => 'Periode 1 - 2025',
                'start_date' => '2025-02-01',
                'end_date' => '2025-04-30',
                'enrollment_opens_at' => '2025-01-15 09:00:00',
                'enrollment_closes_at' => '2025-01-31 17:00:00',
                'is_active' => true,
            ],
            [
                'name' => 'Periode 2 - 2025',
                'start_date' => '2025-05-01',
                'end_date' => '2025-07-31',
                'enrollment_opens_at' => '2025-04-15 09:00:00',
                'enrollment_closes_at' => '2025-04-30 17:00:00',
                'is_active' => true,
            ],
            [
                'name' => 'Periode 3 - 2025',
                'start_date' => '2025-08-01',
                'end_date' => '2025-10-31',
                'enrollment_opens_at' => '2025-07-15 09:00:00',
                'enrollment_closes_at' => '2025-07-31 17:00:00',
                'is_active' => false,
            ],
        ];

        foreach ($periods as $period) {
            Period::create($period);
        }
    }
}
