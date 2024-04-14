<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Searching </title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    form {
  text-align: center;
  margin-top: 30px;
}
input[type="text"] {
  width: 40%;
  padding: 15px;
  border-radius: 10px;
  font-size: 15px;
  border: 1px solid #ccc;
}
button {
  padding: 15px 10px 15px 10px;
  background-color: #708ee6;
  color: white;
  border: none;
  border-radius: 10px;
  margin-left: 10px;
}
.book-container {
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 10px;
  margin: 10px;
  padding: 10px;
  cursor: pointer; 
}
.book-container img {
  width: 200px; 
  height: 300px; 
  display: block;
  margin: 0 auto 10px;
}
.book-details {
  text-align: center;
}
/* Add this CSS for the loader */
.loader {
  border: 6px solid lightcyan; /* Light grey for the background */
  border-top: 6px solid #3498db; /* Blue */
  border-radius: 70%;
  width: 30px;
  height: 30px;
  animation: spin 1s linear infinite;
  margin: 0 auto;
  display: none; 
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<script>
// Function to show book details when a book is clicked
function showBookDetails(bookId) {
    window.location.href = 'show-book-details.php?bookId=' + bookId;
}
</script>

</head>
<body>
<?php include("body/header.php"); ?>
<div class="book-list">
<form method="get" action="">
    <input type="text" name="search" placeholder="Search for a book">
    <button type="submit" name="submit-search"><i class="fa-solid fa-search"></i></button>
</form>


<div class="loader"></div>

<?php
function searchBooks($query) {
    $base_url = 'https://www.googleapis.com/books/v1/volumes?q=';
    $url = $base_url . urlencode($query);
    $response = file_get_contents($url);
    if ($response === false) {
        return false;
    }
    $data = json_decode($response, true);
    if (!$data || !isset($data['items'])) {
        return false;
    }
    return $data['items'];
}
if (isset($_GET['submit-search'])) {
    $query = $_GET['search'];
    echo "<div class='loader'></div>";
    $books = searchBooks($query);
    if ($books === false || empty($books)) {
        echo "No books found for the query: $query";
    } else {
        echo "<div class='book-list'>";
        echo "<h5 style='text-align: center'>Search Results for: $query</h5>";
        foreach ($books as $book) {
            echo "<div class='book-container' onclick='showBookDetails(\"{$book['id']}\")'>";
              // Check if volumeInfo exists and fetch image links
              if (isset($book['volumeInfo']['imageLinks']['thumbnail'])) {
                echo "<img src='" . $book['volumeInfo']['imageLinks']['thumbnail'] . "' alt='Book Cover'>";
            } else {
                echo "<img src='default_image_icon.jpg' alt='Book image not found!'>";
            }
            // Check if volumeInfo exists and fetch title
            if (isset($book['volumeInfo']['title'])) {
                echo "<h3>" . $book['volumeInfo']['title'] . "</h3>";
            } else {
                echo "<h3>Title Not Available</h3>";
            }
            // Check if volumeInfo exists and fetch authors
            if (isset($book['volumeInfo']['authors'])) {
                echo "<p>Author(s): " . implode(", ", $book['volumeInfo']['authors']) . "</p>";
            } else {
                echo "<p>Author(s): Unknown</p>";
            }
            // Check if volumeInfo exists and fetch published date
            if (isset($book['volumeInfo']['publishedDate'])) {
                echo "<p>Publish Year: " . $book['volumeInfo']['publishedDate'] . "</p>";
            } else {
                echo "<p>Publish Year: Unknown</p>";
            }
          
            echo "</div>"; 
        }
        echo "</div>"; 
    }
    echo "<script>document.querySelector('.loader').style.display = 'none';</script>";
}
?>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('.loader').style.display = 'none';
    });
    document.querySelector('form').addEventListener('submit', function () {
        document.querySelector('.loader').style.display = 'block';
    });
    
</script>
<?php include("body/footer.php"); ?>
</body>
</html>
