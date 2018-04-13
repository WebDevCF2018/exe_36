<?php
include_once "header.html.php";

// condition ternaire
$titre = (!$recupUser)?"Profil non existant":$recupUser["username"];

?>

<title>Notre site - <?=$titre?></title>

</head>
<body>

<?php include "menu.html.php"?>

<main role="main">
    <div class="jumbotron">
        <div class="container">
<h1>Notre site - <?=$titre?></h1>
            <?php
            if($recupUser){
            ?>
<h2>Login : <?=$recupUser['login']?> | Niveau : <?=$recupUser['permname']?> </h2>
            <?php
            }
            ?>
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
            <h3><a href="?news=<?=$item['idnews']?>"><?=$item['title']?></a> </h3>
            <p><span class="text-success">Le <?=$item['publication']?></span> dans
<?php
            $idcateg = explode(",",$item['idcateg']);
            $name = explode("_€.€_",$item['categname']);
            foreach ($idcateg as $key => $id){
                ?>
            <a href="?categ=<?=$id?>"><?=$name[$key]?></a>
                <?php
            }
            ?></p>


        <hr>
        <?php
        }
    }
    ?>
    </div>
</main>

</body>
</html>