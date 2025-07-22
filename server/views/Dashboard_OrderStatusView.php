<?php
require_once __DIR__."/../repository/OrderRepository.php";
$orderRepository = new OrderRepository();

$orderList = $orderRepository->getAll();

$pendingOrders = array_values(array_filter($orderList, fn($order) => $order->StatusID === 1));
$inProgressOrders = array_values(array_filter($orderList, fn($order) => $order->StatusID === 2));
$completedOrders = array_values(array_filter($orderList, fn($order) => $order->StatusID === 3));
?>

<div class="pending-order-div">
    <h2 class="pending-order-p"><a href="http://localhost/im-two-project/order.php?orderStatus=1" class="generic-a">Pending Orders: <?php echo count($pendingOrders) ?></a></h2>
    <h2 class="pending-order-p"><a href="http://localhost/im-two-project/order.php?orderStatus=2" class="generic-a">In Progress Orders: <?php echo count($inProgressOrders) ?></a></h2>
    <h2 class="pending-order-p"><a href="http://localhost/im-two-project/order.php?orderStatus=3" class="generic-a">Completed Orders: <?php echo count($completedOrders) ?></a></h2>
</div>
