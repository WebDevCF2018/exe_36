<?php include_once "header.html.php"?>

<title>Notre site - Se connecter</title>

</head>
<body>

<?php include "menu.html.php"?>

<main role="main">
    <div class="jumbotron">
        <div class="container">
<h1>Notre site - Se connecter</h1>
        </div>
    </div>
    <div class="container">
        <h2>Connexion</h2>
        <form name="fff" method="post" action="">
            <div class="form-group">
                <label for="exampleInputEmail1">Login</label>
                <input name="theLogin" type="text" id="exampleInputEmail1" class="form-control" placeholder="Votre login" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Mot de passe</label>
                <input name="thePass" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
            </div>
            <?php
            if(isset($erreur_login)) {
                ?>
<div class="alert-danger"><?=$erreur_login?></div><br>

                <?php
            }
            ?>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

</body>
</html>
