<?php
$pageTitle = "View Order";
$includeNavbar = true;
include_once "template/header.php";
require_once "server/repository/OrderDetailRepository.php";
require_once "server/repository/StatusRepository.php";

$orderDetailRepository = new OrderDetailRepository();
$statusRepository = new StatusRepository();

if (isset($_GET['orderID'])) 
{
    $currentOrderID = $_GET['orderID'];
    $currentOrderDetail = $orderDetailRepository->get($currentOrderID);
    
    if ($currentOrderDetail == false)
    {
        header("Location: order.php");
        die();
    }
        
}
else {
    header("Location: order.php");
    die();
}
    
$statusRepository = new StatusRepository();
$currentStatus = $statusRepository->query("SELECT * FROM Status WHERE Name = '$currentOrderDetail->Status';")[0];

?>

<main id="wrapper">
    <div class="view-order-header-container">
        <h1>ORDER ID#<?php echo $currentOrderID ?> - <?php echo "$currentOrderDetail->Customer $currentOrderDetail->CustomerNumber"?></h1>
        <h2 class="view-order-status">Status: <?php echo $currentOrderDetail->Status ?></h2>
    </div>

    <h3>Total: <?php echo $currentOrderDetail->Total ?> </h3>
    <h3>Remaining Balance: <?php echo $currentOrderDetail->RemainingBalance ?> </h3>
    <h3>Is Claimed: <?php echo empty($currentOrderDetail->DateClaimed) ? "No" : "Yes" ?> </h3>

    <p>Service Type: <?php echo $currentOrderDetail->Services ?></p>
    <p>Load Count: <?php echo $currentOrderDetail->LoadCount ?> </p>
    <p>Date Due: <?php echo $currentOrderDetail->DateDue ?> </p>
    <p>Handled By: <?php echo $currentOrderDetail->Staff ?> </p>

    <a href="pay-order.php?orderID=<?php echo $currentOrderID?>" ><button class="generic-btn">Pay Order</button></a>
    <a href="claim-order.php?orderID=<?php echo $currentOrderID?>"><button class="generic-btn">Claim Order</button></a>


    <h2>Change Status</h2>
    <form action="server/endpoints/change_order_status_action.php" method="POST">
        <input type="hidden" name="orderID" value="<?php echo $currentOrderID ?>">
        <label for="cmbStatus">Current Status:</label>
        <select name="statusID" id="cmbStatus" class="generic-cmb">
            <?php require "server/views/StatusDropDownView.php"; ?>
        </select>
        <button class="generic-btn">Change</button>
    </form>
</main>

<script>
    const cmbStatus = document.getElementById("cmbStatus");
    cmbStatus.value = <?php echo $currentStatus->ID ?>;
</script>

<?php include_once "template/footer.php"; ?>