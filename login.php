<?php
$pageTitle = "Login";
$includeNavbar = false;
$additionalHeaderOptions = "<link rel='preload' href='assets/washing-machine.jpg' as='image' fetchpriority='high'>";
include_once "template/header.php";

if (isset($_SESSION['userID']))
    header("Location: index.php");
?>


<div class="login-page-background">
<div class="login-outer-div">
<div class="login-inner-div">
    <form action="server/endpoints/login_action.php" method="POST">
        <label for="txtUsername">Username:</label>
        <input type="text" name="username" id="txtUsername">
        <label for="txtPassword">Password:</label>
        <input type="password" name="password" id="txtPassword">
        <button>login</button>
    </form>
</div>
</div>
</div>

<?php include_once "template/footer.php"; ?>