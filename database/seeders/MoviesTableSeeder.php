<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MoviesTableSeeder extends Seeder
{
    public function run()
    {
        Movie::create([
            'title' => 'Фильм 1',
            'description' => 'Описание фильма 1',
            'duration' => 120,
            'poster_url' => 'path/to/poster1.jpg', // Укажите путь или URL к изображению
        ]);

        Movie::create([
            'title' => 'Фильм 2',
            'description' => 'Описание фильма 2',
            'duration' => 100,
            'poster_url' => 'path/to/poster2.jpg',
        ]);

        // Добавьте другие фильмы по необходимости
    }
}
