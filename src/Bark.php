<?php

class Bark
{
    private $id;
    private $userId;
    private $text;
    private $creationDate;
    
    public function __construct()
    {
        $this->id = -1;
        $this->userId = -1;
        $this->text = "";
        $this->creationDate = "";
    }    

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getText() {
        return $this->text;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function setUserId($userId) {
        $this->userId = $userId;        
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }
    
    private function setId($id) {
        $this->id = $id;
    }

    public function saveToDB(mysqli $conn) 
    {
        if (-1 === $this->id) {
            $sql = sprintf("INSERT INTO `bark` (`userId`, `text`, `creationDate`) VALUES ('%s', '%s', '%s')",
                $this->userId, $conn->real_escape_string($this->text), $this->creationDate
            );

            $result = $conn->query($sql);

            if ($result) {
                $this->id = $conn->insert_id;
                echo "Your Bark was saved!";
            } else {
                die("Error, Bark not saved: " . $conn->errno);
            }
        }
    }

    static public function loadBarkById(mysqli $conn, $id)
    {
        $id_safe = $conn->real_escape_string($id);

        $sql = "SELECT * FROM `bark` WHERE `id` = $id_safe";

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }

        if (1 === $result->num_rows) {
            $dataFromDB = $result->fetch_assoc();

            $bark = new Bark();

            $bark->setId($dataFromDB['id']);
            $bark->setUserId($dataFromDB['userId']);
            $bark->setText($dataFromDB['text']);
            $bark->setCreationDate($dataFromDB['creationDate']);

            return $bark;
        } else {
            return false;
        }
    }
    
    static private function loadManyBarks(mysqli $conn, $sql) {
        $barks = [];

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }

        if (0 !== $result->num_rows) {
            foreach($result as $row){
                $bark = new Bark();

                $bark->setId($row['id']);
                $bark->setUserId($row['userId']);
                $bark->setText($row['text']);
                $bark->setCreationDate($row['creationDate']);
                $barks[] = $bark;
            }
            return $barks;
        } else {
            return false;
        }        
    }

    static public function loadAllBarksByUserId(mysqli $conn, $id)
    {
        $id_safe = $conn->real_escape_string($id);

        $sql = "SELECT * FROM `bark` WHERE `userId` = $id_safe ORDER BY `id` DESC LIMIT 20";
        return self::loadManyBarks($conn, $sql);
    }

    static public function loadAllBarks(mysqli $conn)
    {
        $sql = "SELECT * FROM `bark` ORDER BY `id` DESC LIMIT 20";
        return self::loadManyBarks($conn, $sql);
    } 

}
