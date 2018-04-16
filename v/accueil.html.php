<?php include_once "header.html.php"?>

<title>Notre site - Accueil</title>

</head>
<body>

<?php include "menu.html.php"?>

<main role="main">
    <div class="jumbotron">
        <div class="container">
<h1>Notre site - Accueil</h1>
        </div>
    </div>
    <div class="container">
        <?php
    // si pas d'articles (false)
    if(!$articles){
        ?>
    <h3 class="text-muted">Pas encore d'articles</h3>
        <?php
    }else{
        foreach($articles as $item) {
        ?>
        <h3><?=$item['title']?></h3>
            <h5><?php
            $idcateg = explode(",",$item['idcateg']);
            $name = explode("_€.€_",$item['name']);
            foreach ($idcateg as $key => $id){
                ?>
            <a href="?categ=<?=$id?>"><?=$name[$key]?></a>
                <?php
            }
            ?></h5>
        <p class="text-success"><?=$item['publication']?></p>
        <p><?php
            // on affiche les 220 derniers caractères venant de la requête, on veut éviter de couper un mot, on cherche la dernière position de l'espace strrpos($item['content']," "), et on coupe la chaîne avec substr($chaine, 0, position dernier espace)
            echo substr($item['content'],0,strrpos($item['content']," "));
            ?> ... <a href="?news=<?=$item['idnews']?>">lire la suite</a></p>
        <hr>
        <?php
        }
    }
    ?>
    </div>
</main>

</body>
</html>
