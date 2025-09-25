<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculty = [
            [
                'name' => 'Dr. Amit Singh',
                'subject' => 'History',
                'email' => 'amit.singh@leadmanagement.com',
                'phone' => '9876543220',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Prof. Sunita Joshi',
                'subject' => 'Geography',
                'email' => 'sunita.joshi@leadmanagement.com',
                'phone' => '9876543221',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Vikram Rao',
                'subject' => 'Political Science',
                'email' => 'vikram.rao@leadmanagement.com',
                'phone' => '9876543222',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ms. Kavya Nair',
                'subject' => 'Economics',
                'email' => 'kavya.nair@leadmanagement.com',
                'phone' => '9876543223',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Prof. Ravi Mehta',
                'subject' => 'Public Administration',
                'email' => 'ravi.mehta@leadmanagement.com',
                'phone' => '9876543224',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Pooja Agarwal',
                'subject' => 'Sociology',
                'email' => 'pooja.agarwal@leadmanagement.com',
                'phone' => '9876543225',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mr. Kiran Sharma',
                'subject' => 'Philosophy',
                'email' => 'kiran.sharma@leadmanagement.com',
                'phone' => '9876543226',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Neha Gupta',
                'subject' => 'Psychology',
                'email' => 'neha.gupta@leadmanagement.com',
                'phone' => '9876543227',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Prof. Rohit Kumar',
                'subject' => 'Mathematics',
                'email' => 'rohit.kumar@leadmanagement.com',
                'phone' => '9876543228',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ms. Deepika Shah',
                'subject' => 'English Literature',
                'email' => 'deepika.shah@leadmanagement.com',
                'phone' => '9876543229',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('faculty')->insert($faculty);
    }
}