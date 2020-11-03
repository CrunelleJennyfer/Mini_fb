<?php

function gras($v) {
    return "<b>$v</b>";

}

function options($attributes) {
    $o = "";
    foreach ($attributes as $attr => $v) {
        $o = $o . "$attr='$v'";
    }
    return $o;
}

function lien($link, $texte, $attributes = array()) {
    $o = "";
    foreach ($attributes as $attr => $v) {
        $o = $o . "$attr='$v'";
    }
    return "<a href='$link' $o>$texte</a>";
}

function item($contenu, $attributes = array()) {
    $o = options($attributes);
    return "<li $o>$contenu</li>";
}

function table($table2Dim) {
    $tmp = "";
    foreach ($table2Dim as $table1Dim) {  // Je parcours ma table à 2 Dim, chaque entréee est
        // une table à 1 dim
        $tmp = $tmp . "<tr>"; // J'ai donc une nouvelle ligne
        foreach ($table1Dim as $cellule) { // Chaque entrée de la table à 1 dim est une donnée
            $tmp = $tmp . "<td>$cellule</td>"; // Je la met entre td!
        }

        $tmp = $tmp . "</tr>"; // Je dois fermer la ligne

    }

    return $tmp;
}

function message($msg) {
    $_SESSION['info'] = $msg;
}



?>












