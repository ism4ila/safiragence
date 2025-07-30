-- =============================================
-- SAFIR - Données de base pour l'agence
-- =============================================

USE safirdb25;

-- =============================================
-- 1. PARAMÈTRES DU SITE
-- =============================================

-- Supprimer les données existantes pour éviter les doublons
DELETE FROM site_settings;

INSERT INTO site_settings (setting_key, setting_value, description) VALUES
('site_name', 'SAFIR', 'Nom du site'),
('site_tagline', 'Agence de voyages et de tourisme', 'Slogan du site'),
('site_description', 'SAFIR est votre agence de confiance spécialisée dans l''organisation du HADJ et OUMRA, la vente de billets d''avion, les voyages d''affaires et le tourisme.', 'Description du site'),
('contact_email', 'safir.agence.cameroun@gmail.com', 'Email de contact principal'),
('contact_phone', '+237 222 24 30 84', 'Téléphone principal'),
('contact_phone_2', '+237 680 57 09 94', 'Téléphone secondaire'),
('address', 'Immeuble SPC, avant carrefour aviation, Bertoua, ENIA', 'Adresse complète'),
('city', 'Bertoua', 'Ville'),
('region', 'ENIA', 'Région'),
('country', 'Cameroun', 'Pays'),
('postal_code', '', 'Code postal'),
('whatsapp_number', '+237680570994', 'Numéro WhatsApp'),
('facebook_url', 'https://facebook.com/safir.agence.cameroun', 'URL Facebook'),
('instagram_url', '', 'URL Instagram'),
('twitter_url', '', 'URL Twitter'),
('linkedin_url', '', 'URL LinkedIn'),
('youtube_url', '', 'URL YouTube'),
('google_maps_url', 'https://maps.google.com/?q=Bertoua+Cameroun', 'URL Google Maps'),
('business_hours', 'Lundi - Vendredi: 08h00 - 18h00, Samedi: 08h00 - 14h00', 'Horaires d''ouverture'),
('license_number', 'LT-001-CM', 'Numéro de licence'),
('founded_year', '2015', 'Année de création'),
('meta_keywords', 'SAFIR, agence voyage, Bertoua, Cameroun, HADJ, OUMRA, pèlerinage, billets avion, tourisme', 'Mots-clés SEO'),
('google_analytics_id', '', 'ID Google Analytics'),
('facebook_pixel_id', '', 'ID Facebook Pixel');

-- =============================================
-- 2. ADMINISTRATEUR PAR DÉFAUT
-- =============================================

-- Supprimer les administrateurs existants pour éviter les doublons
DELETE FROM admins;

INSERT INTO admins (username, email, password, role, first_name, last_name, is_active) VALUES
('admin', 'ismailahamadou5@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin', 'Ismail', 'HAMADOU', 1);
-- Mot de passe : 12345678

-- =============================================
-- 3. PAGES PRINCIPALES
-- =============================================

-- Supprimer les pages existantes pour éviter les doublons
DELETE FROM pages;

INSERT INTO pages (slug, title, content, meta_title, meta_description, meta_keywords, is_active, sort_order, created_by) VALUES

-- Page d'accueil
('home', 'Accueil - SAFIR', 
'<div class="hero-section">
    <h1>L''accomplissement parfait de votre pèlerinage reste notre priorité !</h1>
    <p class="lead">Voyages, tourisme, billetterie et organisation de pèlerinage. Votre satisfaction est notre mission.</p>
</div>

<div class="services-preview">
    <h2>Nos Services</h2>
    <p>Découvrez comment nous pouvons vous aider à réaliser vos projets de voyage.</p>
</div>', 
'SAFIR - Agence de voyages et de tourisme à Bertoua', 
'Agence SAFIR à Bertoua : Spécialiste du HADJ et OUMRA, vente de billets d''avion, voyages d''affaires et tourisme. L''accomplissement parfait de votre pèlerinage reste notre priorité.', 
'SAFIR, agence voyage, Bertoua, HADJ, OUMRA, pèlerinage, billets avion', 
1, 1, 1),

