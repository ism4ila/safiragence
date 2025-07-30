@extends('layouts.admin')

@section('title', 'Tableau de bord - SAFIR Admin')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Tableau de bord</h1>
            <p class="admin-page-subtitle">Bienvenue dans l'administration SAFIR, {{ Auth::user()->name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-grid-3x3-gap text-primary" style="font-size: 2rem;"></i>
                    <h5 class="card-title mt-3">{{ \App\Models\Service::count() }}</h5>
                    <p class="card-text text-muted">Services</p>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-primary btn-sm">Gérer</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-people text-success" style="font-size: 2rem;"></i>
                    <h5 class="card-title mt-3">{{ \App\Models\Encadreur::count() }}</h5>
                    <p class="card-text text-muted">Encadreurs</p>
                    <a href="{{ route('admin.encadreurs.index') }}" class="btn btn-outline-success btn-sm">Gérer</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-images text-warning" style="font-size: 2rem;"></i>
                    <h5 class="card-title mt-3">{{ \App\Models\GalleryImage::count() }}</h5>
                    <p class="card-text text-muted">Images</p>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-warning btn-sm">Gérer</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-chat-quote text-info" style="font-size: 2rem;"></i>
                    <h5 class="card-title mt-3">{{ \App\Models\Testimonial::count() }}</h5>
                    <p class="card-text text-muted">Témoignages</p>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-info btn-sm">Gérer</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.services.create') }}" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle me-2"></i>Nouveau service
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.encadreurs.create') }}" class="btn btn-success w-100">
                                <i class="bi bi-person-plus me-2"></i>Nouvel encadreur
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.gallery.create') }}" class="btn btn-warning w-100">
                                <i class="bi bi-image me-2"></i>Nouvelle image
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-info w-100">
                                <i class="bi bi-chat-square-quote me-2"></i>Nouveau témoignage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Accès rapide</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary" target="_blank">
                            <i class="bi bi-house me-2"></i>Voir le site
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-gear me-2"></i>Paramètres
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-dark">
                            <i class="bi bi-person me-2"></i>Mon profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
