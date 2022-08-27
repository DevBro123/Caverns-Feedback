<?php
namespace api\auth;
// Deps
require __DIR__ . '/../../../vendor/autoload.php';

// Sessions
if (!isset($_SESSION)) {
    session_start();
}

function login($username, $password) {
    $databaseDirectory = __DIR__ . "/../../../db";
    $userStore = new \SleekDB\Store("users", $databaseDirectory, [
        "timeout" => false
    ]);
    $lookup = $userStore->findBy(["username", "=", $username]);
    $loginGood = "false";
    $user = false;
    for ($i = 0; $i < count($lookup); $i++) {
        if ($lookup[$i]["password"] == $password) {
            $loginGood = $i;
            break;
        }
    }
    $user = $lookup[$loginGood];
    $_SESSION["user"] = $user;
    return $user;
}

?>