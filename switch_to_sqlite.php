<?php

/**
 * Switch to SQLite and Run Migrations
 */

echo "=== Switching to SQLite ===\n\n";

$envFile = '.env';

if (!file_exists($envFile)) {
    echo "❌ .env file not found!\n";
    exit(1);
}

$envContent = file_get_contents($envFile);

// Update to SQLite configuration
$updates = [
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => 'database/database.sqlite',
];

// Remove MySQL-specific settings or comment them out
$mysqlSettings = ['DB_HOST', 'DB_PORT', 'DB_USERNAME', 'DB_PASSWORD'];

foreach ($updates as $key => $value) {
    $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';
    
    if (preg_match($pattern, $envContent)) {
        $envContent = preg_replace($pattern, $key . '=' . $value, $envContent);
        echo "  Updated: {$key} = {$value}\n";
    } else {
        $envContent .= "\n{$key}={$value}\n";
        echo "  Added: {$key} = {$value}\n";
    }
}

// Ensure SQLite database file exists
$sqlitePath = 'database/database.sqlite';
if (!file_exists($sqlitePath)) {
    $dir = dirname($sqlitePath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    touch($sqlitePath);
    echo "  Created: {$sqlitePath}\n";
} else {
    echo "  ✓ SQLite database file exists\n";
}

file_put_contents($envFile, $envContent);
echo "\n✓ .env file updated to use SQLite!\n";

// Clear config cache
echo "\nClearing config cache...\n";
exec('php artisan config:clear', $output, $return);
echo "✓ Config cache cleared!\n\n";

// Run migrations
echo "═══════════════════════════════════════════════════\n";
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

