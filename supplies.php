<?php
$pageTitle = "Supplies";
$includeNavbar = true;
include_once "template/header.php";

require_once __DIR__."/server/repository/SupplyRepository.php";
$supplyRepository = new SupplyRepository();
$supplyList = $supplyRepository->getAll();
?>

<main id="wrapper">
    <h1>SUPPLIES</h1>
    <table class="generic-table supplies-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody id="employees-table-body">
            <?php foreach($supplyList as $supply):?>
                <tr>
                    <?php foreach($supply as $key => $value): 
                        if ($key === "TableNameAlias") continue;?>
                        <td>
                        <?php 
                            if ($key === "ID")
                                echo "<a href='edit-supply.php?supplyID=$value' class='generic-a'>$value</a>";
                            else echo $value;
                        ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php include_once "template/footer.php"; ?>