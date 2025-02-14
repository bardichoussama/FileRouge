<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Call the individual seeders
        $this->call([
            UserSeeder::class, // Add the UserSeeder here
            QuestionSeeder::class,
            FeedbackSeeder::class,
            InterviewUserSeeder::class,
            InterviewQuestionSeeder::class,
        ]);
    }
}
