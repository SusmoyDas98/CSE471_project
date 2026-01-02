<?php

/**
 * MySQL Setup Script for Laravel Project
 * This script will help you connect your Laravel project to MySQL
 */

echo "═══════════════════════════════════════════════════\n";
echo "  MySQL Setup for Laravel Project\n";
echo "═══════════════════════════════════════════════════\n\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "❌ Error: .env file not found!\n";
    echo "Please create a .env file first (copy from .env.example if available).\n";
    exit(1);
}

// Check if PDO MySQL extension is available
if (!extension_loaded('pdo_mysql')) {
    echo "❌ Error: PDO MySQL extension is not installed!\n";
    echo "Please install php-mysql extension.\n";
    exit(1);
}

echo "Step 1: Testing MySQL Connection\n";
echo "─────────────────────────────────\n\n";

// Common MySQL configurations to try
$configs = [
    ['host' => '127.0.0.1', 'port' => '3306', 'user' => 'root', 'pass' => ''],
    ['host' => 'localhost', 'port' => '3306', 'user' => 'root', 'pass' => ''],
    ['host' => '127.0.0.1', 'port' => '3306', 'user' => 'root', 'pass' => 'root'],
    ['host' => '127.0.0.1', 'port' => '3306', 'user' => 'root', 'pass' => 'password'],
];

$workingConfig = null;
$pdo = null;

foreach ($configs as $index => $config) {
    echo "Trying configuration " . ($index + 1) . ": ";
    echo "host={$config['host']}, user={$config['user']}, password=";
    echo ($config['pass'] === '' ? '(empty)' : '***') . "... ";
    
    try {
        $pdo = new PDO(
            "mysql:host={$config['host']};port={$config['port']}",
            $config['user'],
            $config['pass'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 3
            ]
        );
        
        echo "✓ SUCCESS!\n";
        $workingConfig = $config;
        break;
    } catch (PDOException $e) {
        echo "✗ Failed (" . $e->getMessage() . ")\n";
    }
}

if (!$workingConfig) {
    echo "\n❌ Could not connect to MySQL with any default configuration.\n\n";
    echo "Please provide your MySQL credentials:\n";
    echo "───────────────────────────────────────\n";
    
    $host = readline("MySQL Host [127.0.0.1]: ") ?: '127.0.0.1';
    $port = readline("MySQL Port [3306]: ") ?: '3306';
    $user = readline("MySQL Username [root]: ") ?: 'root';
    $pass = readline("MySQL Password: ");
    
    try {
        $pdo = new PDO(
            "mysql:host={$host};port={$port}",
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 3
            ]
        );
        
        $workingConfig = [
            'host' => $host,
            'port' => $port,
            'user' => $user,
            'pass' => $pass
        ];
        echo "\n✓ Connection successful!\n\n";
    } catch (PDOException $e) {
        echo "\n❌ Connection failed: " . $e->getMessage() . "\n";
        echo "\nPlease make sure:\n";
        echo "1. MySQL is installed and running\n";
        echo "2. MySQL service is started\n";
        echo "3. The credentials are correct\n";
        echo "4. Port {$port} is not blocked by firewall\n";
        exit(1);
    }
}

// Step 2: Get database name
echo "\nStep 2: Database Configuration\n";
echo "─────────────────────────────────\n\n";

$dbName = readline("Database name [dorminex]: ") ?: 'dorminex';
echo "Using database: {$dbName}\n\n";

// Step 3: Create database if it doesn't exist
echo "Step 3: Creating Database\n";
echo "──────────────────────────\n\n";

try {
    $stmt = $pdo->query("SHOW DATABASES LIKE '{$dbName}'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Database '{$dbName}' already exists!\n";
    } else {
        echo "Creating database '{$dbName}'...\n";
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "✓ Database '{$dbName}' created successfully!\n";
    }
} catch (PDOException $e) {
    echo "❌ Error creating database: " . $e->getMessage() . "\n";
    exit(1);
}

// Step 4: Update .env file
echo "\nStep 4: Updating .env File\n";
echo "───────────────────────────\n\n";

$envFile = '.env';
$envContent = file_get_contents($envFile);

// Update database configuration
$updates = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => $workingConfig['host'],
    'DB_PORT' => $workingConfig['port'],
    'DB_DATABASE' => $dbName,
    'DB_USERNAME' => $workingConfig['user'],
    'DB_PASSWORD' => $workingConfig['pass'],
];

foreach ($updates as $key => $value) {
    $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';
    
    if (preg_match($pattern, $envContent)) {
        $envContent = preg_replace($pattern, $key . '=' . $value, $envContent);
        echo "  Updated: {$key}\n";
    } else {
        // Add at the end if not found
        $envContent .= "\n{$key}={$value}\n";
        echo "  Added: {$key}\n";
    }
}

file_put_contents($envFile, $envContent);
echo "✓ .env file updated successfully!\n";

// Step 5: Clear config cache
echo "\nStep 5: Clearing Configuration Cache\n";
echo "──────────────────────────────────────\n\n";

$output = [];
$return = 0;
exec('php artisan config:clear 2>&1', $output, $return);
if ($return === 0) {
    echo "✓ Configuration cache cleared!\n";
} else {
    echo "⚠ Warning: Could not clear config cache. You may need to run 'php artisan config:clear' manually.\n";
}

// Step 6: Test connection
echo "\nStep 6: Testing Laravel Database Connection\n";
echo "────────────────────────────────────────────\n\n";

try {
    $testPdo = new PDO(
        "mysql:host={$workingConfig['host']};port={$workingConfig['port']};dbname={$dbName}",
        $workingConfig['user'],
        $workingConfig['pass'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✓ Laravel can connect to MySQL database!\n";
} catch (PDOException $e) {
    echo "⚠ Warning: Could not test Laravel connection: " . $e->getMessage() . "\n";
}

// Final summary
echo "\n═══════════════════════════════════════════════════\n";
echo "✓ MySQL Setup Complete!\n";
echo "═══════════════════════════════════════════════════\n\n";

echo "Your Laravel project is now configured to use MySQL.\n\n";
echo "Next steps:\n";
echo "1. Run migrations: php artisan migrate\n";
echo "2. (Optional) Run seeders: php artisan db:seed\n";
echo "3. Start your application: php artisan serve\n\n";

echo "Database Configuration:\n";
echo "  Host: {$workingConfig['host']}\n";
echo "  Port: {$workingConfig['port']}\n";
echo "  Database: {$dbName}\n";
echo "  Username: {$workingConfig['user']}\n";
echo "  Password: " . ($workingConfig['pass'] === '' ? '(empty)' : '***') . "\n\n";

