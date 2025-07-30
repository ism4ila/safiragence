<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create(['setting_key' => 'site_name', 'setting_value' => 'SAFIR', 'description' => 'Nom du site']);
        SiteSetting::create(['setting_key' => 'site_tagline', 'setting_value' => 'Agence de voyages et de tourisme', 'description' => 'Slogan du site']);
        SiteSetting::create(['setting_key' => 'site_description', 'setting_value' => 'SAFIR est votre agence de confiance spécialisée dans l\'organisation du HADJ et OUMRA, la vente de billets d\'avion, les voyages d\'affaires et le tourisme.', 'description' => 'Description du site']);
        SiteSetting::create(['setting_key' => 'contact_email', 'setting_value' => 'safir.agence.cameroun@gmail.com', 'description' => 'Email de contact principal']);
        SiteSetting::create(['setting_key' => 'contact_phone', 'setting_value' => '+237 222 24 30 84', 'description' => 'Téléphone principal']);
        SiteSetting::create(['setting_key' => 'contact_phone_2', 'setting_value' => '+237 680 57 09 94', 'description' => 'Téléphone secondaire']);
        SiteSetting::create(['setting_key' => 'address', 'setting_value' => 'Immeuble SPC, avant carrefour aviation, Bertoua, ENIA', 'description' => 'Adresse complète']);
        SiteSetting::create(['setting_key' => 'city', 'setting_value' => 'Bertoua', 'description' => 'Ville']);
        SiteSetting::create(['setting_key' => 'region', 'setting_value' => 'ENIA', 'description' => 'Région']);
        SiteSetting::create(['setting_key' => 'country', 'setting_value' => 'Cameroun', 'description' => 'Pays']);
        SiteSetting::create(['setting_key' => 'postal_code', 'setting_value' => '', 'description' => 'Code postal']);
        SiteSetting::create(['setting_key' => 'whatsapp_number', 'setting_value' => '+237680570994', 'description' => 'Numéro WhatsApp']);
        SiteSetting::create(['setting_key' => 'facebook_url', 'setting_value' => 'https://facebook.com/safir.agence.cameroun', 'description' => 'URL Facebook']);
        SiteSetting::create(['setting_key' => 'instagram_url', 'setting_value' => '', 'description' => 'URL Instagram']);
        SiteSetting::create(['setting_key' => 'twitter_url', 'setting_value' => '', 'description' => 'URL Twitter']);
        SiteSetting::create(['setting_key' => 'linkedin_url', 'setting_value' => '', 'description' => 'URL LinkedIn']);
        SiteSetting::create(['setting_key' => 'youtube_url', 'setting_value' => '', 'description' => 'URL YouTube']);
        SiteSetting::create(['setting_key' => 'google_maps_url', 'setting_value' => 'https://maps.google.com/?q=Bertoua+Cameroun', 'description' => 'URL Google Maps']);
        SiteSetting::create(['setting_key' => 'business_hours', 'setting_value' => 'Lundi - Vendredi: 08h00 - 18h00, Samedi: 08h00 - 14h00', 'description' => 'Horaires d\'ouverture']);
        SiteSetting::create(['setting_key' => 'license_number', 'setting_value' => 'LT-001-CM', 'description' => 'Numéro de licence']);
        SiteSetting::create(['setting_key' => 'founded_year', 'setting_value' => '2015', 'description' => 'Année de création']);
        SiteSetting::create(['setting_key' => 'meta_keywords', 'setting_value' => 'SAFIR, agence voyage, Bertoua, Cameroun, HADJ, OUMRA, pèlerinage, billets avion, tourisme', 'description' => 'Mots-clés SEO']);
        SiteSetting::create(['setting_key' => 'google_analytics_id', 'setting_value' => '', 'description' => 'ID Google Analytics']);
        SiteSetting::create(['setting_key' => 'facebook_pixel_id', 'setting_value' => '', 'description' => 'ID Facebook Pixel']);
    }
}