<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Role:  
        <?php 
            include "server/views/CurrentRoleView.php";
        ?>
    </p>
    <button><a href="login.php">login</a></button>  
    <form action="server/endpoints/logout_action.php">
        <button>logout</button>
    </form>
    
    
</body>
</html>