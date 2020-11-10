<?php

$sql = "INSERT INTO ecrit VALUES (NULL,?,?, NOW(), NULL, ?,?);";
$query = $pdo->prepare($sql);
$query->execute(array($_POST['titre'], $_POST['message'], $_SESSION['id'], $_POST['ami']));
header("Location:".$_SERVER['HTTP_REFERER']);

?>