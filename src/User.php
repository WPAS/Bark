<?php

class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    
    public function __construct()
    {
        $this->id = -1;
        $this->email = "";
        $this->username = "";
        $this->password = "";
    }
    
    
    function setUsername($username) 
    {
        $this->username = $username;
    }
    
    function setId($id) {
        $this->id = $id;
    }
    
    function setEmail($email) 
    {
        $this->email = $email;
    }

    function setPassword($password) 
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

        
    public function save(mysqli $conn) {
        if (-1 === $this->id) {
            $sql = sprintf("INSERT INTO `user` (`email`, `username`, `password`) VALUES ('%s', '%s', '%s')",
                $this->email,
                $this->username,
                $this->password
            );

            $result = $conn->query($sql);

            if ($result) {
                $this->id = $conn->insert_id;
                echo "Registration was succesful!";
            } else {
                die("Error user not saved: " . $conn->errno);
            }
        }
    }
}

