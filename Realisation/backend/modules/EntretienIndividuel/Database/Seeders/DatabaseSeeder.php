<?php

namespace Modules\EntretienIndividuel\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            GroupeSeeder::class,
            UserSeeder::class,
            FormulaireSeeder::class,
            QuestionSeeder::class,
            OptionReponseSeeder::class,
            EntretienSeeder::class,
            EntretienApprenantSeeder::class,
            ReponseFormulaireSeeder::class,
            ReponseQuestionSeeder::class,
            ReponseOptionSeeder::class,
        ]);
    }
} 