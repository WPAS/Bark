<?php
if ("POST" === $_SERVER["REQUEST_METHOD"]) {
    if(isset($_POST["comment"]) && isset($_POST["userId"]) && isset($_POST["barkId"]) && isset($_POST["creationDate"])) {
        $text = $_POST["comment"];
        $userId = $_POST["userId"];
        $barkId = $_POST["barkId"];
        $creationDate = $_POST["creationDate"];
    
        if (strlen($text) > 100) {
            echo "<p>Your comment can't have more then 100 characters</p>";
        } else {
            $comment = new Comment();

            $comment->setUserId($userId);
            $comment->setBarkId($barkId);
            $comment->setText($text);
            $comment->setCreationDate($creationDate);

            $comment->saveToDB($conn);

            if ($comment->getiD() === -1) {
                echo "We are very sorry. Your comment wasn't saved. Please try again later.";
            }
        }
    }    
}