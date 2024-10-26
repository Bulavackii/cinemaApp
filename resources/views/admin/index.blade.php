@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h2 class="mb-0">Административная панель</h2>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row mt-4 justify-content-center">
                    <!-- Карточка Пользователи -->
                    <div class="col-md-3 col-sm-6 d-flex align-items-stretch">
                        <div class="card admin-card text-white bg-info mb-4 shadow-sm w-100">
                            <div class="card-header text-center">
                                <i class="fas fa-users fa-2x"></i>
                                <div>Пользователи</div>
                            </div>
                            <div class="card-body text-center d-flex flex-column">
                                <h5 class="card-title">Админы и гости</h5>
                                <p class="card-text flex-grow-1">
                                    Всего администраторов: {{ $adminsCount }}<br>
                                    Всего гостей: {{ $guestsCount }}
                                </p>
                                <a href="{{ route('admin.users') }}" class="btn btn-light mt-auto">Перейти</a>
                            </div>
                        </div>
                    </div>
                    <!-- Карточка Управление Залами -->
                    <div class="col-md-3 col-sm-6 d-flex align-items-stretch">
                        <div class="card admin-card text-white bg-primary mb-4 shadow-sm w-100">
                            <div class="card-header text-center">
                                <i class="fas fa-door-open fa-2x"></i>
                                <div>Управление Залами</div>
                            </div>
                            <div class="card-body text-center d-flex flex-column">
                                <h5 class="card-title">Залы Кинотеатра</h5>
                                <p class="card-text flex-grow-1">Действия с залами кинотеатра.</p>
                                <a href="{{ route('admin.halls.index') }}" class="btn btn-light mt-auto">Перейти</a>
                            </div>
                        </div>
                    </div>
                    <!-- Карточка Управление Сеансами -->
                    <div class="col-md-3 col-sm-6 d-flex align-items-stretch">
                        <div class="card admin-card text-white bg-success mb-4 shadow-sm w-100">
                            <div class="card-header text-center">
                                <i class="fas fa-film fa-2x"></i>
                                <div>Управление Сеансами</div>
                            </div>
                            <div class="card-body text-center d-flex flex-column">
                                <h5 class="card-title">Сеансы Фильмов</h5>
                                <p class="card-text flex-grow-1">Создание и управление сеансами фильмов.</p>
                                <a href="{{ route('admin.seances.index') }}" class="btn btn-light mt-auto">Перейти</a>
                            </div>
                        </div>
                    </div>
                    <!-- Карточка Управление Фильмами -->
                    <div class="col-md-3 col-sm-6 d-flex align-items-stretch">
                        <div class="card admin-card text-white bg-warning mb-4 shadow-sm w-100">
                            <div class="card-header text-center">
                                <i class="fas fa-video fa-2x"></i>
                                <div>Управление Фильмами</div>
                            </div>
                            <div class="card-body text-center d-flex flex-column">
                                <h5 class="card-title">Фильмы</h5>
                                <p class="card-text flex-grow-1">Добавление и управление фильмами в системе.</p>
                                <a href="{{ route('admin.movies.index') }}" class="btn btn-light mt-auto">Перейти</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Подключение FontAwesome для иконок --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    {{-- Подключение стилей --}}
    @push('styles')
        <link rel="stylesheet" href="{{ asset('ad/css/index.css') }}">
    @endpush
@endsection
