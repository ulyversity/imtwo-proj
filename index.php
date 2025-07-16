<?php
$pageTitle = "Home Page";
$includeNavbar = true;
include_once "template/header.php";
?>

<div class="index-page-background">
<div class="index-outer-div">
<div class="index-inner-div">
<h1 class="welcome-greeting-h1">Welcome!</h1>
<p class="role-title-p">Role:  
    <?php 
        include "server/views/CurrentRoleView.php";
    ?>
</p>
    <!-- TODO: hide when already logged in -->
<button><a href="login.php">login</a></button>  
<form action="server/endpoints/logout_action.php">
    <button>logout</button>
</form>

<!-- TODO: hide when NOT yet logged in -->
<button><a href="dashboard.php">dash</a></button>
</div>
</div>
</div>

<?php include_once "template/footer.php"; ?>