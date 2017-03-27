<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="POST" action="login.php">
            <p>
                <label>Your username
                    <input name="username" type="text">
                </label>
            </p>
            <p>
                <label>Your password
                    <p><input name="password" type="password"></p>
                </label>
            </p>
            <p>
                <input type="submit" value="Log in">
            </p>
        </form>
    <?php require_once '../src/footer.php'; ?>             
    </body>    
</html>



