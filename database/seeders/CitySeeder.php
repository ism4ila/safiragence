<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::create(['name' => 'Bertoua', 'region' => 'ENIA', 'country' => 'Cameroun', 'is_active' => true, 'sort_order' => 1]);
        City::create(['name' => 'Yaoundé', 'region' => 'Centre', 'country' => 'Cameroun', 'is_active' => true, 'sort_order' => 2]);
        City::create(['name' => 'Douala', 'region' => 'Littoral', 'country' => 'Cameroun', 'is_active' => true, 'sort_order' => 3]);
        City::create(['name' => 'Bafoussam', 'region' => 'Ouest', 'country' => 'Cameroun', 'is_active' => true, 'sort_order' => 4]);
        City::create(['name' => 'Bamenda', 'region' => 'Nord-Ouest', 'country' => 'Cameroun', 'is_active' => true, 'sort_order' => 5]);
        City::create(['name' => 'Garoua', 'region' => 'Nord', 'country' => 'Cameroun', 'is_active' => true, 'sort_order' => 6]);
        City::create(['name' => 'Maroua', 'region' => 'Extrême-Nord', 'country' => 'Cameroun', 'is_active' => true, 'sort_order' => 7]);
        City::create(['name' => 'Ngaoundéré', 'region' => 'Adamaoua', 'country' => 'Cameroun', 'is_active' => true, 'sort_order' => 8]);
        City::create(['name' => 'Ebolowa', 'region' => 'Sud', 'country' => 'Cameroun', 'is_active' => true, 'sort_order' => 9]);
        City::create(['name' => 'Kribi', 'region' => 'Sud', 'country' => 'Cameroun', 'is_active' => true, 'sort_order' => 10]);
    }
}