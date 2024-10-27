@extends('layouts.client')

@section('content')
    <div class="container mt-4" style="margin-bottom: 100px;">
        <!-- Карточка фильма -->
        <div class="movie card shadow-lg mx-auto" style="max-width: 700px; border-radius: 15px; overflow: hidden;">
            <div class="row g-0">
                <!-- Отображение постера, если он существует -->
                <div class="col-md-4">
                    @if ($movie->poster_url)
                        <img src="{{ asset($movie->poster_url) }}" alt="{{ $movie->title }}" class="movie__poster img-fluid rounded-start">
                    @endif
                </div>
                <!-- Информация о фильме -->
                <div class="col-md-8 d-flex flex-column justify-content-between">
                    <div class="p-4">
                        <h1 class="movie__title">{{ $movie->title }}</h1>
                        <p class="movie__synopsis">
                            <strong>Описание:</strong> {{ $movie->description }}
                        </p>
                        <p class="movie__data"><strong>Жанр:</strong> {{ $movie->genre }}</p>
                        <p class="movie__data"><strong>Страна:</strong> {{ $movie->country }}</p>
                        <p class="movie__data"><strong>Длительность:</strong> {{ $movie->duration }} минут</p>
                    </div>

                    <!-- Кнопка для бронирования билета -->
                    <div class="p-4">
                        <a href="{{ route('client.hall', $movie->id) }}" class="acceptin-button btn btn-primary btn-lg w-100">Бронировать билет</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
@endpush
