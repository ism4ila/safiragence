<?php 
$pageTitle = "Contactez-nous - Agence SAFIR";
include('includes/header.php'); 
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="display-4">Contactez-nous</h1>
            <p class="lead">Une question ? Une demande de devis ? N'hésitez pas à nous contacter via le formulaire ci-dessous ou directement par téléphone. Notre équipe vous répondra dans les plus brefs délais.</p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-md-2">
            <div class="card form-container">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">
                        <i class="bi bi-envelope me-2"></i>
                        Envoyez-nous un message
                    </h3>
                    
                    <form action="#" method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Votre nom complet</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">
                                    Veuillez entrer votre nom complet.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Votre email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">
                                    Veuillez entrer une adresse email valide.
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Téléphone (optionnel)</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                                <div class="invalid-feedback">
                                    Veuillez entrer un numéro de téléphone valide.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="service" class="form-label">Service concerné</label>
                                <select class="form-select" id="service" name="service" required>
                                    <option value="">Sélectionnez un service</option>
                                    <option value="hadj">HADJ & OUMRA</option>
                                    <option value="billets">Billets d'avion</option>
                                    <option value="voyages">Voyages & Séjours</option>
                                    <option value="hotels">Réservation d'hôtels</option>
                                    <option value="location">Location de voitures</option>
                                    <option value="autre">Autre</option>
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner un service.
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                            <div class="invalid-feedback">
                                Veuillez entrer un sujet.
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label">Votre message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required 
                                      placeholder="Décrivez votre demande en détail..."></textarea>
                            <div class="invalid-feedback">
                                Veuillez entrer votre message.
                            </div>
                            <div class="form-text">
                                <small class="text-muted">
                                    <span id="char-count">0</span>/500 caractères
                                </small>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="privacy" name="privacy" required>
                                <label class="form-check-label" for="privacy">
                                    J'accepte la <a href="#" target="_blank">politique de confidentialité</a> et 
                                    le traitement de mes données personnelles.
                                </label>
                                <div class="invalid-feedback">
                                    Vous devez accepter la politique de confidentialité.
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send me-2"></i>
                                Envoyer le message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12 text-center mb-4">
            <h2>Nos Coordonnées</h2>
            <p class="lead">Plusieurs moyens de nous contacter</p>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="card-icon mb-3">
                        <i class="bi bi-geo-alt" style="font-size: 2.5rem; color: var(--safir-orange);"></i>
                    </div>
                    <h5 class="card-title">Adresse</h5>
                    <p class="card-text">
                        Bertoua, ENIA<br>
                        Immeuble SPC<br>
                        Avant carrefour aviation
                    </p>
                    <a href="https://maps.google.com/?q=Bertoua+ENIA+Immeuble+SPC" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-map me-1"></i>
                        Voir sur la carte
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="card-icon mb-3">
                        <i class="bi bi-telephone" style="font-size: 2.5rem; color: var(--safir-orange);"></i>
                    </div>
                    <h5 class="card-title">Téléphone</h5>
                    <p class="card-text">
                        <strong>+237 222 24 30 84</strong><br>
                        <small class="text-muted">Lundi - Vendredi: 8h00 - 18h00<br>
                        Samedi: 8h00 - 14h00</small>
                    </p>
                    <a href="tel:+237222243084" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-telephone me-1"></i>
                        Appeler maintenant
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="card-icon mb-3">
                        <i class="bi bi-envelope" style="font-size: 2.5rem; color: var(--safir-orange);"></i>
                    </div>
                    <h5 class="card-title">Email</h5>
                    <p class="card-text">
                        <strong>safir.agence.cameroun@gmail.com</strong><br>
                        <small class="text-muted">Réponse sous 24h</small>
                    </p>
                    <a href="mailto:safir.agence.cameroun@gmail.com" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-envelope me-1"></i>
                        Envoyer un email
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-clock me-2"></i>
                        Horaires d'ouverture
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><strong>Lundi - Vendredi:</strong> 8h00 - 18h00</li>
                                <li><strong>Samedi:</strong> 8h00 - 14h00</li>
                                <li><strong>Dimanche:</strong> Fermé</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted">
                                <i class="bi bi-info-circle me-2"></i>
                                Pour les urgences pendant les heures de fermeture, 
                                n'hésitez pas à nous laisser un message via le formulaire.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include('includes/footer.php'); 
?>