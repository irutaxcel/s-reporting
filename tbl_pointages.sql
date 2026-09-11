-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 31 août 2026 à 13:26
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
-- Structure de la table `tbl_pointages`
--

CREATE TABLE `tbl_pointages` (
  `pointage_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `date_pointage` date NOT NULL,
  `heure_entree` time DEFAULT NULL,
  `heure_sortie` time DEFAULT NULL,
  `heures_sup` decimal(4,1) NOT NULL DEFAULT 0.0,
  `situation` varchar(40) NOT NULL DEFAULT 'Présent',
  `justificatif` varchar(255) DEFAULT NULL,
  `motif` text DEFAULT NULL,
  `encode_par` varchar(100) DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_pointages`
--

INSERT INTO `tbl_pointages` (`pointage_id`, `employe_id`, `date_pointage`, `heure_entree`, `heure_sortie`, `heures_sup`, `situation`, `justificatif`, `motif`, `encode_par`, `cree_le`) VALUES
(1, 59, '2026-08-31', '07:30:00', '17:00:00', 0.0, 'Demi-journée', 'uploads/rh/pointages/pointage_1788173467_6a955c9bdebb5.pdf', 'Je vais utiliser ', NULL, '2026-08-31 10:51:07'),
(2, 58, '2026-08-31', '07:30:00', '17:00:00', 2.0, 'Présent', 'uploads/rh/pointages/pointage_1788173791_6a955ddf8b39e.pdf', 'je vais essayer aussi kabisa', NULL, '2026-08-31 10:56:31'),
(3, 1, '2026-08-21', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(4, 16, '2026-08-21', '07:00:00', '17:00:00', 2.0, 'Présent', NULL, 'Avancement dalle niveau 2', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(5, 22, '2026-08-21', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(6, 36, '2026-08-21', '07:15:00', '17:00:00', 0.0, 'Retard', NULL, 'Retard 15 min — trafic', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(7, 1, '2026-08-24', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(8, 3, '2026-08-24', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(9, 4, '2026-08-24', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(10, 5, '2026-08-24', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(11, 7, '2026-08-24', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(12, 9, '2026-08-24', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(13, 16, '2026-08-24', '07:00:00', '17:00:00', 1.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(14, 22, '2026-08-24', '07:00:00', '17:00:00', 2.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(15, 27, '2026-08-24', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(16, 36, '2026-08-24', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(17, 1, '2026-08-25', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(18, 3, '2026-08-25', '08:05:00', '16:30:00', 0.0, 'Retard', NULL, 'Retard 35 min', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(19, 4, '2026-08-25', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(20, 5, '2026-08-25', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(21, 7, '2026-08-25', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(22, 9, '2026-08-25', '07:30:00', '12:30:00', 0.0, 'Demi-journée', NULL, 'RDV médical', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(23, 16, '2026-08-25', '07:00:00', '17:00:00', 1.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(24, 22, '2026-08-25', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(25, 27, '2026-08-25', NULL, NULL, 0.0, 'Absence non justifiée', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(26, 36, '2026-08-25', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(27, 1, '2026-08-26', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(28, 3, '2026-08-26', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(29, 4, '2026-08-26', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(30, 5, '2026-08-26', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(31, 7, '2026-08-26', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(32, 9, '2026-08-26', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(33, 16, '2026-08-26', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(34, 22, '2026-08-26', '07:00:00', '17:00:00', 3.0, 'Présent', NULL, 'Levage de poutres — heures sup', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(35, 27, '2026-08-26', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(36, 36, '2026-08-26', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(37, 1, '2026-08-27', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(38, 3, '2026-08-27', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(39, 4, '2026-08-27', '07:50:00', '16:30:00', 0.0, 'Retard', NULL, 'Retard 20 min', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(40, 5, '2026-08-27', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(41, 7, '2026-08-27', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(42, 9, '2026-08-27', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(43, 16, '2026-08-27', '07:00:00', '17:00:00', 1.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(44, 22, '2026-08-27', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(45, 27, '2026-08-27', '07:00:00', '17:00:00', 1.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(46, 36, '2026-08-27', NULL, NULL, 0.0, 'Absence justifiée', 'uploads/rh/pointages/certificat_20260827.pdf', 'Maladie — certificat médical', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(47, 1, '2026-08-28', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(48, 3, '2026-08-28', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(49, 4, '2026-08-28', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(50, 5, '2026-08-28', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(51, 7, '2026-08-28', '07:30:00', '12:30:00', 0.0, 'Demi-journée', NULL, 'Formation HSE', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(52, 9, '2026-08-28', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(53, 16, '2026-08-28', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(54, 22, '2026-08-28', '07:00:00', '17:00:00', 2.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(55, 27, '2026-08-28', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(56, 36, '2026-08-28', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(57, 16, '2026-08-29', '07:00:00', '17:00:00', 4.0, 'Présent', NULL, 'Samedi chantier — heures majorées', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(58, 22, '2026-08-29', '07:00:00', '17:00:00', 4.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(59, 27, '2026-08-29', '07:00:00', '17:00:00', 4.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(60, 36, '2026-08-29', '07:00:00', '17:00:00', 4.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(61, 1, '2026-08-29', '07:00:00', '12:00:00', 0.0, 'Présent', NULL, 'Mission terrain Ngagara II', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(62, 4, '2026-08-29', NULL, NULL, 0.0, 'Absence justifiée', 'uploads/rh/pointages/autorisation_20260829.pdf', 'Autorisation spéciale week-end', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(63, 1, '2026-08-31', '07:28:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(64, 3, '2026-08-31', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(65, 4, '2026-08-31', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(66, 5, '2026-08-31', '08:10:00', '16:30:00', 0.0, 'Retard', NULL, 'Retard 40 min', 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(67, 7, '2026-08-31', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(68, 9, '2026-08-31', '07:30:00', '16:30:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(69, 16, '2026-08-31', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(70, 22, '2026-08-31', '07:00:00', '17:00:00', 1.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(71, 27, '2026-08-31', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59'),
(72, 36, '2026-08-31', '07:00:00', '17:00:00', 0.0, 'Présent', NULL, NULL, 'J.-M. NDAYIZEYE', '2026-08-31 11:07:59');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tbl_pointages`
--
ALTER TABLE `tbl_pointages`
  ADD PRIMARY KEY (`pointage_id`),
  ADD UNIQUE KEY `uniq_pointage` (`employe_id`,`date_pointage`),
  ADD KEY `idx_pointage_date` (`date_pointage`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tbl_pointages`
--
ALTER TABLE `tbl_pointages`
  MODIFY `pointage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tbl_pointages`
--
ALTER TABLE `tbl_pointages`
  ADD CONSTRAINT `fk_pointage_employe` FOREIGN KEY (`employe_id`) REFERENCES `tbl_employes` (`employe_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
