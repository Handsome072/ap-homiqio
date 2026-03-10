-- Delete old seeded listings and their photos (keep listing 2)
DELETE FROM listing_photos WHERE listing_id >= 253;
DELETE FROM listings WHERE id >= 253;

-- Reset auto increment
ALTER TABLE listings AUTO_INCREMENT = 253;
ALTER TABLE listing_photos AUTO_INCREMENT = 100;

-- =============================================
-- EMILY (user_id=57) - 5 listings (IDs 253-257)
-- =============================================

INSERT INTO listings (id, user_id, status, rental_frequency, space_type, full_address, street, city, postal_code, province, country, latitude, longitude, capacity, adults, bathrooms, bedrooms_data, amenities, title, subtitle, description, about_chalet, reservation_mode, arrival_time, departure_time, min_stay, max_stay, currency, base_price, weekend_price, cleaning_fee, cancellation_policy, created_at, updated_at) VALUES
(253, 57, 'active', 'nightly', 'entire', '125 Chemin du Lac, Sainte-Adele, QC J8B 2N5', '125 Chemin du Lac', 'Sainte-Adele', 'J8B 2N5', 'QC', 'CA', 46.0500, -74.1400, 6, 4, 2, '[{"name":"Chambre principale","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"double","count":1}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","washer","dryer"]', 'Chalet bois rond au bord du lac', 'Refuge chaleureux dans les Laurentides', 'Magnifique chalet en bois rond situe directement au bord du lac. Profitez du foyer, du spa exterieur et de la nature environnante. Ideal pour une escapade en famille ou entre amis.', 'Construit en 2018 avec des materiaux nobles, ce chalet offre tout le confort moderne dans un cadre rustique et authentique.', 'request', '15:00', '11:00', '2', '14', 'CAD', 195.00, 225.00, 85.00, 'moderate', NOW(), NOW()),

(254, 57, 'active', 'nightly', 'entire', '48 Route des Pionniers, Charlevoix, QC G5A 1T3', '48 Route des Pionniers', 'Baie-Saint-Paul', 'G5A 1T3', 'QC', 'CA', 47.4400, -70.4986, 8, 6, 3, '[{"name":"Suite parentale","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Chambre 3","beds":[{"type":"single","count":2}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","mountain_view","sauna"]', 'Chalet vue fleuve a Charlevoix', 'Vue imprenable sur le Saint-Laurent', 'Superbe chalet avec vue panoramique sur le fleuve Saint-Laurent et les montagnes de Charlevoix. Spa exterieur, sauna finlandais et foyer au bois.', 'Nichee dans les hauteurs de Baie-Saint-Paul, cette propriete offre une vue a couper le souffle sur le fleuve.', 'request', '16:00', '11:00', '2', '21', 'CAD', 275.00, 320.00, 120.00, 'strict', NOW(), NOW()),

(255, 57, 'active', 'nightly', 'entire', '89 Chemin Nature, Sutton, QC J0E 2K0', '89 Chemin Nature', 'Sutton', 'J0E 2K0', 'QC', 'CA', 45.1000, -72.6100, 4, 2, 1, '[{"name":"Chambre principale","beds":[{"type":"queen","count":1}]},{"name":"Mezzanine","beds":[{"type":"double","count":1}]}]', '["wifi","fireplace","bbq","parking","kitchen","hiking_trails"]', 'Refuge forestier dans les Cantons-de-l''Est', 'Immersion totale en nature', 'Petit chalet douillet nichee dans la foret des Cantons-de-l''Est. Parfait pour les couples ou petites familles cherchant la tranquillite.', 'Situe sur un terrain boise de 5 acres, ce refuge offre une immersion totale dans la nature.', 'instant', '15:00', '10:00', '2', '7', 'CAD', 155.00, 185.00, 65.00, 'flexible', NOW(), NOW()),

(256, 57, 'active', 'nightly', 'entire', '210 Rang Saint-Joseph, Stoneham, QC G3C 0P8', '210 Rang Saint-Joseph', 'Stoneham', 'G3C 0P8', 'QC', 'CA', 47.0200, -71.3700, 10, 8, 3, '[{"name":"Suite maitre","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Chambre 3","beds":[{"type":"single","count":2}]},{"name":"Sous-sol","beds":[{"type":"double","count":2}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","ski_access","game_room"]', 'Grand chalet ski-in a Stoneham', 'Acces direct aux pistes de ski', 'Immense chalet familial avec acces ski-in/ski-out a la station Stoneham. Salle de jeux, spa 8 places et foyer double face.', 'Idealement situe au pied des pistes, ce chalet peut accueillir jusqu''a 10 personnes.', 'request', '16:00', '11:00', '3', '14', 'CAD', 345.00, 395.00, 150.00, 'strict', NOW(), NOW()),

