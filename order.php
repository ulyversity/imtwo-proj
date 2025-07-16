<?php
$pageTitle = "Orders";
$includeNavbar = true;
include_once "template/header.php";
?>

<h1>ORDERS:</h1>
<?php
    include "server/views/Order_OrderDetailsView.php";
?>


<?php include_once "template/footer.php"; ?>