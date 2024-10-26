@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h2 class="mb-0">Управление залами</h2>
            </div>
            <div class="card-body">
                <div class="actions mb-3 d-flex justify-content-between">
                    <a href="{{ route('admin.halls.create') }}" class="btn btn-success">Добавить новый зал</a>
                </div>

                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Название зала</th>
                            <th>Количество рядов</th>
                            <th>Количество мест в ряду</th>
                            <th>Активный</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cinemaHalls as $hall)
                            <tr class="text-center align-middle">
                                <td>{{ $hall->name }}</td>
                                <td>{{ $hall->rows }}</td>
                                <td>{{ $hall->seats_per_row }}</td>
                                <td>
                                    <span class="badge {{ $hall->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $hall->is_active ? 'Да' : 'Нет' }}
                                    </span>
                                </td>
                                <td class="d-flex justify-content-center align-items-center">
                                    <!-- Кнопка для редактирования -->
                                    <a href="{{ route('admin.halls.edit', $hall->id) }}" class="btn btn-primary btn-sm me-2">
                                        Правка
                                    </a>
                
                                    <!-- Форма для активации/деактивации зала -->
                                    <form action="{{ route('admin.halls.toggle', $hall->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $hall->is_active ? 'btn-danger' : 'btn-success' }}">
                                            {{ $hall->is_active ? 'Стоп продажам' : 'Старт продажам' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('ad/css/index.css') }}">
    @endpush
@endsection
