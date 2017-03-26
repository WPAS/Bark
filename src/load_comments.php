<?php

$comments = Comment::loadAllCommentsByBarkId($conn, $bark->getId());

if ($comments && count($comments) > 0) {
    echo "<h4>Comments</h4>";
    foreach($comments as $comment) {
        $author = User::loadUserById($conn, $comment->getUserId()); ?>
        <div>
            <p><?php echo $comment->getText(); ?></p>
            <p><?php echo $author->getUsername() . ", " . $comment->getCreationDate() ?></p>
        </div>
<?php    }    
}