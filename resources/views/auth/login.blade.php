<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Attendance System | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            display: flex;
            max-width: 1000px;
          
            width: 80%;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 70px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.2;
            animation: float 20s linear infinite;
        }
        
        @keyframes float {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .login-right {
            flex: 1.2;
            padding: 70px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }
        
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 50px;
            position: relative;
            z-index: 2;
        }
        
        .logo-icon {
            background: rgba(255, 255, 255, 0.2);
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .logo-text {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.5px;
            background: linear-gradient(90deg, #fff, #e0e7ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .system-name {
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
            position: relative;
            z-index: 2;
        }
        
        .system-description {
            font-size: 17px;
            opacity: 0.95;
            line-height: 1.7;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
        }
        
        .features {
            margin-top: 40px;
            position: relative;
            z-index: 2;
        }
        
        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.08);
            padding: 18px;
            border-radius: 14px;
            transition: transform 0.3s, background 0.3s;
        }
        
        .feature:hover {
            transform: translateX(10px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .feature-icon {
            background: rgba(255, 255, 255, 0.15);
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .feature-text {
            font-size: 16px;
            font-weight: 500;
        }
        
        .login-title {
            font-size: 36px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 15px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .login-subtitle {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 40px;
        }
        
        .form-group {
            margin-bottom: 30px;
            position: relative;
        }
        
        .form-label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 10px;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #6366f1;
            font-size: 20px;
            z-index: 2;
        }
        
        .form-input {
            width: 100%;
            padding: 18px 20px 18px 60px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 16px;
            transition: all 0.3s;
            outline: none;
            background: #f8fafc;
            color: #334155;
            font-weight: 500;
        }
        
        .form-input:focus {
            border-color: #8b5cf6;
            background: white;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
        }
        
        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 20px;
            z-index: 2;
            transition: color 0.3s;
        }
        
        .password-toggle:hover {
            color: #6366f1;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-checkbox {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            accent-color: #8b5cf6;
            cursor: pointer;
        }
        
        .remember-label {
            font-size: 15px;
            color: #475569;
            font-weight: 500;
            cursor: pointer;
        }
        
        .forgot-link {
            font-size: 15px;
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            padding: 8px 12px;
            border-radius: 8px;
        }
        
        .forgot-link:hover {
            color: #8b5cf6;
            background: rgba(99, 102, 241, 0.08);
        }
        
        .login-button {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
        }
        
        .login-button:active {
            transform: translateY(0);
        }
        
        .login-button::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }
        
        .login-button:hover::after {
            left: 100%;
        }
        
        .button-icon {
            margin-right: 12px;
            font-size: 20px;
        }
        
        .register-link {
            text-align: center;
            margin-top: 40px;
            font-size: 15px;
            color: #64748b;
            font-weight: 500;
        }
        
        .register-link a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 700;
            margin-left: 6px;
            padding: 6px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .register-link a:hover {
            color: #8b5cf6;
            background: rgba(99, 102, 241, 0.08);
        }
        
        .error-message {
            background: #fef2f2;
            color: #dc2626;
            padding: 16px;
            border-radius: 12px;
            font-size: 15px;
            margin-bottom: 25px;
            border-left: 5px solid #dc2626;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        
        .success-message {
            background: #f0fdf4;
            color: #16a34a;
            padding: 16px;
            border-radius: 12px;
            font-size: 15px;
            margin-bottom: 25px;
            border-left: 5px solid #16a34a;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        
        .error-icon, .success-icon {
            margin-right: 12px;
            font-size: 20px;
        }
        
        /* Floating shapes for left panel */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            z-index: 1;
        }
        
        .shape-1 {
            width: 120px;
            height: 120px;
            top: 10%;
            left: -30px;
        }
        
        .shape-2 {
            width: 80px;
            height: 80px;
            bottom: 15%;
            right: 10%;
        }
        
        .shape-3 {
            width: 60px;
            height: 60px;
            top: 40%;
            right: -20px;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .login-container {
                max-width: 900px;
            }
            
            .login-left, .login-right {
                padding: 50px 40px;
            }
        }
        
        @media (max-width: 900px) {
            .login-container {
                flex-direction: column;
                max-width: 600px;
            }
            
            .login-left, .login-right {
                padding: 50px 40px;
            }
            
            .login-left {
                text-align: center;
            }
            
            .feature {
                justify-content: center;
            }
            
            .system-name {
                font-size: 34px;
            }
        }
        
        @media (max-width: 480px) {
            .login-left, .login-right {
                padding: 40px 30px;
            }
            
            .system-name {
                font-size: 30px;
            }
            
            .login-title {
                font-size: 30px;
            }
            
            .logo-text {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Welcome Section -->
        <div class="login-left">
            <!-- Floating shapes -->
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
            
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-qrcode fa-lg"></i>
                </div>
                <div class="logo-text">QR Attendance</div>
            </div>
            
            <h1 class="system-name">Smart Attendance System</h1>
            <p class="system-description">
                Revolutionize attendance tracking with our intelligent QR system. 
                Experience seamless, secure, and efficient management for modern educational institutions.
            </p>
            
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="feature-text">Lightning-fast QR scanning & marking</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-text">Advanced security with encrypted data</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="feature-text">Real-time analytics & insights dashboard</div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="login-right">
            <h2 class="login-title">Welcome Back</h2>
            <p class="login-subtitle">Sign in to access your smart dashboard</p>
            
            <!-- Display Errors if any -->
            @if($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle error-icon"></i>
                    {{ $errors->first() }}
                </div>
            @endif
            
            @if(session('status'))
                <div class="success-message">
                    <i class="fas fa-check-circle success-icon"></i>
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="Enter your email address" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                        >
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Enter your password" 
                            required
                        >
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            class="remember-checkbox"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label class="remember-label" for="remember">Remember me</label>
                    </div>
                    <div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Forgot Password?
                            </a>
                        @endif
                    </div>
                </div>
                
                <button type="submit" class="login-button">
                    <i class="fas fa-sign-in-alt button-icon"></i>
                    Sign In to Dashboard
                </button>
                
                <div class="register-link">
                    New to Smart Attendance?
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Create Account</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle eye icon
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
        
        // Add focus effects to form inputs
        const formInputs = document.querySelectorAll('.form-input');
        formInputs.forEach(input => {
            // Add focus effect
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            // Remove focus effect
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
        
        // Add animation to form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.animationDelay = `${index * 0.1}s`;
                group.style.animation = 'fadeIn 0.5s ease-out forwards';
                group.style.opacity = '0';
            });
            
            // Add floating animation to shapes
            const shapes = document.querySelectorAll('.floating-shape');
            shapes.forEach((shape, index) => {
                shape.style.animation = `float ${15 + index * 5}s linear infinite`;
            });
        });
    </script>
</body>
</html>