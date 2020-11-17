<?php
$sql = "DELETE FROM lien WHERE etat='attente' AND (idUtilisateur1=? AND idUtilisateur2=?)";
$query= $pdo->prepare($sql);
$query->execute(array($_SESSION['id'],$_POST['id']));
header("Location:index.php?action=monMur");
?>