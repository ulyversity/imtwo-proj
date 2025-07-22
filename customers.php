<?php
$pageTitle = "Customers";
$includeNavbar = true;
include_once "template/header.php";

require_once __DIR__."/server/repository/ClaimSlipRepository.php";

$claimSlipRepository = new ClaimSlipRepository();
$customerList = $claimSlipRepository->getUniqueCustomers();
?>
<script>
    const customerList = <?php echo json_encode($customerList) ?>;
</script>

<main id="wrapper">
    <h1>CUSTOMERS</h1>

    <div class="filter-container">
        <label for="txtName">Search: </label>
        <input type="text" id="txtName" class="generic-txt" placeholder="Name or Number">    
    </div>

    <table class="generic-table customer-list-table">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Total Orders</th> 
            </tr>
        </thead>
        <tbody id="customer-table-body">
        </tbody>
    </table>
</main>

<script>

    txtName = document.getElementById("txtName");

    txtName.addEventListener("keyup", (event) =>{
        filterList(txtName.value.length < 2 ? '' : txtName.value);
    });
    
    function populateTable(curCustomerList)
    {
        const customerTableBody = document.getElementById("customer-table-body");
        customerTableBody.innerHTML = '';
        for(const customer of curCustomerList)
        {
            const currentRow = document.createElement('tr');
            for(const [key, value] of Object.entries(customer))
            {
                const curCell = document.createElement('td');
                if (key === "TotalOrders")
                {
                    let name = `${customer.FirstName} ${customer.LastName}`;
                    curCell.innerHTML = `<a href='order.php?customerName=${name}' class='generic-a'>${value}</a>`;
                }
                else 
                    curCell.textContent = value;
                currentRow.appendChild(curCell);
            }
            customerTableBody.appendChild(currentRow);
        }
    }

    function filterList(value)
    {
        let filteredList = customerList;

        filteredList = filteredList.filter(c=>c.FirstName.includes(value) || c.LastName.includes(value) || (c.PhoneNumber !== null && c.PhoneNumber.includes(value)));

        populateTable(filteredList);
    }

    filterList('');
</script>

<?php include_once "template/footer.php"; ?>