<?php
// Deps
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . "/../internal/api/auth/login.php";
require __DIR__ . '/../internal/templates/root.php';

if (!isset($_SESSION)) {
    session_start();
}

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

$databaseDirectory = __DIR__ . "/../db";
$userStore = new \SleekDB\Store("users", $databaseDirectory, [
    "timeout" => false
]);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $login = \api\auth\login($_POST["username"], $_POST["password"]);
    if ($login) {
        if (isset($_GET["returnUrl"])) {
            redirect($_GET["returnUrl"]);
        } else {
            redirect("/");
        }
        die();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <?php \root\Head(); ?>
    </head>
    <body>
        <main class="">
            <form action="" method="POST" class="border-4 rounded-lg border-sky-400 w-1/3 ml-auto mr-auto mt-16 mb-20 max-w-3xl px-6">
                <fieldset class="grid grid-rows-2">
                    <div class="flex flex-col">
                        <label class="pt-5 pb-2">Username</label>
                        <input type="text" placeholder="Username" name="username" required class="border-2 w-7/12 rounded-lg border-sky-300 outline-sky-400 p-2"/>
                    </div>
                    <div class="flex flex-col">
                        <label class="pt-5 pb-2">Password</label>
                        <input type="password" placeholder="Password" name="password" id="passwordBox" required class="border-2 w-7/12 appearance-none rounded-lg border-sky-300 outline-sky-400 p-2" autocomplete="off"/>
                    </div>
                  <div class="flex flex-row gap-2 px-1 pt-4">
                    <input type="checkbox" onclick="showPassword()">
                    <p>Show Password</p>
                  </div>

<script>
function showPassword() {
  var x = document.getElementById("passwordBox");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
                </fieldset>
                <input type="submit" value="Login" class="bg-sky-300 rounded-lg px-4 py-2 border-sky-500 my-6 hover:bg-sky-400"/>
            </form>
        </main>
    </body>
</html>