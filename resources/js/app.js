/**
 * Загружаем все зависимости JavaScript для проекта, включая Vue и другие библиотеки.
 * Это служит отличной отправной точкой для создания мощных веб-приложений на базе Vue и Laravel.
 */
import './bootstrap'; // Загружаем файл bootstrap.js для настройки проекта.
import { createApp } from 'vue'; // Импортируем функцию для создания Vue приложения.

/**
 * Создаем экземпляр Vue приложения. 
 * Теперь можно регистрировать компоненты, чтобы они были готовы к использованию во вьюхах Laravel.
 */
const app = createApp({}); // Инициализация нового Vue приложения.

// Импортируем и регистрируем компонент ExampleComponent.
import ExampleComponent from './components/ExampleComponent.vue'; 
app.component('example-component', ExampleComponent); // Регистрируем его как <example-component>.

/**
 * Этот блок кода может быть использован для автоматической регистрации Vue компонентов.
 * Он рекурсивно сканирует директорию на наличие файлов Vue и автоматически регистрирует их
 * под именем, соответствующим их базовому имени файла.
 *
 * Например, ./components/ExampleComponent.vue -> <example-component></example-component>
 */
// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * В завершение мы присоединяем экземпляр приложения к HTML элементу с атрибутом id="app".
 * Этот элемент включен в аутентификационные шаблоны. Если вы не используете их, вам нужно
 * добавить этот элемент самостоятельно в ваше HTML.
 */
app.mount('#app'); // Присоединяем приложение Vue к элементу с id="app".
