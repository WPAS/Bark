<?php

require_once '../src/lib.php';
require_once '../src/connection.php';
require_once '../src/User.php';
require_once '../src/Bark.php';
require_once '../src/Comment.php';

session_start();

$user = loggedUser($conn);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bark - user page</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
    if ($user) {
?>
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
                <div class="bark">
                    <p><?php echo $bark->getText(); ?></p>
                    <p><?php echo $bark->getCreationDate() ?></p>
                    <div class="comment">
                        <?php include '../src/load_comments.php'; ?>
                        <div>
                            <?php 
                                if ($user) {
                                    include_once '../src/save_comment.php';
                                    include '../src/comment_form.php';
                                }
                            ?>    
                        </div>
                    </div>
                </div>
        <?php } ?>
    </div>
<?php
    } else {
        echo "<p>Please <a href='login_form.php'>log in</a></p>";
    }
?>
</body>
