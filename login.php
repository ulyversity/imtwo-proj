<?php
session_start();
if (isset($_SESSION['userID']))
    header("Location: index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="backend/endpoints/login_action.php" method="POST">
        <label for="txtUsername">Username:</label>
        <input type="text" name="username" id="txtUsername">
        <label for="txtPassword">Password:</label>
        <input type="password" name="password" id="txtPassword">
        <button>login</button>
    </form>
</body>
</html>