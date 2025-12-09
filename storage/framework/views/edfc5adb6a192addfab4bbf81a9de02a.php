

<?php $__env->startSection('title', 'Корзина - Удалённые автомобили'); ?>

<?php $__env->startSection('content'); ?>
    <!-- ЗАГОЛОВОК -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold mb-0">
                    <i class="fas fa-trash me-2"></i>Корзина
                </h1>
                <a href="<?php echo e(route('cards.index')); ?>" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Вернуться в каталог
                </a>
            </div>
            <p class="text-muted mb-0">Здесь находятся удалённые автомобили. Вы можете восстановить их или удалить навсегда.</p>
        </div>
    </div>

    <!-- СООБЩЕНИЯ ТОЛЬКО ЗДЕСЬ -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- КАРТОЧКИ В КОРЗИНЕ -->
    <?php if($cards->count() > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-danger">
                        <div class="position-relative">
                            <!-- ИЗОБРАЖЕНИЕ -->
                            <?php if($card->image_path && file_exists(public_path($card->image_path))): ?>
                                <img src="<?php echo e(asset($card->image_path)); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo e($card->title); ?>"
                                     style="height: 200px; object-fit: cover; opacity: 0.7;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px; opacity: 0.7;">
                                    <i class="fas fa-car fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- БЕЙДЖ УДАЛЁННОГО -->
                            <span class="position-absolute top-0 end-0 m-2 badge bg-danger">
                                <i class="fas fa-trash me-1"></i>Удалён
                            </span>
                            
                            <!-- ДАТА УДАЛЕНИЯ -->
                            <?php if($card->deleted_at): ?>
                                <div class="position-absolute bottom-0 start-0 m-2">
                                    <small class="text-white bg-dark bg-opacity-75 px-2 py-1 rounded">
                                        <i class="fas fa-clock me-1"></i>
                                        <?php echo e($card->deleted_at->format('d.m.Y H:i')); ?>

                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- ТЕЛО КАРТОЧКИ -->
                        <div class="card-body d-flex flex-column">
                            <!-- ЗАГОЛОВОК -->
                            <h5 class="card-title fw-bold text-center mb-3">
                                <?php echo e($card->title); ?>

                            </h5>
                            
                            <!-- ОПИСАНИЕ -->
                            <p class="card-text text-muted flex-grow-1">
                                <?php echo e(\Illuminate\Support\Str::limit($card->description, 80)); ?>

                            </p>
                            
                            <!-- ДЕТАЛИ -->
                            <div class="mb-3">
                                <p class="mb-1">
                                    <strong><i class="fas fa-car me-1"></i>Марка:</strong> <?php echo e($card->brand); ?>

                                </p>
                                <p class="mb-1">
                                    <strong><i class="fas fa-cog me-1"></i>Модель:</strong> <?php echo e($card->model); ?>

                                </p>
                                <p class="mb-0">
                                    <strong><i class="fas fa-calendar me-1"></i>Год:</strong> <?php echo e($card->year); ?>

                                </p>
                            </div>
                            
                            <!-- КНОПКИ ДЕЙСТВИЙ -->
                            <div class="d-flex gap-2 mt-auto">
                                <!-- ФОРМА ВОССТАНОВЛЕНИЯ -->
                                <form action="<?php echo e(route('cards.restore', $card->id)); ?>" 
                                      method="POST" 
                                      class="flex-grow-1"
                                      onsubmit="return confirm('Восстановить машину \"<?php echo e($card->title); ?>\" и вернуть в каталог?')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-success w-100 py-2">
                                        <i class="fas fa-undo me-2"></i>Восстановить в каталог
                                    </button>
                                </form>
                                
                                <!-- ФОРМА ПОЛНОГО УДАЛЕНИЯ -->
                                <form action="<?php echo e(route('cards.forceDelete', $card->id)); ?>" 
                                      method="POST" 
                                      onsubmit="return confirm('УДАЛИТЬ НАВСЕГДА машину \"<?php echo e($card->title); ?>\"?\n\nЭто действие нельзя отменить!')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger py-2 px-3">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <!-- СТАТИСТИКА -->
        <div class="alert alert-info mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-info-circle me-2"></i>
                    В корзине: <strong><?php echo e($cards->count()); ?></strong> автомобилей
                </div>
                <a href="<?php echo e(route('cards.index')); ?>" class="btn btn-outline-info btn-sm">
                    <i class="fas fa-list me-1"></i>Вернуться к списку
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- ПУСТАЯ КОРЗИНА -->
        <div class="text-center py-5">
            <div class="card shadow-sm border-0">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-trash-alt fa-4x text-muted"></i>
                    </div>
                    <h3 class="mb-3">Корзина пуста</h3>
                    <p class="text-muted mb-4">
                        Здесь будут отображаться удалённые автомобили.<br>
                        Для добавления в корзину удалите автомобиль из каталога.
                    </p>
                    <a href="<?php echo e(route('cards.index')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Вернуться в каталог
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.card {
    transition: all 0.3s;
}

.card:hover {
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.2) !important;
    transform: translateY(-5px);
}

.btn-success:hover {
    transform: translateY(-2px);
    transition: transform 0.2s;
}

.btn-danger:hover {
    transform: scale(1.1);
    transition: transform 0.2s;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\lab33\resources\views/cards/trash.blade.php ENDPATH**/ ?>