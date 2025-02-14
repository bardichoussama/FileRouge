<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::create([
            'text' => 'What are your strengths?',
            'category' => 'General'
        ]);

        Question::create([
            'text' => 'Describe a challenging situation you faced.',
            'category' => 'Behavioral'
        ]);

        Question::create([
            'text' => 'Explain a project you worked on recently.',
            'category' => 'Technical'
        ]);
    }
}
