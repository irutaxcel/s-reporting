-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 24 sep. 2026 à 14:39
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
-- Structure de la table `tbl_crm_contrats`
--

CREATE TABLE `tbl_crm_contrats` (
  `id` int(11) NOT NULL,
  `projet_id` int(11) NOT NULL,
  `chantier_id` int(11) NOT NULL,
  `numero_contrat` varchar(50) NOT NULL,
  `type_contrat` enum('marche_public','gre_a_gre','appel_offres','contrat_prive') NOT NULL,
  `montant` decimal(15,2) NOT NULL DEFAULT 0.00,
  `date_signature` date NOT NULL,
  `date_fin_prevue` date DEFAULT NULL,
  `delai_realisation` int(11) DEFAULT NULL,
  `fichier_contrat` varchar(255) DEFAULT NULL,
  `clauses` text DEFAULT NULL,
  `statut` enum('brouillon','signe','en_cours','termine','resilie') NOT NULL DEFAULT 'signe',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tbl_crm_contrats`
--

INSERT INTO `tbl_crm_contrats` (`id`, `projet_id`, `chantier_id`, `numero_contrat`, `type_contrat`, `montant`, `date_signature`, `date_fin_prevue`, `delai_realisation`, `fichier_contrat`, `clauses`, `statut`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 46, 1, '111', 'gre_a_gre', 2000000.00, '2026-09-24', '2026-10-04', 12, 'uploads/contrats/CNT_1790250176_6ab50cc09797f.pdf', '', 'signe', '2026-09-24 13:42:56', '2026-09-24 13:42:56', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tbl_crm_contrats`
--
ALTER TABLE `tbl_crm_contrats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_numero_contrat` (`numero_contrat`),
  ADD KEY `idx_projet` (`projet_id`),
  ADD KEY `idx_chantier` (`chantier_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tbl_crm_contrats`
--
ALTER TABLE `tbl_crm_contrats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
