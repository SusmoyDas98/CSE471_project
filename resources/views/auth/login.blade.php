<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DormMate</title>
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
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                        linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        .auth-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(14, 165, 233, 0.15);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }
        
        .auth-header {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            padding: 40px;
            text-align: center;
            color: white;
        }
        
        .auth-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .auth-body {
            padding: 40px;
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
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
        }
        
        .btn-google {
            background: white;
            border: 2px solid rgba(14, 165, 233, 0.15);
            color: #333;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-google:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.15);
        }
        
        .divider {
            text-align: center;
            margin: 24px 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: rgba(14, 165, 233, 0.15);
        }
        
        .divider span {
            background: white;
            padding: 0 16px;
            position: relative;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Welcome Back</h1>
            <p class="mb-0">Login to continue to DormMate</p>
        </div>
        
        <div class="auth-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>

                    <div class="position-relative">
                        <input type="password"
                            class="form-control pe-5 password-toggle-input"
                            id="password"
                            name="password"
                            required>

                        <span class="password-toggle-icon"
                            style="
                                position:absolute;
                                top:50%;
                                right:16px;
                                transform:translateY(-50%);
                                cursor:pointer;
                                display:none;
                                color:#000;">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                    </div>
                </div>

                
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </form>
            
            <div class="divider">
                <span>OR</span>
            </div>
            
            <a href="{{ route('google.redirect') }}" class="btn btn-google w-100">
                <i class="fab fa-google me-2"></i>Continue with Google
            </a>
            
            <p class="text-center mt-4 mb-0">
                Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold">Register</a>
            </p>
        </div>
    </div>

    <script>
        document.querySelectorAll('.password-toggle-input').forEach(input => {
            const wrapper = input.parentElement;
            const toggle = wrapper.querySelector('.password-toggle-icon');
            const icon = toggle.querySelector('i');

            input.addEventListener('input', () => {
                if (input.value.length > 0) {
                    toggle.style.display = 'block';
                } else {
                    toggle.style.display = 'none';
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });

            toggle.addEventListener('click', () => {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>


</body>
</html>