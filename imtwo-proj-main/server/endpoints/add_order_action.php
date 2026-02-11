<?php
require_once __DIR__."/../repository/OrderRepository.php";
require_once __DIR__."/../repository/ReceiptRepository.php";
require_once __DIR__."/../repository/ClaimSlipRepository.php";
require_once __DIR__."/../repository/ServiceTypeRepository.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ordeRepository = new OrderRepository();
    $receiptRepository = new ReceiptRepository();
    $claimSlipRepository = new ClaimSlipRepository();
    $serviceTypeRepository = new ServiceTypeRepository();

    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $number = trim($_POST['phoneNumber'] ?? '');
    $loadCount = trim($_POST['loadCount'] ?? '');
    $serviceTypeID = trim($_POST['serviceTypeID'] ?? '');
    
    $paid = $_POST['amountPaid'] ?? 0;
    $staffID = $_POST['staffID'] ?? $_SESSION['userID'];

    if ($firstName === '' || $lastName === '' || $number === '' || $loadCount === '' || $serviceTypeID === '')
    {
        header("Location: ../../add-order.php?Error=MissingFields");
        die();
    }

    $currentServiceType = $serviceTypeRepository->get($serviceTypeID);
    $totalAmount = $loadCount * $currentServiceType->ValuePerKG;

    $order = new Order();
    $order->StatusID = 1;
    $order->ServiceTypeID = $serviceTypeID;
    $order->StaffID = $staffID;
    $order->LoadCount = $loadCount;
    $order->TotalAmount = $totalAmount;
    $newOrderID = $ordeRepository->add($order);

    $claimSlip = new ClaimSlip();
    $claimSlip->OrderID = $newOrderID;
    $claimSlip->FirstName = $firstName;
    $claimSlip->LastName = $lastName;
    $claimSlip->PhoneNumber = $number;
    $claimSlipRepository->add($claimSlip);

    if ($paid > 0)
    {
        $balance = max($totalAmount - $paid, 0);

        $receipt = new Receipt();
        $receipt->OrderID = $newOrderID;
        $receipt->Due = $totalAmount;
        $receipt->AmountPaid = $paid;
        $receipt->Balance = $balance;
        $receiptRepository->add($receipt);
    }
    header("Location: ../../order.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Order</title>
<link rel="stylesheet" href="css/styles/add-order.css">

</head>
<body>
 
</body>
</html>