(257, 57, 'active', 'nightly', 'entire', '15 Chemin des Erables, Ile d''Orleans, QC G0A 3W0', '15 Chemin des Erables', 'Ile d''Orleans', 'G0A 3W0', 'QC', 'CA', 46.9200, -70.9800, 6, 4, 2, '[{"name":"Chambre 1","beds":[{"type":"queen","count":1}]},{"name":"Chambre 2","beds":[{"type":"double","count":1}]},{"name":"Chambre 3","beds":[{"type":"single","count":2}]}]', '["wifi","fireplace","bbq","parking","kitchen","river_view","garden"]', 'Maison champetre sur l''Ile d''Orleans', 'Charme patrimonial et vue sur le fleuve', 'Charmante maison de campagne sur l''Ile d''Orleans avec vue sur le fleuve. Jardin, verger et ambiance champetre garantie.', 'Cette maison centenaire renovee allie le charme d''antan au confort moderne.', 'request', '15:00', '11:00', '2', '14', 'CAD', 220.00, 255.00, 95.00, 'moderate', NOW(), NOW());

-- =============================================
-- PASCAL (user_id=58) - 5 listings (IDs 258-262)
-- =============================================

INSERT INTO listings (id, user_id, status, rental_frequency, space_type, full_address, street, city, postal_code, province, country, latitude, longitude, capacity, adults, bathrooms, bedrooms_data, amenities, title, subtitle, description, about_chalet, reservation_mode, arrival_time, departure_time, min_stay, max_stay, currency, base_price, weekend_price, cleaning_fee, cancellation_policy, created_at, updated_at) VALUES
(258, 58, 'active', 'nightly', 'entire', '334 Chemin du Mont, Saint-Sauveur, QC J0R 1R0', '334 Chemin du Mont', 'Saint-Sauveur', 'J0R 1R0', 'QC', 'CA', 45.9000, -74.1700, 8, 6, 2, '[{"name":"Suite principale","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Chambre 3","beds":[{"type":"double","count":1}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","pool","mountain_view"]', 'Chalet rustique dans les Laurentides', 'Ambiance chaleureuse et vue sur la montagne', 'Magnifique chalet rustique au coeur des Laurentides. Piscine chauffee, spa exterieur et vue imprenable sur les montagnes.', 'Situe a 5 minutes du village de Saint-Sauveur, ce chalet offre le parfait equilibre entre nature et commodites.', 'request', '15:00', '11:00', '2', '14', 'CAD', 295.00, 345.00, 120.00, 'moderate', NOW(), NOW()),

(259, 58, 'active', 'nightly', 'entire', '78 Chemin du Lac-Tremblant, Mont-Tremblant, QC J8E 1T1', '78 Chemin du Lac-Tremblant', 'Mont-Tremblant', 'J8E 1T1', 'QC', 'CA', 46.2100, -74.5900, 6, 4, 2, '[{"name":"Chambre 1","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","lake_access","kayak"]', 'Chalet spa au Lac-Tremblant', 'Directement sur le lac', 'Chalet de luxe avec acces direct au Lac Tremblant. Spa exterieur, kayaks inclus et quai prive.', 'Profitez du calme absolu du lac tout en etant a 10 minutes du village pietonnier.', 'request', '16:00', '11:00', '2', '14', 'CAD', 320.00, 375.00, 130.00, 'strict', NOW(), NOW()),

