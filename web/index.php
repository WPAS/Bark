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
    <title>Bark</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php if ($user) { ?>
        <p>
            You are logged in as: <?php echo $user->getUsername() ?>.<br>
            You can go to <a href="user_page.php">your own page</a> or <a href='logout.php'>logout</a>            
        </p>
    <?php include_once '../src/bark_form.php';
        
    } else { ?>
        <p>
            <a href="login_form.php">Login</a>
        </p>
        <p>
            Not a user? You can <a href="register_form.php">register</a>
        </p>

    <?php } ?>
    <div>
        <h2>Recent Barks</h2>
        <?php            
            $barks = Bark::loadAllBarks($conn);
            
            foreach($barks as $bark) {
                $author = User::loadUserById($conn, $bark->getUserId());
        ?>
                <div class="bark">
                    <p><?php echo $bark->getText(); ?></p>
                    <p><?php echo $author->getUsername() . ", " . $bark->getCreationDate() ?><br>
                    <a href="messages_form.php?to=<?php echo $author->getId() ?>">Send private message to the author</a></p>
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
</body>
</html>
