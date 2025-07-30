<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'slug' => 'hadj',
            'title' => 'Organisation du HADJ',
            'description' => '<p>Le <strong>HADJ</strong> est le pèlerinage à La Mecque que tout musulman doit effectuer au moins une fois dans sa vie s\'il en a les moyens. SAFIR vous accompagne dans cette démarche spirituelle majeure avec un service complet et personnalisé.</p><h3>Notre Forfait HADJ Comprend :</h3><ul><li>Visa saoudien et formalités administratives</li><li>Billet d\'avion aller-retour</li><li>Hébergement à La Mecque et Médine</li><li>Transport local en Arabie Saoudite</li><li>Guides spirituels expérimentés</li><li>Assistance 24h/24 sur place</li><li>Repas selon le programme</li><li>Assurance voyage complète</li></ul><h3>Types de Formules :</h3><ul><li><strong>Formule Économique :</strong> Hébergement en chambre partagée</li><li><strong>Formule Confort :</strong> Hébergement en chambre double</li><li><strong>Formule Premium :</strong> Hébergement de luxe proche du Haram</li></ul>',
            'short_description' => 'Organisez votre pèlerinage à La Mecque avec SAFIR. Forfaits complets incluant visa, transport, hébergement et accompagnement spirituel.',
            'price' => 'À partir de 2 500 000 FCFA',
            'features' => 'Visa inclus|Transport aérien|Hébergement La Mecque/Médine|Guide spirituel|Assistance 24h/24|Assurance voyage',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 1,
            'created_by' => 1,
        ]);

        Service::create([
            'slug' => 'oumra',
            'title' => 'Organisation de l\'OUMRA',
            'description' => '<p>L\'<strong>OUMRA</strong> est le petit pèlerinage qui peut être effectué à tout moment de l\'année. SAFIR organise des voyages OUMRA réguliers avec un accompagnement spirituel de qualité.</p><h3>Notre Forfait OUMRA Comprend :</h3><ul><li>Visa saoudien et formalités</li><li>Billet d\'avion aller-retour</li><li>Hébergement à La Mecque</li><li>Transport aéroport-hôtel</li><li>Guide pour les rites de l\'OUMRA</li><li>Visite de Médine (option)</li><li>Assurance voyage</li></ul><h3>Avantages de l\'OUMRA :</h3><ul><li>Flexible toute l\'année</li><li>Durée adaptable (7 à 15 jours)</li><li>Moins de foule qu\'au HADJ</li><li>Tarifs plus accessibles</li></ul>',
            'short_description' => 'Effectuez votre OUMRA avec SAFIR. Voyages organisés toute l\'année avec guide spirituel et services complets.',
            'price' => 'À partir de 850 000 FCFA',
            'features' => 'Visa inclus|Flexible toute l\'année|Hébergement La Mecque|Guide spirituel|Transport inclus|Durée adaptable',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 2,
            'created_by' => 1,
        ]);

        Service::create([
            'slug' => 'billets',
            'title' => 'Vente de Billets d\'Avion',
            'description' => '<p>SAFIR vous propose les meilleures offres de <strong>billets d\'avion</strong> pour toutes destinations. Notre expertise nous permet de trouver les tarifs les plus avantageux pour vos voyages.</p><h3>Nos Services :</h3><ul><li>Réservation de billets domestiques et internationaux</li><li>Recherche des meilleurs tarifs</li><li>Gestion des modifications et annulations</li><li>Assistance pour les formalités de voyage</li><li>Conseils sur les meilleures routes</li><li>Réservation de sièges préférentiels</li></ul><h3>Destinations Populaires :</h3><ul><li>Europe : Paris, Londres, Bruxelles, Rome</li><li>Moyen-Orient : Dubaï, Doha, Istanbul</li><li>Afrique : Casablanca, Le Caire, Johannesburg</li><li>Amérique : New York, Montréal, Washington</li><li>Asie : Beijing, Bangkok, Kuala Lumpur</li></ul>',
            'short_description' => 'Trouvez les meilleurs prix pour vos billets d\'avion avec SAFIR. Toutes destinations, conseil personnalisé et service de qualité.',
            'price' => 'Tarifs compétitifs',
            'features' => 'Toutes destinations|Meilleurs tarifs|Modifications incluses|Conseil personnalisé|Formalités assistées|Réservation rapide',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 3,
            'created_by' => 1,
        ]);

        Service::create([
            'slug' => 'voyages',
            'title' => 'Voyages et Séjours',
            'description' => '<p>Découvrez le monde avec les <strong>voyages organisés</strong> de SAFIR. Que ce soit pour le tourisme, les affaires ou des occasions spéciales, nous créons des expériences inoubliables.</p><h3>Types de Voyages :</h3><ul><li><strong>Voyages Touristiques :</strong> Circuits découverte, séjours balnéaires</li><li><strong>Voyages d\'Affaires :</strong> Déplacements professionnels, séminaires</li><li><strong>Voyages de Groupe :</strong> Associations, entreprises, familles</li><li><strong>Lune de Miel :</strong> Séjours romantiques personnalisés</li><li><strong>Circuits Culturels :</strong> Découverte du patrimoine mondial</li></ul><h3>Destinations Privilégiées :</h3><ul><li>Afrique : Maroc, Sénégal, Ghana, Afrique du Sud</li><li>Europe : France, Italie, Espagne, Turquie</li><li>Asie : Thaïlande, Malaisie, Chine, Inde</li><li>Amérique : États-Unis, Canada, Brésil</li></ul>',
            'short_description' => 'Voyages organisés par SAFIR : tourisme, affaires, groupes. Circuits sur mesure et expériences inoubliables dans le monde entier.',
            'price' => 'Sur devis',
            'features' => 'Circuits sur mesure|Voyages de groupe|Affaires et tourisme|Guide accompagnateur|Transport inclus|Hébergement sélectionné',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 4,
            'created_by' => 1,
        ]);

        Service::create([
            'slug' => 'hotels',
            'title' => 'Réservation d\'Hôtels',
            'description' => '<p>SAFIR vous offre un accès privilégié à un <strong>large réseau d\'hôtels</strong> dans le monde entier. Des établissements économiques aux hôtels de luxe, trouvez l\'hébergement qui correspond à vos besoins.</p><h3>Notre Réseau :</h3><ul><li>Plus de 500 000 hôtels partenaires</li><li>Toutes catégories : 2 à 5 étoiles</li><li>Tarifs négociés exclusifs</li><li>Réservation instantanée</li><li>Confirmation immédiate</li><li>Service client dédié</li></ul><h3>Types d\'Hébergement :</h3><ul><li>Hôtels d\'affaires</li><li>Hôtels de tourisme</li><li>Resorts et centres de villégiature</li><li>Appartements et résidences</li><li>Auberges et guesthouses</li></ul>',
            'short_description' => 'Réservez votre hébergement avec SAFIR. Large choix d\'hôtels dans le monde, tarifs négociés et service personnalisé.',
            'price' => 'Tarifs négociés',
            'features' => '500 000+ hôtels|Tarifs exclusifs|Réservation instantanée|Toutes catégories|Service client|Confirmation immédiate',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 5,
            'created_by' => 1,
        ]);

        Service::create([
            'slug' => 'location',
            'title' => 'Location d\'Automobiles',
            'description' => '<p>Profitez de notre service de <strong>location de véhicules</strong> pour une liberté de mouvement totale lors de vos déplacements. SAFIR travaille avec les meilleures compagnies de location au monde.</p><h3>Notre Flotte :</h3><ul><li>Véhicules économiques</li><li>Berlines de luxe</li><li>4x4 et SUV</li><li>Monospaces familiaux</li><li>Véhicules utilitaires</li><li>Cars et minibus</li></ul><h3>Services Inclus :</h3><ul><li>Assurance tous risques</li><li>Assistance 24h/24</li><li>GPS et équipements</li><li>Livraison possible</li><li>Conducteur additionnel</li><li>Kilométrage illimité (selon formule)</li></ul>',
            'short_description' => 'Location de voitures avec SAFIR. Large choix de véhicules, assurance incluse et assistance 24h/24 dans le monde entier.',
            'price' => 'À partir de 25 000 FCFA/jour',
            'features' => 'Large choix véhicules|Assurance incluse|Assistance 24h/24|GPS fourni|Livraison possible|Tarifs compétitifs',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 6,
            'created_by' => 1,
        ]);
    }
}