-- Page À Propos
('about', 'À Propos de SAFIR', 
'<div class="about-content">
    <h2>Notre Histoire</h2>
    <p>Fondée en 2015, <strong>SAFIR</strong> est une agence de voyages et de tourisme basée à Bertoua, dans la région de l''ENIA au Cameroun. Nous nous sommes spécialisés dans l''organisation du pèlerinage (HADJ et OUMRA) et offrons une gamme complète de services de voyage.</p>
    
    <h3>Notre Mission</h3>
    <p>L''accomplissement parfait de votre pèlerinage reste notre priorité ! Nous nous engageons à fournir des services de qualité supérieure pour tous vos besoins de voyage, que ce soit pour le pèlerinage, les affaires ou le tourisme.</p>
    
    <h3>Nos Valeurs</h3>
    <ul>
        <li><strong>Excellence :</strong> Nous visons l''excellence dans tous nos services</li>
        <li><strong>Confiance :</strong> Nous construisons des relations durables basées sur la confiance</li>
        <li><strong>Professionnalisme :</strong> Notre équipe expérimentée vous accompagne à chaque étape</li>
        <li><strong>Spiritualité :</strong> Nous comprenons l''importance spirituelle de votre voyage</li>
    </ul>
    
    <h3>Notre Équipe</h3>
    <p>Notre équipe d''experts en voyage possède une vaste expérience dans l''organisation de pèlerinages et de voyages. Nous travaillons avec des encadreurs qualifiés dans plusieurs villes pour vous accompagner tout au long de votre parcours spirituel.</p>
    
    <h3>Nos Certifications</h3>
    <p>SAFIR est une agence agréée avec la licence LT-001-CM. Nous respectons toutes les réglementations en vigueur et maintenons les plus hauts standards de service.</p>
</div>', 
'À Propos de SAFIR - Agence de voyages spécialisée en pèlerinage', 
'Découvrez l''histoire de SAFIR, agence de voyages fondée en 2015 à Bertoua. Spécialisée dans l''organisation du HADJ et OUMRA avec une équipe d''experts.', 
'SAFIR, histoire, mission, valeurs, équipe, Bertoua, pèlerinage', 
1, 2, 1),

-- Page Contact
('contact', 'Nous Contacter', 
'<div class="contact-content">
    <h2>Contactez-Nous</h2>
    <p>Notre équipe est à votre disposition pour répondre à toutes vos questions et vous accompagner dans la réalisation de vos projets de voyage.</p>
    
    <div class="contact-info">
        <h3>Informations de Contact</h3>
        <p><strong>Adresse :</strong> {{address}}</p>
        <p><strong>Téléphone :</strong> {{contact_phone}}</p>
        <p><strong>Email :</strong> {{contact_email}}</p>
        <p><strong>WhatsApp :</strong> {{whatsapp_number}}</p>
        <p><strong>Horaires :</strong> {{business_hours}}</p>
    </div>
    
    <div class="services-contact">
        <h3>Comment pouvons-nous vous aider ?</h3>
        <ul>
            <li>Organisation du HADJ et OUMRA</li>
            <li>Vente de billets d''avion</li>
            <li>Voyages d''affaires et tourisme</li>
            <li>Réservation d''hôtels</li>
            <li>Location de véhicules</li>
            <li>Conseils et devis gratuits</li>
        </ul>
    </div>
</div>', 
'Contact SAFIR - Agence de voyages à Bertoua', 
'Contactez SAFIR pour tous vos besoins de voyage. Téléphone: +237 222 24 30 84. Adresse: Bertoua, ENIA. Spécialiste HADJ et OUMRA.', 
'contact SAFIR, téléphone, adresse Bertoua, devis voyage', 
1, 3, 1);

-- =============================================
-- 4. SERVICES DE L'AGENCE
-- =============================================

-- Supprimer les services existants pour éviter les doublons
DELETE FROM services;

INSERT INTO services (slug, title, description, short_description, price, features, is_featured, is_active, sort_order, created_by) VALUES

