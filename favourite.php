<?php

include_once 'connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the book details from the form
    $bookImage = $_POST['bookImage'];
    $bookTitle = $_POST['bookTitle'];
    $bookAuthor = $_POST['bookAuthor'];
    $bookDate = $_POST['bookDate'];

    // Get the user_id from the session
    session_start();
    $user_id = $_SESSION['user_id'];

    // Check if the book already exists in the favorites for this user
    $sql_check = "SELECT * FROM favorite_books WHERE book_title = ? AND book_author = ? AND user_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("sss", $bookTitle, $bookAuthor, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "This book is already in your favorites.";
    } else {
        // Insert the book into favorites for this user
        $sql_insert = "INSERT INTO favorite_books (book_img, book_title, book_author, book_date, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssi", $bookImage, $bookTitle, $bookAuthor, $bookDate, $user_id);

        if ($stmt_insert->execute()) {
            header("Location: favourite-view.php");
            exit();
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
}

$conn->close();
?>
