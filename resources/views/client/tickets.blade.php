@extends('layouts.client')

@section('title', 'Мои билеты')

@section('header')
    <div class="section-title text-center" style="margin-bottom: 5px;">
        Мои билеты
    </div>
@endsection

@section('content')
    <div class="container mt-4">
        @if($tickets->isEmpty())
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="alert alert-info text-center">
                        У вас пока нет приобретенных билетов
                    </div>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                @foreach($tickets as $ticket)
                    <div class="col-sm-12 col-md-8 d-flex justify-content-center align-items-stretch mb-4">
                        <div class="ticket-card">
                            <div class="ticket-left">
                                <h5 class="movie-title">{{ $ticket->seance->movie->title }}</h5>
                                <p>
                                    <strong>Зал:</strong> {{ $ticket->seance->cinemaHall->name }}<br>
                                    <strong>Дата и время:</strong> {{ $ticket->seance->start_time->format('d.m.Y H:i') }}<br>
                                    <strong>Место:</strong> Ряд {{ $ticket->seat_row }}, Место {{ $ticket->seat_number }}
                                </p>
                            </div>
                            <div class="ticket-right">
                                <img src="{{ asset($ticket->qr_code) }}" alt="QR Code" class="qr-code">
                                <a href="{{ asset($ticket->qr_code) }}" class="btn btn-download" download="QR код">
                                    Скачать QR-код
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
    @endpush
@endsection
