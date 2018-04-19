<?php include_once "header.html.php"?>

<title>Administration - Modifier la news</title>

</head>
<body>

<?php include "adminMenu.html.php"?>

<main role="main">
    <div class="jumbotron">
        <div class="container">
<h1>Administration - Modifier la news</h1>
            <h3><?=$_SESSION["username"]?>, vous êtes connecté en tant que <?=$_SESSION["permissionname"]?></h3>
        </div>
    </div>
    <div class="container">
        <h2>Modifier votre news</h2>
        <form name="fff" method="post" action="">

            <input type="hidden" name="idutil" value="<?=$_SESSION['iduser']?>">
            <input type="hidden" name="idnews" value="<?=$recup['idnews']?>">

            <div class="form-group">
                <label for="exampleInputEmail1">Titre</label>
                <input name="thetitle" type="text" id="exampleInputEmail1" class="form-control" placeholder="Votre titre" value="<?=$recup['title']?>"  required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Votre article</label>
                <textarea name="thecontent" class="form-control" id="exampleInputPassword1" placeholder="Votre article" required><?=$recup['content']?></textarea>
            </div>
            <?php
            // tableau contenant toutes les id des catégories dans lesquelles se trouve la news
            $categ_before_update = explode(",",$recup['idcateg']);
            // tant qu'on a des catégories (toutes!)
            foreach ($categ AS $item) {
                // si la catégorie listée est cochée pour la news
                if(in_array($item['idcateg'],$categ_before_update)){
                    // on coche la checkbox
                    $check = " checked ";
                }else{
                    // sinon on la coche pas
                    $check= "";
                }
            ?>
            <div class="form-check form-check-inline">
                <input name="catid[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" <?=$check?> value="<?=$item['idcateg']?>">
                <label class="form-check-label" for="inlineCheckbox1"><?=$item['name']?> </label>
            </div>
                <?php
            }
                ?>
<br>

            <?php
            if(isset($erreur)) {
                ?>
<br><div class="alert-danger"><?=$erreur?></div><br>

                <?php
            }
            //var_dump($_POST);
            ?>
            <br><button type="submit" class="btn btn-primary">Envoyer</button>
        </form></div>
    </div>
</main>

</body>
</html>
