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

    $name = trim($_POST['name'] ?? '');
    $number = trim($_POST['number'] ?? '');
    $loadCount = trim($_POST['load'] ?? '');
    $serviceTypeID = trim($_POST['serviceTypeID'] ?? '');
    
    $paid = $_POST['paid'] ?? 0;
    $staffID = $_POST['staffID'] ?? $_SESSION['userID'];
    $amount = $_POST['amount'] ?? 0;
    $balance = $_POST['balance'] ?? 0;

    if ($name === '' || $number === '' || $loadCount === '' || $serviceTypeID === '')
    {
        header("Location: ../../order.php?Error=MissingFields");
        die();
    }

    if ($amount === 0)
    {
        $currentServiceType = $serviceTypeRepository->get($serviceTypeID);
        $amount = $loadCount * $currentServiceType->ValuePerKG;
    }

    $order = new Order();
    $order->StatusID = 1;
    $order->ServiceTypeID = $serviceTypeID;
    $order->StaffID = $staffID;
    $order->LoadCount = $loadCount;
    $order->TotalAmount = $amount;
    $newOrderID = $ordeRepository->add($order);

    $name = explode(" ", $name);
    # REFACTOR: this will throw an error or yield unexpected result when array length != 2;
    $firstName = $name[0];
    $lastName = $name[1];

    $claimSlip = new ClaimSlip();
    $claimSlip->OrderID = $newOrderID;
    $claimSlip->FirstName = $firstName;
    $claimSlip->LastName = $lastName;
    $claimSlip->PhoneNumber = $number;
    $claimSlipRepository->add($claimSlip);


    if ($paid > 0)
    {
        if ($balance === 0)
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