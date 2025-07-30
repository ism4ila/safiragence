<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::create([
            'client_name' => 'Madame Aminata KEITA',
            'client_city' => 'Yaoundé',
            'content' => 'Excellent service pour mon HADJ 2023. L\'équipe SAFIR a été très professionnelle et l\'accompagnement spirituel était parfait. Je recommande vivement !',
            'service_type' => 'hadj',
            'rating' => 5,
            'is_featured' => true,
            'created_by' => 1,
        ]);

        Testimonial::create([
            'client_name' => 'Monsieur Jean MBARGA',
            'client_city' => 'Douala',
            'content' => 'J\'ai effectué mon OUMRA avec SAFIR et tout s\'est très bien passé. Organisation impeccable, guide compétent. Merci à toute l\'équipe !',
            'service_type' => 'oumra',
            'rating' => 5,
            'is_featured' => true,
            'created_by' => 1,
        ]);

        Testimonial::create([
            'client_name' => 'Dr. Marie FOTSO',
            'client_city' => 'Bafoussam',
            'content' => 'Pour mes voyages d\'affaires, je fais toujours confiance à SAFIR. Ils trouvent toujours les meilleurs tarifs et le service est rapide.',
            'service_type' => 'billets',
            'rating' => 4,
            'is_featured' => true,
            'created_by' => 1,
        ]);

        Testimonial::create([
            'client_name' => 'Famille NGUEMA',
            'client_city' => 'Bertoua',
            'content' => 'Notre voyage de famille en Turquie organisé par SAFIR était fantastique. Tout était bien planifié, merci !',
            'service_type' => 'voyages',
            'rating' => 5,
            'is_featured' => true,
            'created_by' => 1,
        ]);

        Testimonial::create([
            'client_name' => 'Imam IBRAHIM',
            'client_city' => 'Garoua',
            'content' => 'En tant qu\'imam, j\'apprécie la qualité spirituelle des voyages SAFIR. Leurs encadreurs sont compétents et pieux.',
            'service_type' => 'hadj',
            'rating' => 5,
            'is_featured' => true,
            'created_by' => 1,
        ]);
    }
}