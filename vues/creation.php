<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Ma feuille de style à moi -->
    <link href="./css/style.css" rel="stylesheet">

    <script src="js/jquery-3.2.1.min.js"></script>
</head>

<body>
<div class="acceuil">
    <form action='index.php?action=crea' method='POST' id="coCrea">
        <div class="form">
            <label for="login">Identifiant </label>
            <input type="text" name="login" placeholder="Pseudo">
        </div>
        <div class="form">
            <label for="email">Mail </label>
            <input type="mail" name="email" placeholder="mail">
        </div>
        <div class="form">
            <label for="mdp">Mot de passe </label>
            <input type="password" name="mdp" placeholder="mot de passe">
        </div>
        <input type="submit" name="Entrer" id="envoyer">
    </form>
</div>
</body>
</html>