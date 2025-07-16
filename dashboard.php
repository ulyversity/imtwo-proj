<?php
$pageTitle = "Dashboard";
$includeNavbar = true;
include_once "template/header.php";
?>


<div class="top-bar-div"><p>testing</p></div>
<div class="two-block-div">
    <?php
    include "server/views/Dashboard_OrderStatusView.php";
    include "server/views/Dashboard_SupplyListView.php";
    ?>
</div>
    
<?php include_once "template/footer.php"; ?>