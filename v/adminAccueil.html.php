<?php
include_once "header.html.php";
?>

<title>Administration - Bienvenue <?=$_SESSION["username"]?></title>

</head>
<body>

<?php include "adminMenu.html.php"?>

<main role="main">
    <div class="jumbotron">
        <div class="container">
            <h1>Administration - Bienvenue <?=$_SESSION["username"]?></h1>
            <h2>Vous êtes connecté en tant que <?=$_SESSION["permissionname"]?></h2>

        </div>
    </div>
    <div class="container">
        <h3>Vos articles</h3>
        <div class="container">
            <?php
            // si pas d'articles (false)
            if(!$recup){
                ?>
                <h3 class="text-muted">Pas encore d'articles</h3>
                <?php
            }else{
                foreach($recup as $item) {
                    // si visible
                    if($item['visible']){
                        $h3 = "alert alert-success";
                        $infoVisible="[Published] ";
                    }else{
                        $h3 = "alert alert-warning";
                        $infoVisible="[Not validate] ";
                    }
                    ?>
                    <h3 class="<?=$h3?>"><?=$item['title']?> <small><?=$infoVisible?></small> <a href="?update=<?=$item['idnews']?>" ><img src="public/img/update.png" alt="update" title="update"></a> </h3>
                    <h5><?php
                        $idcateg = explode(",",$item['idcateg']);
                        $name = explode("_€.€_",$item['categname']);
                        foreach ($idcateg as $key => $id){
                            ?>
                            <?=$name[$key]?>
                            <?php
                        }
                        ?></h5>
                    <p class="text-success"><?=$item['publication']?></p>
                    <p><?php
                        // on affiche les 300 derniers caractères venant de la requête, on veut éviter de couper un mot, on cherche la dernière position de l'espace strrpos($item['content']," "), et on coupe la chaîne avec substr($chaine, 0, position dernier espace)
                        echo substr($item['content'],0,strrpos($item['content']," "));
                        ?> ... </p>
                    <hr>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</main>

</body>
</html>