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
<h1>Order ID#<?php echo $currentOrderID ?></h1>
<p>Customer Details: <?php echo "$currentOrderDetail->Customer $currentOrderDetail->CustomerNumber"?></p> 
<p>Status: <?php echo $currentOrderDetail->Status ?></p>
<p>Service Type: <?php echo $currentOrderDetail->Services ?></p>
<p>Load Count: <?php echo $currentOrderDetail->LoadCount ?> </p>
<p>Total: <?php echo $currentOrderDetail->Total ?> </p>
<p>Remaining Balance: <?php echo $currentOrderDetail->RemainingBalance ?> </p> <a href=""></a>
<p>Date Due: <?php echo $currentOrderDetail->DateDue ?> </p>
<!-- handled by or something -->
<p>Staff: <?php echo $currentOrderDetail->Staff ?> </p>

<a href="pay-order.php?orderID=<?php echo $currentOrderID?>"><button>Pay Order</button></a>
<a href="claim-order.php?orderID=<?php echo $currentOrderID?>"><button>Claim Order</button></a>


<h2>Change Status</h2>
<form action="server/endpoints/change_order_status_action.php" method="POST">
    <input type="hidden" name="orderID" value="<?php echo $currentOrderID ?>">
    <label for="cmbStatus">Current Status:</label>
    <select name="statusID" id="cmbStatus" >
        <?php require "server/views/StatusDropDownView.php"; ?>
    </select>
    <button>Change</button>
</form>

<script>
    const cmbStatus = document.getElementById("cmbStatus");
    cmbStatus.value = <?php echo $currentStatus->ID ?>;
</script>



<?php include_once "template/footer.php"; ?>