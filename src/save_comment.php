<?php
if ("POST" === $_SERVER["REQUEST_METHOD"]) {
    if(isset($_POST["comment"]) && isset($_POST["userId"]) && isset($_POST["barkId"]) && isset($_POST["creationDate"])) {
        //here also validation/sanitation needed
        $text = $_POST["comment"];
        $userId = $_POST["userId"];
        $barkId = $_POST["barkId"];
        $creationDate = $_POST["creationDate"];

        $comment = new Comment();
        
        $comment->setUserId($userId);
        $comment->setBarkId($barkId);
        $comment->setText($text);
        $comment->setCreationDate($creationDate);
        
        $comment->saveToDB($conn);
    } else {
        echo "We are very sorry. Your comment wasn't saved. Please try again later.";
    }
}