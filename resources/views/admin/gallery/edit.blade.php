@extends('layouts.admin')

@section('title', 'Modifier l\'image - SAFIR Admin')

@section('content')
    <div class="admin-page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="admin-page-title">Modifier l'image</h1>
                <p class="admin-page-subtitle">Modifiez les informations de cette image</p>
            </div>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour à la galerie
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>Modifier l'image
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Prévisualisation de l'image actuelle -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                             class="img-fluid rounded" 
                             alt="{{ $gallery->title }}"
                             style="max-height: 300px; object-fit: cover;">
                        <p class="text-muted mt-2 small">Image actuelle</p>
                    </div>

                    <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informations de base -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-bold">
                                        <i class="bi bi-type me-2"></i>Titre *
                                    </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           name="title" id="title" value="{{ old('title', $gallery->title) }}" required 
                                           placeholder="Titre de l'image">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label fw-bold">
                                        <i class="bi bi-tag me-2"></i>Catégorie *
                                    </label>
                                    <select class="form-select @error('category') is-invalid @enderror" 
                                            name="category" id="category" required>
                                        <option value="general" {{ old('category', $gallery->category) == 'general' ? 'selected' : '' }}>Général</option>
                                        <option value="services" {{ old('category', $gallery->category) == 'services' ? 'selected' : '' }}>Services</option>
                                        <option value="equipe" {{ old('category', $gallery->category) == 'equipe' ? 'selected' : '' }}>Équipe</option>
                                        <option value="evenements" {{ old('category', $gallery->category) == 'evenements' ? 'selected' : '' }}>Événements</option>
                                        <option value="projets" {{ old('category', $gallery->category) == 'projets' ? 'selected' : '' }}>Projets</option>
                                        <option value="formations" {{ old('category', $gallery->category) == 'formations' ? 'selected' : '' }}>Formations</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-text-paragraph me-2"></i>Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" id="description" rows="3" 
                                      placeholder="Description de l'image">{{ old('description', $gallery->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Options avancées -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label fw-bold">
                                        <i class="bi bi-sort-numeric-up me-2"></i>Ordre d'affichage
                                    </label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           name="sort_order" id="sort_order" value="{{ old('sort_order', $gallery->sort_order) }}" 
                                           min="0" placeholder="0">
                                    <small class="form-text text-muted">Plus le numéro est bas, plus l'image apparaît en premier</small>
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Options</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_featured" 
                                               id="is_featured" value="1" {{ old('is_featured', $gallery->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            <i class="bi bi-star me-2"></i>Image à la une
                                        </label>
                                        <small class="form-text text-muted d-block">Cette image apparaîtra en priorité sur le site</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Remplacement d'image -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">
                                <i class="bi bi-image me-2"></i>Remplacer l'image (optionnel)
                            </label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   name="image" id="image" accept="image/*">
                            <small class="form-text text-muted">Laissez vide pour conserver l'image actuelle. Formats acceptés: JPG, PNG, GIF (max 5MB)</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const currentImage = document.querySelector('.text-center img');
        let originalSrc = currentImage.src;

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file && file.type.startsWith('image/')) {
                // Validation de la taille (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    alert('L\'image est trop grande. Taille maximum : 5MB');
                    e.target.value = '';
                    currentImage.src = originalSrc;
                    return;
                }

                const reader = new FileReader();
                
                reader.onload = function(e) {
                    currentImage.src = e.target.result;
                    currentImage.style.border = '3px solid #28a745';
                    
                    // Ajouter un indicateur de changement
                    let indicator = document.querySelector('.image-changed-indicator');
                    if (!indicator) {
                        indicator = document.createElement('span');
                        indicator.className = 'badge bg-success image-changed-indicator';
                        indicator.innerHTML = '<i class="bi bi-check"></i> Nouvelle image sélectionnée';
                        currentImage.parentNode.appendChild(indicator);
                    }
                };
                
                reader.readAsDataURL(file);
            } else if (file) {
                alert('Veuillez sélectionner un fichier image valide (JPG, PNG, GIF, WEBP)');
                e.target.value = '';
                currentImage.src = originalSrc;
            } else {
                // Reset si aucun fichier sélectionné
                currentImage.src = originalSrc;
                currentImage.style.border = '';
                const indicator = document.querySelector('.image-changed-indicator');
                if (indicator) indicator.remove();
            }
        });

        // Gestion du formulaire
        const form = document.querySelector('form');
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mise à jour...';
            submitBtn.disabled = true;
        });

        // Validation en temps réel
        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');
        
        titleInput.addEventListener('input', function() {
            if (this.value.length > 255) {
                this.classList.add('is-invalid');
                let feedback = this.parentNode.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    this.parentNode.appendChild(feedback);
                }
                feedback.textContent = 'Le titre ne peut pas dépasser 255 caractères.';
            } else {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback');
                if (feedback) feedback.remove();
            }
        });

        descriptionInput.addEventListener('input', function() {
            if (this.value.length > 1000) {
                this.classList.add('is-invalid');
                let feedback = this.parentNode.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    this.parentNode.appendChild(feedback);
                }
                feedback.textContent = 'La description ne peut pas dépasser 1000 caractères.';
            } else {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback');
                if (feedback) feedback.remove();
            }
        });
    });
    </script>
@endsection