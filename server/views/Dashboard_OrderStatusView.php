<?php
require_once __DIR__."/../repository/OrderRepository.php";
$orderRepository = new OrderRepository();

$orderList = $orderRepository->getAll();

$pendingOrders = array_values(array_filter($orderList, fn($order) => $order->StatusID === 1));
$inProgressOrders = array_values(array_filter($orderList, fn($order) => $order->StatusID === 2));
$completedOrders = array_values(array_filter($orderList, fn($order) => $order->StatusID === 3));
?>


<p>Pending Orders: <?php echo count($pendingOrders) ?></p>
<p>In Progress Orders: <?php echo count($inProgressOrders) ?></p>
<p>Completed Orders: <?php echo count($completedOrders) ?></p>