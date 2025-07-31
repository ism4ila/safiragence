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
            'city_id' => 1, // Batouri
            'full_name' => 'DJOUBAIROU NANA',
            'phone_1' => '674412827',
            'email' => 'djoubairou.nana@safir.cm',
            'specialties' => 'HADJ|OUMRA|Spiritualité',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 1, // Batouri
            'full_name' => 'IDRISSOU HAMADOU',
            'phone_1' => '677223713',
            'email' => 'idrissou.hamadou@safir.cm',
            'specialties' => 'Organisation|Logistique',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 2, // Bertoua
            'full_name' => 'ADAMOU ABDOULLAHI',
            'phone_1' => '699664921',
            'email' => 'adamou.abdoullahi@safir.cm',
            'specialties' => 'HADJ|OUMRA|Accompagnement',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 6, // Garoua et Rey
            'full_name' => 'CHEHOU OUSMANOU MANA',
            'phone_1' => '690661872',
            'email' => 'chehou.ousmanou@safir.cm',
            'specialties' => 'Vente|Conseil',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 6, // Garoua-Boulai
            'full_name' => 'OUSMANOU HAMADOU',
            'phone_1' => '675655329',
            'email' => 'ousmanou.hamadou@safir.cm',
            'specialties' => 'HADJ|OUMRA|Formation',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 6, // Garoua-Boulai
            'full_name' => 'ABOUBAKAR ALI',
            'phone_1' => '699272631',
            'email' => 'aboubakar.ali@safir.cm',
            'specialties' => 'Logistique|Suivi',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 4, // Mandjou
            'full_name' => 'OUSTAZ SALE',
            'phone_1' => '675042190',
            'email' => 'oustaz.sale@safir.cm',
            'specialties' => 'HADJ|OUMRA|Langues',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 4, // Mandjou
            'full_name' => 'ALH SOUAIBOU HAROUNA',
            'phone_1' => '657574516',
            'email' => 'alh.souaibou@safir.cm',
            'specialties' => 'HADJ|OUMRA|Anglais',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 8, // Ngaoundéré
            'full_name' => 'ADAMOU ABOUBAKAR GORDI',
            'phone_1' => '679829923',
            'email' => 'adamou.aboubakar@safir.cm',
            'specialties' => 'HADJ|OUMRA|Arabe',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 8, // Ngaoundéré
            'full_name' => 'DALAILOU BIA',
            'phone_1' => '679632298',
            'email' => 'dalailou.bia@safir.cm',
            'specialties' => 'OUMRA|Accompagnement féminin',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 8, // Ngaoundéré
            'full_name' => 'IBRAHIM AHMED',
            'phone_1' => '679623450',
            'email' => 'ibrahim.ahmed@safir.cm',
            'specialties' => 'HADJ|OUMRA|Spiritualité',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 8, // Ngaoundéré
            'full_name' => 'OUSTAZ MAHMOUD GONI',
            'phone_1' => '699851911',
            'email' => 'oustaz.mahmoud@safir.cm',
            'specialties' => 'HADJ|OUMRA|Formation',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 3, // Yaoundé
            'full_name' => 'MOUHAMADOU HABIB',
            'phone_1' => '699933153',
            'email' => 'mouhamadou.habib@safir.cm',
            'specialties' => 'HADJ|OUMRA|Spiritualité',
            'is_active' => true,
        ]);

        Encadreur::create([
            'city_id' => 3, // Yaoundé
            'full_name' => 'SAIDOU BAOURO',
            'phone_1' => '699988201',
            'email' => 'saidou.baouro@safir.cm',
            'specialties' => 'Organisation|Logistique',
            'is_active' => true,
        ]);
    }
}
