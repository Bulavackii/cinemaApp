@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <!-- Заголовок страницы -->
        <h2 class="mb-4">Список сеансов</h2>

        <!-- Вывод сообщения о статусе, если таковое имеется -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- Кнопка для создания нового сеанса -->
        <a href="{{ route('admin.seances.create') }}" class="btn btn-primary mb-3">Создать Новый Сеанс</a>

        <!-- Таблица сеансов -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Фильм</th>
                        <th>Зал</th>
                        <th>Время начала</th>
                        <th>Время окончания</th>
                        <th>Цена (Регуляр)</th>
                        <th>Цена (VIP)</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Проход по каждому сеансу для отображения в таблице -->
                    @foreach($sessions as $session)
                        <tr>
                            <td>{{ $session->movie->title }}</td>
                            <td>{{ $session->cinemaHall->name }}</td>
                            <!-- Форматирование времени начала и окончания с помощью метода format() -->
                            <td>{{ $session->start_time->format('d.m.Y H:i') }}</td>
                            <td>{{ $session->end_time->format('d.m.Y H:i') }}</td>
                            <!-- Отображение цен с форматированием до 2 знаков после запятой -->
                            <td>{{ number_format($session->price_regular, 2) }} руб.</td>
                            <td>{{ number_format($session->price_vip, 2) }} руб.</td>
                            <td>
                                <!-- Кнопка для редактирования сеанса -->
                                <a href="{{ route('admin.seances.edit', $session->id) }}" class="btn btn-sm btn-primary" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Форма для удаления сеанса с подтверждением -->
                                <form action="{{ route('admin.seances.destroy', $session->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот сеанс?')" title="Удалить">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Пагинация для длинных списков -->
        <div class="mt-4">
            {{ $sessions->links() }}
        </div>
    </div>
@endsection

<!-- Подключение стилей -->
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

<!-- Подключение скриптов -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
