<?php

/**
 * XAMPP MySQL Connection Tester
 * XAMPP MySQL typically uses empty password by default
 */

echo "=== XAMPP MySQL Connection Test ===\n\n";

// XAMPP common configurations
$configs = [
    ['user' => 'root', 'pass' => '', 'host' => '127.0.0.1'],
    ['user' => 'root', 'pass' => '', 'host' => 'localhost'],
    ['user' => 'root', 'pass' => 'root', 'host' => '127.0.0.1'],
    ['user' => 'root', 'pass' => 'root', 'host' => 'localhost'],
];

foreach ($configs as $config) {
    $user = $config['user'];
    $pass = $config['pass'];
    $host = $config['host'];
    $pwdDisplay = $pass === '' ? '(empty)' : $pass;
    
    echo "Testing: user={$user}, password={$pwdDisplay}, host={$host}... ";
    
    try {
        $pdo = new PDO(
            "mysql:host={$host};port=3306",
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 3
            ]
        );
        
        echo "✓ SUCCESS!\n\n";
        echo "═══════════════════════════════════════════════════\n";
        echo "WORKING CONFIGURATION FOUND!\n";
        echo "═══════════════════════════════════════════════════\n\n";
        
        // Check if database exists
        $stmt = $pdo->query("SHOW DATABASES LIKE 'laravel'");
        $dbExists = $stmt->rowCount() > 0;
        
        if ($dbExists) {
            echo "✓ Database 'laravel' already exists!\n";
        } else {
            echo "Creating database 'laravel'...\n";
            try {
                $pdo->exec("CREATE DATABASE IF NOT EXISTS laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                echo "✓ Database 'laravel' created successfully!\n";
            } catch (PDOException $e) {
                echo "⚠ Could not create database: " . $e->getMessage() . "\n";
                echo "You may need to create it manually.\n";
            }
        }
        
        echo "\n";
        echo "═══════════════════════════════════════════════════\n";
        echo "UPDATE YOUR .env FILE WITH:\n";
        echo "═══════════════════════════════════════════════════\n";
        echo "DB_CONNECTION=mysql\n";
        echo "DB_HOST={$host}\n";
        echo "DB_PORT=3306\n";
        echo "DB_DATABASE=laravel\n";
        echo "DB_USERNAME={$user}\n";
        if ($pass === '') {
            echo "DB_PASSWORD=\n";
        } else {
            echo "DB_PASSWORD={$pass}\n";
        }
        echo "═══════════════════════════════════════════════════\n\n";
        
        // Test Laravel connection
        echo "Testing Laravel connection...\n";
        try {
            $pdo->exec("USE laravel");
            echo "✓ Can connect to 'laravel' database!\n\n";
            echo "✓ Everything is ready! You can now run: php artisan migrate\n";
        } catch (PDOException $e) {
            echo "⚠ Database 'laravel' exists but cannot be accessed: " . $e->getMessage() . "\n";
        }
        
        exit(0);
        
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Access denied') !== false) {
            echo "✗ Access denied\n";
        } else {
            echo "✗ " . $e->getMessage() . "\n";
        }
    }
}

echo "\n";
echo "═══════════════════════════════════════════════════\n";
echo "❌ None of the XAMPP configurations worked.\n";
echo "═══════════════════════════════════════════════════\n\n";

echo "XAMPP MySQL Troubleshooting:\n\n";
echo "1. Make sure MySQL is running in XAMPP Control Panel:\n";
echo "   - Open XAMPP Control Panel\n";
echo "   - Click 'Start' next to MySQL\n";
echo "   - Wait for it to turn green\n\n";

echo "2. Reset MySQL password (if needed):\n";
echo "   - Open XAMPP Control Panel\n";
echo "   - Click 'Admin' next to MySQL (opens phpMyAdmin)\n";
echo "   - Or use: mysql -u root (no password)\n\n";

echo "3. Check MySQL error logs:\n";
echo "   - In XAMPP Control Panel, click 'Logs' next to MySQL\n";
echo "   - Look for any error messages\n\n";

echo "4. Try connecting manually:\n";
echo "   mysql -u root\n";
echo "   (XAMPP MySQL usually has no password)\n\n";

echo "5. If MySQL won't start in XAMPP:\n";
echo "   - Check if port 3306 is already in use\n";
echo "   - Stop any other MySQL services\n";
echo "   - Check Windows Services for MySQL\n\n";

