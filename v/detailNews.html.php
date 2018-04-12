<?php

include_once "header.html.php";

// pas d'article
if(!$articleDetail){
    // modification du titre pour afficher l'erreur à sa place
    $titre = "Erreur 404";
}else{
    $titre=$articleDetail['title'];
}

?>

<title>Notre site - <?=$titre?></title>

</head>
<body>

<?php include "menu.html.php"?>

<main role="main">
    <div class="jumbotron">
        <div class="container">
<h1>Notre site - <?=$titre?></h1>
        </div>
    </div>
    <div class="container">
        <?php
    // si pas d'articles (false)
    if(!$articleDetail){
        ?>
    <h3 class="text-muted">Lien vers l'article brisé ou article  inexistant</h3>
        <?php
    }else{
        ?>
        <h3><?=$articleDetail['title']?></h3>
            <h5><?php
            $idcateg = explode(",",$articleDetail['idcateg']);
            $name = explode("_€.€_",$articleDetail['categname']);
            foreach ($idcateg as $key => $id){
                ?>
            <a href="?categ=<?=$id?>"><?=$name[$key]?></a>
                <?php
            }
            ?></h5>

        <p>Par <a href="?author=<?=$articleDetail['iduser']?>"><?=$articleDetail['username']?></a> |
            <span class="text-success"><?=$articleDetail['publication']?></span></p>
        <p><?php
            echo nl2br($articleDetail['content']);
            ?></p>
        <hr>
        <?php
    }
    ?>
    </div>
</main>

</body>
</html>
