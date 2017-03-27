<?php
require_once '../src/lib.php';
require_once '../src/connection.php';
require_once '../src/User.php';
require_once '../src/Bark.php';
require_once '../src/Comment.php';
require_once '../src/Message.php';

session_start();

$user = loggedUser($conn);

if ("GET" === $_SERVER["REQUEST_METHOD"] && isset($_GET["to"]) ) {
    $addresseeId = $_GET["to"];
    $addressee = USER::loadUserById($conn, $addresseeId);    
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bark - writing message</title>
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
    <?php
        if ($user->getId() == $addresseeId) {
            echo "<p>You can't send messages to yourself</p>";
        } else {
    ?>
        <form method="POST" action="sending_messages.php">
            <h2>Send message to <?php echo $addressee->getUsername() ?></h2>
             <textarea name="message" placeholder="Write your message" rows="6" cols="60"></textarea>
             <input type="hidden" value="<?php echo $user->getId() ?>" name="authorId">
             <input type="hidden" value="<?php echo $addresseeId ?>" name="addresseeId">
             <input type="hidden" value="<?php echo date('H:i d.m.Y') ?>" name="creationDate"><br>
             <input type="submit" value="Send message">
        </form>
<?php 
        }
    } else {
        echo "<p>Only users can send messages. Please <a href='login_form.php'>log in</a> or return to the <a href='index.php'>main page</a></p>";
    }
require_once '../src/footer.php';             
?>
</body>
