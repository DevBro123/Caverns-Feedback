<?php
// Deps
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . "/../internal/api/auth/login.php";
require __DIR__ . '/../internal/templates/root.php';

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

$databaseDirectory = __DIR__ . "/../db";
$userStore = new \SleekDB\Store("users", $databaseDirectory, ["timeout" => false]);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $new_user = [
        "username" => $_POST["username"],
        "password" => $_POST["password"]
    ];
    $userStore->insert($new_user);
    \api\auth\login($new_user["username"], $new_user["password"]);
    redirect("/");
    die();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <?php \root\Head(); ?>
    </head>
    <body>
        <main>
            <form action="" method="POST" class="border-4 rounded border-sky-400 ml-auto mr-auto mt-auto mb-auto max-w-3xl p-3">
                <fieldset class="mt-5 mb-5 grid grid-rows-2 gap-5">
                    <div class="grid grid-rows-2 gap-1">
                        <label>Username</label>
                        <input type="text" placeholder="username" name="username" required class="border-2 rounded border-sky-300 outline-sky-400 p-2"/>
                    </div>
                    <div class="grid grid-rows-2 gap-1">
                        <label>Password</label>
                        <input type="text" placeholder="password" name="password" required class="border-2 rounded border-sky-300 outline-sky-400 p-2"/>
                    </div>
                </fieldset>
                <input type="submit" value="Login" class="bg-sky-300 rounded p-2 border-4 border-sky-500 hover:bg-sky-400"/>
            </form>
        </main>
    </body>
</html>