<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="api-base-url" content="<?php echo e(url('/api')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php if(auth()->guard()->check()): ?>
        <meta name="auth-user-initial" content="<?php echo e(mb_substr(auth()->user()->name, 0, 1)); ?>">
        <meta name="auth-user-name" content="<?php echo e(auth()->user()->name); ?>">
        <meta name="logout-url" content="<?php echo e(route('logout')); ?>">
    <?php endif; ?>
    <title>YO-TELLO</title>
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('yotello-mark.svg')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('yotello-mark.svg')); ?>">
    <?php
        $js = collect(glob(public_path('assets/index-*.js')))
            ->sortByDesc(fn ($path) => filemtime($path))
            ->map(fn ($path) => '/assets/'.basename($path))
            ->first();
        $css = collect(glob(public_path('assets/index-*.css')))
            ->sortByDesc(fn ($path) => filemtime($path))
            ->map(fn ($path) => '/assets/'.basename($path))
            ->first();
    ?>
    <?php if($js): ?>
        <script type="module" crossorigin src="<?php echo e($js); ?>"></script>
    <?php endif; ?>
    <?php if($css): ?>
        <link rel="stylesheet" crossorigin href="<?php echo e($css); ?>">
    <?php endif; ?>
</head>
<body>
    <div id="app"></div>
</body>
</html>
<?php /**PATH C:\Users\Usuario\Downloads\TIENDA DE ROPAS\backend\resources\views/storefront.blade.php ENDPATH**/ ?>