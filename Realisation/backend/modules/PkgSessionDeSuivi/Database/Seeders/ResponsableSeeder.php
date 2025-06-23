<?php

namespace Modules\PkgSessionDeSuivi\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\PkgSessionDeSuivi\Domain\Entities\Responsable;

class ResponsableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Youssef Lahmidi',
            'email' => 'youssef.respo@example.com',
            'password' => bcrypt('password'),
        ]);

        Responsable::create([
            'user_id' => $user->id,
        ]);
    }
}
