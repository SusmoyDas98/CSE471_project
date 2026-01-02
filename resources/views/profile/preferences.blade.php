<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Preferences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #38bdf8;
            --secondary: #06b6d4;
            --accent: #3b82f6;
            --gold: #fbbf24;
            --success: #10b981;
            --bg-main: #f0f9ff;
            --bg-secondary: #e0f2fe;
            --card-bg: #ffffff;
            --text-primary: #0c4a6e;
            --text-secondary: #075985;
            --border-color: #bae6fd;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                        linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--text-primary);
            min-height: 100vh;
        }
        
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1a1a1a;
        }
        
        .navbar-brand .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .navbar-brand .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .navbar-brand .brand-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0284c7;
            font-family: 'Playfair Display', serif;
        }
        
        .navbar-brand .brand-tagline {
            font-size: 0.65rem;
            font-weight: 500;
            color: #0ea5e9;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-family: 'Inter', sans-serif;
        }
        
        .navbar-text {
            color: var(--text-secondary) !important;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .hero-section {
            padding: 60px 0 40px;
            text-align: center;
        }
        
        .hero-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 8px 24px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero-title span {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 700px;
            margin: 0 auto 40px;
        }
        
        .form-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            box-shadow: 0 20px 60px rgba(14, 165, 233, 0.12);
            margin-bottom: 30px;
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(14, 165, 233, 0.1);
        }
        
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid rgba(14, 165, 233, 0.2);
            padding: 12px 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        
        .btn-save {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            padding: 14px 48px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
        }
        
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
        }
        
        .btn-back {
            background: white;
            color: var(--text-secondary);
            border: 2px solid rgba(14, 165, 233, 0.2);
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-back:hover {
            border-color: var(--primary);
            background: rgba(14, 165, 233, 0.05);
            color: var(--primary);
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .form-card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="brand-text">
                <div class="brand-title">DormMate</div>
                <div class="brand-tagline">HOUSING SIMPLIFIED</div>
            </div>
        </a>
        <span class="navbar-text ms-auto">
            <i class="fas fa-lightbulb me-2"></i>Improve your recommendations
        </span>
    </div>
</nav>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-user-cog me-2"></i>Personalize Your Profile</span>
        <h1 class="hero-title">Your Living <span>Preferences</span></h1>
        <p class="hero-subtitle">Tell us about your preferences to get better dorm and roommate matches</p>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('seeker.dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form class="form-card" method="POST" action="{{ route('profile.preferences.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <h4 class="section-title"><i class="fas fa-address-card me-2"></i>Contact & Bio</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $detail->phone) }}" placeholder="+880 1XXX XXXXXX">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Short bio</label>
                        <textarea name="bio" rows="4" class="form-control @error('bio') is-invalid @enderror" 
                                  placeholder="Tell us about yourself, your interests, habits, and what you value in roommates...">{{ old('bio', $detail->bio) }}</textarea>
                        @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-briefcase me-2"></i>Profession
                        </label>
                        <select name="profession" class="form-select @error('profession') is-invalid @enderror">
                            <option value="">Select Profession</option>
                            <option value="Student" {{ old('profession', $detail->profession) == 'Student' ? 'selected' : '' }}>Student</option>
                            <option value="Job Holder" {{ old('profession', $detail->profession) == 'Job Holder' ? 'selected' : '' }}>Job Holder</option>
                        </select>
                        @error('profession')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">
                            <i class="fas fa-id-card me-2"></i>Verification Document
                        </label>
                        <div class="mb-2">
                            <small class="text-muted d-block mb-2">
                                Upload your Student ID card, University Payment Receipt, or NID (PDF, JPG, PNG - Max 5MB)
                            </small>
                            <input type="file" name="verification_document" 
                                   class="form-control @error('verification_document') is-invalid @enderror"
                                   accept=".pdf,.jpg,.jpeg,.png">
                            @error('verification_document')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($detail->verification_document)
                            <div class="alert alert-info d-flex align-items-center gap-2" style="border-radius: 12px; padding: 12px;">
                                <i class="fas fa-file-pdf text-primary"></i>
                                <span>Current document: 
                                    <a href="{{ $documentUrl ?? route('profile.document.view') }}" target="_blank" class="text-decoration-none fw-bold text-primary">
                                        <i class="fas fa-external-link-alt me-1"></i>View Document
                                    </a>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <h4 class="section-title"><i class="fas fa-money-bill-wave me-2"></i>Budget & Timing</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Budget min (TK)</label>
                        <input type="number" name="budget_min" class="form-control @error('budget_min') is-invalid @enderror"
                               value="{{ old('budget_min', $detail->budget_min) }}" min="0" placeholder="5000">
                        @error('budget_min')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Budget max (TK)</label>
                        <input type="number" name="budget_max" class="form-control @error('budget_max') is-invalid @enderror"
                               value="{{ old('budget_max', $detail->budget_max) }}" min="0" placeholder="15000">
                        @error('budget_max')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Move-in date</label>
                        <input type="date" name="move_in_date" class="form-control @error('move_in_date') is-invalid @enderror"
                               value="{{ old('move_in_date', optional($detail->move_in_date)->format('Y-m-d')) }}">
                        @error('move_in_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Stay length (months)</label>
                        <input type="number" name="stay_length_months" class="form-control @error('stay_length_months') is-invalid @enderror"
                               value="{{ old('stay_length_months', $detail->stay_length_months) }}" min="1" max="60" placeholder="12">
                        @error('stay_length_months')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h4 class="section-title"><i class="fas fa-home me-2"></i>Room & Lifestyle</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Room type preference</label>
                        <input type="text" name="room_type_pref" class="form-control @error('room_type_pref') is-invalid @enderror"
                               value="{{ old('room_type_pref', $detail->room_type_pref) }}" placeholder="Studio / Shared / Private">
                        @error('room_type_pref')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gender preference</label>
                        <input type="text" name="gender_pref" class="form-control @error('gender_pref') is-invalid @enderror"
                               value="{{ old('gender_pref', $detail->gender_pref) }}" placeholder="Any / Male / Female / Mixed">
                        @error('gender_pref')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marital Status</label>
                        <select name="marital_status" class="form-select @error('marital_status') is-invalid @enderror">
                            <option value="">Select Status</option>
                            <option value="Single" {{ old('marital_status', $detail->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('marital_status', $detail->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Divorced" {{ old('marital_status', $detail->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Widowed" {{ old('marital_status', $detail->marital_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        </select>
                        @error('marital_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check me-4">
                            <input class="form-check-input" type="checkbox" name="smoking" value="1" id="smoking"
                                   {{ old('smoking', $detail->smoking) ? 'checked' : '' }}>
                            <label class="form-check-label" for="smoking">Smoking OK</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pet_friendly" value="1" id="pet_friendly"
                                   {{ old('pet_friendly', $detail->pet_friendly) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pet_friendly">Pet friendly</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cleanliness level (1-5)</label>
                        <input type="number" name="cleanliness_level" class="form-control @error('cleanliness_level') is-invalid @enderror"
                               value="{{ old('cleanliness_level', $detail->cleanliness_level) }}" min="1" max="5" placeholder="5">
                        @error('cleanliness_level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Noise tolerance (1-5)</label>
                        <input type="number" name="noise_tolerance" class="form-control @error('noise_tolerance') is-invalid @enderror"
                               value="{{ old('noise_tolerance', $detail->noise_tolerance) }}" min="1" max="5" placeholder="3">
                        @error('noise_tolerance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Wake time</label>
                        <input type="time" name="wake_time" class="form-control @error('wake_time') is-invalid @enderror"
                               value="{{ old('wake_time', optional($detail->wake_time)->format('H:i')) }}">
                        @error('wake_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Sleep time</label>
                        <input type="time" name="sleep_time" class="form-control @error('sleep_time') is-invalid @enderror"
                               value="{{ old('sleep_time', optional($detail->sleep_time)->format('H:i')) }}">
                        @error('sleep_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Study or work habit</label>
                        <input type="text" name="study_habits" class="form-control @error('study_habits') is-invalid @enderror"
                               value="{{ old('study_habits', $detail->study_habits) }}" placeholder="Late night / Early morning">
                        @error('study_habits')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h4 class="section-title"><i class="fas fa-heart me-2"></i>Preferences for Matching</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Languages (comma separated)</label>
                        <input type="text" name="languages" class="form-control @error('languages') is-invalid @enderror"
                               value="{{ old('languages', $detail->languages ? implode(', ', $detail->languages) : '') }}" placeholder="English, Bengali, Hindi">
                        @error('languages')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Interests (comma separated)</label>
                        <input type="text" name="interests" class="form-control @error('interests') is-invalid @enderror"
                               value="{{ old('interests', $detail->interests ? implode(', ', $detail->interests) : '') }}" placeholder="Gaming, Music, Sports">
                        @error('interests')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location priority</label>
                        <input type="text" name="location_priority" class="form-control @error('location_priority') is-invalid @enderror"
                               value="{{ old('location_priority', $detail->location_priority) }}" placeholder="Near campus / downtown">
                        @error('location_priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Amenity priorities (comma separated)</label>
                        <input type="text" name="amenities_priority" class="form-control @error('amenities_priority') is-invalid @enderror"
                               value="{{ old('amenities_priority', $detail->amenities_priority ? implode(', ', $detail->amenities_priority) : '') }}" placeholder="WiFi, AC, Laundry">
                        @error('amenities_priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_roommate" value="1" id="has_roommate"
                                   {{ old('has_roommate', $detail->has_roommate) ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_roommate">I already have roommate(s)</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Roommate count</label>
                        <input type="number" name="roommate_count" class="form-control @error('roommate_count') is-invalid @enderror"
                               value="{{ old('roommate_count', $detail->roommate_count) }}" min="0" max="10" placeholder="0">
                        @error('roommate_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Preferred Areas (comma separated)</label>
                        <input type="text" name="preferred_areas" class="form-control @error('preferred_areas') is-invalid @enderror"
                               value="{{ old('preferred_areas', $detail->preferred_areas ? implode(', ', $detail->preferred_areas) : '') }}" placeholder="Dhanmondi, Gulshan, Banani">
                        @error('preferred_areas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button class="btn-save" type="submit">
                        <i class="fas fa-save me-2"></i>Save Preferences
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
