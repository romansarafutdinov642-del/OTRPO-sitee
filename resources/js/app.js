import '../sass/app.scss';
import { Modal, Tooltip, Popover, Toast, Alert } from 'bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import $ from 'jquery';

// Делаем Bootstrap доступным глобально
window.bootstrap = { Modal, Tooltip, Popover, Toast, Alert };
window.$ = window.jQuery = $;

// Инициализация компонентов Bootstrap при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация всех tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => new Tooltip(el));

    // Инициализация всех popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    popoverTriggerList.forEach(el => new Popover(el));

    // Автоскрытие алертов через 5 секунд
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });

    // Toast уведомления
    const toastTrigger = document.getElementById('liveToastBtn');
    const toastLiveExample = document.getElementById('liveToast');
    if (toastTrigger && toastLiveExample) {
        const toastBootstrap = Toast.getOrCreateInstance(toastLiveExample);
        toastTrigger.addEventListener('click', () => {
            toastBootstrap.show();
        });
    }
});
