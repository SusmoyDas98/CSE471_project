<?php

/**
 * Database Connection Test Script
 * This script helps you test your MySQL connection settings
 */

echo "=== Database Connection Test ===\n\n";

// Common password options for Laravel Herd
$passwords = ['', 'root', 'password', ''];

// Test each common password
foreach ($passwords as $index => $password) {
    $pwdDisplay = $password === '' ? '(empty)' : $password;
    echo "Testing with password: {$pwdDisplay}...\n";
    
    try {
        $pdo = new PDO(
            "mysql:host=127.0.0.1;port=3306",
            'root',
            $password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
        echo "✓ SUCCESS! Connection works with password: {$pwdDisplay}\n\n";
        echo "Update your .env file with:\n";
        echo "DB_CONNECTION=mysql\n";
        echo "DB_HOST=127.0.0.1\n";
        echo "DB_PORT=3306\n";
        echo "DB_DATABASE=laravel\n";
        echo "DB_USERNAME=root\n";
        echo "DB_PASSWORD={$pwdDisplay}\n\n";
        
        // Check if database exists
        $stmt = $pdo->query("SHOW DATABASES LIKE 'laravel'");
        if ($stmt->rowCount() > 0) {
            echo "✓ Database 'laravel' already exists!\n";
        } else {
            echo "⚠ Database 'laravel' does not exist. Creating it...\n";
            $pdo->exec("CREATE DATABASE IF NOT EXISTS laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "✓ Database 'laravel' created successfully!\n";
        }
        
        exit(0);
    } catch (PDOException $e) {
        echo "✗ Failed: " . $e->getMessage() . "\n\n";
    }
}

echo "❌ None of the common passwords worked.\n";
echo "\nPlease manually update your .env file with the correct MySQL password.\n";
echo "For Laravel Herd, check your Herd settings or MySQL configuration.\n";

