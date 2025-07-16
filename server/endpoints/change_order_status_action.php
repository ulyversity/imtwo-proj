<?php
require_once __DIR__."/../repository/OrderRepository.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderID = ($_POST['orderID'] ?? '');
    $statusID = ($_POST['statusID'] ?? 0);

    if ($orderID === '' || $statusID == 0) {
        header("Location: ../../index.php");
        die();
    }

    $orderRepository = new OrderRepository();
    $order = $orderRepository->get($orderID);
    $order->StatusID = $statusID;

    if ($orderRepository->update($order)){
        header("Location: ../../view-order.php?orderID=$orderID");
    }
    else {
        header("Location: ../../index.php");
    }
    
}