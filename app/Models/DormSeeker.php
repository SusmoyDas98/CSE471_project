<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class DormSeeker
{
    /**
     * Get the current dorm seeker (AUTH-READY)
     */
    public static function current()
    {
        // FUTURE: real authenticated user
        if (Auth::check()) {
            return Auth::user();
        }

        // CURRENT: dummy fallback (NO AUTH YET)
        return (object) [
            'id' => 1,
            'name' => 'Alex Johnson',
            'has_dorm' => true,
        ];
    }

    /**
     * Dorm / lease info
     */
    public static function dorm($userId = null)
    {
        $userId = $userId ?? self::current()->id;

        /*
        FUTURE REAL QUERY (NO CHANGE NEEDED LATER):

        return DormRegistrationSubmission::with('dorm.owner')
            ->where('user_id', $userId)
            ->where('status', 'Approved')
            ->first();
        */

        // Dummy data
        return (object) [
            'propertyName' => 'Sunset Residences - Apartment 3B',
            'address' => '245 Campus Drive, University District',
            'landlordName' => 'Robert Anderson',
            'landlordEmail' => 'r.anderson@sunsetresidences.com',
            'monthlyRent' => '$1,200',
            'nextDueDate' => '2024-12-20',
            'leaseStart' => 'September 1, 2024',
            'leaseEnd' => 'August 31, 2025',
            'communityName' => 'Sunset Residences Community',
            'totalMembers' => 24,
        ];
    }

    /**
     * Latest community post
     */
    public static function latestCommunityPost()
    {
        /*
        FUTURE:
        return Post::latest()->first();
        */

        return (object) [
            'author' => 'Emily Chen',
            'authorInitial' => 'E',
            'time' => '2 hours ago',
            'content' => 'Scheduled maintenance this Saturday from 9 AM – 12 PM.',
        ];
    }
}
