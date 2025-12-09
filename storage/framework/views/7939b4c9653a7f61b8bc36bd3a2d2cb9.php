<?php $__env->startSection('title', 'Каталог автомобилей'); ?>

<?php $__env->startSection('content'); ?>

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold text-center mb-0">
                <i class="fas fa-car me-2"></i>Каталог автомобилей
            </h1>
        </div>
    </div>


    <?php if($cards->count() > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            <?php if($card->image_path && file_exists(public_path($card->image_path))): ?>
                                <img src="<?php echo e(asset($card->image_path)); ?>" 
                                    class="card-img-top" 
                                    alt="<?php echo e($card->title); ?>"
                                    style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-car fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            
                            
                            <span class="position-absolute top-0 end-0 m-2 badge bg-primary">
                                <i class="fas fa-tag me-1"></i><?php echo e($card->category_name ?? $card->category); ?>

                            </span>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                           
                            <div class="row g-2 mb-3">
                                <div class="col-4 text-center">
                                    <div class="bg-light rounded p-2">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                        <div class="fw-bold"><?php echo e($card->year); ?> г.</div>
                                        <small class="text-muted">Год</small>
                                    </div>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="bg-light rounded p-2">
                                        <i class="fas fa-horse-head text-primary"></i>
                                        <div class="fw-bold"><?php echo e($card->horsepower); ?> л.с.</div>
                                        <small class="text-muted">Мощность</small>
                                    </div>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="bg-light rounded p-2">
                                        <i class="fas fa-tag text-primary"></i>
                                        <div class="fw-bold"><?php echo e($card->formatted_price ?? '$' . number_format($card->price, 0)); ?></div>
                                        <small class="text-muted">Цена</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- НАЗВАНИЕ МАШИНЫ -->
                            <h5 class="card-title fw-bold text-center mb-3"><?php echo e($card->title); ?></h5>
                            
                            <!-- ИНТЕРЕСНЫЙ ФАКТ (если есть) -->
                            <?php if($card->fun_fact_content): ?>
                            <div class="alert alert-info mb-3 py-2 px-3">
                                <small>
                                    <i class="fas fa-lightbulb me-1"></i>
                                    <?php echo e(Str::limit($card->fun_fact_content, 80)); ?>

                                </small>
                            </div>
                            <?php endif; ?>
                            
                            <!-- ОПИСАНИЕ -->
                            <p class="card-text text-muted flex-grow-1"><?php echo e(Str::limit($card->description, 100)); ?></p>
                            
                            <!-- КНОПКИ ДЕЙСТВИЙ -->
                            <div class="d-flex gap-2 mt-3">
                                <a href="<?php echo e(route('cards.show', $card)); ?>" class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="fas fa-eye me-1"></i>Подробнее
                                </a>
                                <a href="<?php echo e(route('cards.edit', $card)); ?>" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- ТОЛЬКО УДАЛЕНИЕ - ВОССТАНОВЛЕНИЯ НЕТ -->
                                <form action="<?php echo e(route('cards.destroy', $card)); ?>" 
                                    method="POST" 
                                    class="d-inline"
                                    data-confirm="Удалить эту машину навсегда?">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <div class="card shadow-sm">
                <div class="card-body py-5">
                    <i class="fas fa-car fa-4x text-muted mb-3"></i>
                    <h3 class="mb-3">Машин пока нет</h3>
                    <p class="text-muted mb-4">Добавьте первую машину в каталог</p>
                    <a href="<?php echo e(route('cards.create')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Добавить первую машину
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\lab33\resources\views/cards/index.blade.php ENDPATH**/ ?>