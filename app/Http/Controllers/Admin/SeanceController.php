<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seance;
use App\Models\Movie;
use App\Models\CinemaHall;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    /**
     * Отображает список сеансов.
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    // Получаем сеансы с пагинацией
    $seances = Seance::with(['movie', 'cinemaHall'])->orderBy('start_time', 'asc')->paginate(10);
    
    return view('admin.seances.index', compact('seances'));
}

    /**
     * Показывает форму для создания нового сеанса.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();

        return view('admin.seances.create', compact('movies', 'cinemaHalls'));
    }

    /**
     * Сохраняет новый сеанс в базе данных.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'movie_id' => 'required|exists:movies,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'price_regular' => 'required|numeric|min:0',
            'price_vip' => 'required|numeric|min:0',
        ]);

        // Создание нового сеанса
        Seance::create($validated);

        // Перенаправление с сообщением об успехе
        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно создан!');
    }

    /**
     * Показывает форму для редактирования сеанса.
     *
     * @param  \App\Models\Seance  $seance
     * @return \Illuminate\View\View
     */
    public function edit(Seance $seance)
    {
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();

        return view('admin.seances.edit', compact('seance', 'movies', 'cinemaHalls'));
    }

    /**
     * Обновляет сеанс в базе данных.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seance  $seance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Seance $seance)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'movie_id' => 'required|exists:movies,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'price_regular' => 'required|numeric|min:0',
            'price_vip' => 'required|numeric|min:0',
        ]);

        // Обновление сеанса
        $seance->update($validated);

        // Перенаправление с сообщением об успехе
        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно обновлён!');
    }

    /**
     * Удаляет сеанс из базы данных.
     *
     * @param  \App\Models\Seance  $seance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Seance $seance)
    {
        $seance->delete();

        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно удалён!');
    }
}
