<?php

$sql = "INSERT INTO aime WHERE ecrit.id=?";
$query = $pdo->prepare($sql);
$query->execute(array($_POST['love'], $_POST['nul'], $_POST['aime']));
header("Location:".$_SERVER['HTTP_REFERER']);

?>
