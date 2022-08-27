<?php
// Deps
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . "/../../internal/api/auth/admin.php";
require __DIR__ . '/../../internal/templates/root.php';

if (!isset($_SESSION)) {
    session_start();
}

\api\auth\admin\enforceAdmin();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>The Caverns</title>
        <?php \root\Head() ?>
    </head>
    <body>
        <?php \root\Nav() ?>
        <header class="text-center bg-zinc-300 min-h-full">
            <h1 class="text-7xl pt-10 pb-10">Admin Portal</h1>
            <div class="pt-32"></div>
        </header>
        <main class="container grid">
            <a href="/admin/users.php">Users</a>
            <a href="/admin/feedback.php">Feedback</a>
        </main>
    </body>
</html>