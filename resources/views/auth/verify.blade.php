@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Подтверждение электронной почты') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Новое письмо с подтверждением было отправлено на вашу электронную почту.') }}
                        </div>
                    @endif

                    <p>{{ __('Прежде чем продолжить, проверьте свою почту на наличие письма с подтверждением.') }}</p>
                    <p>{{ __('Если вы не получили письмо') }},</p>
                    
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('нажмите сюда, чтобы запросить новое письмо') }}</button>.
                    </form>

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
