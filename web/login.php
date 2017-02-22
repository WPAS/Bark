<?php

require_once '../src/connection.php';
require_once '../src/User.php';

session_start();

if('POST' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_POST['username'])
        && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = User::loadUserByUsername($conn, $username);
            //static, bo inaczej trzeba by stworzyć obiekt przed zalogowaniem użytkownika
            
            if(false === $user) {
                echo "<p>Incorrect username or password</p>";
                exit;
            }
            
        if (password_verify($password, $user->getPassword())) {
            $_SESSION['user'] = $user->getId();
        } else {
            echo '<p>Incorrect username or password</p>';
            exit;            
        }
    }
}

header('Location: /index.php');        