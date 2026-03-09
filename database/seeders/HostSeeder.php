<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Listing;
use App\Models\Reservation;
use App\Models\HostPayout;
use App\Models\Review;
use App\Models\AdminNote;
use App\Models\HostDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class HostSeeder extends Seeder
{
    public function run(): void
    {
        // Create a guest user for reservations and reviews
        $guest = User::updateOrCreate(
            ['email' => 'guest@homiqio.com'],
            [
                'first_name' => 'Client',
                'last_name' => 'Test',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
                'host_status' => 'ACTIF',
            ]
        );

        // Cities per country for listing variety
        $citiesByCountry = [
            'France' => ['Paris', 'Lyon', 'Bordeaux', 'Nice', 'Marseille', 'Toulouse', 'Strasbourg', 'Montpellier'],
            'Belgique' => ['Bruxelles', 'Anvers', 'Gand', 'Liege', 'Bruges', 'Namur'],
            'Suisse' => ['Geneve', 'Zurich', 'Lausanne', 'Berne', 'Bale'],
            'Canada' => ['Montreal', 'Quebec', 'Ottawa', 'Toronto', 'Vancouver', 'Tremblant'],
        ];

        $listingTypes = ['entire', 'private', 'shared'];
        $listingNames = [
            'Villa', 'Appartement', 'Studio', 'Loft', 'Maison', 'Chalet',
            'Penthouse', 'Duplex', 'Cottage', 'Residence',
        ];

        $reviewTexts = [
            'Logement exceptionnel, hote tres accueillant. Je recommande vivement !',
            'Tres bien situe, propre et confortable. Petit bemol sur le bruit.',
            'Parfait pour les vacances. Tout etait impeccable.',
            'Bon rapport qualite-prix. Logement tres bien equipe.',
            'Superbe experience. La vue etait magnifique.',
            'Sejour agreable, communication excellente avec l\'hote.',
            'Tres bel endroit, conforme a la description. Merci !',
            'Un peu petit mais tres propre et bien situe.',
            'Hote reactif et attentionne. Logement charmant.',
            'Excellent sejour, je reviendrai sans hesiter.',
        ];

        $hostsData = [
            [
                'first_name' => 'Jean', 'last_name' => 'Dupont',
                'email' => 'jean.dupont@email.com',
                'phone' => '6 12 34 56 78', 'phone_country_code' => '+33',
                'address_country' => 'France', 'city' => 'Paris',
                'identity_verified' => true, 'phone_verified' => true,
                'bank_verified' => true, 'address_verified' => true,
                'fraud_score' => 8,
                'properties' => 12, 'totalBookings' => 156,
                'totalEarnings' => 45230, 'avgRating' => 4.8,
                'created_at' => Carbon::create(2023, 1, 15),
                'host_status' => 'ACTIF',
                'documents' => ["Carte d'identite", 'Justificatif de domicile', 'RIB bancaire'],
                'note' => 'Hote fiable avec un excellent taux de reponse. Super host potentiel.',
            ],
            [
                'first_name' => 'Marie', 'last_name' => 'Simon',
                'email' => 'marie.simon@email.com',
                'phone' => '6 23 45 67 89', 'phone_country_code' => '+33',
                'address_country' => 'France', 'city' => 'Bordeaux',
                'identity_verified' => true, 'phone_verified' => true,
                'bank_verified' => true, 'address_verified' => true,
                'fraud_score' => 5,
                'properties' => 8, 'totalBookings' => 98,
                'totalEarnings' => 32150, 'avgRating' => 4.6,
                'created_at' => Carbon::create(2023, 2, 3),
                'host_status' => 'ACTIF',
                'documents' => ['Passeport'],
                'note' => 'Bonne hote, logements bien entretenus.',
            ],
            [
                'first_name' => 'Pierre', 'last_name' => 'Laurent',
                'email' => 'pierre.laurent@email.com',
                'phone' => '6 34 56 78 90', 'phone_country_code' => '+33',
                'address_country' => 'France', 'city' => 'Lyon',
                'identity_verified' => false, 'phone_verified' => true,
                'bank_verified' => true, 'address_verified' => false,
                'fraud_score' => 22,
                'properties' => 15, 'totalBookings' => 210,
                'totalEarnings' => 67890, 'avgRating' => 4.3,
                'created_at' => Carbon::create(2023, 3, 22),
                'host_status' => 'ACTIF',
                'documents' => ["Carte d'identite"],
                'note' => 'Verification d\'identite en attente. Beaucoup de logements.',
            ],
            [
                'first_name' => 'Sophie', 'last_name' => 'Martin',
                'email' => 'sophie.martin@email.com',
                'phone' => '6 45 67 89 01', 'phone_country_code' => '+33',
                'address_country' => 'Belgique', 'city' => 'Bruxelles',
                'identity_verified' => true, 'phone_verified' => true,
                'bank_verified' => true, 'address_verified' => true,
                'fraud_score' => 3,
                'properties' => 6, 'totalBookings' => 72,
                'totalEarnings' => 18450, 'avgRating' => 4.9,
                'created_at' => Carbon::create(2023, 9, 8),
                'host_status' => 'ACTIF',
                'documents' => ['Passeport', 'Justificatif de domicile', 'RIB bancaire'],
                'note' => 'Excellente hote, meilleure note de la plateforme.',
            ],
            [
                'first_name' => 'Thomas', 'last_name' => 'Dubois',
                'email' => 'thomas.dubois@email.com',
                'phone' => '2 123 45 67', 'phone_country_code' => '+32',
                'address_country' => 'Belgique', 'city' => 'Anvers',
                'identity_verified' => true, 'phone_verified' => true,
                'bank_verified' => true, 'address_verified' => true,
                'fraud_score' => 35,
                'properties' => 9, 'totalBookings' => 45,
                'totalEarnings' => 28340, 'avgRating' => 3.9,
                'created_at' => Carbon::create(2023, 11, 17),
                'host_status' => 'SUSPENDU',
                'documents' => ["Carte d'identite", 'RIB bancaire'],
                'note' => 'Suspendu suite a des plaintes repetees des voyageurs.',
            ],
            [
                'first_name' => 'Lucie', 'last_name' => 'Bernard',
                'email' => 'lucie.bernard@email.com',
                'phone' => '21 345 67 89', 'phone_country_code' => '+41',
                'address_country' => 'Suisse', 'city' => 'Geneve',
                'identity_verified' => true, 'phone_verified' => true,
                'bank_verified' => true, 'address_verified' => true,
                'fraud_score' => 4,
                'properties' => 18, 'totalBookings' => 312,
                'totalEarnings' => 89120, 'avgRating' => 4.7,
                'created_at' => Carbon::create(2022, 6, 30),
                'host_status' => 'ACTIF',
                'documents' => ['Passeport', 'Justificatif de domicile', 'RIB bancaire', 'Certificat fiscal'],
                'note' => 'Hote premium avec le plus de logements en Suisse.',
            ],
            [
                'first_name' => 'Antoine', 'last_name' => 'Moreau',
                'email' => 'antoine.moreau@email.com',
                'phone' => '438 555 6789', 'phone_country_code' => '+1',
                'address_country' => 'Canada', 'city' => 'Montreal',
                'identity_verified' => true, 'phone_verified' => true,
                'bank_verified' => true, 'address_verified' => true,
                'fraud_score' => 6,
                'properties' => 25, 'totalBookings' => 420,
                'totalEarnings' => 125450, 'avgRating' => 4.5,
                'created_at' => Carbon::create(2022, 4, 12),
                'host_status' => 'ACTIF',
                'documents' => ['Permis de conduire', 'Releve bancaire', 'Preuve de residence'],
                'note' => 'Plus gros hote du Canada. Revenus les plus eleves de la plateforme.',
            ],
            [
                'first_name' => 'Camille', 'last_name' => 'Leroy',
                'email' => 'camille.leroy@email.com',
                'phone' => '6 89 01 23 45', 'phone_country_code' => '+33',
                'address_country' => 'France', 'city' => 'Nice',
                'identity_verified' => false, 'phone_verified' => false,
                'bank_verified' => false, 'address_verified' => false,
                'fraud_score' => 72,
                'properties' => 4, 'totalBookings' => 18,
                'totalEarnings' => 12890, 'avgRating' => 4.1,
                'created_at' => Carbon::create(2025, 2, 20),
                'host_status' => 'BANNI',
                'documents' => [],
                'note' => 'Banni pour fraude suspectee. Aucun document de verification soumis.',
            ],
            [
                'first_name' => 'Romain', 'last_name' => 'Girard',
                'email' => 'romain.girard@email.com',
                'phone' => '6 90 12 34 56', 'phone_country_code' => '+33',
                'address_country' => 'France', 'city' => 'Toulouse',
                'identity_verified' => true, 'phone_verified' => true,
                'bank_verified' => true, 'address_verified' => true,
                'fraud_score' => 10,
                'properties' => 11, 'totalBookings' => 134,
                'totalEarnings' => 56780, 'avgRating' => 4.4,
                'created_at' => Carbon::create(2023, 10, 12),
                'host_status' => 'ACTIF',
                'documents' => ["Carte d'identite", 'Justificatif de domicile'],
                'note' => 'Hote regulier, bon taux d\'occupation.',
            ],
            [
                'first_name' => 'Isabelle', 'last_name' => 'Petit',
                'email' => 'isabelle.petit@email.com',
                'phone' => '613 555 4321', 'phone_country_code' => '+1',
                'address_country' => 'Canada', 'city' => 'Ottawa',
                'identity_verified' => true, 'phone_verified' => true,
                'bank_verified' => true, 'address_verified' => true,
                'fraud_score' => 7,
                'properties' => 3, 'totalBookings' => 28,
                'totalEarnings' => 9730, 'avgRating' => 4.2,
                'created_at' => Carbon::create(2024, 4, 28),
                'host_status' => 'ACTIF',
                'documents' => ['Passeport', 'Releve bancaire'],
                'note' => 'Nouvelle hote avec un bon debut.',
            ],
            [
                'first_name' => 'Emma', 'last_name' => 'Fontaine',
                'email' => 'emma.fontaine@email.com',
                'phone' => '6 11 22 33 44', 'phone_country_code' => '+33',
                'address_country' => 'France', 'city' => 'Strasbourg',
                'identity_verified' => true, 'phone_verified' => true,
                'bank_verified' => true, 'address_verified' => true,
                'fraud_score' => 9,
                'properties' => 7, 'totalBookings' => 89,
                'totalEarnings' => 34560, 'avgRating' => 4.6,
                'created_at' => Carbon::create(2023, 5, 5),
                'host_status' => 'ACTIF',
                'documents' => ["Carte d'identite", 'Justificatif de domicile', 'RIB bancaire'],
                'note' => 'Hote tres reactive, excellents avis.',
            ],
            [
                'first_name' => 'Nicolas', 'last_name' => 'Blanc',
                'email' => 'nicolas.blanc@email.com',
                'phone' => '2 987 65 43', 'phone_country_code' => '+32',
                'address_country' => 'Belgique', 'city' => 'Gand',
                'identity_verified' => false, 'phone_verified' => true,
                'bank_verified' => false, 'address_verified' => false,
                'fraud_score' => 18,
                'properties' => 2, 'totalBookings' => 12,
                'totalEarnings' => 5230, 'avgRating' => 3.8,
                'created_at' => Carbon::create(2025, 1, 14),
                'host_status' => 'ACTIF',
                'documents' => ["Carte d'identite"],
                'note' => 'Nouvel hote, verification incomplete.',
            ],
        ];

        foreach ($hostsData as $data) {
            $verificationDate = $data['identity_verified']
                ? $data['created_at']->copy()->addDays(rand(3, 10))
                : null;

            $host = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'email_verified_at' => $data['created_at'],
                    'phone' => $data['phone'],
                    'phone_country_code' => $data['phone_country_code'],
                    'address_country' => $data['address_country'],
                    'city' => $data['city'],
                    'identity_verified' => $data['identity_verified'],
                    'phone_verified' => $data['phone_verified'],
                    'bank_verified' => $data['bank_verified'],
                    'address_verified' => $data['address_verified'],
                    'verification_date' => $verificationDate,
                    'fraud_score' => $data['fraud_score'],
                    'host_status' => $data['host_status'],
                    'preferred_language' => 'fr',
                    'last_login_at' => now()->subHours(rand(1, 72)),
                    'last_login_ip' => '192.168.1.' . rand(10, 254),
                    'last_login_device' => ['Chrome / macOS', 'Safari / iOS', 'Firefox / Windows', 'Chrome / Android'][rand(0, 3)],
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['created_at'],
                ]
            );

            // Create documents
            foreach ($data['documents'] as $docName) {
                HostDocument::updateOrCreate(
                    ['user_id' => $host->id, 'name' => $docName],
                    [
                        'status' => $data['identity_verified'] ? 'APPROUVE' : 'EN ATTENTE',
                        'created_at' => $data['created_at']->copy()->addDays(rand(0, 3)),
                        'updated_at' => $data['created_at']->copy()->addDays(rand(3, 7)),
                    ]
                );
            }

            // Create admin note
            if (!empty($data['note'])) {
                AdminNote::updateOrCreate(
                    ['user_id' => $host->id, 'content' => $data['note']],
                    [
                        'author' => 'Admin',
                        'created_at' => $data['created_at']->copy()->addDays(rand(5, 30)),
                        'updated_at' => $data['created_at']->copy()->addDays(rand(5, 30)),
                    ]
                );
            }

            // Create listings with varied names and cities
            $cities = $citiesByCountry[$data['address_country']] ?? [$data['city']];
            $listingIds = [];
            for ($i = 0; $i < $data['properties']; $i++) {
                $city = $cities[$i % count($cities)];
                $typeName = $listingNames[$i % count($listingNames)];
                $spaceType = $listingTypes[$i % count($listingTypes)];

                $listing = Listing::create([
                    'user_id' => $host->id,
                    'status' => $i < $data['properties'] - 1 ? 'active' : (['active', 'active', 'archived'][rand(0, 2)]),
                    'title' => "{$typeName} {$city}",
                    'city' => $city,
                    'country' => $data['address_country'] === 'Canada' ? 'CA' :
                                ($data['address_country'] === 'France' ? 'FR' :
                                ($data['address_country'] === 'Belgique' ? 'BE' : 'CH')),
                    'space_type' => $spaceType,
                    'capacity' => rand(2, 8),
                    'bathrooms' => rand(1, 3),
                    'base_price' => rand(80, 300),
                    'currency' => 'EUR',
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['created_at'],
                ]);
                $listingIds[] = $listing->id;
            }

            // Distribute bookings across listings
            $bookingsPerListing = intdiv($data['totalBookings'], count($listingIds));
            $extraBookings = $data['totalBookings'] % count($listingIds);
            $totalEarningsRemaining = $data['totalEarnings'];
            $reservationIndex = 0;
            $totalReservationsCreated = 0;

            foreach ($listingIds as $idx => $listingId) {
                $bookingsForThis = $bookingsPerListing + ($idx < $extraBookings ? 1 : 0);

                for ($j = 0; $j < $bookingsForThis; $j++) {
                    $reservationIndex++;
                    $totalReservationsCreated++;
                    $checkIn = $data['created_at']->copy()->addDays($reservationIndex * 2);
                    $nights = rand(2, 7);
                    $price = rand(150, 500);

                    // Make some reservations cancelled for refunds data
                    $statuses = ['completed', 'completed', 'completed', 'completed', 'completed', 'confirmed', 'cancelled'];
                    $status = $statuses[array_rand($statuses)];

                    $reservation = Reservation::create([
                        'guest_id' => $guest->id,
                        'listing_id' => $listingId,
                        'check_in' => $checkIn,
                        'check_out' => $checkIn->copy()->addDays($nights),
                        'guests_count' => rand(1, 4),
                        'status' => $status,
                        'total_price' => $price,
                        'currency' => 'EUR',
                        'cancellation_reason' => $status === 'cancelled' ? 'Annulation voyageur' : null,
                        'created_at' => $checkIn,
                        'updated_at' => $checkIn,
                    ]);

                    // Create payout only for completed/confirmed
                    if ($status !== 'cancelled') {
                        $isLast = ($totalReservationsCreated === $data['totalBookings']);
                        if ($isLast) {
                            $netAmount = max(1, $totalEarningsRemaining);
                        } else {
                            $remaining = $data['totalBookings'] - $totalReservationsCreated + 1;
                            $avgPayout = $totalEarningsRemaining / max(1, $remaining);
                            $netAmount = max(1, round($avgPayout + rand(-50, 50)));
                            $totalEarningsRemaining -= $netAmount;
                        }

                        $grossAmount = round($netAmount / 0.85, 2);
                        $commissionAmount = round($grossAmount * 0.15, 2);

                        HostPayout::create([
                            'host_id' => $host->id,
                            'reservation_id' => $reservation->id,
                            'listing_id' => $listingId,
                            'gross_amount' => $grossAmount,
                            'commission_rate' => 15.00,
                            'commission_amount' => $commissionAmount,
                            'net_amount' => $netAmount,
                            'currency' => 'EUR',
                            'status' => 'paid',
                            'paid_date' => $checkIn->copy()->addDays($nights + 3),
                            'created_at' => $checkIn,
                            'updated_at' => $checkIn,
                        ]);
                    }
                }
            }

            // Create reviews spread across listings
            $reviewCount = min($data['totalBookings'], rand(8, 20));
            $targetAvg = $data['avgRating'];

            for ($r = 0; $r < $reviewCount; $r++) {
                $listingId = $listingIds[$r % count($listingIds)];
                $rating = $targetAvg + (rand(-5, 5) / 10);
                $rating = max(1.0, min(5.0, round($rating, 1)));

                Review::create([
                    'listing_id' => $listingId,
                    'user_id' => $guest->id,
                    'rating' => $rating,
                    'text' => $reviewTexts[$r % count($reviewTexts)],
                    'created_at' => $data['created_at']->copy()->addDays(rand(10, 365)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
