<?php
/**
 * Contrôleur public
 */

// chargement des modèles
require_once "m/categModel.php";
require_once "m/newsModel.php";

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

}else { // sinon

    /*
     *  on est sur l'accueil
     */

// chargement des articles pour l'accueil
    $articles = listNews($mysqli);
// chargement de la vue
    require_once "v/accueil.html.php";

}