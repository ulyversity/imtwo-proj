<?php
require_once __DIR__."/../repository/OrderRepository.php";
require_once __DIR__."/../repository/ReceiptRepository.php";
require_once __DIR__."/../repository/ClaimSlipRepository.php";

$ordeRepository = new OrderRepository();
$receiptRepository = new ReceiptRepository();
$claimSlipRepository = new ClaimSlipRepository();


$name = $_POST['name'];
$number = $_POST['number'];
$amount = $_POST['amount'];
$paid = $_POST['paid'];
$balance = $_POST['balance'];
$loadCount = $_POST['load'];

$order = new Order();
$order->StaffID = $_SESSION['userID'];

$ordeRepository->add();