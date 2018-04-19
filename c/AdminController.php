<?php
/**
 * Contrôleur de l'admin
 */
// chargement des modèles
require_once "m/categModel.php";
require_once "m/newsModel.php";
require_once "m/userModel.php";

// appel du modèle de déconnexion
if(isset($_GET['logout'])){
    require_once "m/deconnectModel.php";

// on veut insérer une news
}elseif(isset($_GET['ajout'])){
    // formulaire non envoyé
    if(empty($_POST)) {
        // récupération des catégories
        $categ = listCateg($mysqli);
        // appel de la vue
        require_once "v/adminAjout.html.php";
    }else{ // formulaire envoyé
        if(isset($_POST['thetitle'],$_POST['thecontent'])){
            // si on a coché des catégories
            if(isset($_POST['catid'])){
                $recup = createNews($mysqli, $_SESSION['iduser'], $_POST['thetitle'], $_POST['thecontent'],$_POST['catid']);
            }else { // pas de catégories
                $recup = createNews($mysqli, $_SESSION['iduser'], $_POST['thetitle'], $_POST['thecontent']);
            }
        }
    }
}else {
    require_once "v/adminAccueil.html.php";
}