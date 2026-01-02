# Database Setup Guide

## Step 1: Find Your MySQL Password

### For Laravel Herd Users:
1. Open Laravel Herd application
2. Go to Settings → Database
3. Note the MySQL root password shown there

### Alternative: Check MySQL Configuration
- The password might be stored in Herd's configuration files
- Default location: `C:\Users\YourName\AppData\Roaming\Herd\`

## Step 2: Update .env File

Open your `.env` file in the project root and update these lines:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=your_actual_password_here
```

**Important:** Replace `your_actual_password_here` with the password you found in Step 1.

## Step 3: Create Database (if needed)

After updating .env, run:
```bash
php artisan db:create
```

Or manually create it:
```sql
CREATE DATABASE laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Step 4: Run Migrations

```bash
php artisan migrate
```

## Alternative: Use SQLite (No Password Needed)

If you want to skip MySQL setup temporarily, you can use SQLite:

1. Update `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

2. Create the SQLite file:
```bash
touch database/database.sqlite
```

3. Run migrations:
```bash
php artisan migrate
```

