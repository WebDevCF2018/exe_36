<?php
/**
 * Created by PhpStorm.
 * User: webform
 * Date: 23/03/2018
 * Time: 14:26
 */


// identification pour administration
function loginUser($db,$login,$pass){
    $login = htmlspecialchars(strip_tags(trim($login)),ENT_QUOTES);
    $pwd = htmlspecialchars(strip_tags(trim($pass)),ENT_QUOTES);
    if(empty($login)||empty($pwd)) return false;

    $sql = "SELECT u.iduser, u.login, u.name AS username, p.name AS       permissionname, p.level
	FROM user u 
	INNER JOIN permission p 
		ON u.permission_idpermission = p.idpermission
	WHERE u.login='$login' AND u.pwd='$pwd';";

    $recupLogin = mysqli_query($db,$sql) or die(mysqli_error($db));

    // condition ternaire envoyant (return) ( si true) {?} un tableau associatif, sinon {:} false... : false
    return (mysqli_num_rows($recupLogin))?mysqli_fetch_assoc($recupLogin):false;
}

// récupération d'un user par son id
function userById($db,$id){
    $id = (int) $id;
    $sql = "SELECT u.login, u.name AS username, p.name AS permname 
	        FROM user u 
		      INNER JOIN permission p 
		      ON u.permission_idpermission = p.idpermission
		    WHERE u.iduser=$id;";
    $request = mysqli_query($db,$sql);
    /* condition simple binaire (booléenne)
    if(mysqli_num_rows($request)){
        return mysqli_fetch_assoc($request);
    }else{
        return false;
    }
    */
    // identique en ternaire => $var =(condition)?true:false;
    return (mysqli_num_rows($request)) ? mysqli_fetch_assoc($request):false;
}