-- Service HADJ
('hadj', 'Organisation du HADJ', 
'<p>Le <strong>HADJ</strong> est le pèlerinage à La Mecque que tout musulman doit effectuer au moins une fois dans sa vie s''il en a les moyens. SAFIR vous accompagne dans cette démarche spirituelle majeure avec un service complet et personnalisé.</p>

<h3>Notre Forfait HADJ Comprend :</h3>
<ul>
    <li>Visa saoudien et formalités administratives</li>
    <li>Billet d''avion aller-retour</li>
    <li>Hébergement à La Mecque et Médine</li>
    <li>Transport local en Arabie Saoudite</li>
    <li>Guides spirituels expérimentés</li>
    <li>Assistance 24h/24 sur place</li>
    <li>Repas selon le programme</li>
    <li>Assurance voyage complète</li>
</ul>

<h3>Types de Formules :</h3>
<ul>
    <li><strong>Formule Économique :</strong> Hébergement en chambre partagée</li>
    <li><strong>Formule Confort :</strong> Hébergement en chambre double</li>
    <li><strong>Formule Premium :</strong> Hébergement de luxe proche du Haram</li>
</ul>', 
'Organisez votre pèlerinage à La Mecque avec SAFIR. Forfaits complets incluant visa, transport, hébergement et accompagnement spirituel.', 
'À partir de 2 500 000 FCFA', 
'Visa inclus|Transport aérien|Hébergement La Mecque/Médine|Guide spirituel|Assistance 24h/24|Assurance voyage', 
1, 1, 1, 1),

-- Service OUMRA
('oumra', 'Organisation de l''OUMRA', 
'<p>L''<strong>OUMRA</strong> est le petit pèlerinage qui peut être effectué à tout moment de l''année. SAFIR organise des voyages OUMRA réguliers avec un accompagnement spirituel de qualité.</p>

<h3>Notre Forfait OUMRA Comprend :</h3>
<ul>
    <li>Visa saoudien et formalités</li>
    <li>Billet d''avion aller-retour</li>
    <li>Hébergement à La Mecque</li>
    <li>Transport aéroport-hôtel</li>
    <li>Guide pour les rites de l''OUMRA</li>
    <li>Visite de Médine (option)</li>
    <li>Assurance voyage</li>
</ul>

<h3>Avantages de l''OUMRA :</h3>
<ul>
    <li>Flexible toute l''année</li>
    <li>Durée adaptable (7 à 15 jours)</li>
    <li>Moins de foule qu''au HADJ</li>
    <li>Tarifs plus accessibles</li>
</ul>', 
'Effectuez votre OUMRA avec SAFIR. Voyages organisés toute l''année avec guide spirituel et services complets.', 
'À partir de 850 000 FCFA', 
'Visa inclus|Flexible toute l''année|Hébergement La Mecque|Guide spirituel|Transport inclus|Durée adaptable', 
1, 1, 2, 1),

-- Service Billets d'avion
('billets', 'Vente de Billets d''Avion', 
'<p>SAFIR vous propose les meilleures offres de <strong>billets d''avion</strong> pour toutes destinations. Notre expertise nous permet de trouver les tarifs les plus avantageux pour vos voyages.</p>

<h3>Nos Services :</h3>
<ul>
    <li>Réservation de billets domestiques et internationaux</li>
    <li>Recherche des meilleurs tarifs</li>
    <li>Gestion des modifications et annulations</li>
    <li>Assistance pour les formalités de voyage</li>
    <li>Conseils sur les meilleures routes</li>
    <li>Réservation de sièges préférentiels</li>
</ul>

<h3>Destinations Populaires :</h3>
<ul>
    <li>Europe : Paris, Londres, Bruxelles, Rome</li>
    <li>Moyen-Orient : Dubaï, Doha, Istanbul</li>
    <li>Afrique : Casablanca, Le Caire, Johannesburg</li>
    <li>Amérique : New York, Montréal, Washington</li>
    <li>Asie : Beijing, Bangkok, Kuala Lumpur</li>
</ul>', 
'Trouvez les meilleurs prix pour vos billets d''avion avec SAFIR. Toutes destinations, conseil personnalisé et service de qualité.', 
'Tarifs compétitifs', 
'Toutes destinations|Meilleurs tarifs|Modifications incluses|Conseil personnalisé|Formalités assistées|Réservation rapide', 
1, 1, 3, 1),