(260, 58, 'active', 'nightly', 'entire', '456 Sea to Sky Hwy, Whistler, BC V8E 0A1', '456 Sea to Sky Hwy', 'Whistler', 'V8E 0A1', 'BC', 'CA', 50.1163, -122.9574, 8, 6, 3, '[{"name":"Suite maitre","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Chambre 3","beds":[{"type":"double","count":1}]},{"name":"Chambre 4","beds":[{"type":"single","count":2}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","ski_access","sauna","gym"]', 'Chalet ski alpin a Whistler', 'Ski-in/Ski-out sur Blackcomb', 'Luxueux chalet avec acces direct aux pistes de Whistler-Blackcomb. Sauna, gym privee et vue spectaculaire sur les montagnes.', 'Un des plus beaux chalets de la station, entierement renove en 2023.', 'request', '16:00', '10:00', '3', '21', 'CAD', 450.00, 525.00, 200.00, 'strict', NOW(), NOW()),

(261, 58, 'active', 'nightly', 'entire', '22 Chemin de Chelsea, Chelsea, QC J9B 1C1', '22 Chemin de Chelsea', 'Chelsea', 'J9B 1C1', 'QC', 'CA', 45.5200, -75.7900, 6, 4, 2, '[{"name":"Chambre 1","beds":[{"type":"queen","count":1}]},{"name":"Chambre 2","beds":[{"type":"double","count":1}]},{"name":"Mezzanine","beds":[{"type":"single","count":2}]}]', '["wifi","fireplace","bbq","parking","kitchen","hiking_trails","bike_trails"]', 'Chalet familial pres du Parc de la Gatineau', 'Nature et plein air', 'Chalet confortable aux portes du Parc de la Gatineau. Sentiers de randonnee et pistes cyclables a proximite.', 'Ideal pour les amoureux de plein air, a seulement 20 minutes d''Ottawa.', 'instant', '15:00', '11:00', '2', '14', 'CAD', 215.00, 245.00, 85.00, 'flexible', NOW(), NOW()),

(262, 58, 'active', 'nightly', 'entire', '89 Muskoka Rd, Bracebridge, ON P1L 1W8', '89 Muskoka Rd', 'Bracebridge', 'P1L 1W8', 'ON', 'CA', 44.9800, -79.3100, 10, 8, 3, '[{"name":"Suite lac","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Chambre 3","beds":[{"type":"double","count":2}]},{"name":"Chambre 4","beds":[{"type":"single","count":2}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","lake_access","boat_dock","canoe"]', 'Chalet sur le lac a Muskoka', 'Le cottage canadien par excellence', 'Grand chalet familial directement sur le lac Muskoka. Quai, canoe, feu de camp et tout le charme du cottage country.', 'Un classique du cottage country ontarien avec toutes les commodites modernes.', 'request', '16:00', '11:00', '3', '21', 'CAD', 285.00, 335.00, 130.00, 'moderate', NOW(), NOW());

-- =============================================
-- LUCAS (user_id=59) - 5 listings (IDs 263-267)
-- =============================================

INSERT INTO listings (id, user_id, status, rental_frequency, space_type, full_address, street, city, postal_code, province, country, latitude, longitude, capacity, adults, bathrooms, bedrooms_data, amenities, title, subtitle, description, about_chalet, reservation_mode, arrival_time, departure_time, min_stay, max_stay, currency, base_price, weekend_price, cleaning_fee, cancellation_policy, created_at, updated_at) VALUES
(263, 59, 'active', 'nightly', 'entire', '567 Chemin Duplessis, Mont-Tremblant, QC J8E 1K5', '567 Chemin Duplessis', 'Mont-Tremblant', 'J8E 1K5', 'QC', 'CA', 46.2185, -74.5956, 4, 2, 1, '[{"name":"Chambre treehouse","beds":[{"type":"queen","count":1}]},{"name":"Coin nuit","beds":[{"type":"single","count":2}]}]', '["wifi","fireplace","bbq","parking","kitchen","treehouse","nature_view"]', 'Cabane dans les arbres a Tremblant', 'Experience unique en hauteur', 'Vivez une experience unique dans cette cabane perchee dans les arbres. Vue spectaculaire sur la foret et le lac.', 'Construite de maniere ecoresponsable, cette cabane offre une experience inoubliable.', 'request', '15:00', '10:00', '2', '7', 'CAD', 189.00, 225.00, 75.00, 'moderate', NOW(), NOW()),

