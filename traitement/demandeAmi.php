<?php
$sql = "INSERT INTO lien VALUES(NULL,?,?,'attente')";
$query = $pdo->prepare($sql);
$query->execute(array($_POST['id'], $_SESSION['id']));
header("Location:index.php?action=monMur&id=".$_SESSION['id']);

?>