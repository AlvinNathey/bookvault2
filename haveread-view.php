<?php
session_start();

include_once 'connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve books associated with the logged-in user's user_id
    $sql = "SELECT * FROM `haveread` WHERE `user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display books
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Books I\'ve read</title>
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <style>
            .book-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }
            .book {
                width: 50%; 
                margin-bottom: 30px; 
            }
        </style>
    </head>
    <body>';
    include("body/header.php");
    echo '<div class="max-w-xl mx-auto">
        <h2 class="text-3xl font-bold mt-8 mb-4">Books I\'ve read</h2>
        <div class="book-container">';

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $bookImage = $row["book-img"];
            $bookTitle = $row["book-title"];
            $bookAuthors = $row["book-author"];
            $bookPublishedDate = $row["book-date"];
            $timestamp = $row["timestamp"]; // Get the timestamp from the database

            echo '<div class="book">
                    <div class="flex items-center">
                        <img src="' . $bookImage . '" alt="Book Cover" class="w-16 h-auto mr-4">
                        <div>
                            <h3 class="text-lg font-semibold">' . $bookTitle . '</h3>
                            <p class="text-sm text-gray-500">By ' . $bookAuthors . ' <br> Published Date: ' . $bookPublishedDate . ' <br> Book added on : ' . $timestamp . '</p>
                        </div>
                    </div>
                    <!-- Favorite button -->
                    <form action="favourite.php" method="post">
                        <input type="hidden" name="bookImage" value="' . htmlspecialchars($bookImage) . '">
                        <input type="hidden" name="bookTitle" value="' . htmlspecialchars($bookTitle) . '">
                        <input type="hidden" name="bookAuthor" value="' . htmlspecialchars($bookAuthors) . '">
                        <input type="hidden" name="bookDate" value="' . htmlspecialchars($bookPublishedDate) . '">
                        <button class="flex-none flex items-center justify-center w-10 h-10 text-slate-300 ml-20 hover:text-red-800" type="submit" aria-label="Like" title="Add to favourites"> 
                            <svg width="20" height="20" aria-hidden="true" class="fill-current">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" fill="#4B5563" />
                            </svg>
                        </button>
                    </form>
                </div>';
        }
    } else {
        echo '<p class="text-gray-600">No books added to read list yet.</p>';
    }

    echo '</div>
        </div>';
    include("body/footer.php");
    echo '</body>
    </html>';
} else {
    // Handle cases where user is not logged in or user_id is not set in session
    header("Location: userlogin.html");
    exit();
}
?>
