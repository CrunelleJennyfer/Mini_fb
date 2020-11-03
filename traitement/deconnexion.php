<?php
unset($_SESSION['id']);
unset($_SESSION['login']);

header("location:index.php");
?>