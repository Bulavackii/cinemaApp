@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg movie-card">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Список фильмов</h2>
                </div>
                <div class="card-body">
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

                    <a href="{{ route('admin.movies.create') }}" class="btn btn-primary mb-3">Добавить</a>

                    @if ($movies->isEmpty())
                        <div class="alert alert-info">
                            Нет добавленных фильмов. Пожалуйста, добавьте новый фильм.
                        </div>
                    @else
                        <table class="table table-striped table-bordered movie-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Название</th>
                                    <th>Жанр</th>
                                    <th>Страна</th>
                                    <th>Длительность</th>
                                    <th>Постер</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movies as $movie)
                                    <tr>
                                        <td>{{ $movie->title }}</td>
                                        <td>{{ $movie->genre }}</td>
                                        <td>{{ $movie->country }}</td>
                                        <td>{{ $movie->duration }} мин</td>
                                        <td>
                                            @if ($movie->poster_url && Storage::exists(str_replace('storage/', 'public/', $movie->poster_url)))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#posterModal{{ $movie->id }}">
                                                    <img src="{{ asset($movie->poster_url) }}" alt="{{ $movie->title }}" class="movie-poster-thumb">
                                                </a>

                                                <!-- Modal для увеличенного просмотра постера -->
                                                <div class="modal fade" id="posterModal{{ $movie->id }}" tabindex="-1" aria-labelledby="posterModalLabel{{ $movie->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="posterModalLabel{{ $movie->id }}">{{ $movie->title }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <img src="{{ asset($movie->poster_url) }}" alt="{{ $movie->title }}" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span>Нет постера</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning btn-sm">Правка</a>

                                            <!-- Форма для удаления фильма -->
                                            <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Вы уверены, что хотите удалить этот фильм?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Пагинация -->
                        <div class="mt-4">
                            {{ $movies->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('ad/css/index.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
