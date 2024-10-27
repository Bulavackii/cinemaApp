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
        // Получаем список фильмов с пагинацией
        $movies = Movie::paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    public function addMovieForm()
    {
        // Отображаем форму добавления фильма
        return view('admin.movies.create');
    }

    // Метод для сохранения нового фильма
    public function storeMovie(Request $request)
    {
        // Валидация данных фильма
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'country' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'duration' => 'required|integer|min:1|max:500',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Создание нового фильма
        $movie = new Movie($validated);

        // Проверка наличия постера и его сохранение
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('public/posters');
            $movie->poster_url = Storage::url($posterPath);
        }

        // Сохранение фильма
        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно добавлен!');
    }

    // Метод для обновления существующего фильма
    public function updateMovie(Request $request, Movie $movie)
    {
        // Валидация данных фильма
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

        // Если загружен новый постер, удаляем старый и сохраняем новый
        if ($request->hasFile('poster')) {
            // Удаляем старый постер, если он существует
            if ($movie->poster_url) {
                $posterPath = str_replace('storage/', 'public/', $movie->poster_url); 
                if (Storage::exists($posterPath)) {
                    Log::info('Удаляем старый постер по пути: ' . $posterPath);
                    Storage::delete($posterPath);
                }
            }
            // Сохранение нового постера
            $posterPath = $request->file('poster')->store('public/posters');
            $movie->poster_url = Storage::url($posterPath);
        }

        // Сохранение обновленного фильма
        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно обновлен!');
    }

    // Управление пользователями
    public function users(Request $request)
    {
        // Поиск и фильтрация пользователей
        $searchTerm = $request->input('search');
        $adminsQuery = User::where('role', 'admin');
        $guestsQuery = User::where('role', 'guest');

        // Если есть запрос на поиск, фильтруем по имени или email
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

        // Получаем администраторов и гостей с пагинацией
        $admins = $adminsQuery->paginate(10);
        $guests = $guestsQuery->paginate(10);

        return view('admin.users', compact('admins', 'guests'));
    }

    // Переключение роли пользователя
    public function toggleRole(User $user)
    {
        // Переключаем роль пользователя между 'admin' и 'guest'
        if ($user->isAdmin()) {
            $user->role = 'guest';
        } else {
            $user->role = 'admin';
        }

        // Сохраняем обновленную роль
        $user->save();

        return redirect()->route('admin.users')->with('status', 'Роль пользователя успешно изменена.');
    }

    // Управление залами
    public function halls()
    {
        // Получаем список залов с пагинацией
        $cinemaHalls = CinemaHall::paginate(10);
        return view('admin.halls.index', compact('cinemaHalls'));
    }

    public function createHallForm()
    {
        // Отображаем форму для создания нового зала
        return view('admin.halls.create');
    }

    public function storeHall(Request $request)
    {
        // Валидация данных зала
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
        // Отображаем форму для редактирования зала
        return view('admin.halls.edit', compact('hall'));
    }

    public function updateHall(Request $request, CinemaHall $hall)
    {
        // Валидация данных зала
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
        ]);

        // Обновление данных зала
        $hall->update($validated);

        return redirect()->route('admin.halls.index')->with('success', 'Зал успешно обновлен.');
    }

    public function toggleHallActivation(CinemaHall $hall)
    {
        // Переключаем статус активации зала
        $hall->is_active = !$hall->is_active;
        $hall->save();

        // Сообщение об активации/деактивации зала
        $status = $hall->is_active ? 'активирован' : 'деактивирован';
        return redirect()->route('admin.halls.index')->with('status', "Зал успешно {$status}");
    }

    // Управление сеансами
    public function movieSessions()
    {
        // Получаем сеансы с подгруженными фильмами и залами
        $seances = Seance::with(['movie', 'cinemaHall'])->orderBy('start_time', 'asc')->paginate(10);
        return view('admin.seances.index', compact('seances'));
    }

    public function addMovieSessionForm()
    {
        // Отображаем форму для добавления сеанса
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();
        return view('admin.seances.create', compact('movies', 'cinemaHalls'));
    }

    public function storeMovieSession(Request $request)
    {
        // Валидация данных сеанса
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'movie_id' => 'required|exists:movies,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'price_regular' => 'required|numeric|min:0|max:10000',
            'price_vip' => 'required|numeric|min:0|max:20000',
        ]);

        // Создание нового сеанса
        Seance::create($validated);

        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно создан!');
    }

    public function editMovieSessionForm(Seance $movieSession)
    {
        // Отображаем форму для редактирования сеанса
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();
        return view('admin.seances.edit', compact('movieSession', 'movies', 'cinemaHalls'));
    }

    public function updateMovieSession(Request $request, Seance $movieSession)
    {
        // Валидация данных сеанса
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'movie_id' => 'required|exists:movies,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'price_regular' => 'required|numeric|min:0|max:10000',
            'price_vip' => 'required|numeric|min:0|max:20000',
        ]);

        // Обновление данных сеанса
        $movieSession->update($validated);

        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно обновлен!');
    }

    public function deleteMovieSession(Seance $movieSession)
    {
        // Удаление сеанса
        $movieSession->delete();
        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно удалён!');
    }
}
