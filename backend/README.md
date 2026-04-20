# Backend de YO-TELLO con Laravel

Backend del ecommerce para ropa, zapatillas y pantalones. Vive dentro de `backend/` y expone vistas Blade internas, panel administrador y endpoints API para un frontend separado.

## Lo incluido

- Catalogo de productos con categorias, buscador, filtros y ordenamiento.
- Registro, login, dashboard de usuario y roles `admin` y `customer`.
- Carrito de compras, checkout y registro de pedidos.
- Validacion de stock antes de agregar al carrito y confirmar pedidos.
- Checkout con campos peruanos y consulta de DNI por API desde backend.
- Panel administrador para crear, editar y eliminar productos, categorias y promociones.
- Promociones con codigo, tipo de descuento, vigencia, objetivo e imagen editorial.
- Backend en Laravel con modelos, controladores, rutas, migraciones y seeders.
- Endpoints API para el frontend separado en `../frontend`.
- Datos iniciales de ejemplo para arrancar rapido.

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js 20 o superior
- MySQL 8 o superior, opcional si no usas SQLite

## Instalacion

1. Instala dependencias de PHP:

```bash
composer install
```

2. Copia variables de entorno y genera clave:

```bash
copy .env.example .env
php artisan key:generate
```

3. Base de datos recomendada para arrancar rapido: SQLite.

```bash
php artisan migrate --seed
```

4. Si vas a usar MySQL/phpMyAdmin, importa el archivo SQL completo si esta actualizado:

```bash
mysql -u root -p < database/database.sql
```

5. Ajusta tu conexion MySQL en `.env` si aplica:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tienda_ropas
DB_USERNAME=root
DB_PASSWORD=
```

6. Instala dependencias del frontend Vite dentro de Laravel:

```bash
npm install
```

Si PowerShell bloquea `npm.ps1`, usa `npm.cmd install`.

7. Levanta el proyecto:

```bash
php artisan serve
npm run dev
```

## Usuarios demo

- Admin: `admin@novawear.test` / `Admin12345`
- Cliente: `cliente@novawear.test` / `Cliente12345`

## Integracion API Peru

Para autocompletar datos por DNI en el checkout:

```bash
PERU_API_BASE_URL=https://apiperu.dev/api
PERU_API_TOKEN=tu_token_aqui
```

El checkout consulta el DNI desde el backend en la ruta protegida `POST /checkout/dni`.
