<?php 
$pageTitle = "Réservation - Agence SAFIR";
include('includes/header.php'); 
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="display-4">Réserver ou Demander un Devis</h1>
            <p class="lead">Remplissez le formulaire ci-dessous pour faire une demande de réservation ou obtenir un devis personnalisé pour l'un de nos services.</p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-md-2">
            <form action="#" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Votre nom complet</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Votre email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Votre téléphone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="service" class="form-label">Service souhaité</label>
                    <select class="form-select" id="service" name="service" required>
                        <option selected disabled value="">Choisissez un service...</option>
                        <option value="hadj_oumra">Organisation du HADJ et OUMRA</option>
                        <option value="billets">Vente de billets d'avion</option>
                        <option value="sejours">Voyages et Séjours</option>
                        <option value="hotels">Réservation d'hôtels</option>
                        <option value="location">Location de voitures</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Détails de votre demande</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer la demande</button>
            </form>
        </div>
    </div>
</div>

<?php 
include('includes/footer.php'); 
?>
