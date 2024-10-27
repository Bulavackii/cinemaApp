<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Отображение списка всех фильмов.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Получаем фильмы с пагинацией на 10 элементов на странице
        $movies = Movie::paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    /**
     * Форма для создания нового фильма.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.movies.create');
    }

    /**
     * Сохранение нового фильма.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048',
        ]);

        // Создаем новый фильм
        $movie = new Movie($validated);

        // Проверка наличия постера и его сохранение
        if ($request->hasFile('poster')) {
            // Сохранение постера в публичную директорию
            $posterPath = $request->file('poster')->store('posters', 'public');
            $movie->poster_url = 'storage/' . $posterPath; // Сохраняем URL постера
        }

        $movie->save(); // Сохранение фильма

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно добавлен.');
    }

    /**
     * Форма для редактирования фильма.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\View\View
     */
    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    /**
     * Обновление информации о фильме.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Movie $movie)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048',
        ]);

        // Обновляем данные фильма
        $movie->update($validated);

        // Обновление постера, если он загружен
        if ($request->hasFile('poster')) {
            // Удаляем старый постер, если он существует
            if ($movie->poster_url) {
                Storage::disk('public')->delete(str_replace('storage/', '', $movie->poster_url));
            }

            // Сохраняем новый постер
            $posterPath = $request->file('poster')->store('posters', 'public');
            $movie->poster_url = 'storage/' . $posterPath;
        }

        $movie->save(); // Сохраняем изменения

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно обновлен.');
    }

    /**
     * Удаление фильма.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Movie $movie)
    {
        // Удаляем постер, если он существует
        if ($movie->poster_url) {
            Storage::disk('public')->delete(str_replace('storage/', '', $movie->poster_url));
        }

        // Удаляем фильм
        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно удален.');
    }

    /**
     * Сохранение нового фильма (дублированный метод, возможно ошибка).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeMovie(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1|max:500',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Создаем новый фильм
        $movie = new Movie($validated);

        // Сохранение постера
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('public/posters');
            $movie->poster_url = $posterPath;
        }

        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно добавлен!');
    }

    /**
     * Обновление фильма (дублированный метод, возможно ошибка).
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateMovie(Request $request, Movie $movie)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1|max:500',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_poster' => 'nullable|boolean'
        ]);

        // Обновляем данные фильма
        $movie->fill($validated);

        // Удаление постера, если установлено соответствующее поле
        if ($request->has('delete_poster') && $request->delete_poster) {
            if ($movie->poster_url && Storage::exists($movie->poster_url)) {
                Storage::delete($movie->poster_url);
            }
            $movie->poster_url = null;
        }

        // Обновление постера, если загружен новый
        if ($request->hasFile('poster')) {
            if ($movie->poster_url && Storage::exists($movie->poster_url)) {
                Storage::delete($movie->poster_url);
            }
            $posterPath = $request->file('poster')->store('public/posters');
            $movie->poster_url = $posterPath;
        }

        $movie->save(); // Сохраняем изменения

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно обновлен!');
    }
}
