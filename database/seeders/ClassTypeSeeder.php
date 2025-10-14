<?php

namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClassType::create([
            'id' => 1,
            'name' => 'Class 1',
        ]);

        ClassType::create([
            'id' => 2,
            'name' => 'Class 2',
        ]);
    }
}
