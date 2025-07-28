<?php 
$pageTitle = "Location de Voitures - Agence SAFIR";
include('includes/header.php'); 
?>

<section class="hero-section text-white text-center py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/images/location-hero.jpg') no-repeat center center/cover;">
    <div class="container">
        <h1 class="display-3 fw-bold">Location de Voitures</h1>
        <p class="fs-4 mt-3">Louez le véhicule qui vous convient pour une liberté totale lors de vos déplacements.</p>
    </div>
</section>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-body p-5">
                    <h2 class="card-title text-center mb-4 fw-bold">Votre mobilité, notre priorité</h2>
                    <p class="card-text lead text-center mb-5">Que vous ayez besoin d'une voiture pour un court séjour, un déplacement professionnel ou des vacances en famille, l'agence SAFIR vous propose un large choix de véhicules adaptés à vos besoins et à votre budget.</p>
                    
                    <div class="row text-center g-4">
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-car-front service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Large Choix de Véhicules</h3>
                                <p class="text-muted">Berlines, SUV, utilitaires... trouvez le véhicule idéal.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-tag service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Tarifs Compétitifs</h3>
                                <p class="text-muted">Des prix transparents et adaptés à votre budget.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-calendar-check service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Flexibilité de Durée</h3>
                                <p class="text-muted">Location à la journée, semaine ou au mois, selon vos besoins.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-life-preserver service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Assistance Routière</h3>
                                <p class="text-muted">Support 24h/24 et 7j/7 pour une tranquillité d'esprit.</p>
                            </div>
                        </div>
                    </div>
                    
                    <p class="card-text text-center mt-5">Contactez-nous pour réserver votre véhicule et profiter d'une liberté totale lors de vos déplacements.</p>
                    
                    <div class="text-center mt-4">
                        <a href="reservation.php?service=location" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">Voir les véhicules</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include('includes/footer.php'); 
?>