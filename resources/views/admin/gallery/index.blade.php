@extends('layouts.admin')

@section('title', 'Galerie - SAFIR Admin')

@section('content')
    <div class="admin-page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="admin-page-title">Galerie</h1>
                <p class="admin-page-subtitle">Gérez les images de votre galerie</p>
            </div>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Ajouter des images
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-images me-2"></i>Images de la galerie 
                        <span class="badge bg-primary ms-2">{{ $images->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($images->count() > 0)
                        <div class="row g-4">
                            @foreach($images as $image)
                                <div class="col-md-4 col-lg-3">
                                    <div class="card gallery-card h-100">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                 class="card-img-top gallery-thumbnail" 
                                                 alt="{{ $image->title }}"
                                                 style="height: 200px; object-fit: cover;">
                                            
                                            @if($image->is_featured)
                                                <span class="position-absolute top-0 end-0 m-2">
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-star-fill"></i> À la une
                                                    </span>
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $image->title }}</h6>
                                            <p class="card-text text-muted small">
                                                {{ Str::limit($image->description, 60) }}
                                            </p>
                                            <div class="mb-2">
                                                <span class="badge bg-secondary">{{ $image->category }}</span>
                                                <small class="text-muted ms-2">Ordre: {{ $image->sort_order }}</small>
                                            </div>
                                        </div>
                                        
                                        <div class="card-footer bg-transparent">
                                            <div class="btn-group w-100" role="group">
                                                <a href="#" class="btn btn-outline-info btn-sm" 
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#viewModal{{ $image->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.gallery.edit', $image) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.gallery.destroy', $image) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal de visualisation -->
                                <div class="modal fade" id="viewModal{{ $image->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $image->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                     class="img-fluid mb-3" 
                                                     alt="{{ $image->title }}">
                                                
                                                @if($image->description)
                                                    <p class="text-muted">{{ $image->description }}</p>
                                                @endif
                                                
                                                <div class="row text-start">
                                                    <div class="col-md-6">
                                                        <strong>Catégorie:</strong> {{ $image->category }}<br>
                                                        <strong>Ordre d'affichage:</strong> {{ $image->sort_order }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>À la une:</strong> {{ $image->is_featured ? 'Oui' : 'Non' }}<br>
                                                        <strong>Ajoutée le:</strong> {{ $image->created_at->format('d/m/Y à H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-images text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 text-muted">Aucune image dans la galerie</h4>
                            <p class="text-muted">Commencez par ajouter des images à votre galerie.</p>
                            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Ajouter des images
            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
    .gallery-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .gallery-thumbnail {
        transition: transform 0.3s;
    }
    
    .gallery-card:hover .gallery-thumbnail {
        transform: scale(1.05);
    }
    </style>
@endsection