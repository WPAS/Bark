<?php

class Comment
{
    private $id;
    private $userId;
    private $barkId;
    private $creationDate;
    private $text;
    
    public function __construct()
    {
        $this->id = -1;
        $this->userId = -1;
        $this->barkId = -1;
        $this->creationDate = '';
        $this->text = '';
    }
    
    private function setId($id) {
        $this->id = $id;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setBarkId($barkId) {
        $this->barkId = $barkId;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getBarkId() {
        return $this->barkId;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getText() {
        return $this->text;
    }

    public function saveToDB(mysqli $conn) 
    {
        if (-1 === $this->id) {
            $sql = sprintf("INSERT INTO `comment` (`userId`, `barkId`, `creationDate`, `text`) VALUES ('%s', '%s', '%s', '%s')",
                $this->userId, $this->barkId, $this->creationDate, $conn->real_escape_string($this->text)
            );

            $result = $conn->query($sql);

            if ($result) {
                $this->id = $conn->insert_id;
                echo "Your comment was saved!";
            } else {
                die("Error, comments not saved: " . $conn->errno);
            }
        }
    }
    
    public static function loadCommentById(mysqli $conn, $id)
    {
        $id_safe = (int) $conn->real_escape_string($id);

        $sql = "SELECT * FROM `comment` WHERE `id` = $id_safe";

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }

        if (1 === $result->num_rows) {
            $dataFromDB = $result->fetch_assoc();

            $comment = new Comment();

            $comment->setId($dataFromDB['id']);
            $comment->setUserId($dataFromDB['userId']);
            $comment->setBarkId($dataFromDB['barkId']);            
            $comment->setText($dataFromDB['text']);
            $comment->setCreationDate($dataFromDB['creationDate']);

            return $comment;
        } else {
            return false;
        }
    }
    
    public static function loadAllCommentsByBarkId(mysqli $conn, $id)
    {
        $id_safe = (int) $conn->real_escape_string($id);

        $sql = "SELECT * FROM `comment` WHERE `barkId` = $id_safe ORDER BY `id` DESC LIMIT 20";
        
        $comments = [];

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }

        if (0 !== $result->num_rows) {
            foreach($result as $row){
                $comment = new Comment();

                $comment->setId($row['id']);
                $comment->setUserId($row['userId']);
                $comment->setBarkId($row['barkId']);
                $comment->setText($row['text']);
                $comment->setCreationDate($row['creationDate']);
                $comments[] = $comment;
            }
            return $comments;
        } else {
            return false;
        }        
    }

}



