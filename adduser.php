<?php
session_start();

if (!isset($_SESSION['logging']) || $_SESSION['logging'] !== true) {
    header("location: adminlogin.php");
    exit();
}

include_once 'connection.php';

// Check if the form is submitted for adding a new user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    // Retrieve form data using $_POST
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password for security
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert user data into the database
    $sql = "INSERT INTO users (username, email, password_hash) 
            VALUES ('$username', '$email', '$password_hash')";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Display success message using JavaScript
        echo "<script>
                alert('User added successfully');
                window.location.href = 'adminloggedin.php'; // Redirect back to the admin page
              </script>";
    } else {
        // Display error message
        echo "Error adding user: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
