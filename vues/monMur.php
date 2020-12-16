<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KiwiOn</title>

    

    <!-- Ma feuille de style à moi -->
    <link href="./css/style2.css" rel="stylesheet">

    <script src="js/jquery-3.2.1.min.js"></script>
</head>
<body class="container">
<?php
//si pas co, return acceuil
if(!isset($_SESSION["id"])){
    header("Location:index.php?action=login");
}

//afficher notre mur ou celui ami
$ok = false;


if(!isset($_GET["id"]) || $_GET["id"]==$_SESSION["id"]){
    $id = $_SESSION["id"];
    $ok = true;
} else{
    $id = $_GET["id"];
    //verif si ami
    $sql = "SELECT * FROM lien WHERE etat='ami' AND ((idUtilisateur1=? AND idUtilisateur2=?) OR (idUtilisateur1=? AND idUtilisateur2=?))"; //manque peut etre un truc
    $query = $pdo->prepare($sql);
    $query->execute(array($_GET["id"],$_SESSION["id"], $_SESSION["id"], $_GET['id']));
		$line=$query->fetch();
		if($line != false){
            $ok = true;
        }
}

if($ok==false){
    //pour voir le mur des gens qu'on a pas en ami
    $sql = "SELECT * FROM user order by user.login ASC";
    $query = $pdo->prepare($sql);
    $query->execute(array($_SESSION["id"],$_SESSION["id"]));
    while($line = $query->fetch()){
        if($line["id"]==$id){
            echo "<section class='ask_box'><p class='ask'>".$line['login']." n'est pas ton ami, donc ne l'espionne pas ! </p>";

        }
    }

    //pour demande ami en attente
    $attente = false;
    $sql = "SELECT * FROM lien WHERE (idUtilisateur1=? AND idUtilisateur2=?)";//manque peut etre un truc
    $query = $pdo->prepare($sql);
    $query->execute(array($_GET["id"], $_SESSION["id"]));//manque peut etre un truc
    while($line = $query->fetch()){
        if($line['etat'] == 'attente'){
            $attente = true;
            echo"<p>Tu l'as déjà demande en ami, arrête de spam...</p></br>";
        }
    }

    if($attente == false){
        //pour demander ami
        echo"</br><p>Es-tu vraiment sur que tu veux cette personne en ami ?</p>
        <div><form action = 'index.php?action=demandeAmi' method='POST'>
            <input type='hidden' name='id' value".$id.">
            <input type='submit' class='buttonAmi' value='Sur ?'>
        </form>";

    }



}

?>

<!-- affichage du menu si t'es motiver pour le responsive pour l'avoir genre comme sur les appli avec
les 3 pitit trait horizontal sinon y sert a rien faut le virer -->
<!-- <div class="encre">
    <a class="bouton" href="#top">Discut de Kiwis</a></br>
    <a class="bouton" href="#mid">Amis en Kiwis</a></br>
    <a class="bouton" href="#bot">Invit de Kiwis</a></br>
