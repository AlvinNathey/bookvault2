<?php
session_start();

include_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
  
    $bookImage = $_POST['bookImage'];
    $bookTitle = $_POST['bookTitle'];
    $bookAuthors = $_POST['bookAuthors'];
    $bookPublishedDate = $_POST['bookPublishedDate'];
    $user_id = $_SESSION['user_id']; // Get the user ID from the session

    $sql = "INSERT INTO `haveread` (`book-img`, `book-title`, `book-author`, `book-date`, `timestamp`, `user_id`) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $bookImage, $bookTitle, $bookAuthors, $bookPublishedDate, $user_id);

    if ($stmt->execute()) {
      
       header("Location: haveread-view.php");
       exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

   
    $stmt->close();
    $conn->close();
} else {
    // Handle cases where user is not logged in or user_id is not set in session
}
?>
