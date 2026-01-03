SET NAMES 'utf8mb4';
USE event_planner;

-- Clear existing data (order matters due to foreign key constraints)
DELETE FROM registrations;
DELETE FROM events;
DELETE FROM users;

-- Reset auto-increment counters
ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE events AUTO_INCREMENT = 1;

-- Employees (password is 'wachtwoord123' hashed with bcrypt)
INSERT INTO users (email, password, firstname, middle_name, lastname, role, phone, is_active) VALUES
('jan.devries@dorpsvereniging.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jan', 'de', 'Vries', 'employee', '06-12345678', TRUE),
('maria.bakker@dorpsvereniging.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Maria', NULL, 'Bakker', 'employee', '06-23456789', TRUE),
('pieter.jansen@dorpsvereniging.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pieter', NULL, 'Jansen', 'employee', '06-34567890', TRUE);

-- Members (password is 'lid12345' hashed with bcrypt)
INSERT INTO users (email, password, firstname, middle_name, lastname, role, membership_number, phone, is_active) VALUES
('sophie.mulder@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sophie', NULL, 'Mulder', 'member', 'LID-2024-001', '06-11111111', TRUE),
('thomas.visser@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Thomas', NULL, 'Visser', 'member', 'LID-2024-002', '06-22222222', TRUE),
('lisa.smit@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lisa', NULL, 'Smit', 'member', 'LID-2024-003', '06-33333333', TRUE),
('mark.dekker@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mark', 'van', 'Dekker', 'member', 'LID-2024-004', '06-44444444', TRUE),
('emma.bos@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emma', NULL, 'Bos', 'member', 'LID-2024-005', '06-55555555', TRUE),
('daan.peters@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Daan', NULL, 'Peters', 'member', 'LID-2024-006', '06-66666666', TRUE),
('fleur.hendriks@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Fleur', NULL, 'Hendriks', 'member', 'LID-2024-007', '06-77777777', TRUE),
('lucas.vandenBerg@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lucas', 'van den', 'Berg', 'member', 'LID-2024-008', '06-88888888', TRUE),
('julia.dejong@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Julia', 'de', 'Jong', 'member', 'LID-2024-009', '06-99999999', TRUE),
('sem.vandijk@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sem', 'van', 'Dijk', 'member', 'LID-2024-010', '06-10101010', TRUE),
('anna.vanLeeuwen@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Anna', 'van', 'Leeuwen', 'member', 'LID-2024-011', '06-11112222', TRUE),
('ruben.janssen@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ruben', NULL, 'Janssen', 'member', 'LID-2024-012', '06-12121212', TRUE),
('isa.vermeer@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Isa', NULL, 'Vermeer', 'member', 'LID-2024-013', '06-13131313', TRUE),
('bram.kuiper@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bram', NULL, 'Kuiper', 'member', 'LID-2024-014', '06-14141414', TRUE),
('lotte.vanderMeer@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lotte', 'van der', 'Meer', 'member', 'LID-2024-015', '06-15151515', TRUE),
('finn.dewit@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Finn', 'de', 'Wit', 'member', 'LID-2024-016', '06-16161616', TRUE),
('eva.koster@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Eva', NULL, 'Koster', 'member', 'LID-2024-017', '06-17171717', TRUE),
('jesse.vanderLinden@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jesse', 'van der', 'Linden', 'member', 'LID-2024-018', '06-18181818', TRUE),
('noa.vanVliet@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Noa', 'van', 'Vliet', 'member', 'LID-2024-019', '06-19191919', TRUE),
('max.molenaar@email.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Max', NULL, 'Molenaar', 'member', 'LID-2024-020', '06-20202020', TRUE);

-- Events by Jan de Vries (employee id 1)
-- Event 1: PAST (already happened)
INSERT INTO events (name, description, location, event_date, registration_deadline, price, max_participants, created_by) VALUES
('Oud & Nieuw Borrel 2025', 'Gezellige nieuwjaarsborrel voor alle leden. We klinken samen op het nieuwe jaar met een hapje en een drankje. Kinderen zijn ook welkom!', 'Dorpshuis De Eik', '2025-01-01 20:00:00', '2024-12-30 23:59:59', 15.00, 32, 1);

