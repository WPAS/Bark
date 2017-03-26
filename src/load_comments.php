<?php

$comments = Comment::loadAllCommentsByBarkId($conn, $bark->getId());

if ($comments && count($comments) > 0) {
    echo "<h4>Comments</h4>";
    foreach($comments as $comment) {
        $author = User::loadUserById($conn, $comment->getUserId()); ?>
        <div>
            <p><?php echo $comment->getText(); ?></p>
            <p><?php echo $author->getUsername() . ", " . $comment->getCreationDate() ?><br>
            <a href="messages_form.php?to=<?php echo $author->getId() ?>">Send private message to the author</a></p>            
        </div>
<?php    }    
}