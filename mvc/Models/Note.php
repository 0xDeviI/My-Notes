<?php

class Note{
    public function __construct($id, $username, $title, $content, $db){
        $this->db = $db;
        $this->id = mysqli_real_escape_string($this->db, $id);
        $this->username = mysqli_real_escape_string($this->db, $username);
        $this->title = $title;
        $this->content = $content;
    }

    public function addNote(){
        $query = "INSERT INTO notes (id, username, title, content) VALUES ('$this->id', '$this->username', '$this->title', '$this->content')";
        $result = @mysqli_query($this->db, $query);
        if ($result){
            return true;
        }
        else{
            return false;
        }
    }

    public function getNotes(){
        $query = "SELECT * FROM notes WHERE username = '$this->username'";
        $result = @mysqli_query($this->db, $query);
        if ($result){
            $notes = [];
            while ($row = mysqli_fetch_assoc($result)){
                array_push($notes, $row);
            }
            return $notes;
        }
        else{
            return false;
        }
    }

    public function getNote(){
        $query = "SELECT * FROM notes WHERE id = '$this->id' AND username = '$this->username'";
        $result = @mysqli_query($this->db, $query);
        if ($result){
            $note = mysqli_fetch_assoc($result);
            return $note;
        }
        else{
            return false;
        }
    }

    public function updateNote(){
        $query = "UPDATE notes SET title = '$this->title', content = '$this->content' WHERE id = '$this->id' AND username = '$this->username'";
        $result = @mysqli_query($this->db, $query);
        if ($result){
            return true;
        }
        else{
            return false;
        }
    }
    public function deleteNote(){
        $query = "DELETE FROM notes WHERE id = '$this->id'";
        $result = @mysqli_query($this->db, $query);
        if ($result){
            return true;
        }
        else{
            return false;
        }
    }
}

?>