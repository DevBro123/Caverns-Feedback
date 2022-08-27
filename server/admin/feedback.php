<?php
// Deps
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . "/../../internal/api/auth/admin.php";
require __DIR__ . '/../../internal/templates/root.php';

if (!isset($_SESSION)) {
    session_start();
}

\api\auth\admin\enforceAdmin();

$feedbackText = '';

$databaseDirectory = __DIR__ . "/../../db";
$feedbackStore = new \SleekDB\Store("feedback", $databaseDirectory, [
    "timeout" => false
]);
$usersStore = new \SleekDB\Store("users", $databaseDirectory, [
    "timeout" => false
]);

$feedback = $feedbackStore->findAll();

$title = 'Feedback';

if (!isset($_GET["fedid"])) {
    for ($i = 0; $i < count($feedback); $i++) {
        $feedbackText .= '
<div class="w-9/12 ml-auto mr-auto rounded">
    <a href="/admin/feedback.php?fedid=' . $feedback[$i]["_id"] . '" class="transition ease-in-out text-center text-2xl hover:text-blue-500">' . $feedback[$i]["title"] . ' - ' . $usersStore->findById($feedback[$i]["user"])["username"] . '</a>
</div>
    ';
    }
} else {
    $feedback = $feedbackStore->findById($_GET["fedid"]);
    $title = $feedback["title"];
    $feedbackText = '
<p class="text-center col-span-3 text-2xl">' . $feedback["title"] . ' - ' . $usersStore->findById($feedback["user"])["username"] . '</p>
<p class="text-center col-span-3 text-xl">Category: ' . $feedback["category"] . '</p>
';
    if ($feedback["category"] == "Bug") {
        $feedbackText .= '<input type="range" min="1" max="10" value="' . $feedback["bug-severity"] . '" name="bug-severity" class="slider col-span-3" id="bug-severity-slider" disabled/>';
    }
    if (isset($feedback["content"])) {
        $feedbackText .= '<p class="col-span-3">' . $feedback["content"] . '</p>';
    } else {
        $feedbackText .= '<p class="col-span-3">No Content</p>';
    }
    $feedbackText .= '<a href="/admin/stores/feedback/delete.php?id=' . $feedback["_id"] . '" class="mt-20 border-2 border-red-400 bg-red-300 test-center">Delete</a>';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?> - The Caverns</title>
        <?php \root\Head() ?>
    </head>
    <body>
        <?php \root\Nav() ?>
        <header class="text-center bg-zinc-300 min-h-full">
            <h1 class="text-7xl pt-10 pb-10">Feedback</h1>
            <div class="pt-32"></div>
        </header>
        <main class="">
            <div class="container grid grid-cols-3 gap-4 ml-auto mr-auto pt-10">
                <?php echo $feedbackText ?>
            </div>
        </main>
    </body>
</html>