<?php  
$pageTitle = "Galerie Photos - Agence SAFIR"; 
include('includes/header.php');  
?>

<!-- Hero Section -->
<section id="gallery-hero" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-4">Notre Galerie</h1>
                <p class="lead mb-4">Découvrez en images les pèlerinages HADJ & OUMRA que nous avons organisés, ainsi que quelques-unes des destinations de rêve que nous proposons.</p>
                <div class="gallery-stats d-flex justify-content-center flex-wrap">
                    <div class="stat-item mx-3 mb-3">
                        <i class="bi bi-camera-fill"></i>
                        <strong>500+</strong>
                        <span>Photos</span>
                    </div>
                    <div class="stat-item mx-3 mb-3">
                        <i class="bi bi-geo-alt-fill"></i>
                        <strong>25+</strong>
                        <span>Destinations</span>
                    </div>
                    <div class="stat-item mx-3 mb-3">
                        <i class="bi bi-people-fill"></i>
                        <strong>1000+</strong>
                        <span>Pèlerins</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter Tabs -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills justify-content-center gallery-filters" id="gallery-filters" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                            <i class="bi bi-grid-3x3-gap-fill me-2"></i>Toutes les photos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="hadj-tab" data-bs-toggle="pill" data-bs-target="#hadj" type="button" role="tab" aria-controls="hadj" aria-selected="false">
                            <i class="bi bi-moon-stars-fill me-2"></i>Pèlerinage Hadj
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="oumra-tab" data-bs-toggle="pill" data-bs-target="#oumra" type="button" role="tab" aria-controls="oumra" aria-selected="false">
                            <i class="bi bi-star-fill me-2"></i>Pèlerinage Oumra
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="voyages-tab" data-bs-toggle="pill" data-bs-target="#voyages" type="button" role="tab" aria-controls="voyages" aria-selected="false">
                            <i class="bi bi-airplane-fill me-2"></i>Voyages Touristiques
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="hotels-tab" data-bs-toggle="pill" data-bs-target="#hotels" type="button" role="tab" aria-controls="hotels" aria-selected="false">
                            <i class="bi bi-building-fill me-2"></i>Hôtels & Hébergements
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Content -->
<section class="py-5">
    <div class="container">
        <div class="tab-content" id="gallery-content">
            <!-- Toutes les photos -->
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="row gallery-grid">
                    <!-- Hadj Photos -->
                    <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="hadj">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="https://via.placeholder.com/400x300.png/C41E3A/ffffff?text=Kaaba" class="gallery-image" alt="Pèlerinage Hadj - Kaaba">
                                <div class="gallery-overlay">
                                    <button class="btn btn-light btn-sm gallery-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600.png/C41E3A/ffffff?text=Kaaba" data-title="Pèlerinage Hadj - La Kaaba">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <div class="gallery-info">
                                        <h5>Pèlerinage Hadj</h5>
                                        <p>La Kaaba - Mecque</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="hadj">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="https://via.placeholder.com/400x300.png/E67E22/ffffff?text=Arafat" class="gallery-image" alt="Pèlerinage Hadj - Mont Arafat">
                                <div class="gallery-overlay">
                                    <button class="btn btn-light btn-sm gallery-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600.png/E67E22/ffffff?text=Arafat" data-title="Pèlerinage Hadj - Mont Arafat">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <div class="gallery-info">
                                        <h5>Pèlerinage Hadj</h5>
                                        <p>Mont Arafat</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Oumra Photos -->
                    <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="oumra">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="https://via.placeholder.com/400x300.png/F39C12/ffffff?text=Masjid+Nabawi" class="gallery-image" alt="Pèlerinage Oumra - Masjid Nabawi">
                                <div class="gallery-overlay">
                                    <button class="btn btn-light btn-sm gallery-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600.png/F39C12/ffffff?text=Masjid+Nabawi" data-title="Pèlerinage Oumra - Masjid Nabawi">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <div class="gallery-info">
                                        <h5>Pèlerinage Oumra</h5>
                                        <p>Masjid Nabawi - Médine</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="oumra">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="https://via.placeholder.com/400x300.png/A93226/ffffff?text=Haram" class="gallery-image" alt="Pèlerinage Oumra - Haram">
                                <div class="gallery-overlay">
                                    <button class="btn btn-light btn-sm gallery-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600.png/A93226/ffffff?text=Haram" data-title="Pèlerinage Oumra - Haram">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <div class="gallery-info">
                                        <h5>Pèlerinage Oumra</h5>
                                        <p>Masjid al-Haram</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Voyages Touristiques -->
                    <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="voyages">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="https://via.placeholder.com/400x300.png/2C3E50/ffffff?text=Dubai" class="gallery-image" alt="Voyage Touristique - Dubai">
                                <div class="gallery-overlay">
                                    <button class="btn btn-light btn-sm gallery-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600.png/2C3E50/ffffff?text=Dubai" data-title="Voyage Touristique - Dubai">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <div class="gallery-info">
                                        <h5>Voyage Touristique</h5>
                                        <p>Dubai - Émirats Arabes Unis</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="voyages">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="https://via.placeholder.com/400x300.png/5D6D7E/ffffff?text=Istanbul" class="gallery-image" alt="Voyage Touristique - Istanbul">
                                <div class="gallery-overlay">
                                    <button class="btn btn-light btn-sm gallery-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600.png/5D6D7E/ffffff?text=Istanbul" data-title="Voyage Touristique - Istanbul">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <div class="gallery-info">
                                        <h5>Voyage Touristique</h5>
                                        <p>Istanbul - Turquie</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hôtels -->
                    <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="hotels">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="https://via.placeholder.com/400x300.png/D35400/ffffff?text=Hotel+Mecque" class="gallery-image" alt="Hôtel à la Mecque">
                                <div class="gallery-overlay">
                                    <button class="btn btn-light btn-sm gallery-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600.png/D35400/ffffff?text=Hotel+Mecque" data-title="Hôtel de luxe à la Mecque">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <div class="gallery-info">
                                        <h5>Hébergement</h5>
                                        <p>Hôtel 5 étoiles - Mecque</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="hotels">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="https://via.placeholder.com/400x300.png/8E44AD/ffffff?text=Hotel+Medine" class="gallery-image" alt="Hôtel à Médine">
                                <div class="gallery-overlay">
                                    <button class="btn btn-light btn-sm gallery-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600.png/8E44AD/ffffff?text=Hotel+Medine" data-title="Hôtel confortable à Médine">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <div class="gallery-info">
                                        <h5>Hébergement</h5>
                                        <p>Hôtel 4 étoiles - Médine</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4 gallery-item" data-category="voyages">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="https://via.placeholder.com/400x300.png/16A085/ffffff?text=Marrakech" class="gallery-image" alt="Voyage Touristique - Marrakech">
                                <div class="gallery-overlay">
                                    <button class="btn btn-light btn-sm gallery-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="https://via.placeholder.com/800x600.png/16A085/ffffff?text=Marrakech" data-title="Voyage Touristique - Marrakech">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <div class="gallery-info">
                                        <h5>Voyage Touristique</h5>
                                        <p>Marrakech - Maroc</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Load More Button -->
<section class="py-4 text-center">
    <div class="container">
        <button class="btn btn-primary btn-lg" id="loadMoreBtn">
            <i class="bi bi-plus-circle-fill me-2"></i>Voir plus de photos
        </button>
    </div>
</section>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" class="img-fluid" alt="" id="modalImage">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-download"></i> Télécharger
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">Prêt à vivre votre propre aventure ?</h2>
                <p class="lead mb-4">Rejoignez les milliers de pèlerins et voyageurs qui nous ont fait confiance pour organiser leur voyage de rêve.</p>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="contact.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-envelope-fill me-2"></i>Nous contacter
                    </a>
                    <a href="services.php" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-list-check me-2"></i>Voir nos services
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Image Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('imageModalLabel');
    
    imageModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const imageSrc = button.getAttribute('data-image');
        const imageTitle = button.getAttribute('data-title');
        
        modalImage.src = imageSrc;
        modalImage.alt = imageTitle;
        modalTitle.textContent = imageTitle;
    });
    
    // Load more functionality (placeholder)
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    loadMoreBtn.addEventListener('click', function() {
        // Here you would load more images via AJAX
        this.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Toutes les photos chargées';
        this.disabled = true;
    });
});
</script>

<?php  
include('includes/footer.php');  
?>