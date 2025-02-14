<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Interview;
use App\Models\Feedback;
use App\Models\User;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an interview first to ensure there's an interview to reference
        $interview = Interview::create([
            'scheduled_date' => now(),
            'status' => 'scheduled',
            'student_id' => 1,  // Assuming student with ID 1
            'respo_id' => 1,    // Assuming respo with ID 1
            'formateur_id' => 1,  // Assuming formateur with ID 1
        ]);

        // Create feedback for this interview
        Feedback::create([
            'notes' => 'Great communication skills.',
            'interview_id' => $interview->id,
            'created_by' => 1,  // Assuming user with ID 1 created this feedback
        ]);
    }
}
