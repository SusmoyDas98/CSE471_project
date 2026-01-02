# MySQL Setup Guide for Dorminex Project

This guide will help you connect your Laravel project to MySQL.

## Prerequisites

1. **MySQL must be installed** on your PC
2. **MySQL service must be running**
3. **PHP PDO MySQL extension** must be installed (usually comes with PHP)

## Quick Setup (Automated)

Run the automated setup script:

```powershell
php setup_mysql.php
```

This script will:
- ✅ Test MySQL connection with common configurations
- ✅ Create the database if it doesn't exist
- ✅ Update your `.env` file automatically
- ✅ Clear Laravel configuration cache
- ✅ Test the connection

## Manual Setup

If you prefer to set up manually:

### Step 1: Start MySQL

Make sure MySQL is running on your system:
- **XAMPP**: Start MySQL from XAMPP Control Panel
- **Standalone MySQL**: Start MySQL service from Services (Windows) or use `net start MySQL80`

### Step 2: Update .env File

Edit your `.env` file and update these lines:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dorminex
DB_USERNAME=root
DB_PASSWORD=
```

**Note**: 
- Change `DB_PASSWORD` if your MySQL root user has a password
- Change `DB_DATABASE` if you want a different database name

### Step 3: Create Database

Connect to MySQL and create the database:

```powershell
# Connect to MySQL (adjust password if needed)
mysql -u root -p

# Or if no password:
mysql -u root
```

Then in MySQL:

```sql
CREATE DATABASE dorminex CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### Step 4: Clear Config Cache

```powershell
php artisan config:clear
```

### Step 5: Run Migrations

```powershell
php artisan migrate
```

## Troubleshooting

### MySQL Connection Failed

**Error**: "Could not connect to MySQL"

**Solutions**:
1. Check if MySQL is running:
   ```powershell
   # Check MySQL service status
   Get-Service | Where-Object {$_.Name -like "*mysql*"}
   ```

2. Check if port 3306 is available:
   ```powershell
   netstat -ano | findstr :3306
   ```

3. Verify MySQL credentials:
   - Default XAMPP: username `root`, password (empty)
   - Standalone MySQL: Check your installation settings

### PDO MySQL Extension Not Found

**Error**: "PDO MySQL extension is not installed"

**Solution**: 
- Install `php-mysql` or `php-pdo_mysql` extension
- For XAMPP: Usually already included
- For standalone PHP: Enable in `php.ini`:
  ```ini
  extension=pdo_mysql
  extension=mysqli
  ```

### Port Already in Use

**Error**: "Port 3306 is already in use"

**Solutions**:
1. Stop the conflicting MySQL service:
   ```powershell
   net stop MySQL80
   ```

2. Or use a different port in `.env`:
   ```env
   DB_PORT=3307
   ```

### Database Already Exists

This is fine! The setup script will detect it and skip creation.

## Testing the Connection

After setup, test your connection:

```powershell
php artisan tinker
```

Then in tinker:
```php
DB::connection()->getPdo();
// Should return: PDO object
```

## Switching Back to SQLite

If you need to switch back to SQLite:

```powershell
php switch_to_sqlite.php
```

Or manually update `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

## Need Help?

- Check MySQL logs for errors
- Verify your MySQL installation
- Ensure PHP has MySQL extensions enabled
- Check firewall settings if connection fails

