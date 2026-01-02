<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DormController extends Controller
{
    public function index()
    {
        $dorms = Dorm::where('user_id', Auth::id())->with('rooms.vacancies')->get();

        return view('owner.dorms.index', compact('dorms'));
    }

    public function create()
    {
        return view('owner.dorms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:120'],
            'nearby_university' => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string'],
            'amenities' => ['nullable', 'string', 'max:500'],
            'rules' => ['nullable', 'string', 'max:500'],
            'photos' => ['nullable', 'string', 'max:500'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:120'],
        ]);

        $data['user_id'] = Auth::id();
        $data['amenities'] = $this->splitToArray($data['amenities'] ?? null);
        $data['rules'] = $this->splitToArray($data['rules'] ?? null);
        $data['photos'] = $this->splitToArray($data['photos'] ?? null);

        Dorm::create($data);

        return redirect()->route('owner.dorms.index')->with('status', 'Dorm created.');
    }

    public function edit(Dorm $dorm)
    {
        $this->authorizeDorm($dorm);
        return view('owner.dorms.edit', compact('dorm'));
    }

    public function update(Request $request, Dorm $dorm)
    {
        $this->authorizeDorm($dorm);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:120'],
            'nearby_university' => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string'],
            'amenities' => ['nullable', 'string', 'max:500'],
            'rules' => ['nullable', 'string', 'max:500'],
            'photos' => ['nullable', 'string', 'max:500'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:120'],
        ]);

        $data['amenities'] = $this->splitToArray($data['amenities'] ?? null);
        $data['rules'] = $this->splitToArray($data['rules'] ?? null);
        $data['photos'] = $this->splitToArray($data['photos'] ?? null);

        $dorm->update($data);

        return redirect()->route('owner.dorms.index')->with('status', 'Dorm updated.');
    }

    public function destroy(Dorm $dorm)
    {
        $this->authorizeDorm($dorm);
        $dorm->delete();

        return redirect()->route('owner.dorms.index')->with('status', 'Dorm deleted.');
    }

    private function authorizeDorm(Dorm $dorm): void
    {
        if ($dorm->user_id !== Auth::id()) {
            abort(403);
        }
    }

    private function splitToArray(?string $value): ?array
    {
        if (!$value) {
            return null;
        }

        return collect(explode(',', $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}