-- Service Voyages
('voyages', 'Voyages et Séjours', 
'<p>Découvrez le monde avec les <strong>voyages organisés</strong> de SAFIR. Que ce soit pour le tourisme, les affaires ou des occasions spéciales, nous créons des expériences inoubliables.</p>

<h3>Types de Voyages :</h3>
<ul>
    <li><strong>Voyages Touristiques :</strong> Circuits découverte, séjours balnéaires</li>
    <li><strong>Voyages d''Affaires :</strong> Déplacements professionnels, séminaires</li>
    <li><strong>Voyages de Groupe :</strong> Associations, entreprises, familles</li>
    <li><strong>Lune de Miel :</strong> Séjours romantiques personnalisés</li>
    <li><strong>Circuits Culturels :</strong> Découverte du patrimoine mondial</li>
</ul>

<h3>Destinations Privilégiées :</h3>
<ul>
    <li>Afrique : Maroc, Sénégal, Ghana, Afrique du Sud</li>
    <li>Europe : France, Italie, Espagne, Turquie</li>
    <li>Asie : Thaïlande, Malaisie, Chine, Inde</li>
    <li>Amérique : États-Unis, Canada, Brésil</li>
</ul>', 
'Voyages organisés par SAFIR : tourisme, affaires, groupes. Circuits sur mesure et expériences inoubliables dans le monde entier.', 
'Sur devis', 
'Circuits sur mesure|Voyages de groupe|Affaires et tourisme|Guide accompagnateur|Transport inclus|Hébergement sélectionné', 
1, 1, 4, 1),

-- Service Hôtels
('hotels', 'Réservation d''Hôtels', 
'<p>SAFIR vous offre un accès privilégié à un <strong>large réseau d''hôtels</strong> dans le monde entier. Des établissements économiques aux hôtels de luxe, trouvez l''hébergement qui correspond à vos besoins.</p>

<h3>Notre Réseau :</h3>
<ul>
    <li>Plus de 500 000 hôtels partenaires</li>
    <li>Toutes catégories : 2 à 5 étoiles</li>
    <li>Tarifs négociés exclusifs</li>
    <li>Réservation instantanée</li>
    <li>Confirmation immédiate</li>
    <li>Service client dédié</li>
</ul>

<h3>Types d''Hébergement :</h3>
<ul>
    <li>Hôtels d''affaires</li>
    <li>Hôtels de tourisme</li>
    <li>Resorts et centres de villégiature</li>
    <li>Appartements et résidences</li>
    <li>Auberges et guesthouses</li>
</ul>', 
'Réservez votre hébergement avec SAFIR. Large choix d''hôtels dans le monde, tarifs négociés et service personnalisé.', 
'Tarifs négociés', 
'500 000+ hôtels|Tarifs exclusifs|Réservation instantanée|Toutes catégories|Service client|Confirmation immédiate', 
1, 1, 5, 1),

-- Service Location
('location', 'Location d''Automobiles', 
'<p>Profitez de notre service de <strong>location de véhicules</strong> pour une liberté de mouvement totale lors de vos déplacements. SAFIR travaille avec les meilleures compagnies de location au monde.</p>

<h3>Notre Flotte :</h3>
<ul>
    <li>Véhicules économiques</li>
    <li>Berlines de luxe</li>
    <li>4x4 et SUV</li>
    <li>Monospaces familiaux</li>
    <li>Véhicules utilitaires</li>
    <li>Cars et minibus</li>
</ul>

<h3>Services Inclus :</h3>
<ul>
    <li>Assurance tous risques</li>
    <li>Assistance 24h/24</li>
    <li>GPS et équipements</li>
    <li>Livraison possible</li>
    <li>Conducteur additionnel</li>
    <li>Kilométrage illimité (selon formule)</li>
</ul>', 
'Location de voitures avec SAFIR. Large choix de véhicules, assurance incluse et assistance 24h/24 dans le monde entier.', 
'À partir de 25 000 FCFA/jour', 
'Large choix véhicules|Assurance incluse|Assistance 24h/24|GPS fourni|Livraison possible|Tarifs compétitifs', 
1, 1, 6, 1);

