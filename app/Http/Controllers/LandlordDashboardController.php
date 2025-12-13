<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property; // Model (optional for future)

class LandlordDashboardController extends Controller
{
    public function index()
    {
        // No database calls for now — simply load your Blade
        return view('landlord_dashboard');
    }
}
