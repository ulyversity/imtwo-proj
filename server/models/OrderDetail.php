<?php
declare(strict_types=1);

class OrderDetail {
    
    public int $ID;
    public string $Customer;
    public string $CustomerNumber;
    public string $Status;
    public float $LoadCount;
    public float $Total;
    public float $RemainingBalance;
    public string $Services;
    public string $Staff;
    public string $DateDue;
    public string $DateClaimed;


    public function __construct(array $data = null)
    {
        if ($data === null)
            return;

        $this->ID = (int) $data['ID'];
        $this->Customer = $data['Customer'];
        $this->CustomerNumber = $data['CustomerNumber'] ?? '';
        $this->Status = $data['Status'];
        $this->LoadCount = (float) $data['LoadCount'];
        $this->Total = (float) $data['Total'];
        $this->RemainingBalance = (float) ($data['RemainingBalance'] == "" ? $data['Total'] : $data['RemainingBalance']);
        $this->Services = $data['Services'];
        $this->Staff = $data['Staff'];
        $this->DateDue = $data['DateDue'];
        $this->DateClaimed = $data['DateClaimed'] ?? '';

    }
}