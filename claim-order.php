<?php
$pageTitle = "Claim Order";
$includeNavbar = true;
include_once "template/header.php";
require_once "server/repository/OrderDetailRepository.php";
require_once "server/repository/ClaimSlipRepository.php";

$orderDetailRepository = new OrderDetailRepository();

if (isset($_GET['orderID'])) {
    $currentOrderID = $_GET['orderID'];
    $currentOrderDetail = $orderDetailRepository->get($currentOrderID);
    
    if ($currentOrderDetail == false) {
        header("Location: order.php");
        die();
    }
        
}
else {
    header("Location: order.php");
    die();
}
?>
<h1>Claim Order#<?php echo $currentOrderID?></h1>



<?php if($currentOrderDetail->Status != "Completed"): ?>
    <p>Your Order is <?php echo $currentOrderDetail->Status ?> </p>
<?php 
    elseif ($currentOrderDetail->RemainingBalance == 0): 
        $claimSlipRepository = new ClaimSlipRepository();
        $currentClaimSlip = $claimSlipRepository->query("SELECT * FROM ClaimSlips WHERE OrderID = $currentOrderID")[0];
        $currentClaimSlip->DateClaimed = date('Y-m-d H:i:s');
        $claimSlipRepository->update($currentClaimSlip);
?>
    <p>Order Claimed Successfully</p>
<?php else: ?>
    <p>You have Remaining Balance. <a href="pay-order.php?orderID=<?php echo $currentOrderID?>">Pay Here</a></p>
<?php endif; ?>




<?php include_once "template/footer.php"; ?>