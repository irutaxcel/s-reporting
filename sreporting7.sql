-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 08 juil. 2026 à 16:13
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

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
-- Structure de la table `accounting_accounts`
--

CREATE TABLE `accounting_accounts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `account_code` varchar(40) NOT NULL,
  `account_label` varchar(191) NOT NULL,
  `account_class` varchar(40) NOT NULL DEFAULT 'Classe 6',
  `account_type` varchar(40) NOT NULL DEFAULT 'Charge',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `accounting_accounts`
--

INSERT INTO `accounting_accounts` (`id`, `company_id`, `account_code`, `account_label`, `account_class`, `account_type`, `is_active`, `created_at`) VALUES
(1, 2, '512000', 'Banque', 'Classe 5', 'Trésorerie', 1, '2026-04-28 14:56:10'),
(2, 2, '571000', 'Caisse', 'Classe 5', 'Trésorerie', 1, '2026-04-28 14:56:10'),
(3, 2, '401000', 'Fournisseurs', 'Classe 4', 'Tiers', 1, '2026-04-28 14:56:10'),
(4, 2, '411000', 'Clients', 'Classe 4', 'Tiers', 1, '2026-04-28 14:56:10'),
(5, 2, '421000', 'Personnel - rémunérations dues', 'Classe 4', 'Tiers', 1, '2026-04-28 14:56:10'),
(6, 2, '445000', 'État - taxes', 'Classe 4', 'Tiers', 1, '2026-04-28 14:56:10'),
(7, 2, '601000', 'Achats de matériaux', 'Classe 6', 'Charge', 1, '2026-04-28 14:56:10'),
(8, 2, '602000', 'Carburant et lubrifiants', 'Classe 6', 'Charge', 1, '2026-04-28 14:56:10'),
(9, 2, '611000', 'Sous-traitance', 'Classe 6', 'Charge', 1, '2026-04-28 14:56:10'),
(10, 2, '641000', 'Salaires et main d\'œuvre', 'Classe 6', 'Charge', 1, '2026-04-28 14:56:10'),
(11, 2, '707000', 'Produits travaux et services', 'Classe 7', 'Produit', 1, '2026-04-28 14:56:10'),
(212, 2, '612000', 'fournitures consomes t jehova', 'Classe 6', 'Charge', 1, '2026-05-04 09:29:39'),
(312, 2, '4325', 'tva deductible', 'Classe 4', 'Tiers', 1, '2026-05-04 10:13:59'),
(401, 2, '58', 'VIREMENT BC', 'Classe 5', 'Charge', 1, '2026-05-04 10:26:30');

-- --------------------------------------------------------

--
-- Structure de la table `accounting_assistant_entries`
--

CREATE TABLE `accounting_assistant_entries` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `journal_code` varchar(20) NOT NULL,
  `invoice_no` varchar(120) DEFAULT NULL,
  `account_no` varchar(80) NOT NULL,
  `operation_no` varchar(120) DEFAULT NULL,
  `entry_label` varchar(255) NOT NULL,
  `debit_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `credit_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `balance_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `obr_period` varchar(60) DEFAULT NULL,
  `obr_tax_type` varchar(120) DEFAULT NULL,
  `supplier_or_beneficiary` varchar(191) DEFAULT NULL,
  `document_status` varchar(50) NOT NULL DEFAULT 'saisi',
  `observation` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `accounting_assistant_entries`
--

INSERT INTO `accounting_assistant_entries` (`id`, `company_id`, `entry_date`, `journal_code`, `invoice_no`, `account_no`, `operation_no`, `entry_label`, `debit_amount`, `credit_amount`, `amount`, `balance_amount`, `obr_period`, `obr_tax_type`, `supplier_or_beneficiary`, `document_status`, `observation`, `created_by`, `created_at`) VALUES
(1, 2, '2026-04-02', 'Journal KINANIRA', 'Fn1041/2026', '61', '', 'Concertina', 73729.00, 73729.00, 0.00, 0.00, '', '', '', 'saisi', '', 28, '2026-06-11 15:16:58'),
(2, 2, '2026-04-02', 'Journal KINANIRA', 'Fn1041/2026', '4325', '', 'Tva deductible', 13271.00, 0.00, 0.00, 13271.00, '', '', '', 'saisi', '', 28, '2026-06-11 15:18:24'),
(3, 2, '2026-04-02', 'Journal KINANIRA', 'Fn1041/2026', '4325', '', 'Tva deductible', 13271.00, 13271.00, 0.00, 0.00, '', '', '', 'saisi', '', 28, '2026-06-11 15:35:33'),
(4, 2, '2026-04-02', 'Journal Ibb', 'Fn453/2026', '61', '', 'Achat  ciment', 73728.00, 73728.00, 87000.00, 0.00, 'Juin', 'Tva', 'Satraco construction', 'saisi', '', 28, '2026-06-11 15:57:17');

-- --------------------------------------------------------

--
-- Structure de la table `accounting_entries`
--

CREATE TABLE `accounting_entries` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `journal_code` varchar(20) NOT NULL DEFAULT 'OD',
  `piece_ref` varchar(120) DEFAULT NULL,
  `account_code` varchar(40) NOT NULL,
  `label` varchar(255) NOT NULL,
  `third_party` varchar(191) DEFAULT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `debit_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `credit_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `entry_status` varchar(40) NOT NULL DEFAULT 'brouillon',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `accounting_entries`
--

INSERT INTO `accounting_entries` (`id`, `company_id`, `entry_date`, `journal_code`, `piece_ref`, `account_code`, `label`, `third_party`, `chantier_id`, `debit_amount`, `credit_amount`, `entry_status`, `created_by`, `created_at`) VALUES
(1, 2, '2026-05-04', 'CA', '', '612000', 'achat du cima', '', 2, 10000000.00, 0.00, 'brouillon', 22, '2026-05-04 09:40:58'),
(2, 2, '0000-00-00', 'CA', '20638/M/AT-C', '612000', 'aCHAT DU CIMA', 'adams', 2, 16949.00, 16949.00, 'validé', 29, '2026-05-04 10:17:41'),
(3, 2, '2026-05-04', 'OD', '20638/M/AT-C', '4325', 'TVA DEDUCTIBLE', 'adams', 2, 3051.00, 3051.00, 'validé', 29, '2026-05-04 10:19:08'),
(4, 2, '2026-05-04', 'OD', '20638/M/AT-C', '571000', 'PAIE DU CIMA', 'adams', 2, 0.00, 20000.00, 'validé', 29, '2026-05-04 10:20:13'),
(5, 2, '2026-05-04', 'CA', '', '571000', 'alimentation de la caisse', '', 13, 1000000.00, 0.00, 'validé', 29, '2026-05-04 10:39:14');

-- --------------------------------------------------------

--
-- Structure de la table `accounting_payments`
--

CREATE TABLE `accounting_payments` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `beneficiary_name` varchar(191) NOT NULL,
  `payment_type` varchar(80) NOT NULL DEFAULT 'Fournisseur',
  `amount_bif` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_channel` varchar(80) NOT NULL DEFAULT 'Banque',
  `related_ref` varchar(120) DEFAULT NULL,
  `approval_level` varchar(120) DEFAULT NULL,
  `status_label` varchar(40) NOT NULL DEFAULT 'en attente',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `accounting_period_closures`
--

CREATE TABLE `accounting_period_closures` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `period_label` varchar(80) NOT NULL,
  `closure_status` varchar(40) NOT NULL DEFAULT 'ouverte',
  `closed_by` varchar(191) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `module_name` varchar(100) NOT NULL,
  `action_name` varchar(50) NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `ip_address` varchar(80) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `company_id`, `user_id`, `module_name`, `action_name`, `entity_id`, `description`, `ip_address`, `created_at`) VALUES
(1, NULL, 1, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-04-28 12:50:22'),
(2, 2, 1, 'companies', 'create', 2, 'Création entreprise Satraco', '102.134.101.196', '2026-04-28 13:28:30'),
(3, NULL, 1, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '102.134.101.196', '2026-04-28 13:29:35'),
(4, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-04-28 13:29:53'),
(5, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.49', '2026-04-28 14:29:37'),
(6, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.49', '2026-04-28 14:30:13'),
(7, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.49', '2026-04-28 14:47:28'),
(8, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.49', '2026-04-28 14:48:08'),
(9, 2, 22, 'users', 'create', 23, 'Création utilisateur david@satracoconstruction.com', '143.105.213.49', '2026-04-28 14:52:23'),
(10, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.49', '2026-04-28 15:03:03'),
(11, 2, 22, 'backups', 'create', NULL, 'Génération backup ZIP + SQL', '143.105.213.49', '2026-04-28 15:11:11'),
(12, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.49', '2026-04-28 15:16:01'),
(13, 2, 22, 'users', 'create', 24, 'Création utilisateur aldo@satracoconstruction.com', '143.105.213.49', '2026-04-28 15:16:39'),
(14, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '196.2.14.138', '2026-04-28 16:23:05'),
(15, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.118', '2026-04-29 09:11:48'),
(16, 2, 22, 'users', 'create', 25, 'Création utilisateur mariam@satracoconstruction.com', '154.117.216.118', '2026-04-29 09:13:34'),
(17, 2, 22, 'users', 'create', 26, 'Création utilisateur emmanuel@satracoconstruction.com', '154.117.216.118', '2026-04-29 09:15:10'),
(18, 2, 22, 'users', 'create', 27, 'Création utilisateur serges@satracoconstruction.com', '154.117.216.118', '2026-04-29 09:18:02'),
(19, 2, 22, 'users', 'create', 28, 'Création utilisateur emmanuelnduwayo@satracoconstruction.com', '154.117.216.118', '2026-04-29 09:19:42'),
(20, 2, 22, 'users', 'create', 29, 'Création utilisateur severin@satracoconstruction.com', '154.117.216.118', '2026-04-29 09:21:59'),
(21, 2, 22, 'users', 'create', 30, 'Création utilisateur alexis@satracoconstruction.com', '154.117.216.118', '2026-04-29 09:25:26'),
(22, 2, 22, 'users', 'create', 31, 'Création utilisateur alpha@satracoconstruction.com', '154.117.216.118', '2026-04-29 09:28:12'),
(23, 2, 22, 'users', 'create', 32, 'Création utilisateur kercy@satracoconstruction.com', '154.117.216.118', '2026-04-29 09:29:47'),
(24, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.229', '2026-04-29 09:36:43'),
(25, 2, 22, 'users', 'create', 33, 'Création utilisateur malulu@satracoconstruction.com', '143.105.213.229', '2026-04-29 09:42:03'),
(26, 2, 22, 'users', 'create', 34, 'Création utilisateur orly@satracoconstruction.com', '143.105.213.229', '2026-04-29 09:42:44'),
(27, 2, 34, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.229', '2026-04-29 10:03:22'),
(28, 2, 22, 'projects', 'create', 1, 'Création projet INTERBANK Burundi', '143.105.213.229', '2026-04-29 10:26:23'),
(29, 2, 22, 'chantiers', 'create', 1, 'Création chantier IBB entrepots', '143.105.213.229', '2026-04-29 10:39:27'),
(30, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-04-29 10:58:38'),
(31, 2, 34, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.229', '2026-04-29 11:07:35'),
(32, 2, 34, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.229', '2026-04-29 11:11:00'),
(33, 2, 34, 'auth', 'login', NULL, 'Connexion utilisateur', '175.110.114.91', '2026-04-29 11:12:20'),
(34, 2, 34, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '175.110.114.91', '2026-04-29 11:12:42'),
(35, 2, 32, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.229', '2026-04-29 11:18:27'),
(36, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.229', '2026-04-29 11:22:59'),
(37, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '175.110.114.91', '2026-04-29 11:27:27'),
(38, 2, 22, 'projects', 'create', 2, 'Création projet Villa 3et4 Brarudi Gitega', '175.110.114.91', '2026-04-29 11:28:33'),
(39, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.229', '2026-04-29 11:29:27'),
(40, 2, 22, 'users', 'create', 35, 'Création utilisateur nelly@satracoconstruction.com', '143.105.213.229', '2026-04-29 11:59:33'),
(41, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '175.110.114.91', '2026-04-29 12:00:46'),
(42, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '175.110.114.91', '2026-04-29 12:00:49'),
(43, 2, 22, 'users', 'create', 36, 'Création utilisateur fabrice@satracoconstruction.com', '143.105.213.103', '2026-04-29 12:08:22'),
(44, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '175.110.114.91', '2026-04-29 12:10:31'),
(45, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.103', '2026-04-29 12:36:42'),
(46, NULL, 1, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-04-29 12:37:22'),
(47, NULL, 1, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.103', '2026-04-29 12:39:02'),
(48, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-04-29 12:39:56'),
(49, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-29 14:52:53'),
(50, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-29 14:54:06'),
(51, 2, 22, 'access_matrix', 'edit', 23, 'Mise à jour matrice utilisateur #23', '143.105.213.35', '2026-04-29 14:59:23'),
(52, 2, 22, 'access_matrix', 'edit', 23, 'Mise à jour matrice utilisateur #23', '143.105.213.35', '2026-04-29 15:00:28'),
(53, 2, 22, 'users', 'create', 37, 'Création utilisateur michel@satracoconstruction.com', '143.105.213.35', '2026-04-29 15:30:14'),
(54, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-29 15:38:49'),
(55, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-29 16:15:46'),
(56, 2, 22, 'users', 'create', 38, 'Création utilisateur anniella@satracoconstruction.com', '143.105.213.35', '2026-04-29 16:16:52'),
(57, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-29 16:20:31'),
(58, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 09:23:09'),
(59, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 09:24:00'),
(60, 2, 22, 'access_matrix', 'edit', 23, 'Mise à jour matrice utilisateur #23', '143.105.213.35', '2026-04-30 09:27:52'),
(61, 2, 22, 'access_matrix', 'edit', 23, 'Mise à jour matrice utilisateur #23', '143.105.213.35', '2026-04-30 09:28:58'),
(62, 2, 22, 'access_matrix', 'edit', 23, 'Mise à jour matrice utilisateur #23', '143.105.213.35', '2026-04-30 09:31:07'),
(63, 2, 22, 'access_matrix', 'edit', 23, 'Mise à jour matrice utilisateur #23', '143.105.213.35', '2026-04-30 09:38:04'),
(64, 2, 22, 'access_matrix', 'edit', 23, 'Mise à jour matrice utilisateur #23', '143.105.213.35', '2026-04-30 09:39:41'),
(65, 2, 23, 'projects', 'create', 3, 'Création projet DEVIS ROOFTOP BANCOBU', '143.105.213.35', '2026-04-30 09:43:51'),
(66, 2, 23, 'projects', 'create', 4, 'Création projet RENOVATION OUA', '143.105.213.35', '2026-04-30 09:47:30'),
(67, 2, 23, 'projects', 'create', 5, 'Création projet KINANIRA ELIANE', '143.105.213.35', '2026-04-30 09:53:35'),
(68, 2, 23, 'projects', 'create', 6, 'Création projet OFFRE BRARUDI GITEGA', '143.105.213.35', '2026-04-30 09:54:03'),
(69, 2, 22, 'projects', 'delete', 6, 'Suppression projet', '143.105.213.35', '2026-04-30 09:55:47'),
(70, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.35', '2026-04-30 10:02:01'),
(71, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 10:02:33'),
(72, 2, 23, 'projects', 'create', 7, 'Création projet GIHOSHA MPUNDU', '143.105.213.35', '2026-04-30 10:07:11'),
(73, 2, 30, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.35', '2026-04-30 10:08:43'),
(74, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 10:08:47'),
(75, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.35', '2026-04-30 10:10:04'),
(76, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 10:10:31'),
(77, 2, 30, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.35', '2026-04-30 10:10:52'),
(78, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 10:10:56'),
(79, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 10:10:56'),
(80, 2, 22, 'access_matrix', 'edit', 30, 'Mise à jour matrice utilisateur #30', '143.105.213.35', '2026-04-30 10:11:47'),
(81, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.35', '2026-04-30 10:11:53'),
(82, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 10:12:34'),
(83, 2, 30, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.35', '2026-04-30 10:22:21'),
(84, 2, 24, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 10:22:46'),
(85, 2, 24, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.35', '2026-04-30 10:27:02'),
(86, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 10:27:19'),
(87, 2, 22, 'chantiers', 'edit', 1, 'Mise à jour chantier IBB entrepots', '143.105.213.35', '2026-04-30 10:28:13'),
(88, 2, 23, 'projects', 'create', 8, 'Création projet TEMOINS DE JEHOVANH', '143.105.213.35', '2026-04-30 10:38:24'),
(89, 2, 23, 'chantiers', 'create', 2, 'Création chantier TEMOINS DE JEHOVANH', '143.105.213.35', '2026-04-30 10:39:14'),
(90, 2, 22, 'chantiers', 'edit', 2, 'Mise à jour chantier TEMOINS DE JEHOVANH', '143.105.213.35', '2026-04-30 10:40:04'),
(91, 2, 22, 'chantiers', 'edit', 2, 'Mise à jour chantier TEMOINS DE JEHOVANH', '143.105.213.35', '2026-04-30 10:40:04'),
(92, 2, 22, 'projects', 'edit', 8, 'Mise à jour projet', '143.105.213.35', '2026-04-30 10:41:12'),
(93, 2, 22, 'chantiers', 'edit', 2, 'Mise à jour chantier TEMOINS DE JEHOVAH', '143.105.213.35', '2026-04-30 10:41:53'),
(94, 2, 23, 'projects', 'create', 9, 'Création projet KABEZI', '143.105.213.35', '2026-04-30 10:42:20'),
(95, 2, 23, 'chantiers', 'create', 3, 'Création chantier KABEZI', '143.105.213.35', '2026-04-30 10:43:34'),
(96, 2, 23, 'projects', 'create', 10, 'Création projet KING\'S SCHOOL', '143.105.213.35', '2026-04-30 10:44:39'),
(97, 2, 23, 'chantiers', 'create', 4, 'Création chantier KINGS', '143.105.213.35', '2026-04-30 10:45:24'),
(98, 2, 23, 'projects', 'create', 11, 'Création projet GIHOSHA ZONE', '143.105.213.35', '2026-04-30 10:45:54'),
(99, 2, 23, 'projects', 'create', 12, 'Création projet GIHOSHA APPARTEMENT', '143.105.213.35', '2026-04-30 10:46:13'),
(100, 2, 23, 'projects', 'create', 13, 'Création projet EDEN GARDEN APPARTEMENT', '143.105.213.35', '2026-04-30 10:46:37'),
(101, 2, 23, 'projects', 'create', 14, 'Création projet MUHA', '143.105.213.35', '2026-04-30 10:46:56'),
(102, 2, 23, 'chantiers', 'create', 5, 'Création chantier MUHA', '143.105.213.35', '2026-04-30 10:49:34'),
(103, 2, 23, 'messages', 'create', 1, 'Envoi d\'un message interne', '143.105.213.35', '2026-04-30 10:53:40'),
(104, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.35', '2026-04-30 10:54:09'),
(105, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.35', '2026-04-30 10:55:20'),
(106, 2, 30, 'messages', 'create', 2, 'Envoi d\'un message interne', '143.105.213.35', '2026-04-30 10:56:28'),
(107, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.44', '2026-04-30 13:20:29'),
(108, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.148', '2026-04-30 16:38:56'),
(109, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.148', '2026-04-30 16:48:23'),
(110, 2, 22, 'access_matrix', 'edit', 23, 'Mise à jour matrice utilisateur #23', '143.105.213.148', '2026-04-30 16:50:38'),
(111, 2, 22, 'access_matrix', 'edit', 23, 'Mise à jour matrice utilisateur #23', '143.105.213.148', '2026-04-30 16:54:04'),
(112, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.148', '2026-04-30 16:57:00'),
(113, 2, 23, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.148', '2026-04-30 16:57:43'),
(114, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.148', '2026-04-30 16:58:21'),
(115, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.148', '2026-04-30 16:59:39'),
(116, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.57', '2026-05-01 19:50:01'),
(117, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.57', '2026-05-01 20:28:54'),
(118, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 08:34:57'),
(119, 2, 23, 'chantiers', 'create', 6, 'Création chantier GIHOSHA APPARTEMENT', '143.105.213.253', '2026-05-04 08:37:18'),
(120, 2, 23, 'chantiers', 'create', 7, 'Création chantier GIHOSHA ZONE', '143.105.213.253', '2026-05-04 08:37:57'),
(121, 2, 23, 'chantiers', 'create', 8, 'Création chantier AVENANT', '143.105.213.253', '2026-05-04 08:38:19'),
(122, 2, 23, 'chantiers', 'create', 9, 'Création chantier AVENANT', '143.105.213.253', '2026-05-04 08:38:33'),
(123, 2, 23, 'chantiers', 'create', 10, 'Création chantier AVENANT', '143.105.213.253', '2026-05-04 08:39:07'),
(124, 2, 23, 'projects', 'create', 15, 'Création projet KAZOZA  KAMENGE', '143.105.213.253', '2026-05-04 08:40:28'),
(125, 2, 23, 'projects', 'create', 16, 'Création projet MUZINDA', '143.105.213.253', '2026-05-04 08:40:54'),
(126, 2, 23, 'projects', 'create', 17, 'Création projet LARGE APPARTEMENT', '143.105.213.253', '2026-05-04 08:41:38'),
(127, 2, 23, 'projects', 'create', 18, 'Création projet NYABUGETE DR ERIC', '143.105.213.253', '2026-05-04 08:41:54'),
(128, 2, 23, 'projects', 'create', 19, 'Création projet GAKUNGWE', '143.105.213.253', '2026-05-04 08:42:17'),
(129, 2, 23, 'projects', 'create', 20, 'Création projet JABE SDA', '143.105.213.253', '2026-05-04 08:42:50'),
(130, 2, 23, 'chantiers', 'create', 11, 'Création chantier GAKUNGWE', '143.105.213.253', '2026-05-04 08:43:09'),
(131, 2, 23, 'chantiers', 'create', 12, 'Création chantier JABE SDA', '143.105.213.253', '2026-05-04 08:43:25'),
(132, 2, 23, 'chantiers', 'create', 13, 'Création chantier NYABUGETE DR', '143.105.213.253', '2026-05-04 08:43:52'),
(133, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.73.107.154', '2026-05-04 09:07:49'),
(134, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 09:10:12'),
(135, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.253', '2026-05-04 09:13:28'),
(136, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 09:14:11'),
(137, 2, 27, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.253', '2026-05-04 09:14:58'),
(138, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 09:15:01'),
(139, 2, 22, 'access_matrix', 'edit', 29, 'Mise à jour matrice utilisateur #29', '143.105.213.253', '2026-05-04 09:15:58'),
(140, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.253', '2026-05-04 09:16:03'),
(141, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.73.107.154', '2026-05-04 09:16:17'),
(142, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.73.107.154', '2026-05-04 09:16:25'),
(143, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 09:17:44'),
(144, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.253', '2026-05-04 09:17:48'),
(145, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 09:18:09'),
(146, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.253', '2026-05-04 09:25:55'),
(147, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 09:25:57'),
(148, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.253', '2026-05-04 09:27:44'),
(149, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 09:28:07'),
(150, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.253', '2026-05-04 09:31:42'),
(151, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 09:31:44'),
(152, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.253', '2026-05-04 09:42:44'),
(153, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 09:43:03'),
(154, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.253', '2026-05-04 09:44:51'),
(155, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 09:44:53'),
(156, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.253', '2026-05-04 10:09:26'),
(157, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.253', '2026-05-04 10:09:52'),
(158, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.23', '2026-05-04 10:40:53'),
(159, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.23', '2026-05-04 10:40:55'),
(160, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.161', '2026-05-04 11:37:02'),
(161, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.161', '2026-05-04 11:43:20'),
(162, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.161', '2026-05-04 11:43:41'),
(163, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.161', '2026-05-04 11:54:35'),
(164, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.161', '2026-05-04 11:54:38'),
(165, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.161', '2026-05-04 12:21:51'),
(166, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.161', '2026-05-04 12:21:56'),
(167, 2, 22, 'access_matrix', 'edit', 29, 'Mise à jour matrice utilisateur #29', '143.105.213.161', '2026-05-04 12:22:29'),
(168, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.161', '2026-05-04 12:22:34'),
(169, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.161', '2026-05-04 12:22:52'),
(170, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.161', '2026-05-04 12:23:25'),
(171, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.161', '2026-05-04 12:23:28'),
(172, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-05 08:38:27'),
(173, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 08:35:38'),
(174, 2, 22, 'users', 'create', 39, 'Création utilisateur jeandedieu@satracoconstruction.com', '143.105.213.141', '2026-05-06 08:39:02'),
(175, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 08:44:18'),
(176, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 09:02:48'),
(177, 2, 34, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 09:06:50'),
(178, 2, 22, 'users', 'create', 40, 'Création utilisateur gedeon@satracoconstruction.com', '154.117.216.21', '2026-05-06 09:08:49'),
(179, 2, 40, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 09:08:55'),
(180, 2, 40, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.141', '2026-05-06 09:08:59'),
(181, 2, 40, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 09:09:03'),
(182, 2, 31, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 09:17:56'),
(183, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.21', '2026-05-06 09:23:04'),
(184, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 09:24:46'),
(185, 2, 32, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 09:26:21'),
(186, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 09:38:32'),
(187, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 09:59:15'),
(188, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 10:04:15'),
(189, 2, 22, 'access_matrix', 'edit', 36, 'Mise à jour matrice utilisateur #36', '143.105.213.141', '2026-05-06 10:08:32'),
(190, 2, 22, 'access_matrix', 'edit', 36, 'Mise à jour matrice utilisateur #36', '143.105.213.141', '2026-05-06 10:09:32'),
(191, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 10:15:00'),
(192, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 10:16:28'),
(193, 2, 36, 'production_control', 'rebuild', NULL, 'Recalcul des coûts réels et de la rentabilité détaillée', '143.105.213.141', '2026-05-06 10:33:47'),
(194, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '154.73.107.175', '2026-05-06 10:44:37'),
(195, 2, 22, 'users', 'create', 41, 'Création utilisateur jeannette@satracoconstruction.com', '143.105.213.141', '2026-05-06 10:56:14'),
(196, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 11:15:12'),
(197, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 11:33:15'),
(198, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 11:33:16'),
(199, 2, 22, 'access_matrix', 'edit', 41, 'Mise à jour matrice utilisateur #41', '143.105.213.141', '2026-05-06 11:37:51'),
(200, 2, 22, 'users', 'create', 42, 'Création utilisateur kevin@satracoconstruction.com', '143.105.213.141', '2026-05-06 12:10:23'),
(201, 2, 41, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.141', '2026-05-06 12:14:48'),
(202, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 12:15:20'),
(203, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 13:25:34'),
(204, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 13:25:35'),
(205, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 13:25:40'),
(206, 2, 23, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.141', '2026-05-06 13:26:34'),
(207, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 13:26:56'),
(208, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.150', '2026-05-06 13:30:29'),
(209, 2, 22, 'access_matrix', 'edit', 37, 'Mise à jour matrice utilisateur #37', '143.105.213.141', '2026-05-06 13:34:14'),
(210, 2, 37, 'purchase_requests', 'create', 1, 'Création demande d\'achat Mastic de fer', '154.117.217.150', '2026-05-06 13:34:25'),
(211, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.150', '2026-05-06 13:36:12'),
(212, 2, 36, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.141', '2026-05-06 13:36:15'),
(213, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 13:36:20'),
(214, 2, 37, 'purchase_requests', 'create', 2, 'Création demande d\'achat Antirouille', '154.117.217.150', '2026-05-06 13:38:31'),
(215, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.150', '2026-05-06 13:40:05'),
(216, 2, 22, 'purchase_requests', 'edit', 2, 'Mise à jour demande d\'achat Antirouille', '143.105.213.141', '2026-05-06 13:40:20'),
(217, 2, 22, 'purchase_requests', 'edit', 2, 'Mise à jour demande d\'achat Antirouille', '143.105.213.141', '2026-05-06 13:41:45'),
(218, 2, 37, 'purchase_requests', 'create', 3, 'Création demande d\'achat Granulats', '154.117.217.150', '2026-05-06 13:42:37'),
(219, 2, 37, 'purchase_requests', 'create', 4, 'Création demande d\'achat Briques', '154.117.217.150', '2026-05-06 13:45:55'),
(220, 2, 37, 'purchase_requests', 'create', 5, 'Création demande d\'achat Briques', '154.117.217.150', '2026-05-06 13:46:29'),
(221, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 14:23:21'),
(222, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 15:30:56'),
(223, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.141', '2026-05-06 16:07:02'),
(224, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.55', '2026-05-06 17:09:39'),
(225, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.194.55', '2026-05-06 17:10:06'),
(226, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-05-06 19:09:15'),
(227, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.55', '2026-05-07 05:42:27'),
(228, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-07 08:54:29'),
(229, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-07 09:18:33'),
(230, 2, 22, 'access_matrix', 'edit', 29, 'Mise à jour matrice utilisateur #29', '143.105.213.162', '2026-05-07 09:24:08'),
(231, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.162', '2026-05-07 09:25:41'),
(232, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-07 09:26:05'),
(233, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.162', '2026-05-07 09:26:12'),
(234, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-07 09:26:24'),
(235, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.162', '2026-05-07 09:27:00'),
(236, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-07 09:27:17'),
(237, 2, 28, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.162', '2026-05-07 09:28:20'),
(238, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-07 09:34:07'),
(239, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-07 09:34:26'),
(240, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-07 09:35:45'),
(241, 2, 22, 'access_matrix', 'edit', 30, 'Mise à jour matrice utilisateur #30', '143.105.213.162', '2026-05-07 09:38:11'),
(242, 2, 30, 'clients', 'create', 1, 'Création client Madame Eliane ( KINANAIRA )', '143.105.213.162', '2026-05-07 09:40:40'),
(243, 2, 30, 'devis', 'create', 1, 'Création devis TOITURE', '143.105.213.162', '2026-05-07 09:44:14'),
(244, 2, 31, 'auth', 'login', NULL, 'Connexion utilisateur', '154.73.106.51', '2026-05-07 09:45:38'),
(245, 2, 30, 'devis', 'create', 2, 'Création devis TOITURE', '143.105.213.162', '2026-05-07 09:45:42'),
(246, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-07 10:00:46'),
(247, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-07 10:20:17'),
(248, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 10:35:55'),
(249, 2, 22, 'users', 'create', 43, 'Création utilisateur ramla@satracoconstuction.com', '143.105.213.123', '2026-05-07 11:00:40'),
(250, 2, 22, 'access_matrix', 'edit', 43, 'Mise à jour matrice utilisateur #43', '143.105.213.123', '2026-05-07 11:01:32'),
(251, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 11:09:51'),
(252, 2, 22, 'access_matrix', 'edit', 43, 'Mise à jour matrice utilisateur #43', '143.105.213.123', '2026-05-07 11:16:26'),
(253, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.123', '2026-05-07 11:16:28'),
(254, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 11:17:57'),
(255, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.123', '2026-05-07 11:18:18'),
(256, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 11:18:43'),
(257, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 11:28:55'),
(258, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 11:45:42'),
(259, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 11:45:58'),
(260, 2, 43, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.123', '2026-05-07 12:03:34'),
(261, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 12:03:36'),
(262, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.123', '2026-05-07 12:06:42'),
(263, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 12:07:02'),
(264, 2, 43, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.123', '2026-05-07 12:11:07'),
(265, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 12:16:12'),
(266, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 12:18:02'),
(267, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 13:02:57'),
(268, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 13:04:19'),
(269, 2, 39, 'stocks', 'create', 1, 'Création stock ECHAFFAUDAGE', '143.105.213.123', '2026-05-07 13:04:19'),
(270, 2, 39, 'stocks', 'edit', 1, 'Mise à jour stock', '143.105.213.123', '2026-05-07 13:04:57'),
(271, 2, 39, 'stocks', 'create', 2, 'Création stock MATELA', '143.105.213.123', '2026-05-07 13:05:33'),
(272, 2, 39, 'stocks', 'create', 3, 'Création stock PORTES', '143.105.213.123', '2026-05-07 13:06:04'),
(273, 2, 39, 'stocks', 'create', 4, 'Création stock imireko', '143.105.213.123', '2026-05-07 13:06:28'),
(274, 2, 39, 'stocks', 'create', 5, 'Création stock machette', '143.105.213.123', '2026-05-07 13:17:01'),
(275, 2, 39, 'stocks', 'create', 6, 'Création stock projecteur', '143.105.213.123', '2026-05-07 13:17:27'),
(276, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 13:18:25'),
(277, 2, 39, 'stocks', 'create', 7, 'Création stock ampoule', '143.105.213.123', '2026-05-07 13:21:30'),
(278, 2, 39, 'stocks', 'create', 8, 'Création stock scie a menuisier', '143.105.213.123', '2026-05-07 13:23:01'),
(279, 2, 39, 'stocks', 'create', 9, 'Création stock gaine', '143.105.213.123', '2026-05-07 13:23:24'),
(280, 2, 39, 'stocks', 'create', 10, 'Création stock TUBE(ampoule)', '143.105.213.123', '2026-05-07 13:28:49'),
(281, 2, 39, 'stocks', 'create', 11, 'Création stock equerre', '143.105.213.123', '2026-05-07 13:29:10'),
(282, 2, 39, 'stocks', 'create', 12, 'Création stock casque', '143.105.213.123', '2026-05-07 13:29:30'),
(283, 2, 39, 'stocks', 'create', 13, 'Création stock Etrier', '143.105.213.123', '2026-05-07 13:29:58'),
(284, 2, 39, 'stocks', 'create', 14, 'Création stock loofing', '143.105.213.123', '2026-05-07 13:30:46'),
(285, 2, 39, 'stocks', 'create', 15, 'Création stock ratte', '143.105.213.123', '2026-05-07 13:31:04'),
(286, 2, 39, 'stocks', 'create', 16, 'Création stock appareil', '143.105.213.123', '2026-05-07 13:31:36'),
(287, 2, 39, 'stocks', 'create', 17, 'Création stock mastique', '143.105.213.123', '2026-05-07 13:32:31'),
(288, 2, 39, 'stocks', 'create', 18, 'Création stock fil reseau', '143.105.213.123', '2026-05-07 13:33:27'),
(289, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 13:33:30'),
(290, 2, 39, 'stocks', 'create', 19, 'Création stock polis elevateur', '143.105.213.123', '2026-05-07 13:34:04'),
(291, 2, 39, 'stocks', 'create', 20, 'Création stock cache noeud', '143.105.213.123', '2026-05-07 13:34:42'),
(292, 2, 39, 'stocks', 'create', 21, 'Création stock cache oreille', '143.105.213.123', '2026-05-07 13:35:11'),
(293, 2, 43, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.123', '2026-05-07 13:35:27'),
(294, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 13:35:31'),
(295, 2, 39, 'stocks', 'create', 22, 'Création stock FB M12', '143.105.213.123', '2026-05-07 13:35:37'),
(296, 2, 39, 'stocks', 'create', 23, 'Création stock ROBINET', '143.105.213.123', '2026-05-07 13:36:03'),
(297, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.123', '2026-05-07 13:36:03'),
(298, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 13:36:19'),
(299, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 13:46:09'),
(300, 2, 39, 'stocks', 'edit', 21, 'Mise à jour stock', '143.105.213.123', '2026-05-07 13:52:59'),
(301, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 13:54:37'),
(302, 2, 23, 'projects', 'create', 21, 'Création projet GATOKE', '143.105.213.123', '2026-05-07 13:55:44'),
(303, 2, 23, 'chantiers', 'create', 14, 'Création chantier GATOKE CLAUDOIR', '143.105.213.123', '2026-05-07 13:56:27'),
(304, 2, 23, 'projects', 'create', 22, 'Création projet KININDO APPARTEMENT', '143.105.213.123', '2026-05-07 13:56:54'),
(305, 2, 23, 'chantiers', 'create', 15, 'Création chantier KININDO APPARTEMENT', '143.105.213.123', '2026-05-07 13:57:18'),
(306, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 14:03:29'),
(307, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 14:06:28'),
(308, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 14:56:09'),
(309, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 15:26:24'),
(310, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 15:31:53'),
(311, 2, 23, 'projects', 'create', 23, 'Création projet GIHOSHA NDAYI', '143.105.213.123', '2026-05-07 15:32:50'),
(312, 2, 23, 'chantiers', 'create', 16, 'Création chantier GIHOSHA NDAYI', '143.105.213.123', '2026-05-07 15:33:42'),
(313, 2, 23, 'projects', 'create', 24, 'Création projet KINANIRA 3', '143.105.213.123', '2026-05-07 15:34:35'),
(314, 2, 23, 'chantiers', 'create', 17, 'Création chantier KINANIRA 3', '143.105.213.123', '2026-05-07 15:34:55'),
(315, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 16:13:35'),
(316, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 16:57:59'),
(317, 2, 24, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.193.45', '2026-05-07 17:01:53'),
(318, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.123', '2026-05-07 17:15:28'),
(319, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 08:39:38'),
(320, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.192', '2026-05-08 08:52:45'),
(321, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 08:54:57'),
(322, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.74', '2026-05-08 08:55:29'),
(323, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 08:56:01'),
(324, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.62', '2026-05-08 08:56:20'),
(325, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 08:56:43'),
(326, 2, 37, 'purchase_requests', 'create', 6, 'Création demande d\'achat Chargement et déchargement du gris élevateur', '154.117.192.1', '2026-05-08 08:57:35'),
(327, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 09:03:22'),
(328, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.192.242', '2026-05-08 09:04:20'),
(329, 2, 37, 'purchase_requests', 'create', 7, 'Création demande d\'achat Fonctionnemenr', '154.117.230.210', '2026-05-08 09:06:32'),
(330, 2, 36, 'sous_traitants', 'create', 1, 'Création sous-traitant TUYISENGE           Dieudonné', '143.105.213.62', '2026-05-08 09:10:55'),
(331, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 09:12:17'),
(332, 2, 43, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.62', '2026-05-08 09:20:06'),
(333, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 09:20:09'),
(334, 2, 22, 'purchase_requests', 'delete', 6, 'Suppression demande d\'achat', '143.105.213.62', '2026-05-08 09:20:45'),
(335, 2, 37, 'purchase_requests', 'edit', 7, 'Mise à jour demande d\'achat Fonctionnement', '154.117.192.58', '2026-05-08 09:22:15'),
(336, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 09:31:22'),
(337, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 10:42:31'),
(338, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 10:43:16'),
(339, 2, 36, 'sous_traitants', 'create', 2, 'Création sous-traitant NDABARUSHIMANA Jean de Dieu', '143.105.213.62', '2026-05-08 10:44:27'),
(340, 2, 36, 'sous_traitants', 'create', 3, 'Création sous-traitant NDARUBAYEMWO         Willerme', '143.105.213.62', '2026-05-08 10:47:50'),
(341, 2, 36, 'sous_traitants', 'create', 4, 'Création sous-traitant HABONIMANA           Moise', '143.105.213.62', '2026-05-08 10:50:11'),
(342, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 11:10:36'),
(343, 2, 36, 'sous_traitants', 'create', 5, 'Création sous-traitant CISHAHAYO Elie Moses', '143.105.213.62', '2026-05-08 11:47:13'),
(344, 2, 36, 'sous_traitants', 'create', 6, 'Création sous-traitant NIYINDAMUTSA          Adelin', '143.105.213.62', '2026-05-08 11:48:19'),
(345, 2, 36, 'sous_traitants', 'create', 7, 'Création sous-traitant HATUNGIMANA             Vincent', '143.105.213.62', '2026-05-08 11:49:16'),
(346, 2, 36, 'sous_traitants', 'create', 8, 'Création sous-traitant NDUWIMANA              Claude', '143.105.213.62', '2026-05-08 11:51:15'),
(347, 2, 36, 'sous_traitants', 'create', 9, 'Création sous-traitant KWIZERA          Simeon', '143.105.213.62', '2026-05-08 11:53:35'),
(348, 2, 36, 'sous_traitants', 'create', 10, 'Création sous-traitant NSHIMIRIMANA                  Dismas', '143.105.213.62', '2026-05-08 11:55:45'),
(349, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 14:14:51'),
(350, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 14:18:44'),
(351, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 14:19:38'),
(352, 2, 22, 'users', 'create', 44, 'Création utilisateur mwarabu@satracoconstruction.com', '143.105.213.62', '2026-05-08 14:23:18'),
(353, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 14:23:52'),
(354, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 14:24:03'),
(355, 2, 44, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.62', '2026-05-08 14:24:13'),
(356, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 14:24:17'),
(357, 2, 22, 'access_matrix', 'edit', 44, 'Mise à jour matrice utilisateur #44', '143.105.213.62', '2026-05-08 14:27:35'),
(358, 2, 22, 'projects', 'create', 25, 'Création projet Fonctionnemnt bureau', '143.105.213.62', '2026-05-08 14:37:22'),
(359, 2, 22, 'chantiers', 'create', 18, 'Création chantier Fonctionnemnt bureau', '143.105.213.62', '2026-05-08 14:38:38'),
(360, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 14:40:38'),
(361, 2, 43, 'purchase_requests', 'create', 8, 'Création demande d\'achat MANIRAGABA SERGES', '143.105.213.62', '2026-05-08 14:40:39'),
(362, 2, 43, 'purchase_requests', 'create', 9, 'Création demande d\'achat NIYONKURU J DE DIEU', '143.105.213.62', '2026-05-08 14:41:49'),
(363, 2, 43, 'purchase_requests', 'create', 10, 'Création demande d\'achat NIYITEGEKA JACQUES', '143.105.213.62', '2026-05-08 14:43:01'),
(364, 2, 43, 'purchase_requests', 'create', 11, 'Création demande d\'achat HABONIMANA ANIELLA', '143.105.213.62', '2026-05-08 14:44:04'),
(365, 2, 43, 'purchase_requests', 'create', 12, 'Création demande d\'achat TUYISABE SEVERIN', '143.105.213.62', '2026-05-08 14:44:50'),
(366, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 14:45:09'),
(367, 2, 43, 'purchase_requests', 'create', 13, 'Création demande d\'achat NDUZAYO EMMANUEL', '143.105.213.62', '2026-05-08 14:46:09'),
(368, 2, 43, 'purchase_requests', 'create', 14, 'Création demande d\'achat MANIRAKIWA MICHEL', '143.105.213.62', '2026-05-08 14:48:08'),
(369, 2, 43, 'purchase_requests', 'create', 15, 'Création demande d\'achat NDIKUMANA ERIC', '143.105.213.62', '2026-05-08 14:48:52'),
(370, 2, 43, 'purchase_requests', 'create', 16, 'Création demande d\'achat NAHI?ANA RAMLA', '143.105.213.62', '2026-05-08 14:49:52'),
(371, 2, 43, 'purchase_requests', 'create', 17, 'Création demande d\'achat NKORERIMANA EMMANUEL', '143.105.213.62', '2026-05-08 14:50:46'),
(372, 2, 43, 'purchase_requests', 'create', 18, 'Création demande d\'achat MARURU NDEKO', '143.105.213.62', '2026-05-08 14:51:30'),
(373, 2, 43, 'purchase_requests', 'create', 19, 'Création demande d\'achat NKESHIMANA COME', '143.105.213.62', '2026-05-08 14:52:18'),
(374, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.62', '2026-05-08 14:52:43'),
(375, 2, 43, 'purchase_requests', 'create', 20, 'Création demande d\'achat NIBITANGA FABRICE', '143.105.213.62', '2026-05-08 14:53:00'),
(376, 2, 43, 'purchase_requests', 'create', 21, 'Création demande d\'achat HABINGABZA GEDEON', '143.105.213.62', '2026-05-08 14:54:04'),
(377, 2, 43, 'purchase_requests', 'create', 22, 'Création demande d\'achat DUSHIME KERCY MERVEILLE', '143.105.213.62', '2026-05-08 14:56:44'),
(378, 2, 43, 'purchase_requests', 'create', 23, 'Création demande d\'achat IRAKOWE ALPHA', '143.105.213.62', '2026-05-08 14:57:51'),
(379, 2, 43, 'purchase_requests', 'create', 24, 'Création demande d\'achat IRAKOWE CLAUDE', '143.105.213.62', '2026-05-08 14:58:28'),
(380, 2, 43, 'purchase_requests', 'create', 25, 'Création demande d\'achat NKURUNZIZA ALEXIS', '143.105.213.62', '2026-05-08 14:59:22'),
(381, 2, 43, 'purchase_requests', 'create', 26, 'Création demande d\'achat AHISHAKIYE NELLY ANGE', '143.105.213.62', '2026-05-08 15:00:42'),
(382, 2, 43, 'purchase_requests', 'create', 27, 'Création demande d\'achat JEANNETTE MOSES', '143.105.213.62', '2026-05-08 15:02:10'),
(383, 2, 43, 'purchase_requests', 'create', 28, 'Création demande d\'achat RUTH ZKARIAS', '143.105.213.62', '2026-05-08 15:03:20'),
(384, 2, 43, 'purchase_requests', 'create', 29, 'Création demande d\'achat NISHIMWE OLIVIER', '143.105.213.62', '2026-05-08 15:04:19'),
(385, 2, 43, 'purchase_requests', 'create', 30, 'Création demande d\'achat RUGAMIRA J MARIE', '143.105.213.62', '2026-05-08 15:05:27'),
(386, 2, 43, 'purchase_requests', 'create', 31, 'Création demande d\'achat INGABIRE ELGA', '143.105.213.62', '2026-05-08 15:06:21'),
(387, 2, 43, 'purchase_requests', 'create', 32, 'Création demande d\'achat IRUTAVYOSE F AXCEL', '143.105.213.62', '2026-05-08 15:07:16'),
(388, 2, 43, 'purchase_requests', 'create', 33, 'Création demande d\'achat MUNEWERO NADIA', '143.105.213.62', '2026-05-08 15:08:21'),
(389, 2, 43, 'purchase_requests', 'create', 34, 'Création demande d\'achat KWIWERIMANA EMERY', '143.105.213.62', '2026-05-08 15:09:02'),
(390, 2, 43, 'purchase_requests', 'create', 35, 'Création demande d\'achat GENEVIEVE', '143.105.213.62', '2026-05-08 15:09:46'),
(391, 2, 43, 'purchase_requests', 'create', 36, 'Création demande d\'achat ARAKAZA ARNAUD', '143.105.213.62', '2026-05-08 15:10:44'),
(392, 2, 43, 'purchase_requests', 'create', 37, 'Création demande d\'achat HEWAGIRA ORLY', '143.105.213.62', '2026-05-08 15:12:41'),
(393, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.234', '2026-05-08 15:34:45'),
(394, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.234', '2026-05-08 15:35:53'),
(395, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.234', '2026-05-08 15:35:54'),
(396, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.143', '2026-05-08 17:03:24'),
(397, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.236.156', '2026-05-08 19:23:14'),
(398, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-05-08 19:38:09'),
(399, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-05-09 22:05:55'),
(400, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '102.134.101.196', '2026-05-09 22:10:31'),
(401, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-05-09 22:11:59'),
(402, 2, 22, 'backups', 'create', NULL, 'Génération backup ZIP + SQL', '102.134.101.196', '2026-05-09 22:13:03'),
(403, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 08:50:30'),
(404, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 08:53:26'),
(405, 2, 38, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.115', '2026-05-11 08:53:42'),
(406, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 08:54:00'),
(407, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 08:58:02'),
(408, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.249', '2026-05-11 08:59:32'),
(409, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 08:59:35'),
(410, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.73.107.28', '2026-05-11 09:06:31'),
(411, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.115', '2026-05-11 09:07:47'),
(412, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 09:08:05'),
(413, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.73.107.232', '2026-05-11 09:13:46'),
(414, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 09:18:08'),
(415, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 09:25:09'),
(416, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 09:27:30'),
(417, 2, 25, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.115', '2026-05-11 09:29:54'),
(418, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 09:31:43'),
(419, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 09:31:44'),
(420, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 09:32:40'),
(421, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.54', '2026-05-11 09:40:09'),
(422, 2, 38, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.115', '2026-05-11 09:55:41'),
(423, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 09:55:43'),
(424, 2, 22, 'access_matrix', 'edit', 25, 'Mise à jour matrice utilisateur #25', '143.105.213.115', '2026-05-11 09:56:52'),
(425, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 10:03:31'),
(426, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.194', '2026-05-11 10:17:51'),
(427, 2, 22, 'access_matrix', 'edit', 25, 'Mise à jour matrice utilisateur #25', '143.105.213.115', '2026-05-11 10:22:36'),
(428, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 11:04:06'),
(429, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 11:04:06'),
(430, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 11:46:51'),
(431, 2, 25, 'projects', 'create', 26, 'Création projet MRRIOIR', '143.105.213.115', '2026-05-11 11:55:57'),
(432, 2, 25, 'chantiers', 'create', 19, 'Création chantier Chantier Mirroir', '143.105.213.115', '2026-05-11 11:57:10'),
(433, 2, 22, 'chantiers', 'edit', 19, 'Mise à jour chantier Chantier Mirroir', '143.105.213.115', '2026-05-11 11:58:41'),
(434, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 12:28:05'),
(435, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 12:31:39'),
(436, 2, 39, 'stocks', 'create', 24, 'Création stock mazout', '143.105.213.115', '2026-05-11 12:48:58'),
(437, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 12:51:56'),
(438, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 13:08:00'),
(439, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 13:10:13'),
(440, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.193.216', '2026-05-11 13:11:00'),
(441, 2, 22, 'access_matrix', 'edit', 39, 'Mise à jour matrice utilisateur #39', '154.117.193.216', '2026-05-11 13:12:57'),
(442, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 13:30:02'),
(443, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 13:35:41'),
(444, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 13:37:23'),
(445, 2, 22, 'access_matrix', 'edit', 28, 'Mise à jour matrice utilisateur #28', '143.105.213.115', '2026-05-11 13:39:18'),
(446, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 13:47:15'),
(447, 2, 28, 'purchase_requests', 'create', 38, 'Création demande d\'achat MANIRAGABA Serges', '143.105.213.115', '2026-05-11 13:50:22'),
(448, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 13:52:43'),
(449, 2, 28, 'purchase_requests', 'create', 39, 'Création demande d\'achat NDUWAYO EMMANUEL', '143.105.213.115', '2026-05-11 13:54:45'),
(450, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.115', '2026-05-11 13:59:50'),
(451, 2, 28, 'purchase_requests', 'create', 40, 'Création demande d\'achat NKESHIMANA COME', '143.105.213.115', '2026-05-11 14:00:26'),
(452, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 14:07:23');
INSERT INTO `activity_logs` (`id`, `company_id`, `user_id`, `module_name`, `action_name`, `entity_id`, `description`, `ip_address`, `created_at`) VALUES
(453, 2, 36, 'purchase_requests', 'create', 41, 'Création demande d\'achat NIBITANGA                 FABRICE', '143.105.213.115', '2026-05-11 14:10:35'),
(454, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 14:13:37'),
(455, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.115', '2026-05-11 14:23:06'),
(456, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 14:23:27'),
(457, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 14:40:37'),
(458, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 14:41:06'),
(459, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 14:44:21'),
(460, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 15:00:48'),
(461, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 15:19:12'),
(462, 2, 38, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.115', '2026-05-11 15:27:21'),
(463, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 15:27:24'),
(464, 2, 22, 'projects', 'create', 27, 'Création projet GASENYI Presidence', '143.105.213.115', '2026-05-11 15:28:45'),
(465, 2, 22, 'chantiers', 'create', 20, 'Création chantier GASENYI Presidence', '143.105.213.115', '2026-05-11 15:31:08'),
(466, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 15:33:50'),
(467, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 15:46:21'),
(468, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.115', '2026-05-11 15:49:56'),
(469, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 16:08:58'),
(470, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-11 16:33:12'),
(471, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.34', '2026-05-11 16:40:11'),
(472, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 07:56:10'),
(473, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 07:57:30'),
(474, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 07:57:45'),
(475, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 08:37:01'),
(476, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 08:38:26'),
(477, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 08:43:38'),
(478, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 08:47:57'),
(479, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 08:48:15'),
(480, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 08:56:20'),
(481, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 08:57:14'),
(482, 2, 22, 'access_matrix', 'edit', 35, 'Mise à jour matrice utilisateur #35', '143.105.213.116', '2026-05-12 09:00:12'),
(483, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:04:14'),
(484, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:08:35'),
(485, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:13:55'),
(486, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:14:05'),
(487, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:14:13'),
(488, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:20:10'),
(489, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:27:32'),
(490, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:39:48'),
(491, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:40:32'),
(492, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:42:36'),
(493, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 09:58:44'),
(494, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 10:00:21'),
(495, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 10:02:25'),
(496, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 10:04:02'),
(497, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 10:10:23'),
(498, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 10:11:55'),
(499, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 10:14:38'),
(500, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 10:15:22'),
(501, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 10:15:57'),
(502, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 10:23:04'),
(503, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 11:07:42'),
(504, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 11:10:24'),
(505, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 11:38:43'),
(506, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 11:46:41'),
(507, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.207', '2026-05-12 11:48:41'),
(508, 2, 23, 'purchase_requests', 'create', 42, 'Création demande d\'achat ch', '143.105.213.116', '2026-05-12 11:52:06'),
(509, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.232.73', '2026-05-12 11:59:07'),
(510, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.232.73', '2026-05-12 12:00:13'),
(511, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 12:05:22'),
(512, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 12:36:09'),
(513, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.205', '2026-05-12 12:57:35'),
(514, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 13:05:39'),
(515, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 13:05:40'),
(516, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.205', '2026-05-12 13:33:05'),
(517, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.116', '2026-05-12 13:35:22'),
(518, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.205', '2026-05-12 13:46:59'),
(519, 2, 37, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.230.205', '2026-05-12 14:09:22'),
(520, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.205', '2026-05-12 14:09:26'),
(521, 2, 37, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.230.205', '2026-05-12 14:12:01'),
(522, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.205', '2026-05-12 14:12:04'),
(523, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 14:33:01'),
(524, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 14:39:11'),
(525, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 14:41:58'),
(526, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 14:50:10'),
(527, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.87', '2026-05-12 14:53:45'),
(528, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 15:03:26'),
(529, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 16:00:13'),
(530, 2, 23, 'crm', 'create', 1, 'Création opportunité KENYA EMBASSY', '143.105.213.93', '2026-05-12 16:03:50'),
(531, 2, 23, 'crm', 'create', 2, 'Création opportunité ADB', '143.105.213.93', '2026-05-12 16:05:04'),
(532, 2, 23, 'crm', 'create', 3, 'Création opportunité WHH', '143.105.213.93', '2026-05-12 16:06:46'),
(533, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 16:39:22'),
(534, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 16:40:18'),
(535, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 16:40:40'),
(536, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 16:52:01'),
(537, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.93', '2026-05-12 16:52:09'),
(538, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 16:55:36'),
(539, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 17:00:05'),
(540, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 17:01:46'),
(541, 2, 25, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.93', '2026-05-12 17:04:36'),
(542, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 17:09:29'),
(543, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.93', '2026-05-12 17:14:42'),
(544, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.104', '2026-05-12 17:31:35'),
(545, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.104', '2026-05-12 17:42:24'),
(546, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.104', '2026-05-12 17:46:00'),
(547, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-05-13 01:41:07'),
(548, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 08:58:53'),
(549, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:01:31'),
(550, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:02:34'),
(551, 2, 22, 'users', 'create', 45, 'Création utilisateur jacques@satracoconstruction.com', '143.105.213.8', '2026-05-13 09:07:25'),
(552, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:07:55'),
(553, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:08:32'),
(554, 2, 45, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.8', '2026-05-13 09:08:45'),
(555, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:09:04'),
(556, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:09:35'),
(557, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:10:54'),
(558, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:11:27'),
(559, 2, 22, 'access_matrix', 'edit', 45, 'Mise à jour matrice utilisateur #45', '143.105.213.8', '2026-05-13 09:13:04'),
(560, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:13:49'),
(561, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:13:49'),
(562, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.176', '2026-05-13 09:16:49'),
(563, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:19:32'),
(564, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.8', '2026-05-13 09:20:33'),
(565, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:21:55'),
(566, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.8', '2026-05-13 09:22:39'),
(567, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:23:34'),
(568, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:25:15'),
(569, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.8', '2026-05-13 09:25:29'),
(570, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:26:06'),
(571, 2, 24, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.193.164', '2026-05-13 09:29:14'),
(572, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:30:23'),
(573, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:30:24'),
(574, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:31:58'),
(575, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:34:15'),
(576, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:34:16'),
(577, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:35:58'),
(578, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.8', '2026-05-13 09:36:46'),
(579, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:39:14'),
(580, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:44:16'),
(581, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:45:51'),
(582, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:46:25'),
(583, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 09:47:21'),
(584, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 10:04:53'),
(585, 2, 41, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.8', '2026-05-13 10:05:02'),
(586, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 10:05:33'),
(587, 2, 22, 'access_matrix', 'edit', 41, 'Mise à jour matrice utilisateur #41', '143.105.213.8', '2026-05-13 10:07:02'),
(588, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 10:13:56'),
(589, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.8', '2026-05-13 10:25:49'),
(590, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 10:31:53'),
(591, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.8', '2026-05-13 10:40:20'),
(592, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:02:01'),
(593, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.8', '2026-05-13 11:04:04'),
(594, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:19:46'),
(595, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:19:48'),
(596, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:20:32'),
(597, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:24:11'),
(598, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:29:59'),
(599, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:30:05'),
(600, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:31:05'),
(601, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:35:06'),
(602, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:35:09'),
(603, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:41:21'),
(604, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:44:58'),
(605, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:47:16'),
(606, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:52:07'),
(607, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:52:11'),
(608, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:57:20'),
(609, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:58:01'),
(610, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:58:35'),
(611, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 11:58:40'),
(612, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:00:06'),
(613, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:00:08'),
(614, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:00:10'),
(615, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.8', '2026-05-13 12:00:29'),
(616, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:02:48'),
(617, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:02:49'),
(618, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:02:52'),
(619, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:02:53'),
(620, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:02:54'),
(621, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:02:57'),
(622, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:03:00'),
(623, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:04:47'),
(624, 2, 22, 'users', 'create', 46, 'Création utilisateur come@satracoconstruction.com', '143.105.213.8', '2026-05-13 12:08:51'),
(625, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:11:04'),
(626, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:11:19'),
(627, 2, 22, 'chantiers', 'create', 21, 'Création chantier Siège social', '143.105.213.8', '2026-05-13 12:13:37'),
(628, 2, 22, 'chantiers', 'create', 22, 'Création chantier Siège social', '143.105.213.8', '2026-05-13 12:13:50'),
(629, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:16:34'),
(630, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:23:30'),
(631, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.8', '2026-05-13 12:23:35'),
(632, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.245', '2026-05-13 12:30:13'),
(633, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 12:34:09'),
(634, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 12:36:27'),
(635, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 12:36:30'),
(636, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 12:36:32'),
(637, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 12:44:43'),
(638, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 12:45:09'),
(639, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 12:45:12'),
(640, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 12:50:29'),
(641, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 12:54:55'),
(642, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 12:59:40'),
(643, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.210', '2026-05-13 13:12:27'),
(644, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.231.210', '2026-05-13 13:13:01'),
(645, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.210', '2026-05-13 13:13:13'),
(646, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.231.210', '2026-05-13 13:14:17'),
(647, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.210', '2026-05-13 13:14:39'),
(648, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.231.210', '2026-05-13 13:14:47'),
(649, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 13:26:24'),
(650, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 13:43:15'),
(651, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 13:43:17'),
(652, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 13:44:52'),
(653, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 13:46:55'),
(654, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 13:49:03'),
(655, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.48', '2026-05-13 13:50:00'),
(656, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 13:57:39'),
(657, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 14:03:07'),
(658, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 14:08:09'),
(659, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 14:08:39'),
(660, 2, 22, 'users', 'create', 47, 'Création utilisateur claude@satracoconstruction.com', '143.105.213.48', '2026-05-13 14:15:03'),
(661, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 14:15:32'),
(662, 2, 47, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 14:16:51'),
(663, 2, 22, 'access_matrix', 'edit', 47, 'Mise à jour matrice utilisateur #47', '143.105.213.48', '2026-05-13 14:19:00'),
(664, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.48', '2026-05-13 14:19:28'),
(665, 2, 22, 'access_matrix', 'edit', 47, 'Mise à jour matrice utilisateur #47', '143.105.213.48', '2026-05-13 14:19:58'),
(666, 2, 22, 'access_matrix', 'edit', 47, 'Mise à jour matrice utilisateur #47', '143.105.213.48', '2026-05-13 14:23:28'),
(667, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 14:23:48'),
(668, 2, 22, 'access_matrix', 'edit', 47, 'Mise à jour matrice utilisateur #47', '143.105.213.48', '2026-05-13 14:25:17'),
(669, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 14:28:32'),
(670, 2, 22, 'access_matrix', 'edit', 44, 'Mise à jour matrice utilisateur #44', '143.105.213.48', '2026-05-13 14:37:24'),
(671, 2, 22, 'access_matrix', 'edit', 29, 'Mise à jour matrice utilisateur #29', '143.105.213.48', '2026-05-13 14:37:58'),
(672, 2, 22, 'access_matrix', 'edit', 43, 'Mise à jour matrice utilisateur #43', '143.105.213.48', '2026-05-13 14:38:45'),
(673, 2, 22, 'access_matrix', 'edit', 37, 'Mise à jour matrice utilisateur #37', '143.105.213.48', '2026-05-13 14:39:50'),
(674, 2, 22, 'access_matrix', 'edit', 38, 'Mise à jour matrice utilisateur #38', '143.105.213.48', '2026-05-13 14:40:58'),
(675, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 14:41:18'),
(676, 2, 22, 'access_matrix', 'edit', 39, 'Mise à jour matrice utilisateur #39', '143.105.213.48', '2026-05-13 14:41:51'),
(677, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 14:54:29'),
(678, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 14:58:53'),
(679, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:01:00'),
(680, 2, 33, 'rh', 'create', 1, 'Création employé NDAGIJE ALDO GEORGES', '143.105.213.48', '2026-05-13 15:01:54'),
(681, 2, 22, 'access_matrix', 'edit', 43, 'Mise à jour matrice utilisateur #43', '143.105.213.48', '2026-05-13 15:02:04'),
(682, 2, 33, 'rh', 'edit', 1, 'Mise à jour employé NDAGIJE ALDO GEORGES', '143.105.213.48', '2026-05-13 15:03:40'),
(683, 2, 33, 'rh', 'create', 2, 'Création employé NIYIMBONA EMMANUEL', '143.105.213.48', '2026-05-13 15:05:08'),
(684, 2, 33, 'rh', 'create', 3, 'Création employé NDAGIJE MARIAM', '143.105.213.48', '2026-05-13 15:07:55'),
(685, 2, 33, 'rh', 'create', 4, 'Création employé NSENGIYUMVA MARC', '143.105.213.48', '2026-05-13 15:09:09'),
(686, 2, 33, 'rh', 'create', 5, 'Création employé AHISHAKIYE NELLY ANGE', '143.105.213.48', '2026-05-13 15:11:18'),
(687, 2, 33, 'rh', 'create', 6, 'Création employé EMERUSABE DAVID', '143.105.213.48', '2026-05-13 15:14:30'),
(688, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:15:32'),
(689, 2, 33, 'rh', 'create', 7, 'Création employé NIBITANGA FABRICE', '143.105.213.48', '2026-05-13 15:17:17'),
(690, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:17:30'),
(691, 2, 46, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.48', '2026-05-13 15:20:25'),
(692, 2, 33, 'rh', 'create', 8, 'Création employé IRUTAVYOSE AXCEL FERNAND', '143.105.213.48', '2026-05-13 15:21:42'),
(693, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:22:19'),
(694, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:23:00'),
(695, 2, 33, 'rh', 'create', 9, 'Création employé HABONIMANA ANNIELLA', '143.105.213.48', '2026-05-13 15:23:50'),
(696, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:25:14'),
(697, 2, 33, 'rh', 'create', 10, 'Création employé NKORERIMANA EMMANUEL', '143.105.213.48', '2026-05-13 15:26:28'),
(698, 2, 46, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.48', '2026-05-13 15:26:54'),
(699, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:27:37'),
(700, 2, 33, 'rh', 'create', 11, 'Création employé HEZAGIRA AIME ORLY', '143.105.213.48', '2026-05-13 15:27:58'),
(701, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:29:19'),
(702, 2, 33, 'rh', 'create', 12, 'Création employé MANIRAKIZA MICHEL', '143.105.213.48', '2026-05-13 15:30:14'),
(703, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:31:03'),
(704, 2, 33, 'rh', 'edit', 10, 'Mise à jour employé NKORERIMANA EMMANUEL', '143.105.213.48', '2026-05-13 15:32:20'),
(705, 2, 33, 'rh', 'create', 13, 'Création employé DUSHIME KERCY MERVEILLE', '143.105.213.48', '2026-05-13 15:34:22'),
(706, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:35:52'),
(707, 2, 33, 'rh', 'create', 14, 'Création employé NAHIMANA RAMLA', '143.105.213.48', '2026-05-13 15:36:08'),
(708, 2, 33, 'rh', 'create', 15, 'Création employé HABINGABWA GEDEON', '143.105.213.48', '2026-05-13 15:37:59'),
(709, 2, 33, 'rh', 'create', 16, 'Création employé ZEKARIAS RUTH', '143.105.213.48', '2026-05-13 15:39:30'),
(710, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.48', '2026-05-13 15:41:19'),
(711, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:41:26'),
(712, 2, 33, 'rh', 'create', 17, 'Création employé MANIRAMBONA THIERRY', '143.105.213.48', '2026-05-13 15:41:33'),
(713, 2, 33, 'rh', 'create', 18, 'Création employé MINANI MARC', '143.105.213.48', '2026-05-13 15:42:50'),
(714, 2, 46, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.48', '2026-05-13 15:43:57'),
(715, 2, 33, 'rh', 'create', 19, 'Création employé NKURUNZIZA ALEXIS', '143.105.213.48', '2026-05-13 15:44:43'),
(716, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:45:03'),
(717, 2, 33, 'rh', 'create', 20, 'Création employé NKESHIMANA COME', '143.105.213.48', '2026-05-13 15:45:58'),
(718, 2, 33, 'rh', 'create', 21, 'Création employé KWIZERIMANA EMERY', '143.105.213.48', '2026-05-13 15:48:57'),
(719, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:49:32'),
(720, 2, 33, 'rh', 'create', 22, 'Création employé ARAKAZA ARNAUD', '143.105.213.48', '2026-05-13 15:52:08'),
(721, 2, 33, 'rh', 'create', 23, 'Création employé JEANNETTE MOSES', '143.105.213.48', '2026-05-13 15:55:54'),
(722, 2, 33, 'rh', 'create', 24, 'Création employé NIYITEGEKA JACQUES', '143.105.213.48', '2026-05-13 15:57:15'),
(723, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 15:57:36'),
(724, 2, 33, 'rh', 'create', 25, 'Création employé MANIRAGABA SERGES', '143.105.213.48', '2026-05-13 15:59:00'),
(725, 2, 46, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.48', '2026-05-13 16:00:27'),
(726, 2, 33, 'rh', 'create', 26, 'Création employé BUTOYI APOLINAIRE', '143.105.213.48', '2026-05-13 16:00:44'),
(727, 2, 33, 'rh', 'create', 27, 'Création employé HAKIZIMANA CYPRIEN', '143.105.213.48', '2026-05-13 16:03:20'),
(728, 2, 33, 'rh', 'edit', 27, 'Mise à jour employé HAKIZIMANA CYPRIEN', '143.105.213.48', '2026-05-13 16:03:52'),
(729, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 16:06:12'),
(730, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 16:11:45'),
(731, 2, 33, 'rh', 'create', 28, 'Création employé IRAKOZE CLAUDE', '143.105.213.48', '2026-05-13 16:13:24'),
(732, 2, 33, 'rh', 'create', 29, 'Création employé IRAKOZE ALPHA DENARD', '143.105.213.48', '2026-05-13 16:14:31'),
(733, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 16:15:23'),
(734, 2, 33, 'rh', 'create', 30, 'Création employé IGIRUMWETE PISCHON', '143.105.213.48', '2026-05-13 16:15:31'),
(735, 2, 33, 'rh', 'create', 31, 'Création employé MUNEZERO NADIA', '143.105.213.48', '2026-05-13 16:16:33'),
(736, 2, 33, 'rh', 'create', 32, 'Création employé NDUWAYO EMMANUEL', '143.105.213.48', '2026-05-13 16:17:37'),
(737, 2, 33, 'rh', 'create', 33, 'Création employé RUGAMBIRA THOMAS', '143.105.213.48', '2026-05-13 16:19:45'),
(738, 2, 33, 'rh', 'create', 34, 'Création employé NTAKIRUTIMANA EUPHREM', '143.105.213.48', '2026-05-13 16:20:59'),
(739, 2, 33, 'rh', 'create', 35, 'Création employé NSENGIYUMVA SALVATOR', '143.105.213.48', '2026-05-13 16:22:35'),
(740, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 16:23:20'),
(741, 2, 33, 'rh', 'create', 36, 'Création employé NIYONKURU JEAN-DE-DIEU', '143.105.213.48', '2026-05-13 16:23:48'),
(742, 2, 33, 'rh', 'edit', 36, 'Mise à jour employé NIYONKURU JEAN-DE-DIEU', '143.105.213.48', '2026-05-13 16:25:09'),
(743, 2, 33, 'rh', 'create', 37, 'Création employé RUGAMIRA JEAN-MARIE', '143.105.213.48', '2026-05-13 16:29:55'),
(744, 2, 33, 'rh', 'create', 38, 'Création employé BUNUNGUYE LEONCE', '143.105.213.48', '2026-05-13 16:31:04'),
(745, 2, 33, 'rh', 'create', 39, 'Création employé MANIRAMBONA THERENCE', '143.105.213.48', '2026-05-13 16:32:24'),
(746, 2, 33, 'rh', 'create', 40, 'Création employé HAKIZIMANA GRATIEN', '143.105.213.48', '2026-05-13 16:33:32'),
(747, 2, 33, 'rh', 'create', 41, 'Création employé TUYISABE SEVERIN', '143.105.213.48', '2026-05-13 16:34:56'),
(748, 2, 33, 'rh', 'create', 42, 'Création employé UWITEKA WILLY', '143.105.213.48', '2026-05-13 16:36:05'),
(749, 2, 33, 'rh', 'create', 43, 'Création employé IRANKUNDA GENEVIEVE', '143.105.213.48', '2026-05-13 16:37:27'),
(750, 2, 33, 'rh', 'create', 44, 'Création employé NISHIMWE OLIVIER', '143.105.213.48', '2026-05-13 16:38:28'),
(751, 2, 33, 'rh', 'create', 45, 'Création employé INGABIRE ELGA REINE-MARIE', '143.105.213.48', '2026-05-13 16:39:46'),
(752, 2, 33, 'rh', 'create', 46, 'Création employé NDIKUMANA ERIC', '143.105.213.48', '2026-05-13 16:41:20'),
(753, 2, 33, 'rh', 'create', 47, 'Création employé MALULU NDEKO NORBERT', '143.105.213.48', '2026-05-13 16:42:52'),
(754, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 16:47:39'),
(755, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 16:49:45'),
(756, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 16:50:56'),
(757, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.48', '2026-05-13 16:51:49'),
(758, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.48', '2026-05-13 16:52:24'),
(759, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-05-13 17:50:04'),
(760, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.210', '2026-05-13 18:24:53'),
(761, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.210', '2026-05-13 20:40:09'),
(762, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.210', '2026-05-13 20:40:12'),
(763, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.231.210', '2026-05-13 20:51:07'),
(764, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.107', '2026-05-13 23:11:36'),
(765, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '154.73.107.148', '2026-05-14 08:04:35'),
(766, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-05-14 10:19:47'),
(767, 2, 48, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-05-14 16:39:58'),
(768, 2, 48, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '102.134.101.196', '2026-05-14 16:40:12'),
(769, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '102.134.101.196', '2026-05-14 16:40:16'),
(770, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-14 16:40:42'),
(771, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-14 16:56:18'),
(772, 2, 48, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.186', '2026-05-14 20:54:00'),
(773, 2, 48, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.216.186', '2026-05-14 21:04:30'),
(774, 2, 48, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.186', '2026-05-14 21:04:49'),
(775, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.186', '2026-05-14 21:05:21'),
(776, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.186', '2026-05-14 21:08:49'),
(777, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 07:56:50'),
(778, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:34:21'),
(779, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:38:40'),
(780, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:40:45'),
(781, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:40:49'),
(782, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:41:11'),
(783, 2, 22, 'access_matrix', 'edit', 46, 'Mise à jour matrice utilisateur #46', '143.105.213.21', '2026-05-15 08:42:07'),
(784, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:47:41'),
(785, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:47:44'),
(786, 2, 35, 'messages', 'create', 3, 'Envoi d\'un message interne', '143.105.213.21', '2026-05-15 08:50:47'),
(787, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:51:18'),
(788, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:52:47'),
(789, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:56:11'),
(790, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:56:35'),
(791, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:57:06'),
(792, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 08:57:59'),
(793, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:00:28'),
(794, 2, 33, 'rh', 'edit', 39, 'Mise à jour employé MANIRAMBONA THERENCE', '143.105.213.21', '2026-05-15 09:01:15'),
(795, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:02:48'),
(796, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:03:00'),
(797, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:03:10'),
(798, 2, 22, 'access_matrix', 'edit', 38, 'Mise à jour matrice utilisateur #38', '143.105.213.21', '2026-05-15 09:03:18'),
(799, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:04:50'),
(800, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:07:01'),
(801, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.21', '2026-05-15 09:07:44'),
(802, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:11:24'),
(803, 2, 22, 'access_matrix', 'edit', 39, 'Mise à jour matrice utilisateur #39', '143.105.213.21', '2026-05-15 09:11:42'),
(804, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:13:23'),
(805, 2, 22, 'access_matrix', 'edit', 41, 'Mise à jour matrice utilisateur #41', '143.105.213.21', '2026-05-15 09:24:29'),
(806, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:25:16'),
(807, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:42:48'),
(808, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 09:46:22'),
(809, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:08:26'),
(810, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.85', '2026-05-15 10:17:18'),
(811, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:17:19'),
(812, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:23:20'),
(813, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:23:20'),
(814, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:23:20'),
(815, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:26:16'),
(816, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.85', '2026-05-15 10:38:29'),
(817, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:42:24'),
(818, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:42:40'),
(819, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:48:23'),
(820, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:48:26'),
(821, 2, 22, 'access_matrix', 'edit', 44, 'Mise à jour matrice utilisateur #44', '143.105.213.21', '2026-05-15 10:49:07'),
(822, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:49:14'),
(823, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:49:14'),
(824, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:55:55'),
(825, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 10:58:10'),
(826, 2, 22, 'access_matrix', 'edit', 39, 'Mise à jour matrice utilisateur #39', '143.105.213.21', '2026-05-15 11:02:22'),
(827, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:09:44'),
(828, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:14:29'),
(829, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:19:13'),
(830, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:20:21'),
(831, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:24:58'),
(832, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:26:43'),
(833, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.21', '2026-05-15 11:28:57'),
(834, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:42:32'),
(835, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:44:19'),
(836, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:45:25'),
(837, 2, 22, 'access_matrix', 'edit', 37, 'Mise à jour matrice utilisateur #37', '143.105.213.21', '2026-05-15 11:50:03'),
(838, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:58:36'),
(839, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 11:58:40'),
(840, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 12:01:56'),
(841, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 12:03:21'),
(842, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 12:08:30'),
(843, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 12:21:17'),
(844, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.21', '2026-05-15 12:31:03'),
(845, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 12:43:19'),
(846, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 12:48:30'),
(847, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.44', '2026-05-15 13:20:29'),
(848, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 13:28:00'),
(849, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.236', '2026-05-15 13:28:08'),
(850, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 13:34:06'),
(851, 2, 22, 'access_matrix', 'edit', 37, 'Mise à jour matrice utilisateur #37', '143.105.213.236', '2026-05-15 13:34:43'),
(852, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 13:35:11'),
(853, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 13:40:29'),
(854, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.184', '2026-05-15 13:42:49'),
(855, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 13:43:05'),
(856, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '196.2.14.138', '2026-05-15 13:51:44'),
(857, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 13:54:16'),
(858, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 13:56:36'),
(859, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 14:02:10'),
(860, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 14:13:07'),
(861, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 14:22:03'),
(862, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 14:31:16'),
(863, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 14:34:55'),
(864, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 14:35:31'),
(865, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 14:43:22'),
(866, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 14:46:12'),
(867, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 14:55:38'),
(868, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:03:36'),
(869, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:03:38'),
(870, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:03:38'),
(871, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:04:25'),
(872, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:05:44'),
(873, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:07:58'),
(874, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:10:12'),
(875, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:11:02'),
(876, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:11:03'),
(877, 2, 33, 'rh', 'create', 48, 'Création employé NGUMIJAMAHORO PRINCE JOHNSON', '143.105.213.236', '2026-05-15 15:11:24'),
(878, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:13:39'),
(879, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.236', '2026-05-15 15:18:30'),
(880, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:19:45'),
(881, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:24:45'),
(882, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:29:25'),
(883, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:30:28'),
(884, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:37:26'),
(885, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:40:54'),
(886, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:42:43'),
(887, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:46:36'),
(888, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 15:50:13'),
(889, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 16:03:49'),
(890, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 16:05:48'),
(891, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 16:06:35'),
(892, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 16:14:50'),
(893, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.236', '2026-05-15 16:21:11'),
(894, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.226.81', '2026-05-16 22:19:54'),
(895, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.226.81', '2026-05-16 22:21:08'),
(896, 2, 48, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.226.81', '2026-05-16 22:21:14'),
(897, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.192.186', '2026-05-16 22:34:36'),
(898, 2, 45, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.192.186', '2026-05-16 22:35:24'),
(899, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.192.186', '2026-05-16 22:35:58'),
(900, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.165', '2026-05-17 12:08:27'),
(901, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.183', '2026-05-17 19:53:02'),
(902, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '197.157.195.201', '2026-05-17 20:00:02'),
(903, 2, 48, 'auth', 'login', NULL, 'Connexion utilisateur', '197.157.195.201', '2026-05-17 20:00:10'),
(904, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.193.128', '2026-05-18 08:28:12'),
(905, 2, 45, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.193.128', '2026-05-18 08:29:01'),
(906, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.193.128', '2026-05-18 08:29:07'),
(907, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 08:46:29'),
(908, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 08:57:58'),
(909, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:03:39'),
(910, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:09:23'),
(911, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:16:04'),
(912, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:16:55'),
(913, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:18:04'),
(914, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:18:04'),
(915, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:18:04'),
(916, 2, 22, 'access_matrix', 'edit', 44, 'Mise à jour matrice utilisateur #44', '143.105.213.109', '2026-05-18 09:21:15'),
(917, 2, 22, 'access_matrix', 'edit', 44, 'Mise à jour matrice utilisateur #44', '143.105.213.109', '2026-05-18 09:22:43'),
(918, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:25:52'),
(919, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:33:03'),
(920, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:33:47'),
(921, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:40:42'),
(922, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:43:43'),
(923, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:44:06'),
(924, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.84', '2026-05-18 09:45:56'),
(925, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:51:06'),
(926, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 09:55:14'),
(927, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:00:41'),
(928, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:01:25'),
(929, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:01:44'),
(930, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:02:15');
INSERT INTO `activity_logs` (`id`, `company_id`, `user_id`, `module_name`, `action_name`, `entity_id`, `description`, `ip_address`, `created_at`) VALUES
(931, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:02:16'),
(932, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:04:13'),
(933, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:05:24'),
(934, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:07:20'),
(935, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.219', '2026-05-18 10:08:07'),
(936, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:09:57'),
(937, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.13', '2026-05-18 10:12:33'),
(938, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:13:02'),
(939, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:14:15'),
(940, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:18:05'),
(941, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:27:00'),
(942, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:28:23'),
(943, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.132', '2026-05-18 10:41:46'),
(944, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:46:45'),
(945, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:52:12'),
(946, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 10:52:12'),
(947, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 11:00:19'),
(948, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 11:00:19'),
(949, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 11:12:22'),
(950, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 11:29:56'),
(951, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 11:30:36'),
(952, 2, 33, 'rh', 'create', 49, 'Création employé TUYISHIME PROVIDENCE', '143.105.213.109', '2026-05-18 11:32:34'),
(953, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.117', '2026-05-18 11:33:06'),
(954, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.109', '2026-05-18 11:34:07'),
(955, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 11:45:51'),
(956, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 12:21:52'),
(957, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.109', '2026-05-18 12:22:51'),
(958, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 12:22:54'),
(959, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 12:28:05'),
(960, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.109', '2026-05-18 12:35:07'),
(961, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 12:35:26'),
(962, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.109', '2026-05-18 12:43:09'),
(963, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 12:55:06'),
(964, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 12:59:51'),
(965, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 13:13:12'),
(966, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 13:29:27'),
(967, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 13:48:59'),
(968, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 13:49:35'),
(969, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 13:49:36'),
(970, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 13:54:40'),
(971, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 14:00:17'),
(972, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 14:00:59'),
(973, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 14:21:48'),
(974, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 14:29:08'),
(975, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 14:35:10'),
(976, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 14:45:18'),
(977, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 14:45:18'),
(978, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 14:45:19'),
(979, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 15:03:33'),
(980, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 16:06:44'),
(981, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 16:30:10'),
(982, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 16:40:59'),
(983, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 16:49:53'),
(984, 2, 30, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 16:59:49'),
(985, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 17:01:46'),
(986, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 17:01:47'),
(987, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.109', '2026-05-18 17:02:16'),
(988, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.143', '2026-05-18 22:52:30'),
(989, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.83', '2026-05-19 03:20:53'),
(990, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.229.83', '2026-05-19 03:23:46'),
(991, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.159', '2026-05-19 09:07:22'),
(992, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.159', '2026-05-19 09:07:24'),
(993, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.159', '2026-05-19 09:11:27'),
(994, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.159', '2026-05-19 09:13:38'),
(995, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.159', '2026-05-19 09:15:17'),
(996, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.159', '2026-05-19 09:16:50'),
(997, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.159', '2026-05-19 09:18:02'),
(998, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.192.75', '2026-05-19 09:36:28'),
(999, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 09:53:32'),
(1000, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:00:11'),
(1001, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:03:49'),
(1002, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:08:30'),
(1003, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:11:58'),
(1004, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:12:01'),
(1005, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.95', '2026-05-19 10:12:40'),
(1006, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:17:08'),
(1007, 2, 47, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:33:21'),
(1008, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:45:39'),
(1009, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:50:47'),
(1010, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:52:34'),
(1011, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 10:54:15'),
(1012, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.95', '2026-05-19 10:59:46'),
(1013, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:00:11'),
(1014, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:06:45'),
(1015, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:06:45'),
(1016, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:10:21'),
(1017, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:14:42'),
(1018, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:17:54'),
(1019, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:18:15'),
(1020, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:18:16'),
(1021, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:18:53'),
(1022, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:20:30'),
(1023, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:24:09'),
(1024, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:25:55'),
(1025, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:25:59'),
(1026, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:29:55'),
(1027, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:30:17'),
(1028, 2, 29, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.114', '2026-05-19 11:31:08'),
(1029, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:31:22'),
(1030, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:32:05'),
(1031, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:35:02'),
(1032, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:35:13'),
(1033, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:37:09'),
(1034, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:38:14'),
(1035, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:38:34'),
(1036, 2, 22, 'access_matrix', 'edit', 29, 'Mise à jour matrice utilisateur #29', '143.105.213.114', '2026-05-19 11:40:36'),
(1037, 2, 22, 'users', 'edit', 33, 'Mise à jour utilisateur malulu@satracoconstruction.com', '143.105.213.114', '2026-05-19 11:45:05'),
(1038, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:45:29'),
(1039, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:48:21'),
(1040, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:51:05'),
(1041, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:54:49'),
(1042, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 11:54:49'),
(1043, 2, 33, 'documents', 'create', 1, 'Ajout document RESSOURCES HUMAINES', '143.105.213.114', '2026-05-19 11:59:10'),
(1044, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 12:04:16'),
(1045, 2, 33, 'documents', 'create', 2, 'Ajout document Présences hebdomadaires des employés', '143.105.213.114', '2026-05-19 12:07:09'),
(1046, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.114', '2026-05-19 12:12:54'),
(1047, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 12:18:37'),
(1048, 2, 33, 'documents', 'create', 3, 'Ajout document Mouvement des employés', '143.105.213.114', '2026-05-19 12:19:44'),
(1049, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.114', '2026-05-19 12:20:15'),
(1050, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 12:41:57'),
(1051, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 12:45:19'),
(1052, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 12:46:17'),
(1053, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 12:47:11'),
(1054, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 12:48:19'),
(1055, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 12:48:47'),
(1056, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 12:50:47'),
(1057, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 12:55:57'),
(1058, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 13:02:02'),
(1059, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 13:33:32'),
(1060, 2, 46, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.114', '2026-05-19 13:34:27'),
(1061, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 13:34:49'),
(1062, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 13:35:18'),
(1063, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 13:36:41'),
(1064, 2, 46, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.114', '2026-05-19 13:38:35'),
(1065, 2, 27, 'messages', 'read', 3, 'Lecture d\'un message interne', '143.105.213.114', '2026-05-19 13:39:49'),
(1066, 2, 27, 'messages', 'read', 2, 'Lecture d\'un message interne', '143.105.213.114', '2026-05-19 13:40:19'),
(1067, 2, 27, 'messages', 'read', 1, 'Lecture d\'un message interne', '143.105.213.114', '2026-05-19 13:40:31'),
(1068, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 14:03:23'),
(1069, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 14:09:58'),
(1070, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 14:17:47'),
(1071, 2, 22, 'users', 'create', 49, 'Création utilisateur olivier@satracoconstruction.com', '143.105.213.114', '2026-05-19 14:18:59'),
(1072, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 14:54:39'),
(1073, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 14:56:38'),
(1074, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 14:57:21'),
(1075, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 14:57:21'),
(1076, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.114', '2026-05-19 14:59:26'),
(1077, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.148', '2026-05-19 15:05:22'),
(1078, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 15:08:42'),
(1079, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 15:24:32'),
(1080, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 15:29:21'),
(1081, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.86', '2026-05-19 15:31:43'),
(1082, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 15:40:32'),
(1083, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 15:45:33'),
(1084, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 15:45:42'),
(1085, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 16:11:44'),
(1086, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 16:13:27'),
(1087, 2, 22, 'access_matrix', 'edit', 27, 'Mise à jour matrice utilisateur #27', '143.105.213.86', '2026-05-19 16:14:11'),
(1088, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 16:14:52'),
(1089, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 16:27:43'),
(1090, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.86', '2026-05-19 16:33:59'),
(1091, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.85', '2026-05-20 07:51:41'),
(1092, 2, 44, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.194.85', '2026-05-20 07:52:04'),
(1093, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 07:54:25'),
(1094, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 08:44:30'),
(1095, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.52', '2026-05-20 08:52:42'),
(1096, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 08:57:34'),
(1097, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:00:29'),
(1098, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:01:47'),
(1099, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:05:01'),
(1100, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:05:22'),
(1101, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.55', '2026-05-20 09:06:18'),
(1102, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:09:44'),
(1103, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:11:22'),
(1104, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:11:56'),
(1105, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:12:07'),
(1106, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:16:57'),
(1107, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:19:14'),
(1108, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:23:56'),
(1109, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:24:00'),
(1110, 2, 22, 'access_matrix', 'edit', 46, 'Mise à jour matrice utilisateur #46', '143.105.213.55', '2026-05-20 09:24:59'),
(1111, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.55', '2026-05-20 09:29:44'),
(1112, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.158', '2026-05-20 09:34:59'),
(1113, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.98', '2026-05-20 09:38:35'),
(1114, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.158', '2026-05-20 09:41:28'),
(1115, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.158', '2026-05-20 09:42:36'),
(1116, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.104', '2026-05-20 10:01:00'),
(1117, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.52', '2026-05-20 10:03:46'),
(1118, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.158', '2026-05-20 10:08:18'),
(1119, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.241', '2026-05-20 10:21:17'),
(1120, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.241', '2026-05-20 10:31:13'),
(1121, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.158', '2026-05-20 10:36:31'),
(1122, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-20 10:42:28'),
(1123, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.158', '2026-05-20 10:48:08'),
(1124, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.158', '2026-05-20 10:57:32'),
(1125, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.66', '2026-05-20 10:58:21'),
(1126, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-20 11:34:57'),
(1127, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-20 12:05:44'),
(1128, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.236.233', '2026-05-20 12:05:55'),
(1129, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-20 12:06:00'),
(1130, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.74', '2026-05-20 12:10:20'),
(1131, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-20 12:13:07'),
(1132, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-20 12:49:18'),
(1133, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-20 12:51:19'),
(1134, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.217', '2026-05-20 13:18:50'),
(1135, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-20 13:29:07'),
(1136, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-20 13:48:58'),
(1137, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.193.1', '2026-05-20 14:00:45'),
(1138, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.193.1', '2026-05-20 14:00:52'),
(1139, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-20 14:17:03'),
(1140, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 14:20:08'),
(1141, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 14:26:57'),
(1142, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 14:27:13'),
(1143, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 14:43:41'),
(1144, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 14:43:41'),
(1145, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 14:44:44'),
(1146, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 14:52:26'),
(1147, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 14:52:26'),
(1148, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 14:56:56'),
(1149, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:06:40'),
(1150, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:07:32'),
(1151, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:11:36'),
(1152, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:12:41'),
(1153, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:13:54'),
(1154, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:16:13'),
(1155, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:17:54'),
(1156, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:21:43'),
(1157, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-20 15:38:46'),
(1158, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:43:43'),
(1159, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:43:44'),
(1160, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:56:19'),
(1161, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 15:57:11'),
(1162, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 16:04:23'),
(1163, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 16:10:36'),
(1164, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.230', '2026-05-20 16:12:54'),
(1165, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.48', '2026-05-20 21:50:08'),
(1166, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.48', '2026-05-20 21:51:08'),
(1167, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.48', '2026-05-20 21:57:06'),
(1168, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '154.117.231.48', '2026-05-20 21:57:51'),
(1169, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:38:23'),
(1170, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:41:05'),
(1171, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:42:26'),
(1172, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:44:54'),
(1173, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:45:00'),
(1174, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:46:00'),
(1175, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:47:13'),
(1176, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:47:14'),
(1177, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:47:40'),
(1178, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:49:02'),
(1179, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:49:08'),
(1180, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:50:03'),
(1181, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:51:34'),
(1182, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 08:57:29'),
(1183, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 09:12:05'),
(1184, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 09:15:16'),
(1185, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 09:17:54'),
(1186, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 09:17:54'),
(1187, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 09:18:23'),
(1188, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 09:28:33'),
(1189, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 09:30:46'),
(1190, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.168', '2026-05-21 09:43:27'),
(1191, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 10:19:12'),
(1192, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 10:21:33'),
(1193, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-21 10:40:42'),
(1194, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-21 10:40:49'),
(1195, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-21 10:41:04'),
(1196, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 10:51:41'),
(1197, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-21 11:06:08'),
(1198, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 11:28:55'),
(1199, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 11:35:32'),
(1200, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 11:38:30'),
(1201, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 11:39:48'),
(1202, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 11:41:54'),
(1203, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 11:42:08'),
(1204, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 11:47:53'),
(1205, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-21 12:01:08'),
(1206, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-21 12:11:13'),
(1207, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 12:15:38'),
(1208, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 12:19:17'),
(1209, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 12:21:41'),
(1210, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 12:23:07'),
(1211, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.95', '2026-05-21 12:23:59'),
(1212, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 12:29:09'),
(1213, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 12:29:49'),
(1214, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 12:48:13'),
(1215, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 12:56:32'),
(1216, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.95', '2026-05-21 12:58:16'),
(1217, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-21 12:59:19'),
(1218, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-21 12:59:20'),
(1219, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 14:00:49'),
(1220, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 14:02:02'),
(1221, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-21 14:05:42'),
(1222, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-05-21 14:21:11'),
(1223, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 14:27:19'),
(1224, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.95', '2026-05-21 14:32:59'),
(1225, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.94', '2026-05-21 14:55:20'),
(1226, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-21 15:00:00'),
(1227, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-21 15:17:26'),
(1228, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-21 15:19:52'),
(1229, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-21 15:26:02'),
(1230, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-21 16:10:46'),
(1231, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-21 16:10:48'),
(1232, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-21 16:37:49'),
(1233, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.115', '2026-05-21 16:38:41'),
(1234, 2, 24, 'auth', 'login', NULL, 'Connexion utilisateur', '154.74.175.15', '2026-05-21 16:44:42'),
(1235, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.218', '2026-05-21 17:07:59'),
(1236, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.218', '2026-05-21 17:08:00'),
(1237, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.218', '2026-05-21 18:06:28'),
(1238, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.226.108', '2026-05-21 19:06:14'),
(1239, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.218', '2026-05-22 08:27:42'),
(1240, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.218', '2026-05-22 08:27:46'),
(1241, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.70', '2026-05-22 08:52:17'),
(1242, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.70', '2026-05-22 08:54:16'),
(1243, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.70', '2026-05-22 09:03:12'),
(1244, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.70', '2026-05-22 09:03:53'),
(1245, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-22 09:16:17'),
(1246, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-22 09:22:15'),
(1247, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-22 09:22:16'),
(1248, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-22 09:22:47'),
(1249, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.233', '2026-05-22 09:24:02'),
(1250, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 10:05:21'),
(1251, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.226', '2026-05-22 10:10:30'),
(1252, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.226', '2026-05-22 10:10:31'),
(1253, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 11:49:15'),
(1254, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.167', '2026-05-22 12:08:09'),
(1255, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 12:23:42'),
(1256, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 12:28:23'),
(1257, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 12:28:36'),
(1258, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 12:35:33'),
(1259, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 12:50:46'),
(1260, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.15', '2026-05-22 13:06:36'),
(1261, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 13:12:06'),
(1262, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.15', '2026-05-22 13:12:38'),
(1263, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 13:13:36'),
(1264, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 13:21:18'),
(1265, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 13:27:08'),
(1266, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 13:34:36'),
(1267, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.224.163', '2026-05-22 13:37:36'),
(1268, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.226', '2026-05-22 13:39:35'),
(1269, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.224.163', '2026-05-22 13:41:34'),
(1270, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 13:54:12'),
(1271, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 14:10:40'),
(1272, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 14:10:52'),
(1273, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 14:11:37'),
(1274, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 14:11:38'),
(1275, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 14:13:03'),
(1276, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 14:15:48'),
(1277, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 14:30:51'),
(1278, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 14:51:10'),
(1279, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.245', '2026-05-22 14:51:59'),
(1280, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.212.36', '2026-05-22 15:48:24'),
(1281, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.245', '2026-05-22 15:48:36'),
(1282, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.100', '2026-05-22 16:52:15'),
(1283, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.89', '2026-05-25 08:42:19'),
(1284, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.89', '2026-05-25 08:42:20'),
(1285, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.89', '2026-05-25 08:42:21'),
(1286, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.89', '2026-05-25 08:46:58'),
(1287, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.89', '2026-05-25 08:50:51'),
(1288, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.89', '2026-05-25 08:51:07'),
(1289, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.89', '2026-05-25 08:51:07'),
(1290, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.242', '2026-05-25 09:09:40'),
(1291, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.31', '2026-05-25 09:11:35'),
(1292, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.232.119', '2026-05-25 10:13:45'),
(1293, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.212.36', '2026-05-25 10:14:39'),
(1294, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 10:14:40'),
(1295, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.232.119', '2026-05-25 10:17:40'),
(1296, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.212.36', '2026-05-25 11:15:32'),
(1297, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 11:17:34'),
(1298, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.212.36', '2026-05-25 11:50:06'),
(1299, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 11:57:38'),
(1300, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 12:19:11'),
(1301, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 12:37:53'),
(1302, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 13:04:04'),
(1303, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 13:21:26'),
(1304, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 13:28:24'),
(1305, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 13:43:08'),
(1306, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.212.36', '2026-05-25 13:58:05'),
(1307, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 14:14:10'),
(1308, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.113', '2026-05-25 14:20:56'),
(1309, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 14:29:41'),
(1310, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 14:41:41'),
(1311, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 14:42:32'),
(1312, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 14:42:34'),
(1313, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 14:46:58'),
(1314, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 14:47:01'),
(1315, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 14:47:03'),
(1316, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 14:55:40'),
(1317, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 15:48:27'),
(1318, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 15:54:06'),
(1319, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.202', '2026-05-25 16:17:24'),
(1320, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 16:22:06'),
(1321, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.4', '2026-05-25 16:56:37'),
(1322, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 07:56:01'),
(1323, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 09:00:33'),
(1324, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 09:01:36'),
(1325, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 09:05:53'),
(1326, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.178', '2026-05-26 09:07:31'),
(1327, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.178', '2026-05-26 09:08:43'),
(1328, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.178', '2026-05-26 09:08:56'),
(1329, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.178', '2026-05-26 09:09:05'),
(1330, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 09:16:58'),
(1331, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 09:27:30'),
(1332, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 09:29:20'),
(1333, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 09:30:37'),
(1334, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 09:38:44'),
(1335, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.50', '2026-05-26 09:40:45'),
(1336, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 09:55:20'),
(1337, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.81', '2026-05-26 10:10:05'),
(1338, 2, 48, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 10:10:21'),
(1339, 2, 48, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.81', '2026-05-26 10:16:30'),
(1340, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 10:16:32'),
(1341, 2, 22, 'access_matrix', 'edit', 45, 'Mise à jour matrice utilisateur #45', '143.105.213.81', '2026-05-26 10:19:57'),
(1342, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 10:19:59'),
(1343, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 10:44:13'),
(1344, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.81', '2026-05-26 10:48:21'),
(1345, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.50', '2026-05-26 10:58:25'),
(1346, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 11:09:21'),
(1347, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 11:19:54'),
(1348, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 11:36:36'),
(1349, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 12:07:55'),
(1350, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 12:16:21'),
(1351, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 12:43:12'),
(1352, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 13:04:19'),
(1353, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 13:16:09'),
(1354, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 13:22:58'),
(1355, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 13:39:41'),
(1356, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 13:40:34'),
(1357, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 13:49:06'),
(1358, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 14:04:48'),
(1359, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 14:11:08'),
(1360, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 14:41:43'),
(1361, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 15:12:07'),
(1362, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 15:17:00'),
(1363, 2, 27, 'purchase_requests', 'create', 43, 'Création demande d\'achat MANIRAGABA SERGES', '143.105.213.94', '2026-05-26 15:17:02'),
(1364, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 15:19:57'),
(1365, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 15:19:57'),
(1366, 2, 27, 'purchase_requests', 'create', 44, 'Création demande d\'achat MANIRAGABA SERGES', '143.105.213.94', '2026-05-26 15:20:45'),
(1367, 2, 27, 'purchase_requests', 'create', 45, 'Création demande d\'achat MANIRAGABA SERGES', '143.105.213.94', '2026-05-26 15:26:03'),
(1368, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.94', '2026-05-26 16:36:42'),
(1369, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '41.82.207.112', '2026-05-28 02:33:56'),
(1370, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 08:48:43'),
(1371, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 08:51:49'),
(1372, 2, 22, 'access_matrix', 'edit', 47, 'Mise à jour matrice utilisateur #47', '143.105.213.162', '2026-05-28 08:52:35'),
(1373, 2, 22, 'access_matrix', 'edit', 49, 'Mise à jour matrice utilisateur #49', '143.105.213.162', '2026-05-28 08:53:20'),
(1374, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 08:54:16'),
(1375, 2, 22, 'access_matrix', 'edit', 49, 'Mise à jour matrice utilisateur #49', '143.105.213.162', '2026-05-28 08:55:26'),
(1376, 2, 22, 'access_matrix', 'edit', 49, 'Mise à jour matrice utilisateur #49', '143.105.213.162', '2026-05-28 09:01:11'),
(1377, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 09:16:17'),
(1378, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.162', '2026-05-28 09:24:50'),
(1379, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 09:36:26'),
(1380, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 10:20:33'),
(1381, 2, 22, 'users', 'edit', 49, 'Mise à jour utilisateur olivier@satracoconstruction.com', '143.105.213.162', '2026-05-28 10:21:28'),
(1382, 2, 49, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 10:23:36'),
(1383, 2, 22, 'access_matrix', 'edit', 49, 'Mise à jour matrice utilisateur #49', '143.105.213.162', '2026-05-28 10:25:29'),
(1384, 2, 49, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 10:30:34'),
(1385, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 10:30:48'),
(1386, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 11:06:16'),
(1387, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 11:24:32'),
(1388, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 12:12:24'),
(1389, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 12:17:07'),
(1390, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 12:17:51'),
(1391, 2, 22, 'access_matrix', 'edit', 23, 'Mise à jour matrice utilisateur #23', '143.105.213.162', '2026-05-28 12:17:55'),
(1392, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 12:23:20'),
(1393, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 12:32:26'),
(1394, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 12:32:54'),
(1395, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 12:42:48'),
(1396, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 12:44:15'),
(1397, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 12:52:28'),
(1398, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 13:02:39'),
(1399, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 13:04:04'),
(1400, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 13:20:59'),
(1401, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 13:27:43'),
(1402, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 13:35:26'),
(1403, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 13:40:59'),
(1404, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 13:49:26'),
(1405, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 13:50:12'),
(1406, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 14:01:45'),
(1407, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 14:14:12'),
(1408, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 14:19:30'),
(1409, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 14:39:12'),
(1410, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 14:44:07'),
(1411, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 14:45:28');
INSERT INTO `activity_logs` (`id`, `company_id`, `user_id`, `module_name`, `action_name`, `entity_id`, `description`, `ip_address`, `created_at`) VALUES
(1412, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.153', '2026-05-28 15:04:38'),
(1413, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 15:42:57'),
(1414, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.162', '2026-05-28 17:14:47'),
(1415, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.23', '2026-05-28 18:41:38'),
(1416, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 08:35:19'),
(1417, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 08:38:33'),
(1418, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 08:40:30'),
(1419, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 08:40:35'),
(1420, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 08:47:11'),
(1421, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 08:55:04'),
(1422, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 08:55:04'),
(1423, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 08:55:04'),
(1424, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.109', '2026-05-29 08:56:03'),
(1425, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 09:01:09'),
(1426, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 09:01:10'),
(1427, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 09:01:10'),
(1428, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.109', '2026-05-29 09:05:47'),
(1429, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 09:07:56'),
(1430, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 09:20:52'),
(1431, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 09:40:16'),
(1432, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 10:07:01'),
(1433, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 10:10:34'),
(1434, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 10:10:58'),
(1435, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 10:44:25'),
(1436, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 10:45:30'),
(1437, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 10:47:26'),
(1438, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 10:53:45'),
(1439, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 10:56:24'),
(1440, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 10:57:42'),
(1441, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 10:58:51'),
(1442, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 11:04:52'),
(1443, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 11:05:43'),
(1444, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 11:32:52'),
(1445, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.12', '2026-05-29 12:13:13'),
(1446, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.222', '2026-05-29 12:40:42'),
(1447, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.222', '2026-05-29 12:40:43'),
(1448, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.222', '2026-05-29 12:42:00'),
(1449, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.222', '2026-05-29 12:53:00'),
(1450, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '41.82.65.1', '2026-05-29 13:12:55'),
(1451, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '41.82.65.1', '2026-05-29 13:13:55'),
(1452, 2, 48, 'auth', 'login', NULL, 'Connexion utilisateur', '41.82.65.1', '2026-05-29 13:14:21'),
(1453, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.102', '2026-05-29 13:52:57'),
(1454, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.102', '2026-05-29 14:00:12'),
(1455, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.102', '2026-05-29 14:00:28'),
(1456, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.102', '2026-05-29 14:02:20'),
(1457, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.222', '2026-05-29 14:10:06'),
(1458, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.222', '2026-05-29 14:38:03'),
(1459, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.150', '2026-05-29 15:23:55'),
(1460, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.150', '2026-05-29 15:25:24'),
(1461, 2, 22, 'projects', 'create', 28, 'Création projet Projet Pave', '143.105.213.150', '2026-05-29 15:28:51'),
(1462, 2, 22, 'projects', 'create', 29, 'Création projet Maramvya Brique Cute', '143.105.213.150', '2026-05-29 15:30:03'),
(1463, 2, 22, 'chantiers', 'create', 23, 'Création chantier Projet Pave', '143.105.213.150', '2026-05-29 15:32:07'),
(1464, 2, 22, 'chantiers', 'create', 24, 'Création chantier Maramvya Brique Cute', '143.105.213.150', '2026-05-29 15:32:53'),
(1465, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.150', '2026-05-29 15:42:21'),
(1466, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.150', '2026-05-29 15:45:37'),
(1467, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.150', '2026-05-29 15:45:38'),
(1468, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.150', '2026-05-29 15:45:38'),
(1469, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.150', '2026-05-29 15:52:50'),
(1470, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.150', '2026-05-29 15:55:57'),
(1471, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.150', '2026-05-29 15:55:59'),
(1472, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.150', '2026-05-29 15:55:59'),
(1473, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '197.231.248.251', '2026-05-30 09:54:40'),
(1474, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.239', '2026-05-30 13:40:19'),
(1475, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.239', '2026-05-30 13:40:26'),
(1476, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 08:58:15'),
(1477, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 09:12:10'),
(1478, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 09:18:39'),
(1479, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 09:21:48'),
(1480, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 09:27:47'),
(1481, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 09:27:57'),
(1482, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 09:29:39'),
(1483, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 09:31:44'),
(1484, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 09:33:02'),
(1485, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 09:52:01'),
(1486, 2, 27, 'purchase_requests', 'create', 46, 'Création demande d\'achat MANIRAGABA SERGES', '143.105.213.111', '2026-06-01 09:53:43'),
(1487, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 10:00:46'),
(1488, 2, 27, 'purchase_requests', 'create', 47, 'Création demande d\'achat MANIRAGABA SERGES', '143.105.213.111', '2026-06-01 10:01:15'),
(1489, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.76', '2026-06-01 10:03:31'),
(1490, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 10:14:20'),
(1491, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 10:36:18'),
(1492, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 10:36:19'),
(1493, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 10:37:52'),
(1494, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 10:49:20'),
(1495, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 11:08:05'),
(1496, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.76', '2026-06-01 11:17:55'),
(1497, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.76', '2026-06-01 11:18:12'),
(1498, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 11:21:29'),
(1499, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 11:25:26'),
(1500, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 11:27:51'),
(1501, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 11:42:19'),
(1502, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 11:51:36'),
(1503, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 12:01:37'),
(1504, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 12:06:03'),
(1505, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.111', '2026-06-01 12:08:03'),
(1506, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 12:27:50'),
(1507, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 13:05:30'),
(1508, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 13:11:02'),
(1509, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.177', '2026-06-01 13:34:53'),
(1510, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 13:52:51'),
(1511, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 14:38:15'),
(1512, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.72', '2026-06-01 14:42:58'),
(1513, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 14:47:16'),
(1514, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 14:48:29'),
(1515, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 14:50:52'),
(1516, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 14:55:16'),
(1517, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 14:56:28'),
(1518, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 14:58:00'),
(1519, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:03:17'),
(1520, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:05:19'),
(1521, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:07:15'),
(1522, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:09:52'),
(1523, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:14:12'),
(1524, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:19:03'),
(1525, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:19:34'),
(1526, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:20:24'),
(1527, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:31:34'),
(1528, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:39:07'),
(1529, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:55:51'),
(1530, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:57:55'),
(1531, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:58:34'),
(1532, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 15:59:27'),
(1533, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:03:35'),
(1534, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.192', '2026-06-01 16:14:50'),
(1535, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:16:02'),
(1536, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:17:19'),
(1537, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:18:35'),
(1538, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:21:00'),
(1539, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:28:55'),
(1540, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:30:00'),
(1541, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:37:43'),
(1542, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:38:34'),
(1543, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:39:23'),
(1544, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 16:43:23'),
(1545, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-01 17:09:51'),
(1546, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 08:44:49'),
(1547, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.178', '2026-06-02 08:47:06'),
(1548, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 08:48:44'),
(1549, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.138', '2026-06-02 08:49:51'),
(1550, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 08:54:26'),
(1551, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 09:29:30'),
(1552, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 09:33:33'),
(1553, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 10:23:52'),
(1554, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.33', '2026-06-02 10:29:31'),
(1555, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.33', '2026-06-02 10:36:26'),
(1556, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 10:38:13'),
(1557, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.92', '2026-06-02 10:45:46'),
(1558, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 10:58:42'),
(1559, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 11:04:32'),
(1560, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 12:05:58'),
(1561, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 12:11:22'),
(1562, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 12:31:51'),
(1563, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 12:36:04'),
(1564, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.236.69', '2026-06-02 13:08:00'),
(1565, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 13:16:25'),
(1566, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 13:32:10'),
(1567, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 13:39:21'),
(1568, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 14:18:30'),
(1569, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.156', '2026-06-02 14:20:29'),
(1570, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.240', '2026-06-02 14:45:03'),
(1571, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.240', '2026-06-02 15:35:43'),
(1572, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.240', '2026-06-02 15:35:53'),
(1573, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.240', '2026-06-02 15:37:12'),
(1574, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-06-03 09:07:36'),
(1575, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-06-03 09:15:41'),
(1576, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-06-03 09:34:51'),
(1577, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.236.99', '2026-06-03 11:22:41'),
(1578, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.236.99', '2026-06-03 11:22:42'),
(1579, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.30', '2026-06-03 11:33:57'),
(1580, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.236.167', '2026-06-03 11:51:28'),
(1581, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.72', '2026-06-03 12:01:58'),
(1582, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.72', '2026-06-03 12:09:30'),
(1583, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.72', '2026-06-03 12:16:58'),
(1584, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.72', '2026-06-03 12:17:13'),
(1585, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-03 12:23:49'),
(1586, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-03 12:38:25'),
(1587, 2, 37, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.28', '2026-06-03 13:18:22'),
(1588, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:00:44'),
(1589, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:02:56'),
(1590, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:03:36'),
(1591, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:07:41'),
(1592, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:16:02'),
(1593, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:19:48'),
(1594, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:19:53'),
(1595, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:20:45'),
(1596, 2, 45, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.237', '2026-06-03 14:23:41'),
(1597, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:23:51'),
(1598, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:23:54'),
(1599, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:26:29'),
(1600, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.22', '2026-06-03 14:33:38'),
(1601, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.22', '2026-06-03 14:38:25'),
(1602, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 14:58:11'),
(1603, 2, 49, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 15:13:07'),
(1604, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 15:17:17'),
(1605, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 16:09:35'),
(1606, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 16:09:35'),
(1607, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 16:09:44'),
(1608, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 16:10:22'),
(1609, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.236.170', '2026-06-03 16:27:01'),
(1610, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 16:50:45'),
(1611, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.237', '2026-06-03 17:03:01'),
(1612, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.236.170', '2026-06-03 20:17:12'),
(1613, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.76', '2026-06-04 08:20:10'),
(1614, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 08:41:01'),
(1615, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 08:44:48'),
(1616, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 09:02:32'),
(1617, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 09:15:02'),
(1618, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 09:34:48'),
(1619, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.244', '2026-06-04 09:44:18'),
(1620, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 09:50:08'),
(1621, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 09:50:09'),
(1622, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 09:50:09'),
(1623, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 09:50:09'),
(1624, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 09:50:09'),
(1625, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.244', '2026-06-04 10:00:39'),
(1626, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:08:59'),
(1627, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:11:04'),
(1628, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:13:22'),
(1629, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:17:17'),
(1630, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:24:36'),
(1631, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:27:03'),
(1632, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:27:04'),
(1633, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:27:04'),
(1634, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:27:05'),
(1635, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:27:05'),
(1636, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 10:45:41'),
(1637, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 11:18:24'),
(1638, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 11:46:44'),
(1639, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 13:05:16'),
(1640, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 13:09:57'),
(1641, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 13:15:45'),
(1642, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.103', '2026-06-04 13:19:09'),
(1643, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-04 13:53:57'),
(1644, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-04 13:56:37'),
(1645, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-04 13:59:02'),
(1646, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-04 14:01:23'),
(1647, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-04 14:05:47'),
(1648, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-04 14:14:38'),
(1649, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-04 14:21:28'),
(1650, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.146', '2026-06-04 14:22:27'),
(1651, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 14:43:07'),
(1652, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 14:48:48'),
(1653, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 15:27:58'),
(1654, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 15:36:26'),
(1655, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 15:36:28'),
(1656, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 15:44:20'),
(1657, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 15:48:33'),
(1658, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 15:48:38'),
(1659, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 15:49:25'),
(1660, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 16:01:07'),
(1661, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-04 16:04:14'),
(1662, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 08:36:41'),
(1663, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 08:42:03'),
(1664, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 08:51:37'),
(1665, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 09:06:56'),
(1666, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 09:28:40'),
(1667, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.67', '2026-06-05 09:29:35'),
(1668, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 09:30:33'),
(1669, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 09:31:46'),
(1670, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 09:53:34'),
(1671, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 09:54:41'),
(1672, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 09:57:16'),
(1673, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 09:57:21'),
(1674, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.67', '2026-06-05 10:11:31'),
(1675, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.194', '2026-06-05 10:11:53'),
(1676, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.67', '2026-06-05 10:27:28'),
(1677, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 11:09:07'),
(1678, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 11:23:38'),
(1679, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.52', '2026-06-05 11:28:33'),
(1680, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 11:34:10'),
(1681, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.11', '2026-06-05 11:36:32'),
(1682, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 11:38:29'),
(1683, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 11:38:29'),
(1684, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 11:41:14'),
(1685, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 12:26:57'),
(1686, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 12:38:53'),
(1687, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 12:43:08'),
(1688, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 12:59:00'),
(1689, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 12:59:00'),
(1690, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 13:00:21'),
(1691, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 13:03:07'),
(1692, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 13:26:56'),
(1693, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 14:00:26'),
(1694, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 14:04:44'),
(1695, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 14:04:44'),
(1696, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 14:44:56'),
(1697, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 14:47:58'),
(1698, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 14:48:24'),
(1699, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 14:52:15'),
(1700, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 15:09:56'),
(1701, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 15:32:02'),
(1702, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 15:34:50'),
(1703, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.249', '2026-06-05 15:38:19'),
(1704, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.25', '2026-06-06 11:22:47'),
(1705, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.103', '2026-06-08 12:45:05'),
(1706, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.219.209', '2026-06-08 14:26:55'),
(1707, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.219.209', '2026-06-08 14:27:51'),
(1708, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.219.209', '2026-06-08 14:29:51'),
(1709, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.219.209', '2026-06-08 14:29:53'),
(1710, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.219.209', '2026-06-08 14:29:56'),
(1711, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 08:45:06'),
(1712, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.189', '2026-06-09 08:52:28'),
(1713, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 08:52:41'),
(1714, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 08:54:13'),
(1715, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 09:34:28'),
(1716, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 09:54:23'),
(1717, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 10:09:15'),
(1718, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 10:21:54'),
(1719, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 10:26:18'),
(1720, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 10:27:54'),
(1721, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 10:33:05'),
(1722, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 11:05:05'),
(1723, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 11:30:15'),
(1724, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 11:32:28'),
(1725, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 12:06:56'),
(1726, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 12:48:49'),
(1727, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 13:03:03'),
(1728, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 13:23:52'),
(1729, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 13:31:07'),
(1730, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 13:41:04'),
(1731, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 13:43:09'),
(1732, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 14:01:23'),
(1733, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 14:02:22'),
(1734, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 14:03:13'),
(1735, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 14:12:42'),
(1736, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 14:25:05'),
(1737, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 14:34:27'),
(1738, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 14:51:06'),
(1739, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.178', '2026-06-09 15:30:03'),
(1740, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.132', '2026-06-10 08:37:11'),
(1741, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.132', '2026-06-10 08:37:19'),
(1742, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.135', '2026-06-10 08:44:55'),
(1743, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.135', '2026-06-10 08:46:11'),
(1744, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 08:49:20'),
(1745, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 08:51:05'),
(1746, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 08:58:14'),
(1747, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 09:07:32'),
(1748, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 09:29:13'),
(1749, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 10:30:14'),
(1750, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 10:36:15'),
(1751, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 10:57:46'),
(1752, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 11:24:35'),
(1753, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 11:25:15'),
(1754, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 11:28:45'),
(1755, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 11:32:26'),
(1756, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 11:32:34'),
(1757, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 11:36:54'),
(1758, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 11:44:26'),
(1759, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 11:51:10'),
(1760, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 11:51:28'),
(1761, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 11:56:40'),
(1762, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 12:07:03'),
(1763, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 12:07:30'),
(1764, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 12:08:07'),
(1765, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 12:09:01'),
(1766, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 12:21:44'),
(1767, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 13:57:02'),
(1768, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 14:15:59'),
(1769, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 14:18:15'),
(1770, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 14:20:13'),
(1771, 2, 33, 'rh', 'create', 50, 'Création employé NIYONZIMA GILBERT', '143.105.213.87', '2026-06-10 14:20:35'),
(1772, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.87', '2026-06-10 14:22:06'),
(1773, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 14:48:10'),
(1774, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 14:54:27'),
(1775, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 15:02:42'),
(1776, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 15:16:12'),
(1777, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 15:25:35'),
(1778, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.87', '2026-06-10 15:28:08'),
(1779, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 16:06:20'),
(1780, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.87', '2026-06-10 17:05:36'),
(1781, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 07:55:33'),
(1782, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 08:47:08'),
(1783, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 08:53:48'),
(1784, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 08:59:59'),
(1785, 2, 22, 'projects', 'create', 30, 'Création projet Bloque Ciment', '143.105.213.207', '2026-06-11 09:03:06'),
(1786, 2, 22, 'chantiers', 'create', 25, 'Création chantier Bloque Ciment', '143.105.213.207', '2026-06-11 09:03:38'),
(1787, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 09:15:54'),
(1788, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 09:18:36'),
(1789, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 09:19:47'),
(1790, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.219.226', '2026-06-11 09:24:53'),
(1791, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.10', '2026-06-11 09:26:27'),
(1792, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 09:40:31'),
(1793, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 09:46:03'),
(1794, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 10:00:40'),
(1795, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 10:05:36'),
(1796, 2, 39, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.207', '2026-06-11 10:05:52'),
(1797, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 10:05:55'),
(1798, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 10:33:53'),
(1799, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 10:47:08'),
(1800, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 10:47:14'),
(1801, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 10:50:16'),
(1802, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 11:18:28'),
(1803, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 11:26:10'),
(1804, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.2', '2026-06-11 12:13:29'),
(1805, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 12:36:26'),
(1806, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.207', '2026-06-11 12:36:40'),
(1807, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 12:41:35'),
(1808, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 12:53:56'),
(1809, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 12:53:56'),
(1810, 2, 48, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.2', '2026-06-11 12:55:24'),
(1811, NULL, 1, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.2', '2026-06-11 12:55:43'),
(1812, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 13:58:03'),
(1813, 2, 22, 'projects', 'create', 31, 'Création projet Consultance', '143.105.213.207', '2026-06-11 14:01:57'),
(1814, 2, 22, 'chantiers', 'create', 26, 'Création chantier Consultance', '143.105.213.207', '2026-06-11 14:02:24'),
(1815, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 14:04:09'),
(1816, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 14:23:50'),
(1817, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 14:34:28'),
(1818, 2, 25, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.207', '2026-06-11 14:35:14'),
(1819, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-11 14:36:18'),
(1820, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 14:50:14'),
(1821, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 14:50:26'),
(1822, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 14:52:03'),
(1823, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 14:53:59'),
(1824, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 14:55:24'),
(1825, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 14:57:04'),
(1826, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 14:58:44'),
(1827, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:00:54'),
(1828, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:03:30'),
(1829, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:28:53'),
(1830, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:36:28'),
(1831, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.149', '2026-06-11 15:41:03'),
(1832, 2, 49, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:42:11'),
(1833, 2, 49, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.149', '2026-06-11 15:42:40'),
(1834, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:42:48'),
(1835, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.149', '2026-06-11 15:44:29'),
(1836, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:45:40'),
(1837, 2, 41, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.149', '2026-06-11 15:50:06'),
(1838, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:51:31'),
(1839, 2, 28, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.149', '2026-06-11 15:58:24'),
(1840, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:58:28'),
(1841, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:58:47'),
(1842, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 15:59:34'),
(1843, 2, 22, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.149', '2026-06-11 16:08:16'),
(1844, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 16:09:51'),
(1845, 2, 28, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.149', '2026-06-11 16:23:34'),
(1846, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 16:23:38'),
(1847, 2, 22, 'backups', 'create', NULL, 'Génération backup ZIP + SQL', '143.105.213.149', '2026-06-11 16:24:19'),
(1848, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.149', '2026-06-11 16:26:16'),
(1849, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-11 16:40:21'),
(1850, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-11 17:22:51'),
(1851, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 07:59:22'),
(1852, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 08:36:04'),
(1853, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 08:46:16'),
(1854, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 08:59:20'),
(1855, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 09:01:48'),
(1856, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 09:08:08'),
(1857, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 09:10:09'),
(1858, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 09:12:11'),
(1859, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 09:52:59'),
(1860, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 10:09:03'),
(1861, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 10:14:00'),
(1862, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 10:17:47'),
(1863, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 10:23:51'),
(1864, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 10:24:07'),
(1865, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 10:31:59'),
(1866, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 10:35:05'),
(1867, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 11:40:13'),
(1868, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 11:42:21'),
(1869, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 11:53:05'),
(1870, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:02:46'),
(1871, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:03:14'),
(1872, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:03:32'),
(1873, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:18:55'),
(1874, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:35:48'),
(1875, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:35:49'),
(1876, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:36:56'),
(1877, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:48:42'),
(1878, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:50:16'),
(1879, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:51:27'),
(1880, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.42', '2026-06-12 12:54:59'),
(1881, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.217', '2026-06-12 13:47:49'),
(1882, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.217.110', '2026-06-12 14:10:08'),
(1883, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.219.99', '2026-06-12 14:18:45'),
(1884, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.176', '2026-06-12 15:11:42'),
(1885, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.176', '2026-06-12 15:28:46'),
(1886, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 08:44:43'),
(1887, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 08:49:09'),
(1888, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 08:58:43'),
(1889, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 09:04:50'),
(1890, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 09:16:16'),
(1891, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 09:18:33'),
(1892, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.135', '2026-06-15 09:22:26'),
(1893, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 09:25:32'),
(1894, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 09:26:33');
INSERT INTO `activity_logs` (`id`, `company_id`, `user_id`, `module_name`, `action_name`, `entity_id`, `description`, `ip_address`, `created_at`) VALUES
(1895, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.236.200', '2026-06-15 09:28:46'),
(1896, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 09:41:22'),
(1897, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 09:44:37'),
(1898, 2, 26, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 09:51:03'),
(1899, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.135', '2026-06-15 10:33:50'),
(1900, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.229.135', '2026-06-15 10:41:13'),
(1901, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 10:43:23'),
(1902, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 10:46:07'),
(1903, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 10:50:52'),
(1904, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 11:20:08'),
(1905, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 11:20:16'),
(1906, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 11:23:32'),
(1907, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 12:01:39'),
(1908, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 13:40:24'),
(1909, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 14:24:57'),
(1910, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '197.231.248.253', '2026-06-15 15:15:31'),
(1911, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 15:37:11'),
(1912, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 15:39:20'),
(1913, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 15:49:06'),
(1914, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 16:27:24'),
(1915, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 16:42:10'),
(1916, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.129', '2026-06-15 17:10:18'),
(1917, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-15 17:33:30'),
(1918, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.232.160', '2026-06-16 06:26:56'),
(1919, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 08:35:41'),
(1920, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:02:38'),
(1921, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:04:52'),
(1922, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:10:54'),
(1923, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.216.175', '2026-06-16 09:14:41'),
(1924, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:15:36'),
(1925, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:31:12'),
(1926, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:33:47'),
(1927, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:35:39'),
(1928, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:36:34'),
(1929, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:37:11'),
(1930, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:40:25'),
(1931, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:43:57'),
(1932, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:46:31'),
(1933, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:49:04'),
(1934, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:56:01'),
(1935, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 09:59:00'),
(1936, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 10:09:44'),
(1937, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 10:30:27'),
(1938, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 10:32:05'),
(1939, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 10:58:24'),
(1940, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 11:20:49'),
(1941, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 11:29:48'),
(1942, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 11:31:33'),
(1943, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 11:35:28'),
(1944, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 11:35:29'),
(1945, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 11:35:56'),
(1946, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.232', '2026-06-16 11:38:02'),
(1947, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 11:53:39'),
(1948, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 11:55:26'),
(1949, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 11:56:09'),
(1950, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 12:40:52'),
(1951, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 13:53:59'),
(1952, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 13:59:41'),
(1953, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 14:17:12'),
(1954, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 14:17:12'),
(1955, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 14:21:02'),
(1956, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 14:22:42'),
(1957, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 14:23:42'),
(1958, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 14:24:27'),
(1959, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 14:25:28'),
(1960, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 14:42:59'),
(1961, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 14:42:59'),
(1962, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 14:56:16'),
(1963, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.232', '2026-06-16 15:02:51'),
(1964, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 15:15:16'),
(1965, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 16:03:25'),
(1966, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 16:03:26'),
(1967, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 16:45:53'),
(1968, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 16:52:01'),
(1969, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.232', '2026-06-16 17:00:45'),
(1970, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.132', '2026-06-17 08:40:26'),
(1971, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.132', '2026-06-17 08:40:28'),
(1972, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 08:45:49'),
(1973, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 08:47:37'),
(1974, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 08:50:34'),
(1975, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.52', '2026-06-17 08:50:47'),
(1976, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 08:51:34'),
(1977, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 08:55:05'),
(1978, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 09:03:50'),
(1979, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 09:07:59'),
(1980, 2, 36, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 09:14:59'),
(1981, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 09:29:06'),
(1982, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 09:29:07'),
(1983, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.132', '2026-06-17 09:37:26'),
(1984, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 09:42:24'),
(1985, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 09:44:25'),
(1986, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 09:50:31'),
(1987, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 10:03:07'),
(1988, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 10:05:11'),
(1989, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 10:07:28'),
(1990, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 10:07:29'),
(1991, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.57', '2026-06-17 10:10:31'),
(1992, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.57', '2026-06-17 10:10:31'),
(1993, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 10:12:50'),
(1994, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 10:20:48'),
(1995, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.132', '2026-06-17 11:41:23'),
(1996, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.132', '2026-06-17 11:41:35'),
(1997, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 12:46:44'),
(1998, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 12:50:34'),
(1999, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 12:54:02'),
(2000, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 12:56:17'),
(2001, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 12:59:22'),
(2002, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 13:05:24'),
(2003, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.132', '2026-06-17 13:27:13'),
(2004, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.132', '2026-06-17 13:27:14'),
(2005, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 14:44:21'),
(2006, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 15:05:13'),
(2007, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.251', '2026-06-17 15:12:34'),
(2008, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 15:42:52'),
(2009, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 15:47:35'),
(2010, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 16:05:25'),
(2011, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 16:12:03'),
(2012, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 16:30:16'),
(2013, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.231.132', '2026-06-17 16:48:44'),
(2014, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 16:49:56'),
(2015, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 16:56:27'),
(2016, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 17:01:04'),
(2017, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 18:31:48'),
(2018, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-17 18:31:49'),
(2019, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 08:39:29'),
(2020, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.119', '2026-06-18 08:56:51'),
(2021, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 09:00:25'),
(2022, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 09:08:36'),
(2023, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 09:10:30'),
(2024, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 09:14:27'),
(2025, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 09:15:34'),
(2026, 2, 23, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 09:26:41'),
(2027, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 09:27:55'),
(2028, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 09:48:32'),
(2029, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 09:59:27'),
(2030, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 10:16:46'),
(2031, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 11:22:04'),
(2032, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 11:33:51'),
(2033, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 11:38:54'),
(2034, 2, 27, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 11:41:22'),
(2035, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 11:56:54'),
(2036, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 11:57:26'),
(2037, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 12:02:23'),
(2038, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 12:04:52'),
(2039, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 12:06:45'),
(2040, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 12:53:47'),
(2041, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 12:56:10'),
(2042, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 13:02:02'),
(2043, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.52', '2026-06-18 13:05:02'),
(2044, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-18 13:58:35'),
(2045, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.207', '2026-06-18 14:31:47'),
(2046, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.189', '2026-06-18 15:14:34'),
(2047, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.39', '2026-06-18 15:35:08'),
(2048, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.39', '2026-06-18 15:38:31'),
(2049, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.39', '2026-06-18 15:51:18'),
(2050, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.39', '2026-06-18 15:51:18'),
(2051, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.39', '2026-06-18 15:51:23'),
(2052, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-18 16:17:11'),
(2053, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-18 16:35:35'),
(2054, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-18 16:43:27'),
(2055, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-18 17:00:42'),
(2056, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-18 17:04:43'),
(2057, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.70', '2026-06-19 07:56:31'),
(2058, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.70', '2026-06-19 08:44:55'),
(2059, 2, 43, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.82', '2026-06-19 08:59:06'),
(2060, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.82', '2026-06-19 09:07:17'),
(2061, 2, 39, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 10:01:33'),
(2062, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 10:39:29'),
(2063, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 10:41:01'),
(2064, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 10:41:02'),
(2065, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 10:41:45'),
(2066, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 10:43:26'),
(2067, 2, 46, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 10:54:33'),
(2068, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 10:56:08'),
(2069, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 10:57:08'),
(2070, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 11:01:20'),
(2071, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 11:01:50'),
(2072, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 11:06:55'),
(2073, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 11:09:10'),
(2074, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 11:22:36'),
(2075, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 11:48:06'),
(2076, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 11:51:23'),
(2077, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 12:14:41'),
(2078, 2, 22, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 12:16:49'),
(2079, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 12:28:53'),
(2080, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 12:31:51'),
(2081, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 12:43:37'),
(2082, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 12:44:29'),
(2083, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 13:57:17'),
(2084, 2, 33, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 14:23:11'),
(2085, 2, 33, 'auth', 'logout', NULL, 'Déconnexion utilisateur', '143.105.213.172', '2026-06-19 14:25:24'),
(2086, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 15:12:13'),
(2087, 2, 28, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.172', '2026-06-19 15:25:36'),
(2088, 2, 25, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.194.133', '2026-06-21 12:02:47'),
(2089, 2, 45, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.219.102', '2026-06-21 14:22:57'),
(2090, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 07:49:58'),
(2091, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.141', '2026-06-22 07:50:32'),
(2092, 2, 29, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.141', '2026-06-22 08:37:39'),
(2093, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 08:38:35'),
(2094, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 08:41:40'),
(2095, 2, 41, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 08:54:56'),
(2096, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 08:59:12'),
(2097, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 08:59:13'),
(2098, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 09:28:10'),
(2099, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 09:33:16'),
(2100, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 09:37:23'),
(2101, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 09:41:03'),
(2102, 2, 44, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 09:48:29'),
(2103, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 10:03:10'),
(2104, 2, 35, 'auth', 'login', NULL, 'Connexion utilisateur', '143.105.213.110', '2026-06-22 10:04:13'),
(2105, 2, 38, 'auth', 'login', NULL, 'Connexion utilisateur', '154.117.230.63', '2026-06-22 10:09:02');

-- --------------------------------------------------------

--
-- Structure de la table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `alert_type` varchar(40) NOT NULL,
  `alert_level` varchar(20) NOT NULL DEFAULT 'warning',
  `chantier_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'open',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `alert_escalations`
--

CREATE TABLE `alert_escalations` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `alert_id` int(11) NOT NULL,
  `escalation_stage` varchar(30) NOT NULL,
  `target_role_code` varchar(80) NOT NULL,
  `note` text NOT NULL,
  `escalated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `approval_signatures`
--

CREATE TABLE `approval_signatures` (
  `id` int(11) NOT NULL,
  `approval_id` int(11) NOT NULL,
  `signed_by_user_id` int(11) DEFAULT NULL,
  `signer_role_code` varchar(80) DEFAULT NULL,
  `signature_name` varchar(191) NOT NULL,
  `decision` varchar(30) NOT NULL DEFAULT 'approved',
  `note` varchar(255) DEFAULT NULL,
  `signed_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `assigned_tasks`
--

CREATE TABLE `assigned_tasks` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `assigned_role_code` varchar(80) DEFAULT NULL,
  `assigned_user_id` int(11) DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `priority` varchar(30) NOT NULL DEFAULT 'normal',
  `status` varchar(30) NOT NULL DEFAULT 'open',
  `due_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `assigned_tasks`
--

INSERT INTO `assigned_tasks` (`id`, `company_id`, `project_id`, `chantier_id`, `assigned_role_code`, `assigned_user_id`, `title`, `description`, `priority`, `status`, `due_date`, `created_by`, `created_at`) VALUES
(1, 2, 3, NULL, 'INGENIEUR', 36, 'DEVIS', 'Bonjour,\r\n\r\nConcernant le devis, le formulaire ainsi que les quantités sont déjà renseignés dans le fichier Excel transmis. Il nous reste uniquement à compléter les prix unitaires afin de finaliser le document.\r\n\r\nMerci.', 'high', 'in_progress', '2026-05-01', 23, '2026-04-30 09:51:19'),
(2, 2, 3, NULL, 'DESSINATEUR', 30, 'DEVIS ROOF TOP BANCOBU', 'Bonjour,\r\n\r\nConcernant le devis, le formulaire ainsi que les quantités sont déjà renseignés dans le fichier Excel transmis. Il nous reste uniquement à compléter les prix unitaires afin de finaliser le document.\r\n\r\nMerci.', 'high', 'in_progress', '2026-05-01', 23, '2026-04-30 09:52:36'),
(3, 2, 2, NULL, 'DESSINATEUR', 30, 'OFFRE BRARUDI GITEGA', 'Reproduire les plans existants des deux villas, intégrer les modifications proposées par la BRARUDI, réaliser les modélisations 3D, et établir le coût estimatif des travaux de modification.', 'medium', 'in_progress', '2026-05-08', 23, '2026-04-30 10:00:36'),
(4, 2, 7, NULL, '', NULL, 'GIHOSHA MPUNDU', 'Le barza présente des infiltrations d’eaux pluviales. Il est nécessaire d’effectuer une descente sur terrain, en compagnie du chef de chantier de la zone Gihosha, afin d’assurer le suivi et de proposer les mesures correctives appropriées', 'critical', 'open', '2026-05-08', 23, '2026-04-30 10:10:17');

-- --------------------------------------------------------

--
-- Structure de la table `budgets`
--

CREATE TABLE `budgets` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `version_name` varchar(120) NOT NULL,
  `amount_planned` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount_actual` decimal(15,2) NOT NULL DEFAULT 0.00,
  `variance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(40) NOT NULL DEFAULT 'en_preparation',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `budget_lines`
--

CREATE TABLE `budget_lines` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `cost_code` varchar(60) NOT NULL,
  `label` varchar(191) NOT NULL,
  `category` varchar(80) NOT NULL,
  `planned_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `committed_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `actual_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `variance_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `alert_level` varchar(30) NOT NULL DEFAULT 'normal',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cash_journal_entries`
--

CREATE TABLE `cash_journal_entries` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_name` varchar(191) NOT NULL,
  `imputation` varchar(191) DEFAULT NULL,
  `entry_date` date NOT NULL,
  `entry_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `exit_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `balance_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `justification` text DEFAULT NULL,
  `category_label` varchar(191) DEFAULT NULL,
  `receiver_name` varchar(191) DEFAULT NULL,
  `assistant_check` varchar(191) DEFAULT NULL,
  `excess_return_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cash_journal_entries`
--

INSERT INTO `cash_journal_entries` (`id`, `company_id`, `chantier_name`, `imputation`, `entry_date`, `entry_amount`, `exit_amount`, `balance_amount`, `justification`, `category_label`, `receiver_name`, `assistant_check`, `excess_return_amount`, `created_at`) VALUES
(1, 2, 'MUHA', 'FFFFF', '2026-05-11', 40000.00, 10000.00, 30000.00, 'ACHAT CIMENT', 'Chantier', 'michel', 'Jeannette', 0.00, '2026-05-11 10:51:38'),
(2, 2, 'Fonctionnement/entretier vehicule', '61', '2026-01-06', 6200000.00, 1170000.00, 5030000.00, 'Disque, pavalaque, MOD,reparation pr dyna E4178A.', 'Fonctionnement.', '', 'CONTROLE', 0.00, '2026-05-15 09:29:30'),
(3, 2, 'Fonctionnement', '61', '2026-01-06', 1170000.00, 10000.00, 1160000.00, 'Disque, pavalaque, MOD,reparation pr dyna E4178A.', 'ENTRET/REPARATION VEEHICULE', 'RUGAMBIRA THOMAS.', 'CONTROLE', 0.00, '2026-05-15 09:39:01'),
(4, 2, 'FONCTIONNEMENT', '61', '2026-01-06', 1660000.00, 1160000.00, 1660000.00, 'Achat du carburant essence', 'CARBURANT', 'JEAN DE DIEU', 'CONTROLE', 1160000.00, '2026-05-15 09:58:47');

-- --------------------------------------------------------

--
-- Structure de la table `chantiers`
--

CREATE TABLE `chantiers` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `ref_chantier` varchar(255) NOT NULL,
  `name` varchar(191) NOT NULL,
  `chef_chantier` varchar(255) NOT NULL,
  `location` varchar(191) NOT NULL,
  `budget` decimal(15,2) NOT NULL DEFAULT 0.00,
  `date_debut` date DEFAULT NULL,
  `date_fin_prevue` date DEFAULT NULL,
  `status` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chantiers`
--

INSERT INTO `chantiers` (`id`, `company_id`, `project_id`, `ref_chantier`, `name`, `chef_chantier`, `location`, `budget`, `date_debut`, `date_fin_prevue`, `status`, `created_at`) VALUES
(1, 2, 1, '', 'IBB entrepots', '', 'Kajaga', 1132249177.00, NULL, NULL, 'Actif', '2026-04-29 10:39:27'),
(2, 2, 8, '', 'TEMOINS DE JEHOVAH', '', 'ROHERO', 44230176.00, NULL, NULL, 'Actif', '2026-04-30 10:39:14'),
(3, 2, 9, '', 'KABEZI', '', 'KABEZI', 117901513.00, NULL, NULL, 'Actif', '2026-04-30 10:43:34'),
(4, 2, 10, '', 'KING\'S SCHOOL', '', 'LARGE', 0.00, NULL, NULL, 'Actif', '2026-04-30 10:45:24'),
(5, 2, 14, '', 'MUHA', '', 'MUHA', 145628190.00, NULL, NULL, 'Actif', '2026-04-30 10:49:34'),
(6, 2, 12, '', 'GIHOSHA APPARTEMENT', '', 'GIHOSHA', 0.00, NULL, NULL, 'Actif', '2026-05-04 08:37:18'),
(7, 2, 11, '', 'GIHOSHA ZONE', '', 'GIHOSHA', 0.00, NULL, NULL, 'Actif', '2026-05-04 08:37:57'),
(8, 2, 13, '', 'AVENANT', '', '', 0.00, NULL, NULL, 'Actif', '2026-05-04 08:38:19'),
(9, 2, 10, '', 'AVENANT', '', 'LARGE', 0.00, NULL, NULL, 'Actif', '2026-05-04 08:38:33'),
(10, 2, 11, '', 'AVENANT', '', '', 0.00, NULL, NULL, 'Actif', '2026-05-04 08:39:07'),
(11, 2, 19, '', 'GAKUNGWE', '', '', 0.00, NULL, NULL, 'Actif', '2026-05-04 08:43:09'),
(12, 2, 20, '', 'JABE USDA', '', '', 0.00, NULL, NULL, 'Actif', '2026-05-04 08:43:25'),
(13, 2, 18, '', 'NYABUGETE DR', '', 'NYABUGETE', 0.00, NULL, NULL, 'Actif', '2026-05-04 08:43:52'),
(14, 2, 21, '', 'GATOKE CLAUDOIR', '', 'RWEZA', 0.00, NULL, NULL, 'Actif', '2026-05-07 13:56:27'),
(15, 2, 22, '', 'KININDO APPARTEMENT', '', 'LARGE', 0.00, NULL, NULL, 'Actif', '2026-05-07 13:57:18'),
(16, 2, 23, '', 'GIHOSHA NDAYI', '', 'GIHOSHA', 0.00, NULL, NULL, 'Actif', '2026-05-07 15:33:42'),
(17, 2, 24, '', 'KINANIRA 3', '', 'KINANIRA', 0.00, NULL, NULL, 'Actif', '2026-05-07 15:34:55'),
(18, 2, 25, '', 'Fonctionnemnt', '', 'Q.INDUSTRIEL', 0.00, NULL, NULL, 'Actif', '2026-05-08 14:38:38'),
(19, 2, 26, '', 'Chantier Mirroir', '', 'Q. Mirroir', 500000.00, NULL, NULL, 'Actif', '2026-05-11 11:57:10'),
(20, 2, 27, '', 'GASENYI Presidence', '', 'Gasenyi', 0.00, NULL, NULL, 'Actif', '2026-05-11 15:31:08'),
(21, 2, 25, '', 'Siège social', '', 'Q.INDUSTRIEL', 0.00, NULL, NULL, 'Actif', '2026-05-13 12:13:37'),
(23, 2, 28, '', 'Projet Pave', '', 'Bureau de satraco construction', 0.00, NULL, NULL, 'Actif', '2026-05-29 15:32:07'),
(24, 2, 29, '', 'Maramvya Brique Cute', '', 'Maramvya', 0.00, NULL, NULL, 'Actif', '2026-05-29 15:32:53'),
(25, 2, 30, '', 'Bloque Ciment', '', 'Siege', 0.00, NULL, NULL, 'Actif', '2026-06-11 09:03:38'),
(26, 2, 31, 'CH-2026-026', 'Consultance', 'Remis', 'Siege', 0.00, NULL, NULL, 'Actif', '2026-06-11 14:02:24');

-- --------------------------------------------------------

--
-- Structure de la table `chantier_assignments`
--

CREATE TABLE `chantier_assignments` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `assignee_name` varchar(191) NOT NULL,
  `assignee_role` varchar(120) NOT NULL,
  `assignment_scope` varchar(120) NOT NULL DEFAULT 'suivi',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chantier_deliverables`
--

CREATE TABLE `chantier_deliverables` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `deliverable_name` varchar(191) NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'À produire',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chantier_evaluation_lines`
--

CREATE TABLE `chantier_evaluation_lines` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `category_label` varchar(191) NOT NULL,
  `source_type` varchar(40) NOT NULL DEFAULT 'Banque',
  `entry_date` date DEFAULT NULL,
  `description_label` varchar(255) NOT NULL,
  `amount_bif` decimal(15,2) NOT NULL DEFAULT 0.00,
  `observations` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chantier_profitability`
--

CREATE TABLE `chantier_profitability` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `revenue_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `direct_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payroll_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `equipment_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subcontract_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `overhead_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `margin_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `margin_percent` decimal(8,2) NOT NULL DEFAULT 0.00,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chantier_tasks`
--

CREATE TABLE `chantier_tasks` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `task_name` varchar(191) NOT NULL,
  `milestone_name` varchar(191) DEFAULT NULL,
  `planned_start` date DEFAULT NULL,
  `planned_end` date DEFAULT NULL,
  `progress_percent` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` varchar(40) NOT NULL DEFAULT 'Planifié',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `contact_name` varchar(191) NOT NULL,
  `phone` varchar(80) NOT NULL,
  `email` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `company_id`, `name`, `contact_name`, `phone`, `email`, `created_at`) VALUES
(1, 2, 'Madame Eliane ( KINANAIRA )', '79405256', '', '', '2026-05-07 09:40:40');

-- --------------------------------------------------------

--
-- Structure de la table `client_portal_accounts`
--

CREATE TABLE `client_portal_accounts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `portal_status` varchar(30) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client_portal_accounts`
--

INSERT INTO `client_portal_accounts` (`id`, `company_id`, `client_id`, `chantier_id`, `user_id`, `portal_status`, `created_at`) VALUES
(1, 2, 1, 1, 48, 'active', '2026-05-14 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `client_project_updates`
--

CREATE TABLE `client_project_updates` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `client_portal_account_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `update_type` varchar(60) NOT NULL DEFAULT 'avancement',
  `title` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `progress_percent` decimal(8,2) DEFAULT NULL,
  `amount_due` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount_paid` decimal(15,2) NOT NULL DEFAULT 0.00,
  `media_url` varchar(255) DEFAULT NULL,
  `file_original_name` varchar(255) DEFAULT NULL,
  `file_mime` varchar(120) DEFAULT NULL,
  `reminder_date` date DEFAULT NULL,
  `visibility` varchar(30) NOT NULL DEFAULT 'client',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client_project_updates`
--

INSERT INTO `client_project_updates` (`id`, `company_id`, `client_portal_account_id`, `chantier_id`, `update_type`, `title`, `description`, `progress_percent`, `amount_due`, `amount_paid`, `media_url`, `file_original_name`, `file_mime`, `reminder_date`, `visibility`, `created_by`, `created_at`) VALUES
(1, 2, 1, 1, 'avancement', 'Ouverture du compte de suivi chantier', 'Compte client activé pour le suivi autonome du chantier : niveau d’exécution, documents, photos, factures et rappels.', 35.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'client', 22, '2026-05-14 00:00:00'),
(2, 2, 1, 1, 'paiement', 'Situation de paiement initiale', 'Exemple de situation de paiement pour tester l’interface client chantier.', 35.00, 10000000.00, 2500000.00, NULL, NULL, NULL, NULL, 'client', 22, '2026-05-14 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `primary_color` varchar(20) NOT NULL DEFAULT '#0f766e',
  `logo_path` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `companies`
--

INSERT INTO `companies` (`id`, `name`, `slug`, `plan_id`, `status`, `primary_color`, `logo_path`, `created_at`) VALUES
(1, 'Votre entreprise', 'votre-entreprise', 3, 'active', '#0f766e', '', '2026-04-23 00:00:00'),
(2, 'Satraco', 'satraco', 3, 'active', '#0f766e', 'assets/logos/logo_satraco_clean.png', '2026-04-28 13:28:30');

-- --------------------------------------------------------

--
-- Structure de la table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `contract_number` varchar(120) NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'brouillon',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `crm_prospects`
--

CREATE TABLE `crm_prospects` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `prospect_name` varchar(191) NOT NULL,
  `contact_name` varchar(191) DEFAULT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `source_channel` varchar(120) DEFAULT NULL,
  `stage` varchar(80) NOT NULL DEFAULT 'Prospection',
  `offer_type` varchar(80) NOT NULL DEFAULT 'Devis',
  `estimated_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `next_action` text DEFAULT NULL,
  `deadline_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `crm_prospects`
--

INSERT INTO `crm_prospects` (`id`, `company_id`, `prospect_name`, `contact_name`, `phone`, `email`, `source_channel`, `stage`, `offer_type`, `estimated_amount`, `next_action`, `deadline_date`, `created_at`) VALUES
(1, 2, 'KENYA EMBASSY', '', '', '', 'Appel entrant', 'Offre en préparation', 'Devis', 0.00, 'VISITE DU TERRAIN', '2026-05-13', '2026-05-12 16:03:50'),
(2, 2, 'ADB', '', '', '', 'Appel entrant', 'Offre en préparation', 'Appel d’offres', 0.00, 'MANIFESTATION D\'INTERET', '2026-05-28', '2026-05-12 16:05:04'),
(3, 2, 'WHH', '', '', '', 'Appel entrant', 'Prospection', 'Appel d’offres', 0.00, '', '2026-05-19', '2026-05-12 16:06:46');

-- --------------------------------------------------------

--
-- Structure de la table `daf_disbursement_approvals`
--

CREATE TABLE `daf_disbursement_approvals` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `approval_date` date NOT NULL,
  `request_ref` varchar(120) NOT NULL,
  `beneficiary_name` varchar(191) NOT NULL,
  `expense_category` varchar(191) NOT NULL,
  `chantier_name` varchar(191) DEFAULT NULL,
  `requested_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `approved_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status_label` varchar(80) NOT NULL DEFAULT 'En attente',
  `requested_by` varchar(191) DEFAULT NULL,
  `verified_by` varchar(191) DEFAULT NULL,
  `approved_by` varchar(191) DEFAULT NULL,
  `payment_channel` varchar(80) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `daf_fund_movements`
--

CREATE TABLE `daf_fund_movements` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `movement_date` date NOT NULL,
  `movement_type` varchar(80) NOT NULL,
  `source_label` varchar(191) DEFAULT NULL,
  `destination_label` varchar(191) DEFAULT NULL,
  `chantier_name` varchar(191) DEFAULT NULL,
  `amount_bif` decimal(15,2) NOT NULL DEFAULT 0.00,
  `reference_no` varchar(120) DEFAULT NULL,
  `approved_by` varchar(191) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `module_name` varchar(100) NOT NULL,
  `title` varchar(191) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `extension` varchar(30) DEFAULT NULL,
  `size_bytes` bigint(20) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `documents`
--

INSERT INTO `documents` (`id`, `company_id`, `user_id`, `module_name`, `title`, `original_name`, `file_path`, `extension`, `size_bytes`, `created_at`) VALUES
(1, 2, 33, 'GED', 'RESSOURCES HUMAINES', 'RESSOURCES HUMAINES.xlsx', 'uploads/documents/doc_1779184750_a5c09610.xlsx', 'xlsx', 191386, '2026-05-19 11:59:10'),
(2, 2, 33, 'GED', 'Présences hebdomadaires des employés', 'Présences hebdomadaires des employés.xlsx', 'uploads/documents/doc_1779185229_4ff296c8.xlsx', 'xlsx', 76955, '2026-05-19 12:07:09'),
(3, 2, 33, 'GED', 'Mouvement des employés', 'Mouvement des employés.xlsx', 'uploads/documents/doc_1779185984_c57a98ac.xlsx', 'xlsx', 52245, '2026-05-19 12:19:44');

-- --------------------------------------------------------

--
-- Structure de la table `document_approvals`
--

CREATE TABLE `document_approvals` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `requested_by_user_id` int(11) DEFAULT NULL,
  `current_stage` varchar(30) NOT NULL DEFAULT 'N1',
  `current_role_code` varchar(80) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `document_approval_requests`
--

CREATE TABLE `document_approval_requests` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `requested_by_user_id` int(11) DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `document_approval_steps`
--

CREATE TABLE `document_approval_steps` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `sequence_no` int(11) NOT NULL DEFAULT 1,
  `approver_role_code` varchar(80) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `signed_by_user_id` int(11) DEFAULT NULL,
  `signed_at` datetime DEFAULT NULL,
  `signature_name` varchar(191) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `matricule` varchar(80) NOT NULL,
  `full_name` varchar(191) NOT NULL,
  `function_name` varchar(120) NOT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `contract_type` varchar(40) DEFAULT NULL,
  `salary_base` decimal(15,2) NOT NULL DEFAULT 0.00,
  `chantier_id` int(11) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employees`
--

INSERT INTO `employees` (`id`, `company_id`, `matricule`, `full_name`, `function_name`, `phone`, `contract_type`, `salary_base`, `chantier_id`, `status`, `created_at`) VALUES
(1, 2, '1', 'NDAGIJE ALDO GEORGES', 'DIRECTEUR GENERAL', '68131313', 'CDI', 0.00, 21, 'active', '2026-05-13 15:01:54'),
(2, 2, '2', 'NIYIMBONA EMMANUEL', 'DIRECTEUR TECHNIQUE', '69414762', 'CDI', 0.00, 21, 'active', '2026-05-13 15:05:08'),
(3, 2, '3', 'NDAGIJE MARIAM', 'DIRECTRICE ADMINISTRATIVE ET FINANCIERE', '68762745', 'CDI', 0.00, 21, 'active', '2026-05-13 15:07:55'),
(4, 2, '4', 'NSENGIYUMVA MARC', 'CHAUFFEUR', '77137234', 'CDI', 0.00, 21, 'active', '2026-05-13 15:09:09'),
(5, 2, '5', 'AHISHAKIYE NELLY ANGE', 'COMPTABLE', '71731954', 'CDI', 0.00, 21, 'active', '2026-05-13 15:11:18'),
(6, 2, '6', 'EMERUSABE DAVID', 'DIRECTEUR DES PROJETS ET ASSISTANT DE DIRECTION', '79528662', 'CDI', 0.00, 21, 'active', '2026-05-13 15:14:30'),
(7, 2, '7', 'NIBITANGA FABRICE', 'Ir DE STRUCTURES + CONTROLE EXECUTION SUR CHANTIERS', '69142719', 'CDI', 0.00, 21, 'active', '2026-05-13 15:17:17'),
(8, 2, '8', 'IRUTAVYOSE AXCEL FERNAND', 'INFORMATICIEN', '79383134', 'CDD', 0.00, 21, 'active', '2026-05-13 15:21:42'),
(9, 2, '9', 'HABONIMANA ANNIELLA', 'CHARGEE DES APPROVISIONNEMENTS', '61316022', 'CDD', 0.00, 21, 'active', '2026-05-13 15:23:50'),
(10, 2, '10', 'NKORERIMANA EMMANUEL', 'CHARGE DES ACHATS ET APPROVISIONNEMENT', '61402029', 'CDI', 0.00, 21, 'active', '2026-05-13 15:26:28'),
(11, 2, '11', 'HEZAGIRA AIME ORLY', 'ARCHITECTE', '69584055', 'CDD', 0.00, 21, 'active', '2026-05-13 15:27:58'),
(12, 2, '12', 'MANIRAKIZA MICHEL', 'CHARGE DES ACHATS ET APPROVISIONNEMENT', '68890558', 'CDD', 0.00, 21, 'active', '2026-05-13 15:30:14'),
(13, 2, '13', 'DUSHIME KERCY MERVEILLE', 'ARCHITECTE', '61583843   71873559', 'CDD', 0.00, 21, 'active', '2026-05-13 15:34:22'),
(14, 2, '14', 'NAHIMANA RAMLA', 'ASSISTANT COMPTABLE', '61871346', 'CDD', 0.00, 21, 'active', '2026-05-13 15:36:08'),
(15, 2, '15', 'HABINGABWA GEDEON', 'ARCHITECTE', '69968202', 'CDD', 0.00, 21, 'active', '2026-05-13 15:37:59'),
(16, 2, '16', 'ZEKARIAS RUTH', 'ARCHITECTE', '62692283', 'CDD', 0.00, 21, 'active', '2026-05-13 15:39:30'),
(17, 2, '17', 'MANIRAMBONA THIERRY', 'CHAUFFEUR DE CAMION', '65447601', 'CDD', 0.00, 21, 'active', '2026-05-13 15:41:33'),
(18, 2, '18', 'MINANI MARC', 'CHAUFFEUR DE CAMION', '71035832', 'CDD', 0.00, 21, 'active', '2026-05-13 15:42:50'),
(19, 2, '19', 'NKURUNZIZA ALEXIS', 'INGENIEUR METREUR DESSINATEUR', '79405256   66320842', 'CDD', 0.00, 21, 'active', '2026-05-13 15:44:43'),
(20, 2, '20', 'NKESHIMANA COME', 'ASSISTANT COMPTABLE', '68328903', 'CDD', 0.00, 21, 'active', '2026-05-13 15:45:58'),
(21, 2, '21', 'KWIZERIMANA EMERY', 'CHARGE DE L\'HYGIENE ET RESTAURATION DU PERSONNEL', '62956996', 'CDD', 0.00, 21, 'active', '2026-05-13 15:48:57'),
(22, 2, '22', 'ARAKAZA ARNAUD', 'CHARGE DU SUIVI DES TRAVAUX AUX CHANTIERS', '79884905', 'CDD', 0.00, 21, 'active', '2026-05-13 15:52:08'),
(23, 2, '23', 'JEANNETTE MOSES', 'ASSISTANTE FINANCIERE', '69267214', 'CDD', 0.00, 21, 'active', '2026-05-13 15:55:54'),
(24, 2, '24', 'NIYITEGEKA JACQUES', 'GESTIONNAIRE DU CHARROI', '68974071', 'CDD', 0.00, 21, 'active', '2026-05-13 15:57:15'),
(25, 2, '25', 'MANIRAGABA SERGES', 'COMPTABLE', '61013172', 'CDD', 0.00, 21, 'active', '2026-05-13 15:59:00'),
(26, 2, '26', 'BUTOYI APOLINAIRE', 'GARDIEN DE NUIT', '68304252', 'CDD', 0.00, 21, 'active', '2026-05-13 16:00:44'),
(27, 2, '27', 'HAKIZIMANA CYPRIEN', 'CHARGE D\'HYGIENE, AIDE-MAGASINIER ET JARDINIER', '61990443   71577613', 'CDD', 0.00, 21, 'active', '2026-05-13 16:03:20'),
(28, 2, '28', 'IRAKOZE CLAUDE', 'Ir RESPONSABLE DES SOUMISSIONS ET DE L\'APPUI TECHNIQUE', '66307796   71753441', 'CDD', 0.00, 21, 'active', '2026-05-13 16:13:24'),
(29, 2, '29', 'IRAKOZE ALPHA DENARD', 'ARCHITECTE', '79183032', 'CDD', 0.00, 21, 'active', '2026-05-13 16:14:31'),
(30, 2, '30', 'IGIRUMWETE PISCHON', 'CHAUFFEUR', '61510525', 'CDD', 0.00, 21, 'active', '2026-05-13 16:15:31'),
(31, 2, '31', 'MUNEZERO NADIA', 'CHARGEE DE L\'HYGIENE', '71013624', 'CDD', 0.00, 21, 'active', '2026-05-13 16:16:33'),
(32, 2, '32', 'NDUWAYO EMMANUEL', 'ASSISTANT COMPTABLE', '68441031', 'CDD', 0.00, 21, 'active', '2026-05-13 16:17:37'),
(33, 2, '33', 'RUGAMBIRA THOMAS', 'CHAUFFEUR', '61949296   79949262   77949262', 'CDD', 0.00, 21, 'active', '2026-05-13 16:19:45'),
(34, 2, '34', 'NTAKIRUTIMANA EUPHREM', 'CHAUFFEUR', '62826765   79602715', 'CDD', 0.00, 21, 'active', '2026-05-13 16:20:59'),
(35, 2, '35', 'NSENGIYUMVA SALVATOR', 'CONVOYEUR', '77137234', 'CDD', 0.00, 21, 'active', '2026-05-13 16:22:35'),
(36, 2, '36', 'NIYONKURU JEAN-DE-DIEU', 'GESTIONNAIRE DES STOCKS', '68005594', 'CDD', 0.00, 21, 'active', '2026-05-13 16:23:48'),
(37, 2, '37', 'RUGAMIRA JEAN-MARIE', 'TECHNICIEN AUDIO-VISUEL', '61252765', 'CDD', 0.00, 21, 'active', '2026-05-13 16:29:55'),
(38, 2, '38', 'BUNUNGUYE LEONCE', 'GARDIEN DE NUIT', '62296503   79701578', 'CDD', 0.00, 21, 'active', '2026-05-13 16:31:04'),
(39, 2, '39', 'MANIRAMBONA THERENCE', 'GARDIEN DU JOUR', '64276004', 'CDD', 0.00, 1, 'active', '2026-05-13 16:32:24'),
(40, 2, '40', 'HAKIZIMANA GRATIEN', 'GARDIEN DU JOUR', '62278070', 'CDD', 0.00, 21, 'active', '2026-05-13 16:33:32'),
(41, 2, '41', 'TUYISABE SEVERIN', 'ASSISTANT COMPTABLE', '69229283   72075522   77551371', 'CDD', 0.00, 21, 'active', '2026-05-13 16:34:56'),
(42, 2, '42', 'UWITEKA WILLY', 'CHAUFFEUR DE CAMION', '68946989', 'CDD', 0.00, 21, 'active', '2026-05-13 16:36:05'),
(43, 2, '43', 'IRANKUNDA GENEVIEVE', 'CHARGEE DE L\'HYGIENE', '65214683', 'CDD', 0.00, 21, 'active', '2026-05-13 16:37:27'),
(44, 2, '44', 'NISHIMWE OLIVIER', 'INGENIEUR DE BUREAU', '61540241', 'CDD', 0.00, 21, 'active', '2026-05-13 16:38:28'),
(45, 2, '45', 'INGABIRE ELGA REINE-MARIE', 'CHARGEE DU MARKETING', '69632055', 'CDD', 0.00, 21, 'active', '2026-05-13 16:39:46'),
(46, 2, '46', 'NDIKUMANA ERIC', 'CHARGE DES ACHATS ET APPROVISIONNEMENT', '62244801', 'CDD', 0.00, 21, 'active', '2026-05-13 16:41:20'),
(47, 2, '47', 'MALULU NDEKO NORBERT', 'RESPONSABLE DES RESSOURCES HUMAINES', '62400830   77496633', 'CDD', 0.00, 21, 'active', '2026-05-13 16:42:52'),
(48, 2, '48', 'NGUMIJAMAHORO PRINCE JOHNSON', 'ARCHITECTE', '68594484   72049883', 'CDD', 0.00, 21, 'active', '2026-05-15 15:11:24'),
(49, 2, '49', 'TUYISHIME PROVIDENCE', 'INGENIEUR EN INFORMATIQUE', '71403610   61983505', 'CDD', 0.00, 21, 'active', '2026-05-18 11:32:34'),
(50, 2, '50', 'NIYONZIMA GILBERT', 'CHAUFFEUR', '61041581', 'CDD', 0.00, 21, 'active', '2026-06-10 14:20:35');

-- --------------------------------------------------------

--
-- Structure de la table `equipments`
--

CREATE TABLE `equipments` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `code` varchar(80) NOT NULL,
  `label` varchar(191) NOT NULL,
  `equipment_type` varchar(120) DEFAULT NULL,
  `immatriculation` varchar(120) DEFAULT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'disponible',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `external_messages`
--

CREATE TABLE `external_messages` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `message_channel` varchar(40) NOT NULL DEFAULT 'Email',
  `recipient_name` varchar(191) DEFAULT NULL,
  `recipient_contact` varchar(191) NOT NULL,
  `subject_line` varchar(191) DEFAULT NULL,
  `message_body` text NOT NULL,
  `related_module` varchar(80) DEFAULT NULL,
  `related_reference` varchar(120) DEFAULT NULL,
  `approval_status` varchar(40) NOT NULL DEFAULT 'brouillon',
  `sent_status` varchar(40) NOT NULL DEFAULT 'préparé',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `finances`
--

CREATE TABLE `finances` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `reference` varchar(120) NOT NULL,
  `type` varchar(80) NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `finance_contract_situations`
--

CREATE TABLE `finance_contract_situations` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `partner_name` varchar(191) NOT NULL,
  `chantier_service` varchar(191) NOT NULL,
  `contract_object` varchar(255) NOT NULL,
  `contract_duration` varchar(80) DEFAULT NULL,
  `signature_date` date DEFAULT NULL,
  `contract_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `invoice_date` date DEFAULT NULL,
  `invoiced_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_date` date DEFAULT NULL,
  `paid_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `withholding_tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remaining_invoice_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remaining_contract_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `collection_rate` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status_label` varchar(80) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `finance_contract_situations`
--

INSERT INTO `finance_contract_situations` (`id`, `company_id`, `partner_name`, `chantier_service`, `contract_object`, `contract_duration`, `signature_date`, `contract_amount`, `invoice_date`, `invoiced_amount`, `payment_date`, `paid_amount`, `withholding_tax`, `remaining_invoice_amount`, `remaining_contract_amount`, `collection_rate`, `status_label`, `observations`, `created_at`) VALUES
(1, 2, 'KING SCHOOL', 'Chantier de construction', 'Avenat(Travaux supplementaire pour l\'extension de l\'ecole Kings  \\School)', '5 mois', '2026-03-01', 500000000.00, '2026-02-10', 150000000.00, '2026-03-15', 150000000.00, 0.00, 0.00, 350000000.00, 30.00, 'Valider', '', '2026-05-11 11:46:33'),
(2, 2, 'African  Revial Ministries-Burundi ( ARM-BURUNDI)', 'KING\'S SCHOOL', 'Travaux divers pour la construction de l\'extension de l\'école KING\'S SCHOOL restant à réaliser en 2026', 'Travaux en cours d\'achèvement, reste à payer une seule tranche', '2026-01-01', 167940436.00, '2026-02-03', 167940436.00, '2026-02-28', 167940436.00, 0.00, 0.00, 0.00, 100.00, 'En cours', '', '2026-05-12 10:55:26'),
(3, 2, 'African  Revial Ministries-Burundi ( ARM-BURUNDI)', 'KING\'S SCHOOL/AVENANT', 'Travaux supplémentaire pour l\'extension de l\'Ecole KING\'S SCHOOL/AVENANT', '5 mois', '2026-01-22', 730000000.00, '2026-01-27', 730000000.00, '2026-02-17', 330000000.00, 0.00, 400000000.00, 400000000.00, 45.21, 'En cours', '', '2026-05-12 12:43:18'),
(4, 2, 'African  Revial Ministries-Burundi ( ARM-BURUNDI)', 'KING\'S SCHOOL/AVENANT', 'Travaux supplémentaire pour l\'extension de l\'Ecole KING\'S SCHOOL/AVENANT', '5 mois', '2026-01-22', 730000000.00, '2026-03-27', 70000000.00, NULL, 0.00, 0.00, 70000000.00, 730000000.00, 0.00, 'En cours', '', '2026-05-12 13:01:10');

-- --------------------------------------------------------

--
-- Structure de la table `fuel_logs`
--

CREATE TABLE `fuel_logs` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `log_date` date NOT NULL,
  `fuel_card_ref` varchar(120) DEFAULT NULL,
  `quantity_liters` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unit_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `odometer_hours` varchar(120) DEFAULT NULL,
  `supplier_name` varchar(191) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `immobilisations`
--

CREATE TABLE `immobilisations` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `reference_no` varchar(120) NOT NULL,
  `label` varchar(191) NOT NULL,
  `asset_type` varchar(120) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `acquisition_date` date DEFAULT NULL,
  `purchase_value` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(40) NOT NULL DEFAULT 'active',
  `assigned_to` varchar(191) DEFAULT NULL,
  `qr_code` varchar(191) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `insurances`
--

CREATE TABLE `insurances` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `equipment_id` int(11) DEFAULT NULL,
  `immobilisation_id` int(11) DEFAULT NULL,
  `policy_no` varchar(120) NOT NULL,
  `provider_name` varchar(191) NOT NULL,
  `coverage_type` varchar(191) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `premium_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(40) NOT NULL DEFAULT 'active',
  `attachment_path` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `internal_messages`
--

CREATE TABLE `internal_messages` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `sender_user_id` int(11) DEFAULT NULL,
  `recipient_role_code` varchar(80) NOT NULL DEFAULT 'ALL',
  `subject` varchar(191) NOT NULL,
  `body` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'unread',
  `read_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `internal_messages`
--

INSERT INTO `internal_messages` (`id`, `company_id`, `sender_user_id`, `recipient_role_code`, `subject`, `body`, `status`, `read_at`, `created_at`) VALUES
(1, 2, 23, 'ALL', 'Test', 'message de test', 'read', '2026-05-19 13:40:31', '2026-04-30 10:53:40'),
(2, 2, 30, 'ALL', 'Test', 'Merci Pour la message de test', 'read', '2026-05-19 13:40:19', '2026-04-30 10:56:28'),
(3, 2, 35, 'RESPONSABLE_ADMIN_FINANCIER', 'DAF', 'La demande de King\'s school de 900 000 et le paiement d\'assurance maladie sont urgents', 'read', '2026-05-19 13:39:49', '2026-05-15 08:50:47');

-- --------------------------------------------------------

--
-- Structure de la table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `situation_id` int(11) DEFAULT NULL,
  `linked_contract_id` int(11) DEFAULT NULL,
  `invoice_type` varchar(30) NOT NULL,
  `third_party_name` varchar(191) NOT NULL,
  `reference_no` varchar(120) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(30) NOT NULL DEFAULT 'émise',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `maintenance_logs`
--

CREATE TABLE `maintenance_logs` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `maintenance_type` varchar(120) NOT NULL,
  `maintenance_date` date NOT NULL,
  `next_due_date` date DEFAULT NULL,
  `cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `fuel_liters` decimal(12,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'planifiée',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `material_consumptions`
--

CREATE TABLE `material_consumptions` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `consumption_no` varchar(120) NOT NULL,
  `consumption_date` date NOT NULL,
  `quantity` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(50) NOT NULL,
  `cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(40) NOT NULL DEFAULT 'validé',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mobile_reports`
--

CREATE TABLE `mobile_reports` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `report_type` varchar(80) NOT NULL DEFAULT 'Rapport journalier',
  `title` varchar(191) NOT NULL,
  `report_date` date NOT NULL,
  `weather` varchar(120) DEFAULT NULL,
  `progress_percent` decimal(8,2) NOT NULL DEFAULT 0.00,
  `photo_count` int(11) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `alert_id` int(11) DEFAULT NULL,
  `recipient_role_code` varchar(80) NOT NULL DEFAULT 'ALL',
  `notification_type` varchar(40) NOT NULL,
  `priority_level` varchar(20) NOT NULL DEFAULT 'warning',
  `title` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'unread',
  `read_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payment_vouchers`
--

CREATE TABLE `payment_vouchers` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `voucher_number` varchar(80) NOT NULL,
  `voucher_date` date NOT NULL,
  `expense_nature` text NOT NULL,
  `amount_paid` decimal(15,2) NOT NULL DEFAULT 0.00,
  `budget_line` varchar(191) DEFAULT NULL,
  `handed_to_name` varchar(191) DEFAULT NULL,
  `received_by_name` varchar(191) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `payment_vouchers`
--

INSERT INTO `payment_vouchers` (`id`, `company_id`, `voucher_number`, `voucher_date`, `expense_nature`, `amount_paid`, `budget_line`, `handed_to_name`, `received_by_name`, `notes`, `created_at`) VALUES
(1, 2, 'BP-20260511-104428', '2026-05-11', 'ciment', 50000.00, '', '', '', '', '2026-05-11 10:48:11'),
(2, 2, 'BP-20260511-105138', '2026-05-11', 'Main d\'oeuvredes travaux de soudure', 500000.00, 'Kinanira 3', 'Nkorerimana Emmanuel', 'Habonimana Claude', '', '2026-05-11 11:08:45'),
(3, 2, 'BP-20260511-120734', '2026-05-11', 'Avance sur main d\'oeuvre', 500000.00, 'Mirroir', 'UWIZIGIRA Violette', 'Maniragaba Serges', '', '2026-05-11 12:10:30'),
(4, 2, 'BP-20260512-145217', '2026-05-12', 'Frais de ration nettoyage', 200000.00, 'Témoins de Jéhovah', 'Nelly Ange', 'Nkeshimana Vincent', '', '2026-05-12 14:54:58'),
(5, 2, 'BP-20260512-150256', '2026-05-12', 'Controle de  compresseur benz E1070A', 200000.00, 'Fonctionnement', 'Nelly Ange', '', '', '2026-05-12 15:05:51'),
(6, 2, 'BP-20260512-150614', '2026-05-12', 'Achat sambussa et arachide pour les visiteurs', 27500.00, 'Fonctionnement', '', 'Nelly Ange', '', '2026-05-12 15:16:02'),
(7, 2, 'BP-20260513-175703', '2026-05-13', 'Frais de déplacement après les heures de service le 12/5/2026', 10000.00, 'Fonctionnement', 'NIYONKURU Jean de Dieu', 'NTAKIRUTIMANA Euphem', '', '2026-05-13 18:00:55'),
(8, 2, 'BP-20260515-160551', '2026-05-15', 'Achat livres: 7Bibles, 7 grand espoir', 285000.00, 'Fonctionnement', 'Nelly Ange', 'Michel Manirakiza', '', '2026-05-15 16:07:15'),
(9, 2, 'BP-20260518-144539', '2026-05-18', 'LAVAGE DU VEHICULE E2464A', 20000.00, 'Fonctionnement', 'NELLY ANGE', 'IGURUMWETE PISCHON', '', '2026-05-18 14:49:10'),
(10, 2, 'BP-20260518-144910', '2026-05-18', 'Ubuyi,isukari,tangawizi,indimu,amakra', 148000.00, 'Fonctionnement', 'NELLY ANGE', 'Kwizerimana Emery', '', '2026-05-18 15:27:18'),
(11, 2, 'BP-20260518-160649', '2026-05-18', 'ibitumbura ,icapati ,samboussa,imikate ,ivoka ,ibitumbura ,icapati.', 227000.00, 'Fonctionnement', 'Jeannette moses', 'Kwizerimana Emery', '', '2026-05-18 16:07:51'),
(12, 2, 'BP-20260518-163020', '2026-05-18', 'Frais de saisi att,photocopie de quitance ,frais transaction cash tel pour attest non litige et non faillite', 19000.00, 'Fonctionnement', 'Jeannette moses', 'Nduwayo Emmanuel', '', '2026-05-18 16:32:40'),
(13, 2, 'BP-20260518-163241', '2026-05-18', 'Frais de deplacement ADB vers OBR', 10000.00, 'Fonctionnement', 'Jeannette moses', 'Nduwayo Emmanuel', '', '2026-05-18 16:34:27'),
(14, 2, 'BP-20260519-110037', '2026-05-19', 'Pyt dot pour le mariage de Michel', 1500000.00, 'Fonctionnement', 'Nelly Ange', 'Michel Manirakiza', '', '2026-05-19 11:01:45'),
(15, 2, 'BP-20260519-113521', '2026-05-19', 'Frais de deplacment  pour visiter le cite des granulats [Kaburantwa Muhira', 100000.00, 'Eden garden III', 'NELLY ANGE', 'Micher Manirakiza', '', '2026-05-19 11:38:07'),
(16, 2, 'BP-20260519-113808', '2026-05-19', 'Deplacement les ecoles de Bukinanyana et Bubanza ,Deplacement Cibitoke /Mugina ,MOD 2personnes deux journees.', 600000.00, 'Fonctionnement', 'Jeannette moses', 'Ir Fabrice Nibitanga', '', '2026-05-19 11:44:44'),
(17, 2, 'BP-20260519-124855', '2026-05-19', 'Reparation chassis véhicule fuso I4945A', 250000.00, 'Fonctionnement', 'Jacques Niyitegeka', '', '', '2026-05-19 12:50:15'),
(18, 2, 'BP-20260520-145727', '2026-05-20', 'Reparation electric Howo D8152A', 300000.00, 'Fonctionnement', 'NIYITEGEKA Jacques', '', '', '2026-05-20 15:03:11'),
(19, 2, 'BP-20260520-150311', '2026-05-20', 'Achat retroviseur pour Howo D8152A', 450000.00, 'Fonctionnement', 'NIYITEGEKA Jacques', 'HABONIMANA Diomede', '', '2026-05-20 15:06:43'),
(20, 2, 'BP-20260520-155737', '2026-05-20', 'Carburat mazout (remboursement de dette)', 1300000.00, '', 'Niyonkuru J de Dieu', '', '', '2026-05-20 16:00:42'),
(21, 2, 'BP-20260521-094715', '2026-05-21', 'developpement de logicile de gestio', 300.00, '', 'Axcel', 'Mustapha', '', '2026-05-21 09:49:09'),
(22, 2, 'BP-20260521-140053', '2026-05-21', 'Heures supplémentaires', 100000.00, 'Fonctionnement', 'Nelly Ange', 'Aimé Orly Hezagira', '', '2026-05-21 14:01:37'),
(23, 2, 'BP-20260521-152629', '2026-05-21', 'Main d\'oeuvre electric pr Benz E1070A', 100000.00, 'Fonctionnement', 'NIYITEGEKA Jacques', 'NDAYISENGA Twayibu', '', '2026-05-21 15:30:10'),
(24, 2, 'BP-20260522-154849', '2026-05-22', 'Paiement sur la maitenance des climatiseurs Bureau 1 & 2, Centre de reunion et Salle des ingenieur', 920000.00, '', 'Axcel', 'Samuel', '', '2026-05-22 15:51:09'),
(25, 2, 'BP-20260528-125752', '2026-05-28', 'Deplacement de 3 personnes', 150000.00, 'fonctionnement', 'ANGE NELLY', 'DAVID', '', '2026-05-28 12:59:29'),
(26, 2, 'BP-20260528-125929', '2026-05-28', 'Presentation projet OUA - 2 PERSONNES', 200000.00, 'fonctionnement', 'ANGE NELLY', 'DAVID', '', '2026-05-28 13:00:19'),
(27, 2, 'BP-20260528-125929', '2026-05-28', 'Presentation projet OUA - 2 PERSONNES', 200000.00, 'fonctionnement', 'ANGE NELLY', 'DAVID', '', '2026-05-28 13:00:19'),
(28, 2, 'BP-20260528-125929', '2026-05-28', 'Presentation projet OUA - 2 PERSONNES', 200000.00, 'fonctionnement', 'ANGE NELLY', 'DAVID', '', '2026-05-28 13:00:22'),
(29, 2, 'BP-20260528-125929', '2026-05-28', 'Presentation projet OUA - 2 PERSONNES', 200000.00, 'fonctionnement', 'ANGE NELLY', 'DAVID', '', '2026-05-28 13:00:29'),
(30, 2, 'BP-20260603-121536', '2026-06-03', 'Sambussa,papier fresheur, cake, sachets', 92000.00, 'Fonctionnement', 'Jeanette', 'Nelly Ange', '', '2026-06-03 12:18:18'),
(31, 2, 'BP-20260603-145437', '2026-06-03', 'Prestation de sercice', 200000.00, '', 'Nelly', 'Orly', '', '2026-06-03 15:02:57'),
(32, 2, 'BP-20260603-150257', '2026-06-03', 'Prestation de sercice', 100000.00, '', 'Nelly', 'Axcel', '', '2026-06-03 15:08:17');

-- --------------------------------------------------------

--
-- Structure de la table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `period_month` varchar(20) NOT NULL,
  `base_salary` decimal(15,2) NOT NULL DEFAULT 0.00,
  `allowances` decimal(15,2) NOT NULL DEFAULT 0.00,
  `deductions` decimal(15,2) NOT NULL DEFAULT 0.00,
  `net_salary` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(30) NOT NULL DEFAULT 'préparée',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `plans`
--

INSERT INTO `plans` (`id`, `name`) VALUES
(3, 'Professionnel'),
(2, 'Standard'),
(1, 'Starter');

-- --------------------------------------------------------

--
-- Structure de la table `pointages`
--

CREATE TABLE `pointages` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `work_date` date NOT NULL,
  `hours_worked` decimal(8,2) NOT NULL DEFAULT 0.00,
  `overtime_hours` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` varchar(30) NOT NULL DEFAULT 'saisi',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `production_cost_breakdowns`
--

CREATE TABLE `production_cost_breakdowns` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `lot_name` varchar(191) DEFAULT NULL,
  `budget_line_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `estimated_revenue_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payroll_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `equipment_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `material_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subcontract_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `other_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `actual_cost_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `margin_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `margin_percent` decimal(8,2) NOT NULL DEFAULT 0.00,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `production_journals`
--

CREATE TABLE `production_journals` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `budget_line_id` int(11) DEFAULT NULL,
  `journal_no` varchar(120) NOT NULL,
  `report_date` date NOT NULL,
  `lot_name` varchar(191) DEFAULT NULL,
  `weather` varchar(120) DEFAULT NULL,
  `work_shift` varchar(40) NOT NULL DEFAULT 'Jour',
  `workforce_count` int(11) NOT NULL DEFAULT 0,
  `quantity_done` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unit_label` varchar(50) DEFAULT NULL,
  `progress_percent` decimal(8,2) NOT NULL DEFAULT 0.00,
  `team_summary` text DEFAULT NULL,
  `equipment_summary` text DEFAULT NULL,
  `equipment_hours` decimal(10,2) NOT NULL DEFAULT 0.00,
  `material_summary` text DEFAULT NULL,
  `payroll_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `equipment_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `material_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subcontract_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `other_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'saisi',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `reference` varchar(120) NOT NULL,
  `status` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `company_id`, `name`, `reference`, `status`, `created_at`) VALUES
(1, 2, 'INTERBANK Burundi', 'PRJ-2026-00001', 'En cours', '2026-04-29 10:26:23'),
(2, 2, 'Villa 3et4 Brarudi Gitega', 'PRJ-2026-00002', 'En cours', '2026-04-29 11:28:33'),
(3, 2, 'DEVIS ROOFTOP BANCOBU', 'PRJ-2026-00003', 'En cours', '2026-04-30 09:43:51'),
(4, 2, 'RENOVATION OUA', 'PRJ-2026-00004', 'En cours', '2026-04-30 09:47:30'),
(5, 2, 'KINANIRA ELIANE', 'PRJ-2026-00005', 'En cours', '2026-04-30 09:53:35'),
(7, 2, 'GIHOSHA MPUNDU', 'PRJ-2026-00006', 'En cours', '2026-04-30 10:07:10'),
(8, 2, 'TEMOINS DE JEHOVAH', 'PRJ-2026-00007', 'En cours', '2026-04-30 10:38:24'),
(9, 2, 'KABEZI', 'PRJ-2026-00008', 'En cours', '2026-04-30 10:42:20'),
(10, 2, 'KING\'S SCHOOL', 'PRJ-2026-00009', 'En cours', '2026-04-30 10:44:39'),
(11, 2, 'GIHOSHA ZONE', 'PRJ-2026-00010', 'En cours', '2026-04-30 10:45:54'),
(12, 2, 'GIHOSHA APPARTEMENT', 'PRJ-2026-00011', 'En cours', '2026-04-30 10:46:13'),
(13, 2, 'EDEN GARDEN APPARTEMENT', 'PRJ-2026-00012', 'En cours', '2026-04-30 10:46:37'),
(14, 2, 'MUHA', 'PRJ-2026-00013', 'En cours', '2026-04-30 10:46:56'),
(15, 2, 'KAZOZA  KAMENGE', 'PRJ-2026-00014', 'En cours', '2026-05-04 08:40:28'),
(16, 2, 'MUZINDA', 'PRJ-2026-00015', 'En cours', '2026-05-04 08:40:54'),
(17, 2, 'LARGE APPARTEMENT', 'PRJ-2026-00016', 'En cours', '2026-05-04 08:41:38'),
(18, 2, 'NYABUGETE DR ERIC', 'PRJ-2026-00017', 'En cours', '2026-05-04 08:41:54'),
(19, 2, 'GAKUNGWE', 'PRJ-2026-00018', 'En cours', '2026-05-04 08:42:17'),
(20, 2, 'JABE SDA', 'PRJ-2026-00019', 'En cours', '2026-05-04 08:42:50'),
(21, 2, 'GATOKE', 'PRJ-2026-00020', 'En cours', '2026-05-07 13:55:44'),
(22, 2, 'KININDO APPARTEMENT', 'PRJ-2026-00021', 'En cours', '2026-05-07 13:56:54'),
(23, 2, 'GIHOSHA NDAYI', 'PRJ-2026-00022', 'En cours', '2026-05-07 15:32:50'),
(24, 2, 'KINANIRA 3', 'PRJ-2026-00023', 'En cours', '2026-05-07 15:34:35'),
(25, 2, 'Fonctionnemnt bureau', 'PRJ-2026-00024', 'En cours', '2026-05-08 14:37:22'),
(26, 2, 'MRRIOIR', 'PRJ-2026-00025', 'En cours', '2026-05-11 11:55:57'),
(27, 2, 'GASENYI Presidence', 'PRJ-2026-00026', 'En cours', '2026-05-11 15:28:45'),
(28, 2, 'Projet Pave', 'PRJ-2026-00027', 'En cours', '2026-05-29 15:28:51'),
(29, 2, 'Maramvya Brique Cute', 'PRJ-2026-00028', 'En cours', '2026-05-29 15:30:03'),
(30, 2, 'Bloque Ciment', 'PRJ-2026-00029', 'En cours', '2026-06-11 09:03:06'),
(31, 2, 'Consultance', 'PRJ-2026-00030', 'En cours', '2026-06-11 14:01:57');

-- --------------------------------------------------------

--
-- Structure de la table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `reference` varchar(120) NOT NULL,
  `supplier_name` varchar(191) NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `purchase_requests`
--

CREATE TABLE `purchase_requests` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `requested_by_user_id` int(11) DEFAULT NULL,
  `request_ref` varchar(120) NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `budget_line_id` int(11) DEFAULT NULL,
  `estimated_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `priority` varchar(30) NOT NULL DEFAULT 'normale',
  `status` varchar(40) NOT NULL DEFAULT 'brouillon',
  `current_step` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `purchase_requests`
--

INSERT INTO `purchase_requests` (`id`, `company_id`, `chantier_id`, `supplier_id`, `requested_by_user_id`, `request_ref`, `title`, `description`, `budget_line_id`, `estimated_amount`, `priority`, `status`, `current_step`, `created_at`) VALUES
(1, 2, 4, NULL, 37, 'Mastic de fer', 'Soudure', '', NULL, 900000.00, 'haute', 'en_validation', 1, '2026-05-06 13:34:25'),
(2, 2, 4, NULL, 22, 'Antirouille', 'la soudure', 'Six boites pour 70.000 chacun', NULL, 420000.00, 'haute', 'commandée', 0, '2026-05-06 13:38:31'),
(3, 2, 4, NULL, 37, 'Granulats', 'Maçonnerie', '', NULL, 60000.00, 'normale', 'en_validation', 1, '2026-05-06 13:42:37'),
(4, 2, 4, NULL, 37, 'Briques', 'Maçonnerie', '', NULL, 70000.00, 'normale', 'commandée', 0, '2026-05-06 13:45:55'),
(5, 2, 4, NULL, 37, 'Briques', 'Maçonnerie', '', NULL, 70000.00, 'normale', 'commandée', 0, '2026-05-06 13:46:29'),
(7, 2, 2, NULL, 37, 'Fonctionnement', 'Chargement déchargement echaffaudage', '', NULL, 130000.00, 'normale', 'brouillon', 0, '2026-05-08 09:06:32'),
(8, 2, 18, NULL, 43, 'MANIRAGABA SERGES', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:40:39'),
(9, 2, 18, NULL, 43, 'NIYONKURU J DE DIEU', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:41:49'),
(10, 2, 18, NULL, 43, 'NIYITEGEKA JACQUES', 'RESTAURATION', '', NULL, 3000.00, 'normale', 'brouillon', 0, '2026-05-08 14:43:01'),
(11, 2, 18, NULL, 43, 'HABONIMANA ANIELLA', 'RESTAURATION', '', NULL, 12000.00, 'normale', 'brouillon', 0, '2026-05-08 14:44:04'),
(12, 2, 18, NULL, 43, 'TUYISABE SEVERIN', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:44:50'),
(13, 2, 18, NULL, 43, 'NDUZAYO EMMANUEL', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:46:09'),
(14, 2, 18, NULL, 43, 'MANIRAKIWA MICHEL', 'RESTAURATION', '', NULL, 24000.00, 'normale', 'brouillon', 0, '2026-05-08 14:48:08'),
(15, 2, 18, NULL, 43, 'NDIKUMANA ERIC', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:48:52'),
(16, 2, 18, NULL, 43, 'NAHI?ANA RAMLA', 'RESTAURATION', '', NULL, 24000.00, 'normale', 'brouillon', 0, '2026-05-08 14:49:52'),
(17, 2, 18, NULL, 43, 'NKORERIMANA EMMANUEL', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:50:46'),
(18, 2, 18, NULL, 43, 'MARURU NDEKO', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:51:30'),
(19, 2, 18, NULL, 43, 'NKESHIMANA COME', 'RESTAURATION', '', NULL, 12000.00, 'normale', 'brouillon', 0, '2026-05-08 14:52:18'),
(20, 2, 18, NULL, 43, 'NIBITANGA FABRICE', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:53:00'),
(21, 2, 18, NULL, 43, 'HABINGABZA GEDEON', 'RESTAURATION', '', NULL, 21000.00, 'normale', 'brouillon', 0, '2026-05-08 14:54:04'),
(22, 2, 18, NULL, 43, 'DUSHIME KERCY MERVEILLE', 'RESTAURATION', '', NULL, 24000.00, 'normale', 'brouillon', 0, '2026-05-08 14:56:44'),
(23, 2, 18, NULL, 43, 'IRAKOWE ALPHA', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:57:51'),
(24, 2, 18, NULL, 43, 'IRAKOWE CLAUDE', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:58:28'),
(25, 2, 18, NULL, 43, 'NKURUNZIZA ALEXIS', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 14:59:22'),
(26, 2, 10, NULL, 43, 'AHISHAKIYE NELLY ANGE', 'RESTAURATION', '', NULL, 24000.00, 'normale', 'brouillon', 0, '2026-05-08 15:00:42'),
(27, 2, 18, NULL, 43, 'JEANNETTE MOSES', 'RESTAURATION', '', NULL, 18000.00, 'normale', 'brouillon', 0, '2026-05-08 15:02:10'),
(28, 2, 18, NULL, 43, 'RUTH ZKARIAS', 'RESTAURATION', '', NULL, 24000.00, 'normale', 'brouillon', 0, '2026-05-08 15:03:20'),
(29, 2, 18, NULL, 43, 'NISHIMWE OLIVIER', 'RESTAURATION', '', NULL, 9000.00, 'normale', 'brouillon', 0, '2026-05-08 15:04:19'),
(30, 2, 18, NULL, 43, 'RUGAMIRA J MARIE', 'RESTAURATION', '', NULL, 24000.00, 'normale', 'brouillon', 0, '2026-05-08 15:05:27'),
(31, 2, 18, NULL, 43, 'INGABIRE ELGA', 'RESTAURATION', '', NULL, 24000.00, 'normale', 'brouillon', 0, '2026-05-08 15:06:21'),
(32, 2, 18, NULL, 43, 'IRUTAVYOSE F AXCEL', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 15:07:16'),
(33, 2, 18, NULL, 43, 'MUNEWERO NADIA', 'RESTAURATION', '', NULL, 18000.00, 'normale', 'brouillon', 0, '2026-05-08 15:08:21'),
(34, 2, 18, NULL, 43, 'KWIWERIMANA EMERY', 'RESTAURATION', '', NULL, 18000.00, 'normale', 'brouillon', 0, '2026-05-08 15:09:02'),
(35, 2, 18, NULL, 43, 'GENEVIEVE', 'RESTAURATION', '', NULL, 18000.00, 'normale', 'brouillon', 0, '2026-05-08 15:09:46'),
(36, 2, 18, NULL, 43, 'ARAKAZA ARNAUD', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 15:10:44'),
(37, 2, 18, NULL, 43, 'HEWAGIRA ORLY', 'RESTAURATION', '', NULL, 27000.00, 'normale', 'brouillon', 0, '2026-05-08 15:12:41'),
(38, 2, 18, NULL, 28, 'MANIRAGABA Serges', 'Service rendu', 'Frais de déchargement d\'un table de bureau vendredi le 08/05/2026', NULL, 10000.00, 'normale', 'commandée', 0, '2026-05-11 13:50:22'),
(39, 2, 18, NULL, 28, 'NDUWAYO EMMANUEL', 'Service rendu', 'frais de deplacement vers ADB ET VIRAGO (OBR)', NULL, 8000.00, 'normale', 'commandée', 0, '2026-05-11 13:54:45'),
(40, 2, 18, NULL, 28, 'NKESHIMANA COME', 'Service rendu', 'FRAIS RATIONS ET ROUTIERS POUR LES CHAUFFEURS', NULL, 700000.00, 'haute', 'commandée', 0, '2026-05-11 14:00:26'),
(41, 2, 3, NULL, 36, 'NIBITANGA                 FABRICE', 'Etude de reconnaissance géotechnique du sol', 'Prestation de service pour les études de reconnaissance geotechnique du sol.Les etudes sont deja terminées et le rapport est deja remis', NULL, 850000.00, 'haute', 'brouillon', 0, '2026-05-11 14:10:35'),
(42, 2, 18, NULL, 23, 'ch', 'chaussure de terrain', '', NULL, 200000.00, 'normale', 'brouillon', 0, '2026-05-12 11:52:06'),
(43, 2, 18, NULL, 27, 'MANIRAGABA SERGES', 'Assurance automobile G34445A', 'ASSURANCE ANNUELLE', NULL, 125885.00, 'normale', 'brouillon', 0, '2026-05-26 15:17:02'),
(44, 2, 18, NULL, 27, 'MANIRAGABA SERGES', 'ASSURANCE E4924A', 'ASSURANCE ANNUELLE HILUX E4924A', NULL, 167618.00, 'normale', 'commandée', 0, '2026-05-26 15:20:45'),
(45, 2, 18, NULL, 27, 'MANIRAGABA SERGES', 'ASSURANCE E1070A', 'ASSURANCE ANNUELLE MERCEDES BENZ E1070A', NULL, 149464.00, 'normale', 'commandée', 0, '2026-05-26 15:26:03'),
(46, 2, 18, NULL, 27, 'MANIRAGABA SERGES', 'AVANCE SUR SALAIRE MOIS DE MAI 2026', '', NULL, 50000.00, 'normale', 'brouillon', 0, '2026-06-01 09:53:43'),
(47, 2, 18, NULL, 27, 'MANIRAGABA SERGES', 'AVANCE SUR SALAIRE', '', NULL, 50000.00, 'haute', 'commandée', 0, '2026-06-01 10:01:15');

-- --------------------------------------------------------

--
-- Structure de la table `purchase_request_forms`
--

CREATE TABLE `purchase_request_forms` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `destination_chantier` varchar(191) NOT NULL,
  `requested_by` varchar(191) NOT NULL,
  `buyer_name` varchar(191) DEFAULT NULL,
  `category_type` varchar(50) NOT NULL DEFAULT 'chantier',
  `requires_validation` tinyint(1) NOT NULL DEFAULT 1,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `verified_by` varchar(191) DEFAULT NULL,
  `technical_approver` varchar(191) DEFAULT NULL,
  `financial_approver` varchar(191) DEFAULT NULL,
  `dg_approver` varchar(191) DEFAULT NULL,
  `treasurer_name` varchar(191) DEFAULT NULL,
  `verifier_status` varchar(40) NOT NULL DEFAULT 'en_attente',
  `technical_status` varchar(40) NOT NULL DEFAULT 'en_attente',
  `financial_status` varchar(40) NOT NULL DEFAULT 'en_attente',
  `dg_status` varchar(40) NOT NULL DEFAULT 'en_attente',
  `treasury_status` varchar(40) NOT NULL DEFAULT 'en_attente',
  `supplier_followup` text DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `workflow_status` varchar(50) NOT NULL DEFAULT 'brouillon',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `purchase_request_forms`
--

INSERT INTO `purchase_request_forms` (`id`, `company_id`, `chantier_id`, `destination_chantier`, `requested_by`, `buyer_name`, `category_type`, `requires_validation`, `total_amount`, `verified_by`, `technical_approver`, `financial_approver`, `dg_approver`, `treasurer_name`, `verifier_status`, `technical_status`, `financial_status`, `dg_status`, `treasury_status`, `supplier_followup`, `request_date`, `notes`, `workflow_status`, `created_by`, `created_at`) VALUES
(1, 2, 0, 'KINGS', 'DIEUDONNE', 'MICHEL', 'chantier', 1, 900000.00, 'DAVID', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-06', '', 'en_verification', 0, '2026-05-06 13:55:25'),
(2, 2, 0, 'KINGS', 'DIEUDONNE', 'MICHEL', 'chantier', 1, 2325000.00, 'DAVID', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-06', 'DEMANDES KINGS', 'en_verification', 0, '2026-05-06 14:06:03'),
(3, 2, 0, 'TEMOINS DE JEHOVAH', 'MICHEL', '', 'chantier', 1, 130000.01, 'Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-08', '', 'en_verification', 0, '2026-05-08 09:09:32'),
(4, 2, 0, 'IBB entrepots', 'Ir Nsengiyumva Eric', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 1860000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-08', '', 'simplifie', 0, '2026-05-08 14:39:26'),
(5, 2, 0, 'Fonctionnemnt bureau', 'NAHIMANA Ramla', 'NAHIMANA Ramla', 'fonctionnement', 0, 177500.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-11', '', 'traite', 0, '2026-05-11 09:09:31'),
(6, 2, 0, 'KINGS', 'Ndihokubwayo Michel', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 5700000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'simplifie', 0, '2026-05-11 09:11:21'),
(7, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'fonctionnement', 0, 3201750.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-11', '', 'traite', 0, '2026-05-11 09:15:30'),
(8, 2, 0, 'GIHOSHA APPARTEMENT', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 1140000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'simplifie', 0, '2026-05-11 09:42:40'),
(9, 2, 0, 'GIHOSHA ZONE', 'Dionesie', 'Habonimana Anniella', 'fonctionnement', 0, 1797000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-11', '', 'traite', 0, '2026-05-11 09:46:55'),
(10, 2, 0, 'Gihosha Ndayi', 'Ir Claude', 'Nkorerimana Emmanuel', 'chantier', 1, 1140000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'en_verification', 0, '2026-05-11 10:19:43'),
(11, 2, 0, 'KINGS', 'NDIHOKUBWAYO MICHEL', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 5760000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-11', '', 'traite', 0, '2026-05-11 11:14:54'),
(12, 2, 0, 'GIHOSHA ZONE', 'DIONESIE', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 1152000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-11', '', 'traite', 0, '2026-05-11 11:22:15'),
(13, 2, 0, 'IBB entrepots', 'NSENGIYUMVA ERIC', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 936000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-11', '', 'traite', 0, '2026-05-11 11:26:06'),
(14, 2, 0, 'KINANIRA 3', 'Habonimana Claude', 'Nkorerimana Emmanuel', 'chantier', 1, 500000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-11', '', 'approuve', 0, '2026-05-11 11:28:22'),
(15, 2, 0, 'KABEZI', 'Maurice', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 1152000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-11', '', 'traite', 0, '2026-05-11 11:33:52'),
(16, 2, 0, 'Chantier Mirroir', 'Viollete', 'Maniragaba Serges', 'fonctionnement', 0, 500000.00, 'Violette Magasiniere', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-11', '', 'traite', 0, '2026-05-11 12:06:23'),
(17, 2, 0, 'projet Maramvya', 'Niyonkuru', '', 'chantier', 1, 16000000.00, 'NIYONKURU J de Dieu', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'en_verification', 0, '2026-05-11 13:25:49'),
(18, 2, 0, 'Fonctionnemnt bureau', 'Orly', 'Axcel', 'fonctionnement', 0, 100.00, 'Axcel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', 'StarLink', '2026-05-11', '', 'traite', 0, '2026-05-11 13:56:22'),
(19, 2, 0, 'KINGS', 'Dieu donné', 'Michel', 'fonctionnement', 0, 900000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'en_attente', '', '2026-05-11', '', 'validation_financiere', 0, '2026-05-11 14:14:09'),
(20, 2, 0, 'Fonctionnemnt bureau', 'Nkeshimana', 'Come', 'chantier', 1, 700000.00, 'DAF', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'valide', 'en_attente', 'en_attente', '', '2026-05-11', '', 'validation_financiere', 0, '2026-05-11 14:21:13'),
(21, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'fonctionnement', 0, 700000.00, 'Emmanuel(DAWE)', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'en_attente', '', '2026-05-11', '', 'validation_financiere', 0, '2026-05-11 14:25:14'),
(22, 2, 0, 'GIHOSHA NDAYI', 'Vedaste', 'Habonimana Anniella', 'chantier', 1, 7200000.00, 'Emmanuel(DAWE)', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-11', '', 'approuve', 0, '2026-05-11 14:28:04'),
(23, 2, 0, 'KINANIRA 3', 'Patrick', 'Habonimana Anniella', 'chantier', 1, 1899500.00, 'Emmanuel(DAWE)', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'en_verification', 0, '2026-05-11 14:53:55'),
(24, 2, 0, 'JABE SDA', 'Ir Kévin', 'Michel', 'chantier', 1, 2868000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'en_verification', 0, '2026-05-11 14:55:34'),
(25, 2, 0, 'KINANIRA 3', 'HATEGEKIMANA CLAUDE', 'Habonimana Anniella', 'fonctionnement', 0, 1067500.00, 'Emmanuel(DAWE)', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'simplifie', 0, '2026-05-11 14:57:54'),
(26, 2, 0, 'JABE SDA', 'Ir kévin NIRERA', 'Michel Manirakiza', 'chantier', 1, 2000000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'validation_technique', 0, '2026-05-11 15:01:31'),
(27, 2, 0, 'Fonctionnemnt bureau', 'Kwizerimana Emery (Lundi)', 'Kwizerimana Emery', 'chantier', 1, 35000.00, 'MARIAM', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-11', '', 'approuve', 0, '2026-05-11 15:05:30'),
(28, 2, 0, 'Fonctionnemnt bureau', 'Kwizerimana Emery (Mardi)', 'Kwizerimana Emery', 'chantier', 1, 58500.00, 'MARIAM', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'en_verification', 0, '2026-05-11 15:07:33'),
(29, 2, 0, 'JABE SDA', 'Ir kévin NIRERA', 'Michel Manirakiza', 'chantier', 1, 1728000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'validation_technique', 0, '2026-05-11 15:07:36'),
(30, 2, 0, 'Fonctionnemnt bureau', 'Kwizerimana Emery (Mercredi)', 'Kwizerimana Emery', 'chantier', 1, 40000.00, 'MARIAM', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'en_verification', 0, '2026-05-11 15:14:16'),
(31, 2, 0, 'Fonctionnemnt bureau', 'Kwizerimana Emery (Vendredi)', 'Kwizerimana Emery', 'chantier', 1, 58500.00, 'MARIAM', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'en_verification', 0, '2026-05-11 15:15:46'),
(32, 2, 0, 'KINGS', 'Ir Dieu donné', 'Michel Manirakiza', 'chantier', 1, 1590000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', 'Seven', '2026-05-11', '', 'validation_technique', 0, '2026-05-11 15:17:11'),
(33, 2, 0, 'Chantier Mirroir', 'Uwizigra Violette', 'Habonimana Anniella', 'fonctionnement', 0, 10581000.00, 'Emmanuel(DAWE)', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'simplifie', 0, '2026-05-11 15:21:04'),
(34, 2, 0, 'Fonctionnemnt bureau', 'NIYONKURU J de Dieu', '', 'chantier', 1, 540000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'en_attente', '', '2026-05-11', '', 'validation_financiere', 0, '2026-05-11 15:21:24'),
(35, 2, 0, 'Chantier Mirroir', 'Uwizigra Violette', 'Habonimana Anniella', 'fonctionnement', 0, 5760000.00, 'Emmanuel(DAWE)', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'simplifie', 0, '2026-05-11 15:23:05'),
(36, 2, 0, 'Chantier Mirroir', 'Uwizigra Violette', 'Habonimana Anniella', 'fonctionnement', 0, 1050000.00, 'Emmanuel(DAWE)', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'simplifie', 0, '2026-05-11 15:25:51'),
(37, 2, 0, 'GASENYI Presidence', 'Habonimana Anniella', 'Habonimana Anniella', 'fonctionnement', 0, 2084000.00, 'Emmanuel(DAWE)', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'simplifie', 0, '2026-05-11 15:35:04'),
(38, 2, 0, 'GASENYI Presidence', 'Habonimana Anniella', 'Habonimana Anniella', 'fonctionnement', 0, 6852000.00, 'Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'validation_technique', 0, '2026-05-11 15:41:51'),
(39, 2, 0, 'KABEZI', 'Ing.   MUKESHIMANA            Philippe', '', 'chantier', 1, 850000.00, 'Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'valide', 'en_attente', 'en_attente', '', '2026-05-11', '', 'validation_financiere', 0, '2026-05-11 16:06:54'),
(40, 2, 0, 'Fonctionnemnt bureau', 'Kwizerimana Emery', 'Kwizerimana Emery', 'fonctionnement', 0, 279500.00, 'MARIAM', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'simplifie', 0, '2026-05-11 16:23:12'),
(41, 2, 0, 'KABEZI', 'Ndacayisaba Maurice', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 2278400.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-12', '', 'traite', 0, '2026-05-12 08:46:59'),
(42, 2, 0, 'CIBITOKE/HOPITAL UBUNTU', 'NIYOMWUNGERE          Blaise', '', 'chantier', 1, 300000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-12', '', 'validation_financiere', 0, '2026-05-12 08:51:09'),
(43, 2, 0, 'IBB entrepots', 'HABONIMANA MOISE', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 4985000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'en_attente', '', '2026-05-12', '', 'validation_financiere', 0, '2026-05-12 09:13:08'),
(44, 2, 0, 'Fonctionnemnt bureau', 'IGIRUMWETE Pischon', '', 'chantier', 1, 20000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-12', '', 'approuve', 0, '2026-05-12 09:15:13'),
(45, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 8000000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'en_attente', '', '2026-05-12', '', 'validation_financiere', 0, '2026-05-12 09:16:28'),
(46, 2, 0, 'Fonctionnemnt', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 200000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'en_attente', '', '2026-05-12', '', 'validation_financiere', 0, '2026-05-12 09:17:13'),
(47, 2, 0, 'IBB entrepots', 'Ir Nsengiyumva Eric', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 2424000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-12', '', 'traite', 0, '2026-05-12 09:24:00'),
(48, 2, 0, 'Fonctionnemnt bureau', 'IRAKOZE Claude', '', 'chantier', 1, 200000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'en_attente', '', '2026-05-12', '', 'validation_financiere', 0, '2026-05-12 09:39:57'),
(49, 2, 0, 'Fonctionnemnt bureau', 'NISHIMWE Olivier', '', 'chantier', 1, 200000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-12', '', 'validation_financiere', 0, '2026-05-12 09:40:56'),
(50, 2, 0, 'MUHA', 'CISHAHAYO ELIE MOSES', '', 'chantier', 1, 114000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'en_attente', '', '2026-05-12', '', 'validation_financiere', 0, '2026-05-12 10:17:19'),
(51, 2, 0, 'KINANIRA 3', 'Vital', 'Habonimana Anniella', 'chantier', 1, 276600.00, 'Emmanuel dawe', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-12', '', 'en_verification', 0, '2026-05-12 10:21:16'),
(52, 2, 0, 'KINANIRA 3', 'Vital', 'Habonimana Anniella', 'chantier', 1, 180600.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-03-25', '', 'approuve', 0, '2026-05-12 10:21:16'),
(53, 2, 0, 'Fonctionnemnt bureau', 'Jeannette Moses', 'Jeannette Moses', 'fonctionnement', 0, 1720000.00, 'Daf', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'en_attente', '', '2026-05-12', '', 'validation_financiere', 0, '2026-05-12 10:27:48'),
(54, 2, 0, 'Fonctionnemnt bureau', 'Jean Marie Rugamira', 'Jean Marie Rugamira', 'fonctionnement', 0, 100000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-12', '', 'traite', 0, '2026-05-12 10:30:46'),
(55, 2, 0, 'Fonctionnemnt bureau', 'ALEXIS', 'Alexis', 'fonctionnement', 0, 200000.00, 'Ir DAVID', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-12', '', 'traite', 0, '2026-05-12 11:15:09'),
(56, 2, 0, 'Témoins de Jéhovah', 'Ir Claude', 'Michel Manirakiza', 'chantier', 1, 75000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-12', '', 'validation_technique', 0, '2026-05-12 11:55:16'),
(57, 2, 0, 'King\'s school', 'CIZA Claver', 'Michel Manirakiza', 'chantier', 1, 12332200.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-12', '', 'validation_technique', 0, '2026-05-12 13:22:32'),
(58, 2, 0, 'Eden garden lll', 'Ir Janvier NDAYIZEYE', 'Michel Manirakiza', 'chantier', 1, 300000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-12', '', 'approuve', 0, '2026-05-12 13:38:29'),
(59, 2, 0, 'Eden garden lll', 'Ir Janvier NDAYIZEYE', 'Michel Manirakiza', 'chantier', 1, 3180900.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-12', '', 'validation_technique', 0, '2026-05-12 13:58:30'),
(60, 2, 0, 'Témoins de Jéhovah', 'NKESHIMANA Vincent', 'Michel Manirakiza', 'chantier', 1, 200000.00, 'Ir David EMERUSABE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-12', '', 'approuve', 0, '2026-05-12 14:16:25'),
(61, 2, 0, 'Témoins de Jéhovah', 'NKESHIMANA Vincent', 'Michel Manirakiza', 'chantier', 1, 200000.00, 'Ir David EMERUSABE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'en_attente', '', '2026-05-12', '', 'validation_financiere', 0, '2026-05-12 14:20:35'),
(62, 2, 0, 'Fonctionnemnt bureau', 'Niyonkuru Jean de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 200000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-12', '', 'simplifie', 0, '2026-05-12 14:42:49'),
(63, 2, 0, 'Fonctionnemnt', 'NDUWAYO EMMANUEL', 'NDUWAYO EMMANUEL', 'fonctionnement', 0, 10000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-11', '', 'simplifie', 0, '2026-05-12 14:46:20'),
(64, 2, 0, 'IBB entrepots', 'NSENGIYUMVA           Arnaud', '', 'chantier', 1, 150000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-12', '', 'approuve', 0, '2026-05-12 16:48:26'),
(65, 2, 0, 'Fonctionnemnt bureau', 'NIYONKURU J de Dieu', '', 'chantier', 1, 2700000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-13', '', 'validation_technique', 0, '2026-05-13 09:15:20'),
(66, 2, 0, 'MUHA', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 1380000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-13', '', 'approuve', 0, '2026-05-13 09:26:31'),
(67, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 62000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-13', '', 'traite', 0, '2026-05-13 09:26:36'),
(68, 2, 0, 'Fonctionnemnt bureau', 'HABINGABWA GEDEON', 'HABINGABWA GEDEON', 'fonctionnement', 0, 70000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-13', '', 'traite', 0, '2026-05-13 11:44:46'),
(69, 2, 0, 'Fonctionnemnt bureau', 'NAHIMANA Ramla', 'KWIZERIMANA Emery', 'fonctionnement', 0, 30000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-13', '', 'traite', 0, '2026-05-13 12:04:48'),
(70, 2, 0, 'Fonctionnemnt bureau', 'DAVID', 'ALEXIS', 'chantier', 1, 200000.00, 'DAVID', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-13', '', 'en_verification', 0, '2026-05-13 12:07:18'),
(71, 2, 0, 'Fonctionnemnt bureau', 'NAHIMANA Ramla', 'NSHIMIRIMANA Aaron', 'chantier', 1, 3000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-13', '', 'en_verification', 0, '2026-05-13 12:23:48'),
(72, 2, 0, 'Fonctionnemnt bureau', 'NIYONKURU J de Dieu', '', 'chantier', 1, 1500000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-13', '', 'validation_technique', 0, '2026-05-13 12:47:53'),
(73, 2, 0, 'Fonctionnemnt bureau', 'NTAKIRUTIMANA  EUPREM', 'NIYONKURU Jean de Dieu', 'chantier', 1, 10000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-13', '', 'validation_financiere', 0, '2026-05-13 13:24:15'),
(74, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'HABONIMANA Anniella', 'chantier', 1, 300000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-13', '', 'approuve', 0, '2026-05-13 14:17:26'),
(75, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 6000000.00, 'Emmanuel dawe', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-13', '', 'validation_technique', 0, '2026-05-13 14:20:03'),
(76, 2, 0, 'GIHOSHA ZONE', 'Dionisie', 'Habonimana Anniella', 'chantier', 1, 6000000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-13', '', 'validation_technique', 0, '2026-05-13 14:21:14'),
(77, 2, 0, 'FONCTIONNEMENT', 'NDUWAYO EMMANUEL', 'NDUWAYO Emmanuel', 'fonctionnement', 0, 100000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-13', '', 'traite', 0, '2026-05-13 14:28:11'),
(78, 2, 0, 'GIHOSHA APPARTEMENT', 'Dionisie', 'Habonimana Anniella', 'chantier', 1, 2997500.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-13', '', 'approuve', 0, '2026-05-13 14:34:15'),
(79, 2, 0, 'Fonctionnemnt bureau', 'Chauffeur Thierry', 'Niyitegeka Jacques', 'fonctionnement', 0, 1785000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-13', '', 'validation_technique', 0, '2026-05-13 15:19:39'),
(80, 2, 0, 'Fonctionnemnt bureau', 'NAHIMANA Ramla', 'NIYIMBONA Emmanuel', 'chantier', 1, 592000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-13', '', 'en_verification', 0, '2026-05-13 16:17:32'),
(81, 2, 0, 'Fonctionnemnt bureau', 'Chauffeur Thierry', 'Niyitegeka Jacques', 'fonctionnement', 0, 457000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-13', '', 'simplifie', 0, '2026-05-13 16:25:55'),
(82, 2, 0, 'KINANIRA 3', 'HATEGEKIMANA CLAUDE', 'Habonimana Anniella', 'fonctionnement', 0, 759000.00, 'Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-13', '', 'traite', 0, '2026-05-13 16:42:43'),
(83, 2, 0, 'KINANIRA 3', 'Patrick', 'Habonimana Anniella', 'chantier', 1, 455000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 09:06:14'),
(84, 2, 0, 'Fonctionnemnt bureau', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1500000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 09:12:51'),
(85, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 2880000.00, 'Emmanuel dawe', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-15', '', 'en_verification', 0, '2026-05-15 09:12:54'),
(86, 2, 0, 'Fonctionnemnt bureau', 'NIYONKURU J de Dieu', '', 'chantier', 1, 1350000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 09:30:35'),
(87, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 748800.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 10:07:35'),
(88, 2, 0, 'GIHOSHA ZONE', 'Dionisie', 'Habonimana Anniella', 'chantier', 1, 748800.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 10:08:51'),
(89, 2, 0, 'King\'s school', 'Samson', 'Habonimana Anniella', 'chantier', 1, 748800.00, 'Emmanuel  DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 10:10:38'),
(90, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', 'NKESHIMANA COME', 'chantier', 1, 300000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 10:30:00'),
(91, 2, 0, 'IBB entrepots', 'NSENGIYUMVA             Eric', 'NKORERIMANA       Emmanuel', 'chantier', 1, 1280000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'en_attente', 'valide', 'en_attente', 'en_attente', '', '2026-05-15', '', 'validation_financiere', 0, '2026-05-15 10:51:24'),
(92, 2, 0, 'KABEZI', 'NDACAYISABA    Maurice', 'NKORERIMANA       Emmanuel', 'chantier', 1, 576000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 10:53:11'),
(93, 2, 0, 'MUHA', 'NINDAMUTSA         Adelin', 'NKORERIMANA       Emmanuel', 'chantier', 1, 275500.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 10:56:45'),
(94, 2, 0, 'Fonctionnemnt bureau', 'NIYONKURU J de Dieu', 'Jeean de Dieu', 'chantier', 1, 1200000.00, 'dt', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 10:56:52'),
(95, 2, 0, 'IBB entrepots', 'Ir Nsengiyumva Eric', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 1152000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-15', '', 'simplifie', 0, '2026-05-15 10:59:34'),
(96, 2, 0, 'CIBITOKE', 'NIYOMWUNGERE Blaise', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 150000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'traite', 0, '2026-05-15 11:18:41'),
(97, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 120000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 11:18:56'),
(98, 2, 0, 'TEMOINS DE JEHOVAH', 'Nkorerimana', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 500000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'traite', 0, '2026-05-15 11:25:16'),
(99, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 500000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 11:38:37'),
(100, 2, 0, 'King\'s school', 'Ir Michel NDIHOKUBWAYO', 'Michel Manirakiza', 'chantier', 1, 5760000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-15', '', 'en_verification', 0, '2026-05-15 11:50:50'),
(101, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 500000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'traite', 0, '2026-05-15 12:04:28'),
(102, 2, 0, 'Témoins de Jéhovah', 'Ir Claude', 'Michel Manirakiza', 'chantier', 1, 1065000.00, 'Ir David EMERUSABE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 12:55:54'),
(103, 2, 0, 'King\'s school', 'HABONIMANA Moïse', 'Michel Manirakiza', 'chantier', 1, 2325000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-15', '', 'en_verification', 0, '2026-05-15 13:31:57'),
(104, 2, 0, 'Fonctionnemnt', 'NDUWAYO EMMANUEL', 'NDUWAYO Emmanuel', 'fonctionnement', 0, 140000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'traite', 0, '2026-05-15 13:36:59'),
(105, 2, 0, 'KING\'S SCHOOL', 'NDUWAYO EMMANUEL', 'NDUWAYO EMMANUEL', 'fonctionnement', 0, 1000000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'traite', 0, '2026-05-15 13:40:54'),
(106, 2, 0, 'Fonctionnemnt', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 540000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 13:42:21'),
(107, 2, 0, 'King\'s school', 'NDAYISHIMIYE Yvan', 'Michel Manirakiza', 'chantier', 1, 2380000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 14:11:06'),
(108, 2, 0, 'King\'s school', 'NDAYISHIMIYE Yvan', 'Michel Manirakiza', 'chantier', 1, 945000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 14:36:33'),
(109, 2, 0, 'King\'s school', 'NIYINDAMUTSA Adelin', 'Michel Manirakiza', 'chantier', 1, 4703000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 14:54:34'),
(110, 2, 0, 'Fonctionnemnt bureau', 'Kwizerimana Emery', 'Habonimana Anniella', 'chantier', 1, 148000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 15:00:40'),
(111, 2, 0, 'King\'s school', 'NIYINDAMUTSA Adelin', 'Michel Manirakiza', 'chantier', 1, 1980000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-15', '', 'validation_technique', 0, '2026-05-15 15:20:05'),
(112, 2, 0, 'King\'s school', 'NIYINDAMUTSA Adelin', 'Michel Manirakiza', 'chantier', 1, 2166500.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-15', '', 'validation_technique', 0, '2026-05-15 15:20:08'),
(113, 2, 0, 'Fonctionnement', 'Gaheta', 'Habonimana Anniella', 'chantier', 1, 100000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 15:35:26'),
(114, 2, 0, 'Fonctionnemnt', 'Nahimana Ramla', 'Nahimana Ramla', 'fonctionnement', 0, 351000.00, 'MANIRAGABA, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'rejete', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'traite', 0, '2026-05-15 15:53:43'),
(115, 2, 0, 'Fonctionnemnt', 'Nahimana Ramla', 'Nahimana Ramla', 'chantier', 1, 696000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-08', '', 'approuve', 0, '2026-05-15 15:55:43'),
(116, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 55000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-15', '', 'approuve', 0, '2026-05-15 16:18:58'),
(117, 2, 0, 'KABEZI, GIHOSHA NDAYI, GIHOSHA ZONE APPARTEMENT', 'Ndacayisaba Maurice', 'Nkorerimana Emmanuel', 'chantier', 1, 2592000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 09:06:50'),
(118, 2, 0, 'IBB entrepots', 'Ir Nsengiyumva Eric', 'Nkorerimana Emmanuel', 'chantier', 1, 1305000.00, 'Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-18', '', 'validation_technique', 0, '2026-05-18 09:08:48'),
(119, 2, 0, 'Fonctionnemnt bureau', 'Manirambona Thierry', 'Manirambona Thierry', 'fonctionnement', 0, 20000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'traite', 0, '2026-05-18 09:11:53'),
(120, 2, 0, 'MUHA', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 1102500.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 09:13:55'),
(121, 2, 0, 'TEMOINS DE JEHOVAH', 'Nishimwe Olivier', 'Nishimwe Olivier', 'fonctionnement', 0, 2437500.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'traite', 0, '2026-05-18 09:17:25'),
(122, 2, 0, 'IBB entrepots', 'HABONIMANA MOISE', 'Nkorerimana Emmanuel', 'chantier', 1, 38467000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-18', '', 'en_verification', 0, '2026-05-18 09:33:08'),
(123, 2, 0, 'Fonctionnemnt bureau', 'Axcel', 'Axcel', 'fonctionnement', 0, 100.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-18', '', 'simplifie', 0, '2026-05-18 09:37:18'),
(124, 2, 0, 'KINGS', 'Ndikumana Claude', 'Nkorerimana Emmanuel', 'chantier', 1, 1000000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-18', '', 'en_verification', 0, '2026-05-18 09:39:54'),
(125, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 864000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-18', '', 'validation_technique', 0, '2026-05-18 10:02:23'),
(126, 2, 0, 'GIHOSHA ZONE', 'Dionisie', 'Habonimana Anniella', 'chantier', 1, 864000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-18', '', 'validation_technique', 0, '2026-05-18 10:03:32'),
(127, 2, 0, 'Fonctionnemnt bureau', 'NDUWAYO Emmanuel', 'NDUWAYO Emmanuel', 'fonctionnement', 0, 19000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'traite', 0, '2026-05-18 10:06:48'),
(128, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 4000000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-18', '', 'validation_technique', 0, '2026-05-18 10:06:53'),
(129, 2, 0, 'GIHOSHA ZONE', 'Dionisie', 'Habonimana Anniella', 'chantier', 1, 4000000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-18', '', 'validation_technique', 0, '2026-05-18 10:07:54'),
(130, 2, 0, 'King\'s school', 'Ir Michel NDIHOKUBWAYO', 'Michel Manirakiza', 'chantier', 1, 285000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-18', '', 'validation_technique', 0, '2026-05-18 10:11:42'),
(132, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 250000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 11:38:58'),
(133, 2, 0, 'King\'s school', 'Ir  NDIHOKUBWAYO Michel', 'Michel Manirakiza', 'chantier', 1, 966500.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 11:41:04'),
(134, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 930000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'traite', 0, '2026-05-18 11:53:42'),
(135, 2, 0, 'Fonctionnemnt bureau', 'Kwizerimana Emery', 'Habonimana Anniella', 'chantier', 1, 227000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 12:36:44'),
(136, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 2420000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'traite', 0, '2026-05-18 13:18:16'),
(137, 2, 0, 'Fonctionnemnt', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 220000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'traite', 0, '2026-05-18 13:29:30'),
(138, 2, 0, 'KININDO APPARTEMENT', 'BARUMWETE Simon', 'Nkorerimana Emmanuel', 'chantier', 1, 100000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 13:33:12'),
(139, 2, 0, 'CIBITOKE PNUD', 'NDUWIMANA JEAN MARIE', 'Nkorerimana Emmanuel', 'chantier', 1, 165000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 13:58:30'),
(140, 2, 0, 'Fonctionnemnt bureau', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1050000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 14:05:44'),
(141, 2, 0, 'Fonctionnemnt bureau', 'NIYONKURU J de Dieu', '', 'chantier', 1, 1450000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 14:07:07'),
(142, 2, 0, 'Fonctionnemnt bureau', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 160000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 15:23:06'),
(143, 2, 0, 'Fonctionnemnt bureau', 'Axcel', 'Axcel', 'fonctionnement', 0, 885000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-18', '', 'traite', 0, '2026-05-18 16:44:46'),
(144, 2, 0, 'OFFRE WHH', 'IRAKOZE    Claude', '', 'chantier', 1, 600000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-18', '', 'approuve', 0, '2026-05-18 16:59:35'),
(145, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1350000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 09:15:35'),
(146, 2, 0, 'KING \'S SCHOOL, IBB, JABE USDA', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 3456000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 09:28:15'),
(147, 2, 0, 'JABE SDA', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 288000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-19', '', 'en_verification', 0, '2026-05-19 09:31:40');
INSERT INTO `purchase_request_forms` (`id`, `company_id`, `chantier_id`, `destination_chantier`, `requested_by`, `buyer_name`, `category_type`, `requires_validation`, `total_amount`, `verified_by`, `technical_approver`, `financial_approver`, `dg_approver`, `treasurer_name`, `verifier_status`, `technical_status`, `financial_status`, `dg_status`, `treasury_status`, `supplier_followup`, `request_date`, `notes`, `workflow_status`, `created_by`, `created_at`) VALUES
(148, 2, 0, 'Kinanira 4 Dominika', 'Vital', 'Habonimana Anniella', 'chantier', 1, 864000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 09:32:52'),
(149, 2, 0, 'GIHOSHA NDAYI', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 576000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-19', '', 'en_verification', 0, '2026-05-19 09:38:11'),
(150, 2, 0, 'GIHOSHA ZONE', 'Nkorerimana Emmanuel', 'NKORERIMANA       Emmanuel', 'chantier', 1, 288000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-19', '', 'en_verification', 0, '2026-05-19 09:39:31'),
(151, 2, 0, 'KINANIRA 3', 'Vital', 'Habonimana Anniella', 'chantier', 1, 70000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 09:54:32'),
(152, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 830000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 10:08:02'),
(153, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 180000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 10:09:12'),
(154, 2, 0, 'Eden garden lll', 'Ir Janvier NDAYIZEYE', 'Michel Manirakiza', 'chantier', 1, 100000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 10:15:18'),
(155, 2, 0, 'Fonctionnement', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 202500.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'traite', 0, '2026-05-19 10:20:51'),
(157, 2, 0, 'King\'s school', 'Ir Michel NDIHOKUBWAYO', 'Michel Manirakiza', 'chantier', 1, 2880000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-19', '', 'validation_technique', 0, '2026-05-19 10:29:33'),
(158, 2, 0, 'IBB entrepots', 'Ir Nsengiyumva Eric', 'Nkorerimana Emmanuel', 'chantier', 1, 10000500.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-04', '', 'approuve', 0, '2026-05-19 10:50:29'),
(159, 2, 0, 'Fonctionnemnt bureau', 'Nishimwe Olivier', 'Habonimana Anniella', 'chantier', 1, 150000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Ir', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 10:55:49'),
(160, 2, 0, 'Fonctionnemnt bureau', 'IRAKOZE    Claude', 'Habonimana Anniella', 'chantier', 1, 150000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 10:57:42'),
(161, 2, 0, 'IBB entrepots', 'Ir Nsengiyumva Eric', 'Nkorerimana Emmanuel', 'chantier', 1, 6800000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-08', '', 'approuve', 0, '2026-05-19 11:00:29'),
(162, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', '', 'chantier', 1, 700000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 11:15:22'),
(164, 2, 0, 'Fonctionnemnt bureau', 'IGIRUMWETE Pischon', 'IGIRANEZA Pichou', 'chantier', 1, 20000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 11:41:44'),
(165, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 42000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'validation_financiere', 0, '2026-05-19 12:47:43'),
(166, 2, 0, 'Fonctionnement', 'NKESHIMANA Come', 'NKESHIMANA Come', 'chantier', 1, 750000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 13:02:55'),
(167, 2, 0, 'KINGS', 'NKESHIMANA Come', '', 'chantier', 1, 350000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 13:05:30'),
(168, 2, 0, 'KABEZI', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 1174000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-19', '', 'en_verification', 0, '2026-05-19 13:06:14'),
(169, 2, 0, 'MUHA', 'NKESHIMANA Come', '', 'chantier', 1, 170000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 13:07:47'),
(170, 2, 0, 'GIHOSHA ZONE', 'NKESHIMANA Come', 'Côme Côme', 'chantier', 1, 350000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 13:09:30'),
(171, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 3960000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 13:34:42'),
(172, 2, 0, 'FONCTIONNEMENT', 'NDUWAYO EMMANUEL', '', 'fonctionnement', 0, 20038606.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-19', '', 'simplifie', 0, '2026-05-19 14:15:41'),
(173, 2, 0, 'Fonctionnemnt bureau', 'Nishimwe Olivier', 'Nishimwe Olivier', 'fonctionnement', 0, 213000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'traite', 0, '2026-05-19 14:22:31'),
(174, 2, 0, 'AVENANT SOCABU AVENUE DU JANVIER', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 565200.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 15:02:15'),
(175, 2, 0, 'AVENANT SOCABU AVENUE DU JANVIER', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 65000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 15:03:37'),
(176, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 150000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 15:11:40'),
(177, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 450000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'approuve', 0, '2026-05-19 15:30:25'),
(178, 2, 0, 'Fonctionnemnt bureau', 'Hategekimana Claude', 'Habonimana Anniella', 'chantier', 1, 17000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-19', '', 'validation_technique', 0, '2026-05-19 15:47:34'),
(179, 2, 0, 'Fonctionnemnt bureau', 'Jeannette Moses', 'Habonimana Anniella', 'chantier', 1, 28000.00, 'Mariam DAF', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-19', '', 'en_verification', 0, '2026-05-19 16:16:29'),
(180, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 300000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'fonds_ok', '', '2026-05-19', '', 'traite', 0, '2026-05-19 16:32:53'),
(181, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 5808000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-20', '', 'approuve', 0, '2026-05-20 07:59:09'),
(182, 2, 0, 'King\'s school', 'KWIZERA Siméon', 'Michel Manirakiza', 'chantier', 1, 2861800.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-20', '', 'approuve', 0, '2026-05-20 08:58:09'),
(183, 2, 0, 'Fonctionnemnt', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1450000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-20', '', 'approuve', 0, '2026-05-20 09:10:49'),
(184, 2, 0, 'KABEZI', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 1726000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-20', '', 'approuve', 0, '2026-05-20 09:14:37'),
(185, 2, 0, 'Fonctionnemnt bureau', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 370000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-20', '', 'approuve', 0, '2026-05-20 09:16:33'),
(186, 2, 0, 'Eden garden lll', 'Ir Janvier NDAYIZEYE', 'Michel Manirakiza', 'chantier', 1, 32000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-20', '', 'approuve', 0, '2026-05-20 09:28:14'),
(187, 2, 0, 'King\'s school', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 576000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-20', '', 'validation_technique', 0, '2026-05-20 10:12:20'),
(188, 2, 0, 'Fonctionnement', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 100000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-20', '', 'approuve', 0, '2026-05-20 10:34:58'),
(189, 2, 0, 'Muha kinanira', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 775000.00, 'Ir David EMERUSABE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-20', '', 'approuve', 0, '2026-05-20 10:52:12'),
(190, 2, 0, 'GIHOSHA ZONE', 'Dionisie', 'Habonimana Anniella', 'chantier', 1, 400000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-20', '', 'approuve', 0, '2026-05-20 12:53:12'),
(191, 2, 0, 'Fonctionnemnt', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 1400000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-20', '', 'traite', 0, '2026-05-20 12:54:31'),
(192, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 1299999.95, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-20', 'Paiement dette', 'traite', 0, '2026-05-20 12:56:39'),
(193, 2, 0, 'Fonctionnemnt bureau', 'Kwizerimana Emery', 'Habonimana Anniella', 'chantier', 1, 35000.00, 'Mariam DAF', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-20', '', 'approuve', 0, '2026-05-20 16:06:38'),
(194, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1500000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-21', '', 'en_verification', 0, '2026-05-21 08:49:21'),
(195, 2, 0, 'Fonctionnement', 'IGIRUMWETE Pischon', 'IGIRUMWETE Pichon', 'fonctionnement', 0, 30000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Chef Comptable', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'traite', 0, '2026-05-21 08:51:45'),
(196, 2, 0, 'KINGS SCHOOL, IBB ENTREPÔT', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 4320000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'approuve', 0, '2026-05-21 08:51:52'),
(197, 2, 0, 'Fonctionnemnt bureau', 'NDAMUHAWENIMANA        Jeremie', '', 'chantier', 1, 74000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'approuve', 0, '2026-05-21 08:55:16'),
(198, 2, 0, 'GIHOSHA APPARTEMENT, GIHOSHA NDAYI ET KABEZI', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 2016000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'approuve', 0, '2026-05-21 08:59:05'),
(199, 2, 0, 'MUHA', 'NKORERIMANA Emmanuel', '', 'chantier', 1, 168000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'approuve', 0, '2026-05-21 09:03:12'),
(200, 2, 0, 'Fonctionnemnt bureau', 'Axcel', 'Axcel', 'fonctionnement', 0, 920000.00, 'Axcel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'traite', 0, '2026-05-21 09:04:23'),
(201, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', '', 'chantier', 1, 70000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'approuve', 0, '2026-05-21 09:11:30'),
(202, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 400000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'rejete', 'en_attente', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'traite', 0, '2026-05-21 09:12:48'),
(203, 2, 0, 'Fonctionnemnt bureau', 'NAHIMANA Ramla', 'NAHIMANA Ramla', 'fonctionnement', 0, 125000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'traite', 0, '2026-05-21 09:19:29'),
(204, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 696600.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'approuve', 0, '2026-05-21 11:39:28'),
(205, 2, 0, 'ARTISAN MODERNE', 'NAHAYO NORMAND', 'NAHAYO NORMAND', 'fonctionnement', 0, 860000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-21', '', 'simplifie', 0, '2026-05-21 15:21:10'),
(206, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 50000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-21', '', 'traite', 0, '2026-05-21 16:12:51'),
(207, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1500000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-21', '', 'en_verification', 0, '2026-05-21 17:09:31'),
(208, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', '', 'chantier', 1, 300000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-22', '', 'approuve', 0, '2026-05-22 08:55:11'),
(209, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1600000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-22', '', 'approuve', 0, '2026-05-22 09:34:42'),
(210, 2, 0, 'Fonctionnemnt bureau', 'KWIZERIMANA EMELY', 'KWIZERIMANA EMELY', 'fonctionnement', 0, 152500.00, 'Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-22', '', 'traite', 0, '2026-05-22 11:54:14'),
(211, 2, 0, 'Fonctionnemnt bureau', 'IRABOZE CLAUDE', '', 'fonctionnement', 0, 5000.00, 'Chef Comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-22', '', 'traite', 0, '2026-05-22 13:16:33'),
(212, 2, 0, 'Fonctionnemnt bureau', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 510000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-22', '', 'en_verification', 0, '2026-05-22 13:16:43'),
(213, 2, 0, 'BGF/ETUDE', 'EMERUSABE  David', '', 'fonctionnement', 0, 900000.00, 'Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-22', '', 'traite', 0, '2026-05-22 13:38:14'),
(214, 2, 0, 'Fonctionnemnt bureau', 'NAHIMANA RAMLA', '', 'chantier', 1, 455000.00, 'Chef Comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-22', '', 'approuve', 0, '2026-05-22 13:42:45'),
(215, 2, 0, 'Fonctionnement bureau', 'NKESHIMANA Come', '', 'fonctionnement', 0, 500000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'en_attente', '', '2026-05-25', '', 'validation_financiere', 0, '2026-05-25 08:54:05'),
(216, 2, 0, 'Muha kinanira', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 676000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 08:54:52'),
(217, 2, 0, 'Fonctionnemnt bureau', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 1245000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 09:00:11'),
(218, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1749000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-25', '', 'approuve', 0, '2026-05-25 09:12:23'),
(219, 2, 0, 'King\'s school', 'HABONIMANA Moïse', 'Michel Manirakiza', 'chantier', 1, 5040000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 10:29:06'),
(220, 2, 0, 'King\'s school', 'HABONIMANA Moïse', 'Michel Manirakiza', 'chantier', 1, 6482000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 10:29:09'),
(221, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 45000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-25', '', 'traite', 0, '2026-05-25 10:39:45'),
(222, 2, 0, 'KING\'S SCHOOL', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 2250000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-25', '', 'approuve', 0, '2026-05-25 11:25:49'),
(223, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 1400000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-25', '', 'traite', 0, '2026-05-25 12:01:58'),
(224, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 1000000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'fonds_ok', '', '2026-05-25', '', 'traite', 0, '2026-05-25 12:05:48'),
(225, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', '', 'chantier', 1, 400000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-25', '', 'approuve', 0, '2026-05-25 12:21:19'),
(226, 2, 0, 'King\'s school', 'Ir Michel NDIHOKUBWAYO', 'Michel Manirakiza', 'chantier', 1, 5760000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 12:40:30'),
(227, 2, 0, 'KINANIRA 3/DAF', 'Hategekimana Claude', 'Habonimana Anniella', 'chantier', 1, 71000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-25', '', 'approuve', 0, '2026-05-25 13:08:40'),
(228, 2, 0, 'JABE SDA University', 'Ir kévin NIRERA', 'Michel Manirakiza', 'chantier', 1, 48000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-25', '', 'approuve', 0, '2026-05-25 13:30:05'),
(229, 2, 0, 'King\'s school', 'Ir Michel NDIHOKUBWAYO', 'Michel Manirakiza', 'chantier', 1, 680000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 14:20:13'),
(230, 2, 0, 'King\'s school', 'Ir Michel NDIHOKUBWAYO', 'Michel Manirakiza', 'chantier', 1, 1750000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 14:24:08'),
(231, 2, 0, 'King\'s school', 'Ir Michel NDIHOKUBWAYO', 'Michel Manirakiza', 'chantier', 1, 1785000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 14:30:41'),
(232, 2, 0, 'KINANIRA 3', 'Nshimirimana Aaron', 'Habonimana Anniella', 'chantier', 1, 75000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-25', '', 'approuve', 0, '2026-05-25 14:49:25'),
(233, 2, 0, 'GASENYI Presidence', 'J marie', 'Habonimana Anniella', 'chantier', 1, 284000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 15:01:31'),
(234, 2, 0, 'GASENYI Presidence', 'J Marie', 'Habonimana Anniella', 'chantier', 1, 170000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 15:05:04'),
(235, 2, 0, 'GASENYI Presidence', 'J Marie', 'Habonimana Anniella', 'chantier', 1, 64000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 15:55:59'),
(236, 2, 0, 'GASENYI Presidence', 'J Marie', 'Habonimana Anniella', 'chantier', 1, 180000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 15:58:19'),
(237, 2, 0, 'GASENYI Presidence', 'J Marie', 'Habonimana Anniella', 'chantier', 1, 60000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-25', '', 'approuve', 0, '2026-05-25 16:02:24'),
(238, 2, 0, 'GASENYI Presidence', 'J Marie', 'Habonimana Anniella', 'chantier', 1, 576000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-25', '', 'en_verification', 0, '2026-05-25 16:04:46'),
(239, 2, 0, 'Fonctionnemnt', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 15000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-25', '', 'approuve', 0, '2026-05-25 16:19:41'),
(240, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 1000000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'approuve', 0, '2026-05-26 09:02:42'),
(241, 2, 0, 'King\'s school', 'Ir Michel NDIHOKUBWAYO', 'Michel Manirakiza', 'chantier', 1, 1405500.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'approuve', 0, '2026-05-26 09:10:41'),
(242, 2, 0, 'Fonctionnemnt bureau', 'Claude Hategekimana', 'Habonimana Anniella', 'fonctionnement', 0, 18000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 09:14:02'),
(243, 2, 0, 'Fonctionnemnt bureau', 'Hategekimana Claude', 'Habonimana Anniella', 'chantier', 1, 60000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'approuve', 0, '2026-05-26 09:16:37'),
(244, 2, 0, 'GIHOSHA APPARTEMENT', 'Dionisie', 'Habonimana Anniella', 'chantier', 1, 70000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'approuve', 0, '2026-05-26 09:37:31'),
(245, 2, 0, 'Fonctionnemnt bureau', 'Moise & Providence', 'Moise', 'fonctionnement', 0, 570000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-26', '', 'simplifie', 0, '2026-05-26 09:49:40'),
(246, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 250000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 09:59:48'),
(247, 2, 0, 'Fonctionnemnt bureau', 'Axcel', 'Ali', 'fonctionnement', 0, 70000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 10:07:54'),
(248, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 1400000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'approuve', 0, '2026-05-26 10:12:49'),
(249, 2, 0, 'Fonctionnement', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 20000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 10:33:01'),
(250, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 30000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 10:35:08'),
(251, 2, 0, 'Fonctionnement', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 400000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'approuve', 0, '2026-05-26 10:42:49'),
(252, 2, 0, 'KING\'S SCHOOL', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 748800.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'approuve', 0, '2026-05-26 10:45:28'),
(253, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 646000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'approuve', 0, '2026-05-26 10:48:45'),
(254, 2, 0, 'Fonctionnemnt', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 900000.00, 'Ir DAVID', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-26', '', 'en_verification', 0, '2026-05-26 10:52:18'),
(255, 2, 0, 'Fonctionnemnt bureau', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 180000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 10:54:31'),
(256, 2, 0, 'Fonctionnemnt bureau', 'Directrice Administrative et Financière', 'Pischon IGIRUMWETE', 'fonctionnement', 0, 120000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 12:09:19'),
(257, 2, 0, 'Fonctionnemnt bureau', 'IGIRUMWETE Pischon', 'IGIRUMWETE Pischon', 'fonctionnement', 0, 50000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 12:11:48'),
(258, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 576000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'approuve', 0, '2026-05-26 13:21:39'),
(259, 2, 0, 'Fonctionnement', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 140000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 13:58:48'),
(260, 2, 0, 'Fonctionnemnt bureau', 'KWIZERIMANA EMERY', '', 'fonctionnement', 0, 227000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 14:16:32'),
(261, 2, 0, 'Fonctionnement', 'NDAGIJE Mariam', '', 'fonctionnement', 0, 60000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-26', '', 'traite', 0, '2026-05-26 15:26:13'),
(262, 2, 0, 'GIHOSHA APPARTEMENT', 'HABONIMANA ANIELLA', 'HABONIMANA ANNIELLA', 'chantier', 1, 403200.00, 'Ir NIBITANGA FABRICE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-28', '', 'approuve', 0, '2026-05-28 09:22:42'),
(263, 2, 0, 'GIHOSHA APPARTEMENT', 'HABONIMANA ANNIELLA', 'HABONIMANA ANNIELLA', 'chantier', 1, 300000.00, 'Ir NIBITANGA FABRICE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-28', '', 'approuve', 0, '2026-05-28 09:25:11'),
(264, 2, 0, 'GIHOSHA NDAYI', 'HABONIMANA ANNIELLA', 'HABONIMANA ANNIELLA', 'fonctionnement', 0, 911750.00, 'Ir NIBITANGA FABRICE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-28', '', 'traite', 0, '2026-05-28 09:31:32'),
(265, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 170000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-28', '', 'traite', 0, '2026-05-28 09:50:50'),
(266, 2, 0, 'Fonctionnemnt bureau', 'Nishimwe Olivier et Irakoze Claude', '', 'fonctionnement', 0, 100000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-28', '', 'traite', 0, '2026-05-28 10:33:17'),
(267, 2, 0, 'GIHOSHA NDAYI', 'MISAGO PAPIAS', 'HABONIMANA ANNIELLA', 'chantier', 1, 2156000.00, 'Ir NIBITANGA FABRICE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-28', 'Paiement dette, dernière tranche', 'approuve', 0, '2026-05-28 10:38:26'),
(268, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', '', 'fonctionnement', 0, 300000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-28', '', 'traite', 0, '2026-05-28 11:16:47'),
(269, 2, 0, 'Muha kinanira', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 147000.00, 'Ir DAVID', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-28', '', 'en_verification', 0, '2026-05-28 12:18:44'),
(270, 2, 0, 'Fonctionnemnt bureau', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 365000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-28', '', 'en_verification', 0, '2026-05-28 12:22:39'),
(271, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 576000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-28', '', 'en_verification', 0, '2026-05-28 12:31:40'),
(272, 2, 0, 'Fonctionnement', 'Niyonkuru Jean de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 1200000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-28', '', 'traite', 0, '2026-05-28 12:34:04'),
(273, 2, 0, 'KABEZI', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 300000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-28', '', 'en_verification', 0, '2026-05-28 12:34:32'),
(274, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 60000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-28', '', 'traite', 0, '2026-05-28 12:35:00'),
(275, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 99000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-28', '', 'traite', 0, '2026-05-28 12:38:57'),
(276, 2, 0, 'Muha kinanira', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 654000.00, 'Ir DAVID', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-28', '', 'en_verification', 0, '2026-05-28 12:52:23'),
(277, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 870000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-28', '', 'traite', 0, '2026-05-28 12:59:10'),
(278, 2, 0, 'Avenue du Janvier', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 360000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-28', '', 'en_verification', 0, '2026-05-28 13:24:01'),
(279, 2, 0, 'Kinanira3', 'Vitar', 'Habonimana Anniella', 'chantier', 1, 288000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-29', '', 'en_verification', 0, '2026-05-29 08:45:57'),
(280, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 900000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 08:49:06'),
(281, 2, 0, 'KINANIRA 3', 'Vitar', 'Habonimana Anniella', 'chantier', 1, 70000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'approuve', 0, '2026-05-29 08:49:37'),
(282, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 690000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 08:50:02'),
(283, 2, 0, 'KINANIRA 3', 'Vitar', 'Habonimana Anniella', 'chantier', 1, 100000.00, 'Emmanuel DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-29', '', 'en_verification', 0, '2026-05-29 08:52:49'),
(284, 2, 0, 'Gihosha ndayi', 'Munszero Claude', 'Habonimana Anniella', 'chantier', 1, 1150000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'approuve', 0, '2026-05-29 09:00:31'),
(285, 2, 0, 'Fonctionnemnt bureau', 'RUGAMBIRA THOMAS', 'RUGAMBIRA THOMAS', 'fonctionnement', 0, 40000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 09:02:17'),
(286, 2, 0, 'Fonctionnemnt bureau', 'Elga', 'Elga', 'fonctionnement', 0, 62000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-29', '', 'validation_technique', 0, '2026-05-29 09:07:05'),
(287, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 1400000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 09:09:50'),
(288, 2, 0, 'Fonctionnemnt bureau', 'Jean Marie Rugamira', 'Jean Marie Rugamira', 'fonctionnement', 0, 53000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-29', '', 'validation_technique', 0, '2026-05-29 09:33:42'),
(289, 2, 0, 'Fonctionnemnt bureau', 'Elga', 'Elga', 'fonctionnement', 0, 300000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-29', '', 'validation_technique', 0, '2026-05-29 10:46:38'),
(290, 2, 0, 'Fonctionnemnt bureau', 'Elga', 'Elga', 'fonctionnement', 0, 660000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-05-29', '', 'validation_technique', 0, '2026-05-29 10:50:22'),
(291, 2, 0, 'ARTISANT Moderne', 'NAHAYO  Normand', '', 'fonctionnement', 0, 560000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', 'PYT de 50 % de la facture totalisant 1120000 FBU', 'traite', 0, '2026-05-29 10:51:49'),
(292, 2, 0, 'ARTISANAT MODERNE', 'NAHAYO Normand', '', 'fonctionnement', 0, 860000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 11:01:52');
INSERT INTO `purchase_request_forms` (`id`, `company_id`, `chantier_id`, `destination_chantier`, `requested_by`, `buyer_name`, `category_type`, `requires_validation`, `total_amount`, `verified_by`, `technical_approver`, `financial_approver`, `dg_approver`, `treasurer_name`, `verifier_status`, `technical_status`, `financial_status`, `dg_status`, `treasury_status`, `supplier_followup`, `request_date`, `notes`, `workflow_status`, `created_by`, `created_at`) VALUES
(293, 2, 0, 'Fonctionnemnt bureau', 'Emmanuel Niyimbona', 'Jacques', 'fonctionnement', 0, 500000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 11:56:58'),
(294, 2, 0, 'Fonctionnemnt bureau', 'Emmanuel Niyimbona', 'Jacques', 'fonctionnement', 0, 579000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 11:59:30'),
(295, 2, 0, 'Fonctionnemnt bureau', 'Emmanuel Niyimbona', 'Jacques', 'chantier', 1, 350000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'approuve', 0, '2026-05-29 12:03:19'),
(296, 2, 0, 'Fonctionnemnt bureau', 'Emmanuel Niyimbona', 'Jacques Niyitegeka', 'fonctionnement', 0, 2000000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 12:04:55'),
(297, 2, 0, 'NAHIMANA Ramla', 'NAHIMANA RAMLA', 'NAHIMANA Ramla', 'fonctionnement', 0, 357000.00, 'Chef Comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 14:07:53'),
(298, 2, 0, 'Fonctionnement', 'NDAGIJE Mariam', '', 'chantier', 1, 48000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'approuve', 0, '2026-05-29 14:39:32'),
(299, 2, 0, 'FONCTIONNEMENT', 'KWIZERIMANA EMERY', 'KWIZERIMANA EMERY', 'fonctionnement', 0, 181500.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 14:41:30'),
(300, 2, 0, 'Projet Pave', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 228000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-05-29', '', 'traite', 0, '2026-05-29 15:47:10'),
(301, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 840000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 09:26:05'),
(302, 2, 0, 'PROJET PAVE', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 687000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 09:36:00'),
(304, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 1100000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 10:02:17'),
(305, 2, 0, 'projet Maramvya/ Briques cuites', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 1700000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 10:06:16'),
(306, 2, 0, 'Témoins de Jéhovah', 'Ir Claude', 'Michel Manirakiza', 'chantier', 1, 750000.00, 'Ir David EMERUSABE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'approuve', 0, '2026-06-01 10:09:03'),
(307, 2, 0, 'King\'s school', 'NSHIMIRIMANA Aaron', 'Michel Manirakiza', 'chantier', 1, 300000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-01', '', 'approuve', 0, '2026-06-01 10:13:20'),
(308, 2, 0, 'Fonctionnement', 'NKESHIMANA Come', '', 'fonctionnement', 0, 300000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 10:56:41'),
(309, 2, 0, 'Eden garden lll', 'Ir Janvier NDAYIZEYE', 'Michel Manirakiza', 'chantier', 1, 2880000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-01', '', 'validation_technique', 0, '2026-06-01 11:19:50'),
(310, 2, 0, 'GASENYI Presidence', 'HABONIMANA Anniella', 'HABONIMANA         Anniella', 'chantier', 1, 2138000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-01', '', 'validation_technique', 0, '2026-06-01 11:40:49'),
(311, 2, 0, 'Fonctionnement', 'GRATIEN HAKIZIMANA', 'GRATIEN HAKIZIMANA', 'fonctionnement', 0, 30000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 11:43:22'),
(312, 2, 0, 'FonctionnemEnt', 'Ramla', 'Ramla', 'fonctionnement', 0, 187500.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 11:54:38'),
(313, 2, 0, 'Fonctionnemnt bureau', 'DAVID EMERUSABE', 'DAVID', 'fonctionnement', 0, 48000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 12:31:13'),
(314, 2, 0, 'Eden garden lll', 'Ir Janvier NDAYIZEYE', 'Michel Manirakiza', 'chantier', 1, 25380000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-01', '', 'validation_technique', 0, '2026-06-01 13:42:15'),
(315, 2, 0, 'King\'s school', 'Ir Michel NDIHOKUBWAYO', 'Michel Manirakiza', 'chantier', 1, 640900.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'approuve', 0, '2026-06-01 14:46:22'),
(316, 2, 0, 'GASENYI Presidence', 'JEAN MARIE', 'HABONIMANA ANNIELLA', 'chantier', 1, 124000.00, 'NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-01', '', 'validation_technique', 0, '2026-06-01 15:03:07'),
(317, 2, 0, 'FONCTIONNEMENT', 'KWIZERIMANA EMERY', 'KWIZERIMANA EMERY', 'fonctionnement', 0, 258000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 15:16:20'),
(318, 2, 0, 'Fonctionnemnt bureau', 'JEANNETTE MOSES', 'Jeannette Moses', 'fonctionnement', 0, 300000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 15:35:47'),
(319, 2, 0, 'Muha kinanira', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 502000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-01', '', 'en_verification', 0, '2026-06-01 16:23:05'),
(320, 2, 0, 'Avenue du Janvier', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'fonctionnement', 0, 450000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 16:24:50'),
(321, 2, 0, 'FONCTIONNEMENT', 'HAKIZIMANA CYPRIEN', 'NDUWAYO EMMANUEL', 'fonctionnement', 0, 50000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-01', '', 'traite', 0, '2026-06-01 16:43:14'),
(322, 2, 0, 'King\'s school', 'Ir Michel NDIHOKUBWAYO', 'Michel Manirakiza', 'chantier', 1, 576000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-02', '', 'en_verification', 0, '2026-06-02 08:54:54'),
(323, 2, 0, 'King\'s school , IBB ENTREPÔT, JABE USDA', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 8775000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-02', '', 'approuve', 0, '2026-06-02 09:50:57'),
(324, 2, 0, 'KABEZI, KINANIRA, GIHOSHA ZONE, GIHOSHA NDAYI, BUREAU', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 13975000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-02', '', 'approuve', 0, '2026-06-02 09:55:36'),
(325, 2, 0, 'Fonctionnement ,OFFRE INSS', 'NISHIMWE        NISHIMWE Olivier', '', 'chantier', 1, 500000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-02', '', 'approuve', 0, '2026-06-02 10:51:12'),
(326, 2, 0, 'Kabezi, Kinanira III, Gihosha Zone, Gihosha Ndayi, projet PAVE', 'NKORERIMANA Emmanuel', 'NKORERIMANA Emmanuel', 'chantier', 1, 129000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-02', '', 'approuve', 0, '2026-06-02 11:13:26'),
(327, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 2110000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-02', '', 'traite', 0, '2026-06-02 12:11:47'),
(328, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', '', 'chantier', 1, 200000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-02', '', 'approuve', 0, '2026-06-02 12:15:14'),
(329, 2, 0, 'PROJET PAVE', 'HATEGEKIMANA JEAN CLAUDE', 'NDUWAYO EMMANUEL', 'fonctionnement', 0, 25000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-02', '', 'traite', 0, '2026-06-02 12:33:26'),
(330, 2, 0, 'FONCTIONNEMENT', 'NDUWAYO EMMANUEL', '', 'chantier', 1, 2220000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-02', '', 'approuve', 0, '2026-06-02 12:36:16'),
(331, 2, 0, 'TEMOINS DE JEHOVAH', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 250000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-02', '', 'approuve', 0, '2026-06-02 12:55:24'),
(332, 2, 0, 'King\'s school , IBB ENTREPÔT, JABE USDA', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 144000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-02', '', 'approuve', 0, '2026-06-02 13:51:19'),
(333, 2, 0, 'Projet pavé', 'HATEGEKIMANA JEAN CLAUDE', 'HABONIMANA ANNIELLA', 'fonctionnement', 0, 59000.00, 'MANIRAGABA SERGESh', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-02', '', 'traite', 0, '2026-06-02 14:23:50'),
(334, 2, 0, 'KINANIRA 3', 'HATEGEKIMANA JEAN CLAUDE', 'HABONIMANA ANNIELLA', 'chantier', 1, 38400.00, 'Ir NIBITANGA FABRICE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-02', '', 'approuve', 0, '2026-06-02 14:26:16'),
(335, 2, 0, 'Fonctionnemnt bureau', 'DAVID', '', 'chantier', 1, 200000.00, 'DAVID', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', 'FRAIS DE PREPARATION PROJET OBUHA OUA', '2026-06-02', '', 'approuve', 0, '2026-06-02 14:29:50'),
(336, 2, 0, 'GATOKE CLAUDOIR', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 2304000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-03', '', 'approuve', 0, '2026-06-03 09:26:11'),
(338, 2, 0, 'GIHOSHA ZONE', 'Di0nisie', 'HABONIMANA Anniella', 'chantier', 1, 50000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-03', '', 'approuve', 0, '2026-06-03 11:32:44'),
(339, 2, 0, 'NYABUGETE', 'NAHAYO NORMAND', 'NAHAYO NORMAND', 'chantier', 1, 14800000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-03', '', 'en_verification', 0, '2026-06-03 11:40:00'),
(340, 2, 0, 'NYABUGETE DR', 'NAHAYO NORMAND', 'NAHAYO NORMAND', 'fonctionnement', 0, 15880000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-03', '', 'simplifie', 0, '2026-06-03 11:47:20'),
(341, 2, 0, 'Fonctionnemnt bureau', 'Nelly Ange', '', 'fonctionnement', 0, 92000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-03', '', 'traite', 0, '2026-06-03 12:15:22'),
(342, 2, 0, 'Fonctionnemnt bureau', 'Nelly Ange', 'Nelly Ange', 'chantier', 1, 285000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-03', '', 'approuve', 0, '2026-06-03 12:27:13'),
(343, 2, 0, 'Fonctionnemnt bureau', 'Nelly Ange', 'Nelly Ange', 'chantier', 1, 490000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-03', '', 'approuve', 0, '2026-06-03 12:31:43'),
(344, 2, 0, 'Fonctionnemnt bureau', 'Orly', 'Orly', 'fonctionnement', 0, 200000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-03', '', 'traite', 0, '2026-06-03 14:21:50'),
(345, 2, 0, 'Fonctionnemnt bureau', 'Providence', 'Providence', 'fonctionnement', 0, 100000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-03', '', 'traite', 0, '2026-06-03 14:24:04'),
(346, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', '', 'chantier', 1, 700000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-03', '', 'approuve', 0, '2026-06-03 14:26:28'),
(347, 2, 0, 'PROJET PAVE', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'chantier', 1, 740000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-03', '', 'approuve', 0, '2026-06-03 14:27:37'),
(348, 2, 0, 'Fonctionnemnt bureau', 'JEANNETTE MOSES', '', 'fonctionnement', 0, 108000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-03', '', 'traite', 0, '2026-06-03 14:32:24'),
(349, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 650000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-03', '', 'traite', 0, '2026-06-03 14:32:47'),
(350, 2, 0, 'GATOKE CLAUDOIR', 'NAHAYO NORMAND', 'NAHAYO NORMAND', 'chantier', 1, 1360000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-03', '', 'en_verification', 0, '2026-06-03 14:35:07'),
(351, 2, 0, 'NYABUGETE DR ERIC', 'NAHAYO NORMAND', 'NAHAYO NORMAND', 'chantier', 1, 22337500.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-03', '', 'en_verification', 0, '2026-06-03 14:44:27'),
(352, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 362800.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-03', '', 'approuve', 0, '2026-06-03 14:50:33'),
(353, 2, 0, 'Fonctionnemnt bureau', 'IGIRUMWETE Pischon', 'IGIRUMWETE Pischon', 'fonctionnement', 0, 60000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-03', '', 'traite', 0, '2026-06-03 14:54:03'),
(354, 2, 0, 'GATOKE CLAUDOIR', 'NAHAYO NORMAND', 'NAHAYO NORMAND', 'fonctionnement', 0, 20923499.80, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-03', '', 'simplifie', 0, '2026-06-03 15:07:57'),
(355, 2, 0, 'PROJET PAVE', 'IMENYAVYOSE Bernardin', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 500000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-03', '', 'traite', 0, '2026-06-03 16:12:23'),
(356, 2, 0, 'Fonctionnemnt bureau', 'Axcel', 'Axcel', 'chantier', 1, 4755000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-03', '', 'en_verification', 0, '2026-06-03 16:53:23'),
(357, 2, 0, 'Fonctionnemnt bureau', 'NIYITEGEKA Jacques', '', 'fonctionnement', 0, 75000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-03', '', 'traite', 0, '2026-06-03 17:17:59'),
(358, 2, 0, 'Fonctionnement', 'Jeanette mOSES', '', 'fonctionnement', 0, 120000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-03', '', 'traite', 0, '2026-06-03 17:29:29'),
(359, 2, 0, 'IBB ENTREPOT', 'NKORERIMANA Emmanuel', '', 'chantier', 1, 15718957.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-03', 'Pyt par OV N°76762  de l\'IBB dont une copie est ci jointe;', 'approuve', 0, '2026-06-03 17:48:31'),
(360, 2, 0, 'IBB ENTREPOT', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 780000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-04', '', 'approuve', 0, '2026-06-04 09:46:35'),
(361, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 130000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-04', '', 'en_verification', 0, '2026-06-04 09:54:09'),
(362, 2, 0, 'Fonctionnemnt', 'NKESHIMANA Come', '', 'fonctionnement', 0, 1894206.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-03', '', 'traite', 0, '2026-06-04 09:55:09'),
(363, 2, 0, 'JABE Universite', 'NKESHIMANA Come', '', 'chantier', 1, 157688.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'en_attente', '', '2026-06-04', '', 'validation_financiere', 0, '2026-06-04 09:59:10'),
(364, 2, 0, 'KINGS SCHOOL', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 260000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-04', '', 'approuve', 0, '2026-06-04 10:14:29'),
(365, 2, 0, 'PROJET PAVE', 'IMENYAVYOSE Bernardin', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 200000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-04', '', 'traite', 0, '2026-06-04 10:39:57'),
(366, 2, 0, 'PROJET PAVE', 'IMENYAVYOSE Bernardin', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 1152000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-04', '', 'traite', 0, '2026-06-04 11:28:27'),
(367, 2, 0, 'Projet Bloc Ciment', 'HAKIZIMANA Moïse', 'HAKIZIMANA Moïse', 'fonctionnement', 0, 1000000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-04', 'RESTE A PAYER 800000 FBU sur commande de 1800000 BIF', 'traite', 0, '2026-06-04 13:01:12'),
(368, 2, 0, 'Fonctionnemnt bureau', 'Jeanette Moses', 'Jeanette Moses', 'fonctionnement', 0, 215000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-04', '', 'traite', 0, '2026-06-04 13:55:50'),
(369, 2, 0, 'FONCTIONNEMENT', 'KWIZERIMANA EMERY', 'KWIZERIMANA EMERY', 'fonctionnement', 0, 70000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-04', '', 'traite', 0, '2026-06-04 13:57:48'),
(370, 2, 0, 'PROJET PAVE', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 157000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-04', '', 'traite', 0, '2026-06-04 14:04:54'),
(371, 2, 0, 'Fonctionnemnt bureau', 'Jean Marie Rugamira', 'Jean Marie Rugamira', 'fonctionnement', 0, 150000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-04', '', 'traite', 0, '2026-06-04 14:19:23'),
(372, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', '', 'chantier', 1, 100000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-04', '', 'approuve', 0, '2026-06-04 15:32:04'),
(373, 2, 0, 'KINANIRA 3', 'Vedaste', 'HABONIMANA ANNIELLA', 'fonctionnement', 0, 1670000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-04', '', 'validation_technique', 0, '2026-06-04 15:41:41'),
(374, 2, 0, 'GIHOSHA APPARTEMENT', 'Vedaste', 'HABONIMANA ANNIELLA', 'fonctionnement', 0, 3110000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-04', '', 'validation_technique', 0, '2026-06-04 15:57:05'),
(375, 2, 0, 'Projet pavé', 'TUYISABE SEVERIN', 'TUYISABE SEVERIN', 'fonctionnement', 0, 189000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 09:24:51'),
(376, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 630600.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'approuve', 0, '2026-06-05 09:38:06'),
(377, 2, 0, 'AVENANT SOCABU AVENUE DU JANVIER', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 136500.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-05', '', 'en_verification', 0, '2026-06-05 10:14:13'),
(378, 2, 0, 'FONCTIONNEMENT', 'KWIZERIMANA EMERY', 'KWIZERIMANA EMERY', 'fonctionnement', 0, 162000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 11:28:46'),
(379, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 2500000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 11:29:42'),
(380, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 440000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 11:30:59'),
(381, 2, 0, 'KINGS SCHOOL', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 350000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'approuve', 0, '2026-06-05 11:37:47'),
(382, 2, 0, 'Fonctionnement', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 260000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 12:05:15'),
(383, 2, 0, 'Fonctionnement', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 2240000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 12:25:06'),
(384, 2, 0, 'Fonctionnemnt bureau', 'NAHIMANA Ramla', '', 'fonctionnement', 0, 417000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 12:39:51'),
(385, 2, 0, 'Tous les chanties', 'NAHIMANA Ramla', '', 'chantier', 1, 32585500.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'approuve', 0, '2026-06-05 12:52:57'),
(386, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 145000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 13:02:08'),
(387, 2, 0, 'Fonctionnemnt bureau', 'Jeannette moses', '', 'chantier', 1, 192000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'approuve', 0, '2026-06-05 13:03:33'),
(388, 2, 0, 'Fonctionnemnt bureau', 'Jean Marie Rugamira', 'Jean Marie Rugamira', 'fonctionnement', 0, 150000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 13:04:49'),
(389, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 60000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'approuve', 0, '2026-06-05 13:14:58'),
(390, 2, 0, 'Fonctionnement', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 592000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 13:19:37'),
(391, 2, 0, 'Fonctionnemnt bureau', 'Pischon Igirumwete', '', 'chantier', 1, 10000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-05', '', 'approuve', 0, '2026-06-05 14:46:27'),
(392, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 700000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-05', '', 'traite', 0, '2026-06-05 15:01:06'),
(393, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 80000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-05', '', 'validation_technique', 0, '2026-06-05 15:33:44'),
(394, 2, 0, 'IBB', 'Ir Eric', 'Habonimana Anniella', 'chantier', 1, 2600000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-09', '', 'validation_technique', 0, '2026-06-09 08:59:41'),
(395, 2, 0, 'IBB ENTREPOT', 'Ir Eric', 'Habonimana Anniella', 'chantier', 1, 580000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-09', '', 'approuve', 0, '2026-06-09 09:07:08'),
(396, 2, 0, 'IBB', 'Ir Eric', 'Habonimana Anniella', 'chantier', 1, 3947500.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-09', '', 'validation_technique', 0, '2026-06-09 09:13:15'),
(397, 2, 0, 'IBB ENTREPOT', 'Ir Eric', 'Habonimana Anniella', 'chantier', 1, 357000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-09', '', 'approuve', 0, '2026-06-09 09:18:45'),
(398, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 2300000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-09', '', 'validation_technique', 0, '2026-06-09 09:21:46'),
(399, 2, 0, 'SOCABU Avenue du janvier', 'Simon', 'Habonimana Anniella', 'chantier', 1, 150000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-09', '', 'approuve', 0, '2026-06-09 09:23:46'),
(400, 2, 0, 'IBB ENTREPOT', 'Simeon', 'Habonimana Anniella', 'chantier', 1, 1467000.00, 'DT, Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-09', '', 'approuve', 0, '2026-06-09 09:27:20'),
(401, 2, 0, 'King\'s school', 'Simeon', 'Habonimana Anniella', 'chantier', 1, 2600000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-09', '', 'approuve', 0, '2026-06-09 09:33:03'),
(402, 2, 0, 'Fonctionnement', 'Jeannette moses', '', 'fonctionnement', 0, 1920000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'fonds_ok', '', '2026-06-09', '', 'traite', 0, '2026-06-09 10:25:50'),
(403, 2, 0, 'Les chanters different', 'Ir Arneud', 'Habonimana Anniella', 'chantier', 1, 75000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-09', '', 'en_verification', 0, '2026-06-09 10:27:40'),
(404, 2, 0, 'IBB ENTREPOT', 'CISHAHAYO ELIE MOSES', 'Nkorerimana Emmanuel', 'chantier', 1, 230000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', 'ELECTRICITE-GAINNE', '2026-06-09', '', 'approuve', 0, '2026-06-09 10:36:13'),
(405, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', '', 'chantier', 1, 200000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-09', '', 'approuve', 0, '2026-06-09 10:36:14'),
(406, 2, 0, 'KABEZI', 'ALEXIS HAKIZIMANA', '', 'chantier', 1, 400000.00, 'Ir David EMERUSABE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', 'TOPOGRAPHE', '2026-06-09', '', 'approuve', 0, '2026-06-09 10:47:52'),
(407, 2, 0, 'King\'s school', 'Michel', 'Habonimana Anniella', 'chantier', 1, 498000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-09', '', 'approuve', 0, '2026-06-09 11:04:35'),
(408, 2, 0, 'King\'s school', 'Ir Michel', 'Habonimana Anniella', 'chantier', 1, 1050000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-09', '', 'approuve', 0, '2026-06-09 11:07:21'),
(409, 2, 0, 'KINANIRA 3', 'Hategekimana Claude', 'Habonimana Anniella', 'chantier', 1, 929000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-09', '', 'validation_technique', 0, '2026-06-09 11:17:19'),
(410, 2, 0, 'Fonctionnemnt bureau', 'Gedeon Habingabwa', '', 'chantier', 1, 300000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-09', '', 'approuve', 0, '2026-06-09 11:32:00'),
(411, 2, 0, 'Fonctionnemnt', 'KWIZERIMANA EMERY', 'KWIZERIMANA EMERY', 'fonctionnement', 0, 106000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-09', '', 'traite', 0, '2026-06-09 13:14:00'),
(412, 2, 0, 'GIHOSHA ZONE', 'Arnaud', 'Arnaud', 'fonctionnement', 0, 15000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', 'Ciment de stock', '2026-06-09', '', 'traite', 0, '2026-06-09 14:16:21'),
(413, 2, 0, 'KINGS SCHOOL', 'Arnaud', 'Arnaud', 'chantier', 1, 10000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-09', 'Ciment de stock', 'approuve', 0, '2026-06-09 14:17:13'),
(414, 2, 0, 'KINANIRA 3', 'Arnaud', 'Arnaud', 'chantier', 1, 3500.00, 'IR', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-09', '', 'approuve', 0, '2026-06-09 14:18:06'),
(415, 2, 0, 'IBB entrepots', 'Arnaud', 'Arnaud', 'fonctionnement', 0, 7500.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-09', 'Approvisionnement Stock', 'traite', 0, '2026-06-09 14:19:51'),
(416, 2, 0, 'GATOKE CLAUDOIR', 'Arnaud', 'Arnaud', 'fonctionnement', 0, 1500.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-09', 'Approvisionnement Stock', 'traite', 0, '2026-06-09 14:20:51'),
(417, 2, 0, 'GIHOSHA NDAYI', 'Arnaud', 'Arnaud', 'chantier', 1, 5000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-09', 'Approvisionnement de Stock', 'approuve', 0, '2026-06-09 14:21:56'),
(418, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 120000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-10', '', 'traite', 0, '2026-06-10 10:37:34'),
(419, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 100000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-10', '', 'traite', 0, '2026-06-10 10:40:46'),
(420, 2, 0, 'Artisanat .Moderne', 'NAHAYO NORMAND', '', 'fonctionnement', 0, 560000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-10', 'Paiement 2ème et derniere tranche', 'traite', 0, '2026-06-10 11:32:29'),
(421, 2, 0, 'IBB ENTREPOT', 'Ir ERIC', 'HABONIMANA ANNIELLA', 'chantier', 1, 200000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-10', '', 'approuve', 0, '2026-06-10 11:34:14'),
(422, 2, 0, 'PROJET PAVÉ', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 576000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-10', '', 'simplifie', 0, '2026-06-10 11:36:27'),
(423, 2, 0, 'IBB entrepots', 'Ir Eric', 'HABONIMANA ANNIELLA', 'chantier', 1, 702800.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-10', '', 'approuve', 0, '2026-06-10 11:49:00'),
(424, 2, 0, 'FONCTIONNEMENT', 'HAKIZIMANA GRATIEN', '', 'fonctionnement', 0, 400000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-10', '', 'traite', 0, '2026-06-10 12:27:23'),
(425, 2, 0, 'Fonctionnemnt bureau', 'IGIRUMWETE Pischon', 'IGIRUMWETE Pischon', 'fonctionnement', 0, 50000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-10', '', 'traite', 0, '2026-06-10 14:50:08'),
(426, 2, 0, 'Fonctionnemnt bureau', 'KWIZERIMANA EMERY', '', 'fonctionnement', 0, 45000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-10', '', 'traite', 0, '2026-06-10 14:58:25'),
(427, 2, 0, 'Fonctionnemnt', 'MANIRAGABA  Serges', '', 'fonctionnement', 0, 729000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-10', '', 'traite', 0, '2026-06-10 15:07:49'),
(428, 2, 0, 'Fonctionnemnt bureau', 'NKESHIMANA Come', '', 'chantier', 1, 100000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-10', '', 'approuve', 0, '2026-06-10 15:09:20'),
(429, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 1101000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-10', '', 'traite', 0, '2026-06-10 15:21:43'),
(430, 2, 0, 'Fonctionnemnt', 'NKESHIMANA Come', 'NKESHIMANA Come', 'fonctionnement', 0, 741604.50, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-10', '', 'traite', 0, '2026-06-10 16:20:28'),
(431, 2, 0, 'IBB ENTREPOT', 'Moïse', 'HABONIMANA ANNIELLA', 'chantier', 1, 4964000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-11', '', 'approuve', 0, '2026-06-11 08:53:01'),
(432, 2, 0, 'KINANIRA 3', 'Vital', 'HABONIMANA ANNIELLA', 'chantier', 1, 70000.00, 'Ir Fabrice NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-11', '', 'approuve', 0, '2026-06-11 08:55:58'),
(433, 2, 0, 'KING\'S SCHOOL', 'Ir Michel', 'HABONIMANA ANNIELLA', 'chantier', 1, 864000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-11', '', 'approuve', 0, '2026-06-11 08:58:36'),
(434, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 1250000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-11', '', 'traite', 0, '2026-06-11 09:22:26'),
(435, 2, 0, 'Fonctionnement', 'NKESHIMANA Come', '', 'chantier', 1, 700000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-11', '', 'approuve', 0, '2026-06-11 09:25:15'),
(436, 2, 0, 'Fonctionnemnt bureau', 'Irakoze Alpha Dénard', 'Nelly Ange', 'chantier', 1, 1500000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-11', '', 'approuve', 0, '2026-06-11 09:45:49'),
(437, 2, 0, 'Fonctionnemnt bureau', 'Emmanuel Niyimbona', 'Jean de Dieu Niyonkuru', 'fonctionnement', 0, 150000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-11', '', 'traite', 0, '2026-06-11 09:59:58'),
(438, 2, 0, 'Fonctionnemnt bureau', 'Emmanuel Niyimbona', 'Jean de Dieu Niyonkuru', 'fonctionnement', 0, 250000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-11', '', 'traite', 0, '2026-06-11 10:02:09');
INSERT INTO `purchase_request_forms` (`id`, `company_id`, `chantier_id`, `destination_chantier`, `requested_by`, `buyer_name`, `category_type`, `requires_validation`, `total_amount`, `verified_by`, `technical_approver`, `financial_approver`, `dg_approver`, `treasurer_name`, `verifier_status`, `technical_status`, `financial_status`, `dg_status`, `treasury_status`, `supplier_followup`, `request_date`, `notes`, `workflow_status`, `created_by`, `created_at`) VALUES
(439, 2, 0, 'TEMOINS DE JEHOVAH', 'MANIRAKIZA Michel', '', 'chantier', 1, 1500000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-04', '', 'approuve', 0, '2026-06-11 11:05:06'),
(440, 2, 0, 'Fonctionnement', 'TUYISHIME  Providence', '', 'fonctionnement', 0, 50000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-11', '', 'traite', 0, '2026-06-11 11:07:35'),
(441, 2, 0, 'BIO KINGS', 'NDEREYAHAYO MANASSE', '', 'chantier', 1, 150000.00, 'chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-11', '', 'en_verification', 0, '2026-06-11 11:28:49'),
(442, 2, 0, 'Fonctionnemnt bureau', 'NDEREYAHAYO MANASE', '', 'chantier', 1, 150000.00, 'chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-11', '', 'en_verification', 0, '2026-06-11 11:35:13'),
(443, 2, 0, 'CONSULTANCE', 'NTWARI Lionel', '', 'fonctionnement', 0, 500000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-11', '', 'traite', 0, '2026-06-11 14:04:10'),
(444, 2, 0, 'FONCTIONNEMENT/OFFRE SOCABU GITEGA', 'NDIKUMANA           Laurent', '', 'chantier', 1, 53000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-11', '', 'approuve', 0, '2026-06-11 14:07:51'),
(445, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 735000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-11', '', 'validation_technique', 0, '2026-06-11 14:56:04'),
(446, 2, 0, 'Fonctionnemnt bureau', 'KWIZERIMANA EMERY', '', 'chantier', 1, 112500.00, 'chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-11', '', 'en_verification', 0, '2026-06-11 16:05:22'),
(447, 2, 0, 'Fonctionnemnt bureau', 'Nelly Ange', 'Nelly Ange', 'chantier', 1, 25000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-12', '', 'approuve', 0, '2026-06-12 09:09:39'),
(448, 2, 0, 'Fonctionnemnt bureau', 'NSENGIYUMVA SALVATOR', '', 'chantier', 1, 300000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-12', '', 'en_verification', 0, '2026-06-12 09:58:27'),
(449, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NSENGIYUMVA MARC', 'fonctionnement', 0, 84000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-12', '', 'traite', 0, '2026-06-12 10:10:45'),
(450, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 660000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-12', '', 'traite', 0, '2026-06-12 10:27:24'),
(451, 2, 0, 'KING\' S SCHOOL', 'Aaron NSHIMIRIMANA', 'Habonimana Anniella', 'fonctionnement', 0, 200000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-12', '', 'traite', 0, '2026-06-12 10:33:21'),
(452, 2, 0, 'Fonctionnemnt', 'KWIZERIMANA Emery', 'KWIZERIMANA Emery', 'chantier', 1, 140000.00, 'CHEF COMPTABLE', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-12', '', 'approuve', 0, '2026-06-12 10:58:24'),
(453, 2, 0, 'KINANIRA 3', 'Ntibaruhisha Gaspard', 'HABONIMANA ANNIELLA', 'chantier', 1, 13000.00, 'NDAGIJE Mariam DAF', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-12', '', 'approuve', 0, '2026-06-12 12:23:24'),
(454, 2, 0, 'Fonctionnemnt bureau', 'Aaron', 'HABONIMANA ANNIELLA', 'chantier', 1, 55000.00, 'NDAGIJE Mariam DAF', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-12', '', 'approuve', 0, '2026-06-12 12:33:23'),
(455, 2, 0, 'Fonctionnemnt bureau', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 2300000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-12', '', 'traite', 0, '2026-06-12 12:45:07'),
(456, 2, 0, 'Fonctionnemnt bureau', 'Nelly Ange', 'Nelly Ange', 'fonctionnement', 0, 40000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-12', '', 'traite', 0, '2026-06-12 12:50:21'),
(457, 2, 0, 'Fonctionnemnt', 'Jeannette moses', '', 'fonctionnement', 0, 168000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-12', '', 'traite', 0, '2026-06-12 12:54:50'),
(458, 2, 0, 'Fonctionnemnt', 'Nelly Ange', 'Nelly Ange', 'fonctionnement', 0, 20000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-12', '', 'traite', 0, '2026-06-12 13:33:19'),
(459, 2, 0, 'Fonctionnemnt', 'NAHIMANA RAMLA', '', 'fonctionnement', 0, 303000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-12', '', 'traite', 0, '2026-06-12 13:49:27'),
(460, 2, 0, 'KINANIRA III', 'NKESHIMANA Come', '', 'chantier', 1, 750000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-12', '', 'approuve', 0, '2026-06-12 15:47:54'),
(461, 2, 0, 'KING\'S SCHOOL', 'NKESHIMANA Come', '', 'chantier', 1, 350000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-12', '', 'approuve', 0, '2026-06-12 15:53:43'),
(462, 2, 0, 'GIHOSHA ZONE', 'NKESHIMANA Come', '', 'chantier', 1, 350000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-12', '', 'approuve', 0, '2026-06-12 15:55:51'),
(463, 2, 0, 'Fonctionnemnt', 'NAHIMANA Ramla', 'NAHIMANA Ramla', 'fonctionnement', 0, 187500.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-15', '', 'traite', 0, '2026-06-15 08:46:52'),
(464, 2, 0, 'JABE USDA', 'Ir NIRERA Kévin', 'Manirakiza Michel', 'chantier', 1, 2694000.00, 'DT NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-15', '', 'validation_technique', 0, '2026-06-15 09:35:52'),
(465, 2, 0, 'MUHA', 'NKORERIMANA EMMANUEL', '', 'chantier', 1, 50000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-15', '', 'approuve', 0, '2026-06-15 09:37:43'),
(466, 2, 0, 'KINGS SCHOOL', 'Manirakiza Michel', '', 'chantier', 1, 50000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-15', '', 'approuve', 0, '2026-06-15 09:42:04'),
(467, 2, 0, 'IBB entrepots', 'NKORERIMANA EMMANUEL', '', 'chantier', 1, 25000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-15', '', 'en_verification', 0, '2026-06-15 09:45:04'),
(468, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 920000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-15', '', 'approuve', 0, '2026-06-15 09:55:04'),
(469, 2, 0, 'GATOKE CLAUDOIR', 'Nsavyimana Edouard', 'HABONIMANA ANNIELLA', 'chantier', 1, 50000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-15', '', 'approuve', 0, '2026-06-15 10:36:06'),
(470, 2, 0, 'PROJET PAVE', 'IMENYAVYOSE Bernardin', 'TUYISABE SÉVÉRIN', 'chantier', 1, 200000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-15', '', 'approuve', 0, '2026-06-15 10:49:12'),
(471, 2, 0, 'KING\'S SCHOOL', 'Samson nizigama', 'HABONIMANA ANNIELLA', 'chantier', 1, 864000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-15', '', 'approuve', 0, '2026-06-15 11:18:09'),
(472, 2, 0, 'KINGS SCHOOL', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 310000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-15', '', 'approuve', 0, '2026-06-15 11:22:41'),
(473, 2, 0, 'KING\'S SCHOOL', 'Aaron', 'HABONIMANA ANNIELLA', 'chantier', 1, 400000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-15', '', 'en_verification', 0, '2026-06-15 11:43:26'),
(474, 2, 0, 'Projet Oua', 'Jean Marie Rugamira', 'Jean Marie Rugamira', 'chantier', 1, 450000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-15', '', 'approuve', 0, '2026-06-15 14:27:42'),
(475, 2, 0, 'Fonctionnemnt', 'KWIZERIMANA Emery', 'KWIZERIMANA Emery', 'fonctionnement', 0, 257000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-15', '', 'traite', 0, '2026-06-15 15:44:46'),
(476, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', '', 'chantier', 1, 50000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-15', '', 'approuve', 0, '2026-06-15 15:52:34'),
(477, 2, 0, 'Fonctionnement', 'Niyonkuru Jean de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1400000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-15', '', 'approuve', 0, '2026-06-15 16:42:55'),
(478, 2, 0, 'PROJET PAVE', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 1254400.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', '', 'traite', 0, '2026-06-16 08:48:07'),
(479, 2, 0, 'IBB ENTREPOT', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 2050000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', '', 'approuve', 0, '2026-06-16 09:10:05'),
(480, 2, 0, 'Fonctionnemnt', 'Jeannette moses', '', 'chantier', 1, 48000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', '', 'approuve', 0, '2026-06-16 09:14:51'),
(481, 2, 0, 'KINANIRA 3', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 150000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-16', '', 'approuve', 0, '2026-06-16 09:35:04'),
(482, 2, 0, 'Fonctionnement', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 750000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-16', '', 'approuve', 0, '2026-06-16 09:37:45'),
(483, 2, 0, 'Fonctionnemnt', 'NGUMIJAMAHORO P.Johnson', '', 'chantier', 1, 760000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', '', 'approuve', 0, '2026-06-16 09:43:27'),
(484, 2, 0, 'Fonctionnemnt', 'Nelly Ange', '', 'fonctionnement', 0, 1800000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', '', 'traite', 0, '2026-06-16 10:33:20'),
(485, 2, 0, 'Fonctionnemnt', 'Axcel', 'Axcel', 'fonctionnement', 0, 100.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-16', '', 'simplifie', 0, '2026-06-16 11:22:49'),
(486, 2, 0, 'Fonctionnement/Projet Oua', 'Jean Marie Rugamira', 'Jean Marie Rugamira', 'fonctionnement', 0, 450000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-16', '', 'traite', 0, '2026-06-16 11:42:03'),
(487, 2, 0, 'Fonctionnement /Projet Oua', 'Jean Marie Rugamira', 'Jean Marie Rugamira', 'fonctionnement', 0, 40000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', '', 'traite', 0, '2026-06-16 11:43:45'),
(488, 2, 0, 'Fonctionnement Projet Oua', 'Jean Marie Rugamira', 'Jean Marie Rugamira', 'fonctionnement', 0, 120000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', '', 'traite', 0, '2026-06-16 11:46:25'),
(489, 2, 0, 'Fonctionnemnt', 'Charoi Jacques', '', 'chantier', 1, 251114.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', '', 'approuve', 0, '2026-06-16 12:02:26'),
(490, 2, 0, 'Fonctionnement /Projet Oua', 'Jean Marie Rugamira', 'Jean Marie Rugamira', 'fonctionnement', 0, 820000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', '', 'traite', 0, '2026-06-16 12:24:05'),
(491, 2, 0, 'Fonctionnemnt', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'chantier', 1, 439000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', '', 'approuve', 0, '2026-06-16 13:17:51'),
(492, 2, 0, 'Fonctionnemnt', 'NKESHIMANA Come', '', 'chantier', 1, 300000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-16', '', 'approuve', 0, '2026-06-16 14:20:46'),
(493, 2, 0, 'GATOKE CLAUDOIR', 'NKORERIMANA Emmanuel', '', 'chantier', 1, 3000000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-16', 'RESTE A PAYER 6518750 FBU SUR LE MONTANT DU COUT DU MARCHE DE 23518750 FBU', 'approuve', 0, '2026-06-16 14:52:17'),
(494, 2, 0, 'Fonctionnemnt', 'AHISHAKIYE NELLY ANGE', '', 'chantier', 1, 1800000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-16', '', 'en_verification', 0, '2026-06-16 16:50:28'),
(495, 2, 0, 'Fonctionnemnt', 'HABONIMANA Aniella', '', 'chantier', 1, 500000.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-16', '', 'approuve', 0, '2026-06-16 16:53:28'),
(496, 2, 0, 'Fonctionnemnt', 'RUGAMBIRA Thomas', '', 'chantier', 1, 500000.00, 'MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-16', '', 'en_verification', 0, '2026-06-16 16:56:51'),
(497, 2, 0, 'Brarudi', 'Moses Cishahayo', 'Habonimana Anniella', 'chantier', 1, 422000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 08:58:44'),
(498, 2, 0, 'King\'s school', 'Ir Michel', 'Habonimana Anniella', 'chantier', 1, 107000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 09:09:41'),
(499, 2, 0, 'KINANIRA 3', 'Vital', 'Habonimana Anniella', 'chantier', 1, 288000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 09:12:13'),
(500, 2, 0, 'KING\'S SCHOOL', 'NDIHOKUBWAYO     MICHEL', 'HABONIMANA         Anniella', 'chantier', 1, 100000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 09:17:14'),
(501, 2, 0, 'IBB ENTREPOT', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 900000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 09:37:56'),
(502, 2, 0, 'PROJET PAVE', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 18320000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'traite', 0, '2026-06-17 09:41:30'),
(503, 2, 0, 'IBB ENTREPOT', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 300000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 09:52:39'),
(504, 2, 0, 'PROJET PAVE', 'IMENYAVYOSE Bernardin', '', 'fonctionnement', 0, 652800.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'traite', 0, '2026-06-17 09:57:13'),
(505, 2, 0, 'Fonctionnemnt', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1400000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 10:11:52'),
(506, 2, 0, 'GIHOSHA NDAYI', 'Mine Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 1323000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 10:14:25'),
(507, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 480000.00, 'Nibitanga Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 10:17:46'),
(508, 2, 0, 'Fonctionnemnt', 'James Ngendakumana', '', 'fonctionnement', 0, 1060000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'traite', 0, '2026-06-17 12:49:50'),
(509, 2, 0, 'PROJET PAVÉ', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'chantier', 1, 864000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 13:28:48'),
(510, 2, 0, 'PROJET PAVE', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 80000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'traite', 0, '2026-06-17 13:32:44'),
(511, 2, 0, 'Fonctionnemnt', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 920000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'en_attente', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'traite', 0, '2026-06-17 14:51:11'),
(512, 2, 0, 'BRARUDI', 'IR David', '', 'chantier', 1, 513000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 15:07:31'),
(513, 2, 0, 'Fonctionnemnt', 'KWIZERIMANA EMERY', '', 'chantier', 1, 28000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 16:12:05'),
(514, 2, 0, 'IBB ENTREPOT', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1000000.00, 'DT, NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 16:12:41'),
(515, 2, 0, 'Fonctionnemnt', 'RUGAMBIRA THOMAS', '', 'chantier', 1, 170000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-17', '', 'approuve', 0, '2026-06-17 16:51:40'),
(516, 2, 0, 'GIHOSHA NDAYI', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 1900000.00, '', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-17', '', 'en_verification', 0, '2026-06-17 18:32:35'),
(517, 2, 0, 'King\'s school', 'Ir Michel', 'Habonimana Anniella', 'chantier', 1, 576000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'approuve', 0, '2026-06-18 08:43:33'),
(518, 2, 0, 'PROJET PAVE', 'IMENYAVYOSE Bernardin', '', 'fonctionnement', 0, 930000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'traite', 0, '2026-06-18 09:16:57'),
(519, 2, 0, 'Fonctionnemnt', 'NKESHIMANA Come', '', 'chantier', 1, 700000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'approuve', 0, '2026-06-18 09:52:28'),
(520, 2, 0, 'Fonctionnemnt', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 164000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'traite', 0, '2026-06-18 10:06:35'),
(521, 2, 0, 'Fonctionnemnt', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 30000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'traite', 0, '2026-06-18 10:19:26'),
(522, 2, 0, 'KINANIRA III', 'HABONIMANA ANNIELLA', 'GOLDEN  PAINT, MUZAFALA', 'chantier', 1, 5000000.00, 'Ir Fabrice     NIBITANGA', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'approuve', 0, '2026-06-18 11:52:47'),
(523, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 2865000.00, 'DT-Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'approuve', 0, '2026-06-18 12:00:24'),
(524, 2, 0, 'KING\'S SCHOOL', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 2865000.00, 'DT-Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'approuve', 0, '2026-06-18 12:01:39'),
(525, 2, 0, 'FONCTIONNEMENT', 'NDUWAYO EMMANUEL', 'NAHAYO NORMAND, ARTISAN  MODERNE', 'fonctionnement', 0, 601000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', 'Paiement 1ère tranche du montant total de 1246250 FBU du devis en annexe', 'traite', 0, '2026-06-18 14:36:41'),
(526, 2, 0, 'FONCTIONNEMENT', 'NDUWAYO EMMANUEL', 'NAHAYO NORMAND, ARTISAN  MODERNE', 'fonctionnement', 0, 512500.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'traite', 0, '2026-06-18 14:40:42'),
(527, 2, 0, 'FONCTIONNEMENT', 'NDUWAYO EMMANUEL', 'NAHAYO NORMAND, ARTISAN  MODERNE', 'fonctionnement', 0, 668250.00, 'MANIRAGABA Serges, chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'traite', 0, '2026-06-18 14:47:50'),
(528, 2, 0, 'Fonctionnemnt', 'IGIRUMWETE Pischon', '', 'fonctionnement', 0, 70000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'traite', 0, '2026-06-18 16:09:01'),
(529, 2, 0, 'PROJET PAVE', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 798000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-18', '', 'traite', 0, '2026-06-18 16:15:24'),
(530, 2, 0, 'PROJET PAVE', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 588000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'en_attente', '', '2026-06-18', '', 'validation_financiere', 0, '2026-06-18 16:18:47'),
(531, 2, 0, 'Fonctionnemnt', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'fonctionnement', 0, 1120000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-19', '', 'traite', 0, '2026-06-19 09:08:24'),
(532, 2, 0, 'Fonctionnemnt', 'NIYONKURU J de Dieu', 'NIYONKURU Jean de Dieu', 'chantier', 1, 660000.00, 'MANIRAGABA Serges, Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-19', '', 'validation_financiere', 0, '2026-06-19 09:15:14'),
(533, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 288000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-19', '', 'en_verification', 0, '2026-06-19 10:40:36'),
(534, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 288000.00, 'DT', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-19', '', 'en_verification', 0, '2026-06-19 10:40:42'),
(535, 2, 0, 'KINANIRA 3', 'Vital', 'Habonimana Anniella', 'chantier', 1, 45000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-19', '', 'en_verification', 0, '2026-06-19 10:45:06'),
(536, 2, 0, 'Fonctionnemnt', 'NKESHIMANA Come', '', 'chantier', 1, 110000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-19', '', 'approuve', 0, '2026-06-19 11:00:43'),
(537, 2, 0, 'Tout les chantiers', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 26919600.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-19', '', 'approuve', 0, '2026-06-19 11:07:12'),
(538, 2, 0, 'Fonctionnemnt', 'Jeannette moses', '', 'chantier', 1, 192000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-19', '', 'approuve', 0, '2026-06-19 11:27:52'),
(539, 2, 0, 'Fonctionnemnt', 'NSENGIMANA ALAIN', '', 'chantier', 1, 1750000.00, 'Chef comptable, MANIRAGABA  Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-19', '', 'approuve', 0, '2026-06-19 11:30:43'),
(540, 2, 0, 'Fonctionnemnt', 'NAHIMANA RAMLA', '', 'fonctionnement', 0, 426000.00, 'Chef comptable, MANIRAGABA Serges', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'fonds_ok', '', '2026-06-19', '', 'traite', 0, '2026-06-19 11:49:53'),
(541, 2, 0, 'FONCTIONNEMENT', 'KWIZERIMANA EMERY', 'KWIZERIMANA EMERY', 'fonctionnement', 0, 193000.00, 'MANIRAGABA SERGES', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-19', '', 'traite', 0, '2026-06-19 11:56:00'),
(542, 2, 0, 'Fonctionnemnt', 'Niyitegeka Jacques', '', 'fonctionnement', 0, 60000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'valide', 'fonds_ok', '', '2026-06-19', '', 'traite', 0, '2026-06-19 12:16:49'),
(543, 2, 0, 'EDEN /KAJAGA', 'NDUWAYO EMMANUEL', 'NAHAYO NORMAND', 'fonctionnement', 0, 17572500.00, 'DT: NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-19', '', 'simplifie', 0, '2026-06-19 15:30:07'),
(544, 2, 0, 'EDEN /KAJAGA', 'NDUWAYO EMMANUEL', 'NAHAYO NORMAND', 'fonctionnement', 0, 5966250.00, 'DT: NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-19', '', 'simplifie', 0, '2026-06-19 15:38:07'),
(545, 2, 0, 'GIHOSHA ZONE', 'NDUWAYO EMMANUEL', 'NAHAYO NORMAND', 'fonctionnement', 0, 33987500.00, 'DT: NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-19', '', 'simplifie', 0, '2026-06-19 15:45:59'),
(546, 2, 0, 'GIHOSHA ZONE', 'NDUWAYO EMMANUEL', 'NAHAYO NORMAND', 'fonctionnement', 0, 46760000.00, 'DT: NIYIMBONA EMMANUEL', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-19', '', 'simplifie', 0, '2026-06-19 15:55:00'),
(547, 2, 0, 'Fonctionnemnt', 'Niyitegeka Jacques', 'Niyitegeka Jacques', 'fonctionnement', 0, 2200000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-21', '', 'simplifie', 0, '2026-06-21 14:30:34'),
(548, 2, 0, 'King\'s school', 'Ir Michel', 'HABONIMANA ANNIELLA', 'chantier', 1, 864000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 07:51:36'),
(549, 2, 0, 'PROJET PAVE', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 964000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'simplifie', 0, '2026-06-22 07:57:06'),
(550, 2, 0, 'PROJET PAVE', 'TUYISABE SÉVÉRIN', 'TUYISABE SÉVÉRIN', 'fonctionnement', 0, 1200000.00, 'DT, NIYIMBONA Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'simplifie', 0, '2026-06-22 07:58:46'),
(551, 2, 0, 'GIHOSHA APPARTEMENT', 'Dionisie', 'HABONIMANA ANNIELLA', 'chantier', 1, 2880000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 08:40:10'),
(552, 2, 0, 'GIHOSHA APPARTEMENT', 'Dionisie', 'HABONIMANA ANNIELLA', 'chantier', 1, 200000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 08:44:30'),
(553, 2, 0, 'GIHOSHA APPARTEMENT', 'Dionisie', 'HABONIMANA ANNIELLA', 'chantier', 1, 3450000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 08:46:17'),
(554, 2, 0, 'Fonctionnemnt', 'DT NIYIMBONA EMMANUEL', '', 'chantier', 1, 120000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 08:58:10'),
(555, 2, 0, 'Fonctionnemnt', 'NIYONKURU JEAN DE DIEU', '', 'chantier', 1, 120000.00, 'Chef comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-16', '', 'en_verification', 0, '2026-06-22 09:00:37'),
(556, 2, 0, 'KINANIRA 3', 'Vital', 'Habonimana Anniella', 'chantier', 1, 60000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 09:02:59'),
(557, 2, 0, 'Kinanira 3', 'Patrick', 'Habonimana Anniella', 'chantier', 1, 450000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 09:23:09'),
(558, 2, 0, 'KINANIRA 3', 'Patrick', 'Habonimana Anniella', 'chantier', 1, 366000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 09:30:07'),
(559, 2, 0, 'GIHOSHA NDAYI', 'Munezero Claude', 'Habonimana Anniella', 'chantier', 1, 5760000.00, 'Niyimbona Emmanuel⅕', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 09:35:08'),
(560, 2, 0, 'IBB entrepots', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 1902000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 09:40:39'),
(561, 2, 0, 'Fonctionnemnt', 'Emerry', 'Habonimana Anniella', 'chantier', 1, 60000.00, 'Ndagije Mariam', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 09:42:42'),
(562, 2, 0, 'Fonctionnemnt bureau', 'Nkorerimana Emmanuel', 'Nkorerimana Emmanuel', 'chantier', 1, 60000.00, 'Ir Fabrice', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 09:50:33'),
(563, 2, 0, 'Fonctionnemnt', 'Emmanuel Niyimbona', '', 'fonctionnement', 0, 2000000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'simplifie', 0, '2026-06-22 10:06:23'),
(564, 2, 0, 'Fonctionnemnt', 'Emmanuel Niyimbona', '', 'fonctionnement', 0, 1100000.00, 'Serges Maniragaba', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'simplifie', 0, '2026-06-22 10:07:23'),
(565, 2, 0, 'Kunanira 3', 'Vital', 'Habonimana Anniella', 'chantier', 1, 576000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 10:10:22'),
(566, 2, 0, 'KINANIRA 3', 'Vital', 'Habonimana Anniella', 'chantier', 1, 70000.00, 'Niyimbona Emmanuel', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'en_attente', 'en_attente', 'en_attente', 'en_attente', 'en_attente', '', '2026-06-22', '', 'en_verification', 0, '2026-06-22 10:11:44'),
(568, 2, 1, 'IBB entrepots', 'Michel', 'Anniella', 'chantier', 1, 24579600.00, 'Chef Comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'valide', NULL, '2026-06-27', NULL, 'Valide', 0, '2026-06-27 09:29:58'),
(569, 2, 18, 'Fonctionnemnt', 'Severin', 'Severin', 'chantier', 1, 505000.00, 'Chef Comptable', 'Directeur Technique', 'Directrice Administrative et Financière', 'Directeur Général', 'Trésorier', 'valide', 'valide', 'valide', 'en_attente', 'valide', NULL, '2026-06-27', NULL, 'Valide', 22, '2026-06-27 15:39:55');

-- --------------------------------------------------------

--
-- Structure de la table `purchase_request_items`
--

CREATE TABLE `purchase_request_items` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `designation` text NOT NULL,
  `technical_specs` text DEFAULT NULL,
  `quantity` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unit_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `observations` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `purchase_request_items`
--

INSERT INTO `purchase_request_items` (`id`, `request_id`, `designation`, `technical_specs`, `quantity`, `unit_price`, `total_price`, `observations`) VALUES
(1, 1, 'MASTIC DE FER', 'KINGS SCHOOL', 6.00, 150000.00, 900000.00, ''),
(9, 2, 'MASTIC DE FER', 'BOITE', 6.00, 150000.00, 900000.00, ''),
(10, 2, 'ANTIROUILLE', 'BOITE', 6.00, 70000.00, 420000.00, ''),
(11, 2, 'PETROL', 'LITRE', 6.00, 20000.00, 120000.00, ''),
(12, 2, 'BROSS N°2', 'PCE', 10.00, 3000.00, 30000.00, ''),
(13, 2, 'ROULEAU PEINTRE', 'PCE', 10.00, 6000.00, 60000.00, ''),
(14, 2, 'BAGUETTE', 'BOITE', 5.00, 27000.00, 135000.00, ''),
(15, 2, 'PAPIER MELE', 'ROULEAU', 1.00, 70000.00, 70000.00, ''),
(16, 2, 'TUBE 20 X20', 'PCE', 30.00, 18000.00, 540000.00, ''),
(17, 2, 'PAUMELLE', 'PCE', 10.00, 5000.00, 50000.00, ''),
(20, 3, 'CHARGEMENT ET  DECHARGEMENT', 'ECHAFFAUDAGE ELECTRIQUE', 1.00, 130000.01, 130000.01, ''),
(26, 6, 'Ciments', 'Lissages', 100.00, 57000.00, 5700000.00, ''),
(60, 5, 'Eagle mineral water', 'paquets', 15.00, 8500.00, 127500.00, ''),
(61, 5, 'Eagle mineral water', 'bidons', 10.00, 5000.00, 50000.00, ''),
(80, 8, 'Ciments', 'Maçonnerie des annexes', 20.00, 57000.00, 1140000.00, ''),
(97, 10, 'Ciments', 'Construction du clôture', 20.00, 57000.00, 1140000.00, ''),
(98, 11, 'Ciment', '', 100.00, 57000.00, 5700000.00, ''),
(99, 11, 'Chargement & Dechargement', '', 100.00, 600.00, 60000.00, ''),
(100, 12, 'Ciment', '', 20.00, 57000.00, 1140000.00, ''),
(101, 12, 'Chargement & Dechargement', '', 20.00, 600.00, 12000.00, ''),
(102, 13, 'Ciment', '', 10.00, 57000.00, 570000.00, ''),
(103, 13, 'chargment & dechargemet', '', 10.00, 600.00, 6000.00, ''),
(104, 13, 'cloux', '', 2.00, 180000.00, 360000.00, ''),
(105, 14, 'Main d\'oeuvre', '', 1.00, 500000.00, 500000.00, ''),
(106, 15, 'Ciment', '', 20.00, 57000.00, 1140000.00, ''),
(107, 15, 'chargement & dechargement', '', 20.00, 600.00, 12000.00, ''),
(108, 16, 'Avance sur main d\'oeuvre occasionnel', '', 1.00, 500000.00, 500000.00, ''),
(111, 18, 'Interligence Artificiel', '', 1.00, 100.00, 100.00, 'Payement des Outils des rendu des Images'),
(115, 22, 'VOB 1.5MM', '', 15.00, 170000.00, 2550000.00, ''),
(116, 22, 'VOB 2.5MM', '', 20.00, 230000.00, 4600000.00, ''),
(117, 22, 'Isolant', '', 10.00, 5000.00, 50000.00, ''),
(119, 23, 'Peinture Blanch', '', 1.00, 81500.00, 81500.00, ''),
(120, 23, 'Grand Rouleau', '', 1.00, 6000.00, 6000.00, ''),
(121, 23, 'Planfon Dubai 8 metre carre', '', 8.00, 75000.00, 600000.00, ''),
(122, 23, 'mastique', '', 20.00, 60000.00, 1200000.00, ''),
(123, 23, 'papier meuleu 180', '', 3.00, 4000.00, 12000.00, ''),
(171, 25, 'Poigne', '', 19.00, 7000.00, 133000.00, ''),
(172, 25, 'Tube 60*40', '', 3.00, 44500.00, 133500.00, ''),
(173, 25, 'Fer Plan de 20', '', 10.00, 13000.00, 130000.00, ''),
(174, 25, 'Pomelle de 12', '', 3.00, 6000.00, 18000.00, ''),
(175, 25, 'Tole Plane de 3m', '', 1.00, 160000.00, 160000.00, ''),
(176, 25, 'Pomelle de 8', '', 1.00, 5000.00, 5000.00, ''),
(177, 25, 'Disque a Couper', '', 7.00, 13000.00, 91000.00, ''),
(178, 25, 'Baguette', '', 1.00, 26000.00, 26000.00, ''),
(179, 25, 'Mastique de fer', '', 2.00, 140000.00, 280000.00, ''),
(180, 25, 'Brosse Numero 2', '', 2.00, 2500.00, 5000.00, ''),
(181, 25, 'Petit Rouleau', '', 2.00, 3000.00, 6000.00, ''),
(182, 25, 'Papier Meuleu de 80', '', 5.00, 4000.00, 20000.00, ''),
(183, 25, 'Tube de 16*16', '', 4.00, 15000.00, 60000.00, ''),
(190, 28, 'Capati', '', 35.00, 1500.00, 52500.00, ''),
(191, 28, 'samboussa', '', 6.00, 1000.00, 6000.00, ''),
(192, 30, 'Pain Coupe de Ble', '', 1.00, 5000.00, 5000.00, ''),
(193, 30, 'Pain Coupe de Farine', '', 4.00, 5500.00, 22000.00, ''),
(194, 30, 'Pain(akadingi)', '', 1.00, 3000.00, 3000.00, ''),
(195, 30, 'Avocat', '', 5.00, 2000.00, 10000.00, ''),
(196, 31, 'Capati', '', 35.00, 1500.00, 52500.00, ''),
(197, 31, 'Samboussa', '', 6.00, 1000.00, 6000.00, ''),
(201, 33, 'Fer a beton de 10', '', 35.00, 58000.00, 2030000.00, ''),
(202, 33, 'Fer a beton de 12', '', 5.00, 78000.00, 390000.00, ''),
(203, 33, 'Fer a beton de 8', '', 200.00, 38000.00, 7600000.00, ''),
(204, 33, 'Fil a rigature', '', 2.00, 220000.00, 440000.00, ''),
(205, 33, 'CHARGEMENT ET  DECHARGEMENT', '', 1.00, 121000.00, 121000.00, ''),
(207, 35, 'Ciment', '', 100.00, 57000.00, 5700000.00, ''),
(208, 35, 'CHARGEMENT ET  DECHARGEMENT', '', 100.00, 600.00, 60000.00, ''),
(209, 36, 'gravier', '', 1.00, 750000.00, 750000.00, ''),
(210, 36, 'sable', '', 1.00, 300000.00, 300000.00, ''),
(211, 37, 'Madrier', '', 20.00, 13000.00, 260000.00, ''),
(212, 37, 'chevron', '', 350.00, 5000.00, 1750000.00, ''),
(213, 37, 'CHARGEMENT ET  DECHARGEMENT', '', 370.00, 200.00, 74000.00, ''),
(288, 40, 'Pain Coupe de Farine', '', 4.00, 5500.00, 22000.00, ''),
(289, 40, 'Capati', '', 70.00, 1500.00, 105000.00, ''),
(290, 40, 'Samboussa', '', 12.00, 1000.00, 12000.00, ''),
(291, 40, 'Pain Coupe de Ble', '', 1.00, 5000.00, 5000.00, ''),
(292, 40, 'Pain(ubudingi)', '', 1.00, 3000.00, 3000.00, ''),
(293, 40, 'Beignet', '', 70.00, 1000.00, 70000.00, ''),
(294, 40, 'Avocat', '', 5.00, 2000.00, 10000.00, ''),
(295, 40, 'Miel', '', 1.50, 35000.00, 52500.00, ''),
(303, 42, 'CIBITOKE/HOPITAL UBUNTU', 'Levés topographiques(Avance)', 1.00, 300000.00, 300000.00, ''),
(312, 39, 'KABEZI', 'Etude de reconnaissance géotechnique du sol', 1.00, 850000.00, 850000.00, ''),
(350, 46, 'Avance sur achat de vibreuse', 'Utilisation sur les chantiers lors de betonnages', 1.00, 200000.00, 200000.00, ''),
(358, 43, 'Tubes 60x40 de 1,5mm', '', 24.00, 135000.00, 3240000.00, ''),
(359, 43, 'Disque à coupé  (cartons)', '', 1.00, 130000.00, 130000.00, ''),
(360, 43, 'Baguette (2cartons)', '', 1.00, 270000.00, 270000.00, ''),
(361, 43, 'Antirouille', '', 2.00, 50000.00, 100000.00, ''),
(362, 43, 'Petroles (litles)', '', 2.00, 20000.00, 40000.00, ''),
(363, 43, 'Rouleau pointu', '', 5.00, 3000.00, 15000.00, ''),
(364, 43, 'Chargement des tubes', '', 1.00, 50000.00, 50000.00, ''),
(365, 43, 'Ciments', '', 20.00, 57000.00, 1140000.00, ''),
(366, 51, 'Disque a béton grand', '', 2.00, 50000.00, 100000.00, ''),
(367, 51, 'Disque a béton petit', '', 1.00, 20000.00, 20000.00, ''),
(368, 51, 'Fer a béton de 8', '', 2.00, 38000.00, 76000.00, ''),
(369, 51, 'Utubuye twirabura', '', 4.00, 20000.00, 80000.00, ''),
(370, 51, 'Chargement de deux fab', '', 2.00, 300.00, 600.00, ''),
(381, 48, 'chaussures du terrain', '', 1.00, 200000.00, 200000.00, ''),
(384, 50, 'TUYAU GAINE', 'PCE', 12.00, 7000.00, 84000.00, ''),
(385, 50, 'Manchon', 'pce', 10.00, 2000.00, 20000.00, ''),
(386, 50, 'Ampoule', 'pce', 1.00, 10000.00, 10000.00, ''),
(388, 17, 'inkwi', '', 100.00, 160000.00, 16000000.00, ''),
(418, 53, 'Assurence Maladie', 'Fonctionnement', 43.00, 40000.00, 1720000.00, ''),
(419, 7, 'Moillon de riviere', '', 2.00, 180000.00, 360000.00, ''),
(420, 7, 'Moillon de carriere', '', 2.00, 175000.00, 350000.00, ''),
(421, 7, 'Gravier', '', 1.00, 160000.00, 160000.00, ''),
(422, 7, 'Fer a Beton de 8cm', '', 15.00, 38450.00, 576750.00, ''),
(423, 7, 'Etrier 15*15', '', 300.00, 1300.00, 390000.00, ''),
(424, 7, 'Cloux de 6cm', '', 1.00, 180000.00, 180000.00, ''),
(425, 7, 'Cloux de 10cm', '', 1.00, 180000.00, 180000.00, ''),
(426, 7, 'Fil a rigature', '', 10.00, 15000.00, 150000.00, ''),
(427, 7, 'Ciment', '', 15.00, 57000.00, 855000.00, ''),
(434, 9, 'Ciment', '', 16.00, 57000.00, 912000.00, ''),
(435, 9, 'Boullon', '', 1.00, 260000.00, 260000.00, ''),
(436, 9, 'Fil a rigature', '', 1.00, 220000.00, 220000.00, ''),
(437, 9, 'Ram de scie', '', 6.00, 5000.00, 30000.00, ''),
(438, 9, 'Brique', '', 30000.00, 12.50, 375000.00, ''),
(442, 20, 'Frais de ration et Routier des chauffeur', '', 1.00, 700000.00, 700000.00, ''),
(443, 34, 'essense', '', 2.00, 270000.00, 540000.00, ''),
(446, 24, 'Briques industriels', 'Maçonnerie', 4000.00, 700.00, 2800000.00, ''),
(447, 24, 'Taxe communal', 'Ff', 4000.00, 7.00, 28000.00, ''),
(448, 24, 'Déchargement', 'Ff', 4000.00, 10.00, 40000.00, ''),
(490, 61, 'Avance sur Main d\'oeuvre', 'Nettoyage', 1.00, 200000.00, 200000.00, ''),
(500, 4, 'Perches', 'Échafaudage pour charpente', 600.00, 2500.00, 1500000.00, ''),
(501, 4, 'Cloux', 'Échafaudage pour charpente', 2.00, 180000.00, 360000.00, ''),
(502, 62, 'control de compresseur', 'benz E1070A', 1.00, 200000.00, 200000.00, ''),
(505, 60, 'Frais de Ration', 'Nettoyage', 1.00, 200000.00, 200000.00, ''),
(564, 67, 'Amagorori', 'Moto JEHOKUKI', 1.00, 10000.00, 10000.00, ''),
(565, 67, 'Bourrage', 'Moto JEHOKUKI', 1.00, 10000.00, 10000.00, ''),
(566, 67, 'Bougis', 'Moto JEHOKUKI', 1.00, 12000.00, 12000.00, ''),
(567, 67, 'Chambrayeur', 'Moto JEHOKUKI', 1.00, 20000.00, 20000.00, ''),
(568, 67, 'Main d\'oeuvre', 'Moto JEHOKUKI', 1.00, 10000.00, 10000.00, ''),
(589, 44, 'Lavage du vehicule', 'E2464A', 2.00, 10000.00, 20000.00, ''),
(631, 49, 'chaussures du terrain', '', 1.00, 200000.00, 200000.00, ''),
(632, 68, 'HABINGABWA GEDEON', '', 1.00, 40000.00, 40000.00, ''),
(633, 68, 'NIYITEGEKA JACQUES', '', 1.00, 30000.00, 30000.00, ''),
(688, 19, 'Sable', 'Lissage', 2.00, 450000.00, 900000.00, ''),
(705, 47, 'Ciments', '', 15.00, 57000.00, 855000.00, ''),
(706, 47, 'Cloux', '', 2.00, 180000.00, 360000.00, ''),
(707, 47, 'Chargement et déchargement du ciment', '', 15.00, 600.00, 9000.00, ''),
(708, 47, 'Perches', '', 400.00, 3000.00, 1200000.00, ''),
(709, 56, 'Location des marteaux masses  pour 3jours', 'Démolition', 5.00, 15000.00, 75000.00, ''),
(710, 41, 'Moellons de carrière', '', 5.00, 230000.00, 1150000.00, ''),
(711, 41, 'Ciments', '', 9.00, 57000.00, 513000.00, ''),
(712, 41, 'Planches', '', 20.00, 13000.00, 260000.00, ''),
(713, 41, 'Chargement et déchargement du ciment', '', 9.00, 600.00, 5400.00, ''),
(714, 41, 'Bouillons', '', 1.00, 350000.00, 350000.00, ''),
(717, 64, 'IBB entrepots', 'Frais de stage professionnel du mois d\'avril', 1.00, 150000.00, 150000.00, ''),
(721, 71, 'umuhini/isuka', '', 1.00, 3000.00, 3000.00, ''),
(722, 59, 'Carreax Noirs', 'Carrélage', 5.76, 90000.00, 518400.00, ''),
(723, 59, 'Marbres Noirs', '', 3.00, 750000.00, 2250000.00, ''),
(724, 59, 'Petrôl', '', 1.00, 20000.00, 20000.00, ''),
(725, 59, 'Jexe', 'Nettoyage', 5.00, 1500.00, 7500.00, ''),
(726, 59, 'Savon multi Usage', 'Nettoyage', 5.00, 7000.00, 35000.00, ''),
(727, 59, 'Siphon du sol', '', 7.00, 50000.00, 350000.00, ''),
(728, 57, 'Seau de 20L', 'Peinture\r\nBlanche', 12.00, 330600.00, 3967200.00, ''),
(729, 57, 'Seau de 20L', 'Peinture Blanc Cassée', 15.00, 330600.00, 4959000.00, ''),
(730, 57, 'Seau de 4L', 'Peinture à l\'huile Bleue marine', 15.00, 207400.00, 3111000.00, ''),
(731, 57, 'Grands Rouleaux', 'à peindre', 10.00, 6000.00, 60000.00, ''),
(732, 57, 'Petits Rouleux', 'à peindre', 15.00, 3000.00, 45000.00, ''),
(733, 57, 'Brosses num 2', 'à peindre', 10.00, 2500.00, 25000.00, ''),
(734, 57, 'Papier Meuleux num 120', 'Pour poncer', 1.00, 65000.00, 65000.00, ''),
(735, 57, 'Petrôl', '', 5.00, 20000.00, 100000.00, ''),
(736, 32, 'Plaster', 'Peintures', 10.00, 150000.00, 1500000.00, 'I'),
(737, 32, 'Grands Rouleaux', 'Peintures', 10.00, 6000.00, 60000.00, ''),
(738, 32, 'Brosses num2', 'Peintures', 10.00, 3000.00, 30000.00, ''),
(741, 29, 'Ciment', 'Maçonnerie', 30.00, 57000.00, 1710000.00, ''),
(742, 29, 'Chargement et Déchargement', 'Ff', 30.00, 600.00, 18000.00, ''),
(743, 26, 'Briques cuites', 'Maçonnerie', 10000.00, 200.00, 2000000.00, ''),
(745, 65, 'Essense', '', 10.00, 270000.00, 2700000.00, ''),
(746, 72, 'fabr de tabl vibrante', '', 1.00, 1500000.00, 1500000.00, ''),
(747, 66, 'Plaster', '', 1.00, 150000.00, 150000.00, ''),
(748, 66, 'Peinture à eau', '', 2.00, 507000.00, 1014000.00, ''),
(749, 66, 'Scoth', '', 5.00, 10000.00, 50000.00, ''),
(750, 66, 'Papier lisse nº120', '', 20.00, 3000.00, 60000.00, ''),
(751, 66, 'Grand rouleaux', '', 4.00, 6000.00, 24000.00, ''),
(752, 66, 'Brosse nº2', '', 5.00, 3000.00, 15000.00, ''),
(753, 66, 'Petit rouleau', '', 4.00, 3000.00, 12000.00, ''),
(754, 66, 'Papier meré', '', 5.00, 5000.00, 25000.00, ''),
(755, 66, 'ROOFING', '', 2.00, 15000.00, 30000.00, ''),
(804, 76, 'Brique cuite', '', 30000.00, 200.00, 6000000.00, ''),
(805, 75, 'Brique cuite', '', 30000.00, 200.00, 6000000.00, ''),
(806, 21, 'Plaquar', '', 1.00, 700000.00, 700000.00, ''),
(814, 80, 'Huile de moteur', '', 13.00, 34000.00, 442000.00, ''),
(815, 80, 'Filtre d huile', '', 1.00, 150000.00, 150000.00, ''),
(825, 79, 'IMIPIRA(bislilles barre stabilisateur)', '', 2.00, 60000.00, 120000.00, ''),
(826, 79, 'Gourgeons', '', 9.00, 25000.00, 225000.00, ''),
(827, 79, 'Filtre mazout', '', 2.00, 50000.00, 100000.00, ''),
(828, 79, 'tuyau mazout', '', 4.00, 15000.00, 60000.00, ''),
(829, 79, 'cles des roues', '', 1.00, 150000.00, 150000.00, ''),
(830, 79, 'jeke camion', '', 1.00, 350000.00, 350000.00, ''),
(831, 79, 'Fil pompe', '', 1.00, 250000.00, 250000.00, ''),
(832, 79, 'Pompe d amorsage', '', 1.00, 80000.00, 80000.00, ''),
(833, 79, 'Gante', '', 1.00, 450000.00, 450000.00, ''),
(834, 81, 'Huile de Moteur', '', 13.00, 34000.00, 442000.00, ''),
(835, 81, 'Filtre d\'Huile', '', 1.00, 15000.00, 15000.00, ''),
(878, 73, 'Frais de déplacement après les heures de service le  12/5/2026', '', 1.00, 10000.00, 10000.00, ''),
(891, 85, 'Cimen', '', 50.00, 57000.00, 2850000.00, ''),
(892, 85, 'Chargement déchargement', '', 50.00, 600.00, 30000.00, ''),
(894, 70, 'NKURUNZIZA ALEXIS', '', 1.00, 100000.00, 100000.00, ''),
(895, 70, 'HAGABIMANA GEDEON', '', 1.00, 100000.00, 100000.00, ''),
(904, 89, 'Ciment', '', 13.00, 57000.00, 741000.00, ''),
(905, 89, 'Chargement déchargement', '', 13.00, 600.00, 7800.00, ''),
(907, 88, 'Ciment', '', 13.00, 57000.00, 741000.00, ''),
(908, 88, 'Chargement déchargement', '', 13.00, 600.00, 7800.00, ''),
(909, 87, 'Ciment', '', 13.00, 57000.00, 741000.00, ''),
(910, 87, 'Chargement déchargement', '', 13.00, 600.00, 7800.00, ''),
(911, 83, 'Mastic', '', 7.00, 65000.00, 455000.00, ''),
(912, 74, 'Sable', '', 1.00, 300000.00, 300000.00, ''),
(927, 95, 'Ciments', '', 20.00, 57000.00, 1140000.00, ''),
(928, 95, 'Chargement et déchargement du ciment', '', 20.00, 600.00, 12000.00, ''),
(931, 94, 'MAZOUT', '', 4.00, 300000.00, 1200000.00, ''),
(940, 91, 'Percles', 'Echauffade', 400.00, 3000.00, 1200000.00, ''),
(941, 91, 'Chargement et dechargement', '', 400.00, 200.00, 80000.00, ''),
(984, 86, 'ESSENCE', '', 5.00, 270000.00, 1350000.00, ''),
(992, 84, 'CARBURANT', 'MAZOUT', 5.00, 300000.00, 1500000.00, ''),
(1027, 98, 'Ration d\'opérateur', '', 1.00, 500000.00, 500000.00, ''),
(1069, 92, 'Ciment', 'KABIMBA', 10.00, 57000.00, 570000.00, ''),
(1070, 92, 'Charg /decharg ciment', '', 10.00, 600.00, 6000.00, ''),
(1082, 93, 'Vis WC siege encastre', '', 2.00, 80000.00, 160000.00, ''),
(1083, 93, 'Reducteur 3/8sur 1/6', '', 1.00, 40000.00, 40000.00, ''),
(1084, 93, 'Tuyaux flexible', '', 4.00, 15000.00, 60000.00, ''),
(1085, 93, 'Niple  1/2', '', 4.00, 2000.00, 8000.00, ''),
(1086, 93, 'Coude galvanise1/2', '', 3.00, 2500.00, 7500.00, ''),
(1104, 96, 'Levé topographique', '', 1.00, 150000.00, 150000.00, ''),
(1133, 103, 'Mastic de fer', '', 6.00, 150000.00, 900000.00, ''),
(1134, 103, 'Antirouille', '', 6.00, 70000.00, 420000.00, ''),
(1135, 103, 'Petrol', '', 6.00, 20000.00, 120000.00, ''),
(1136, 103, 'Brosses num 2', '', 10.00, 3000.00, 30000.00, ''),
(1137, 103, 'Grands Rouleaux', '', 10.00, 6000.00, 60000.00, ''),
(1138, 103, 'Baguettes', '', 5.00, 28000.00, 140000.00, ''),
(1139, 103, 'Papier Meuleux 80', '', 1.00, 65000.00, 65000.00, ''),
(1140, 103, 'Tubes 20x20', '', 30.00, 18000.00, 540000.00, ''),
(1141, 103, 'Pomelles de 10', '', 10.00, 5000.00, 50000.00, ''),
(1142, 110, 'Ubuyi', '', 3.00, 10000.00, 30000.00, ''),
(1143, 110, 'Isukari', '', 4.00, 6500.00, 26000.00, ''),
(1144, 110, 'Tangawizi', '', 1.00, 8000.00, 8000.00, ''),
(1145, 110, 'Ama ayicayi', '', 1.00, 2000.00, 2000.00, ''),
(1146, 110, 'Indimu', '', 1.00, 2000.00, 2000.00, ''),
(1147, 110, 'Amakara', '', 1.00, 80000.00, 80000.00, ''),
(1154, 100, 'Ciment', 'Lissage', 100.00, 57000.00, 5700000.00, ''),
(1155, 100, 'Chargement et déchargement', 'Ff', 100.00, 600.00, 60000.00, ''),
(1192, 113, 'Ingurane', '', 4.00, 25000.00, 100000.00, ''),
(1196, 97, 'Huile moteur', 'Wish J2818A', 4.00, 30000.00, 120000.00, ''),
(1201, 99, 'Huile moteur', 'Hilux C1566A', 10.00, 30000.00, 300000.00, ''),
(1202, 99, 'Réparation Charbon', 'Hilux C1566A', 4.00, 25000.00, 100000.00, ''),
(1203, 99, 'Main-d\'œuvre', 'Hilux C1566A', 1.00, 50000.00, 50000.00, ''),
(1204, 99, 'Demarrerut', 'Hilux C1566A', 1.00, 50000.00, 50000.00, ''),
(1206, 90, 'Frais de ration des chauffeurs', 'Restauration', 8.00, 37500.00, 300000.00, ''),
(1207, 101, 'Réparation', 'Réparation de Howo\r\nContrepoids et siavant', 1.00, 300000.00, 300000.00, ''),
(1208, 101, 'Achat pour', 'Varve pour Benz E1070A', 1.00, 200000.00, 200000.00, ''),
(1215, 116, 'Chargement et déchargement des pacerelles', '', 100.00, 400.00, 40000.00, ''),
(1216, 116, 'Déchargement des tubes', '', 1.00, 15000.00, 15000.00, ''),
(1247, 119, 'Charge de Battery', '', 2.00, 10000.00, 20000.00, ''),
(1256, 122, 'Tubes 60x40 de 1;5mm', '', 250.00, 135000.00, 33750000.00, ''),
(1257, 122, 'Planche de live', '', 7.00, 80000.00, 560000.00, ''),
(1258, 122, 'Disque à coupé', '', 25.00, 13000.00, 325000.00, ''),
(1259, 122, 'Baguette boites', '', 3.00, 27000.00, 81000.00, ''),
(1260, 122, 'Antiroulle', '', 7.00, 50000.00, 350000.00, ''),
(1261, 122, 'Petroles', '', 7.00, 20000.00, 140000.00, ''),
(1262, 122, 'Tôle métallique', '', 20.00, 140000.00, 2800000.00, ''),
(1263, 122, 'Mastic de fer', '', 2.00, 145000.00, 290000.00, ''),
(1264, 122, 'Descente 10/100', '', 6.00, 5000.00, 30000.00, ''),
(1265, 122, 'Priage des tôles', '', 20.00, 6000.00, 120000.00, ''),
(1266, 122, 'Rouleau pointu', '', 7.00, 3000.00, 21000.00, ''),
(1268, 124, 'MOD restant vendredi sur les tâches de lissage des classes', '', 2.00, 500000.00, 1000000.00, ''),
(1309, 126, 'Ciment', '', 15.00, 57000.00, 855000.00, ''),
(1310, 126, 'Chargement déchargement', '', 15.00, 600.00, 9000.00, ''),
(1326, 128, 'Brique cuite', '', 20000.00, 200.00, 4000000.00, ''),
(1328, 125, 'Ciment', '', 15.00, 57000.00, 855000.00, ''),
(1329, 125, 'Chargement déchargement', '', 15.00, 600.00, 9000.00, ''),
(1331, 129, 'Brique cuite', '', 20000.00, 200.00, 4000000.00, ''),
(1418, 104, 'Attestation de non litige', '', 1.00, 20000.00, 20000.00, ''),
(1419, 104, 'Attestation de non faillite', '', 1.00, 120000.00, 120000.00, ''),
(1420, 106, 'Carburant', 'Essence', 2.00, 270000.00, 540000.00, ''),
(1423, 63, 'FRAIS DE DEPLACEMENT VERS ADB VERS OBR VIRAGO', 'DIRECTEUR D ADMINISTRATION ET FINANCIERE', 1.00, 10000.00, 10000.00, ''),
(1439, 139, 'Briques cuite', '', 150.00, 200.00, 30000.00, ''),
(1440, 139, 'MOD Maçons', '', 2.00, 30000.00, 60000.00, ''),
(1441, 139, 'MOD aide maçon', '', 1.00, 15000.00, 15000.00, ''),
(1442, 139, 'Déplacement', '', 1.00, 30000.00, 30000.00, ''),
(1443, 139, 'Logement', '', 1.00, 30000.00, 30000.00, ''),
(1444, 120, 'Peinture à eau boîtes', '', 3.00, 108500.00, 325500.00, ''),
(1445, 120, 'Peinture à eau blanc', '', 1.00, 87000.00, 87000.00, ''),
(1446, 120, 'Savons bidons', '', 1.00, 50000.00, 50000.00, ''),
(1447, 120, 'Savons de nettoyage des vitres', '', 2.00, 28000.00, 56000.00, ''),
(1448, 120, 'Lacrette', '', 2.00, 7000.00, 14000.00, ''),
(1449, 120, 'Ibitambara vyogukoropa', '', 1.00, 20000.00, 20000.00, ''),
(1450, 120, 'Esui main', '', 1.00, 20000.00, 20000.00, ''),
(1451, 120, 'Acide', '', 5.00, 17000.00, 85000.00, ''),
(1452, 120, 'Inzembe', '', 1.00, 5000.00, 5000.00, ''),
(1453, 120, 'Wall master et tarch', '', 1.00, 155000.00, 155000.00, ''),
(1454, 120, 'Carreaux', '', 3.00, 95000.00, 285000.00, ''),
(1456, 138, 'Dette remboursable pendant 4 semaines', '', 1.00, 100000.00, 100000.00, ''),
(1459, 142, 'Déplacement de 4machines', '', 4.00, 15000.00, 60000.00, ''),
(1460, 142, 'Chargement et déchargement des pacerelles', '', 250.00, 400.00, 100000.00, ''),
(1461, 135, 'Ibitumbura', '', 35.00, 1000.00, 35000.00, ''),
(1462, 135, 'Icapati', '', 35.00, 1500.00, 52500.00, ''),
(1463, 135, 'Samboussa', '', 12.00, 1000.00, 12000.00, ''),
(1464, 135, 'Imikate', '', 1.00, 30000.00, 30000.00, ''),
(1465, 135, 'Ivoka', '', 5.00, 2000.00, 10000.00, ''),
(1466, 135, 'Ibitumbura', '', 35.00, 1000.00, 35000.00, ''),
(1467, 135, 'Icapati', '', 35.00, 1500.00, 52500.00, ''),
(1468, 69, 'serviettes en tissus', '', 2.00, 5000.00, 10000.00, ''),
(1469, 69, 'bassin en plastique', '', 1.00, 20000.00, 20000.00, ''),
(1470, 133, 'Blanc cassé', 'Peinture', 1.00, 468500.00, 468500.00, ''),
(1471, 133, 'Plaster', 'Peinture', 1.00, 160000.00, 160000.00, ''),
(1472, 133, 'Peinture Bleue', '', 2.00, 136000.00, 272000.00, ''),
(1473, 133, 'Grands Rouleaux', '', 4.00, 6000.00, 24000.00, ''),
(1474, 133, 'Petits Rouleaux', '', 4.00, 3000.00, 12000.00, ''),
(1475, 133, 'Brosses num 2', '', 6.00, 3000.00, 18000.00, ''),
(1476, 133, 'Brosses num1', '', 6.00, 2000.00, 12000.00, ''),
(1478, 77, 'AVANCE SUR SALAIRE  MAI  2026', '', 1.00, 100000.00, 100000.00, ''),
(1479, 127, 'Frais de déplacement  vers OBR', '', 1.00, 8000.00, 8000.00, ''),
(1480, 127, 'Frais de saisi des attestations de lnon litige et non faillite', '', 3.00, 2000.00, 6000.00, ''),
(1481, 127, 'Photopie de quitance', '', 2.00, 1000.00, 2000.00, ''),
(1482, 127, 'Frais de transation cash tel', 'Pour attestation de non litige et non failite', 1.00, 3000.00, 3000.00, ''),
(1487, 123, 'Abonnement Starlink(en Dollar)', 'Mois de Mai', 1.00, 100.00, 100.00, ''),
(1494, 144, 'Deplacement', 'Les Ecoles de Bukinanyana et BUBANZA', 2.00, 100000.00, 200000.00, ''),
(1495, 144, 'Deplacement', 'CIBITOKE/MUGINA et MPANDA', 2.00, 100000.00, 200000.00, ''),
(1496, 144, 'Main d\'oeuvre', '2personnes deux journées de', 4.00, 50000.00, 200000.00, ''),
(1503, 118, 'Ciments', '', 15.00, 57000.00, 855000.00, ''),
(1504, 118, 'Clous', '', 2.00, 180000.00, 360000.00, ''),
(1505, 118, 'Ficelles', '', 5.00, 12000.00, 60000.00, ''),
(1506, 118, 'Chargement et déchargement du ciment', '', 50.00, 600.00, 30000.00, ''),
(1509, 147, 'Ciments', '', 5.00, 57000.00, 285000.00, ''),
(1510, 147, 'Chargement et déchargement', '', 5.00, 600.00, 3000.00, ''),
(1513, 149, 'Ciments', '', 10.00, 57000.00, 570000.00, ''),
(1514, 149, 'Chargement et déchargement du ciment', '', 10.00, 600.00, 6000.00, ''),
(1515, 150, 'Ciments', '', 5.00, 57000.00, 285000.00, ''),
(1516, 150, 'Chargement et déchargement du ciment', '', 5.00, 600.00, 3000.00, ''),
(1518, 115, 'Restauration Hebdomadaire', 'Raflechissement', 1.00, 696000.00, 696000.00, ''),
(1524, 114, 'Restauration Hebdomadaire', 'Raflechissement', 1.00, 351000.00, 351000.00, ''),
(1531, 148, 'Ciment', '', 15.00, 57000.00, 855000.00, ''),
(1532, 148, 'Chargement déchargement', '', 15.00, 600.00, 9000.00, ''),
(1539, 154, 'Frais de déplacement pour visiter le cite des Granulats (Kaburantwa-Muhira)', '', 2.00, 50000.00, 100000.00, ''),
(1540, 58, 'Sable(Howo)', 'Epandage', 1.00, 300000.00, 300000.00, ''),
(1559, 157, 'Ciment', 'Lissage', 50.00, 57000.00, 2850000.00, ''),
(1560, 157, 'Chargement et déchargement', 'Ff', 50.00, 600.00, 30000.00, ''),
(1610, 158, 'Tubes 60x40 1;5mm', '', 63.00, 135000.00, 8505000.00, ''),
(1611, 158, 'Disque à coupé', '', 50.00, 13000.00, 650000.00, ''),
(1612, 158, 'Antiroulle', '', 6.00, 65000.00, 390000.00, ''),
(1613, 158, 'Petroles', '', 6.00, 20000.00, 120000.00, ''),
(1614, 158, 'Baguette', '', 8.00, 28000.00, 224000.00, ''),
(1615, 158, 'Petit rouleau', '', 10.00, 3000.00, 30000.00, ''),
(1616, 158, 'Brosse nº2', '', 10.00, 3000.00, 30000.00, ''),
(1617, 158, 'Chargement et déchargement des pacelelles y compris les tubes', '', 1.00, 51500.00, 51500.00, ''),
(1620, 161, 'Tubes 60x40 de 1, 5mm', '', 50.00, 135000.00, 6750000.00, ''),
(1621, 161, 'Chargement et déchargement', '', 50.00, 1000.00, 50000.00, ''),
(1622, 145, 'Carburat', 'Essence', 5.00, 270000.00, 1350000.00, ''),
(1623, 141, 'MAZOUT', '', 5.00, 290000.00, 1450000.00, ''),
(1625, 121, 'Location de Pelle chargeur', '1 jour 5heures', 1.00, 2437500.00, 2437500.00, ''),
(1626, 132, 'Réparation Châssis Véhicule', 'Réparation Châssis Véhicule Benne Fuso I4945A', 1.00, 250000.00, 250000.00, ''),
(1643, 168, 'Moellons de carrière', '', 5.00, 230000.00, 1150000.00, ''),
(1644, 168, 'Ficelle', '', 2.00, 12000.00, 24000.00, ''),
(1647, 146, 'Ciments pour KING\'S SCOOL', 'plus charg/décharg', 40.00, 57600.00, 2304000.00, ''),
(1648, 146, 'Ciments pour IBB ENTREPOT', 'plus charg/décharg', 15.00, 57600.00, 864000.00, ''),
(1649, 146, 'Ciments pour Jabe USDA', 'plus charg/décharg', 5.00, 57600.00, 288000.00, ''),
(1653, 117, 'Ciments Pour KABEZI Plus chargement et dechargement', '', 30.00, 57600.00, 1728000.00, ''),
(1654, 117, 'Ciments Pour GIHOSHA NDAYI Plus chargement et dechargement', '', 10.00, 57600.00, 576000.00, ''),
(1655, 117, 'Ciments Pour GIHOSHA ZONE APPARTEMENTPlus chargement et dechargement', '', 5.00, 57600.00, 288000.00, ''),
(1658, 170, 'Frais de sécurité par GICICO', 'Frais de sécurité', 2.00, 175000.00, 350000.00, ''),
(1659, 169, 'Frais de sécurité par GICICO', 'Frais de sécurité', 2.00, 85000.00, 170000.00, ''),
(1660, 171, 'Briques cuites', '', 18000.00, 220.00, 3960000.00, ''),
(1661, 167, 'Frais de sécurité par GICICO', 'Frais de sécurité', 2.00, 175000.00, 350000.00, ''),
(1663, 166, 'Frais de sécurité par GICICO', 'Frais de sécurité', 5.00, 150000.00, 750000.00, ''),
(1672, 164, 'Lavage du véhicule E2464A', 'NETTOYAGE', 2.00, 10000.00, 20000.00, ''),
(1679, 105, 'MOD OCCOASIONNEL                          à                                                                                    BUJUMBURA Objet : Transmission de la facture      n°N860W672737/FN22/2026  Madame la Directrice Nationale, J’ai l’honneur de vous transmettre en annexe à la présente, la facture n° N860W672737/FN22/2026 d’un montant de septante millions  (70 000 000 BIF) représentant la deuxième tranche de paiement mensuel figurant sur le contrat d’exécution de travaux supplémentaires non prévus dans le devis initial du contrat principal, mais devenus nécessaires a la bonne réalisation et à la fonctionnalité du projet de construction de l’extension de l’Ecole KINGS SCHOOL, sise Avenue du Large à Bujumbura. Comme convenu le paiement sera effectué par virement bancaire sur le compte n° 6011732/001-000-108 ouvert à la BBCI au nom de SATRACO Construction. Je vous prie d’agréer, Madame la Directrice Nationale, l’assurance de ma considération distinguée.                                                                                                                                                                                                                                           Pour SATRACO CONSTRUCTION                                                                                                                M. Arch. Aldo Georges NDAGIJE                                                                              MAIN D OEUVRE DE MOIS D AVRIL', 'DU CHEF CHANTIER KINGS', 1.00, 1000000.00, 1000000.00, ''),
(1689, 179, 'Noix de cajou', '', 1.00, 20000.00, 20000.00, ''),
(1690, 179, 'Samboussa', '', 5.00, 1500.00, 7500.00, ''),
(1691, 179, 'Emballage', '', 1.00, 500.00, 500.00, ''),
(1692, 178, 'Pomelos de 8', '', 1.00, 4000.00, 4000.00, ''),
(1693, 178, 'Poignet', '', 1.00, 8000.00, 8000.00, ''),
(1694, 178, 'Doulle', '', 1.00, 5000.00, 5000.00, ''),
(1711, 153, 'Gravier', '', 1.00, 180000.00, 180000.00, ''),
(1720, 152, 'Etrier 15*25', '', 100.00, 1500.00, 150000.00, ''),
(1721, 152, 'Fer a béton de 8', '', 10.00, 38000.00, 380000.00, ''),
(1722, 152, 'Fer a béton de 10', '', 5.00, 58000.00, 290000.00, ''),
(1723, 152, 'Chargement déchargement', '', 1.00, 10000.00, 10000.00, ''),
(1758, 176, 'courroie', 'courroie de l’alternateur pour Howo D8152A', 1.00, 100000.00, 100000.00, ''),
(1759, 176, 'Tendeur', 'Tendeur pour Howo Howo D8152A', 1.00, 50000.00, 50000.00, ''),
(1761, 177, 'Rétroviseur', 'le rétroviseur côté passager pour Rava L4521A', 1.00, 450000.00, 450000.00, ''),
(1762, 180, 'Reparation Electrique', 'Howo\r\nE8152A', 1.00, 300000.00, 300000.00, ''),
(1765, 162, 'Frais de ration des chauffeurs', 'Restauration des chauffeurs', 8.00, 87500.00, 700000.00, ''),
(1778, 183, 'MAZOUT', '', 5.00, 290000.00, 1450000.00, ''),
(1779, 182, 'Plaster', '', 3.00, 160000.00, 480000.00, ''),
(1780, 182, 'Petrol', '', 5.00, 22000.00, 110000.00, ''),
(1781, 182, 'Blanc cassé à eau', '', 3.00, 468600.00, 1405800.00, ''),
(1782, 182, 'Grands Rouleaux', '', 6.00, 6000.00, 36000.00, ''),
(1783, 182, 'Peinture à l\'huile bleu', '', 4.00, 207500.00, 830000.00, ''),
(1786, 102, 'Latérité', 'Remblais', 10.00, 100000.00, 1000000.00, ''),
(1787, 102, 'Vis à tôles', '', 1.00, 65000.00, 65000.00, ''),
(1790, 130, 'Jexe', 'Nettoyage des briques industriels', 80.00, 1500.00, 120000.00, ''),
(1791, 130, 'Papier Meuleux  num 120', 'Nettoyage des briques industriels', 1.00, 65000.00, 65000.00, ''),
(1792, 130, 'Acide pour les carreaux', 'Nettoyage', 10.00, 10000.00, 100000.00, ''),
(1794, 184, 'Moellons de carrière', '', 5.00, 230000.00, 1150000.00, ''),
(1795, 184, 'Ciments', '', 10.00, 57000.00, 570000.00, ''),
(1796, 184, 'Chargement et déchargement du ciment', '', 10.00, 600.00, 6000.00, ''),
(1801, 185, 'Gravier tamise', '', 1.00, 300000.00, 300000.00, ''),
(1802, 185, 'Sable', '', 1.00, 70000.00, 70000.00, ''),
(1803, 181, 'Tubes 60x40 de 1, 5mm', '', 35.00, 135000.00, 4725000.00, ''),
(1804, 181, 'Clous de 10 et de 12', '', 2.00, 180000.00, 360000.00, ''),
(1805, 181, 'Chiffon', '', 20.00, 4000.00, 80000.00, ''),
(1806, 181, 'Ciments', '', 10.00, 57000.00, 570000.00, ''),
(1807, 181, 'Chargement et déchargement du ciment', '', 10.00, 600.00, 6000.00, ''),
(1808, 181, 'Chargement des tubes', '', 35.00, 200.00, 7000.00, ''),
(1809, 181, 'Ficelle', '', 5.00, 12000.00, 60000.00, ''),
(1814, 174, 'Pavé  m²', '', 10.00, 45000.00, 450000.00, ''),
(1815, 174, 'Ciments', '', 2.00, 57600.00, 115200.00, ''),
(1816, 175, 'Sables', '', 1.00, 65000.00, 65000.00, ''),
(1817, 189, 'Lavabo ovale', '', 1.00, 380000.00, 380000.00, ''),
(1818, 189, 'Shattaf noire', '', 2.00, 150000.00, 300000.00, ''),
(1819, 189, 'Tuyau flexible spain', '', 1.00, 15000.00, 15000.00, ''),
(1820, 189, 'Robinet de lavabo noire', '', 1.00, 80000.00, 80000.00, ''),
(1821, 188, 'Main-d\'œuvre', 'Électrique pour Benz E1070A', 1.00, 100000.00, 100000.00, ''),
(1827, 134, 'Filter à gasoil de 26/28', 'Filter à gasoil pour Benz E1070A', 2.00, 50000.00, 100000.00, ''),
(1828, 134, 'Filter pompe', 'Filter pompe pour Benz E1070A', 1.00, 100000.00, 100000.00, ''),
(1829, 134, 'Jante occ', 'Jante occ pour Benz', 1.00, 400000.00, 400000.00, ''),
(1830, 134, 'Goujons', 'Goujons pour Benz E1070A', 9.00, 30000.00, 270000.00, ''),
(1831, 134, 'Tuyau d\'air', 'Tuyau d\'air pour Benz E1070A', 4.00, 15000.00, 60000.00, ''),
(1838, 155, 'Huile moteur', 'Huile moteur pour Hilux E4924A', 5.50, 35000.00, 192500.00, ''),
(1839, 155, 'Boullon', 'Boullon de Vidange pour Hilux E4924A', 1.00, 10000.00, 10000.00, ''),
(1840, 137, 'Main-d\'œuvre', 'Main-d\'œuvre pour Réparations  Mercedes-Benz E1070A', 1.00, 220000.00, 220000.00, ''),
(1841, 136, 'Lavage Véhicule', 'Lavage Véhicule pour Benne E4945A', 1.00, 20000.00, 20000.00, ''),
(1842, 136, 'changer les pneus', 'changer les pneus pour Benne E4945A', 2.00, 1200000.00, 2400000.00, ''),
(1845, 192, 'Carburat', 'MAZOUT', 5.00, 259999.99, 1299999.95, ''),
(1846, 191, 'Carburat', 'ESSENCE', 5.00, 280000.00, 1400000.00, ''),
(1848, 194, 'Carburat', 'Mazout', 5.00, 300000.00, 1500000.00, ''),
(1853, 195, 'Lavage du véhicule E2464A', 'Lavage', 2.00, 10000.00, 20000.00, ''),
(1854, 195, 'Lavage du véhicule L5495A', 'Lavage', 1.00, 10000.00, 10000.00, ''),
(1857, 193, 'Isabune', '', 1.00, 35000.00, 35000.00, ''),
(1870, 196, 'Ciments pour King\'s school', '', 60.00, 57600.00, 3456000.00, ''),
(1871, 196, 'Ciments pour IBB Entrepôt', '', 15.00, 57600.00, 864000.00, ''),
(1876, 165, 'plantes', '', 12.00, 2500.00, 30000.00, ''),
(1877, 165, 'ibirungo', '', 5.00, 2000.00, 10000.00, ''),
(1878, 165, 'Ille', '', 1.00, 2000.00, 2000.00, ''),
(1891, 198, 'Ciments pour kabezi', '', 5.00, 57600.00, 288000.00, ''),
(1892, 198, 'Ciments pour Gihosha Ndayi', '', 10.00, 57600.00, 576000.00, ''),
(1893, 198, 'Ciments pour Gihosha appartement', '', 10.00, 57600.00, 576000.00, ''),
(1894, 198, 'Ciments pour FONCTIONNEMENT BUREAU', '', 10.00, 57600.00, 576000.00, ''),
(1895, 197, 'Prestation de service', 'Offre WHH/lOgement deplacement', 1.00, 74000.00, 74000.00, ''),
(1902, 199, 'Acide', '', 3.00, 17000.00, 51000.00, ''),
(1903, 199, 'Peinture a eau', 'Soft white', 1.00, 108000.00, 108000.00, ''),
(1904, 199, 'Brosse numer2', '', 3.00, 3000.00, 9000.00, ''),
(1915, 78, 'Fer a béton de 8', '', 20.00, 38000.00, 760000.00, ''),
(1916, 78, 'Fer a béton de 6', '', 20.00, 23000.00, 460000.00, ''),
(1917, 78, 'Fer a béton de 10', '', 30.00, 58000.00, 1740000.00, ''),
(1918, 78, 'Chargement déchargement', '', 1.00, 37500.00, 37500.00, ''),
(1919, 202, 'ration du chauffeur', '', 2.00, 200000.00, 400000.00, ''),
(1920, 190, 'Disjonction Tetra polaire 63', '', 1.00, 250000.00, 250000.00, ''),
(1921, 190, 'Interpteur', '', 1.00, 150000.00, 150000.00, ''),
(1926, 201, 'PF sur importation', 'PF', 1.00, 50000.00, 50000.00, ''),
(1927, 201, 'Frais de transaction', 'Transaction de dédouanement et de PF', 1.00, 20000.00, 20000.00, ''),
(1935, 55, 'CHAUSSURE DE TERRAIN', 'PCE', 1.00, 200000.00, 200000.00, ''),
(1940, 187, 'Ciments', '', 10.00, 57000.00, 570000.00, ''),
(1941, 187, 'Chargement et déchargement du ciment', '', 10.00, 600.00, 6000.00, ''),
(1942, 203, 'Eagle mineral water', 'paquet', 10.00, 8500.00, 85000.00, ''),
(1943, 203, 'Eagle mineral water', 'bidon', 8.00, 5000.00, 40000.00, ''),
(1950, 204, 'Controre Technique', 'Mercedes-Benz \r\nE1070A \r\nToyota Hilux E4924A\r\nMitsubishi Fuso\r\nI4945A \r\nRAVA L4521A \r\nWISH J2818A', 5.00, 139320.00, 696600.00, ''),
(1951, 173, 'Frais de traduction', 'Invoice for transalation service  provided to SATRACO', 6.00, 35500.00, 213000.00, ''),
(1952, 159, 'Frais de déplacement et heures supplémentaires', '', 1.00, 150000.00, 150000.00, ''),
(1953, 160, 'Déplacement et heures supplémentaires', '', 1.00, 150000.00, 150000.00, ''),
(1954, 205, 'MADRIE', '', 12.00, 30000.00, 360000.00, ''),
(1955, 205, 'MACHINAGE', '', 12.00, 5000.00, 60000.00, ''),
(1956, 205, 'SEADING SILLA', '', 2.00, 30000.00, 60000.00, ''),
(1957, 205, 'THINNER', '', 2.00, 30000.00, 60000.00, ''),
(1958, 205, 'VERNIE', '', 2.00, 20000.00, 40000.00, ''),
(1959, 205, 'PONCAGE', '', 1.00, 100000.00, 100000.00, ''),
(1960, 205, 'VIS; MAIN D OEUVRE', '', 1.00, 180000.00, 180000.00, ''),
(1969, 209, 'Carburat', 'ESSENCE', 5.00, 320000.00, 1600000.00, ''),
(1970, 208, 'Frais de ration des chauffeurs', 'Ration des chauffeus', 8.00, 37500.00, 300000.00, ''),
(1971, 206, 'Réparation Pneu', 'Réparation Pneu pour Howo D8152A', 1.00, 50000.00, 50000.00, ''),
(1977, 210, 'Amakara', '', 1.00, 80000.00, 80000.00, ''),
(1978, 210, 'Isukari', '', 5.00, 6500.00, 32500.00, ''),
(1979, 210, 'Ubuyi', '', 3.00, 10000.00, 30000.00, ''),
(1980, 210, 'Tangawizi', '', 1.00, 8000.00, 8000.00, ''),
(1981, 210, 'Indimu', '', 1.00, 2000.00, 2000.00, ''),
(1982, 27, 'Beignet', '', 35.00, 1000.00, 35000.00, ''),
(1984, 212, 'Gedeon', '', 1.00, 100000.00, 100000.00, ''),
(1985, 212, 'Alexis', '', 1.00, 100000.00, 100000.00, ''),
(1986, 212, 'HABONIMANA Claude', '', 1.00, 220000.00, 220000.00, ''),
(1987, 212, 'Iranezereje jean Bosco', '', 1.00, 45000.00, 45000.00, ''),
(1988, 212, 'Nduwayezu Eric', '', 1.00, 45000.00, 45000.00, ''),
(1989, 207, 'Carburat', 'Mazout', 5.00, 300000.00, 1500000.00, ''),
(1993, 214, 'RESTAURATION HEBDOMADAIRE', '', 1.00, 455000.00, 455000.00, ''),
(1994, 200, 'Gaz de climatiseur', 'Bureau 1 \r\n1kg', 1.00, 150000.00, 150000.00, ''),
(1995, 200, 'Entretient', 'Bureau 1', 1.00, 100000.00, 100000.00, ''),
(1996, 200, 'Reparation de carte electronique', 'Bureau 2', 1.00, 200000.00, 200000.00, ''),
(1997, 200, 'Gaz de climatiseur', 'Bureau 2\r\n1.5kg', 1.00, 150000.00, 150000.00, ''),
(1998, 200, 'Entretient', 'Bureau 2', 1.00, 100000.00, 100000.00, ''),
(1999, 200, 'Entretient du climatiseur', 'Salle de reunion & Salle de s ingenieurs', 2.00, 60000.00, 120000.00, ''),
(2000, 200, 'Telcommande Universel', '', 1.00, 100000.00, 100000.00, ''),
(2001, 211, 'Reliure', '', 1.00, 5000.00, 5000.00, ''),
(2002, 213, 'A1', 'Impression document', 28.00, 15000.00, 420000.00, ''),
(2003, 213, 'A0', 'Impression document', 16.00, 30000.00, 480000.00, ''),
(2004, 52, 'Disque a béton grand', '', 2.00, 50000.00, 100000.00, ''),
(2005, 52, 'Utubuye twirabura', '', 4.00, 20000.00, 80000.00, ''),
(2006, 52, 'Chargement de deux fab', '', 2.00, 300.00, 600.00, ''),
(2007, 82, 'Mastique de fer', '', 3.00, 140000.00, 420000.00, ''),
(2008, 82, 'Baguettes', '', 2.00, 28000.00, 56000.00, ''),
(2009, 82, 'Anti Roulle', '', 1.00, 65000.00, 65000.00, ''),
(2010, 82, 'Disque a couper', '', 5.00, 13000.00, 65000.00, ''),
(2011, 82, 'Profile Bouteille', '', 3.00, 15000.00, 45000.00, ''),
(2012, 82, 'Rovase', '', 3.00, 11000.00, 33000.00, ''),
(2013, 82, 'Poigne', '', 3.00, 5000.00, 15000.00, ''),
(2014, 82, 'Petit Roulette', '', 4.00, 5000.00, 20000.00, ''),
(2015, 82, 'petrol', '', 1.00, 20000.00, 20000.00, ''),
(2016, 82, 'Papier meuleu', '', 5.00, 4000.00, 20000.00, ''),
(2018, 216, 'Peinture à eau blanc', '', 1.00, 510000.00, 510000.00, ''),
(2019, 216, 'Peinture une boîte', '', 1.00, 82000.00, 82000.00, ''),
(2020, 216, 'Petroles', '', 2.00, 22000.00, 44000.00, ''),
(2021, 216, 'Petit rouleau', '', 2.00, 3000.00, 6000.00, ''),
(2022, 216, 'Brosse nº2', '', 2.00, 3000.00, 6000.00, ''),
(2023, 216, 'Scotch', '', 4.00, 7000.00, 28000.00, ''),
(2024, 217, 'Ciments', '', 20.00, 57000.00, 1140000.00, ''),
(2025, 217, 'Ibipawa n\'imihini', '', 2.00, 25000.00, 50000.00, ''),
(2026, 217, 'Imyiko', '', 3.00, 5000.00, 15000.00, ''),
(2027, 217, 'Guants', '', 4.00, 10000.00, 40000.00, ''),
(2029, 219, 'Cornières (40x40) 5mm', '', 3.00, 250000.00, 750000.00, ''),
(2030, 219, 'Cornières (30×30)', '', 8.00, 45000.00, 360000.00, ''),
(2031, 219, 'Profil c', '', 32.00, 90000.00, 2880000.00, ''),
(2032, 219, 'Roulette', '', 4.00, 30000.00, 120000.00, ''),
(2033, 219, 'Petits Roulettes', '', 8.00, 10000.00, 80000.00, ''),
(2034, 219, 'Pomelle (10)', '', 2.00, 5000.00, 10000.00, ''),
(2035, 219, 'Mastic de fer', '', 6.00, 140000.00, 840000.00, ''),
(2336, 221, 'Feel Pump', 'Feel Pump pour Benz E1070A', 1.00, 25000.00, 25000.00, ''),
(2337, 221, 'Lavage', 'Lavage Véhicule pour Benz E1070A', 1.00, 20000.00, 20000.00, ''),
(2353, 226, 'Ciment', '', 100.00, 57000.00, 5700000.00, ''),
(2354, 226, 'Chargement et déchargement', '', 100.00, 600.00, 60000.00, ''),
(2360, 220, 'Cornières (40x40) 5mm', '', 3.00, 250000.00, 750000.00, ''),
(2361, 220, 'Cornières (30×30)', '', 8.00, 45000.00, 360000.00, ''),
(2362, 220, 'Profil c', '', 32.00, 90000.00, 2880000.00, ''),
(2363, 220, 'Roulette', '', 4.00, 30000.00, 120000.00, ''),
(2364, 220, 'Petits Roulettes', '', 8.00, 10000.00, 80000.00, ''),
(2365, 220, 'Pomelle (10)', '', 2.00, 5000.00, 10000.00, ''),
(2366, 220, 'Mastic de fer', '', 6.00, 140000.00, 840000.00, ''),
(2367, 220, 'Antirouille', '', 6.00, 65000.00, 390000.00, ''),
(2368, 220, 'Petrol', '', 6.00, 20000.00, 120000.00, ''),
(2369, 220, 'Petits Rouleaux', '', 10.00, 3000.00, 30000.00, ''),
(2370, 220, 'Brosses num2', '', 10.00, 3000.00, 30000.00, ''),
(2371, 220, 'Disques à couper', '', 25.00, 13000.00, 325000.00, ''),
(2372, 220, 'Baguettes', '', 16.00, 27000.00, 432000.00, ''),
(2373, 220, 'Papier Meuleux (80)', '', 1.00, 65000.00, 65000.00, ''),
(2374, 220, 'Chargement et déchargement', '', 1.00, 50000.00, 50000.00, ''),
(2380, 227, 'Baguette', '', 1.00, 28000.00, 28000.00, ''),
(2381, 227, 'Disque a couper', '', 1.00, 13000.00, 13000.00, ''),
(2382, 227, 'Pomelos hydraulique', '', 1.00, 30000.00, 30000.00, ''),
(2383, 229, 'Sable(benne)', '', 8.00, 65000.00, 520000.00, ''),
(2384, 229, 'Gravier fin (ubuyoriyori)', '', 2.00, 80000.00, 160000.00, ''),
(2385, 230, 'Planches', '', 80.00, 13000.00, 1040000.00, ''),
(2386, 230, 'Clous num 6', '', 1.00, 180000.00, 180000.00, ''),
(2387, 230, 'Clous num 5', '', 1.00, 180000.00, 180000.00, ''),
(2388, 230, 'Scalité', '', 50.00, 7000.00, 350000.00, ''),
(2389, 231, 'Tuyaux PPR', '', 3.00, 25000.00, 75000.00, ''),
(2390, 231, 'Balais modernes', '', 5.00, 10000.00, 50000.00, ''),
(2391, 231, 'Torchons', '', 8.00, 10000.00, 80000.00, ''),
(2392, 231, 'Pigment rouge', '', 2.00, 350000.00, 700000.00, ''),
(2393, 231, 'Pigment vert', '', 2.00, 350000.00, 700000.00, ''),
(2394, 231, 'Clous de 10cm', '', 1.00, 180000.00, 180000.00, ''),
(2396, 233, 'Cloux de 10', '', 10.00, 10000.00, 100000.00, ''),
(2397, 233, 'Pelle', '', 2.00, 23000.00, 46000.00, ''),
(2398, 233, 'Fil maçon', '', 1.00, 12000.00, 12000.00, ''),
(2399, 233, 'Machette', '', 1.00, 12000.00, 12000.00, ''),
(2400, 233, 'Bidon', '', 2.00, 15000.00, 30000.00, ''),
(2401, 233, 'Sceau', '', 3.00, 13000.00, 39000.00, ''),
(2402, 233, 'Shiting', '', 1.00, 45000.00, 45000.00, ''),
(2403, 234, 'Matelas 90', '', 1.00, 150000.00, 150000.00, ''),
(2404, 234, 'Moustiquaire', '', 1.00, 20000.00, 20000.00, ''),
(2405, 235, 'Perche', '', 20.00, 3000.00, 60000.00, ''),
(2406, 235, 'Chargement déchargement', '', 20.00, 200.00, 4000.00, ''),
(2407, 236, 'Matelas 90', '', 1.00, 150000.00, 150000.00, ''),
(2408, 236, 'Moustiquaire', '', 1.00, 30000.00, 30000.00, ''),
(2420, 238, 'Ciment', '', 10.00, 57000.00, 570000.00, ''),
(2421, 238, 'Chargement déchargement', '', 10.00, 600.00, 6000.00, ''),
(2422, 241, 'Blanc cassé extérieur', '', 3.00, 468500.00, 1405500.00, ''),
(2424, 243, 'Boîte de vis', '', 3.00, 20000.00, 60000.00, ''),
(2426, 244, 'Courant électrique', '', 1.00, 70000.00, 70000.00, ''),
(2427, 242, 'Doulle', '', 1.00, 8000.00, 8000.00, ''),
(2428, 242, 'Pomele', '', 1.00, 4000.00, 4000.00, ''),
(2429, 242, 'Rock', '', 1.00, 6000.00, 6000.00, ''),
(2430, 151, 'Sable', '', 1.00, 70000.00, 70000.00, ''),
(2439, 232, 'Amase', '', 1.00, 75000.00, 75000.00, ''),
(2440, 245, 'Adapteur', '', 1.00, 45000.00, 45000.00, ''),
(2441, 245, 'Connecteur Reseau', 'RJ45', 50.00, 1000.00, 50000.00, ''),
(2442, 245, 'Jacket', 'Prise reseau', 15.00, 5000.00, 75000.00, ''),
(2443, 245, 'Cable Reseau', '', 1.00, 400000.00, 400000.00, ''),
(2445, 240, 'Brique cuite', '', 5000.00, 200.00, 1000000.00, ''),
(2466, 254, 'Impression des plans sur A1', '', 28.00, 15000.00, 420000.00, ''),
(2467, 254, 'Impression des plans sur A0', '', 16.00, 30000.00, 480000.00, ''),
(2475, 255, 'Chargement et déchargement des briques (bennes )', '', 3.00, 60000.00, 180000.00, ''),
(2476, 253, 'Ciments', '', 10.00, 57600.00, 576000.00, ''),
(2477, 253, 'Brosse métallique', '', 10.00, 7000.00, 70000.00, ''),
(2478, 252, 'Ciments', '', 13.00, 57600.00, 748800.00, ''),
(2484, 256, 'Essence', 'pour RAV 4 L4521A', 30.00, 4000.00, 120000.00, ''),
(2485, 225, 'Frais de ration', 'des chauffeurs', 4.00, 100000.00, 400000.00, ''),
(2495, 258, 'Ciment', '', 10.00, 57000.00, 570000.00, ''),
(2496, 258, 'Chargement dechargement', '', 10.00, 600.00, 6000.00, ''),
(2497, 140, 'granirrant', 'gravier congassin', 3.50, 300000.00, 1050000.00, ''),
(2499, 222, 'location', 'paile', 1.00, 2250000.00, 2250000.00, ''),
(2503, 218, 'Carburat', 'mazout', 5.83, 300000.00, 1749000.00, ''),
(2517, 224, 'ESSENCE', 'PROBOX L5495A', 2.00, 250000.00, 500000.00, ''),
(2518, 224, 'ESSENCE', 'Hilux E 4923A', 2.00, 250000.00, 500000.00, ''),
(2520, 223, 'Carburant', 'MAZOUT', 5.00, 280000.00, 1400000.00, ''),
(2523, 248, 'Mise en Peinture', 'Mise en Peinture pour Rava L4521A', 2.00, 350000.00, 700000.00, ''),
(2524, 248, 'Deboseolage', 'Deboseolage du Vautre Toyota Rava L4521A', 1.00, 150000.00, 150000.00, ''),
(2525, 248, 'Vernis', 'Vernis pour Rava L4521A', 2.00, 130000.00, 260000.00, ''),
(2526, 248, 'Durcisseur', 'Durcisseur pour Rava L4521A', 1.50, 130000.00, 195000.00, ''),
(2527, 248, 'Main-d\'œuvre', 'Main-d\'œuvre pour Réparations L4521A', 1.00, 95000.00, 95000.00, ''),
(2528, 260, 'Beignets', 'Lundi', 35.00, 1000.00, 35000.00, ''),
(2529, 260, 'Capati', 'Mardi', 35.00, 1500.00, 52500.00, ''),
(2530, 260, 'Pains', 'Jeudi', 1.00, 30000.00, 30000.00, ''),
(2531, 260, 'Avocats', 'Jeudi', 5.00, 2000.00, 10000.00, ''),
(2532, 260, 'Samboussa', 'Vendredi', 12.00, 1000.00, 12000.00, ''),
(2533, 260, 'Savon liquide', 'Jeudi', 1.00, 35000.00, 35000.00, ''),
(2534, 260, 'Capati', 'Vendredi', 35.00, 1500.00, 52500.00, ''),
(2535, 257, 'Lavage', 'Vehicule E2464A', 3.00, 10000.00, 30000.00, ''),
(2536, 257, 'Paiement compresseur', 'Pour le Pneu E2464A', 1.00, 20000.00, 20000.00, ''),
(2538, 261, 'Restautation en 5 JRS', 'Du 18 au 23/5/2026', 5.00, 12000.00, 60000.00, ''),
(2539, 249, 'Lavage Véhicule', 'Lavage pour Benne Fuso E4945A', 1.00, 20000.00, 20000.00, ''),
(2541, 250, 'Réparation Pneu', 'Réparation Pneu pour Benne Fuso E4945A', 1.00, 30000.00, 30000.00, ''),
(2544, 246, 'Fuor Pompe', 'Fuor Pompe pour Benz E1070A', 1.00, 250000.00, 250000.00, ''),
(2545, 239, 'Réparation Pneu', 'Réparation Pneu pour RAVA L4521A', 1.00, 15000.00, 15000.00, ''),
(2546, 172, 'FRAIS DE DEDOUANEMENT', '', 1.00, 20038606.00, 20038606.00, 'CRITIQUE'),
(2561, 269, 'Coude 63', '', 3.00, 7000.00, 21000.00, ''),
(2562, 269, 'Tuyaux 63', '', 2.00, 10000.00, 20000.00, ''),
(2563, 269, 'Bouchon 3/4', '', 20.00, 2500.00, 50000.00, ''),
(2564, 269, 'Col tangite 1/4', '', 1.00, 10000.00, 10000.00, ''),
(2565, 269, 'Silicone sosiso', '', 1.00, 30000.00, 30000.00, ''),
(2566, 269, 'Clous', '', 8.00, 2000.00, 16000.00, ''),
(2569, 270, 'Gravier tamise', '', 1.00, 300000.00, 300000.00, ''),
(2570, 270, 'Sable gros', '', 1.00, 65000.00, 65000.00, ''),
(2571, 271, 'Ciments', '', 10.00, 57600.00, 576000.00, ''),
(2577, 276, 'Peinture à eau blanc', '', 1.00, 510000.00, 510000.00, ''),
(2578, 276, 'Peinture à eau blanc  boîte', '', 1.00, 82000.00, 82000.00, ''),
(2579, 276, 'Petroles', '', 1.00, 22000.00, 22000.00, ''),
(2580, 276, 'Petit rouleau', '', 2.00, 3000.00, 6000.00, ''),
(2581, 276, 'Bross nº2', '', 2.00, 3000.00, 6000.00, ''),
(2582, 276, 'Scotch', '', 4.00, 7000.00, 28000.00, ''),
(2583, 272, 'MAZOUT', '', 4.00, 300000.00, 1200000.00, ''),
(2587, 277, 'ESSENCE', 'PROBOX L5495', 30.00, 4000.00, 120000.00, ''),
(2588, 277, 'ESSENCE', 'HIACE E2464A', 2.00, 250000.00, 500000.00, ''),
(2589, 277, 'ESSENCE', 'SUCCED L0501A', 1.00, 250000.00, 250000.00, ''),
(2591, 275, 'Huile mogas', 'Huile mogas pour Benne E4945A', 3.00, 33000.00, 99000.00, ''),
(2592, 274, 'Huile moteur', 'Huile moteur pour Hilux C1566A', 1.00, 60000.00, 60000.00, ''),
(2593, 265, 'hydraulique', 'hydraulique pour compacteur Chantiers King\'s school', 5.00, 20000.00, 100000.00, ''),
(2594, 265, 'Filter Air', 'Filter Air pour compacteur Chantier King\'s school', 1.00, 70000.00, 70000.00, ''),
(2595, 228, 'Déchargement  des briques industriels', 'Maçonnerie', 6000.00, 8.00, 48000.00, ''),
(2599, 186, 'Gravier', 'Echantillon d\'ependage', 1.00, 32000.00, 32000.00, ''),
(2600, 279, 'Ciment', '', 5.00, 57000.00, 285000.00, ''),
(2601, 279, 'Chargement dechargement', '', 5.00, 600.00, 3000.00, ''),
(2606, 283, 'Disque a beton', '', 2.00, 50000.00, 100000.00, ''),
(2618, 286, 'Impression de Bache', '', 1.00, 62000.00, 62000.00, ''),
(2622, 289, 'carnet', '', 9.00, 28000.00, 252000.00, ''),
(2623, 289, 'stylo', '', 6.00, 8000.00, 48000.00, ''),
(2624, 290, 'Habillement', 'Uniforme des Gardien', 1.00, 660000.00, 660000.00, ''),
(2626, 273, 'Ciments', '', 5.00, 60000.00, 300000.00, ''),
(2628, 291, 'Facture  Artisanat Moderne', 'pour la Main d\'oeuvre  (Pyt partiel)', 1.00, 560000.00, 560000.00, ''),
(2630, 278, 'Pavés m²', '', 8.00, 45000.00, 360000.00, ''),
(2632, 268, 'Frais de ration et routiers', 'Pour Les chauffeurs', 4.00, 75000.00, 300000.00, ''),
(2633, 292, 'Main d\'oeuvre pour Artisanat', 'Main d\'oeuvre', 1.00, 860000.00, 860000.00, ''),
(2634, 280, 'Carburat', 'Mazout', 3.00, 300000.00, 900000.00, ''),
(2635, 282, 'Carburat', 'essence', 3.00, 230000.00, 690000.00, ''),
(2637, 285, 'POMPE A VIDAGE', '', 1.00, 40000.00, 40000.00, ''),
(2639, 294, 'Eclous,,', '', 10.00, 1500.00, 15000.00, ''),
(2640, 294, 'ibipila', '', 2.00, 2000.00, 4000.00, ''),
(2641, 294, ',livée,', '', 10.00, 1000.00, 10000.00, ''),
(2642, 294, 'soudure', '', 1.00, 150000.00, 150000.00, ''),
(2643, 294, 'peinture,peinçage', '', 2.00, 200000.00, 400000.00, ''),
(2647, 295, 'Head light L4924A', '', 1.00, 350000.00, 350000.00, ''),
(2648, 293, 'Gradebou L4924A', '', 1.00, 500000.00, 500000.00, ''),
(2649, 296, 'Pneus L0501A, L5495L', '', 8.00, 250000.00, 2000000.00, ''),
(2650, 287, 'Démarreur', 'Démarreur pour Howo D8152A', 1.00, 1300000.00, 1300000.00, ''),
(2651, 287, 'Main-d\'œuvre', 'Main-d\'œuvre pour Howo D8152A', 1.00, 100000.00, 100000.00, ''),
(2653, 297, 'RESTAURATION HEBDOMADAIRE', '', 1.00, 357000.00, 357000.00, ''),
(2670, 298, 'Restauration  4 jours', '25-26-28-29/5/2026', 4.00, 12000.00, 48000.00, ''),
(2671, 299, 'SUCRE', '', 7.00, 6500.00, 45500.00, ''),
(2672, 299, 'TANGAWIZI', '', 1.00, 8000.00, 8000.00, ''),
(2673, 299, 'CAYICAYI', '', 1.00, 2000.00, 2000.00, ''),
(2674, 299, 'INDIMU', '', 1.00, 2000.00, 2000.00, ''),
(2675, 299, 'AMAKARA', '', 1.00, 80000.00, 80000.00, ''),
(2676, 299, 'UDUSHASHI', '', 2.00, 7000.00, 14000.00, ''),
(2677, 299, 'UBUYI', '', 3.00, 10000.00, 30000.00, ''),
(2679, 300, 'Ciment', '', 4.00, 57000.00, 228000.00, ''),
(2715, 308, 'Frais de ration et routiers', 'Pour Les chauffeurs', 8.00, 37500.00, 300000.00, ''),
(2716, 307, 'Terre végétale', '', 4.00, 75000.00, 300000.00, ''),
(2717, 306, 'Location pelle(1/2jr)', '', 1.00, 750000.00, 750000.00, ''),
(2719, 263, 'Sable', '', 1.00, 300000.00, 300000.00, ''),
(2777, 262, 'Ciment', '', 7.00, 57000.00, 399000.00, ''),
(2778, 262, 'Chargement & Déchargement', '', 7.00, 600.00, 4200.00, ''),
(2779, 264, 'Fer à Béton de 8', '', 15.00, 38000.00, 570000.00, ''),
(2780, 264, 'Etriers 15×15', '', 200.00, 1300.00, 260000.00, ''),
(2781, 264, 'Fil à ligaturés', '', 5.00, 15000.00, 75000.00, ''),
(2782, 264, 'Chargement et déchargement', '', 15.00, 450.00, 6750.00, ''),
(2783, 284, 'Brique cuite', '', 5000.00, 230.00, 1150000.00, ''),
(2786, 312, 'Bidon', '20litre', 12.00, 5000.00, 60000.00, ''),
(2787, 312, 'Paquet', '', 15.00, 8500.00, 127500.00, ''),
(2792, 302, 'Ciment', '', 5.00, 57000.00, 285000.00, ''),
(2793, 302, 'Gant', '', 4.00, 8000.00, 32000.00, ''),
(2794, 302, 'Sable', '', 1.00, 70000.00, 70000.00, ''),
(2795, 302, 'Gravier', '', 1.00, 300000.00, 300000.00, ''),
(2797, 313, 'FRAIS DE RESTAURATION', '', 4.00, 12000.00, 48000.00, ''),
(2832, 315, 'Blanc cassé (intérieur)', '', 1.00, 330600.00, 330600.00, ''),
(2833, 315, 'Peinture à l\'huile (Bleue)', '', 1.00, 150300.00, 150300.00, ''),
(2834, 315, 'Plaster', '', 1.00, 160000.00, 160000.00, ''),
(2838, 111, 'Tuyaux PPR 3/4 BUJUMBURA', '', 13.00, 35000.00, 455000.00, ''),
(2839, 111, 'Tuyaux PPR 1/2 BUJUMBURA', '', 21.00, 25000.00, 525000.00, ''),
(2840, 111, 'Coude galvanisé  1/2', '', 124.00, 2500.00, 310000.00, ''),
(2841, 111, 'Te galvanisé  1/2', '', 38.00, 3500.00, 133000.00, ''),
(2842, 111, 'Teflon', '', 150.00, 1000.00, 150000.00, ''),
(2843, 111, 'Filace', '', 4.00, 10000.00, 40000.00, ''),
(2844, 111, 'Bouchon 1/2', '', 61.00, 1500.00, 91500.00, '');
INSERT INTO `purchase_request_items` (`id`, `request_id`, `designation`, `technical_specs`, `quantity`, `unit_price`, `total_price`, `observations`) VALUES
(2845, 111, 'Reducteur 3/4/1/2', '', 18.00, 2500.00, 45000.00, ''),
(2846, 111, 'Te galvanisé 3/4', '', 18.00, 4000.00, 72000.00, ''),
(2847, 111, 'Coude galvanisé  3/4', '', 35.00, 3500.00, 122500.00, ''),
(2848, 111, 'Manchon Reducteur  3/4 /1/2', '', 12.00, 3000.00, 36000.00, ''),
(2849, 215, 'Courant electrique pour bureau', 'electriceté', 1.00, 500000.00, 500000.00, ''),
(2866, 112, 'Tuyaux PPR 3/4 BUJUMBURA', '', 13.00, 35000.00, 455000.00, ''),
(2867, 112, 'Tuyaux PPR 1/2 BUJUMBURA', '', 21.00, 25000.00, 525000.00, ''),
(2868, 112, 'Coude galvanisé  1/2', '', 124.00, 2500.00, 310000.00, ''),
(2869, 112, 'Te galvanisé  1/2', '', 38.00, 3500.00, 133000.00, ''),
(2870, 112, 'Teflon', '', 150.00, 1000.00, 150000.00, ''),
(2871, 112, 'Filace', '', 4.00, 10000.00, 40000.00, ''),
(2872, 112, 'Bouchon 1/2', '', 61.00, 1500.00, 91500.00, ''),
(2873, 112, 'Reducteur  3/4/1/2', '', 18.00, 2500.00, 45000.00, ''),
(2874, 112, 'Te galvanisé  3/4', '', 18.00, 4000.00, 72000.00, ''),
(2875, 112, 'Coude galvanisé  3/4', '', 35.00, 3500.00, 122500.00, ''),
(2876, 112, 'Manchon Reducteur 3/4/1/2', '', 12.00, 3000.00, 36000.00, ''),
(2877, 112, 'Manchon 3/4', '', 8.00, 3000.00, 24000.00, ''),
(2878, 112, 'Niple  1/2', '', 40.00, 2000.00, 80000.00, ''),
(2879, 112, 'Niple 3/4', '', 21.00, 2500.00, 52500.00, ''),
(2880, 112, 'Raccord-Union  3/4', '', 4.00, 4000.00, 16000.00, ''),
(2881, 112, 'Raccord-Union  1/2', '', 4.00, 3500.00, 14000.00, ''),
(2908, 310, 'Percles', '', 50.00, 5000.00, 250000.00, ''),
(2909, 310, 'Madriers', '', 30.00, 13000.00, 390000.00, ''),
(2910, 310, 'Chevrons', '', 285.00, 5000.00, 1425000.00, ''),
(2911, 310, 'Chargement et dechargement', '', 1.00, 73000.00, 73000.00, ''),
(2915, 316, 'CLOUX DE 10', '', 10.00, 10000.00, 100000.00, ''),
(2916, 316, 'FIL A MACON', '', 1.00, 12000.00, 12000.00, ''),
(2917, 316, 'MACHETTE', '', 1.00, 12000.00, 12000.00, ''),
(2918, 317, 'beignet', '', 80.00, 1000.00, 80000.00, ''),
(2919, 317, 'ICAPATI', '', 80.00, 1500.00, 120000.00, ''),
(2920, 317, 'ISAMBUSA', '', 12.00, 1000.00, 12000.00, ''),
(2921, 317, 'IMIKATE', '', 7.00, 5000.00, 35000.00, ''),
(2922, 317, 'Avocat', '', 11.00, 1000.00, 11000.00, ''),
(2923, 38, 'Body', '', 32.00, 55000.00, 1760000.00, ''),
(2924, 38, 'Mastique', '', 4.00, 60000.00, 240000.00, ''),
(2925, 38, 'Corniche', '', 25.00, 10000.00, 250000.00, ''),
(2926, 38, 'Corniere en  V', 'V', 10.00, 13000.00, 130000.00, ''),
(2927, 38, 'vis', 'Boite', 4.00, 25000.00, 100000.00, ''),
(2928, 38, 'papier meulue de 180', 'P180', 5.00, 5000.00, 25000.00, ''),
(2929, 38, 'Fil macon', 'rouleau', 2.00, 10000.00, 20000.00, ''),
(2930, 38, 'Fil a ligaturer', 'KG', 7.00, 10000.00, 70000.00, ''),
(2931, 38, 'Super Glue', '', 12.00, 2500.00, 30000.00, ''),
(2932, 38, 'Clous(6,8,10)', 'kg', 25.00, 10000.00, 250000.00, ''),
(2933, 38, 'Clous a béton de 8', 'boite numero8', 2.00, 25000.00, 50000.00, ''),
(2934, 38, 'Plafond PVC', '', 120.00, 28000.00, 3360000.00, ''),
(2935, 38, 'Corniere PVC', '', 39.00, 13000.00, 507000.00, ''),
(2936, 38, 'Nette', '', 4.00, 15000.00, 60000.00, ''),
(2937, 237, 'Sable', '', 1.00, 60000.00, 60000.00, ''),
(2957, 318, 'Contribution mensuelle de l\'entreprise au déjeuner du personnel', 'juin 2026', 1.00, 300000.00, 300000.00, ''),
(2958, 311, 'deplacement du BETONIER', '', 1.00, 30000.00, 30000.00, ''),
(2969, 320, 'Pavé', '', 10.00, 45000.00, 450000.00, ''),
(2972, 301, 'Carburat/mazout', 'pele chargeable', 3.00, 280000.00, 840000.00, ''),
(2973, 321, 'AVANCE SUR SALAIRE', '', 1.00, 50000.00, 50000.00, ''),
(2974, 319, 'Wall master', '', 3.50, 140000.00, 490000.00, ''),
(2975, 319, 'Taroch', '', 1.00, 12000.00, 12000.00, ''),
(2977, 322, 'Ciment', '', 10.00, 57000.00, 570000.00, ''),
(2978, 322, 'Chargement et déchargement', '', 10.00, 600.00, 6000.00, ''),
(3012, 324, 'Ciments', 'Pour KABEZI', 100.00, 65000.00, 6500000.00, ''),
(3013, 324, 'Ciments pour KINANIRA', '', 10.00, 65000.00, 650000.00, ''),
(3014, 324, 'Ciments pour Gihosha Zone', '', 45.00, 65000.00, 2925000.00, ''),
(3015, 324, 'Ciments pour Gihosha Ndayi', '', 30.00, 65000.00, 1950000.00, ''),
(3016, 324, 'Ciments', 'Pour projet PAVE', 30.00, 65000.00, 1950000.00, ''),
(3032, 326, 'Chargement:Déchargement', '100 sacs de ciment  pour Kabezi', 100.00, 600.00, 60000.00, ''),
(3033, 326, 'Chargement et décharge', '10 sacs de ciment pour Kinanira III', 10.00, 600.00, 6000.00, ''),
(3034, 326, 'Chargement et déchargement', '45 sacs de ciment pour Gihosha Zone', 45.00, 600.00, 27000.00, ''),
(3035, 326, 'Chargement et décharge', '30 sacs de ciment pour Gihosha Ndayi', 30.00, 600.00, 18000.00, ''),
(3036, 326, 'Chargement et décharge', '30 sacs de ciment pour projet PAVE', 30.00, 600.00, 18000.00, ''),
(3037, 323, 'Ciments', 'Pour King\'s school', 80.00, 65000.00, 5200000.00, ''),
(3038, 323, 'Ciments', 'Pour IBB ENTREPÔT', 50.00, 65000.00, 3250000.00, ''),
(3039, 323, 'Ciments', 'Pour JABE USDA', 5.00, 65000.00, 325000.00, ''),
(3044, 45, 'inkwi', '', 50.00, 160000.00, 8000000.00, ''),
(3048, 329, 'AVANCE SUR MAIN D OEUVRE', 'PROJET PAVE', 1.00, 25000.00, 25000.00, ''),
(3057, 331, 'Frais de suivi chantier', '', 1.00, 50000.00, 50000.00, ''),
(3058, 331, 'ration du chauffeur', '', 1.00, 200000.00, 200000.00, ''),
(3059, 332, 'Chargement et déchargement des briques (bennes )', '80 Sacs de ciment pour King\'s School', 80.00, 600.00, 48000.00, ''),
(3060, 332, 'Chargement et déchargement', '80 Sacs de ciment pour IBB ENTREPOT', 80.00, 600.00, 48000.00, ''),
(3061, 332, 'Chargement et déchargement', '5 Sacs de ciment pour JABE USDA', 80.00, 600.00, 48000.00, ''),
(3080, 328, 'Frais de ration et routiers', 'pour les chauffeurs', 8.00, 25000.00, 200000.00, ''),
(3168, 341, 'Sambussa; papier fresheur, cake, sachets', '', 1.00, 92000.00, 92000.00, ''),
(3169, 342, 'Scotch', '', 1.00, 25000.00, 25000.00, ''),
(3170, 342, 'Papier en carton', '', 1.00, 25000.00, 25000.00, ''),
(3171, 342, 'Papier transparent', '', 1.00, 30000.00, 30000.00, ''),
(3172, 342, 'Agraffeuse', '', 1.00, 200000.00, 200000.00, ''),
(3173, 342, 'Agraffe', '', 1.00, 5000.00, 5000.00, ''),
(3174, 343, 'cartons lames papiers', '', 2.00, 140000.00, 280000.00, ''),
(3175, 343, 'Elastique', '', 3.00, 5000.00, 15000.00, ''),
(3176, 343, 'Flash disk', '', 5.00, 25000.00, 125000.00, ''),
(3177, 343, 'Crayon', '', 10.00, 1000.00, 10000.00, ''),
(3178, 343, 'Enveloppe white', '', 2.00, 10000.00, 20000.00, ''),
(3179, 343, 'Enveloppe sacA4', '', 2.00, 20000.00, 40000.00, ''),
(3182, 334, 'doulle', '', 3.00, 10000.00, 30000.00, ''),
(3183, 334, 'vis', '', 42.00, 200.00, 8400.00, ''),
(3184, 281, 'Sable', '', 1.00, 70000.00, 70000.00, ''),
(3185, 338, 'Lame de scie', '', 10.00, 5000.00, 50000.00, ''),
(3190, 345, 'Prestation de service', 'Providence Dimanche le 31 mai 2026', 1.00, 50000.00, 50000.00, ''),
(3191, 345, 'Prestation de service', 'Axcel Dimanche le 31 mai 2026', 1.00, 50000.00, 50000.00, ''),
(3196, 344, 'Prestation de service', 'Dimanche le 31 Mai 2026', 1.00, 200000.00, 200000.00, ''),
(3207, 350, 'SEADING SILLA', '', 10.00, 40000.00, 400000.00, ''),
(3208, 350, 'THINNER', '', 10.00, 30000.00, 300000.00, ''),
(3209, 350, 'VERNIS', '', 10.00, 30000.00, 300000.00, ''),
(3210, 350, 'PAPIER LISE', '', 20.00, 3000.00, 60000.00, ''),
(3211, 350, 'PAPIER DISQUE', '', 10.00, 5000.00, 50000.00, ''),
(3212, 350, 'BROSSE RUDIPO', '', 2.00, 25000.00, 50000.00, ''),
(3213, 350, 'COLLE', '', 5.00, 20000.00, 100000.00, ''),
(3214, 350, 'TRANSPORT', '', 1.00, 100000.00, 100000.00, ''),
(3215, 339, 'PORTES (MONTANT RESTANT SUR LE PAIEMENT DE PORTES)', 'NYABUGETE', 1.00, 14800000.00, 14800000.00, ''),
(3255, 247, 'Maintenance', 'Imprimante Canon 2420', 1.00, 70000.00, 70000.00, ''),
(3289, 352, 'Chargement et déchargement des tubes, Tôles tôles et autres matériaux', '', 907.00, 400.00, 362800.00, ''),
(3292, 351, 'BOIS DU CONGE (poutre)', '', 4.00, 1500000.00, 6000000.00, ''),
(3293, 351, 'BOIS DU CONGO (planche)', '', 10.00, 800000.00, 8000000.00, ''),
(3294, 351, 'BOULEAU', '', 25.00, 10000.00, 250000.00, ''),
(3295, 351, 'VIS', '', 5.00, 40000.00, 200000.00, ''),
(3296, 351, 'COLLE', '', 5.00, 90000.00, 450000.00, ''),
(3297, 351, 'FOREUSE A LOUER', '', 15.00, 15000.00, 225000.00, ''),
(3298, 351, 'VERNIE', '', 4.00, 120000.00, 480000.00, ''),
(3299, 351, 'SANDING SEALER', '', 4.00, 150000.00, 600000.00, ''),
(3300, 351, 'THINNER', '', 4.00, 150000.00, 600000.00, ''),
(3301, 351, 'CHEVILLE', '', 3.00, 15000.00, 45000.00, ''),
(3302, 351, 'BROSSE', '', 10.00, 40000.00, 400000.00, ''),
(3303, 351, 'PAPIER MELE', '', 30.00, 5000.00, 150000.00, ''),
(3304, 351, 'PAPIER DISQUE', '', 30.00, 4000.00, 120000.00, ''),
(3305, 351, 'MACHINAGE ROBOTAGE et CHARGEMENT', '', 14.00, 25000.00, 350000.00, ''),
(3306, 351, 'MAIN D OEUVRE', '', 1.00, 4467500.00, 4467500.00, ''),
(3359, 327, 'Carburat', 'MAZOUT', 7.00, 280000.00, 1960000.00, ''),
(3360, 327, 'Carburat(DETTE)', 'ESSENCE', 10.00, 15000.00, 150000.00, ''),
(3421, 305, 'GUFYATUZA', '', 4.00, 250000.00, 1000000.00, ''),
(3422, 305, 'KWIKOREZA', '', 50000.00, 9.00, 450000.00, ''),
(3423, 305, 'KWUBAKA', '', 50000.00, 4.00, 200000.00, ''),
(3424, 305, 'IKOTI', '', 1.00, 50000.00, 50000.00, ''),
(3442, 54, 'Frais  d\'élaboration des documents du projet BGF', '', 1.00, 100000.00, 100000.00, ''),
(3463, 353, 'Lavage du vehicule', 'E2464A', 5.00, 10000.00, 50000.00, ''),
(3464, 353, 'Lavage du vehicule', 'L4521A', 1.00, 10000.00, 10000.00, ''),
(3516, 354, 'POUTRE DU BOIS DU CONGo', '', 1.00, 1400000.00, 1400000.00, ''),
(3517, 354, 'PLANCHES BOIS DU CONGo', '', 12.00, 750000.00, 9000000.00, ''),
(3518, 354, 'CHARGEMENT ET DECHARGEMENT', '', 13.00, 30000.00, 390000.00, ''),
(3519, 354, 'MACHINAGE', '', 13.00, 50000.00, 650000.00, ''),
(3520, 354, 'VIS', '', 4.00, 40000.00, 160000.00, ''),
(3521, 354, 'CHARNIEL', '', 3.00, 15000.00, 45000.00, ''),
(3522, 354, 'SEADING SILA', '', 20.00, 40000.00, 800000.00, ''),
(3523, 354, 'THINNER', '', 20.00, 40000.00, 800000.00, ''),
(3524, 354, 'VERNIS', '', 20.00, 40000.00, 800000.00, ''),
(3525, 354, 'CELLULES', '', 1.00, 200000.00, 200000.00, ''),
(3526, 354, 'PONCEUSE', '', 2.00, 250000.00, 500000.00, ''),
(3527, 354, 'PAPIER DISQUE', '', 20.00, 4999.99, 99999.80, ''),
(3528, 354, 'PAPIER LISE', '', 50.00, 3000.00, 150000.00, ''),
(3529, 354, 'FEVICOL', '', 6.00, 100000.00, 600000.00, ''),
(3530, 354, 'WOODFIX', '', 10.00, 20000.00, 200000.00, ''),
(3531, 354, 'TRANSPORT', '', 1.00, 300000.00, 300000.00, ''),
(3532, 354, 'MAIN D OEUVRE DE 30%', '', 1.00, 4828500.00, 4828500.00, ''),
(3554, 325, 'DAO de l\'INSS', 'Numero DNCMP/73/T/2025-2026', 1.00, 500000.00, 500000.00, ''),
(3667, 355, 'Avance sur la MOD projet pavé', 'IMENYAVYOSE Bernardin', 1.00, 500000.00, 500000.00, ''),
(3668, 356, 'Ondulaire', '', 9.00, 350000.00, 3150000.00, ''),
(3669, 356, 'Adapteur wifi', '', 3.00, 35000.00, 105000.00, ''),
(3670, 356, 'Antivirus', '', 2.00, 250000.00, 500000.00, ''),
(3671, 356, 'Ordimateur de bureau', 'pour Severin', 1.00, 1000000.00, 1000000.00, ''),
(3678, 357, '1 bidon de  5 litres e  clear car wash soap', '', 1.00, 25000.00, 25000.00, ''),
(3679, 357, 'Cling film', '', 1.00, 50000.00, 50000.00, ''),
(3683, 358, 'HOTPACK CLING FILM,', '', 1.00, 30000.00, 30000.00, ''),
(3684, 358, 'PORTE ESSUI TOUT', '', 1.00, 15000.00, 15000.00, ''),
(3685, 358, 'GOURDE', '', 1.00, 50000.00, 50000.00, ''),
(3686, 358, 'ESSUI TOUT', '', 1.00, 25000.00, 25000.00, ''),
(3688, 359, 'Avance sur commande des tôles, de tubes et autre matériel chez MAGASIN IRAKOZE', '( voir liste du matériel en annexe)', 1.00, 15718957.00, 15718957.00, ''),
(3689, 330, 'MAIN D\'OEUVRE DU MOIS DE MAI', '', 1.00, 2220000.00, 2220000.00, ''),
(3695, 361, 'Chargement et déchargement d\'elevateur', '', 1.00, 130000.00, 130000.00, ''),
(3703, 360, 'Câble dss soudeurs', 'En mettre', 30.00, 25000.00, 750000.00, ''),
(3704, 360, 'Pences', '', 2.00, 15000.00, 30000.00, ''),
(3705, 364, 'Sables', '', 4.00, 65000.00, 260000.00, ''),
(3708, 363, 'Pyt facture', 'eau', 1.00, 157688.00, 157688.00, ''),
(3712, 362, 'Pyt des frais', 'pour reconnaissance geothechnique du sol ( voir fac proforma en annexe)', 1.00, 1894206.00, 1894206.00, ''),
(3713, 348, 'Frais pour la confectionnement Carte', 'CARTE D\'ASSURANCE MALADIE', 1.00, 108000.00, 108000.00, ''),
(3727, 368, 'Blinder', '', 1.00, 200000.00, 200000.00, ''),
(3728, 368, 'Emballage', '', 1.00, 15000.00, 15000.00, ''),
(3737, 370, 'Thermecanic', '', 1.00, 120000.00, 120000.00, ''),
(3738, 370, 'Condasateure', '', 1.00, 25000.00, 25000.00, ''),
(3739, 370, 'Fishe et prise', '', 2.00, 6000.00, 12000.00, ''),
(3740, 369, 'ubuki', '', 1.00, 35000.00, 35000.00, ''),
(3741, 369, 'savon de nettoyage matériel de cuisine', '', 1.00, 35000.00, 35000.00, ''),
(3745, 288, 'Carde', 'A3', 1.00, 53000.00, 53000.00, ''),
(3747, 346, 'Frais de ration et routiers', 'pour les chauffeurs', 7.00, 100000.00, 700000.00, ''),
(3749, 371, 'Frais d\'elaboration du document', 'OUA, KIRIRI SAMUEL, CIBITOKE CLINIQUE, CIBITOKE SHOP, dimanche , 31 Mai, Lundi le 1 Juin, Mardi le 2 juin 2026', 3.00, 50000.00, 150000.00, ''),
(3762, 372, 'Achat courant', 'electriques', 1.00, 100000.00, 100000.00, ''),
(3763, 266, 'Frais de finalisation et transmission  d\'in DAO  weltthungerhilfe', 'au jour férié de Mercredi le 27/05/2026', 2.00, 50000.00, 100000.00, ''),
(3773, 375, 'CHARGEMENT ET DECHARGEMENT DES PAVES', '', 1.00, 189000.00, 189000.00, ''),
(3782, 376, 'Peinture  à l\'huile gris clair n⁰72', '', 4.00, 131400.00, 525600.00, ''),
(3783, 376, 'Petit rouleau', '', 7.00, 3000.00, 21000.00, ''),
(3784, 376, 'Brosse nº2', '', 6.00, 3000.00, 18000.00, ''),
(3785, 376, 'Petroles', '', 3.00, 22000.00, 66000.00, ''),
(3786, 377, 'Pavé', '', 3.00, 45500.00, 136500.00, ''),
(3794, 381, 'Pigments vert', '', 1.00, 350000.00, 350000.00, ''),
(3805, 384, 'Frais de restauration du personnel', '', 1.00, 417000.00, 417000.00, ''),
(3811, 385, 'MOD pour  les ouvriers sur tous les chantiers                                              ers (Chef chantier;magasinier;gardien et tous les ouvriers)', 'du 29 Mai, 31 au 4 Mai 2026', 1.00, 32585500.00, 32585500.00, ''),
(3817, 387, 'Frais de restauration', 'du personnel', 3.00, 64000.00, 192000.00, ''),
(3820, 389, 'Réparation du contacteur', 'Réparation du contacteur de démarrage pour Hilux C1566A', 1.00, 60000.00, 60000.00, ''),
(3821, 386, 'Remplacement de la chape', 'Remplacement de la chape d\'articulation de la benne Fuso I4945A', 1.00, 145000.00, 145000.00, ''),
(3827, 373, 'VOB 2,5mm²', '', 3.00, 230000.00, 690000.00, ''),
(3828, 373, 'VOB 1,5mm²', '', 3.00, 170000.00, 510000.00, ''),
(3829, 373, 'Câble 2×4mm²', '', 20.00, 20000.00, 400000.00, ''),
(3830, 373, 'Dérivation (100×1000)', '', 10.00, 7000.00, 70000.00, ''),
(3831, 349, 'alternateur', 'alternateur pour Benz E1070A', 1.00, 600000.00, 600000.00, ''),
(3832, 349, 'Main-d\'œuvre', 'Main-d\'œuvre pour Benz E1070A', 1.00, 50000.00, 50000.00, ''),
(3843, 378, 'SUCRE', '', 7.00, 6000.00, 42000.00, ''),
(3844, 378, 'UBUYI', '', 3.00, 10000.00, 30000.00, ''),
(3845, 378, 'TANGAWIZI', '', 1.00, 10000.00, 10000.00, ''),
(3846, 378, 'AMAKARA', '', 1.00, 80000.00, 80000.00, ''),
(3848, 391, 'Lavage du vehicule E2463A', '', 1.00, 10000.00, 10000.00, ''),
(3856, 393, 'Location de groupe électrogène', '', 1.00, 80000.00, 80000.00, ''),
(3906, 392, 'Frais de déchargement d\'un camion', 'd\'un machine bétonnière', 1.00, 700000.00, 700000.00, ''),
(3910, 403, 'Chargement', '', 150.00, 500.00, 75000.00, ''),
(3931, 347, 'Gravier', '', 2.00, 300000.00, 600000.00, ''),
(3932, 347, 'Sable', '', 2.00, 70000.00, 140000.00, ''),
(3942, 399, 'Pavee', '', 3.00, 50000.00, 150000.00, ''),
(3943, 410, 'Frais de prestation de service: Projet  OUA', '', 1.00, 300000.00, 300000.00, ''),
(3944, 365, 'MOD', 'Aménagement du terrain de pavage', 1.00, 200000.00, 200000.00, ''),
(3958, 411, 'Beignet', '', 40.00, 1000.00, 40000.00, ''),
(3959, 411, 'ICAPATI', '', 40.00, 1500.00, 60000.00, ''),
(3960, 411, 'ISAMBUSA', '', 6.00, 1000.00, 6000.00, ''),
(3985, 405, 'Frais de ration et routiers', 'pour les chauffeurs', 4.00, 50000.00, 200000.00, ''),
(3988, 404, 'GAINNE', '', 2.00, 50000.00, 100000.00, ''),
(3989, 404, 'COFFRET 12M', '', 1.00, 50000.00, 50000.00, ''),
(3990, 404, 'BOITE DE DERIVATION 100 X100', '', 10.00, 8000.00, 80000.00, ''),
(3991, 394, 'Brique cuites', '', 10000.00, 260.00, 2600000.00, ''),
(3994, 396, 'Fil a ligaturer', '', 1.00, 230000.00, 230000.00, ''),
(3995, 396, 'Fer a beton de 10', '', 50.00, 58650.00, 2932500.00, ''),
(3996, 396, 'Cloud de 10', '', 1.00, 200000.00, 200000.00, ''),
(3997, 396, 'Cloud de 6', '', 1.00, 200000.00, 200000.00, ''),
(3998, 396, 'Trier 15x15', '', 300.00, 1000.00, 300000.00, ''),
(3999, 396, 'Lames de scie', '', 5.00, 5000.00, 25000.00, ''),
(4000, 396, 'Fil maçon', '', 5.00, 12000.00, 60000.00, ''),
(4055, 309, 'Gravier pour épandage', '', 3.00, 960000.00, 2880000.00, ''),
(4056, 314, 'W.PNC', '', 540.00, 40000.00, 21600000.00, ''),
(4057, 314, 'Silicone (carton)', '', 2.00, 600000.00, 1200000.00, ''),
(4058, 314, 'Attaches (Boite)', '', 5.00, 300000.00, 1500000.00, ''),
(4059, 314, 'Clous à béton, 1cm(carton)', '', 4.00, 25000.00, 100000.00, ''),
(4060, 314, 'Angle ligne', '', 22.00, 40000.00, 880000.00, ''),
(4061, 314, 'Disc à couper', '', 10.00, 10000.00, 100000.00, ''),
(4062, 409, 'Tuyaux mobilier40', '', 4.00, 160000.00, 640000.00, ''),
(4063, 409, 'Tube 40×40', '', 2.00, 36000.00, 72000.00, ''),
(4064, 409, 'P0melle de 10', '', 3.00, 5000.00, 15000.00, ''),
(4065, 409, 'Fer plan de 20x20', '', 5.00, 14000.00, 70000.00, ''),
(4066, 409, 'Baguette', '', 2.00, 26000.00, 52000.00, ''),
(4067, 409, 'Disque a couper', '', 4.00, 14000.00, 56000.00, ''),
(4068, 409, 'Verrou', '', 4.00, 6000.00, 24000.00, ''),
(4069, 398, 'Brique cuites', '', 10000.00, 230.00, 2300000.00, ''),
(4070, 374, 'Gaine', '', 6.00, 50000.00, 300000.00, ''),
(4071, 374, 'Dérivation 100×100', '', 10.00, 70000.00, 700000.00, ''),
(4072, 374, 'VOB 1,5mm²', '', 4.00, 170000.00, 680000.00, ''),
(4073, 374, 'VOB 2,5mm²', '', 6.00, 230000.00, 1380000.00, ''),
(4074, 374, 'Isolant', '', 10.00, 5000.00, 50000.00, ''),
(4075, 400, 'Picture a l\'huile', '', 10.00, 131500.00, 1315000.00, ''),
(4076, 400, 'Petit roulon', '', 8.00, 3000.00, 24000.00, ''),
(4077, 400, 'Bross numero 2', '', 6.00, 3000.00, 18000.00, ''),
(4078, 400, 'Petrol', '', 5.00, 22000.00, 110000.00, ''),
(4079, 417, 'Ciment', '', 10.00, 0.00, 0.00, ''),
(4080, 417, 'CHARGEMENT ET  DECHARGEMENT', '', 10.00, 500.00, 5000.00, ''),
(4083, 416, 'Ciment', '', 3.00, 0.00, 0.00, ''),
(4084, 416, 'CHARGEMENT ET  DECHARGEMENT', '', 3.00, 500.00, 1500.00, ''),
(4085, 415, 'Ciment', '', 15.00, 0.00, 0.00, ''),
(4086, 415, 'CHARGEMENT ET  DECHARGEMENT', '', 15.00, 500.00, 7500.00, ''),
(4087, 414, 'Ciment', '', 7.00, 0.00, 0.00, ''),
(4088, 414, 'CHARGEMENT ET  DECHARGEMENT', '', 7.00, 500.00, 3500.00, ''),
(4093, 412, 'Sac de ciment', '', 30.00, 0.00, 0.00, ''),
(4094, 412, 'CHARGEMENT ET  DECHARGEMENT', '', 30.00, 500.00, 15000.00, ''),
(4099, 413, 'Ciment', '', 20.00, 0.00, 0.00, ''),
(4100, 413, 'CHARGEMENT ET  DECHARGEMENT', '', 20.00, 500.00, 10000.00, ''),
(4101, 340, 'MDF', '', 18.00, 400000.00, 7200000.00, ''),
(4102, 340, 'MARBRES', '', 3.00, 1500000.00, 4500000.00, ''),
(4103, 340, 'MACHINAGES DE MDF', '', 18.00, 40000.00, 720000.00, ''),
(4104, 340, 'MACHINAGE DE MARBRE', '', 3.00, 150000.00, 450000.00, ''),
(4105, 340, 'GLICIERES', '', 18.00, 10000.00, 180000.00, ''),
(4106, 340, 'CHARNIERE SPECIAL', '', 18.00, 10000.00, 180000.00, ''),
(4107, 340, 'LIPING', '', 140.00, 3000.00, 420000.00, ''),
(4108, 340, 'POIGNES', '', 18.00, 10000.00, 180000.00, ''),
(4109, 340, 'VIS', '', 5.00, 40000.00, 200000.00, ''),
(4110, 340, 'PONCE PIE', '', 20.00, 10000.00, 200000.00, ''),
(4111, 340, 'ELEPHAT', '', 8.00, 50000.00, 400000.00, ''),
(4112, 340, 'CROCHES', '', 30.00, 2000.00, 60000.00, ''),
(4113, 340, 'SIRCONES', '', 3.00, 40000.00, 120000.00, ''),
(4114, 340, 'COLLE DU MARBRE', '', 3.00, 60000.00, 180000.00, ''),
(4115, 340, 'DISQUES APONCEMARBRE', '', 5.00, 40000.00, 200000.00, ''),
(4116, 340, 'DISQUE A COUP MARBRE', '', 3.00, 50000.00, 150000.00, ''),
(4117, 340, 'PONCEUSE DE MARBRE', '', 1.00, 300000.00, 300000.00, ''),
(4118, 340, 'TRIPLEX', '', 4.00, 60000.00, 240000.00, ''),
(4119, 340, 'MAIN D\'OEUVRE', 'A NÉGOCIER', 1.00, 0.00, 0.00, ''),
(4121, 379, 'Carburat', 'MAZOUT', 10.00, 250000.00, 2500000.00, ''),
(4123, 418, 'Carburat', 'ESSENCE L4521A', 30.00, 4000.00, 120000.00, ''),
(4126, 422, 'Ciment', '', 10.00, 57000.00, 570000.00, ''),
(4127, 422, 'Chargement et déchargement', '', 10.00, 600.00, 6000.00, ''),
(4130, 420, 'Facture artisan moderne', 'Pour pyt restant', 1.00, 560000.00, 560000.00, ''),
(4136, 421, 'CLOUS NO 10', '', 1.00, 200000.00, 200000.00, ''),
(4139, 335, 'Prestation de service DUSHIME KERCY MERVEILLE: Projet OAU', '', 1.00, 100000.00, 100000.00, ''),
(4140, 335, 'Prestation de service NGUMIJAMAHORO PRINCE JOHNSON: Projet OUA', '', 1.00, 100000.00, 100000.00, ''),
(4143, 395, 'Bouillon', '', 1.00, 260000.00, 260000.00, ''),
(4144, 395, 'Moillon de riviere', '', 2.00, 160000.00, 320000.00, ''),
(4170, 428, 'Frais de ration et routiers', 'pour les chaufeurs', 1.00, 100000.00, 100000.00, ''),
(4171, 426, 'Pains', '', 7.00, 5000.00, 35000.00, ''),
(4172, 426, 'Avocats', '', 10.00, 1000.00, 10000.00, ''),
(4192, 429, 'Controre Technique pour RAV 4 L4521A', '', 1.00, 130000.00, 130000.00, ''),
(4193, 429, 'Controre Technique Benne I4945A', '', 1.00, 150000.00, 150000.00, ''),
(4194, 429, 'Controre Technique pour Probox L5495A', '', 1.00, 102000.00, 102000.00, ''),
(4195, 429, 'Controre Technique pour SUCCED L0501A', '', 1.00, 111000.00, 111000.00, ''),
(4196, 429, 'Controre Technique pour Benz E1070A', '', 1.00, 350000.00, 350000.00, ''),
(4197, 429, 'Controre Technique pour Hiace E2464A', '', 1.00, 118000.00, 118000.00, ''),
(4198, 429, 'Refrecteur Pour Benz E1070A', '', 1.00, 140000.00, 140000.00, ''),
(4204, 383, 'Sport moteur', 'pour RAV 4 L4521A', 1.00, 350000.00, 350000.00, ''),
(4205, 383, 'Cetesse', 'pour RAV4 L4521A', 2.00, 120000.00, 240000.00, ''),
(4206, 383, 'Amortisseur avant', 'pour RAV4 L4521A', 1.00, 150000.00, 150000.00, ''),
(4207, 383, 'Crémaillère de direction', 'pour RAV 4 L4521A', 1.00, 1400000.00, 1400000.00, ''),
(4208, 383, 'Main-d\'œuvre', 'pour RAV4 L4521A', 1.00, 100000.00, 100000.00, ''),
(4209, 382, 'Pompe Essence', 'pour SUCCED GRISE L0501A', 1.00, 100000.00, 100000.00, ''),
(4210, 382, 'Filter Essence', 'pour SUCCD GRISE L0501A', 1.00, 100000.00, 100000.00, ''),
(4211, 382, 'Huile moteur', 'Huile moteur pour SUCCED GRISE L0501A', 1.00, 30000.00, 30000.00, ''),
(4212, 382, 'Main-d\'œuvre', 'pour SUCCED GRISE L0501A', 1.00, 30000.00, 30000.00, ''),
(4213, 390, 'Huile de moteur', 'pour Benne Fusso E4945A', 13.00, 34000.00, 442000.00, ''),
(4214, 390, 'Filter de Huile', 'pour benne FUSSO E4945A', 1.00, 150000.00, 150000.00, ''),
(4216, 259, 'Vidange', 'pour Probox L5495A', 4.00, 30000.00, 120000.00, ''),
(4217, 259, 'Changer le filtre', 'pour Probox L5495A', 1.00, 20000.00, 20000.00, ''),
(4220, 251, 'pompe d’amorçage', 'pour Benz E1070A', 1.00, 350000.00, 350000.00, ''),
(4221, 251, 'Main-d\'œuvre', 'pour Benz E1070A', 1.00, 50000.00, 50000.00, ''),
(4223, 430, 'ASSURANCES AUTOMOBILES', 'COROLLA A0764A HINO A3953A MERCEDES BENZ E1070A TOYOTA E4924A NISSAN G3445A DYNA E4178A PICK UP C1566A', 7.00, 105943.50, 741604.50, ''),
(4224, 419, 'Frais de prestation après les heures de service', 'pour\r\nN.J DE DIEU ET Ir ERIC', 2.00, 50000.00, 100000.00, ''),
(4233, 366, 'Ciments', '', 20.00, 57000.00, 1140000.00, ''),
(4234, 366, 'Chargement et déchargement', '', 20.00, 600.00, 12000.00, ''),
(4241, 304, 'Carburat/ESSENCE', 'HIACE E2464A', 3.00, 220000.00, 660000.00, ''),
(4242, 304, 'Carburat/ESSENCE', 'WISH J2818A', 1.00, 220000.00, 220000.00, ''),
(4243, 304, 'Carburat', 'SUCCED L0501A', 1.00, 220000.00, 220000.00, ''),
(4244, 427, 'Assurance transport', 'mobile boom pump', 1.00, 623000.00, 623000.00, ''),
(4245, 427, 'Licennce d\'importation', 'mobile boom pump', 1.00, 106000.00, 106000.00, ''),
(4248, 431, 'Tubes 16x16', '', 50.00, 15000.00, 750000.00, ''),
(4249, 431, 'Tôles plannes riding BG 28', '', 101.00, 40000.00, 4040000.00, ''),
(4250, 431, 'Cilicone', '', 2.00, 30000.00, 60000.00, ''),
(4251, 431, 'Fiche', '', 2.00, 12000.00, 24000.00, ''),
(4252, 431, 'Chargement déchargement', '', 1.00, 90000.00, 90000.00, ''),
(4253, 436, 'Contribution sociale (Dot)', '', 1.00, 1500000.00, 1500000.00, ''),
(4258, 423, 'Tôles transparente', '', 7.00, 100000.00, 700000.00, ''),
(4259, 423, 'Chargement déchargement', '', 7.00, 400.00, 2800.00, ''),
(4260, 433, 'Ciment', '', 15.00, 57000.00, 855000.00, ''),
(4261, 433, 'Chargement déchargement', '', 15.00, 600.00, 9000.00, ''),
(4267, 439, 'Frais de Location d\'une machine', 'machine pelle chargeable le 4/6/2026', 1.00, 1500000.00, 1500000.00, ''),
(4268, 441, 'Frais de suivi du dossier', 'Bio kings', 1.00, 150000.00, 150000.00, ''),
(4269, 442, 'Frais de suivi du dossier', 'Bio king', 1.00, 150000.00, 150000.00, ''),
(4272, 380, 'Carburat', 'ESSENCE', 2.00, 220000.00, 440000.00, ''),
(4273, 434, 'MAZOUT', '', 5.00, 250000.00, 1250000.00, ''),
(4275, 443, 'Frais de consultance', '', 1.00, 500000.00, 500000.00, ''),
(4283, 388, 'Frais d\'elaboration du document', 'peojet OUA, KIRIRI, CIBITOKE', 3.00, 50000.00, 150000.00, ''),
(4284, 445, 'Câble électrique', 'De 2/1/2', 2.00, 350000.00, 700000.00, ''),
(4285, 445, 'Fiche Femelle', '', 1.00, 35000.00, 35000.00, ''),
(4286, 446, 'Achat de capati ,serviette', 'omo', 3.00, 37500.00, 112500.00, ''),
(4287, 447, 'Recherche d\'une document d\'attestation de résidence', '', 1.00, 25000.00, 25000.00, ''),
(4289, 435, 'Frais de ration et routiers', 'pour les chauffeurs', 7.00, 100000.00, 700000.00, ''),
(4290, 397, 'Couton', '', 3.00, 6000.00, 18000.00, ''),
(4291, 397, 'Savon', '', 1.00, 40000.00, 40000.00, ''),
(4292, 397, 'Indobo', '', 3.00, 13000.00, 39000.00, ''),
(4293, 397, 'Jexes', '', 40.00, 2000.00, 80000.00, ''),
(4294, 397, 'Papier meuleu de 120', '', 1.00, 180000.00, 180000.00, ''),
(4295, 448, 'Avance sur salaire', 'REMBOURSABLE EN 6TRANCHES DONT 50000 PAR TRANCHE', 1.00, 300000.00, 300000.00, ''),
(4297, 449, 'Carburat', 'ESSENCE POUR WISH J2818A', 4.00, 21000.00, 84000.00, ''),
(4304, 425, 'Lavage du vehicule', 'L4521A\r\nDate : le 09 Juin', 1.00, 10000.00, 10000.00, ''),
(4305, 425, 'Lavage du vehicule', 'E2464A\r\nDate : le 05 Juin\r\nDate : le 09 Juin\r\nDate : le 11 Juin', 3.00, 10000.00, 30000.00, ''),
(4306, 425, 'Lavage du vehicule', 'J2818A\r\nDate : le 11 Juin', 1.00, 10000.00, 10000.00, ''),
(4327, 452, 'sucre', '', 3.00, 6000.00, 18000.00, ''),
(4328, 452, 'ubuyi', '', 3.00, 10000.00, 30000.00, ''),
(4329, 452, 'tangawizi', '', 1.00, 8000.00, 8000.00, ''),
(4330, 452, 'cayicayi', '', 1.00, 2000.00, 2000.00, ''),
(4331, 452, 'indimu', '', 1.00, 2000.00, 2000.00, ''),
(4332, 452, 'amakara', '', 1.00, 80000.00, 80000.00, ''),
(4333, 451, 'Terre arable', '', 1.00, 200000.00, 200000.00, ''),
(4341, 440, 'Frais de prestation pour les activités informatiquesac', 'Dimanche le 7/6/2026', 1.00, 50000.00, 50000.00, ''),
(4345, 456, 'Unité pour DG', '', 1.00, 40000.00, 40000.00, ''),
(4348, 458, 'Unité pour DT', '', 1.00, 20000.00, 20000.00, ''),
(4358, 454, 'Arrosoir', '', 3.00, 15000.00, 45000.00, ''),
(4359, 454, 'Chargement déchargement des briques industrielle', '', 2.00, 5000.00, 10000.00, ''),
(4360, 453, 'Ampoule', '', 1.00, 5000.00, 5000.00, ''),
(4361, 453, 'Déchargement des briques industrielles', '', 1.00, 8000.00, 8000.00, ''),
(4374, 463, 'Eagle mineral water', 'bidon', 12.00, 5000.00, 60000.00, ''),
(4375, 463, 'Eagle mineral water', 'paquet', 15.00, 8500.00, 127500.00, ''),
(4377, 462, 'Frais de sécurité par GICICO', 'mois de juin 2026', 2.00, 175000.00, 350000.00, ''),
(4378, 461, 'Frais de sécurité par GICICO', 'Mois de Mai 2026', 1.00, 350000.00, 350000.00, ''),
(4386, 460, 'Frais de sécurité par GICICO', 'Mois de Mai 2026', 1.00, 750000.00, 750000.00, ''),
(4389, 108, 'Attache 22mm', '', 120.00, 1500.00, 180000.00, ''),
(4390, 108, 'Boite de derrivation  130x100 \"App\"', '', 10.00, 25000.00, 250000.00, ''),
(4391, 108, 'Boite de derrivation  100x100 \"App\"', '', 10.00, 20000.00, 200000.00, ''),
(4392, 108, 'Boite de derrivation  75x75 \" App\"', '', 15.00, 10000.00, 150000.00, ''),
(4393, 108, 'Boite de derrivation  150x110x70 Ipss \" App\"', '', 6.00, 25000.00, 150000.00, ''),
(4394, 108, 'Manchon  20 mm', '', 10.00, 1500.00, 15000.00, ''),
(4397, 107, 'Boites d\'encastrement', '', 50.00, 4000.00, 200000.00, ''),
(4398, 107, '100x100 Boites de deprivation \"encastré\"', '', 10.00, 5000.00, 50000.00, ''),
(4399, 107, 'Gaine', '', 1.00, 40000.00, 40000.00, ''),
(4400, 107, 'Vo B 2,5 mm2', '', 6.00, 230000.00, 1380000.00, ''),
(4401, 107, 'VoB 1,5mm2', '', 3.00, 170000.00, 510000.00, ''),
(4402, 107, 'Piquet de terre', '', 1.00, 200000.00, 200000.00, ''),
(4403, 467, 'Location du TUKTUK', '13/4/2026', 1.00, 25000.00, 25000.00, ''),
(4404, 109, 'Tuyaux pvc 110 PN10', '', 14.00, 90000.00, 1260000.00, ''),
(4405, 109, 'Tuyaux PVC 63 PN10', '', 10.00, 55000.00, 550000.00, ''),
(4406, 109, 'Tuyaux PVC 75 PN10', '', 6.00, 70000.00, 420000.00, ''),
(4407, 109, 'Coude PVC 110 PN10', '', 18.00, 20000.00, 360000.00, ''),
(4408, 109, 'Te PVC 110 PN10', '', 15.00, 30000.00, 450000.00, ''),
(4409, 109, 'Te PVC Culotte 110 45 degr', '', 4.00, 30000.00, 120000.00, ''),
(4410, 109, 'Coude PVC 63 PN10', '', 15.00, 7000.00, 105000.00, ''),
(4411, 109, 'Coude PVC 63 45 degr PN10', '', 10.00, 8000.00, 80000.00, ''),
(4412, 109, 'Te PVC 63 PN10', '', 16.00, 10000.00, 160000.00, ''),
(4413, 109, 'Coude PVC 75 PN10', '', 16.00, 12000.00, 192000.00, ''),
(4414, 109, 'Coude PVC 75 45degr PN10', '', 8.00, 12000.00, 96000.00, ''),
(4415, 109, 'Te PVC 75 PN10', '', 10.00, 15000.00, 150000.00, ''),
(4416, 109, 'Reducteur PVC 110/75', '', 4.00, 15000.00, 60000.00, ''),
(4417, 109, 'Colle tangit Henkhel', '', 5.00, 140000.00, 700000.00, ''),
(4419, 402, 'Frais d\'assurance maladie', 'nombre de 48 personnes, juin 2026', 48.00, 40000.00, 1920000.00, ''),
(4420, 464, 'Briques ordinaires', '', 10000.00, 200.00, 2000000.00, ''),
(4421, 464, 'Ciments', '', 10.00, 57000.00, 570000.00, ''),
(4422, 464, 'Fer à Béton Ø8', '', 3.00, 38000.00, 114000.00, ''),
(4423, 464, 'Fils à Ligaturer', '', 1.00, 10000.00, 10000.00, ''),
(4459, 336, 'Concertinat', '', 2.00, 45000.00, 90000.00, ''),
(4460, 336, 'Tubes 40x40', '', 2.00, 47000.00, 94000.00, ''),
(4461, 336, 'Fer plat 20x20', '3mm', 8.00, 20000.00, 160000.00, ''),
(4462, 336, 'Mastique de fer', '', 2.00, 145000.00, 290000.00, ''),
(4463, 336, 'Priage des fer plat', '', 8.00, 10000.00, 80000.00, ''),
(4464, 336, 'Antirouille', '', 1.00, 50000.00, 50000.00, ''),
(4465, 336, 'Petroles', '', 1.00, 20000.00, 20000.00, ''),
(4466, 336, 'Tuyaux d\'arrosage 3/4', '', 1.00, 210000.00, 210000.00, ''),
(4467, 336, 'Wallmaster', '', 2.00, 140000.00, 280000.00, ''),
(4468, 336, 'Pierre taillé', '', 7.00, 130000.00, 910000.00, ''),
(4469, 336, 'Taroch', '', 2.00, 12000.00, 24000.00, ''),
(4470, 336, 'Scotch', '', 3.00, 8000.00, 24000.00, ''),
(4471, 336, 'Papier lisse', '', 4.00, 3000.00, 12000.00, ''),
(4472, 336, 'Fil balbere', 'Rouleau', 20.00, 3000.00, 60000.00, ''),
(4492, 401, 'Plaster', '', 2.00, 160000.00, 320000.00, ''),
(4493, 401, 'Peinture blanc', '', 2.00, 330600.00, 661200.00, ''),
(4494, 401, 'Peinture blanc cassé', '', 2.00, 330600.00, 661200.00, ''),
(4495, 401, 'Blanc cassé accly', '', 1.00, 468600.00, 468600.00, ''),
(4496, 401, 'Peinture bleu a l\'huile', '', 2.00, 207500.00, 415000.00, ''),
(4497, 401, 'Petrol', '', 2.00, 22000.00, 44000.00, ''),
(4498, 401, 'Grand roulon', '', 5.00, 6000.00, 30000.00, ''),
(4501, 408, 'Pigment rouge', '', 1.00, 350000.00, 350000.00, ''),
(4502, 408, 'Pigment vert', '', 2.00, 350000.00, 700000.00, ''),
(4506, 473, 'Terre arable', '', 2.00, 200000.00, 400000.00, ''),
(4510, 470, 'Sable de gros calibre (Ubuyoriyori)', '', 1.00, 200000.00, 200000.00, ''),
(4521, 466, 'Location du TUKTUK', '15/4/2026', 1.00, 25000.00, 25000.00, ''),
(4522, 466, 'Location du TUKTUK', '16/4/2026', 1.00, 25000.00, 25000.00, ''),
(4523, 465, 'Location du TUKTUK', '20/5/2026', 1.00, 25000.00, 25000.00, ''),
(4524, 465, 'Location du TUKTUK', '28/5/2026', 1.00, 25000.00, 25000.00, ''),
(4526, 469, 'Uburengeti', '', 1.00, 50000.00, 50000.00, ''),
(4527, 471, 'Ciment', '', 15.00, 57000.00, 855000.00, ''),
(4528, 471, 'Chargement déchargement', '', 15.00, 600.00, 9000.00, ''),
(4532, 472, 'Jexes', '', 40.00, 2000.00, 80000.00, ''),
(4533, 472, 'Acide', '', 5.00, 10000.00, 50000.00, ''),
(4534, 472, 'Papier mellé nº80', '', 1.00, 180000.00, 180000.00, ''),
(4545, 475, 'ibitumbura', 'LUNDI', 40.00, 1000.00, 40000.00, ''),
(4546, 475, 'CAPATI', 'MARDI', 40.00, 1500.00, 60000.00, ''),
(4547, 475, 'PAINS', 'MERCREDI', 1.00, 45000.00, 45000.00, ''),
(4548, 475, 'ibitumbura', 'JEUDI', 40.00, 1000.00, 40000.00, ''),
(4549, 475, 'CAPATI', 'VENDREDI', 40.00, 1500.00, 60000.00, ''),
(4550, 475, 'SAMBOUSSA', 'MARDI ET VENDREDI', 12.00, 1000.00, 12000.00, ''),
(4552, 476, 'RANGEMENT DES MATERIAUX', 'dans les magasins de SATRACO-CONSTRUCTION', 5.00, 10000.00, 50000.00, ''),
(4553, 477, 'Carburat/mazout', '', 5.00, 280000.00, 1400000.00, ''),
(4565, 478, 'Ciment', '', 15.00, 57000.00, 855000.00, ''),
(4566, 478, 'Chargement et déchargement', '', 15.00, 600.00, 9000.00, ''),
(4567, 478, 'Chargement et déchargement compacteur', '', 8.00, 5000.00, 40000.00, ''),
(4568, 478, 'Chargement et déchargement pave', '', 1.00, 50400.00, 50400.00, ''),
(4569, 478, 'Gravier', '', 1.00, 300000.00, 300000.00, ''),
(4577, 459, 'RESTAURATION HEBDOMADAIRE', '', 1.00, 303000.00, 303000.00, ''),
(4604, 438, 'Essence E4924A du 05/06/2026', '', 1.00, 250000.00, 250000.00, ''),
(4606, 437, 'Essence E4924A du 02/06/2026', '', 1.00, 150000.00, 150000.00, ''),
(4613, 480, 'Paquet de PH', 'PH', 2.00, 24000.00, 48000.00, ''),
(4615, 479, 'Ciments', '', 15.00, 56600.00, 849000.00, ''),
(4616, 479, 'Fer à béton de 10', '', 10.00, 56000.00, 560000.00, ''),
(4617, 479, 'Fil à liguaturé', '', 1.00, 230000.00, 230000.00, ''),
(4618, 479, 'Clous de 10 et de 6', '', 2.00, 180000.00, 360000.00, ''),
(4619, 479, 'Ficelle', '', 3.00, 12000.00, 36000.00, ''),
(4620, 479, 'Lame de scie', '', 3.00, 5000.00, 15000.00, ''),
(4625, 367, 'Avance pour  fabrucation de quatre formats des blocs ciment', 'avance', 1.00, 1000000.00, 1000000.00, ''),
(4626, 407, 'Sable', '', 1.00, 498000.00, 498000.00, ''),
(4627, 481, 'Avance sur MOD du Jardinier', '', 1.00, 150000.00, 150000.00, 'Reste à payé 250000Fbu'),
(4632, 468, 'Carburat/ESSENCE', 'HIACE E2464A', 2.00, 230000.00, 460000.00, ''),
(4633, 468, 'Carburat/ESSENCE', 'HILLUX E4923A', 1.00, 230000.00, 230000.00, ''),
(4634, 468, 'Carburat/ESSENCE', 'HILLUX E4924A', 1.00, 230000.00, 230000.00, ''),
(4635, 483, 'Salaire du mois de Mai 2026', '', 1.00, 760000.00, 760000.00, ''),
(4636, 457, 'Frais de restauration  pour 2 Pers', 'pour 4 jours , 9 au 12/6/2026', 2.00, 48000.00, 96000.00, ''),
(4637, 457, 'Frais de restauration  pour 1 Pers', 'pour 5 jours , 8 au 12/6/2026', 6.00, 12000.00, 72000.00, ''),
(4640, 474, 'Impression', 'Papier Photo A3 des documents pour projet OUA', 1.00, 450000.00, 450000.00, ''),
(4645, 485, 'Starlink', 'Abonnement du Mois de juin', 1.00, 100.00, 100.00, ''),
(4653, 488, 'Déplacement lors de l\'impression du projet OUA', 'Lundi le 15 juin', 1.00, 60000.00, 60000.00, ''),
(4654, 488, 'Deplacement lors de l\'impression du  projet OUA', 'mardi le 16 juin', 1.00, 60000.00, 60000.00, ''),
(4659, 143, 'Flotte(Econet Leo)', 'Pour le mois de Juin 2026', 1.00, 585000.00, 585000.00, ''),
(4660, 143, 'Unite de Communication(Lumitel)', 'Pour le mois de Juin 2026', 1.00, 300000.00, 300000.00, ''),
(4661, 487, 'Reliure', 'Spirale des documents de projet OUA', 4.00, 10000.00, 40000.00, ''),
(4662, 486, 'Impression sur papier photo A3', 'des documents de projet OUA', 1.00, 450000.00, 450000.00, ''),
(4664, 489, 'Assurance automobile E2464A', '', 1.00, 251114.00, 251114.00, ''),
(4666, 490, 'Impression sur papier photo A3', 'des documents de projet OUA', 2.00, 410000.00, 820000.00, ''),
(4705, 484, 'Avance sur salaire', '', 1.00, 1800000.00, 1800000.00, ''),
(4706, 493, 'Paiement 3 ème tranche de la facture de PORTAIL', 'pour fourniture des vitres laminées', 1.00, 3000000.00, 3000000.00, ''),
(4707, 444, 'Frais de visite', 'SOCABU GITEGA REF DFC/448', 1.00, 53000.00, 53000.00, ''),
(4710, 492, 'Frais de ration et routiers', 'pour les chauffeurs', 6.00, 50000.00, 300000.00, ''),
(4711, 494, 'Avance sur salaire', 'Remboursable en tranches dont 150000/mois', 1.00, 1800000.00, 1800000.00, ''),
(4713, 496, 'Avance sur salaire', 'Remboursable en tranches dont 70000/mois', 1.00, 500000.00, 500000.00, ''),
(4716, 432, 'Sable', '', 1.00, 70000.00, 70000.00, ''),
(4717, 450, 'Carburat', 'ESSENCE', 3.00, 220000.00, 660000.00, ''),
(4731, 497, 'Comi cleaning', '', 10.00, 35000.00, 350000.00, ''),
(4732, 497, 'Serviette', '', 12.00, 6000.00, 72000.00, ''),
(4752, 498, 'Picture blanc a l\'eau exterieur', '', 1.00, 107000.00, 107000.00, ''),
(4761, 499, 'Ciment', '', 5.00, 57000.00, 285000.00, ''),
(4762, 499, 'Chargement dechargement', '', 5.00, 600.00, 3000.00, ''),
(4767, 500, 'Avance MAIN D\'OEUVRE', 'Réalisations des logos KING\'S SCHOOL', 1.00, 100000.00, 100000.00, ''),
(4775, 502, 'Ciments', '', 200.00, 57000.00, 11400000.00, ''),
(4776, 502, 'Chargement et déchargement', '', 200.00, 600.00, 120000.00, ''),
(4777, 502, 'Gravier', '', 20.00, 300000.00, 6000000.00, ''),
(4778, 502, 'Sable', '', 10.00, 80000.00, 800000.00, ''),
(4779, 503, 'Sables', '', 1.00, 300000.00, 300000.00, ''),
(4800, 501, 'Fer à béton de 10', '', 4.00, 56000.00, 224000.00, ''),
(4801, 501, 'Jexes', '', 50.00, 2000.00, 100000.00, ''),
(4802, 501, 'Ciments', '', 10.00, 57600.00, 576000.00, ''),
(4804, 508, 'Frais du dossier sur le transport machine Dodoma-Kabanga -Buja et ration chauffeur', '', 1.00, 1060000.00, 1060000.00, ''),
(4806, 505, 'mazout', '', 5.00, 280000.00, 1400000.00, ''),
(4824, 333, 'petrol', '', 1.00, 20000.00, 20000.00, ''),
(4825, 333, 'baguette', '', 1.00, 26000.00, 26000.00, ''),
(4826, 333, 'disquet a couper', '', 1.00, 13000.00, 13000.00, ''),
(4836, 510, 'Sable', '', 1.00, 80000.00, 80000.00, ''),
(4844, 513, 'Isukari', '3kg', 3.00, 6000.00, 18000.00, ''),
(4845, 513, 'ubuyi', '1kg', 1.00, 10000.00, 10000.00, ''),
(4846, 509, 'Ciments', '', 15.00, 57000.00, 855000.00, ''),
(4847, 509, 'Chargement déchargement', '', 15.00, 600.00, 9000.00, ''),
(4849, 515, 'GUKURA IYARARA', 'DYNA E4178A', 1.00, 170000.00, 170000.00, ''),
(4850, 512, 'ASSURANCE TOUS RISQUES CHANTIER', '', 1.00, 513000.00, 513000.00, ''),
(4851, 516, 'BRIQUE CUITE', '', 9500.00, 200.00, 1900000.00, ''),
(4871, 518, 'Avance sur la MOD 1/2 du montant prévu', '', 185.00, 5000.00, 925000.00, ''),
(4872, 518, 'Déplacement du travailleur bloc ciment', '', 1.00, 5000.00, 5000.00, ''),
(4876, 504, 'Achat de 16 bordures', 'Reste bordures', 16.00, 30000.00, 480000.00, ''),
(4877, 504, 'Ciment de pavage bordures', '', 3.00, 57000.00, 171000.00, ''),
(4878, 504, 'Chargement déchargement', '', 3.00, 600.00, 1800.00, ''),
(4879, 507, 'Sable', '', 1.00, 300000.00, 300000.00, ''),
(4880, 507, 'Gravier', '', 1.00, 180000.00, 180000.00, ''),
(4881, 517, 'Ciment', '', 10.00, 57000.00, 570000.00, ''),
(4882, 517, 'Chargement dechargement', '', 10.00, 600.00, 6000.00, ''),
(4884, 267, 'Fer a béton', '', 1.00, 2156000.00, 2156000.00, ''),
(4886, 506, 'Laclette', '', 4.00, 15000.00, 60000.00, ''),
(4887, 506, 'Savon', '', 1.00, 40000.00, 40000.00, ''),
(4888, 506, 'Bross methalique', '', 4.00, 6000.00, 24000.00, ''),
(4889, 506, 'Entries 15x15', '', 200.00, 1000.00, 200000.00, ''),
(4890, 506, 'Fil a ligaturer', '', 1.00, 230000.00, 230000.00, ''),
(4891, 506, 'Fer a betony de 8', '', 20.00, 38000.00, 760000.00, ''),
(4892, 506, 'Chargement dechargement', '', 20.00, 450.00, 9000.00, ''),
(4896, 519, 'Frais de ration et routiers', 'pour les chaufeurs', 7.00, 100000.00, 700000.00, ''),
(4898, 522, 'Avance sur quotation for tallazzo at site  kinanira III', 'POUR MUZAFALA de  GOLDEN PAINT', 1.00, 5000000.00, 5000000.00, ''),
(4903, 524, 'Ciments', '', 50.00, 57000.00, 2850000.00, ''),
(4904, 524, 'chargement', '', 50.00, 300.00, 15000.00, ''),
(4905, 523, 'Ciments', '', 50.00, 57000.00, 2850000.00, ''),
(4906, 523, 'Chargement', '', 50.00, 300.00, 15000.00, ''),
(4908, 495, 'Avance sur salaire', 'Remboursable en tranches dont 100000/mois', 1.00, 500000.00, 500000.00, ''),
(4909, 424, 'AVANCE SUR SALAIRE DE JUIN 2026', '', 1.00, 400000.00, 400000.00, ''),
(4993, 406, 'IMPLANTATION D\'UNE MAISON SITE KEABEZI', '', 1.00, 350000.00, 350000.00, ''),
(4994, 406, 'ASSISTANCE AU SHOOTING A KABEZI MOYENNANT UN NIVEAU A LUNETTE', '', 1.00, 50000.00, 50000.00, ''),
(4995, 511, 'ESSENCE', 'HIACE E2464A', 2.00, 230000.00, 460000.00, ''),
(4996, 511, 'ESSENCE', 'HILLUX L4923A', 1.00, 230000.00, 230000.00, ''),
(4997, 511, 'ESSENCE', 'WISH J2818A', 1.00, 230000.00, 230000.00, ''),
(4999, 482, 'mazout', '', 3.00, 250000.00, 750000.00, ''),
(5041, 525, 'MACHINAGE', '', 90.00, 3000.00, 270000.00, ''),
(5042, 525, 'clous', '', 3.00, 12000.00, 36000.00, ''),
(5043, 525, 'PAPIER LISE', '', 10.00, 3000.00, 30000.00, ''),
(5044, 525, 'VIS', '', 2.00, 30000.00, 60000.00, ''),
(5045, 525, 'PONCAGE', '', 1.00, 100000.00, 100000.00, ''),
(5046, 525, 'PAPIER DISQUE', '', 10.00, 3000.00, 30000.00, ''),
(5047, 525, 'colo', '', 5.00, 15000.00, 75000.00, ''),
(5133, 527, 'MDF', '', 1.00, 250000.00, 250000.00, ''),
(5134, 527, 'MACHINAGE', '', 1.00, 10000.00, 10000.00, ''),
(5135, 527, 'CHARNIERE', '', 2.00, 15000.00, 30000.00, ''),
(5136, 527, 'PAPIER LISE', '', 2.00, 3000.00, 6000.00, ''),
(5137, 527, 'VIS', '', 2.00, 30000.00, 60000.00, ''),
(5138, 527, 'verrous', '', 2.00, 15000.00, 30000.00, ''),
(5139, 527, 'POIGNES', '', 2.00, 10000.00, 20000.00, ''),
(5140, 527, 'cadenat', '', 2.00, 5000.00, 10000.00, ''),
(5141, 527, 'pienture', '', 2.00, 25000.00, 50000.00, ''),
(5142, 527, 'PAPIER DISQUE', '', 2.00, 3000.00, 6000.00, ''),
(5143, 527, 'ELEPHAT', '', 1.00, 30000.00, 30000.00, ''),
(5144, 527, 'MAIN D OEUVRE', '', 1.00, 166250.00, 166250.00, ''),
(5145, 526, 'MDF', '', 0.50, 250000.00, 125000.00, ''),
(5146, 526, 'MACHINAGE', '', 1.00, 10000.00, 10000.00, ''),
(5147, 526, 'PLANCHE', '', 2.00, 20000.00, 40000.00, ''),
(5148, 526, 'MACHINAGE', '', 2.00, 5000.00, 10000.00, ''),
(5149, 526, 'CHARNIERE', '', 3.00, 15000.00, 45000.00, ''),
(5150, 526, 'PAPIER LISE', '', 5.00, 3000.00, 15000.00, ''),
(5151, 526, 'VIS', '', 0.50, 30000.00, 15000.00, ''),
(5152, 526, 'colo', '', 1.00, 15000.00, 15000.00, ''),
(5153, 526, 'verrous', '', 4.00, 15000.00, 60000.00, ''),
(5154, 526, 'POIGNES', '', 2.00, 10000.00, 20000.00, ''),
(5155, 526, 'peinture', '', 1.00, 25000.00, 25000.00, ''),
(5156, 526, 'PAPIER DISQUE', '', 5.00, 3000.00, 15000.00, ''),
(5157, 526, 'ELEPHAT', '', 0.50, 30000.00, 15000.00, ''),
(5158, 526, 'MAIN D OEUVRE', '', 1.00, 102500.00, 102500.00, ''),
(5159, 528, 'Lavage du véhicule', 'J2818A,\r\nE2464A, \r\nLe15/6/2026.', 2.00, 10000.00, 20000.00, ''),
(5160, 528, 'Lavage du véhicule', 'L0501A, \r\nLe16/6/2026.', 1.00, 10000.00, 10000.00, ''),
(5161, 528, 'Lavage du véhicule', 'L5495A,\r\nJ2818A,\r\nE2464A,\r\nL0501A,\r\nLe18/6/2026.', 4.00, 10000.00, 40000.00, ''),
(5162, 521, 'Huile moteur pour Hilux', 'Huile moteur pour Hilux C1566A', 1.00, 30000.00, 30000.00, ''),
(5163, 520, 'Valve de purge pour Benne Fuso', 'Valve de purge pour Benne Fuso E4945A', 1.00, 114000.00, 114000.00, ''),
(5164, 520, 'Main-d\'œuvre pour Benne Fuso', 'Main-d\'œuvre pour Benne Fuso E4945A', 1.00, 50000.00, 50000.00, ''),
(5165, 491, 'Huile Frein', 'Huile Frein pour Benne Fuso E4945A', 3.00, 5000.00, 15000.00, ''),
(5166, 491, 'boulon central pour', 'Boulon centre pour Benne Fuso E4945A', 2.00, 15000.00, 30000.00, ''),
(5167, 491, 'Ibikomo pour', 'Ibikomo pour Benne Fuso E4945A', 4.00, 8000.00, 32000.00, ''),
(5168, 491, 'Coupre pour Benne Fuso E4945A', 'Coupre pour Benne Fuso E4945A', 6.00, 7000.00, 42000.00, ''),
(5169, 491, 'Remplacement des lame pour Benne Fuso', 'Remplacement des lame de ressort pour Benne Fuso E4945A', 1.00, 130000.00, 130000.00, ''),
(5170, 491, 'Remplacement des lame pour Benne Fuso', 'Remplacement des lame de ressort pour Benne Fuso E4945A', 1.00, 120000.00, 120000.00, ''),
(5171, 491, 'Boulaje pour Benne Fuso', 'Boulaje pour Benne Fuso E4945A', 2.00, 30000.00, 60000.00, ''),
(5172, 491, 'Gutoboza', 'Lame', 1.00, 10000.00, 10000.00, ''),
(5173, 455, 'Pompe hydraulique pour Howo D8152A', 'Pompe Hydraulique pour Howo E8152A', 1.00, 2000000.00, 2000000.00, ''),
(5174, 455, 'Huile moteur Hydraulique', 'Huile Hydraulique pour Howo E8152A', 10.00, 25000.00, 250000.00, ''),
(5175, 455, 'Main-d\'œuvre pour Howo D8152A', 'Main-d\'œuvre pour Howo D8152A', 1.00, 50000.00, 50000.00, ''),
(5178, 533, 'Ciments', '', 5.00, 57600.00, 288000.00, ''),
(5179, 534, 'Ciments', '', 5.00, 57600.00, 288000.00, ''),
(5182, 535, 'Nettoyage', '', 3.00, 15000.00, 45000.00, ''),
(5193, 529, 'Sable de gros calibre (Ubuyoriyori)', '', 1.00, 498000.00, 498000.00, ''),
(5194, 529, 'Gravier', '', 1.00, 300000.00, 300000.00, ''),
(5199, 537, 'MOD pour tous les  ouvriers, le chef chantier, les magasiniers, les gardiens des chantiers, les Tâcherons,...)', '', 1.00, 26919600.00, 26919600.00, ''),
(5200, 530, 'Ciments', '', 10.00, 57000.00, 570000.00, ''),
(5201, 530, 'Chargement déchargement', '', 10.00, 600.00, 6000.00, ''),
(5202, 530, 'Imihini y\'ibipawa', '', 4.00, 3000.00, 12000.00, ''),
(5206, 532, 'Carburat', 'ESSENCE', 3.00, 220000.00, 660000.00, ''),
(5209, 514, 'BRIQUE CUITE', '', 5000.00, 200.00, 1000000.00, ''),
(5211, 539, 'Dedouanement machine bétoniere', 'Machine', 1.00, 1750000.00, 1750000.00, ''),
(5212, 538, 'Frais de restauration du personne du15 au 19/6', 'pour 5jours', 2.00, 60000.00, 120000.00, ''),
(5213, 538, 'Frais de restauration du14 au 19/6', '6jrs', 1.00, 72000.00, 72000.00, ''),
(5221, 540, 'RESTAURATION HEBDOMADAIRE', '', 1.00, 426000.00, 426000.00, ''),
(5223, 536, 'Achat Etwit et Pile sony', 'pour fourniture bureau', 2.00, 55000.00, 110000.00, ''),
(5224, 542, 'Huile moteur pour Compacteur', 'Huile moteur pour Compacteur', 1.00, 60000.00, 60000.00, ''),
(5225, 531, 'Carburat', 'MAZOUT', 4.00, 280000.00, 1120000.00, ''),
(5226, 541, 'AMAKARA', '', 1.00, 80000.00, 80000.00, ''),
(5227, 541, 'UBUYI', '', 4.00, 10000.00, 40000.00, ''),
(5228, 541, 'SUCRE', '', 5.00, 6000.00, 30000.00, ''),
(5229, 541, 'TANGAWIZI', '', 1.00, 8000.00, 8000.00, ''),
(5230, 541, 'savon', '', 1.00, 35000.00, 35000.00, ''),
(5264, 543, 'PLANCHES BOIS DU CONGE', '', 16.00, 750000.00, 12000000.00, ''),
(5265, 543, 'MACHINAGE', '', 16.00, 20000.00, 320000.00, ''),
(5266, 543, 'CLOUS', '', 4.00, 12000.00, 48000.00, ''),
(5267, 543, 'THINNER', '', 6.00, 35000.00, 210000.00, ''),
(5268, 543, 'SEADING SILA', '', 6.00, 30000.00, 180000.00, ''),
(5269, 543, 'VERNIS', '', 6.00, 30000.00, 180000.00, ''),
(5270, 543, 'COLO RUDI PAINT', '', 10.00, 30000.00, 300000.00, ''),
(5271, 543, 'PAPIER LISE', '', 20.00, 3000.00, 60000.00, ''),
(5272, 543, 'CHARNIERE', '', 3.00, 20000.00, 60000.00, ''),
(5273, 543, 'VIS', '', 2.00, 30000.00, 60000.00, ''),
(5274, 543, 'TRIPLEX', '', 6.00, 30000.00, 180000.00, ''),
(5275, 543, 'CELLULES', '', 1.00, 200000.00, 200000.00, ''),
(5276, 543, 'CHEVILLE', '', 100.00, 500.00, 50000.00, ''),
(5277, 543, 'PONCAGE', '', 1.00, 100000.00, 100000.00, ''),
(5278, 543, 'PAPIER DISQUE', '', 10.00, 3000.00, 30000.00, ''),
(5279, 543, 'MAIN D OEUVRE', '', 1.00, 3594500.00, 3594500.00, ''),
(5313, 544, 'PLANCHES', '', 40.00, 60000.00, 2400000.00, ''),
(5314, 544, 'MACHINAGE', '', 40.00, 10000.00, 400000.00, ''),
(5315, 544, 'CLOUS', '', 4.00, 12000.00, 48000.00, ''),
(5316, 544, 'THINNER', '', 6.00, 35000.00, 210000.00, ''),
(5317, 544, 'SEADING SILLA', '', 6.00, 30000.00, 180000.00, ''),
(5318, 544, 'VERNIS', '', 6.00, 30000.00, 180000.00, ''),
(5319, 544, 'COLO RUDI PAINT', '', 10.00, 30000.00, 300000.00, ''),
(5320, 544, 'PAPIER LISE', '', 25.00, 3000.00, 75000.00, ''),
(5321, 544, 'CHARNIERE', '', 3.00, 20000.00, 60000.00, ''),
(5322, 544, 'VIS', '', 2.00, 30000.00, 60000.00, ''),
(5323, 544, 'TRIPLEX', '', 6.00, 30000.00, 180000.00, ''),
(5324, 544, 'BROU DU NOIX', '', 6.00, 20000.00, 120000.00, ''),
(5325, 544, 'CELLULES', '', 1.00, 200000.00, 200000.00, ''),
(5326, 544, 'CHEVILLE', '', 100.00, 1000.00, 100000.00, ''),
(5327, 544, 'PONCAGE', '', 1.00, 200000.00, 200000.00, ''),
(5328, 544, 'PAPIER DISQUE', '', 20.00, 3000.00, 60000.00, ''),
(5329, 544, 'MAIN D OEUVRE', '', 1.00, 1193250.00, 1193250.00, ''),
(5382, 545, 'MDF', '', 27.00, 450000.00, 12150000.00, ''),
(5383, 545, 'MARBRES', '', 5.00, 1300000.00, 6500000.00, ''),
(5384, 545, 'MACHINAGE DE MARBRE', '', 5.00, 150000.00, 750000.00, ''),
(5385, 545, 'MACHINAGES DE MDF', '', 27.00, 40000.00, 1080000.00, ''),
(5386, 545, 'GLICIERES', '', 15.00, 20000.00, 300000.00, ''),
(5387, 545, 'CHARNIERE SPECIAL', '', 60.00, 10000.00, 600000.00, ''),
(5388, 545, 'LIPING', '', 300.00, 3000.00, 900000.00, ''),
(5389, 545, 'POIGNES', '', 60.00, 10000.00, 600000.00, ''),
(5390, 545, 'VIS', '', 10.00, 40000.00, 400000.00, ''),
(5391, 545, 'PONCE PIE', '', 60.00, 12000.00, 720000.00, ''),
(5392, 545, 'ELEPHAT', '', 10.00, 50000.00, 500000.00, ''),
(5393, 545, 'CROCHES', '', 100.00, 2000.00, 200000.00, ''),
(5394, 545, 'SIRCONES', '', 6.00, 40000.00, 240000.00, ''),
(5395, 545, 'COLLE DU MARBRE', '', 5.00, 60000.00, 300000.00, ''),
(5396, 545, 'DISQUES APONCEMARBRE', '', 5.00, 40000.00, 200000.00, ''),
(5397, 545, 'DISQUE A COUP MARBRE', '', 5.00, 50000.00, 250000.00, ''),
(5398, 545, 'PONCEUSE DE MARBRE', '', 1.00, 400000.00, 400000.00, ''),
(5399, 545, 'TRIPLEX', '', 10.00, 60000.00, 600000.00, ''),
(5400, 545, 'TRANSPORT', '', 1.00, 500000.00, 500000.00, ''),
(5401, 545, 'MAIN D OEUVRE', '', 1.00, 6797500.00, 6797500.00, ''),
(5452, 546, 'PLANCHE', '', 3.00, 40000.00, 120000.00, ''),
(5453, 546, 'MADRIE', '', 7.00, 40000.00, 280000.00, ''),
(5454, 546, 'MACHINAGE', '', 10.00, 3000.00, 30000.00, ''),
(5455, 546, 'CHARGEMENT ET DECHARGEMENT', '', 10.00, 1000.00, 10000.00, ''),
(5456, 546, 'FEVICOL', '', 1.00, 80000.00, 80000.00, ''),
(5457, 546, 'WOODFIX', '', 3.00, 20000.00, 60000.00, ''),
(5458, 546, 'PAPIER DISQUE', '', 5.00, 2000.00, 10000.00, ''),
(5459, 546, 'PAPIER MELI', '', 3.00, 3000.00, 9000.00, ''),
(5460, 546, 'CLOUS', '', 2.00, 10000.00, 20000.00, ''),
(5461, 546, 'INDUITS', '', 2.00, 20000.00, 40000.00, ''),
(5462, 546, 'THINNER', '', 1.00, 30000.00, 30000.00, ''),
(5463, 546, 'SEADING', '', 1.00, 30000.00, 30000.00, ''),
(5464, 546, 'CELLULES', '', 1.00, 150000.00, 150000.00, ''),
(5465, 546, 'POMELLE', '', 3.00, 10000.00, 30000.00, ''),
(5466, 546, 'PONCAGE', '', 1.00, 70000.00, 70000.00, ''),
(5467, 546, 'MAIN D OEUVRE', '', 1.00, 200000.00, 200000.00, ''),
(5468, 546, 'PORTE', '', 39.00, 1169000.00, 45591000.00, '');
INSERT INTO `purchase_request_items` (`id`, `request_id`, `designation`, `technical_specs`, `quantity`, `unit_price`, `total_price`, `observations`) VALUES
(5469, 547, 'changer les pneus pour Benne Fuso', 'changer les pneus pour Benne Fuso E4945A', 2.00, 1100000.00, 2200000.00, ''),
(5470, 548, 'Ciment', '', 15.00, 57000.00, 855000.00, ''),
(5471, 548, 'Chargement dechargement', '', 15.00, 600.00, 9000.00, ''),
(5472, 549, 'Ciments', '', 15.00, 57000.00, 855000.00, ''),
(5473, 549, 'Chargement et déchargement', '', 15.00, 600.00, 9000.00, ''),
(5474, 549, 'Huile (Oki)', '', 5.00, 20000.00, 100000.00, ''),
(5476, 550, 'Gravier', '', 4.00, 300000.00, 1200000.00, ''),
(5477, 551, 'Ciment', '', 50.00, 57000.00, 2850000.00, ''),
(5478, 551, 'Chargement dechargement', '', 50.00, 600.00, 30000.00, ''),
(5479, 552, 'Cloux de 10', '', 1.00, 200000.00, 200000.00, ''),
(5480, 553, 'Brique cuite', '', 15000.00, 230.00, 3450000.00, ''),
(5481, 554, 'Carburant esence 30LITRE', 'HILUX E2464', 1.00, 120000.00, 120000.00, ''),
(5482, 555, 'Carburant esence 30LITRE', 'HIACE L0501', 1.00, 120000.00, 120000.00, ''),
(5483, 556, 'Nettoyage', '', 3.00, 20000.00, 60000.00, ''),
(5484, 557, 'Mastique', '', 3.00, 60000.00, 180000.00, ''),
(5485, 557, 'Clonier', '', 12.00, 15000.00, 180000.00, ''),
(5486, 557, 'Cloux de 10', '', 3.00, 10000.00, 30000.00, ''),
(5487, 557, 'Cloux de 8', '', 3.00, 10000.00, 30000.00, ''),
(5488, 557, 'Cloux de 6', '', 3.00, 10000.00, 30000.00, ''),
(5489, 558, 'Chevron', '', 60.00, 6000.00, 360000.00, ''),
(5490, 558, 'Chargement dechargement', '', 60.00, 100.00, 6000.00, ''),
(5491, 559, 'Ciment', '', 100.00, 57000.00, 5700000.00, ''),
(5492, 559, 'Chargement dechargement', '', 100.00, 600.00, 60000.00, ''),
(5493, 560, 'Tôles transparents', '', 13.00, 100000.00, 1300000.00, ''),
(5494, 560, 'Ciments', '', 10.00, 57600.00, 576000.00, ''),
(5495, 560, 'Chargement et déchargement des tôles', '', 13.00, 2000.00, 26000.00, ''),
(5496, 561, 'Balait', '', 4.00, 15000.00, 60000.00, ''),
(5497, 562, 'Vitre de douche', '', 1.00, 60000.00, 60000.00, ''),
(5498, 563, 'Mazout pour une machine Dodoma-Buja', '', 1.00, 2000000.00, 2000000.00, ''),
(5499, 564, 'Gante desport pour probox L5495A', '', 1.00, 1100000.00, 1100000.00, ''),
(5500, 565, 'Ciment', '', 10.00, 57000.00, 570000.00, ''),
(5501, 565, 'Chargement dechargement', '', 10.00, 600.00, 6000.00, ''),
(5502, 566, 'Sable', '', 1.00, 70000.00, 70000.00, ''),
(5506, 568, 'Ciment', NULL, 333.00, 57000.00, 18981000.00, NULL),
(5507, 568, 'Amgi', NULL, 3999.00, 1400.00, 5598600.00, NULL),
(5515, 569, 'Ibitubura', NULL, 100.00, 1500.00, 150000.00, NULL),
(5516, 569, 'isukali', NULL, 15.00, 9000.00, 135000.00, NULL),
(5517, 569, 'sambussa', NULL, 100.00, 1300.00, 130000.00, NULL),
(5518, 569, 'amagi', NULL, 60.00, 1500.00, 90000.00, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `reference` varchar(120) NOT NULL,
  `object` varchar(255) NOT NULL,
  `amount_ht` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_rate` decimal(8,2) NOT NULL DEFAULT 18.00,
  `amount_ttc` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(40) NOT NULL DEFAULT 'brouillon',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quotes`
--

INSERT INTO `quotes` (`id`, `company_id`, `client_id`, `reference`, `object`, `amount_ht`, `tax_rate`, `amount_ttc`, `status`, `created_at`) VALUES
(1, 2, 1, 'TOITURE', 'TRAVAUX DE CHANGEMENT  DE LA TOITURE   D\'UNE MAISON  D\'HABITATION SISE A KINANIRA   POUR LE COMPTE DE MADAME Eliane ( Option 2)', 74087750.00, 0.00, 74087750.00, 'converti', '2026-05-07 09:44:14'),
(2, 2, 1, 'TOITURE', 'TRAVAUX DE CHANGEMENT  DE LA TOITURE   D\'UNE MAISON  D\'HABITATION SISE A KINANIRA   POUR LE COMPTE DE MADAME Eliane ( Option 1)', 148428400.00, 0.00, 148428400.00, 'converti', '2026-05-07 09:45:42');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `code` varchar(80) NOT NULL,
  `name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `code`, `name`) VALUES
(1, 'SUPER_ADMIN', 'Super Administrateur'),
(2, 'ADMIN_ENTREPRISE', 'Administrateur entreprise'),
(3, 'DIRECTEUR_GENERAL', 'Directeur général'),
(4, 'DIRECTEUR_TECHNIQUE', 'Directeur technique'),
(5, 'CONDUCTEUR_TRAVAUX', 'Conducteur de travaux'),
(6, 'CHEF_CHANTIER', 'Chef de chantier'),
(7, 'RESPONSABLE_ADMIN_FINANCIER', 'Responsable administratif et financier'),
(8, 'COMPTABLE', 'Comptable'),
(9, 'RESPONSABLE_ACHATS', 'Responsable achats'),
(10, 'MAGASINIER', 'Magasinier'),
(11, 'RESPONSABLE_RH', 'Responsable RH'),
(12, 'RESPONSABLE_PARC', 'Responsable parc matériel'),
(13, 'CONTROLEUR_GESTION', 'Contrôleur de gestion'),
(14, 'ASSISTANT_ADMIN', 'Assistant administratif'),
(15, 'CLIENT_PORTAL', 'Portail client'),
(16, 'FOURNISSEUR_PORTAL', 'Portail fournisseur'),
(17, 'SOUS_TRAITANT_PORTAL', 'Portail sous-traitant'),
(18, 'AUDITEUR_EXTERNE', 'Auditeur externe'),
(19, 'RESPONSABLE_IMMOBILISATIONS', 'Responsable immobilisations'),
(20, 'ARCHITECTE', 'Architecte'),
(21, 'DESSINATEUR', 'Dessinateur'),
(22, 'PROJETEUR', 'Projeteur'),
(23, 'ASSISTANT_COMPTABLE', 'Assistant comptable'),
(24, 'TRESORIER', 'Trésorier'),
(25, 'AUDIT_INTERNE', 'Audit interne'),
(26, 'INGENIEUR', 'Ingénieur'),
(27, 'RESPONSABLE_MATERIEL', 'Responsable matériel'),
(28, 'RESPONSABLE_STOCK', 'Responsable stock'),
(29, 'EQUIPE_ACHATS_TERRAIN', 'Équipe achats terrain'),
(30, 'ASSISTANT_TRESORERIE', 'Assistant trésorerie'),
(31, 'RESPONSABLE_EXCECUCTION', 'Responsable Execution'),
(32, 'RESPONSABLE_SOUMMISSION_APPUI_TECHNIQUE', 'Responsable Soummission Appui Technique');

-- --------------------------------------------------------

--
-- Structure de la table `role_permission_overrides`
--

CREATE TABLE `role_permission_overrides` (
  `id` int(11) NOT NULL,
  `role_code` varchar(100) NOT NULL,
  `module_code` varchar(100) NOT NULL,
  `can_view` tinyint(1) NOT NULL DEFAULT 0,
  `can_create` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit` tinyint(1) NOT NULL DEFAULT 0,
  `can_delete` tinyint(1) NOT NULL DEFAULT 0,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role_permission_overrides`
--

INSERT INTO `role_permission_overrides` (`id`, `role_code`, `module_code`, `can_view`, `can_create`, `can_edit`, `can_delete`, `updated_by`, `updated_at`) VALUES
(1, 'CLIENT_PORTAL', 'client_portal', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(2, 'CLIENT_PORTAL', 'notifications', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(3, 'CLIENT_PORTAL', 'messages', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43'),
(4, 'CLIENT_PORTAL', 'external_messages', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43'),
(5, 'CLIENT_PORTAL', 'documents', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(11, 'ADMIN_ENTREPRISE', 'situation_encaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(12, 'ADMIN_ENTREPRISE', 'situation_decaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(13, 'DIRECTEUR_GENERAL', 'situation_encaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(14, 'DIRECTEUR_GENERAL', 'situation_decaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(15, 'RESPONSABLE_ADMIN_FINANCIER', 'situation_encaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(16, 'RESPONSABLE_ADMIN_FINANCIER', 'situation_decaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(17, 'COMPTABLE', 'situation_encaissements', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43'),
(18, 'COMPTABLE', 'situation_decaissements', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43'),
(19, 'TRESORIER', 'situation_encaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(20, 'TRESORIER', 'situation_decaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(21, 'ASSISTANT_TRESORERIE', 'situation_encaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(22, 'ASSISTANT_TRESORERIE', 'situation_decaissements', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43');

-- --------------------------------------------------------

--
-- Structure de la table `service_orders`
--

CREATE TABLE `service_orders` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `subcontractor_id` int(11) DEFAULT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `order_no` varchar(120) NOT NULL,
  `title` varchar(191) NOT NULL,
  `issue_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `progress_percent` decimal(8,2) NOT NULL DEFAULT 0.00,
  `status` varchar(40) NOT NULL DEFAULT 'émis',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `situations`
--

CREATE TABLE `situations` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `contract_id` int(11) DEFAULT NULL,
  `reference_no` varchar(120) NOT NULL,
  `report_type` varchar(40) NOT NULL DEFAULT 'rapport',
  `report_date` date NOT NULL,
  `progress_percent` decimal(8,2) NOT NULL DEFAULT 0.00,
  `billed_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `previous_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `current_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cumulative_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `retention_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `vat_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `net_payable_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `measurement_summary` text DEFAULT NULL,
  `attachment_summary` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'ouvert',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `item_name` varchar(191) NOT NULL,
  `quantity` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(50) NOT NULL,
  `location` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id`, `company_id`, `item_name`, `quantity`, `unit`, `location`, `created_at`) VALUES
(1, 2, 'ECHAFFAUDAGE', 10.00, 'Pcs', '', '2026-05-07 13:04:19'),
(2, 2, 'MATELA', 4.00, 'Pcs', '', '2026-05-07 13:05:33'),
(3, 2, 'PORTES', 4.00, 'Pcs', '', '2026-05-07 13:06:04'),
(4, 2, 'imireko', 18.00, 'p', '', '2026-05-07 13:06:28'),
(5, 2, 'machette', 3.00, 'Pcs', '', '2026-05-07 13:17:01'),
(6, 2, 'projecteur', 9.00, 'Pcs', '', '2026-05-07 13:17:27'),
(7, 2, 'ampoule', 24.00, 'Pcs', '', '2026-05-07 13:21:30'),
(8, 2, 'scie a menuisier', 3.00, 'Pcs', '', '2026-05-07 13:23:01'),
(9, 2, 'gaine', 19.00, 'Pcs', '', '2026-05-07 13:23:24'),
(10, 2, 'TUBE(ampoule)', 6.00, 'Pcs', '', '2026-05-07 13:28:49'),
(11, 2, 'equerre', 3.00, 'Pcs', '', '2026-05-07 13:29:10'),
(12, 2, 'casque', 40.00, 'Pcs', '', '2026-05-07 13:29:30'),
(13, 2, 'Etrier', 200.00, 'Pcs', '', '2026-05-07 13:29:58'),
(14, 2, 'loofing', 1.50, 'Rouleau', '', '2026-05-07 13:30:46'),
(15, 2, 'ratte', 10.00, 'Pcs', '', '2026-05-07 13:31:04'),
(16, 2, 'appareil', 3.00, 'Pcs', '', '2026-05-07 13:31:36'),
(17, 2, 'mastique', 8.00, 'Sacs', '', '2026-05-07 13:32:31'),
(18, 2, 'fil reseau', 0.50, 'r', '', '2026-05-07 13:33:27'),
(19, 2, 'polis elevateur', 1.00, 'Pcs', '', '2026-05-07 13:34:04'),
(20, 2, 'cache noeud', 7.00, 'Pcs', '', '2026-05-07 13:34:42'),
(21, 2, 'cache oreille', 12.00, 'Pcs', '', '2026-05-07 13:35:11'),
(22, 2, 'FB M12', 6.00, 'Pcs', '', '2026-05-07 13:35:37'),
(23, 2, 'ROBINET', 1.00, 'Pcs', '', '2026-05-07 13:36:03'),
(24, 2, 'mazout', 14.00, 'bidon/20l', '', '2026-05-11 12:48:58');

-- --------------------------------------------------------

--
-- Structure de la table `stock_issues`
--

CREATE TABLE `stock_issues` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `issue_no` varchar(120) NOT NULL,
  `issue_date` date NOT NULL,
  `quantity` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(50) NOT NULL,
  `requested_by` varchar(191) DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'validé',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `source_stock_id` int(11) NOT NULL,
  `target_stock_id` int(11) DEFAULT NULL,
  `transfer_no` varchar(120) NOT NULL,
  `transfer_date` date NOT NULL,
  `from_location` varchar(191) NOT NULL,
  `to_location` varchar(191) NOT NULL,
  `quantity` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(50) NOT NULL,
  `requested_by` varchar(191) DEFAULT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'transféré',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `subcontractors`
--

CREATE TABLE `subcontractors` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `specialty` varchar(191) DEFAULT NULL,
  `contact_name` varchar(191) DEFAULT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `subcontractors`
--

INSERT INTO `subcontractors` (`id`, `company_id`, `name`, `specialty`, `contact_name`, `phone`, `email`, `status`, `created_at`) VALUES
(1, 2, 'TUYISENGE           Dieudonné', 'Charpentier', '', '62987670', '', 'active', '2026-05-08 09:10:55'),
(2, 2, 'NDABARUSHIMANA Jean de Dieu', 'Ferrailleur', '', '68155404', '', 'active', '2026-05-08 10:44:27'),
(3, 2, 'NDARUBAYEMWO         Willerme', 'Maconnerie et travaux complémentaires', '', '69514162', '', 'active', '2026-05-08 10:47:50'),
(4, 2, 'HABONIMANA           Moise', 'Soudeur', '', '61222737', '', 'active', '2026-05-08 10:50:11'),
(5, 2, 'CISHAHAYO Elie Moses', 'Électricien', '', '69980120', '', 'active', '2026-05-08 11:47:13'),
(6, 2, 'NIYINDAMUTSA          Adelin', 'Plombier', '', '71856908', '', 'active', '2026-05-08 11:48:19'),
(7, 2, 'HATUNGIMANA             Vincent', 'Maconnerie et travaux complémentaires', '', '61415334', '', 'active', '2026-05-08 11:49:16'),
(8, 2, 'NDUWIMANA              Claude', 'Maconnerie et travaux complémentaires', '', '66584017', '', 'active', '2026-05-08 11:51:15'),
(9, 2, 'KWIZERA          Simeon', 'Peintre', '', '72134633', '', 'active', '2026-05-08 11:53:35'),
(10, 2, 'NSHIMIRIMANA                  Dismas', 'Carreleur et travaux divers  maconnerie', '', '68180628', '', 'active', '2026-05-08 11:55:45');

-- --------------------------------------------------------

--
-- Structure de la table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `contact_name` varchar(191) DEFAULT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `specialty` varchar(191) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_finance_accounting_entry`
--

CREATE TABLE `tbl_finance_accounting_entry` (
  `id` int(11) NOT NULL,
  `piece_number` varchar(100) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `journal_id` int(11) NOT NULL,
  `operation_date` date NOT NULL,
  `reference` varchar(150) DEFAULT NULL,
  `general_label` varchar(255) NOT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'FBU',
  `total_debit` decimal(18,2) DEFAULT 0.00,
  `total_credit` decimal(18,2) DEFAULT 0.00,
  `total_tva` decimal(18,2) DEFAULT 0.00,
  `observation` text DEFAULT NULL,
  `status` enum('draft','validated','cancelled') DEFAULT 'draft',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_finance_accounting_entry`
--

INSERT INTO `tbl_finance_accounting_entry` (`id`, `piece_number`, `exercise_id`, `journal_id`, `operation_date`, `reference`, `general_label`, `chantier_id`, `currency`, `total_debit`, `total_credit`, `total_tva`, `observation`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(11, 'PC-2026-0001', 3, 1, '2026-07-01', 'ACH-001', 'Achat matériaux chantier Gitega', 1, 'FBU', 500000.00, 500000.00, 90000.00, 'RAS', 'draft', 1, '2026-07-06 10:21:17', NULL),
(12, 'PC-2026-0002', 3, 2, '2026-07-01', 'BNQ-001', 'Paiement fournisseur', 2, 'FBU', 350000.00, 350000.00, 63000.00, 'RAS', 'validated', 1, '2026-07-06 10:21:17', NULL),
(13, 'PC-2026-0003', 3, 3, '2026-07-02', 'VEN-001', 'Facturation client', 3, 'FBU', 800000.00, 800000.00, 144000.00, 'RAS', 'validated', 1, '2026-07-06 10:21:17', NULL),
(14, 'PC-2026-0004', 3, 1, '2026-07-02', 'CAI-001', 'Paiement salaire', 1, 'FBU', 420000.00, 420000.00, 0.00, 'RAS', 'draft', 1, '2026-07-06 10:21:17', NULL),
(15, 'PC-2026-0005', 3, 4, '2026-07-03', 'OD-001', 'Régularisation', 2, 'FBU', 250000.00, 250000.00, 0.00, 'RAS', 'validated', 1, '2026-07-06 10:21:17', NULL),
(16, 'PC-2026-0006', 3, 2, '2026-07-03', 'BNQ-002', 'Paiement carburant', 3, 'FBU', 190000.00, 190000.00, 34200.00, 'RAS', 'draft', 1, '2026-07-06 10:21:17', NULL),
(17, 'PC-2026-0007', 3, 1, '2026-07-04', 'CAI-002', 'Achat fournitures', 4, 'FBU', 280000.00, 280000.00, 50400.00, 'RAS', 'validated', 1, '2026-07-06 10:21:17', NULL),
(18, 'PC-2026-0008', 3, 3, '2026-07-04', 'VEN-002', 'Facture client', 5, 'FBU', 920000.00, 920000.00, 165600.00, 'RAS', 'draft', 1, '2026-07-06 10:21:17', NULL),
(19, 'PC-2026-0009', 3, 4, '2026-07-05', 'OD-002', 'Ajustement stock', 2, 'FBU', 140000.00, 140000.00, 0.00, 'RAS', 'validated', 1, '2026-07-06 10:21:17', NULL),
(20, 'PC-2026-0010', 3, 2, '2026-07-05', 'BNQ-003', 'Paiement transport', 1, 'FBU', 310000.00, 310000.00, 55800.00, 'RAS', 'draft', 1, '2026-07-06 10:21:17', NULL),
(21, 'PC-2026-0011', 3, 1, '2026-07-06', 'CAI-003', 'Achat ciment', 3, 'FBU', 670000.00, 670000.00, 120600.00, 'RAS', 'validated', 1, '2026-07-06 10:21:17', NULL),
(22, 'PC-2026-0012', 3, 3, '2026-07-06', 'VEN-003', 'Facture client B', 2, 'FBU', 760000.00, 760000.00, 136800.00, 'RAS', 'draft', 1, '2026-07-06 10:21:17', NULL),
(23, 'PC-2026-0013', 3, 2, '2026-07-07', 'BNQ-004', 'Paiement mission', 4, 'FBU', 220000.00, 220000.00, 39600.00, 'RAS', 'validated', 1, '2026-07-06 10:21:17', NULL),
(24, 'PC-2026-0014', 3, 1, '2026-07-07', 'CAI-004', 'Achat pièces', 5, 'FBU', 430000.00, 430000.00, 77400.00, 'RAS', 'draft', 1, '2026-07-06 10:21:17', NULL),
(25, 'PC-2026-0015', 3, 3, '2026-07-08', 'VEN-004', 'Facturation marché', 1, 'FBU', 1250000.00, 1250000.00, 225000.00, 'RAS', 'validated', 1, '2026-07-06 10:21:17', NULL),
(26, 'PC-2026-0016', 3, 4, '2026-07-08', 'OD-003', 'Correction écriture', 2, 'FBU', 180000.00, 180000.00, 0.00, 'RAS', 'draft', 1, '2026-07-06 10:21:17', NULL),
(27, 'PC-2026-0017', 3, 2, '2026-07-09', 'BNQ-005', 'Paiement TVA', 3, 'FBU', 510000.00, 510000.00, 91800.00, 'RAS', 'validated', 1, '2026-07-06 10:21:17', NULL),
(28, 'PC-2026-0018', 3, 1, '2026-07-09', 'CAI-005', 'Petites dépenses', 4, 'FBU', 96000.00, 96000.00, 17280.00, 'RAS', 'draft', 1, '2026-07-06 10:21:17', NULL),
(29, 'PC-2026-0019', 3, 3, '2026-07-10', 'PC-2026-0019', 'Facture client C', 5, 'FBU', 840000.00, 840000.00, 151200.00, 'RAS', 'validated', 1, '2026-07-06 10:21:17', NULL),
(30, 'PC-2026-0020', 3, 4, '2026-07-10', 'PC-2026-0020', 'Écriture diverse', 2, 'FBU', 200000.00, 200000.00, 36000.00, 'RAS', 'draft', 1, '2026-07-06 10:21:17', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_finance_accounting_entry_line`
--

CREATE TABLE `tbl_finance_accounting_entry_line` (
  `id` int(11) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `debit_account_id` int(11) NOT NULL,
  `credit_account_id` int(11) NOT NULL,
  `line_label` varchar(255) DEFAULT NULL,
  `debit` decimal(18,2) DEFAULT 0.00,
  `credit` decimal(18,2) DEFAULT 0.00,
  `has_tva` tinyint(1) DEFAULT 0,
  `tva_type` enum('deductible','collected') DEFAULT NULL,
  `tva_rate` decimal(5,2) DEFAULT 0.00,
  `tva_amount` decimal(18,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_finance_accounting_entry_line`
--

INSERT INTO `tbl_finance_accounting_entry_line` (`id`, `entry_id`, `debit_account_id`, `credit_account_id`, `line_label`, `debit`, `credit`, `has_tva`, `tva_type`, `tva_rate`, `tva_amount`, `created_at`) VALUES
(61, 11, 18, 14, 'Achat ciment', 300000.00, 300000.00, 1, 'deductible', 18.00, 54000.00, '2026-07-06 10:37:42'),
(62, 11, 19, 14, 'Achat carburant', 150000.00, 150000.00, 1, 'deductible', 18.00, 27000.00, '2026-07-06 10:37:42'),
(63, 11, 21, 14, 'Frais chantier', 50000.00, 50000.00, 1, 'deductible', 18.00, 9000.00, '2026-07-06 10:37:42'),
(64, 12, 18, 13, 'Paiement fournisseur matériaux', 200000.00, 200000.00, 1, 'deductible', 18.00, 36000.00, '2026-07-06 10:37:42'),
(65, 12, 19, 13, 'Paiement carburant', 100000.00, 100000.00, 1, 'deductible', 18.00, 18000.00, '2026-07-06 10:37:42'),
(66, 12, 25, 13, 'Transport fournisseur', 50000.00, 50000.00, 1, 'deductible', 18.00, 9000.00, '2026-07-06 10:37:42'),
(67, 13, 10, 25, 'Facturation travaux', 500000.00, 500000.00, 1, 'collected', 18.00, 90000.00, '2026-07-06 10:37:42'),
(68, 13, 10, 26, 'Travaux bâtiment', 200000.00, 200000.00, 1, 'collected', 18.00, 36000.00, '2026-07-06 10:37:42'),
(69, 13, 10, 25, 'Travaux complémentaires', 100000.00, 100000.00, 1, 'collected', 18.00, 18000.00, '2026-07-06 10:37:42'),
(70, 14, 22, 14, 'Paiement salaires', 250000.00, 250000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(71, 14, 11, 14, 'Main d\'oeuvre', 120000.00, 120000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(72, 14, 22, 14, 'Prime chantier', 50000.00, 50000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(73, 15, 13, 14, 'Régularisation caisse', 100000.00, 100000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(74, 15, 14, 13, 'Régularisation banque', 100000.00, 100000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(75, 15, 10, 9, 'Ajustement divers', 50000.00, 50000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(76, 16, 19, 13, 'Paiement carburant', 100000.00, 100000.00, 1, 'deductible', 18.00, 18000.00, '2026-07-06 10:37:42'),
(77, 16, 19, 13, 'Lubrifiants', 50000.00, 50000.00, 1, 'deductible', 18.00, 9000.00, '2026-07-06 10:37:42'),
(78, 16, 25, 13, 'Transport carburant', 40000.00, 40000.00, 1, 'deductible', 18.00, 7200.00, '2026-07-06 10:37:42'),
(79, 17, 18, 14, 'Fournitures chantier', 150000.00, 150000.00, 1, 'deductible', 18.00, 27000.00, '2026-07-06 10:37:42'),
(80, 17, 21, 14, 'Outillage', 80000.00, 80000.00, 1, 'deductible', 18.00, 14400.00, '2026-07-06 10:37:42'),
(81, 17, 25, 14, 'Transport matériel', 50000.00, 50000.00, 1, 'deductible', 18.00, 9000.00, '2026-07-06 10:37:42'),
(82, 18, 10, 25, 'Facture client', 600000.00, 600000.00, 1, 'collected', 18.00, 108000.00, '2026-07-06 10:37:42'),
(83, 18, 10, 26, 'Prestations', 200000.00, 200000.00, 1, 'collected', 18.00, 36000.00, '2026-07-06 10:37:42'),
(84, 18, 10, 25, 'Travaux annexes', 120000.00, 120000.00, 1, 'collected', 18.00, 21600.00, '2026-07-06 10:37:42'),
(85, 19, 7, 18, 'Correction stock', 70000.00, 70000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(86, 19, 8, 19, 'Inventaire carburant', 40000.00, 40000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(87, 19, 7, 18, 'Inventaire matériel', 30000.00, 30000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(88, 20, 25, 13, 'Paiement transport', 150000.00, 150000.00, 1, 'deductible', 18.00, 27000.00, '2026-07-06 10:37:42'),
(89, 20, 23, 13, 'Mission chantier', 100000.00, 100000.00, 1, 'deductible', 18.00, 18000.00, '2026-07-06 10:37:42'),
(90, 20, 25, 13, 'Logistique', 60000.00, 60000.00, 1, 'deductible', 18.00, 10800.00, '2026-07-06 10:37:42'),
(91, 21, 18, 14, 'Achat ciment', 400000.00, 400000.00, 1, 'deductible', 18.00, 72000.00, '2026-07-06 10:37:42'),
(92, 21, 18, 14, 'Fer à béton', 200000.00, 200000.00, 1, 'deductible', 18.00, 36000.00, '2026-07-06 10:37:42'),
(93, 21, 25, 14, 'Transport matériaux', 70000.00, 70000.00, 1, 'deductible', 18.00, 12600.00, '2026-07-06 10:37:42'),
(94, 22, 10, 25, 'Facture client B', 500000.00, 500000.00, 1, 'collected', 18.00, 90000.00, '2026-07-06 10:37:42'),
(95, 22, 10, 26, 'Prestations diverses', 160000.00, 160000.00, 1, 'collected', 18.00, 28800.00, '2026-07-06 10:37:42'),
(96, 22, 10, 25, 'Travaux supplémentaires', 100000.00, 100000.00, 1, 'collected', 18.00, 18000.00, '2026-07-06 10:37:42'),
(97, 23, 23, 13, 'Mission technique', 100000.00, 100000.00, 1, 'deductible', 18.00, 18000.00, '2026-07-06 10:37:42'),
(98, 23, 25, 13, 'Transport mission', 70000.00, 70000.00, 1, 'deductible', 18.00, 12600.00, '2026-07-06 10:37:42'),
(99, 23, 26, 13, 'Communication', 50000.00, 50000.00, 1, 'deductible', 18.00, 9000.00, '2026-07-06 10:37:42'),
(100, 24, 21, 14, 'Pièces engins', 250000.00, 250000.00, 1, 'deductible', 18.00, 45000.00, '2026-07-06 10:37:42'),
(101, 24, 5, 14, 'Outillage', 120000.00, 120000.00, 1, 'deductible', 18.00, 21600.00, '2026-07-06 10:37:42'),
(102, 24, 25, 14, 'Transport pièces', 60000.00, 60000.00, 1, 'deductible', 18.00, 10800.00, '2026-07-06 10:37:42'),
(103, 25, 10, 25, 'Facturation marché', 900000.00, 900000.00, 1, 'collected', 18.00, 162000.00, '2026-07-06 10:37:42'),
(104, 25, 10, 25, 'Acompte client', 250000.00, 250000.00, 1, 'collected', 18.00, 45000.00, '2026-07-06 10:37:42'),
(105, 25, 10, 26, 'Travaux complémentaires', 100000.00, 100000.00, 1, 'collected', 18.00, 18000.00, '2026-07-06 10:37:42'),
(106, 26, 13, 14, 'Correction caisse', 80000.00, 80000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(107, 26, 14, 13, 'Correction banque', 60000.00, 60000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(108, 26, 10, 9, 'Correction tiers', 40000.00, 40000.00, 0, NULL, 0.00, 0.00, '2026-07-06 10:37:42'),
(109, 27, 12, 13, 'Paiement TVA', 300000.00, 300000.00, 1, 'deductible', 18.00, 54000.00, '2026-07-06 10:37:42'),
(110, 27, 12, 13, 'Règlement taxe', 150000.00, 150000.00, 1, 'deductible', 18.00, 27000.00, '2026-07-06 10:37:42'),
(111, 27, 12, 13, 'Complément TVA', 60000.00, 60000.00, 1, 'deductible', 18.00, 10800.00, '2026-07-06 10:37:42'),
(112, 28, 26, 14, 'Petites dépenses', 40000.00, 40000.00, 1, 'deductible', 18.00, 7200.00, '2026-07-06 10:37:42'),
(113, 28, 25, 14, 'Transport local', 30000.00, 30000.00, 1, 'deductible', 18.00, 5400.00, '2026-07-06 10:37:42'),
(114, 28, 21, 14, 'Fournitures bureau', 26000.00, 26000.00, 1, 'deductible', 18.00, 4680.00, '2026-07-06 10:37:42'),
(135, 30, 13, 14, 'Écriture diverse', 100000.00, 100000.00, 1, 'collected', 18.00, 18000.00, '2026-07-08 10:57:08'),
(136, 30, 14, 13, 'Régularisation', 70000.00, 70000.00, 1, 'collected', 18.00, 12600.00, '2026-07-08 10:57:08'),
(137, 30, 10, 9, 'Écriture diverse', 30000.00, 30000.00, 1, 'collected', 18.00, 5400.00, '2026-07-08 10:57:08'),
(138, 29, 10, 25, 'Facture client C', 600000.00, 600000.00, 1, 'deductible', 18.00, 108000.00, '2026-07-08 10:58:50'),
(139, 29, 10, 26, 'Services', 150000.00, 150000.00, 1, 'deductible', 18.00, 27000.00, '2026-07-08 10:58:50'),
(140, 29, 10, 25, 'Travaux additionnels', 90000.00, 90000.00, 1, 'deductible', 18.00, 16200.00, '2026-07-08 10:58:50');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_finance_account_class`
--

CREATE TABLE `tbl_finance_account_class` (
  `id` int(11) NOT NULL,
  `class_number` int(11) NOT NULL,
  `code_prefix` varchar(5) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `class_name` varchar(150) NOT NULL,
  `nature` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_finance_account_class`
--

INSERT INTO `tbl_finance_account_class` (`id`, `class_number`, `code_prefix`, `sort_order`, `class_name`, `nature`, `description`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '1', 1, 'Comptes de ressources durables', 'Bilan - Passif', 'Capital, réserves, emprunts, subventions et autres ressources stables', 'active', NULL, '2026-07-02 12:09:26', '2026-07-02 12:45:52'),
(2, 2, '2', 2, 'Comptes d\'actif immobilisé', 'Bilan - Actif', 'Immobilisations incorporelles, corporelles et financières.', 'active', NULL, '2026-07-02 12:09:26', NULL),
(3, 3, '3', 3, 'Comptes de stocks', 'Bilan - Actif', 'Stocks de matières premières, marchandises, carburant, matériaux et fournitures.', 'active', NULL, '2026-07-02 12:09:26', NULL),
(4, 4, '4', 4, 'Comptes de tiers', 'Bilan - Actif / Passif', 'Clients, fournisseurs, personnel, État, organismes sociaux et autres tiers.', 'active', NULL, '2026-07-02 12:09:26', NULL),
(5, 5, '5', 5, 'Comptes de trésorerie', 'Bilan - Actif', 'Caisses, banques, chèques, virements et autres disponibilités.', 'active', NULL, '2026-07-02 12:09:26', NULL),
(6, 6, '6', 6, 'Comptes de charges', 'Compte de résultat', 'Achats, salaires, carburants, frais généraux, amortissements et autres charges.', 'active', NULL, '2026-07-02 12:09:26', NULL),
(7, 7, '7', 7, 'Comptes de produits', 'Compte de résultat', 'Prestations, ventes, travaux réalisés et autres produits.', 'active', NULL, '2026-07-02 12:09:26', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_finance_chart_account`
--

CREATE TABLE `tbl_finance_chart_account` (
  `id` int(11) NOT NULL,
  `account_code` varchar(20) NOT NULL,
  `account_name` varchar(180) NOT NULL,
  `class_id` int(11) NOT NULL,
  `account_type` enum('Caisse','Banque','Client','Fournisseur','Charge','Produit','Stock','Immobilisation','Personnel','Etat','Autre') NOT NULL DEFAULT 'Autre',
  `chantier_id` int(11) DEFAULT NULL,
  `opening_balance` decimal(18,2) NOT NULL DEFAULT 0.00,
  `current_balance` decimal(18,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(10) NOT NULL DEFAULT 'FBU',
  `allow_entry` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_finance_chart_account`
--

INSERT INTO `tbl_finance_chart_account` (`id`, `account_code`, `account_name`, `class_id`, `account_type`, `chantier_id`, `opening_balance`, `current_balance`, `currency`, `allow_entry`, `status`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '101000', 'Capital social', 1, 'Autre', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Capital de la société', NULL, '2026-07-02 15:10:46', '2026-07-03 03:58:19'),
(2, '161000', 'Emprunts auprès des établissements financiers', 1, 'Autre', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Emprunts bancaires et dettes financières.', NULL, '2026-07-02 15:10:46', NULL),
(3, '211000', 'Terrains', 2, 'Immobilisation', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Terrains appartenant à SATRACO.', NULL, '2026-07-02 15:10:46', NULL),
(4, '213000', 'Bâtiments', 2, 'Immobilisation', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Bâtiments et constructions.', NULL, '2026-07-02 15:10:46', NULL),
(5, '244000', 'Matériel de transport', 2, 'Immobilisation', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Véhicules, camions et engins roulants.', NULL, '2026-07-02 15:10:46', NULL),
(6, '245000', 'Matériel et outillage', 2, 'Immobilisation', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Machines, outillages et équipements de chantier.', NULL, '2026-07-02 15:10:46', NULL),
(7, '311000', 'Stocks de matériaux de construction', 3, 'Stock', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Ciment, fer à béton, sable, gravier et autres matériaux.', NULL, '2026-07-02 15:10:46', NULL),
(8, '312000', 'Stocks carburant et lubrifiants', 3, 'Stock', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Carburant, huiles et lubrifiants.', NULL, '2026-07-02 15:10:46', NULL),
(9, '401000', 'Fournisseurs', 4, 'Fournisseur', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Dettes envers les fournisseurs.', NULL, '2026-07-02 15:10:46', NULL),
(10, '411000', 'Clients', 4, 'Client', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Créances clients.', NULL, '2026-07-02 15:10:46', NULL),
(11, '421000', 'Personnel - Salaires dus', 4, 'Personnel', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Salaires et rémunérations à payer.', NULL, '2026-07-02 15:10:46', NULL),
(12, '442000', 'État - Impôts et taxes', 4, 'Etat', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Impôts, taxes et obligations fiscales.', NULL, '2026-07-02 15:10:46', NULL),
(13, '512000', 'Compte bancaire principal', 5, 'Banque', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Compte bancaire principal de SATRACO.', NULL, '2026-07-02 15:10:46', NULL),
(14, '521000', 'Caisse principale', 5, 'Caisse', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Caisse générale de SATRACO.', NULL, '2026-07-02 15:10:46', NULL),
(15, '521001', 'Caisse Chantier Gitega', 5, 'Caisse', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Caisse affectée au chantier de Gitega.', NULL, '2026-07-02 15:10:46', NULL),
(16, '521002', 'Caisse Chantier Ngozi', 5, 'Caisse', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Caisse affectée au chantier de Ngozi.', NULL, '2026-07-02 15:10:46', NULL),
(17, '521003', 'Caisse Chantier Bujumbura', 5, 'Caisse', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Caisse affectée au chantier de Bujumbura.', NULL, '2026-07-02 15:10:46', NULL),
(18, '601000', 'Achats de matériaux', 6, 'Charge', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Achats de ciment, fer, sable, gravier et autres matériaux.', NULL, '2026-07-02 15:10:46', NULL),
(19, '602000', 'Achats carburant et lubrifiants', 6, 'Charge', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Dépenses de carburant et lubrifiants.', NULL, '2026-07-02 15:10:46', NULL),
(21, '605000', 'Location matériels et engins', 6, 'Charge', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Location d’engins, machines et matériels de chantier.', NULL, '2026-07-02 15:10:46', NULL),
(22, '621000', 'Personnel chantier', 6, 'Charge', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Main d’œuvre et rémunération du personnel chantier.', NULL, '2026-07-02 15:10:46', NULL),
(23, '625000', 'Déplacements et missions', 6, 'Charge', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Frais de déplacement, mission et transport.', NULL, '2026-07-02 15:10:46', NULL),
(24, '626000', 'Frais de communication', 6, 'Charge', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Téléphone, internet et communication.', NULL, '2026-07-02 15:10:46', NULL),
(25, '701000', 'Ventes de travaux / prestations', 7, 'Produit', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Revenus issus des travaux réalisés.', NULL, '2026-07-02 15:10:46', NULL),
(26, '706000', 'Prestations de services', 7, 'Produit', NULL, 0.00, 0.00, 'FBU', 1, 'active', 'Prestations diverses facturées aux clients.', NULL, '2026-07-02 15:10:46', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_finance_exercice`
--

CREATE TABLE `tbl_finance_exercice` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_finance_exercice`
--

INSERT INTO `tbl_finance_exercice` (`id`, `name`, `year`, `start_date`, `end_date`, `status`, `is_active`, `created_by`, `created_at`, `updated_at`, `closed_at`) VALUES
(1, 'Exercice 2024', 2024, '2024-01-01', '2024-12-31', 'closed', 0, 1, '2026-07-02 10:37:36', NULL, NULL),
(2, 'Exercice 2025', 2025, '2025-01-01', '2025-12-31', 'closed', 0, 1, '2026-07-02 10:37:36', NULL, NULL),
(3, 'Exercice 2026', 2026, '2026-01-01', '2026-12-31', 'open', 1, 1, '2026-07-02 10:37:36', '2026-07-02 11:14:22', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_finance_journal_code`
--

CREATE TABLE `tbl_finance_journal_code` (
  `id` int(11) NOT NULL,
  `journal_code` varchar(20) NOT NULL,
  `journal_name` varchar(150) NOT NULL,
  `journal_type` enum('Caisse','Banque','Achat','Vente','Opérations diverses') NOT NULL,
  `default_account_id` int(11) DEFAULT NULL,
  `allow_entry` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_finance_journal_code`
--

INSERT INTO `tbl_finance_journal_code` (`id`, `journal_code`, `journal_name`, `journal_type`, `default_account_id`, `allow_entry`, `status`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'CAI', 'Journal de caisse', 'Caisse', 14, 1, 'active', 'Toutes les opérations de caisse.', NULL, '2026-07-03 05:11:17', NULL),
(2, 'BAN', 'Journal de banque', 'Banque', 13, 1, 'active', 'Opérations bancaires, virements et retraits.', NULL, '2026-07-03 05:11:17', NULL),
(3, 'ACH', 'Journal des achats', 'Achat', NULL, 1, 'active', 'Factures fournisseurs et achats de matériaux.', NULL, '2026-07-03 05:11:17', NULL),
(4, 'VEN', 'Journal des ventes', 'Vente', NULL, 1, 'active', 'Factures clients et prestations facturées.', NULL, '2026-07-03 05:11:17', NULL),
(5, 'OD', 'Opérations diverses', 'Opérations diverses', NULL, 1, 'active', 'Ajustements, écritures de régularisation et corrections comptables.', NULL, '2026-07-03 05:11:17', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_stock_article`
--

CREATE TABLE `tbl_stock_article` (
  `id` int(11) NOT NULL,
  `code_article` varchar(50) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `unite` varchar(50) DEFAULT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_stock_article`
--

INSERT INTO `tbl_stock_article` (`id`, `code_article`, `designation`, `unite`, `categorie`, `created_at`) VALUES
(3, 'ART-001', 'ECHAFFAUDAGE', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(4, 'ART-002', 'MATELA', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(5, 'ART-003', 'PORTES', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(6, 'ART-004', 'mireko', 'p', 'Matériel technique', '2026-06-30 15:19:24'),
(7, 'ART-005', 'machette', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(8, 'ART-006', 'projecteur', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(9, 'ART-007', 'ampoule', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(10, 'ART-008', 'scie a menuisier', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(11, 'ART-009', 'gaine', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(12, 'ART-010', 'TUBE(ampoule)', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(13, 'ART-011', 'equerre', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(14, 'ART-012', 'casque', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(15, 'ART-013', 'Etrier', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(16, 'ART-014', 'loofing', 'Rouleau', 'Matériel technique', '2026-06-30 15:19:24'),
(17, 'ART-015', 'ratte', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(18, 'ART-016', 'appareil', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(19, 'ART-017', 'mastique', 'Sacs', 'Matériel technique', '2026-06-30 15:19:24'),
(20, 'ART-018', 'fil reseau', 'r', 'Matériel technique', '2026-06-30 15:19:24'),
(21, 'ART-019', 'polis elevateur', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(22, 'ART-020', 'cache noed', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(23, 'ART-021', 'cache oreille', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(24, 'ART-022', 'FB M12', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(25, 'ART-023', 'ROBINET', 'Pcs', 'Matériel technique', '2026-06-30 15:19:24'),
(26, 'ART-024', 'mazout', 'bidon/20l', 'Matériel technique', '2026-06-30 15:19:24');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_stock_emplacement`
--

CREATE TABLE `tbl_stock_emplacement` (
  `id` int(11) NOT NULL,
  `nom_emplacement` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_stock_emplacement`
--

INSERT INTO `tbl_stock_emplacement` (`id`, `nom_emplacement`, `description`, `created_at`) VALUES
(3, 'Magasin Général', 'Emplacement principal du stock technique', '2026-06-30 15:19:24');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_stock_quantite`
--

CREATE TABLE `tbl_stock_quantite` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `emplacement_id` int(11) NOT NULL,
  `quantite` decimal(10,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_stock_quantite`
--

INSERT INTO `tbl_stock_quantite` (`id`, `article_id`, `emplacement_id`, `quantite`, `created_at`) VALUES
(1, 3, 3, 10.00, '2026-06-30 15:19:24'),
(2, 4, 3, 4.00, '2026-06-30 15:19:24'),
(3, 5, 3, 4.00, '2026-06-30 15:19:24'),
(4, 6, 3, 18.00, '2026-06-30 15:19:24'),
(5, 7, 3, 3.00, '2026-06-30 15:19:24'),
(6, 8, 3, 9.00, '2026-06-30 15:19:24'),
(7, 9, 3, 24.00, '2026-06-30 15:19:24'),
(8, 10, 3, 3.00, '2026-06-30 15:19:24'),
(9, 11, 3, 19.00, '2026-06-30 15:19:24'),
(10, 12, 3, 6.00, '2026-06-30 15:19:24'),
(11, 13, 3, 3.00, '2026-06-30 15:19:24'),
(12, 14, 3, 40.00, '2026-06-30 15:19:24'),
(13, 15, 3, 200.00, '2026-06-30 15:19:24'),
(14, 16, 3, 1.50, '2026-06-30 15:19:24'),
(15, 17, 3, 10.00, '2026-06-30 15:19:24'),
(16, 18, 3, 3.00, '2026-06-30 15:19:24'),
(17, 19, 3, 8.00, '2026-06-30 15:19:24'),
(18, 20, 3, 0.50, '2026-06-30 15:19:24'),
(19, 21, 3, 1.00, '2026-06-30 15:19:24'),
(20, 22, 3, 7.00, '2026-06-30 15:19:24'),
(21, 23, 3, 12.00, '2026-06-30 15:19:24'),
(22, 24, 3, 6.00, '2026-06-30 15:19:24'),
(23, 25, 3, 1.00, '2026-06-30 15:19:24'),
(24, 26, 3, 14.00, '2026-06-30 15:19:24');

-- --------------------------------------------------------

--
-- Structure de la table `technical_documents`
--

CREATE TABLE `technical_documents` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `doc_type` varchar(80) NOT NULL DEFAULT 'Plan',
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `visibility_scope` varchar(30) NOT NULL DEFAULT 'TECH_DG',
  `created_by_user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `technical_documents`
--

INSERT INTO `technical_documents` (`id`, `company_id`, `project_id`, `title`, `doc_type`, `description`, `file_path`, `visibility_scope`, `created_by_user_id`, `created_at`) VALUES
(1, 2, 2, 'OFFRE BRARUDI', 'Dessin', 'Reproduction  releve du villa3  Brarudi Gitega', 'uploads/plan_library/plan_20260429113442_237150c0.PNG', 'TECH_DG', 30, '2026-04-29 11:34:42'),
(2, 2, 16, 'rendu', 'Visuel', 'rendu réaliste', 'uploads/plan_library/plan_20260506091215_de174ab5.png', 'TECH_DG', 40, '2026-05-06 09:12:15'),
(3, 2, 4, 'HOTEL OUA', 'Dessin', 'CONCEPTION OF A HOTEL 5 STARS', 'uploads/plan_library/plan_20260506091957_1ddcb2b3.JPG', 'TECH_DG', 34, '2026-05-06 09:19:57'),
(4, 2, 4, 'Villa', 'Dessin', 'Conception d’un ville OUA R+1', 'uploads/plan_library/plan_20260506092240_6f6f15a9.jpeg', 'TECH_DG', 31, '2026-05-06 09:22:40'),
(5, 2, 4, 'Plan masse', 'Plan', '', 'uploads/plan_library/plan_20260506093110_a7565eb9.png', 'TECH_DG', 32, '2026-05-06 09:31:10'),
(6, 2, 5, 'CHANGEMENT DE LA TOITURE', 'Dessin', 'Changement de la  toiture', 'uploads/plan_library/plan_20260506093451_eb1f05e5.PNG', 'TECH_DG', 30, '2026-05-06 09:34:51'),
(7, 2, 5, 'CHANGEMENT DE TOITURE ET DEVIS', 'Dessin', 'CHANGEMENT DE TOITURE ET DEVIS', 'uploads/plan_library/plan_20260507093751_f6ce3c42.pdf', 'TECH_DG', 30, '2026-05-07 09:37:51'),
(8, 2, 4, 'Villa', 'Dessin', 'Design of modern hose G+1  version 2', 'uploads/plan_library/plan_20260507094949_5087b5c7.jpeg', 'TECH_DG', 31, '2026-05-07 09:49:49');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `company_id`, `role_id`, `first_name`, `last_name`, `email`, `password_hash`, `status`, `created_at`) VALUES
(1, NULL, 1, 'Super', 'Admin', 'superadmin@votre-entreprise.com', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(2, 1, 2, 'Admin', 'Principal', 'admin@votre-entreprise.com', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(3, 1, 3, 'Directeur', 'Général', 'dg@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(4, 1, 25, 'Audit', 'Interne', 'audit@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(5, 1, 4, 'Directeur', 'Technique', 'dt@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(6, 1, 26, 'Ingénieur', 'Bureau', 'ingenieur@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(7, 1, 5, 'Conducteur', 'Travaux', 'conducteur@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(8, 1, 6, 'Chef', 'Chantier', 'chef.chantier@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(9, 1, 27, 'Responsable', 'Matériel', 'materiel@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(10, 1, 28, 'Responsable', 'Stock', 'stock@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(11, 1, 29, 'Équipe', 'Achats Terrain', 'achats.terrain@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(12, 1, 7, 'Directrice', 'Administrative et Financière', 'daf@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(13, 1, 8, 'Comptable', 'Principal', 'comptable@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(14, 1, 23, 'Assistant', 'Comptable 01', 'assistant.comptable01@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(15, 1, 23, 'Assistant', 'Comptable 02', 'assistant.comptable02@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(16, 1, 23, 'Assistant', 'Comptable 03', 'assistant.comptable03@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(17, 1, 23, 'Assistant', 'Comptable 04', 'assistant.comptable04@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(18, 1, 23, 'Assistant', 'Comptable 05', 'assistant.comptable05@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(19, 1, 23, 'Assistant', 'Comptable 06', 'assistant.comptable06@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(20, 1, 24, 'Trésorier', 'Principal', 'tresorier@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(21, 1, 30, 'Assistant', 'Trésorerie', 'assistant.tresorerie@satraco.local', '$2y$12$cJdNyM.8lFRgKL/eEEVAD.sB0HG5e3yrOWt8Oxteg278yTkAtk5q.', 'active', '2026-04-23 00:00:00'),
(22, 2, 2, 'Axcel', 'IRUTAVYOSE', 'axcel@satracoconstruction.com', '$2y$10$AQMpuyYcREZCMH8VAns/i.oIsm8e7ugD9eaQ/Fc0eSjI5NkeNoPdi', 'active', '2026-04-28 13:28:30'),
(23, 2, 14, 'David', 'EMERUSABE', 'david@satracoconstruction.com', '$2y$10$PLHXHcL69yCUQDlAoFAR2.RuaQcqv062go6co8ctEiprYIbh.ikJu', 'active', '2026-04-28 14:52:23'),
(24, 2, 3, 'Aldo Georges', 'NDAGIJE', 'aldo@satracoconstruction.com', '$2y$10$NFupAJyzP1h6QQ3xmbtfSuiBW2uz4JW4tCVFXHm5EQ7yp6vLKhyje', 'active', '2026-04-28 15:16:39'),
(25, 2, 7, 'Mariam', 'NDAGIJE', 'mariam@satracoconstruction.com', '$2y$10$KIHuRfBmWCoJGq8jStUMy.qNOel1wKXnn/fsehY4D0SxjhRcuAX5y', 'active', '2026-04-29 09:13:34'),
(26, 2, 4, 'Emmanuel (Dawe)', 'NIYIMUBONA', 'emmanuel@satracoconstruction.com', '$2y$10$92lVV9IZM8y5ySl6/X3fzeT3fQP2ItTHLPmeArFI2X.pVEvCSQDO6', 'active', '2026-04-29 09:15:10'),
(27, 2, 8, 'Serges', 'MANIRAGABA', 'serges@satracoconstruction.com', '$2y$10$4.nB6Kx69zd9KzBZrrZ7Wu15FyByfKyunosD1VhoLGNQPkZrwaj5W', 'active', '2026-04-29 09:18:02'),
(28, 2, 23, 'Emmanuel', 'NDUWAYO', 'emmanuelnduwayo@satracoconstruction.com', '$2y$10$W4JTT7TBIZu2FtAnuvbkfudKyCO1e7B/hpOH9SQuq4.10xvU9zpXq', 'active', '2026-04-29 09:19:42'),
(29, 2, 23, 'Severin', 'TUYISABE', 'severin@satracoconstruction.com', '$2y$10$TgwYqCWyEMenMPltlJanaOHm74TxSGOnUEsHLitEvYEn/C3CFSmsm', 'active', '2026-04-29 09:21:59'),
(30, 2, 21, 'Alexis', 'NKURUNZIZA', 'alexis@satracoconstruction.com', '$2y$10$IB37Zp7Qx3v2jf0xFK8GQelx/PHZXbWviIL7DH4iwvFeCcxl6PYrK', 'active', '2026-04-29 09:25:26'),
(31, 2, 20, 'Alpha Denard', 'IRAKOZE', 'alpha@satracoconstruction.com', '$2y$10$cKf6A43sOUozIvjCdLgLVOkkRuCf5KdOKIpc7yRPZBr.uV3QAaM16', 'active', '2026-04-29 09:28:12'),
(32, 2, 20, 'Kercy Merveille', 'DUSHIME', 'kercy@satracoconstruction.com', '$2y$10$8.vby3XCffYd43Ln7Cs5zOtQK8p5ohLgnjLN.BbpELWWM55i67hg2', 'active', '2026-04-29 09:29:47'),
(33, 2, 11, 'MALULU', 'NDEKO Norbert', 'malulu@satracoconstruction.com', '$2y$10$.v6wCnYY4YysQ7EK6IrcleNaowk3AiTuTNDjieoHp5pVFae.p2i9.', 'active', '2026-04-29 09:42:03'),
(34, 2, 20, 'Aime Orly', 'HEZAGIRA', 'orly@satracoconstruction.com', '$2y$10$d4odN3.uYwArYtqm5sTuZOHl3KM5CMmPPIqEeafzgMMAHNx9it1yG', 'active', '2026-04-29 09:42:44'),
(35, 2, 30, 'Nelly Ange', 'AHISHAKIYE', 'nelly@satracoconstruction.com', '$2y$10$kZ0ZXegTPGYDPSiaWZE50efj06.WaowzDia4GKntvdHLtfLsGkuAG', 'active', '2026-04-29 11:59:33'),
(36, 2, 31, 'Fabrice', 'NIBITANGA', 'fabrice@satracoconstruction.com', '$2y$10$R7UT418JK4lvkFuhoR6qEOC3AFaiC2dAsLnH14L9Q9KMgQUfn3x.C', 'active', '2026-04-29 12:08:22'),
(37, 2, 29, 'Michel', 'MANIRAKIZA', 'michel@satracoconstruction.com', '$2y$10$RrBcLoUPRfB7gjWh6x85nO97h6OzYPQY3Xa1bIV7AHQz8PwabndEi', 'active', '2026-04-29 15:30:14'),
(38, 2, 29, 'Anniella', 'HABONIMANA', 'anniella@satracoconstruction.com', '$2y$10$CAO9MZtxt9Sz5u5zdFviSO8wDJeBMkhrerNwwY65Lizf6jjhq3RPO', 'active', '2026-04-29 16:16:52'),
(39, 2, 28, 'Jean de Dieu', 'NIYONKURU', 'jeandedieu@satracoconstruction.com', '$2y$10$gt/nOSlI3jqwus4/5OatouaZtLqcwre7vdfG4Xd9YYCT4yZkLyjHq', 'active', '2026-05-06 08:39:02'),
(40, 2, 20, 'Gédéon', 'HABINGABWA', 'gedeon@satracoconstruction.com', '$2y$10$UB/GYvEJFHgXSaB7OUpbeudFmcuFM0IirCX0ouD4vxktAIVVCvkYS', 'active', '2026-05-06 09:08:49'),
(41, 2, 30, 'Jeannette', 'MOSES', 'jeannette@satracoconstruction.com', '$2y$10$yaEKg4D5CC/k6r/1yk5VGeBhH0qjacbPCqx/BAtWrz16xvuYYwa5e', 'active', '2026-05-06 10:56:14'),
(42, 2, 26, 'Kévin', 'NIRERA', 'kevin@satracoconstruction.com', '$2y$10$ylw9FWW0tRCVXbtxof0fA.flr0lViXcd9c8o6WmU38emJghxZ3H..', 'active', '2026-05-06 12:10:23'),
(43, 2, 23, 'Ramla', 'NAHIMANA', 'ramla@satracoconstuction.com', '$2y$10$dwWBfI/u53p5r.VcUkcNkOav1IrM7xicQTDv/D1QYm7UyKMfXfbyK', 'active', '2026-05-07 11:00:40'),
(44, 2, 29, 'Emmanuel(MWARABU)', 'NKORERIMANA', 'mwarabu@satracoconstruction.com', '$2y$10$ee5Cyi2eH9KewRnd65fQ1O3DD7d1kSXLmuNKCmJsQ2dIS0RsWuWjC', 'active', '2026-05-08 14:23:18'),
(45, 2, 19, 'Jacques', 'NIYITEGEKA', 'jacques@satracoconstruction.com', '$2y$10$EsXdv2KEn7xNFtvrOtpaGe1FJznWyAH72BYudtYU8R6DBWaqkDbjK', 'active', '2026-05-13 09:07:25'),
(46, 2, 30, 'Côme', 'NKESHIMANA', 'come@satracoconstruction.com', '$2y$10$an8GdZ2bN8VjceMr9EvqveeujvucCIKpI15fFntiYSOx464Lqa.pm', 'active', '2026-05-13 12:08:51'),
(47, 2, 32, 'Claude', 'IRAKOZE', 'claude@satracoconstruction.com', '$2y$10$AXrc1A9DNAcSIGt5Yr411.jnXEVEmbdal.H5ShW7Te5mOGCNnTweO', 'active', '2026-05-13 14:15:03'),
(48, 2, 15, 'Client', 'Chantier', 'client.chantier@satracoconstruction.com', '$2y$12$B2vnmTAt/H78uyR5.h4V2e1WY5dWYiw1uKnixGp/qlmisTZiLW/.6', 'active', '2026-05-14 00:00:00'),
(49, 2, 32, 'Olivier', 'NISHIMWE', 'olivier@satracoconstruction.com', '$2y$10$Wu81dL85uUTSIMQk3ZPaIeyUDaRskhPlCP8eawopeZZTL/UrSuHh6', 'active', '2026-05-19 14:18:59');

-- --------------------------------------------------------

--
-- Structure de la table `user_permission_overrides`
--

CREATE TABLE `user_permission_overrides` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_code` varchar(100) NOT NULL,
  `can_view` tinyint(1) NOT NULL DEFAULT 0,
  `can_create` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit` tinyint(1) NOT NULL DEFAULT 0,
  `can_delete` tinyint(1) NOT NULL DEFAULT 0,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_permission_overrides`
--

INSERT INTO `user_permission_overrides` (`id`, `user_id`, `module_code`, `can_view`, `can_create`, `can_edit`, `can_delete`, `updated_by`, `updated_at`) VALUES
(247, 36, 'dashboard', 1, 1, 0, 0, 22, '2026-05-06 08:09:32'),
(248, 36, 'notifications', 1, 1, 0, 0, 22, '2026-05-06 08:09:32'),
(249, 36, 'messages', 1, 1, 0, 0, 22, '2026-05-06 08:09:32'),
(250, 36, 'tasks', 1, 1, 0, 0, 22, '2026-05-06 08:09:32'),
(251, 36, 'projects', 1, 1, 0, 0, 22, '2026-05-06 08:09:32'),
(252, 36, 'chantiers', 1, 1, 0, 0, 22, '2026-05-06 08:09:32'),
(253, 36, 'purchase_requests', 1, 1, 1, 0, 22, '2026-05-06 08:09:32'),
(254, 36, 'achats', 1, 1, 1, 0, 22, '2026-05-06 08:09:32'),
(255, 36, 'fournisseurs', 1, 0, 0, 0, 22, '2026-05-06 08:09:32'),
(256, 36, 'sous_traitants', 1, 1, 1, 0, 22, '2026-05-06 08:09:32'),
(257, 36, 'production_journal', 1, 1, 0, 0, 22, '2026-05-06 08:09:32'),
(258, 36, 'production_control', 1, 1, 1, 0, 22, '2026-05-06 08:09:32'),
(259, 36, 'chantier_evaluation', 1, 1, 1, 0, 22, '2026-05-06 08:09:32'),
(260, 36, 'workforce', 1, 1, 1, 0, 22, '2026-05-06 08:09:32'),
(261, 36, 'crm', 1, 1, 0, 0, 22, '2026-05-06 08:09:32'),
(262, 36, 'clients', 1, 1, 0, 0, 22, '2026-05-06 08:09:32'),
(263, 36, 'devis', 1, 1, 1, 0, 22, '2026-05-06 08:09:32'),
(264, 36, 'contracts', 1, 1, 1, 0, 22, '2026-05-06 08:09:32'),
(291, 30, 'dashboard', 1, 0, 0, 0, 22, '2026-05-07 07:38:11'),
(292, 30, 'messages', 1, 1, 0, 0, 22, '2026-05-07 07:38:11'),
(293, 30, 'tasks', 1, 0, 0, 0, 22, '2026-05-07 07:38:11'),
(294, 30, 'projects', 1, 0, 0, 0, 22, '2026-05-07 07:38:11'),
(295, 30, 'chantiers', 1, 0, 0, 0, 22, '2026-05-07 07:38:11'),
(296, 30, 'documents', 1, 1, 0, 0, 22, '2026-05-07 07:38:11'),
(297, 30, 'clients', 1, 1, 1, 1, 22, '2026-05-07 07:38:11'),
(298, 30, 'devis', 1, 1, 1, 1, 22, '2026-05-07 07:38:11'),
(299, 30, 'plan_library', 1, 1, 1, 0, 22, '2026-05-07 07:38:11'),
(358, 25, 'dashboard', 1, 0, 0, 0, 22, '2026-05-11 08:22:36'),
(359, 25, 'reports', 1, 0, 0, 0, 22, '2026-05-11 08:22:36'),
(360, 25, 'validations', 1, 0, 1, 0, 22, '2026-05-11 08:22:36'),
(361, 25, 'notifications', 1, 0, 1, 0, 22, '2026-05-11 08:22:36'),
(362, 25, 'messages', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(363, 25, 'external_messages', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(364, 25, 'tasks', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(365, 25, 'audit', 1, 0, 0, 0, 22, '2026-05-11 08:22:36'),
(366, 25, 'direction_technique', 1, 1, 1, 1, 22, '2026-05-11 08:22:36'),
(367, 25, 'projects', 1, 1, 1, 1, 22, '2026-05-11 08:22:36'),
(368, 25, 'chantiers', 1, 1, 1, 1, 22, '2026-05-11 08:22:36'),
(369, 25, 'purchase_requests', 1, 1, 1, 1, 22, '2026-05-11 08:22:36'),
(370, 25, 'achats', 1, 1, 1, 1, 22, '2026-05-11 08:22:36'),
(371, 25, 'stocks', 1, 1, 1, 1, 22, '2026-05-11 08:22:36'),
(372, 25, 'daf', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(373, 25, 'accounting_capture', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(374, 25, 'finance', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(375, 25, 'invoices', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(376, 25, 'paie', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(377, 25, 'rh', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(378, 25, 'budgets', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(379, 25, 'profitability', 1, 0, 0, 0, 22, '2026-05-11 08:22:36'),
(380, 25, 'immobilisations', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(381, 25, 'assurances', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(382, 25, 'documents', 1, 1, 1, 0, 22, '2026-05-11 08:22:36'),
(383, 25, 'access_matrix', 1, 0, 0, 0, 22, '2026-05-11 08:22:36'),
(384, 25, 'users', 1, 0, 0, 0, 22, '2026-05-11 08:22:36'),
(385, 25, 'settings', 1, 0, 0, 0, 22, '2026-05-11 08:22:36'),
(397, 28, 'dashboard', 1, 0, 0, 0, 22, '2026-05-11 11:39:18'),
(398, 28, 'messages', 1, 1, 0, 0, 22, '2026-05-11 11:39:18'),
(399, 28, 'tasks', 1, 0, 1, 0, 22, '2026-05-11 11:39:18'),
(400, 28, 'purchase_requests', 1, 1, 1, 0, 22, '2026-05-11 11:39:18'),
(401, 28, 'achats', 1, 1, 1, 0, 22, '2026-05-11 11:39:18'),
(402, 28, 'accounting_capture', 1, 1, 1, 0, 22, '2026-05-11 11:39:18'),
(403, 28, 'invoices', 1, 1, 0, 0, 22, '2026-05-11 11:39:18'),
(404, 28, 'paie', 1, 1, 0, 0, 22, '2026-05-11 11:39:18'),
(405, 28, 'documents', 1, 1, 0, 0, 22, '2026-05-11 11:39:18'),
(406, 35, 'dashboard', 1, 0, 0, 0, 22, '2026-05-12 07:00:12'),
(407, 35, 'messages', 1, 1, 0, 0, 22, '2026-05-12 07:00:12'),
(408, 35, 'tasks', 1, 0, 1, 0, 22, '2026-05-12 07:00:12'),
(409, 35, 'purchase_requests', 1, 1, 1, 1, 22, '2026-05-12 07:00:12'),
(410, 35, 'achats', 1, 1, 1, 1, 22, '2026-05-12 07:00:12'),
(411, 35, 'accounting_capture', 1, 1, 1, 1, 22, '2026-05-12 07:00:12'),
(412, 35, 'finance', 1, 1, 1, 1, 22, '2026-05-12 07:00:12'),
(413, 35, 'invoices', 1, 1, 1, 1, 22, '2026-05-12 07:00:12'),
(414, 35, 'paie', 1, 1, 1, 1, 22, '2026-05-12 07:00:12'),
(415, 35, 'documents', 1, 1, 0, 0, 22, '2026-05-12 07:00:12'),
(516, 43, 'dashboard', 1, 0, 0, 0, 22, '2026-05-13 13:02:04'),
(517, 43, 'messages', 1, 1, 0, 0, 22, '2026-05-13 13:02:04'),
(518, 43, 'tasks', 1, 0, 1, 0, 22, '2026-05-13 13:02:04'),
(519, 43, 'purchase_requests', 1, 0, 0, 0, 22, '2026-05-13 13:02:04'),
(520, 43, 'achats', 1, 1, 1, 0, 22, '2026-05-13 13:02:04'),
(521, 43, 'chantier_evaluation', 1, 1, 1, 1, 22, '2026-05-13 13:02:04'),
(522, 43, 'workforce', 1, 1, 1, 1, 22, '2026-05-13 13:02:04'),
(523, 43, 'pointages', 1, 1, 1, 1, 22, '2026-05-13 13:02:04'),
(524, 43, 'accounting_capture', 1, 1, 0, 0, 22, '2026-05-13 13:02:04'),
(525, 43, 'invoices', 1, 1, 0, 0, 22, '2026-05-13 13:02:04'),
(526, 43, 'paie', 1, 1, 0, 0, 22, '2026-05-13 13:02:04'),
(527, 43, 'documents', 1, 1, 0, 0, 22, '2026-05-13 13:02:04'),
(528, 48, 'client_portal', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(529, 48, 'messages', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43'),
(530, 48, 'external_messages', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43'),
(534, 2, 'situation_encaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(535, 22, 'situation_encaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(536, 21, 'situation_encaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(537, 35, 'situation_encaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(540, 13, 'situation_encaissements', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43'),
(542, 3, 'situation_encaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(543, 24, 'situation_encaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(544, 12, 'situation_encaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(545, 25, 'situation_encaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(546, 20, 'situation_encaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(549, 2, 'situation_decaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(550, 22, 'situation_decaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(551, 21, 'situation_decaissements', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43'),
(552, 35, 'situation_decaissements', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43'),
(555, 13, 'situation_decaissements', 1, 1, 0, 0, NULL, '2026-05-14 14:38:43'),
(557, 3, 'situation_decaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(558, 24, 'situation_decaissements', 1, 0, 0, 0, NULL, '2026-05-14 14:38:43'),
(559, 12, 'situation_decaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(560, 25, 'situation_decaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(561, 20, 'situation_decaissements', 1, 1, 1, 0, NULL, '2026-05-14 14:38:43'),
(576, 38, 'dashboard', 1, 0, 0, 0, 22, '2026-05-15 07:03:18'),
(577, 38, 'notifications', 1, 0, 1, 0, 22, '2026-05-15 07:03:18'),
(578, 38, 'messages', 1, 1, 1, 0, 22, '2026-05-15 07:03:18'),
(579, 38, 'tasks', 1, 0, 1, 0, 22, '2026-05-15 07:03:18'),
(580, 38, 'purchase_requests', 1, 1, 1, 0, 22, '2026-05-15 07:03:18'),
(581, 38, 'achats', 1, 1, 0, 0, 22, '2026-05-15 07:03:18'),
(582, 38, 'fournisseurs', 1, 0, 0, 0, 22, '2026-05-15 07:03:18'),
(583, 38, 'stocks', 1, 0, 0, 0, 22, '2026-05-15 07:03:18'),
(584, 38, 'stock_transfers', 1, 0, 0, 0, 22, '2026-05-15 07:03:18'),
(597, 41, 'dashboard', 1, 0, 0, 0, 22, '2026-05-15 07:24:29'),
(598, 41, 'notifications', 1, 0, 1, 0, 22, '2026-05-15 07:24:29'),
(599, 41, 'messages', 1, 1, 1, 0, 22, '2026-05-15 07:24:29'),
(600, 41, 'tasks', 1, 0, 1, 0, 22, '2026-05-15 07:24:29'),
(601, 41, 'purchase_requests', 1, 1, 0, 0, 22, '2026-05-15 07:24:29'),
(602, 41, 'achats', 1, 1, 1, 0, 22, '2026-05-15 07:24:29'),
(603, 41, 'accounting_capture', 1, 1, 0, 0, 22, '2026-05-15 07:24:29'),
(604, 41, 'finance', 1, 1, 0, 0, 22, '2026-05-15 07:24:29'),
(605, 41, 'situation_encaissements', 1, 0, 0, 0, 22, '2026-05-15 07:24:29'),
(606, 41, 'situation_decaissements', 1, 1, 0, 0, 22, '2026-05-15 07:24:29'),
(607, 41, 'invoices', 1, 0, 0, 0, 22, '2026-05-15 07:24:29'),
(608, 41, 'documents', 1, 1, 0, 0, 22, '2026-05-15 07:24:29'),
(619, 39, 'dashboard', 1, 0, 0, 0, 22, '2026-05-15 09:02:22'),
(620, 39, 'reports', 1, 0, 0, 0, 22, '2026-05-15 09:02:22'),
(621, 39, 'notifications', 1, 0, 1, 0, 22, '2026-05-15 09:02:22'),
(622, 39, 'messages', 1, 1, 1, 0, 22, '2026-05-15 09:02:22'),
(623, 39, 'purchase_requests', 1, 1, 1, 0, 22, '2026-05-15 09:02:22'),
(624, 39, 'achats', 1, 1, 1, 0, 22, '2026-05-15 09:02:22'),
(625, 39, 'fournisseurs', 1, 0, 0, 0, 22, '2026-05-15 09:02:22'),
(626, 39, 'stocks', 1, 1, 1, 0, 22, '2026-05-15 09:02:22'),
(627, 39, 'stock_issues', 1, 1, 1, 0, 22, '2026-05-15 09:02:22'),
(628, 39, 'stock_transfers', 1, 1, 1, 0, 22, '2026-05-15 09:02:22'),
(629, 39, 'material_consumption', 1, 1, 1, 0, 22, '2026-05-15 09:02:22'),
(630, 39, 'fuel_logs', 1, 0, 0, 0, 22, '2026-05-15 09:02:22'),
(640, 37, 'dashboard', 1, 0, 0, 0, 22, '2026-05-15 11:34:43'),
(641, 37, 'notifications', 1, 0, 1, 0, 22, '2026-05-15 11:34:43'),
(642, 37, 'messages', 1, 1, 1, 0, 22, '2026-05-15 11:34:43'),
(643, 37, 'tasks', 1, 0, 1, 0, 22, '2026-05-15 11:34:43'),
(644, 37, 'purchase_requests', 1, 1, 0, 0, 22, '2026-05-15 11:34:43'),
(645, 37, 'achats', 1, 1, 1, 0, 22, '2026-05-15 11:34:43'),
(646, 37, 'fournisseurs', 1, 0, 0, 0, 22, '2026-05-15 11:34:43'),
(647, 37, 'stocks', 1, 0, 0, 0, 22, '2026-05-15 11:34:43'),
(648, 37, 'stock_transfers', 1, 0, 0, 0, 22, '2026-05-15 11:34:43'),
(659, 44, 'dashboard', 1, 0, 0, 0, 22, '2026-05-18 07:22:43'),
(660, 44, 'notifications', 1, 0, 1, 0, 22, '2026-05-18 07:22:43'),
(661, 44, 'messages', 1, 1, 1, 0, 22, '2026-05-18 07:22:43'),
(662, 44, 'tasks', 1, 0, 1, 0, 22, '2026-05-18 07:22:43'),
(663, 44, 'purchase_requests', 1, 0, 0, 0, 22, '2026-05-18 07:22:43'),
(664, 44, 'achats', 1, 1, 1, 0, 22, '2026-05-18 07:22:43'),
(665, 44, 'fournisseurs', 1, 1, 1, 0, 22, '2026-05-18 07:22:43'),
(666, 44, 'stocks', 1, 0, 0, 0, 22, '2026-05-18 07:22:43'),
(667, 44, 'stock_transfers', 1, 0, 0, 0, 22, '2026-05-18 07:22:43'),
(668, 44, 'workforce', 1, 1, 1, 1, 22, '2026-05-18 07:22:43'),
(669, 29, 'dashboard', 1, 0, 0, 0, 22, '2026-05-19 09:40:36'),
(670, 29, 'notifications', 1, 0, 1, 0, 22, '2026-05-19 09:40:36'),
(671, 29, 'messages', 1, 1, 1, 0, 22, '2026-05-19 09:40:36'),
(672, 29, 'tasks', 1, 0, 1, 0, 22, '2026-05-19 09:40:36'),
(673, 29, 'purchase_requests', 1, 0, 0, 0, 22, '2026-05-19 09:40:36'),
(674, 29, 'achats', 1, 1, 1, 0, 22, '2026-05-19 09:40:36'),
(675, 29, 'fournisseurs', 1, 0, 0, 0, 22, '2026-05-19 09:40:36'),
(676, 29, 'accounting_capture', 1, 1, 1, 0, 22, '2026-05-19 09:40:36'),
(677, 29, 'invoices', 1, 1, 0, 0, 22, '2026-05-19 09:40:36'),
(678, 29, 'paie', 1, 1, 0, 0, 22, '2026-05-19 09:40:36'),
(679, 29, 'documents', 1, 1, 0, 0, 22, '2026-05-19 09:40:36'),
(680, 27, 'dashboard', 1, 0, 0, 0, 22, '2026-05-19 14:14:11'),
(681, 27, 'reports', 1, 0, 0, 0, 22, '2026-05-19 14:14:11'),
(682, 27, 'notifications', 1, 0, 1, 0, 22, '2026-05-19 14:14:11'),
(683, 27, 'messages', 1, 1, 1, 0, 22, '2026-05-19 14:14:11'),
(684, 27, 'tasks', 1, 0, 1, 0, 22, '2026-05-19 14:14:11'),
(685, 27, 'purchase_requests', 1, 1, 1, 0, 22, '2026-05-19 14:14:11'),
(686, 27, 'achats', 1, 1, 1, 0, 22, '2026-05-19 14:14:11'),
(687, 27, 'daf', 1, 0, 0, 0, 22, '2026-05-19 14:14:11'),
(688, 27, 'accounting_capture', 1, 1, 1, 0, 22, '2026-05-19 14:14:11'),
(689, 27, 'finance', 1, 0, 0, 0, 22, '2026-05-19 14:14:11'),
(690, 27, 'situation_encaissements', 1, 1, 0, 0, 22, '2026-05-19 14:14:11'),
(691, 27, 'situation_decaissements', 1, 1, 0, 0, 22, '2026-05-19 14:14:11'),
(692, 27, 'invoices', 1, 1, 1, 0, 22, '2026-05-19 14:14:11'),
(693, 27, 'paie', 1, 0, 0, 0, 22, '2026-05-19 14:14:11'),
(694, 27, 'budgets', 1, 0, 0, 0, 22, '2026-05-19 14:14:11'),
(695, 27, 'documents', 1, 1, 0, 0, 22, '2026-05-19 14:14:11'),
(696, 46, 'dashboard', 1, 0, 0, 0, 22, '2026-05-20 07:24:59'),
(697, 46, 'notifications', 1, 0, 1, 0, 22, '2026-05-20 07:24:59'),
(698, 46, 'messages', 1, 1, 1, 0, 22, '2026-05-20 07:24:59'),
(699, 46, 'tasks', 1, 0, 1, 0, 22, '2026-05-20 07:24:59'),
(700, 46, 'purchase_requests', 1, 1, 0, 0, 22, '2026-05-20 07:24:59'),
(701, 46, 'achats', 1, 1, 1, 1, 22, '2026-05-20 07:24:59'),
(702, 46, 'daf', 1, 1, 1, 1, 22, '2026-05-20 07:24:59'),
(703, 46, 'accounting_capture', 1, 1, 1, 1, 22, '2026-05-20 07:24:59'),
(704, 46, 'finance', 1, 1, 1, 1, 22, '2026-05-20 07:24:59'),
(705, 46, 'situation_encaissements', 1, 1, 1, 1, 22, '2026-05-20 07:24:59'),
(706, 46, 'situation_decaissements', 1, 1, 0, 0, 22, '2026-05-20 07:24:59'),
(707, 46, 'invoices', 1, 0, 0, 0, 22, '2026-05-20 07:24:59'),
(708, 46, 'documents', 1, 1, 0, 0, 22, '2026-05-20 07:24:59'),
(709, 45, 'dashboard', 1, 0, 0, 0, 22, '2026-05-26 08:19:57'),
(710, 45, 'notifications', 1, 0, 1, 0, 22, '2026-05-26 08:19:57'),
(711, 45, 'messages', 1, 1, 1, 0, 22, '2026-05-26 08:19:57'),
(712, 45, 'purchase_requests', 1, 1, 1, 0, 22, '2026-05-26 08:19:57'),
(713, 45, 'achats', 1, 1, 1, 0, 22, '2026-05-26 08:19:57'),
(714, 45, 'fournisseurs', 1, 1, 0, 0, 22, '2026-05-26 08:19:57'),
(715, 45, 'engins', 1, 0, 0, 0, 22, '2026-05-26 08:19:57'),
(716, 45, 'maintenance', 1, 0, 0, 0, 22, '2026-05-26 08:19:57'),
(717, 45, 'immobilisations', 1, 1, 1, 0, 22, '2026-05-26 08:19:57'),
(718, 45, 'assurances', 1, 1, 1, 0, 22, '2026-05-26 08:19:57'),
(719, 47, 'dashboard', 1, 0, 0, 0, 22, '2026-05-28 06:52:35'),
(720, 47, 'notifications', 1, 0, 1, 0, 22, '2026-05-28 06:52:35'),
(721, 47, 'messages', 1, 1, 1, 0, 22, '2026-05-28 06:52:35'),
(722, 47, 'external_messages', 1, 1, 0, 0, 22, '2026-05-28 06:52:35'),
(723, 47, 'purchase_requests', 1, 1, 1, 0, 22, '2026-05-28 06:52:35'),
(724, 47, 'achats', 1, 0, 0, 0, 22, '2026-05-28 06:52:35'),
(725, 47, 'crm', 1, 1, 1, 0, 22, '2026-05-28 06:52:35'),
(726, 47, 'clients', 1, 1, 0, 0, 22, '2026-05-28 06:52:35'),
(727, 47, 'devis', 1, 1, 0, 0, 22, '2026-05-28 06:52:35'),
(728, 47, 'plan_library', 1, 1, 1, 0, 22, '2026-05-28 06:52:35'),
(749, 49, 'notifications', 1, 0, 1, 0, 22, '2026-05-28 08:25:29'),
(750, 49, 'messages', 1, 1, 1, 0, 22, '2026-05-28 08:25:29'),
(751, 49, 'purchase_requests', 1, 1, 1, 0, 22, '2026-05-28 08:25:29'),
(752, 49, 'achats', 1, 1, 1, 0, 22, '2026-05-28 08:25:29'),
(753, 49, 'crm', 1, 1, 1, 0, 22, '2026-05-28 08:25:29'),
(754, 49, 'clients', 1, 1, 0, 0, 22, '2026-05-28 08:25:29'),
(755, 49, 'devis', 1, 1, 0, 0, 22, '2026-05-28 08:25:29'),
(756, 49, 'plan_library', 1, 1, 1, 0, 22, '2026-05-28 08:25:29'),
(757, 23, 'dashboard', 1, 0, 0, 0, 22, '2026-05-28 10:17:54'),
(758, 23, 'direction_generale', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(759, 23, 'validations', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(760, 23, 'notifications', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(761, 23, 'messages', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(762, 23, 'external_messages', 1, 0, 0, 0, 22, '2026-05-28 10:17:54'),
(763, 23, 'tasks', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(764, 23, 'direction_technique', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(765, 23, 'projects', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(766, 23, 'chantiers', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(767, 23, 'purchase_requests', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(768, 23, 'achats', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(769, 23, 'fournisseurs', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(770, 23, 'sous_traitants', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(771, 23, 'stocks', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(772, 23, 'stock_issues', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(773, 23, 'stock_transfers', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(774, 23, 'material_consumption', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(775, 23, 'engins', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(776, 23, 'maintenance', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(777, 23, 'fuel_logs', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(778, 23, 'production_journal', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(779, 23, 'production_control', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(780, 23, 'chantier_evaluation', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(781, 23, 'workforce', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(782, 23, 'pointages', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(783, 23, 'service_orders', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(784, 23, 'finance', 1, 1, 1, 0, 22, '2026-05-28 10:17:54'),
(785, 23, 'invoices', 1, 1, 0, 0, 22, '2026-05-28 10:17:54'),
(786, 23, 'paie', 1, 1, 1, 0, 22, '2026-05-28 10:17:54'),
(787, 23, 'rh', 1, 1, 1, 0, 22, '2026-05-28 10:17:54'),
(788, 23, 'profitability', 1, 1, 1, 0, 22, '2026-05-28 10:17:54'),
(789, 23, 'immobilisations', 1, 1, 1, 0, 22, '2026-05-28 10:17:54'),
(790, 23, 'documents', 1, 1, 0, 0, 22, '2026-05-28 10:17:54'),
(791, 23, 'crm', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(792, 23, 'clients', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(793, 23, 'devis', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(794, 23, 'contracts', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(795, 23, 'situations', 1, 1, 1, 1, 22, '2026-05-28 10:17:54'),
(796, 23, 'plan_library', 1, 1, 1, 1, 22, '2026-05-28 10:17:54');

-- --------------------------------------------------------

--
-- Structure de la table `weekly_payroll_lists`
--

CREATE TABLE `weekly_payroll_lists` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `week_label` varchar(80) NOT NULL,
  `list_type` varchar(80) NOT NULL DEFAULT 'Journaliers',
  `prepared_by` varchar(191) DEFAULT NULL,
  `transmission_day` varchar(40) DEFAULT NULL,
  `validation_dt` varchar(40) NOT NULL DEFAULT 'En attente',
  `validation_daf` varchar(40) NOT NULL DEFAULT 'En attente',
  `payment_status` varchar(40) NOT NULL DEFAULT 'Préparation',
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `weekly_payroll_lists`
--

INSERT INTO `weekly_payroll_lists` (`id`, `company_id`, `chantier_id`, `week_label`, `list_type`, `prepared_by`, `transmission_day`, `validation_dt`, `validation_daf`, `payment_status`, `total_amount`, `notes`, `created_at`) VALUES
(7, 2, 18, 'semaine du 13/05/2026', 'Journaliers', 'NIYIMBONA Emmanuel', 'Mercredi', 'En attente', 'En attente', 'Préparation', 170000.00, '', '2026-05-13 15:27:17');

-- --------------------------------------------------------

--
-- Structure de la table `workflow_validations`
--

CREATE TABLE `workflow_validations` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `module_name` varchar(80) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `entity_ref` varchar(120) DEFAULT NULL,
  `validation_step` int(11) NOT NULL DEFAULT 1,
  `validator_role_code` varchar(80) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'en_attente',
  `comments` text DEFAULT NULL,
  `validated_by_user_id` int(11) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `workflow_validations`
--

INSERT INTO `workflow_validations` (`id`, `company_id`, `module_name`, `entity_id`, `entity_ref`, `validation_step`, `validator_role_code`, `status`, `comments`, `validated_by_user_id`, `validated_at`, `created_at`) VALUES
(1, 2, 'purchase_requests', 1, 'Mastic de fer', 1, 'CHEF_CHANTIER', 'en_attente', NULL, NULL, NULL, '2026-05-06 13:34:25'),
(2, 2, 'purchase_requests', 1, 'Mastic de fer', 2, 'RESPONSABLE_ACHATS', 'en_attente', NULL, NULL, NULL, '2026-05-06 13:34:25'),
(3, 2, 'purchase_requests', 1, 'Mastic de fer', 3, 'RESPONSABLE_ADMIN_FINANCIER', 'en_attente', NULL, NULL, NULL, '2026-05-06 13:34:25'),
(4, 2, 'purchase_requests', 1, 'Mastic de fer', 4, 'DIRECTEUR_GENERAL', 'en_attente', NULL, NULL, NULL, '2026-05-06 13:34:25'),
(5, 2, 'purchase_requests', 3, 'Granulats', 1, 'CHEF_CHANTIER', 'en_attente', NULL, NULL, NULL, '2026-05-06 13:42:37'),
(6, 2, 'purchase_requests', 3, 'Granulats', 2, 'RESPONSABLE_ACHATS', 'en_attente', NULL, NULL, NULL, '2026-05-06 13:42:37'),
(7, 2, 'purchase_requests', 3, 'Granulats', 3, 'RESPONSABLE_ADMIN_FINANCIER', 'en_attente', NULL, NULL, NULL, '2026-05-06 13:42:37'),
(8, 2, 'purchase_requests', 3, 'Granulats', 4, 'DIRECTEUR_GENERAL', 'en_attente', NULL, NULL, NULL, '2026-05-06 13:42:37');

-- --------------------------------------------------------

--
-- Structure de la table `workforce_contracts`
--

CREATE TABLE `workforce_contracts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `chantier_id` int(11) DEFAULT NULL,
  `worker_name` varchar(191) NOT NULL,
  `worker_type` varchar(80) NOT NULL DEFAULT 'Journalier',
  `function_name` varchar(120) DEFAULT NULL,
  `contact_phone` varchar(60) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `pay_mode` varchar(80) NOT NULL DEFAULT 'hebdomadaire',
  `unit_rate` decimal(15,2) NOT NULL DEFAULT 0.00,
  `contract_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status_label` varchar(60) NOT NULL DEFAULT 'actif',
  `approved_by_dt` tinyint(1) NOT NULL DEFAULT 0,
  `approved_by_daf` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `workforce_contracts`
--

INSERT INTO `workforce_contracts` (`id`, `company_id`, `chantier_id`, `worker_name`, `worker_type`, `function_name`, `contact_phone`, `start_date`, `end_date`, `pay_mode`, `unit_rate`, `contract_amount`, `status_label`, `approved_by_dt`, `approved_by_daf`, `notes`, `created_at`) VALUES
(1, 2, 3, 'NDACAYISABA Morice', 'Chef de chantier', 'Suivis', '69532121', '2026-05-03', '2026-05-07', 'hebdomadaire', 125000.00, 500000.00, 'actif', 1, 1, '', '2026-05-07 11:56:46'),
(2, 2, 3, 'Joachin', 'Manœuvre', 'Gardien', '', '2026-05-03', '2026-05-07', 'hebdomadaire', 20000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 11:58:51'),
(3, 2, 3, 'HATUNGIMANA Vincent', 'Tâcheron', 'Mancon', '', '2026-05-03', '2026-05-07', 'mensuel', 1000000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 12:00:37'),
(4, 2, 3, 'NIBIZI Desire', 'Tâcheron', 'Mancon', '', '2026-05-03', '2026-05-07', 'hebdomadaire', 1500000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 12:01:49'),
(5, 2, 3, 'Joachin', 'Journalier', 'Arrosage', '', '2026-05-03', '2026-05-07', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 12:02:51'),
(6, 2, 12, 'NIRERA Kevin', 'Tâcheron', 'elevation mur d accrotere', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 900000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 12:25:03'),
(7, 2, 13, 'NITUNGA Eliachim', 'Journalier', 'suivi des travaux', '69663065', '2026-05-01', '2026-05-07', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 13:04:58'),
(8, 2, 13, 'NZAMBIMANA Jeanine', 'Journalier', 'proprete', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 13:19:28'),
(9, 2, 13, 'NKURUNZIZA Pascal', 'Journalier', 'plafonnage', '', '2026-05-01', '2026-05-07', 'à la tâche', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 13:21:30'),
(10, 2, 13, 'NSHIMIRIMANA Aaron', 'Journalier', 'jardinnage', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 13:22:31'),
(11, 2, 13, 'NKENGURUTSE Gahetan', 'Manœuvre', 'ration du gardien', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 13:23:48'),
(12, 2, 1, 'NSENGIYUMVA Eric', 'Chef de chantier', 'suivi des travaux', '61426386', '2026-05-01', '2026-05-07', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 13:27:35'),
(13, 2, 1, 'KENEZA Gretta', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 0, 0, '', '2026-05-07 13:28:38'),
(14, 2, 1, 'NDUWAYEZU Eric', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:10:57'),
(15, 2, 1, 'NZOKURISHAKA Emmanuel', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:12:07'),
(16, 2, 1, 'IBANEZEREYE Bosco', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:13:11'),
(17, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'maçonnerie apparente et betonage', '', '2026-05-01', '2026-05-07', 'à la tâche', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:15:02'),
(18, 2, 1, 'NSENGIYUMVA Eric', 'Manœuvre', 'dechargement du ciment', '', '2026-05-01', '2026-05-07', 'à la tâche', 35000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:18:43'),
(19, 2, 1, 'TUYISENGE Dieudonnée', 'Journalier', 'gutarura igikwa', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:19:48'),
(20, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'rejointellage des murs exterieur et interieur', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 2300000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:21:01'),
(21, 2, 1, 'HABONIMANA Moise', 'Tâcheron', 'charpente metallique et couverture', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:22:09'),
(22, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des elements porteurs interieurs', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 1800000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:23:17'),
(23, 2, 1, 'TUYISENGE Dieudonnée', 'Tâcheron', 'decoffrage de la dalle', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:24:55'),
(24, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des claustrats', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 700000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:25:52'),
(25, 2, 14, 'MANIRAMBONA Victor', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:30:29'),
(26, 2, 14, 'NAHIMANA Bélyse', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:31:17'),
(27, 2, 14, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'pose des tuiles sur la cloture', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:46:31'),
(28, 2, 14, 'KWIZERA Simeon', 'Tâcheron', 'application du wall master et masticage', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:47:57'),
(29, 2, 14, 'NSAVYIMANA Edouard', 'Journalier', 'achat du cadenat pur huisseri du stock annexe', '', NULL, NULL, 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:52:34'),
(30, 2, 14, 'NSAVYIMANA Edouard', 'Journalier', 'Frais du cahier de menage', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:55:17'),
(31, 2, 14, 'NTAHOMPAGAZE', 'Journalier', 'ration du gardien', '', '2026-05-01', '2026-05-01', 'hebdomadaire', 20000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:56:50'),
(32, 2, 14, 'MANIRANKUNDA Victor', 'Journalier', 'ration du gardien', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 20000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 14:57:38'),
(33, 2, 4, 'Fabien', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 90000.00, 0.00, 'actif', 0, 0, '', '2026-05-07 15:02:02'),
(34, 2, 4, 'IRANGABIYE Adam', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:02:39'),
(35, 2, 4, 'BITANGIMANA Isidore', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:03:35'),
(36, 2, 4, 'HABIMANA Gerard', 'Journalier', 'operateur', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:04:26'),
(37, 2, 4, 'NDUWIMANA Claude', 'Tâcheron', 'maçon', '', '2026-05-01', '2026-05-07', 'à la tâche', 3000000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:05:40'),
(38, 2, 4, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'maçonnerie en brique et betonnage des colonnes/cloture', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:06:45'),
(39, 2, 4, 'KWIZERA Simeon', 'Tâcheron', 'peintre', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:07:29'),
(40, 2, 4, 'NDIHOKUBWAYO Michel', 'Journalier', 'suivi des travaux', '69679798', '2026-05-01', '2026-05-07', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:10:28'),
(41, 2, 15, 'BARUMWETE Simon', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:18:49'),
(42, 2, 15, 'IRADUKUNDA Richard', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:19:54'),
(43, 2, 15, 'NSHIMIRIMANA Annonciate', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:20:41'),
(44, 2, 15, 'HABONIMANA Moise', 'Tâcheron', 'soudure', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:21:59'),
(45, 2, 15, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricité', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:23:07'),
(46, 2, 10, 'NDAYIZEYE Janvier', 'Chef de chantier', 'suivi des travaux et frais de deplacement', '68993981', '2026-05-01', '2026-05-07', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:26:26'),
(47, 2, 10, 'NIJIMBERE Lin', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:31:50'),
(48, 2, 10, 'NKURUNZIZA Jean', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:32:49'),
(49, 2, 10, 'BARENGAYABO Joseph', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:33:26'),
(50, 2, 10, 'NIBITANGA Djalia', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:34:25'),
(51, 2, 10, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'Enduit fosse septique', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:35:31'),
(52, 2, 10, 'NDAYISABA J Marie', 'Manœuvre', 'deplacement du sable', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:36:34'),
(53, 2, 10, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:37:34'),
(54, 2, 5, 'HABONIMANA Richard', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:40:52'),
(55, 2, 5, 'KWIZERA Simeon', 'Journalier', 'peintre', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:44:03'),
(56, 2, 7, 'HATUNGIMANA Vincent', 'Tâcheron', '', '', '2026-05-01', '2026-05-07', 'à la tâche', 2900000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:47:48'),
(57, 2, 7, 'TUYISENGE Dieudonnée', 'Tâcheron', 'coffrage', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 900000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:48:41'),
(58, 2, 7, 'NDABARUSHIMANA J de Dieu', 'Tâcheron', 'feraillage', '', '2026-05-01', '2026-05-07', 'à la tâche', 1400000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:49:42'),
(59, 2, 7, 'NSAVYIMANA Edouard', 'Journalier', 'Topographe', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:51:31'),
(60, 2, 7, 'KUBWAYO Dionisie', 'Chef de chantier', 'suivi des travaux', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:53:07'),
(61, 2, 7, 'NDAYISHIMIYE Jodacin', 'Tâcheron', 'demolition fosse septique', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 180000.00, 0.00, 'actif', 0, 0, '', '2026-05-07 15:58:22'),
(62, 2, 7, 'NDUWIMANA J Marie', 'Journalier', 'supervision', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 185000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 15:59:08'),
(63, 2, 7, 'UWIZEYIMANA Emelyne', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:03:11'),
(64, 2, 7, 'MANIRAKIZA Isaac', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:04:00'),
(65, 2, 7, 'IRAKOZE Cedrick', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 25000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:04:41'),
(66, 2, 7, 'NYANDWI Janvier', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:18:33'),
(67, 2, 7, 'MPAWENAYO Yvonne', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:20:01'),
(68, 2, 7, 'NTIRENGANYA Romeo', 'Journalier', 'Aide maçon', '', NULL, NULL, 'hebdomadaire', 12000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:20:36'),
(69, 2, 7, 'NKUNZIMANA Floride', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:21:22'),
(70, 2, 7, 'NSHEMEZIMNA Jeanine', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:21:56'),
(71, 2, 7, 'NSHEMEZIMANA Patricia', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:22:41'),
(72, 2, 17, 'Francois', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:23:44'),
(73, 2, 17, 'Venuste', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:24:20'),
(74, 2, 17, 'Fiston', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:24:49'),
(75, 2, 7, 'Christian', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:25:29'),
(76, 2, 17, 'Benjamin', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:26:02'),
(77, 2, 17, 'Fleury', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:26:33'),
(78, 2, 17, 'vital', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:28:45'),
(79, 2, 17, 'gaspard', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:29:15'),
(80, 2, 17, 'Thierry', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:29:47'),
(81, 2, 17, 'Richard', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:30:17'),
(82, 2, 17, 'Vianney', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:31:06'),
(83, 2, 17, 'Godefroid', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:31:40'),
(84, 2, 17, 'olivier', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:32:10'),
(85, 2, 17, 'wilson', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:32:42'),
(86, 2, 17, 'ange', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:33:14'),
(88, 2, 17, 'Patrick', 'Journalier', 'Plafonage', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:34:47'),
(89, 2, 16, 'MUNEZERO Claude', 'Chef de chantier', 'suivi des travaux', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:35:47'),
(90, 2, 16, 'NSAVYIMANA Emmanuel', 'Tâcheron', '', '', NULL, NULL, 'à la tâche', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:36:31'),
(91, 2, 16, 'NSAVYIMANA Emmanuel', 'Tâcheron', '', '', '2026-05-01', '2026-05-07', 'à la tâche', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:37:09'),
(92, 2, 16, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 270000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:37:58'),
(93, 2, 16, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'location machine', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:39:13'),
(94, 2, 16, 'NSHIMIRIMANA  Eric', 'Journalier', 'Arrosage', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 18000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:39:56'),
(95, 2, 16, 'KWIZERA Vedaste', 'Tâcheron', 'electricien', '', '2026-05-01', '2026-05-07', 'à la tâche', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:40:40'),
(96, 2, 16, 'MUNEZERO Claude', 'Manœuvre', 'achat d eletricité', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 70000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:41:27'),
(97, 2, 16, 'HAVYARIMANA Fabrice', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:42:12'),
(98, 2, 16, 'NGENDAKUMANA Eric', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:42:42'),
(99, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Aide maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:43:19'),
(100, 2, 16, 'BIGIRIMANA Methode', 'Journalier', 'maçon', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:45:47'),
(101, 2, 16, 'HABONIMANA Moise', 'Tâcheron', 'soudure', '', '2026-05-01', '2026-05-07', 'à la tâche', 350000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 16:54:35'),
(102, 2, 7, 'NIBITANGA Fabrice', 'Manœuvre', 'Les rapports hebdomadaire', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-05-07 17:17:42'),
(104, 2, 4, 'HABONIMANA Moise', 'Tâcheron', 'soudure', '', '2026-05-01', '2026-05-07', 'à la tâche', 450000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:11:19'),
(105, 2, 14, 'HABONIMANA Moise', 'Tâcheron', 'soudure', '', '2026-05-01', '2026-05-07', 'à la tâche', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:12:20'),
(106, 2, 12, 'NIYINDAMUTSA Adelin', 'Tâcheron', 'pose de descente', '', '2026-05-01', '2026-05-07', 'à la tâche', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:14:55'),
(107, 2, 16, 'NIYINDAMUTSA Adelin', 'Tâcheron', 'Alimentation SDB', '', '2026-05-01', '2026-05-07', 'à la tâche', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:16:05'),
(108, 2, 13, 'NSHIMIRIMANA Aaron', 'Journalier', 'achat des fleurs et gazons', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 210000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:19:54'),
(109, 2, 5, 'EMERUSABE David', 'Manœuvre', 'suivi des travaux', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:22:59'),
(110, 2, 7, 'NIBITANGA Fabrice', 'Manœuvre', 'suivi des travaux', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:23:40'),
(111, 2, 11, 'NDACAYISABA Maurice', 'Manœuvre', 'Gardien', '', '2026-05-01', '2026-05-07', 'mensuel', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:28:48'),
(112, 2, 1, 'NDABARUSHIMANA J de Dieu', 'Manœuvre', 'Gardien', '', '2026-05-01', '2026-05-07', 'mensuel', 120000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:30:22'),
(113, 2, 16, 'Bernardo', 'Journalier', 'pierre taillé', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 1500000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:32:30'),
(116, 2, 13, 'NKURUNZIZA Pascal', 'Manœuvre', 'plafonnier', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:43:53'),
(119, 2, 2, 'Claude', 'Chef de chantier', 'suivi des travaux', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:46:53'),
(120, 2, 2, 'TUYISENGE Dieudonné', 'Tâcheron', 'decoffrage', '', '2026-05-01', '2026-05-07', 'à la tâche', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:48:21'),
(121, 2, 2, 'Appolinnaire', 'Journalier', 'securité', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:49:11'),
(122, 2, 2, 'Jean claude', 'Journalier', 'ramasse des perches d une echaffaudage', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:50:26'),
(123, 2, 2, 'Claude', 'Journalier', 'location des marteaux masse', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:51:11'),
(124, 2, 13, 'NDARUBAYEMWO Willerme', 'Manœuvre', 'pavage', '', '2026-05-01', '2026-05-07', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-05-08 09:51:50'),
(125, 2, 18, 'Esaie NIYOBUSHOBOZI', 'Manœuvre', 'Mecanicien', '', '2026-05-13', '2026-05-13', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-13 15:24:47'),
(126, 2, 18, 'Esaie NIYOBUSHOBOZI', 'Manœuvre', 'Mecanicien', '', '2026-05-13', '2026-05-13', 'hebdomadaire', 70000.00, 0.00, 'actif', 1, 1, '', '2026-05-13 15:25:21'),
(127, 2, 7, 'MANIRAKIZA Isaac', 'Journalier', 'maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:42:07'),
(128, 2, 7, 'NYANDWI Janvier', 'Journalier', 'maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:43:33'),
(129, 2, 7, 'KWIZERIMANA Emelyne', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:45:02'),
(130, 2, 7, 'KWIZERIMANA Jean', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 12000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:45:38'),
(131, 2, 16, 'MUNEZERO Claude', 'Chef de chantier', 'suivi des travaux', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:46:26'),
(132, 2, 16, 'BIGIRIMANA Methode', 'Journalier', 'maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:47:08'),
(133, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:47:38'),
(134, 2, 16, 'HAVYARIMANA Fabrice', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:48:03'),
(135, 2, 16, 'NGENDAKUMANA Eric', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:48:43'),
(136, 2, 16, 'NSHIMIRIMANA Dismas', 'Journalier', 'location machine pour couper les carreaux', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:49:46'),
(137, 2, 5, 'NSHIMIRIMANA Dismas', 'Journalier', 'maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:50:19'),
(138, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Arrosage', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 18000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:51:23'),
(139, 2, 16, 'IRAKOZE Lyse', 'Journalier', 'ration du magasinnier', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:52:11'),
(140, 2, 16, 'Bernardo', 'Manœuvre', 'pierre taillé', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 1500000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:53:07'),
(141, 2, 19, 'UWIZIGIYE Violette', 'Journalier', 'deplacement du moellons de carriere', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-14 16:57:39'),
(142, 2, 4, 'NDAYISHIMIYE Yvan', 'Tâcheron', 'electricien', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 08:50:22'),
(143, 2, 10, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 08:51:01'),
(144, 2, 15, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 08:51:49'),
(145, 2, 13, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 08:52:30'),
(146, 2, 1, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 08:53:39'),
(147, 2, 14, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 08:54:31'),
(148, 2, 18, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien/CIBITOKE', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 08:55:09'),
(149, 2, 7, 'NIBITANGA Fabrice', 'Manœuvre', 'suivi des travaux', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 08:55:53'),
(150, 2, 14, 'EMERUSABE David', 'Manœuvre', 'suivi des travaux', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 08:56:23'),
(151, 2, 20, 'NTEZIRYAYO Firmin', 'Manœuvre', 'ration du gardien/2 weeks', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 08:57:00'),
(152, 2, 18, 'moise', 'Journalier', 'fabrication table vibrante', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 1500000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 09:17:13'),
(153, 2, 16, 'NSAVYIMANA Emmanuel', 'Tâcheron', '', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 10:49:00'),
(154, 2, 16, 'NSAVYIMANA Emmanuel', 'Tâcheron', 'annexe et controle', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 1000000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 10:49:38'),
(155, 2, 16, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 10:50:29'),
(156, 2, 16, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 1000000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 10:51:01'),
(157, 2, 7, 'KWIZERA Vedaste', 'Tâcheron', 'electricien', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 10:51:36'),
(158, 2, 16, 'HABONIMANA Moise', 'Tâcheron', 'soudure', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 10:52:03'),
(159, 2, 16, 'NIYINDAMUTSA Adelin', 'Tâcheron', 'Alimentation dans les salles de bain', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 10:53:24'),
(160, 2, 18, 'NSAVYIMANA Emmanuel', 'Manœuvre', 'ach vibreuse', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 1000000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 10:54:31'),
(161, 2, 7, 'NDABARUSHIMAN J de Dieu', 'Tâcheron', 'feraillage', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 1000000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:05:40'),
(162, 2, 7, 'NIYONKURU Chadrack', 'Manœuvre', 'carrelage', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 296000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:06:23'),
(163, 2, 7, 'KUBWAYO Dionisie', 'Chef de chantier', 'suivi des travaux', '', '2026-05-08', NULL, 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:07:23'),
(164, 2, 7, 'HATUNGIMANA Vincent', 'Tâcheron', 'annexe cloture,crepissage 1er couche', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 1000000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:07:58'),
(165, 2, 7, 'NDUWIMANA J Marie', 'Chef de chantier', 'supervision', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 185000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:09:07'),
(166, 2, 7, 'TUYISENGE Dieudonnée', 'Tâcheron', 'charpentier', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 800000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:10:05'),
(167, 2, 7, 'IRAKOZE Cedrick', 'Manœuvre', 'dechargement perches,madriers,ciment 2fois', '', NULL, NULL, 'hebdomadaire', 83000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:10:44'),
(168, 2, 7, 'NKUNZIMANA Floride', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:13:25'),
(169, 2, 7, 'MPAWENAYO Yvonne', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 0.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:14:27'),
(170, 2, 7, 'MPWENAYO Yvonne', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:15:07'),
(171, 2, 7, 'NSHEMEZIMNA Jeanine', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:15:48'),
(172, 2, 7, 'NSHIMIRIMANA Patricia', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:16:19'),
(173, 2, 7, 'KAMIKAZI Samia', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 12000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:17:06'),
(174, 2, 3, 'NDACAYISABA Maurice', 'Chef de chantier', 'suivi des travaux', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 225000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:18:17'),
(175, 2, 3, 'NDAYIZEYE Désire', 'Tâcheron', '', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 1200000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:19:08'),
(176, 2, 3, 'NDACAYISABA Maurice', 'Journalier', 'Arrosage', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:19:49'),
(177, 2, 3, 'NDACAYISABA Maurice', 'Journalier', 'deplacement du ciment', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 12000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:20:24'),
(178, 2, 13, 'KWIZERA Simeon', 'Tâcheron', 'peintre', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:21:27'),
(179, 2, 13, 'HATEGEKIMANA Claude', 'Manœuvre', 'soudure', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:22:00'),
(180, 2, 13, 'NDIKUMANA Vital', 'Manœuvre', 'maçonnerie', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:22:42'),
(181, 2, 13, 'NDARUBAYEMWO Willerme', 'Manœuvre', 'location meleze', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:23:22'),
(182, 2, 13, 'NSHIMIRIMANA Aaron', 'Journalier', 'Jardinnage', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:23:57'),
(183, 2, 13, 'ITERITEKA Nelly d or', 'Journalier', 'proprete et arrosage', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 25000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:24:49'),
(184, 2, 13, 'NKENGURUTSE Gaetan', 'Manœuvre', '', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:25:50'),
(185, 2, 13, 'NITUNGA Eliachim', 'Chef de chantier', 'suivi des travaux', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:26:26'),
(186, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'maconnerie', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 800000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:27:43'),
(187, 2, 4, 'NDIKUMANA Claude', 'Manœuvre', 'Lissage et plinth', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 2000000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:28:52'),
(188, 2, 4, 'NDARUBAYEMWO Willerme', 'Manœuvre', 'maçonnerie en brique et betonnage des colonnes/cloture', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:30:21'),
(189, 2, 4, 'Patrick', 'Journalier', 'plafonnier', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:31:18'),
(190, 2, 4, 'NZEYIMANA Abias', 'Manœuvre', 'nettoyage des briques', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 700000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:32:10'),
(191, 2, 4, 'HABONIMANA Moise', 'Manœuvre', 'soudure', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:32:46'),
(192, 2, 4, 'NGENDAKUMANA Norbert', 'Journalier', 'remblais', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 860000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:33:40'),
(193, 2, 4, 'NIZIGAMA Samson', 'Manœuvre', '', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:34:18'),
(194, 2, 4, 'IRANGABIYE Adam', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:35:00'),
(195, 2, 4, 'Fabien', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:35:29'),
(196, 2, 4, 'Isidore', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:36:04'),
(197, 2, 4, 'melance', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:44:10'),
(198, 2, 4, 'Naphtalie', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:44:36'),
(199, 2, 4, 'Gerard', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:45:07'),
(200, 2, 14, 'MANIRAMBONA Victor', 'Journalier', 'maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 25000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:45:52'),
(201, 2, 14, 'NAHIMANA Bélyse', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:46:21'),
(202, 2, 14, 'NSHIMIRIMANA Dismas', 'Journalier', 'pose des pierres taillés et pose des tuiiles sur cloture', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:46:53'),
(203, 2, 14, 'MANIRAMBONA Victor', 'Manœuvre', 'ration du gardien', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:48:17'),
(204, 2, 14, 'NTAHOMPAGAZE', 'Manœuvre', 'ration du gardien', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:48:58'),
(205, 2, 17, 'HATEGEKIMANA Claude', 'Manœuvre', 'soudure', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:49:42'),
(206, 2, 17, 'Patrick', 'Manœuvre', 'plafonnier', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:50:14'),
(207, 2, 17, 'NDIKUMANA Vital', 'Manœuvre', 'maçonnerie', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 1075000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:50:50'),
(208, 2, 1, 'KANEZA Gretta', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:51:32'),
(209, 2, 1, 'NZOKURISHAKA Pascal', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:52:04'),
(210, 2, 1, 'IRANEZEREYE J Bosco', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:52:36'),
(211, 2, 1, 'NDUWAYEZU Eric', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:53:13'),
(212, 2, 1, 'NSENGIYUMVA Eric', 'Chef de chantier', 'suivi des travaux', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:53:40'),
(213, 2, 1, 'TUYISENGE Dieudonnée', 'Tâcheron', 'gutarura igikwa', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:54:23'),
(214, 2, 1, 'NSENGIYUMVA Eric', 'Manœuvre', 'dechargement perches et tubes', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:55:18'),
(215, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'rejointellage des murs exterieur et interieur', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 1900000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:56:14'),
(216, 2, 1, 'HABONIMANA Moise', 'Tâcheron', 'charpente metallique et couverture', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 2000000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:57:16'),
(217, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des elements porteurs interieurs', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 700000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:58:41'),
(218, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'location groupe electrogene', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 12:59:50'),
(219, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des claustrats', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 2000000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:01:01'),
(220, 2, 12, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'elevation mur accrotére', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:02:03'),
(221, 2, 12, 'NDUWAYO Egide', 'Chef de chantier', 'suivi des travaux', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:02:41'),
(222, 2, 10, 'NDAYIZEYE Janvier', 'Chef de chantier', 'suivi des travaux', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:03:40'),
(223, 2, 10, 'NIJIMBERE Lin', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:04:04'),
(224, 2, 10, 'NKURUNZIZA Jean', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:04:33'),
(225, 2, 10, 'NIBITANGA Djalia', 'Journalier', 'proprete', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:05:45'),
(226, 2, 10, 'BARENGAYABO Joseph', 'Journalier', 'Aide maçon', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:06:20'),
(227, 2, 10, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:07:33'),
(228, 2, 10, 'NSHIMIRIMANA Dismas', 'Journalier', 'Enduit fosse septique', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:08:23'),
(229, 2, 10, 'NDAYIZEYE Janvier', 'Journalier', 'Arrosage', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:08:56'),
(230, 2, 2, 'Appolinnaire', 'Journalier', '', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:09:47'),
(231, 2, 2, 'TUYISENGE Dieudonné', 'Manœuvre', 'charpentier', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:10:28'),
(232, 2, 2, 'Jean claude', 'Chef de chantier', 'suivi des travaux', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:11:00'),
(233, 2, 2, 'Jean claude', 'Journalier', 'Aide maçon/2', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:11:45'),
(234, 2, 18, 'HATEGEKIMANA Claude', 'Manœuvre', 'soudure chaises', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 140000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:12:27'),
(235, 2, 5, 'KWIZERA Simeon', 'Manœuvre', 'peintre', '', '2026-05-08', '2026-05-14', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-15 13:12:57'),
(236, 2, 13, 'NDIKUMANA Vital', 'Journalier', '', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 10:30:40'),
(237, 2, 13, 'KWIZERA Simeon', 'Journalier', 'peintre', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 10:34:29'),
(238, 2, 13, 'ITERITEKA Nelly d or', 'Journalier', 'proprete', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 10:54:19'),
(239, 2, 13, 'BUKURU Leonie', 'Journalier', 'nettoyage', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 10:57:07'),
(242, 2, 3, 'NDACAYISABA Maurice', 'Manœuvre', 'achat de 2 fil maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 24000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:09:57'),
(243, 2, 3, 'NDACAYISABA Maurice', 'Manœuvre', 'deplacement du ciment', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:12:41'),
(244, 2, 3, 'NDACAYISABA Maurice', 'Manœuvre', 'Arrosage', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:14:33'),
(245, 2, 3, 'NIYIBIZI Desiré', 'Tâcheron', '', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 1200000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:15:56'),
(246, 2, 3, 'HATUNGIMANA Vincent', 'Tâcheron', '', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:16:53'),
(247, 2, 3, 'NDACAYISABA Maurice', 'Chef de chantier', 'suivi des travaux', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:17:59'),
(248, 2, 7, 'KWIZERA Vedaste', 'Tâcheron', 'electricien', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 700000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:32:16'),
(249, 2, 7, 'HATUNGIMANA Vincent', 'Tâcheron', 'annexe et controle', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:34:43'),
(250, 2, 7, 'NDABARUSHIMANA J de Dieu', 'Tâcheron', 'feraillage', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 600000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:37:04'),
(251, 2, 7, 'TUYISENGE Dieudonnée', 'Tâcheron', 'coffrage', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 700000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:38:45'),
(252, 2, 7, 'KUBWAYO Dionisie', 'Chef de chantier', 'suivi des travaux', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:42:01'),
(253, 2, 7, 'NDUWIMANA J Marie', 'Chef de chantier', 'supervision', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 185000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:42:52'),
(254, 2, 7, 'NYANDWI Janvier', 'Journalier', 'maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:46:27'),
(255, 2, 7, 'MANIRAKIZA Isaac', 'Journalier', 'maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:47:01'),
(256, 2, 7, 'NKUNZIMANA Floride', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:47:56'),
(257, 2, 7, 'MPAWENAYO Yvonne', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:48:42'),
(258, 2, 7, 'NSHEMEZIMNA Jeanine', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:49:34'),
(259, 2, 7, 'NSHIMIRIMANA Patricia', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:50:09'),
(260, 2, 7, 'NDIKUMWENAYO Jean', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:50:49'),
(261, 2, 7, 'KWIZERIMANA Emelyne', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:51:25'),
(262, 2, 21, 'BARUMWETE Simon', 'Journalier', 'maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:54:07'),
(263, 2, 21, 'NIMUBONA J Marie', 'Journalier', 'maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:54:56'),
(264, 2, 21, 'IRANGABIYE Arsene', 'Journalier', 'maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 11:55:39'),
(265, 2, 21, 'NGABIRANO CISIA', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 12:08:37'),
(266, 2, 21, 'NTAKIRUTIMANA Odette', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 12:09:19'),
(267, 2, 21, 'NYANDWI Pascasie', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 12:09:49'),
(268, 2, 5, 'KWIZERA Simeon', 'Tâcheron', 'peintre', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 600000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 12:15:14'),
(269, 2, 8, 'NDUWIMANA J Marie', 'Chef de chantier', 'suivi des travaux', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 185000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 12:54:56'),
(270, 2, 8, 'NDUWIMANA J Marie', 'Journalier', 'Logement', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 12:55:48'),
(271, 2, 16, 'HABONIMANA Moise', 'Tâcheron', 'soudure', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 12:58:58'),
(272, 2, 16, 'NIYINDAMUTSA Adelin', 'Tâcheron', 'plombier', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 12:59:48'),
(273, 2, 16, 'NSAVYIMANA Emmanuel', 'Tâcheron', '', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 900000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:01:06'),
(274, 2, 16, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:01:50'),
(275, 2, 16, 'NSHIMIRIMANA Eric', 'Manœuvre', 'Arrosage', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 18000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:02:37'),
(276, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'deplacement des briques', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:03:54'),
(277, 2, 16, 'KWIZERA Vedaste', 'Tâcheron', 'electricien', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:04:33'),
(278, 2, 16, 'MUNEZERO Claude', 'Chef de chantier', 'suivi des travaux', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:05:04'),
(279, 2, 16, 'Arnaud', 'Journalier', 'maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 25000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:06:35'),
(280, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:07:08'),
(281, 2, 16, 'NGENDAKUMANA Eric', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:07:53'),
(282, 2, 16, 'HAVYARIMANA Fabrice', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:08:26'),
(283, 2, 17, 'NDIKUMANA Vital', 'Journalier', 'maçon et aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 840000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:11:35'),
(284, 2, 17, 'ndikumana vITAL', 'Tâcheron', 'construction d un escalier', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:12:55'),
(285, 2, 17, 'Patrick', 'Journalier', 'plafonnier', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:13:37'),
(286, 2, 17, 'HATEGEKIMANA Claude', 'Journalier', 'soudure', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:14:54'),
(287, 2, 17, 'NSHIMIRIMANA Aaron', 'Journalier', 'Jardinnage', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:15:24'),
(288, 2, 9, 'Francois', 'Journalier', 'maçon e', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:17:01'),
(289, 2, 9, 'Venuste', 'Journalier', 'maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:17:33'),
(290, 2, 9, 'Fiston', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:18:01'),
(291, 2, 9, 'Benjamin', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:20:06'),
(292, 2, 9, 'Christian', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:20:39'),
(293, 2, 9, 'Freri', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:21:10'),
(294, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'Lissage et plinth', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 4000000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:23:33'),
(295, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'controle de finissage', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 1000000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:25:04'),
(296, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'retenue du 15/05', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 1600000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:25:45'),
(297, 2, 4, 'Patrick', 'Tâcheron', 'plafonnier', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:26:23'),
(298, 2, 4, 'NZEYIMANA Abias', 'Tâcheron', 'nettoyage des briques', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 700000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:27:36'),
(299, 2, 4, 'HABONIMANA Moise', 'Tâcheron', 'soudure', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:28:10'),
(300, 2, 4, 'NGENDAKUMANA Norbert', 'Tâcheron', 'remblais', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:29:05'),
(301, 2, 4, 'NDIHOKUBWAYO Michel', 'Chef de chantier', 'suivi des travaux', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:29:37'),
(302, 2, 4, 'Fabrice', 'Journalier', 'charpentier', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:30:42'),
(303, 2, 4, 'Gerard', 'Journalier', 'opérateur', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:31:23');
INSERT INTO `workforce_contracts` (`id`, `company_id`, `chantier_id`, `worker_name`, `worker_type`, `function_name`, `contact_phone`, `start_date`, `end_date`, `pay_mode`, `unit_rate`, `contract_amount`, `status_label`, `approved_by_dt`, `approved_by_daf`, `notes`, `created_at`) VALUES
(304, 2, 4, 'IRANGABIYE Adam', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:31:55'),
(305, 2, 4, 'Isidore', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:32:26'),
(306, 2, 4, 'Fabien', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:34:35'),
(307, 2, 4, 'NTAHOMVUKIYE Dismas', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:35:11'),
(308, 2, 4, 'NSHIMIRIMANA Michel', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:35:54'),
(309, 2, 4, 'samson', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:36:22'),
(310, 2, 14, 'MANIRAMBONA Victor', 'Journalier', 'maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:40:30'),
(311, 2, 14, 'NAHIMANA Bélyse', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:41:13'),
(312, 2, 14, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'pose des pierres taillés et pose des tuiiles sur cloture', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:41:46'),
(313, 2, 14, 'MANIRANKUNDA Victor', 'Journalier', 'ration du gardien', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:42:44'),
(314, 2, 14, 'NTAHOMPAGAZE', 'Journalier', 'ration du gardien', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:44:33'),
(315, 2, 20, 'NTEZIRYAYO Firmin', 'Journalier', 'ration du gardien', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 25000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 13:46:41'),
(316, 2, 10, 'NIJIMBERE Lin', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 14:08:41'),
(317, 2, 10, 'NIBITANGA Djalia', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 14:09:26'),
(318, 2, 10, 'NDAYIZEYE Janvier', 'Chef de chantier', 'suivi des travaux', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 14:11:30'),
(319, 2, 12, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'elevation mur accrotére', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 800000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 14:25:12'),
(320, 2, 12, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'elevation mur accrotére et interieur', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-05-21 14:26:14'),
(321, 2, 1, 'NZOKURISHAKA Pascal', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:30:23'),
(322, 2, 1, 'KANEZA Gretta', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:31:04'),
(323, 2, 1, 'NDUWAYEZU Eric', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:31:37'),
(324, 2, 1, 'IRANEZEREYE J Bosco', 'Journalier', 'Aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:32:13'),
(325, 2, 1, 'TUYISENGE Dieudonnée', 'Tâcheron', 'gutarura igikwa', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 210000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:33:05'),
(326, 2, 1, 'NSENGIYUMVA Eric', 'Chef de chantier', 'suivi des travaux', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:33:39'),
(327, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'rejointellage des murs exterieur et interieur', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 700000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:34:15'),
(328, 2, 1, 'HABONIMANA Moise', 'Tâcheron', 'charpente metallique et couverture', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 3000000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:34:54'),
(329, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des elements porteurs interieurs', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 1200000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:35:34'),
(330, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'location groupe electrogene', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:36:18'),
(331, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des claustrats', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 2200000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:36:53'),
(332, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'dechargement perches', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 27000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:37:44'),
(333, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'Achat logistre du magasinnier', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 20000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:38:25'),
(334, 2, 4, 'KWIZERA Simeon', 'Tâcheron', 'peintre', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 600000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:39:19'),
(335, 2, 10, 'jean marie', 'Manœuvre', 'deplacement du sable', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:55:12'),
(336, 2, 10, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:55:45'),
(337, 2, 10, 'NDAYIZEYE Janvier', 'Journalier', 'dechargement  des materiaux', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:56:32'),
(338, 2, 10, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:57:11'),
(339, 2, 2, 'Claude', 'Chef de chantier', 'suivi des travaux', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:58:10'),
(340, 2, 2, 'Appolinnaire', 'Manœuvre', 'securité', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:58:55'),
(341, 2, 2, 'Claude', 'Journalier', 'maçon et aide maçon', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 220000.00, 0.00, 'actif', 1, 1, '', '2026-05-22 08:59:36'),
(342, 2, 16, 'Bernardo', 'Tâcheron', 'Pierre Taille', '69532121', '2026-05-15', '2026-05-21', 'hebdomadaire', 800000.00, 0.00, 'actif', 0, 0, '', '2026-05-22 09:05:26'),
(343, 2, 18, 'Alexis', 'Journalier', 'Supleme', '', '2026-05-16', '2026-05-21', 'hebdomadaire', 100000.00, 0.00, 'actif', 0, 0, '', '2026-05-22 09:30:23'),
(344, 2, 18, 'Gedeon', 'Journalier', '', '', '2026-05-16', '2026-05-21', 'hebdomadaire', 100000.00, 0.00, 'actif', 0, 0, '', '2026-05-22 09:30:52'),
(345, 2, 18, 'Habonimana Claude', 'Journalier', '', '', '2026-05-15', '2026-05-21', 'hebdomadaire', 220000.00, 0.00, 'actif', 0, 0, '', '2026-05-22 09:34:19'),
(346, 2, 18, 'Bosco IRANEZEREJE', 'Journalier', 'Aide macon', '', '2026-05-16', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 0, 0, '', '2026-05-22 09:36:26'),
(347, 2, 18, 'NDUWAYEZU ERIC', 'Journalier', 'Aide macon', '', '2026-05-16', '2026-05-21', 'hebdomadaire', 45000.00, 0.00, 'actif', 0, 0, '', '2026-05-22 09:37:12'),
(348, 2, 13, 'Nitunga Eliackim', 'Journalier', 'Chef chantier', '', '2026-05-16', '2026-05-21', 'hebdomadaire', 100000.00, 0.00, 'actif', 0, 0, '', '2026-05-21 10:02:25'),
(349, 2, 13, 'Gaetan', 'Journalier', '', '', '2026-05-16', '2026-05-21', 'hebdomadaire', 40000.00, 0.00, 'actif', 0, 0, '', '2026-05-21 10:03:29'),
(350, 2, 13, 'BUKURU Leonie', 'Journalier', 'proprete', '', '2026-05-21', '2026-05-28', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:29:20'),
(351, 2, 13, 'ITERITEKA Nelly d or', 'Journalier', 'Arrosage', '', '2026-05-21', '2026-05-28', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:30:01'),
(352, 2, 13, 'NKENGURUTSE Gaetan', 'Journalier', 'ration du gardien', '', '2026-05-21', '2026-05-28', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:30:51'),
(353, 2, 13, 'NITUNGA Eliachim', 'Chef de chantier', 'suivi des travaux', '', '2026-05-21', '2026-05-28', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:31:22'),
(354, 2, 3, 'NIBIZI Desiré', 'Tâcheron', 'mur de soutenement', '', '2026-05-21', '2026-05-28', 'hebdomadaire', 1670000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:33:13'),
(355, 2, 3, 'NDACAYISABA Maurice', 'Journalier', 'arrosage', '', '2026-05-21', '2026-05-28', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:34:17'),
(356, 2, 3, 'NDACAYISABA Maurice', 'Journalier', 'deplacement du ciment', '', '2026-05-21', '2026-05-28', 'hebdomadaire', 7500.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:35:57'),
(357, 2, 3, 'NDACAYISABA Maurice', 'Chef de chantier', 'suivi des travaux', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:36:43'),
(358, 2, 15, 'TUYISENGE Dieudonnée', 'Tâcheron', 'decoffrage d echaffaudage', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:39:29'),
(359, 2, 15, 'GAHUTU Eric', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:40:11'),
(360, 2, 15, 'NSHIMIRIMANA Abelard', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 11:41:05'),
(361, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'controle de finissage', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 2700000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:13:18'),
(362, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'amenagement exterieur', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 700000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:14:59'),
(363, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'Lissage et plinth', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 600000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:15:32'),
(364, 2, 4, 'NZEYIMANA Abias', 'Tâcheron', 'nettoyage des briques', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 350000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:19:05'),
(365, 2, 4, 'KWIZERA Simeon', 'Tâcheron', 'peintre', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 800000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:20:17'),
(366, 2, 4, 'NGENDAKUMANA Norbert', 'Journalier', 'remblais', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:21:19'),
(367, 2, 4, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'cloture', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:21:58'),
(368, 2, 4, 'Patrick', 'Tâcheron', 'plafonnier', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:22:42'),
(369, 2, 4, 'NIZIGAMA Samson', 'Journalier', 'achat des clous 5kg', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:23:36'),
(370, 2, 4, 'alexis', 'Journalier', 'charpentier', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:25:15'),
(371, 2, 4, 'Gerard', 'Journalier', 'compactage', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:26:00'),
(372, 2, 4, 'Adam', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:29:18'),
(373, 2, 4, 'Isidore', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:30:06'),
(374, 2, 4, 'Fabien', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:30:49'),
(375, 2, 4, 'Axcel', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:31:29'),
(376, 2, 4, 'Elvis', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:32:10'),
(377, 2, 4, 'Dismas', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:33:13'),
(378, 2, 4, 'NIZIGAMA Samson', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:34:28'),
(379, 2, 7, 'TUYISENGE Dieudonnée', 'Tâcheron', 'charpentier', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 1000000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:42:27'),
(381, 2, 7, 'NDABARUSHIMANA J de Dieu', 'Tâcheron', 'feraillage', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 800000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 12:47:20'),
(382, 2, 7, 'HATUNGIMANA Vincent', 'Tâcheron', 'annexe et clotures', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 2800000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:36:51'),
(383, 2, 7, 'KUBWAYO Dionisie', 'Chef de chantier', 'suivi des travaux', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:37:48'),
(384, 2, 7, 'NDUWIMANA J Marie', 'Chef de chantier', 'supervision', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 185000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:38:23'),
(385, 2, 7, 'IRAKOZE Cedrick', 'Journalier', 'dechargement perches et FAB', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:39:06'),
(386, 2, 7, 'NYANDWI Janvier', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:39:59'),
(387, 2, 7, 'MANIRAKIZA Isaac', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:40:32'),
(388, 2, 7, 'TUYISHIME Onesime', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:41:21'),
(389, 2, 7, 'NKUNZIMANA Floride', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:42:29'),
(390, 2, 7, 'NSHEMEZIMNA Jeanine', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:43:02'),
(391, 2, 7, 'NSHIMIRIMANA Patricia', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:43:42'),
(392, 2, 7, 'KWIZERIMANA Emelyne', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:44:40'),
(393, 2, 7, 'MPAWENAYO Yvonne', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:45:13'),
(394, 2, 12, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'elevation mur niveau 4', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:46:48'),
(395, 2, 12, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'elevation mur accrotére et interieur', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 340000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:47:18'),
(396, 2, 12, 'NDUWAYO Egide', 'Chef de chantier', 'suivi des travaux', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:47:56'),
(397, 2, 16, 'NSAVYIMANA Emmanuel', 'Tâcheron', 'cloture et annexe', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 2000000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:50:06'),
(398, 2, 16, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:51:35'),
(399, 2, 16, 'NIYINDAMUTSA Adelin', 'Tâcheron', 'plombier', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:53:11'),
(400, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Arrosage', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 18000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:53:52'),
(401, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:54:50'),
(402, 2, 16, 'HAVYARIMANA Fabrice', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:55:20'),
(403, 2, 16, 'NGENDAKUMANA Eric', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:55:59'),
(404, 2, 16, 'Arnaud', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:56:40'),
(405, 2, 17, 'vital', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 160000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 13:59:42'),
(406, 2, 17, 'gaspard', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:00:15'),
(407, 2, 17, 'Richard', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:00:48'),
(408, 2, 17, 'Thierry', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:01:23'),
(409, 2, 17, 'Lionnel', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:01:57'),
(410, 2, 17, 'Godefroid', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:03:27'),
(411, 2, 17, 'olivier', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:06:27'),
(412, 2, 17, 'wilson', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:07:08'),
(413, 2, 17, 'Fiston', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:10:05'),
(414, 2, 17, 'Ange', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:10:45'),
(415, 2, 17, 'NDIKUMANA Vital', 'Journalier', 'carrelage', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 85000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:12:13'),
(416, 2, 17, 'NSHIMIRIMANA Aaron', 'Journalier', 'Jardinnage', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:15:29'),
(417, 2, 14, 'MANIRANKUNDA Victor', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:24:42'),
(418, 2, 14, 'NAHIMANA Bélyse', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:27:10'),
(419, 2, 14, 'ITERITEKA Odile', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:29:03'),
(420, 2, 14, 'NSHIMIRIMANA Dismas', 'Journalier', 'pose des pierres taillés et pose des tuiiles sur cloture', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:31:44'),
(421, 2, 14, 'NTAHOMPAGAZE', 'Journalier', 'ration du gardien', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:34:06'),
(422, 2, 14, 'MANIRANKUNDA Victor', 'Journalier', 'ration du gardien', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:53:48'),
(423, 2, 1, 'NZOKURISHAKA Pascal', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:55:23'),
(424, 2, 1, 'NDUWAYEZU Eric', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:56:06'),
(425, 2, 1, 'IRANEZEREJE Bosco', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:56:49'),
(426, 2, 1, 'KANEZA Gretta', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 14:57:22'),
(427, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'rejointellage des murs exterieur et interieur', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:10:48'),
(428, 2, 1, 'HABONIMANA Moise', 'Tâcheron', 'Charpente metalliques et couvertures en toles', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 1800000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:12:04'),
(429, 2, 1, 'NSENGIYUMVA Eric', 'Chef de chantier', 'suivi des travaux', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:13:18'),
(430, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'Controle des elements porteurs', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 2000000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:14:17'),
(431, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des claustrats', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 1500000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:16:38'),
(432, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'location  electrogene moto soudeusee', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:19:17'),
(433, 2, 16, 'KWIZERA Vedaste', 'Journalier', 'electricien', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:20:20'),
(434, 2, 7, 'KWIZERA Vedaste', 'Tâcheron', 'electricien', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:22:23'),
(435, 2, 9, 'jean marie', 'Journalier', 'deplacement du sable', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:23:55'),
(436, 2, 10, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:25:43'),
(437, 2, 10, 'NDAYIZEYE Janvier', 'Journalier', 'Frais de chargement', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:26:28'),
(438, 2, 10, 'NDAYIZEYE Janvier', 'Chef de chantier', 'suivi des travaux', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:27:30'),
(439, 2, 10, 'NIJIMBERE Lin', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:28:01'),
(440, 2, 10, 'NKURUNZIZA Jean', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:28:29'),
(441, 2, 10, 'BARENGAYABO Joseph', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:29:19'),
(442, 2, 10, 'NIBITANGA Djalia', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:29:50'),
(443, 2, 9, 'BARUMWETE Simon', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:32:11'),
(444, 2, 9, 'NIMBONA J Marie', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:33:33'),
(445, 2, 9, 'NDIKUMANA Deo', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:34:33'),
(446, 2, 9, 'IRANGABIYE Arsene', 'Journalier', 'maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:35:29'),
(447, 2, 9, 'NGABIRANO CISIA', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:36:19'),
(448, 2, 9, 'NYANDWI Pascasie', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:36:51'),
(449, 2, 9, 'NTAKIRUTIMANA Odette', 'Journalier', 'Aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:37:35'),
(450, 2, 5, 'KWIZERA Simeon', 'Tâcheron', 'peintre', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 600000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:42:00'),
(451, 2, 2, 'Claude', 'Chef de chantier', 'suivi des travaux', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:49:12'),
(452, 2, 2, 'BUTOYI Appolinnaire', 'Journalier', 'securité', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:50:03'),
(453, 2, 2, 'Claude', 'Journalier', 'maçon et aide maçon', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:50:36'),
(454, 2, 10, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:54:56'),
(455, 2, 13, 'CISHAHAYO Elie Moses', 'Journalier', 'electricien', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:58:40'),
(456, 2, 15, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 15:59:50'),
(457, 2, 17, 'NTIBARUHISHA Gaspard', 'Journalier', 'Mod occasionnel du gardien', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 240000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 16:28:41'),
(458, 2, 18, 'Bernardo', 'Journalier', 'Mod de pavage', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 16:30:09'),
(459, 2, 18, 'Bernardo', 'Journalier', 'achat de ibipawa et imyika', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 65000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 16:33:02'),
(460, 2, 20, 'NTEZIRYAYO Firmin', 'Journalier', 'ration du gardien', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 25000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 16:46:08'),
(461, 2, 7, 'NIBITANGA Fabrice', 'Journalier', 'suivi des travaux', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 16:46:43'),
(462, 2, 5, 'EMERUSABE David', 'Journalier', 'suivi des travaux', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-28 16:47:22'),
(463, 2, 16, 'MUNEZERO Claude', 'Chef de chantier', 'suivi des travaux', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 175000.00, 0.00, 'actif', 1, 1, '', '2026-05-29 08:40:24'),
(464, 2, 8, 'Edmond', 'Journalier', 'Gardien du chantier', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-05-29 08:42:12'),
(465, 2, 18, 'HATEGEKIMA Claude', 'Journalier', 'soudure', '', '2026-05-22', '2026-05-28', 'hebdomadaire', 110000.00, 0.00, 'actif', 1, 1, '', '2026-05-29 08:45:00'),
(466, 2, 12, 'NIRERA KEVIN', 'Chef de chantier', 'Suivis de chantier', '', NULL, NULL, 'hebdomadaire', 600000.00, 0.00, 'actif', 1, 0, '', '2026-06-01 09:15:15'),
(467, 2, 4, 'NDIHOKUBWAYO Michel', 'Chef de chantier', 'Suivis de chantier', '', NULL, NULL, 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-01 09:16:13'),
(468, 2, 13, 'BUKURU Leonie', 'Journalier', 'proprete', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:06:32'),
(469, 2, 13, 'NKENGURUTSE Gaetan', 'Journalier', 'ration du gardien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:08:07'),
(470, 2, 13, 'NKENGURUTSE Gaetan', 'Journalier', 'Mod occasionnel du gardien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 77000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:09:23'),
(471, 2, 13, 'ITERITEKA Nelly d or', 'Journalier', 'Arrosage', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:10:27'),
(472, 2, 13, 'ITERITEKA Nelly d or', 'Journalier', 'Mod occasionnel du magasinnier', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:14:35'),
(473, 2, 13, 'NITUNGA Eliachim', 'Chef de chantier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:15:31'),
(474, 2, 3, 'NIBIZI Desiré', 'Tâcheron', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 800000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:35:53'),
(475, 2, 3, 'HATUNGIMANA Vincent', 'Tâcheron', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:36:42'),
(476, 2, 3, 'NDACAYISABA Maurice', 'Chef de chantier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:37:20'),
(477, 2, 3, 'NDACAYISABA Maurice', 'Journalier', 'Arrosage', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:38:42'),
(478, 2, 3, 'NDACAYISABA Maurice', 'Journalier', 'deplacement du ciment', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 95000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:39:34'),
(479, 2, 3, 'joach', 'Manœuvre', 'Mod occasionnel du gardien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 80000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:40:43'),
(480, 2, 3, 'NDACAYISABA Maurice', 'Journalier', 'heure supplementaire', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:41:52'),
(481, 2, 7, 'NYANDWI Janvier', 'Journalier', 'maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:58:08'),
(482, 2, 7, 'MANIRAKIZA Isaac', 'Journalier', 'maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 12:58:54'),
(483, 2, 7, 'TUYISHIME Onesime', 'Journalier', 'maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:05:52'),
(484, 2, 7, 'NKUNZIMANA Floride', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:06:36'),
(485, 2, 7, 'NSHEMEZIMNA Jeanine', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:07:31'),
(486, 2, 7, 'NSHIMIRIMANA Patricia', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:10:00'),
(487, 2, 7, 'MPAWENAYO Yvonne', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:10:46'),
(488, 2, 7, 'KWIZERIMANA Emelyne', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 48000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:22:45'),
(489, 2, 7, 'NYIKIZA Emelyne', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 36000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:23:40'),
(490, 2, 7, 'HATUNGIMANA Vincent', 'Tâcheron', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 1400000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:24:32'),
(491, 2, 7, 'KWIZERA Vedaste', 'Tâcheron', 'electricien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:25:09'),
(492, 2, 7, 'NDABARUSHIMANA J de Dieu', 'Tâcheron', 'feraillage', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:25:47'),
(493, 2, 7, 'KUBWAYO Dionisie', 'Chef de chantier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:26:25'),
(494, 2, 7, 'NDUWIMANA J Marie', 'Chef de chantier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 185000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:27:09'),
(495, 2, 7, 'TUYISENGE Dieudonnée', 'Tâcheron', 'coffrage', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 800000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 13:27:49'),
(496, 2, 7, 'KUBWAYO Dionisie', 'Journalier', 'DECHARGEMENT CIMENT ET DEPACEMENT VIBREUSE', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 29000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:13:17'),
(497, 2, 8, 'BARUMWETE Simon', 'Journalier', 'maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:15:12'),
(498, 2, 8, 'NIMUBONA J Marie', 'Journalier', 'maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:15:47'),
(499, 2, 8, 'IRANGABIYE Arsene', 'Journalier', 'maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:16:19'),
(500, 2, 8, 'NGABIRANO CISIA', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:16:45'),
(501, 2, 4, 'Patrick', 'Tâcheron', 'plafonnier', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 450000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:21:59'),
(502, 2, 4, 'NDIKUMANA Claude', 'Journalier', 'controle de finissage', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 2200000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:23:31'),
(503, 2, 4, 'NDIKUMANA Claude', 'Journalier', 'amenagement exterieur', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 2300000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:24:34'),
(504, 2, 4, 'KWIZERA Simeon', 'Journalier', 'peintre', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:25:19'),
(505, 2, 4, 'NSHIMIRIMANA Aaron', 'Journalier', 'Jardinnage', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 80000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:26:01'),
(506, 2, 4, 'NIZIGAMA Samson', 'Journalier', 'Mod occasionnel du magasinnier', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 350000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:26:45'),
(507, 2, 4, 'HABONIMANA Moise', 'Journalier', 'soudure', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:27:26'),
(508, 2, 4, 'NEMERIMANA Claude', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:29:14'),
(509, 2, 4, 'TUYISENGE J de Dieu', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:30:04'),
(510, 2, 4, 'IRANGABIYE Adam', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:30:42'),
(511, 2, 4, 'Isidore', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:50:39'),
(512, 2, 4, 'Fabien', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:51:10'),
(513, 2, 4, 'Axcel', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:51:45'),
(514, 2, 4, 'Elvis', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:52:18'),
(515, 2, 4, 'robert', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:52:47'),
(516, 2, 4, 'Gerard', 'Journalier', 'opérateur', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:53:34'),
(517, 2, 15, 'TUYISENGE Dieudonnée', 'Tâcheron', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:54:36'),
(518, 2, 15, 'HABONIMANA Moise', 'Tâcheron', 'couverture de tole batiment existant', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:55:53'),
(519, 2, 15, 'HABONIMANA Moise', 'Tâcheron', 'charpente et couverture reservoirs', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:57:01'),
(520, 2, 15, 'NZINAHORA Philippe', 'Journalier', 'maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:57:49'),
(521, 2, 15, 'GAHUTU Eric', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:58:37'),
(522, 2, 15, 'NIKWIGIZE Noah', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:59:22'),
(523, 2, 15, 'NDIHOKUBWAYO Michel', 'Chef de chantier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 14:59:54'),
(524, 2, 1, 'NDUWAYEZU Eric', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:00:58'),
(525, 2, 1, 'NZOKURISHAKA Pascal', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:01:44'),
(526, 2, 1, 'KANEZA Gretta', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:02:15'),
(527, 2, 1, 'IRANEZEREJE Bosco', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:02:46'),
(528, 2, 1, 'HABONIMANA Moise', 'Tâcheron', 'charpente metallique et couverture', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 3500000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:03:30'),
(529, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des elements porteurs interieurs', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 1000000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:04:10'),
(530, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'location groupe electrogene', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:05:03'),
(531, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des claustrats', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 700000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:06:07'),
(532, 2, 1, 'NSENGIYUMVA Eric', 'Chef de chantier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:06:45'),
(533, 2, 1, 'KWIZERA Simeon', 'Tâcheron', 'peinture a huile sur charpente', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:08:34'),
(534, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'dechargement des tubes et ciment', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:09:42'),
(535, 2, 1, 'Joas', 'Journalier', 'Mod occasionnel du magasinnier', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:10:24'),
(536, 2, 16, 'NSAVYIMANA Emmanuel', 'Tâcheron', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 2000000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:11:33'),
(537, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Arrosage', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 18000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:12:14'),
(538, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:13:33'),
(539, 2, 16, 'NGENDAKUMANA Eric', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:14:00'),
(540, 2, 16, 'HAVYARIMANA Fabrice', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:14:35'),
(541, 2, 16, 'NGENDAKUMANA Prosper', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:15:30'),
(542, 2, 16, 'IRAKOZE Lyse', 'Journalier', 'Mod occasionnel du magasinnier', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:16:06'),
(543, 2, 16, 'MUNEZERO Claude', 'Chef de chantier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 175000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:17:12'),
(544, 2, 16, 'Eric', 'Journalier', 'Mod occasionnel du gardien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 80000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:19:01'),
(545, 2, 12, 'NIJIMBERE  Seraphine', 'Magasinier chantier', 'Mod occasionnel du magasinnier', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 350000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:20:09'),
(546, 2, 12, 'NSENGIYUMVA Lieve', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:20:54'),
(547, 2, 12, 'Chantal', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:21:23'),
(548, 2, 12, 'BUCUMI  Alexis', 'Journalier', 'Arrosage  des murs en briques', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:22:13'),
(549, 2, 14, 'MANIRANKUNDA Victor', 'Journalier', 'maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:23:46'),
(550, 2, 14, 'NAHIMANA Bélyse', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:24:31'),
(551, 2, 14, 'HABONIMANA    Moise', 'Tâcheron', 'concertina  sur la cloture  de l extension', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 350000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:25:51'),
(552, 2, 14, 'NSAVYIMANA Edouard', 'Chef de chantier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 600000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:26:28'),
(553, 2, 14, 'NTAHOMPAGAZE', 'Journalier', 'Mod occasionnel du gardien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 80000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:28:55'),
(554, 2, 14, 'MANIRANKUNDA Victor', 'Journalier', 'Mod occasionnel du gardien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 80000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:29:32'),
(555, 2, 17, 'NDIKUMANA Vital', 'Journalier', 'maçon et aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 800000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:32:16'),
(556, 2, 17, 'HATEGEKIMANA Claude', 'Journalier', 'soudure', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:32:52'),
(557, 2, 17, 'Patrick', 'Journalier', 'plafonnier', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:33:19'),
(558, 2, 10, 'NIJIMBERE Lin', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:35:04'),
(559, 2, 10, 'NKURUNZIZA Jean', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:35:37'),
(560, 2, 10, 'BAREANGAYABO Joseph', 'Journalier', 'Aide maçon', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:36:10'),
(561, 2, 10, 'NIBITANGA Djalia', 'Journalier', 'proprete', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:36:46'),
(562, 2, 10, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:37:36'),
(563, 2, 10, 'KWIZERA Simeon', 'Journalier', 'peintre', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:38:08'),
(564, 2, 10, 'jean marie', 'Journalier', 'deplacement du sable', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:38:40'),
(565, 2, 10, 'Claude', 'Journalier', 'demolition fosse septique', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:39:16'),
(566, 2, 10, 'NDAYIZEYE Janvier', 'Chef de chantier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:39:46'),
(567, 2, 10, 'NIJIMBERE Lin', 'Magasinier chantier', 'Mod occasionnel du magasinnier', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:40:21'),
(568, 2, 10, 'Janvier', 'Journalier', 'Mod occasionnel du gardien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 80000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:41:04'),
(569, 2, 7, 'BUTOYI Roshan', 'Manœuvre', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:42:12'),
(570, 2, 2, 'Claude', 'Journalier', 'pyt des ouvriers', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:43:11'),
(571, 2, 2, 'BUKURU Appolinaire', 'Journalier', 'securité', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:43:55'),
(572, 2, 2, 'Claude', 'Chef de chantier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:53:34'),
(573, 2, 10, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:56:17'),
(574, 2, 18, 'CISHAHAYO Elie Moses', 'Journalier', 'electricien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 15:56:46'),
(575, 2, 24, 'NIMBONA Saidi', 'Manœuvre', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 16:04:51'),
(576, 2, 19, 'david', 'Journalier', 'Mod occasionnel du gardien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 16:24:49'),
(577, 2, 19, 'UWIZIGIYE Violette', 'Magasinier chantier', 'Mod occasionnel du gardien', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 16:25:27'),
(578, 2, 7, 'NIBITANGA Fabrice', 'Journalier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 16:49:25'),
(579, 2, 5, 'EMERUSABE David', 'Journalier', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 16:50:01'),
(580, 2, 17, 'Edouard', 'Journalier', 'Mod occasionnel du gardien/kinanira dominika', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-04 16:53:08'),
(581, 2, 17, 'NDIKUMANA Vital', 'Journalier', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-05 08:43:45'),
(582, 2, 7, 'NIBITANGA Fabrice', 'Manœuvre', 'suivi des travaux', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-05 08:44:38'),
(583, 2, 1, 'NSENGIYUMVA Arnaud', 'Manœuvre', 'frais de stage professionnel', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-05 08:45:21'),
(584, 2, 23, 'IRAKOZE Olivier', 'Journalier', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 67500.00, 0.00, 'actif', 1, 1, '', '2026-06-05 08:47:13'),
(585, 2, 23, 'NKUNZIMANA Gerard', 'Journalier', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 67500.00, 0.00, 'actif', 1, 1, '', '2026-06-05 08:47:54'),
(586, 2, 23, 'NDAYISENGA Chadrack', 'Journalier', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 67500.00, 0.00, 'actif', 1, 1, '', '2026-06-05 08:48:34'),
(587, 2, 23, 'MUGISHA Alain', 'Journalier', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 27000.00, 0.00, 'actif', 1, 1, '', '2026-06-05 08:49:11'),
(588, 2, 18, 'pierre et eric', 'Journalier', '', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 42000.00, 0.00, 'actif', 1, 1, '', '2026-06-05 09:58:57'),
(589, 2, 1, 'NKORERIMANA Emmanuel', 'Journalier', 'chargement des toles survenue lors d un accident avec dyna', '', '2026-05-29', '2026-06-04', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-06-05 10:03:16'),
(590, 2, 2, 'Ir j claude', 'Chef de chantier', 'suivi des travaux', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:01:55'),
(591, 2, 2, 'Appolinnaire', 'Journalier', 'ration du gardien', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:04:25'),
(592, 2, 5, 'KWIZERA Simeon', 'Tâcheron', 'peintre', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:07:14'),
(593, 2, 14, 'MANIRAMBONA Victor', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 70000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:09:31'),
(594, 2, 14, 'NAHIMANA Bélyse', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:11:21'),
(595, 2, 14, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:12:41'),
(596, 2, 14, 'NTAHOMPAGAZE', 'Journalier', 'ration du gardien', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 20000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:14:09'),
(597, 2, 23, 'IRAKOZE Olivier', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 54000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:21:05');
INSERT INTO `workforce_contracts` (`id`, `company_id`, `chantier_id`, `worker_name`, `worker_type`, `function_name`, `contact_phone`, `start_date`, `end_date`, `pay_mode`, `unit_rate`, `contract_amount`, `status_label`, `approved_by_dt`, `approved_by_daf`, `notes`, `created_at`) VALUES
(598, 2, 23, 'NKUNZIMANA Gerard', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 54000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:21:53'),
(599, 2, 23, 'NDAYISENGA Chadrack', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 54000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:22:50'),
(600, 2, 23, 'MUGISHA Alain', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 54000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 13:23:43'),
(601, 2, 1, 'HABONIMANA Moise', 'Tâcheron', 'soudure', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 3000000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 14:25:00'),
(602, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des elements porteurs interieurs', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 14:26:14'),
(603, 2, 1, 'HABONIMANA Moise', 'Journalier', 'location groupe electrogene', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 350000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 14:29:11'),
(604, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des claustrats', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 14:32:26'),
(605, 2, 1, 'NSENGIYUMVA Eric', 'Chef de chantier', 'suivi des travaux', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 14:33:14'),
(606, 2, 1, 'KWIZERA Simeon', 'Tâcheron', 'peinture a huile sur charpente', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 1000000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 14:34:19'),
(607, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des claustrats Z phase 2', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 1200000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 14:35:53'),
(608, 2, 1, 'NZEYIMANA Abdias', 'Tâcheron', 'nettoyage des briques', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 14:37:27'),
(609, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'Rejointallage et controle des soubassement', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 14:59:37'),
(610, 2, 1, 'NSENGIYUMVA Eric', 'Tâcheron', 'Echaffaudage', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 290000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:01:11'),
(611, 2, 1, 'NDABARUSHIMANA J de Dieu', 'Tâcheron', 'Traveaux de ferraillage phase de cloture', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:03:06'),
(612, 2, 1, 'TUYISENGE Dieudonne', 'Tâcheron', 'Coffrage cloture', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:04:53'),
(613, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'dechargement du ciment', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:05:53'),
(614, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'Location du groupe triphasi', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 240000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:07:40'),
(615, 2, 1, 'NSABIMANA Claude', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:13:16'),
(616, 2, 1, 'NSHIMIRIMANA Maurice', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:14:35'),
(617, 2, 1, 'KANEZA Gretta', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:15:39'),
(618, 2, 1, 'NDUWAYEZU Eric', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:16:40'),
(619, 2, 1, 'NZOKURISHAKA Pascal', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:17:37'),
(620, 2, 1, 'NDABARUSHIMANA J de Dieu', 'Journalier', 'Gardien du chantier', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:18:50'),
(621, 2, 21, 'ERIC; Pierre; Egide; Robert; Alexis; Andre', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 160000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:23:33'),
(622, 2, 17, 'NDIKUMANA Vital', 'Journalier', 'maçon et aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 1055000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:37:31'),
(623, 2, 17, 'HATEGEKIMANA Claude', 'Tâcheron', 'soudure', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:38:37'),
(624, 2, 3, 'NIBIZI Desiré', 'Tâcheron', 'construction du mur de soutenemment', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 900000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:41:33'),
(625, 2, 3, 'Ir HATUNGIMANA Vincent', 'Chef de chantier', 'suivi des travaux', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:42:57'),
(626, 2, 3, 'Ir NDACAYISABA Mauric', 'Chef de chantier', 'suivi des travaux', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:44:27'),
(627, 2, 3, 'NDACAYISABA Maurice', 'Journalier', 'Arrosage; cadena; hache', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 15:45:58'),
(628, 2, 4, 'Isidore', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:01:53'),
(629, 2, 4, 'Fabien', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:02:51'),
(630, 2, 4, 'Axcel', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:03:36'),
(631, 2, 4, 'Elvis', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:04:44'),
(632, 2, 4, 'robert', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:07:09'),
(633, 2, 4, 'Gerard', 'Journalier', 'operateur', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:08:15'),
(634, 2, 4, 'david', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:09:06'),
(635, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'Controle et finissage', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 2100000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:13:32'),
(636, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'Lissage et plinth', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 2200000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:16:54'),
(637, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'amenagement exterieur', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 1100000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:18:02'),
(638, 2, 4, 'Abdias', 'Tâcheron', 'nettoyage des briques', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:19:20'),
(639, 2, 4, 'NIZIGAMA Samson', 'Journalier', 'achat de 3bennes de sable et dechargement de 100sacs du ciment', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 225000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:21:43'),
(640, 2, 4, 'Norbert', 'Tâcheron', 'remblais', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:22:36'),
(641, 2, 4, 'KWIZERA Simeon', 'Tâcheron', 'peintre', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:23:23'),
(642, 2, 15, 'NIZINAHORA Philip', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:25:25'),
(643, 2, 15, 'NIKWIGIZE Noah', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:26:19'),
(644, 2, 16, 'NSAVYIMANA Emmanuel', 'Tâcheron', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 900000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:37:00'),
(645, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Arrosage', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 18000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:38:11'),
(646, 2, 16, 'NGENDAKUMANA Eric', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:42:25'),
(647, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:44:37'),
(648, 2, 16, 'HAVYARIMANA Fabrice', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:45:40'),
(649, 2, 13, 'BUKURU Leonie', 'Journalier', 'Traitement du gazon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:47:52'),
(650, 2, 13, 'ITERITEKA Nelly d or', 'Journalier', 'Arrosage du jardin', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:49:09'),
(651, 2, 13, 'NIYONKURU Jeane', 'Journalier', 'proprete', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:50:56'),
(652, 2, 13, 'NITUNGA Eliachim', 'Chef de chantier', 'suivi des travaux', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:51:49'),
(653, 2, 13, 'NKENGURUTSE Gaetan', 'Journalier', 'ration du gardien', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:53:43'),
(654, 2, 8, 'KWIZERA Simeon', 'Tâcheron', 'Masticage', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:56:21'),
(655, 2, 8, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:57:18'),
(656, 2, 8, 'NIJIMBERE Lin', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:58:36'),
(657, 2, 8, 'BUTOYI Oscar', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 25000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 16:59:53'),
(658, 2, 8, 'NIBITANGA Djalia', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:00:48'),
(659, 2, 8, 'Janvier', 'Journalier', 'Gardien du chantier', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 80000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:03:16'),
(660, 2, 9, 'BARUMWETE Simon', 'Journalier', 'maçon et aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:04:54'),
(661, 2, 6, 'KWIZERA Vedaste', 'Tâcheron', 'electricien', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:06:48'),
(662, 2, 6, 'NDABARUSHIMANA J de Dieu', 'Tâcheron', 'feraillage', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:07:45'),
(663, 2, 6, 'TUYISENGE Dieudonnée', 'Tâcheron', 'coffrage', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:08:37'),
(664, 2, 6, 'Ir KUBWAYO Dionesie', 'Chef de chantier', 'suivi des travaux', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 185000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:11:04'),
(665, 2, 6, 'HATUNGIMANA Vincent', 'Tâcheron', 'construction annexe; cloture et escalier', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 1200000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:13:25'),
(666, 2, 6, 'IRAKOZE Cedrick', 'Tâcheron', 'Soulever la dalle de la fosse sptique', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:15:08'),
(667, 2, 6, 'MANIRAKIZA Eduige', 'Magasinier chantier', 'suivi des travaux', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:16:21'),
(668, 2, 6, 'NDIKUMWENAYO Jean', 'Journalier', 'deplacement du ciment', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:17:17'),
(669, 2, 6, 'NYANDWI Janvier', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:18:30'),
(670, 2, 6, 'MANIRAKIZA Isaac', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:19:18'),
(671, 2, 6, 'TUYISHIME Onesime', 'Journalier', 'maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:20:16'),
(672, 2, 6, 'NKUNZIMANA Floride', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:21:09'),
(673, 2, 6, 'NSHEMEZIMNA Jeanine', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:22:04'),
(674, 2, 6, 'NSHIMIRIMANA Patricia', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 24000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:22:53'),
(675, 2, 6, 'MPAWENAYO Yvonne', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:23:43'),
(676, 2, 6, 'KWIZERIMANA Emelyne', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:24:29'),
(677, 2, 6, 'NIYIKIZA Emelyne', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:25:35'),
(678, 2, 11, 'NDACAYISABA Maurice', 'Journalier', 'Gardien du chantier', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-11 17:27:29'),
(679, 2, 3, 'NIBIZI Desiré', 'Tâcheron', 'maçon (credit remboursable dans 10semaines; soit 50000fbu par semaine)', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-06-12 08:53:21'),
(680, 2, 4, 'IRANGABIYE Adam', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-12 08:59:56'),
(681, 2, 4, 'Dismas', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-12 09:01:31'),
(682, 2, 14, 'HABONIMANA Moise', 'Tâcheron', 'soudure', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-12 09:17:21'),
(683, 2, 12, 'NDUWAYO Egide', 'Journalier', 'frais de stage professionnel ( avance)', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-12 10:14:53'),
(684, 2, 12, 'Libert', 'Journalier', 'Frais de gardiennage', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-12 10:16:14'),
(685, 2, 12, 'NSENGIYUMVA Lieve', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-12 10:17:13'),
(686, 2, 12, 'Chantal', 'Journalier', 'Aide maçon', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-12 10:17:52'),
(687, 2, 12, 'NDUWIMANA Leonidas', 'Journalier', 'Frais de Nettoyage', '', '2026-06-05', '2026-06-11', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-06-12 10:20:05'),
(688, 2, 8, 'BARUMWETE Simon', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 11:34:34'),
(689, 2, 23, 'IRAKOZE Olivier', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 94500.00, 0.00, 'actif', 1, 1, '', '2026-06-18 11:54:06'),
(690, 2, 23, 'NKUNZIMANA Gerard', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 94500.00, 0.00, 'actif', 1, 1, '', '2026-06-18 11:55:09'),
(691, 2, 23, 'NDAYISENGA Chadrack', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 94500.00, 0.00, 'actif', 1, 1, '', '2026-06-18 11:56:00'),
(692, 2, 23, 'MUGISHA Alain', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 94500.00, 0.00, 'actif', 1, 1, '', '2026-06-18 11:56:43'),
(693, 2, 5, 'KWIZERA Simeon', 'Tâcheron', 'peintre', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 12:05:39'),
(694, 2, 5, 'KWIZERA Simeon', 'Tâcheron', 'peintre', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 12:06:03'),
(695, 2, 3, 'NIBIZI Desiré', 'Tâcheron', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 750000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 12:17:37'),
(696, 2, 3, 'NDACAYISABA Maurice', 'Chef de chantier', 'suivi des travaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 12:18:23'),
(697, 2, 3, 'HATUNGIMANA Vincent', 'Chef de chantier', 'suivi des travaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 300000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 12:19:12'),
(698, 2, 3, 'NDACAYISABA Maurice', 'Journalier', 'Arrosage', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 0.00, 10000.00, 'actif', 1, 1, '', '2026-06-18 12:20:10'),
(699, 2, 3, 'NDACAYISABA Maurice', 'Journalier', 'Frais de deplacement', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 10000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 12:21:14'),
(700, 2, 9, 'KWIZERA Simeon', 'Journalier', 'peintre', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 120000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 12:24:07'),
(701, 2, 17, 'NDIKUMANA Vital', 'Tâcheron', 'Finition de l\'escalier', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 350000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:08:07'),
(702, 2, 17, 'NSHIMIRIMANA Aaron', 'Tâcheron', 'Jardinnage', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:10:08'),
(703, 2, 17, 'NTIBARUHISHA Gaspard', 'Journalier', 'Controle du batiment', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 855000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:12:45'),
(704, 2, 17, 'HATEGEKIMANA Claude', 'Tâcheron', 'soudure', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 370000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:14:30'),
(705, 2, 14, 'NSHIMIRIMANA Victor', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 35000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:25:27'),
(706, 2, 14, 'NAHIMANA Bélyse', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:26:17'),
(707, 2, 14, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:27:08'),
(708, 2, 14, 'HABONIMANA Moise', 'Tâcheron', 'soudure', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:28:01'),
(709, 2, 1, 'HABONIMANA Moise', 'Tâcheron', 'couverture du batiment avec les toles', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 2000000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:38:08'),
(710, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des elements porteurs', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 350000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:39:59'),
(711, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'location groupe electrogene', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:40:47'),
(713, 2, 1, 'NSENGIYUMVA Eric', 'Chef de chantier', 'suivi des travaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:42:36'),
(714, 2, 1, 'KWIZERA Simeon', 'Tâcheron', 'peinture a huile sur charpente', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 600000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:43:42'),
(715, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des claustrats Z phase 2', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 1100000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 13:45:56'),
(716, 2, 1, 'KWIZERA Vedaste', 'Tâcheron', 'electricien', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:00:57'),
(717, 2, 1, 'NZEYIMANA Abdias', 'Tâcheron', 'nettoyage des briques', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 600000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:02:11'),
(718, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'foulle plus fondation du cloture', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:03:59'),
(719, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'Montage des echaffaudages', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:06:01'),
(720, 2, 1, 'NDABARUSHIMANA J de Dieu', 'Tâcheron', 'feraillage du cloture', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:07:18'),
(721, 2, 1, 'TUYISENGE Dieudonnée', 'Tâcheron', 'Coffrage cloture', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 400000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:08:24'),
(722, 2, 1, 'IRANEZEREYE J Bosco', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 135000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:10:02'),
(723, 2, 1, 'Josias', 'Journalier', 'over time', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:11:04'),
(724, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'Gufunga musi y\'amabati ( masonneri en dessous des toles', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 1080000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:14:16'),
(725, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'dechargement des materiaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 25000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:15:20'),
(726, 2, 1, 'NSENGIYUMVA Eric', 'Journalier', 'location groupe electrogene triphasi', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 240000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:16:37'),
(727, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'Rejointallage et controle du soubassement', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 350000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:17:49'),
(728, 2, 1, 'NGENDAKUMANA Eduard', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:20:10'),
(729, 2, 1, 'NDUWIMANA Chadrack', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:21:14'),
(730, 2, 1, 'KANEZA Gretta', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:21:58'),
(731, 2, 1, 'NDUWAYEZU Eric', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:22:45'),
(732, 2, 1, 'NZOKURISHAKA Pascal', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:23:53'),
(733, 2, 1, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:24:52'),
(734, 2, 21, 'Jean de Dieu', 'Journalier', '', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:26:16'),
(735, 2, 2, 'NDAYIZEYE Jean claude', 'Chef de chantier', 'suivi des travaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 180000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:28:11'),
(736, 2, 2, 'BUTOYI Appolinnaire', 'Journalier', 'Gardien du chantier', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:29:34'),
(737, 2, 2, 'ERERUSABE David', 'Chef de chantier', 'suivi des travaux pendant 2semaines', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:31:16'),
(738, 2, 7, 'HATUNGIMANA Vincent', 'Tâcheron', 'maçonnerie sur Escalier; annexes et cloture', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 900000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:34:11'),
(739, 2, 7, 'TUYISENGE Dieudonné', 'Tâcheron', 'Coffrage', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:35:37'),
(740, 2, 7, 'NDABARUSHIMANA J de Dieu', 'Tâcheron', 'Ferallages', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:37:40'),
(741, 2, 7, 'NDUWIMANA J Marie', 'Chef de chantier', 'suivi des travaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 185000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:39:20'),
(742, 2, 7, 'KUBWAYO Dionisie', 'Chef de chantier', 'suivi des travaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:40:10'),
(743, 2, 7, 'NDIKUMWENAYO Jean', 'Journalier', 'dechargement du ciment', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 3600.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:42:49'),
(744, 2, 7, 'NYANDWI Janvier', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:44:31'),
(745, 2, 7, 'TUYISHIME Onesime', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:45:59'),
(746, 2, 7, 'MANIRAKIZA Isaac', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:46:45'),
(747, 2, 7, 'NKUNZIMANA Floride', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:47:45'),
(748, 2, 7, 'NSHEMEZIMNA Jeanine', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:48:42'),
(749, 2, 7, 'NSHIMIRIMANA Patricia', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:50:24'),
(750, 2, 7, 'MPAWENAYO Yvonne', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:51:30'),
(751, 2, 7, 'NIYIKIZA Emelyne', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 72000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:52:34'),
(752, 2, 7, 'KWIZERIMANA Emelyne', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:53:24'),
(753, 2, 7, 'NDIKUMWENAYO Jean', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:54:23'),
(754, 2, 7, 'KWIZERA Vedaste', 'Tâcheron', 'electricien', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 14:56:13'),
(756, 2, 16, 'NSAVYIMANA Emmanuel', 'Tâcheron', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 1300000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:02:47'),
(757, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Arrosage', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 18000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:03:43'),
(758, 2, 16, 'KWIZERA Vedaste', 'Tâcheron', 'electricien', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:04:28'),
(759, 2, 16, 'BIGIRIMANA Methode', 'Journalier', 'maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:05:06'),
(760, 2, 16, 'NSHIMIRIMANA Eric', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:06:01'),
(761, 2, 16, 'HAVYARIMANA Fabrice', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:06:40'),
(762, 2, 16, 'NGENDAKUMANA Eric', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:07:24'),
(763, 2, 16, 'IR FABRICE', 'Chef de chantier', 'suivi des travaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:08:53'),
(764, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'controle de finissage', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 1700000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:17:41'),
(765, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'Lissage et plinth', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 1600000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:18:26'),
(766, 2, 4, 'NDIKUMANA Claude', 'Tâcheron', 'amenagement exterieur', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 1200000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:19:46'),
(767, 2, 4, 'Abdias', 'Tâcheron', 'nettoyage des briques', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:20:30'),
(768, 2, 4, 'Norbert', 'Tâcheron', 'remblais', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:21:09'),
(769, 2, 4, 'IR Eduard', 'Journalier', 'nivelement des pavages des tuyaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 70000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:22:54'),
(770, 2, 4, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'plantation du gazon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 450000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:23:48'),
(771, 2, 4, 'Pacifique', 'Tâcheron', 'LOGO Dessinateur', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:26:01'),
(772, 2, 4, 'IRANGABIYE Adam', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:27:02'),
(773, 2, 4, 'Gerard', 'Journalier', 'opérateur', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 250000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:27:48'),
(774, 2, 4, 'Isidore', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 90000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:28:27'),
(775, 2, 4, 'Axcel', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:36:46'),
(776, 2, 4, 'Elvis', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:37:56'),
(777, 2, 4, 'samson', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 45000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:38:37'),
(778, 2, 4, 'Fabien', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:39:12'),
(779, 2, 10, 'NIJIMBERE Lin', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 75000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:41:23'),
(780, 2, 10, 'NIBITANGA Djalia', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 60000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:42:01'),
(781, 2, 10, 'NSHIMIRIMANA Dismas', 'Tâcheron', 'carrelage', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:42:49'),
(782, 2, 10, 'KWIZERA Simeon', 'Tâcheron', 'Masticage', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 80000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:43:42'),
(783, 2, 10, 'NDAYIZEYE Janvier', 'Chef de chantier', 'suivi des travaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:44:33'),
(784, 2, 10, 'NIJIMBERE Lin', 'Magasinier chantier', 'AVANCE SUR SALAIRE', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 150000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:45:36'),
(785, 2, 10, 'CISHAHAYO Elie Moses', 'Tâcheron', 'electricien', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:46:08'),
(786, 2, 13, 'ITERITEKA Nelly d or', 'Journalier', 'Aide maçon', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 15000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:49:05'),
(787, 2, 13, 'BUKURU Leonie', 'Journalier', 'proprete', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 30000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:49:55'),
(788, 2, 13, 'NKENGURUTSE Gaetan', 'Journalier', 'ration du gardien', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:50:40'),
(789, 2, 13, 'NITUNGA Eliachim', 'Chef de chantier', 'suivi des travaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 125000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:51:16'),
(790, 2, 23, 'Bernardo', 'Tâcheron', 'MOD pour les travaux de commencement du projet de pave', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-06-18 15:55:13'),
(791, 2, 4, 'yvan', 'Tâcheron', 'electricien', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, '', '2026-06-19 08:46:58'),
(792, 2, 20, 'Firmin', 'Journalier', 'Gardien du chantier  MOD du mois et ration de 2semainnes', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 100000.00, 0.00, 'actif', 0, 0, '', '2026-06-19 08:51:29'),
(793, 2, 4, 'NSHIMIRIMANA Aaron', 'Tâcheron', 'Jardinnage', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 40000.00, 0.00, 'actif', 1, 1, '', '2026-06-19 09:00:51'),
(794, 2, 1, 'NDARUBAYEMWO Willerme', 'Tâcheron', 'controle des claustrats Z', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 500000.00, 0.00, 'actif', 1, 1, '', '2026-06-19 09:02:13'),
(795, 2, 16, 'MUNEZERO Claude', 'Chef de chantier', 'suivi des travaux', '', '2026-06-12', '2026-06-18', 'hebdomadaire', 350000.00, 0.00, 'actif', 1, 1, '', '2026-06-19 09:03:09'),
(796, 2, 1, 'Rugamira', 'Tâcheron', 'dafffdsfds', NULL, '2026-06-21', '2026-06-27', 'Hebdomadaire', 100000.00, 0.00, 'actif', 1, 1, NULL, '2026-06-23 15:56:11'),
(797, 2, 1, 'Elga', 'Magasinier', 'dsfdsfdsfsdfs', NULL, '2026-06-21', '2026-06-26', 'Hebdomadaire', 200000.00, 0.00, 'actif', 1, 1, NULL, '2026-06-23 15:56:11'),
(798, 2, 14, 'kamapayano', 'Journalier', 'dsafadadas', NULL, '2026-06-21', '2026-06-27', 'Hebdomadaire', 50000.00, 0.00, 'actif', 1, 1, NULL, '2026-06-23 16:00:29'),
(799, 2, 14, 'sabushimike', 'Tâcheron', 'adadasda', NULL, '2026-06-21', '2026-06-27', '', 300000.00, 0.00, 'actif', 1, 1, NULL, '2026-06-23 16:00:29');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accounting_accounts`
--
ALTER TABLE `accounting_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_account_company` (`company_id`,`account_code`);

--
-- Index pour la table `accounting_assistant_entries`
--
ALTER TABLE `accounting_assistant_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_assistant_entries_user_sql` (`created_by`),
  ADD KEY `idx_assistant_entries_company` (`company_id`),
  ADD KEY `idx_assistant_entries_date` (`entry_date`),
  ADD KEY `idx_assistant_entries_invoice` (`invoice_no`);

--
-- Index pour la table `accounting_entries`
--
ALTER TABLE `accounting_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_entries_company` (`company_id`),
  ADD KEY `idx_entries_account` (`account_code`);

--
-- Index pour la table `accounting_payments`
--
ALTER TABLE `accounting_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_acc_payments_company_sql` (`company_id`);

--
-- Index pour la table `accounting_period_closures`
--
ALTER TABLE `accounting_period_closures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_acc_periods_company_sql` (`company_id`);

--
-- Index pour la table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_activity_company` (`company_id`),
  ADD KEY `idx_activity_user` (`user_id`);

--
-- Index pour la table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_alerts_company` (`company_id`),
  ADD KEY `fk_alerts_chantier` (`chantier_id`),
  ADD KEY `fk_alerts_task` (`task_id`);

--
-- Index pour la table `alert_escalations`
--
ALTER TABLE `alert_escalations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_alert_escalations_company` (`company_id`),
  ADD KEY `fk_alert_escalations_alert` (`alert_id`);

--
-- Index pour la table `approval_signatures`
--
ALTER TABLE `approval_signatures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_approval_signatures_approval` (`approval_id`),
  ADD KEY `fk_approval_signatures_user` (`signed_by_user_id`);

--
-- Index pour la table `assigned_tasks`
--
ALTER TABLE `assigned_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_assigned_tasks_company` (`company_id`),
  ADD KEY `fk_assigned_tasks_project` (`project_id`),
  ADD KEY `fk_assigned_tasks_chantier` (`chantier_id`),
  ADD KEY `fk_assigned_tasks_user` (`assigned_user_id`);

--
-- Index pour la table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_budgets_company` (`company_id`),
  ADD KEY `fk_budgets_chantier` (`chantier_id`);

--
-- Index pour la table `budget_lines`
--
ALTER TABLE `budget_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_budget_lines_company` (`company_id`),
  ADD KEY `fk_budget_lines_budget` (`budget_id`),
  ADD KEY `fk_budget_lines_chantier` (`chantier_id`);

--
-- Index pour la table `cash_journal_entries`
--
ALTER TABLE `cash_journal_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cash_journal_entries_company` (`company_id`);

--
-- Index pour la table `chantiers`
--
ALTER TABLE `chantiers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_chantiers_company` (`company_id`),
  ADD KEY `fk_chantiers_project` (`project_id`);

--
-- Index pour la table `chantier_assignments`
--
ALTER TABLE `chantier_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_assignment_company` (`company_id`);

--
-- Index pour la table `chantier_deliverables`
--
ALTER TABLE `chantier_deliverables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_deliverables_company` (`company_id`),
  ADD KEY `fk_deliverables_chantier` (`chantier_id`);

--
-- Index pour la table `chantier_evaluation_lines`
--
ALTER TABLE `chantier_evaluation_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_eval_company` (`company_id`);

--
-- Index pour la table `chantier_profitability`
--
ALTER TABLE `chantier_profitability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_profitability_company` (`company_id`),
  ADD KEY `fk_profitability_chantier` (`chantier_id`);

--
-- Index pour la table `chantier_tasks`
--
ALTER TABLE `chantier_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tasks_company` (`company_id`),
  ADD KEY `fk_tasks_chantier` (`chantier_id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_clients_company` (`company_id`);

--
-- Index pour la table `client_portal_accounts`
--
ALTER TABLE `client_portal_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_client_portal_user` (`user_id`),
  ADD KEY `idx_client_portal_company` (`company_id`),
  ADD KEY `fk_cpa_client` (`client_id`),
  ADD KEY `fk_cpa_chantier` (`chantier_id`);

--
-- Index pour la table `client_project_updates`
--
ALTER TABLE `client_project_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cpu_company` (`company_id`),
  ADD KEY `idx_cpu_account` (`client_portal_account_id`),
  ADD KEY `fk_cpu_chantier` (`chantier_id`),
  ADD KEY `fk_cpu_creator` (`created_by`);

--
-- Index pour la table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_companies_plan` (`plan_id`);

--
-- Index pour la table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contracts_company` (`company_id`),
  ADD KEY `fk_contracts_client` (`client_id`),
  ADD KEY `fk_contracts_project` (`project_id`);

--
-- Index pour la table `crm_prospects`
--
ALTER TABLE `crm_prospects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_crm_company` (`company_id`);

--
-- Index pour la table `daf_disbursement_approvals`
--
ALTER TABLE `daf_disbursement_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_daf_disbursement_company` (`company_id`);

--
-- Index pour la table `daf_fund_movements`
--
ALTER TABLE `daf_fund_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_daf_fund_movements_company` (`company_id`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_documents_company` (`company_id`),
  ADD KEY `fk_documents_user` (`user_id`);

--
-- Index pour la table `document_approvals`
--
ALTER TABLE `document_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_document_approvals_company` (`company_id`),
  ADD KEY `fk_document_approvals_document` (`document_id`),
  ADD KEY `fk_document_approvals_requester` (`requested_by_user_id`);

--
-- Index pour la table `document_approval_requests`
--
ALTER TABLE `document_approval_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doc_approval_requests_company` (`company_id`),
  ADD KEY `fk_doc_approval_requests_document` (`document_id`),
  ADD KEY `fk_doc_approval_requests_user` (`requested_by_user_id`);

--
-- Index pour la table `document_approval_steps`
--
ALTER TABLE `document_approval_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doc_approval_steps_request` (`request_id`),
  ADD KEY `fk_doc_approval_steps_user` (`signed_by_user_id`);

--
-- Index pour la table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employees_company` (`company_id`),
  ADD KEY `fk_employees_chantier` (`chantier_id`);

--
-- Index pour la table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_equipments_company` (`company_id`),
  ADD KEY `fk_equipments_chantier` (`chantier_id`);

--
-- Index pour la table `external_messages`
--
ALTER TABLE `external_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_external_company` (`company_id`);

--
-- Index pour la table `finances`
--
ALTER TABLE `finances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_finances_company` (`company_id`);

--
-- Index pour la table `finance_contract_situations`
--
ALTER TABLE `finance_contract_situations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_finance_contract_situations_company` (`company_id`);

--
-- Index pour la table `fuel_logs`
--
ALTER TABLE `fuel_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fuel_logs_company` (`company_id`),
  ADD KEY `fk_fuel_logs_equipment` (`equipment_id`),
  ADD KEY `fk_fuel_logs_chantier` (`chantier_id`);

--
-- Index pour la table `immobilisations`
--
ALTER TABLE `immobilisations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_immobilisations_company` (`company_id`);

--
-- Index pour la table `insurances`
--
ALTER TABLE `insurances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_insurances_company` (`company_id`),
  ADD KEY `fk_insurances_equipment` (`equipment_id`),
  ADD KEY `fk_insurances_immobilisation` (`immobilisation_id`);

--
-- Index pour la table `internal_messages`
--
ALTER TABLE `internal_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_internal_messages_company` (`company_id`),
  ADD KEY `fk_internal_messages_sender` (`sender_user_id`);

--
-- Index pour la table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoices_company` (`company_id`),
  ADD KEY `fk_invoices_chantier` (`chantier_id`),
  ADD KEY `fk_invoices_situation` (`situation_id`),
  ADD KEY `fk_invoices_contract` (`linked_contract_id`);

--
-- Index pour la table `maintenance_logs`
--
ALTER TABLE `maintenance_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_maintenance_company` (`company_id`),
  ADD KEY `fk_maintenance_equipment` (`equipment_id`);

--
-- Index pour la table `material_consumptions`
--
ALTER TABLE `material_consumptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_material_consumptions_company` (`company_id`),
  ADD KEY `fk_material_consumptions_stock` (`stock_id`),
  ADD KEY `fk_material_consumptions_chantier` (`chantier_id`),
  ADD KEY `fk_material_consumptions_task` (`task_id`);

--
-- Index pour la table `mobile_reports`
--
ALTER TABLE `mobile_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mobile_company` (`company_id`),
  ADD KEY `fk_mobile_chantier` (`chantier_id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_company` (`company_id`),
  ADD KEY `fk_notifications_alert` (`alert_id`);

--
-- Index pour la table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_vouchers_company` (`company_id`);

--
-- Index pour la table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payroll_company` (`company_id`),
  ADD KEY `fk_payroll_employee` (`employee_id`);

--
-- Index pour la table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `pointages`
--
ALTER TABLE `pointages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pointages_company` (`company_id`),
  ADD KEY `fk_pointages_employee` (`employee_id`),
  ADD KEY `fk_pointages_chantier` (`chantier_id`);

--
-- Index pour la table `production_cost_breakdowns`
--
ALTER TABLE `production_cost_breakdowns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prod_cost_company` (`company_id`),
  ADD KEY `fk_prod_cost_chantier` (`chantier_id`),
  ADD KEY `fk_prod_cost_budget_line` (`budget_line_id`),
  ADD KEY `fk_prod_cost_task` (`task_id`);

--
-- Index pour la table `production_journals`
--
ALTER TABLE `production_journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_production_journals_company` (`company_id`),
  ADD KEY `fk_production_journals_chantier` (`chantier_id`),
  ADD KEY `fk_production_journals_task` (`task_id`),
  ADD KEY `fk_production_journals_budget_line` (`budget_line_id`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_projects_company` (`company_id`);

--
-- Index pour la table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_purchases_company` (`company_id`);

--
-- Index pour la table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_purchase_requests_company` (`company_id`),
  ADD KEY `fk_purchase_requests_chantier` (`chantier_id`),
  ADD KEY `fk_purchase_requests_supplier` (`supplier_id`),
  ADD KEY `fk_purchase_requests_user` (`requested_by_user_id`),
  ADD KEY `fk_purchase_requests_budget_line` (`budget_line_id`);

--
-- Index pour la table `purchase_request_forms`
--
ALTER TABLE `purchase_request_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_purchase_request_forms_company` (`company_id`);

--
-- Index pour la table `purchase_request_items`
--
ALTER TABLE `purchase_request_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_purchase_request_items_request` (`request_id`);

--
-- Index pour la table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_quotes_company` (`company_id`),
  ADD KEY `fk_quotes_client` (`client_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Index pour la table `role_permission_overrides`
--
ALTER TABLE `role_permission_overrides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_role_module` (`role_code`,`module_code`);

--
-- Index pour la table `service_orders`
--
ALTER TABLE `service_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_service_orders_company` (`company_id`),
  ADD KEY `fk_service_orders_chantier` (`chantier_id`),
  ADD KEY `fk_service_orders_subcontractor` (`subcontractor_id`),
  ADD KEY `fk_service_orders_contract` (`contract_id`);

--
-- Index pour la table `situations`
--
ALTER TABLE `situations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_situations_company` (`company_id`),
  ADD KEY `fk_situations_chantier` (`chantier_id`),
  ADD KEY `fk_situations_contract` (`contract_id`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stocks_company` (`company_id`);

--
-- Index pour la table `stock_issues`
--
ALTER TABLE `stock_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stock_issues_company` (`company_id`),
  ADD KEY `fk_stock_issues_stock` (`stock_id`),
  ADD KEY `fk_stock_issues_chantier` (`chantier_id`);

--
-- Index pour la table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stock_transfers_company` (`company_id`),
  ADD KEY `fk_stock_transfers_source` (`source_stock_id`),
  ADD KEY `fk_stock_transfers_target` (`target_stock_id`);

--
-- Index pour la table `subcontractors`
--
ALTER TABLE `subcontractors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subcontractors_company` (`company_id`);

--
-- Index pour la table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_suppliers_company` (`company_id`);

--
-- Index pour la table `tbl_finance_accounting_entry`
--
ALTER TABLE `tbl_finance_accounting_entry`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_finance_accounting_entry_line`
--
ALTER TABLE `tbl_finance_accounting_entry_line`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entry` (`entry_id`);

--
-- Index pour la table `tbl_finance_account_class`
--
ALTER TABLE `tbl_finance_account_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_number` (`class_number`);

--
-- Index pour la table `tbl_finance_chart_account`
--
ALTER TABLE `tbl_finance_chart_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_code` (`account_code`),
  ADD KEY `fk_chart_account_class` (`class_id`);

--
-- Index pour la table `tbl_finance_exercice`
--
ALTER TABLE `tbl_finance_exercice`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_finance_journal_code`
--
ALTER TABLE `tbl_finance_journal_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `journal_code` (`journal_code`),
  ADD KEY `fk_journal_default_account` (`default_account_id`);

--
-- Index pour la table `tbl_stock_article`
--
ALTER TABLE `tbl_stock_article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_stock_emplacement`
--
ALTER TABLE `tbl_stock_emplacement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_stock_quantite`
--
ALTER TABLE `tbl_stock_quantite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `emplacement_id` (`emplacement_id`);

--
-- Index pour la table `technical_documents`
--
ALTER TABLE `technical_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_technical_documents_company` (`company_id`),
  ADD KEY `fk_technical_documents_project` (`project_id`),
  ADD KEY `fk_technical_documents_creator` (`created_by_user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_company` (`company_id`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- Index pour la table `user_permission_overrides`
--
ALTER TABLE `user_permission_overrides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_module` (`user_id`,`module_code`);

--
-- Index pour la table `weekly_payroll_lists`
--
ALTER TABLE `weekly_payroll_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_weekly_company` (`company_id`);

--
-- Index pour la table `workflow_validations`
--
ALTER TABLE `workflow_validations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_workflow_validations_company` (`company_id`),
  ADD KEY `fk_workflow_validations_user` (`validated_by_user_id`);

--
-- Index pour la table `workforce_contracts`
--
ALTER TABLE `workforce_contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_workforce_company` (`company_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accounting_accounts`
--
ALTER TABLE `accounting_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1084;

--
-- AUTO_INCREMENT pour la table `accounting_assistant_entries`
--
ALTER TABLE `accounting_assistant_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `accounting_entries`
--
ALTER TABLE `accounting_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `accounting_payments`
--
ALTER TABLE `accounting_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `accounting_period_closures`
--
ALTER TABLE `accounting_period_closures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2106;

--
-- AUTO_INCREMENT pour la table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `alert_escalations`
--
ALTER TABLE `alert_escalations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `approval_signatures`
--
ALTER TABLE `approval_signatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `assigned_tasks`
--
ALTER TABLE `assigned_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `budget_lines`
--
ALTER TABLE `budget_lines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cash_journal_entries`
--
ALTER TABLE `cash_journal_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `chantiers`
--
ALTER TABLE `chantiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `chantier_assignments`
--
ALTER TABLE `chantier_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `chantier_deliverables`
--
ALTER TABLE `chantier_deliverables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `chantier_evaluation_lines`
--
ALTER TABLE `chantier_evaluation_lines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `chantier_profitability`
--
ALTER TABLE `chantier_profitability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `chantier_tasks`
--
ALTER TABLE `chantier_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `client_portal_accounts`
--
ALTER TABLE `client_portal_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `client_project_updates`
--
ALTER TABLE `client_project_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `crm_prospects`
--
ALTER TABLE `crm_prospects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `daf_disbursement_approvals`
--
ALTER TABLE `daf_disbursement_approvals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `daf_fund_movements`
--
ALTER TABLE `daf_fund_movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `document_approvals`
--
ALTER TABLE `document_approvals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `document_approval_requests`
--
ALTER TABLE `document_approval_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `document_approval_steps`
--
ALTER TABLE `document_approval_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `external_messages`
--
ALTER TABLE `external_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `finances`
--
ALTER TABLE `finances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `finance_contract_situations`
--
ALTER TABLE `finance_contract_situations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `fuel_logs`
--
ALTER TABLE `fuel_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `immobilisations`
--
ALTER TABLE `immobilisations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `insurances`
--
ALTER TABLE `insurances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `internal_messages`
--
ALTER TABLE `internal_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `maintenance_logs`
--
ALTER TABLE `maintenance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `material_consumptions`
--
ALTER TABLE `material_consumptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mobile_reports`
--
ALTER TABLE `mobile_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `pointages`
--
ALTER TABLE `pointages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `production_cost_breakdowns`
--
ALTER TABLE `production_cost_breakdowns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `production_journals`
--
ALTER TABLE `production_journals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `purchase_request_forms`
--
ALTER TABLE `purchase_request_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=570;

--
-- AUTO_INCREMENT pour la table `purchase_request_items`
--
ALTER TABLE `purchase_request_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5519;

--
-- AUTO_INCREMENT pour la table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `role_permission_overrides`
--
ALTER TABLE `role_permission_overrides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `service_orders`
--
ALTER TABLE `service_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `situations`
--
ALTER TABLE `situations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `stock_issues`
--
ALTER TABLE `stock_issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `subcontractors`
--
ALTER TABLE `subcontractors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tbl_finance_accounting_entry`
--
ALTER TABLE `tbl_finance_accounting_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `tbl_finance_accounting_entry_line`
--
ALTER TABLE `tbl_finance_accounting_entry_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT pour la table `tbl_finance_account_class`
--
ALTER TABLE `tbl_finance_account_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `tbl_finance_chart_account`
--
ALTER TABLE `tbl_finance_chart_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `tbl_finance_exercice`
--
ALTER TABLE `tbl_finance_exercice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `tbl_finance_journal_code`
--
ALTER TABLE `tbl_finance_journal_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `tbl_stock_article`
--
ALTER TABLE `tbl_stock_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `tbl_stock_emplacement`
--
ALTER TABLE `tbl_stock_emplacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tbl_stock_quantite`
--
ALTER TABLE `tbl_stock_quantite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `technical_documents`
--
ALTER TABLE `technical_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `user_permission_overrides`
--
ALTER TABLE `user_permission_overrides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=797;

--
-- AUTO_INCREMENT pour la table `weekly_payroll_lists`
--
ALTER TABLE `weekly_payroll_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `workflow_validations`
--
ALTER TABLE `workflow_validations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `workforce_contracts`
--
ALTER TABLE `workforce_contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=800;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `accounting_accounts`
--
ALTER TABLE `accounting_accounts`
  ADD CONSTRAINT `fk_acc_accounts_company_sql` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `accounting_assistant_entries`
--
ALTER TABLE `accounting_assistant_entries`
  ADD CONSTRAINT `fk_assistant_entries_company_sql` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assistant_entries_user_sql` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `accounting_entries`
--
ALTER TABLE `accounting_entries`
  ADD CONSTRAINT `fk_acc_entries_company_sql` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `accounting_payments`
--
ALTER TABLE `accounting_payments`
  ADD CONSTRAINT `fk_acc_payments_company_sql` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `accounting_period_closures`
--
ALTER TABLE `accounting_period_closures`
  ADD CONSTRAINT `fk_acc_periods_company_sql` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_activity_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_activity_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `fk_alerts_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_alerts_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_alerts_task` FOREIGN KEY (`task_id`) REFERENCES `chantier_tasks` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `alert_escalations`
--
ALTER TABLE `alert_escalations`
  ADD CONSTRAINT `fk_alert_escalations_alert` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_alert_escalations_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `approval_signatures`
--
ALTER TABLE `approval_signatures`
  ADD CONSTRAINT `fk_approval_signatures_approval` FOREIGN KEY (`approval_id`) REFERENCES `document_approvals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_approval_signatures_user` FOREIGN KEY (`signed_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `assigned_tasks`
--
ALTER TABLE `assigned_tasks`
  ADD CONSTRAINT `fk_assigned_tasks_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_assigned_tasks_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assigned_tasks_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_assigned_tasks_user` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `fk_budgets_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_budgets_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `budget_lines`
--
ALTER TABLE `budget_lines`
  ADD CONSTRAINT `fk_budget_lines_budget` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_budget_lines_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_budget_lines_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cash_journal_entries`
--
ALTER TABLE `cash_journal_entries`
  ADD CONSTRAINT `fk_cash_journal_entries_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `chantiers`
--
ALTER TABLE `chantiers`
  ADD CONSTRAINT `fk_chantiers_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_chantiers_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `chantier_assignments`
--
ALTER TABLE `chantier_assignments`
  ADD CONSTRAINT `fk_assignment_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `chantier_deliverables`
--
ALTER TABLE `chantier_deliverables`
  ADD CONSTRAINT `fk_deliverables_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_deliverables_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `chantier_evaluation_lines`
--
ALTER TABLE `chantier_evaluation_lines`
  ADD CONSTRAINT `fk_eval_company_sql` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `chantier_profitability`
--
ALTER TABLE `chantier_profitability`
  ADD CONSTRAINT `fk_profitability_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_profitability_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `chantier_tasks`
--
ALTER TABLE `chantier_tasks`
  ADD CONSTRAINT `fk_tasks_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tasks_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_clients_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `client_portal_accounts`
--
ALTER TABLE `client_portal_accounts`
  ADD CONSTRAINT `fk_cpa_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cpa_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cpa_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cpa_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `client_project_updates`
--
ALTER TABLE `client_project_updates`
  ADD CONSTRAINT `fk_cpu_account` FOREIGN KEY (`client_portal_account_id`) REFERENCES `client_portal_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cpu_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cpu_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cpu_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `fk_companies_plan` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`);

--
-- Contraintes pour la table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `fk_contracts_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_contracts_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_contracts_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `crm_prospects`
--
ALTER TABLE `crm_prospects`
  ADD CONSTRAINT `fk_crm_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `daf_disbursement_approvals`
--
ALTER TABLE `daf_disbursement_approvals`
  ADD CONSTRAINT `fk_daf_disbursement_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `daf_fund_movements`
--
ALTER TABLE `daf_fund_movements`
  ADD CONSTRAINT `fk_daf_fund_movements_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `fk_documents_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_documents_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `document_approvals`
--
ALTER TABLE `document_approvals`
  ADD CONSTRAINT `fk_document_approvals_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_document_approvals_document` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_document_approvals_requester` FOREIGN KEY (`requested_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `document_approval_requests`
--
ALTER TABLE `document_approval_requests`
  ADD CONSTRAINT `fk_doc_approval_requests_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_doc_approval_requests_document` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_doc_approval_requests_user` FOREIGN KEY (`requested_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `document_approval_steps`
--
ALTER TABLE `document_approval_steps`
  ADD CONSTRAINT `fk_doc_approval_steps_request` FOREIGN KEY (`request_id`) REFERENCES `document_approval_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_doc_approval_steps_user` FOREIGN KEY (`signed_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employees_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_employees_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `equipments`
--
ALTER TABLE `equipments`
  ADD CONSTRAINT `fk_equipments_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_equipments_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `external_messages`
--
ALTER TABLE `external_messages`
  ADD CONSTRAINT `fk_external_company_sql` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `finances`
--
ALTER TABLE `finances`
  ADD CONSTRAINT `fk_finances_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `finance_contract_situations`
--
ALTER TABLE `finance_contract_situations`
  ADD CONSTRAINT `fk_finance_contract_situations_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fuel_logs`
--
ALTER TABLE `fuel_logs`
  ADD CONSTRAINT `fk_fuel_logs_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_fuel_logs_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_fuel_logs_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `immobilisations`
--
ALTER TABLE `immobilisations`
  ADD CONSTRAINT `fk_immobilisations_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `insurances`
--
ALTER TABLE `insurances`
  ADD CONSTRAINT `fk_insurances_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_insurances_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_insurances_immobilisation` FOREIGN KEY (`immobilisation_id`) REFERENCES `immobilisations` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `internal_messages`
--
ALTER TABLE `internal_messages`
  ADD CONSTRAINT `fk_internal_messages_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_internal_messages_sender` FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_invoices_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_invoices_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_invoices_contract` FOREIGN KEY (`linked_contract_id`) REFERENCES `contracts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_invoices_situation` FOREIGN KEY (`situation_id`) REFERENCES `situations` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `maintenance_logs`
--
ALTER TABLE `maintenance_logs`
  ADD CONSTRAINT `fk_maintenance_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_maintenance_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `material_consumptions`
--
ALTER TABLE `material_consumptions`
  ADD CONSTRAINT `fk_material_consumptions_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_material_consumptions_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_material_consumptions_stock` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_material_consumptions_task` FOREIGN KEY (`task_id`) REFERENCES `chantier_tasks` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `mobile_reports`
--
ALTER TABLE `mobile_reports`
  ADD CONSTRAINT `fk_mobile_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_mobile_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_alert` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_notifications_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payment_vouchers`
--
ALTER TABLE `payment_vouchers`
  ADD CONSTRAINT `fk_payment_vouchers_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `fk_payroll_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_payroll_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pointages`
--
ALTER TABLE `pointages`
  ADD CONSTRAINT `fk_pointages_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pointages_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pointages_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `production_cost_breakdowns`
--
ALTER TABLE `production_cost_breakdowns`
  ADD CONSTRAINT `fk_prod_cost_budget_line` FOREIGN KEY (`budget_line_id`) REFERENCES `budget_lines` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_prod_cost_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_prod_cost_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_prod_cost_task` FOREIGN KEY (`task_id`) REFERENCES `chantier_tasks` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `production_journals`
--
ALTER TABLE `production_journals`
  ADD CONSTRAINT `fk_production_journals_budget_line` FOREIGN KEY (`budget_line_id`) REFERENCES `budget_lines` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_production_journals_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_production_journals_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_production_journals_task` FOREIGN KEY (`task_id`) REFERENCES `chantier_tasks` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `fk_purchases_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD CONSTRAINT `fk_purchase_requests_budget_line` FOREIGN KEY (`budget_line_id`) REFERENCES `budget_lines` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_purchase_requests_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_purchase_requests_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_purchase_requests_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_purchase_requests_user` FOREIGN KEY (`requested_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `purchase_request_forms`
--
ALTER TABLE `purchase_request_forms`
  ADD CONSTRAINT `fk_purchase_request_forms_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `purchase_request_items`
--
ALTER TABLE `purchase_request_items`
  ADD CONSTRAINT `fk_purchase_request_items_request` FOREIGN KEY (`request_id`) REFERENCES `purchase_request_forms` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quotes`
--
ALTER TABLE `quotes`
  ADD CONSTRAINT `fk_quotes_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_quotes_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `service_orders`
--
ALTER TABLE `service_orders`
  ADD CONSTRAINT `fk_service_orders_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_service_orders_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_service_orders_contract` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_service_orders_subcontractor` FOREIGN KEY (`subcontractor_id`) REFERENCES `subcontractors` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `situations`
--
ALTER TABLE `situations`
  ADD CONSTRAINT `fk_situations_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_situations_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_situations_contract` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `fk_stocks_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `stock_issues`
--
ALTER TABLE `stock_issues`
  ADD CONSTRAINT `fk_stock_issues_chantier` FOREIGN KEY (`chantier_id`) REFERENCES `chantiers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stock_issues_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stock_issues_stock` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD CONSTRAINT `fk_stock_transfers_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stock_transfers_source` FOREIGN KEY (`source_stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stock_transfers_target` FOREIGN KEY (`target_stock_id`) REFERENCES `stocks` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `subcontractors`
--
ALTER TABLE `subcontractors`
  ADD CONSTRAINT `fk_subcontractors_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `fk_suppliers_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tbl_finance_accounting_entry_line`
--
ALTER TABLE `tbl_finance_accounting_entry_line`
  ADD CONSTRAINT `fk_entry` FOREIGN KEY (`entry_id`) REFERENCES `tbl_finance_accounting_entry` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tbl_finance_chart_account`
--
ALTER TABLE `tbl_finance_chart_account`
  ADD CONSTRAINT `fk_chart_account_class` FOREIGN KEY (`class_id`) REFERENCES `tbl_finance_account_class` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tbl_finance_journal_code`
--
ALTER TABLE `tbl_finance_journal_code`
  ADD CONSTRAINT `fk_journal_default_account` FOREIGN KEY (`default_account_id`) REFERENCES `tbl_finance_chart_account` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `tbl_stock_quantite`
--
ALTER TABLE `tbl_stock_quantite`
  ADD CONSTRAINT `tbl_stock_quantite_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `tbl_stock_article` (`id`),
  ADD CONSTRAINT `tbl_stock_quantite_ibfk_2` FOREIGN KEY (`emplacement_id`) REFERENCES `tbl_stock_emplacement` (`id`);

--
-- Contraintes pour la table `technical_documents`
--
ALTER TABLE `technical_documents`
  ADD CONSTRAINT `fk_technical_documents_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_technical_documents_creator` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_technical_documents_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Contraintes pour la table `user_permission_overrides`
--
ALTER TABLE `user_permission_overrides`
  ADD CONSTRAINT `fk_user_perm_user_sql` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `weekly_payroll_lists`
--
ALTER TABLE `weekly_payroll_lists`
  ADD CONSTRAINT `fk_weekly_company_sql` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `workflow_validations`
--
ALTER TABLE `workflow_validations`
  ADD CONSTRAINT `fk_workflow_validations_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_workflow_validations_user` FOREIGN KEY (`validated_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `workforce_contracts`
--
ALTER TABLE `workforce_contracts`
  ADD CONSTRAINT `fk_workforce_company_sql` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
