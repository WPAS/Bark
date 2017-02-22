<?php
require_once '../src/connection.php';
require_once '../src/User.php';

if ("POST" === $_SERVER["REQUEST_METHOD"]) {
    if(isset($_POST["username"])
        && isset($_POST["email"])
        && isset($_POST["password"])
    ) {
        //add some validation in future
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        $user = new User();
        
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        
        $user->save($conn);
    }
}

header('Location: /index.php');