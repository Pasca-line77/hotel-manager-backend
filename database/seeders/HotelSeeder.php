<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = [
            
            [
                'name' => 'Hôtel Splendid Ouaga',
                'description' => 'Hôtel 5 étoiles au cœur de la capitale burkinabè',
                'address' => 'Avenue Kwame Nkrumah',
                'city' => 'Ouagadougou',
                'country' => 'Burkina Faso',
                'phone' => '+226 25 30 12 34',
                'email' => 'contact@splendidouaga.bf',
                'stars' => 5,
                'price_per_night' => 45000.00,
                'amenities' => json_encode(['wifi', 'piscine', 'spa', 'restaurant', 'climatisation', 'parking sécurisé']),
                'images' => json_encode(['ouaga1.jpg', 'ouaga2.jpg']),
                'is_active' => true
            ],
            [
                'name' => 'Hôtel Independence',
                'description' => 'Hôtel historique près de la Place de la Révolution',
                'address' => 'Boulevard de la Revolution',
                'city' => 'Ouagadougou',
                'country' => 'Burkina Faso',
                'phone' => '+226 25 31 45 67',
                'email' => 'info@independencehotel.bf',
                'stars' => 4,
                'price_per_night' => 35000.00,
                'amenities' => json_encode(['wifi', 'restaurant', 'bar', 'salle de conférence']),
                'images' => json_encode(['independence1.jpg']),
                'is_active' => true
            ],
            [
                'name' => 'Hôtel Pacific Ouaga',
                'description' => 'Hôtel économique au centre-ville',
                'address' => 'Avenue de la Nation',
                'city' => 'Ouagadougou',
                'country' => 'Burkina Faso',
                'phone' => '+226 25 33 44 55',
                'email' => 'accueil@pacificouaga.bf',
                'stars' => 3,
                'price_per_night' => 22000.00,
                'amenities' => json_encode(['wifi', 'restaurant', 'climatisation']),
                'images' => json_encode(['pacific1.jpg']),
                'is_active' => true
            ],

            
            [
                'name' => 'Hôtel Bobo Plaza',
                'description' => 'Hôtel de standing dans la capitale économique',
                'address' => 'Avenue de la République',
                'city' => 'Bobo-Dioulasso',
                'country' => 'Burkina Faso',
                'phone' => '+226 20 98 76 54',
                'email' => 'info@boboplaza.bf',
                'stars' => 4,
                'price_per_night' => 32000.00,
                'amenities' => json_encode(['wifi', 'piscine', 'restaurant', 'climatisation']),
                'images' => json_encode(['boboplaza1.jpg']),
                'is_active' => true
            ],
            [
                'name' => 'Hôtel Farakan',
                'description' => 'Hôtel moderne avec vue sur la ville',
                'address' => 'Route de Banfora',
                'city' => 'Bobo-Dioulasso',
                'country' => 'Burkina Faso',
                'phone' => '+226 20 87 65 43',
                'email' => 'reservation@farakanhotel.bf',
                'stars' => 3,
                'price_per_night' => 28000.00,
                'amenities' => json_encode(['wifi', 'restaurant', 'bar']),
                'images' => json_encode(['farakan1.jpg']),
                'is_active' => true
            ],

           
            [
                'name' => 'Hôtel Teranga Dakar',
                'description' => 'Hôtel 5 étoiles avec vue sur l\'océan Atlantique',
                'address' => 'Corniche Ouest',
                'city' => 'Dakar',
                'country' => 'Sénégal',
                'phone' => '+221 33 823 45 67',
                'email' => 'reservation@terangadakar.sn',
                'stars' => 5,
                'price_per_night' => 85000.00,
                'amenities' => json_encode(['wifi', 'piscine', 'spa', 'plage privée', 'restaurant gastronomique']),
                'images' => json_encode(['teranga1.jpg', 'teranga2.jpg']),
                'is_active' => true
            ],
            [
                'name' => 'Hôtel Radisson Blu',
                'description' => 'Hôtel international au cœur du quartier des affaires',
                'address' => 'Route de la Corniche',
                'city' => 'Dakar',
                'country' => 'Sénégal',
                'phone' => '+221 33 869 33 33',
                'email' => 'reservation@radissondakar.sn',
                'stars' => 4,
                'price_per_night' => 65000.00,
                'amenities' => json_encode(['wifi', 'piscine', 'restaurant', 'fitness center']),
                'images' => json_encode(['radisson1.jpg']),
                'is_active' => true
            ],
            [
                'name' => 'Hôtel du Plateau',
                'description' => 'Hôtel économique dans le centre administratif',
                'address' => 'Avenue William Ponty',
                'city' => 'Dakar',
                'country' => 'Sénégal',
                'phone' => '+221 33 821 23 45',
                'email' => 'info@hotelduplateau.sn',
                'stars' => 3,
                'price_per_night' => 35000.00,
                'amenities' => json_encode(['wifi', 'restaurant', 'climatisation']),
                'images' => json_encode(['plateau1.jpg']),
                'is_active' => true
            ]
        ];

        foreach ($hotels as $hotelData) {
            Hotel::create($hotelData);
        }
    }
}