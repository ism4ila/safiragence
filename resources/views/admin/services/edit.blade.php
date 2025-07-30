@extends('layouts.admin')

@section('title', 'Modifier le Service - SAFIR Admin')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Modifier le Service</h1>
            <p class="admin-page-subtitle">Modifiez les informations du service "{{ $service->title }}"</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Informations du Service</h5>
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

            <form action="{{ route('admin.services.update', $service) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre *</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $service->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Description courte *</label>
                            <textarea name="short_description" id="short_description" rows="3" 
                                      class="form-control @error('short_description') is-invalid @enderror" 
                                      placeholder="Résumé du service en quelques mots" required>{{ old('short_description', $service->short_description) }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description complète *</label>
                            <textarea name="description" id="description" rows="6" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Description détaillée du service" required>{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label">Caractéristiques</label>
                            <textarea name="features" id="features" rows="4" 
                                      class="form-control @error('features') is-invalid @enderror" 
                                      placeholder="Liste des fonctionnalités du service (une par ligne)">{{ old('features', $service->features) }}</textarea>
                            @error('features')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="price" class="form-label">Prix (FCFA)</label>
                            <input type="number" name="price" id="price" min="0" step="0.01" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price', $service->price) }}" placeholder="Laisser vide pour 'Sur devis'">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Icône Bootstrap</label>
                            <input type="text" name="icon" id="icon" 
                                   class="form-control @error('icon') is-invalid @enderror" 
                                   value="{{ old('icon', $service->icon ?? 'bi bi-grid-3x3-gap') }}" 
                                   placeholder="bi bi-grid-3x3-gap">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Utilisez les classes Bootstrap Icons (ex: bi bi-heart)</div>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Ordre d'affichage</label>
                            <input type="number" name="sort_order" id="sort_order" min="0" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   value="{{ old('sort_order', $service->sort_order) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" 
                                       value="1" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Service en vedette
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                       value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Service actif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
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