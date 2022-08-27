<?php
namespace root;

function Head() {
    echo '
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="/slider.css"/>
    ';
}

function Nav() {
    $userLinks = '
<a href="/login.php" class="text-sky-500 ml-auto pl-2 pr-2">Login</a>
<a href="/register.php" class="text-sky-500 pl-2 pr-2">Register</a>
';
    $feedback = '';
    if (array_key_exists("user", $_SESSION)) {
        $userLinks = '
<a href="/logout.php" class="text-sky-500 ml-auto pl-2 pr-2">Logout</a>
    ';
        $feedback = '<a href="/feedback.php" class="text-sky-500 mr-auto pl-2 pr-2">Give Feedback</a>';
    }
    echo '
<nav class="flex flex-row sticky top-0 bg-white">
' . $feedback . '
' . $userLinks . '
</nav>
';
}

?>