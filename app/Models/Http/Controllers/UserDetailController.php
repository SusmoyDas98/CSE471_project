<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserDetailController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $detail = $user->detail ?: new UserDetail(['user_id' => $user->id]);

        // Generate document URL if exists
        $documentUrl = null;
        if ($detail->verification_document) {
            $documentUrl = Storage::disk('public')->url($detail->verification_document);
        }

        return view('profile.preferences', [
            'user' => $user,
            'detail' => $detail,
            'documentUrl' => $documentUrl,
        ]);
    }

    public function viewDocument()
    {
        $user = Auth::user();
        $detail = $user->detail;

        if (!$detail || !$detail->verification_document) {
            abort(404, 'Document not found');
        }

        if (!Storage::disk('public')->exists($detail->verification_document)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->response($detail->verification_document);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'phone' => ['nullable', 'string', 'max:30'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'profession' => ['nullable', 'string', 'in:Student,Job Holder'],
            'verification_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5MB max
            'budget_min' => ['nullable', 'integer', 'min:0'],
            'budget_max' => ['nullable', 'integer', 'min:0'],
            'move_in_date' => ['nullable', 'date'],
            'stay_length_months' => ['nullable', 'integer', 'min:1', 'max:60'],
            'room_type_pref' => ['nullable', 'string', 'max:50'],
            'gender_pref' => ['nullable', 'string', 'max:20'],
            'marital_status' => ['nullable', 'string', 'in:Single,Married,Divorced,Widowed'],
            'smoking' => ['nullable', 'boolean'],
            'pet_friendly' => ['nullable', 'boolean'],
            'cleanliness_level' => ['nullable', 'integer', 'min:1', 'max:5'],
            'noise_tolerance' => ['nullable', 'integer', 'min:1', 'max:5'],
            'wake_time' => ['nullable', 'date_format:H:i'],
            'sleep_time' => ['nullable', 'date_format:H:i'],
            'study_habits' => ['nullable', 'string', 'max:100'],
            'languages' => ['nullable', 'string', 'max:500'],
            'interests' => ['nullable', 'string', 'max:500'],
            'location_priority' => ['nullable', 'string', 'max:120'],
            'amenities_priority' => ['nullable', 'string', 'max:500'],
            'has_roommate' => ['nullable', 'boolean'],
            'roommate_count' => ['nullable', 'integer', 'min:0', 'max:10'],
            'preferred_areas' => ['nullable', 'string', 'max:500'],
        ]);

        // Normalize checkbox booleans
        $data['smoking'] = $request->boolean('smoking');
        $data['pet_friendly'] = $request->boolean('pet_friendly');
        $data['has_roommate'] = $request->boolean('has_roommate');

        // Handle file upload
        $detail = $user->detail;

        if ($request->hasFile('verification_document')) {
            // Delete old file if exists
            if ($detail && $detail->verification_document) {
                Storage::disk('public')->delete($detail->verification_document);
            }

            // Store new file
            $file = $request->file('verification_document');
            $path = $file->store('verification-documents', 'public');
            $data['verification_document'] = $path;
        } else {
            // Keep existing file if no new file uploaded
            unset($data['verification_document']);
        }

        // Convert comma-separated text inputs to arrays for storage
        $data['languages'] = $this->splitToArray($data['languages'] ?? null);
        $data['interests'] = $this->splitToArray($data['interests'] ?? null);
        $data['amenities_priority'] = $this->splitToArray($data['amenities_priority'] ?? null);
        $data['preferred_areas'] = $this->splitToArray($data['preferred_areas'] ?? null);

        $detail = $user->detail ?: new UserDetail(['user_id' => $user->id]);
        $detail->fill($data);
        $detail->save();

        return redirect()
            ->route('profile.preferences.edit')
            ->with('status', 'Preferences updated for better recommendations.');
    }

    private function splitToArray(?string $value): ?array
    {
        if (!$value) {
            return null;
        }

        return collect(explode(',', $value))
            ->map(fn($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
