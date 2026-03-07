<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\ListingPhoto;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertyDetailSeeder extends Seeder
{
    public function run(): void
    {
        // ── Host user ────────────────────────────────────────────────────────
        $host = User::firstOrCreate(
            ['email' => 'jeremy.host@homiqio.com'],
            [
                'first_name'        => 'Jérémy',
                'last_name'         => 'Dupont',
                'password'          => bcrypt('password'),
                'role'              => 'user',
                'email_verified_at' => now()->subMonths(4),
                'profession'        => 'Artiste',
                'interests'         => ['Cinéma théâtre art', 'lire', 'écrire', 'créer'],
                'languages_spoken'  => ['Français', 'English'],
                'profile_photo_url' => 'https://images.unsplash.com/photo-1664482017668-91158897414c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxhcnRpc3QlMjBwb3J0cmFpdCUyMHByb2ZpbGV8ZW58MXx8fHwxNzY3NzcwNDcxfDA&ixlib=rb-4.1.0&q=80&w=1080',
                'identity_verified' => true,
                'phone_verified'    => true,
                'bio'               => 'Artiste passionné, j\'adore accueillir des voyageurs du monde entier.',
                'city'              => 'Paris',
                'created_at'        => now()->subMonths(4),
            ]
        );

        // ── Listing ──────────────────────────────────────────────────────────
        $listing = Listing::firstOrCreate(
            ['title' => 'Studio aux Portes de Paris', 'user_id' => $host->id],
            [
                'status'              => 'active',
                'subtitle'            => 'Superbe studio de 15m² au calme tout confort',
                'space_type'          => 'Logement entier : appartement',
                'rental_frequency'    => 'occasional',
                'full_address'        => 'Paris, Île-de-France, France',
                'city'                => 'Paris',
                'province'            => 'Île-de-France',
                'country'             => 'France',
                'latitude'            => 48.8589384,
                'longitude'           => 2.2646350,
                'capacity'            => 2,
                'adults'              => 2,
                'bathrooms'           => 1,
                'bedrooms_data'       => [
                    ['name' => 'Chambre', 'beds' => [['type' => 'lit double', 'count' => 1]]],
                ],
                'open_areas_data'     => [
                    ['name' => 'Espace commun', 'beds' => [['type' => 'canapé-lit', 'count' => 1]]],
                ],
                'amenities'           => [
                    'cuisine', 'wifi', 'television', 'seche_cheveux',
                    'espace_travail', 'animaux_acceptes', 'refrigerateur', 'micro_ondes',
                ],
                'description'         => "Bienvenue dans ce studio cosy de 15m², entièrement refait à neuf et pensé pour votre confort. Vous y trouverez une pièce lumineuse, une cuisine équipée donnant sur cour, double vitrage pour le calme, salle de bain pratique et toilettes privatives sur le palier. L'immeuble est paisible et agréable. Les photos montrent chaque détail pour préparer votre séjour. Je reste disponible avec plaisir pour répondre à vos questions et vous accompagner.",
                'about_chalet'        => "Ce studio confortable dispose de tout le nécessaire pour passer un agréable séjour. La pièce principale est lumineuse et bien aménagée. La cuisine est entièrement équipée avec réfrigérateur, plaques de cuisson, micro-ondes et tous les ustensiles nécessaires. La salle de bain moderne comprend une douche, un lavabo et des rangements. Le logement est situé dans un quartier calme et bien desservi par les transports en commun.",
                'neighborhood'        => 'Quartier calme et résidentiel, proche du métro.',
                'transport'           => 'Métro à 5 minutes à pied, bus à 2 minutes.',
                'base_price'          => 87.56,
                'weekend_price'       => 99.00,
                'cleaning_fee'        => 25.00,
                'currency'            => 'CAD',
                'cancellation_policy' => 'flexible',
                'arrival_time'        => '14:00',
                'departure_time'      => '11:00',
                'min_age'             => 18,
                'reservation_mode'    => 'request',
                'has_wifi'            => true,
                'wifi_speed'          => '100 Mbps',
                'checkin_method'      => 'lockbox',
                'checkin_instructions' => 'Le code de la boîte à clés vous sera communiqué la veille de votre arrivée.',
                'accepted_local_laws' => true,
            ]
        );

        // ── Listing Photos ───────────────────────────────────────────────────
        $photos = [
            'https://images.unsplash.com/photo-1737305457496-dc7503cdde1e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBzdHVkaW8lMjBhcGFydG1lbnQlMjBpbnRlcmlvcnxlbnwxfHx8fDE3Njc3NjY1NTN8MA&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1612419299101-6c294dc2901d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb3p5JTIwYXBhcnRtZW50JTIwbGl2aW5nJTIwcm9vbXxlbnwxfHx8fDE3Njc2ODYxNDN8MA&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1737467016100-68cd7759d93c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxhcGFydG1lbnQlMjBiZWRyb29tJTIwY29tZm9ydGFibGV8ZW58MXx8fHwxNzY3NzY2NTU0fDA&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1597497522150-2f50bffea452?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBraXRjaGVuJTIwYXBhcnRtZW50fGVufDF8fHx8MTc2NzczMDQyNXww&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1757439402224-56c48352f719?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiYXRocm9vbSUyMGFwYXJ0bWVudCUyMG1vZGVybnxlbnwxfHx8fDE3Njc3NjY1NTV8MA&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1662454419736-de132ff75638?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBiZWRyb29tJTIwYXBhcnRtZW50fGVufDF8fHx8MTc2NzgwNjkyOHww&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1650338031185-1e97add7a389?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxvdXRkb29yJTIwcGF0aW8lMjBnYXJkZW58ZW58MXx8fHwxNzY3ODI1MjIzfDA&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1696774276390-6ce82111140f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb3p5JTIwbGl2aW5nJTIwc3BhY2V8ZW58MXx8fHwxNzY3ODI4Nzc1fDA&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1682888818696-906287d759f5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBzaG93ZXIlMjBiYXRocm9vbXxlbnwxfHx8fDE3Njc4NzQ5NjF8MA&ixlib=rb-4.1.0&q=80&w=1080',
            'https://images.unsplash.com/photo-1758448511533-e1502259fff6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxhcGFydG1lbnQlMjBlbnRyYW5jZSUyMGhhbGx3YXl8ZW58MXx8fHwxNzY3ODc0OTYyfDA&ixlib=rb-4.1.0&q=80&w=1080',
        ];

        // Only create photos if none exist for this listing
        if ($listing->photos()->count() === 0) {
            foreach ($photos as $index => $url) {
                ListingPhoto::create([
                    'listing_id' => $listing->id,
                    'path'       => $url,
                    'order'      => $index,
                ]);
            }
        }

        // ── Reviewer users ───────────────────────────────────────────────────
        $reviewers = [
            ['first_name' => 'Kai',     'last_name' => 'Schmidt',  'email' => 'kai.reviewer@homiqio.com',     'created_at' => now()->subYears(10)],
            ['first_name' => 'Emil',    'last_name' => 'Larsson',  'email' => 'emil.reviewer@homiqio.com',    'created_at' => now()->subYears(2)],
            ['first_name' => 'Vanessa', 'last_name' => 'Moreau',   'email' => 'vanessa.reviewer@homiqio.com', 'created_at' => now()->subYears(8)],
            ['first_name' => 'Marie',   'last_name' => 'Lefebvre', 'email' => 'marie.reviewer@homiqio.com',  'created_at' => now()->subYears(13)],
        ];

        $reviewerUsers = [];
        foreach ($reviewers as $data) {
            $reviewerUsers[] = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'first_name'        => $data['first_name'],
                    'last_name'         => $data['last_name'],
                    'password'          => bcrypt('password'),
                    'email_verified_at' => $data['created_at'],
                    'created_at'        => $data['created_at'],
                    'updated_at'        => $data['created_at'],
                ]
            );
        }

        // ── Featured reviews (matching current UI) ───────────────────────────
        $featuredReviews = [
            [
                'user_index' => 0, // Kai
                'rating'     => 5.0,
                'text'       => "J'ai passé trois jours très agréables dans l'appartement de Jérémy. L'appartement est petit mais super confortable, situé au centre et bien desservi par le métro. Les toilettes sont sur le palier mais c'est très propre et pratique. Jérémy est un hôte très réactif et accueillant. Je recommande vivement ce studio pour un séjour à Paris !",
                'created_at' => now()->subDays(2),
                'cleanliness' => 5.0, 'accuracy' => 5.0, 'checkin' => 5.0, 'communication' => 5.0, 'location' => 4.5, 'value' => 5.0,
            ],
            [
                'user_index' => 1, // Emil
                'rating'     => 5.0,
                'text'       => "J'ai vraiment apprécié mon séjour chez Jeremy. L'appartement était propre, confortable et exactement conforme à la description. Tout a parfaitement fonctionné, et Jeremy a été très réactif et disponible. Un excellent choix pour un séjour à Paris, je recommande sans hésitation !",
                'created_at' => now()->subWeek(),
                'cleanliness' => 5.0, 'accuracy' => 5.0, 'checkin' => 5.0, 'communication' => 5.0, 'location' => 4.5, 'value' => 5.0,
            ],
            [
                'user_index' => 2, // Vanessa
                'rating'     => 5.0,
                'text'       => "Jeremy est un hôte très sympathique, qui nous réserve un très bon accueil. L'appartement est joliment décoré et très propre. Il est bien situé, proche des transports en commun et des commerces. Un séjour très agréable que je recommande vivement.",
                'created_at' => now()->subWeeks(2),
                'cleanliness' => 5.0, 'accuracy' => 5.0, 'checkin' => 5.0, 'communication' => 5.0, 'location' => 5.0, 'value' => 5.0,
            ],
            [
                'user_index' => 3, // Marie
                'rating'     => 5.0,
                'text'       => "Jeremy nous a accueilli chaleureusement, les échanges avec lui ont été sympathique et réactif. L'appartement est très propre et bien situé. Je recommande vivement !",
                'created_at' => now()->subDays(5),
                'cleanliness' => 5.0, 'accuracy' => 5.0, 'checkin' => 5.0, 'communication' => 5.0, 'location' => 4.5, 'value' => 5.0,
            ],
        ];

        // Only seed reviews if none exist for this listing
        if ($listing->reviews()->count() === 0) {
            // Create featured reviews
            foreach ($featuredReviews as $reviewData) {
                Review::create([
                    'listing_id'           => $listing->id,
                    'user_id'              => $reviewerUsers[$reviewData['user_index']]->id,
                    'rating'               => $reviewData['rating'],
                    'text'                 => $reviewData['text'],
                    'cleanliness_rating'   => $reviewData['cleanliness'],
                    'accuracy_rating'      => $reviewData['accuracy'],
                    'checkin_rating'       => $reviewData['checkin'],
                    'communication_rating' => $reviewData['communication'],
                    'location_rating'      => $reviewData['location'],
                    'value_rating'         => $reviewData['value'],
                    'created_at'           => $reviewData['created_at'],
                    'updated_at'           => $reviewData['created_at'],
                ]);
            }

            // Create 22 additional reviews to reach 26 total
            $firstNames = ['Lucas', 'Sophie', 'Thomas', 'Camille', 'Hugo', 'Léa', 'Louis', 'Chloé', 'Jules', 'Emma', 'Nathan', 'Manon', 'Arthur', 'Jade', 'Théo', 'Alice', 'Raphaël', 'Louise', 'Maxime', 'Inès', 'Gabriel', 'Sarah'];
            $lastNames  = ['Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard', 'Petit', 'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia', 'David', 'Bertrand', 'Roux', 'Vincent', 'Fournier', 'Morel', 'Girard'];

            $reviewTexts = [
                'Très bon séjour, appartement conforme à la description. Jérémy est un hôte attentionné.',
                'Studio parfait pour un court séjour à Paris. Propre et bien équipé.',
                'Excellent rapport qualité-prix. Le quartier est calme et agréable.',
                'Séjour très agréable. Le studio est petit mais fonctionnel et bien situé.',
                'Super accueil de Jérémy. L\'appartement est exactement comme sur les photos.',
                'Nous avons passé un excellent séjour. Le studio est cosy et bien aménagé.',
                'Parfait pour découvrir Paris. Proche du métro et des commerces.',
                'Studio impeccable, Jérémy est très réactif. Je recommande !',
                'Très bon séjour, l\'appartement est propre et bien situé.',
                'Le studio est confortable et calme. Idéal pour un couple.',
                'Jérémy est un hôte formidable. L\'appartement est chaleureux et accueillant.',
                'Très satisfait de mon séjour. Le logement correspond parfaitement à l\'annonce.',
                'Un petit studio très bien aménagé. Tout est prévu pour un séjour agréable.',
                'Excellent emplacement, studio propre et confortable. Merci Jérémy !',
                'Séjour parfait. Le studio est fonctionnel et le quartier est super.',
                'Très bon accueil, appartement propre et bien équipé. À recommander.',
                'Studio charmant et bien situé. Communication fluide avec Jérémy.',
                'Nous avons adoré ce petit studio. Parfait pour un week-end à Paris.',
                'Logement conforme à la description, propre et calme. Merci !',
                'Super studio, idéalement placé. Jérémy est un hôte très agréable.',
                'Très bon séjour dans ce studio cosy. Je reviendrai avec plaisir.',
                'Appartement parfait pour 2 personnes. Tout est bien pensé.',
            ];

            for ($i = 0; $i < 22; $i++) {
                // Create user for this review
                $email = strtolower($firstNames[$i]) . '.' . strtolower($lastNames[$i]) . '@homiqio-guest.com';
                $yearsAgo = rand(1, 12);
                $reviewUser = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'first_name'        => $firstNames[$i],
                        'last_name'         => $lastNames[$i],
                        'password'          => bcrypt('password'),
                        'email_verified_at' => now()->subYears($yearsAgo),
                        'created_at'        => now()->subYears($yearsAgo),
                        'updated_at'        => now()->subYears($yearsAgo),
                    ]
                );

                // Ratings that average to ~4.96
                $rating = $i < 20 ? 5.0 : 4.5;
                $cleanlinessRating = $i % 5 === 0 ? 4.5 : 5.0;
                $locationRating = $i % 3 === 0 ? 4.5 : ($i % 7 === 0 ? 4.0 : 5.0);

                Review::create([
                    'listing_id'           => $listing->id,
                    'user_id'              => $reviewUser->id,
                    'rating'               => $rating,
                    'text'                 => $reviewTexts[$i],
                    'cleanliness_rating'   => $cleanlinessRating,
                    'accuracy_rating'      => $i % 7 === 0 ? 4.5 : 5.0,
                    'checkin_rating'       => 5.0,
                    'communication_rating' => 5.0,
                    'location_rating'      => $locationRating,
                    'value_rating'         => $i % 6 === 0 ? 4.5 : 5.0,
                    'created_at'           => now()->subDays(rand(3, 90)),
                    'updated_at'           => now()->subDays(rand(3, 90)),
                ]);
            }
        }
    }
}
