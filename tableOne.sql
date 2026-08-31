-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 31 août 2026 à 11:01
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
-- Structure de la table `tbl_finance_regularisations`
--

CREATE TABLE `tbl_finance_regularisations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT 2,
  `reference` varchar(40) NOT NULL,
  `purchase_request_id` int(11) NOT NULL,
  `payment_voucher_id` int(11) DEFAULT NULL,
  `regularisation_type` enum('retour','supplement','exact') NOT NULL,
  `amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `regularisation_date` date NOT NULL,
  `concerned` varchar(191) DEFAULT NULL,
  `receipt_number` varchar(100) DEFAULT NULL,
  `justification` varchar(255) NOT NULL,
  `observation` text DEFAULT NULL,
  `status` enum('validated','pending','cancelled') NOT NULL DEFAULT 'validated',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_finance_regularisations`
--

INSERT INTO `tbl_finance_regularisations` (`id`, `company_id`, `reference`, `purchase_request_id`, `payment_voucher_id`, `regularisation_type`, `amount`, `regularisation_date`, `concerned`, `receipt_number`, `justification`, `observation`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'REG-2026-0001', 1094, 8, 'retour', 50000.00, '2026-08-19', 'Severin', '', 'retour en caisse', NULL, 'validated', 22, '2026-08-19 09:42:45', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tbl_finance_regularisations`
--
ALTER TABLE `tbl_finance_regularisations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_regularisation_reference` (`reference`),
  ADD KEY `idx_regularisation_request` (`purchase_request_id`),
  ADD KEY `idx_regularisation_type` (`regularisation_type`),
  ADD KEY `idx_regularisation_date` (`regularisation_date`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tbl_finance_regularisations`
--
ALTER TABLE `tbl_finance_regularisations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
