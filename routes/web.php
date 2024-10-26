<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Admin\SeanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;

// Удаляем BookingController, так как мы больше не используем его
// use App\Http\Controllers\BookingController;

// Маршруты для клиента
Route::get('/', [ClientController::class, 'index'])->name('client.index');
Route::get('/hall/{id}', [ClientController::class, 'hall'])->name('client.hall'); // Маршрут для выбора мест в зале
Route::post('/booking/complete', [ClientController::class, 'completeBooking'])->name('client.complete_booking');
Route::get('/ticket/{id}', [ClientController::class, 'showTicket'])->name('ticket.show'); // Маршрут для отображения билета
Route::get('/profile', [ClientController::class, 'profile'])->name('client.profile');
Route::get('/tickets', [ClientController::class, 'tickets'])->name('client.tickets');
Route::get('/settings', [ClientController::class, 'settings'])->name('client.settings');

// Маршрут для отображения списка фильмов
Route::get('/movies', [ClientController::class, 'showMovies'])->name('client.movies');

// Маршрут для отображения расписания фильмов (сеансов) для клиента
Route::get('/schedule', [ClientController::class, 'showSchedule'])->name('client.schedule');

// Маршрут для отображения деталей фильма в клиентской части
Route::get('/movie/{id}', [ClientController::class, 'showMovieDetails'])->name('client.movie.details');

// Маршрут для страницы "Контакты"
Route::get('/contact', [ClientController::class, 'showContactPage'])->name('client.contact');

// Маршрут для страницы "Политика конфиденциальности"
Route::get('/privacy-policy', function () {
    return view('client.privacy-policy');
})->name('client.privacy-policy');

// Маршруты для авторизации
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Маршруты для регистрации
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Защищённые маршруты для админки (доступны только после авторизации)
Route::middleware('auth')->group(function () {

    // Главная страница админки
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Управление залами
    Route::prefix('admin/halls')->name('admin.halls.')->group(function () {
        Route::get('/', [AdminController::class, 'halls'])->name('index');
        Route::get('/create', [AdminController::class, 'createHallForm'])->name('create');
        Route::post('/store', [AdminController::class, 'storeHall'])->name('store');
        Route::get('/{hall}/edit', [AdminController::class, 'editHallForm'])->name('edit');
        Route::put('/{hall}', [AdminController::class, 'updateHall'])->name('update');
        Route::delete('/{hall}', [AdminController::class, 'deleteHall'])->name('destroy');
        Route::post('/{hall}/toggle', [AdminController::class, 'toggleHallActivation'])->name('toggle');
    });

    // Управление сеансами
    Route::prefix('admin/seances')->name('admin.seances.')->group(function () {
        Route::get('/', [SeanceController::class, 'index'])->name('index');
        Route::get('/create', [SeanceController::class, 'create'])->name('create');
        Route::post('/', [SeanceController::class, 'store'])->name('store');
        Route::get('/{seance}/edit', [SeanceController::class, 'edit'])->name('edit');
        Route::put('/{seance}', [SeanceController::class, 'update'])->name('update');
        Route::delete('/{seance}', [SeanceController::class, 'destroy'])->name('destroy');
    });

    // Управление фильмами
    Route::prefix('admin/movies')->name('admin.movies.')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('index');
        Route::get('/create', [MovieController::class, 'create'])->name('create');
        Route::post('/store', [MovieController::class, 'store'])->name('store');
        Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('edit');
        Route::put('/{movie}', [MovieController::class, 'update'])->name('update');
        Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('destroy');
    });

    // Управление ценами (если необходимо)
    // Если у вас есть функциональность для управления ценами, убедитесь, что соответствующие методы существуют в AdminController

    // Управление пользователями
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/admin/users/{user}/toggleRole', [AdminController::class, 'toggleRole'])->name('admin.users.toggleRole');
});