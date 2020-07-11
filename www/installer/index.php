<?php

// On redirige l'utilisateur vers la première étape de l'installation

header("Location: step_1.php");

// Puis on arrête le processus en cours sur cette page
exit();