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
    redirect("/login.php?returnUrl=/feedback.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["complete"])) {
        redirect("/");
        die();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["title"]) || !isset($_POST["category"]) || !isset($_POST["content"])) {
        echo '{"error": true, "message": "Missing field/s"}';
    }
    $databaseDirectory = __DIR__ . "/../db";
    $store = new \SleekDB\Store("feedback", $databaseDirectory, [
        "timeout" => false
    ]);
    $feedback = [
        "user" => $_SESSION["user"]["_id"],
        "category" => $_POST["category"],
        "title" => $_POST["title"],
        "content" => $_POST["content"]
    ];
    if ($_POST["category"] == "Bug") {
        $feedback["bug-severity"] = $_POST["bug-severity"];
    }
    $store->insert($feedback);
    redirect("/feedback.php?complete");
    die();
}
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Give Feedback - The Caverns</title>
        <?php \root\Head() ?>
    </head>
    <body>
        <?php \root\Nav() ?>
        <header class="text-center bg-zinc-300 min-h-full">
            <h1 class="text-5xl pt-10 pb-10">Feedback</h1>
        </header>
        <main class="text-left">
            <form class="rounded-lg border-4 border-sky-300 ml-auto mr-auto mb-20 mt-20 container p-5 w-1/4" id="form" method="POST" action="">
                <?php
                    echo '<input type="text" value="' . session_encode() . '" hidden/>';
                ?>
                <fieldset class="grid grid-cols-4 p-2">
                    <p class="text-2xl">Subject</p>
                    <input type="text" class="w-full border-2 rounded-lg border-sky-300 col-span-3 outline-sky-300 h-10 text-center" required id="title" name="title"/>
                </fieldset>
                <fieldset class="text-center grid grid-cols-2 p-2">
                    <p class="text-xl text-left">Category</p>
                    <select id="category-picker" name="category" class="text-center">
                        <option>Pick One</option>
                        <option>Bug</option>
                    </select>
                </fieldset>
                <div id="feedback-main"></div>
                <div class="w-full mt-5 mb-5">
                    <input type="submit" value="Submit" class="disabled:bg-zinc-300 disabled:cursor-not-allowed enabled:bg-sky-300 rounded-lg p-2 disabled:border-zinc-500 enabled:border-sky-500 enabled:hover:bg-sky-400 w-2/12 ml-auto mr-auto disabled block" disabled id="feedback-submit-btn"/>
                </div>
            </form>
        </main>
        <script src="feedback.js"></script>
    </body>
</html>