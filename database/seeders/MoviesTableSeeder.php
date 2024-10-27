<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MoviesTableSeeder extends Seeder
{
    /**
     * Запускает посев данных для таблицы фильмов.
     *
     * @return void
     */
    public function run()
    {
        // Создание первого фильма
        Movie::create([
            'title' => 'Фильм 1', 
            'description' => 'Описание фильма 1', 
            'duration' => 120, 
            'poster_url' => 'path/to/poster1.jpg', 
        ]);

        // Создание второго фильма
        Movie::create([
            'title' => 'Фильм 2',
            'description' => 'Описание фильма 2',
            'duration' => 100,
            'poster_url' => 'path/to/poster2.jpg', 
        ]);
    }
}
