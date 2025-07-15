<?php
declare(strict_types=1);

class Receipt {
    public int $ID;
    public int $OrderID;
    public float $Due;
    public float $AmountPaid;
    public float $Balance;

    public function __construct(array $data = null)
    {
        if ($data === null)
            return;

        $this->ID = (int) $data['ID'];
        $this->OrderID = (int) $data['OrderID'];
        $this->Due = (float) $data['Due'];
        $this->AmountPaid = (float) $data['AmountPaid'];
        $this->Balance = (float) $data['Balance'];
    }
}