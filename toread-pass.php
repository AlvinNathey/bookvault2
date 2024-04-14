<?php

include_once 'connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the book details from the form
    $bookImage = $_POST['bookImage'];
    $bookTitle = $_POST['bookTitle'];
    $bookAuthors = $_POST['bookAuthors'];
    $bookPublishedDate = $_POST['bookPublishedDate'];

    // Start the session to get the user_id
    session_start();
    $user_id = $_SESSION['user_id'];

    // Insert the book into 'want-to-read' for this user
    $sql = "INSERT INTO `want_to_read` (`book-img`, `book-title`, `book-author`, `book-date`, `user_id`) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $bookImage, $bookTitle, $bookAuthors, $bookPublishedDate, $user_id);

    if ($stmt->execute()) {
        header("Location: toread-view.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
