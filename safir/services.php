<?php 
// Définir le titre de la page
$pageTitle = "Nos Services - Agence SAFIR";
include('includes/header.php'); 
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="display-4">Tous Nos Services</h1>
            <p class="lead">L'agence SAFIR vous propose une gamme complète de services pour simplifier vos voyages, qu'ils soient pour le pèlerinage, les affaires ou le tourisme. Découvrez tout ce que nous pouvons faire pour vous.</p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-md-2">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Organisation du HADJ et OUMRA</h5>
                        <p class="mb-0">Accompagnement complet et personnalisé pour votre pèlerinage.</p>
                    </div>
                    <a href="service_hadj.php" class="btn btn-light">En savoir plus</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Vente de billets d'avion</h5>
                        <p class="mb-0">Les meilleures offres pour vos destinations nationales et internationales.</p>
                    </div>
                    <a href="service_billets.php" class="btn btn-light">Réserver un vol</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Voyages et Séjours</h5>
                        <p class="mb-0">Des formules sur mesure pour vos vacances ou déplacements professionnels.</p>
                    </div>
                    <a href="service_voyages.php" class="btn btn-light">Explorer nos offres</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Réservation d'hôtels</h5>
                        <p class="mb-0">Un vaste choix d'hôtels partenaires pour un séjour confortable.</p>
                    </div>
                    <a href="service_hotels.php" class="btn btn-light">Trouver un hôtel</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Location de voitures</h5>
                        <p class="mb-0">Louez le véhicule qui vous convient pour une liberté totale lors de vos déplacements.</p>
                    </div>
                    <a href="service_location.php" class="btn btn-light">Voir les véhicules</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Devis et Réservation</h5>
                        <p class="mb-0">Obtenez une estimation rapide pour n'importe lequel de nos services.</p>
                    </div>
                    <a href="reservation.php" class="btn btn-light">Demander un devis</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php 
include('includes/footer.php'); 
?>