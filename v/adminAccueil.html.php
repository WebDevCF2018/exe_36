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
        <pre><?php
        var_dump($_SESSION);
        ?></pre>
    </div>
</main>

</body>
</html>