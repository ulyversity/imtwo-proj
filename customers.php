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

<h1>CUSTOMERS</h1>

<label for="txtName">Search: </label>
<input type="text" id="txtName">    

<table>
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
            
            const firstNameCell = document.createElement('td');
            firstNameCell.textContent = customer.FirstName;
            currentRow.appendChild(firstNameCell);

            const lastNameCell = document.createElement('td');
            lastNameCell.textContent = customer.LastName;
            currentRow.appendChild(lastNameCell);

            const phoneNumberCell = document.createElement('td');
            phoneNumberCell.textContent = customer.PhoneNumber;
            currentRow.appendChild(phoneNumberCell);

            const totalOrdersCell = document.createElement('td');
            totalOrdersCell.textContent = customer.TotalOrders;
            currentRow.appendChild(totalOrdersCell);

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