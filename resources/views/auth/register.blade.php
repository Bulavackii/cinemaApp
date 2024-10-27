@extends('layouts.client')

@section('title', 'Регистрация')

@section('content')
<div class="container mt-5 auth-page">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Карточка для формы регистрации -->
            <div class="card shadow-lg">
                <!-- Заголовок карточки с текстом "Регистрация" -->
                <div class="card-header bg-primary text-white text-center">
                    {{ __('Регистрация') }}
                </div>

                <div class="card-body">
                    <!-- Форма регистрации пользователя -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Поле для ввода имени пользователя -->
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Имя') }}</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Поле для ввода электронной почты -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Электронная почта') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Поле для ввода пароля с возможностью его показа/скрытия -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Пароль') }}</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <!-- Кнопка для показа/скрытия пароля -->
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Поле для подтверждения пароля с возможностью его показа/скрытия -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Подтвердите пароль') }}</label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    <!-- Кнопка для показа/скрытия пароля -->
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password-confirm')">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Кнопка отправки формы регистрации -->
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-warning text-white">
                                    {{ __('Зарегистрироваться') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Скрипт для показа/скрытия пароля -->
<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.firstElementChild;
        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection

@push('styles')
<!-- Подключение стилей и FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    body {
        background-image: url('{{ asset('client/i/background.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    .card-header {
        background-color: #007bff; 
    }

    .btn-warning {
        background-color: #ff9800; 
        border-radius: 20px;
    }

    .btn-warning:hover {
        background-color: #e68900;
    }

    .form-label {
        color: #333;
        font-weight: bold;
    }

    .input-group button {
        border-radius: 0 10px 10px 0;
    }

    /* Стили для страницы регистрации */
    .auth-page {
        margin-bottom: 100px;
    }
</style>
@endpush
