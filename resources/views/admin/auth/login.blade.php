<!DOCTYPE html>
<html lang="{{ lang() }}" dir="{{ lang() === 'ar' ? 'rtl' : 'ltr' }}" data-textdirection="{{ lang() === 'ar' ? 'rtl' : 'ltr' }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="{{ $data['name_' . lang()] }} - Admin Login">
    <meta name="author" content="{{ $data['name_' . lang()] }}">
    <title>{{ __('site.login') }}</title>
    
    <link rel="apple-touch-icon" href="{{ asset('storage/images/settings/fav_icon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/images/settings/fav_icon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    
    <!-- Custom Login CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/login.css') }}?v={{ time() }}">
    @if(lang() === 'ar')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/login-rtl.css') }}?v={{ time() }}">
    @endif
</head>
<body>
    <!-- Top Controls (Language & Theme Toggle) -->
    <div class="top-controls">
        <!-- Language Toggle -->
        <div class="language-toggle" id="languageToggle">
            <button class="lang-btn {{ lang() === 'en' ? 'active' : '' }}" data-lang="en" type="button">
                <span class="flag-icon">🇬🇧</span>
                <span class="lang-text">English</span>
            </button>
            <button class="lang-btn {{ lang() === 'ar' ? 'active' : '' }}" data-lang="ar" type="button">
                <span class="flag-icon">🇸🇦</span>
                <span class="lang-text">العربية</span>
            </button>
        </div>
        
        <!-- Theme Toggle -->
        <button class="theme-toggle" id="themeToggle" type="button">
            <i class="fas fa-moon theme-toggle-icon" id="themeIcon"></i>
            <span class="theme-toggle-text" id="themeText" data-dark-text="{{ __('site.dark_mode') }}" data-light-text="{{ __('site.light_mode') }}">{{ __('site.dark_mode') }}</span>
        </button>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <!-- Left Side: Login Form -->
        <div class="login-form-section">
            <!-- Logo -->
            <div class="logo-container">
                <img src="{{ $data['logo'] }}" alt="{{ $data['name_' . lang()] }}">
            </div>
            
            <!-- Login Header -->
            <div class="login-header">
                <h1 class="login-title">{{ __('site.login') }}</h1>
                <p class="login-subtitle">{{ __('site.hi') }} {{ $data['name_' . lang()] }}</p>
            </div>
            
            <!-- Login Form -->
            <form class="login-form form-horizontal" action="{{ route('admin.login') }}" method="POST">
                @csrf
                <input type="hidden" name="device_id" id="device_id">
                <input type="hidden" name="selected_lang" id="selected_lang" value="{{ lang() }}">
                
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('site.email') }}</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="{{ __('site.email') }}"
                            autocomplete="email"
                            required
                        >
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>
                
                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('site.password') }}</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="{{ __('site.password') }}"
                            autocomplete="current-password"
                            required
                        >
                        <i class="fas fa-lock input-icon"></i>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                </div>
                
                <!-- Remember Me -->
                <div class="remember-me">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="remember" value="1">
                        <span class="checkbox-mark"></span>
                    </label>
                    <span class="checkbox-label">{{ __('site.remember') }}</span>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-login submit_button" data-text="{{ __('site.login') }}">
                    {{ __('site.login') }}
                </button>
            </form>
        </div>
        
        <!-- Right Side: Branding -->
        <div class="branding-section">
            <div class="branding-content">
                <h2 class="branding-title">{{ __('site.welcome_back') }}</h2>
                <p class="branding-description">{{ __('site.login_description') }}</p>
                
                <!-- Features List -->
                <ul class="features-list">
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <div class="feature-title">{{ __('site.secure_access') }}</div>
                            <div class="feature-description">{{ __('site.secure_access_desc') }}</div>
                        </div>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="feature-text">
                            <div class="feature-title">{{ __('site.fast_performance') }}</div>
                            <div class="feature-description">{{ __('site.fast_performance_desc') }}</div>
                        </div>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-text">
                            <div class="feature-title">{{ __('site.analytics') }}</div>
                            <div class="feature-description">{{ __('site.analytics_desc') }}</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/login.js') }}"></script>
    
    <!-- Firebase -->
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging-compat.js"></script>
    <script>
        @if(config('fcm.api_key'))
        const firebaseConfig = {
            apiKey: "{{ config('fcm.api_key') }}",
            authDomain: "{{ config('fcm.auth_domain') }}",
            projectId: "{{ config('fcm.project_id') }}",
            storageBucket: "{{ config('fcm.storage_bucket') }}",
            messagingSenderId: "{{ config('fcm.messaging_sender_id') }}",
            appId: "{{ config('fcm.app_id') }}",
            measurementId: "{{ config('fcm.measurement_id') }}",
            vapidKey: "{{ config('fcm.vapid_key') }}"
        };
        
        if (typeof FirebaseManager !== 'undefined') {
            FirebaseManager.init(firebaseConfig);
        }
        @endif
    </script>
</body>
</html>
