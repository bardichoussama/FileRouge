<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterviewQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('interview_question')->insert([
            [
                'interview_id' => 1,
                'question_id' => 1,
                'order' => 1
            ],
            [
                'interview_id' => 1,
                'question_id' => 2,
                'order' => 2
            ],
            [
                'interview_id' => 2,
                'question_id' => 3,
                'order' => 1
            ]
        ]);
    }
}
