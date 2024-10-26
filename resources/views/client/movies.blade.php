@extends('layouts.client')

@section('title', 'Фильмы')

@section('header')
    <div class="section-title text-center" style="margin-bottom: 5px;">
        Фильмы
    </div>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            @if($movies->isEmpty())
                <p class="text-white text-center">На данный момент фильмы отсутствуют.</p>
            @else
                @foreach($movies as $movie)
                    <div class="col-sm-6 col-md-4 d-flex justify-content-center">
                        <div class="card movie-card shadow-lg mb-4">
                            @if ($movie->poster_url)
                                <img src="{{ asset($movie->poster_url) }}" class="card-img-top movie-poster" alt="{{ $movie->title }}">
                            @endif
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title">{{ $movie->title }}</h5>
                                    <p class="card-text">{{ Str::limit($movie->description, 100) }}</p>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('client.movie.details', $movie->id) }}" class="btn btn-warning btn-block">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
@endpush
