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
}elseif(isset($_GET['ajout'])) {
    // formulaire non envoyé
    if (empty($_POST)) {
        // récupération des catégories
        $categ = listCateg($mysqli);
        // appel de la vue
        require_once "v/adminAjout.html.php";
    } else { // formulaire envoyé
        if (isset($_POST['thetitle'], $_POST['thecontent'])) {
            // si on a coché des catégories
            if (isset($_POST['catid'])) {
                $recup = createNews($mysqli, $_SESSION['iduser'], $_POST['thetitle'], $_POST['thecontent'], $_POST['catid']);
            } else { // pas de catégories
                $recup = createNews($mysqli, $_SESSION['iduser'], $_POST['thetitle'], $_POST['thecontent']);
            }
            // si récup vaut vrai (==true)
            if ($recup) {
                // redirection sur l'accueil
                header("Location: ./");
            } else { // false
                // création de la faute
                $erreur = "Erreur lors de l'insertion de votre article";
                // récupération des catégories
                $categ = listCateg($mysqli);
                // appel de la vue
                require_once "v/adminAjout.html.php";
            }
        }
    }
}elseif (isset($_GET['update'])){
    $update = (int) $_GET['update'];
    // formulaire non envoyé
    if(empty($_POST)){
        // on récupère toutes les catégories
        $categ = listCateg($mysqli);
        // on récupère l'article
        $recup = viewNews($mysqli,$update,false);
        // on prend l'iduser du user dans la db et on le compare avec l'iduser de session, et si ils sont différents, on déconnecte l'utilisateur
        if($recup['iduser']!=$_SESSION['iduser']) header("Location: ?logout");
        // appel de la vue
        require_once "v/adminUpdate.html.php";
    }else{
        // traitement de l'envoi
        echo updateNews($mysqli,$update,$_POST);
    }
}else {
    // on récupère toutes les news de l'utilisateur connecté, avec la description (true), et même les news non validées (news.visible=0) en plus des valides
    $recup = listNewsUser($mysqli,$_SESSION['iduser'],true,false);
    require_once "v/adminAccueil.html.php";
}