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
        $sessions = Seance::with(['movie', 'cinemaHall'])
                          ->where('start_time', '>=', now())
                          ->orderBy('start_time', 'asc')
                          ->get();

        // Группируем сеансы по фильму
        $movies = $sessions->groupBy('movie_id');

        return view('client.index', compact('movies'));
    }

    // Страница выбора мест для сеанса
    public function hall($id)
    {
        $session = Seance::with(['movie', 'cinemaHall'])
            ->whereHas('cinemaHall', function ($query) {
                $query->where('is_active', true);
            })
            ->findOrFail($id);
    
        $rows = $session->cinemaHall->rows;
        $seatsPerRow = $session->cinemaHall->seats_per_row;
        $bookedSeats = Ticket::where('seance_id', $session->id)->get(['seat_row', 'seat_number']);
    
        return response()
            ->view('client.hall', compact('session', 'rows', 'seatsPerRow', 'bookedSeats'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }    

    // Обработка завершения бронирования
    public function completeBooking(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:seances,id',
            'selected_seats' => 'required|string',
            'seat_type' => 'required|in:regular,vip',
        ]);

        $session = Seance::findOrFail($request->session_id);
        $selectedSeats = explode(',', $request->selected_seats);
        $seatType = $request->seat_type;

        $userId = Auth::id();
        $ticketIds = []; // Массив для хранения ID созданных билетов

        foreach ($selectedSeats as $seat) {
            [$row, $number] = explode('-', $seat);

            // Проверяем, не занято ли место
            $isBooked = Ticket::where('seance_id', $session->id)
                ->where('seat_row', $row)
                ->where('seat_number', $number)
                ->exists();

            if ($isBooked) {
                return redirect()->back()->withErrors(['Место ряд ' . $row . ', место ' . $number . ' уже занято.']);
            }

            // Определяем цену места
            $price = $seatType === 'vip' ? $session->price_vip : $session->price_regular;

            // Создаем билет
            $ticket = Ticket::create([
                'seance_id' => $session->id,
                'user_id' => $userId,
                'seat_row' => $row,
                'seat_number' => $number,
                'seat_type' => $seatType,
                'price' => $price,
                'qr_code' => '', // Заполним позже
            ]);

            $ticketIds[] = $ticket->id;
        }

        // Генерация QR-кода и обновление билетов
        foreach ($ticketIds as $ticketId) {
            $ticket = Ticket::find($ticketId);
            $qrData = route('ticket.show', $ticket->id);
            $qrCodePath = 'qrcodes/' . $ticket->id . '.png';

            // Генерация QR-кода с использованием endroid/qr-code
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($qrData)
                ->size(200)
                ->margin(10)
                ->build();

            // Убедитесь, что директория для хранения QR-кодов существует
            if (!file_exists(public_path('qrcodes'))) {
                mkdir(public_path('qrcodes'), 0755, true);
            }

            // Сохранение QR-кода в файл
            $result->saveToFile(public_path($qrCodePath));

            $ticket->qr_code = $qrCodePath;
            $ticket->save();
        }

        // Получаем билеты из базы данных как коллекцию объектов модели Ticket
        $tickets = Ticket::whereIn('id', $ticketIds)->get();

        return view('client.ticket', [
            'session' => $session,
            'seats' => $tickets,
            'booking_code' => strtoupper(Str::random(8)) . "-S{$session->id}",
            'qrCodeUrl' => asset($tickets->first()->qr_code),
        ]);
    }

    // Метод для отображения информации о билете
    public function showTicket($id)
    {
        $ticket = Ticket::with('seance.movie', 'seance.cinemaHall')->findOrFail($id);
        return view('client.ticket_details', compact('ticket'));
    }

    // Страница с деталями фильма
    public function showMovieDetails($id)
    {
        $movie = Movie::findOrFail($id);
        return view('client.movie.details', compact('movie'));
    }

    // Метод для отображения списка фильмов
    public function showMovies()
    {
        $movies = Movie::all();
        return view('client.movies', compact('movies'));
    }

    // Страница с расписанием сеансов
    public function showSchedule()
    {
        $seances = Seance::with('movie', 'cinemaHall')->get();
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
        $user = Auth::user();
        return view('client.profile', compact('user'));
    }

    // Страница с билетами пользователя
    public function tickets()
    {
        $user = Auth::user();
        $tickets = $user->tickets()->with('seance.movie', 'seance.cinemaHall')->get();

        return view('client.tickets', compact('tickets'));
    }

    // Страница настроек пользователя
    public function settings()
    {
        $user = Auth::user();
        return view('client.settings', compact('user'));
    }
}