-- =============================================
-- 5. VILLES ET RÉGIONS
-- =============================================

-- Supprimer les villes existantes pour éviter les doublons
DELETE FROM cities;

INSERT INTO cities (name, region, country, is_active, sort_order) VALUES
('Bertoua', 'ENIA', 'Cameroun', 1, 1),
('Yaoundé', 'Centre', 'Cameroun', 1, 2),
('Douala', 'Littoral', 'Cameroun', 1, 3),
('Bafoussam', 'Ouest', 'Cameroun', 1, 4),
('Bamenda', 'Nord-Ouest', 'Cameroun', 1, 5),
('Garoua', 'Nord', 'Cameroun', 1, 6),
('Maroua', 'Extrême-Nord', 'Cameroun', 1, 7),
('Ngaoundéré', 'Adamaoua', 'Cameroun', 1, 8),
('Ebolowa', 'Sud', 'Cameroun', 1, 9),
('Kribi', 'Sud', 'Cameroun', 1, 10);

-- =============================================
-- 6. ENCADREURS PAR VILLE
-- =============================================

-- Supprimer les encadreurs existants pour éviter les doublons
DELETE FROM encadreurs;

INSERT INTO encadreurs (city_id, full_name, phone_1, email, specialties, notes, is_active) VALUES

-- Encadreurs Bertoua
(1, 'Imam Hassan MAHMOUD', '+237 690 123 456', 'hassan.mahmoud@safir.cm', 'HADJ|OUMRA|Spiritualité', 'Guide spirituel senior - 15 ans d''expérience dans l''accompagnement spirituel des pèlerins. Il a effectué le HADJ 8 fois et maîtrise parfaitement les rites.', 1),
(1, 'Abdoulaye IBRAHIM', '+237 691 234 567', 'abdoulaye.ibrahim@safir.cm', 'Organisation|Logistique', 'Coordinateur régional - Coordinateur expérimenté basé à Bertoua, Abdoulaye gère l''organisation logistique des voyages pour la région ENIA.', 1),

-- Encadreurs Yaoundé
(2, 'Dr. Amina HASSAN', '+237 692 345 678', 'amina.hassan@safir.cm', 'HADJ|OUMRA|Accompagnement féminin', 'Guide spirituelle - Dr. Amina se spécialise dans l''accompagnement des groupes féminins lors des pèlerinages. Médecin de formation, elle assure aussi le suivi médical.', 1),
(2, 'Mohamed BAKARI', '+237 693 456 789', 'mohamed.bakari@safir.cm', 'Vente|Conseil|Relations clients', 'Responsable commercial - Responsable de l''équipe commerciale de Yaoundé, Mohamed conseille les clients sur les meilleures formules de voyage.', 1),

-- Encadreurs Douala
(3, 'Imam Ousmane FALL', '+237 694 567 890', 'ousmane.fall@safir.cm', 'HADJ|OUMRA|Formation spirituelle', 'Guide spirituel - Avec 18 ans d''expérience, Imam Ousmane est l''un de nos guides les plus expérimentés. Il forme également les nouveaux encadreurs.', 1),
(3, 'Fatima DIALLO', '+237 695 678 901', 'fatima.diallo@safir.cm', 'Logistique|Organisation|Suivi groupe', 'Coordinatrice logistique - Fatima coordonne la logistique des départs depuis Douala et assure le suivi des groupes pendant le voyage.', 1),

-- Encadreurs Bafoussam
(4, 'Ibrahim FOFANA', '+237 696 789 012', 'ibrahim.fofana@safir.cm', 'HADJ|OUMRA|Langues locales', 'Guide régional - Ibrahim maîtrise plusieurs langues locales de la région Ouest et facilite la communication avec les pèlerins locaux.', 1),

