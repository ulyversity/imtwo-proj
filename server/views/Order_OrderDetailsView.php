<?php
require_once __DIR__."/../repository/OrderDetailRepository.php";

$orderDetailRepository = new OrderDetailRepository();
$orderDetails = $orderDetailRepository->getOrderDetails();
?>

<table>
    <thead>
        <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Customer Number</th>
            <th>Status</th>
            <th>Load Count</th>
            <th>Total</th>
            <th>Remaining Balance</th>
            <th>Services</th>
            <th>Staff</th>
            <th>Date Due</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orderDetails as $orders): ?>
            <tr>
                <?php foreach ($orders as $value): ?>
                    <td> <?php echo $value ?> </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

