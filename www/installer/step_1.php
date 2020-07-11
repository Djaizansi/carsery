<?php

session_start();

// On vérifie si une installation a été déjà faite

if (file_exists("../conf.inc.php")) {
    header("Location: step_3.php");
    exit();
}

// Versions PHP
$requiredVersion = "7.0.30";
$oldVersion = "6.0.8"; // Test de la condition


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carsery</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.0/js.cookie.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="../public/css/styles.css">
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                if (!Cookies.get('modalShown')) {
                    $("#myModal").modal('show');
                    Cookies.set('modalShown', true);
                }
            }, 1000);
            $.modal.defaults = {
                fadeDuration: 500,
            }
        });
    </script>
</head>

<body>

    <div id="myModal" class="modal">
        <h3 class="txt-center">Information importante</h3>
        <p class="txt-center">Pour assurer un fonctionnement correct du CMS, votre version PHP doit être supérieur à <i style="color: orange;">7.0.30.</i></p>
        <p class="txt-center">
            <?php
            if (version_compare(PHP_VERSION, $requiredVersion) >= 0) {
                $ok = "yes";
            ?>
                <i style="color: green;">Votre version actuelle de PHP (<?php echo PHP_VERSION; ?>) est compatible avec Carsery.</i>
            <?php
            } else { ?>
                <i style="color: red;">Votre version actuelle de PHP n'est pas jour (<?php echo PHP_VERSION; ?>).</i>
            <?php
            }
            ?>
        </p>

        <?php
        if (isset($ok)) {
        ?>
            <a href="#" rel="modal:close" style="text-decoration: none;">Ok super, je commence !</a>
        <?php
        } else { ?>
            <a href="#" rel="modal:close" style="text-decoration: none;">Ah mince, je vais régler ça !</a>
        <?php } ?>
    </div>

    <div class="container">

        <div class="txt-center">
            <img src="../public/img/logo.png" alt="logo">
        </div>

        <div class="col-12 intro">

            <p class="txt-center">Bonjour et bienvenue sur Carsery, veuillez saisir les champs ci-dessous pour commencer.</p>

            <form action="step_2.php" class="box" method="post">
                <div class="form-table">
                    <table>
                        <tr>
                            <th scope="row">
                                <label for="namewebsite">Nom du site</label>
                            </th>
                            <td>
                                <input name="namewebsite" id="namewebsite" type="text" aria-describedby="namewebsite-desc" placeholder="Nom du site" autofocus required>
                            </td>
                            <td id="namewebsite-desc" class="desc">
                                Le nom du site que vous souhaitez utiliser.
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="user">Description</label>
                            </th>
                            <td>
                                <input name="descwebsite" id="descwebsite" type="text" aria-describedby="descwebsite-desc" size="25" placeholder="Description" required>
                            </td>
                            <td id="descwebsite-desc" class="desc">
                                Une petite description du site que vous allez créer.
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="txt-center">
                    <button class="btn btn--primary" type="submit">Suivant</button>
                </div>

            </form>
        </div>

    </div>
</body>

</html>