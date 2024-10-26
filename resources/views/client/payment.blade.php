<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оплата</title>
    <link rel="stylesheet" href="{{ asset('client/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="container mt-4">
        <h1>Оплата билета</h1>
    </header>

    <section class="container mt-5">
        <form action="{{ route('client.complete_payment') }}" method="POST" class="card p-4 shadow-lg">
            @csrf
            <div class="payment-info mb-4">
                <h4>Информация о платеже</h4>
                <p><strong>Выбранное место:</strong> {{ $seat->row }} ряд, {{ $seat->seat_number }} место</p>
                <p><strong>Цена:</strong> {{ $seat->price }} руб.</p>
            </div>

            <div class="payment-method mb-4">
                <h4>Данные банковской карты</h4>

                <div class="form-group">
                    <label for="card-number">Номер карты:</label>
                    <input type="text" name="card_number" id="card-number" class="form-control" required autocomplete="off" maxlength="19" pattern="\d{16,19}" placeholder="1234 5678 9012 3456">
                </div>

                <div class="form-group">
                    <label for="expiry-date">Дата окончания (MM/YY):</label>
                    <input type="text" name="expiry_date" id="expiry-date" class="form-control" required autocomplete="off" maxlength="5" pattern="\d{2}/\d{2}" placeholder="MM/YY">
                </div>

                <div class="form-group">
                    <label for="cvc">CVC:</label>
                    <input type="text" name="cvc" id="cvc" class="form-control" required autocomplete="off" maxlength="3" pattern="\d{3}" placeholder="123">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Оплатить</button>
        </form>
    </section>

    <footer class="container mt-5">
        <p class="text-center">&copy; 2024 Онлайн-кинотеатр</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Маска для номера карты и даты окончания
        document.addEventListener('DOMContentLoaded', function () {
            const cardNumberInput = document.getElementById('card-number');
            const expiryDateInput = document.getElementById('expiry-date');

            cardNumberInput.addEventListener('input', function () {
                let value = cardNumberInput.value.replace(/\D/g, '').match(/.{1,4}/g);
                cardNumberInput.value = value ? value.join(' ') : '';
            });

            expiryDateInput.addEventListener('input', function () {
                let value = expiryDateInput.value.replace(/\D/g, '').match(/.{1,2}/g);
                expiryDateInput.value = value ? value.join('/') : '';
            });
        });
    </script>
</body>
</html>
