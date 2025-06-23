<?php

namespace Modules\PkgApprenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgApprenant\Models\Apprenant;
use Modules\PkgApprenant\Models\Groupe;
use App\Models\User;

class ApprenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupes = Groupe::all();
        $noms = [
            ['Fatima Zahra', 'Salma Idrissi', 'Youssef Benali', 'Amina El Amrani'],
            ['Ahmed El Khatib', 'Mohamed Bakkali', 'Sara Ouhadi', 'Karim Choukri'],
        ];

        foreach ($groupes as $index => $groupe) {
            $names = $noms[$index % count($noms)];

            foreach ($names as $name) {
                // create user for apprenant
                $user = User::create([
                    'name' => $name,
                    'email' => strtolower(str_replace(' ', '.', $name)) . '.' . $groupe->promotion->start_year . '@example.com',
                    'password' => bcrypt('password'),
                ]);

                Apprenant::create([
                    'user_id' => $user->id,
                    'groupe_id' => $groupe->id,
                ]);
            }
        }
    }
}
