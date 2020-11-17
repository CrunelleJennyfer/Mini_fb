<?php
$sql = "DELETE FROM lien WHERE etat='ami' AND (idUtilisateur1=? AND idUtilisateur2=? 
        OR idUtilisateur1=? AND idUtilisateur2=?)";
$query= $pdo->prepare($sql);
$query->execute(array($_SESSION['id'],$_POST['id'],$_POST['id'],$_SESSION['id']));
header("Location:index.php?action=monMur");
?>