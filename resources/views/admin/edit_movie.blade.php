@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Редактировать фильм</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h5">Основная информация</h2>
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Название:</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title', $movie->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание:</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{ old('description', $movie->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Страна:</label>
                <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" id="country" value="{{ old('country', $movie->country) }}" required>
                @error('country')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Жанр:</label>
                <input type="text" class="form-control @error('genre') is-invalid @enderror" name="genre" id="genre" value="{{ old('genre', $movie->genre) }}" required>
                @error('genre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="duration" class="form-label">Длительность (минуты):</label>
                <input type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" id="duration" value="{{ old('duration', $movie->duration) }}" required>
                @error('duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="poster" class="form-label">Постер:</label>
                @if ($movie->poster_url)
                    <div class="mb-2">
                        <img src="{{ asset($movie->poster_url) }}" alt="{{ $movie->title }}" style="width: 150px;">
                    </div>
                    <div class="mb-2">
                        <label>
                            <input type="checkbox" name="delete_poster" value="1"> Удалить постер
                        </label>
                    </div>
                @endif
                <input type="file" class="form-control @error('poster') is-invalid @enderror" name="poster" id="poster" accept="image/*">
                <small class="form-text text-muted">Поддерживаются форматы: jpeg, png, jpg, gif.</small>
                @error('poster')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary ms-2">Вернуться к списку фильмов</a>
            </div>
        </form>
    </div>
@endsection
