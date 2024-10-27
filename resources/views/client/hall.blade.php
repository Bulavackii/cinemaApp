@extends('layouts.client')

@section('title', 'Выбор мест')

@section('content')
    <div class="container mt-4 mb-5">
        <!-- Постер фильма -->
        <div class="text-center">
            <img src="{{ asset($session->movie->poster_url) }}" alt="Постер фильма {{ $session->movie->title }}"
                class="img-fluid" style="max-width: 300px; border-radius: 10px;">
        </div>

        <!-- Заголовок и информация о сеансе -->
        <h2 class="text-center text-dark mt-3">Выберите места для сеанса "{{ $session->movie->title }}"</h2>
        <p class="text-center text-dark">Зал: {{ $session->cinemaHall->name }}</p>
        <p class="text-center text-dark">Время: {{ $session->start_time->format('d.m.Y H:i') }}</p>

        <!-- Изображение экрана кинотеатра -->
        <div class="screen-container text-center my-4">
            <img id="screenImage" src="{{ asset('client/i/screen.png') }}" alt="Экран кинотеатра" class="img-fluid" style="max-width: 600px;">
        </div>

        <!-- Схема зала -->
        <h3 class="text-center text-dark mt-5">Схема зала</h3>

        <!-- Сообщение об ошибке, если не выбрано место -->
        <div id="error-message" class="alert alert-danger d-none text-center" role="alert">
            Пожалуйста, выберите хотя бы одно место для бронирования.
        </div>

        <!-- Выбор типа места -->
        <div class="d-flex justify-content-center mb-4">
            <label class="btn btn-primary mr-3">
                <input type="radio" name="seat_type" value="regular" checked> Обычное место ({{ $session->price_regular }} руб.)
            </label>
            <label class="btn btn-danger">
                <input type="radio" name="seat_type" value="vip"> VIP место ({{ $session->price_vip }} руб.)
            </label>
        </div>

        <!-- Счетчик выбранных мест -->
        <p id="seat-counter" class="text-center text-dark">Вы выбрали <span id="selectedCount">0</span> мест.</p>

        <!-- Схема зала -->
        <div class="hall-layout mt-3 d-flex justify-content-center">
            <div class="seating-grid">
                @for ($row = 1; $row <= $rows; $row++)
                    <div class="seat-row-container d-flex justify-content-center align-items-center mb-2">
                        <!-- Метка ряда -->
                        <span class="row-label text-dark font-weight-bold mr-3">Ряд {{ $row }}</span>
                        <div class="seats-row d-flex justify-content-center">
                            @for ($seat = 1; $seat <= $seatsPerRow; $seat++)
                                @php
                                    // Проверяем, забронировано ли место
                                    $isBooked = $bookedSeats->contains(function ($seatObj) use ($row, $seat) {
                                        return $seatObj->seat_row == $row && $seatObj->seat_number == $seat;
                                    });
                                @endphp

                                <!-- Место -->
                                <label class="seat m-1">
                                    <input type="checkbox" name="seats[]" value="{{ $row }}-{{ $seat }}"
                                        {{ $isBooked ? 'disabled' : '' }} onclick="updateSelectedCount()">
                                    <span class="
                                        seat-number
                                        @if ($isBooked)
                                            booked
                                        @else
                                            available
                                        @endif
                                    " title="Ряд {{ $row }}, Место {{ $seat }}">
                                        {{ $seat }}
                                    </span>
                                </label>
                            @endfor
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Форма бронирования -->
        <form id="bookingForm" action="{{ route('client.complete_booking') }}" method="POST" class="text-center mt-5">
            @csrf
            <input type="hidden" name="session_id" value="{{ $session->id }}">
            <input type="hidden" name="selected_seats" id="selectedSeatsInput">
            <input type="hidden" name="seat_type" id="selectedSeatType">
            <button type="button" class="btn btn-warning btn-lg" onclick="completeBooking()">Забронировать</button>
        </form>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
    @endpush

    @push('scripts')
        <script>
            // Завершение бронирования
            function completeBooking() {
                const selectedSeats = document.querySelectorAll('input[name="seats[]"]:checked');
                const seatType = document.querySelector('input[name="seat_type"]:checked').value;

                if (selectedSeats.length === 0) {
                    alert('Пожалуйста, выберите хотя бы одно место для бронирования.');
                    return;
                }

                let selectedSeatsValue = [];
                selectedSeats.forEach(seat => {
                    selectedSeatsValue.push(seat.value);
                });

                document.getElementById('selectedSeatsInput').value = selectedSeatsValue.join(',');
                document.getElementById('selectedSeatType').value = seatType;

                document.getElementById('bookingForm').submit();
            }

            // Обновление счетчика выбранных мест
            function updateSelectedCount() {
                const selectedSeats = document.querySelectorAll('input[name="seats[]"]:checked');
                document.getElementById('selectedCount').innerText = selectedSeats.length;
            }

            // Изменение изображения экрана кинотеатра в зависимости от ширины экрана
            function changeScreenImage() {
                const screenImage = document.getElementById('screenImage');
                const screenWidth = window.innerWidth;

                if (screenWidth <= 768) {
                    screenImage.src = "{{ asset('client/i/screen-420.png') }}";
                } else {
                    screenImage.src = "{{ asset('client/i/screen.png') }}";
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                updateSelectedCount();
                changeScreenImage();
            });

            window.addEventListener('resize', changeScreenImage);
        </script>
    @endpush
@endsection
