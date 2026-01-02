<?php

/**
 * Test All Features Including Owner Features
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "═══════════════════════════════════════════════════\n";
echo "  Testing All Features (Including Owner Features)\n";
echo "═══════════════════════════════════════════════════\n\n";

$features = [
    // Seeker Features
    [
        'name' => 'Profile Preferences',
        'route' => '/test/profile/preferences',
        'description' => 'User profile and preferences management',
        'category' => 'Seeker'
    ],
    [
        'name' => 'Browse Seekers',
        'route' => '/test/seekers',
        'description' => 'Browse other seekers profiles to find roommates',
        'category' => 'Seeker'
    ],
    [
        'name' => 'Seeker Dashboard',
        'route' => '/test/seeker/dashboard',
        'description' => 'Seeker dashboard',
        'category' => 'Seeker'
    ],
    [
        'name' => 'Browse Vacancies',
        'route' => '/test/seeker/vacancies',
        'description' => 'Browse and apply for dorm vacancies',
        'category' => 'Seeker'
    ],
    // Owner Features
    [
        'name' => 'Owner Dashboard',
        'route' => '/test/owner/dorms',
        'description' => 'Owner dashboard - Manage dorms',
        'category' => 'Owner'
    ],
    [
        'name' => 'Create Dorm',
        'route' => '/test/owner/dorms/create',
        'description' => 'Create a new dorm',
        'category' => 'Owner'
    ],
    [
        'name' => 'Review Applications',
        'route' => '/test/owner/applications',
        'description' => 'Review and manage applications',
        'category' => 'Owner'
    ],
    // Community & Payment
    [
        'name' => 'Community Forum',
        'route' => '/test/community',
        'description' => 'Community forum for dorm residents',
        'category' => 'Community'
    ],
    [
        'name' => 'Payment Portal',
        'route' => '/test/payments',
        'description' => 'Payment portal for invoices and payments',
        'category' => 'Payment'
    ],
];

$results = [];
$categories = [];

foreach ($features as $index => $feature) {
    $category = $feature['category'];
    if (!isset($categories[$category])) {
        $categories[$category] = [];
    }
    
    echo "Testing: [{$category}] {$feature['name']}\n";
    echo "─────────────────────────────────────────────────\n";
    echo "Route: {$feature['route']}\n";
    echo "Description: {$feature['description']}\n";
    
    try {
        $request = Illuminate\Http\Request::create($feature['route'], 'GET');
        $response = $kernel->handle($request);
        
        $statusCode = $response->getStatusCode();
        
        if ($statusCode >= 200 && $statusCode < 300) {
            echo "✓ Status: {$statusCode} - SUCCESS\n";
            $results[] = ['feature' => $feature['name'], 'category' => $category, 'status' => 'success', 'code' => $statusCode];
            $categories[$category][] = ['name' => $feature['name'], 'status' => 'success'];
        } else {
            echo "⚠ Status: {$statusCode} - Warning\n";
            $results[] = ['feature' => $feature['name'], 'category' => $category, 'status' => 'warning', 'code' => $statusCode];
            $categories[$category][] = ['name' => $feature['name'], 'status' => 'warning'];
        }
    } catch (\Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n";
        $results[] = ['feature' => $feature['name'], 'category' => $category, 'status' => 'error', 'error' => $e->getMessage()];
        $categories[$category][] = ['name' => $feature['name'], 'status' => 'error'];
    }
    
    echo "\n";
}

// Summary by Category
echo "═══════════════════════════════════════════════════\n";
echo "  Test Summary by Category\n";
echo "═══════════════════════════════════════════════════\n\n";

foreach ($categories as $category => $features) {
    $successCount = count(array_filter($features, fn($f) => $f['status'] === 'success'));
    $totalCount = count($features);
    
    echo "{$category} Features:\n";
    foreach ($features as $feature) {
        $icon = $feature['status'] === 'success' ? '✓' : ($feature['status'] === 'warning' ? '⚠' : '✗');
        echo "  {$icon} {$feature['name']}\n";
    }
    echo "  → {$successCount}/{$totalCount} successful\n\n";
}

// Overall Summary
echo "═══════════════════════════════════════════════════\n";
echo "  Overall Summary\n";
echo "═══════════════════════════════════════════════════\n\n";

$successCount = count(array_filter($results, fn($r) => $r['status'] === 'success'));
$warningCount = count(array_filter($results, fn($r) => $r['status'] === 'warning'));
$errorCount = count(array_filter($results, fn($r) => $r['status'] === 'error'));

echo "Total Features: " . count($results) . "\n";
echo "Successful: {$successCount}\n";
echo "Warnings: {$warningCount}\n";
echo "Errors: {$errorCount}\n\n";

if ($successCount === count($results)) {
    echo "✓ All features are working correctly!\n";
} else {
    echo "⚠ Some features need attention.\n";
}

echo "\n";
echo "Owner Features URLs:\n";
echo "  • Dashboard: http://127.0.0.1:8000/test/owner/dorms\n";
echo "  • Create Dorm: http://127.0.0.1:8000/test/owner/dorms/create\n";
echo "  • Review Applications: http://127.0.0.1:8000/test/owner/applications\n\n";

