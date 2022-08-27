<?php
// Deps
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . "/../../internal/api/auth/admin.php";
require __DIR__ . '/../../internal/templates/root.php';

if (!isset($_SESSION)) {
    session_start();
}

\api\auth\admin\enforceAdmin();

$userText = '';

$databaseDirectory = __DIR__ . "/../../db";
$userStore = new \SleekDB\Store("users", $databaseDirectory, [
    "timeout" => false
]);

$users = $userStore->findAll();

for ($i = 0; $i < count($users); $i++) {
    $userText .= '
<div class="border-2 border-sky-300 rounded w-9/12 ml-auto mr-auto block p-2">
    <p>Name: ' . $users[$i]["username"] . '
    <p>Id: ' . $users[$i]["_id"] . '
</div>
';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Users - The Caverns</title>
        <?php \root\Head() ?>
    </head>
    <body>
        <?php \root\Nav() ?>
        <header class="text-center bg-zinc-300 min-h-full">
            <h1 class="text-7xl pt-10 pb-10">Users</h1>
            <div class="pt-32"></div>
        </header>
        <main class="container grid grid-cols-3 gap-4 ml-auto mr-auto pt-10">
            <?php echo $userText ?>
        </main>
    </body>
</html>