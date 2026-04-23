<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? config('app.name', 'YO-TELLO')); ?></title>
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('yotello-mark.svg')); ?>">
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
    <header class="site-header">
        <nav class="container nav">
            <a class="brand" href="<?php echo e(route('home')); ?>">YO-TELLO</a>
            <div class="nav-links">
                <a href="<?php echo e(route('products.index')); ?>">Catalogo</a>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.index')); ?>">Admin</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('cart.index')); ?>">Carrito</a>
                        <a href="<?php echo e(route('orders.index')); ?>">Pedidos</a>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="nav-button" type="submit">Salir</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>">Login</a>
                    <a href="<?php echo e(route('register')); ?>">Registro</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <?php if(session('status')): ?>
        <div class="container">
            <div class="flash success"><?php echo e(session('status')); ?></div>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="container">
            <div class="flash error">
                <p>Revisa los datos ingresados.</p>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <?php if (! empty(trim($__env->yieldContent('content')))): ?>
        <?php echo $__env->yieldContent('content'); ?>
    <?php else: ?>
        <main>
            <?php echo e($slot ?? ''); ?>

        </main>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\Users\Usuario\Downloads\TIENDA DE ROPAS\backend\resources\views/layouts/app.blade.php ENDPATH**/ ?>