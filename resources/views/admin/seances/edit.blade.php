@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Редактировать Сеанс</h1>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Упс!</strong> Есть некоторые проблемы с вашими данными.
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.seances.update', $seance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="movie_id" class="form-label">Фильм:</label>
                <select name="movie_id" class="form-control @error('movie_id') is-invalid @enderror" required>
                    <option value="">-- Выберите фильм --</option>
                    @foreach($movies as $movie)
                        <option value="{{ $movie->id }}" {{ (old('movie_id') ?? $seance->movie_id) == $movie->id ? 'selected' : '' }}>
                            {{ $movie->title }}
                        </option>
                    @endforeach
                </select>
                @error('movie_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="cinema_hall_id" class="form-label">Зал:</label>
                <select name="cinema_hall_id" class="form-control @error('cinema_hall_id') is-invalid @enderror" required>
                    <option value="">-- Выберите зал --</option>
                    @foreach($cinemaHalls as $hall)
                        <option value="{{ $hall->id }}" {{ (old('cinema_hall_id') ?? $seance->cinema_hall_id) == $hall->id ? 'selected' : '' }}>
                            {{ $hall->name }}
                        </option>
                    @endforeach
                </select>
                @error('cinema_hall_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="start_time" class="form-label">Время Начала:</label>
                <input type="datetime-local" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time') ? date('Y-m-d\TH:i', strtotime(old('start_time'))) : $seance->start_time->format('Y-m-d\TH:i') }}" required>
                @error('start_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="end_time" class="form-label">Время Окончания:</label>
                <input type="datetime-local" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time') ? date('Y-m-d\TH:i', strtotime(old('end_time'))) : $seance->end_time->format('Y-m-d\TH:i') }}" required>
                <small class="form-text text-muted">Убедитесь, что время окончания превышает время начала сеанса.</small>
                @error('end_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="price_regular" class="form-label">Цена (Регуляр):</label>
                <input type="number" step="0.01" name="price_regular" class="form-control @error('price_regular') is-invalid @enderror" value="{{ old('price_regular') ?? $seance->price_regular }}" required>
                @error('price_regular')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="price_vip" class="form-label">Цена (VIP):</label>
                <input type="number" step="0.01" name="price_vip" class="form-control @error('price_vip') is-invalid @enderror" value="{{ old('price_vip') ?? $seance->price_vip }}" required>
                @error('price_vip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.seances.index') }}" class="btn btn-secondary ms-3">Отменить</a>
        </div>
    </form>
</div>
@endsection

{{-- Подключение стилей --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('ad/css/index.css') }}">
@endpush
