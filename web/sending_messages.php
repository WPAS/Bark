<?php
require_once '../src/connection.php';
require_once '../src/Message.php';
require_once '../src/lib.php';

session_start();

$user = loggedUser($conn);

if ("POST" === $_SERVER["REQUEST_METHOD"]) {
    if(isset($_POST["message"]) && isset($_POST["authorId"]) && isset($_POST["addresseeId"]) && isset($_POST["creationDate"])) {
        $text = $_POST["message"];
        $authorId = $_POST["authorId"];
        $addresseeId = $_POST["addresseeId"];
        $creationDate = $_POST["creationDate"];

        if (strlen($text) > 150) {
            echo "<p>Your message can't have more then 150 characters</p>";
        } else {
            $message = new Message();

            $message->setAuthorId($authorId);
            $message->setAddresseeId($addresseeId);
            $message->setText($text);
            $message->setCreationDate($creationDate);

            $message->saveToDB($conn);

            if ($message->getId() === -1) {
                echo "We are very sorry. Your message wasn't send. Please try again later.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bark - sending message</title>
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
    } else {
        echo "It seems you are lost :) You can return <a href='index.php'>return to the main page</a>";
    }
