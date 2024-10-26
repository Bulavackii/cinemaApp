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
        $movies = Movie::paginate(10); // Пагинация на 10 элементов на странице
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
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'country' => 'required|string|max:255',
        'genre' => 'required|string|max:255',
        'duration' => 'required|integer|min:1',
        'poster' => 'nullable|image|max:2048',
    ]);

    $movie = new Movie($validated);

    // Сохранение постера
    if ($request->hasFile('poster')) {
        // Сохраняем изображение в публичный диск
        $posterPath = $request->file('poster')->store('posters', 'public');
        $movie->poster_url = 'storage/' . $posterPath; // Сохраняем путь к изображению
    }

    $movie->save();

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
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'country' => 'required|string|max:255',
        'genre' => 'required|string|max:255',
        'duration' => 'required|integer|min:1',
        'poster' => 'nullable|image|max:2048',
    ]);

    $movie->update($validated);

    // Обновление постера
    if ($request->hasFile('poster')) {
        // Удаление старого постера
        if ($movie->poster_url) {
            Storage::disk('public')->delete(str_replace('storage/', '', $movie->poster_url));
        }

        // Сохранение нового постера
        $posterPath = $request->file('poster')->store('posters', 'public');
        $movie->poster_url = 'storage/' . $posterPath; // Сохраняем путь к изображению
    }

    $movie->save();

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
        if ($movie->poster_url) {
            Storage::disk('public')->delete(str_replace('storage/', '', $movie->poster_url));
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно удален.');
    }
    public function storeMovie(Request $request)
{
    // Валидация данных
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'country' => 'required|string|max:255',
        'genre' => 'required|string|max:255',
        'duration' => 'required|integer|min:1|max:500',
        'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Создаем фильм
    $movie = new Movie($validated);

    // Проверка и сохранение постера
    if ($request->hasFile('poster')) {
        $posterPath = $request->file('poster')->store('public/posters');
        $movie->poster_url = $posterPath;
    }

    $movie->save();

    return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно добавлен!');
}

public function updateMovie(Request $request, Movie $movie)
{
    // Валидация данных
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'country' => 'required|string|max:255',
        'genre' => 'required|string|max:255',
        'duration' => 'required|integer|min:1|max:500',
        'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'delete_poster' => 'nullable|boolean'
    ]);

    // Обновление данных фильма
    $movie->fill($validated);

    // Если нужно удалить текущий постер
    if ($request->has('delete_poster') && $request->delete_poster) {
        if ($movie->poster_url && Storage::exists($movie->poster_url)) {
            Storage::delete($movie->poster_url);
        }
        $movie->poster_url = null;
    }

    // Проверка и обновление постера
    if ($request->hasFile('poster')) {
        if ($movie->poster_url && Storage::exists($movie->poster_url)) {
            Storage::delete($movie->poster_url);
        }
        $posterPath = $request->file('poster')->store('public/posters');
        $movie->poster_url = $posterPath;
    }

    $movie->save();

    return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно обновлен!');
}
}
