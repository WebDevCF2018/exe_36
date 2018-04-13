<?php
/**
 * Contrôleur public
 */

// chargement des modèles
require_once "m/categModel.php";
require_once "m/newsModel.php";
require_once "m/userModel.php";

// on charge les données du menu du head
$menu = listCateg($mysqli);

/*
 * si on est sur le détail d'une news
 */
if(isset($_GET['news'])) {
    $idNews = (int)$_GET['news'];
    $articleDetail = viewNews($mysqli, $idNews);
    //var_dump($articleDetail);
// chargement de la vue
    require_once "v/detailNews.html.php";

/*
 *  si on est sur une section
 */
}elseif (isset($_GET['categ'])){
    $idCateg = (int) $_GET['categ'];
    // titre et description de la categ
    $headCateg = viewCateg($mysqli,$idCateg);
    //var_dump($headCateg);

    // on récupère les articles qui sont dans la catégorie
    $articles = listNewsCateg($mysqli,$idCateg);

    // la catégorie n'existe pas
    if(!$headCateg) header("Location: ./");// redirection accueil

    require_once "v/detailCateg.html.php";

/*
 *  si on est sur le profil d'un auteur
 */
}elseif (isset($_GET['author'])){
    // autre manière de changer le type (int), renvoie false en cas d'échec ( 0 avec (int) )
    $iduser = $_GET['author'];
    settype($iduser,"integer");

    $recupUser = userById($mysqli,$iduser);

    // on récupère les articles qui appartiennent à l'auteur
    $articles = listNewsUser($mysqli,$iduser);

    require_once "v/user.html.php";

/*
 *  si on est sur on veut se connecter
 */
}elseif (isset($_GET['login'])){

    // formulaire non envoyé, affichage de celui-ci
    if(empty($_POST)){
        require_once "v/login.html.php";
    }else{
        $connect = loginUser($mysqli,$_POST['theLogin'],$_POST['thePass']);
        if($connect){
            // création de la session
            $_SESSION['myKey'] = session_id(); // id de session
            $_SESSION['idutil'] = $connect['iduser']; // iduser
            $_SESSION['login'] = $connect['login'];
            $_SESSION['name'] = $connect['username'];
            $_SESSION['permissionname'] = $connect['permissionname'];
        var_dump($_SESSION);

        }
    }

}else { // sinon

    /*
     *  on est sur l'accueil
     */

// chargement des articles pour l'accueil
    $articles = listNews($mysqli);
// chargement de la vue
    require_once "v/accueil.html.php";

}