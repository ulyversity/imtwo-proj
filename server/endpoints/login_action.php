<?php
declare(strict_types=1);
require_once __DIR__."/../repository/UserRepository.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $UserRepository = new UserRepository();
    $error = "";

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '')
    {
        header("Location: ../../index.php?Error=MissingFields");
    }

    $userFound = $UserRepository->query("SELECT * FROM Users WHERE (username = '$username' OR email = '$username') AND password = '$password'");

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
}