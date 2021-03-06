<?php
if ("POST" === $_SERVER["REQUEST_METHOD"]) {
    if(isset($_POST["text"]) && isset($_POST["userId"]) && isset($_POST["creationDate"])) {
        $text = nl2br(htmlentities($_POST["text"]));
        $userId = (int) $_POST["userId"];
        $creationDate = $_POST["creationDate"];

        if (strlen($text) > 150) {
            echo "<p>Your Bark can't have more then 150 characters</p>";
        } else {
            $bark = new Bark();

            $bark->setUserId($userId);
            $bark->setText($text);
            $bark->setCreationDate($creationDate);

            $bark->saveToDB($conn);

            if ($bark->getId() === -1) {
                echo "We are very sorry. Your Bark wasn't saved. Please try again later.";
            }
        }
    }
}
?>

<form method="POST" action="index.php">
     <h2>Bark something!</h2>
     <textarea name="text" placeholder="Share your thoughts" rows="4" cols="50"></textarea>
     <input type="hidden" value="<?php echo $user->getId() ?>" name="userId">
     <input type="hidden" value="<?php echo date('H:i d.m.Y') ?>" name="creationDate"><br>
     <input type="submit" value="Save your Bark">
</form>
