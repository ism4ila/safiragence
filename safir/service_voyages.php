<?php 
$pageTitle = "Voyages et Séjours - Agence SAFIR";
include('includes/header.php'); 
?>

<section class="hero-section text-white text-center py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/images/voyages-hero.jpg') no-repeat center center/cover;">
    <div class="container">
        <h1 class="display-3 fw-bold">Voyages et Séjours</h1>
        <p class="fs-4 mt-3">Découvrez le monde avec nos offres de voyages sur mesure.</p>
    </div>
</section>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-body p-5">
                    <h2 class="card-title text-center mb-4 fw-bold">Des vacances de rêve à votre portée</h2>
                    <p class="card-text lead text-center mb-5">Que vous rêviez de plages de sable fin, de découvertes culturelles ou d'aventures inoubliables, l'agence SAFIR organise le voyage de vos rêves. Nous vous proposons :</p>
                    
                    <div class="row text-center g-4">
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-beach service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Séjours Touristiques</h3>
                                <p class="text-muted">Explorez les plus belles destinations du monde.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-compass service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Circuits Organisés</h3>
                                <p class="text-muted">Découvrez une région ou un pays en profondeur avec nos experts.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-briefcase service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Voyages d'Affaires</h3>
                                <p class="text-muted">Solutions clés en main pour vos déplacements professionnels.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-sun service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Week-ends d'Évasion</h3>
                                <p class="text-muted">Ressourcez-vous lors de courts séjours inoubliables.</p>
                            </div>
                        </div>
                    </div>
                    
                    <p class="card-text text-center mt-5">Nous nous adaptons à vos envies et à votre budget pour vous créer un voyage sur mesure. Contactez-nous pour nous faire part de votre projet.</p>
                    
                    <div class="text-center mt-4">
                        <a href="reservation.php?service=sejours" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">Explorer nos offres</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include('includes/footer.php'); 
?>