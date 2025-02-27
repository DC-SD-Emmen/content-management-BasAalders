<?php
class loginManager{
    private $conn;

    //making the connection
    public function __construct() {
        include_once 'databaseConnection.php';
        $db = new DataBase();
        $this->conn = $db->getConnection();
    }
    function addLogin($username, $password){
        // test if username already exist
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            session_start();
            $_SESSION['error'] = "Username already exists";
            header("Location: http://localhost/register.php");
            return;
        }


        $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        session_start();
        $_SESSION['success'] = "Your login have been added please login";
        header("Location: http://localhost/login.php");
    }

    function login($username, $password){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $user['id'];
                header("Location: http://localhost/");
                exit();
            } else {
                session_start();
                $_SESSION['error'] = "Wrong password";
                header("Location: http://localhost/login.php");
            }
        }else{
            session_start();
            $_SESSION['error'] = "No user found with this username";
            header("Location: http://localhost/login.php");
        }

    }
}