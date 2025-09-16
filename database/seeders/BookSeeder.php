<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'title' => 'Laravel untuk Pemula',
            'author' => 'John Doe',
            'publisher' => 'Tech Books',
            'year' => 2024,
            'isbn' => '9781234567890',
            'stock' => 10
        ]);

        Book::create([
            'title' => 'Mastering PHP',
            'author' => 'Jane Doe',
            'publisher' => 'Code Academy',
            'year' => 2023,
            'isbn' => '9780987654321',
            'stock' => 5
        ]);
    }
}
