<?php
/**
 * Gestion des catégories
 */

// titre et description d'UNE catégorie
function viewCateg($db,$id){
    $idcateg = (int) $id;
    $sql = "SELECT * FROM categ WHERE idcateg=$idcateg";
    $recup = mysqli_query($db,$sql) or die(mysqli_error($db));
    if(mysqli_num_rows($recup)){
        return mysqli_fetch_assoc($recup);
    }else{
        return false;
    }
}
// pour menu (public)
function listCateg($db){
    $sql = "SELECT idcateg, name FROM categ ORDER BY idcateg ASC;";
    $recup = mysqli_query($db,$sql);
    // si on a au moins une catégorie
    if(mysqli_num_rows($recup)){
        // on envoie le tableau indexé contenant tous les résultats au format tableau associatif (MYSQLI_ASSOC)
        return mysqli_fetch_all($recup,MYSQLI_ASSOC);
    }else{
        return false;
    }

}