-- Encadreurs Bamenda
(5, 'Alhadji Musa TANKO', '+237 697 890 123', 'musa.tanko@safir.cm', 'HADJ|OUMRA|Anglais', 'Guide spirituel - Guide bilingue français-anglais, Alhadji Musa accompagne les pèlerins anglophones du Nord-Ouest.', 1),

-- Encadreurs Garoua
(6, 'Mahamat ALI', '+237 698 901 234', 'mahamat.ali@safir.cm', 'HADJ|OUMRA|Arabe|Organisation', 'Coordinateur Nord - Coordinateur pour les régions du Nord, Mahamat parle couramment l''arabe et facilite les démarches en Arabie Saoudite.', 1),

-- Encadreurs Maroua
(7, 'Hadja Aïcha MOUSSA', '+237 699 012 345', 'aicha.moussa@safir.cm', 'OUMRA|Accompagnement féminin|Conseil', 'Guide féminine - Hadja Aïcha se spécialise dans l''accompagnement des femmes lors des pèlerinages et offre des conseils personnalisés.', 1),

-- Encadreurs Ngaoundéré
(8, 'Amadou HAMADOU', '+237 690 123 789', 'amadou.hamadou@safir.cm', 'HADJ|OUMRA|Spiritualité|Formation', 'Guide spirituel - Guide expérimenté de l''Adamaoua, Amadou combine spiritualité et formation pratique pour préparer les pèlerins.', 1);

-- =============================================
-- 7. GALERIE D'IMAGES (exemples)
-- =============================================

-- Supprimer les images de galerie existantes pour éviter les doublons
DELETE FROM gallery_images;

INSERT INTO gallery_images (title, description, image_path, category, is_featured, sort_order, created_by) VALUES
('Groupe HADJ 2023', 'Notre groupe de pèlerins lors du HADJ 2023 à la Grande Mosquée de La Mecque', 'gallery/hadj_2023_group.jpg', 'hadj', 1, 1, 1),
('OUMRA Février 2024', 'Pèlerins effectuant l''OUMRA en février 2024', 'gallery/oumra_feb_2024.jpg', 'oumra', 1, 2, 1),
('Équipe SAFIR', 'Notre équipe professionnelle au siège de Bertoua', 'gallery/team_safir.jpg', 'team', 1, 3, 1),
('Voyage Istanbul', 'Séjour touristique à Istanbul - Mosquée Bleue', 'gallery/istanbul_trip.jpg', 'tourism', 1, 4, 1),
('Formation encadreurs', 'Session de formation de nos encadreurs spirituels', 'gallery/training_session.jpg', 'training', 0, 5, 1);

-- =============================================
-- 8. TÉMOIGNAGES CLIENTS
-- =============================================

-- Supprimer les témoignages existants pour éviter les doublons
DELETE FROM testimonials;

INSERT INTO testimonials (client_name, client_city, content, service_type, rating, is_featured, created_by) VALUES
('Madame Aminata KEITA', 'Yaoundé', 'Excellent service pour mon HADJ 2023. L''équipe SAFIR a été très professionnelle et l''accompagnement spirituel était parfait. Je recommande vivement !', 'hadj', 5, 1, 1),
('Monsieur Jean MBARGA', 'Douala', 'J''ai effectué mon OUMRA avec SAFIR et tout s''est très bien passé. Organisation impeccable, guide compétent. Merci à toute l''équipe !', 'oumra', 5, 1, 1),
('Dr. Marie FOTSO', 'Bafoussam', 'Pour mes voyages d''affaires, je fais toujours confiance à SAFIR. Ils trouvent toujours les meilleurs tarifs et le service est rapide.', 'billets', 4, 1, 1),
('Famille NGUEMA', 'Bertoua', 'Notre voyage de famille en Turquie organisé par SAFIR était fantastique. Tout était bien planifié, merci !', 'voyages', 5, 1, 1),
('Imam IBRAHIM', 'Garoua', 'En tant qu''imam, j''apprécie la qualité spirituelle des voyages SAFIR. Leurs encadreurs sont compétents et pieux.', 'hadj', 5, 1, 1);

-- =============================================
-- MESSAGE DE CONFIRMATION
-- =============================================

SELECT 'Données SAFIR importées avec succès !' AS message;