<?php 
$pageTitle = "Nos Encadreurs - Agence SAFIR";
include('includes/header.php'); 

// Charger les encadreurs par ville depuis la BDD
$encadreurs_by_city = getEncadreursByCity();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 text-center mb-5">
            <h1 class="display-4">Nos Encadreurs</h1>
            <p class="lead text-muted">
                Découvrez nos encadreurs qualifiés répartis dans différentes villes du Cameroun.
                Ils sont là pour vous accompagner dans vos projets de voyage et de pèlerinage.
            </p>
        </div>
    </div>

    <?php if (!empty($encadreurs_by_city)): ?>
        <!-- Filtre par ville -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <h6 class="mb-0">
                                    <i class="fas fa-filter mr-2"></i>
                                    Filtrer par ville :
                                </h6>
                            </div>
                            <div class="col-md-9">
                                <div class="btn-group flex-wrap" role="group">
                                    <button type="button" class="btn btn-outline-primary active" onclick="filterCity('all')">
                                        Toutes les villes
                                    </button>
                                    <?php foreach (array_keys($encadreurs_by_city) as $city): ?>
                                    <button type="button" class="btn btn-outline-primary" onclick="filterCity('<?= htmlspecialchars($city) ?>')">
                                        <?= htmlspecialchars($city) ?>
                                        <span class="badge badge-light ml-1"><?= count($encadreurs_by_city[$city]) ?></span>
                                    </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des encadreurs par ville -->
        <?php foreach ($encadreurs_by_city as $city_name => $encadreurs): ?>
        <div class="city-section mb-5" data-city="<?= htmlspecialchars($city_name) ?>">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="city-title">
                        <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                        <?= htmlspecialchars($city_name) ?>
                        <span class="badge badge-primary ml-2"><?= count($encadreurs) ?> encadreur<?= count($encadreurs) > 1 ? 's' : '' ?></span>
                    </h2>
                    <hr class="mb-4">
                </div>
            </div>
            
            <div class="row">
                <?php foreach ($encadreurs as $encadreur): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 encadreur-card">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="encadreur-avatar mr-3">
                                    <?php if (!empty($encadreur['photo'])): ?>
                                    <img src="uploads/encadreurs/<?= htmlspecialchars($encadreur['photo']) ?>" 
                                         alt="<?= htmlspecialchars($encadreur['full_name']) ?>"
                                         class="rounded-circle" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                    <?php else: ?>
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px; font-size: 1.5rem;">
                                        <?= strtoupper(substr($encadreur['full_name'], 0, 1)) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-1"><?= htmlspecialchars($encadreur['full_name']) ?></h5>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        <?= htmlspecialchars($city_name) ?>
                                    </p>
                                    
                                    <?php if (!empty($encadreur['specialties'])): ?>
                                    <div class="mb-2">
                                        <span class="badge badge-info"><?= htmlspecialchars($encadreur['specialties']) ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="contact-info mt-3">
                                <!-- Téléphone principal -->
                                <div class="mb-2">
                                    <a href="tel:<?= htmlspecialchars($encadreur['phone_1']) ?>" 
                                       class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-phone mr-2"></i>
                                        <?= htmlspecialchars($encadreur['phone_1']) ?>
                                    </a>
                                </div>
                                
                                <!-- Téléphone secondaire -->
                                <?php if (!empty($encadreur['phone_2'])): ?>
                                <div class="mb-2">
                                    <a href="tel:<?= htmlspecialchars($encadreur['phone_2']) ?>" 
                                       class="btn btn-outline-secondary btn-sm w-100">
                                        <i class="fas fa-phone mr-2"></i>
                                        <?= htmlspecialchars($encadreur['phone_2']) ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                                
                                <!-- WhatsApp -->
                                <div class="mb-2">
                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $encadreur['phone_1']) ?>?text=Bonjour, je souhaite obtenir des informations sur vos services." 
                                       target="_blank"
                                       class="btn btn-success btn-sm w-100">
                                        <i class="fab fa-whatsapp mr-2"></i>
                                        WhatsApp
                                    </a>
                                </div>
                                
                                <!-- Email -->
                                <?php if (!empty($encadreur['email'])): ?>
                                <div class="mb-2">
                                    <a href="mailto:<?= htmlspecialchars($encadreur['email']) ?>" 
                                       class="btn btn-outline-info btn-sm w-100">
                                        <i class="fas fa-envelope mr-2"></i>
                                        Email
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if (!empty($encadreur['address'])): ?>
                        <div class="card-footer text-muted">
                            <small>
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <?= htmlspecialchars($encadreur['address']) ?>
                            </small>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Section contact général -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h4>Vous ne trouvez pas d'encadreur dans votre ville ?</h4>
                        <p class="text-muted">
                            Contactez-nous directement, nous vous mettrons en relation avec l'encadreur le plus proche de votre localisation.
                        </p>
                        <div class="btn-group">
                            <a href="contact.php" class="btn btn-primary">
                                <i class="fas fa-envelope mr-2"></i>
                                Nous contacter
                            </a>
                            <a href="reservation.php" class="btn btn-success">
                                <i class="fas fa-calendar-check mr-2"></i>
                                Faire une réservation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <?php else: ?>
        <!-- Message si pas d'encadreurs -->
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-body py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h4>Aucun encadreur disponible pour le moment</h4>
                        <p class="text-muted">
                            Nous travaillons à constituer notre réseau d'encadreurs. 
                            Contactez-nous pour plus d'informations.
                        </p>
                        <a href="contact.php" class="btn btn-primary">
                            <i class="fas fa-envelope mr-2"></i>
                            Nous contacter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.encadreur-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid #e9ecef;
}

.encadreur-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.city-title {
    color: #2c3e50;
    font-weight: 600;
}

.btn-group .btn {
    margin: 2px;
}

.contact-info .btn {
    font-size: 0.875rem;
}

.encadreur-avatar {
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .btn-group {
        display: block;
    }
    
    .btn-group .btn {
        display: block;
        width: 100%;
        margin: 2px 0;
    }
}
</style>

<script>
function filterCity(cityName) {
    // Retirer la classe active de tous les boutons
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Ajouter la classe active au bouton cliqué
    event.target.classList.add('active');
    
    // Afficher/masquer les sections
    document.querySelectorAll('.city-section').forEach(section => {
        if (cityName === 'all' || section.dataset.city === cityName) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
    
    // Scroll vers le haut si un filtre spécifique est sélectionné
    if (cityName !== 'all') {
        document.querySelector('.city-section[data-city="' + cityName + '"]').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Animation d'apparition des cartes
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.encadreur-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>

<?php 
include('includes/footer.php'); 
?>