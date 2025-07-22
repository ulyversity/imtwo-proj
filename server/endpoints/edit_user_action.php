<?php
require_once __DIR__."/../repository/UserRepository.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userRepository = new UserRepository();

    $id         = isset($_POST['ID']) ? (int)$_POST['ID'] : null;
    $roleID     = $_POST['RoleID'] ?? null;
    $firstName  = $_POST['FirstName'] ?? null;
    $lastName   = $_POST['LastName'] ?? null;
    $username   = $_POST['Username'] ?? null;
    $email      = $_POST['Email'] ?? null;
    $password   = $_POST['Password'] ?? null;
    $birthdate  = $_POST['Birthdate'] ?? null;
    $isActive   = isset($_POST['IsActive']) ? true : false;

    if (!$id) {
        header("Location: ../../employee.php?Error=MissingID");
        die();
    }

    $user = $userRepository->get($id);

    if (!$user) {
        header("Location: ../../employee.php?Error=UserNotFound");
        die();
    }

    if (isset($roleID))    $user->RoleID = $roleID;
    if (isset($firstName)) $user->FirstName = $firstName;
    if (isset($lastName))  $user->LastName = $lastName;
    if (isset($username))  $user->Username = $username;
    if (isset($email))     $user->Email = $email;
    if (!empty($password)) $user->Password =$password;
    if (isset($birthdate)) $user->Birthdate = $birthdate;
    if (isset($isActive))  $user->IsActive = $isActive;

    $user->UpdatedAt = date('Y-m-d H:i:s');

    $userRepository->update($user);

    header("Location: ../../employees.php");
}