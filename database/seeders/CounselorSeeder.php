<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounselorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $counselors = [
            [
                'name' => 'Priya Sharma',
                'email' => 'priya.sharma@leadmanagement.com',
                'phone' => '9876543210',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rajesh Kumar',
                'email' => 'rajesh.kumar@leadmanagement.com',
                'phone' => '9876543211',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Anita Verma',
                'email' => 'anita.verma@leadmanagement.com',
                'phone' => '9876543212',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Suresh Patel',
                'email' => 'suresh.patel@leadmanagement.com',
                'phone' => '9876543213',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Meera Gupta',
                'email' => 'meera.gupta@leadmanagement.com',
                'phone' => '9876543214',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('counselors')->insert($counselors);
    }
}