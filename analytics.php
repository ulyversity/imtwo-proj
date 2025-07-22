<?php
$pageTitle = "Analytics";
$includeNavbar = true;
include_once "template/header.php";
if ($_SESSION['roleID'] == 2):
    echo "You don't have permission to access this page";
else:
    require_once __DIR__."/server/repository/OrderRepository.php";
    require_once __DIR__."/server/repository/ServiceTypeRepository.php";

    $orderRepository = new OrderRepository();
    $serviceTypeRepository = new ServiceTypeRepository();

    $orderList = $orderRepository->getAll();
    $totalSales = $orderRepository->getTotalSales();
    $totalSalesThisWeek = $orderRepository->getTotalSalesThisWeek();
    $totalSalesToday = $orderRepository->getTotalSalesToday() ?? '0';
    $remainingBalance = $orderRepository->getRemainingBalance();
    $totalAmountPaid = $orderRepository->getTotalAmountPaid();
    
    $orderReceiptList = $orderRepository->getOrderReceipts();
    $notPaidList = array_values(array_filter($orderReceiptList, fn($orderReceipt) => $orderReceipt->AmountPaid == null));
    $partiallyPaidList = array_values(array_filter($orderReceiptList, fn($orderReceipt) => $orderReceipt->AmountPaid != null && $orderReceipt->TotalAmount != $orderReceipt->AmountPaid));
    $fullyPaidList = array_values(array_filter($orderReceiptList, fn($orderReceipt) => $orderReceipt->TotalAmount == $orderReceipt->AmountPaid));

    $regularLaundryList = array_values(array_filter($orderList, fn($order) => $order->ServiceTypeID === 1));
    $washAndFoldList = array_values(array_filter($orderList, fn($order) => $order->ServiceTypeID === 2));
    $dryCleaningList = array_values(array_filter($orderList, fn($order) => $order->ServiceTypeID === 3));
    $ironAndPressList = array_values(array_filter($orderList, fn($order) => $order->ServiceTypeID === 4));
    $orderServicesList= array();
    array_push($orderServicesList, $regularLaundryList, $washAndFoldList, $dryCleaningList, $ironAndPressList);

    $highestOrderServiceTypeID = 1;
    $highestOrderServicesCounter = 0;
    foreach($orderServicesList as $orderPerServiceList) {
        if (count($orderPerServiceList) > $highestOrderServicesCounter) {
            $highestOrderServiceTypeID = $orderPerServiceList[0]->ServiceTypeID;
            $highestOrderServicesCounter = count($orderPerServiceList);
        }
    }
    $bestService = $serviceTypeRepository->get($highestOrderServiceTypeID);
    
    $pendingOrders = array_values(array_filter($orderList, fn($order) => $order->StatusID === 1));
    $inProgressOrders = array_values(array_filter($orderList, fn($order) => $order->StatusID === 2));
    $completedOrders = array_values(array_filter($orderList, fn($order) => $order->StatusID === 3));

    $maxLoadCount = $orderRepository->getMaxLoadCounttOrder();
?>

<h1>ANALYTICS</h1>
<h2>Sales Overview</h2>
<p>Total Sales Today: ₱ <?php echo $totalSalesToday ?></p>
<p>Total Sales This Week: ₱ <?php echo $totalSalesThisWeek ?></p>
<p>Total Sales: ₱ <?php echo $totalSales ?></p>
<p>Collection: ₱ <?php echo $totalAmountPaid ?></p>
<p>Remaining Balance: ₱ <?php echo $remainingBalance ?></p>

<h2>Orders</h2>
<p>Total Orders: <?php echo count($orderList) ?></p>
<p>Not Paid: <?php echo count($notPaidList) ?></p>
<p>Partially Paid: <?php echo count($partiallyPaidList) ?></p>
<p>Fully Paid: <?php echo count($fullyPaidList) ?></p>

<h2>Services</h2>
<p>Best Service: <?php echo $bestService->Name ?></p>
<p>Regular Laundry: <?php echo count($regularLaundryList) ?></p>
<p>Wash and Fold: <?php echo count($washAndFoldList) ?></p>
<p>Dry Cleaning: <?php echo count($dryCleaningList) ?></p>
<p>Iron and Press: <?php echo count($ironAndPressList) ?></p>

<h2>Order Status</h2>
<p>Pending Orders: <?php echo count($pendingOrders) ?></p>
<p>In Progress Orders: <?php echo count($inProgressOrders) ?></p>
<p>Completed Orders: <?php echo count($completedOrders) ?></p>

<h2>Misc</h2>
<p>Highest kg order: <?php echo $maxLoadCount ?>kg</p>

<h2>Supplies</h2>

<?php endif; include_once "template/footer.php"; ?>