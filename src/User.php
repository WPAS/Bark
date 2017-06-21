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
    
    public function setUsername($username) 
    {
        $this->username = $username;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setEmail($email) 
    {
        $this->email = $email;
    }

    public function setPassword($password) 
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function setHash($hash)
    {
        $this->password = $hash;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function getUsername() 
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword() 
    {
        return $this->password;
    }
    
        
    public function save(mysqli $conn) 
    {
        if (-1 === $this->id) {
            $sql = sprintf("INSERT INTO `user` (`email`, `username`, `password`) VALUES ('%s', '%s', '%s')",
                $conn->real_escape_string($this->email),
                $conn->real_escape_string($this->username),
                $conn->real_escape_string($this->password)
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


    public static function loadUserByUsername(mysqli $conn, $username)
    {
        $username = $conn->real_escape_string($username);
        
        $sql = "SELECT * FROM `user` WHERE `username` = '$username'";
        
        $result = $conn->query($sql);
        
        if (!$result) {
            die('Query error: ' . $conn->error);
        }
        
        if (1 === $result->num_rows) {
            $userArray = $result->fetch_assoc();
            
            $user = new User();
            
            $user->setId($userArray['id']);
            $user->setEmail($userArray['email']);
            $user->setUsername($userArray['username']);
            $user->setHash($userArray['password']);
            
            return $user;
        } else {
            return false;
        }
    }

    public static function loadUserById(mysqli $conn, $id)
    {
        $id = (int) $conn->real_escape_string($id);

        $sql = "SELECT * FROM `user` WHERE `id` = $id";

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }

        if (1 === $result->num_rows) {
            $userArray = $result->fetch_assoc();

            $user = new User();

            $user->setId($userArray['id']);
            $user->setEmail($userArray['email']);
            $user->setUsername($userArray['username']);
            $user->setHash($userArray['password']);

            return $user;
        } else {
            return false;
        }
    }
}
