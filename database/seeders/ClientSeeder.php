<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Listing;
use App\Models\Reservation;
use App\Models\GuestReview;
use App\Models\ClientReport;
use App\Models\ActivityLog;
use App\Models\AdminNote;
use App\Models\HostDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Clients data matching the static frontend data
        $clientsData = [
            [
                'first_name' => 'Jean', 'last_name' => 'Dupont',
                'email' => 'jean.dupont@email.com',
                'phone' => '6 12 34 56 78', 'phone_country_code' => '+33',
                'address_country' => 'France', 'identity_verified' => true,
                'created_at' => Carbon::create(2024, 1, 15),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'fr',
                'verification_date' => Carbon::create(2024, 1, 20),
                'fraud_score' => 12, 'login_count' => 48, 'failed_logins' => 1,
                'last_login_at' => Carbon::create(2025, 3, 5, 14, 32),
                'last_login_ip' => '192.168.1.42', 'last_login_device' => 'Chrome / macOS',
            ],
            [
                'first_name' => 'Marie', 'last_name' => 'Simon',
                'email' => 'marie.simon@email.com',
                'phone' => '6 23 45 67 89', 'phone_country_code' => '+33',
                'address_country' => 'France', 'identity_verified' => true,
                'created_at' => Carbon::create(2024, 2, 3),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'fr',
                'verification_date' => Carbon::create(2024, 2, 10),
                'fraud_score' => 5, 'login_count' => 32, 'failed_logins' => 0,
                'last_login_at' => Carbon::create(2025, 3, 4, 9, 15),
                'last_login_ip' => '10.0.0.58', 'last_login_device' => 'Safari / iOS',
            ],
            [
                'first_name' => 'Pierre', 'last_name' => 'Laurent',
                'email' => 'pierre.laurent@email.com',
                'phone' => '514 555 1234', 'phone_country_code' => '+1',
                'address_country' => 'Canada', 'identity_verified' => false,
                'created_at' => Carbon::create(2024, 3, 22),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'fr',
                'verification_date' => null,
                'fraud_score' => 18, 'login_count' => 15, 'failed_logins' => 2,
                'last_login_at' => Carbon::create(2025, 3, 1, 16, 45),
                'last_login_ip' => '172.16.0.33', 'last_login_device' => 'Firefox / Windows',
            ],
            [
                'first_name' => 'Sophie', 'last_name' => 'Martin',
                'email' => 'sophie.martin@email.com',
                'phone' => '6 45 67 89 01', 'phone_country_code' => '+33',
                'address_country' => 'France', 'identity_verified' => true,
                'created_at' => Carbon::create(2023, 9, 8),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'fr',
                'verification_date' => Carbon::create(2023, 9, 15),
                'fraud_score' => 3, 'login_count' => 95, 'failed_logins' => 0,
                'last_login_at' => Carbon::create(2025, 3, 6, 10, 20),
                'last_login_ip' => '192.168.2.15', 'last_login_device' => 'Chrome / macOS',
            ],
            [
                'first_name' => 'Thomas', 'last_name' => 'Dubois',
                'email' => 'thomas.dubois@email.com',
                'phone' => '2 123 45 67', 'phone_country_code' => '+32',
                'address_country' => 'Belgique', 'identity_verified' => true,
                'created_at' => Carbon::create(2024, 11, 17),
                'client_status' => 'SUSPENDU', 'is_suspect' => true,
                'preferred_language' => 'fr',
                'verification_date' => Carbon::create(2024, 11, 25),
                'fraud_score' => 65, 'login_count' => 22, 'failed_logins' => 5,
                'last_login_at' => Carbon::create(2025, 2, 28, 23, 45),
                'last_login_ip' => '85.14.233.12', 'last_login_device' => 'Chrome / Windows',
            ],
            [
                'first_name' => 'Lucie', 'last_name' => 'Bernard',
                'email' => 'lucie.bernard@email.com',
                'phone' => '21 345 67 89', 'phone_country_code' => '+41',
                'address_country' => 'Suisse', 'identity_verified' => false,
                'created_at' => Carbon::create(2025, 1, 5),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'fr',
                'verification_date' => null,
                'fraud_score' => 8, 'login_count' => 6, 'failed_logins' => 0,
                'last_login_at' => Carbon::create(2025, 3, 2, 11, 30),
                'last_login_ip' => '10.0.1.22', 'last_login_device' => 'Safari / macOS',
            ],
            [
                'first_name' => 'Antoine', 'last_name' => 'Moreau',
                'email' => 'antoine.moreau@email.com',
                'phone' => '438 555 6789', 'phone_country_code' => '+1',
                'address_country' => 'Canada', 'identity_verified' => true,
                'created_at' => Carbon::create(2023, 6, 30),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'fr',
                'verification_date' => Carbon::create(2023, 7, 10),
                'fraud_score' => 7, 'login_count' => 78, 'failed_logins' => 1,
                'last_login_at' => Carbon::create(2025, 3, 5, 8, 15),
                'last_login_ip' => '192.168.3.44', 'last_login_device' => 'Chrome / macOS',
            ],
            [
                'first_name' => 'Camille', 'last_name' => 'Leroy',
                'email' => 'camille.leroy@email.com',
                'phone' => '6 89 01 23 45', 'phone_country_code' => '+33',
                'address_country' => 'France', 'identity_verified' => true,
                'created_at' => Carbon::create(2025, 2, 20),
                'client_status' => 'BANNI', 'is_suspect' => true,
                'preferred_language' => 'fr',
                'verification_date' => Carbon::create(2025, 2, 22),
                'fraud_score' => 92, 'login_count' => 3, 'failed_logins' => 8,
                'last_login_at' => Carbon::create(2025, 2, 25, 2, 10),
                'last_login_ip' => '45.33.12.88', 'last_login_device' => 'Chrome / Linux',
            ],
            [
                'first_name' => 'Romain', 'last_name' => 'Girard',
                'email' => 'romain.girard@email.com',
                'phone' => '6 90 12 34 56', 'phone_country_code' => '+33',
                'address_country' => 'France', 'identity_verified' => false,
                'created_at' => Carbon::create(2024, 10, 12),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'fr',
                'verification_date' => null,
                'fraud_score' => 22, 'login_count' => 28, 'failed_logins' => 3,
                'last_login_at' => Carbon::create(2025, 3, 4, 18, 50),
                'last_login_ip' => '10.0.0.77', 'last_login_device' => 'Firefox / macOS',
            ],
            [
                'first_name' => 'Isabelle', 'last_name' => 'Petit',
                'email' => 'isabelle.petit@email.com',
                'phone' => '613 555 4321', 'phone_country_code' => '+1',
                'address_country' => 'Canada', 'identity_verified' => true,
                'created_at' => Carbon::create(2024, 4, 28),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'en',
                'verification_date' => Carbon::create(2024, 5, 5),
                'fraud_score' => 6, 'login_count' => 45, 'failed_logins' => 0,
                'last_login_at' => Carbon::create(2025, 3, 5, 12, 0),
                'last_login_ip' => '192.168.1.100', 'last_login_device' => 'Chrome / Windows',
            ],
            [
                'first_name' => 'Marc', 'last_name' => 'Fontaine',
                'email' => 'marc.fontaine@email.com',
                'phone' => '6 11 22 33 44', 'phone_country_code' => '+33',
                'address_country' => 'France', 'identity_verified' => true,
                'created_at' => Carbon::create(2023, 4, 10),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'fr',
                'verification_date' => Carbon::create(2023, 4, 18),
                'fraud_score' => 4, 'login_count' => 112, 'failed_logins' => 1,
                'last_login_at' => Carbon::create(2025, 3, 6, 9, 30),
                'last_login_ip' => '10.0.2.50', 'last_login_device' => 'Safari / macOS',
            ],
            [
                'first_name' => 'Elena', 'last_name' => 'Rossi',
                'email' => 'elena.rossi@email.com',
                'phone' => '06 1234 5678', 'phone_country_code' => '+39',
                'address_country' => 'Italie', 'identity_verified' => true,
                'created_at' => Carbon::create(2024, 7, 14),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'it',
                'verification_date' => Carbon::create(2024, 7, 20),
                'fraud_score' => 9, 'login_count' => 35, 'failed_logins' => 0,
                'last_login_at' => Carbon::create(2025, 3, 3, 14, 15),
                'last_login_ip' => '192.168.4.22', 'last_login_device' => 'Chrome / Windows',
            ],
            [
                'first_name' => 'Yves', 'last_name' => 'Tremblay',
                'email' => 'yves.tremblay@email.com',
                'phone' => '514 999 8877', 'phone_country_code' => '+1',
                'address_country' => 'Canada', 'identity_verified' => false,
                'created_at' => Carbon::create(2025, 2, 2),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'fr',
                'verification_date' => null,
                'fraud_score' => 15, 'login_count' => 8, 'failed_logins' => 1,
                'last_login_at' => Carbon::create(2025, 3, 1, 20, 0),
                'last_login_ip' => '172.16.1.10', 'last_login_device' => 'Firefox / Windows',
            ],
            [
                'first_name' => 'Clara', 'last_name' => 'Muller',
                'email' => 'clara.muller@email.com',
                'phone' => '79 876 5432', 'phone_country_code' => '+41',
                'address_country' => 'Suisse', 'identity_verified' => true,
                'created_at' => Carbon::create(2023, 5, 19),
                'client_status' => 'ACTIF', 'is_suspect' => false,
                'preferred_language' => 'fr',
                'verification_date' => Carbon::create(2023, 5, 25),
                'fraud_score' => 2, 'login_count' => 88, 'failed_logins' => 0,
                'last_login_at' => Carbon::create(2025, 3, 6, 7, 45),
                'last_login_ip' => '10.0.3.15', 'last_login_device' => 'Safari / iOS',
            ],
        ];

        // Create host users that will own listings (for bookings to reference)
        $hosts = [];
        $hostNames = [
            ['first_name' => 'Marie', 'last_name' => 'Simon', 'email' => 'host.marie.simon@email.com'],
            ['first_name' => 'Pierre', 'last_name' => 'Laurent', 'email' => 'host.pierre.laurent@email.com'],
            ['first_name' => 'Sophie', 'last_name' => 'Martin', 'email' => 'host.sophie.martin@email.com'],
            ['first_name' => 'Thomas', 'last_name' => 'Dubois', 'email' => 'host.thomas.dubois@email.com'],
            ['first_name' => 'Camille', 'last_name' => 'Leroy', 'email' => 'host.camille.leroy@email.com'],
            ['first_name' => 'Antoine', 'last_name' => 'Moreau', 'email' => 'host.antoine.moreau@email.com'],
            ['first_name' => 'Lucie', 'last_name' => 'Bernard', 'email' => 'host.lucie.bernard@email.com'],
        ];

        foreach ($hostNames as $hostData) {
            $hosts[$hostData['email']] = User::updateOrCreate(
                ['email' => $hostData['email']],
                [
                    'first_name' => $hostData['first_name'],
                    'last_name' => $hostData['last_name'],
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'email_verified_at' => now(),
                    'host_status' => 'ACTIF',
                    'client_status' => 'ACTIF',
                ]
            );
        }

        // Create listings for the hosts
        $listingsMap = [];
        $listingsData = [
            ['title' => 'Villa Toscane', 'host' => 'host.marie.simon@email.com', 'city' => 'Nice', 'country' => 'France', 'base_price' => 250],
            ['title' => 'Appartement Paris 8e', 'host' => 'host.pierre.laurent@email.com', 'city' => 'Paris', 'country' => 'France', 'base_price' => 178],
            ['title' => 'Chalet Alpes', 'host' => 'host.sophie.martin@email.com', 'city' => 'Chamonix', 'country' => 'France', 'base_price' => 300],
            ['title' => 'Studio Lyon', 'host' => 'host.thomas.dubois@email.com', 'city' => 'Lyon', 'country' => 'France', 'base_price' => 85],
            ['title' => 'Loft Marseille', 'host' => 'host.camille.leroy@email.com', 'city' => 'Marseille', 'country' => 'France', 'base_price' => 140],
            ['title' => 'Maison Bordeaux', 'host' => 'host.antoine.moreau@email.com', 'city' => 'Bordeaux', 'country' => 'France', 'base_price' => 196],
            ['title' => 'Appartement Nice', 'host' => 'host.lucie.bernard@email.com', 'city' => 'Nice', 'country' => 'France', 'base_price' => 180],
        ];

        foreach ($listingsData as $ld) {
            $host = $hosts[$ld['host']];
            $listing = Listing::updateOrCreate(
                ['title' => $ld['title'], 'user_id' => $host->id],
                [
                    'status' => 'active',
                    'city' => $ld['city'],
                    'province' => $ld['city'],
                    'country' => $ld['country'],
                    'space_type' => 'entire',
                    'capacity' => rand(2, 8),
                    'bathrooms' => rand(1, 3),
                    'base_price' => $ld['base_price'],
                    'currency' => 'USD',
                    'reservation_mode' => 'instant',
                ]
            );
            $listingsMap[$ld['title']] = $listing;
        }

        // Now create client users and their associated data
        $createdClients = [];
        foreach ($clientsData as $cd) {
            $client = User::updateOrCreate(
                ['email' => $cd['email']],
                array_merge($cd, [
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'email_verified_at' => now(),
                ])
            );
            $createdClients[$cd['email']] = $client;
        }

        // ---- Jean Dupont (jean.dupont@email.com) - 12 bookings, 8320$ ----
        $jean = $createdClients['jean.dupont@email.com'];

        $jeanBookings = [
            ['listing' => 'Villa Toscane', 'check_in' => '2025-02-15', 'check_out' => '2025-02-20', 'amount' => 1250, 'status' => 'confirmed'],
            ['listing' => 'Appartement Paris 8e', 'check_in' => '2025-01-01', 'check_out' => '2025-01-05', 'amount' => 890, 'status' => 'completed'],
            ['listing' => 'Chalet Alpes', 'check_in' => '2024-12-20', 'check_out' => '2024-12-27', 'amount' => 2100, 'status' => 'completed'],
            ['listing' => 'Studio Lyon', 'check_in' => '2024-11-10', 'check_out' => '2024-11-12', 'amount' => 340, 'status' => 'cancelled', 'reason' => 'Logement non conforme aux photos'],
            ['listing' => 'Loft Marseille', 'check_in' => '2024-10-05', 'check_out' => '2024-10-08', 'amount' => 560, 'status' => 'completed'],
            ['listing' => 'Maison Bordeaux', 'check_in' => '2024-09-15', 'check_out' => '2024-09-20', 'amount' => 980, 'status' => 'completed'],
        ];

        foreach ($jeanBookings as $b) {
            $listing = $listingsMap[$b['listing']];
            Reservation::updateOrCreate(
                ['guest_id' => $jean->id, 'listing_id' => $listing->id, 'check_in' => $b['check_in']],
                [
                    'check_out' => $b['check_out'],
                    'guests_count' => rand(1, 4),
                    'status' => $b['status'],
                    'total_price' => $b['amount'],
                    'currency' => 'USD',
                    'cancellation_reason' => $b['reason'] ?? null,
                ]
            );
        }

        // Add remaining bookings for Jean to reach 12 total
        $extraListings = array_values($listingsMap);
        for ($i = 0; $i < 6; $i++) {
            $listing = $extraListings[$i % count($extraListings)];
            $monthOffset = 3 + $i;
            Reservation::updateOrCreate(
                ['guest_id' => $jean->id, 'listing_id' => $listing->id, 'check_in' => Carbon::create(2024, $monthOffset, 1)->format('Y-m-d')],
                [
                    'check_out' => Carbon::create(2024, $monthOffset, 3 + rand(1, 4))->format('Y-m-d'),
                    'guests_count' => rand(1, 3),
                    'status' => 'completed',
                    'total_price' => rand(200, 600),
                    'currency' => 'USD',
                ]
            );
        }

        // Jean's guest reviews (from hosts)
        $jeanReviews = [
            ['host_email' => 'host.marie.simon@email.com', 'listing' => 'Villa Toscane', 'rating' => 5, 'comment' => 'Voyageur exemplaire, tres respectueux du logement. Je recommande vivement.', 'date' => '2025-02-22'],
            ['host_email' => 'host.pierre.laurent@email.com', 'listing' => 'Appartement Paris 8e', 'rating' => 5, 'comment' => 'Client parfait, communication fluide et logement laisse impeccable.', 'date' => '2025-01-06'],
            ['host_email' => 'host.sophie.martin@email.com', 'listing' => 'Chalet Alpes', 'rating' => 4, 'comment' => 'Bon sejour, quelques retards de communication mais globalement tres bien.', 'date' => '2024-12-28'],
            ['host_email' => 'host.thomas.dubois@email.com', 'listing' => 'Studio Lyon', 'rating' => 4, 'comment' => 'Sejour annule mais client correct dans la communication.', 'date' => '2024-11-13'],
            ['host_email' => 'host.camille.leroy@email.com', 'listing' => 'Loft Marseille', 'rating' => 5, 'comment' => "Excellent voyageur, je l'accueillerais a nouveau sans hesitation.", 'date' => '2024-10-09'],
        ];

        foreach ($jeanReviews as $r) {
            $host = $hosts[$r['host_email']];
            $listing = $listingsMap[$r['listing']];
            GuestReview::updateOrCreate(
                ['host_id' => $host->id, 'guest_id' => $jean->id, 'listing_id' => $listing->id],
                [
                    'rating' => $r['rating'],
                    'comment' => $r['comment'],
                    'created_at' => Carbon::parse($r['date']),
                    'updated_at' => Carbon::parse($r['date']),
                ]
            );
        }

        // Jean's report
        ClientReport::updateOrCreate(
            ['client_id' => $jean->id, 'reason' => 'Annulation tardive'],
            [
                'reporter_id' => $hosts['host.thomas.dubois@email.com']->id,
                'description' => 'Le voyageur a annule moins de 24h avant le check-in sans raison valable.',
                'status' => 'RESOLU',
                'created_at' => Carbon::parse('2024-11-10'),
                'updated_at' => Carbon::parse('2024-11-10'),
            ]
        );

        // Jean's activity logs
        $jeanActivities = [
            ['action' => 'Connexion', 'detail' => 'Connexion reussie', 'date' => '2025-03-05 14:32', 'ip' => '192.168.1.42'],
            ['action' => 'Reservation', 'detail' => 'Nouvelle reservation Villa Toscane', 'date' => '2025-02-08 10:15', 'ip' => '192.168.1.42'],
            ['action' => 'Paiement', 'detail' => 'Paiement PAY-001 effectue', 'date' => '2025-02-10 11:20', 'ip' => '192.168.1.42'],
            ['action' => 'Modification profil', 'detail' => 'Mise a jour du numero de telephone', 'date' => '2025-02-01 09:45', 'ip' => '192.168.1.42'],
            ['action' => 'Avis', 'detail' => 'Avis depose pour Chalet Alpes', 'date' => '2024-12-28 16:00', 'ip' => '10.0.0.15'],
            ['action' => 'Connexion', 'detail' => 'Connexion reussie', 'date' => '2024-12-27 08:30', 'ip' => '10.0.0.15'],
        ];

        foreach ($jeanActivities as $a) {
            ActivityLog::updateOrCreate(
                ['user_id' => $jean->id, 'action' => $a['action'], 'created_at' => Carbon::parse($a['date'])],
                [
                    'detail' => $a['detail'],
                    'ip' => $a['ip'],
                    'updated_at' => Carbon::parse($a['date']),
                ]
            );
        }

        // Jean's documents
        HostDocument::updateOrCreate(
            ['user_id' => $jean->id, 'name' => "Carte d'identite"],
            ['status' => 'APPROUVE', 'created_at' => Carbon::parse('2024-01-15'), 'updated_at' => Carbon::parse('2024-01-15')]
        );
        HostDocument::updateOrCreate(
            ['user_id' => $jean->id, 'name' => 'Justificatif de domicile'],
            ['status' => 'APPROUVE', 'created_at' => Carbon::parse('2024-01-15'), 'updated_at' => Carbon::parse('2024-01-15')]
        );

        // Jean's admin note
        AdminNote::updateOrCreate(
            ['user_id' => $jean->id, 'content' => 'Client VIP - a effectue plus de 10 reservations. Offrir un code promo pour fidelisation.'],
            ['author' => 'Admin', 'created_at' => Carbon::parse('2025-03-01'), 'updated_at' => Carbon::parse('2025-03-01')]
        );

        // ---- Marie Simon (marie.simon@email.com) - 8 bookings, 5140$ ----
        $marie = $createdClients['marie.simon@email.com'];

        $marieBookings = [
            ['listing' => 'Maison Bordeaux', 'check_in' => '2025-03-01', 'check_out' => '2025-03-07', 'amount' => 1680, 'status' => 'confirmed'],
            ['listing' => 'Appartement Nice', 'check_in' => '2025-02-14', 'check_out' => '2025-02-18', 'amount' => 720, 'status' => 'completed'],
        ];

        foreach ($marieBookings as $b) {
            $listing = $listingsMap[$b['listing']];
            Reservation::updateOrCreate(
                ['guest_id' => $marie->id, 'listing_id' => $listing->id, 'check_in' => $b['check_in']],
                [
                    'check_out' => $b['check_out'],
                    'guests_count' => rand(1, 3),
                    'status' => $b['status'],
                    'total_price' => $b['amount'],
                    'currency' => 'USD',
                ]
            );
        }

        // Add extra bookings for Marie to reach 8
        for ($i = 0; $i < 6; $i++) {
            $listing = $extraListings[$i % count($extraListings)];
            $monthOffset = 4 + $i;
            Reservation::updateOrCreate(
                ['guest_id' => $marie->id, 'listing_id' => $listing->id, 'check_in' => Carbon::create(2024, $monthOffset, 5)->format('Y-m-d')],
                [
                    'check_out' => Carbon::create(2024, $monthOffset, 8 + rand(1, 3))->format('Y-m-d'),
                    'guests_count' => rand(1, 2),
                    'status' => 'completed',
                    'total_price' => rand(300, 600),
                    'currency' => 'USD',
                ]
            );
        }

        // Marie's guest reviews
        GuestReview::updateOrCreate(
            ['host_id' => $hosts['host.antoine.moreau@email.com']->id, 'guest_id' => $marie->id, 'listing_id' => $listingsMap['Maison Bordeaux']->id],
            ['rating' => 5, 'comment' => 'Voyageuse tres agreable et respectueuse.', 'created_at' => Carbon::parse('2025-03-08'), 'updated_at' => Carbon::parse('2025-03-08')]
        );
        GuestReview::updateOrCreate(
            ['host_id' => $hosts['host.lucie.bernard@email.com']->id, 'guest_id' => $marie->id, 'listing_id' => $listingsMap['Appartement Nice']->id],
            ['rating' => 4, 'comment' => 'Bon sejour, client ponctuel et sympathique.', 'created_at' => Carbon::parse('2025-02-19'), 'updated_at' => Carbon::parse('2025-02-19')]
        );

        // Marie's document
        HostDocument::updateOrCreate(
            ['user_id' => $marie->id, 'name' => 'Passeport'],
            ['status' => 'APPROUVE', 'created_at' => Carbon::parse('2024-02-03'), 'updated_at' => Carbon::parse('2024-02-03')]
        );

        // Marie's activity logs
        ActivityLog::updateOrCreate(
            ['user_id' => $marie->id, 'action' => 'Connexion', 'created_at' => Carbon::parse('2025-03-04 09:15')],
            ['detail' => 'Connexion reussie', 'ip' => '10.0.0.58', 'updated_at' => Carbon::parse('2025-03-04 09:15')]
        );
        ActivityLog::updateOrCreate(
            ['user_id' => $marie->id, 'action' => 'Reservation', 'created_at' => Carbon::parse('2025-02-20 14:30')],
            ['detail' => 'Nouvelle reservation Maison Bordeaux', 'ip' => '10.0.0.58', 'updated_at' => Carbon::parse('2025-02-20 14:30')]
        );

        // ---- Create bookings for remaining clients to match totalBookings counts ----
        $bookingCounts = [
            'pierre.laurent@email.com' => 3,
            'sophie.martin@email.com' => 21,
            'thomas.dubois@email.com' => 5,
            'lucie.bernard@email.com' => 1,
            'antoine.moreau@email.com' => 15,
            'camille.leroy@email.com' => 0,
            'romain.girard@email.com' => 7,
            'isabelle.petit@email.com' => 9,
            'marc.fontaine@email.com' => 18,
            'elena.rossi@email.com' => 6,
            'yves.tremblay@email.com' => 2,
            'clara.muller@email.com' => 11,
        ];

        $spentTargets = [
            'pierre.laurent@email.com' => 1890,
            'sophie.martin@email.com' => 15670,
            'thomas.dubois@email.com' => 3250,
            'lucie.bernard@email.com' => 420,
            'antoine.moreau@email.com' => 11200,
            'camille.leroy@email.com' => 0,
            'romain.girard@email.com' => 4580,
            'isabelle.petit@email.com' => 6730,
            'marc.fontaine@email.com' => 13450,
            'elena.rossi@email.com' => 4210,
            'yves.tremblay@email.com' => 980,
            'clara.muller@email.com' => 9870,
        ];

        foreach ($bookingCounts as $email => $count) {
            if ($count === 0) continue;
            $client = $createdClients[$email];
            $totalTarget = $spentTargets[$email];
            $avgAmount = $count > 0 ? round($totalTarget / $count) : 0;

            for ($i = 0; $i < $count; $i++) {
                $listing = $extraListings[$i % count($extraListings)];
                $monthsAgo = rand(1, 18);
                $checkIn = now()->subMonths($monthsAgo)->subDays(rand(0, 15));
                $nights = rand(2, 7);
                $amount = ($i === $count - 1)
                    ? max(0, $totalTarget - ($avgAmount * ($count - 1)))
                    : $avgAmount;

                $status = ($i === 0 && $email === 'thomas.dubois@email.com') ? 'cancelled' : (($i < 2) ? 'confirmed' : 'completed');

                Reservation::create([
                    'guest_id' => $client->id,
                    'listing_id' => $listing->id,
                    'check_in' => $checkIn->format('Y-m-d'),
                    'check_out' => $checkIn->addDays($nights)->format('Y-m-d'),
                    'guests_count' => rand(1, 4),
                    'status' => $status,
                    'total_price' => $amount,
                    'currency' => 'USD',
                    'cancellation_reason' => $status === 'cancelled' ? 'Annulation client' : null,
                ]);
            }
        }

        // Create guest reviews for other clients (to match averageRating)
        $ratingTargets = [
            'pierre.laurent@email.com' => [3.9, 2],
            'sophie.martin@email.com' => [4.9, 15],
            'thomas.dubois@email.com' => [4.2, 3],
            'antoine.moreau@email.com' => [4.7, 10],
            'romain.girard@email.com' => [3.6, 4],
            'isabelle.petit@email.com' => [4.4, 6],
            'marc.fontaine@email.com' => [4.6, 12],
            'elena.rossi@email.com' => [4.3, 4],
            'yves.tremblay@email.com' => [3.2, 1],
            'clara.muller@email.com' => [4.9, 8],
        ];

        $reviewComments = [
            'Voyageur tres respectueux, logement laisse en parfait etat.',
            'Excellent client, communication agreable et ponctuel.',
            'Bon sejour, rien a signaler.',
            'Client sympathique et discret.',
            'Tres bon voyageur, je recommande.',
            'Sejour agreable, client respectueux des regles.',
            'Parfait, aucun souci durant le sejour.',
            'Client ponctuel et soigneux.',
            'Bonne communication, logement bien entretenu.',
            'Voyageur ideal, a recommander sans hesitation.',
            'Client agreable, bon echange.',
            'Tres respectueux, logement impeccable au depart.',
            'Communication fluide, client discret.',
            'Bon client, respectueux des voisins.',
            'Sejour sans probleme, client recommande.',
        ];

        foreach ($ratingTargets as $email => [$targetRating, $reviewCount]) {
            $client = $createdClients[$email];
            for ($i = 0; $i < $reviewCount; $i++) {
                $hostKey = array_keys($hosts)[$i % count($hosts)];
                $host = $hosts[$hostKey];
                $listing = $extraListings[$i % count($extraListings)];

                // Vary ratings around target
                $rating = min(5, max(1, $targetRating + (rand(-2, 2) * 0.1)));
                $rating = round($rating, 1);

                GuestReview::create([
                    'host_id' => $host->id,
                    'guest_id' => $client->id,
                    'listing_id' => $listing->id,
                    'rating' => $rating,
                    'comment' => $reviewComments[$i % count($reviewComments)],
                    'created_at' => now()->subDays(rand(10, 300)),
                    'updated_at' => now()->subDays(rand(10, 300)),
                ]);
            }
        }

        // Create activity logs for all clients
        $actionTypes = [
            ['action' => 'Connexion', 'detail' => 'Connexion reussie'],
            ['action' => 'Reservation', 'detail' => 'Nouvelle reservation effectuee'],
            ['action' => 'Paiement', 'detail' => 'Paiement effectue'],
            ['action' => 'Modification profil', 'detail' => 'Mise a jour du profil'],
            ['action' => 'Connexion', 'detail' => 'Connexion reussie'],
        ];

        foreach ($createdClients as $email => $client) {
            // Skip Jean and Marie (already have activity logs)
            if (in_array($email, ['jean.dupont@email.com', 'marie.simon@email.com'])) continue;

            $logCount = rand(3, 8);
            for ($i = 0; $i < $logCount; $i++) {
                $at = $actionTypes[$i % count($actionTypes)];
                $date = now()->subDays(rand(1, 120))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
                ActivityLog::create([
                    'user_id' => $client->id,
                    'action' => $at['action'],
                    'detail' => $at['detail'],
                    'ip' => $client->last_login_ip ?? '192.168.1.' . rand(1, 254),
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }

        // Create reports for Thomas Dubois (suspect)
        $thomas = $createdClients['thomas.dubois@email.com'];
        ClientReport::updateOrCreate(
            ['client_id' => $thomas->id, 'reason' => 'Comportement suspect'],
            [
                'reporter_id' => $hosts['host.sophie.martin@email.com']->id,
                'description' => 'Le client a tente de contacter en dehors de la plateforme et a demande un paiement direct.',
                'status' => 'EN COURS',
                'created_at' => Carbon::parse('2025-01-15'),
                'updated_at' => Carbon::parse('2025-01-15'),
            ]
        );

        // Create reports for Camille Leroy (banned)
        $camille = $createdClients['camille.leroy@email.com'];
        ClientReport::updateOrCreate(
            ['client_id' => $camille->id, 'reason' => 'Fraude'],
            [
                'reporter_id' => $hosts['host.antoine.moreau@email.com']->id,
                'description' => 'Tentative de fraude avec carte bancaire volee. Compte banni.',
                'status' => 'RESOLU',
                'created_at' => Carbon::parse('2025-02-23'),
                'updated_at' => Carbon::parse('2025-02-23'),
            ]
        );
        ClientReport::updateOrCreate(
            ['client_id' => $camille->id, 'reason' => 'Usurpation identite'],
            [
                'reporter_id' => $hosts['host.marie.simon@email.com']->id,
                'description' => 'Documents d\'identite suspects, possible usurpation.',
                'status' => 'RESOLU',
                'created_at' => Carbon::parse('2025-02-24'),
                'updated_at' => Carbon::parse('2025-02-24'),
            ]
        );

        // Documents for other verified clients
        $verifiedEmails = [
            'sophie.martin@email.com', 'thomas.dubois@email.com', 'antoine.moreau@email.com',
            'camille.leroy@email.com', 'isabelle.petit@email.com', 'marc.fontaine@email.com',
            'elena.rossi@email.com', 'clara.muller@email.com',
        ];

        $docTypes = ["Carte d'identite", 'Passeport', 'Justificatif de domicile', 'Permis de conduire'];

        foreach ($verifiedEmails as $email) {
            $client = $createdClients[$email];
            $docCount = rand(1, 2);
            for ($i = 0; $i < $docCount; $i++) {
                HostDocument::updateOrCreate(
                    ['user_id' => $client->id, 'name' => $docTypes[$i]],
                    [
                        'status' => 'APPROUVE',
                        'created_at' => $client->created_at->addDays(rand(0, 5)),
                        'updated_at' => $client->created_at->addDays(rand(0, 5)),
                    ]
                );
            }
        }
    }
}
