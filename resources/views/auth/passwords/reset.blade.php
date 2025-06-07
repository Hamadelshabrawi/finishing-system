<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
            --text-color: #5a5c69;
        }
        
        body {
            background-color: var(--secondary-color);
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--text-color);
        }
        
        .reset-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .reset-card {
            width: 100%;
            max-width: 500px;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 1.5rem;
            border-bottom: none;
        }
        
        .card-header h3 {
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .card-body {
            padding: 2rem;
            background-color: white;
        }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.35rem;
            border: 1px solid #d1d3e2;
        }
        
        .form-control:focus {
            border-color: #bac8f3;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-reset {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
        }
        
        .btn-reset:hover {
            background-color: var(--accent-color);
        }
        
        .input-group-text {
            background-color: #f8f9fc;
            border: 1px solid #d1d3e2;
        }
        
        .login-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .login-link:hover {
            text-decoration: underline;
        }
        
        .password-strength {
            margin-top: 0.25rem;
            font-size: 0.875rem;
        }
        
        .password-strength.weak {
            color: #e74a3b;
        }
        
        .password-strength.medium {
            color: #f6c23e;
        }
        
        .password-strength.strong {
            color: #1cc88a;
        }
        
        .instructions {
            color: #858796;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="card reset-card">
            <div class="card-header">
                <h3><i class="fas fa-key me-2"></i>Reset Password</h3>
            </div>
            <div class="card-body">
                <p class="instructions">Enter your email and a new password to reset your account.</p>
                
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-4">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                                   placeholder="Enter your email address">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">{{ __('New Password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password"
                                   placeholder="Create a new password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div id="password-strength" class="password-strength"></div>
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" required autocomplete="new-password"
                                   placeholder="Confirm your new password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-reset mb-3">
                        <i class="fas fa-sync-alt me-2"></i>{{ __('Reset Password') }}
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="login-link">
                            <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Login') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Password Strength Indicator -->
    <script>
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthIndicator = document.getElementById('password-strength');
            
            if (password.length === 0) {
                strengthIndicator.textContent = '';
                strengthIndicator.className = 'password-strength';
                return;
            }
            
            // Simple password strength check
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            let strengthText = '';
            let strengthClass = '';
            
            if (strength <= 2) {
                strengthText = 'Weak password';
                strengthClass = 'weak';
            } else if (strength <= 4) {
                strengthText = 'Medium strength';
                strengthClass = 'medium';
            } else {
                strengthText = 'Strong password';
                strengthClass = 'strong';
            }
            
            strengthIndicator.textContent = strengthText;
            strengthIndicator.className = 'password-strength ' + strengthClass;
        });
    </script>
</body>
</html>