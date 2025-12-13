<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DormMate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #0ea5e9;
            --accent: #3b82f6;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.1);
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
        }
        
        .welcome-card h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">DormMate</a>
            <div class="d-flex">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <div class="dashboard-container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="welcome-card">
            <h1>Welcome, {{ Auth::user()->name }}!</h1>
            <p class="mb-0">You're logged in to your DormMate dashboard</p>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card p-4">
                    <h3><i class="fas fa-building text-primary me-2"></i>Browse Dorms</h3>
                    <p>Explore available dorms and read reviews from other students</p>
                    <a href="{{ route('dorms.index') }}" class="btn btn-primary">View Dorms</a>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card p-4">
                    <h3><i class="fas fa-user text-primary me-2"></i>Your Profile</h3>
                    <p>Email: {{ Auth::user()->email }}</p>
                    <p>Role: {{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>