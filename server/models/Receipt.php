<?php
declare(strict_types=1);

class Receipt {
    public string $TableNameAlias = "receipts";
    public int $ID;
    public int $OrderID;
    public float $AmountPaid;

    public function __construct(array $data = null)
    {
        if ($data === null)
            return;

        $this->ID = (int) $data['ID'];
        $this->OrderID = (int) $data['OrderID'];
        $this->AmountPaid = (float) $data['AmountPaid'];
    }
}