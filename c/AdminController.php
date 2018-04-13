<?php
/**
 * Contrôleur de l'admin
 */
// chargement des modèles
require_once "m/categModel.php";
require_once "m/newsModel.php";
require_once "m/userModel.php";

if(isset($_GET['logout'])){
    // appel du modèle de déconnexion
    require_once "m/deconnectModel.php";
}else {
    require_once "v/adminAccueil.html.php";
}