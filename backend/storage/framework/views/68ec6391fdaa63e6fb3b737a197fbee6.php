<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? 'YO-TELLO Admin'); ?></title>
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
<body class="admin-body">
    <header class="admin-only-header">
        <a class="admin-only-brand" href="<?php echo e(route('admin.index')); ?>">YO-TELLO Admin</a>
        <nav class="admin-only-links">
            <a href="<?php echo e(route('home')); ?>">Ver tienda</a>
            <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="nav-button" type="submit">Salir</button>
            </form>
        </nav>
    </header>

    <main class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand-card">
                <img class="admin-avatar" src="<?php echo e(asset('yotello-mark.svg')); ?>" alt="YO-TELLO">
                <div>
                    <strong>Panel Admin</strong>
                    <span><?php echo e(auth('admin')->user()?->email ?? 'admin@yotello.com'); ?></span>
                </div>
            </div>

            <nav class="admin-nav">
                <a class="<?php echo e(request()->routeIs('admin.index') ? 'active' : ''); ?>" href="<?php echo e(route('admin.index')); ?>">Dashboard</a>
                <a class="<?php echo e(request()->routeIs('admin.productos.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.productos.index')); ?>">Productos</a>
                <a class="<?php echo e(request()->routeIs('admin.categorias.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categorias.index')); ?>">Categorias</a>
                <a class="<?php echo e(request()->routeIs('admin.promociones.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.promociones.index')); ?>">Promociones</a>
                <a class="<?php echo e(request()->routeIs('admin.pedidos.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.pedidos.index')); ?>">Pedidos</a>
                <a class="<?php echo e(request()->routeIs('admin.usuarios.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.usuarios.index')); ?>">Usuarios</a>
                <a href="<?php echo e(route('home')); ?>">Ver tienda</a>
            </nav>
        </aside>

        <div class="admin-main">
            <?php if(session('status')): ?>
                <div class="flash success"><?php echo e(session('status')); ?></div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="flash error">
                    <p>Revisa los datos ingresados.</p>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>
</body>
</html>
<?php /**PATH C:\Users\Usuario\Downloads\TIENDA DE ROPAS\backend\resources\views/layouts/admin.blade.php ENDPATH**/ ?>