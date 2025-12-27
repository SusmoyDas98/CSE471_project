<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Dorm - Premium Housing Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            --bg-main: #f0f9ff;
            --bg-secondary: #e0f2fe;
            --card-bg: #ffffff;
            --text-primary: #0c4a6e;
            --text-secondary: #075985;
            --border-color: #bae6fd;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                        linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 0;
        }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.03) 0%, rgba(59, 130, 246, 0.03) 100%),
                        white;
            border-radius: 24px;
            padding: 80px 70px;
            margin: 80px auto 60px;
            max-width: 1400px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            box-shadow: 0 20px 60px rgba(14, 165, 233, 0.12);
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.06) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .hero-content {
            display: flex;
            align-items: center;
            gap: 80px;
            position: relative;
            z-index: 1;
        }
        
        .hero-image {
            flex: 1;
            position: relative;
        }
        
        .hero-image-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 48px rgba(14, 165, 233, 0.2);
        }
        
        .hero-image-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            border: 3px solid rgba(14, 165, 233, 0.2);
            border-radius: 20px;
            z-index: 1;
        }
        
        .hero-image-wrapper::after {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            right: 20px;
            bottom: 20px;
            background: linear-gradient(135deg, var(--primary-light), var(--accent));
            border-radius: 20px;
            z-index: -1;
            opacity: 0.2;
        }
        
        .hero-image img {
            width: 100%;
            display: block;
        }
        
        .hero-text {
            flex: 1;
        }
        
        .hero-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }
        
        .hero-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 24px;
            line-height: 1.15;
            letter-spacing: -1px;
        }
        
        .hero-text h1 span {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
        }
        
        .hero-text p {
            color: var(--text-secondary);
            font-size: 1.15rem;
            line-height: 1.7;
            margin-bottom: 32px;
        }
        
        .hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 32px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            display: block;
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-container {
            background: white;
            border-radius: 24px;
            padding: 70px;
            margin: 60px auto 80px;
            max-width: 1100px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            box-shadow: 0 20px 60px rgba(14, 165, 233, 0.12);
            position: relative;
        }
        
        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 0 0 10px 10px;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
            letter-spacing: -1px;
        }
        
        .form-header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }
        
        .form-section {
            margin-bottom: 50px;
            padding: 40px;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.02) 0%, rgba(59, 130, 246, 0.02) 100%);
            border-radius: 16px;
            border: 2px solid rgba(14, 165, 233, 0.08);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .form-section::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
            border-radius: 16px 0 0 16px;
        }
        
        .form-section:hover {
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.1);
            border-color: rgba(14, 165, 233, 0.15);
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        
        .section-title i {
            color: var(--primary);
            font-size: 1.6rem;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(59, 130, 246, 0.1));
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }
        
        .form-control, .form-select {
            background: white;
            border: 2px solid rgba(14, 165, 233, 0.15);
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 0.95rem;
            color: var(--text-primary);
            transition: all 0.3s ease;
        }
        
        .form-control::placeholder {
            color: #94a3b8;
        }
        
        .form-control:focus, .form-select:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
            color: var(--text-primary);
            outline: none;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            padding: 18px 60px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(14, 165, 233, 0.4);
        }
        
        small.text-muted {
            color: var(--text-secondary) !important;
        }
        
        .footer-note {
            text-align: center;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 2px solid rgba(14, 165, 233, 0.1);
        }
        
        .footer-note p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
                gap: 50px;
            }
            
            .hero-text h1 {
                font-size: 2.5rem;
            }
            
            .hero-section, .form-container {
                padding: 50px 30px;
            }
            
            .form-header h2 {
                font-size: 2.2rem;
            }
            
            .hero-stats {
                gap: 30px;
            }
        }
    </style>
</head>
<body>
    {{-- Page Header + Nav --}}
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>
    
    <div style="height: 120px;"></div>
    
    <div class="container">
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <span class="hero-badge">✨ Premium Platform</span>
                    <h1>From idea to impact — <span>we've got your back</span></h1>
                    <p class="lead">Join the most trusted platform for student housing. Register your dorm and connect with thousands of verified students looking for their perfect home away from home.</p>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number">50K+</span>
                            <span class="stat-label">Active Students</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">2.5K+</span>
                            <span class="stat-label">Listed Dorms</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">98%</span>
                            <span class="stat-label">Satisfaction</span>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="hero-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600" alt="Professional Property Owner">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-container">
            <div class="form-header">
                <h2>Register Your Property</h2>
                <p>Complete the form below to list your premium dorm on our platform</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <form id="dormRegistrationForm" method="POST" action="{{ route('dorm.register.store') }}">
                @csrf
                
                <!-- Dorm Information -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-building"></i>
                        Property Details
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="dormName" class="form-label">Property Name *</label>
                            <input type="text" class="form-control" id="dormName" name="dorm_name" placeholder="Enter your property's name" value="{{ old('dorm_name') }}" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label for="location" class="form-label">Location *</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Enter property location" value="{{ old('location') }}" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="numRooms" class="form-label">Available Rooms *</label>
                            <input type="number" class="form-control" id="numRooms" name="room_count" placeholder="e.g., 25" min="1" value="{{ old('room_count') }}" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="roomTypes" class="form-label">Room Categories *</label>
                            <input type="text" class="form-control" id="roomTypes" name="room_types" placeholder="Single, Double, Suite, Deluxe" value="{{ old('room_types') }}" required>
                            <small class="text-muted">Separate categories with commas</small>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe your property..." required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-paper-plane me-2"></i>Submit Registration
                    </button>
                </div>
                
                <div class="footer-note">
                    <p><i class="fas fa-lock me-2"></i>Your information is secure and will be verified within 24-48 hours</p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>