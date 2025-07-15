<?php
require_once __DIR__."/../repository/SupplyRepository.php";

$supplyRepository = new SupplyRepository();
$supplyList = $supplyRepository->getAll();
?>

<p>SupplyList:</p>
<?php foreach($supplyList as $supply): ?>
    <span><?php echo $supply->Name ?></span> 
    <span>
        <?php 
            $quantity = $supply->Quantity; 
            if ($quantity > 5)
                echo "In Stock";
            else if ($quantity > 0)
                echo "Low Stock";
            else
                echo "No Stock";
        ?>
    </span>
    <br>
<?php endforeach ?>