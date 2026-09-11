-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 11 sep. 2026 à 13:58
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
-- Structure de la table `tbl_relation_publique`
--

CREATE TABLE `tbl_relation_publique` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(50) NOT NULL COMMENT 'Numéro de sortie (SC-2026-XXX)',
  `beneficiaire` varchar(150) NOT NULL,
  `montant` decimal(20,2) NOT NULL DEFAULT 0.00,
  `motif` text NOT NULL,
  `date_sortie` date NOT NULL,
  `autorise_par` varchar(50) NOT NULL COMMENT 'dg, daf, admin',
  `autorise_par_nom` varchar(150) DEFAULT NULL,
  `reference_doc` varchar(100) DEFAULT NULL COMMENT 'Référence documentaire',
  `observation` text DEFAULT NULL,
  `status` enum('en_attente','valide','rejete') NOT NULL DEFAULT 'valide',
  `company_id` int(11) NOT NULL DEFAULT 2,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by_nom` varchar(150) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tbl_relation_publique`
--
ALTER TABLE `tbl_relation_publique`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reference` (`reference`),
  ADD KEY `idx_date` (`date_sortie`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tbl_relation_publique`
--
ALTER TABLE `tbl_relation_publique`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
