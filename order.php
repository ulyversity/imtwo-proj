<?php
$pageTitle = "Orders";
$includeNavbar = true;
include_once "template/header.php";
?>

<h1>ORDERS</h1>

<?php
    include "server/views/Order_OrderDetailsView.php";
?>
<a class="add-order-a" href="add-order.php">ADD ORDER</a>

<?php include_once "template/footer.php"; ?>