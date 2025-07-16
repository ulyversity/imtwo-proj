<?php
$pageTitle = "Add Order";
$includeNavbar = true;
include_once "template/header.php";
?>
<h1>Add Order</h1>


<form action="server/endpoints/add_order_action.php" method="POST">
    <label for="txtFirstName">Firstname: </label>
    <input type="text" id="txtFirstName" name="firstName">

    <label for="txtLastName">Lastname: </label>
    <input type="text" id="txtLastName" name="lastName">

    <label for="txtPhoneNumber">Phone Number:</label>
    <input type="text" id="txtPhoneNumber" name="phoneNumber">

    <label for="numLoadCount">Load Count:</label>
    <input type="number" id="numLoadCount" name="loadCount" min="3" value="3"><span>KG</span>

    <label for="cmbService">Service:</label>
    <select name="serviceTypeID" id="cmbService">
        <?php require "server/views/ServiceTypesDropDownView.php"; ?>
    </select>

    <label for="txtTotalAmount">Total Amount</label>
    <input type="text" id="txtTotalAmount" readonly>
    
    <label for="txtAmountPaid">Amount Paid:</label>
    <input type="text" id="txtAmountPaid" name="amountPaid" value="0">

    <label for="txtBalance">Balance:</label>
    <input type="text" id="txtBalance" value="0" readonly>

    <button>SEND</button>
    
</form>

<script>
    let loadCount = 3;
    let amountMultiplier = 60;
    
    const txtTotalAmount = document.getElementById('txtTotalAmount');
    const txtAmountPaid = document.getElementById('txtAmountPaid');
    const txtBalance = document.getElementById('txtBalance');
    const numLoadCount = document.getElementById('numLoadCount');
    const cmbService = document.getElementById('cmbService');

    cmbService.addEventListener('change', (event) => {
        const selectedOption = cmbService.options[cmbService.selectedIndex];
        amountMultiplier = selectedOption.dataset.value;
        changeTotalAmount();
    });
    
    numLoadCount.addEventListener('change', (event) => {
        loadCount = event.target.value;
        changeTotalAmount();
    });


    txtAmountPaid.addEventListener('keyup', (event) => {
        changeBalanceAmount();
    });

    function changeTotalAmount() {
        txtTotalAmount.value = loadCount * amountMultiplier;
        txtAmountPaid.value = 0;
        changeBalanceAmount();
    }
    function changeBalanceAmount() {
        txtBalance.value = txtTotalAmount.value - txtAmountPaid.value;
    }
    changeTotalAmount();  
</script>


<?php include_once "template/footer.php"; ?>