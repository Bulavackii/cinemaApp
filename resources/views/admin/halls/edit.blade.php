@extends('layouts.admin')

@section('content')
    <!-- Основной контейнер страницы редактирования зала -->
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-lg-8">
            <!-- Карточка для редактирования данных зала -->
            <div class="card shadow-lg">
                <!-- Заголовок карточки -->
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Редактировать Зал</h2>
                </div>
                <div class="card-body">
                    <!-- Блок для отображения ошибок валидации -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <!-- Кнопка для закрытия уведомления об ошибке -->
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Форма для редактирования зала -->
                    <form action="{{ route('admin.halls.update', $hall->id) }}" method="POST">
                        @csrf <!-- Токен защиты от CSRF атак -->
                        @method('PUT') <!-- Метод для обновления данных (PUT) -->

                        <!-- Поле ввода для названия зала -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Название зала:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $hall->name) }}" required>
                            <!-- Сообщение об ошибке для названия зала -->
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле ввода для количества рядов -->
                        <div class="mb-3">
                            <label for="rows" class="form-label">Количество рядов:</label>
                            <input type="number" class="form-control @error('rows') is-invalid @enderror" name="rows" id="rows" value="{{ old('rows', $hall->rows) }}" min="1" required>
                            <!-- Сообщение об ошибке для количества рядов -->
                            @error('rows')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Поле ввода для количества мест в ряду -->
                        <div class="mb-3">
                            <label for="seats_per_row" class="form-label">Количество мест в ряду:</label>
                            <input type="number" class="form-control @error('seats_per_row') is-invalid @enderror" name="seats_per_row" id="seats_per_row" value="{{ old('seats_per_row', $hall->seats_per_row) }}" min="1" required>
                            <!-- Сообщение об ошибке для количества мест -->
                            @error('seats_per_row')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Кнопки управления формой: отмена, очистить, сохранить -->
                        <div class="text-center mt-4">
                            <a href="{{ route('admin.halls.index') }}" class="btn btn-secondary me-3">Отменить</a>
                            <button type="reset" class="btn btn-warning me-3">Очистить</button>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Подключение пользовательских стилей -->
    <link rel="stylesheet" href="{{ asset('ad/css/index.css') }}">
@endpush

@push('scripts')
    <!-- Подключение скриптов Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
