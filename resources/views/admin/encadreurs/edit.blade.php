@extends('layouts.admin')

@section('title', 'Modifier l\'Encadreur - SAFIR Admin')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Modifier l'Encadreur</h1>
            <p class="admin-page-subtitle">Modifiez les informations de "{{ $encadreur->full_name }}"</p>
        </div>
        <a href="{{ route('admin.encadreurs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Informations de l'Encadreur</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.encadreurs.update', $encadreur) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nom complet *</label>
                            <input type="text" name="full_name" id="full_name" class="form-control @error('full_name') is-invalid @enderror" 
                                   value="{{ old('full_name', $encadreur->full_name) }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_1" class="form-label">Téléphone *</label>
                            <input type="tel" name="phone_1" id="phone_1" class="form-control @error('phone_1') is-invalid @enderror" 
                                   value="{{ old('phone_1', $encadreur->phone_1) }}" placeholder="Ex: +221 77 123 45 67" required>
                            @error('phone_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $encadreur->email) }}" placeholder="exemple@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="specialties" class="form-label">Spécialités</label>
                            <textarea name="specialties" id="specialties" rows="3" 
                                      class="form-control @error('specialties') is-invalid @enderror" 
                                      placeholder="Décrivez les spécialités de l'encadreur">{{ old('specialties', $encadreur->specialties) }}</textarea>
                            @error('specialties')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" rows="4" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      placeholder="Notes additionnelles sur l'encadreur">{{ old('notes', $encadreur->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                       value="1" {{ old('is_active', $encadreur->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Encadreur actif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.encadreurs.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection