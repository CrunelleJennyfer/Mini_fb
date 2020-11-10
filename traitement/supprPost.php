<?php
$sql = "DELETE FROM ecrit WHERE ecrit.id=? ";
$query= $pdo->prepare($sql);
$query->execute(array($_POST['id']));
header("Location:index.php?action=monMur");
?>