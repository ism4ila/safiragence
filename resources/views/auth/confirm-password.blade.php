<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold mb-2">Confirmation de sécurité</h4>
        <p class="text-muted mb-0">Veuillez confirmer votre mot de passe pour accéder à cette zone sécurisée.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label fw-medium">
                <i class="bi bi-shield-lock me-2"></i>Mot de passe
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

        <div class="d-grid">
            <button type="submit" class="btn btn-auth">
                <i class="bi bi-check-circle me-2"></i>Confirmer
            </button>
        </div>
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
