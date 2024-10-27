@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Карточка для подтверждения электронной почты -->
            <div class="card">
                <div class="card-header">{{ __('Подтверждение электронной почты') }}</div>

                <div class="card-body">
                    <!-- Сообщение об успешной отправке нового письма с подтверждением -->
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Новое письмо с подтверждением было отправлено на вашу электронную почту.') }}
                        </div>
                    @endif

                    <!-- Основное описание процесса подтверждения -->
                    <p>{{ __('Прежде чем продолжить, проверьте свою почту на наличие письма с подтверждением.') }}</p>
                    <p>{{ __('Если вы не получили письмо') }},</p>

                    <!-- Форма для повторной отправки письма с подтверждением -->
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <!-- Кнопка для повторного запроса письма -->
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('нажмите сюда, чтобы запросить новое письмо') }}</button>.
                    </form>

                    <!-- Дополнительная информация по поиску письма в "Спам" -->
                    <hr>
                    <p class="text-muted">
                        {{ __('Если вы не видите письмо в своем почтовом ящике, проверьте папку "Спам" или "Нежелательная почта".') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
