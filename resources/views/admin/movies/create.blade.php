@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="col-lg-8 mx-auto">
            <!-- Карточка для добавления нового фильма -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Добавить новый фильм</h2>
                </div>
                <div class="card-body">
                    <!-- Отображение ошибок при вводе данных -->
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

                    <!-- Форма для добавления фильма -->
                    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Поле для ввода названия фильма -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Название фильма:</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="Введите название фильма">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле для ввода описания фильма -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание:</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Введите описание фильма">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле для ввода страны производства -->
                        <div class="mb-3">
                            <label for="country" class="form-label">Страна:</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}" required placeholder="Введите страну производства">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле для ввода жанра -->
                        <div class="mb-3">
                            <label for="genre" class="form-label">Жанр:</label>
                            <input type="text" class="form-control @error('genre') is-invalid @enderror" id="genre" name="genre" value="{{ old('genre') }}" required placeholder="Введите жанр фильма">
                            @error('genre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле для ввода длительности фильма -->
                        <div class="mb-3">
                            <label for="duration" class="form-label">Длительность (в минутах):</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" required min="1" placeholder="Введите длительность фильма в минутах">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле для загрузки постера фильма -->
                        <div class="mb-3">
                            <label for="poster" class="form-label">Постер фильма:</label>
                            <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster" accept="image/*" onchange="previewImage(event)">
                            @error('poster')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!-- Предпросмотр загруженного постера -->
                            <img id="posterPreview" class="img-fluid mt-3 d-none" alt="Предпросмотр постера">
                        </div>

                        <!-- Кнопки управления формой -->
                        <div class="text-center mt-4">
                            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary me-3">Отмена</a>
                            <button type="submit" class="btn btn-primary">Добавить</button>
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
        // Функция предпросмотра постера
        function previewImage(event) {
            const reader = new FileReader();
            const file = event.target.files[0];
            
            // Ограничение на размер файла (максимум 2 МБ)
            if (file.size > 2 * 1024 * 1024) {
                alert("Размер файла слишком большой. Максимальный размер — 2 МБ.");
                event.target.value = "";
                return;
            }

            // Отображение изображения после его загрузки
            reader.onload = function() {
                const output = document.getElementById('posterPreview');
                output.src = reader.result;
                output.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    </script>
@endpush
