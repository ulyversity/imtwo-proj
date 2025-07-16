<?php
session_start();
if (isset($_SESSION['userID']))
    header("Location: index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preload" href="assets/washing-machine.jpg" as="image" fetchpriority="high">
</head>
<body>
    <div class="login-page-background">
    <div class="login-outer-div">
    <div class="login-inner-div">
        <form action="server/endpoints/login_action.php" method="POST">
            <label for="txtUsername">Username:</label>
            <input type="text" name="username" id="txtUsername">
            <label for="txtPassword">Password:</label>
            <input type="password" name="password" id="txtPassword">
            <button>login</button>
        </form>
    </div>
    </div>
    </div>
</body>
</html>