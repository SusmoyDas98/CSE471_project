# Testing Guide: Vacancy Management & Application Review

## How to Test the Feature

### Step 1: Start the Laravel Server

If the server is not already running, start it:

```bash
php artisan serve
```

The application will be available at `http://localhost:8000` or `http://127.0.0.1:8000`

### Step 2: Access the Owner Dashboard

1. Open your browser and go to: **http://localhost:8000/test/owner/dorms**
   - This route automatically logs you in as a test owner
   - No authentication required for testing

2. You should see the **Owner Dashboard** with:
   - A header showing "Your dorms"
   - A "Review Applications" button (if there are pending applications)
   - Options to create dorms, rooms, and vacancies

### Step 3: Create Test Data (If Needed)

#### Option A: Create via UI
1. Click **"Add dorm"** to create a new dorm
2. Fill in dorm details (name, address, city, etc.)
3. Click **"Add room"** for the dorm
4. Fill in room details (label, capacity, price, etc.)
5. Click **"Post vacancy"** for the room
6. Fill in vacancy details and save

#### Option B: Use Tinker (Quick Test Data)
Run this in your terminal:

```bash
php artisan tinker
```

Then paste:

```php
// Create test owner
$owner = \App\Models\User::firstOrCreate(
    ['email' => 'owner@test.com'],
    ['name' => 'Test Owner', 'password' => bcrypt('password'), 'role' => 'owner']
);

// Create test dorm
$dorm = \App\Models\Dorm::firstOrCreate(
    ['name' => 'Test Dorm'],
    [
        'user_id' => $owner->id,
        'address' => '123 Test Street',
        'city' => 'Test City',
        'description' => 'A test dorm for testing',
        'amenities' => ['WiFi', 'AC', 'Laundry']
    ]
);

// Create test room
$room = \App\Models\Room::firstOrCreate(
    ['dorm_id' => $dorm->id, 'label' => 'Room 101'],
    [
        'capacity' => 2,
        'price' => 5000,
        'room_type' => 'Shared',
        'gender_policy' => 'Mixed'
    ]
);

// Create test vacancy
$vacancy = \App\Models\Vacancy::firstOrCreate(
    ['room_id' => $room->id],
    [
        'status' => 'available',
        'available_from' => now(),
        'notes' => 'Available for immediate move-in'
    ]
);

// Create test seeker
$seeker = \App\Models\User::firstOrCreate(
    ['email' => 'seeker@test.com'],
    ['name' => 'Test Seeker', 'password' => bcrypt('password'), 'role' => 'seeker']
);

// Create test application
$application = \App\Models\Application::create([
    'vacancy_id' => $vacancy->id,
    'user_id' => $seeker->id,
    'message' => 'I am interested in this room. Please consider my application.',
    'budget' => 5000,
    'move_in_date' => now()->addDays(30),
    'status' => 'submitted'
]);

echo "Test data created successfully!";
```

### Step 4: Test Application Review Features

1. **View All Applications**
   - Click **"Review Applications"** in the navigation or dashboard
   - You'll see all applications from dorm seekers
   - Filter by status (Submitted, Reviewing, Accepted, Rejected, Waitlisted)
   - Filter by dorm

2. **Review Individual Application**
   - Click **"Review Details"** or **"View Details"** on any application card
   - You'll see:
     - Application information (dorm, room, move-in date, budget)
     - Seeker's message
     - Complete seeker profile and preferences
     - Review & Decision panel

3. **Select a Seeker to Stay**
   - In the application detail page:
     - Select **"Accept - Allow to Stay"** from the status dropdown
     - Check **"Automatically reject other applications"** (recommended)
     - Add private notes if needed
     - Click **"Save Decision"**
   - OR use the quick action button: **"✓ Accept to Stay in Dorm"**

4. **Test Quick Actions**
   - **Accept**: Accepts the seeker and optionally rejects others
   - **Reject**: Rejects the application
   - **Waitlist**: Adds to waitlist

5. **View Applications by Vacancy**
   - From the dorm dashboard, click **"Review"** next to any vacancy
   - See all applications for that specific vacancy
   - Accept/reject directly from the list

### Step 5: Verify Features

✅ **Check that:**
- Pending applications show a badge count in navigation
- Dashboard shows alert when there are pending applications
- Application cards display seeker information clearly
- Status changes work correctly
- When accepting one seeker, others are automatically rejected (if option checked)
- Filtering by status and dorm works
- Navigation shows pending count badge

### Step 6: Test from Welcome Page

You can also access the feature from the main welcome page:
- Go to: **http://localhost:8000**
- Click **"Feature 2: Vacancy Mgmt"** button
- This will take you directly to the owner dashboard

## Troubleshooting

### No Applications Showing?
- Make sure you've created test applications (see Step 3)
- Check that the vacancy status is "available"
- Verify the application status is "submitted"

### Can't See Owner Dashboard?
- Make sure you're accessing `/test/owner/dorms`
- Check that the server is running
- Clear browser cache if needed

### Database Issues?
Run migrations:
```bash
php artisan migrate
```

## Quick Test Checklist

- [ ] Owner dashboard loads
- [ ] Can create dorm, room, vacancy
- [ ] Applications appear in review list
- [ ] Can view application details
- [ ] Can accept/reject applications
- [ ] Status updates correctly
- [ ] Pending count badge shows in navigation
- [ ] Filtering works (by status, by dorm)
- [ ] Accepting one seeker rejects others (if option checked)

---

**Note**: These test routes bypass authentication for easy testing. In production, proper authentication will be required.

