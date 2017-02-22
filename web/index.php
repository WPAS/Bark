<?php

require_once '../src/lib.php';
require_once '../src/connection.php';
require_once '../src/User.php';

session_start();

$user = loggedUser($conn);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Index</title>
</head>
<body>
    <?php if ($user) { ?>
        <p>
            You are logged in as: <?php echo $user->getUsername() ?>
            <a href='/logout.php'>Logout</a>
        </p>
    <?php } else { ?>
        <p>
            <a href="loginForm.php">Login</a>
        </p>
    <?php } ?>
</body>
</html>