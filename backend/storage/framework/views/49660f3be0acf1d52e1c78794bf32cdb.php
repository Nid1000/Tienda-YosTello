<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>YO-TELLO | Acceso Admin</title>
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('yotello-mark.svg')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('yotello-mark.svg')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="admin-login-body">
    <main class="admin-login-shell">
        <section class="admin-login-card">
            <div class="admin-login-brand">
                <img src="<?php echo e(asset('yotello-mark.svg')); ?>" alt="YO-TELLO">
                <div>
                    <span>YO-TELLO</span>
                    <strong>Acceso administrador</strong>
                </div>
            </div>

            <div>
                <p class="eyebrow">Panel privado</p>
                <h1>Panel<br>administrador</h1>
                <p class="lead compact-lead">Gestiona el catalogo YO-TELLO, inventario, promociones, usuarios y pedidos desde un solo lugar.</p>
            </div>

            <?php if(session('status')): ?>
                <div class="flash success">
                    <p><?php echo e(session('status')); ?></p>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="flash error">
                    <p>Revisa las credenciales ingresadas.</p>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.login.store')); ?>" class="stack-form">
                <?php echo csrf_field(); ?>
                <label>
                    <span>Email administrador</span>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                </label>
                <label>
                    <span>Clave de acceso</span>
                    <input type="password" name="password" required>
                </label>
                <label class="check-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Recordarme en este panel</span>
                </label>
                <button class="button primary" type="submit">Entrar al panel</button>
            </form>

            <div class="admin-login-footer">
                <a href="<?php echo e(route('login')); ?>">Ir al login de clientes</a>
                <a href="<?php echo e(route('home')); ?>">Volver a la tienda</a>
            </div>
        </section>
    </main>
</body>
</html>
<?php /**PATH C:\Users\Usuario\Downloads\TIENDA DE ROPAS\backend\resources\views/auth/admin-login.blade.php ENDPATH**/ ?>