<?php 
$pageTitle = "Organisation de l'OUMRA - Agence SAFIR";
include('includes/header.php'); 
?>

<section class="hero-section text-white text-center py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/images/oumra-hero.jpg') no-repeat center center/cover;">
    <div class="container">
        <h1 class="display-3 fw-bold">Organisation de l'OUMRA</h1>
        <p class="fs-4 mt-3">Confiez-nous l'organisation de votre Oumra pour une expérience spirituelle inoubliable.</p>
    </div>
</section>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-3 mb-4">
                <div class="card-body p-5">
                    <h2 class="card-title text-center mb-4 fw-bold">Un service complet pour votre Oumra</h2>
                    <p class="card-text lead text-center mb-5">L'agence SAFIR vous propose un accompagnement complet pour l'accomplissement de votre Oumra. Nos formules incluent :</p>
                    
                    <div class="row text-center g-4">
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-file-earmark-text service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Formalités de Visa</h3>
                                <p class="text-muted">Prise en charge complète des démarches administratives.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-airplane service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Billets d'Avion</h3>
                                <p class="text-muted">Vols aller-retour avec des compagnies fiables.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-building service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Hébergement de Qualité</h3>
                                <p class="text-muted">Hôtels confortables à la Mecque et à Médine.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-bus-front service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Transport Terrestre</h3>
                                <p class="text-muted">Déplacements en bus climatisé pour votre confort.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-person-check service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Guides Expérimentés</h3>
                                <p class="text-muted">Accompagnement par des professionnels dévoués.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-3 h-100 d-flex flex-column justify-content-between">
                                <i class="bi bi-map service-icon mb-3"></i>
                                <h3 class="fs-5 fw-bold">Visites des Sites</h3>
                                <p class="text-muted">Découverte des lieux saints et historiques (Ziyarates).</p>
                            </div>
                        </div>
                    </div>
                    
                    <p class="card-text text-center mt-5">Nous nous engageons à vous fournir un service de qualité pour que vous puissiez vous concentrer sur l'essentiel : votre dévotion.</p>
                    
                    <div class="text-center mt-4">
                        <a href="reservation.php?service=oumra" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">Demander un devis</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include('includes/footer.php'); 
?>