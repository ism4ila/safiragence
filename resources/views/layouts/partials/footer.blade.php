<!-- Footer SAFIR -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5>SAFIR</h5>
                <p>Agence de voyages et de tourisme située à Bertoua, spécialisée dans l'organisation du HADJ et OUMRA. 
                L'accomplissement parfait de votre pèlerinage reste notre priorité ! Nous offrons également des services de billetterie, 
                réservation d'hôtels et location de véhicules.</p>
                <div class="social-links">
                    <a href="#" class="me-3"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="me-3"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="me-3"><i class="bi bi-whatsapp"></i></a>
                    <a href="#"><i class="bi bi-envelope"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6 mb-4">
                <h5>Navigation</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('about') }}">À propos</a></li>
                    <li><a href="{{ route('services.index') }}">Services</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Services</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Organisation HADJ</a></li>
                    <li><a href="#">Organisation OUMRA</a></li>
                    <li><a href="#">Vente de billets</a></li>
                    <li><a href="#">Réservation hôtels</a></li>
                    <li><a href="#">Location voitures</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 mb-4">
                <h5>Contact</h5>
                <ul class="list-unstyled">
                    <li><i class="bi bi-geo-alt"></i> Bertoua, ENIA - Immeuble SPC, avant carrefour aviation</li>
                    <li><i class="bi bi-telephone"></i> +237 222 24 30 84</li>
                    <li><i class="bi bi-envelope"></i> safir.agence.cameroun@gmail.com</li>
                    <li><i class="bi bi-clock"></i> Lun-Sam: 8h-18h</li>
                </ul>
            </div>
        </div>
        
        <hr class="my-4">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} SAFIR - Agence de voyages et de tourisme. Tous droits réservés.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <small>Développé avec ❤️ pour SAFIR</small>
            </div>
        </div>
    </div>
</footer>