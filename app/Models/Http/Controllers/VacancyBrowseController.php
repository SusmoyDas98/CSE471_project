<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Models\Dorm;
use Illuminate\Http\Request;

class VacancyBrowseController extends Controller
{
    public function index(Request $request)
    {
        $query = Vacancy::with(['room.dorm'])
            ->where('status', 'open');

        // Filter by city
        if ($request->has('city') && $request->city) {
            $query->whereHas('room.dorm', function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->city . '%');
            });
        }

        // Filter by price range
        if ($request->has('max_price') && $request->max_price) {
            $query->whereHas('room', function ($q) use ($request) {
                $q->where('price', '<=', $request->max_price);
            });
        }

        $vacancies = $query->latest()->paginate(12);

        // Get unique cities for filter
        $cities = Dorm::distinct()->pluck('city')->filter()->sort()->values();

        return view('seeker.vacancies.index', compact('vacancies', 'cities'));
    }

    public function show(Vacancy $vacancy)
    {
        $vacancy->load(['room.dorm', 'applications' => function ($q) {
            $q->where('user_id', auth()->id());
        }]);

        $hasApplied = $vacancy->applications->isNotEmpty();
        $userApplication = $vacancy->applications->first();

        return view('seeker.vacancies.show', compact('vacancy', 'hasApplied', 'userApplication'));
    }
}
