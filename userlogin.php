<?php
session_start();

if(isset($_SESSION['logging']) && $_SESSION['logging'] === true){
    header("location: userloggedin.php");
    exit();
}

require_once("connection.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['username']) && isset($_POST['password'])){
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $username = validate($_POST['username']);
        $password = validate($_POST['password']);

        if(empty($username) || empty($password)){
            $error = "All fields are required";
        }else{
            $sql = "SELECT * FROM users WHERE username ='$username'";
            $result = $conn->query($sql);
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                // Verify hashed password
                if(password_verify($password, $row['password_hash'])){
                    $_SESSION['logging'] = true;
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    header("location: userloggedin.php");
                    exit();
                }else{
                    $error = "Incorrect password";
                }
            }else{
                $error = "User not found";
            }
        }
    }
}

?>
