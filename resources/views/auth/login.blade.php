<x-guest-layout>
    @if (session('status'))
        <div class="alert alert-success mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf
        
        <div class="text-center mb-4">
            <h4 class="fw-bold mb-2">Connexion Administrateur</h4>
            <p class="text-muted mb-0">Connectez-vous pour accéder au panneau d'administration</p>
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-medium">
                <i class="bi bi-envelope me-2"></i>Adresse email
            </label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="votre@email.com">
            @if($errors->has('email'))
                <div class="text-danger mt-1 small">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium">
                <i class="bi bi-lock me-2"></i>Mot de passe
            </label>
            <div class="position-relative">
                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="••••••••">
                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted" onclick="togglePassword()">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>
            @if($errors->has('password'))
                <div class="text-danger mt-1 small">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">
                    Se souvenir de moi
                </label>
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-auth">
                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
            </button>
        </div>

        @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a class="auth-link small" href="{{ route('password.request') }}">
                    <i class="bi bi-question-circle me-1"></i>Mot de passe oublié ?
                </a>
            </div>
        @endif
    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }

    </script>
</x-guest-layout>
