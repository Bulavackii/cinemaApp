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
     * Отображает список сеансов с пагинацией.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Получаем сеансы с их фильмами и залами, сортируем по времени начала
        $seances = Seance::with(['movie', 'cinemaHall'])
                         ->orderBy('start_time', 'asc') // Сортировка по возрастанию времени начала сеанса
                         ->paginate(10); // Пагинация, выводим по 10 сеансов на страницу

        // Передаем данные о сеансах в представление
        return view('admin.seances.index', compact('seances'));
    }

    /**
     * Показывает форму для создания нового сеанса.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Получаем все фильмы и залы для отображения в форме выбора
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();

        // Передаем фильмы и залы в форму создания сеанса
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
        // Валидация входных данных запроса
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id', // Проверяем, что зал существует
            'movie_id' => 'required|exists:movies,id', // Проверяем, что фильм существует
            'start_time' => 'required|date|after:now', // Начало сеанса должно быть позже текущего времени
            'end_time' => 'required|date|after:start_time', // Конец сеанса должен быть позже начала
            'price_regular' => 'required|numeric|min:0', // Цена для обычных мест не может быть меньше нуля
            'price_vip' => 'required|numeric|min:0', // Цена для VIP мест не может быть меньше нуля
        ]);

        // Создаем новый сеанс с валидированными данными
        Seance::create($validated);

        // Перенаправляем на страницу списка сеансов с сообщением об успешном создании
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
        // Получаем все фильмы и залы для отображения в форме редактирования
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();

        // Передаем данные сеанса, фильмов и залов в представление
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
        // Валидация входных данных запроса
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id', // Проверка, что зал существует
            'movie_id' => 'required|exists:movies,id', // Проверка, что фильм существует
            'start_time' => 'required|date|after:now', // Время начала должно быть позже текущего времени
            'end_time' => 'required|date|after:start_time', // Время окончания должно быть позже времени начала
            'price_regular' => 'required|numeric|min:0', // Обычная цена не может быть меньше нуля
            'price_vip' => 'required|numeric|min:0', // Цена VIP не может быть меньше нуля
        ]);

        // Обновляем сеанс с валидированными данными
        $seance->update($validated);

        // Перенаправляем на страницу списка сеансов с сообщением об успешном обновлении
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
        // Удаляем сеанс
        $seance->delete();

        // Перенаправляем на страницу списка сеансов с сообщением об успешном удалении
        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно удалён!');
    }
}
