<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $current_file_name = basename($_SERVER['PHP_SELF']);
    if (isset($_SESSION['userID']))
    {
        echo "<script>console.log('{$_SESSION['name']} is currently logged in');</script>";
    }
    else if ($current_file_name !== 'login.php')
    {
        header("Location: login.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($pageTitle) ? $pageTitle : 'Laundry') ?></title>
    <?php if (isset($additionalHeaderOptions)) echo $additionalHeaderOptions ?>
</head>
<body>
<?php if(isset($includeNavbar) && $includeNavbar === true): ?>
    <nav class="top-bar-nav">
        <ul>
            <li><a class="<?php if ($current_file_name === "index.php" || $current_file_name === "dashboard.php") echo 'active '?>" href="index.php">Dashboard</a></li>
            <li><a class="<?php if ($current_file_name === "order.php") echo 'active '?>" href="order.php">Orders</a></li>
            <li><a class="<?php if ($current_file_name === "customers.php") echo 'active '?>" href="customers.php">Customers</a></li>
            <li><a class="<?php if ($current_file_name === "supplies.php") echo 'active '?>" href="supplies.php">Supplies</a></li>
            <?php if($_SESSION['roleID'] == 1 || $_SESSION['roleID'] == 3):?>
                <li><a class="<?php if ($current_file_name === "analytics.php") echo 'active '?>" href="analytics.php">Analytics</a></li>
            <?php endif; ?>
            <?php if($_SESSION['roleID'] == 1):?>
            <li><a class="<?php if ($current_file_name === "employees.php") echo 'active '?>" href="employees.php">Employees</a></li>
            <?php endif; ?>
            <li><a href="server/endpoints/logout_action.php">Logout</a></li>
        </ul>
    </nav>
<?php endif; ?>
