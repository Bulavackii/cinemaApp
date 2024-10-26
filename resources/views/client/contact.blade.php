@extends('layouts.client')

@section('title', 'Контакты')

@section('header')
    <div class="section-title text-center" style="margin-bottom: 5px;">
        Контакты
    </div>
@endsection

@section('content')
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <p>Если у вас есть вопросы, вы можете связаться с нами по следующим контактам:</p>
                        <ul>
                            <li><strong>Email:</strong> support@cinemaapp.com</li>
                            <li><strong>Телефон:</strong> +7 (123) 456-78-90</li>
                            <li><strong>Адрес:</strong> г. Москва, ул. Примерная, д. 1</li>
                        </ul>
                        <h5 class="mt-4">Свяжитесь с нами:</h5>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Ваше имя</label>
                                <input type="text" class="form-control" id="name" placeholder="Введите ваше имя">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Ваш email</label>
                                <input type="email" class="form-control" id="email" placeholder="Введите ваш email">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Ваше сообщение</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Введите ваше сообщение"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Отправить сообщение</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
@endpush
