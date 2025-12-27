<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Role - DormMate</title>

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
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .auth-body {
            padding: 40px;
        }

        .form-select {
            border: 2px solid rgba(14, 165, 233, 0.15);
            border-radius: 12px;
            padding: 14px 18px;
            transition: all 0.3s ease;
        }

        .form-select:focus {
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
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-header">
        <h1>Select Your Role</h1>
        <p class="mb-0">Choose how you want to use DormMate</p>
    </div>

    <div class="auth-body">

        <form method="POST" action="{{ route('google.role.store') }}">
            @csrf

            <div class="mb-4">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="Dorm Seeker">Dorm Seeker</option>
                    <option value="Dorm Owner">Dorm Owner</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fab fa-google me-2"></i>Continue with Google
            </button>
        </form>

    </div>
</div>

</body>
</html>
