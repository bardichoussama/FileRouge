<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Interview;
use Carbon\Carbon;

class InterviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Interview::create([
            'scheduled_date' => Carbon::now()->addDays(3), // 3 days from now
            'status' => 'scheduled'
        ]);

        Interview::create([
            'scheduled_date' => Carbon::now()->subDays(1), // 1 day ago
            'status' => 'completed'
        ]);

        Interview::create([
            'scheduled_date' => Carbon::now()->addDays(7), // 7 days from now
            'status' => 'scheduled'
        ]);

        Interview::create([
            'scheduled_date' => Carbon::now()->subDays(5), // 5 days ago
            'status' => 'cancelled'
        ]);
    }
}
