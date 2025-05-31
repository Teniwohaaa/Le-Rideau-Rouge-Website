-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 31 mai 2025 à 14:49
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
-- Base de données : `rideau_rouge`
--

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `event_description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category` enum('cinema','theatre','opera') NOT NULL,
  `date_event` datetime NOT NULL,
  `venue` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `title`, `event_description`, `image_path`, `category`, `date_event`, `venue`, `price`) VALUES
(1, 'Until Dawn', 'Movie screening at Cinéma Cosmos Beta', 'until.jpg', 'cinema', '2025-05-16 13:00:00', 'Cinéma Cosmos Beta à Alger', 1000.00),
(2, 'The Amateur', 'Movie screening at Salle Ibn Zeydoun', 'amateur.jpg', 'cinema', '2025-05-20 20:00:00', 'Salle Ibn Zeydoun à Alger', 1000.00),
(3, 'Thunderbolts', 'Movie screening at Cinéma Cosmos Beta', 'thunderbolts.jpg', 'cinema', '2025-05-16 20:00:00', 'Cinéma Cosmos Beta à Alger', 1000.00),
(4, 'Armageddon', 'Movie screening at Le Maghreb', 'armageddon.jpg', 'cinema', '2025-05-16 20:00:00', 'Le Maghreb à Oran', 1000.00),
(5, 'Querelles', 'Movie screening at Le Maghreb', 'querelles.jpg', 'cinema', '2025-05-20 22:00:00', 'Le Maghreb à Oran', 1000.00),
(6, 'Le Retour des Hirondelles', 'Movie screening at Salle Ibn Zeydoun', 'hirondelles.jpg', 'cinema', '2025-05-20 22:00:00', 'Salle Ibn Zeydoun à Alger', 1000.00),
(7, 'شارع المنافقين', 'Theatre performance at TNA', 'charii.jpg', 'theatre', '2025-05-22 19:00:00', 'Théatre National d\'Alger', 2000.00),
(8, 'Arlouken', 'Theatre performance at TRO', 'arloukan.jpg', 'theatre', '2025-05-25 20:00:00', 'théatre regional d\'Oran', 2000.00),
(9, 'Basta', 'Theatre performance at TNA', 'basta.jpg', 'theatre', '2025-05-22 19:00:00', 'Théatre National d\'Alger', 2000.00),
(10, 'Sahrat El Madina', 'Opera performance at Opéra D\'Alger', 'sahrat.jpg', 'opera', '2025-05-27 20:00:00', 'Opéra D\'Alger', 3000.00),
(11, 'Théatre nationel de dance de Russie', 'Russian National Theatre Dance performance', 'russie.jpg', 'opera', '2025-05-31 20:00:00', 'Opéra D\'Alger', 3000.00),
(12, '14e edition du festival culturel international de musique symphonique égupte,corée de Sud et Japon', 'International Symphonic Music Festival - Egypt, South Korea and Japan', 'russie.jpg', 'opera', '2025-05-14 22:00:00', 'Opéra D\'Alger', 3000.00),
(13, '14e edition du festival culturel international de musique symphonique Afrique de Sud,France et Danem', 'International Symphonic Music Festival - South Africa, France and Denmark', 'russie.jpg', 'opera', '2025-05-16 20:00:00', 'Le Maghreb à Oran', 3000.00),
(14, '14e edition du festival culturel international de musique symphonique Italie et Autriche', 'International Symphonic Music Festival - Italy and Austria', 'russie.jpg', 'opera', '2025-05-23 20:00:00', 'Opéra D\'Alger', 3000.00),
(15, '14e edition du festival culturel international de musique symphonique Russie,Pologne et Syria', 'International Symphonic Music Festival - Russia, Poland and Syria', 'russie.jpg', 'opera', '2025-05-28 22:00:00', 'Opéra D\'Alger', 3000.00);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usr_password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `usr_password`, `is_admin`) VALUES
(1, 'admin', 'admin0@gmail.com', 'admin0', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
