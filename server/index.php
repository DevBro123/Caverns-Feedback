<?php
// Deps
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../internal/templates/root.php';
session_start();

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

if (!isset($_SESSION["user"])) {
    redirect("/login.php");
} else {
    redirect("/feedback.php");
}

?>

<?php
#<!DOCTYPE html>
#<html>
#    <head>
#        <title>The Caverns</title>
#        <php \root\Head() >
#    </head>
#    <body>
#        <php \root\Nav() >
#        <header class="text-center bg-zinc-300 min-h-full">
#            <h1 class="text-7xl pt-10 pb-10">The Caverns Project</h1>
#            <div class="pt-32"></div>
#        </header>
#        <main class="container">
#        </main>
#    </body>
#</html>
?>