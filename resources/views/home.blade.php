@extends('layouts.app')

@section('title', 'SAFIR - Agence de voyages et de tourisme')

@section('content')
    <!-- Section Héro -->
    <section id="hero">
        <div class="container">
            <h1>L'accomplissement parfait de votre pèlerinage reste notre priorité !</h1>
            <p>Voyages, tourisme, billetterie et organisation de pèlerinage. Votre satisfaction est notre mission.</p>
            <a href="{{ route('contact') }}" class="btn">Réserver ou demander un devis</a>
        </div>
    </section>

    <!-- Section Services -->
    <section class="container my-5">
        <h2 class="section-title">Nos Services</h2>
        <p class="text-center mb-5">Découvrez comment nous pouvons vous aider à réaliser vos projets de voyage.</p>
        
        <div class="row g-4 justify-content-center">
            @foreach ($featuredServices as $service)
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="service-card">
                        <div class="card-body">
                            <div class="card-icon"><i class="{{ $service->icon }}"></i></div>
                            <h5 class="card-title">{{ $service->title }}</h5>
                            <p class="card-text">{{ $service->short_description }}</p>
                            <a href="{{ route('services.show', $service) }}" class="btn">En savoir plus</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section Galerie -->
    @if($galleryImages->count() > 0)
    <section class="gallery-section py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Notre Galerie</h2>
                    <p class="text-muted">Découvrez nos plus beaux moments en images</p>
                </div>
            </div>
            
            <!-- Carrousel Bootstrap -->
            <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach($galleryImages as $index => $image)
                        <button type="button" data-bs-target="#galleryCarousel" data-bs-slide-to="{{ $index }}" 
                                class="{{ $index === 0 ? 'active' : '' }}" 
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                                aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                
                <div class="carousel-inner">
                    @foreach($galleryImages as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row g-3">
                                <!-- Image principale -->
                                <div class="col-md-8">
                                    <div class="gallery-main-image">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             class="d-block w-100" 
                                             alt="{{ $image->title }}"
                                             style="height: 400px; object-fit: cover; border-radius: 15px;">
                                        <div class="gallery-overlay">
                                            <div class="gallery-info">
                                                <h5 class="text-white fw-bold">{{ $image->title }}</h5>
                                                @if($image->description)
                                                    <p class="text-white-50 mb-0">{{ Str::limit($image->description, 100) }}</p>
                                                @endif
                                                <span class="badge bg-primary mt-2">{{ ucfirst($image->category) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Miniatures des autres images -->
                                <div class="col-md-4">
                                    <div class="gallery-thumbnails">
                                        @php
                                            $otherImages = $galleryImages->slice($index + 1, 3);
                                            if($otherImages->count() < 3) {
                                                $otherImages = $otherImages->concat($galleryImages->take(3 - $otherImages->count()));
                                            }
                                        @endphp
                                        
                                        @foreach($otherImages as $thumbIndex => $thumbImage)
                                            <div class="gallery-thumb mb-3">
                                                <img src="{{ asset('storage/' . $thumbImage->image_path) }}" 
                                                     class="img-fluid" 
                                                     alt="{{ $thumbImage->title }}"
                                                     style="height: 120px; width: 100%; object-fit: cover; border-radius: 10px; cursor: pointer;"
                                                     onclick="showImageModal('{{ asset('storage/' . $thumbImage->image_path) }}', '{{ $thumbImage->title }}', '{{ $thumbImage->description }}')">
                                                <div class="thumb-overlay">
                                                    <small class="text-white fw-bold">{{ $thumbImage->title }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
            
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary">
                    <i class="bi bi-images me-2"></i>Voir toute la galerie
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Section Témoignages -->
    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-bold">Témoignages</h2>
            </div>
        </div>
        <div class="row">
            @foreach ($testimonials as $testimonial)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">"{{ $testimonial->content }}"</p>
                            <footer class="blockquote-footer">{{ $testimonial->client_name }}</footer>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal pour agrandir les images -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 text-white" 
                            data-bs-dismiss="modal" aria-label="Close" style="z-index: 1050;"></button>
                    <img id="modalImage" src="" class="img-fluid w-100" alt="">
                    <div class="modal-caption p-3 bg-dark text-white">
                        <h5 id="modalTitle" class="mb-1"></h5>
                        <p id="modalDescription" class="mb-0 text-white-50"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .gallery-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .gallery-main-image {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
    }
    
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.7));
        padding: 2rem;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }
    
    .gallery-main-image:hover .gallery-overlay {
        transform: translateY(0);
    }
    
    .gallery-thumb {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    
    .gallery-thumb:hover {
        transform: scale(1.05);
    }
    
    .thumb-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        padding: 0.5rem;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }
    
    .gallery-thumb:hover .thumb-overlay {
        transform: translateY(0);
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
    }
    
    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    </style>

    <script>
    function showImageModal(imageSrc, title, description) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalDescription').textContent = description || '';
        
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }
    
    // Auto-play du carrousel
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.querySelector('#galleryCarousel');
        if (carousel) {
            const bsCarousel = new bootstrap.Carousel(carousel, {
                interval: 5000,
                ride: 'carousel'
            });
        }
    });
    </script>
@endsection
