<?php
$pageTitle = "Employees";
$includeNavbar = true;
include_once "template/header.php";

require_once __DIR__."/server/repository/UserRepository.php";
$userRepository = new UserRepository();
$userList = $userRepository->getAll();
?>

<main id="wrapper">
    <h1>EMPLOYEES</h1>
    <table class="generic-table employees-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Role</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Birthdate</th>
                <th>Is Active</th>
            </tr>
        </thead>
        <tbody id="employees-table-body">
            <?php foreach($userList as $user):?>
                <tr>
                    <?php foreach($user as $key => $value): 
                        if ($key === "TableNameAlias" || $key === "Password" || $key === "CreatedAt" || $key === "UpdatedAt") continue;?>
                        <td>
                        <?php 
                            if ($key === "ID")
                                echo "<a href='employee.php?userID=$value' class='generic-a'>$value</a>";
                            elseif ($key === "RoleID") {
                                if ($value === 1) echo "Admin";
                                elseif ($value === 2) echo "Staff";
                                elseif ($value === 3) echo "Analyst";
                            }
                            elseif ($key === "IsActive")
                                echo $value ? "Yes" : "No";
                            else echo $value;
                        ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a class="generic-btn" href="employee.php">ADD EMPLOYEE</a>
</main>


<?php include_once "template/footer.php"; ?>