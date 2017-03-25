<?php

require_once '../src/lib.php';
require_once '../src/connection.php';
require_once '../src/User.php';
require_once '../src/Bark.php';

session_start();

$user = loggedUser($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bark - user page</title>
</head>
<body>
    <p>
        You are logged in as: <?php echo $user->getUsername() ?>. <br>
        You can <a href="index.php">return to main page</a> or <a href='logout.php'>logout</a>.            
    </p>
    <?php include_once '../src/bark_form.php'; ?>
    <div>
        <h2>Your Barks</h2>
        <?php            
            $barks = Bark::loadAllBarksByUserId($conn, $user->getId());
            
            foreach($barks as $bark) { 
        ?>
                <div>
                    <p><?php echo $bark->getText(); ?></p>
                    <p><?php echo $bark->getCreationDate() ?></p>
                </div>
        <?php } ?>
    </div>   
</body>
