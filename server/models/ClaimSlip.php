<?php
declare(strict_types=1);

class ClaimSlip {
    public string $TableNameAlias = "claimslips";
    public int $ID;
    public int $OrderID;
    public string $FirstName;
    public string $LastName;
    public string $PhoneNumber;
    public string $DateReceived;
    public string $DateDue;
    public string $DateClaimed;

    public function __construct(array $data = null)
    {
        if ($data === null)
            return;

        $this->ID = (int) $data['ID'];
        $this->OrderID = (int) $data['OrderID'];
        $this->FirstName = $data['FirstName'];
        $this->LastName = $data['LastName'];
        $this->PhoneNumber = $data['PhoneNumber'];
        $this->DateReceived = $data['DateReceived'];
        $this->DateDue = $data['DateDue'];
        $this->DateClaimed = $data['DateClaimed'];
    }
}