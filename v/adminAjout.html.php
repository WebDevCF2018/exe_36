<?php include_once "header.html.php"?>

<title>Administration - Ajouter une news</title>

</head>
<body>

<?php include "adminMenu.html.php"?>

<main role="main">
    <div class="jumbotron">
        <div class="container">
<h1>Administration - Ajouter une news</h1>
            <h3><?=$_SESSION["username"]?>, vous êtes connecté en tant que <?=$_SESSION["permissionname"]?></h3>
        </div>
    </div>
    <div class="container">
        <h2>Créez votre news</h2>
        <form name="fff" method="post" action="">

            <input type="hidden" name="idutil" value="<?=$_SESSION['iduser']?>">

            <div class="form-group">
                <label for="exampleInputEmail1">Titre</label>
                <input name="thetitle" type="text" id="exampleInputEmail1" class="form-control" placeholder="Votre titre" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Votre article</label>
                <textarea name="thecontent" class="form-control" id="exampleInputPassword1" placeholder="Votre article" required></textarea>
            </div>
            <?php
            foreach ($categ AS $item) {
            ?>
            <div class="form-check form-check-inline">
                <input name="catid[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="<?=$item['idcateg']?>">
                <label class="form-check-label" for="inlineCheckbox1"><?=$item['name']?> </label>
            </div>
                <?php
            }
                ?>
<br>

            <?php
            if(isset($erreur_login)) {
                ?>
<div class="alert-danger"><?=$erreur_login?></div><br>

                <?php
            }
            var_dump($_POST);
            ?>
            <br><button type="submit" class="btn btn-primary">Envoyer</button>
        </form></div>
    </div>
</main>

</body>
</html>
