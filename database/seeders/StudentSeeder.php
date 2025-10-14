<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'id' => 1,
            'class_id' => 1,
            'name' => 'Mg Mg',
            'phone' => '09-87654321',
            'address' => '123 Main St',
            'parent_name' => 'U Ba',
        ]);

        Student::create([
            'id' => 2,
            'class_id' => 2,
            'name' => 'Jane Marry',
            'phone' => '09-12345678',
            'address' => '456 Elm St',
            'parent_name' => 'Mr.Dean Smith',
        ]);
    }
}