</div> -->
<!-- affichage du menu si t'es motiver pour le responsive pour l'avoir genre comme sur les appli avec
les 3 pitit trait horizontal sinon y sert a rien faut le virer -->
<div class="pageMur">
        <div class="bonjour">
            <?php 
            echo "Bonjour ".$_SESSION['login']." ! </br>";
            ?>

            
            <?php
            if(isset($_POST["env"])){
                $Pp=$_FILES['avatar']['name'];
                if($Pp!=""){
                    require "./traitement/uploadImage.php";
                    if($sortie==false){
                        $Pp=$dest_dossier.$dest_fichier;
                    }else{
                        $Pp="notdid";
                    }
                }
                if($Pp!="notdid"){
                    echo "<img id='pp' src='$Pp' alt='Profil'>";
                    $sql = "UPDATE user SET avatar ='".$Pp."'";
                    $query = $pdo->prepare($sql);
                    $query->execute();

                }else{
                    echo "<img id='pp' src='./img/Unknow.png' alt='Profil'>";
                }
            }else{
                echo "<img id='pp' src='./img/Unknow.png' alt='Profil'>";
            }
            ?>
            
            
        </div>
        <div class="deco">
            <form method="POST" name="formulaire" enctype="multipart/form-data">
                <div><p> Envie de changement? </p>
                <input type="file" name="avatar" id="avatar" /> </div>
                <div><input type="submit" class="btn" value="envoyer" /></div>
                <input type="hidden" value="b" name="env"/>
            </form>
            <p id='connexion'> <a href='index.php?action=deconnexion'>Deconnexion</a></p>
        </div>

        <div class="mur">
            <?php
                $sql = "SELECT * FROM user order by user.login ASC";
                $query = $pdo->prepare($sql);
                $query->execute(array($_SESSION['id']));//manque peut etre un truc
                while($line = $query->fetch()){
                    if($line['id'] == $id){
                        echo "<p>Mur de <b>".$line['login']."</b>, le meilleur des Kiwis</p>";
                    }
                }
            ?>
            <img id="banniere" src="./img/bannière.jpg" alt="bannière">
        </div>

        <div class="chat">
                <?php
                $sql = "SELECT *, ecrit.id AS idecrit FROM ecrit JOIN user ON idAuteur=user.id WHERE idAmi=? order by dateEcrit DESC";
                $query = $pdo->prepare($sql);
                $query->execute(array($id));
                while($line = $query->fetch()){
                    if($line['idAuteur'] == $_SESSION['id']){
                        echo "<div class='message'>";
                    }
                    echo "<p class='sayTitre'><a href=index.php?action=monMur&id=".$line['id']."><strong>".$line['login']."</strong></a> a partagé sa pensée :</p>";
                    echo "<p class='sayContent'>".$line['contenu']."</p>";
                    echo "<p class='sayDate'>".$line['dateEcrit']."</p>";

                    //del mess
                    if(($_SESSION['id'] == $line['idAuteur']) OR ($_SESSION['id'] == $line['idAmi'])){
                        echo "<form action='index.php?action=supprPost' method='POST'>
                                    <input type='hidden' name='id' value=".$line['idecrit'].">
                                    <input type='submit' class='boutSuppr' value='Supprimer'>
                            </form></div>";
                    }
                    echo "</br>";
                }
                ?>
        </div>
        
        <form class="submit" action="index.php?action=nouvPost" method="POST">
            <p>Une pensée à partager?</p>
            <input type="hidden" name="ami" value='<?php echo $id; ?>'>
            <input type="hidden" name="titre">
            <input type="text" name="message" class="msg" placeholder="Ecrivez ici...">
            <input type="submit" name="poster" class="sub" value=">">
        </form>

 <!-- appel la comme tu veux c'est la gestion d'ami demande+liste ami-->
        <div> <!-- appel la comme tu veux c'est la demande d'ami -->
            <div class="mid">
                <p>Rechercher un kiwi</p>
                <div class="search">
                    <?php
                    if(isset($_POST['search'])){
                        $sql = "SELECT * FROM user WHERE login LIKE concat('%',?,'%')";
                        $query = $pdo->prepare($sql);
                        $query->execute(array($_POST["search"]));
                        while($line = $query->fetch()){
                            $sql = "SELECT * FROM lien WHERE (idUtilisateur1=? AND idUtilisateur2=?)"; //manque peut etre untruc
                            $query2 = $pdo->prepare($sql);
                            $query2->execute(array($_SESSION['id'],$line["id"])); // manque peut etre des truc
                            $etat = $query2->fetch();
                            if($etat == false || $etat['etat'] != 'banni'){
                                if($line['id'] != $_SESSION['id']){
                                    echo "<a href=index.php?action=monMur&id=".$line['id'].">".$line['login']."</a>";
                                    if($etat == false){
                                        echo "<form action='index.php?action=demandeAmi' method='POST'>
                                                    <input type='hidden' name='id' value=".$line['id'].">
                                                    <input type='submit' class='boutAdd' value='Envoyer'>
                                            </form>";
                                    }else{
                                        echo "</br>";
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </div>
                
            </div>
            <form action="#" method="POST" id="formMid">
                <input type="search" name="search" class="search">
                <input type="submit" value=">" class="searchValid">
            </form>

            <div> <!-- appel la comme tu veux c'est pour la liste d'ami-->
            </div>
        </div>

        <div class="ami"><!-- appel la comme tu veux c'est la liste d'amis avec suppr ami-->
            <p>T'a liste de kiwi</p>
            <div>
                <?php
                    $id = $_SESSION['id'];
                    $sql = "SELECT * FROM user 
                    WHERE id IN ( SELECT user.id FROM user INNER JOIN lien ON idUtilisateur1=user.id 
                                    AND etat='ami' AND idUtilisateur2=? UNION SELECT user.id FROM user 
                                    INNER JOIN lien ON idUtilisateur2=user.id AND etat='ami' AND idUTilisateur1=?) 
                                    order by user.login ASC";
                    $query = $pdo->prepare($sql);
                    $query->execute(array($_SESSION["id"],$_SESSION["id"])); //2 $_SESSION["id"] c'est normal... sinon foncionne pas
                    while($line = $query->fetch()){
                        echo "<div class='boutDiv'>
                                    <a href=index.php?action=monMur&id=".$line['id'].">".$line['login']."</a>
                                    <form action='index.php?action=supprAmi' method='POST'>
                                            <input type='hidden' name='id' value=".$line['id'].">
                                            <input type='submit' name='boutDel' value='Supprimer'>
                                    </form>
                            </div>";
                    }
                ?>
            </div>
        </div>

        <div class="monMur"> <!-- bouton pour retourner page mon mur-->
            <?php
                echo "<form action='index.php?action=monMur' method='post'>
                            <input type='hidden' name='id' value=".$_SESSION['id'].">
                            <input type='submit' class='buttonMur' value='Mon mur'>
                    </form>";
            ?>
        </div>

        <div class="gestAm">
            <div class="invit"> <!-- gestion demande ami -->
                <p>Invitation</p>
                <?php
                    $sql="SELECT user.* FROM user INNER JOIN lien ON user.id=idUtilisateur2 
                        AND etat='attente' AND idUtilisateur1=? order by user.login ASC";
                    $query=$pdo->prepare($sql);
                    $query->execute(array($_SESSION['id']));
                    while($line=$query->fetch()){
                        echo "<div> 
                                <a href=index.php?action=mur&id=".$line['id'].">".$line['login']."</a>
                                <form action='index.php?action=accepter' method='post'>
                                    <input type='hidden' name='id' value=".$line['id'].">
                                    <input type='submit' class='buttonAccept' value='Accepter'>
                                </form>
                                
                                <form action='index.php?action=refuser' method='post'>
                                    <input type='hidden' name='id' value=".$line['id'].">
                                    <input type='submit' class='buttonRefus' value='Refuser'>
                                </form>
                            </div> ";
                    }
                ?>
            </div>

            <div class="Attente"> <!-- gestion demande amis en attente -->
                <p>En attente</p>
                <?php
                    $id=$_SESSION['id'];
                    $sql="SELECT user.* FROM user INNER JOIN lien ON user.id=idUtilisateur1 AND etat='attente'
                        AND idUtilisateur2=? order by user.login ASC";
                    $query=$pdo->prepare($sql);
                    $query->execute(array($_SESSION['id']));
                    while($line=$query->fetch()){
                        echo "<div>
                                <a href=index.php?action=monMur&id=".$line['id'].">".$line['login']."</a>
                                <form action='index.php?action=annuler' method='post'>
                                    <input type='hidden' name='id' value=".$line['id'].">
                                    <input type='submit' class='buttonAnnul' value='Annuler'>
                                </form>
                            </div>";
                    }
                ?>
            </div>
        </div>

</div>
</body>
</html>