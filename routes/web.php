<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Admin\SeanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

// Маршруты для клиента
Route::get('/', [ClientController::class, 'index'])->name('client.index'); // Главная страница клиента
Route::get('/hall/{id}', [ClientController::class, 'hall'])->name('client.hall'); // Маршрут для выбора мест в зале
Route::post('/booking/complete', [ClientController::class, 'completeBooking'])->name('client.complete_booking'); // Завершение бронирования
Route::get('/ticket/{id}', [ClientController::class, 'showTicket'])->name('ticket.show'); // Маршрут для отображения билета
Route::get('/profile', [ClientController::class, 'profile'])->name('client.profile'); // Профиль пользователя
Route::get('/tickets', [ClientController::class, 'tickets'])->name('client.tickets'); // Список билетов пользователя
Route::get('/settings', [ClientController::class, 'settings'])->name('client.settings'); // Настройки пользователя

// Маршрут для отображения списка фильмов
Route::get('/movies', [ClientController::class, 'showMovies'])->name('client.movies'); // Список фильмов

// Маршрут для отображения расписания фильмов (сеансов) для клиента
Route::get('/schedule', [ClientController::class, 'showSchedule'])->name('client.schedule'); // Расписание фильмов

// Маршрут для отображения деталей фильма в клиентской части
Route::get('/movie/{id}', [ClientController::class, 'showMovieDetails'])->name('client.movie.details'); // Детали фильма

// Маршрут для страницы "Контакты"
Route::get('/contact', [ClientController::class, 'showContactPage'])->name('client.contact'); // Контактная информация

// Маршрут для страницы "Политика конфиденциальности"
Route::get('/privacy-policy', function () {
    return view('client.privacy-policy'); // Политика конфиденциальности
})->name('client.privacy-policy');

// Маршруты для авторизации
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Форма входа
Route::post('/login', [AuthController::class, 'login']); // Логика входа
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Выход

// Маршруты для регистрации
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register'); // Форма регистрации
Route::post('/register', [AuthController::class, 'register']); // Логика регистрации

// Защищённые маршруты для админки (доступны только после авторизации)
Route::middleware('auth')->group(function () {

    // Главная страница админки
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index'); // Главная админки

    // Управление залами
    Route::prefix('admin/halls')->name('admin.halls.')->group(function () {
        Route::get('/', [AdminController::class, 'halls'])->name('index'); // Список залов
        Route::get('/create', [AdminController::class, 'createHallForm'])->name('create'); // Форма создания зала
        Route::post('/store', [AdminController::class, 'storeHall'])->name('store'); // Сохранение зала
        Route::get('/{hall}/edit', [AdminController::class, 'editHallForm'])->name('edit'); // Форма редактирования зала
        Route::put('/{hall}', [AdminController::class, 'updateHall'])->name('update'); // Обновление зала
        Route::delete('/{hall}', [AdminController::class, 'deleteHall'])->name('destroy'); // Удаление зала
        Route::post('/{hall}/toggle', [AdminController::class, 'toggleHallActivation'])->name('toggle'); // Активация/деактивация зала
    });

    // Управление сеансами
    Route::prefix('admin/seances')->name('admin.seances.')->group(function () {
        Route::get('/', [SeanceController::class, 'index'])->name('index'); // Список сеансов
        Route::get('/create', [SeanceController::class, 'create'])->name('create'); // Форма создания сеанса
        Route::post('/', [SeanceController::class, 'store'])->name('store'); // Сохранение сеанса
        Route::get('/{seance}/edit', [SeanceController::class, 'edit'])->name('edit'); // Форма редактирования сеанса
        Route::put('/{seance}', [SeanceController::class, 'update'])->name('update'); // Обновление сеанса
        Route::delete('/{seance}', [SeanceController::class, 'destroy'])->name('destroy'); // Удаление сеанса
    });

    // Управление фильмами
    Route::prefix('admin/movies')->name('admin.movies.')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('index'); // Список фильмов
        Route::get('/create', [MovieController::class, 'create'])->name('create'); // Форма создания фильма
        Route::post('/store', [MovieController::class, 'store'])->name('store'); // Сохранение фильма
        Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('edit'); // Форма редактирования фильма
        Route::put('/{movie}', [MovieController::class, 'update'])->name('update'); // Обновление фильма
        Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('destroy'); // Удаление фильма
    });

    // Управление пользователями
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users'); // Список пользователей
    Route::patch('/admin/users/{user}/toggleRole', [AdminController::class, 'toggleRole'])->name('admin.users.toggleRole'); // Смена роли пользователя
});
