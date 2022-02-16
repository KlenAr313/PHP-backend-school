<?php

use JetBrains\PhpStorm\Internal\ReturnTypeContract;

include('database.php');

    class User{
        private $conn;
        private $id;
        public $firstName;
        public $lastName;
        public $email;
        public $password;

        function __construct()
        {
            $db = new DB();
            $this->conn = $db->getConnection();
        }

        function signUp()
        {
            $query = "INSERT INTO `users`(`firstName`, `lastName`, `email`, `password`) VALUES (?,?,?,?)";
            $stmt = $this->conn->prepare($query);

            $this->firstName = htmlspecialchars(strip_tags($this->firstName));
            $this->lastName = htmlspecialchars(strip_tags($this->lastName));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = password_hash($this->password,PASSWORD_BCRYPT);

            $stmt->bind_param("ssss",$this->firstName,$this->lastName,$this->email,$this->password);

            return $result = $stmt->execute();
        }

        function emailExists()
        {
            $query = "SELECT * FROM `users` WHERE `email` like ?";

            $this->email = htmlspecialchars(strip_tags($this->email));

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s",$this->email);

            $stmt->execute();
            
            $result = $stmt->get_result();
            if ($result->num_rows == 0) return false;
            return true;
        }

        function login()
        {
            $query = "SELECT * FROM `users` WHERE `email` like ?";

            $this->email = htmlspecialchars(strip_tags($this->email));

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s",$this->email);
            $stmt->execute();
            
            $result = $stmt->get_result();
            if ($result->num_rows == 0) return false;

            $fetched = $result->fetch_object();
            $hash = $fetched->password;
            if (password_verify($this->password,$hash) == false) return false;
            $this->firstName = $fetched->firstName;
            $this->lastName = $fetched->lastName;
            return true;
        }

        function modify()
        {
            $query = "UPDATE `users` SET `firstName`= ?,`lastName`= ?,`password`= ? WHERE `email` = ?";
            $stmt = $this->conn->prepare($query);

            $this->firstName = htmlspecialchars(strip_tags($this->firstName));
            $this->lastName = htmlspecialchars(strip_tags($this->lastName));
            $this->email = htmlspecialchars(strip_tags($this->email));
            if (ctype_space($this->password) || $this->password == null || $this->password == "")
            {
                return false;
            }
            $this->password = password_hash($this->password,PASSWORD_BCRYPT);

            $stmt->bind_param("ssss",$this->firstName,$this->lastName,$this->password, $this->email);
            
            $stmt->execute();
            if ($stmt->affected_rows == 0) return false;
            return true;
        }
    }

?>