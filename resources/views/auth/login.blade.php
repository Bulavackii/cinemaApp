@extends('layouts.client')

@section('title', 'Вход')

@section('content')
<div class="container mt-5 auth-page">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Карточка для формы входа -->
            <div class="card shadow-lg">
                <!-- Заголовок карточки с текстом "Вход в аккаунт" -->
                <div class="card-header bg-primary text-white text-center">
                    {{ __('Вход в аккаунт') }}
                </div>

                <div class="card-body">
                    <!-- Форма для входа пользователя -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Поле для ввода электронной почты -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Электронная почта') }}</label>
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <!-- Отображение ошибки, если введена неправильная почта -->
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
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <!-- Кнопка для отображения/скрытия пароля -->
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')">
                                        <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <!-- Отображение ошибки для поля пароля -->
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Чекбокс для функции "Запомнить меня" -->
                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">{{ __('Запомнить меня') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Кнопка для отправки формы и ссылки на восстановление пароля и регистрацию -->
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4 d-flex flex-column align-items-start">
                                <button type="submit" class="btn btn-warning text-white w-100 mb-2">
                                    {{ __('Войти') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Забыли пароль?') }}</a>
                                @endif

                                <a href="{{ route('register') }}" class="btn btn-secondary mt-2 w-100">{{ __('Зарегистрироваться') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Скрипт для отображения/скрытия пароля -->
<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById('togglePasswordIcon');
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endpush
