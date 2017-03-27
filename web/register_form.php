<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="POST" action="register.php">
            <ul>
                <li>
                <label>Login
                    <input name="username" type="text">
                </label>
                </li>
                <li>    
                <label>Email
                    <input name="email" type="email">
                </label>
                </li>
                <li>    
                <label>Password
                    <input name="password" type="password">
                </label>
                </li>
                <li>    
                <input type="submit" value="Register">
                </li>
            </ul>
        </form>
        <?php require_once '../src/footer.php'; ?>         
    </body>    
</html>
