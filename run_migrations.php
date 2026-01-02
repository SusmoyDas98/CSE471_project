<?php

/**
 * Run Migrations with MySQL Setup
 * This script will help configure MySQL and run all migrations
 */

echo "=== Run Migrations ===\n\n";

// Check if password is provided as argument
$password = '';
if ($argc > 1) {
    $password = $argv[1];
} else {
    echo "Please provide MySQL password (or press Enter for empty password):\n";
    echo "Usage: php run_migrations.php [password]\n";
    echo "Example: php run_migrations.php mypassword\n";
    echo "         php run_migrations.php \"\" (for empty password)\n\n";
    
    // Try common passwords first
    $commonPasswords = ['', 'root', 'password'];
    $found = false;
    
    foreach ($commonPasswords as $pwd) {
        echo "Trying password: " . ($pwd === '' ? '(empty)' : $pwd) . "... ";
        try {
            $pdo = new PDO(
                "mysql:host=127.0.0.1;port=3306",
                'root',
                $pwd,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 2]
            );
            echo "✓ SUCCESS!\n";
            $password = $pwd;
            $found = true;
            break;
        } catch (PDOException $e) {
            echo "✗ Failed\n";
        }
    }
    
    if (!$found) {
        echo "\n❌ Could not connect with common passwords.\n";
        echo "Please run: php run_migrations.php YOUR_PASSWORD\n";
        exit(1);
    }
}

echo "\nTesting MySQL connection...\n";
try {
    $pdo = new PDO(
        "mysql:host=127.0.0.1;port=3306",
        'root',
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✓ MySQL connection successful!\n";
} catch (PDOException $e) {
    echo "✗ MySQL connection failed: " . $e->getMessage() . "\n";
    echo "\nPlease make sure:\n";
    echo "1. MySQL is running in XAMPP (should be green)\n";
    echo "2. You have the correct password\n";
    echo "3. Port 3306 is not blocked\n\n";
    exit(1);
}

// Create database if needed
echo "\nChecking database 'laravel'...\n";
try {
    $stmt = $pdo->query("SHOW DATABASES LIKE 'laravel'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Database 'laravel' exists!\n";
    } else {
        echo "Creating database 'laravel'...\n";
        $pdo->exec("CREATE DATABASE IF NOT EXISTS laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "✓ Database 'laravel' created!\n";
    }
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Update .env file
echo "\nUpdating .env file...\n";
$envFile = '.env';

if (!file_exists($envFile)) {
    echo "❌ .env file not found!\n";
    exit(1);
}

$envContent = file_get_contents($envFile);

$updates = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'laravel',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => $password,
];

foreach ($updates as $key => $value) {
    $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';
    
    if (preg_match($pattern, $envContent)) {
        $envContent = preg_replace($pattern, $key . '=' . $value, $envContent);
        echo "  Updated: {$key}\n";
    } else {
        $envContent .= "\n{$key}={$value}\n";
        echo "  Added: {$key}\n";
    }
}

file_put_contents($envFile, $envContent);
echo "✓ .env file updated!\n";

// Clear config cache
echo "\nClearing config cache...\n";
exec('php artisan config:clear', $output, $return);
echo "✓ Config cache cleared!\n";

// Run migrations
echo "\n═══════════════════════════════════════════════════\n";
echo "Running migrations...\n";
echo "═══════════════════════════════════════════════════\n\n";

passthru('php artisan migrate', $returnCode);

if ($returnCode === 0) {
    echo "\n═══════════════════════════════════════════════════\n";
    echo "✓ All migrations completed successfully!\n";
    echo "═══════════════════════════════════════════════════\n";
} else {
    echo "\n═══════════════════════════════════════════════════\n";
    echo "⚠ Some migrations may have failed. Check the output above.\n";
    echo "═══════════════════════════════════════════════════\n";
    exit(1);
}

