<?php
$pageTitle = "Dashboard";
$includeNavbar = true;
include_once "template/header.php";
?>
<h1>DASHBOARD</h1>

<div class="two-block-div">
    <?php
    include "server/views/Dashboard_OrderStatusView.php";
    include "server/views/Dashboard_SupplyListView.php";
    ?>
</div>
    
<?php include_once "template/footer.php"; ?>