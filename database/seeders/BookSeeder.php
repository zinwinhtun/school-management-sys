<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'id' => 1,
            'category' => 'Fiction',
            'class_id' => 1,
            'purchase_price' => 100,
            'sale_price' => 150,
            'stock' => 30
        ]);

        Book::create([
            'id' => 2,
            'category' => 'Non-Fiction',
            'class_id' => 2,
            'purchase_price' => 200,
            'sale_price' => 250,
            'stock' => 50
        ]);
    }
}
