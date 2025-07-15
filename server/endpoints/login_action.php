<?php
declare(strict_types=1);
require_once __DIR__."/../repository/UserRepository.php";

$UserRepository = new UserRepository();

$error = "";

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === '' || $password === '')
{
    header("Location: ../../index.php?Error=LackingFields");
}

$userFound = $UserRepository->search("WHERE (username = '$username' OR email = '$username') AND password = '$password'");

if (count($userFound) === 0 ) {
    $error = "IncorrectCredentials";
}

if ($error == '')
{
    $currentUser = $userFound[0];
    $_SESSION['userID'] = $currentUser->ID;
    $_SESSION['roleID'] = $currentUser->RoleID;
    $_SESSION['name'] = "$currentUser->FirstName $currentUser->LastName";
    header("Location: ../../index.php");
}
else {
    header("Location: ../../login.php?Error=".$error);
}