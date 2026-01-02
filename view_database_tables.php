<?php

/**
 * View Database Tables
 * This script shows you all your database tables and how to access them
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

echo "═══════════════════════════════════════════════════\n";
echo "  Your Database Information\n";
echo "═══════════════════════════════════════════════════\n\n";

$connection = config('database.default');
$dbConfig = config("database.connections.{$connection}");

echo "Current Connection: {$connection}\n";
echo "Database Name: " . ($dbConfig['database'] ?? 'N/A') . "\n";
echo "Host: " . ($dbConfig['host'] ?? 'N/A') . "\n";
echo "Port: " . ($dbConfig['port'] ?? 'N/A') . "\n";
echo "Username: " . ($dbConfig['username'] ?? 'N/A') . "\n\n";

echo "═══════════════════════════════════════════════════\n";
echo "  Database Tables\n";
echo "═══════════════════════════════════════════════════\n\n";

try {
    $tables = DB::select('SHOW TABLES');
    $tableKey = 'Tables_in_' . $dbConfig['database'];
    
    if (count($tables) > 0) {
        $tableNames = array_map(function($table) use ($tableKey) {
            return $table->$tableKey ?? array_values((array)$table)[0];
        }, $tables);
        
        sort($tableNames);
        
        foreach ($tableNames as $index => $tableName) {
            $rowCount = DB::table($tableName)->count();
            echo sprintf("%2d. %-40s (%d rows)\n", $index + 1, $tableName, $rowCount);
        }
        
        echo "\nTotal: " . count($tableNames) . " tables\n";
    } else {
        echo "No tables found.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nTrying alternative method...\n\n";
    
    try {
        $tables = Schema::getTableListing();
        foreach ($tables as $index => $tableName) {
            $rowCount = DB::table($tableName)->count();
            echo sprintf("%2d. %-40s (%d rows)\n", $index + 1, $tableName, $rowCount);
        }
    } catch (\Exception $e2) {
        echo "Alternative method also failed: " . $e2->getMessage() . "\n";
    }
}

echo "\n═══════════════════════════════════════════════════\n";
echo "  How to Access Your Database\n";
echo "═══════════════════════════════════════════════════\n\n";

echo "Method 1: Using MySQL Command Line\n";
echo "───────────────────────────────────\n";
echo "mysql -u {$dbConfig['username']} -p {$dbConfig['database']}\n";
echo "(Enter your MySQL password when prompted)\n\n";

echo "Method 2: Using Laravel Tinker\n";
echo "───────────────────────────────\n";
echo "php artisan tinker\n";
echo "Then run: DB::table('users')->get();\n\n";

echo "Method 3: Using Laravel Artisan Commands\n";
echo "─────────────────────────────────────────\n";
echo "php artisan db:table users          # Show table structure\n";
echo "php artisan db:show                 # Show database info\n";
echo "php artisan db:monitor              # Monitor queries\n\n";

echo "Method 4: Using Database GUI Tools\n";
echo "──────────────────────────────────\n";
echo "• phpMyAdmin (if using XAMPP): http://localhost/phpmyadmin\n";
echo "• MySQL Workbench (download from mysql.com)\n";
echo "• DBeaver (free, cross-platform)\n";
echo "• TablePlus (Windows/Mac)\n";
echo "• HeidiSQL (Windows)\n\n";

echo "Connection Details for GUI Tools:\n";
echo "  Host: {$dbConfig['host']}\n";
echo "  Port: {$dbConfig['port']}\n";
echo "  Database: {$dbConfig['database']}\n";
echo "  Username: {$dbConfig['username']}\n";
echo "  Password: " . (empty($dbConfig['password']) ? '(empty)' : '***') . "\n\n";

