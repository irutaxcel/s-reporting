-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 24 sep. 2026 à 09:27
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sreporting`
--

-- --------------------------------------------------------

--
-- Structure de la table `tbl_chantiers`
--

CREATE TABLE `tbl_chantiers` (
  `id` int(11) NOT NULL,
  `projet_id` int(11) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `location` varchar(191) DEFAULT NULL,
  `chef_chantier` varchar(191) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin_prevue` date DEFAULT NULL,
  `status` varchar(80) DEFAULT 'Planifié',
  `created_at` datetime DEFAULT current_timestamp(),
  `avancement` decimal(5,2) DEFAULT 0.00,
  `budget` decimal(15,2) DEFAULT 0.00,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_chantiers`
--

INSERT INTO `tbl_chantiers` (`id`, `projet_id`, `name`, `location`, `chef_chantier`, `date_debut`, `date_fin_prevue`, `status`, `created_at`, `avancement`, `budget`, `deleted_at`) VALUES
(1, 42, 'TABA-GIHOSHA(ETUDE)', 'Gasenyi', 'Undefinied', NULL, NULL, 'Planifié', '2026-09-21 10:35:00', 0.00, 0.00, NULL),
(2, 42, 'IBB entrepots', 'Kajaga', 'Remis', '2026-08-31', '2026-09-10', 'En cours', '2026-09-21 10:36:33', 30.00, 200000000.00, NULL),
(3, 42, 'Construction Terrain Basketball', 'Gasenyi', 'Emmanuel SAVYIMANA', NULL, NULL, 'Planifié', '2026-09-21 10:39:17', 0.00, 0.00, NULL),
(4, 1, 'Bâtiment Principal', 'Bujumbura - Centre Ville', 'Jean Pierre NKURUNZIZA', '2026-05-01', '2027-05-01', 'En cours', '2026-09-21 10:57:41', 50.00, 5000000.00, NULL),
(5, 1, 'Parking Souterrain', 'Bujumbura - Centre Ville', 'Emmanuel NDAYIZEYE', '2026-06-15', '2026-12-15', 'En cours', '2026-09-21 10:57:41', 70.00, 2000000.00, NULL),
(6, 2, 'Construction Villa', 'Gitega - Quartier Résidentiel', 'Patrick MUGISHA', '2026-04-20', '2026-10-20', 'En cours', '2026-09-21 10:57:41', 100.00, 8000000.00, NULL),
(7, 3, 'Rooftop Bancaire', 'Bujumbura - CBD', 'Michel NDAYISENGA', '2026-05-10', '2026-11-10', 'En cours', '2026-09-21 10:57:41', 55.00, 3500000.00, NULL),
(8, 4, 'Rénovation Bâtiment A', 'Bujumbura - OUA', 'François NIMUBONA', '2026-04-25', '2026-09-25', 'En cours', '2026-09-21 10:57:41', 70.00, 4000000.00, NULL),
(9, 4, 'Rénovation Bâtiment B', 'Bujumbura - OUA', 'Charles MURWANASHYAKA', '2026-06-01', '2026-10-01', 'Planifié', '2026-09-21 10:57:41', 15.00, 3500000.00, NULL),
(10, 5, 'Construction Résidentielle', 'Bujumbura - Kinanira', 'Emmanuel SAVYIMANA', '2026-05-15', '2027-02-15', 'En cours', '2026-09-21 10:57:41', 40.00, 12000000.00, NULL),
(11, 7, 'Villa Moderne', 'Bujumbura - Gihosha', 'Remis NDAYIZEYE', '2026-05-20', '2026-12-20', 'En cours', '2026-09-21 10:57:41', 50.00, 15000000.00, NULL),
(12, 8, 'Salle du Royaume', 'Bujumbura - Rohero', 'Jean Bosco NDAYIZEYE', '2026-06-01', '2027-01-01', 'En cours', '2026-09-21 10:57:41', 35.00, 6000000.00, NULL),
(13, 9, 'Construction Commerciale', 'Kabezi - Centre', 'Patrick NDAYISENGA', '2026-05-05', '2026-11-05', 'En cours', '2026-09-21 10:57:41', 45.00, 7000000.00, NULL),
(14, 10, 'Bâtiment Scolaire', 'Bujumbura - Kinama', 'Michel NDAYIZEYE', '2026-04-15', '2026-10-15', 'En cours', '2026-09-21 10:57:41', 65.00, 9000000.00, NULL),
(15, 10, 'Terrain de Sport', 'Bujumbura - Kinama', 'François NKURUNZIZA', '2026-07-01', '2026-09-01', 'Planifié', '2026-09-21 10:57:41', 20.00, 2500000.00, NULL),
(16, 11, 'Complexe Commercial', 'Bujumbura - Gihosha', 'Charles MUGISHA', '2026-06-10', '2027-03-10', 'En cours', '2026-09-21 10:57:41', 38.00, 18000000.00, NULL),
(17, 12, 'Immeuble Résidentiel', 'Bujumbura - Gihosha', 'Emmanuel NDAYIZEYE', '2026-05-25', '2027-02-25', 'En cours', '2026-09-21 10:57:41', 42.00, 16000000.00, NULL),
(18, 13, 'Appartements Standing', 'Bujumbura - Nyakabiga', 'Jean Pierre NDAYISENGA', '2026-06-05', '2027-04-05', 'En cours', '2026-09-21 10:57:41', 35.00, 20000000.00, NULL),
(19, 14, 'Villa Familiale', 'Bujumbura - Muha', 'Patrick MURWANASHYAKA', '2026-05-30', '2026-12-30', 'En cours', '2026-09-21 10:57:41', 48.00, 11000000.00, NULL),
(20, 15, 'Construction Moderne', 'Bujumbura - Kamenge', 'Remis NDAYIZEYE', '2026-06-15', '2027-01-15', 'En cours', '2026-09-21 10:57:41', 32.00, 9500000.00, NULL),
(21, 16, 'Villa de Luxe', 'Bujumbura - Muzinda', 'Michel NKURUNZIZA', '2026-07-01', '2027-02-01', 'Planifié', '2026-09-21 10:57:41', 10.00, 14000000.00, NULL),
(22, 17, 'Complexe Immobilier', 'Bujumbura - Centre', 'François NDAYISENGA', '2026-06-20', '2027-03-20', 'En cours', '2026-09-21 10:57:41', 40.00, 22000000.00, NULL),
(23, 18, 'Clinique Privée', 'Bujumbura - Nyabugete', 'Jean Bosco MUGISHA', '2026-05-10', '2027-01-10', 'En cours', '2026-09-21 10:57:41', 52.00, 25000000.00, NULL),
(24, 19, 'Résidence Privée', 'Bujumbura - Gakungwe', 'Charles NDAYIZEYE', '2026-06-25', '2027-02-25', 'En cours', '2026-09-21 10:57:41', 28.00, 8000000.00, NULL),
(25, 20, 'Centre Religieux', 'Bujumbura - Jabe', 'Emmanuel NDAYISENGA', '2026-05-15', '2026-12-15', 'En cours', '2026-09-21 10:57:41', 55.00, 7500000.00, NULL),
(26, 21, 'Construction Rurale', 'Gatoke - Centre', 'Patrick NKURUNZIZA', '2026-06-01', '2027-01-01', 'En cours', '2026-09-21 10:57:41', 38.00, 6500000.00, NULL),
(27, 22, 'Immeuble Moderne', 'Bujumbura - Kinindo', 'Remis MURWANASHYAKA', '2026-06-10', '2027-03-10', 'En cours', '2026-09-21 10:57:41', 44.00, 17000000.00, NULL),
(28, 23, 'Villa Contemporaine', 'Bujumbura - Gihosha', 'Michel NDAYIZEYE', '2026-07-05', '2027-02-05', 'Planifié', '2026-09-21 10:57:41', 18.00, 13000000.00, NULL),
(29, 24, 'Résidence Familiale', 'Bujumbura - Kinanira', 'François NDAYISENGA', '2026-06-15', '2027-01-15', 'En cours', '2026-09-21 10:57:41', 36.00, 10000000.00, NULL),
(30, 25, 'Aménagement Bureau', 'Bujumbura - CBD', 'Jean Pierre MUGISHA', '2026-05-20', '2026-09-20', 'En cours', '2026-09-21 10:57:41', 75.00, 3000000.00, NULL),
(31, 26, 'Construction Commerciale', 'Bujumbura - Centre', 'Patrick NDAYIZEYE', '2026-06-05', '2026-12-05', 'En cours', '2026-09-21 10:57:41', 42.00, 8500000.00, NULL),
(32, 27, 'Palais Présidentiel', 'Gisenyi - Centre', 'Emmanuel NKURUNZIZA', '2026-05-01', '2028-05-01', 'En cours', '2026-09-21 10:57:41', 58.00, 50000000.00, NULL),
(33, 27, 'Jardins Présidentiels', 'Gisenyi - Centre', 'Remis NDAYISENGA', '2026-07-01', '2027-07-01', 'Planifié', '2026-09-21 10:57:41', 25.00, 15000000.00, NULL),
(34, 28, 'Usine de Production', 'Bujumbura - Zone Industrielle', 'Charles MUGISHA', '2026-06-01', '2027-06-01', 'En cours', '2026-09-21 10:57:41', 48.00, 30000000.00, NULL),
(35, 29, 'Unité de Production', 'Maramvya - Zone Industrielle', 'Michel NDAYIZEYE', '2026-05-15', '2027-02-15', 'En cours', '2026-09-21 10:57:41', 52.00, 12000000.00, NULL),
(36, 30, 'Fabrique de Ciment', 'Bujumbura - Zone Industrielle', 'François NKURUNZIZA', '2026-06-10', '2027-03-10', 'En cours', '2026-09-21 10:57:41', 45.00, 25000000.00, NULL),
(37, 31, 'Bureau de Consultance', 'Bujumbura - CBD', 'Jean Bosco NDAYIZEYE', '2026-05-25', '2026-11-25', 'En cours', '2026-09-21 10:57:41', 60.00, 4500000.00, NULL),
(38, 33, 'Complexe Résidentiel', 'Bujumbura - Nyakabiga', 'Patrick MURWANASHYAKA', '2026-07-15', '2027-07-15', 'Planifié', '2026-09-21 10:57:41', 12.00, 28000000.00, NULL),
(39, 34, 'Extension Clinique', 'Bujumbura - Cibitoke', 'Emmanuel NDAYIZEYE', '2026-06-20', '2027-02-20', 'En cours', '2026-09-21 10:57:41', 40.00, 18000000.00, NULL),
(40, 35, 'Centre Social', 'Bujumbura - Centre', 'Remis NKURUNZIZA', '2026-05-30', '2026-12-30', 'En cours', '2026-09-21 10:57:41', 50.00, 6000000.00, NULL),
(41, 36, 'Entrepôt Industriel', 'Bujumbura - Zone Industrielle', 'Michel MUGISHA', '2026-06-05', '2027-01-05', 'En cours', '2026-09-21 10:57:41', 46.00, 20000000.00, NULL),
(42, 36, 'Parking Industriel', 'Bujumbura - Zone Industrielle', 'Charles NDAYISENGA', '2026-07-10', '2026-10-10', 'Planifié', '2026-09-21 10:57:41', 22.00, 3500000.00, NULL),
(43, 37, 'Campus Universitaire', 'Bujumbura - Kivoga', 'François NDAYIZEYE', '2026-05-01', '2028-05-01', 'En cours', '2026-09-21 10:57:41', 55.00, 45000000.00, NULL),
(44, 37, 'Bibliothèque', 'Bujumbura - Kivoga', 'Jean Pierre NKURUNZIZA', '2026-08-01', '2027-08-01', 'Planifié', '2026-09-21 10:57:41', 15.00, 12000000.00, NULL),
(45, 37, 'Résidence Étudiante', 'Bujumbura - Kivoga', 'Patrick NDAYISENGA', '2026-07-15', '2027-07-15', 'Planifié', '2026-09-21 10:57:41', 20.00, 15000000.00, NULL),
(46, 38, 'Villa Résidentielle', 'Bujumbura - Kiriri', 'Emmanuel MURWANASHYAKA', '2026-06-12', '2027-01-12', 'En cours', '2026-09-21 10:57:41', 42.00, 11000000.00, NULL),
(47, 39, 'Immeuble Commercial', 'Bujumbura - Rohero', 'Remis NDAYIZEYE', '2026-07-01', '2027-02-01', 'Planifié', '2026-09-21 10:57:41', 18.00, 16000000.00, NULL),
(48, 40, 'Centre Commercial', 'Dar es Salaam', 'Michel NKURUNZIZA', '2026-06-15', '2027-06-15', 'Planifié', '2026-09-21 10:57:41', 25.00, 35000000.00, NULL),
(49, 41, 'Complexe Immobilier', 'Nairobi', 'François MUGISHA', '2026-07-05', '2027-07-05', 'Planifié', '2026-09-21 10:57:41', 20.00, 40000000.00, NULL),
(53, 43, 'Usine Centrale', 'Bujumbura - Zone Industrielle', 'Jean Bosco NKURUNZIZA', '2026-07-10', '2027-04-10', 'Planifié', '2026-09-21 10:57:41', 15.00, 35000000.00, NULL),
(54, 45, 'Pavage Industriel', 'Bujumbura - Zone Industrielle', 'Patrick NDAYIZEYE', '2026-09-20', '2026-12-20', 'Planifié', '2026-09-21 10:57:41', 5.00, 8000000.00, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_clients`
--

