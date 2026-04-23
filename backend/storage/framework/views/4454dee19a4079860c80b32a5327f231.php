<?php $__env->startSection('content'); ?>
    <header class="admin-topbar">
        <div>
            <p class="eyebrow">Panel de administración</p>
            <h1>Visión general de la tienda</h1>
        </div>
    </header>

    <div class="admin-metric-grid">
        <article class="admin-metric-card">
            <span>Ventas potenciales</span>
            <strong>S/. <?php echo e(number_format($stats['projected_revenue'], 0, ',', '.')); ?></strong>
        </article>
        <article class="admin-metric-card">
            <span>Productos</span>
            <strong><?php echo e($stats['products']); ?></strong>
        </article>
        <article class="admin-metric-card">
            <span>Categorias</span>
            <strong><?php echo e($stats['categories']); ?></strong>
        </article>
        <article class="admin-metric-card">
            <span>Promociones activas</span>
            <strong><?php echo e($stats['active_promotions']); ?></strong>
        </article>
    </div>

    <div class="admin-dashboard-grid">
                <section class="admin-surface">
                    <div class="admin-surface-head">
                        <h2>Ventas de la semana</h2>
                        <span><?php echo e($hasWeeklySales ? '7 días' : 'Vista preliminar'); ?></span>
                    </div>

                    <div class="admin-chart <?php echo e($hasWeeklySales ? '' : 'is-preview'); ?>">
                        <?php $__currentLoopData = $weeklyChart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="admin-bar-col">
                                <div class="admin-bar-wrap">
                                    <div
                                        class="admin-bar"
                                        style="height: <?php echo e(max(24, ($day['amount'] / $maxWeeklySales) * 220)); ?>px"
                                        title="S/. <?php echo e(number_format($day['amount'], 0, ',', '.')); ?>"
                                    ></div>
                                </div>
                                <strong><?php echo e($hasWeeklySales ? 'S/. '.number_format($day['amount'], 0, ',', '.') : 'Ref.'); ?></strong>
                                <span><?php echo e($day['label']); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php if (! ($hasWeeklySales)): ?>
                        <p class="admin-chart-note">Aún no hay pedidos esta semana. Estas barras sirven como guía visual; se reemplazarán con ventas reales automáticamente.</p>
                    <?php endif; ?>
                </section>

                <section class="admin-surface">
                    <div class="admin-surface-head">
                        <h2>Inventario por categoría</h2>
                        <span><?php echo e($stats['products']); ?> productos</span>
                    </div>

                    <div class="admin-horizontal-chart">
                        <?php $__currentLoopData = $categoryInventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="admin-hbar-row">
                                <div class="admin-hbar-label">
                                    <strong><?php echo e($category['name']); ?></strong>
                                    <span><?php echo e($category['products']); ?> prod. | <?php echo e($category['stock']); ?> und.</span>
                                </div>
                                <div class="admin-hbar-track">
                                    <div class="admin-hbar" style="width: <?php echo e(max(8, ($category['stock'] / $maxCategoryStock) * 100)); ?>%"></div>
                                </div>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>

                <section class="admin-surface">
                    <div class="admin-surface-head">
                        <h2>Rentabilidad</h2>
                        <span>Resumen</span>
                    </div>

                    <div class="admin-donut-wrap">
                        <?php
                            $discountPercent = $stats['products'] > 0 ? round(($stats['discounted_products'] / $stats['products']) * 100) : 0;
                        ?>
                        <div class="admin-donut" style="--value: <?php echo e($discountPercent); ?>">
                            <strong><?php echo e($discountPercent); ?>%</strong>
                            <span>con descuento</span>
                        </div>
                        <div class="admin-profit-grid">
                            <div class="admin-profit-card">
                                <span>Valor de inventario</span>
                                <strong>S/. <?php echo e(number_format($stats['inventory_value'], 0, ',', '.')); ?></strong>
                            </div>
                            <div class="admin-profit-card accent-card">
                                <span>Ganancia estimada</span>
                                <strong>S/. <?php echo e(number_format($stats['projected_profit'], 0, ',', '.')); ?></strong>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="admin-surface">
                    <div class="admin-surface-head">
                        <h2>Campanas activas</h2>
                        <span><?php echo e($stats['promotions']); ?> total</span>
                    </div>

                    <div class="admin-profit-grid">
                        <?php $__empty_1 = true; $__currentLoopData = $promotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promotion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="admin-profit-card">
                                <span><?php echo e($promotion->discount_label); ?></span>
                                <strong><?php echo e($promotion->title); ?></strong>
                                <p class="muted-copy"><?php echo e($promotion->target_label); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="muted-copy">Crea promociones para destacar campanas en la tienda.</p>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="admin-surface admin-surface-wide">
                    <div class="admin-surface-head">
                        <h2>Pedidos recientes</h2>
                        <span>Ultimos movimientos</span>
                    </div>

                    <div class="admin-order-list">
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <article class="admin-order-item">
                                <div>
                                    <strong>Pedido #<?php echo e($order->id); ?></strong>
                                    <p><?php echo e($order->created_at?->format('d/m/Y H:i')); ?></p>
                                </div>
                                <span class="admin-status"><?php echo e(ucfirst($order->status)); ?></span>
                                <strong>S/. <?php echo e(number_format($order->total, 2, ',', '.')); ?></strong>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="muted-copy">No hay pedidos recientes todavia.</p>
                        <?php endif; ?>
                    </div>
                </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', ['title' => 'YO-TELLO | Administrador'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Usuario\Downloads\TIENDA DE ROPAS\backend\resources\views/admin/index.blade.php ENDPATH**/ ?>