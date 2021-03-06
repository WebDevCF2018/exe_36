<?php
/**
 * fonctions liées à la table news
 */

// affiche le détail d'une news
function viewNews($db,$id,$visible=true){
    $id = (int) $id;
    // création d'une variable pour la requête basée sur $visible
    $visibleSql = ($visible)?"n.visible=1 AND ":"";
    $sql="SELECT n.idnews, n.title, n.content, n.publication,
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
          WHERE $visibleSql n.idnews=$id
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

// affiche les news écrites par l'auteur sur leur profil ($desc et $visible par défaut) et sur l'accueil de leur administration ($desc = true et $visible = false)
function listNewsUser($db,$id,$desc=false,$visible=true){
    $iduser = (int) $id;
    // si la desc est nécessaire
    if($desc){
        // on prend +- 300 caractères
        $descSql = "SUBSTRING(n.content,1,300) AS content, ";

    }else{
        // on ne fait rien
        $descSql ="";
    }
    // si on veut afficher toutes les news, même non validées (visible=false)
    if(!$visible){
        $visibleSql="";
        $recupVisible="n.visible, ";
    }else{
        $visibleSql="n.visible=1 AND ";
        $recupVisible="";
    }
    $sql="SELECT n.idnews, n.title, $descSql $recupVisible n.publication,
  GROUP_CONCAT(c.idcateg) AS idcateg, 
  GROUP_CONCAT(c.name SEPARATOR '_€.€_') AS categname
	      FROM news n
		    LEFT JOIN news_has_categ h
			  ON h.news_idnews = n.idnews
		    LEFT JOIN categ c
			  ON h.categ_idcateg = c.idcateg
			INNER JOIN user u 
				ON n.user_iduser= u.iduser
          WHERE $visibleSql u.iduser=$iduser
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

/*
 * Mise à jour d'une news
 * @arg => $db => obj(connexion mysqli)
 * @arg => $idnews => int
 * @arg => $tabPost => array[$_POST]
 * @return => boolean
 */
function updateNews($db,$idnews,$tabPost){
    $idnews=(int)$idnews;
    $title = htmlspecialchars(strip_tags(trim($tabPost['thetitle'])), ENT_QUOTES);
    $texte = htmlspecialchars(strip_tags($tabPost['thecontent']), ENT_QUOTES);
    // si un des champs est vide après vérification
    if(empty($title)||empty($texte)) return false;
    // mise à jour de la news
    $sql = "UPDATE news SET title='$title', content='$texte' WHERE idnews = $idnews";
    $req = mysqli_query($db,$sql) or die(mysqli_error($db));

        // on va supprimer les entrées de la table news_has_categ liées à cet article
        $sql = "DELETE FROM news_has_categ WHERE news_idnews = $idnews";
        mysqli_query($db,$sql) or die(mysqli_error($db));
        // si on a coché une ou des sections
        if(isset($tabPost['catid'])){
            // on pérpare une requête pour insérer les liens avec les section
            $sql = "INSERT INTO news_has_categ (news_idnews,categ_idcateg) VALUES ";
            foreach($tabPost['catid'] as $idcateg){
                $idcateg = (int) $idcateg;
                $sql .="($idnews,$idcateg),";
            }
            mysqli_query($db,substr($sql,0,-1)) or die(mysqli_error($db));

        return true;
    }else {
        return true;
    }
}