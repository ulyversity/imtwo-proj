<?php
$pageTitle = "Manage Supply";
$includeNavbar = true;
include_once "template/header.php";

require_once __DIR__."/server/repository/SupplyRepository.php";
$supplyRepository = new SupplyRepository();

if (!isset($_GET['supplyID'])) {
    header("Location: supplies.php?Error=MissingID");
    die();
}
$currentSupplyID = $_GET['supplyID'];
$currentSupply = $supplyRepository->get($currentSupplyID);

if($currentSupply == false)
{
    header("Location: supplies.php?Error=UserNotFound");
    die();
}

?>

<main id="wrapper">
    <h1><?php echo $currentSupply->Name ?></h1>
    <form action="server/endpoints/edit_supply_quantity_action.php" method="POST" class="form-container">
        <div class="form-input-container">
            <input type="hidden" name="ID" value="<?php echo $currentSupplyID ?>">
            <div class="form-row">
                <label for="txtQuantity">Quantity: </label>
                <input type="text" name="Quantity" id="txtQuantity" value="<?php echo $currentSupply->Quantity ?>"  class="generic-txt">
            </div>
        </div>
        <button class="generic-btn">CONFIRM</button>
    </form>
</main>

<?php include_once "template/footer.php"; ?>