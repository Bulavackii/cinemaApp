@extends('layouts.client')

@section('title', 'Ваш билет')

@section('content')
    <div class="container mt-5 mb-5">
        <section class="ticket-card shadow-lg rounded">
            <div class="ticket-left">
                <h2 class="movie-title text-center mb-4">Ваш билет</h2>
                
                <!-- Информация о фильме и сеансе -->
                <p class="ticket-info"><strong>Фильм:</strong> {{ $session->movie->title }}</p>
                <p class="ticket-info"><strong>Зал:</strong> {{ $session->cinemaHall->name }}</p>
                <p class="ticket-info"><strong>Время сеанса:</strong> {{ $session->start_time->translatedFormat('H:i, d F Y') }}</p>

                <!-- Перечисление всех выбранных мест -->
                <p class="ticket-info"><strong>Места:</strong></p>
                <ul class="list-unstyled text-left">
                    @foreach ($seats as $ticket)
                        <li class="mb-3">
                            <span><strong>Ряд:</strong> {{ $ticket->seat_row }}, <strong>Место:</strong> {{ $ticket->seat_number }}</span><br>
                            <span><strong>Тип места:</strong> {{ $ticket->seat_type === 'vip' ? 'VIP' : 'Обычное' }}</span><br>
                            <span><strong>Цена:</strong> {{ $ticket->price }} руб.</span>
                        </li>
                    @endforeach
                </ul>

                <!-- Код бронирования -->
                <p class="ticket-info"><strong>Код бронирования:</strong> {{ $booking_code }}</p>

                <!-- QR-код билета -->
                @if($qrCodeUrl)
                    <div class="qr-code text-center">
                        <img src="{{ $qrCodeUrl }}" alt="QR-код билета" class="img-fluid">
                    </div>
                @else
                    <p class="text-danger">QR-код не был сгенерирован.</p>
                @endif

                <div class="text-center mt-4">
                    <!-- Кнопка для печати билета -->
                    <button class="btn btn-warning" onclick="window.print()">Печать билета</button>
                </div>
            </div>
            <div class="ticket-right text-center">
                <img src="{{ asset('client/images/cinema_logo.png') }}" alt="Логотип кинотеатра" class="img-fluid mb-4">
                <p><strong>Спасибо за ваш заказ!</strong></p>
            </div>
        </section>
    </div>

    @push('styles')
        <!-- Подключение стилей для страницы билета -->
        <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
    @endpush
@endsection
