# YO-TELLO separado en carpetas reales

Estructura del proyecto:

```text
TIENDA DE ROPAS/
|-- backend/   -> Laravel, base de datos, autenticacion, carrito, pedidos, promociones y API
`-- frontend/  -> app Vite independiente que consume el backend por HTTP
```

## Backend

`backend/` contiene el proyecto Laravel.

Puntos clave:

- Rutas web con Blade para el ecommerce.
- Panel administrador para productos, categorias y promociones.
- API publica:
  - `GET /api/storefront/overview`
  - `GET /api/storefront/products`

## Frontend

`frontend/` contiene una app de catalogo premium que consume la API del backend.

Puntos clave:

- Lee `VITE_API_BASE_URL` cuando se usa con Vite.
- Tambien puede correr como frontend estatico sin build.
- Muestra catalogo, carrito local, paneles editoriales y promociones activas.

## Arranque sugerido

Backend:

```bash
cd backend
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Frontend (Vite):

```bash
cd frontend
copy .env.example .env
npm install
npm run dev
```

Nota Windows/PowerShell: si `npm.ps1` esta bloqueado, usa `npm.cmd install` y `npm.cmd run dev`.

Frontend estatico, sin Node:

```bash
php -S 127.0.0.1:5173 -t frontend
```

Luego abre `http://127.0.0.1:5173` y asegurate de tener el backend corriendo en `http://127.0.0.1:8000`.
