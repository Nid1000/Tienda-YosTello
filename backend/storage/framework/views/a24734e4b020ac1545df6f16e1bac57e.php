<?php $__env->startSection('content'); ?>
    <section class="section compact">
        <div class="container product-detail">
            <div>
                <img class="detail-image" src="<?php echo e($product->image); ?>" alt="<?php echo e($product->name); ?>">
            </div>

            <div class="detail-copy">
                <p class="product-category"><?php echo e($product->category); ?></p>
                <h1><?php echo e($product->name); ?></h1>
                <div class="detail-price-wrap">
                    <p class="detail-price">S/. <?php echo e(number_format($product->final_price, 2, '.', ',')); ?></p>
                    <?php if($product->has_discount): ?>
                        <p class="detail-price-old">Antes S/. <?php echo e(number_format($product->price, 2, '.', ',')); ?></p>
                        <p class="discount-inline">Descuento de <?php echo e(rtrim(rtrim(number_format($product->discount_percent, 2, '.', ''), '0'), '.')); ?>%</p>
                    <?php endif; ?>
                </div>
                <p><?php echo e($product->description); ?></p>

                <div class="detail-box">
                    <p><strong>Tallas:</strong> <?php echo e(implode(', ', $product->sizes)); ?></p>
                    <p><strong>Colores:</strong> <?php echo e(implode(', ', $product->colors)); ?></p>
                    <p><strong>Stock disponible:</strong> <?php echo e($product->stock); ?></p>
                </div>

                <?php if(auth()->guard()->check()): ?>
                    <form class="stack-form detail-form" method="POST" action="<?php echo e(route('cart.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <label>
                            <span>Talla</span>
                            <select name="size" required>
                                <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($size); ?>"><?php echo e($size); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                        <label>
                            <span>Cantidad</span>
                            <input type="number" name="quantity" min="1" max="10" value="1" required>
                        </label>
                        <button class="button primary" type="submit">Agregar al carrito</button>
                    </form>
                <?php else: ?>
                    <a class="button primary" href="<?php echo e(route('login')); ?>">Inicia sesion para comprar</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section related">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Relacionados</p>
                <h2>Mas opciones para combinar</h2>
            </div>

            <div class="product-grid">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="product-card">
                        <img src="<?php echo e($related->image); ?>" alt="<?php echo e($related->name); ?>">
                        <div class="product-copy">
                            <p class="product-category"><?php echo e($related->category); ?></p>
                            <h3><?php echo e($related->name); ?></h3>
                            <div class="product-meta">
                                <div class="price-stack">
                                    <strong>S/. <?php echo e(number_format($related->final_price, 2, '.', ',')); ?></strong>
                                    <?php if($related->has_discount): ?>
                                        <span class="price-old">S/. <?php echo e(number_format($related->price, 2, '.', ',')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo e(route('products.show', $related)); ?>">Ver detalle</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'YO-TELLO | '.$product->name], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Usuario\Downloads\TIENDA DE ROPAS\backend\resources\views/products/show.blade.php ENDPATH**/ ?>