(264, 59, 'active', 'nightly', 'entire', '123 Bow Valley Trail, Banff, AB T1L 1A1', '123 Bow Valley Trail', 'Banff', 'T1L 1A1', 'AB', 'CA', 51.1784, -115.5708, 8, 6, 3, '[{"name":"Suite montagne","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Chambre 3","beds":[{"type":"double","count":1}]},{"name":"Loft","beds":[{"type":"single","count":2}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","mountain_view","ski_storage"]', 'Chalet de montagne a Banff', 'Au coeur des Rocheuses canadiennes', 'Somptueux chalet au pied des Rocheuses. Spa exterieur avec vue sur les montagnes, foyer au bois et acces rapide aux pistes.', 'Situe a 5 minutes du centre-ville de Banff, dans un environnement naturel exceptionnel.', 'request', '16:00', '11:00', '3', '21', 'CAD', 380.00, 450.00, 175.00, 'strict', NOW(), NOW()),

(265, 59, 'active', 'nightly', 'entire', '890 Pacific Rim Hwy, Tofino, BC V0R 2Z0', '890 Pacific Rim Hwy', 'Tofino', 'V0R 2Z0', 'BC', 'CA', 49.1530, -125.9066, 6, 4, 2, '[{"name":"Chambre ocean","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Chambre 3","beds":[{"type":"double","count":1}]}]', '["wifi","fireplace","bbq","parking","kitchen","ocean_view","surfboard_storage","outdoor_shower"]', 'Refuge cotier a Tofino', 'Les vagues a vos pieds', 'Chalet unique en bord de mer avec vue sur l''ocean Pacifique. Ideal pour les surfeurs et amoureux de la nature sauvage de la cote Ouest.', 'A quelques pas de Long Beach, dans un cadre naturel preserve.', 'request', '15:00', '11:00', '2', '14', 'CAD', 265.00, 310.00, 110.00, 'moderate', NOW(), NOW()),

(266, 59, 'active', 'nightly', 'entire', '45 Rue du Lac, Alma, QC G8B 5V2', '45 Rue du Lac', 'Alma', 'G8B 5V2', 'QC', 'CA', 48.5500, -71.6500, 8, 6, 2, '[{"name":"Chambre 1","beds":[{"type":"queen","count":1}]},{"name":"Chambre 2","beds":[{"type":"double","count":1}]},{"name":"Chambre 3","beds":[{"type":"single","count":2}]},{"name":"Salon","beds":[{"type":"sofa_bed","count":1}]}]', '["wifi","fireplace","bbq","parking","kitchen","lake_access","fishing","canoe"]', 'Chalet du Lac-Saint-Jean', 'Peche, canot et tranquillite', 'Grand chalet familial au bord du Lac-Saint-Jean. Quai de peche prive, canoe et ambiance familiale garantie.', 'Un endroit paisible pour decouvrir la beaute du Lac-Saint-Jean.', 'instant', '15:00', '11:00', '2', '14', 'CAD', 165.00, 195.00, 75.00, 'flexible', NOW(), NOW()),

(267, 59, 'active', 'nightly', 'entire', '200 Rue Saint-Paul, Quebec, QC G1K 3W2', '200 Rue Saint-Paul', 'Quebec', 'G1K 3W2', 'QC', 'CA', 46.8140, -71.2074, 4, 2, 1, '[{"name":"Suite","beds":[{"type":"queen","count":1}]},{"name":"Mezzanine","beds":[{"type":"double","count":1}]}]', '["wifi","fireplace","parking","kitchen","city_view","heritage_building"]', 'Loft heritage dans le Vieux-Quebec', 'Charme historique au coeur de la ville', 'Magnifique loft dans un batiment patrimonial du Vieux-Quebec. Murs de pierre, poutres apparentes et vue sur le fleuve.', 'Un alliage parfait entre histoire et confort moderne, au coeur du Vieux-Quebec.', 'instant', '15:00', '11:00', '1', '14', 'CAD', 225.00, 265.00, 90.00, 'moderate', NOW(), NOW());

-- =============================================
-- ROMEO (user_id=60) - 5 listings (IDs 268-272)
-- =============================================

