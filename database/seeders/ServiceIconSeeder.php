<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'Vente de billets d\'avion' => 'bi bi-airplane',
            'Organisation du HADJ et OUMRA' => 'bi bi-moon-stars',
            'Voyages et séjours' => 'bi bi-map',
            'Réservation d\'hôtel' => 'bi bi-building',
            'Location automobiles' => 'bi bi-car-front',
        ];

        foreach ($services as $title => $icon) {
            Service::where('title', $title)->update(['icon' => $icon]);
        }
    }
}
