<?php

session_start();

// On vérifie si le fichier d'installation existe. Si c'est le cas, on redirige vers l'accueil

$filename = "conf.inc.php";
$_SESSION['filename'] = $filename;

if (file_exists('../' . $_SESSION['filename'])) {
    header("Locatio: step_3.php");
    exit();
}

// On vérifie l'existence des variables de sessions

if (!isset($_SESSION['namewebsite']) && !isset($_SESSION['descwebsite'])) {
    $_SESSION['namewebsite'] = $_POST['namewebsite'];
    $_SESSION['descwebsite'] = $_POST['descwebsite'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carsery</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="../public/css/styles.css">
</head>

<body>

    <div class="container">

        <div class="txt-center">
            <img src="../public/img/logo.png" alt="logo">
        </div>

        <?php

        if (isset($_SESSION['sql'])) {
            echo "<small class=\"form-text text-muted\" style='color: red'>Erreur de connexion de SQL : " . $_SESSION['sql'] . "</small>";
            unset($_SESSION['sql']);
        }

        ?>

        <div class="col-12 intro">

            <p class="txt-center">Vous devez saisir ci-dessous les détails de connexion à votre base de données. Si vous ne les connaissez pas, contactez votre hébergeur.</p>

            <form action="step_3.php" method="post" class="box">
                <div class="form-table">
                    <table>
                        <tr>
                            <th scope="row">
                                <label for="namewebsite">Driver de la base de données</label>
                            </th>
                            <td>
                                <input name="dbdriver" id="dbdriver" type="text" aria-describedby="dbdriver-desc" value="mysql" placeholder="Driver" autofocus required>
                            </td>
                            <td id="dbdriver-desc" class="desc">
                                Moteur de la base de données
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="namewebsite">Adresse de la base de données</label>
                            </th>
                            <td>
                                <input name="dbhost" id="dbhost" type="text" aria-describedby="dbhost-desc" value="database" placeholder="Adresse de la base de données" required>
                            </td>
                            <td id="dbhost-desc" class="desc">
                                Demandez cette information à l’hébergeur de votre site.
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="namewebsite">Nom de le base de données</label>
                            </th>
                            <td>
                                <input name="dbname" id="dbname" type="text" aria-describedby="dbname-desc" value="carsery" placeholder="Nom de la base de données" required>
                            </td>
                            <td id="dbname-desc" class="desc">
                                Le nom de la base de données avec laquelle vous souhaitez utiliser Carsery.
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="namewebsite">Nom d'utilisateur</label>
                            </th>
                            <td>
                                <input name="dbuser" id="dbuser" type="text" aria-describedby="dbuser-desc" value="root" placeholder="Nom d'utilisateur" required>
                            </td>
                            <td id="dbuser-desc" class="desc">
                                Nom d’utilisateur MySQL.
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="namewebsite">Mot de passe</label>
                            </th>
                            <td>
                                <input name="dbpwd" id="dbpwd" type="text" aria-describedby="dbpwd-desc" value="root" placeholder="Mot de passe" required>
                            </td>
                            <td id="dbpwd-desc" class="desc">
                                Votre mot de passe de base de données.
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="txt-center">
                    <button class="btn btn--primary" type="submit">Envoyer !</button>
                </div>

            </form>

        </div>

    </div>

</body>

</html>