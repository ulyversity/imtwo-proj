<?php
require_once __DIR__."/../repository/SupplyRepository.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplyRepository = new SupplyRepository();

    $id         = $_POST['ID'] ?? null;
    $quantity  = isset($_POST['Quantity']) ? (int) $_POST['Quantity'] : null;

    if ($id == null || !$id) {
        header("Location: ../../supplies.php?Error=MissingID");
        die();
    }

    $currentSupply = $supplyRepository->get($id);

    if (!$currentSupply) {
        header("Location: ../../supplies.php?Error=SupplyNotFound");
        die();
    }

    if($quantity === null || $quantity === false|| $quantity < 0) {
        header("Location: ../../supplies.php?Error=InvalidQuantity");
        die();
    }

    $currentSupply->Quantity = $quantity;
    $supplyRepository->update($currentSupply);

    header("Location: ../../supplies.php");
}