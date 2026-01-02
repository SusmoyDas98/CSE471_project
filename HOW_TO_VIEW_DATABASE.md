# How to View Your Database Tables

## Quick Check: Which Database Are You Using?

Run this command to see your current database connection:
```powershell
php artisan db:show
```

## Method 1: Using Laravel Artisan Commands (Easiest)

### View All Tables
```powershell
php artisan db:show
```

### View Table Structure
```powershell
php artisan db:table users
php artisan db:table dorms
php artisan db:table applications
# etc.
```

### View Table Data
```powershell
php artisan tinker
```
Then in tinker:
```php
DB::table('users')->get();
DB::table('dorms')->get();
DB::table('applications')->get();
```

## Method 2: Using MySQL Command Line

If you're using MySQL, connect directly:

```powershell
mysql -u root -p
```

Then:
```sql
USE dorminex;  -- or your database name
SHOW TABLES;
SELECT * FROM users;
SELECT * FROM dorms;
```

## Method 3: Using phpMyAdmin (If Using XAMPP)

1. **Start XAMPP** and make sure MySQL is running
2. **Open your browser** and go to: `http://localhost/phpmyadmin`
3. **Login** with:
   - Username: `root`
   - Password: (usually empty for XAMPP)
4. **Select your database** from the left sidebar
5. **Click on any table** to view its data

## Method 4: Using Database GUI Tools

### Recommended Tools:

1. **MySQL Workbench** (Official MySQL Tool)
   - Download: https://dev.mysql.com/downloads/workbench/
   - Free and powerful

2. **DBeaver** (Free, Cross-platform)
   - Download: https://dbeaver.io/download/
   - Supports MySQL, PostgreSQL, SQLite, etc.

3. **HeidiSQL** (Windows)
   - Download: https://www.heidisql.com/download.php
   - Lightweight and fast

4. **TablePlus** (Windows/Mac)
   - Download: https://tableplus.com/
   - Modern and user-friendly

### Connection Details for GUI Tools:

Get your connection details:
```powershell
php artisan tinker
```

Then:
```php
config('database.connections.mysql.host')      // Usually: 127.0.0.1
config('database.connections.mysql.port')      // Usually: 3306
config('database.connections.mysql.database')  // Your database name
config('database.connections.mysql.username')  // Usually: root
config('database.connections.mysql.password')  // Your password (may be empty)
```

**Typical Connection Settings:**
- **Host:** `127.0.0.1` or `localhost`
- **Port:** `3306`
- **Database:** `dorminex` (or check your .env file)
- **Username:** `root`
- **Password:** (empty for XAMPP, or your MySQL password)

## Method 5: List All Tables Programmatically

Create a simple script:

```php
<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$tables = DB::select('SHOW TABLES');
$dbName = config('database.connections.mysql.database');
$key = 'Tables_in_' . $dbName;

echo "Database: {$dbName}\n";
echo "Tables:\n";
foreach($tables as $table) {
    $tableName = $table->$key ?? array_values((array)$table)[0];
    $count = DB::table($tableName)->count();
    echo "  - {$tableName} ({$count} rows)\n";
}
```

## Your Database Tables

Based on your migrations, you should have these tables:

1. **users** - User accounts
2. **user_details** - Extended user profile information
3. **dorms** - Dorm listings
4. **rooms** - Rooms within dorms
5. **vacancies** - Available room vacancies
6. **applications** - Applications from seekers
7. **invoices** - Payment invoices
8. **payments** - Payment records
9. **payment_methods** - Saved payment methods
10. **community_posts** - Community forum posts
11. **roommate_connections** - Roommate selections
12. **notifications** - User notifications
13. **dorm_user** - Dorm membership (pivot table)
14. **migrations** - Migration tracking
15. **cache** - Cache storage
16. **sessions** - Session storage
17. **jobs** - Queue jobs
18. **failed_jobs** - Failed queue jobs
19. **job_batches** - Job batches
20. **cache_locks** - Cache locks
21. **password_reset_tokens** - Password reset tokens

## Quick Commands Reference

```powershell
# Show database info
php artisan db:show

# Show table structure
php artisan db:table users

# Open interactive database shell
php artisan tinker

# In tinker, run queries:
DB::table('users')->get();
DB::table('users')->count();
DB::table('users')->where('role', 'owner')->get();
```

## Check Your .env File

Your database connection is configured in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dorminex
DB_USERNAME=root
DB_PASSWORD=
```

Check these values to know your exact connection details!

