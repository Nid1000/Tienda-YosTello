# Frontend de YO-TELLO

Este frontend consume la API del backend Laravel y presenta una experiencia editorial de moda premium.

## Configuracion de API

- Con Vite: usa `VITE_API_BASE_URL` en `.env`.
- Sin Vite, modo estatico: edita el `<meta name="api-base-url" ...>` en `index.html`.

## Ejecutar con Vite

```bash
copy .env.example .env
npm install
npm run dev
```

Si PowerShell bloquea `npm.ps1`, usa `npm.cmd install` y `npm.cmd run dev`.

## Ejecutar sin Node

Desde la raiz del repo:

```bash
php -S 127.0.0.1:5173 -t frontend
```

Luego abre `http://127.0.0.1:5173`.
