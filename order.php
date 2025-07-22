<?php
$pageTitle = "Orders";
$includeNavbar = true;
include_once "template/header.php";

require_once __DIR__."/server/repository/OrderDetailRepository.php";

$orderDetailRepository = new OrderDetailRepository();
$orderDetails = $orderDetailRepository->getAll();


?>
<script>
    let orderStatus = <?php echo isset($_GET['orderStatus']) ? $_GET['orderStatus'] :  "''";?>;
    let customerName = <?php echo isset($_GET['customerName']) ? "'$_GET[customerName]'" : "''";?>;

    const orderDetailList = <?php echo json_encode($orderDetails) ?>;
</script>

<main id="wrapper">
    <h1>ORDERS</h1>

    <div class="filter-container">
        <label for="txtSearchNameOrNumber">Search:</label>
        <input type="text" id="txtSearchNameOrNumber" class="generic-txt" placeholder="Name or Number">

        <label for="cmbOrderStatus">Order Status:</label>
        <select name="cmbOrderStatus" id="cmbOrderStatus" class="generic-cmb">
            <option value="0">All</option>
            <option value="1">Pending</option>
            <option value="2">Ongoing</option>
            <option value="3">Completed</option>
        </select>

        <label for="cmbClaimStatus">Claim:</label>
        <select name="cmbClaimStatus" id="cmbClaimStatus" class="generic-cmb">
            <option value="0">All</option>
            <option value="1">Claimed</option>
            <option value="2">Not Claimed</option>
        </select>

        <label for="cmbPaymentStatus">Payment:</label>
        <select name="cmbPaymentStatus" id="cmbPaymentStatus" class="generic-cmb">
            <option value="0">All</option>
            <option value="1">Fully Paid</option>
            <option value="2">Partially Paid</option>
            <option value="2">Not Paid</option>
        </select>

        <label for="txtHandledBy">Handled By:</label>
        <input type="text" id="txtHandledBy" class="generic-txt" placeholder="Employee Name">
        <button id="btn-reset" class="generic-btn zero-margin">Reset Filter</button>
    </div>

    <table class="generic-table order-list-table ">
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
        <tbody id="order-table-body">
        </tbody>
    </table>
    <a class="generic-btn" href="add-order.php">ADD ORDER</a>
</main>

<script>
    if (orderStatus !== '')
        cmbOrderStatus.selectedIndex = orderStatus;

    if (customerName !== '')
        txtSearchNameOrNumber.value = customerName;

    document.getElementById("txtSearchNameOrNumber").addEventListener('keyup', (event)=> {
        filterList();
    });
    document.getElementById("cmbOrderStatus").addEventListener('change', (event) => {
        filterList();
    });
    document.getElementById("cmbClaimStatus").addEventListener('change', (event) => {
        filterList();
    });
    document.getElementById("cmbPaymentStatus").addEventListener('change', (event) => {
        filterList();
    });
    document.getElementById("txtHandledBy").addEventListener('keyup', (event)=> {
        filterList();
    });

    document.getElementById("btn-reset").addEventListener('click', (event) => {
        const txtSearchNameOrNumber = document.getElementById("txtSearchNameOrNumber");
        const cmbOrderStatus = document.getElementById("cmbOrderStatus");
        const cmbClaimStatus = document.getElementById("cmbClaimStatus");
        const cmbPaymentStatus = document.getElementById("cmbPaymentStatus");
        const txtHandledBy = document.getElementById("txtHandledBy");

        txtSearchNameOrNumber.value = "";
        cmbOrderStatus.selectedIndex = 0;
        cmbClaimStatus.selectedIndex = 0;
        cmbPaymentStatus.selectedIndex = 0;
        txtHandledBy.value = "";

        populateTable(orderDetailList);
    });

    function populateTable(curOrderDetailList)
    {
        const orderTableBody = document.getElementById("order-table-body");
        orderTableBody.innerHTML = '';
        for (const orderDetail of curOrderDetailList)
        {
            const currentRow = document.createElement('tr');
            for (const [key, value] of Object.entries(orderDetail))
            {
                const currentCell = document.createElement('td');   
                if (key == "ID")
                    currentCell.innerHTML = `<a href='view-order.php?orderID=${value}' class='generic-a'>${value}</a>`
                else if (key == "DateClaimed" && value !== "")
                    currentCell.textContent ="✔️" ;
                else
                    currentCell.textContent = value;
                currentRow.appendChild(currentCell);
            }
            orderTableBody.appendChild(currentRow);
        }
    }

    function filterList()
    {
        let filteredList = orderDetailList;
        const txtSearchNameOrNumber = document.getElementById("txtSearchNameOrNumber");
        const cmbOrderStatus = document.getElementById("cmbOrderStatus");
        const cmbClaimStatus = document.getElementById("cmbClaimStatus");
        const cmbPaymentStatus = document.getElementById("cmbPaymentStatus");
        const txtHandledBy = document.getElementById("txtHandledBy");

        if (txtSearchNameOrNumber.value.length > 1)
        {
            let value = txtSearchNameOrNumber.value;
            filteredList = filteredList.filter(o=>o.Customer.includes(value) || o.CustomerNumber.includes(value));
        }

        let cmbOrderStatusSelectedText = getComboBoxText(cmbOrderStatus);
        if (cmbOrderStatusSelectedText !== "All")
        {
            filteredList = filteredList.filter(o=>o.Status ==cmbOrderStatusSelectedText);
        }

        let cmbClaimStatusSelectedText = getComboBoxText(cmbClaimStatus);
        if (cmbClaimStatusSelectedText !== "All")
        {
            if (cmbClaimStatusSelectedText === "Claimed")
            {
                filteredList = filteredList.filter(o=>o.DateClaimed !== "");
            }
            else if (cmbClaimStatusSelectedText === "Not Claimed")
            {
                filteredList = filteredList.filter(o=>o.DateClaimed === "");
            }
            
        }

        let cmbPaymentStatusSelectedText = getComboBoxText(cmbPaymentStatus);
        if (cmbPaymentStatusSelectedText !== "All")
        {
            if (cmbPaymentStatusSelectedText === "Fully Paid")
            {
                filteredList = filteredList.filter(o=>o.RemainingBalance === 0);
            }
            else if (cmbPaymentStatusSelectedText === "Partially Paid")
            {
                filteredList = filteredList.filter(o=>o.RemainingBalance > 0 && o.RemainingBalance !== o.Total);
            }
            else if (cmbPaymentStatusSelectedText === "Not Paid")
            {
                filteredList = filteredList.filter(o=>o.RemainingBalance === o.Total);
            }
            
        }

        if (txtHandledBy.value.length > 1)
        {
            let value = txtHandledBy.value;
            console.log(value);
            filteredList = filteredList.filter(o=>o.Staff.includes(value));
        }

        populateTable(filteredList);
    }

    function getComboBoxText(cmb){
        return cmb.options[cmb.selectedIndex].text;
    }
    
    filterList();
</script>
<?php include_once "template/footer.php"; ?>