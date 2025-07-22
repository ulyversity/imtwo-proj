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

<main id="wrapper">
    <h1>ANALYTICS</h1>

    <div class="analytics-group-container">
        <h2 class="analytics-group-header">Sales Overview</h2>
        <div class="analytics-group-stat-container">
            <div class="analytics-stat-container">
                <span class="analytics-stat-text">₱ <?php echo $totalSalesToday ?></span>
                <p>Total Sales Today </p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> ₱ <?php echo $totalSalesThisWeek ?> </span>
                <p>Total Sales This Week </p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text">₱ <?php echo $totalSales ?> </span>
                <p>Total Sales</p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text">₱ <?php echo $totalAmountPaid ?> </span>
                <p>Collection </p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text">₱ <?php echo $remainingBalance ?> </span>
                <p>Remaining Balance </p>
            </div>
            
        </div>
    </div>

    <div class="analytics-group-container">
        <h2 class="analytics-group-header">Orders</h2>
        <div class="analytics-group-stat-container">
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo count($orderList) ?> </span>
                <p>Total Orders </p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo count($notPaidList) ?> </span>
                <p>Not Paid </p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"><?php echo count($partiallyPaidList) ?></span>
                <p>Partially Paid</p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"><?php echo count($fullyPaidList) ?></span>
                <p>Fully Paid</p>
            </div>
            
        </div>
    </div>

    <div class="analytics-group-container">
        <h2 class="analytics-group-header">Services</h2>
        <div class="analytics-group-stat-container">
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo $bestService->Name ?> </span>
                <p>Best Service</p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo count($regularLaundryList) ?></span>
                <p>Regulary Laundry</p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo count($washAndFoldList) ?> </span>
                <p>Wash and Fold</p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo count($dryCleaningList) ?> </span>
                <p>Dry Cleaning</p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo count($ironAndPressList) ?> </span>
                <p>Iron and Press</p>
            </div>
            
        </div>
    </div>

    <div class="analytics-group-container">
        <h2 class="analytics-group-header">Order Status</h2>
        <div class="analytics-group-stat-container">
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo count($pendingOrders) ?> </span>
                <p>Pending</p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo count($inProgressOrders) ?> </span>
                <p>In Progress</p>
            </div>
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo count($completedOrders) ?> </span>
                <p>Completed</p>
            </div>
        </div>
    </div>

    <div class="analytics-group-container">
        <h2 class="analytics-group-header">Misc</h2>
        <div class="analytics-group-stat-container">
            <div class="analytics-stat-container">
                <span class="analytics-stat-text"> <?php echo $maxLoadCount ?> kg</span>
                <p>Heaviest Load Count</p>
            </div>
        </div>
    </div>
</main>

<?php endif; include_once "template/footer.php"; ?>