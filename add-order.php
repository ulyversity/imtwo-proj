<?php
$pageTitle = "Add Order";
$includeNavbar = true;
include_once "template/header.php";
?>

<main id="wrapper">
    <h1>ADD ORDER</h1>
    <form action="server/endpoints/add_order_action.php" method="POST" class="form-container">
        <div class="form-input-container">
            <div class="form-row">
                <label for="txtFirstName">Firstname: </label>
                <input type="text" id="txtFirstName" class="generic-txt" name="firstName">
            </div>

            <div class="form-row">
                <label for="txtLastName">Lastname: </label>
                <input type="text" id="txtLastName" class="generic-txt" name="lastName">
            </div>

            <div class="form-row">
                <label for="txtPhoneNumber">Phone Number:</label>
                <input type="text" id="txtPhoneNumber" class="generic-txt" name="phoneNumber">
            </div>

            <div class="form-row">
                <label for="numLoadCount">Load Count:</label>
                <input type="number" id="numLoadCount" class="generic-txt" name="loadCount" min="3" value="3"><span>KG</span>
            </div>

            <div class="form-row">
                <label for="cmbService">Service:</label>
                <select name="serviceTypeID" id="cmbService" class="generic-cmb">
                    <?php require "server/views/ServiceTypesDropDownView.php"; ?>
                </select>
            </div>

            <div class="form-row">
                <label for="txtTotalAmount">Total Amount</label>
                <input type="text" id="txtTotalAmount" class="generic-txt" readonly>
            </div>

            <div class="form-row">
                <label for="txtAmountPaid">Amount Paid:</label>
                <input type="text" id="txtAmountPaid" class="generic-txt" name="amountPaid" value="0">
            </div>

            <div class="form-row">
                <label for="txtBalance">Balance:</label>
                <input type="text" id="txtBalance" class="generic-txt" value="0" readonly>
            </div>
        </div>
        <button class="generic-btn">SEND</button>
    </form>
</main>

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