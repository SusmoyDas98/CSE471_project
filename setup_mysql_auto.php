<?php

/**
 * Automatic MySQL Setup for XAMPP
 * This script will test connection and update .env automatically
 */

echo "=== Automatic MySQL Setup ===\n\n";

// Try common XAMPP configurations
$configs = [
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => ''],
    ['host' => 'localhost', 'user' => 'root', 'pass' => ''],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => 'root'],
];

$workingConfig = null;

foreach ($configs as $config) {
    echo "Testing: {$config['host']} / {$config['user']} / " . ($config['pass'] === '' ? '(empty)' : $config['pass']) . "... ";
    
    try {
        $pdo = new PDO(
            "mysql:host={$config['host']};port=3306",
            $config['user'],
            $config['pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 2]
        );
        
        echo "✓ SUCCESS!\n";
        $workingConfig = $config;
        break;
    } catch (PDOException $e) {
        echo "✗ Failed\n";
    }
}

if (!$workingConfig) {
    echo "\n❌ Could not connect to MySQL.\n\n";
    echo "Please make sure:\n";
    echo "1. MySQL is running in XAMPP Control Panel (should be green)\n";
    echo "2. Port 3306 is not blocked\n";
    echo "3. MySQL service is started\n\n";
    echo "If MySQL won't start in XAMPP, check the Logs button for error messages.\n";
    exit(1);
}

echo "\n✓ MySQL connection successful!\n\n";

// Create database if it doesn't exist
echo "Checking database 'laravel'...\n";
try {
    $stmt = $pdo->query("SHOW DATABASES LIKE 'laravel'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Database 'laravel' already exists!\n";
    } else {
        echo "Creating database 'laravel'...\n";
        $pdo->exec("CREATE DATABASE IF NOT EXISTS laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "✓ Database 'laravel' created!\n";
    }
} catch (PDOException $e) {
    echo "⚠ Error: " . $e->getMessage() . "\n";
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

// Update database configuration
$updates = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => $workingConfig['host'],
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'laravel',
    'DB_USERNAME' => $workingConfig['user'],
    'DB_PASSWORD' => $workingConfig['pass'],
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
echo "✓ .env file updated!\n\n";

// Clear config cache
echo "Clearing config cache...\n";
exec('php artisan config:clear', $output, $return);
echo "✓ Config cache cleared!\n\n";

echo "═══════════════════════════════════════════════════\n";
echo "✓ MySQL setup complete!\n";
echo "═══════════════════════════════════════════════════\n\n";
echo "You can now run migrations:\n";
echo "  php artisan migrate\n\n";

