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
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .welcome {
            color: lightslategrey;
            font-size: 18px;
        }
        .menu {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .menu div {
            flex: 1;
            text-align: center;
            padding: 20px;
            margin: 0px;
            border: 1px solid #000;
            cursor: pointer;
        }
        .view-users {
            background-color: #3c763d;
            color: white;
        }
        .add-user {
            background-color: #87ceeb;
            color: black;
        }
        .edit-user-list {
            background-color: #d3d3d3;
            color: black;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="wrapper">
        <img src="img/book-vault-logo.png" alt="Book Vault Logo" style="width: 100px; height: auto;">
        <h4 style="text-align: left; margin: 0;">Revolutionize Reading!</h4>
    </div>
    <div class="welcome">
        Welcome, Admin <?php echo htmlspecialchars($adminName); ?>
    </div>
</div>

<div class="menu">
    <div class="view-users" onclick="loadUsersTable()" style="cursor: pointer; text-decoration: none; color: inherit;">VIEW USERS</div>
    <div class="add-user">ADD USER</div>
    <div class="edit-user-list">EDIT USER LIST</div>
</div>

<div id="usersTableContainer"></div>

<script>
    function loadUsersTable() {
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "viewusers.php", true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("usersTableContainer").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }
</script>

</body>
</html>
