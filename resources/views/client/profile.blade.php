@extends('layouts.client')

@section('title', 'Профиль')

@section('header')
    <!-- Заголовок страницы "Профиль" -->
    <div class="section-title text-center" style="margin-bottom: 5px;">
        Профиль
    </div>
@endsection

@section('content')
    <div class="container mt-4" style="margin-bottom: 100px;"> 
        <div class="card shadow-lg" style="max-width: 600px; margin: 0 auto;"> 
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <!-- Отображение имени пользователя -->
                        <p class="h5 mb-4"><strong>Имя:</strong> {{ $user->name }}</p>
                        <!-- Отображение email пользователя -->
                        <p class="h5 mb-4"><strong>Email:</strong> {{ $user->email }}</p>
                        <hr>
                        <!-- Информационное сообщение о профиле -->
                        <p class="text-muted text-center">
                            Ваш профиль содержит основную информацию о вас, используемую для бронирования билетов и связи.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <!-- Подключение стилей для страницы профиля -->
        <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
    @endpush
@endsection
