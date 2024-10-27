import 'bootstrap'; // Импортируем Bootstrap для стилей и поведения элементов.

/**
 * Загружаем библиотеку axios, которая используется для отправки HTTP-запросов
 * к бэкенду Laravel. Эта библиотека автоматически добавляет CSRF токен в заголовки
 * запросов, используя значение cookie "XSRF" токена.
 */
import axios from 'axios'; // Импортируем библиотеку для работы с HTTP запросами.
window.axios = axios; // Делаем axios глобально доступным через объект window.

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; 
// Устанавливаем заголовок 'X-Requested-With', чтобы обозначить, что запросы AJAX.

/**
 * Echo предоставляет удобный API для подписки на каналы и прослушивания событий,
 * которые транслируются через Laravel. Использование Echo позволяет легко создавать
 * реальные веб-приложения с поддержкой событий.
 */

// Следующий код закомментирован, но если требуется использовать Laravel Echo с Pusher:

// import Echo from 'laravel-echo'; // Импортируем Echo для работы с событиями в реальном времени.

// import Pusher from 'pusher-js'; // Импортируем Pusher, который является частью Pusher API для работы с WebSockets.
// window.Pusher = Pusher; // Делаем Pusher глобально доступным через объект window.

// Настройка Echo с Pusher для работы в реальном времени с событиями Laravel.
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY, // Используем ключ Pusher из переменных окружения.
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1', // Устанавливаем кластер Pusher.
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`, // Хост для WebSocket соединения.
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80, // Порт для WebSocket соединений (не защищенный).
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443, // Порт для защищенных WebSocket соединений.
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https', // Включаем поддержку TLS если используется HTTPS.
//     enabledTransports: ['ws', 'wss'], // Включаем WebSocket и WebSocket Secure (wss) протоколы.
// });
