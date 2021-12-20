<?php

class User{
    public function __construct($name, $username, $password, $db){
        $this->db = $db;
        $this->name = mysqli_real_escape_string($db, $name);
        $this->username = mysqli_real_escape_string($db, $username);
        $this->password = mysqli_real_escape_string($db, $password);
    }

    // getters
    public function getName(){
        return $this->name;
    }
    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }

    public function isUserExist(){
        $sql = "SELECT * FROM users WHERE username = '$this->username'";
        $result = $this->db->query($sql);
        return $result->num_rows > 0;
    }

    public function login(){
        $sql = "SELECT * FROM users WHERE username = '$this->username'";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (crypt($this->password, $row["password"]) == $row["password"]) {
                $this->name = $row["name"];
                return $this;
            }
            else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function createUser(){
        $this->password = better_crypt($this->password);
        $sql = "INSERT INTO users (name, username, password) VALUES ('$this->name', '$this->username', '$this->password')";
        $this->db->query($sql);
    }
}

?>