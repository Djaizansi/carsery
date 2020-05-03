<?php
session_start();
header("Content-type: image/png");

$image = imagecreate(400, 100);

$back = imagecolorallocate($image, rand(0,100), rand(0,100), rand(0,100));

$charsAuthorized = "abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ0123456789"; //Permet de prendre des chiffres ou des lettres Maj ou Min
$charsAuthorized = str_shuffle($charsAuthorized);
$lengthCaptcha = rand(4,6);
$captcha = substr($charsAuthorized, 0, $lengthCaptcha);

$_SESSION["captcha"] = $captcha;


$listOfFonts = glob("fonts/*.ttf");

$x = rand(30,40);

for($i=0;$i<$lengthCaptcha;$i++){

	$colors[] = imagecolorallocate($image, rand(150,250), rand(150,250), rand(150,250));

	imagettftext($image, rand(20,40), rand(-45,45), $x, rand(35,45), $colors[$i], $listOfFonts[array_rand($listOfFonts)], $captcha[$i]);

	$x += rand(40,50);
}

$nbGeo = rand(4,10);
for($i=0 ; $i<=$nbGeo ; $i++){

	$draw = rand(1,3);
	switch ($draw) {
		case 1:
			imagerectangle($image, rand(0,400), rand(0,200), rand(0,400), rand(0,200), $colors[array_rand($colors)]);
			break;
		
		case 2:
			imageellipse($image, rand(0,400), rand(0,200), rand(0,400), rand(0,200), $colors[array_rand($colors)]);
			break;

		default:
			imageline($image, rand(0,400), rand(0,200), rand(0,400), rand(0,200), $colors[array_rand($colors)]);
			break;
	}

}

imagepng($image);


//Générer une chaîne aléatoire d'une longueur aléatoire entre 6 et 8

//Afficher cette chaîne dans l'image
//	-> avec une police aléatoire par caractère au format ttf se trouvant dans le dossier fonts
//	-> si je rajoute un fichier ttf il doit être automatiquement pris en compte
//	-> avec une position aléatoire par caractère
//	-> avec un angle aléatoire par caractère
//	-> avec une couleur aléatoire par caractère
//	-> avec une taille aléatoire par caractère
//	-> la couleur de fond doit être aléatoire
// 	-> ajouter par dessus une nombre aléatoire de formes géométriques aléatoires de couleurs déjà utilisées par le texte sur des positions aléatoires

//ATTENTION DOIT ÊTRE LISIBLE