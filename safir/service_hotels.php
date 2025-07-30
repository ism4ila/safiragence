<?php 
$pageTitle = "Réservation d'Hôtels - Agence SAFIR";
include('includes/header.php'); 
?>

<section class="hero-section text-white text-center py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/images/hotels-hero.jpg') no-repeat center center/cover;">
    <div class="container">
        <h1 class="display-3 fw-bold">Réservation d'Hôtels</h1>
        <p class="fs-4 mt-3">Trouvez l'hébergement idéal pour votre séjour, où que vous soyez.</p>
    </div>
</section>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-body p-5">
                    <h2 class="card-title text-center mb-4 fw-bold">Un séjour tout confort</h2>
                    <p class="card-text lead text-center mb-5">Grâce à notre large réseau d'hôtels partenaires, nous vous proposons des hébergements de qualité, adaptés à tous les budgets. Que vous cherchiez un hôtel de luxe, un appartement meublé ou une chambre d'hôtes, nous avons ce qu'il vous faut.</p>
                    
                    <div class="row text-center g-4">
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-star service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Hôtels de Qualité</h3>
                                <p class="text-muted">Une sélection rigoureuse pour votre confort et votre satisfaction.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-tags service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Tarifs Négociés</h3>
                                <p class="text-muted">Les meilleurs prix pour un excellent rapport qualité-prix.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-headset service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Assistance Personnalisée</h3>
                                <p class="text-muted">Notre équipe vous aide à gérer vos réservations et demandes.</p>
                            </div>
                        </div>
                    </div>
                    
                    <p class="card-text text-center mt-5">Contactez-nous pour trouver l'hôtel parfait pour votre prochain voyage.</p>
                    
                    <div class="text-center mt-4">
                        <a href="reservation.php?service=hotels" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">Trouver un hôtel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include('includes/footer.php'); 
?>