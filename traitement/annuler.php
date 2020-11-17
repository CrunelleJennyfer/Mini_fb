<?php
$sql = "DELETE FROM lien WHERE etat='attente' AND (idUtilisateur2=? AND idUtilisateur1=?)";
$query= $pdo->prepare($sql);
$query->execute(array($_SESSION['id'],$_POST['id']));
header("Location:index.php?action=monMur");
?>