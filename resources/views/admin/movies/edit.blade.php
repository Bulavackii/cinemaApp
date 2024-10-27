@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="col-lg-8 mx-auto">
            <!-- Карточка для редактирования фильма -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Редактировать фильм</h2>
                </div>
                <div class="card-body">
                    <!-- Сообщение об успешном обновлении -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Вывод ошибок, если они есть -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Форма редактирования фильма -->
                    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Поле для ввода названия фильма -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Название фильма:</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title', $movie->title) }}" required placeholder="Введите название фильма">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле для ввода описания фильма -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" required placeholder="Введите описание фильма">{{ old('description', $movie->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле для ввода страны выпуска -->
                        <div class="mb-3">
                            <label for="country" class="form-label">Страна выпуска:</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" id="country" value="{{ old('country', $movie->country) }}" required placeholder="Введите страну выпуска">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле для ввода жанра фильма -->
                        <div class="mb-3">
                            <label for="genre" class="form-label">Жанр:</label>
                            <input type="text" class="form-control @error('genre') is-invalid @enderror" name="genre" id="genre" value="{{ old('genre', $movie->genre) }}" required placeholder="Введите жанр">
                            @error('genre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле для ввода длительности фильма -->
                        <div class="mb-3">
                            <label for="duration" class="form-label">Длительность (в минутах):</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" id="duration" value="{{ old('duration', $movie->duration) }}" required placeholder="Введите длительность">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле для загрузки постера фильма -->
                        <div class="mb-3">
                            <label for="poster" class="form-label">Постер фильма:</label>
                            <input type="file" class="form-control @error('poster') is-invalid @enderror" name="poster" id="poster" accept="image/*" onchange="previewImage(event)">
                            <!-- Проверка, если постер уже загружен -->
                            @if ($movie->poster_url && Storage::exists(str_replace('storage/', 'public/', $movie->poster_url)))
                                <div class="mt-2">
                                    <img src="{{ asset($movie->poster_url) }}" alt="Текущий постер" id="currentPoster" class="movie-poster">
                                </div>
                            @endif
                            @error('poster')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!-- Предпросмотр нового постера -->
                            <img id="posterPreview" class="img-fluid mt-3 d-none" alt="Предпросмотр постера">
                        </div>

                        <!-- Кнопки управления формой -->
                        <div class="text-center mt-4">
                            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary me-3">Отменить</a>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Подключение стилей -->
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('ad/css/index.css') }}">
@endpush

<!-- Подключение скриптов -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Функция для предпросмотра нового постера
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('posterPreview');
            output.src = reader.result;
            output.classList.remove('d-none');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
