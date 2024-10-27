@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Карточка для сброса пароля -->
            <div class="card">
                <!-- Заголовок формы сброса пароля -->
                <div class="card-header">{{ __('Сброс Пароля') }}</div>

                <div class="card-body">
                    <!-- Уведомление об успешной отправке ссылки на сброс пароля -->
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Форма для запроса ссылки на сброс пароля -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Поле для ввода email -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Адрес') }}</label>

                            <div class="col-md-6">
                                <!-- Поле для email с проверкой ошибок -->
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                
                                <!-- Подсказка для пользователя -->
                                <small class="form-text text-muted">
                                    Пожалуйста, введите email, связанный с вашим аккаунтом.
                                </small>

                                <!-- Сообщение об ошибке, если email неверен -->
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Кнопка отправки формы -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Отправить Ссылку для Сброса Пароля') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
