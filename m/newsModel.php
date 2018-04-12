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
    GROUP BY n.idnews;";
    $recup = mysqli_query($db,$sql);
    if(mysqli_num_rows($recup)){
        return mysqli_fetch_all($recup,MYSQLI_ASSOC);
    }else{
        return false;
    }
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
    GROUP BY n.idnews;";
    $recup = mysqli_query($db,$sql);
    if(mysqli_num_rows($recup)){
        return mysqli_fetch_all($recup,MYSQLI_ASSOC);
    }else{
        return false;
    }
}

