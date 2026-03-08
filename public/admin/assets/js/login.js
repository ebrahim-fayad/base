/**
 * ========================================
 * LOGIN PAGE JAVASCRIPT
 * ========================================
 */

(function() {
    'use strict';

    // ========================================
    // LANGUAGE TOGGLE FUNCTIONALITY
    // ========================================
    const LanguageManager = {
        container: null,
        buttons: null,
        selectedLangInput: null,

        init() {
            this.container = document.getElementById('languageToggle');
            this.selectedLangInput = document.getElementById('selected_lang');
            
            if (!this.container) return;
            
            this.buttons = this.container.querySelectorAll('.lang-btn');
            this.setActiveLanguage();
            this.bindEvents();
        },

        bindEvents() {
            this.buttons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const lang = e.currentTarget.getAttribute('data-lang');
                    this.changeLanguage(lang);
                });
            });
        },

        setActiveLanguage() {
            const currentLang = document.documentElement.getAttribute('lang') || 'ar';
            this.buttons.forEach(btn => {
                if (btn.getAttribute('data-lang') === currentLang) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        },

        changeLanguage(lang) {
            // Prevent if already active
            const currentLang = document.documentElement.getAttribute('lang');
            if (currentLang === lang) return;

            // Update hidden input
            if (this.selectedLangInput) {
                this.selectedLangInput.value = lang;
            }

            // Save to localStorage
            localStorage.setItem('preferred_lang', lang);

            // Update active button
            this.buttons.forEach(btn => {
                if (btn.getAttribute('data-lang') === lang) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Show loading overlay
            this.showLoadingOverlay();

            // Check if jQuery is available
            if (typeof $ === 'undefined' || typeof $.ajax === 'undefined') {
                console.error('jQuery is not loaded');
                this.hideLoadingOverlay();
                return;
            }

            // Change language via AJAX and reload page
            $.ajax({
                url: `/admin/lang/${lang}`,
                method: 'GET',
                success: (response) => {
                    // Reload page to apply new language
                    window.location.reload();
                },
                error: (xhr) => {
                    // Hide loading overlay on error
                    this.hideLoadingOverlay();
                    console.error('Language change error:', xhr);
                    
                    // Still reload on error to apply session change
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            });
        },

        showLoadingOverlay() {
            // Add class to body to prevent any movement
            document.body.classList.add('language-changing');
            document.body.style.overflow = 'hidden';
            
            // Create overlay if it doesn't exist
            let overlay = document.getElementById('languageOverlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'languageOverlay';
                overlay.className = 'language-overlay';
                overlay.innerHTML = '<div class="language-loader"></div>';
                document.body.appendChild(overlay);
            }
            overlay.style.display = 'flex';
        },

        hideLoadingOverlay() {
            // Remove class and re-enable scroll
            document.body.classList.remove('language-changing');
            document.body.style.overflow = '';
            
            const overlay = document.getElementById('languageOverlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        }
    };

    // ========================================
    // THEME TOGGLE FUNCTIONALITY
    // ========================================
    const ThemeManager = {
        toggle: document.getElementById('themeToggle'),
        icon: document.getElementById('themeIcon'),
        text: document.getElementById('themeText'),
        html: document.documentElement,

        init() {
            // Load saved theme or default to light
            const savedTheme = localStorage.getItem('theme') || 'light';
            this.setTheme(savedTheme);
            this.bindEvents();
        },

        bindEvents() {
            if (this.toggle) {
                this.toggle.addEventListener('click', () => this.toggleTheme());
            }
        },

        toggleTheme() {
            const currentTheme = this.html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            this.setTheme(newTheme);
        },

        setTheme(theme) {
            this.html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            this.updateButton(theme);
        },

        updateButton(theme) {
            if (!this.icon || !this.text) return;

            if (theme === 'dark') {
                this.icon.classList.remove('fa-moon');
                this.icon.classList.add('fa-sun');
                this.text.textContent = this.text.getAttribute('data-light-text') || 'Light Mode';
            } else {
                this.icon.classList.remove('fa-sun');
                this.icon.classList.add('fa-moon');
                this.text.textContent = this.text.getAttribute('data-dark-text') || 'Dark Mode';
            }
        }
    };

    // ========================================
    // PASSWORD TOGGLE FUNCTIONALITY
    // ========================================
    const PasswordToggle = {
        toggle: document.getElementById('togglePassword'),
        input: document.getElementById('password'),

        init() {
            this.bindEvents();
        },

        bindEvents() {
            if (this.toggle && this.input) {
                this.toggle.addEventListener('click', () => this.toggleVisibility());
            }
        },

        toggleVisibility() {
            const type = this.input.getAttribute('type') === 'password' ? 'text' : 'password';
            this.input.setAttribute('type', type);
            
            this.toggle.classList.toggle('fa-eye');
            this.toggle.classList.toggle('fa-eye-slash');
        }
    };

    // ========================================
    // FORM SUBMISSION HANDLER
    // ========================================
    const FormHandler = {
        form: null,
        submitButton: null,

        init() {
            this.form = document.querySelector('.form-horizontal');
            this.submitButton = document.querySelector('.submit_button');
            
            if (this.form) {
                this.bindEvents();
            }
        },

        bindEvents() {
            $(this.form).on('submit', (e) => this.handleSubmit(e));
        },

        handleSubmit(e) {
            e.preventDefault();
            const url = $(this.form).attr('action');
            
            $.ajax({
                url: url,
                method: 'post',
                data: new FormData(this.form),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: () => this.beforeSend(),
                success: (response) => this.handleSuccess(response),
                error: (xhr) => this.handleError(xhr)
            });
        },

        beforeSend() {
            $(this.submitButton)
                .html('<span class="spinner"></span>')
                .attr('disabled', true);
        },

        handleSuccess(response) {
            this.clearErrors();
            
            if (response.status === 'login') {
                toastr.success(response.message);
                setTimeout(() => {
                    window.location.replace(response.url);
                }, 1000);
            } else {
                this.resetButton();
                this.showFieldError('password', response.message);
            }
        },

        handleError(xhr) {
            this.resetButton();
            this.clearErrors();

            if (xhr.responseJSON && xhr.responseJSON.errors) {
                $.each(xhr.responseJSON.errors, (key, value) => {
                    this.showFieldError(key, value);
                });
            }
        },

        showFieldError(fieldName, message) {
            const input = $(`.form-horizontal input[name="${fieldName}"]`);
            input.addClass('border-danger');
            input.after(`<span class="text-danger">${message}</span>`);
        },

        clearErrors() {
            $('.text-danger').remove();
            $('.form-horizontal input').removeClass('border-danger');
        },

        resetButton() {
            const buttonText = $(this.submitButton).data('original-text') || 
                             $(this.submitButton).attr('data-text') || 
                             'Login';
            
            $(this.submitButton)
                .html(buttonText)
                .attr('disabled', false);
        }
    };

    // ========================================
    // TOASTR CONFIGURATION
    // ========================================
    const ToastrConfig = {
        init() {
            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    closeButton: true,
                    newestOnTop: false,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    showMethod: 'slideDown',
                    hideMethod: 'slideUp',
                    timeOut: 2000,
                    extendedTimeOut: 1000,
                    showEasing: 'swing',
                    hideEasing: 'linear',
                    showDuration: 300,
                    hideDuration: 1000
                };
            }
        }
    };

    // ========================================
    // FIREBASE CONFIGURATION
    // ========================================
    const FirebaseManager = {
        config: null,
        messaging: null,

        init(config) {
            if (!config || !config.apiKey) return;
            
            this.config = config;
            this.initializeFirebase();
        },

        initializeFirebase() {
            try {
                firebase.initializeApp(this.config);
                this.messaging = firebase.messaging();
                this.requestPermission();
            } catch (error) {
                console.error('Firebase initialization error:', error);
            }
        },

        requestPermission() {
            Notification.requestPermission().then((permission) => {
                if (permission === 'granted') {
                    this.getToken();
                }
            }).catch((error) => {
                console.error('Notification permission error:', error);
            });
        },

        getToken() {
            const vapidKey = this.config.vapidKey;
            
            this.messaging.getToken({ vapidKey })
                .then((token) => {
                    const deviceIdInput = document.getElementById('device_id');
                    if (deviceIdInput && token) {
                        deviceIdInput.value = token;
                    }
                })
                .catch((error) => {
                    console.error('Error getting token:', error);
                });
        }
    };

    // ========================================
    // INPUT ENHANCEMENTS
    // ========================================
    const InputEnhancements = {
        init() {
            this.addFloatingLabels();
            this.addAutocompleteAttributes();
        },

        addFloatingLabels() {
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', () => {
                    if (!input.value) {
                        input.parentElement.classList.remove('focused');
                    }
                });
            });
        },

        addAutocompleteAttributes() {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            if (emailInput) emailInput.setAttribute('autocomplete', 'email');
            if (passwordInput) passwordInput.setAttribute('autocomplete', 'current-password');
        }
    };

    // ========================================
    // KEYBOARD SHORTCUTS
    // ========================================
    const KeyboardShortcuts = {
        init() {
            document.addEventListener('keydown', (e) => {
                // Alt + T: Toggle Theme
                if (e.altKey && e.key === 't') {
                    e.preventDefault();
                    ThemeManager.toggleTheme();
                }
            });
        }
    };

    // ========================================
    // INITIALIZE ALL MODULES
    // ========================================
    document.addEventListener('DOMContentLoaded', () => {
        console.log('Initializing login modules...');
        
        try {
            LanguageManager.init();
            console.log('✓ LanguageManager initialized');
        } catch (e) {
            console.error('✗ LanguageManager error:', e);
        }
        
        try {
            ThemeManager.init();
            console.log('✓ ThemeManager initialized');
        } catch (e) {
            console.error('✗ ThemeManager error:', e);
        }
        
        try {
            PasswordToggle.init();
            console.log('✓ PasswordToggle initialized');
        } catch (e) {
            console.error('✗ PasswordToggle error:', e);
        }
        
        try {
            ToastrConfig.init();
            console.log('✓ ToastrConfig initialized');
        } catch (e) {
            console.error('✗ ToastrConfig error:', e);
        }
        
        try {
            InputEnhancements.init();
            console.log('✓ InputEnhancements initialized');
        } catch (e) {
            console.error('✗ InputEnhancements error:', e);
        }
        
        try {
            KeyboardShortcuts.init();
            console.log('✓ KeyboardShortcuts initialized');
        } catch (e) {
            console.error('✗ KeyboardShortcuts error:', e);
        }
        
        // Initialize form handler after jQuery is ready
        if (typeof $ !== 'undefined') {
            $(document).ready(() => {
                try {
                    FormHandler.init();
                    console.log('✓ FormHandler initialized');
                } catch (e) {
                    console.error('✗ FormHandler error:', e);
                }
            });
        } else {
            console.error('✗ jQuery not loaded');
        }
    });

    // ========================================
    // EXPOSE FIREBASE MANAGER GLOBALLY
    // ========================================
    window.FirebaseManager = FirebaseManager;

})();
