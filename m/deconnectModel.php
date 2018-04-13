<?php

// Détruit toutes les variables de session
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Finalement, on détruit la session.
session_destroy();

// redirection vers l'accueil
header("Location: ./");