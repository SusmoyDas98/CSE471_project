<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function create(Dorm $dorm)
    {
        $this->authorizeDorm($dorm);
        return view('owner.rooms.create', compact('dorm'));
    }

    public function store(Request $request, Dorm $dorm)
    {
        $this->authorizeDorm($dorm);

        $data = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'capacity' => ['required', 'integer', 'min:1', 'max:10'],
            'price' => ['nullable', 'integer', 'min:0'],
            'room_type' => ['nullable', 'string', 'max:50'],
            'is_shared' => ['nullable', 'boolean'],
            'size_sqft' => ['nullable', 'integer', 'min:0'],
            'gender_policy' => ['nullable', 'string', 'max:30'],
            'available_from' => ['nullable', 'date'],
        ]);

        $data['is_shared'] = $request->boolean('is_shared');
        $data['dorm_id'] = $dorm->id;

        Room::create($data);

        return redirect()->route('owner.dorms.index')->with('status', 'Room added.');
    }

    public function edit(Dorm $dorm, Room $room)
    {
        $this->authorizeDorm($dorm);
        $this->authorizeRoom($room, $dorm);

        return view('owner.rooms.edit', compact('dorm', 'room'));
    }

    public function update(Request $request, Dorm $dorm, Room $room)
    {
        $this->authorizeDorm($dorm);
        $this->authorizeRoom($room, $dorm);

        $data = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'capacity' => ['required', 'integer', 'min:1', 'max:10'],
            'price' => ['nullable', 'integer', 'min:0'],
            'room_type' => ['nullable', 'string', 'max:50'],
            'is_shared' => ['nullable', 'boolean'],
            'size_sqft' => ['nullable', 'integer', 'min:0'],
            'gender_policy' => ['nullable', 'string', 'max:30'],
            'available_from' => ['nullable', 'date'],
        ]);

        $data['is_shared'] = $request->boolean('is_shared');

        $room->update($data);

        return redirect()->route('owner.dorms.index')->with('status', 'Room updated.');
    }

    public function destroy(Dorm $dorm, Room $room)
    {
        $this->authorizeDorm($dorm);
        $this->authorizeRoom($room, $dorm);

        // Get all vacancies for this room
        $vacancies = $room->vacancies()->with('applications.seeker')->get();
        
        // Collect unique seekers who have applied to this room's vacancies
        $seekersToNotify = collect();
        
        foreach ($vacancies as $vacancy) {
            foreach ($vacancy->applications as $application) {
                if ($application->seeker && !$seekersToNotify->contains('id', $application->seeker->id)) {
                    $seekersToNotify->push($application->seeker);
                }
            }
        }
        
        // Create notifications for each seeker
        foreach ($seekersToNotify as $seeker) {
            \App\Models\Notification::create([
                'user_id' => $seeker->id,
                'type' => 'room_deleted',
                'title' => 'Room No Longer Available',
                'message' => "The room '{$room->label}' at {$room->dorm->name} that you applied for has been removed by the dorm owner. Your application is no longer valid.",
                'is_read' => false,
                'related_id' => $room->id,
                'related_type' => Room::class,
            ]);
        }

        $room->delete();

        $notificationCount = $seekersToNotify->count();
        $statusMessage = $notificationCount > 0 
            ? "Room deleted. {$notificationCount} seeker(s) have been notified."
            : 'Room deleted.';

        return redirect()->route('owner.dorms.index')->with('status', $statusMessage);
    }

    private function authorizeDorm(Dorm $dorm): void
    {
        if ($dorm->user_id !== Auth::id()) {
            abort(403);
        }
    }

    private function authorizeRoom(Room $room, Dorm $dorm): void
    {
        if ($room->dorm_id !== $dorm->id) {
            abort(404);
        }
    }
}

