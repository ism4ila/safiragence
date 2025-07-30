<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GalleryImage;

class GalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GalleryImage::create([
            'title' => 'Groupe HADJ 2023',
            'description' => 'Notre groupe de pèlerins lors du HADJ 2023 à la Grande Mosquée de La Mecque',
            'image_path' => 'gallery/hadj_2023_group.jpg',
            'category' => 'hadj',
            'is_featured' => true,
            'sort_order' => 1,
            'created_by' => 1,
        ]);

        GalleryImage::create([
            'title' => 'OUMRA Février 2024',
            'description' => 'Pèlerins effectuant l\'OUMRA en février 2024',
            'image_path' => 'gallery/oumra_feb_2024.jpg',
            'category' => 'oumra',
            'is_featured' => true,
            'sort_order' => 2,
            'created_by' => 1,
        ]);

        GalleryImage::create([
            'title' => 'Équipe SAFIR',
            'description' => 'Notre équipe professionnelle au siège de Bertoua',
            'image_path' => 'gallery/team_safir.jpg',
            'category' => 'team',
            'is_featured' => true,
            'sort_order' => 3,
            'created_by' => 1,
        ]);

        GalleryImage::create([
            'title' => 'Voyage Istanbul',
            'description' => 'Séjour touristique à Istanbul - Mosquée Bleue',
            'image_path' => 'gallery/istanbul_trip.jpg',
            'category' => 'tourism',
            'is_featured' => true,
            'sort_order' => 4,
            'created_by' => 1,
        ]);

        GalleryImage::create([
            'title' => 'Formation encadreurs',
            'description' => 'Session de formation de nos encadreurs spirituels',
            'image_path' => 'gallery/training_session.jpg',
            'category' => 'training',
            'is_featured' => false,
            'sort_order' => 5,
            'created_by' => 1,
        ]);
    }
}