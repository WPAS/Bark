<?php

require_once '../src/lib.php';
require_once '../src/connection.php';
require_once '../src/User.php';
require_once '../src/Bark.php';
require_once '../src/Comment.php';
require_once '../src/Message.php';

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
        <h2>Messages send to you</h2>
        <?php            
        $messagesForYou = Message::loadAllMessagesByAddressee($conn, $user->getId());
        if ($messagesForYou && count($messagesForYou) > 0) {
            
            foreach($messagesForYou as $message) { 

                $author = User::loadUserById($conn, $message->getAuthorId())
        ?>
                <div class="bark">
                    <?php
                        if ($message->getRead() === '0') {
                            echo "NEW MESSAGE!";
                            $message->checkAsRead($conn);
                        }
                    ?>
                    <p><?php echo $message->getText(); ?></p>
                    <p>From <?php echo $author->getUsername() . ", " . $message->getCreationDate() ?><br>
                    <a href="messages_form.php?to=<?php echo $author->getId() ?>">Send private message to the author</a></p>    
                </div>
        <?php } 
        } else {
            echo "You have no messages";
        }    
        ?>

        <h2>Your messages</h2>
        <?php            
        $yourMessages = Message::loadAllMessagesByAuthor($conn, $user->getId());
        if ($yourMessages && count($yourMessages) > 0) {

            foreach($yourMessages as $message) { 
                $addressee = User::loadUserById($conn, $message->getAddresseeId())
        ?>
                <div class="bark">
                    <p><?php echo $message->getText(); ?></p>
                    <p>To <?php echo $addressee->getUsername() . ", " . $message->getCreationDate() ?></p>                    
                </div>
        <?php } 
        } else {
            echo "You send no messages";
        }    
        ?>
        
        <h2>Your Barks</h2>
        <?php            
        $barks = Bark::loadAllBarksByUserId($conn, $user->getId());
        if ($barks && count($barks) > 0) {
            
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
        <?php } 
        } else {
            echo "You wrote no Barks";
        }    
        ?>
    </div>
<?php
    } else {
        echo "<p>Please <a href='login_form.php'>log in</a></p>";
    }
?>
</body>