CREATE TABLE `tbl_clients` (
  `id` int(11) NOT NULL,
  `type_client` varchar(20) NOT NULL COMMENT 'entreprise, particulier, public',
  `categorie` char(1) DEFAULT 'C' COMMENT 'A, B, C',
  `raison_sociale` varchar(255) NOT NULL,
  `nom_commercial` varchar(255) DEFAULT NULL,
  `projet_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` text DEFAULT NULL,
  `ville` varchar(100) NOT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `pays` varchar(50) DEFAULT 'Algérie',
  `rc` varchar(50) DEFAULT NULL,
  `nif` varchar(20) DEFAULT NULL,
  `ais` varchar(20) DEFAULT NULL,
  `statut` varchar(20) DEFAULT 'prospect' COMMENT 'prospect, actif, inactif',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tbl_clients`
--

INSERT INTO `tbl_clients` (`id`, `type_client`, `categorie`, `raison_sociale`, `nom_commercial`, `projet_id`, `email`, `telephone`, `adresse`, `ville`, `code_postal`, `pays`, `rc`, `nif`, `ais`, `statut`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'entreprise', 'A', 'BRARUDI', 'Brarudi', 36, 'contact@brarudi.bi', '+257 22 30 01 01', 'Zone Industrielle, Bujumbura', 'Bujumbura', '0000', 'Burundi', 'RC-BRB-001', 'NIF-BRB-001', '', 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:52:47', NULL),
(2, 'entreprise', 'A', 'INTERBANK Burundi', 'Interbank', 1, 'info@interbank.bi', '+257 22 25 12 34', 'Avenue du Commerce, Bujumbura', 'Bujumbura', '0000', 'Burundi', 'RC-INT-001', 'NIF-INT-001', NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:46:43', NULL),
(3, 'entreprise', 'B', 'BANCOBU', 'Bancobu', 3, 'contact@bancobu.bi', '+257 22 26 45 67', 'Boulevard Lumumba, Bujumbura', 'Bujumbura', '0000', 'Burundi', 'RC-BNC-001', 'NIF-BNC-001', NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:52:08', NULL),
(4, 'entreprise', 'B', 'KING\'S SCHOOL', 'King\'s School', 10, 'admin@kingsschool.bi', '+257 22 27 89 01', 'Quartier Kinama, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:47:11', NULL),
(5, 'entreprise', 'C', 'TEMOINS DE JEHOVAH', 'TDJ Burundi', 8, 'contact@tdj.bi', '+257 22 28 12 34', 'Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:51:00', NULL),
(6, 'public', 'A', 'Présidence de la République - GASENYI', 'Présidence', 27, 'contact@presidence.bi', '+257 22 20 00 01', 'Palais de la Présidence, Gisenyi', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:51:28', NULL),
(7, 'entreprise', 'B', 'KIVOGA UNIVERSITY', 'Kivoga University', 37, 'info@kivoga.ac.bi', '+257 22 29 34 56', 'Campus Kivoga', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:50:14', NULL),
(8, 'entreprise', 'B', 'CLINIQUE UBUNTU - CIBITOKE', 'Clinique Ubuntu', 34, 'contact@ubuntu-clinic.bi', '+257 22 31 45 67', 'Quartier Cibitoke, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:49:48', NULL),
(9, 'entreprise', 'B', 'CENTRALE A BETON', 'CAB', 43, 'info@centralebeton.bi', '+257 22 32 56 78', 'Zone Industrielle, Bujumbura', 'Bujumbura', '0000', 'Burundi', 'RC-CAB-001', NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:53:18', NULL),
(10, 'entreprise', 'C', 'PRODUCTION AGGLOMERE', 'PA', 28, 'contact@agglo.bi', '+257 22 33 67 89', 'Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:53:39', NULL),
(11, 'entreprise', 'C', 'Maramvya Brique Cute', 'MBC', 29, 'contact@maramvya.bi', '+257 22 34 78 90', 'Maramvya', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:53:59', NULL),
(12, 'entreprise', 'C', 'Bloque Ciment', 'BC', 30, 'info@bloqueciment.bi', '+257 22 35 89 01', 'Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:54:32', NULL),
(13, 'entreprise', 'B', 'EDEN GARDEN', 'Eden Garden', 33, 'contact@edengarden.bi', '+257 22 36 90 12', 'Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:55:02', NULL),
(14, 'entreprise', 'C', 'JABE SDA', 'Jabe SDA', 20, 'contact@jabesda.bi', '+257 22 37 01 23', 'Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:55:47', NULL),
(15, 'entreprise', 'A', 'TANZANIE', 'Tanzania Project', 40, 'info@tanzania-project.tz', '+255 22 123 4567', 'Dar es Salaam', 'Dar es Salaam', '0000', 'Tanzanie', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:56:08', NULL),
(16, 'entreprise', 'A', 'KENYA', 'Kenya Project', 41, 'info@kenya-project.ke', '+254 20 123 4567', 'Nairobi', 'Nairobi', '0000', 'Kenya', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:56:24', NULL),
(17, 'particulier', 'B', 'Dr. Eric NYABUGETE', 'Nyabugete Eric', 18, 'eric.nyabugete@gmail.com', '+257 79 123 456', 'Quartier Nyabugete, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:56:48', NULL),
(18, 'particulier', 'C', 'KIRIRI SAMUEL', 'Samuel Kiriri', 38, 'samuel.kiriri@gmail.com', '+257 79 234 567', 'Quartier Kiriri, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:57:10', NULL),
(19, 'particulier', 'C', 'ROHERO CEDRIC', 'Cedric Rohero', 39, 'cedric.rohero@gmail.com', '+257 79 345 678', 'Quartier Rohero, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:57:30', NULL),
(20, 'particulier', 'C', 'ELIANE KINANIRA', 'Eliane Kinanira', 5, 'eliane.kinanira@gmail.com', '+257 79 456 789', 'Quartier Kinanira, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:58:01', NULL),
(21, 'particulier', 'C', 'MPUNDU GIHOSHA', 'Mpundu Gihosha', 7, 'mpundu.gihosha@gmail.com', '+257 79 567 890', 'Quartier Gihosha, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:58:41', NULL),
(22, 'particulier', 'C', 'KABEZI', 'Kabezi', 9, 'kabezi@gmail.com', '+257 79 678 901', 'Kabezi, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:59:02', NULL),
(23, 'particulier', 'C', 'MUHA', 'Muha', 14, 'muha@gmail.com', '+257 79 789 012', 'Quartier Muha, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:59:17', NULL),
(24, 'particulier', 'C', 'KAZOZA KAMENGE', 'Kazoza Kamenge', 15, 'kazoza.kamenge@gmail.com', '+257 79 890 123', 'Quartier Kamenge, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:59:39', NULL),
(25, 'particulier', 'C', 'MUZINDA', 'Muzinda', 16, 'muzinda@gmail.com', '+257 79 901 234', 'Muzinda, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 12:59:54', NULL),
(26, 'particulier', 'C', 'GAKUNGWE', 'Gakungwe', 19, 'gakungwe@gmail.com', '+257 79 012 345', 'Gakungwe, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:00:28', NULL),
(27, 'particulier', 'C', 'GATOKE', 'Gatoke', 21, 'gatoke@gmail.com', '+257 79 123 450', 'Gatoke, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:00:42', NULL),
(28, 'particulier', 'C', 'NDAYI GIHOSHA', 'Ndayi Gihosha', 23, 'ndayi.gihosha@gmail.com', '+257 79 234 560', 'Quartier Gihosha, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:01:19', NULL),
(29, 'particulier', 'C', 'KINANIRA 3', 'Kinanira 3', 24, 'kinanira3@gmail.com', '+257 79 345 670', 'Quartier Kinanira, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:01:36', NULL),
(30, 'particulier', 'C', 'MRROIDR', 'Mr Roidr', 26, 'mrroidr@gmail.com', '+257 79 456 780', 'Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:02:08', NULL),
(31, 'particulier', 'C', 'TABA-GIHOSHA', 'Taba Gihosha', 42, 'taba.gihosha@gmail.com', '+257 79 567 890', 'Quartier Gihosha, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:02:48', NULL),
(32, 'entreprise', 'B', 'Consultance', 'Consultance Services', 31, 'info@consultance.bi', '+257 22 38 12 34', 'Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:03:23', NULL),
(33, 'public', 'B', 'Contribution sociale', 'CS', 35, 'contact@contribution-sociale.bi', '+257 22 39 23 45', 'Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:03:46', NULL),
(34, 'entreprise', 'B', 'OUA', 'OUA', 4, 'contact@oua.bi', '+257 22 40 34 56', 'Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:04:11', NULL),
(35, 'particulier', 'C', 'ZONE GIHOSHA', 'Gihosha Zone', 11, 'gihosha.zone@gmail.com', '+257 79 678 900', 'Quartier Gihosha, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:06:05', NULL),
(36, 'particulier', 'C', 'LARGE APPARTEMENT', 'Large Appart', 17, 'large.appart@gmail.com', '+257 79 789 010', 'Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:06:25', NULL),
(37, 'particulier', 'C', 'KININDO APPARTEMENT', 'Kinindo Appart', 22, 'kinindo.appart@gmail.com', '+257 79 890 120', 'Quartier Kinindo, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:06:44', NULL),
(38, 'particulier', 'C', 'GIHOSHA APPARTEMENT', 'Gihosha Appart', 12, 'gihosha.appart@gmail.com', '+257 79 901 230', 'Quartier Gihosha, Bujumbura', 'Bujumbura', '0000', 'Burundi', NULL, NULL, NULL, 'actif', 22, '2026-09-15 11:38:56', '2026-09-20 13:07:03', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_client_projet`
--

CREATE TABLE `tbl_client_projet` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `projet_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tbl_client_projet`
--

INSERT INTO `tbl_client_projet` (`id`, `client_id`, `projet_id`, `created_at`) VALUES
(1, 1, 36, '2026-09-15 11:38:56'),
(2, 2, 1, '2026-09-15 11:38:56'),
(3, 3, 3, '2026-09-15 11:38:56'),
(4, 4, 10, '2026-09-15 11:38:56'),
(5, 5, 8, '2026-09-15 11:38:56'),
(6, 6, 27, '2026-09-15 11:38:56'),
(7, 7, 37, '2026-09-15 11:38:56'),
(8, 8, 34, '2026-09-15 11:38:56'),
(9, 9, 43, '2026-09-15 11:38:56'),
(10, 10, 28, '2026-09-15 11:38:56'),
(11, 11, 29, '2026-09-15 11:38:56'),
(12, 12, 30, '2026-09-15 11:38:56'),
(13, 13, 33, '2026-09-15 11:38:56'),
(14, 14, 20, '2026-09-15 11:38:56'),
(15, 15, 40, '2026-09-15 11:38:56'),
(16, 16, 41, '2026-09-15 11:38:56'),
(17, 17, 18, '2026-09-15 11:38:56'),
(18, 18, 38, '2026-09-15 11:38:56'),
(19, 19, 39, '2026-09-15 11:38:56'),
(20, 20, 5, '2026-09-15 11:38:56'),
(21, 21, 7, '2026-09-15 11:38:56'),
(22, 22, 9, '2026-09-15 11:38:56'),
(23, 23, 14, '2026-09-15 11:38:56'),
(24, 24, 15, '2026-09-15 11:38:56'),
(25, 25, 16, '2026-09-15 11:38:56'),
(26, 26, 19, '2026-09-15 11:38:56'),
(27, 27, 21, '2026-09-15 11:38:56'),
(28, 28, 23, '2026-09-15 11:38:56'),
(29, 29, 24, '2026-09-15 11:38:56'),
(30, 30, 26, '2026-09-15 11:38:56'),
(31, 31, 42, '2026-09-15 11:38:56'),
(32, 32, 31, '2026-09-15 11:38:56'),
(33, 33, 35, '2026-09-15 11:38:56'),
(34, 34, 4, '2026-09-15 11:38:56'),
(35, 35, 11, '2026-09-15 11:38:56'),
(36, 36, 17, '2026-09-15 11:38:56'),
(37, 37, 22, '2026-09-15 11:38:56'),
(38, 38, 12, '2026-09-15 11:38:56');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_contrat_tranches`
--

CREATE TABLE `tbl_contrat_tranches` (
  `id` int(11) NOT NULL,
  `contrat_id` int(11) NOT NULL,
  `numero_tranche` int(11) NOT NULL,
  `pourcentage` decimal(5,2) NOT NULL,
  `avancement_requis` decimal(5,2) DEFAULT NULL,
  `condition_paiement` varchar(50) DEFAULT NULL,
  `montant` decimal(15,2) NOT NULL,
  `date_paiement` date DEFAULT NULL,
  `statut` enum('en_attente','paye','retard') DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_contrat_tranches`
--

INSERT INTO `tbl_contrat_tranches` (`id`, `contrat_id`, `numero_tranche`, `pourcentage`, `avancement_requis`, `condition_paiement`, `montant`, `date_paiement`, `statut`) VALUES
(1, 32, 1, 30.00, 30.00, 'avancement', 150000000.00, NULL, 'en_attente'),
(2, 32, 2, 30.00, 60.00, 'avancement', 150000000.00, NULL, 'en_attente'),
(3, 32, 3, 30.00, 90.00, 'avancement', 150000000.00, NULL, 'en_attente'),
(4, 32, 4, 8.00, 100.00, 'reception_provisoire', 40000000.00, NULL, 'en_attente'),
(5, 32, 5, 2.00, 100.00, 'reception_definitive', 10000000.00, NULL, 'en_attente');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_devis`
--

CREATE TABLE `tbl_devis` (
  `id` int(11) NOT NULL,
  `projet_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `montant` decimal(15,2) NOT NULL DEFAULT 0.00,
  `date_creation` date NOT NULL,
  `date_signature` date DEFAULT NULL,
  `date_expiration` date NOT NULL,
  `statut` enum('en_attente','signe','expire','annule') DEFAULT 'en_attente',
  `fichier_devis` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tbl_devis`
--

INSERT INTO `tbl_devis` (`id`, `projet_id`, `chantier_id`, `reference`, `montant`, `date_creation`, `date_signature`, `date_expiration`, `statut`, `fichier_devis`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 40, 48, 'PRJ-2026-00031', 222.00, '2026-09-21', '2026-09-25', '2026-10-03', 'signe', 'uploads/devis/devis_1789994746_6ab126fa25810.pdf', 'asasa', '2026-09-21 14:45:46', '2026-09-21 14:45:46', NULL),
(2, 42, 1, 'DEV-2026-001', 2500000.00, '2026-09-01', '2026-09-10', '2026-12-01', 'signe', 'uploads/devis/dev_001.pdf', 'Devis pour TABA-GIHOSHA', '2026-09-01 10:00:00', '2026-09-21 15:21:22', NULL),
(3, 42, 2, 'DEV-2026-002', 3500000.00, '2026-09-02', '2026-09-12', '2026-12-02', 'signe', 'uploads/devis/dev_002.pdf', 'Devis pour IBB entrepots', '2026-09-02 10:00:00', '2026-09-21 15:21:22', NULL),
(4, 42, 3, 'DEV-2026-003', 1800000.00, '2026-09-03', NULL, '2026-12-03', 'en_attente', 'uploads/devis/dev_003.pdf', 'Devis pour Terrain Basketball', '2026-09-03 10:00:00', '2026-09-21 15:21:22', NULL),
(5, 1, 4, 'DEV-2026-004', 6000000.00, '2026-09-04', '2026-09-15', '2026-12-04', 'signe', 'uploads/devis/dev_004.pdf', 'Devis Bâtiment Principal', '2026-09-04 10:00:00', '2026-09-21 15:21:22', NULL),
(6, 1, 5, 'DEV-2026-005', 2000000.00, '2026-09-05', '2026-09-16', '2026-12-05', 'signe', 'uploads/devis/dev_005.pdf', 'Devis Parking Souterrain', '2026-09-05 10:00:00', '2026-09-21 15:21:22', NULL),
(7, 2, 6, 'DEV-2026-006', 8000000.00, '2026-09-06', '2026-09-18', '2026-12-06', 'signe', 'uploads/devis/dev_006.pdf', 'Devis Construction Villa', '2026-09-06 10:00:00', '2026-09-21 15:21:22', NULL),
(8, 3, 7, 'DEV-2026-007', 3500000.00, '2026-09-07', NULL, '2026-12-07', 'en_attente', 'uploads/devis/dev_007.pdf', 'Devis Rooftop Bancaire', '2026-09-07 10:00:00', '2026-09-21 15:21:22', NULL),
(9, 4, 8, 'DEV-2026-008', 4000000.00, '2026-09-08', '2026-09-20', '2026-12-08', 'signe', 'uploads/devis/dev_008.pdf', 'Devis Rénovation Bâtiment A', '2026-09-08 10:00:00', '2026-09-21 15:21:22', NULL),
(10, 4, 9, 'DEV-2026-009', 3500000.00, '2026-09-09', NULL, '2026-12-09', 'en_attente', 'uploads/devis/dev_009.pdf', 'Devis Rénovation Bâtiment B', '2026-09-09 10:00:00', '2026-09-21 15:21:22', NULL),
(11, 5, 10, 'DEV-2026-010', 12000000.00, '2026-09-10', '2026-09-22', '2026-12-10', 'signe', 'uploads/devis/dev_010.pdf', 'Devis Construction Résidentielle', '2026-09-10 10:00:00', '2026-09-21 15:21:22', NULL),
(12, 7, 11, 'DEV-2026-011', 15000000.00, '2026-09-11', '2026-09-23', '2026-12-11', 'signe', 'uploads/devis/dev_011.pdf', 'Devis Villa Moderne', '2026-09-11 10:00:00', '2026-09-21 15:21:22', NULL),
(13, 8, 12, 'DEV-2026-012', 6000000.00, '2026-09-12', NULL, '2026-12-12', 'en_attente', 'uploads/devis/dev_012.pdf', 'Devis Salle du Royaume', '2026-09-12 10:00:00', '2026-09-21 15:21:22', NULL),
(14, 9, 13, 'DEV-2026-013', 7000000.00, '2026-09-13', '2026-09-25', '2026-12-13', 'signe', 'uploads/devis/dev_013.pdf', 'Devis Construction Commerciale', '2026-09-13 10:00:00', '2026-09-21 15:21:22', NULL),
(15, 10, 14, 'DEV-2026-014', 9000000.00, '2026-09-14', '2026-09-26', '2026-12-14', 'signe', 'uploads/devis/dev_014.pdf', 'Devis Bâtiment Scolaire', '2026-09-14 10:00:00', '2026-09-21 15:21:22', NULL),
(16, 10, 15, 'DEV-2026-015', 2500000.00, '2026-09-15', NULL, '2026-12-15', 'en_attente', 'uploads/devis/dev_015.pdf', 'Devis Terrain de Sport', '2026-09-15 10:00:00', '2026-09-21 15:21:22', NULL),
(17, 11, 16, 'DEV-2026-016', 18000000.00, '2026-09-16', '2026-09-28', '2026-12-16', 'signe', 'uploads/devis/dev_016.pdf', 'Devis Complexe Commercial', '2026-09-16 10:00:00', '2026-09-21 15:21:22', NULL),
(18, 12, 17, 'DEV-2026-017', 16000000.00, '2026-09-17', NULL, '2026-12-17', 'en_attente', 'uploads/devis/dev_017.pdf', 'Devis Immeuble Résidentiel', '2026-09-17 10:00:00', '2026-09-21 15:21:22', NULL),
(19, 13, 18, 'DEV-2026-018', 20000000.00, '2026-09-18', '2026-09-30', '2026-12-18', 'signe', 'uploads/devis/dev_018.pdf', 'Devis Appartements Standing', '2026-09-18 10:00:00', '2026-09-21 15:21:22', NULL),
(20, 14, 19, 'DEV-2026-019', 11000000.00, '2026-09-19', NULL, '2026-12-19', 'expire', 'uploads/devis/dev_019.pdf', 'Devis Villa Familiale', '2026-09-19 10:00:00', '2026-09-21 15:21:22', NULL),
(21, 15, 20, 'DEV-2026-020', 9500000.00, '2026-09-20', '2026-10-02', '2026-12-20', 'signe', 'uploads/devis/dev_020.pdf', 'Devis Construction Moderne', '2026-09-20 10:00:00', '2026-09-21 15:21:22', NULL),
(22, 16, 21, 'DEV-2026-021', 14000000.00, '2026-09-21', NULL, '2026-12-21', 'en_attente', 'uploads/devis/dev_021.pdf', 'Devis Villa de Luxe', '2026-09-21 10:00:00', '2026-09-21 15:21:22', NULL),
(23, 17, 22, 'DEV-2026-022', 22000000.00, '2026-09-22', '2026-10-04', '2026-12-22', 'signe', 'uploads/devis/dev_022.pdf', 'Devis Complexe Immobilier', '2026-09-22 10:00:00', '2026-09-21 15:21:22', NULL),
(24, 18, 23, 'DEV-2026-023', 25000000.00, '2026-09-23', '2026-10-05', '2026-12-23', 'signe', 'uploads/devis/dev_023.pdf', 'Devis Clinique Privée', '2026-09-23 10:00:00', '2026-09-21 15:21:22', NULL),
(25, 19, 24, 'DEV-2026-024', 8000000.00, '2026-09-24', NULL, '2026-12-24', 'en_attente', 'uploads/devis/dev_024.pdf', 'Devis Résidence Privée', '2026-09-24 10:00:00', '2026-09-21 15:21:22', NULL),
(26, 20, 25, 'DEV-2026-025', 7500000.00, '2026-09-25', '2026-10-07', '2026-12-25', 'signe', 'uploads/devis/dev_025.pdf', 'Devis Centre Religieux', '2026-09-25 10:00:00', '2026-09-21 15:21:22', NULL),
(27, 21, 26, 'DEV-2026-026', 6500000.00, '2026-09-26', NULL, '2026-12-26', 'expire', 'uploads/devis/dev_026.pdf', 'Devis Construction Rurale', '2026-09-26 10:00:00', '2026-09-21 15:21:22', NULL),
(28, 22, 27, 'DEV-2026-027', 17000000.00, '2026-09-27', '2026-10-09', '2026-12-27', 'signe', 'uploads/devis/dev_027.pdf', 'Devis Immeuble Moderne', '2026-09-27 10:00:00', '2026-09-21 15:21:22', NULL),
(29, 23, 28, 'DEV-2026-028', 13000000.00, '2026-09-28', NULL, '2026-12-28', 'en_attente', 'uploads/devis/dev_028.pdf', 'Devis Villa Contemporaine', '2026-09-28 10:00:00', '2026-09-21 15:21:22', NULL),
(30, 24, 29, 'DEV-2026-029', 10000000.00, '2026-09-29', '2026-10-11', '2026-12-29', 'signe', 'uploads/devis/dev_029.pdf', 'Devis Résidence Familiale', '2026-09-29 10:00:00', '2026-09-21 15:21:22', NULL),
(31, 25, 30, 'DEV-2026-030', 3000000.00, '2026-09-30', NULL, '2026-12-30', 'en_attente', 'uploads/devis/dev_030.pdf', 'Devis Aménagement Bureau', '2026-09-30 10:00:00', '2026-09-21 15:21:22', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tbl_chantiers`
--
ALTER TABLE `tbl_chantiers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_clients`
--
ALTER TABLE `tbl_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type_client` (`type_client`),
  ADD KEY `idx_statut` (`statut`),
  ADD KEY `idx_categorie` (`categorie`),
  ADD KEY `idx_projet_id` (`projet_id`),
  ADD KEY `idx_ville` (`ville`);

--
-- Index pour la table `tbl_client_projet`
--
ALTER TABLE `tbl_client_projet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_client_projet` (`client_id`,`projet_id`),
  ADD KEY `idx_client_id` (`client_id`),
  ADD KEY `idx_projet_id` (`projet_id`);

--
-- Index pour la table `tbl_contrat_tranches`
--
ALTER TABLE `tbl_contrat_tranches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contrat_id` (`contrat_id`);

--
-- Index pour la table `tbl_devis`
--
ALTER TABLE `tbl_devis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_projet_id` (`projet_id`),
  ADD KEY `idx_chantier_id` (`chantier_id`),
  ADD KEY `idx_reference` (`reference`),
  ADD KEY `idx_statut` (`statut`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tbl_chantiers`
--
ALTER TABLE `tbl_chantiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `tbl_clients`
--
ALTER TABLE `tbl_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `tbl_client_projet`
--
ALTER TABLE `tbl_client_projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `tbl_contrat_tranches`
--
ALTER TABLE `tbl_contrat_tranches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `tbl_devis`
--
ALTER TABLE `tbl_devis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
