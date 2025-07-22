<?php
$pageTitle = "Employee";
$includeNavbar = true;
include_once "template/header.php";
require_once __DIR__."/server/repository/UserRepository.php";

if ($_SESSION['roleID'] != 1):
    echo "You don't have permission to access this page";
else:

$userRepository = new UserRepository();

$isEditMode = isset($_GET['userID']);
$currentUserID = $isEditMode ? $_GET['userID'] : 0;
$headerTitle = $isEditMode ? "Edit Employee" : "Add Employee";
$currentAction = $isEditMode ? "server/endpoints/edit_user_action.php" : "server/endpoints/add_user_action.php";
$currentUser = $isEditMode ? $userRepository->get($currentUserID) : new User();
$btnText = $isEditMode ? "Edit" : "Add";
?>

<main id="wrapper">
    <h1><?php echo $headerTitle ?></h1>
    <form action="<?php echo $currentAction?>" method="POST" class="form-container">
        <div class="form-input-container">
            <?php if($isEditMode): ?>
                <input type="hidden" name="ID" value="<?php echo $currentUserID ?>">
            <?php endif; ?>

            <div class="form-row">
                <label for="txtFirstName">First Name: </label>
                <input type="text" name="FirstName" id="txtFirstName" value="<?php if ($isEditMode) echo $currentUser->FirstName ?>"  class="generic-txt">
            </div>
            <div class="form-row">
                <label for="txtLastName">Last Name: </label>
                <input type="text" name="LastName" id="txtLastName" value="<?php if ($isEditMode) echo $currentUser->LastName ?>"  class="generic-txt">
            </div>
            <div class="form-row">
                <label for="txtUsernamme">Username: </label>
                <input type="text" name="Username" id="txtUsernamme" value="<?php if ($isEditMode) echo $currentUser->Username ?>"  class="generic-txt">
            </div>
            <div class="form-row">
                <label for="txtEmail">Email: </label>
                <input type="text" name="Email" id="txtEmail" value="<?php if ($isEditMode) echo $currentUser->Email ?>"  class="generic-txt">
            </div>

            <div class="form-row">
                <label for="txtPassword">Password: </label>
                <input type="password" name="Password" id="txtPassword" value="<?php if ($isEditMode) echo $currentUser->Password ?>"  class="generic-txt">
            </div>

            <div class="form-row">
                <label for="dateBirthday">Birthday:</label>
                <input type="date" id="dateBirthday" name="Birthdate" value="<?php if ($isEditMode && !empty($currentUser->Birthdate)) echo $currentUser->Birthdate ?>">
            </div>

            <div class="form-row">
                <label for="checkIsActive">Is Active:</label>
                <input type="checkbox" id="checkIsActive" name="IsActive" value="IsActive" <?php if ($isEditMode && $currentUser->IsActive) echo "checked='checked'" ?>>
            </div>

            <div class="form-row">
                <label for="cmbRole">Role:</label>
                <select id="cmbRole" name="RoleID">
                    <option value="1" <?php if ($isEditMode && $currentUser->RoleID === 1) echo "selected" ?>>Admin</option>
                    <option value="2" <?php if ($isEditMode && $currentUser->RoleID === 2) echo "selected" ?>>Staff</option>
                    <option value="3" <?php if ($isEditMode && $currentUser->RoleID === 3) echo "selected" ?>>Analyst</option>
                </select>
            </div>
        </div>
        <button class="generic-btn"><?php echo $btnText ?></button>
    </form>
</main>

<?php endif; include_once "template/footer.php"; ?>