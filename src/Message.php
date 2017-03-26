<?php

class Message {
    private $id;
    private $text;
    private $creationDate;
    private $authorId;
    private $addresseeId;
    private $read;
    
    public function __construct()
    {
        $this->id = -1;
        $this->authorId = -1;
        $this->addresseeId = -1;
        $this->creationDate = '';
        $this->text = '';
        $this->read = 0;        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getText() {
        return $this->text;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getAuthorId() {
        return $this->authorId;
    }

    public function getAddresseeId() {
        return $this->addresseeId;
    }

    public function getRead() {
        return $this->read;
    }

    private function setId($id) {
        $this->id = $id;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setAuthorId($authorId) {
        $this->authorId = $authorId;
    }

    public function setAddresseeId($addresseeId) {
        $this->addresseeId = $addresseeId;
    }

    public function setRead($read) {
        $this->read = $read;
    }

    public function saveToDB(mysqli $conn) 
    {
        if (-1 === $this->id) {
            $sql = sprintf("INSERT INTO `message` (`authorId`, `addresseeId`, `creationDate`, `text`, `read`) "
                . "VALUES ('%s', '%s', '%s', '%s', '%s')",
                $this->authorId, $this->addresseeId, $this->creationDate, $conn->real_escape_string($this->text), $this->read 
            );

            $result = $conn->query($sql);

            if ($result) {
                $this->id = $conn->insert_id;
                echo "Your message was send!";
            } else {
                die("Error, message not send: " . $conn->errno);
            }
        }
    }

    static private function loadManyMessages(mysqli $conn, $sql) {
        $messages = [];

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }

        if (0 !== $result->num_rows) {
            foreach($result as $row){
                $message = new Message();

                $message->setId($row['id']);
                $message->setAuthorId($row['authorId']);
                $message->setAddresseeId($row['addresseeId']);                
                $message->setText($row['text']);
                $message->setCreationDate($row['creationDate']);
                $message->setRead($row['read']);
                $messages[] = $message;
            }
            return $messages;
        } else {
            return false;
        }        
    }

    static public function loadAllMessagesByAuthor(mysqli $conn, $id)
    {
        $id_safe = $conn->real_escape_string($id);

        $sql = "SELECT * FROM `message` WHERE `authorId` = $id_safe ORDER BY `id` DESC LIMIT 20";
        return self::loadManyMessages($conn, $sql);
    }

    static public function loadAllMessagesByAddressee(mysqli $conn, $id)
    {
        $id_safe = $conn->real_escape_string($id);
        
        $sql = "SELECT * FROM `message` WHERE `addresseeId` = $id_safe ORDER BY `id` DESC LIMIT 20";
        return self::loadManyMessages($conn, $sql);
    } 
    
    public function checkAsRead(mysqli $conn) {
        $id = $this->id;        
        $sql = "UPDATE `message` SET `read` = 1 WHERE `id` = $id LIMIT 1";
        $conn->query($sql);
    }
    
}
