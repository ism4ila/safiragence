<?php 
$pageTitle = "Vente de Billets d'Avion - Agence SAFIR";
include('includes/header.php'); 
?>

<section class="hero-section text-white text-center py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/images/billets-hero.jpg') no-repeat center center/cover;">
    <div class="container">
        <h1 class="display-3 fw-bold">Billets d'Avion</h1>
        <p class="fs-4 mt-3">Votre passeport pour le monde. Réservez vos vols en toute simplicité.</p>
    </div>
</section>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-body p-5">
                    <h2 class="card-title text-center mb-4 fw-bold">Voyagez en toute sérénité avec SAFIR</h2>
                    <p class="card-text lead text-center mb-5">Que vous voyagiez pour les affaires, le tourisme ou le pèlerinage, l'agence SAFIR vous trouve les meilleures offres de billets d'avion. Nous travaillons avec les plus grandes compagnies aériennes pour vous garantir :</p>
                    
                    <div class="row text-center g-4">
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-currency-dollar service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Tarifs Compétitifs</h3>
                                <p class="text-muted">Accédez aux meilleurs prix du marché pour toutes vos destinations.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-globe service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Large Choix de Destinations</h3>
                                <p class="text-muted">Des vols vers des centaines de villes nationales et internationales.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-headset service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Assistance Personnalisée</h3>
                                <p class="text-muted">Notre équipe vous accompagne à chaque étape de votre réservation.</p>
                            </div>
                        </div>
                    </div>
                    
                    <p class="card-text text-center mt-5">Contactez-nous dès aujourd'hui pour obtenir un devis personnalisé et réserver votre prochain vol en toute simplicité.</p>
                    
                    <div class="text-center mt-4">
                        <a href="reservation.php?service=billets" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">Réserver un vol</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include('includes/footer.php'); 
?>