INSERT INTO listings (id, user_id, status, rental_frequency, space_type, full_address, street, city, postal_code, province, country, latitude, longitude, capacity, adults, bathrooms, bedrooms_data, amenities, title, subtitle, description, about_chalet, reservation_mode, arrival_time, departure_time, min_stay, max_stay, currency, base_price, weekend_price, cleaning_fee, cancellation_policy, created_at, updated_at) VALUES
(268, 60, 'active', 'nightly', 'entire', '78 Chemin des Falaises, La Malbaie, QC G5A 2Y5', '78 Chemin des Falaises', 'La Malbaie', 'G5A 2Y5', 'QC', 'CA', 47.6500, -70.1500, 10, 8, 4, '[{"name":"Suite royale","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Chambre 3","beds":[{"type":"queen","count":1}]},{"name":"Chambre 4","beds":[{"type":"double","count":2}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","mountain_view","sauna","wine_cellar","home_cinema"]', 'Chalet grand luxe a Charlevoix', 'Le summum du luxe en nature', 'Chalet haut de gamme avec cinema maison, cave a vin, sauna et spa. Vue panoramique sur les montagnes et le fleuve.', 'Le chalet ultime pour des vacances inoubliables a Charlevoix.', 'request', '16:00', '11:00', '3', '21', 'CAD', 495.00, 575.00, 250.00, 'strict', NOW(), NOW()),

(269, 60, 'active', 'nightly', 'entire', '345 Marine Drive, Tofino, BC V0R 2Z0', '345 Marine Drive', 'Tofino', 'V0R 2Z0', 'BC', 'CA', 49.1560, -125.9030, 6, 4, 2, '[{"name":"Chambre ocean","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Loft","beds":[{"type":"double","count":1}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","ocean_view","outdoor_shower","surfboard_storage"]', 'Cabane ocean vue Pacifique a Tofino', 'Reveil face a l''ocean', 'Cabane de charme avec vue imprenable sur l''ocean Pacifique. Spa exterieur, terrasse panoramique et acces direct a la plage.', 'Un lieu magique ou la foret rencontre l''ocean.', 'request', '15:00', '11:00', '2', '14', 'CAD', 295.00, 345.00, 120.00, 'moderate', NOW(), NOW()),

(270, 60, 'active', 'nightly', 'entire', '567 Mountain Ave, Canmore, AB T1W 1A1', '567 Mountain Ave', 'Canmore', 'T1W 1A1', 'AB', 'CA', 51.0884, -115.3480, 8, 6, 3, '[{"name":"Suite Rocheuses","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Chambre 3","beds":[{"type":"double","count":1}]},{"name":"Den","beds":[{"type":"sofa_bed","count":1}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","mountain_view","ski_storage","bike_storage"]', 'Chalet alpin a Canmore-Banff', 'Aux portes du Parc national de Banff', 'Chalet moderne au pied des Rocheuses, a 15 minutes de Banff. Vue spectaculaire, spa et acces aux sentiers de randonnee.', 'L''emplacement ideal pour explorer les Rocheuses canadiennes.', 'request', '16:00', '11:00', '2', '21', 'CAD', 310.00, 365.00, 140.00, 'strict', NOW(), NOW()),

(271, 60, 'active', 'nightly', 'entire', '123 Chemin du Parc, Val-des-Monts, QC J8N 7E8', '123 Chemin du Parc', 'Val-des-Monts', 'J8N 7E8', 'QC', 'CA', 45.5000, -75.6500, 6, 4, 2, '[{"name":"Chambre 1","beds":[{"type":"queen","count":1}]},{"name":"Chambre 2","beds":[{"type":"double","count":1}]},{"name":"Chambre 3","beds":[{"type":"single","count":2}]}]', '["wifi","fireplace","hot_tub","bbq","parking","kitchen","lake_access","canoe","fishing"]', 'Maison champetre a Gatineau', 'Lac prive et serenite', 'Chalet au bord d''un lac prive dans la region de Gatineau. Canoe, peche et spa exterieur sous les etoiles.', 'Un havre de paix a seulement 30 minutes d''Ottawa.', 'instant', '15:00', '11:00', '2', '14', 'CAD', 185.00, 215.00, 80.00, 'flexible', NOW(), NOW()),

(272, 60, 'active', 'nightly', 'entire', '456 Rue du Quai, Roberval, QC G8H 1V5', '456 Rue du Quai', 'Roberval', 'G8H 1V5', 'QC', 'CA', 48.5200, -72.2200, 8, 6, 2, '[{"name":"Chambre lac","beds":[{"type":"king","count":1}]},{"name":"Chambre 2","beds":[{"type":"queen","count":1}]},{"name":"Chambre 3","beds":[{"type":"double","count":1}]},{"name":"Salon","beds":[{"type":"sofa_bed","count":1}]}]', '["wifi","fireplace","bbq","parking","kitchen","lake_access","fishing","canoe","snowmobile_access"]', 'Chalet de peche au Lac-Saint-Jean', 'Paradis du pecheur', 'Grand chalet au bord du Lac-Saint-Jean avec quai de peche prive. Motoneige en hiver, baignade et peche en ete.', 'Le reve de tout amateur de plein air et de peche sportive.', 'request', '15:00', '11:00', '2', '14', 'CAD', 175.00, 205.00, 80.00, 'moderate', NOW(), NOW());

