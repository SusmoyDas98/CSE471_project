<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\Room;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{
    public function create(Room $room)
    {
        $this->authorizeRoom($room);
        return view('owner.vacancies.create', compact('room'));
    }

    public function store(Request $request, Room $room)
    {
        $this->authorizeRoom($room);

        $data = $request->validate([
            'status' => ['required', 'in:open,closed,filled'],
            'available_from' => ['nullable', 'date'],
            'available_to' => ['nullable', 'date', 'after_or_equal:available_from'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['room_id'] = $room->id;

        Vacancy::create($data);

        return redirect()->route('owner.dorms.index')->with('status', 'Vacancy posted.');
    }

    public function edit(Vacancy $vacancy)
    {
        $this->authorizeRoom($vacancy->room);
        return view('owner.vacancies.edit', compact('vacancy'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $this->authorizeRoom($vacancy->room);

        $data = $request->validate([
            'status' => ['required', 'in:open,closed,filled'],
            'available_from' => ['nullable', 'date'],
            'available_to' => ['nullable', 'date', 'after_or_equal:available_from'],
            'notes' => ['nullable', 'string'],
        ]);

        $vacancy->update($data);

        return redirect()->route('owner.dorms.index')->with('status', 'Vacancy updated.');
    }

    private function authorizeRoom(Room $room): void
    {
        if (!$room || $room->dorm->user_id !== Auth::id()) {
            abort(403);
        }
    }
}

