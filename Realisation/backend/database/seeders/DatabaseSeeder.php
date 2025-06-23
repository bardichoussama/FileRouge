<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents; 
use Illuminate\Database\Seeder;
use Modules\PkgApprenant\Database\Seeders\GroupeSeeder;
use Modules\PkgApprenant\Database\Seeders\PromotionSeeder;
use Modules\PkgApprenant\Database\Seeders\ApprenantSeeder;
use Modules\PkgSessionDeSuivi\Database\Seeders\ResponsableSeeder;
use Modules\PkgSessionDeSuivi\Database\Seeders\CheckinFormSeeder;
use Modules\PkgSessionDeSuivi\Database\Seeders\QuestionSeeder;
use Modules\PkgSessionDeSuivi\Database\Seeders\StudentCheckinSeeder;
use Modules\PkgSessionDeSuivi\Database\Seeders\StudentCheckinAnswerSeeder;
use Modules\PkgSessionDeSuivi\Database\Seeders\AIInsightSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        $this->call([
            PromotionSeeder::class,
            GroupeSeeder::class,
            ApprenantSeeder::class,

            ResponsableSeeder::class,
            CheckinFormSeeder::class,
            QuestionSeeder::class,
            StudentCheckinSeeder::class,
            StudentCheckinAnswerSeeder::class,
            AIInsightSeeder::class,
        ]);
    }
} 