-- =============================================
-- PHOTOS - 5 unique chalet photos per listing
-- Using verified Unsplash chalet/cabin photo IDs
-- =============================================

-- Emily listing 253 - Chalet bois rond Sainte-Adele
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(253, 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80', 0, NOW(), NOW()),
(253, 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=800&q=80', 1, NOW(), NOW()),
(253, 'https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=800&q=80', 2, NOW(), NOW()),
(253, 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80', 3, NOW(), NOW()),
(253, 'https://images.unsplash.com/photo-1542718610-a1d656d1884c?w=800&q=80', 4, NOW(), NOW());

-- Emily listing 254 - Chalet vue fleuve Charlevoix
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(254, 'https://images.unsplash.com/photo-1518732714860-b62714ce0c59?w=800&q=80', 0, NOW(), NOW()),
(254, 'https://images.unsplash.com/photo-1587061949409-02df41d5e562?w=800&q=80', 1, NOW(), NOW()),
(254, 'https://images.unsplash.com/photo-1595877244574-e90ce41ce089?w=800&q=80', 2, NOW(), NOW()),
(254, 'https://images.unsplash.com/photo-1521401830884-6c03c1c87ebb?w=800&q=80', 3, NOW(), NOW()),
(254, 'https://images.unsplash.com/photo-1604014237800-1c9102c219da?w=800&q=80', 4, NOW(), NOW());

-- Emily listing 255 - Refuge forestier Sutton
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(255, 'https://images.unsplash.com/photo-1470770841497-7b3202e2f483?w=800&q=80', 0, NOW(), NOW()),
(255, 'https://images.unsplash.com/photo-1482192505345-5655af888cc4?w=800&q=80', 1, NOW(), NOW()),
(255, 'https://images.unsplash.com/photo-1605146769289-440113cc3d00?w=800&q=80', 2, NOW(), NOW()),
(255, 'https://images.unsplash.com/photo-1416331108676-a22ccb276e35?w=800&q=80', 3, NOW(), NOW()),
(255, 'https://images.unsplash.com/photo-1544984243-ec57ea16fe25?w=800&q=80', 4, NOW(), NOW());

-- Emily listing 256 - Grand chalet Stoneham
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(256, 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=800&q=80', 0, NOW(), NOW()),
(256, 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80', 1, NOW(), NOW()),
(256, 'https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=800&q=80', 2, NOW(), NOW()),
(256, 'https://images.unsplash.com/photo-1596178065887-1198b6148b2b?w=800&q=80', 3, NOW(), NOW()),
(256, 'https://images.unsplash.com/photo-1600585152220-90363fe7e115?w=800&q=80', 4, NOW(), NOW());

-- Emily listing 257 - Maison Ile d'Orleans
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(257, 'https://images.unsplash.com/photo-1600573472550-8090b5e0745e?w=800&q=80', 0, NOW(), NOW()),
(257, 'https://images.unsplash.com/photo-1592417817098-8fd3d9eb14a5?w=800&q=80', 1, NOW(), NOW()),
(257, 'https://images.unsplash.com/photo-1600607687644-aac4c3eac7f4?w=800&q=80', 2, NOW(), NOW()),
(257, 'https://images.unsplash.com/photo-1560185007-cde436f6a4d0?w=800&q=80', 3, NOW(), NOW()),
(257, 'https://images.unsplash.com/photo-1560185127-6ed189bf02f4?w=800&q=80', 4, NOW(), NOW());

-- Pascal listing 258 - Chalet rustique Saint-Sauveur
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(258, 'https://images.unsplash.com/photo-1520984032042-162d526883e0?w=800&q=80', 0, NOW(), NOW()),
(258, 'https://images.unsplash.com/photo-1595521624992-48a59aef95e3?w=800&q=80', 1, NOW(), NOW()),
(258, 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=800&q=80', 2, NOW(), NOW()),
(258, 'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?w=800&q=80', 3, NOW(), NOW()),
(258, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800&q=80', 4, NOW(), NOW());

-- Pascal listing 259 - Chalet spa Lac-Tremblant
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(259, 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80', 0, NOW(), NOW()),
(259, 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80', 1, NOW(), NOW()),
(259, 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=80', 2, NOW(), NOW()),
(259, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80', 3, NOW(), NOW()),
(259, 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80', 4, NOW(), NOW());

-- Pascal listing 260 - Chalet Whistler
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(260, 'https://images.unsplash.com/photo-1499696010180-025ef6e1a8f9?w=800&q=80', 0, NOW(), NOW()),
(260, 'https://images.unsplash.com/photo-1618767689160-da3fb810aad7?w=800&q=80', 1, NOW(), NOW()),
(260, 'https://images.unsplash.com/photo-1575517111478-7f6afd0973db?w=800&q=80', 2, NOW(), NOW()),
(260, 'https://images.unsplash.com/photo-1551524559-8af4e6624178?w=800&q=80', 3, NOW(), NOW()),
(260, 'https://images.unsplash.com/photo-1505916349660-8d91a09afa5a?w=800&q=80', 4, NOW(), NOW());

-- Pascal listing 261 - Chalet Gatineau
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(261, 'https://images.unsplash.com/photo-1505843513577-22bb7d21e455?w=800&q=80', 0, NOW(), NOW()),
(261, 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&q=80', 1, NOW(), NOW()),
(261, 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=800&q=80', 2, NOW(), NOW()),
(261, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&q=80', 3, NOW(), NOW()),
(261, 'https://images.unsplash.com/photo-1630699144867-37acec97df5a?w=800&q=80', 4, NOW(), NOW());

-- Pascal listing 262 - Chalet Muskoka
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(262, 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=800&q=80', 0, NOW(), NOW()),
(262, 'https://images.unsplash.com/photo-1600607687644-aac4c3eac7f4?w=800&q=80', 1, NOW(), NOW()),
(262, 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80', 2, NOW(), NOW()),
(262, 'https://images.unsplash.com/photo-1560185007-cde436f6a4d0?w=800&q=80', 3, NOW(), NOW()),
(262, 'https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=800&q=80', 4, NOW(), NOW());

-- Lucas listing 263 - Cabane arbres Tremblant
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(263, 'https://images.unsplash.com/photo-1596178065887-1198b6148b2b?w=800&q=80', 0, NOW(), NOW()),
(263, 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80', 1, NOW(), NOW()),
(263, 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80', 2, NOW(), NOW()),
(263, 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=800&q=80', 3, NOW(), NOW()),
(263, 'https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=800&q=80', 4, NOW(), NOW());

-- Lucas listing 264 - Chalet Banff
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(264, 'https://images.unsplash.com/photo-1542718610-a1d656d1884c?w=800&q=80', 0, NOW(), NOW()),
(264, 'https://images.unsplash.com/photo-1518732714860-b62714ce0c59?w=800&q=80', 1, NOW(), NOW()),
(264, 'https://images.unsplash.com/photo-1587061949409-02df41d5e562?w=800&q=80', 2, NOW(), NOW()),
(264, 'https://images.unsplash.com/photo-1595877244574-e90ce41ce089?w=800&q=80', 3, NOW(), NOW()),
(264, 'https://images.unsplash.com/photo-1521401830884-6c03c1c87ebb?w=800&q=80', 4, NOW(), NOW());

-- Lucas listing 265 - Refuge Tofino
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(265, 'https://images.unsplash.com/photo-1604014237800-1c9102c219da?w=800&q=80', 0, NOW(), NOW()),
(265, 'https://images.unsplash.com/photo-1470770841497-7b3202e2f483?w=800&q=80', 1, NOW(), NOW()),
(265, 'https://images.unsplash.com/photo-1482192505345-5655af888cc4?w=800&q=80', 2, NOW(), NOW()),
(265, 'https://images.unsplash.com/photo-1605146769289-440113cc3d00?w=800&q=80', 3, NOW(), NOW()),
(265, 'https://images.unsplash.com/photo-1416331108676-a22ccb276e35?w=800&q=80', 4, NOW(), NOW());

-- Lucas listing 266 - Chalet Lac-Saint-Jean
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(266, 'https://images.unsplash.com/photo-1544984243-ec57ea16fe25?w=800&q=80', 0, NOW(), NOW()),
(266, 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=800&q=80', 1, NOW(), NOW()),
(266, 'https://images.unsplash.com/photo-1600585152220-90363fe7e115?w=800&q=80', 2, NOW(), NOW()),
(266, 'https://images.unsplash.com/photo-1600573472550-8090b5e0745e?w=800&q=80', 3, NOW(), NOW()),
(266, 'https://images.unsplash.com/photo-1592417817098-8fd3d9eb14a5?w=800&q=80', 4, NOW(), NOW());

-- Lucas listing 267 - Loft Vieux-Quebec
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(267, 'https://images.unsplash.com/photo-1560185007-cde436f6a4d0?w=800&q=80', 0, NOW(), NOW()),
(267, 'https://images.unsplash.com/photo-1560185127-6ed189bf02f4?w=800&q=80', 1, NOW(), NOW()),
(267, 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=800&q=80', 2, NOW(), NOW()),
(267, 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=80', 3, NOW(), NOW()),
(267, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80', 4, NOW(), NOW());

-- Romeo listing 268 - Chalet luxe Charlevoix
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(268, 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80', 0, NOW(), NOW()),
(268, 'https://images.unsplash.com/photo-1499696010180-025ef6e1a8f9?w=800&q=80', 1, NOW(), NOW()),
(268, 'https://images.unsplash.com/photo-1618767689160-da3fb810aad7?w=800&q=80', 2, NOW(), NOW()),
(268, 'https://images.unsplash.com/photo-1575517111478-7f6afd0973db?w=800&q=80', 3, NOW(), NOW()),
(268, 'https://images.unsplash.com/photo-1551524559-8af4e6624178?w=800&q=80', 4, NOW(), NOW());

-- Romeo listing 269 - Cabane ocean Tofino
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(269, 'https://images.unsplash.com/photo-1505916349660-8d91a09afa5a?w=800&q=80', 0, NOW(), NOW()),
(269, 'https://images.unsplash.com/photo-1505843513577-22bb7d21e455?w=800&q=80', 1, NOW(), NOW()),
(269, 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&q=80', 2, NOW(), NOW()),
(269, 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=800&q=80', 3, NOW(), NOW()),
(269, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&q=80', 4, NOW(), NOW());

-- Romeo listing 270 - Chalet Canmore-Banff
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(270, 'https://images.unsplash.com/photo-1630699144867-37acec97df5a?w=800&q=80', 0, NOW(), NOW()),
(270, 'https://images.unsplash.com/photo-1600607687644-aac4c3eac7f4?w=800&q=80', 1, NOW(), NOW()),
(270, 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80', 2, NOW(), NOW()),
(270, 'https://images.unsplash.com/photo-1520984032042-162d526883e0?w=800&q=80', 3, NOW(), NOW()),
(270, 'https://images.unsplash.com/photo-1595521624992-48a59aef95e3?w=800&q=80', 4, NOW(), NOW());

-- Romeo listing 271 - Maison Gatineau
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(271, 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=800&q=80', 0, NOW(), NOW()),
(271, 'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?w=800&q=80', 1, NOW(), NOW()),
(271, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800&q=80', 2, NOW(), NOW()),
(271, 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80', 3, NOW(), NOW()),
(271, 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80', 4, NOW(), NOW());

-- Romeo listing 272 - Chalet Lac-Saint-Jean
INSERT INTO listing_photos (listing_id, path, `order`, created_at, updated_at) VALUES
(272, 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80', 0, NOW(), NOW()),
(272, 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80', 1, NOW(), NOW()),
(272, 'https://images.unsplash.com/photo-1499696010180-025ef6e1a8f9?w=800&q=80', 2, NOW(), NOW()),
(272, 'https://images.unsplash.com/photo-1618767689160-da3fb810aad7?w=800&q=80', 3, NOW(), NOW()),
(272, 'https://images.unsplash.com/photo-1596178065887-1198b6148b2b?w=800&q=80', 4, NOW(), NOW());

-- Update reservations to point to new listing IDs
UPDATE reservations SET listing_id = 253 WHERE listing_id NOT IN (SELECT id FROM listings);
