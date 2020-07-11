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
  $passwordUser2 = '$5$rounds=5000$j=kpyrJAXw?0NFmS$ye03NSHcv6omsbtxsyZwocWdxZAEhXc67PwDSH3B2.4'; // ID = 11 -> Azerty123

  // Installation de SQL

  $pdo->exec("CREATE TABLE `ymnw_page` (
    `id` int(11) NOT NULL,
    `titre` varchar(150) NOT NULL,
    `auteur` varchar(100) NOT NULL,
    `content` text,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `publie` tinyint(4) NOT NULL,
    `menu` tinyint(4) NOT NULL,
    `home` tinyint(4) NOT NULL,
    `uri` varchar(100) NOT NULL,
    `token` varchar(255) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_page`
  --
  
  INSERT INTO `ymnw_page` (`id`, `titre`, `auteur`, `content`, `date`, `publie`, `menu`, `home`, `uri`, `token`) VALUES
  (12, 'test', 'Youcef', 'ezfijzeifezjf', '2020-06-24 11:11:07', 0, 0, 0, '/myproject/test', 'OcbnDOtdk1VXO9x4BUsf4XbrOsg='),
  (13, 'bonjour les amis ca va', 'Youcef', '<h1 style=\"text-align: center;\">Bienvenu sur le site !</h1>\r\n<p style=\"text-align: center;\"><em><span style=\"text-decoration: underline;\">Le 07/07/2020</span></em></p>\r\n<p style=\"text-align: center;\"><img class=\"addslash\" src=\"public/images_upload/S0-mercedes-la-cla-45-amg-devoilee-par-erreur-590119.jpg\" alt=\"\" width=\"971\" height=\"558\" /></p>\r\n<p style=\"text-align: center;\">Les statistiques</p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 20%;\">ðŸ’¯</td>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n<td style=\"width: 20%;\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: center;\">[carousel 2]</p>', '2020-06-08 13:25:00', 1, 1, 1, '/myproject/bonjour-les-amis-ca-va', 'kSf5GrF04NQ.YyGtyLMugSBRlr8='),
  (15, 'testons', 'Youcef', '', '2020-06-29 20:03:00', 1, 0, 0, '/myproject/testons', 'oneRvGg3V8iiz0VL4S2gZO/5bM4='),
  (17, 'miam miam', 'Youcef', '', '2020-05-27 22:59:00', 0, 0, 0, '/myproject/miam-miam', '3H/4kFWFI5h7Y72pIQgDIoRd3N4='),
  (19, 'coucou', 'Youcef', '<p style=\"text-align: center;\">coucou</p>\r\n<p style=\"text-align: center;\">[carousel 1]</p>\r\n<p style=\"text-align: center;\">dsgdiau sugda gsidu</p>\r\n<p><img class=\"addslash\" style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"public/images_upload/mercedes_20cla180amglinesd2b_angularfront.png\" alt=\"\" width=\"600\" height=\"400\" /></p>', '2020-07-06 15:12:36', 1, 1, 0, '/myproject/coucou', '57kSgD2S0ibKMchVFf0gaCudTQQ='),
  (20, 'Final', 'Youcef', '<p>Hello</p>\r\n<p>[carousel 5]</p>', '2020-06-20 13:18:00', 1, 1, 0, '/myproject/final', 'XLruBBVz.fbf/K5JRYJwQ8D8j9I=');
  
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
    `images` text NOT NULL,
    `type` varchar(20) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
  --
  -- Déchargement des données de la table `ymnw_shortcode`
  --
  
  INSERT INTO `ymnw_shortcode` (`id`, `shortcode`, `images`, `type`) VALUES
  (2, '[carousel 1]', '../public/images_upload/GokuUI.png', 'caroussel'),
  (3, '[carousel 2]', '../public/images_upload/GokuUI.png,../public/images_upload/mario.png', 'caroussel'),
  (4, '[carousel 3]', '../public/images_upload/GokuUI.png,../public/images_upload/mario.png', 'caroussel'),
  (12, '[carousel 4]', '../public/images_upload/folderred_93207.png,../public/images_upload/mario.png', 'caroussel'),
  (13, '[carousel 5]', '../public/images_upload/S0-mercedes-la-cla-45-amg-devoilee-par-erreur-590119.jpg,../public/images_upload/audi-a3-sportback-2020-on-location.jpg', 'caroussel');
  
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
  (1, 'JALLALI', 'Youcef', 'youcef.jallali@gmail.com', '$passwordUser1', 'Admin', NULL, 1, 0, '2020-03-01 08:31:51', '2020-07-07 12:46:09'),
  (11, 'DJAIZANSI', 'Youss', 'djaizansi93@gmail.com', '$passwordUser2', 'Admin', NULL, 1, 0, '2020-07-03 08:49:17', '2020-07-03 10:42:27');

  --
  -- Index pour les tables déchargées
  --
  
  --
  -- Index pour la table `ymnw_page`
  --
  ALTER TABLE `ymnw_page`
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
  -- AUTO_INCREMENT pour les tables déchargées
  --
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_page`
  --
  ALTER TABLE `ymnw_page`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
  
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
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_themes`
  --
  ALTER TABLE `ymnw_themes`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
  
  --
  -- AUTO_INCREMENT pour la table `ymnw_users`
  --
  ALTER TABLE `ymnw_users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
  
  --
  -- Contraintes pour les tables déchargées
  --
  
  --
  -- Contraintes pour la table `ymnw_posts`
  --
  ALTER TABLE `ymnw_posts`
    ADD CONSTRAINT `ymnw_posts_ibfk_1` FOREIGN KEY (`author`) REFERENCES `ymnw_users` (`id`);
  
  --
  -- Contraintes pour la table `ymnw_users`
  --
  ALTER TABLE `ymnw_users`
    ADD CONSTRAINT `ymnw_users_ibfk_1` FOREIGN KEY (`theme`) REFERENCES `ymnw_themes` (`id`);
  COMMIT");
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