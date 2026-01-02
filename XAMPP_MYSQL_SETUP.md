# XAMPP MySQL Setup Guide

## Step 1: Start MySQL in XAMPP

1. **Open XAMPP Control Panel**
2. **Click "Start" next to MySQL**
3. **Wait for it to turn green** (indicating it's running)
4. If MySQL shows an error or won't start:
   - Click "Logs" next to MySQL to see error messages
   - Common issues:
     - Port 3306 already in use (another MySQL instance running)
     - Missing dependencies
     - Permission issues

## Step 2: If Port 3306 is Already in Use

If MySQL won't start because port 3306 is busy:

**Option A: Stop the existing MySQL service**
```powershell
# Check what's using port 3306
netstat -ano | findstr :3306

# Stop MySQL Windows Service (if running)
net stop MySQL80
# or
net stop MySQL
```

**Option B: Use the existing MySQL instance**
- If another MySQL is already running, you can use that instead
- Just need to find the correct password

## Step 3: Test MySQL Connection

Once MySQL is running in XAMPP, test the connection:

```powershell
# Test with empty password (XAMPP default)
php test_xampp_mysql.php
```

Or manually:
```powershell
mysql -u root
# (XAMPP MySQL usually has no password, just press Enter)
```

## Step 4: Update .env File

Once you can connect, update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

(Leave DB_PASSWORD empty if XAMPP MySQL has no password)

## Step 5: Create Database and Run Migrations

```powershell
# Clear config cache
php artisan config:clear

# Create database (if needed)
php artisan db:create

# Run migrations
php artisan migrate
```

## Quick Fix Script

If you know your MySQL password, run:
```powershell
php update_mysql_config.php YOUR_PASSWORD
```

If password is empty:
```powershell
php update_mysql_config.php ""
```

