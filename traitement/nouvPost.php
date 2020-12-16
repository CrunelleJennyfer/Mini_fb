<?php

$sql = "INSERT INTO ecrit VALUES (NULL,?,?, NOW(), ?, ?,?);";
$query = $pdo->prepare($sql);
$query->execute(array($_POST['titre'], $_POST['message'], $_POST['importImg'], $_SESSION['id'], $_POST['ami']));
header("Location:".$_SERVER['HTTP_REFERER']);

?>