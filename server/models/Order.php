<?php
declare(strict_types=1);

class Order {
    public int $ID;
    public int $StatusID;
    public int $ServiceTypeID;
    public int $StaffID;
    public float $LoadCount;
    public float $TotalAmount;

    public function __construct(array $data = null)
    {
        if ($data === null)
            return;

        $this->ID = (int) $data['ID'];
        $this->StatusID = (int) $data['StatusID'];
        $this->ServiceTypeID = (int) $data['ServiceTypeID'];
        $this->StaffID = (int) $data['StaffID'];
        $this->LoadCount = (float) $data['LoadCount'];
        $this->TotalAmount = (float) $data['TotalAmount'];
    }
}