@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Панель управления') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <!-- Уведомление об успешном входе -->
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Добро пожаловать, {{ Auth::user()->name }}!</h4>
                    <p>Вы успешно вошли в систему.</p>

                    <div class="mt-4">
                        <!-- Условия для отображения кнопок в зависимости от роли пользователя -->
                        @if(Auth::user()->role === 'admin')
                            <!-- Кнопки управления для администраторов -->
                            <a href="{{ route('admin.halls.index') }}" class="btn btn-primary">Управление Залами</a>
                            <a href="{{ route('admin.movies.index') }}" class="btn btn-primary">Управление Фильмами</a>
                            <a href="{{ route('admin.seances.index') }}" class="btn btn-primary">Управление Сеансами</a>
                        @else
                            <!-- Кнопки для обычных пользователей -->
                            <a href="{{ route('client.index') }}" class="btn btn-primary">Посмотреть фильмы</a>
                            <a href="{{ route('client.schedule') }}" class="btn btn-secondary">Просмотреть расписание</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
