<?php

namespace App\Http\Controllers;

use App\Models\Property;

class LandlordDashboardController extends Controller
{
    public function index()
    {
        // 🔹 Fetch properties from model (dummy for now)
        $properties = Property::dummyProperties();

        // Compute stats
        $stats = [
            'total'   => count($properties),
            'active'  => count(array_filter($properties, fn($p) => $p['status'] === 'active')),
            'pending' => count(array_filter($properties, fn($p) => $p['status'] === 'pending')),
            'rented'  => count(array_filter($properties, fn($p) => $p['status'] === 'rented')),
        ];

        // Pass data to Blade
        return view('landlord_dashboard', [
            'properties' => $properties,
            'stats'      => $stats,
        ]);
    }
}
