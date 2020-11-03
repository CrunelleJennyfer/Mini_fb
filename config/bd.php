<?php
// Script login.php utilisé pour la connexion à la BD


$host = HOST; // le chemin vers le serveur (localhost dans 99% des cas)

$db = DB;
// A l IUT, 3 possibilité prenomnom prenomnom1...

$user = USER;
// A l iut prenom.nom

$passwd = PASSWORD;
// A l iut, généré automatiquement

try {
    // On essaie de créer une instance de PDO.
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $passwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "<br />";
    die(1);
}


?>