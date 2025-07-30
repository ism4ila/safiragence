<?php 
// Inclure l'en-tête commun à toutes les pages
include('includes/header.php'); 
?>

<!-- Section Héro -->
<div id="hero" class="d-flex align-items-center justify-content-center text-white text-center py-5">
    <div class="container">
        <h1 class="display-4 fw-bold">L'accomplissement parfait de votre pèlerinage reste notre priorité !</h1>
        <p class="lead">Voyages, tourisme, billetterie et organisation de pèlerinage. Votre satisfaction est notre mission.</p>
        <a href="reservation.php" class="btn btn-light btn-lg mt-3">Réserver ou demander un devis</a>
    </div>
</div>

<!-- Section Services -->
<div class="container my-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h2 class="fw-bold">Nos Services</h2>
            <p class="text-muted">Découvrez comment nous pouvons vous aider à réaliser vos projets de voyage.</p>
        </div>
    </div>
    <div class="row g-4 justify-content-center">
        <!-- Carte Service: Vente de billets d'avion -->
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card service-card text-center w-100">
                <div class="card-body">
                    <div class="card-icon"><i class="bi bi-airplane"></i></div>
                    <h5 class="card-title">Vente de billets d'avion</h5>
                    <p class="card-text">Nous trouvons pour vous les meilleures offres de vols, quelle que soit votre destination.</p>
                    <a href="service_billets.php" class="btn">En savoir plus</a>
                </div>
            </div>
        </div>

        <!-- Carte Service: Organisation du HADJ et OUMRA -->
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card service-card text-center w-100">
                <div class="card-body">
                    <div class="card-icon"><i class="bi bi-moon-stars"></i></div>
                    <h5 class="card-title">Organisation du HADJ et OUMRA</h5>
                    <p class="card-text">Nous vous accompagnons dans votre pèlerinage avec des services complets et personnalisés.</p>
                    <a href="service_hadj.php" class="btn">En savoir plus</a>
                </div>
            </div>
        </div>

        <!-- Carte Service: Voyages et séjours -->
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card service-card text-center w-100">
                <div class="card-body">
                    <div class="card-icon"><i class="bi bi-map"></i></div>
                    <h5 class="card-title">Voyages et séjours</h5>
                    <p class="card-text">Que ce soit pour le tourisme ou les affaires, nous organisons des séjours inoubliables.</p>
                    <a href="service_voyages.php" class="btn">En savoir plus</a>
                </div>
            </div>
        </div>

        <!-- Carte Service: Réservation d'hôtel -->
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card service-card text-center w-100">
                <div class="card-body">
                    <div class="card-icon"><i class="bi bi-building"></i></div>
                    <h5 class="card-title">Réservation d'hôtel</h5>
                    <p class="card-text">Accédez à un large choix d'hôtels partout dans le monde, aux meilleurs tarifs.</p>
                    <a href="service_hotels.php" class="btn">En savoir plus</a>
                </div>
            </div>
        </div>

        <!-- Carte Service: Location automobiles -->
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card service-card text-center w-100">
                <div class="card-body">
                    <div class="card-icon"><i class="bi bi-car-front"></i></div>
                    <h5 class="card-title">Location automobiles</h5>
                    <p class="card-text">Profitez de nos solutions de location de véhicules pour une liberté de mouvement totale.</p>
                    <a href="service_location.php" class="btn">En savoir plus</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// Inclure le pied de page commun à toutes les pages
include('includes/footer.php'); 
?>