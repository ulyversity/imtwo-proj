<?php
require_once __DIR__."/../repository/SupplyRepository.php";

$supplyRepository = new SupplyRepository();
$supplyList = $supplyRepository->getAll();
?>

<div class="supply-list-outer-div">
<div class="supply-list-title-div">
    <p class="supply-list-title-p">SupplyList:</p>
</div>

<div class="supply-list-inner-div">
<?php foreach($supplyList as $supply): ?>
    <span class="supply-name-span"><?php echo $supply->Name ?></span> 
    <span class='supply-quantity-span'>
        <?php 
            $quantity = $supply->Quantity; 
            if ($quantity > 5)
                echo "<p class='supply-quantity-p'>In Stock</p>";
            else if ($quantity > 0)
                echo "<p class='supply-quantity-p'>Low Stock</p>";
            else
                echo "<p class='supply-quantity-p'>No Stock</p>";
        ?>
    </span>
    <br>
<?php endforeach ?>
</div>
</div>