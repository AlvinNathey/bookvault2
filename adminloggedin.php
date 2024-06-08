<?php
session_start();

if (!isset($_SESSION['logging']) || $_SESSION['logging'] !== true) {
    header("location: adminlogin.php");
    exit();
}

include_once 'connection.php';

// Retrieve the admin's ID and name from the session
$adminId = $_SESSION['admin_id'];
$adminName = $_SESSION['admin_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        .header {
            position: sticky;
            top: 0;
            background: #f7f7f8;
            border-bottom: 3px solid #87CEEB;
            z-index: 1000;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .welcome {
            position: absolute;
            top: 0;
            right: 0;
        }
        h3 {
            font-size: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .header .nav li a {
            color: lightslategrey;
            display: block;
            line-height: 30px;
            padding: 2px 0 0;
            width: 100px;
            background: url('../img/book-vault-logo.png') no-repeat 0px 60px;
            white-space: nowrap;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            text-decoration: none;
            cursor: pointer;
        }
        .genre-section {
            margin-bottom: 40px;
        }
        .genre-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .carousel {
            display: flex;
            overflow-x: scroll;
            overflow-y: hidden;
            position: relative;
            width: 100%;
        }
        .carousel-inner {
            display: flex;
            transition: transform 0.5s ease;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="wrapper">
        <img src="img/book-vault-logo.png" alt="Book Vault Logo" style="width: 100px; height: auto;">
        <h4 style="text-align: left;">Revolutionize Reading!</h4>
    </div>
</div>
<!-- Welcome Message -->
<div class="container">
    <h3>Welcome, <?php echo htmlspecialchars($adminName); ?></h3>
</div>
</body>
</html>
