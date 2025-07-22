<?php
require_once __DIR__."/../repository/UserRepository.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roleID     = $_POST['RoleID'] ?? null;
    $firstName  = $_POST['FirstName'] ?? null;
    $lastName   = $_POST['LastName'] ?? null;
    $username   = $_POST['Username'] ?? null;
    $email      = $_POST['Email'] ?? null;
    $password   = $_POST['Password'] ?? null;
    $birthdate  = $_POST['Birthdate'] ?? null;
    $isActive   = isset($_POST['IsActive']) ? true : false;

    if (!$roleID || !$firstName || !$lastName || !$username || !$email || !$password) {
        header("Location: ../../employee.php?Error=MissingFields");
        die();
    }
    
    $userRepository = new UserRepository();

    $user = new User();
    $user->RoleID = $roleID;
    $user->FirstName = $firstName;
    $user->LastName = $lastName;
    $user->Username = $username;
    $user->Email = $email;
    $user->Password = $password;
    $user->Birthdate = !$birthdate ? date('Y-m-d H:i:s') : $birthdate;
    $user->CreatedAt = date('Y-m-d H:i:s');
    $user->IsActive = $isActive;

    $userRepository->add($user);
    header("Location: ../../employees.php");
}
