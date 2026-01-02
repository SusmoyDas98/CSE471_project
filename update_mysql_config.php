<?php

/**
 * Update MySQL Configuration in .env file
 * Usage: php update_mysql_config.php your_password_here
 */

if ($argc < 2) {
    echo "Usage: php update_mysql_config.php <mysql_password>\n";
    echo "Example: php update_mysql_config.php mypassword\n";
    echo "         php update_mysql_config.php \"\" (for empty password)\n";
    exit(1);
}

$password = $argv[1];
$envFile = '.env';

if (!file_exists($envFile)) {
    echo "Error: .env file not found!\n";
    exit(1);
}

// Read .env file
$envContent = file_get_contents($envFile);

// Update MySQL configuration
$updates = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'laravel',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => $password,
];

foreach ($updates as $key => $value) {
    // Pattern to match the key (with or without quotes, with or without value)
    $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';
    
    if (preg_match($pattern, $envContent)) {
        // Replace existing value
        $envContent = preg_replace($pattern, $key . '=' . $value, $envContent);
        echo "Updated: {$key}\n";
    } else {
        // Add new line if it doesn't exist
        $envContent .= "\n{$key}={$value}\n";
        echo "Added: {$key}\n";
    }
}

// Save .env file
file_put_contents($envFile, $envContent);

echo "\n✓ .env file updated successfully!\n\n";

// Test the connection
echo "Testing MySQL connection...\n";
try {
    $pdo = new PDO(
        "mysql:host=127.0.0.1;port=3306",
        'root',
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "✓ Connection successful!\n";
    
    // Check/create database
    $stmt = $pdo->query("SHOW DATABASES LIKE 'laravel'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Database 'laravel' exists!\n";
    } else {
        echo "Creating database 'laravel'...\n";
        $pdo->exec("CREATE DATABASE IF NOT EXISTS laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "✓ Database 'laravel' created!\n";
    }
    
    echo "\n✓ Everything is ready! You can now run: php artisan migrate\n";
    
} catch (PDOException $e) {
    echo "✗ Connection failed: " . $e->getMessage() . "\n";
    echo "\nPlease check your MySQL password and try again.\n";
    exit(1);
}

