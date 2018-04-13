<?php
/**
 * Contrôleur frontal
 */

// lancement de session
session_start();

// récupération du fichier de configuration
require_once "config.php";

// connexion à la db dans $mysqli
require_once "m/ConnectDBModel.php";


// si nous sommes connectés ET que la session est valide
if(isset($_SESSION['myKey'])&&$_SESSION['myKey']==session_id()){
    require_once "c/AdminController.php";

// sinon on appel le contrôleur public
}else{
    require_once "c/PublicController.php";

}