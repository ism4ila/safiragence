@extends('layouts.admin')

@section('title', 'Ajouter des images - SAFIR Admin')

@section('content')
    <div class="admin-page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="admin-page-title">Ajouter des images</h1>
                <p class="admin-page-subtitle">Ajoutez plusieurs images à votre galerie</p>
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
                        <i class="bi bi-cloud-upload me-2"></i>Upload d'images
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" id="galleryForm">
                        @csrf
                        
                        <!-- Upload d'images -->
                        <div class="mb-4">
                            <label for="images" class="form-label fw-bold">
                                <i class="bi bi-images me-2"></i>Sélectionner les images *
                            </label>
                            <div class="upload-area" id="uploadArea">
                                <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                       name="images[]" id="images" multiple accept="image/*" required>
                                <div class="upload-text">
                                    <i class="bi bi-cloud-upload" style="font-size: 3rem; color: #6c757d;"></i>
                                    <p class="mt-2 mb-1"><strong>Cliquez pour sélectionner</strong> ou glissez-déposez vos images</p>
                                    <small class="text-muted">Formats acceptés: JPG, PNG, GIF (max 5MB par image)</small>
                                </div>
                            </div>
                            @error('images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Prévisualisation -->
                        <div id="imagePreview" class="mb-4" style="display: none;">
                            <h6 class="fw-bold">Prévisualisation des images sélectionnées:</h6>
                            <div id="previewContainer" class="row g-3"></div>
                        </div>

                        <!-- Informations générales -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-bold">
                                        <i class="bi bi-type me-2"></i>Titre principal *
                                    </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           name="title" id="title" value="{{ old('title') }}" required 
                                           placeholder="Titre pour les images">
                                    <small class="form-text text-muted">Un numéro sera ajouté automatiquement pour chaque image supplémentaire</small>
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
                                        <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>Général</option>
                                        <option value="services" {{ old('category') == 'services' ? 'selected' : '' }}>Services</option>
                                        <option value="equipe" {{ old('category') == 'equipe' ? 'selected' : '' }}>Équipe</option>
                                        <option value="evenements" {{ old('category') == 'evenements' ? 'selected' : '' }}>Événements</option>
                                        <option value="projets" {{ old('category') == 'projets' ? 'selected' : '' }}>Projets</option>
                                        <option value="formations" {{ old('category') == 'formations' ? 'selected' : '' }}>Formations</option>
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
                                      placeholder="Description commune pour toutes les images">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_featured" 
                                       id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_featured">
                                    <i class="bi bi-star me-2"></i>Mettre la première image à la une
                                </label>
                                <small class="form-text text-muted d-block">Cette image apparaîtra en priorité sur le site</small>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-circle me-2"></i>Ajouter les images
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        position: relative;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .upload-area:hover {
        border-color: #0d6efd;
        background: #e7f3ff;
    }
    
    .upload-area.dragover {
        border-color: #0d6efd;
        background: #e7f3ff;
    }
    
    .upload-area input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .preview-image {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .preview-image img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }
    
    .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('images');
        const previewDiv = document.getElementById('imagePreview');
        const previewContainer = document.getElementById('previewContainer');
        const form = document.getElementById('galleryForm');
        let selectedFiles = [];

        // Drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            const files = Array.from(e.dataTransfer.files);
            handleFiles(files);
        });

        // File input change
        fileInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            handleFiles(files);
        });

        function handleFiles(files) {
            // Filtrer seulement les images
            const imageFiles = files.filter(file => file.type.startsWith('image/'));
            
            if (imageFiles.length === 0) {
                alert('Veuillez sélectionner des fichiers image valides.');
                return;
            }

            selectedFiles = imageFiles;
            updatePreview();
        }

        function updatePreview() {
            if (selectedFiles.length === 0) {
                previewDiv.style.display = 'none';
                return;
            }

            previewDiv.style.display = 'block';
            previewContainer.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 col-sm-4 col-6';
                    col.innerHTML = `
                        <div class="preview-image">
                            <img src="${e.target.result}" alt="Preview ${index + 1}">
                            <button type="button" class="remove-image" onclick="removeImage(${index})">
                                <i class="bi bi-x"></i>
                            </button>
                            <div class="p-2 bg-light">
                                <small class="text-muted">${file.name}</small>
                            </div>
                        </div>
                    `;
                    previewContainer.appendChild(col);
                };
                reader.readAsDataURL(file);
            });

            // Mettre à jour l'input file
            updateFileInput();
        }

        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
        }

        window.removeImage = function(index) {
            selectedFiles.splice(index, 1);
            updatePreview();
        };

        // Animation du bouton submit
        form.addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Upload en cours...';
            submitBtn.disabled = true;
        });
    });
    </script>
@endsection