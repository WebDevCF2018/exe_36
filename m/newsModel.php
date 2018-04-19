<?php
/**
 * fonctions liées à la table news
 */

// affiche le détail d'une news
function viewNews($db,$id){
    $id = (int) $id;
    $sql="SELECT n.title, n.content, n.publication,
  GROUP_CONCAT(c.idcateg) AS idcateg, 
  GROUP_CONCAT(c.name SEPARATOR '_€.€_') AS categname,
  u.name as username, u.iduser
	      FROM news n
		    LEFT JOIN news_has_categ h
			  ON h.news_idnews = n.idnews
		    LEFT JOIN categ c
			  ON h.categ_idcateg = c.idcateg
			INNER JOIN user u 
				ON n.user_iduser= u.iduser
          WHERE n.visible=1 AND n.idnews=$id
            GROUP BY n.idnews;";
    $recupNews = mysqli_query($db,$sql) or die(mysqli_error($db));
    // si on récupère une news
    if(mysqli_num_rows($recupNews)){
        // on envoie un tableau associatif avec les champs venant de notre requête pour 1 news
        return mysqli_fetch_assoc($recupNews);
    }else{
        return false;
    }
}

// affiche toutes les news présentes dans UNE catégorie
function listNewsCateg($db,$id){
    $idCateg= (int) $id;
    $sql="SELECT n.idnews, n.title, SUBSTR(n.content, 1, 220) AS content, n.publication
	FROM news n
		INNER JOIN news_has_categ h
			ON h.news_idnews = n.idnews
		INNER JOIN categ c
			ON h.categ_idcateg = c.idcateg
    WHERE n.visible=1 AND c.idcateg=$idCateg
    GROUP BY n.idnews
    ORDER BY n.publication DESC;";
    $recup = mysqli_query($db,$sql);
    if(mysqli_num_rows($recup)){
        return mysqli_fetch_all($recup,MYSQLI_ASSOC);
    }else{
        return false;
    }
}

// affiche les news écrites par l'auteur
function listNewsUser($db,$id){
    $iduser = (int) $id;
    $sql="SELECT n.idnews, n.title,  n.publication,
  GROUP_CONCAT(c.idcateg) AS idcateg, 
  GROUP_CONCAT(c.name SEPARATOR '_€.€_') AS categname
	      FROM news n
		    LEFT JOIN news_has_categ h
			  ON h.news_idnews = n.idnews
		    LEFT JOIN categ c
			  ON h.categ_idcateg = c.idcateg
			INNER JOIN user u 
				ON n.user_iduser= u.iduser
          WHERE n.visible=1 AND u.iduser=$iduser
            GROUP BY n.idnews
            ORDER BY n.publication DESC;";
    $recupNews = mysqli_query($db,$sql) or die(mysqli_error($db));

    return (mysqli_num_rows($recupNews))? mysqli_fetch_all($recupNews,MYSQLI_ASSOC): false;
}

// affiche toutes les news sur l'accueil
function listNews($db){
    $sql="SELECT n.idnews, n.title, SUBSTR(n.content, 1, 220) AS content, n.publication, GROUP_CONCAT(c.idcateg) AS idcateg, GROUP_CONCAT(c.name SEPARATOR '_€.€_') AS name 
	FROM news n
		LEFT JOIN news_has_categ h
			ON h.news_idnews = n.idnews
		LEFT JOIN categ c
			ON h.categ_idcateg = c.idcateg
    WHERE n.visible=1
    GROUP BY n.idnews
    ORDER BY n.publication DESC;";
    $recup = mysqli_query($db,$sql);
    if(mysqli_num_rows($recup)){
        return mysqli_fetch_all($recup,MYSQLI_ASSOC);
    }else{
        return false;
    }
}

// création d'une news

function createNews($db,$idutil,$titre,$texte,$categ=array()){

    $titre = htmlspecialchars(strip_tags(trim($titre)),ENT_QUOTES);
    $texte = htmlspecialchars(strip_tags($texte),ENT_QUOTES);
    $idutil = (int) $idutil;

    // si après traitement une des variables est vide ou l'id vaut 0
    if(empty($titre)||empty($texte)||$idutil==0) return false;

    $sql = "INSERT INTO news (title,content,user_iduser) VALUES ('$titre','$texte',$idutil);";

    $req = mysqli_query($db,$sql) or die(mysqli_error($db));

    // si on a sélectionné des catégories
    if(!empty($categ)){
        // on récupère l'id de la news insérée
        $idnews = mysqli_insert_id($db);
        // préparation de la requête avant concaténation
        $sql = "INSERT INTO news_has_categ (news_idnews,categ_idcateg) VALUES ";
        // tant qu'on a des id's de categ
        foreach($categ as $item){
            $item = (int) $item;
            // on concatène les id nécessaires à notre requête
            $sql .= "($idnews,$item),";
        }
        // requête effectuée en retirant la dernière virgule pour éviter la faute sql
        mysqli_query($db,substr($sql,0,-1));
    }
    // réponse de la fonction: return(si on a ajouté au moins une ligne)?(true) : (false)
    return (mysqli_affected_rows($db))?true:false;
}
