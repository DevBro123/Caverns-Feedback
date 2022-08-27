<?php
// Deps
require __DIR__ . '/../../../../vendor/autoload.php';
require __DIR__ . "/../../../../internal/api/auth/admin.php";
require __DIR__ . '/../../../../internal/templates/root.php';

if (!isset($_SESSION)) {
    session_start();
}

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

\api\auth\admin\enforceAdmin();

$databaseDirectory = __DIR__ . "/../../../../db";
$feedbackStore = new \SleekDB\Store("feedback", $databaseDirectory, [
    "timeout" => false
]);

if (isset($_GET["id"])) {
    $feedbackStore->deleteById($_GET["id"]);
}

redirect("/admin/feedback.php");
?>