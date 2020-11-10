<?php

$sql = "SELECT * FROM user WHERE login=? AND mdp=PASSWORD(?)";

// Etape 1  : preparation
$query = $pdo->prepare($sql);

// Etape 2 : execution : 2 paramètres dans la requêtes !!
$query->execute(array($_POST['Pseudo'], $_POST['psw']));

// Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.
$line = $query->fetch();
// un seul fetch

// Si $line est faux le couple login mdp est mauvais, on retourne au formulaire
if($line==FALSE){
    header("Location:index.php?action=login");
}

// sinon on crée les variables de session $_SESSION['id'] et $_SESSION['login'] et on va à la page d'accueil
else {
    $_SESSION['id']=$line['id'];
    $_SESSION['login']=$line['login'];
    header("location:vues/page2.php");
}
?>