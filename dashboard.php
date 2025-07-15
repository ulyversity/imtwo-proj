<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div class="top-bar-div"><p>testing</p></div>
    <div class="two-block-div">
        <?php
        include "server/views/Dashboard_OrderStatusView.php";
        include "server/views/Dashboard_SupplyListView.php";
        ?>
    </div>
    
</body>
</html>