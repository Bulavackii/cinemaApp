<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Movie;
use App\Models\CinemaHall;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Главная страница админки
    public function index()
    {
        // Получаем все сеансы с подгруженными данными о фильмах и залах
        $movieSessions = Seance::with('movie', 'cinemaHall')->orderBy('start_time', 'asc')->paginate(10);
        
        // Получаем количество администраторов и зрителей
        $adminsCount = User::where('role', 'admin')->count();
        $guestsCount = User::where('role', 'guest')->count();

        return view('admin.index', compact('movieSessions', 'adminsCount', 'guestsCount'));
    }

    // Управление фильмами
    public function movies()
    {
        $movies = Movie::paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    public function addMovieForm()
    {
        return view('admin.movies.create');
    }

    // Метод для сохранения нового фильма
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
            $movie->poster_url = Storage::url($posterPath);
        }

        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно добавлен!');
    }

    // Метод для обновления существующего фильма
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
        ]);

        // Обновление данных фильма
        $movie->fill($validated);

        // Проверка и обновление постера
        if ($request->hasFile('poster')) {
            // Удаление старого постера, если он есть
            if ($movie->poster_url) {
                $posterPath = str_replace('storage/', 'public/', $movie->poster_url); 
                if (Storage::exists($posterPath)) {
                    Log::info('Удаляем старый постер по пути: ' . $posterPath);
                    Storage::delete($posterPath);
                }
            }
            // Сохранение нового постера
            $posterPath = $request->file('poster')->store('public/posters');
            $movie->poster_url = Storage::url($posterPath); // Сохраняем новый путь к постеру
        }

        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно обновлен!');
    }

    // Управление пользователями
    public function users(Request $request)
    {
        // Поиск пользователей
        $searchTerm = $request->input('search');
        $adminsQuery = User::where('role', 'admin');
        $guestsQuery = User::where('role', 'guest');

        if ($searchTerm) {
            $adminsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });

            $guestsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $admins = $adminsQuery->paginate(10);
        $guests = $guestsQuery->paginate(10);

        return view('admin.users', compact('admins', 'guests'));
    }

    // Переключение роли пользователя
    public function toggleRole(User $user)
    {
        if ($user->isAdmin()) {
            $user->role = 'guest';
        } else {
            $user->role = 'admin';
        }

        $user->save();

        return redirect()->route('admin.users')->with('status', 'Роль пользователя успешно изменена.');
    }

    // Управление залами
    public function halls()
    {
        $cinemaHalls = CinemaHall::paginate(10);
        return view('admin.halls.index', compact('cinemaHalls'));
    }

    public function createHallForm()
    {
        return view('admin.halls.create');
    }

    public function storeHall(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
        ]);

        // Создание нового зала
        CinemaHall::create($validated);

        return redirect()->route('admin.halls.index')->with('success', 'Зал успешно создан!');
    }

    public function editHallForm(CinemaHall $hall)
    {
        return view('admin.halls.edit', compact('hall'));
    }

    public function updateHall(Request $request, CinemaHall $hall)
    {
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
        ]);

        // Обновление данных о зале
        $hall->update($validated);

        return redirect()->route('admin.halls.index')->with('success', 'Зал успешно обновлен.');
    }

    public function toggleHallActivation(CinemaHall $hall)
    {
        $hall->is_active = !$hall->is_active;
        $hall->save();

        $status = $hall->is_active ? 'активирован' : 'деактивирован';
        return redirect()->route('admin.halls.index')->with('status', "Зал успешно {$status}");
    }

    // Управление сеансами
    public function movieSessions()
    {
        $seances = Seance::with(['movie', 'cinemaHall'])->orderBy('start_time', 'asc')->paginate(10);
        return view('admin.seances.index', compact('seances'));
    }

    public function addMovieSessionForm()
    {
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();
        return view('admin.seances.create', compact('movies', 'cinemaHalls'));
    }

    public function storeMovieSession(Request $request)
    {
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'movie_id' => 'required|exists:movies,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'price_regular' => 'required|numeric|min:0|max:10000',
            'price_vip' => 'required|numeric|min:0|max:20000',
        ]);

        Seance::create($validated);

        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно создан!');
    }

    public function editMovieSessionForm(Seance $movieSession)
    {
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();
        return view('admin.seances.edit', compact('movieSession', 'movies', 'cinemaHalls'));
    }

    public function updateMovieSession(Request $request, Seance $movieSession)
    {
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'movie_id' => 'required|exists:movies,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'price_regular' => 'required|numeric|min:0|max:10000',
            'price_vip' => 'required|numeric|min:0|max:20000',
        ]);

        $movieSession->update($validated);

        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно обновлен!');
    }

    public function deleteMovieSession(Seance $movieSession)
    {
        $movieSession->delete();
        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно удалён!');
    }
}