-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 31 août 2026 à 10:46
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
-- Structure de la table `tbl_conges`
--

CREATE TABLE `tbl_conges` (
  `conge_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `type_conge` varchar(50) NOT NULL DEFAULT 'Congé annuel',
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `jours_ouvres` int(11) NOT NULL DEFAULT 0,
  `remplacant_id` int(11) DEFAULT NULL,
  `justificatif` varchar(255) DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `statut` enum('En attente','Approuvé','Rejeté') NOT NULL DEFAULT 'En attente',
  `encode_par` varchar(100) DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_conges`
--

INSERT INTO `tbl_conges` (`conge_id`, `employe_id`, `type_conge`, `date_debut`, `date_fin`, `jours_ouvres`, `remplacant_id`, `justificatif`, `observation`, `statut`, `encode_par`, `cree_le`) VALUES
(1, 58, 'Congé annuel', '2026-08-03', '2026-08-07', 5, 53, 'uploads/rh/conges/conge_1787731998_6a8ea01ee468e.pdf', 'je veux faire une test ici', 'En attente', NULL, '2026-08-26 08:13:18');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_contrats`
--

CREATE TABLE `tbl_contrats` (
  `contrat_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `operation` varchar(50) NOT NULL DEFAULT 'Nouveau contrat',
  `type_contrat` enum('CDI','CDD','Stage') NOT NULL DEFAULT 'CDI',
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `periode_essai` varchar(20) DEFAULT NULL,
  `fonction` varchar(100) NOT NULL,
  `salaire_base` decimal(12,2) NOT NULL DEFAULT 0.00,
  `site_affectation` varchar(100) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `statut` enum('Actif','Expiré','Renouvelé','Résilié') NOT NULL DEFAULT 'Actif',
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_contrats`
--

INSERT INTO `tbl_contrats` (`contrat_id`, `employe_id`, `operation`, `type_contrat`, `date_debut`, `date_fin`, `periode_essai`, `fonction`, `salaire_base`, `site_affectation`, `document`, `observations`, `statut`, `cree_le`) VALUES
(1, 58, 'Renouvellement', 'CDD', '2026-01-01', '2026-12-31', '3 mois', 'Secrétaire de chantier', 20000000.00, 'Siège (Bujumbura)', 'uploads/rh/contrats/contrat_1787654543_6a8d718fa1590.pdf', 'je fais un test icic', 'Actif', '2026-08-25 10:42:23'),
(2, 1, 'Nouveau contrat', 'CDI', '2020-03-02', NULL, '6 mois', 'Responsable RH & Suivi-Évaluation', 1850000.00, 'Siège (Bujumbura)', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(3, 2, 'Nouveau contrat', 'CDI', '2023-02-03', NULL, '3 mois', 'Secrétaire de direction', 950000.00, 'Siège (Bujumbura)', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(4, 3, 'Nouveau contrat', 'CDI', '2026-08-01', NULL, '3 mois', 'Designer', 200000.00, 'Siège (Bujumbura)', NULL, 'Période d\'essai en cours', 'Actif', '2026-08-25 13:10:27'),
(5, 4, 'Nouveau contrat', 'CDI', '2019-05-06', NULL, '6 mois', 'Directeur administratif et financier', 2500000.00, 'Siège (Bujumbura)', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(6, 5, 'Nouveau contrat', 'CDD', '2023-09-04', '2024-12-31', '3 mois', 'Assistante comptable', 700000.00, 'Siège (Bujumbura)', NULL, 'Premier CDD', 'Renouvelé', '2026-08-25 13:10:27'),
(7, 5, 'Renouvellement', 'CDD', '2025-01-01', '2026-12-31', 'Aucune', 'Assistante comptable', 700000.00, 'Siège (Bujumbura)', NULL, 'Renouvellement 2025', 'Actif', '2026-08-25 13:10:27'),
(8, 6, 'Nouveau contrat', 'CDI', '2021-02-15', NULL, '6 mois', 'Ingénieur génie civil', 1600000.00, 'Siège (Bujumbura)', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(9, 7, 'Nouveau contrat', 'CDD', '2024-01-08', '2026-09-30', '3 mois', 'Réceptionniste / standardiste', 550000.00, 'Siège (Bujumbura)', NULL, 'CDD en cours — à traiter', 'Actif', '2026-08-25 13:10:27'),
(10, 8, 'Nouveau contrat', 'CDI', '2020-10-01', NULL, '6 mois', 'Architecte', 1700000.00, 'Siège (Bujumbura)', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(11, 9, 'Nouveau contrat', 'CDI', '2022-06-01', NULL, '3 mois', 'Chargée de paie', 900000.00, 'Siège (Bujumbura)', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(12, 10, 'Nouveau contrat', 'CDI', '2019-11-12', NULL, '6 mois', 'Responsable logistique', 1500000.00, 'Siège (Bujumbura)', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(13, 12, 'Nouveau contrat', 'CDD', '2023-05-02', '2026-08-31', '3 mois', 'Dessinateur projeteur', 800000.00, 'Siège (Bujumbura)', NULL, 'CDD expire J-6', 'Actif', '2026-08-25 13:10:27'),
(14, 16, 'Nouveau contrat', 'CDI', '2019-09-16', NULL, '6 mois', 'Chef de chantier', 1400000.00, 'Chantier Ngagara II', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(15, 18, 'Nouveau contrat', 'CDI', '2020-01-20', NULL, '6 mois', 'Chef d\'équipe maçonnerie', 850000.00, 'Chantier Ngagara II', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(16, 22, 'Nouveau contrat', 'CDI', '2021-06-07', NULL, '6 mois', 'Grutier', 900000.00, 'Chantier Ngagara II', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(17, 27, 'Nouveau contrat', 'CDD', '2024-02-19', '2026-08-20', '3 mois', 'Peintre', 500000.00, 'Chantier Ngagara II', NULL, 'CDD expire J-…', 'Actif', '2026-08-25 13:10:27'),
(18, 28, 'Nouveau contrat', 'CDI', '2020-03-09', NULL, '6 mois', 'Chef de chantier', 1300000.00, 'Chantier Gitega', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(19, 39, 'Nouveau contrat', 'CDI', '2019-12-02', NULL, '6 mois', 'Chef de chantier', 1300000.00, 'Chantier Ngozi', NULL, 'Contrat initial', 'Actif', '2026-08-25 13:10:27'),
(20, 56, 'Nouveau contrat', 'CDD', '2023-03-13', '2026-08-10', '3 mois', 'Maçon', 450000.00, 'Chantier Ngozi', NULL, 'Arrivé à échéance — non renouvelé', 'Expiré', '2026-08-25 13:10:27'),
(21, 57, 'Nouveau contrat', 'CDD', '2024-09-09', '2027-09-08', '3 mois', 'Secrétaire de chantier', 600000.00, 'Chantier Ngozi', NULL, 'Contrat en cours', 'Actif', '2026-08-25 13:10:27');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_discipline`
--

CREATE TABLE `tbl_discipline` (
  `dossier_id` int(11) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `type_faute` varchar(100) NOT NULL,
  `date_fait` date NOT NULL,
  `lieu` varchar(100) DEFAULT NULL,
  `signale_par` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `sanction_proposee` varchar(100) DEFAULT NULL,
  `pieces` varchar(255) DEFAULT NULL,
  `statut` enum('Ouvert','Audience planifiée','Clôturé') NOT NULL DEFAULT 'Ouvert',
  `sanction_finale` varchar(100) DEFAULT NULL,
  `encode_par` varchar(100) DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_discipline`
--

INSERT INTO `tbl_discipline` (`dossier_id`, `reference`, `employe_id`, `type_faute`, `date_fait`, `lieu`, `signale_par`, `description`, `sanction_proposee`, `pieces`, `statut`, `sanction_finale`, `encode_par`, `cree_le`) VALUES
(1, 'DIS-2026-001', 56, 'Absence non justifiée', '2026-08-20', 'Siège (Bujumbura)', '', 'je fait de test kandi', 'Blâme verbal', 'uploads/rh/discipline/dossier_1787826204_6a90101cdd157.pdf', 'Ouvert', NULL, NULL, '2026-08-27 10:23:24'),
(2, 'DIS-2025-001', 18, 'Retard non justifié', '2025-02-11', 'Chantier Ngagara II', 'Chef de chantier', 'Trois retards non justifiés durant le mois de janvier 2025.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(3, 'DIS-2025-002', 27, 'Absence non justifiée', '2025-03-17', 'Chantier Ngagara II', 'Chef de chantier', 'Absence d\'une journée sans autorisation ni justificatif.', 'Avertissement écrit', NULL, 'Clôturé', 'Avertissement écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(4, 'DIS-2025-003', 31, 'Non-respect des consignes de sécurité', '2025-04-22', 'Chantier Gitega', 'Superviseur HSE', 'Travail sans casque sur la dalle du 2e étage.', 'Suspension', NULL, 'Clôturé', 'Suspension 2 jours', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(5, 'DIS-2025-004', 43, 'Autre', '2025-05-30', 'Chantier Ngozi', 'Chef d\'équipe', 'Utilisation du téléphone pendant la manœuvre.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(6, 'DIS-2025-005', 56, 'Retard non justifié', '2025-06-12', 'Chantier Ngozi', 'Chef de chantier', 'Retards répétés (4) au cours du mois de juin.', 'Avertissement écrit', NULL, 'Clôturé', 'Avertissement écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(7, 'DIS-2025-006', 22, 'Non-respect des consignes de sécurité', '2025-07-08', 'Chantier Ngagara II', 'Superviseur HSE', 'Grue laissée sans coupe-circuit en fin de journée.', 'Blâme écrit', NULL, 'Clôturé', 'Blâme écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(8, 'DIS-2025-007', 14, 'Retard non justifié', '2025-08-19', 'Siège (Bujumbura)', 'DAF', 'Deux retards non justifiés en août.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(9, 'DIS-2025-008', 36, 'Absence non justifiée', '2025-09-25', 'Chantier Gitega', 'Chef de chantier', 'Absence de deux jours sans nouvelle.', 'Suspension', NULL, 'Clôturé', 'Suspension 3 jours', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(10, 'DIS-2025-009', 50, 'Autre', '2025-10-14', 'Chantier Ngagara II', 'Chef de chantier', 'Outils non rangés au magasin en fin de semaine.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(11, 'DIS-2025-010', 5, 'Retard non justifié', '2025-11-06', 'Siège (Bujumbura)', 'DAF', 'Retard de plus d\'une heure sans justification.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(12, 'DIS-2026-002', 23, 'Autre', '2026-03-12', 'Chantier Ngagara II', 'Chef de chantier', 'Altercation légère avec un collègue.', 'Blâme écrit', NULL, 'Clôturé', 'Blâme écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(13, 'DIS-2026-003', 36, 'Retard non justifié', '2026-07-14', 'Chantier Gitega', 'Chef de chantier', 'Récidive : trois retards en juillet.', 'Avertissement écrit', NULL, 'Clôturé', 'Avertissement écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(14, 'DIS-2026-004', 43, 'Non-respect des consignes de sécurité', '2026-08-02', 'Chantier Gitega', 'Superviseur HSE', 'Travail sous tension sans EPI adapté.', 'Suspension', 'uploads/rh/discipline/rapport_hse_082026.pdf', 'Clôturé', 'Suspension 5 jours', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(15, 'DIS-2026-005', 3, 'Retard non justifié', '2026-08-20', 'Siège (Bujumbura)', 'Responsable RH', 'Trois retards en août (06, 13, 20).', 'Avertissement écrit', NULL, 'Audience planifiée', NULL, 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(16, 'DIS-2026-006', 27, 'Absence non justifiée', '2026-08-21', 'Chantier Ngagara II', 'Chef de chantier', 'Absence non justifiée le 21/08/2026.', 'Avertissement écrit', NULL, 'Ouvert', NULL, 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(17, 'DIS-2026-007', 24, 'Retard non justifié', '2026-01-15', 'Chantier Ngagara II', 'Chef de chantier', 'Retard d\'une heure sans justification.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(18, 'DIS-2026-008', 47, 'Absence non justifiée', '2026-02-03', 'Chantier Ngozi', 'Chef de chantier', 'Absence d\'une demi-journée.', 'Blâme écrit', NULL, 'Clôturé', 'Blâme écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(19, 'DIS-2026-009', 32, 'Non-respect des consignes de sécurité', '2026-02-18', 'Chantier Gitega', 'Superviseur HSE', 'Soudure sans écran de protection.', 'Suspension', NULL, 'Clôturé', 'Suspension 1 jour', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(20, 'DIS-2026-010', 53, 'Retard non justifié', '2026-03-05', 'Siège (Bujumbura)', 'DAF', 'Retards répétés en février.', 'Avertissement écrit', NULL, 'Clôturé', 'Avertissement écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(21, 'DIS-2026-011', 48, 'Autre', '2026-03-22', 'Chantier Ngozi', 'Chef d\'équipe', 'Départ du chantier avant la fin de la journée.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(22, 'DIS-2026-012', 16, 'Insubordination', '2026-04-09', 'Chantier Ngagara II', 'Direction Technique', 'Refus d\'exécuter une instruction liée à la sécurité.', 'Suspension', 'uploads/rh/discipline/rapport_0409.pdf', 'Clôturé', 'Suspension 3 jours', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(23, 'DIS-2026-013', 52, 'Retard non justifié', '2026-04-27', 'Siège (Bujumbura)', 'Direction Générale', 'Retard non justifié le 27/04.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(24, 'DIS-2026-014', 37, 'Non-respect des consignes de sécurité', '2026-05-11', 'Chantier Gitega', 'Superviseur HSE', 'Zone de levage non balisée.', 'Avertissement écrit', NULL, 'Clôturé', 'Avertissement écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(25, 'DIS-2026-015', 41, 'Autre', '2026-05-26', 'Chantier Ngozi', 'Chef de chantier', 'Mauvaise gestion du stock de ciment (perte).', 'Blâme écrit', NULL, 'Clôturé', 'Blâme écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(26, 'DIS-2026-016', 7, 'Retard non justifié', '2026-06-08', 'Siège (Bujumbura)', 'Direction Générale', 'Retard de 45 min sans préavis.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(27, 'DIS-2026-017', 28, 'Insubordination', '2026-06-19', 'Chantier Gitega', 'Chef de chantier', 'Refus de pointage contradictoire.', 'Suspension', NULL, 'Clôturé', 'Suspension 2 jours', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(28, 'DIS-2026-018', 46, 'Absence non justifiée', '2026-07-02', 'Chantier Ngozi', 'Chef de chantier', 'Absence de deux jours (30/06 – 01/07).', 'Suspension', NULL, 'Clôturé', 'Suspension 4 jours', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(29, 'DIS-2026-019', 8, 'Autre', '2026-07-15', 'Siège (Bujumbura)', 'Direction Technique', 'Erreur de plan non signalée ayant causé un retard.', 'Blâme écrit', NULL, 'Clôturé', 'Blâme écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(30, 'DIS-2026-020', 36, 'Absence non justifiée', '2026-08-05', 'Chantier Gitega', 'Chef de chantier', 'Absence d\'une journée — récidive sur 12 mois.', 'Suspension', NULL, 'Audience planifiée', NULL, 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(31, 'DIS-2026-021', 58, 'Retard non justifié', '2026-08-10', 'Siège (Bujumbura)', 'Direction Générale', 'Deux retards en août.', 'Blâme verbal', NULL, 'Ouvert', NULL, 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(32, 'DIS-2026-022', 22, 'Non-respect des consignes de sécurité', '2026-08-12', 'Chantier Ngagara II', 'Superviseur HSE', 'Charge suspendue laissée sans surveillance.', 'Suspension', NULL, 'Ouvert', NULL, 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(33, 'DIS-2026-023', 12, 'Retard non justifié', '2026-01-28', 'Siège (Bujumbura)', 'Direction Technique', 'Retard non justifié le 28/01.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(34, 'DIS-2026-024', 59, 'Autre', '2026-02-14', 'Siège (Bujumbura)', 'Responsable RH', 'Non-respect de la procédure de classement des plans.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(35, 'DIS-2026-025', 18, 'Non-respect des consignes de sécurité', '2026-03-30', 'Chantier Ngagara II', 'Superviseur HSE', 'Échafaudage monté sans vérification.', 'Avertissement écrit', NULL, 'Clôturé', 'Avertissement écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(36, 'DIS-2026-026', 50, 'Autre', '2026-04-16', 'Chantier Ngagara II', 'Chef de chantier', 'Engin non entretenu (panne évitable).', 'Blâme écrit', NULL, 'Clôturé', 'Blâme écrit', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(37, 'DIS-2026-027', 31, 'Non-respect des consignes de sécurité', '2026-05-21', 'Chantier Gitega', 'Superviseur HSE', 'Récidive : travail sans harnais en hauteur.', 'Suspension', NULL, 'Clôturé', 'Suspension 6 jours', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(38, 'DIS-2026-028', 56, 'Vol / destruction volontaire', '2026-06-24', 'Chantier Ngozi', 'Gardien', 'Vol d\'outillage — enquête interne.', 'Licenciement pour faute grave', 'uploads/rh/discipline/pv_enquete_0626.pdf', 'Clôturé', 'Licenciement pour faute grave', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(39, 'DIS-2026-029', 57, 'Retard non justifié', '2026-07-20', 'Chantier Ngozi', 'Chef de chantier', 'Retard non justifié le 20/07.', 'Blâme verbal', NULL, 'Clôturé', 'Blâme verbal', 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(40, 'DIS-2026-030', 14, 'Autre', '2026-08-18', 'Siège (Bujumbura)', 'DAF', 'Erreur de caisse non signalée.', 'Blâme écrit', NULL, 'Ouvert', NULL, 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31'),
(41, 'DIS-2026-031', 43, 'Retard non justifié', '2026-08-24', 'Chantier Ngozi', 'Chef de chantier', 'Retard de plus d\'une heure.', 'Blâme verbal', NULL, 'Ouvert', NULL, 'J.-M. NDAYIZEYE', '2026-08-27 10:36:31');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_employes`
--

CREATE TABLE `tbl_employes` (
  `employe_id` int(11) NOT NULL,
  `matricule` varchar(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenoms` varchar(100) NOT NULL,
  `sexe` enum('Masculin','Féminin') NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `etat_civil` varchar(20) DEFAULT NULL,
  `cnid` varchar(30) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `categorie` enum('Bureau','Chantier') NOT NULL DEFAULT 'Bureau',
  `fonction` varchar(100) NOT NULL,
  `departement` varchar(100) DEFAULT NULL,
  `site_affectation` varchar(100) DEFAULT NULL,
  `date_embauche` date NOT NULL,
  `type_contrat` enum('CDI','CDD','Stage') NOT NULL DEFAULT 'CDI',
  `date_fin_contrat` date DEFAULT NULL,
  `periode_essai` varchar(20) DEFAULT NULL,
  `salaire_base` decimal(12,2) NOT NULL DEFAULT 0.00,
  `mode_paiement` varchar(30) DEFAULT 'Virement bancaire',
  `matricule_inss` varchar(30) DEFAULT NULL,
  `numero_contribuable` varchar(30) DEFAULT NULL,
  `doc_cnid` varchar(255) DEFAULT NULL,
  `doc_photo` varchar(255) DEFAULT NULL,
  `doc_contrat` varchar(255) DEFAULT NULL,
  `doc_cv` varchar(255) DEFAULT NULL,
  `statut` enum('Actif','En congé','Suspendu','Fin de contrat') NOT NULL DEFAULT 'Actif',
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifie_le` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_employes`
--

INSERT INTO `tbl_employes` (`employe_id`, `matricule`, `nom`, `prenoms`, `sexe`, `date_naissance`, `etat_civil`, `cnid`, `telephone`, `email`, `adresse`, `categorie`, `fonction`, `departement`, `site_affectation`, `date_embauche`, `type_contrat`, `date_fin_contrat`, `periode_essai`, `salaire_base`, `mode_paiement`, `matricule_inss`, `numero_contribuable`, `doc_cnid`, `doc_photo`, `doc_contrat`, `doc_cv`, `statut`, `cree_le`, `modifie_le`) VALUES
(1, 'SAT-0001', 'NDAYIZEYE', 'Jean-Marie', 'Masculin', NULL, 'Marié(e)', '1985010112345', '+257 79 100 001', 'j.ndayizeye@satraco.bi', 'Ngagara, Bujumbura', 'Bureau', 'Responsable RH & Suivi-Évaluation', 'Ressources Humaines', 'Siège (Bujumbura)', '2020-03-02', 'CDI', NULL, '6 mois', 1850000.00, 'Virement bancaire', '102456', '401234567', NULL, NULL, NULL, NULL, 'Actif', '2026-08-11 07:16:34', '2026-08-11 07:16:34'),
(2, 'SAT-0007', 'INGABIRE', 'Espérance', 'Féminin', NULL, 'Marié(e)', '1990051412346', '+257 79 100 007', 'e.ingabire@satraco.bi', 'Rohero, Bujumbura', 'Bureau', 'Secrétaire de direction', 'Direction Générale', 'Siège (Bujumbura)', '2023-02-03', 'CDI', NULL, '3 mois', 950000.00, 'Virement bancaire', '102890', '401234568', NULL, NULL, NULL, NULL, 'Actif', '2026-08-11 07:16:34', '2026-08-11 07:16:34'),
(3, 'SAT-0008', 'Aymar', 'KIGABIRO', 'Masculin', NULL, 'Célibataire', '', '+25776352700', 'aymardkigabiro@gmail.com', 'Burundi', 'Bureau', 'Designner', 'Direction Générale', 'Siège (Bujumbura)', '2026-08-01', 'CDI', '2026-10-25', '3 mois', 200000.00, 'Virement bancaire', '12233', '12234', 'uploads/rh/employes/doc_cnid_1786440440_6a7aeaf8a3a08.png', 'uploads/rh/employes/doc_photo_1786440440_6a7aeaf8a4ec9.png', NULL, NULL, 'Actif', '2026-08-11 09:27:20', '2026-08-11 09:27:20'),
(4, 'SAT-0009', 'NIMUBONA', 'Thierry', 'Masculin', '1988-07-12', 'Marié(e)', '1988071212301', '+257 79 200 009', 't.nimubona@satraco.bi', 'Gihosha, Bujumbura', 'Bureau', 'Directeur administratif et financier', 'DAF / Finance', 'Siège (Bujumbura)', '2019-05-06', 'CDI', NULL, '6 mois', 2500000.00, 'Virement bancaire', '100201', '400001', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(5, 'SAT-0010', 'KANEZA', 'Sandrine', 'Féminin', '1992-03-25', 'Célibataire', '1992032512302', '+257 79 200 010', 's.kaneza@satraco.bi', 'Kamenge, Bujumbura', 'Bureau', 'Assistante comptable', 'DAF / Finance', 'Siège (Bujumbura)', '2023-09-04', 'CDD', '2026-12-31', '3 mois', 700000.00, 'Virement bancaire', '100202', '400002', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(6, 'SAT-0011', 'BUKURU', 'Olivier', 'Masculin', '1990-11-02', 'Marié(e)', '1990110212303', '+257 79 200 011', 'o.bukuru@satraco.bi', 'Ngagara, Bujumbura', 'Bureau', 'Ingénieur génie civil', 'Direction Technique', 'Siège (Bujumbura)', '2021-02-15', 'CDI', NULL, '6 mois', 1600000.00, 'Virement bancaire', '100203', '400003', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(7, 'SAT-0012', 'NIBIGIRA', 'Grâce', 'Féminin', '1994-06-18', 'Célibataire', '1994061812304', '+257 79 200 012', 'g.nibigira@satraco.bi', 'Rohero, Bujumbura', 'Bureau', 'Réceptionniste / standardiste', 'Direction Générale', 'Siège (Bujumbura)', '2024-01-08', 'CDD', '2026-09-30', '3 mois', 550000.00, 'Virement bancaire', '100204', '400004', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(8, 'SAT-0013', 'MUHIRE', 'Fabrice', 'Masculin', '1987-09-30', 'Marié(e)', '1987093012305', '+257 79 200 013', 'f.muhire@satraco.bi', 'Kinindo, Bujumbura', 'Bureau', 'Architecte', 'Direction Technique', 'Siège (Bujumbura)', '2020-10-01', 'CDI', NULL, '6 mois', 1700000.00, 'Virement bancaire', '100205', '400005', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(9, 'SAT-0014', 'NDABANEZE', 'Léocadie', 'Féminin', '1991-12-05', 'Marié(e)', '1991120512306', '+257 79 200 014', 'l.ndabaneze@satraco.bi', 'Musaga, Bujumbura', 'Bureau', 'Chargée de paie', 'Ressources Humaines', 'Siège (Bujumbura)', '2022-06-01', 'CDI', NULL, '3 mois', 900000.00, 'Virement bancaire', '100206', '400006', NULL, NULL, NULL, NULL, 'En congé', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(10, 'SAT-0015', 'CIZA', 'Dieudonné', 'Masculin', '1985-04-22', 'Marié(e)', '1985042212307', '+257 79 200 015', 'd.ciza@satraco.bi', 'Ngagara, Bujumbura', 'Bureau', 'Responsable logistique', 'Direction Générale', 'Siège (Bujumbura)', '2019-11-12', 'CDI', NULL, '6 mois', 1500000.00, 'Virement bancaire', '100207', '400007', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(11, 'SAT-0016', 'UMUGWANEZA', 'Josiane', 'Féminin', '1996-08-09', 'Célibataire', '1996080912308', '+257 79 200 016', 'j.umugwaneza@satraco.bi', 'Gihosha, Bujumbura', 'Bureau', 'Assistante RH', 'Ressources Humaines', 'Siège (Bujumbura)', '2025-03-17', 'CDD', '2027-03-16', '3 mois', 650000.00, 'Virement bancaire', '100208', '400008', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(12, 'SAT-0017', 'NDUWIMANA', 'Egide', 'Masculin', '1993-02-14', 'Célibataire', '1993021412309', '+257 79 200 017', 'e.nduwimana@satraco.bi', 'Buterere, Bujumbura', 'Bureau', 'Dessinateur projeteur', 'Direction Technique', 'Siège (Bujumbura)', '2023-05-02', 'CDD', '2026-08-31', '3 mois', 800000.00, 'Virement bancaire', '100209', '400009', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(13, 'SAT-0018', 'NYANDWI', 'Blaise', 'Masculin', '1989-10-17', 'Marié(e)', '1989101712310', '+257 79 200 018', 'b.nyandwi@satraco.bi', 'Kamenge, Bujumbura', 'Bureau', 'Informaticien', 'Direction Générale', 'Siège (Bujumbura)', '2021-08-23', 'CDI', NULL, '3 mois', 1100000.00, 'Virement bancaire', '100210', '400010', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(14, 'SAT-0019', 'IZERE', 'Nadège', 'Féminin', '1995-01-27', 'Célibataire', '1995012712311', '+257 79 200 019', 'n.izere@satraco.bi', 'Rohero, Bujumbura', 'Bureau', 'Caissière', 'DAF / Finance', 'Siège (Bujumbura)', '2024-07-01', 'CDD', '2027-06-30', '3 mois', 600000.00, 'Virement bancaire', '100211', '400011', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(15, 'SAT-0020', 'NTEREKA', 'Yves', 'Masculin', '1992-05-19', 'Célibataire', '1992051912312', '+257 79 200 020', 'y.ntereka@satraco.bi', 'Musaga, Bujumbura', 'Bureau', 'Métreur économiste', 'Direction Technique', 'Siège (Bujumbura)', '2022-10-10', 'CDI', NULL, '3 mois', 1200000.00, 'Virement bancaire', '100212', '400012', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(16, 'SAT-0021', 'NSABIMANA', 'Jean-Claude', 'Masculin', '1986-03-08', 'Marié(e)', '1986030812313', '+257 79 300 021', NULL, 'Ngagara, Bujumbura', 'Chantier', 'Chef de chantier', 'Direction Technique', 'Chantier Ngagara II', '2019-09-16', 'CDI', NULL, '6 mois', 1400000.00, 'Virement bancaire', '100213', '400013', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(17, 'SAT-0022', 'DUSABE', 'Pacifique', 'Féminin', '1993-07-21', 'Célibataire', '1993072112314', '+257 79 300 022', NULL, 'Buterere, Bujumbura', 'Chantier', 'Officière HSE', 'Direction Technique', 'Chantier Ngagara II', '2023-02-06', 'CDD', '2027-02-05', '3 mois', 950000.00, 'Mobile money', '100214', '400014', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(18, 'SAT-0023', 'BIZIMUNGU', 'Révocat', 'Masculin', '1990-12-11', 'Marié(e)', '1990121112315', '+257 79 300 023', NULL, 'Kamenge, Bujumbura', 'Chantier', 'Chef d\'équipe maçonnerie', 'Direction Technique', 'Chantier Ngagara II', '2020-01-20', 'CDI', NULL, '6 mois', 850000.00, 'Espèces', '100215', '400015', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(19, 'SAT-0024', 'IRAMBONA', 'Elie', 'Masculin', '1997-04-03', 'Célibataire', '1997040312316', '+257 79 300 024', NULL, 'Gihosha, Bujumbura', 'Chantier', 'Maçon', 'Direction Technique', 'Chantier Ngagara II', '2024-11-04', 'CDD', '2026-11-03', '3 mois', 450000.00, 'Espèces', '100216', '400016', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(20, 'SAT-0025', 'KAZINGUFI', 'Innocent', 'Masculin', '1994-09-26', 'Célibataire', '1994092612317', '+257 79 300 025', NULL, 'Musaga, Bujumbura', 'Chantier', 'Coffreur', 'Direction Technique', 'Chantier Ngagara II', '2025-01-13', 'CDD', '2026-10-12', '3 mois', 450000.00, 'Espèces', '100217', '400017', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(21, 'SAT-0026', 'MUKESHIMANA', 'Claudine', 'Féminin', '1991-06-30', 'Divorcé(e)', '1991063012318', '+257 79 300 026', NULL, 'Ngagara, Bujumbura', 'Chantier', 'Magasinière de chantier', 'Direction Technique', 'Chantier Ngagara II', '2022-04-11', 'CDI', NULL, '3 mois', 700000.00, 'Mobile money', '100218', '400018', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(22, 'SAT-0027', 'RUKARA', 'Gilbert', 'Masculin', '1988-01-24', 'Marié(e)', '1988012412319', '+257 79 300 027', NULL, 'Buterere, Bujumbura', 'Chantier', 'Grutier', 'Direction Technique', 'Chantier Ngagara II', '2021-06-07', 'CDI', NULL, '6 mois', 900000.00, 'Virement bancaire', '100219', '400019', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(23, 'SAT-0028', 'SINDAYIHEBURA', 'Eric', 'Masculin', '1995-10-08', 'Célibataire', '1995100812320', '+257 79 300 028', NULL, 'Kamenge, Bujumbura', 'Chantier', 'Électricien bâtiment', 'Direction Technique', 'Chantier Ngagara II', '2024-05-20', 'CDD', '2026-09-19', '3 mois', 550000.00, 'Mobile money', '100220', '400020', NULL, NULL, NULL, NULL, 'En congé', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(24, 'SAT-0029', 'TWAGIRAYEZU', 'Vincent', 'Masculin', '1992-08-15', 'Célibataire', '1992081512321', '+257 79 300 029', NULL, 'Gihosha, Bujumbura', 'Chantier', 'Plombier', 'Direction Technique', 'Chantier Ngagara II', '2023-08-01', 'CDD', '2027-07-31', '3 mois', 550000.00, 'Espèces', '100221', '400021', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(25, 'SAT-0030', 'NZEYIMANA', 'Honorine', 'Féminin', '1990-02-02', 'Marié(e)', '1990020212322', '+257 79 300 030', NULL, 'Musaga, Bujumbura', 'Chantier', 'Commis de chantier', 'Direction Technique', 'Chantier Ngagara II', '2020-07-14', 'CDI', NULL, '3 mois', 650000.00, 'Mobile money', '100222', '400022', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(26, 'SAT-0031', 'HABONIMANA', 'Landry', 'Masculin', '1998-11-23', 'Célibataire', '1998112312323', '+257 79 300 031', NULL, 'Ngagara, Bujumbura', 'Chantier', 'Manœuvre', 'Direction Technique', 'Chantier Ngagara II', '2025-06-02', 'CDD', '2026-12-01', '3 mois', 300000.00, 'Espèces', '100223', '400023', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(27, 'SAT-0032', 'MBONIMPA', 'Justine', 'Féminin', '1996-05-05', 'Célibataire', '1996050512324', '+257 79 300 032', NULL, 'Buterere, Bujumbura', 'Chantier', 'Peintre', 'Direction Technique', 'Chantier Ngagara II', '2024-02-19', 'CDD', '2026-08-20', '3 mois', 500000.00, 'Mobile money', '100224', '400024', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(28, 'SAT-0033', 'NDIKUMANA', 'Félicien', 'Masculin', '1987-06-16', 'Marié(e)', '1987061612325', '+257 79 400 033', NULL, 'Gitega Centre', 'Chantier', 'Chef de chantier', 'Direction Technique', 'Chantier Gitega', '2020-03-09', 'CDI', NULL, '6 mois', 1300000.00, 'Virement bancaire', '100225', '400025', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(29, 'SAT-0034', 'KANEZERO', 'Diane', 'Féminin', '1994-10-30', 'Célibataire', '1994103012326', '+257 79 400 034', NULL, 'Gitega Centre', 'Chantier', 'Topographe', 'Direction Technique', 'Chantier Gitega', '2023-04-17', 'CDD', '2027-04-16', '3 mois', 900000.00, 'Mobile money', '100226', '400026', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(30, 'SAT-0035', 'BARANCIRA', 'Joseph', 'Masculin', '1991-03-12', 'Marié(e)', '1991031212327', '+257 79 400 035', NULL, 'Gitega Centre', 'Chantier', 'Chef d\'équipe charpente', 'Direction Technique', 'Chantier Gitega', '2021-09-27', 'CDI', NULL, '6 mois', 800000.00, 'Espèces', '100227', '400027', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(31, 'SAT-0036', 'IRAKOZE', 'Kevin', 'Masculin', '1996-12-01', 'Célibataire', '1996120112328', '+257 79 400 036', NULL, 'Gitega Centre', 'Chantier', 'Ferrailleur', 'Direction Technique', 'Chantier Gitega', '2025-02-10', 'CDD', '2026-10-09', '3 mois', 400000.00, 'Espèces', '100228', '400028', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(32, 'SAT-0037', 'NDAYIRAGIJE', 'Samuel', 'Masculin', '1993-05-28', 'Célibataire', '1993052812329', '+257 79 400 037', NULL, 'Gitega Centre', 'Chantier', 'Soudeur', 'Direction Technique', 'Chantier Gitega', '2024-08-12', 'CDD', '2026-12-11', '3 mois', 500000.00, 'Espèces', '100229', '400029', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(33, 'SAT-0038', 'UWIZEYIMANA', 'Chantal', 'Féminin', '1992-09-09', 'Marié(e)', '1992090912330', '+257 79 400 038', NULL, 'Gitega Centre', 'Chantier', 'Magasinière de chantier', 'Direction Technique', 'Chantier Gitega', '2022-11-21', 'CDI', NULL, '3 mois', 650000.00, 'Mobile money', '100230', '400030', NULL, NULL, NULL, NULL, 'En congé', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(34, 'SAT-0039', 'NGENZI', 'Pierre', 'Masculin', '1989-07-07', 'Marié(e)', '1989070712331', '+257 79 400 039', NULL, 'Gitega Centre', 'Chantier', 'Conducteur d\'engins', 'Direction Technique', 'Chantier Gitega', '2020-10-19', 'CDI', NULL, '6 mois', 950000.00, 'Virement bancaire', '100231', '400031', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(35, 'SAT-0040', 'MANIRAKIZA', 'Thaddée', 'Masculin', '1995-04-24', 'Célibataire', '1995042412332', '+257 79 400 040', NULL, 'Gitega Centre', 'Chantier', 'Maçon', 'Direction Technique', 'Chantier Gitega', '2024-04-08', 'CDD', '2027-04-07', '3 mois', 450000.00, 'Espèces', '100232', '400032', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(36, 'SAT-0041', 'NIYONGABO', 'Cédric', 'Masculin', '1997-01-15', 'Célibataire', '1997011512333', '+257 79 400 041', NULL, 'Gitega Centre', 'Chantier', 'Manœuvre', 'Direction Technique', 'Chantier Gitega', '2025-09-01', 'CDD', '2026-08-31', '3 mois', 300000.00, 'Espèces', '100233', '400033', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(37, 'SAT-0042', 'KAMENYI', 'Solange', 'Féminin', '1993-11-11', 'Célibataire', '1993111112334', '+257 79 400 042', NULL, 'Gitega Centre', 'Chantier', 'Agente HSE', 'Direction Technique', 'Chantier Gitega', '2023-06-05', 'CDD', '2027-06-04', '3 mois', 700000.00, 'Mobile money', '100234', '400034', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(38, 'SAT-0043', 'BIGIRIMANA', 'Emmanuel', 'Masculin', '1990-08-28', 'Marié(e)', '1990082812335', '+257 79 400 043', NULL, 'Gitega Centre', 'Chantier', 'Électricien bâtiment', 'Direction Technique', 'Chantier Gitega', '2021-05-31', 'CDI', NULL, '3 mois', 600000.00, 'Espèces', '100235', '400035', NULL, NULL, NULL, NULL, 'Suspendu', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(39, 'SAT-0044', 'NIMBONEZA', 'Patrick', 'Masculin', '1988-05-05', 'Marié(e)', '1988050512336', '+257 79 500 044', NULL, 'Ngozi Centre', 'Chantier', 'Chef de chantier', 'Direction Technique', 'Chantier Ngozi', '2019-12-02', 'CDI', NULL, '6 mois', 1300000.00, 'Virement bancaire', '100236', '400036', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(40, 'SAT-0045', 'NDAYISENGA', 'Olive', 'Féminin', '1994-02-14', 'Célibataire', '1994021412337', '+257 79 500 045', NULL, 'Ngozi Centre', 'Chantier', 'Ingénieure travaux', 'Direction Technique', 'Chantier Ngozi', '2022-03-14', 'CDI', NULL, '6 mois', 1500000.00, 'Virement bancaire', '100237', '400037', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(41, 'SAT-0046', 'HAVYARIMANA', 'Gustave', 'Masculin', '1986-10-10', 'Marié(e)', '1986101012338', '+257 79 500 046', NULL, 'Ngozi Centre', 'Chantier', 'Chef d\'équipe maçonnerie', 'Direction Technique', 'Chantier Ngozi', '2020-06-15', 'CDI', NULL, '6 mois', 850000.00, 'Espèces', '100238', '400038', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(42, 'SAT-0047', 'NIYONKURU', 'Ange', 'Masculin', '1996-03-03', 'Célibataire', '1996030312339', '+257 79 500 047', NULL, 'Ngozi Centre', 'Chantier', 'Maçon', 'Direction Technique', 'Chantier Ngozi', '2024-10-07', 'CDD', '2026-11-06', '3 mois', 450000.00, 'Espèces', '100239', '400039', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(43, 'SAT-0048', 'NTAKARUTIMANA', 'Wilson', 'Masculin', '1992-12-25', 'Marié(e)', '1992122512340', '+257 79 500 048', NULL, 'Ngozi Centre', 'Chantier', 'Coffreur', 'Direction Technique', 'Chantier Ngozi', '2023-01-23', 'CDD', '2027-01-22', '3 mois', 450000.00, 'Espèces', '100240', '400040', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(44, 'SAT-0049', 'IRORIWE', 'Jeanne', 'Féminin', '1991-09-17', 'Marié(e)', '1991091712341', '+257 79 500 049', NULL, 'Ngozi Centre', 'Chantier', 'Magasinière de chantier', 'Direction Technique', 'Chantier Ngozi', '2021-11-08', 'CDI', NULL, '3 mois', 650000.00, 'Mobile money', '100241', '400041', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(45, 'SAT-0050', 'NZOYISABA', 'Charles', 'Masculin', '1989-04-14', 'Marié(e)', '1989041412342', '+257 79 500 050', NULL, 'Ngozi Centre', 'Chantier', 'Grutier', 'Direction Technique', 'Chantier Ngozi', '2020-09-21', 'CDI', NULL, '6 mois', 900000.00, 'Virement bancaire', '100242', '400042', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(46, 'SAT-0051', 'SABUSHIMIKE', 'Didier', 'Masculin', '1994-07-27', 'Célibataire', '1994072712343', '+257 79 500 051', NULL, 'Ngozi Centre', 'Chantier', 'Plombier', 'Direction Technique', 'Chantier Ngozi', '2024-06-10', 'CDD', '2026-09-09', '3 mois', 550000.00, 'Espèces', '100243', '400043', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(47, 'SAT-0052', 'GAKOBWA', 'Vestine', 'Féminin', '1993-08-08', 'Célibataire', '1993080812344', '+257 79 500 052', NULL, 'Ngozi Centre', 'Chantier', 'Peintre', 'Direction Technique', 'Chantier Ngozi', '2023-10-16', 'CDD', '2027-10-15', '3 mois', 500000.00, 'Mobile money', '100244', '400044', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(48, 'SAT-0053', 'NUNUBAHA', 'Divine', 'Féminin', '1997-06-06', 'Célibataire', '1997060612345', '+257 79 500 053', NULL, 'Ngozi Centre', 'Chantier', 'Manœuvre', 'Direction Technique', 'Chantier Ngozi', '2025-05-19', 'CDD', '2026-11-18', '3 mois', 300000.00, 'Espèces', '100245', '400045', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(49, 'SAT-0054', 'NDORIMANA', 'Gaspard', 'Masculin', '1985-12-30', 'Marié(e)', '1985123012346', '+257 79 600 054', 'g.ndorimana@satraco.bi', 'Ngagara, Bujumbura', 'Bureau', 'Chauffeur de direction', 'Direction Générale', 'Siège (Bujumbura)', '2019-08-05', 'CDI', NULL, '3 mois', 600000.00, 'Espèces', '100246', '400046', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(50, 'SAT-0055', 'BARAMPAMA', 'Jean-Bosco', 'Masculin', '1987-02-02', 'Marié(e)', '1987020212347', '+257 79 600 055', NULL, 'Buterere, Bujumbura', 'Chantier', 'Mécanicien d\'engins', 'Direction Technique', 'Chantier Ngagara II', '2020-02-17', 'CDI', NULL, '6 mois', 700000.00, 'Espèces', '100247', '400047', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(51, 'SAT-0056', 'NDAYIZAMBA', 'Callixte', 'Masculin', '1990-01-01', 'Célibataire', '1990010112348', '+257 79 600 056', NULL, 'Gitega Centre', 'Chantier', 'Agent de sécurité', 'Direction Technique', 'Chantier Gitega', '2022-07-04', 'CDD', '2027-07-03', '3 mois', 350000.00, 'Espèces', '100248', '400048', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(52, 'SAT-0057', 'UWIMANA', 'Bernadette', 'Féminin', '1989-11-11', 'Marié(e)', '1989111112349', '+257 79 600 057', 'b.uwimana@satraco.bi', 'Musaga, Bujumbura', 'Bureau', 'Cuisinière', 'Direction Générale', 'Siège (Bujumbura)', '2021-03-22', 'CDI', NULL, '3 mois', 400000.00, 'Espèces', '100249', '400049', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(53, 'SAT-0058', 'NIYIMANA', 'Cyprien', 'Masculin', '1998-02-09', 'Célibataire', '1998020912350', '+257 79 600 058', NULL, 'Kamenge, Bujumbura', 'Bureau', 'Office boy', 'DAF / Finance', 'Siège (Bujumbura)', '2025-10-06', 'CDD', '2026-10-05', '3 mois', 250000.00, 'Espèces', '100250', '400050', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(54, 'SAT-0059', 'IRAKOZE', 'Nadia', 'Féminin', '1999-09-09', 'Célibataire', '1999090912351', '+257 79 600 059', 'n.irakoze@satraco.bi', 'Rohero, Bujumbura', 'Bureau', 'Stagiaire RH', 'Ressources Humaines', 'Siège (Bujumbura)', '2026-02-02', 'Stage', '2026-08-31', 'Aucune', 200000.00, 'Espèces', '100251', '400051', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(55, 'SAT-0060', 'NZIGAMIMANA', 'Libère', 'Masculin', '1991-05-05', 'Marié(e)', '1991050512352', '+257 79 600 060', NULL, 'Gihosha, Bujumbura', 'Bureau', 'Chauffeur camion', 'Direction Technique', 'Siège (Bujumbura)', '2022-01-10', 'CDI', NULL, '3 mois', 550000.00, 'Espèces', '100252', '400052', NULL, NULL, NULL, NULL, 'Actif', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(56, 'SAT-0061', 'MUGISHA', 'Robert', 'Masculin', '1992-04-04', 'Célibataire', '1992040412353', '+257 79 600 061', NULL, 'Ngozi Centre', 'Chantier', 'Maçon', 'Direction Technique', 'Chantier Ngozi', '2023-03-13', 'CDD', '2026-08-10', '3 mois', 450000.00, 'Espèces', '100253', '400053', NULL, NULL, NULL, NULL, 'Fin de contrat', '2026-08-12 18:04:42', '2026-08-12 18:04:42'),
(57, 'SAT-0062', 'NDABASHIMANA', 'Priscaa', 'Féminin', '1995-10-21', 'Célibataire', '1995102112354', '+257 79 600 062', 'p.ndabashimana@satraco.bi', 'Ngozi Centre', 'Bureau', 'Secrétaire de chantier', 'Direction Technique', 'Chantier Ngozi', '2024-09-09', 'CDD', '2027-09-08', '3 mois', 600000.00, 'Virement bancaire', '100254', '400054', NULL, NULL, NULL, NULL, 'Fin de contrat', '2026-08-12 18:04:42', '2026-08-25 12:56:36'),
(58, 'SAT-0063', 'Orly', 'KAZE', 'Masculin', NULL, 'Célibataire', '', '+25769140846', 'kaze@gmail.com', 'Rohero 1', 'Bureau', 'Secrétaire de chantier', 'Direction Générale', 'Siège (Bujumbura)', '2025-03-02', 'CDI', NULL, '3 mois', 20000000.00, 'Virement bancaire', '112121', '12212121', 'uploads/rh/employes/doc_cnid_1787050550_6a843a3632252.pdf', 'uploads/rh/employes/doc_photo_1787050550_6a843a3634571.pdf', 'uploads/rh/employes/doc_contrat_1787050550_6a843a3634ac5.jpeg', 'uploads/rh/employes/doc_cv_1787050550_6a843a363521a.jpeg', 'Actif', '2026-08-18 10:55:50', '2026-08-18 10:55:50'),
(59, 'SAT-0064', 'kings', 'Homes', 'Masculin', NULL, 'Célibataire', '', '+25769077777', 'homeskings20@gmail.com', 'Zeimet', 'Bureau', 'Designner', 'Ressources Humaines', 'Siège (Bujumbura)', '2024-09-06', 'CDI', '2026-10-25', '3 mois', 3000000.00, 'Virement bancaire', '100254', '333333', 'uploads/rh/employes/doc_cnid_1787052270_6a8440ee85e61.pdf', 'uploads/rh/employes/doc_photo_1787052270_6a8440ee868a1.pdf', 'uploads/rh/employes/doc_contrat_1787052270_6a8440ee86c71.pdf', 'uploads/rh/employes/doc_cv_1787052270_6a8440ee87293.jpeg', 'Actif', '2026-08-18 11:24:30', '2026-08-18 11:24:30');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_evaluations`
--

CREATE TABLE `tbl_evaluations` (
  `evaluation_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `evaluateur` varchar(100) NOT NULL,
  `type_evaluation` varchar(60) NOT NULL DEFAULT 'Annuelle',
  `periode_debut` date NOT NULL,
  `periode_fin` date NOT NULL,
  `note_performance` tinyint(4) NOT NULL,
  `note_competences` tinyint(4) NOT NULL,
  `note_ponctualite` tinyint(4) NOT NULL,
  `note_esprit` tinyint(4) NOT NULL,
  `note_initiative` tinyint(4) NOT NULL,
  `note_securite` tinyint(4) NOT NULL,
  `score_global` decimal(3,2) NOT NULL,
  `appreciation` varchar(20) NOT NULL,
  `points_forts` text DEFAULT NULL,
  `axes_amelioration` text DEFAULT NULL,
  `objectifs` text DEFAULT NULL,
  `decision_proposee` varchar(60) DEFAULT NULL,
  `statut` enum('En cours','Validée') NOT NULL DEFAULT 'Validée',
  `encode_par` varchar(100) DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_evaluations`
--

INSERT INTO `tbl_evaluations` (`evaluation_id`, `employe_id`, `evaluateur`, `type_evaluation`, `periode_debut`, `periode_fin`, `note_performance`, `note_competences`, `note_ponctualite`, `note_esprit`, `note_initiative`, `note_securite`, `score_global`, `appreciation`, `points_forts`, `axes_amelioration`, `objectifs`, `decision_proposee`, `statut`, `encode_par`, `cree_le`) VALUES
(1, 50, 'J.-M. NDAYIZEYE (Resp. RH)', 'Fin de stage', '2026-08-01', '2026-08-23', 3, 3, 3, 3, 1, 3, 2.80, 'Satisfaisant', 'il a bien fait', 'lkadjklasda', 'alad;akda', 'Formation', 'Validée', NULL, '2026-08-27 13:45:46'),
(2, 1, 'Direction Générale', 'Annuelle', '2026-01-01', '2026-06-30', 5, 5, 5, 5, 4, 5, 4.90, 'Excellent', 'Leadership, rigueur administrative', 'Délégation accrue', 'Digitaliser le registre du personnel', 'Prime de performance', 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(3, 4, 'Direction Générale', 'Annuelle', '2026-01-01', '2026-06-30', 4, 4, 4, 4, 4, 4, 4.00, 'Très bien', 'Maîtrise financière, reporting fiable', 'Communication inter-services', 'Budget prévisionnel 2027', NULL, 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(4, 5, 'Th. NIMUBONA (DAF)', 'Annuelle', '2026-01-01', '2026-06-30', 4, 3, 4, 4, 3, 4, 3.70, 'Très bien', 'Précision comptable', 'Autonomie sur clôtures', 'Clôtures mensuelles sans appui', 'Formation', 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(5, 6, 'O. BUKURU (Dir. Technique)', 'Annuelle', '2026-01-01', '2026-06-30', 5, 5, 4, 4, 4, 5, 4.60, 'Excellent', 'Expertise génie civil, encadrement', 'Gestion documentaire', 'Superviser 2 chantiers simultanés', 'Promotion', 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(6, 9, 'J.-M. NDAYIZEYE (Resp. RH)', 'Annuelle', '2026-01-01', '2026-06-30', 4, 4, 5, 4, 3, 4, 4.05, 'Très bien', 'Fiabilité paie, ponctualité', 'Prise de parole en réunion', 'Automatiser les déclarations INSS', NULL, 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(7, 16, 'O. BUKURU (Dir. Technique)', 'Annuelle', '2026-01-01', '2026-06-30', 4, 4, 4, 5, 3, 5, 4.15, 'Très bien', 'Encadrement d\'équipe, sécurité', 'Planification des approvisionnements', 'Zéro accident sur Ngagara II', NULL, 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(8, 18, 'J.-C. NSABIMANA (Chef de chantier)', 'Annuelle', '2026-01-01', '2026-06-30', 4, 3, 4, 4, 3, 4, 3.70, 'Très bien', 'Polyvalence maçonnerie', 'Lecture de plans', 'Former 2 manœuvres', 'Formation', 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(9, 22, 'J.-C. NSABIMANA (Chef de chantier)', 'Annuelle', '2026-01-01', '2026-06-30', 3, 3, 3, 4, 2, 3, 3.05, 'Satisfaisant', 'Conduite de grue expérimentée', 'Rigueur des vérifications fin de journée', 'Check-list quotidienne grue', 'Plan de progrès', 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(10, 27, 'J.-C. NSABIMANA (Chef de chantier)', 'Annuelle', '2026-01-01', '2026-06-30', 2, 3, 2, 3, 2, 2, 2.35, 'À améliorer', 'Qualité de finition peinture', 'Assiduité, respect des horaires', 'Aucune absence non justifiée sur 3 mois', 'Plan de progrès', 'En cours', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(11, 3, 'J.-M. NDAYIZEYE (Resp. RH)', 'Fin de période d\'essai', '2026-08-01', '2026-10-31', 4, 3, 4, 4, 3, 4, 3.70, 'Très bien', 'Créativité, maîtrise des outils', 'Connaissance des procédures internes', 'Autonomie sur les maquettes', NULL, 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(12, 54, 'J.-M. NDAYIZEYE (Resp. RH)', 'Fin de stage', '2026-02-02', '2026-08-31', 4, 3, 4, 5, 3, 4, 3.85, 'Très bien', 'Sérieux, intégration rapide', 'Approfondir le module paie', 'Embauche éventuelle en CDD', 'Promotion', 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(13, 7, 'Direction Générale', 'Annuelle', '2026-01-01', '2026-06-30', 3, 3, 4, 4, 3, 3, 3.30, 'Satisfaisant', 'Accueil et standard impeccables', 'Gestion du courrier entrant', 'Tenue du registre courrier', NULL, 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(14, 8, 'O. BUKURU (Dir. Technique)', 'Annuelle', '2026-01-01', '2026-06-30', 4, 5, 4, 4, 4, 4, 4.20, 'Très bien', 'Qualité des plans d\'exécution', 'Délais de rendu', 'Réduire les retours de plans de 20 %', NULL, 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(15, 10, 'Direction Générale', 'Annuelle', '2026-01-01', '2026-06-30', 4, 4, 4, 3, 4, 4, 3.85, 'Très bien', 'Organisation logistique', 'Anticipation des stocks', 'Procédure d\'inventaire trimestriel', NULL, 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(16, 12, 'O. BUKURU (Dir. Technique)', 'Annuelle', '2026-01-01', '2026-06-30', 4, 4, 3, 4, 3, 4, 3.75, 'Très bien', 'Précision du dessin', 'Ponctualité', 'Respect des horaires de pointage', NULL, 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(17, 28, 'O. BUKURU (Dir. Technique)', 'Annuelle', '2026-01-01', '2026-06-30', 4, 4, 4, 4, 3, 5, 4.00, 'Très bien', 'Management du chantier Gitega', 'Reporting hebdomadaire', 'Rapports de chantier chaque vendredi', NULL, 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(18, 36, 'J.-C. NSABIMANA (Chef de chantier)', 'Ponctuelle (après incident ou promotion)', '2026-07-01', '2026-08-20', 2, 3, 2, 3, 2, 3, 2.45, 'À améliorer', 'Bonne capacité physique', 'Assiduité, discipline', '30 jours sans retard ni absence', 'Plan de progrès', 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(19, 39, 'O. BUKURU (Dir. Technique)', 'Annuelle', '2026-01-01', '2026-06-30', 4, 4, 5, 4, 3, 5, 4.15, 'Très bien', 'Expérience, sécurité exemplaire', 'Transmission aux jeunes', 'Mentorer 1 chef d\'équipe junior', NULL, 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(20, 47, 'J.-C. NSABIMANA (Chef de chantier)', 'Annuelle', '2026-01-01', '2026-06-30', 3, 3, 3, 3, 3, 3, 3.00, 'Satisfaisant', 'Régularité du travail', 'Initiative', 'Proposer 1 amélioration par mois', 'Formation', 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33'),
(21, 52, 'Direction Générale', 'Annuelle', '2026-01-01', '2026-06-30', 3, 3, 4, 4, 2, 3, 3.20, 'Satisfaisant', 'Discrétion, ponctualité', 'Proposition d\'améliorations', 'Prendre 1 initiative par trimestre', 'Formation', 'Validée', 'J.-M. NDAYIZEYE', '2026-08-27 14:01:33');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_finance_cashbox`
--

CREATE TABLE `tbl_finance_cashbox` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  `role` enum('principale','secondaire') NOT NULL,
  `responsable` varchar(150) DEFAULT NULL,
  `devise` enum('BIF','USD','EUR') NOT NULL DEFAULT 'BIF',
  `opening_balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `current_balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `alert_threshold` decimal(20,2) NOT NULL DEFAULT 0.00,
  `observation` text DEFAULT NULL,
  `status` enum('active','inactive','closed') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_finance_cashbox`
--

INSERT INTO `tbl_finance_cashbox` (`id`, `code`, `name`, `role`, `responsable`, `devise`, `opening_balance`, `current_balance`, `alert_threshold`, `observation`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'CAI-2026-001', 'CAISSE PRINCIPALE', 'principale', 'Nelly Ange', 'BIF', 0.00, 50000000.00, 0.00, NULL, 'active', 22, '2026-08-19 09:28:03', '2026-08-19 09:34:06'),
(2, 'CAI-2026-002', 'CAISSE Secondaire', 'secondaire', 'Come', 'BIF', 0.00, 44190000.00, 0.00, NULL, 'active', 22, '2026-08-19 09:29:02', '2026-08-19 09:42:45');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_finance_mouvement_principale`
--

CREATE TABLE `tbl_finance_mouvement_principale` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(40) NOT NULL,
  `sens` enum('entree','sortie') NOT NULL,
  `nature` enum('encaissement','approvisionnement','solde_initial') NOT NULL,
  `movement_date` date NOT NULL,
  `amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `balance_before` decimal(20,2) NOT NULL DEFAULT 0.00,
  `balance_after` decimal(20,2) NOT NULL DEFAULT 0.00,
  `devise` enum('BIF','USD','EUR') NOT NULL DEFAULT 'BIF',
  `transfer_reference` varchar(40) DEFAULT NULL,
  `third_party` varchar(180) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `payment_method` enum('cash','bank','cheque','mobile') NOT NULL DEFAULT 'cash',
  `document_number` varchar(100) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `label` varchar(255) NOT NULL,
  `observation` text DEFAULT NULL,
  `status` enum('pending','validated','cancelled') NOT NULL DEFAULT 'validated',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `validated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_finance_mouvement_principale`
--

INSERT INTO `tbl_finance_mouvement_principale` (`id`, `reference`, `sens`, `nature`, `movement_date`, `amount`, `balance_before`, `balance_after`, `devise`, `transfer_reference`, `third_party`, `category`, `payment_method`, `document_number`, `attachment`, `label`, `observation`, `status`, `created_by`, `validated_by`, `created_at`, `updated_at`) VALUES
(1, 'MVP-2026-0001', 'entree', 'encaissement', '2026-08-19', 100000000.00, 0.00, 100000000.00, 'BIF', NULL, 'IBB Entrepot / Compte BBCI ', 'Approvisionnement', 'cash', '', NULL, 'Encaissement — IBB Entrepot / Compte BBCI ', '', 'validated', 22, NULL, '2026-08-19 09:33:08', NULL),
(2, 'MVP-2026-0002', 'sortie', 'approvisionnement', '2026-08-19', 50000000.00, 100000000.00, 50000000.00, 'BIF', 'TRF-2026-6916', NULL, 'Approvisionnement', 'cash', '', NULL, 'Approvisionnement de la caisse secondaire', '', 'validated', 22, NULL, '2026-08-19 09:34:06', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_finance_mouvement_secondaire`
--

CREATE TABLE `tbl_finance_mouvement_secondaire` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(40) NOT NULL,
  `sens` enum('entree','sortie') NOT NULL,
  `nature` enum('approvisionnement_recu','paiement_da','solde_initial','retour_caisse','supplement') NOT NULL,
  `movement_date` date NOT NULL,
  `amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `balance_before` decimal(20,2) NOT NULL DEFAULT 0.00,
  `balance_after` decimal(20,2) NOT NULL DEFAULT 0.00,
  `devise` enum('BIF','USD','EUR') NOT NULL DEFAULT 'BIF',
  `transfer_reference` varchar(40) DEFAULT NULL,
  `purchase_request_id` int(11) DEFAULT NULL,
  `purchase_request_reference` varchar(100) DEFAULT NULL,
  `third_party` varchar(180) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `payment_method` enum('cash','bank','cheque','mobile') NOT NULL DEFAULT 'cash',
  `document_number` varchar(100) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `label` varchar(255) NOT NULL,
  `observation` text DEFAULT NULL,
  `status` enum('pending','validated','cancelled') NOT NULL DEFAULT 'validated',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `validated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_finance_mouvement_secondaire`
--

INSERT INTO `tbl_finance_mouvement_secondaire` (`id`, `reference`, `sens`, `nature`, `movement_date`, `amount`, `balance_before`, `balance_after`, `devise`, `transfer_reference`, `purchase_request_id`, `purchase_request_reference`, `third_party`, `category`, `payment_method`, `document_number`, `attachment`, `label`, `observation`, `status`, `created_by`, `validated_by`, `created_at`, `updated_at`) VALUES
(1, 'MVS-2026-0001', 'entree', 'approvisionnement_recu', '2026-08-19', 50000000.00, 0.00, 50000000.00, 'BIF', 'TRF-2026-6916', NULL, NULL, NULL, 'Approvisionnement', 'cash', NULL, NULL, 'Approvisionnement reçu de la caisse principale', '', 'validated', 22, NULL, '2026-08-19 09:34:06', NULL),
(2, 'MVS-2026-0002', 'sortie', 'paiement_da', '2026-08-19', 5860000.00, 50000000.00, 44140000.00, 'BIF', NULL, 1094, 'DA-2026-1094', 'Severin', 'Paiement demande achat', 'cash', 'BP-2026-000008', NULL, 'Paiement DA-2026-1094', 'Ciment, Chargement et déchargement de 100sacs du ciment ', 'validated', 22, NULL, '2026-08-19 09:37:22', NULL),
(3, 'MVS-2026-0003', 'entree', 'retour_caisse', '2026-08-19', 50000.00, 44140000.00, 44190000.00, 'BIF', NULL, 1094, 'DA-2026-1094', 'Severin', 'Retour à la caisse', 'cash', NULL, NULL, 'Retour à la caisse — retour en caisse', NULL, 'validated', 22, NULL, '2026-08-19 09:42:45', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_mouvements`
--

CREATE TABLE `tbl_mouvements` (
  `mouvement_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `type_mouvement` varchar(50) NOT NULL,
  `date_effet` date NOT NULL,
  `nouvelle_affectation` varchar(100) DEFAULT NULL,
  `justificatif` varchar(255) DEFAULT NULL,
  `motif` text DEFAULT NULL,
  `encode_par` varchar(100) DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_mouvements`
--

INSERT INTO `tbl_mouvements` (`mouvement_id`, `employe_id`, `type_mouvement`, `date_effet`, `nouvelle_affectation`, `justificatif`, `motif`, `encode_par`, `cree_le`) VALUES
(1, 57, 'Démission', '2026-08-03', NULL, 'uploads/rh/mouvements/mouvement_1787662596_6a8d91046e820.jpeg', 'je fait test ici', NULL, '2026-08-25 12:56:36'),
(2, 3, 'Entrée', '2026-08-01', NULL, NULL, 'Embauche CDI — Designer', 'J.-M. NDAYIZEYE', '2026-08-25 13:10:40'),
(3, 57, 'Entrée', '2024-09-09', NULL, NULL, 'Embauche CDD — Secrétaire de chantier', 'J.-M. NDAYIZEYE', '2026-08-25 13:10:40'),
(4, 27, 'Entrée', '2024-02-19', NULL, NULL, 'Embauche CDD — Peintre', 'J.-M. NDAYIZEYE', '2026-08-25 13:10:40'),
(5, 56, 'Fin de contrat', '2026-08-10', NULL, NULL, 'CDD arrivé à échéance — non renouvelé', 'J.-M. NDAYIZEYE', '2026-08-25 13:10:40'),
(6, 18, 'Promotion', '2026-06-01', 'Chantier Ngagara II', NULL, 'Maçon → Chef d\'équipe maçonnerie', 'J.-M. NDAYIZEYE', '2026-08-25 13:10:40'),
(7, 9, 'Promotion', '2024-06-01', NULL, NULL, 'Assistante paie → Chargée de paie', 'J.-M. NDAYIZEYE', '2026-08-25 13:10:40'),
(8, 36, 'Transfert', '2026-03-01', 'Chantier Ngozi', NULL, 'Transfert inter-chantiers selon charge de travail', 'J.-M. NDAYIZEYE', '2026-08-25 13:10:40');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_rapports`
--

CREATE TABLE `tbl_rapports` (
  `rapport_id` int(11) NOT NULL,
  `type_rapport` varchar(100) NOT NULL,
  `periode` varchar(50) NOT NULL,
  `format` varchar(30) NOT NULL DEFAULT 'PDF',
  `genere_par` varchar(100) DEFAULT NULL,
  `fichier` varchar(255) DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_rapports`
--

INSERT INTO `tbl_rapports` (`rapport_id`, `type_rapport`, `periode`, `format`, `genere_par`, `fichier`, `cree_le`) VALUES
(1, 'Mouvements du personnel', 'Juillet 2026', 'PDF + Excel', 'J.-M. NDAYIZEYE', NULL, '2026-08-05 08:12:00'),
(2, 'Masse salariale & paie', 'Juillet 2026', 'PDF + Excel', 'J.-M. NDAYIZEYE', NULL, '2026-08-05 07:40:00'),
(3, 'Effectifs & démographie', 'Au 31/07/2026', 'Excel', 'J.-M. NDAYIZEYE', NULL, '2026-08-01 06:15:00'),
(4, 'Déclaration INSS (T2 2026)', 'Avril – juin 2026', 'PDF', 'J.-M. NDAYIZEYE', NULL, '2026-07-15 12:05:00'),
(5, 'IPR OBR — retenue à la source', 'Juin 2026', 'PDF', 'J.-M. NDAYIZEYE', NULL, '2026-07-10 09:30:00'),
(6, 'Mouvements du personnel', 'Juin 2026', 'PDF + Excel', 'J.-M. NDAYIZEYE', NULL, '2026-07-03 07:00:00'),
(7, 'Évaluations — campagne 2025', 'Année 2025', 'PDF', 'J.-M. NDAYIZEYE', NULL, '2026-06-30 14:45:00'),
(8, 'Registre d\'employeur', 'Au 30/06/2026', 'PDF', 'J.-M. NDAYIZEYE', NULL, '2026-06-30 13:20:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tbl_conges`
--
ALTER TABLE `tbl_conges`
  ADD PRIMARY KEY (`conge_id`),
  ADD KEY `idx_conge_employe` (`employe_id`),
  ADD KEY `fk_conge_remplacant` (`remplacant_id`);

--
-- Index pour la table `tbl_contrats`
--
ALTER TABLE `tbl_contrats`
  ADD PRIMARY KEY (`contrat_id`),
  ADD KEY `idx_contrat_employe` (`employe_id`);

--
-- Index pour la table `tbl_discipline`
--
ALTER TABLE `tbl_discipline`
  ADD PRIMARY KEY (`dossier_id`),
  ADD UNIQUE KEY `uniq_reference` (`reference`),
  ADD KEY `idx_discipline_employe` (`employe_id`);

--
-- Index pour la table `tbl_employes`
--
ALTER TABLE `tbl_employes`
  ADD PRIMARY KEY (`employe_id`),
  ADD UNIQUE KEY `uniq_matricule` (`matricule`),
  ADD KEY `idx_nom` (`nom`),
  ADD KEY `idx_statut` (`statut`);

--
-- Index pour la table `tbl_evaluations`
--
ALTER TABLE `tbl_evaluations`
  ADD PRIMARY KEY (`evaluation_id`),
  ADD KEY `idx_eval_employe` (`employe_id`);

--
-- Index pour la table `tbl_finance_cashbox`
--
ALTER TABLE `tbl_finance_cashbox`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_cashbox_code` (`code`),
  ADD UNIQUE KEY `uk_cashbox_role` (`role`),
  ADD KEY `idx_cashbox_status` (`status`);

--
-- Index pour la table `tbl_finance_mouvement_principale`
--
ALTER TABLE `tbl_finance_mouvement_principale`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_mvt_p_reference` (`reference`),
  ADD KEY `idx_mvt_p_date` (`movement_date`);

--
-- Index pour la table `tbl_finance_mouvement_secondaire`
--
ALTER TABLE `tbl_finance_mouvement_secondaire`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_mvt_s_reference` (`reference`),
  ADD KEY `idx_mvt_s_date` (`movement_date`);

--
-- Index pour la table `tbl_mouvements`
--
ALTER TABLE `tbl_mouvements`
  ADD PRIMARY KEY (`mouvement_id`),
  ADD KEY `idx_mouvement_employe` (`employe_id`);

--
-- Index pour la table `tbl_rapports`
--
ALTER TABLE `tbl_rapports`
  ADD PRIMARY KEY (`rapport_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tbl_conges`
--
ALTER TABLE `tbl_conges`
  MODIFY `conge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tbl_contrats`
--
ALTER TABLE `tbl_contrats`
  MODIFY `contrat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `tbl_discipline`
--
ALTER TABLE `tbl_discipline`
  MODIFY `dossier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `tbl_employes`
--
ALTER TABLE `tbl_employes`
  MODIFY `employe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `tbl_evaluations`
--
ALTER TABLE `tbl_evaluations`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `tbl_finance_cashbox`
--
ALTER TABLE `tbl_finance_cashbox`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tbl_finance_mouvement_principale`
--
ALTER TABLE `tbl_finance_mouvement_principale`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tbl_finance_mouvement_secondaire`
--
ALTER TABLE `tbl_finance_mouvement_secondaire`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tbl_mouvements`
--
ALTER TABLE `tbl_mouvements`
  MODIFY `mouvement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `tbl_rapports`
--
ALTER TABLE `tbl_rapports`
  MODIFY `rapport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tbl_conges`
--
ALTER TABLE `tbl_conges`
  ADD CONSTRAINT `fk_conge_employe` FOREIGN KEY (`employe_id`) REFERENCES `tbl_employes` (`employe_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_conge_remplacant` FOREIGN KEY (`remplacant_id`) REFERENCES `tbl_employes` (`employe_id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `tbl_contrats`
--
ALTER TABLE `tbl_contrats`
  ADD CONSTRAINT `fk_contrat_employe` FOREIGN KEY (`employe_id`) REFERENCES `tbl_employes` (`employe_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tbl_discipline`
--
ALTER TABLE `tbl_discipline`
  ADD CONSTRAINT `fk_discipline_employe` FOREIGN KEY (`employe_id`) REFERENCES `tbl_employes` (`employe_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tbl_evaluations`
--
ALTER TABLE `tbl_evaluations`
  ADD CONSTRAINT `fk_eval_employe` FOREIGN KEY (`employe_id`) REFERENCES `tbl_employes` (`employe_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tbl_mouvements`
--
ALTER TABLE `tbl_mouvements`
  ADD CONSTRAINT `fk_mouvement_employe` FOREIGN KEY (`employe_id`) REFERENCES `tbl_employes` (`employe_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
