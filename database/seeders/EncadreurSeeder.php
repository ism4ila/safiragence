<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Encadreur;

class EncadreurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Encadreur::create([
            'city_id' => 1,
            'full_name' => 'Imam Hassan MAHMOUD',
            'phone_1' => '+237 690 123 456',
            'email' => 'hassan.mahmoud@safir.cm',
            'specialties' => 'HADJ|OUMRA|Spiritualité',
            'notes' => 'Guide spirituel senior - 15 ans d\'expérience dans l\'accompagnement spirituel des pèlerins. Il a effectué le HADJ 8 fois et maîtrise parfaitement les rites.',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 1,
            'full_name' => 'Abdoulaye IBRAHIM',
            'phone_1' => '+237 691 234 567',
            'email' => 'abdoulaye.ibrahim@safir.cm',
            'specialties' => 'Organisation|Logistique',
            'notes' => 'Coordinateur régional - Coordinateur expérimenté basé à Bertoua, Abdoulaye gère l\'organisation logistique des voyages pour la région ENIA.',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 2,
            'full_name' => 'Dr. Amina HASSAN',
            'phone_1' => '+237 692 345 678',
            'email' => 'amina.hassan@safir.cm',
            'specialties' => 'HADJ|OUMRA|Accompagnement féminin',
            'notes' => 'Guide spirituelle - Dr. Amina se spécialise dans l\'accompagnement des groupes féminins lors des pèlerinages. Médecin de formation, elle assure aussi le suivi médical.',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 2,
            'full_name' => 'Mohamed BAKARI',
            'phone_1' => '+237 693 456 789',
            'email' => 'mohamed.bakari@safir.cm',
            'specialties' => 'Vente|Conseil|Relations clients',
            'notes' => 'Responsable commercial - Responsable de l\'équipe commerciale de Yaoundé, Mohamed conseille les clients sur les meilleures formules de voyage.',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 3,
            'full_name' => 'Imam Ousmane FALL',
            'phone_1' => '+237 694 567 890',
            'email' => 'ousmane.fall@safir.cm',
            'specialties' => 'HADJ|OUMRA|Formation spirituelle',
            'notes' => 'Guide spirituel - Avec 18 ans d\'expérience, Imam Ousmane est l\'un de nos guides les plus expérimentés. Il forme également les nouveaux encadreurs.',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 3,
            'full_name' => 'Fatima DIALLO',
            'phone_1' => '+237 695 678 901',
            'email' => 'fatima.diallo@safir.cm',
            'specialties' => 'Logistique|Organisation|Suivi groupe',
            'notes' => 'Coordinatrice logistique - Fatima coordonne la logistique des départs depuis Douala et assure le suivi des groupes pendant le voyage.',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 4,
            'full_name' => 'Ibrahim FOFANA',
            'phone_1' => '+237 696 789 012',
            'email' => 'ibrahim.fofana@safir.cm',
            'specialties' => 'HADJ|OUMRA|Langues locales',
            'notes' => 'Guide régional - Ibrahim maîtrise plusieurs langues locales de la région Ouest et facilite la communication avec les pèlerins locaux.',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 5,
            'full_name' => 'Alhadji Musa TANKO',
            'phone_1' => '+237 697 890 123',
            'email' => 'musa.tanko@safir.cm',
            'specialties' => 'HADJ|OUMRA|Anglais',
            'notes' => 'Guide spirituel - Guide bilingue français-anglais, Alhadji Musa accompagne les pèlerins anglophones du Nord-Ouest.',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 6,
            'full_name' => 'Mahamat ALI',
            'phone_1' => '+237 698 901 234',
            'email' => 'mahamat.ali@safir.cm',
            'specialties' => 'HADJ|OUMRA|Arabe|Organisation',
            'notes' => 'Coordinateur Nord - Coordinateur pour les régions du Nord, Mahamat parle couramment l\'arabe et facilite les démarches en Arabie Saoudite.',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 7,
            'full_name' => 'Hadja Aïcha MOUSSA',
            'phone_1' => '+237 699 012 345',
            'email' => 'aicha.moussa@safir.cm',
            'specialties' => 'OUMRA|Accompagnement féminin|Conseil',
            'notes' => 'Guide féminine - Hadja Aïcha se spécialise dans l\'accompagnement des femmes lors des pèlerinages et offre des conseils personnalisés.',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 8,
            'full_name' => 'Amadou HAMADOU',
            'phone_1' => '+237 690 123 789',
            'email' => 'amadou.hamadou@safir.cm',
            'specialties' => 'HADJ|OUMRA|Spiritualité|Formation',
            'notes' => 'Guide spirituel - Guide expérimenté de l\'Adamaoua, Amadou combine spiritualité et formation pratique pour préparer les pèlerins.',
            'is_active' => true,
        ]);
    }
}