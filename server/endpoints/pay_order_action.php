<?php
require_once __DIR__."/../repository/OrderRepository.php";
require_once __DIR__."/../repository/ReceiptRepository.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $orderID = ($_POST['orderID'] ?? '');
    $remainingBalance = ($_POST['remainingBalance'] ?? '');
    $paid = $_POST['amountPaid'] ?? 0;

    $orderRepository = new OrderRepository();
    $currentOrder = $orderRepository->get($orderID);


    if($orderID === '' || $currentOrder == false || $remainingBalance === '')
    {
        header("Location:../../index.php");
        die();
    }
        

    if ($paid < 0)
    {
        header("Location:../../pay-order.php?orderID=$orderID&Error=InvalidAmountPaid");
        die();
    }   
        

    $receiptRepository = new ReceiptRepository();

    if ($paid > $remainingBalance)
        $paid = $remainingBalance;


    $receipt = new Receipt();
    $receipt->OrderID = $orderID;
    $receipt->AmountPaid = $paid;
    $receiptRepository->add($receipt);

    header("Location: ../../view-order.php?orderID=$orderID");
}