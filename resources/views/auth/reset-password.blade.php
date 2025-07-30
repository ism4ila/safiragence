<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold mb-2">Réinitialiser le mot de passe</h4>
        <p class="text-muted mb-0">Entrez votre nouveau mot de passe ci-dessous</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-medium">
                <i class="bi bi-envelope me-2"></i>Adresse email
            </label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" readonly>
            @if($errors->has('email'))
                <div class="text-danger mt-1 small">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium">
                <i class="bi bi-lock me-2"></i>Nouveau mot de passe
            </label>
            <div class="position-relative">
                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="••••••••">
                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted" onclick="togglePassword('password', 'toggleIcon1')">
                    <i class="bi bi-eye" id="toggleIcon1"></i>
                </button>
            </div>
            @if($errors->has('password'))
                <div class="text-danger mt-1 small">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-medium">
                <i class="bi bi-lock-fill me-2"></i>Confirmer le mot de passe
            </label>
            <div class="position-relative">
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                    <i class="bi bi-eye" id="toggleIcon2"></i>
                </button>
            </div>
            @if($errors->has('password_confirmation'))
                <div class="text-danger mt-1 small">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-auth">
                <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser le mot de passe
            </button>
        </div>

        <div class="text-center mt-3">
            <a class="auth-link small" href="{{ route('login') }}">
                <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
            </a>
        </div>
    </form>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
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
