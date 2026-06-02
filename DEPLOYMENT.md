# RWS Laravel Admin Deployment

## Free-friendly stack

- Database: Supabase Postgres free plan.
- Admin hosting: Render Free Web Service for MVP/testing.
- Media files: store public image/audio/PDF URLs. For large files, use Supabase Storage free tier or another object storage provider.

Render free web services spin down after 15 minutes without traffic and wake up on the next request. Render free Postgres expires after 30 days, so use Supabase Postgres instead for the database.

## Local setup

```sh
cd admin-panel
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Admin URL:

```text
http://127.0.0.1:8000/admin
```

API URL:

```text
http://127.0.0.1:8000/api/content
```

## Supabase environment values

Create a Supabase project, then copy the connection values from Project Settings > Database.

```env
DB_CONNECTION=pgsql
DB_HOST=your-project-ref.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-database-password
DB_SSLMODE=require
```

## Render environment values

Set these in Render:

```env
APP_KEY=base64:generate-with-php-artisan-key-generate
APP_URL=https://your-render-app.onrender.com
ADMIN_EMAIL=your-admin-email@example.com
ADMIN_PASSWORD=use-a-strong-password
DB_CONNECTION=pgsql
DB_HOST=your-project-ref.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-database-password
DB_SSLMODE=require
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

For the Expo app, add the Laravel URL:

```env
EXPO_PUBLIC_API_URL=https://your-render-app.onrender.com
```
