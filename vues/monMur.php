Ceci sera la page de ton profil plus tard, donc attend c'est en cour
<?php
//si pas co, return acceuil
if(!isset($_SESSION["id"])){
    header("Location:index.php?action=login");
}

//afficher notre ur ou celui ami
$ok = false;

if(!isset($_GET["id"]) || $_GET["id"]==$_SESSION["id"]){
    $id = $_SESSION["id"];
    $ok = true;
} else{
    $id = $_GET["id"];
    //verif si ami
    $sql = "SELECT * FROM lien WHERE etat='ami' AND (idUtilisateur1=? AND idUtilisateur2=?)"; //manque peut etre un truc
    $query = $pdo->prepare($sql);
    $quey->execute(array($_GET["id"],$_SESSION["id"], $_SESSION["id"], $_GET['id']));
		$line=$query->fetch();
		if($line != false){
            $ok = true;
        }
        // les deux ids à tester sont : $_GET["id"] et $_SESSION["id"]
        // A completer. 
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
            echo"<p>Tu l'a déjà demande en ami, arrête de spam...</p></br>";
        }
    }

    if($attente == false){
        //pour demander ami
        echo"</br><p>T'es sur tu cette personne en ami ?</p>
        <div><form action = 'index.php?action=demandeAmi' method='POST'>
            <input type='hidden' name='id' value".$id.">
            <input type='submit' class='buttonAmi' value='Sur ?'>
        </form>";

    }

    //manque affichage mur select * from ecrit where idami=? oder by dateEcrit


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
<div>
    <div class="mur">
        <?php
            $sql = "SELECT * FROM user order by user.login ASC";
            $query = $pdo->prepare($sql);
            $query->execute(array($_SESSION['id']));//manque peut etre un truc
            while($line = $query->fetch()){
                if($line['id'] == $id){
                    echo "Mur de <b>".$line['login']."</b>, le meilleure des Kiwis";
                }
            }
        ?>
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
                        </form>";
                }
                echo "</div></br>";
            }
            ?>
    </div>
    
    <form class="submit" action="index.php?action=nouvPost" method="POST">
        <input type="hidden" name="ami" value='<?php echo $id; ?>'>
        <input type="hidden" name="titre">
        <input type="text" name="message" class="msg" placeholder="Ecrivez ici...">
        <input type="submit" name="poster" class="sub" value=">">
    </form>
</div>