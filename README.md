# Render Test

App sencilla en Laravel 12 con SQLite. La pagina principal muestra el framework, el estado de SQLite y un contador de visitas guardado en base de datos.

## Local

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

Luego abre `http://127.0.0.1:8000`.

## Deploy en Render

Este repo incluye `Dockerfile`, `scripts/00-laravel-deploy.sh`, config de NGINX y `render.yaml`.

### Opcion recomendada: Blueprint

1. Sube este repo a GitHub.
2. En Render, ve a **New +** > **Blueprint**.
3. Conecta el repo `rendertest`.
4. Render detectara `render.yaml`.
5. Cuando Render pida `APP_KEY`, genera una llave local con:

```bash
php artisan key:generate --show
```

6. Pega esa llave en `APP_KEY` y crea el servicio.

La base SQLite queda en `/var/data/database.sqlite`, que esta montado en un persistent disk de Render.
Si no defines `APP_KEY`, el script de arranque genera una llave y la guarda en `/var/data/app.key`.

### Opcion manual: Web Service

1. En Render, ve a **New +** > **Web Service**.
2. Conecta el repo `rendertest`.
3. Runtime: **Docker**.
4. Branch: `main`.
5. Agrega un persistent disk:
   - Name: `sqlite-data`
   - Mount path: `/var/data`
   - Size: `1 GB` o mas
6. Agrega estas variables de entorno:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_KEY=<salida de php artisan key:generate --show>`
   - `APP_URL=https://TU-SERVICIO.onrender.com`
   - `DB_CONNECTION=sqlite`
   - `DB_DATABASE=/var/data/database.sqlite`
   - `LOG_CHANNEL=stderr`
7. Deploy.

Nota: para que SQLite sobreviva redeploys/restarts necesitas persistent disk. Sin disk, el filesystem de Render es efimero.
Tambien se usa el disk para guardar `/var/data/app.key` si `APP_KEY` no fue configurado en Render.
