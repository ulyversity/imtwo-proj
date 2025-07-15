<?php

if(isset($_SESSION['roleID']))
{
    require_once __DIR__."/../repository/RoleRepository.php";

    $roleRepository = new RoleRepository();
    $currentRole = $roleRepository->get($_SESSION['roleID']);
    echo "$currentRole->Name";
}
else {
    echo "VISITOR";
}
