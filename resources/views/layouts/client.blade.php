<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cinema App')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome для иконок -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Навигация -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-film"></i> Проект кинотеатра
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.index') }}">
                            <i class="fas fa-ticket-alt"></i> Сеансы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.movies') }}">
                            <i class="fas fa-film"></i> Фильмы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.schedule') }}">
                            <i class="far fa-calendar-alt"></i> Расписание
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.contact') }}">
                            <i class="fas fa-envelope"></i> Контакты
                        </a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Войти
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> Регистрация
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('client.profile') }}">
                                    <i class="fas fa-user-circle"></i> Профиль
                                </a>
                                <a class="dropdown-item" href="{{ route('client.tickets') }}">
                                    <i class="fas fa-ticket-alt"></i> Мои билеты
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Выйти
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <header class="container mt-4">
        @yield('header')
    </header>
    
    <main class="flex-grow-1 container mt-5">
        @yield('content')
    </main>

    <!-- Футер -->
    <footer class="bg-light text-dark text-center py-3 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>Мы в соцсетях:</h5>
                    <div class="social-icons">
                        <a href="https://facebook.com"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="https://twitter.com"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="https://telegram.org"><i class="fab fa-telegram fa-2x"></i></a>
                    </div>
                    <div class="social-icons">
                        <a href="https://vk.com"><i class="fab fa-vk fa-2x"></i></a>
                        <a href="https://discord.com"><i class="fab fa-discord fa-2x"></i></a>
                        <a href="https://instagram.com"><i class="fab fa-instagram fa-2x"></i></a>
                    </div>
                </div>

                <div class="col-md-4 mb-3 useful-links">
                    <h5>Полезные ссылки</h5>
                    <a href="{{ route('client.contact') }}"><i class="fas fa-envelope"></i> Контакты</a>
                    <a href="{{ route('client.privacy-policy') }}"><i class="fas fa-file-alt"></i> Соглашение</a>

                    <div class="call-section">
                        <h5>Звоните</h5>
                        <a href="tel:+71234567890"><i class="fas fa-phone-alt"></i> +7 (123) 456-78-90</a>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <h5>Наш адрес</h5>
                    <p>ул. Примерная, дом 10</p>
                    <div id="map" style="width: 100%; height: 150px;"></div>
                </div>
            </div>
            <p class="mt-4">© {{ date('Y') }} Проект кинотеатра. Все права защищены.</p>
        </div>
    </footer>

    <!-- Подключение Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Яндекс.Карты -->
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
        ymaps.ready(function () {
            var myMap = new ymaps.Map('map', {
                center: [55.751574, 37.573856],
                zoom: 12
            }, {
                searchControlProvider: 'yandex#search'
            });

            myMap.geoObjects.add(new ymaps.Placemark([55.751574, 37.573856], {
                balloonContent: 'Наш кинотеатр'
            }, {
                preset: 'islands#icon',
                iconColor: '#007bff'
            }));
        });
    </script>

    @stack('scripts')
</body>
</html>
