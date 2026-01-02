<?php

/**
 * MySQL Password Finder for Laravel Herd
 * This script helps you find the correct MySQL password
 */

echo "=== MySQL Password Finder ===\n\n";
echo "This script will help you find the correct MySQL password.\n";
echo "For Laravel Herd, common passwords are tried first.\n\n";

// Extended list of common passwords for Herd/MySQL
$passwords = [
    '',           // Empty
    'root',       // Common default
    'password',   // Common default
    'laravel',    // Laravel default
    'herd',       // Herd default
    'secret',     // Common default
    '123456',     // Simple password
    'mysql',      // MySQL default
];

echo "Testing common passwords...\n\n";

foreach ($passwords as $password) {
    $pwdDisplay = $password === '' ? '(empty)' : $password;
    echo "Testing: {$pwdDisplay}... ";
    
    try {
        $pdo = new PDO(
            "mysql:host=127.0.0.1;port=3306",
            'root',
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 2
            ]
        );
        
        echo "✓ SUCCESS!\n\n";
        echo "═══════════════════════════════════════════════════\n";
        echo "FOUND WORKING PASSWORD: {$pwdDisplay}\n";
        echo "═══════════════════════════════════════════════════\n\n";
        
        // Check if database exists
        $stmt = $pdo->query("SHOW DATABASES LIKE 'laravel'");
        $dbExists = $stmt->rowCount() > 0;
        
        if ($dbExists) {
            echo "✓ Database 'laravel' already exists!\n";
        } else {
            echo "⚠ Database 'laravel' does not exist.\n";
            echo "Creating database 'laravel'...\n";
            try {
                $pdo->exec("CREATE DATABASE IF NOT EXISTS laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                echo "✓ Database 'laravel' created successfully!\n";
            } catch (PDOException $e) {
                echo "✗ Could not create database: " . $e->getMessage() . "\n";
            }
        }
        
        echo "\n";
        echo "═══════════════════════════════════════════════════\n";
        echo "UPDATE YOUR .env FILE WITH:\n";
        echo "═══════════════════════════════════════════════════\n";
        echo "DB_CONNECTION=mysql\n";
        echo "DB_HOST=127.0.0.1\n";
        echo "DB_PORT=3306\n";
        echo "DB_DATABASE=laravel\n";
        echo "DB_USERNAME=root\n";
        if ($password === '') {
            echo "DB_PASSWORD=\n";
        } else {
            echo "DB_PASSWORD={$password}\n";
        }
        echo "═══════════════════════════════════════════════════\n\n";
        
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
echo "❌ None of the common passwords worked.\n";
echo "═══════════════════════════════════════════════════\n\n";

echo "Please try one of these options:\n\n";
echo "1. Check Laravel Herd Settings:\n";
echo "   - Open Laravel Herd application\n";
echo "   - Go to Settings → Database\n";
echo "   - Find the MySQL root password\n\n";

echo "2. Check MySQL Configuration:\n";
echo "   - Look for MySQL config files\n";
echo "   - Check if you set a custom password during installation\n\n";

echo "3. Reset MySQL Password (if you have access):\n";
echo "   - You may need to reset the MySQL root password\n\n";

echo "4. Try connecting manually:\n";
echo "   mysql -u root -p\n";
echo "   (It will prompt for password)\n\n";

echo "Once you find the password, update your .env file:\n";
echo "DB_CONNECTION=mysql\n";
echo "DB_HOST=127.0.0.1\n";
echo "DB_PORT=3306\n";
echo "DB_DATABASE=laravel\n";
echo "DB_USERNAME=root\n";
echo "DB_PASSWORD=your_password_here\n\n";

