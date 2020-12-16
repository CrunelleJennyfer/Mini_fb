
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Ma feuille de style à moi -->
    <link href="./css/style.css" rel="stylesheet">

    <script src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
<div class="acceuil">
    <form action='index.php?action=connexion' method='POST' id="coCrea">
        <div class="form">
            <label for="Pseudo">Identifiant </label>
            <input type="text" name="Pseudo" placeholder="Pseudo">
        </div>
        <div class="form">
            <label for="psw">Mot de passe </label>
            <input type="password" name="psw" placeholder="mot de passe">
        </div>
        <input type="submit" name="Connexion" id="envoyer">
    </form>
</div>
</body>
</html>