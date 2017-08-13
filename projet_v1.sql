-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Sam 12 Août 2017 à 12:06
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_v1`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_recipe` int(11) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rating`
--

CREATE TABLE `rating` (
  `id_rate` int(11) NOT NULL,
  `id_recipe` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `rate` enum('0','1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `recipes`
--

CREATE TABLE `recipes` (
  `id_recipe` int(11) NOT NULL,
  `id_region` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `star_ingredient` enum('viande','poisson','fruits de mer','vegetarien') NOT NULL,
  `difficulty` enum('1','2','3','4','5') NOT NULL,
  `prep_time` time NOT NULL,
  `cook_time` time NOT NULL,
  `portion` int(11) NOT NULL,
  `ingredients` longtext NOT NULL,
  `methods` longtext NOT NULL,
  `story` longtext NOT NULL,
  `status` enum('En attente','validée') NOT NULL DEFAULT 'En attente',
  `picture_recipe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `recipes`
--

INSERT INTO `recipes` (`id_recipe`, `id_region`, `id_user`, `title`, `star_ingredient`, `difficulty`, `prep_time`, `cook_time`, `portion`, `ingredients`, `methods`, `story`, `status`, `picture_recipe`) VALUES
(13, 1, 2, '123213', 'viande', '1', '00:00:13', '00:00:13', 123213, '123123', '123213213', '21321321', 'En attente', 'chapeau-chasse.jpeg'),
(14, 1, 2, 'COUSCOUS héhéhéhé', 'viande', '2', '10:10:00', '20:20:00', 52, '\r\n654654\r\n654\r\n654\r\n654\r\n654\r\n65\r\n4\r\n65\r\n4\r\n65465\r\n4\r\n65', '654\r\n654\r\n564\r\n654\r\n564\r\n654', '654\r\n65\r\n465\r\n465\r\n4', 'En attente', 'pantalon-noir.jpg'),
(15, 1, 2, 'Boeuf aux vermicelles', 'viande', '3', '01:00:00', '00:15:00', 6, '600g de boeuf\r\n2 gousses d\'ail', 'Couper le boeuf en lamelles\r\nEcraser l\'ail', 'HAHA drole', 'En attente', 'Boeuf-Vermicelles.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `regions`
--

CREATE TABLE `regions` (
  `region_name` varchar(255) NOT NULL,
  `id_region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `regions`
--

INSERT INTO `regions` (`region_name`, `id_region`) VALUES
('Hauts-de-France', 1),
('Grand Est', 2),
('Bourgogne-Franche-Comté', 3),
('Auvergne-Rhône-Alpes', 4),
('Provence-Alpes-Côte d\'Azur', 5),
('Corse', 6),
('Nouvelle-Aquitaine', 7),
('Centre-Val de Loire', 8),
('Île-de-France', 9),
('Normandie', 10),
('Pays de la Loire', 11),
('Bretagne', 12),
('Occitanie', 13),
('Guadeloupe', 14),
('Martinique', 15);

-- --------------------------------------------------------

--
-- Structure de la table `regions_details`
--

CREATE TABLE `regions_details` (
  `id_region_detail` int(11) NOT NULL,
  `picture_region` varchar(255) NOT NULL,
  `region_story` text NOT NULL,
  `details` text NOT NULL,
  `id_region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `regions_details`
--

INSERT INTO `regions_details` (`id_region_detail`, `picture_region`, `region_story`, `details`, `id_region`) VALUES
(1, '', 'Les Hauts-de-France comptent trois langues régionales : le ch’ti, le picard, le flamand.', 'La préfecture des Hauts de France est Lille.\r\n\r\nExceptionnel : le littoral des Hauts-de-France court du port de Dunkerque aux villas Belle Époque de Mers-les-Bains, des stations balnéaires la côte d’Opale aux longues plages et landes sauvages de la côte picarde.', 1),
(2, '', 'La région a une forte dimension industrielle. Frontalière avec la Belgique, le Luxembourg, l\'Allemagne et la Suisse, elle est particulièrement ouverte aux marchés internationaux. Le Rhin, à l\'est, est la colonne vertébrale de la mégalopole européenne et l\'axe majeur des échanges économiques du continent.', 'Le Grand Est est une région administrative française résultant de la fusion des anciennes régions Alsace, Lorraine et Champagne-Ardenne. Elle compte 5 554 645 habitants et réunit, sur 57 433 km2, des territoires de l\'Europe rhénane (le Haut-Rhin, le Bas-Rhin, la Meurthe-et-Moselle, la Moselle et l\'Est des Vosges) à l\'est et des territoires du bassin parisien (les Ardennes et la Marne) à l\'ouest, séparés par la diagonale du vide (qui inclut majoritairement des territoires de la Haute-Marne, de l\'Aube et de la Meuse).', 2),
(3, '', 'C\'est également à Dijon que se trouve la préfecture de région mais les grands services régionaux de l\'État sont répartis entre Besançon et Dijon.', 'La région s\'étend sur 47 784 km2, compte 2 820 623 habitants en 2014 et réunit les huit départements de la Côte-d\'Or, du Doubs, de la Haute-Saône, du Jura, de la Nièvre, de Saône-et-Loire, du Territoire de Belfort et de l\'Yonne.', 3),
(4, '', 'Le nom « Auvergne-Rhône-Alpes » a été formé en juxtaposant par ordre alphabétique les noms des deux anciennes régions. ', 'L\'Auvergne-Rhône-Alpes est une région administrative française. Située dans la partie centrale et orientale du sud de la France, elle a été créée par la réforme territoriale de 2015. Mise en place après les élections régionales de décembre 2015, elle regroupe les anciennes régions Auvergne et Rhône-Alpes. Elle se compose de 12 départements et d\'une métropole à statut de collectivité territoriale, s\'étend sur 69 711 km2 et compte 7 757 595 habitants5. Lyon est le chef-lieu de la région.', 4),
(5, '', 'En 1970, Provence-Côte d’Azur-Corse devient Provence-Côte d’Azur à la suite de la constitution de la région Corse. En 1976, elle est rebaptisée Provence-Alpes-Côte d’Azur.', 'Provence-Alpes-Côte d\'Azur est formée de six départements issus des anciennes provinces de Provence et du Dauphiné. Une partie de Vaucluse est issue du Comtat Venaissin et la rive gauche du Var, dans les Alpes-Maritimes constituait autrefois le comté de Nice, les villes de Menton et Roquebrune-Cap-Martin ayant fait partie de la principauté de Monaco jusqu\'à leur rattachement à la France en 1861.', 5),
(6, '', 'Bien des légendes existent sur l\'origine du nom donné à l\'île de Corse. Parmi les plus tenaces, celle qui veut que les Grecs l\'aient appelée Kallistê (en grec ancien ???????? : « la plus belle ») et dont on sait maintenant qu\'elle est fausse', 'Quatrième île de Méditerranée par sa superficie, la Corse a fait partie durant près de quatre siècles de la République de Gênes avant de se déclarer indépendante le 30 janvier 1735. En 1755 elle adopte la première constitution démocratique de l\'histoire moderne donnant pour la première fois le droit de vote aux femmes. Le 15 mai 1768 elle est cédée par Gênes à la France, contre son gré car elle se considère indépendante. Elle est conquise militairement par le Royaume de France lors de la bataille de Ponte-Novo, le 9 mai 1769.', 6),
(7, '', 'Elle est la plus vaste région de France (métropole et outre-mer confondus), avec une superficie supérieure à celle de l’Autriche.', 'La Nouvelle-Aquitaine dans sa version originale Écouter est une région administrative française, créée par la réforme territoriale de 2015 et effective au 1er janvier 2016, après les élections régionales de décembre 2015. Résultant de la fusion des anciennes régions Aquitaine, Limousin et Poitou-Charentes, elle s\'est d\'abord appelée provisoirement Aquitaine-Limousin-Poitou-Charentes. Elle regroupe 12 départements, s’étend sur 84 061 kilomètres carrés, soit un huitième du territoire national, et compte 5 879 144 habitants (population municipale au 1er janvier 2014).', 7),
(8, '', 'Le Centre-Val de Loire (dénommée Centre avant le 17 janvier 20153) est une région administrative française qui regroupe trois régions historiques : le Berry, l\'Orléanais et la Touraine. L\'extrémité sud-est du territoire faisait partie d\'une quatrième province : le Bourbonnais. Une partie de la région se situe dans la région naturelle du Val de Loire.', 'Septième région par sa superficie, le Centre-Val de Loire s\'étend sur 39 151 km2. Avec 2,58 millions d\'habitants au 1er janvier 2014, soit 4 % de la population métropolitaine, la région se situe au 12e rang national ce qui fait d\'elle une des régions les moins peuplées de France métropolitaine. Sa densité de 66 habitants par km2, moitié moindre que celle de la France métropolitaine, en fait une région peu peuplée. La densité de population est plus forte sur l\'axe ligérien où vivent la moitié des habitants.', 8),
(9, '', 'Avec un PIB estimé à 642 milliards d\'euros et un PIB par habitant de 52 788 euros en 20132, c\'est la région qui produit le plus de richesses en France.', 'L’Île-de-France (prononcé [il d? f???s]), que l\'on connaît aussi sous le nom populaire de « région parisienne », est une région historique et administrative française. Il s\'agit d\'une région très fortement peuplée, qui représente à elle seule 18,8 % de la population de la France métropolitaine, ce qui en fait la région la plus peuplée (12,03 millions d\'habitants en 2014) et à la plus forte densité (1 001 hab/km2) de France. Ses habitants sont appelés les Franciliens.', 9),
(10, '', 'Fondé en Neustrie par Rollon, le duché de Normandie occupe à partir de 911 la basse vallée de la Seine, puis le Bessin, le pays d\'Auge et l\'Hiémois en 924, le Cotentin, l’Avranchin et les îles de la Manche en 933.', 'La Normandie (en normand : Normaundie, en anglais : Normandy) est un territoire géographique et culturel, situé au nord-ouest de la France et bordé par la Manche ; elle a traversé différentes époques historiques, malgré une absence de reconnaissance administrative entre la Révolution française et la réforme territoriale la reconnaissant. Par son histoire les frontières continentales de la province de l\'Ancien Régime épousent assez fidèlement celles de la région administrative contemporaine.', 10),
(11, '', 'Les Pays de la Loire sont une région du Grand Ouest français regroupant les départements de la Loire-Atlantique, de Maine-et-Loire, de la Mayenne, de la Sarthe et de la Vendée.', 'La préfecture de région est Nantes, qui est aussi la ville la plus peuplée.\r\n\r\nBordée à l’ouest par le golfe de Gascogne (océan Atlantique-Nord), elle est délimitée au nord par les régions Bretagne et Normandie, à l’est par le Centre-Val de Loire avec qui elle partage la région naturelle du Val de Loire, et au sud par la Nouvelle-Aquitaine.', 11),
(12, '', 'La Bretagne est une entité géographique et culturelle à l\'identité forte, notamment marquée par son histoire. Elle occupe une péninsule, à l\'extrémité ouest de la France, située entre la Manche au nord, la mer Celtique et la mer d\'Iroise à l\'ouest et le golfe de Gascogne au sud.', 'À la fin de l\'Empire romain, elle connaît un afflux de population dû à l\'immigration massive, de Bretons insulaires dans une partie de l\'ancienne Armorique gauloise. Ceux-ci créent un royaume4 au ixe siècle, qui devient ensuite un duché5 dépendant du royaume de France. Réunie à la Couronne de France en 1532, elle intègre le Domaine royal et devient une province française, jusqu\'à sa disparition administrative en 1790 et sa division en cinq départements : Côtes-du-Nord, Finistère, Ille-et-Vilaine, Loire-Inférieure et Morbihan.', 12),
(13, '', 'Elle s\'étend sur 72 724 km2 ce qui en fait la troisième plus vaste région de France derrière la Nouvelle-Aquitaine et la Guyane, et la deuxième de France métropolitaine3. Elle compte 5 830 166 habitants (population municipale au 1er janvier 20164, et constitue ainsi la cinquième région française (et métropolitaine) la plus peuplée.', 'L\'Occitanie est une région administrative française créée par la réforme territoriale de 2014 et comportant 13 départements, et qui résulte de la fusion des anciennes régions Languedoc-Roussillon et Midi-Pyrénées. Temporairement appelée Languedoc-Roussillon-Midi-Pyrénées, le nom « Occitanie » est officiel depuis le 28 septembre 2016 et effectif depuis le 30 septembre 20161.', 13),
(14, '', 'La Guadeloupe (Gwadloup en créole et, par abus de langage confondant les deux parties de l\'île, Karukera en amérindien) est à la fois une région monodépartementale de l\'Outre-mer français et une région ultrapériphérique européenne, située dans les Caraïbes ; son code départemental officiel est le « 971 ».', 'Ce territoire des Antilles et département d\'outre-mer français, bordé par la mer des Caraïbes et l\'océan Atlantique, est situé à environ 6 200 km de la France métropolitaine, à 600 km au nord des côtes du Venezuela en Amérique du Sud, à 700 km à l\'est de la République dominicaine et à 2 200 km au sud-est des États-Unis.', 14),
(15, '', 'La Martinique est située dans l\'arc volcanique des petites Antilles, dans la mer des Caraïbes, entre la Dominique au nord et Sainte-Lucie au sud, à environ 450 km au nord-est des côtes du Venezuela, et environ 700 km au sud-est de la République dominicaine.', 'La Martinique (en créole martiniquais Matinik, Matnik ou Lamatinik1), aussi surnommée « l’île aux fleurs »2, est une région insulaire française située dans les Caraïbes plus précisément dans l\'archipel des petites Antilles. Elle est administrée dans le cadre d\'une collectivité territoriale unique dirigée par l\'assemblée de Martinique. Son code Insee est le 972. C\'est également une région ultrapériphérique de l\'union européenne.', 15);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `civility` enum('mme','m') NOT NULL DEFAULT 'm',
  `id_region` int(11) NOT NULL,
  `status` enum('admin','membre') NOT NULL DEFAULT 'membre',
  `user_picture` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `lastname`, `firstname`, `email`, `username`, `civility`, `id_region`, `status`, `user_picture`, `password`) VALUES
(2, 'admin', 'admin', 'admin@mail.fr', 'admin', 'm', 9, 'admin', '', '$2y$10$33T7qSj5.0ILpP45AV52/O5gElkLrOukYkho4ZFH5z0KX6FPvGX92');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_recipe` (`id_recipe`);

--
-- Index pour la table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id_rate`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD KEY `id_recipe` (`id_recipe`);

--
-- Index pour la table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id_recipe`),
  ADD KEY `id_region` (`id_region`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id_region`);

--
-- Index pour la table `regions_details`
--
ALTER TABLE `regions_details`
  ADD PRIMARY KEY (`id_region_detail`),
  ADD KEY `id_region` (`id_region`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_region` (`id_region`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rate` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id_recipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `regions`
--
ALTER TABLE `regions`
  MODIFY `id_region` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `regions_details`
--
ALTER TABLE `regions_details`
  MODIFY `id_region_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_recipe`) REFERENCES `recipes` (`id_recipe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`id_recipe`) REFERENCES `recipes` (`id_recipe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`id_region`) REFERENCES `regions` (`id_region`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `recipes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `regions_details`
--
ALTER TABLE `regions_details`
  ADD CONSTRAINT `regions_details_ibfk_1` FOREIGN KEY (`id_region`) REFERENCES `regions` (`id_region`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_region`) REFERENCES `regions` (`id_region`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;