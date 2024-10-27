<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seance;
use App\Models\Ticket;
use App\Models\Movie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class ClientController extends Controller
{
    // Главная страница с расписанием фильмов
    public function index()
    {
        // Получаем сеансы, которые еще не начались, сортируем по времени начала
        $sessions = Seance::with(['movie', 'cinemaHall'])
                          ->where('start_time', '>=', now())
                          ->orderBy('start_time', 'asc')
                          ->get();

        // Группируем сеансы по ID фильмов
        $movies = $sessions->groupBy('movie_id');

        return view('client.index', compact('movies'));
    }

    // Страница выбора мест для конкретного сеанса
    public function hall($id)
    {
        // Получаем информацию о сеансе, фильме и активном зале
        $session = Seance::with(['movie', 'cinemaHall'])
            ->whereHas('cinemaHall', function ($query) {
                $query->where('is_active', true); // Только активные залы
            })
            ->findOrFail($id);
    
        $rows = $session->cinemaHall->rows;
        $seatsPerRow = $session->cinemaHall->seats_per_row;

        // Получаем занятые места для данного сеанса
        $bookedSeats = Ticket::where('seance_id', $session->id)->get(['seat_row', 'seat_number']);
    
        // Отключаем кеширование страницы
        return response()
            ->view('client.hall', compact('session', 'rows', 'seatsPerRow', 'bookedSeats'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }    

    // Обработка завершения бронирования билетов
    public function completeBooking(Request $request)
    {
        // Валидация данных бронирования
        $request->validate([
            'session_id' => 'required|exists:seances,id',
            'selected_seats' => 'required|string', // Строка с выбранными местами
            'seat_type' => 'required|in:regular,vip', // Тип места: обычное или VIP
        ]);

        // Поиск сеанса
        $session = Seance::findOrFail($request->session_id);
        $selectedSeats = explode(',', $request->selected_seats); // Разбиваем строку мест
        $seatType = $request->seat_type;

        $userId = Auth::id(); // ID текущего пользователя
        $ticketIds = []; // Массив для хранения ID созданных билетов

        foreach ($selectedSeats as $seat) {
            [$row, $number] = explode('-', $seat); // Разбиваем информацию о ряде и номере места

            // Проверка, не занято ли место
            $isBooked = Ticket::where('seance_id', $session->id)
                ->where('seat_row', $row)
                ->where('seat_number', $number)
                ->exists();

            if ($isBooked) {
                return redirect()->back()->withErrors(['Место ряд ' . $row . ', место ' . $number . ' уже занято.']);
            }

            // Определяем цену места в зависимости от типа
            $price = $seatType === 'vip' ? $session->price_vip : $session->price_regular;

            // Создаем новый билет
            $ticket = Ticket::create([
                'seance_id' => $session->id,
                'user_id' => $userId,
                'seat_row' => $row,
                'seat_number' => $number,
                'seat_type' => $seatType,
                'price' => $price,
                'qr_code' => '', // QR-код заполним позже
            ]);

            $ticketIds[] = $ticket->id; // Сохраняем ID билета
        }

        // Генерация QR-кодов для каждого билета
        foreach ($ticketIds as $ticketId) {
            $ticket = Ticket::find($ticketId);
            $qrData = route('ticket.show', $ticket->id); // Ссылка на билет для QR-кода
            $qrCodePath = 'qrcodes/' . $ticket->id . '.png';

            // Генерация QR-кода
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($qrData)
                ->size(200)
                ->margin(10)
                ->build();

            // Создаем директорию для QR-кодов, если ее нет
            if (!file_exists(public_path('qrcodes'))) {
                mkdir(public_path('qrcodes'), 0755, true);
            }

            // Сохраняем QR-код
            $result->saveToFile(public_path($qrCodePath));

            // Обновляем путь к QR-коду для билета
            $ticket->qr_code = $qrCodePath;
            $ticket->save();
        }

        // Получаем билеты как коллекцию для отображения
        $tickets = Ticket::whereIn('id', $ticketIds)->get();

        // Возвращаем страницу с билетами и QR-кодом
        return view('client.ticket', [
            'session' => $session,
            'seats' => $tickets,
            'booking_code' => strtoupper(Str::random(8)) . "-S{$session->id}", // Код бронирования
            'qrCodeUrl' => asset($tickets->first()->qr_code), // URL QR-кода для первого билета
        ]);
    }

    // Метод для отображения информации о конкретном билете
    public function showTicket($id)
    {
        $ticket = Ticket::with('seance.movie', 'seance.cinemaHall')->findOrFail($id); // Получаем билет с информацией о сеансе
        return view('client.ticket_details', compact('ticket'));
    }

    // Страница с деталями фильма
    public function showMovieDetails($id)
    {
        $movie = Movie::findOrFail($id); // Получаем информацию о фильме
        return view('client.movie.details', compact('movie'));
    }

    // Метод для отображения списка фильмов
    public function showMovies()
    {
        $movies = Movie::all(); // Получаем все фильмы
        return view('client.movies', compact('movies'));
    }

    // Страница с расписанием сеансов
    public function showSchedule()
    {
        $seances = Seance::with('movie', 'cinemaHall')->get(); // Получаем все сеансы
        return view('client.schedule', compact('seances'));
    }

    // Страница "Контакты"
    public function showContactPage()
    {
        return view('client.contact');
    }

    // Страница профиля пользователя
    public function profile()
    {
        $user = Auth::user(); // Получаем данные текущего пользователя
        return view('client.profile', compact('user'));
    }

    // Страница с билетами пользователя
    public function tickets()
    {
        $user = Auth::user();
        $tickets = $user->tickets()->with('seance.movie', 'seance.cinemaHall')->get(); // Получаем билеты пользователя
        return view('client.tickets', compact('tickets'));
    }

    // Страница настроек пользователя
    public function settings()
    {
        $user = Auth::user(); // Получаем данные текущего пользователя
        return view('client.settings', compact('user'));
    }
}
