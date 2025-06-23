<?php

namespace Modules\PkgApprenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgApprenant\Models\Promotion;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::create([
            
            'name' => '2023-2024 Academic Year',
            'description' => 'Promotion 2023-2024',
            'start_date' => '2023-09-01',
            'end_date' => '2024-06-30',
            'is_active' => false, // Past promotion
        ]);

        Promotion::create([
            
            'name' => '2024-2025 Academic Year',
            'description' => 'Promotion 2024-2025',
            'start_date' => '2024-09-01',
            'end_date' => '2025-06-30',
            'is_active' => true, // Current active promotion
        ]);

        
    }
}