<?php
$sql = "UPDATE lien set etat='ami' WHERE (idUtilisateur1=? AND idUtilisateur2=?)";
$query= $pdo->prepare($sql);
$query->execute(array($_SESSION['id'],$_POST['id']));
header("Location:index.php?action=monMur");
?>