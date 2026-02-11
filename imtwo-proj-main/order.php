<?php
$pageTitle = "Orders";
$includeNavbar = true;
include_once "template/header.php";
?>

<?php
    include "server/views/Order_OrderDetailsView.php";
?>
<a class="add-order-a" href="add-order.php">ADD ORDER</a>

<?php include_once "template/footer.php"; ?>