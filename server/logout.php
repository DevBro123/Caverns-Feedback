<?php
session_start();
session_destroy();

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

redirect("/");

?>