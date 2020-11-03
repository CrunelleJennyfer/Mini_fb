<?php
if (!isset($_POST['login']) || !isset($_POST['mdp']) || !isset($_POST['email'])) {
    $_SESSION['info'] = "Inscription impossible - Identifiants invalides";
    header("Location:index.php");
} else {

    $query = $pdo->prepare("select * from user where login=?");
    $query->execute(array($_POST['login']));

    $result = $query->fetch();

    if ($result != false) {
        $_SESSION['info'] = "Inscription impossible - l'utilisateur existe déjà";
        header("Location:index.php?action=register");
    } else {
        $query2 = $pdo->prepare("insert into user(login,mdp,email) values (?,PASSWORD(?),?)");
        $query2->execute(array($_POST['login'],$_POST['mdp'],$_POST['email']));

        $_SESSION['id'] = $pdo->lastInsertId();
        $_SESSION['login'] = $_POST['login'];
        header("Location:index.php?action=mur");
    }
}
?>