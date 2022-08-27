<?php
namespace api\auth\admin;
// Deps
require __DIR__ . '/../../../vendor/autoload.php';

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

function isAnAdmin() {
    return isset($_SESSION) && isset($_SESSION["user"]) && isset($_SESSION["user"]["admin"]) && $_SESSION["user"]["admin"];
}

function enforceAdmin() {
    if (!isset($_SESSION["user"])) {
        redirect("/login.php?returnUrl=" . $_SERVER["REQUEST_URI"] . "&fromError=401");
        die();
    }
    if (!isset($_SESSION["user"]["admin"]) || !$_SESSION["user"]["admin"]) {
        redirect("/index.php?fromError=403");
        die();
    }
}
?>