-- Event 2: UPCOMING but registration closed
INSERT INTO events (name, description, location, event_date, registration_deadline, price, max_participants, created_by) VALUES
('Workshop Paasstukjes Maken', 'Maak je eigen paasstuk onder begeleiding van bloemist Margriet. Alle materialen zijn inbegrepen. Neem je eigen snoeischaar mee!', 'Dorpshuis De Eik', '2026-01-15 14:00:00', '2026-01-01 23:59:59', 25.00, 16, 1);

-- Events by Maria Bakker (employee id 2)
-- Event 3: PAST
INSERT INTO events (name, description, location, event_date, registration_deadline, price, max_participants, created_by) VALUES
('Sinterklaasfeest voor Kinderen', 'De sint komt naar ons dorp! Inclusief entertainment, pepernoten en een cadeautje voor elk kind. Voor kinderen van 3-10 jaar.', 'Basisschool Het Kompas', '2024-12-05 14:00:00', '2024-11-28 23:59:59', 10.00, 24, 2);

-- Event 4: UPCOMING, registration open, almost full
INSERT INTO events (name, description, location, event_date, registration_deadline, price, max_participants, created_by) VALUES
('Pubquiz Avond', 'Test je kennis tijdens onze gezellige pubquiz! Teams van 4-6 personen. Mooie prijzen te winnen. Inclusief twee consumpties.', 'Café ''t Hoekje', '2026-02-14 20:00:00', '2026-02-10 23:59:59', 12.50, 8, 2);

-- Events by Pieter Jansen (employee id 3)
-- Event 5: UPCOMING, registration open, half full
INSERT INTO events (name, description, location, event_date, registration_deadline, price, max_participants, created_by) VALUES
('Voorjaarswandeling met Gids', 'Ontdek de natuur rondom ons dorp met natuurgids Henk. Leer over lokale flora en fauna. Ongeveer 8 km wandelen. Eigen vervoer naar startpunt.', 'Parkeerplaats Bos', '2026-03-22 10:00:00', '2026-03-18 23:59:59', 10.00, 16, 3);

-- Event 6: UPCOMING, registration open, uncapped
INSERT INTO events (name, description, location, event_date, registration_deadline, price, max_participants, created_by) VALUES
('Koningsdag Rommelmarkt', 'Verkoop je oude spullen of kom snuffelen tussen de kraampjes! Standplaats reserveren kost €10, bezoeken is gratis. Muziek en kinderactiviteiten aanwezig.', 'Dorpsplein', '2026-04-27 09:00:00', '2026-04-20 23:59:59', 10.00, NULL, 3);

-- Registrations
-- Event 1 (Oud & Nieuw, max 32) - PAST, was full with 32 registrations
INSERT INTO registrations (user_id, event_id) VALUES
(4, 1), (5, 1), (6, 1), (7, 1), (8, 1), (9, 1), (10, 1), (11, 1),
(12, 1), (13, 1), (14, 1), (15, 1), (16, 1), (17, 1), (18, 1), (19, 1);

-- Event 2 (Workshop Paasstukjes, max 16) - registration closed, full
INSERT INTO registrations (user_id, event_id) VALUES
(4, 2), (5, 2), (6, 2), (7, 2), (8, 2), (9, 2), (10, 2), (11, 2),
(12, 2), (13, 2), (14, 2), (15, 2), (16, 2), (17, 2), (18, 2), (19, 2);

-- Event 3 (Sinterklaas, max 24) - PAST, was almost full with 22
INSERT INTO registrations (user_id, event_id) VALUES
(4, 3), (5, 3), (6, 3), (7, 3), (8, 3), (9, 3), (10, 3), (11, 3),
(12, 3), (13, 3), (14, 3), (15, 3), (16, 3), (17, 3), (18, 3), (19, 3),
(20, 3), (21, 3), (22, 3), (23, 3);

-- Event 4 (Pubquiz, max 8) - almost full with 7
INSERT INTO registrations (user_id, event_id) VALUES
(4, 4), (5, 4), (6, 4), (7, 4), (8, 4), (9, 4), (10, 4);

-- Event 5 (Voorjaarswandeling, max 16) - half full with 8
INSERT INTO registrations (user_id, event_id) VALUES
(11, 5), (12, 5), (13, 5), (14, 5), (15, 5), (16, 5), (17, 5), (18, 5);

-- Event 6 (Koningsdag, uncapped) - about 12 registrations
INSERT INTO registrations (user_id, event_id) VALUES
(4, 6), (6, 6), (8, 6), (10, 6), (12, 6), (14, 6), (16, 6), (18, 6),
(20, 6), (21, 6), (22, 6), (23, 6);
