@extends('layouts.client')

@section('title', 'Расписание')

@section('header')
    <!-- Заголовок страницы "Расписание" -->
    <div class="section-title text-center" style="margin-bottom: 5px;">
        Расписание
    </div>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            @if($seances->isEmpty())
                <!-- Сообщение о том, что сеансы отсутствуют -->
                <p class="text-white text-center">В настоящее время нет доступных сеансов.</p>
            @else
                <div class="col-md-6"> <!-- Уменьшаем ширину колонок до 6 для лучшего отображения -->
                    <div class="list-group">
                        @foreach($seances as $seance)
                            <div class="list-group-item list-group-item-action mb-3 shadow-lg">
                                <div class="d-flex align-items-center">
                                    <!-- Проверяем наличие постера фильма -->
                                    @if ($seance->movie->poster_url)
                                        <img src="{{ asset($seance->movie->poster_url) }}" class="img-fluid movie-poster mr-3" alt="{{ $seance->movie->title }}">
                                    @endif
                                    <!-- Информация о сеансе -->
                                    <div class="ml-3"> <!-- Добавлен отступ слева для информации -->
                                        <h5 class="mb-1 text-dark font-weight-bold">{{ $seance->movie->title }}</h5>
                                        <p class="mb-1 text-dark">
                                            <strong>Время:</strong> {{ $seance->start_time->format('d.m.Y H:i') }}<br>
                                            <strong>Зал:</strong> {{ $seance->cinemaHall->name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <!-- Кнопка для бронирования билетов -->
                                    <a href="{{ route('client.hall', $seance->id) }}" class="btn btn-warning btn-sm">
                                        Забронировать билеты
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <!-- Подключение стилей для страницы расписания -->
        <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
    @endpush
@endsection
