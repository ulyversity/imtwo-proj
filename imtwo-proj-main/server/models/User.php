<?php
declare(strict_types=1);

class User {
    public string $TableNameAlias = "users";

    public int $ID;
    public int $RoleID;
    public string $FirstName;
    public string $LastName;
    public string $Username;
    public string $Email;
    public string $Password;
    public string $Birthdate;
    public bool $IsActive;
    public string $CreatedAt;
    public string $UpdatedAt;

    public function __construct(array $data = null)
    {
        if ($data === null)
            return;

        $this->ID = (int) $data['ID'];
        $this->RoleID = (int) $data['RoleID'];
        $this->FirstName = $data['FirstName'];
        $this->LastName = $data['LastName'];
        $this->Username = $data['Username'];
        $this->Email = $data['Email'];
        $this->Password = $data['Password'];
        $this->Birthdate = $data['Birthdate'];
        $this->IsActive = (bool) $data['IsActive'];
        $this->CreatedAt = $data['CreatedAt'];
        $this->UpdatedAt = $data['UpdatedAt'];
    }
}