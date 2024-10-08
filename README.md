install composer cli
install git
install symfony 



pour faire fonctionner mon site .
1 j'ouvre ma base de données Mysql
2 cd symfony-react-stripe-e-commerce-application
3npm run dev 
Symfony serve 

CTRL clic sur le lien donné puis vous etes sur le site


Voici le code SQL de ma base de données pour les tests à effectuer .
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 06 oct. 2024 à 23:25
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
-- Base de données : `stttt2458592`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240919041405', '2024-09-19 06:17:04', 27);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `price` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `description` longtext DEFAULT NULL,
  `stripe_product_id` varchar(255) DEFAULT NULL,
  `stripe_price_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `image_name`, `image_size`, `created_at`, `updated_at`, `price`, `active`, `description`, `stripe_product_id`, `stripe_price_id`) VALUES
(1, ': Blackbelt**', '1-66ebac1e0b474897553886.jpeg', 39048, NULL, '2024-09-19 06:44:14', 2990, 1, 'Black Sweetshirt', 'prod_QsMx8Q75SZTn8u', 'price_1Q0cDyJzTs5MrbsqCxUsLif8'),
(2, 'BlueBelt.', '2-66ebac35e752d709883719.jpeg', 50980, NULL, '2024-09-19 06:44:37', 2990, 1, 'Sweetshirt', 'prod_QsMyvTSCpk7p7j', 'price_1Q0cELJzTs5Mrbsq2QMGacti'),
(3, 'Street.', '3-66ebac4aa4384744992247.jpeg', 75570, NULL, '2024-09-19 06:44:58', 3450, 1, 'Sweetshirt', 'prod_QsMyCMyKBJ9SmO', 'price_1Q0cEgJzTs5MrbsqiPO24uGO'),
(4, 'Pokeball**', '4-66ebac6139ce6707445465.jpeg', 66594, NULL, '2024-09-19 06:45:21', 4500, 1, 'Sweetshirt', 'prod_QsMz8l8rTwWY77', 'price_1Q0cF3JzTs5Mrbsq9JxaoQmo'),
(5, 'PinkLady', '5-66ebac7929894581412963.jpeg', 49321, NULL, '2024-09-19 06:45:45', 2990, 1, 'SweetShirt', 'prod_QsMzbOIMlxo9dN', 'price_1Q0cFRJzTs5Mrbsq346hhtQj'),
(6, 'Snow', '6-66ebac91a5f42938435818.jpeg', 42717, NULL, '2024-09-19 06:46:09', 3200, 1, 'SweetShirt', 'prod_QsMzJyAAw4yDxg', 'price_1Q0cFpJzTs5MrbsqzGGq1um4'),
(7, 'Greyback', '7-66ebaca68f84d425011656.jpeg', 46316, NULL, '2024-09-19 06:46:30', 2850, 1, 'SweetShirt', 'prod_QsN05frOrh9jpF', 'price_1Q0cGAJzTs5MrbsqlPSFdRGN'),
(8, 'BlueCloud', '8-66ebacbda8aee545374680.jpeg', 62625, NULL, '2024-09-19 06:46:53', 4500, 1, 'SweetShirt', 'prod_QsN0AjsMX2BeoR', 'price_1Q0cGXJzTs5MrbsqVpYx81nt'),
(9, 'BornInUsa **', '9-66ebacd1b55e6082804814.jpeg', 64013, NULL, '2024-09-19 06:47:13', 5990, 1, 'SweetShirt', 'prod_QsN0RYKypxcS42', 'price_1Q0cGrJzTs5Mrbsq6AM1tn4n'),
(10, 'GreenSchool', '10-66ebace861ff1063648311.jpeg', 51662, NULL, '2024-09-19 06:47:36', 4220, 1, 'SweetShirt', 'prod_QsN1r4Q7RAqBsi', 'price_1Q0cHEJzTs5Mrbsq1JZSwraq');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `email` varchar(255) NOT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `delivery_address`, `roles`, `password`) VALUES
(1, 'nico', 'dnicolas120@gmail.com', '4 RUE VICTOR HUGO', '[\"ROLE_ADMIN\"]', '$2y$13$U.OFBm9tXlgDh0.HCxr2weSJflUr7ZKqMvjmqIe5tVsr/NadIXwKG'),
(2, 'test', 'test@gmail.com', 'test', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', '$2y$13$VYduJkn/9vmNV6txDWd/veGuqNIE3UPYqYCLRm7JjVR1zCD9zem6a'),
(3, 'coco', 'coco@gmail.com', 'coco', '[]', '$2y$13$BXEQVd0lM7PlXkncg7sPBeR6ZcNPFNmDCuXlqDaOUy.hKfOXMinN6'),
(4, 'token', 'token@gmail.com', 'token', '[]', '$2y$13$zw46/jK7gVvLWNKaEYp/.Ow8uem5xh6F6oVOX5O7yTLwHLvDPdl2S'),
(5, 'azer', 'azer@gmail.com', 'azer', '[]', '$2y$13$WvwB8.rdhQz9JOIMdVCvEummOH9Vw/nShsNLJEcnPY6mQsM3Y/CEi');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
