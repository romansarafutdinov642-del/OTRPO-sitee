<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo $__env->yieldContent('title', 'Каталог автомобилей'); ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Ваш CSS через Laravel Mix -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Навигация -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo e(route('cards.index')); ?>">
                <i class="fas fa-car me-2"></i>Каталог автомобилей
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav">
                    <a class="nav-link <?php echo e(request()->routeIs('cards.index') ? 'active' : ''); ?>" 
                       href="<?php echo e(route('cards.index')); ?>">
                        <i class="fas fa-home me-1"></i>Главная
                    </a>
                </div>
                
                <div class="navbar-nav ms-auto">
                    <!-- Кнопка корзины -->
                    <a href="<?php echo e(route('cards.trash')); ?>" 
                       class="btn btn-outline-warning me-3 position-relative">
                        <i class="fas fa-trash me-1"></i>Корзина
                        <?php
                            $trashCount = App\Models\Card::onlyTrashed()->count();
                        ?>
                        <?php if($trashCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo e($trashCount); ?>

                                <span class="visually-hidden">удалённых записей</span>
                            </span>
                        <?php endif; ?>
                    </a>
                    
                    <!-- Кнопка добавления новой машины -->
                    <a href="<?php echo e(route('cards.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Добавить машину
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <main class="container py-2 flex-grow-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-4 bg-dark text-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-0">
                    <h5 class="mb-0">Шарафутдинов Роман</h5>
                </div>
                <div class="d-flex gap-3">
                    <a href="https://t.me/" target="_blank" class="text-white" title="Telegram">
                        <i class="fab fa-telegram fa-lg"></i>
                    </a>
                    <a href="https://vk.com/" target="_blank" class="text-white" title="ВКонтакте">
                        <i class="fab fa-vk fa-lg"></i>
                    </a>
                    <a href="https://github.com/" target="_blank" class="text-white" title="GitHub">
                        <i class="fab fa-github fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Ваш JS через Laravel Mix -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    
    <!-- Дополнительные скрипты -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Подтверждение удаления
            const deleteForms = document.querySelectorAll('form[data-confirm]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const message = this.getAttribute('data-confirm');
                    if (!confirm(message)) {
                        e.preventDefault();
                    }
                });
            });
            
            // Автоматическое скрытие уведомлений через 5 секунд
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\User\Desktop\lab33\resources\views/layouts/app.blade.php ENDPATH**/ ?>