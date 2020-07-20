<?php

session_start();


// On vérifie si le fichier d'installation et les variables de bases de données existent

if (
  isset($_POST['dbdriver']) &&
  isset($_POST['dbhost']) &&
  isset($_POST['dbname']) &&
  isset($_POST['dbuser']) &&
  isset($_POST['dbpwd']) &&
  !file_exists('../' . $_SESSION['filename'])
) {
  $_SESSION['dbdriver'] = trim($_POST['dbdriver']);
  $_SESSION['dbhost'] = trim($_POST['dbhost']);
  $_SESSION['dbname'] = trim($_POST['dbname']);
  $_SESSION['dbuser'] = trim($_POST['dbuser']);
  $_SESSION['dbpwd'] = trim($_POST['dbpwd']);

  try {
    $pdo = new PDO($_SESSION['dbdriver'] . ":host=" . $_SESSION['dbhost'] . ";dbname=" . $_SESSION['dbname'], $_SESSION['dbuser'], $_SESSION['dbpwd']);
  } catch (Exception $e) {
    $_SESSION['sql'] = $e->getMessage();
    header("Location: step_2.php");
    exit();
  }

  // On ouvre le fichier de configuration
  $handle = fopen('../' . $_SESSION['filename'], "a+");

  $txt = "<?php
        define(\"DBDRIVER\", \"" . $_SESSION['dbdriver'] . "\");
        define(\"DBHOST\", \"" . $_SESSION['dbhost'] . "\");
        define(\"DBNAME\", \"" . $_SESSION['dbname'] . "\");
        define(\"DBUSER\", \"" . $_SESSION['dbuser'] . "\");
        define(\"DBPWD\", \"" . $_SESSION['dbpwd'] . "\");
        define(\"WEBSITE_TITLE\", \"" . $_SESSION['namewebsite'] . "\");             
        define(\"DESCRIPTION\", \"" . $_SESSION['descwebsite'] . "\");";

  fwrite($handle, $txt);
  fclose($handle);

  // On ouvre le fichier .env

  $fileEnv = ".env";
  $file = fopen('../' . $fileEnv, 'a+');

  // On écrit les constantes de configuration

  $constantsConf =
    'DB_USER=' . $_SESSION['dbuser'] . "\n" .
    'DB_PWD=' . $_SESSION['dbpwd'] . "\n" .
    'DB_HOST=' . $_SESSION['dbhost'] . "\n" .
    'DB_DRIVER=' . $_SESSION['dbdriver'] . "\n" .
    'DB_NAME=' . $_SESSION['dbname'] . "\n";

  fwrite($file, $constantsConf);

  // On ferme le fichier

  fclose($file);

  // Mot de passe cryptés

  $passwordUser1 = '$5$rounds=5000$58=ZpSWLHwfQ2uC?$mnzlNTUjhAV81.vZdj2BpmYK6CMLAtmsDMYy4d.Rhh/'; // ID = 1 -> Azerty123

  // Installation de SQL

  $pdo->exec("CREATE TABLE `ymnw_article` (
    `id` int(11) NOT NULL,
    `title` varchar(200) NOT NULL,
    `description` text NOT NULL,
    `tags` varchar(200) DEFAULT NULL,
    `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `modification_date` timestamp NULL DEFAULT NULL,
    `author` int(11) NOT NULL,
    `category` int(11) NOT NULL,
    `resolve` tinyint(1) NOT NULL DEFAULT '0'
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_article`
  --
  
  INSERT INTO `ymnw_article` (`id`, `title`, `description`, `tags`, `creation_date`, `modification_date`, `author`, `category`, `resolve`) VALUES
  (19, 'Vitre teintÃ©', '                                Test fumÃ©ess              \r\n              ', NULL, '2020-07-13 11:49:17', '2020-07-06 01:19:25', 13, 2, 0),
  (23, 'Test IDD', '                                                                    Test                \r\n                                            eztz', NULL, '2020-07-13 11:49:13', '2020-07-19 21:15:39', 19, 2, 0),
  (26, 'ezfzef', '                            efzefze', NULL, '2020-07-19 21:19:25', NULL, 13, 2, 0),
  (27, 'zefez', '                  fzefzef          ', NULL, '2020-07-19 21:25:15', NULL, 19, 2, 0),
  (28, 'Nes', '                            Hey', NULL, '2020-07-19 21:33:16', NULL, 13, 1, 0);
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_category`
  --
  
  CREATE TABLE `ymnw_category` (
    `id` int(8) NOT NULL,
    `name` varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_category`
  --
  
  INSERT INTO `ymnw_category` (`id`, `name`) VALUES
  (2, 'Carrosserie'),
  (1, 'Pneumatique');
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_contact`
  --
  
  CREATE TABLE `ymnw_contact` (
    `id` int(11) NOT NULL,
    `nom` varchar(255) NOT NULL,
    `adresse` varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_contact`
  --
  
  INSERT INTO `ymnw_contact` (`id`, `nom`, `adresse`) VALUES
  (1, 'Audi', '88 Cours de Vincennes, 75012 Paris'),
  (2, 'Mercedes', 'Mercedes Paris'),
  (3, 'Volswagen', 'Volswagen France');
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_marques`
  --
  
  CREATE TABLE `ymnw_marques` (
    `id` int(11) NOT NULL,
    `nomMarque` varchar(200) NOT NULL,
    `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  --
  -- Déchargement des données de la table `ymnw_marques`
  --
  
  INSERT INTO `ymnw_marques` (`id`, `nomMarque`, `date_inserted`, `date_updated`) VALUES
  (1, 'Audi', '2020-03-10 14:27:58', NULL),
  (2, 'Citroen', '2020-03-10 14:27:58', NULL),
  (3, 'Mercedes', '2020-03-10 14:27:58', NULL),
  (4, 'Mazda', '2020-03-10 14:49:30', NULL),
  (5, 'Opel', '2020-07-16 18:51:49', '2020-07-17 09:14:16'),
  (6, 'Renault', '2020-07-17 09:24:21', NULL),
  (7, 'Peugeot', '2020-07-17 21:04:44', NULL),
  (8, 'Toyota', '2020-07-18 07:44:25', NULL);
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_message`
  --
  
  CREATE TABLE `ymnw_message` (
    `id` int(11) NOT NULL,
    `message` text NOT NULL,
    `article` int(11) NOT NULL,
    `author` int(11) NOT NULL,
    `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `modification_date` timestamp NULL DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_message`
  --
  
  INSERT INTO `ymnw_message` (`id`, `message`, `article`, `author`, `creation_date`, `modification_date`) VALUES
  (15, '                                    Testss       ezfzefez         \r\n                ', 19, 19, '2020-07-06 01:59:00', '2020-07-13 11:47:00'),
  (17, '\r\n                coucou\r\n', 26, 19, '2020-07-19 21:25:25', NULL);
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_modeles`
  --
  
  CREATE TABLE `ymnw_modeles` (
    `id` int(11) NOT NULL,
    `nomModele` varchar(200) NOT NULL,
    `marque` int(11) NOT NULL,
    `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  --
  -- Déchargement des données de la table `ymnw_modeles`
  --
  
  INSERT INTO `ymnw_modeles` (`id`, `nomModele`, `marque`, `date_inserted`, `date_updated`) VALUES
  (1, 'Audi S5', 1, '2020-03-10 14:32:19', NULL),
  (2, 'Audi S6', 1, '2020-03-10 14:32:19', NULL),
  (3, 'Audi S7', 1, '2020-03-10 14:32:19', NULL),
  (4, 'Citroen Visa', 2, '2020-03-10 14:32:19', NULL),
  (5, 'Citroen Sm', 2, '2020-03-10 14:32:19', NULL),
  (6, 'Mercedes Marco Polo', 3, '2020-03-10 14:32:19', NULL),
  (7, 'Opel Corsa', 5, '2020-07-17 09:14:53', NULL),
  (8, 'Renault Clio 3', 6, '2020-07-17 09:24:33', NULL),
  (9, 'Peugeot 207', 7, '2020-07-17 21:05:50', NULL),
  (11, 'Audi S8', 1, '2020-07-18 08:25:23', NULL),
  (16, 'Mazda2', 4, '2020-07-18 14:33:32', NULL),
  (17, 'Toyota Yaris', 8, '2020-07-18 14:34:15', NULL);
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_page`
  --
  
  CREATE TABLE `ymnw_page` (
    `id` int(11) NOT NULL,
    `titre` varchar(150) NOT NULL,
    `auteur` varchar(100) NOT NULL,
    `content` text,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `publie` tinyint(4) NOT NULL,
    `menu` tinyint(4) NOT NULL,
    `home` tinyint(4) NOT NULL,
    `template` tinyint(4) DEFAULT NULL,
    `uri` varchar(100) NOT NULL,
    `token` varchar(255) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_page`
  --
  
  INSERT INTO `ymnw_page` (`id`, `titre`, `auteur`, `content`, `date`, `publie`, `menu`, `home`, `template`, `uri`, `token`) VALUES
  (12, 'Forum', 'Youcef', '<p>ezfijzeifezjf</p>\r\n<p>[forum 1]</p>', '2020-06-24 11:11:07', 1, 1, 0, 1, '/myproject/forum', 'XhuD5WRoWCAD4tT8tD4cAosTmqA='),
  (13, 'Accueil', 'Youcef', '<h1 style=\"text-align: center;\"><span style=\"font-family: \'courier new\', courier, monospace;\">Bienvenu sur le site fait par Carsery!</span></h1>\r\n<p style=\"text-align: center;\"><em><span style=\"text-decoration: underline;\">Le 07/07/2020</span></em></p>\r\n<p style=\"text-align: center;\"><img class=\"addslash\" src=\"public/images_upload/S0-mercedes-la-cla-45-amg-devoilee-par-erreur-590119.jpg\" alt=\"\" width=\"971\" height=\"558\" /></p>\r\n<p style=\"text-align: center;\">Les statistiques</p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>Ffjdjfjdkxdnz\'wnfndkw\'f</p>\r\n<p style=\"text-align: center;\">[carousel 2]</p>\r\n<p style=\"text-align: center;\"><img class=\"addslash\" src=\"public/images_upload/Urus-03.jpg\" alt=\"\" width=\"1012\" height=\"768\" /></p>\r\n<p style=\"text-align: center;\">test</p>', '2020-06-08 13:25:00', 1, 1, 1, 1, '/myproject/accueil', 'RUHOUu720v4uz2rAIwB3NxYXq8w='),
  (19, 'exemple', 'Youcef', '<p style=\"text-align: center;\">coucou</p>\r\n<p style=\"text-align: center;\">[carousel 1]</p>\r\n<p style=\"text-align: center;\">dsgdiau sugda gsidu</p>\r\n<p><img class=\"addslash\" style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"public/images_upload/mercedes_20cla180amglinesd2b_angularfront.png\" alt=\"\" width=\"600\" height=\"400\" /></p>\r\n<p style=\"text-align: center;\">Waouuuu</p>', '2020-07-06 15:12:36', 1, 1, 0, 1, '/myproject/exemple', 'MK3b14jetrszEDjXfj4bx8uIh0A='),
  (20, 'Vehicule', 'Youcef', '<p>[voiture 1]</p>', '2020-06-20 13:18:00', 1, 1, 0, 1, '/myproject/vehicule', 'wVtiegzZ6Mgfiw3SVe9JLQCYHE8='),
  (21, 'piece', 'Marwane', 'Hello. [piece 1]', '2020-07-16 08:41:57', 1, 1, 0, 1, '/myproject/piece', 'gdeiZOBikeJoH7PxDcB1KpYH/Wg='),
  (22, 'Contact', 'Marwane', '<p>[contact 1]</p>', '2020-07-18 14:02:00', 1, 1, 0, 1, '/myproject/contact', 'GR8Zzr4GzaLraxjYuHeUHvRo/0g='),
  (24, 'zetetet', 'Marwane', 'Hello', '2020-07-19 21:14:00', 1, 1, 0, 1, '/myproject/zetetet', 'u7AK4ouPECqq14coItAh/hi.kJ0=');
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_paniers`
  --
  
  CREATE TABLE `ymnw_paniers` (
    `id` int(11) NOT NULL,
    `user` int(11) NOT NULL,
    `piece` int(11) NOT NULL,
    `quantite` int(11) NOT NULL,
    `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_pieces`
  --
  
  CREATE TABLE `ymnw_pieces` (
    `id` int(11) NOT NULL,
    `nomPiece` varchar(100) NOT NULL,
    `description` varchar(500) NOT NULL,
    `prix` float NOT NULL,
    `reference` varchar(20) NOT NULL,
    `stock` int(11) NOT NULL,
    `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  --
  -- Déchargement des données de la table `ymnw_pieces`
  --
  
  INSERT INTO `ymnw_pieces` (`id`, `nomPiece`, `description`, `prix`, `reference`, `stock`, `date_inserted`, `date_updated`) VALUES
  (1, 'Amortisseur SACHS', 'Systeme bitume, pression d\'huile Jambes de suspension', 56.2, '230271', 2, '2020-06-17 17:00:04', '2020-07-19 23:16:41'),
  (2, 'Pompe a eau FEBI BILSTEIN', 'Fonte d\'aluminium', 37.4, '212410', 8, '2020-06-17 17:03:54', '2020-07-15 22:04:40'),
  (3, 'Projecteur principal HELLA', 'gauche, H4, PY21W, W5W, sans ampoules, sans commande pour correcteur de site projecteur, Halogene', 68.92, '7350111', 6, '2020-07-05 09:27:52', '2020-07-15 22:05:34'),
  (4, 'Rotule de barre de connexion SWAG', 'Essieu avant gauche', 10.65, '60919605', 25, '2020-07-05 10:06:36', '2020-07-16 08:35:33'),
  (5, 'ezfzef', 'ezfzefez', 20, 'FZEFZ', 3, '2020-07-19 21:03:43', '2020-07-19 23:16:46'),
  (6, 'efzef', 'ezfzefze', 30, 'ZEFZEF', 3, '2020-07-19 21:04:46', '2020-07-19 23:16:43');
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_posts`
  --
  
  CREATE TABLE `ymnw_posts` (
    `id` int(11) NOT NULL,
    `title` varchar(30) NOT NULL,
    `author` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_posts`
  --
  
  INSERT INTO `ymnw_posts` (`id`, `title`, `author`) VALUES
  (1, 'Test', 1);
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_recuperation`
  --
  
  CREATE TABLE `ymnw_recuperation` (
    `id` int(11) NOT NULL,
    `mail` varchar(255) NOT NULL,
    `code` int(11) NOT NULL,
    `confirme` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_shortcode`
  --
  
  CREATE TABLE `ymnw_shortcode` (
    `id` int(11) NOT NULL,
    `shortcode` text NOT NULL,
    `description` varchar(255) DEFAULT NULL,
    `images` text,
    `type` varchar(20) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_shortcode`
  --
  
  INSERT INTO `ymnw_shortcode` (`id`, `shortcode`, `description`, `images`, `type`) VALUES
  (2, '[carousel 1]', 'Carousel Goku', '../public/images_upload/GokuUI.png', 'caroussel'),
  (3, '[carousel 2]', 'Carousel Goku et voiture', '../public/images_upload/GokuUI.png,../public/images_upload/mario.png', 'caroussel'),
  (13, '[carousel 5]', 'Carousel Mercedes', '../public/images_upload/S0-mercedes-la-cla-45-amg-devoilee-par-erreur-590119.jpg,../public/images_upload/audi-a3-sportback-2020-on-location.jpg', 'caroussel'),
  (14, '[forum 1]', 'Widget Forum', NULL, 'forum'),
  (15, '[piece 1]', 'Widget piece + panier', NULL, 'piece'),
  (20, '[carousel 6]', 'Caroussel de vÃ©hicule ( mercedes, audi, lambo )', '../public/images_upload/S0-mercedes-la-cla-45-amg-devoilee-par-erreur-590119.jpg,../public/images_upload/Urus-03.jpg,../public/images_upload/audi-a3-sportback-2020-on-location.jpg', 'caroussel'),
  (21, '[contact 1]', 'Formulaire de contact', NULL, 'contact'),
  (22, '[voiture 1]', 'Tableau de vehicule', NULL, 'voiture');
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_themes`
  --
  
  CREATE TABLE `ymnw_themes` (
    `id` int(11) NOT NULL,
    `title` varchar(20) NOT NULL,
    `content` varchar(50) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_themes`
  --
  
  INSERT INTO `ymnw_themes` (`id`, `title`, `content`) VALUES
  (1, 'Theme 1', 'Par defaut'),
  (2, 'Theme 2', 'Carsery Display'),
  (3, 'Theme 3', 'Carsery Remote');
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_users`
  --
  
  CREATE TABLE `ymnw_users` (
    `id` int(11) NOT NULL,
    `lastname` varchar(100) NOT NULL,
    `firstname` varchar(50) NOT NULL,
    `email` varchar(255) NOT NULL,
    `pwd` varchar(255) NOT NULL,
    `status` varchar(12) NOT NULL,
    `token` varchar(255) DEFAULT NULL,
    `theme` int(11) NOT NULL DEFAULT '1',
    `ban` tinyint(4) NOT NULL DEFAULT '0',
    `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_users`
  --
  
  INSERT INTO `ymnw_users` (`id`, `lastname`, `firstname`, `email`, `pwd`, `status`, `token`, `theme`, `ban`, `date_inserted`, `date_updated`) VALUES
  (13, 'BOUABDELLAH', 'Marwane', 'manbou92@hotmail.fr', '$passwordUser1', 'Admin', NULL, 1, 0, '2020-07-09 13:02:42', '2020-07-20 02:52:22'),
  (19, 'YOUCEF', 'Jallali', 'youcef.jallali@gmail.com', '$passwordUser1', 'Client', NULL, 1, 0, '2020-07-09 21:16:14', '2020-07-19 22:05:02');
  
  -- --------------------------------------------------------
  
  --
  -- Structure de la table `ymnw_voitures`
  --
  
  CREATE TABLE `ymnw_voitures` (
    `id` int(11) NOT NULL,
    `immatriculation` varchar(30) DEFAULT NULL,
    `anneeCreation` int(11) DEFAULT NULL,
    `compteur` int(11) DEFAULT NULL,
    `situation` varchar(50) DEFAULT NULL,
    `etat` varchar(50) DEFAULT NULL,
    `marque` int(11) NOT NULL,
    `modele` int(11) NOT NULL,
    `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  --
  -- Déchargement des données de la table `ymnw_voitures`
  --
  
  INSERT INTO `ymnw_voitures` (`id`, `immatriculation`, `anneeCreation`, `compteur`, `situation`, `etat`, `marque`, `modele`, `date_inserted`, `date_updated`) VALUES
  (2, 'CC-897-BB', 2008, 9000, 'Neuf', 'Disponible', 1, 2, '2020-03-10 14:37:07', '2020-07-17 08:45:40'),
  (3, 'FF-222-GG', 2012, 15000, 'En Occasion', 'Disponible', 1, 3, '2020-03-10 14:37:07', '2020-07-17 08:46:02'),
  (9, 'VB-745-ED', 2006, 41000, 'En occassion', 'Disponible', 7, 9, '2020-07-17 21:06:36', NULL),
  (10, 'QW-125-RT', 2010, 250000, 'En occassion', 'Disponible', 1, 1, '2020-07-17 21:09:36', NULL),
  (11, 'AA-111-BB', 2011, 350000, 'Neuf', 'Disponible', 3, 6, '2020-07-17 21:17:56', NULL),
  (17, 'CC-897-BN', 2000, 2000, 'Neuf', 'Disponible', 4, 8, '2020-07-18 07:05:47', NULL),
  (18, 'GT-751-TR', 2012, 254102, 'Neuf', 'Disponible', 8, 17, '2020-07-18 14:35:13', NULL),
  (20, 'AF-635-RF', 2020, 6789, 'Neuf', 'Disponible', 1, 1, '2020-07-19 15:26:54', NULL);
  
  --
  -- Index pour les tables déchargées
  --
  
  --
  -- Index pour la table `ymnw_article`
  --
  ALTER TABLE `ymnw_article`
    ADD PRIMARY KEY (`id`),
    ADD KEY `author` (`author`),
    ADD KEY `category` (`category`);
  
  --
  -- Index pour la table `ymnw_category`
  --
  ALTER TABLE `ymnw_category`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `cat_name_unique` (`name`);
  
  --
  -- Index pour la table `ymnw_contact`
  --
  ALTER TABLE `ymnw_contact`
    ADD PRIMARY KEY (`id`);
  
  --
  -- Index pour la table `ymnw_marques`
  --
  ALTER TABLE `ymnw_marques`
    ADD PRIMARY KEY (`id`);
  
  --
  -- Index pour la table `ymnw_message`
  --
  ALTER TABLE `ymnw_message`
    ADD PRIMARY KEY (`id`),
    ADD KEY `author` (`author`),
    ADD KEY `ymnw_message_ibfk_2` (`article`);
  
  --
  -- Index pour la table `ymnw_modeles`
  --
  ALTER TABLE `ymnw_modeles`
    ADD PRIMARY KEY (`id`),
    ADD KEY `marque` (`marque`);
  
  --
  -- Index pour la table `ymnw_page`
  --
  ALTER TABLE `ymnw_page`
    ADD PRIMARY KEY (`id`);
  
  --
  -- Index pour la table `ymnw_paniers`
  --
  ALTER TABLE `ymnw_paniers`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user` (`user`),
    ADD KEY `piece` (`piece`);
  
  --
  -- Index pour la table `ymnw_pieces`
  --
  ALTER TABLE `ymnw_pieces`
    ADD PRIMARY KEY (`id`);
  
  --
  -- Index pour la table `ymnw_posts`
  --
  ALTER TABLE `ymnw_posts`
    ADD PRIMARY KEY (`id`),
    ADD KEY `author` (`author`);
  
  --
  -- Index pour la table `ymnw_recuperation`
  --
  ALTER TABLE `ymnw_recuperation`
    ADD PRIMARY KEY (`id`);
  
  --
  -- Index pour la table `ymnw_shortcode`
  --
  ALTER TABLE `ymnw_shortcode`
    ADD PRIMARY KEY (`id`);
  
  --
  -- Index pour la table `ymnw_themes`
  --
  ALTER TABLE `ymnw_themes`
    ADD PRIMARY KEY (`id`);
  
  --
  -- Index pour la table `ymnw_users`
  --
  ALTER TABLE `ymnw_users`
    ADD PRIMARY KEY (`id`),
    ADD KEY `theme` (`theme`);
  
  --
  -- Index pour la table `ymnw_voitures`
  --
  ALTER TABLE `ymnw_voitures`
    ADD PRIMARY KEY (`id`),
    ADD KEY `ymnw_voitures_ibfk_1` (`marque`),
    ADD KEY `ymnw_voitures_ibfk_2` (`modele`);
  
  --
  -- AUTO_INCREMENT pour les tables déchargées
  --
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_article`
  --
  ALTER TABLE `ymnw_article`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_category`
  --
  ALTER TABLE `ymnw_category`
    MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_contact`
  --
  ALTER TABLE `ymnw_contact`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_marques`
  --
  ALTER TABLE `ymnw_marques`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_message`
  --
  ALTER TABLE `ymnw_message`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_modeles`
  --
  ALTER TABLE `ymnw_modeles`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_page`
  --
  ALTER TABLE `ymnw_page`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_paniers`
  --
  ALTER TABLE `ymnw_paniers`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_pieces`
  --
  ALTER TABLE `ymnw_pieces`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_posts`
  --
  ALTER TABLE `ymnw_posts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_recuperation`
  --
  ALTER TABLE `ymnw_recuperation`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_shortcode`
  --
  ALTER TABLE `ymnw_shortcode`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_themes`
  --
  ALTER TABLE `ymnw_themes`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_users`
  --
  ALTER TABLE `ymnw_users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_voitures`
  --
  ALTER TABLE `ymnw_voitures`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
  
  --
  -- Contraintes pour les tables déchargées
  --
  
  --
  -- Contraintes pour la table `ymnw_article`
  --
  ALTER TABLE `ymnw_article`
    ADD CONSTRAINT `ymnw_article_ibfk_1` FOREIGN KEY (`author`) REFERENCES `ymnw_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `ymnw_article_ibfk_2` FOREIGN KEY (`category`) REFERENCES `ymnw_category` (`id`);
  
  --
  -- Contraintes pour la table `ymnw_message`
  --
  ALTER TABLE `ymnw_message`
    ADD CONSTRAINT `ymnw_message_ibfk_1` FOREIGN KEY (`author`) REFERENCES `ymnw_users` (`id`),
    ADD CONSTRAINT `ymnw_message_ibfk_2` FOREIGN KEY (`article`) REFERENCES `ymnw_article` (`id`) ON DELETE CASCADE;
  
  --
  -- Contraintes pour la table `ymnw_modeles`
  --
  ALTER TABLE `ymnw_modeles`
    ADD CONSTRAINT `ymnw_modeles_ibfk_1` FOREIGN KEY (`marque`) REFERENCES `ymnw_marques` (`id`);
  
  --
  -- Contraintes pour la table `ymnw_paniers`
  --
  ALTER TABLE `ymnw_paniers`
    ADD CONSTRAINT `ymnw_paniers_ibfk_1` FOREIGN KEY (`user`) REFERENCES `ymnw_users` (`id`),
    ADD CONSTRAINT `ymnw_paniers_ibfk_2` FOREIGN KEY (`piece`) REFERENCES `ymnw_pieces` (`id`);
  
  --
  -- Contraintes pour la table `ymnw_voitures`
  --
  ALTER TABLE `ymnw_voitures`
    ADD CONSTRAINT `ymnw_voitures_ibfk_1` FOREIGN KEY (`marque`) REFERENCES `ymnw_marques` (`id`),
    ADD CONSTRAINT `ymnw_voitures_ibfk_2` FOREIGN KEY (`modele`) REFERENCES `ymnw_modeles` (`id`);
  COMMIT;");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Carsery</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="../public/css/styles.css">
</head>

<body>
  <div class="container">
    <div class="txt-center">
      <img src="../public/img/logo.png" alt="logo">
    </div>
    <div class="col-12 intro">
      <p class="txt-center">
        <i style="color: green;">La configuration de la base de données a été menée avec succès.</i>
        <br>
        Pour terminer l'installation, veuillez supprimer le dossier <q>installer</q>
        qui se trouve à la racine du CMS puis cliquez <a href="http://localhost/">ici</a>.
      </p>

      <div class="row">
        <div class="col-6">
          <h5 class="txt-center">Petit récap' du site</h5>
          <ul>
            <li>Nom : <?php echo $_SESSION['namewebsite']; ?></li>
            <li>Description : <?php echo $_SESSION['descwebsite']; ?></li>
          </ul>
        </div>
        <div class="col-6">
          <h5 class="txt-center">Informations de la base de données</h5>
          <ul>
            <li>Driver : <?php echo $_SESSION['dbdriver']; ?></li>
            <li>Adresse : <?php echo $_SESSION['dbhost'] ?></li>
            <li>Nom : <?php echo $_SESSION['dbname']; ?></li>
            <li>Utilisateur : <?php echo $_SESSION['dbuser']; ?></li>
            <li>Mot de passe : <i>Votre mot de passe</i></li>
          </ul>
        </div>
      </div>
    </div>
</body>

</html>