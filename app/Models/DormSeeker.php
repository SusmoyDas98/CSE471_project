<?php

namespace App\Models;

class DormSeeker
{
    public static function current()
    {
        // Simulate a logged-in dorm seeker
        return [
            'id' => 1,
            'name' => 'Alex Johnson',
            'has_dorm' => true, // toggle this
        ];
    }

    public static function dorm()
    {
        return [
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

    public static function latestCommunityPost()
    {
        return [
            'author' => 'Emily Chen',
            'authorInitial' => 'E',
            'time' => '2 hours ago',
            'content' => 'Scheduled maintenance this Saturday from 9 AM – 12 PM.',
        ];
    }
}
