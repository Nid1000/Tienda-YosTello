<?php $__env->startSection('content'); ?>
    <section class="section compact">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Catalogo</p>
                <h1>Encuentra tu siguiente look</h1>
                <p class="lead compact-lead">
                    <?php echo e($resultsCount); ?> resultado(s)
                    <?php if($selectedCategory !== ''): ?>
                        en <?php echo e($selectedCategory); ?>

                    <?php endif; ?>
                    <?php if($search !== ''): ?>
                        para "<?php echo e($search); ?>"
                    <?php endif; ?>
                </p>
            </div>

            <form
                class="filters"
                method="GET"
                action="<?php echo e(route('products.index')); ?>"
                data-auto-submit-filters
            >
                <label class="filter-field">
                    <span>Buscar producto</span>
                    <input
                        type="text"
                        name="search"
                        value="<?php echo e($search); ?>"
                        placeholder="Ropa, zapatillas o pantalones"
                    >
                </label>

                <label class="filter-field">
                    <span>Categoria</span>
                    <span class="select-field">
                        <select name="category">
                            <option value="">Todas las categorias</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->slug); ?>" <?php if($selectedCategory === $category->slug || $selectedCategory === $category->name): echo 'selected'; endif; ?>>
                                    <?php echo e($category->name); ?> (<?php echo e($category->products_count); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </span>
                </label>

                <label class="filter-field">
                    <span>Ordenar por</span>
                    <span class="select-field">
                        <select name="sort">
                            <option value="latest" <?php if($sort === 'latest'): echo 'selected'; endif; ?>>Mas recientes</option>
                            <option value="price_asc" <?php if($sort === 'price_asc'): echo 'selected'; endif; ?>>Precio: menor a mayor</option>
                            <option value="price_desc" <?php if($sort === 'price_desc'): echo 'selected'; endif; ?>>Precio: mayor a menor</option>
                            <option value="name_asc" <?php if($sort === 'name_asc'): echo 'selected'; endif; ?>>Nombre A-Z</option>
                        </select>
                    </span>
                </label>

                <button class="button primary" type="submit">Filtrar</button>
            </form>

            <div class="filter-chips">
                <a class="filter-chip <?php echo e($selectedCategory === '' ? 'active' : ''); ?>" href="<?php echo e(route('products.index', ['search' => $search, 'sort' => $sort])); ?>">
                    Todo
                </a>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a
                        class="filter-chip <?php echo e($selectedCategory === $category->slug || $selectedCategory === $category->name ? 'active' : ''); ?>"
                        href="<?php echo e(route('products.index', ['category' => $category->slug, 'search' => $search, 'sort' => $sort])); ?>"
                    >
                        <?php echo e($category->name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="product-grid">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="product-card">
                        <img src="<?php echo e($product->image); ?>" alt="<?php echo e($product->name); ?>">
                        <div class="product-copy">
                            <p class="product-category"><?php echo e($product->category); ?></p>
                            <h3><?php echo e($product->name); ?></h3>
                            <p><?php echo e(\Illuminate\Support\Str::limit($product->description, 100)); ?></p>
                            <div class="product-meta">
                                <div class="price-stack">
                                    <strong>S/. <?php echo e(number_format($product->final_price, 0, '.', ',')); ?></strong>
                                    <?php if($product->has_discount): ?>
                                        <span class="price-old">S/. <?php echo e(number_format($product->price, 0, '.', ',')); ?></span>
                                        <span class="discount-badge">-<?php echo e(rtrim(rtrim(number_format($product->discount_percent, 2, '.', ''), '0'), '.')); ?>%</span>
                                    <?php endif; ?>
                                </div>
                                <a class="product-detail-link" href="<?php echo e(route('products.show', $product)); ?>">Ver detalle</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>No hay productos para los filtros actuales.</p>
                <?php endif; ?>
            </div>

            <div class="pagination-wrap">
                <?php echo e($products->links()); ?>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'YO-TELLO | Catalogo'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Usuario\Downloads\TIENDA DE ROPAS\backend\resources\views/products/index.blade.php ENDPATH**/ ?>