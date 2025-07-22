<?php
$pageTitle = "Pay Order";
$includeNavbar = true;
include_once "template/header.php";
require_once "server/repository/OrderDetailRepository.php";

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



<h1>PAY FOR ORDER#<?php echo $currentOrderID; ?></h1>
<form action="server/endpoints/pay_order_action.php" method="POST">
    <input type="hidden" name="orderID" value="<?php echo $currentOrderID ?>">
    <label for="txtTotalAmount">Total: </label>
    <input type="text" name="total" id="txtTotalAmount" value="<?php echo $currentOrderDetail->Total ?>"  class="generic-txt" readonly>
    <label for="txtRemaningBalance">Remaining Balance: </label>
    <input type="text" name="remainingBalance" id="txtRemaningBalance" value="<?php echo $currentOrderDetail->RemainingBalance ?>"  class="generic-txt" readonly>
    <label for="txtAmount">Amount: </label>
    <input type="text" name="amountPaid" id="txtAmount" class="generic-txt">

    <?php if ($currentOrderDetail->RemainingBalance > 0): ?>
        <button class="generic-btn">Pay</button>
    <?php else: ?>
        <a href="view-order.php?orderID=<?php echo $currentOrderID?>" class="generic-btn">Back</a>
    <?php endif; ?>
</form>

<p>Remarks:  
<?php if ($currentOrderDetail->RemainingBalance == 0)
    echo "Fully Paid";
elseif ($currentOrderDetail->RemainingBalance == $currentOrderDetail->Total)
    echo "Not Paid";
else
    echo "Partially Paid"; 
?>
</p>



<?php include_once "template/footer.php"; ?>