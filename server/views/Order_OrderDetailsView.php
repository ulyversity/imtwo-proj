<?php
require_once __DIR__."/../repository/OrderDetailRepository.php";

$orderDetailRepository = new OrderDetailRepository();
$orderDetails = $orderDetailRepository->getAll();
?>

<table class="order-list-table">
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
            <th>Is Claimed</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orderDetails as $orders): ?>
            <tr>
                <?php foreach ($orders as $key => $value): ?>
                <td>
                    <?php if($key === "ID"): ?>
                        <a href='view-order.php?orderID=<?php echo$value ?>'> <?php echo $value ?></a>
                    <?php elseif($key === "DateClaimed" && $value !== ''): echo "✔️";?>
                    <?php else: echo $value; endif;?>
                </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

