<x-guest-layout>
    @if (session('status'))
        <div class="alert alert-success mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
        </div>
    @endif

    <div class="text-center mb-4">
        <h4 class="fw-bold mb-2">Mot de passe oublié ?</h4>
        <p class="text-muted mb-0">Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label fw-medium">
                <i class="bi bi-envelope me-2"></i>Adresse email
            </label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="votre@email.com">
            @if($errors->has('email'))
                <div class="text-danger mt-1 small">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-auth">
                <i class="bi bi-send me-2"></i>Envoyer le lien de réinitialisation
            </button>
        </div>

        <div class="text-center mt-3">
            <a class="auth-link small" href="{{ route('login') }}">
                <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
            </a>
        </div>
    </form>
</x-guest-layout>
