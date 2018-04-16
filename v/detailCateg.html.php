<?php include_once "header.html.php"?>

<title>Notre site - <?=$headCateg['name']?></title>

</head>
<body>

<?php include "menu.html.php"?>

<main role="main">
    <div class="jumbotron">
        <div class="container">
<h1>Notre site - <?=$headCateg['name']?></h1>
        <div class="lead text-secondary font-weight-bold">
            <?=nl2br($headCateg['desc'])?>
        </div>
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
