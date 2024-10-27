<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Админ Панель</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- FontAwesome для иконок -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Подключение стилей для админ панели -->
    <link rel="stylesheet" href="{{ asset('ad/css/index.css') }}">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('ad/i/logo.png') }}" alt="Эмблема Админ Панели">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <!-- Главная страница админ панели -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index') }}">
                                <i class="fas fa-home"></i> Главная
                            </a>
                        </li>
                        <!-- Управление фильмами -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.movies.index') }}">
                                <i class="fas fa-film"></i> Фильмы
                            </a>
                        </li>
                        <!-- Управление залами -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.halls.index') }}">
                                <i class="fas fa-door-open"></i> Залы
                            </a>
                        </li>
                        <!-- Управление сеансами -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.seances.index') }}">
                                <i class="fas fa-clock"></i> Сеансы
                            </a>
                        </li>
                        <!-- Управление пользователями -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users') }}">
                                <i class="fas fa-users"></i> Пользователи
                            </a>
                        </li>
                        <!-- Выход из системы -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Выйти
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Скрытая форма для выхода из системы -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </header>

    <!-- Основной контент страницы -->
    <main class="py-4">
        <div class="container">
            @yield('content') <!-- Здесь будет основной контент страницы -->
        </div>
    </main>

    <!-- Футер с копирайтом -->
    <footer class="bg-dark text-white text-center py-3">
        <p>© {{ date('Y') }} Админ Панель Кинотеатра. Все права защищены.</p>
    </footer>

    <!-- Bootstrap JS для функциональности -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
