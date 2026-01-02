<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply to {{ $dorms->name }} - DormMate</title>
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
        
        .application-form {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin: 30px auto;
            max-width: 800px;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.1);
        }
        
        .form-control {
            border: 2px solid rgba(14, 165, 233, 0.15);
            border-radius: 12px;
            padding: 14px 18px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 600;
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
    
    <div class="container py-5">
        <div class="application-form">
            <h1 class="text-center mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary);">
                Apply to {{ $dorms->name }}
            </h1>
            
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Location:</strong> {{ $dorms->location }} | 
                <strong>Available Rooms:</strong> {{ $dorms->number_of_rooms }}
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

            <form method="POST" action="{{ route('dorms.apply.store', $dorms->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-id-card me-2 text-primary"></i>Student ID (upload)</label>
                    <input type="file" name="Student_id" class="form-control" required accept="image/*,application/pdf">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-id-badge me-2 text-primary"></i>Government ID (upload)</label>
                    <input type="file" name="Government_id" class="form-control" required accept="image/*,application/pdf">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-user-circle me-2 text-primary"></i>Personal Photo</label>
                    <input type="file" name="Personal_photo" class="form-control" required accept="image/*">
                </div>

                <div class="mb-4">
                    <label for="Reference" class="form-label fw-bold"><i class="fas fa-comment-dots me-2 text-primary"></i>Reference / Message (optional)</label>
                    <textarea class="form-control" id="Reference" name="Reference" rows="4" placeholder="Any message or reference you'd like the owner to see">{{ old('Reference') }}</textarea>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>