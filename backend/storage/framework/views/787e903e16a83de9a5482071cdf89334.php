<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? 'YO-TELLO'); ?></title>
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('yotello-mark.svg')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('yotello-mark.svg')); ?>">
    <?php
        $hasViteAssets = file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json'));
    ?>
    <?php if($hasViteAssets): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(url('/app.css')); ?>">
        <script defer src="<?php echo e(url('/app.js')); ?>"></script>
    <?php endif; ?>
</head>
<body>
    <?php
        $cartCount = collect(session('cart', []))->sum('quantity');
    ?>
    <header class="site-header">
        <div class="container nav">
            <a class="brand" href="<?php echo e(route('home')); ?>">YO-TELLO</a>
            <nav class="nav-links">
                <a href="<?php echo e(route('home')); ?>">Inicio</a>
                <a href="<?php echo e(route('products.index')); ?>">Catalogo</a>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.index')); ?>">Panel admin</a>
                        <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="nav-button" type="submit">Salir</button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('cart.index')); ?>" class="cart-link">
                            Carrito
                            <?php if($cartCount > 0): ?>
                                <span class="cart-badge"><?php echo e($cartCount); ?></span>
                            <?php endif; ?>
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="nav-button" type="submit">Salir</button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>">Login</a>
                    <a href="<?php echo e(route('register')); ?>">Registro</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <?php if(session('status')): ?>
            <div class="container flash success"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="container flash error">
                <p>Corrige los campos marcados para continuar.</p>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php echo e($slot ?? ''); ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <h3>YO-TELLO</h3>
                <p>Moda urbana con una experiencia de inicio, carrito y pedidos mas viva y accionable.</p>
            </div>
            <div>
                <h4>Compra</h4>
                <ul>
                    <li>Catalogo conectado</li>
                    <li>Carrito y checkout</li>
                    <li>Seguimiento de pedidos</li>
                </ul>
            </div>
            <div>
                <h4>Contacto</h4>
                <p>ventas@novawear.test</p>
                <p>+57 300 000 0000</p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\Users\Usuario\Downloads\TIENDA DE ROPAS\backend\resources\views/layouts/app.blade.php ENDPATH**/ ?>