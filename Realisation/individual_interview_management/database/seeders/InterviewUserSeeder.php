<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterviewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('interview_user')->insert([
            [
                'interview_id' => 1,
                'user_id' => 1,
                'role' => 'apprenant'
            ],
            [
                'interview_id' => 1,
                'user_id' => 2,
                'role' => 'formateur'
            ],
            [
                'interview_id' => 2,
                'user_id' => 3,
                'role' => 'resposable_de_formation'
            ]
        ]);
    }
}
