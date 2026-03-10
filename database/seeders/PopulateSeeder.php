<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\GuestReview;
use App\Models\HostDocument;
use App\Models\HostPayout;
use App\Models\Listing;
use App\Models\ListingPhoto;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class PopulateSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================================
        // 4 HOTES
        // =====================================================================

        $hosts = [
            [
                'first_name' => 'Emily',
                'last_name' => 'Hote',
                'email' => 'hoteemily@gmail.com',
                'password' => bcrypt('123456789'),
                'role' => 'user',
                'birth_date' => '1990-04-15',
                'phone' => '+14185551001',
                'phone_country_code' => 'CA',
                'address_street' => '245 Rue Saint-Jean',
                'address_city' => 'Quebec',
                'address_postal_code' => 'G1R 1N8',
                'address_country' => 'Canada',
                'bio' => "Passionnee de voyage et de decoration interieure, j'adore accueillir des voyageurs du monde entier dans mes logements soigneusement amenages. Superhote depuis 3 ans.",
                'city' => 'Quebec',
                'profession' => 'Architecte d\'interieur',
                'languages_spoken' => ['Francais', 'English', 'Espanol'],
                'interests' => ['Decoration', 'Voyage', 'Cuisine', 'Yoga'],
                'profile_photo_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop&crop=face',
                'preferred_language' => 'fr',
                'preferred_currency' => 'CAD',
                'timezone' => 'America/Montreal',
                'phone_verified' => true,
                'identity_verified' => true,
                'bank_verified' => true,
                'address_verified' => true,
                'email_verified_at' => now()->subMonths(8),
                'verification_date' => now()->subMonths(7),
                'fraud_score' => 3,
                'last_login_at' => now()->subHours(2),
                'last_login_ip' => '192.168.1.45',
                'last_login_device' => 'Chrome / macOS',
                'login_count' => 156,
                'client_status' => 'ACTIF',
                'host_status' => 'ACTIF',
                'created_at' => now()->subMonths(8),
            ],
            [
                'first_name' => 'Pascal',
                'last_name' => 'Hote',
                'email' => 'hotepascal@gmail.com',
                'password' => bcrypt('123456789'),
                'role' => 'user',
                'birth_date' => '1985-11-22',
                'phone' => '+14385552002',
                'phone_country_code' => 'CA',
                'address_street' => '78 Boulevard des Laurentides',
                'address_city' => 'Montreal',
                'address_postal_code' => 'H2T 1R8',
                'address_country' => 'Canada',
                'bio' => "Entrepreneur et amateur de plein air, je possede plusieurs chalets dans les Laurentides. J'offre des experiences uniques en nature avec tout le confort moderne.",
                'city' => 'Montreal',
                'profession' => 'Entrepreneur',
                'languages_spoken' => ['Francais', 'English'],
                'interests' => ['Randonnee', 'Ski', 'Gastronomie', 'Photographie'],
                'profile_photo_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face',
                'preferred_language' => 'fr',
                'preferred_currency' => 'CAD',
                'timezone' => 'America/Montreal',
                'phone_verified' => true,
                'identity_verified' => true,
                'bank_verified' => true,
                'address_verified' => true,
                'email_verified_at' => now()->subMonths(12),
                'verification_date' => now()->subMonths(11),
                'fraud_score' => 2,
                'last_login_at' => now()->subHours(5),
                'last_login_ip' => '10.0.0.88',
                'last_login_device' => 'Safari / iPhone',
                'login_count' => 234,
                'client_status' => 'ACTIF',
                'host_status' => 'ACTIF',
                'created_at' => now()->subMonths(12),
            ],
            [
                'first_name' => 'Lucas',
                'last_name' => 'Hote',
                'email' => 'hotelucas@gmail.com',
                'password' => bcrypt('123456789'),
                'role' => 'user',
                'birth_date' => '1992-07-03',
                'phone' => '+15145553003',
                'phone_country_code' => 'CA',
                'address_street' => '12 Rue de la Montagne',
                'address_city' => 'Tremblant',
                'address_postal_code' => 'J8E 1A1',
                'address_country' => 'Canada',
                'bio' => "Guide de montagne et hote passionne, je propose des sejours authentiques au coeur des Laurentides. Mes logements sont des refuges chaleureux pour se ressourcer.",
                'city' => 'Tremblant',
                'profession' => 'Guide touristique',
                'languages_spoken' => ['Francais', 'English', 'Deutsch'],
                'interests' => ['Montagne', 'Escalade', 'Nature', 'Musique'],
                'profile_photo_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop&crop=face',
                'preferred_language' => 'fr',
                'preferred_currency' => 'CAD',
                'timezone' => 'America/Montreal',
                'phone_verified' => true,
                'identity_verified' => true,
                'bank_verified' => false,
                'address_verified' => true,
                'email_verified_at' => now()->subMonths(6),
                'verification_date' => now()->subMonths(5),
                'fraud_score' => 5,
                'last_login_at' => now()->subDay(),
                'last_login_ip' => '172.16.0.12',
                'last_login_device' => 'Firefox / Windows',
                'login_count' => 89,
                'client_status' => 'ACTIF',
                'host_status' => 'ACTIF',
                'created_at' => now()->subMonths(6),
            ],
            [
                'first_name' => 'Romeo',
                'last_name' => 'Hote',
                'email' => 'hoteromeo@gmail.com',
                'password' => bcrypt('123456789'),
                'role' => 'user',
                'birth_date' => '1988-01-18',
                'phone' => '+15815554004',
                'phone_country_code' => 'CA',
                'address_street' => '560 Chemin du Lac',
                'address_city' => 'Sherbrooke',
                'address_postal_code' => 'J1L 2J9',
                'address_country' => 'Canada',
                'bio' => "Ancien chef cuisinier reconverti dans l'hebergement touristique. Mes logements offrent une experience gastronomique avec un livret de recettes locales a chaque sejour.",
                'city' => 'Sherbrooke',
                'profession' => 'Chef cuisinier / Hotelier',
                'languages_spoken' => ['Francais', 'English', 'Italiano'],
                'interests' => ['Cuisine', 'Vin', 'Jardinage', 'Architecture'],
                'profile_photo_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop&crop=face',
                'preferred_language' => 'fr',
                'preferred_currency' => 'CAD',
                'timezone' => 'America/Montreal',
                'phone_verified' => true,
                'identity_verified' => true,
                'bank_verified' => true,
                'address_verified' => true,
                'email_verified_at' => now()->subMonths(10),
                'verification_date' => now()->subMonths(9),
                'fraud_score' => 1,
                'last_login_at' => now()->subHours(8),
                'last_login_ip' => '192.168.0.22',
                'last_login_device' => 'Chrome / Android',
                'login_count' => 198,
                'client_status' => 'ACTIF',
                'host_status' => 'ACTIF',
                'created_at' => now()->subMonths(10),
            ],
        ];

        $hostUsers = [];
        foreach ($hosts as $hostData) {
            $hostUsers[] = User::create($hostData);
        }

        // ── Host Documents ──────────────────────────────────────────────────
        foreach ($hostUsers as $host) {
            HostDocument::create(['user_id' => $host->id, 'name' => 'Piece d\'identite', 'status' => 'APPROUVE']);
            HostDocument::create(['user_id' => $host->id, 'name' => 'Preuve d\'adresse', 'status' => 'APPROUVE']);
        }

        // =====================================================================
        // LISTINGS (2 par hote = 8 listings)
        // =====================================================================

        $listingsData = [
            // ── Emily: 2 listings ───────────────────────────────────────────
            [
                'user' => 0,
                'listing' => [
                    'status' => 'active',
                    'title' => 'Loft lumineux au coeur du Vieux-Quebec',
                    'subtitle' => 'Loft design avec vue sur le fleuve Saint-Laurent',
                    'space_type' => 'Logement entier : appartement',
                    'rental_frequency' => 'frequent',
                    'full_address' => '245 Rue Saint-Jean, Quebec, QC, Canada',
                    'street' => '245 Rue Saint-Jean',
                    'city' => 'Quebec',
                    'province' => 'Quebec',
                    'country' => 'Canada',
                    'latitude' => 46.8139,
                    'longitude' => -71.2080,
                    'capacity' => 4,
                    'adults' => 4,
                    'bathrooms' => 1,
                    'bedrooms_data' => [
                        ['name' => 'Chambre principale', 'beds' => [['type' => 'lit queen', 'count' => 1]]],
                        ['name' => 'Salon', 'beds' => [['type' => 'canape-lit', 'count' => 1]]],
                    ],
                    'open_areas_data' => [
                        ['name' => 'Espace de vie', 'beds' => []],
                    ],
                    'amenities' => ['wifi', 'cuisine', 'television', 'climatisation', 'lave_linge', 'seche_cheveux', 'espace_travail', 'stationnement'],
                    'description' => "Magnifique loft de 65m2 entierement renove au coeur du Vieux-Quebec. Grandes fenetres offrant une luminosite exceptionnelle et une vue imprenable sur le fleuve Saint-Laurent. Decoration moderne et chaleureuse avec des materiaux nobles.",
                    'about_chalet' => "Le loft dispose d'une cuisine complete, d'un salon spacieux, d'une chambre avec lit queen et d'une salle de bain moderne. Le canape-lit permet d'accueillir jusqu'a 4 personnes confortablement.",
                    'neighborhood' => 'Quartier historique du Vieux-Quebec, classee au patrimoine mondial de l\'UNESCO.',
                    'transport' => 'Bus a 1 minute. Gare du Palais a 10 min a pied.',
                    'base_price' => 145.00,
                    'weekend_price' => 175.00,
                    'weekly_price' => 900.00,
                    'cleaning_fee' => 45.00,
                    'security_deposit' => 200.00,
                    'currency' => 'CAD',
                    'cancellation_policy' => 'moderate',
                    'arrival_time' => '15:00',
                    'departure_time' => '11:00',
                    'min_age' => 18,
                    'min_stay' => 2,
                    'reservation_mode' => 'instant',
                    'has_wifi' => true,
                    'wifi_speed' => '200 Mbps',
                    'checkin_method' => 'lockbox',
                    'checkin_instructions' => 'Code de la boite a cles communique 24h avant.',
                    'accepted_local_laws' => true,
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1560185893-a55cbc8c57e8?w=1080&fit=max',
                ],
            ],
            [
                'user' => 0,
                'listing' => [
                    'status' => 'active',
                    'title' => 'Maison de charme a l\'Ile d\'Orleans',
                    'subtitle' => 'Escapade champetre avec vue sur le fleuve',
                    'space_type' => 'Logement entier : maison',
                    'rental_frequency' => 'occasional',
                    'full_address' => 'Ile d\'Orleans, Quebec, Canada',
                    'street' => '120 Chemin Royal',
                    'city' => 'Ile d\'Orleans',
                    'province' => 'Quebec',
                    'country' => 'Canada',
                    'latitude' => 46.9087,
                    'longitude' => -70.9742,
                    'capacity' => 6,
                    'adults' => 6,
                    'bathrooms' => 2,
                    'bedrooms_data' => [
                        ['name' => 'Chambre 1', 'beds' => [['type' => 'lit king', 'count' => 1]]],
                        ['name' => 'Chambre 2', 'beds' => [['type' => 'lit double', 'count' => 1]]],
                        ['name' => 'Chambre 3', 'beds' => [['type' => 'lit simple', 'count' => 2]]],
                    ],
                    'open_areas_data' => [],
                    'amenities' => ['wifi', 'cuisine', 'television', 'foyer', 'bbq', 'terrasse', 'stationnement', 'lave_linge'],
                    'description' => "Charmante maison patrimoniale sur l'Ile d'Orleans, entouree de vergers et de champs. Vue spectaculaire sur le fleuve Saint-Laurent. Parfaite pour une escapade en famille ou entre amis.",
                    'about_chalet' => "Maison de 3 chambres avec cachet d'epoque, cuisine entierement equipee, salon avec foyer, grande terrasse avec BBQ. Terrain prive avec acces direct au fleuve.",
                    'neighborhood' => 'Ile d\'Orleans, connue pour ses produits du terroir et ses paysages bucoliques.',
                    'transport' => 'Voiture recommandee. Pont de l\'Ile a 5 minutes.',
                    'base_price' => 220.00,
                    'weekend_price' => 260.00,
                    'weekly_price' => 1350.00,
                    'cleaning_fee' => 65.00,
                    'security_deposit' => 350.00,
                    'currency' => 'CAD',
                    'cancellation_policy' => 'strict',
                    'arrival_time' => '16:00',
                    'departure_time' => '11:00',
                    'min_age' => 21,
                    'min_stay' => 2,
                    'reservation_mode' => 'request',
                    'has_wifi' => true,
                    'wifi_speed' => '50 Mbps',
                    'checkin_method' => 'in_person',
                    'checkin_instructions' => 'Je vous accueillerai personnellement a votre arrivee.',
                    'accepted_local_laws' => true,
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1600573472550-8090b5e0745e?w=1080&fit=max',
                ],
            ],
            // ── Pascal: 2 listings ──────────────────────────────────────────
            [
                'user' => 1,
                'listing' => [
                    'status' => 'active',
                    'title' => 'Chalet rustique dans les Laurentides',
                    'subtitle' => 'Retraite en nature avec spa et foyer',
                    'space_type' => 'Logement entier : chalet',
                    'rental_frequency' => 'frequent',
                    'full_address' => 'Saint-Sauveur, Laurentides, Quebec, Canada',
                    'street' => '88 Chemin du Sommet',
                    'city' => 'Saint-Sauveur',
                    'province' => 'Quebec',
                    'country' => 'Canada',
                    'latitude' => 45.9003,
                    'longitude' => -74.1701,
                    'capacity' => 8,
                    'adults' => 8,
                    'bathrooms' => 2,
                    'bedrooms_data' => [
                        ['name' => 'Suite principale', 'beds' => [['type' => 'lit king', 'count' => 1]]],
                        ['name' => 'Chambre montagne', 'beds' => [['type' => 'lit queen', 'count' => 1]]],
                        ['name' => 'Dortoir', 'beds' => [['type' => 'lit superpose', 'count' => 2]]],
                    ],
                    'open_areas_data' => [
                        ['name' => 'Mezzanine', 'beds' => [['type' => 'futon', 'count' => 1]]],
                    ],
                    'amenities' => ['wifi', 'cuisine', 'foyer', 'spa', 'bbq', 'terrasse', 'stationnement', 'raquettes', 'jeux_societe'],
                    'description' => "Chalet en bois rond niché au sommet d'une colline boisee. Vue panoramique sur les montagnes des Laurentides. Ideal pour les amateurs de plein air ete comme hiver.",
                    'about_chalet' => "Chalet de 3 chambres avec mezzanine, grand salon avec foyer en pierre, cuisine champetre equipee, spa 6 places sur le balcon avec vue sur la foret. Sentiers de randonnee accessibles a pied.",
                    'neighborhood' => 'Au coeur des Laurentides, a 5 min du village de Saint-Sauveur.',
                    'transport' => 'Voiture obligatoire. Stationnement pour 3 vehicules.',
                    'base_price' => 295.00,
                    'weekend_price' => 350.00,
                    'weekly_price' => 1800.00,
                    'cleaning_fee' => 85.00,
                    'security_deposit' => 500.00,
                    'currency' => 'CAD',
                    'cancellation_policy' => 'moderate',
                    'arrival_time' => '16:00',
                    'departure_time' => '11:00',
                    'min_age' => 21,
                    'min_stay' => 2,
                    'reservation_mode' => 'instant',
                    'has_wifi' => true,
                    'wifi_speed' => '75 Mbps',
                    'checkin_method' => 'lockbox',
                    'checkin_instructions' => 'Boite a cles sur le pilier gauche du porche. Code envoye par SMS.',
                    'accepted_local_laws' => true,
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1587061949409-02df41d5e562?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1595521624992-48a59aef95e3?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1521401830884-6c03c1c87ebb?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1604014237800-1c9102c219da?w=1080&fit=max',
                ],
            ],
            [
                'user' => 1,
                'listing' => [
                    'status' => 'active',
                    'title' => 'Condo moderne au centre-ville de Montreal',
                    'subtitle' => 'Design contemporain au Plateau Mont-Royal',
                    'space_type' => 'Logement entier : appartement',
                    'rental_frequency' => 'frequent',
                    'full_address' => 'Plateau Mont-Royal, Montreal, QC, Canada',
                    'street' => '3456 Avenue du Parc',
                    'city' => 'Montreal',
                    'province' => 'Quebec',
                    'country' => 'Canada',
                    'latitude' => 45.5200,
                    'longitude' => -73.5900,
                    'capacity' => 3,
                    'adults' => 3,
                    'bathrooms' => 1,
                    'bedrooms_data' => [
                        ['name' => 'Chambre', 'beds' => [['type' => 'lit queen', 'count' => 1]]],
                    ],
                    'open_areas_data' => [
                        ['name' => 'Salon', 'beds' => [['type' => 'canape-lit', 'count' => 1]]],
                    ],
                    'amenities' => ['wifi', 'cuisine', 'television', 'climatisation', 'lave_linge', 'espace_travail', 'velo'],
                    'description' => "Condo au design epure situe sur le Plateau Mont-Royal, a deux pas des meilleurs restos, cafes et boutiques de Montreal. Parfait pour decouvrir la ville.",
                    'about_chalet' => "Appartement d'une chambre avec salon ouvert, cuisine moderne avec ilot, salle de bain avec douche a l'italienne. Velos mis a disposition.",
                    'neighborhood' => 'Le Plateau Mont-Royal, quartier boheme et vibrant de Montreal.',
                    'transport' => 'Metro Mont-Royal a 3 min. Bixi devant l\'immeuble.',
                    'base_price' => 125.00,
                    'weekend_price' => 150.00,
                    'weekly_price' => 750.00,
                    'cleaning_fee' => 35.00,
                    'security_deposit' => 150.00,
                    'currency' => 'CAD',
                    'cancellation_policy' => 'flexible',
                    'arrival_time' => '14:00',
                    'departure_time' => '11:00',
                    'min_age' => 18,
                    'min_stay' => 1,
                    'reservation_mode' => 'instant',
                    'has_wifi' => true,
                    'wifi_speed' => '300 Mbps',
                    'checkin_method' => 'smart_lock',
                    'checkin_instructions' => 'Code unique envoye par email le jour de l\'arrivee.',
                    'accepted_local_laws' => true,
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1554995207-c18c203602cb?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1556909114-44e3e70034e2?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1585128903994-9788298932a4?w=1080&fit=max',
                ],
            ],
            // ── Lucas: 2 listings ───────────────────────────────────────────
            [
                'user' => 2,
                'listing' => [
                    'status' => 'active',
                    'title' => 'Cabane dans les arbres a Tremblant',
                    'subtitle' => 'Experience unique en hauteur dans la foret',
                    'space_type' => 'Logement entier : cabane',
                    'rental_frequency' => 'occasional',
                    'full_address' => 'Mont-Tremblant, Quebec, Canada',
                    'street' => '55 Sentier des Cimes',
                    'city' => 'Mont-Tremblant',
                    'province' => 'Quebec',
                    'country' => 'Canada',
                    'latitude' => 46.2094,
                    'longitude' => -74.5850,
                    'capacity' => 2,
                    'adults' => 2,
                    'bathrooms' => 1,
                    'bedrooms_data' => [
                        ['name' => 'Nid douillet', 'beds' => [['type' => 'lit queen', 'count' => 1]]],
                    ],
                    'open_areas_data' => [],
                    'amenities' => ['chauffage', 'terrasse', 'vue_panoramique', 'petit_dejeuner_inclus'],
                    'description' => "Cabane perchee a 8 metres du sol au milieu d'une foret centenaire. Experience romantique et insolite avec vue panoramique sur la canopee. Petit-dejeuner livre dans un panier hisse par une poulie.",
                    'about_chalet' => "Cabane tout en bois avec lit queen ultra-confortable, chauffage au bois, terrasse suspendue et salle d'eau avec douche. Toilette seche ecologique.",
                    'neighborhood' => 'Foret privee a 10 min du village de Mont-Tremblant.',
                    'transport' => 'Voiture necessaire. Stationnement au pied de l\'arbre.',
                    'base_price' => 189.00,
                    'weekend_price' => 225.00,
                    'cleaning_fee' => 40.00,
                    'security_deposit' => 200.00,
                    'currency' => 'CAD',
                    'cancellation_policy' => 'strict',
                    'arrival_time' => '15:00',
                    'departure_time' => '10:00',
                    'min_age' => 18,
                    'min_stay' => 1,
                    'reservation_mode' => 'request',
                    'has_wifi' => false,
                    'checkin_method' => 'in_person',
                    'checkin_instructions' => 'Je vous guiderai personnellement jusqu\'a votre cabane.',
                    'accepted_local_laws' => true,
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1499696010180-025ef6e1a8f9?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1618767689160-da3fb810aad7?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1596178065887-1198b6148b2b?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=1080&fit=max',
                ],
            ],
            [
                'user' => 2,
                'listing' => [
                    'status' => 'active',
                    'title' => 'Cottage au bord du Lac Tremblant',
                    'subtitle' => 'Detente absolue au bord de l\'eau',
                    'space_type' => 'Logement entier : maison',
                    'rental_frequency' => 'frequent',
                    'full_address' => 'Lac Tremblant, Quebec, Canada',
                    'street' => '200 Chemin du Lac',
                    'city' => 'Mont-Tremblant',
                    'province' => 'Quebec',
                    'country' => 'Canada',
                    'latitude' => 46.2306,
                    'longitude' => -74.5700,
                    'capacity' => 5,
                    'adults' => 5,
                    'bathrooms' => 2,
                    'bedrooms_data' => [
                        ['name' => 'Chambre vue lac', 'beds' => [['type' => 'lit king', 'count' => 1]]],
                        ['name' => 'Chambre foret', 'beds' => [['type' => 'lit double', 'count' => 1], ['type' => 'lit simple', 'count' => 1]]],
                    ],
                    'open_areas_data' => [],
                    'amenities' => ['wifi', 'cuisine', 'foyer', 'canoe', 'kayak', 'terrasse', 'bbq', 'quai_prive', 'stationnement'],
                    'description' => "Cottage de charme avec acces prive au Lac Tremblant. Reveillez-vous avec le chant des huards et profitez du quai prive pour la baignade, le canoe ou la peche.",
                    'about_chalet' => "Cottage 2 chambres, salon avec foyer, cuisine complete, grande terrasse avec vue sur le lac, quai prive avec canoe et kayak inclus.",
                    'neighborhood' => 'Rive ouest du Lac Tremblant, secteur paisible.',
                    'transport' => 'Voiture necessaire. 15 min du village pietonnier.',
                    'base_price' => 265.00,
                    'weekend_price' => 310.00,
                    'weekly_price' => 1600.00,
                    'cleaning_fee' => 75.00,
                    'security_deposit' => 400.00,
                    'currency' => 'CAD',
                    'cancellation_policy' => 'moderate',
                    'arrival_time' => '16:00',
                    'departure_time' => '11:00',
                    'min_age' => 18,
                    'min_stay' => 2,
                    'reservation_mode' => 'instant',
                    'has_wifi' => true,
                    'wifi_speed' => '100 Mbps',
                    'checkin_method' => 'lockbox',
                    'checkin_instructions' => 'Cle dans la boite a cles pres de la porte. Code: envoye par SMS.',
                    'accepted_local_laws' => true,
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1575517111478-7f6afd0973db?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1505916349660-8d91a09afa5a?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1551524559-8af4e6624178?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1544984243-ec57ea16fe25?w=1080&fit=max',
                ],
            ],
            // ── Romeo: 2 listings ───────────────────────────────────────────
            [
                'user' => 3,
                'listing' => [
                    'status' => 'active',
                    'title' => 'Villa gastronomique a Sherbrooke',
                    'subtitle' => 'Sejour gourmand avec livret de recettes locales',
                    'space_type' => 'Logement entier : maison',
                    'rental_frequency' => 'frequent',
                    'full_address' => '560 Chemin du Lac, Sherbrooke, QC, Canada',
                    'street' => '560 Chemin du Lac',
                    'city' => 'Sherbrooke',
                    'province' => 'Quebec',
                    'country' => 'Canada',
                    'latitude' => 45.4042,
                    'longitude' => -71.8929,
                    'capacity' => 7,
                    'adults' => 7,
                    'bathrooms' => 3,
                    'bedrooms_data' => [
                        ['name' => 'Suite chef', 'beds' => [['type' => 'lit king', 'count' => 1]]],
                        ['name' => 'Chambre herbes', 'beds' => [['type' => 'lit queen', 'count' => 1]]],
                        ['name' => 'Chambre epices', 'beds' => [['type' => 'lit double', 'count' => 1], ['type' => 'lit simple', 'count' => 1]]],
                    ],
                    'open_areas_data' => [],
                    'amenities' => ['wifi', 'cuisine_pro', 'television', 'foyer', 'bbq', 'terrasse', 'jardin_potager', 'stationnement', 'climatisation'],
                    'description' => "Villa spacieuse avec cuisine professionnelle et jardin potager. Chaque sejour inclut un livret de recettes utilisant les produits du terroir estrien. Experience gastronomique unique.",
                    'about_chalet' => "Villa de 3 chambres avec cuisine professionnelle (four a convection, plaque a induction, batterie de cuisine complete), salle a manger pour 8, salon avec foyer, jardin potager biologique.",
                    'neighborhood' => 'Campagne estrienne, a 15 min du centre-ville de Sherbrooke.',
                    'transport' => 'Voiture recommandee. Stationnement gratuit.',
                    'base_price' => 245.00,
                    'weekend_price' => 295.00,
                    'weekly_price' => 1500.00,
                    'cleaning_fee' => 70.00,
                    'security_deposit' => 350.00,
                    'currency' => 'CAD',
                    'cancellation_policy' => 'moderate',
                    'arrival_time' => '15:00',
                    'departure_time' => '11:00',
                    'min_age' => 18,
                    'min_stay' => 2,
                    'reservation_mode' => 'instant',
                    'has_wifi' => true,
                    'wifi_speed' => '150 Mbps',
                    'checkin_method' => 'in_person',
                    'checkin_instructions' => 'Accueil personnalise avec visite guidee de la propriete et du potager.',
                    'accepted_local_laws' => true,
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1600585152220-90363fe7e115?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1416331108676-a22ccb276e35?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1600607687644-aac4c3eac7f4?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1592417817098-8fd3d9eb14a5?w=1080&fit=max',
                ],
            ],
            [
                'user' => 3,
                'listing' => [
                    'status' => 'active',
                    'title' => 'Studio cosy au centre de Magog',
                    'subtitle' => 'Nid douillet a deux pas du Lac Memphremagog',
                    'space_type' => 'Logement entier : appartement',
                    'rental_frequency' => 'frequent',
                    'full_address' => '15 Rue Principale, Magog, QC, Canada',
                    'street' => '15 Rue Principale',
                    'city' => 'Magog',
                    'province' => 'Quebec',
                    'country' => 'Canada',
                    'latitude' => 45.2668,
                    'longitude' => -72.1440,
                    'capacity' => 2,
                    'adults' => 2,
                    'bathrooms' => 1,
                    'bedrooms_data' => [
                        ['name' => 'Chambre', 'beds' => [['type' => 'lit queen', 'count' => 1]]],
                    ],
                    'open_areas_data' => [],
                    'amenities' => ['wifi', 'cuisine', 'television', 'climatisation', 'stationnement'],
                    'description' => "Studio chaleureux au centre de Magog, a 5 minutes a pied du Lac Memphremagog et des commerces. Ideal pour un couple en escapade dans les Cantons-de-l'Est.",
                    'about_chalet' => "Studio avec chambre separee, coin cuisine equipe, salon avec TV et salle de bain renovee. Decoration soignee et chaleureuse.",
                    'neighborhood' => 'Centre-ville de Magog, acces facile au lac et aux activites.',
                    'transport' => 'Tout a distance de marche. Stationnement inclus.',
                    'base_price' => 95.00,
                    'weekend_price' => 115.00,
                    'weekly_price' => 580.00,
                    'cleaning_fee' => 25.00,
                    'security_deposit' => 100.00,
                    'currency' => 'CAD',
                    'cancellation_policy' => 'flexible',
                    'arrival_time' => '14:00',
                    'departure_time' => '11:00',
                    'min_age' => 18,
                    'min_stay' => 1,
                    'reservation_mode' => 'instant',
                    'has_wifi' => true,
                    'wifi_speed' => '100 Mbps',
                    'checkin_method' => 'smart_lock',
                    'checkin_instructions' => 'Code d\'acces unique envoye par SMS le jour de l\'arrivee.',
                    'accepted_local_laws' => true,
                ],
                'photos' => [
                    'https://images.unsplash.com/photo-1630699144867-37acec97df5a?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1560185007-cde436f6a4d0?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1560185127-6ed189bf02f4?w=1080&fit=max',
                    'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=1080&fit=max',
                ],
            ],
        ];

        $listings = [];
        foreach ($listingsData as $ld) {
            $listing = Listing::create(array_merge(
                $ld['listing'],
                ['user_id' => $hostUsers[$ld['user']]->id]
            ));
            foreach ($ld['photos'] as $i => $url) {
                ListingPhoto::create([
                    'listing_id' => $listing->id,
                    'path' => $url,
                    'order' => $i,
                ]);
            }
            $listings[] = $listing;
        }

        // =====================================================================
        // 5 VOYAGEURS
        // =====================================================================

        $voyageurs = [
            [
                'first_name' => 'Paul',
                'last_name' => 'Voyageur',
                'email' => 'voyageurpaul@gmail.com',
                'password' => bcrypt('123456789'),
                'role' => 'user',
                'birth_date' => '1995-03-12',
                'phone' => '+33612345001',
                'phone_country_code' => 'FR',
                'address_street' => '14 Rue de Rivoli',
                'address_city' => 'Paris',
                'address_postal_code' => '75004',
                'address_country' => 'France',
                'bio' => "Voyageur passionné et photographe amateur. J'adore découvrir de nouvelles cultures à travers la gastronomie locale et les rencontres authentiques.",
                'city' => 'Paris',
                'profession' => 'Photographe',
                'languages_spoken' => ['Francais', 'English'],
                'interests' => ['Photographie', 'Gastronomie', 'Randonnee', 'Cinema'],
                'profile_photo_url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&h=400&fit=crop&crop=face',
                'preferred_language' => 'fr',
                'preferred_currency' => 'EUR',
                'timezone' => 'Europe/Paris',
                'phone_verified' => true,
                'identity_verified' => true,
                'email_verified_at' => now()->subMonths(5),
                'fraud_score' => 4,
                'last_login_at' => now()->subHours(3),
                'last_login_ip' => '86.192.44.12',
                'last_login_device' => 'Chrome / macOS',
                'login_count' => 67,
                'client_status' => 'ACTIF',
                'created_at' => now()->subMonths(5),
            ],
            [
                'first_name' => 'Juliette',
                'last_name' => 'Voyageur',
                'email' => 'voyageurjuliette@gmail.com',
                'password' => bcrypt('123456789'),
                'role' => 'user',
                'birth_date' => '1993-08-25',
                'phone' => '+33612345002',
                'phone_country_code' => 'FR',
                'address_street' => '22 Rue du Faubourg',
                'address_city' => 'Lyon',
                'address_postal_code' => '69002',
                'address_country' => 'France',
                'bio' => "Digital nomad et blogueuse voyage. Toujours a la recherche d'endroits uniques et de belles histoires a raconter.",
                'city' => 'Lyon',
                'profession' => 'Blogueuse / Redactrice',
                'languages_spoken' => ['Francais', 'English', 'Espanol'],
                'interests' => ['Ecriture', 'Yoga', 'Surf', 'Art'],
                'profile_photo_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=400&fit=crop&crop=face',
                'preferred_language' => 'fr',
                'preferred_currency' => 'EUR',
                'timezone' => 'Europe/Paris',
                'phone_verified' => true,
                'identity_verified' => true,
                'email_verified_at' => now()->subMonths(4),
                'fraud_score' => 2,
                'last_login_at' => now()->subHours(6),
                'last_login_ip' => '176.128.33.89',
                'last_login_device' => 'Safari / iPhone',
                'login_count' => 45,
                'client_status' => 'ACTIF',
                'created_at' => now()->subMonths(4),
            ],
            [
                'first_name' => 'Oscar',
                'last_name' => 'Voyageur',
                'email' => 'voyageuroscar@gmail.com',
                'password' => bcrypt('123456789'),
                'role' => 'user',
                'birth_date' => '1998-12-01',
                'phone' => '+14165559003',
                'phone_country_code' => 'CA',
                'address_street' => '789 King Street',
                'address_city' => 'Toronto',
                'address_postal_code' => 'M5V 1M5',
                'address_country' => 'Canada',
                'bio' => "Etudiant en architecture, passionne par les espaces uniques et les constructions insolites. Chaque logement est une source d'inspiration.",
                'city' => 'Toronto',
                'profession' => 'Etudiant en architecture',
                'languages_spoken' => ['English', 'Francais'],
                'interests' => ['Architecture', 'Design', 'Velo', 'Musique'],
                'profile_photo_url' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400&h=400&fit=crop&crop=face',
                'preferred_language' => 'fr',
                'preferred_currency' => 'CAD',
                'timezone' => 'America/Toronto',
                'phone_verified' => true,
                'identity_verified' => false,
                'email_verified_at' => now()->subMonths(3),
                'fraud_score' => 8,
                'last_login_at' => now()->subDays(2),
                'last_login_ip' => '72.38.12.55',
                'last_login_device' => 'Firefox / Linux',
                'login_count' => 23,
                'client_status' => 'ACTIF',
                'created_at' => now()->subMonths(3),
            ],
            [
                'first_name' => 'Marie',
                'last_name' => 'Voyageur',
                'email' => 'voyageurmarie@gmail.com',
                'password' => bcrypt('123456789'),
                'role' => 'user',
                'birth_date' => '1987-06-14',
                'phone' => '+33612345004',
                'phone_country_code' => 'FR',
                'address_street' => '8 Place Bellecour',
                'address_city' => 'Lyon',
                'address_postal_code' => '69002',
                'address_country' => 'France',
                'bio' => "Maman de deux enfants, j'organise des vacances en famille inoubliables. Je recherche des logements spacieux, securitaires et proches de la nature.",
                'city' => 'Lyon',
                'profession' => 'Enseignante',
                'languages_spoken' => ['Francais', 'English'],
                'interests' => ['Famille', 'Nature', 'Lecture', 'Jardinage'],
                'profile_photo_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=400&h=400&fit=crop&crop=face',
                'preferred_language' => 'fr',
                'preferred_currency' => 'EUR',
                'timezone' => 'Europe/Paris',
                'phone_verified' => true,
                'identity_verified' => true,
                'email_verified_at' => now()->subMonths(7),
                'fraud_score' => 1,
                'last_login_at' => now()->subHours(12),
                'last_login_ip' => '82.64.11.200',
                'last_login_device' => 'Chrome / Windows',
                'login_count' => 98,
                'client_status' => 'ACTIF',
                'created_at' => now()->subMonths(7),
            ],
            [
                'first_name' => 'Lilly',
                'last_name' => 'Voyageur',
                'email' => 'voyageurlilly@gmail.com',
                'password' => bcrypt('123456789'),
                'role' => 'user',
                'birth_date' => '2000-02-28',
                'phone' => '+14505558005',
                'phone_country_code' => 'CA',
                'address_street' => '55 Rue Sainte-Catherine',
                'address_city' => 'Montreal',
                'address_postal_code' => 'H2X 1K5',
                'address_country' => 'Canada',
                'bio' => "Jeune voyageuse solo, j'adore les micro-aventures et les hebergements insolites. Fan de cafe specialty et de marches locaux.",
                'city' => 'Montreal',
                'profession' => 'Designer graphique',
                'languages_spoken' => ['Francais', 'English', 'Portugues'],
                'interests' => ['Cafe', 'Design', 'Marches locaux', 'Plein air'],
                'profile_photo_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=400&fit=crop&crop=face',
                'preferred_language' => 'fr',
                'preferred_currency' => 'CAD',
                'timezone' => 'America/Montreal',
                'phone_verified' => true,
                'identity_verified' => true,
                'email_verified_at' => now()->subMonths(2),
                'fraud_score' => 3,
                'last_login_at' => now()->subHours(1),
                'last_login_ip' => '24.48.65.100',
                'last_login_device' => 'Safari / macOS',
                'login_count' => 34,
                'client_status' => 'ACTIF',
                'created_at' => now()->subMonths(2),
            ],
        ];

        $voyageurUsers = [];
        foreach ($voyageurs as $vData) {
            $voyageurUsers[] = User::create($vData);
        }

        // =====================================================================
        // RESERVATIONS (variete de statuts)
        // =====================================================================

        $reservationsData = [
            // Paul → Emily loft (completed)
            ['guest' => 0, 'listing' => 0, 'check_in' => now()->subMonths(3), 'check_out' => now()->subMonths(3)->addDays(5), 'guests_count' => 2, 'status' => 'completed', 'total_price' => 770.00],
            // Paul → Pascal chalet (confirmed, upcoming)
            ['guest' => 0, 'listing' => 2, 'check_in' => now()->addDays(14), 'check_out' => now()->addDays(18), 'guests_count' => 4, 'status' => 'confirmed', 'total_price' => 1265.00],
            // Juliette → Lucas cabane (completed)
            ['guest' => 1, 'listing' => 4, 'check_in' => now()->subMonths(2), 'check_out' => now()->subMonths(2)->addDays(2), 'guests_count' => 2, 'status' => 'completed', 'total_price' => 418.00],
            // Juliette → Romeo villa (pending)
            ['guest' => 1, 'listing' => 6, 'check_in' => now()->addDays(30), 'check_out' => now()->addDays(35), 'guests_count' => 3, 'status' => 'pending', 'total_price' => 1295.00],
            // Oscar → Pascal condo (completed)
            ['guest' => 2, 'listing' => 3, 'check_in' => now()->subMonths(1), 'check_out' => now()->subMonths(1)->addDays(4), 'guests_count' => 2, 'status' => 'completed', 'total_price' => 535.00],
            // Oscar → Emily maison (cancelled)
            ['guest' => 2, 'listing' => 1, 'check_in' => now()->subWeeks(2), 'check_out' => now()->subWeeks(2)->addDays(3), 'guests_count' => 3, 'status' => 'cancelled', 'total_price' => 725.00],
            // Marie → Pascal chalet (completed)
            ['guest' => 3, 'listing' => 2, 'check_in' => now()->subMonths(2), 'check_out' => now()->subMonths(2)->addDays(7), 'guests_count' => 6, 'status' => 'completed', 'total_price' => 2150.00],
            // Marie → Lucas cottage (confirmed)
            ['guest' => 3, 'listing' => 5, 'check_in' => now()->addDays(7), 'check_out' => now()->addDays(12), 'guests_count' => 4, 'status' => 'confirmed', 'total_price' => 1400.00],
            // Lilly → Lucas cabane (completed)
            ['guest' => 4, 'listing' => 4, 'check_in' => now()->subWeeks(3), 'check_out' => now()->subWeeks(3)->addDays(1), 'guests_count' => 1, 'status' => 'completed', 'total_price' => 229.00],
            // Lilly → Romeo studio (active)
            ['guest' => 4, 'listing' => 7, 'check_in' => now()->subDays(1), 'check_out' => now()->addDays(3), 'guests_count' => 1, 'status' => 'confirmed', 'total_price' => 310.00],
            // Lilly → Emily loft (pending)
            ['guest' => 4, 'listing' => 0, 'check_in' => now()->addDays(20), 'check_out' => now()->addDays(24), 'guests_count' => 2, 'status' => 'pending', 'total_price' => 625.00],
            // Marie → Romeo villa (completed)
            ['guest' => 3, 'listing' => 6, 'check_in' => now()->subMonths(4), 'check_out' => now()->subMonths(4)->addDays(5), 'guests_count' => 5, 'status' => 'completed', 'total_price' => 1295.00],
        ];

        $reservations = [];
        foreach ($reservationsData as $rd) {
            $reservations[] = Reservation::create([
                'guest_id' => $voyageurUsers[$rd['guest']]->id,
                'listing_id' => $listings[$rd['listing']]->id,
                'check_in' => $rd['check_in'],
                'check_out' => $rd['check_out'],
                'guests_count' => $rd['guests_count'],
                'status' => $rd['status'],
                'total_price' => $rd['total_price'],
                'currency' => 'CAD',
                'guest_message' => $rd['status'] === 'cancelled' ? null : 'Bonjour, nous avons hate de decouvrir votre logement !',
                'cancellation_reason' => $rd['status'] === 'cancelled' ? 'Changement de plans' : null,
            ]);
        }

        // =====================================================================
        // REVIEWS (voyageurs → listings, pour reservations completed)
        // =====================================================================

        $reviewsData = [
            // Paul → Emily loft (reservation 0)
            ['user' => 0, 'listing' => 0, 'rating' => 4.8, 'text' => "Superbe loft, tres bien situe dans le Vieux-Quebec. Emily est une hote formidable, toujours disponible. La vue sur le fleuve est magnifique. Je recommande vivement !", 'cleanliness' => 5.0, 'accuracy' => 4.5, 'checkin' => 5.0, 'communication' => 5.0, 'location' => 5.0, 'value' => 4.5],
            // Juliette → Lucas cabane (reservation 2)
            ['user' => 1, 'listing' => 4, 'rating' => 5.0, 'text' => "Experience inoubliable ! La cabane est magique, on se sent vraiment deconnecte du monde. Le petit-dejeuner livre dans le panier est un detail adorable. Lucas est un hote exceptionnel.", 'cleanliness' => 5.0, 'accuracy' => 5.0, 'checkin' => 5.0, 'communication' => 5.0, 'location' => 5.0, 'value' => 4.5],
            // Oscar → Pascal condo (reservation 4)
            ['user' => 2, 'listing' => 3, 'rating' => 4.5, 'text' => "Condo tres bien situe sur le Plateau. La decoration est moderne et agreable. Les velos sont un vrai plus pour explorer Montreal. Seul bemol : un peu de bruit la nuit.", 'cleanliness' => 4.5, 'accuracy' => 4.5, 'checkin' => 5.0, 'communication' => 4.5, 'location' => 5.0, 'value' => 4.0],
            // Marie → Pascal chalet (reservation 6)
            ['user' => 3, 'listing' => 2, 'rating' => 4.9, 'text' => "Le chalet est absolument parfait pour une semaine en famille ! Le spa sous les etoiles, le foyer, la vue sur les montagnes... Tout etait impeccable. Les enfants ont adore.", 'cleanliness' => 5.0, 'accuracy' => 5.0, 'checkin' => 5.0, 'communication' => 5.0, 'location' => 4.5, 'value' => 5.0],
            // Lilly → Lucas cabane (reservation 8)
            ['user' => 4, 'listing' => 4, 'rating' => 4.7, 'text' => "Quelle experience unique ! La cabane dans les arbres est un reve devenu realite. Parfait pour une nuit romantique ou une micro-aventure. Je reviendrai c'est sur !", 'cleanliness' => 4.5, 'accuracy' => 5.0, 'checkin' => 5.0, 'communication' => 4.5, 'location' => 5.0, 'value' => 4.5],
            // Marie → Romeo villa (reservation 11)
            ['user' => 3, 'listing' => 6, 'rating' => 5.0, 'text' => "Romeo est un hote exceptionnel ! La villa est magnifique, la cuisine professionnelle est un reve, et le livret de recettes locales est une attention touchante. Les enfants ont adore cueillir les herbes du potager.", 'cleanliness' => 5.0, 'accuracy' => 5.0, 'checkin' => 5.0, 'communication' => 5.0, 'location' => 4.5, 'value' => 5.0],
        ];

        foreach ($reviewsData as $rd) {
            Review::create([
                'listing_id' => $listings[$rd['listing']]->id,
                'user_id' => $voyageurUsers[$rd['user']]->id,
                'rating' => $rd['rating'],
                'text' => $rd['text'],
                'cleanliness_rating' => $rd['cleanliness'],
                'accuracy_rating' => $rd['accuracy'],
                'checkin_rating' => $rd['checkin'],
                'communication_rating' => $rd['communication'],
                'location_rating' => $rd['location'],
                'value_rating' => $rd['value'],
            ]);
        }

        // =====================================================================
        // GUEST REVIEWS (hotes → voyageurs)
        // =====================================================================

        $guestReviewsData = [
            // Emily → Paul
            ['host' => 0, 'guest' => 0, 'reservation' => 0, 'listing' => 0, 'rating' => 5.0, 'comment' => "Paul est un voyageur exemplaire. Tres respectueux du logement, communication parfaite. Un plaisir de l'accueillir !"],
            // Lucas → Juliette
            ['host' => 2, 'guest' => 1, 'reservation' => 2, 'listing' => 4, 'rating' => 5.0, 'comment' => "Juliette est une voyageuse adorable. Elle a respecte la cabane comme si c'etait la sienne. Je la recommande a 100%."],
            // Pascal → Oscar
            ['host' => 1, 'guest' => 2, 'reservation' => 4, 'listing' => 3, 'rating' => 4.5, 'comment' => "Oscar est un bon voyageur, ponctuel et propre. Communication agreable."],
            // Pascal → Marie
            ['host' => 1, 'guest' => 3, 'reservation' => 6, 'listing' => 2, 'rating' => 5.0, 'comment' => "Marie et sa famille sont des hotes ideaux. Le chalet etait impeccable a leur depart. Les enfants etaient tres bien eleves."],
            // Lucas → Lilly
            ['host' => 2, 'guest' => 4, 'reservation' => 8, 'listing' => 4, 'rating' => 4.8, 'comment' => "Lilly est une voyageuse enthousiaste et respectueuse. Bonne communication tout au long du sejour."],
            // Romeo → Marie
            ['host' => 3, 'guest' => 3, 'reservation' => 11, 'listing' => 6, 'rating' => 5.0, 'comment' => "Marie et sa famille ont ete des hotes merveilleux. Ils ont adore le potager et ont meme laisse la cuisine plus propre qu'a leur arrivee !"],
        ];

        foreach ($guestReviewsData as $gr) {
            GuestReview::create([
                'host_id' => $hostUsers[$gr['host']]->id,
                'guest_id' => $voyageurUsers[$gr['guest']]->id,
                'reservation_id' => $reservations[$gr['reservation']]->id,
                'listing_id' => $listings[$gr['listing']]->id,
                'rating' => $gr['rating'],
                'comment' => $gr['comment'],
            ]);
        }

        // =====================================================================
        // HOST PAYOUTS (pour reservations completed)
        // =====================================================================

        $completedReservations = [0, 2, 4, 6, 8, 11]; // indices des reservations completed
        foreach ($completedReservations as $ri) {
            $res = $reservations[$ri];
            $listing = Listing::find($res->listing_id);
            $gross = $res->total_price;
            $commissionRate = 15.00;
            $commissionAmount = round($gross * $commissionRate / 100, 2);
            $cleaningFee = $listing->cleaning_fee ?? 0;
            $netAmount = round($gross - $commissionAmount, 2);

            HostPayout::create([
                'host_id' => $listing->user_id,
                'reservation_id' => $res->id,
                'listing_id' => $listing->id,
                'gross_amount' => $gross,
                'commission_rate' => $commissionRate,
                'commission_amount' => $commissionAmount,
                'cleaning_fee' => $cleaningFee,
                'taxes' => 0,
                'net_amount' => $netAmount,
                'currency' => 'CAD',
                'status' => 'paid',
                'scheduled_date' => $res->check_out,
                'paid_date' => $res->check_out->copy()->addDays(3),
                'reference' => 'PAY-' . strtoupper(substr(md5($res->id . $listing->id), 0, 8)),
            ]);
        }

        // =====================================================================
        // ACTIVITY LOGS
        // =====================================================================

        foreach ($voyageurUsers as $v) {
            ActivityLog::create(['user_id' => $v->id, 'action' => 'Inscription', 'detail' => 'Inscription via formulaire', 'ip' => $v->last_login_ip]);
            ActivityLog::create(['user_id' => $v->id, 'action' => 'Connexion', 'detail' => 'Connexion reussie', 'ip' => $v->last_login_ip]);
            ActivityLog::create(['user_id' => $v->id, 'action' => 'Verification email', 'detail' => 'Email verifie avec succes', 'ip' => $v->last_login_ip]);
        }

        foreach ($hostUsers as $h) {
            ActivityLog::create(['user_id' => $h->id, 'action' => 'Inscription', 'detail' => 'Inscription via formulaire', 'ip' => $h->last_login_ip]);
            ActivityLog::create(['user_id' => $h->id, 'action' => 'Connexion', 'detail' => 'Connexion reussie', 'ip' => $h->last_login_ip]);
            ActivityLog::create(['user_id' => $h->id, 'action' => 'Publication annonce', 'detail' => 'Annonce publiee avec succes', 'ip' => $h->last_login_ip]);
        }

        $this->command->info('PopulateSeeder: 4 hotes + 5 voyageurs + 8 listings + 12 reservations + 6 reviews + 6 guest reviews + 6 payouts + activity logs crees avec succes !');
    }
}
