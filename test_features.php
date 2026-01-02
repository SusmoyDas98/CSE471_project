<?php

/**
 * Test the 4 Main Features
 */

echo "═══════════════════════════════════════════════════\n";
echo "  Testing 4 Main Features\n";
echo "═══════════════════════════════════════════════════\n\n";

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$features = [
    [
        'name' => 'Feature 1: Profile Preferences',
        'route' => '/test/profile/preferences',
        'description' => 'User profile and preferences management'
    ],
    [
        'name' => 'Feature 1: Browse Seekers',
        'route' => '/test/seekers',
        'description' => 'Browse other seekers profiles to find roommates'
    ],
    [
        'name' => 'Feature 2: Vacancy Management',
        'route' => '/test/seeker/vacancies',
        'description' => 'Browse and apply for dorm vacancies'
    ],
    [
        'name' => 'Feature 3: Community Forum',
        'route' => '/test/community',
        'description' => 'Community forum for dorm residents'
    ],
    [
        'name' => 'Feature 4: Payment Portal',
        'route' => '/test/payments',
        'description' => 'Payment portal for invoices and payments'
    ],
];

$results = [];

foreach ($features as $index => $feature) {
    echo "Testing Feature " . ($index + 1) . ": {$feature['name']}\n";
    echo "─────────────────────────────────────────────────\n";
    echo "Route: {$feature['route']}\n";
    echo "Description: {$feature['description']}\n";
    
    try {
        $request = Illuminate\Http\Request::create($feature['route'], 'GET');
        $response = $kernel->handle($request);
        
        $statusCode = $response->getStatusCode();
        
        if ($statusCode >= 200 && $statusCode < 300) {
            echo "✓ Status: {$statusCode} - SUCCESS\n";
            $results[] = ['feature' => $feature['name'], 'status' => 'success', 'code' => $statusCode];
        } else {
            echo "⚠ Status: {$statusCode} - Warning\n";
            $results[] = ['feature' => $feature['name'], 'status' => 'warning', 'code' => $statusCode];
        }
    } catch (\Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n";
        $results[] = ['feature' => $feature['name'], 'status' => 'error', 'error' => $e->getMessage()];
    }
    
    echo "\n";
}

// Summary
echo "═══════════════════════════════════════════════════\n";
echo "  Test Summary\n";
echo "═══════════════════════════════════════════════════\n\n";

$successCount = count(array_filter($results, fn($r) => $r['status'] === 'success'));
$warningCount = count(array_filter($results, fn($r) => $r['status'] === 'warning'));
$errorCount = count(array_filter($results, fn($r) => $r['status'] === 'error'));

foreach ($results as $result) {
    $icon = $result['status'] === 'success' ? '✓' : ($result['status'] === 'warning' ? '⚠' : '✗');
    $color = $result['status'] === 'success' ? 'green' : ($result['status'] === 'warning' ? 'yellow' : 'red');
    echo "{$icon} {$result['feature']}\n";
}

echo "\n";
echo "Total: " . count($results) . " features tested\n";
echo "Successful: {$successCount}\n";
echo "Warnings: {$warningCount}\n";
echo "Errors: {$errorCount}\n\n";

if ($successCount === count($results)) {
    echo "✓ All features are working correctly!\n";
} else {
    echo "⚠ Some features need attention.\n";
}

echo "\n";

