<?php
declare(strict_types=1);

class Supply {
    public string $TableNameAlias = "Supplies";

    public int $ID;
    public string $Name;
    public int $Quantity;

    public function __construct(array $data = null)
    {
        if ($data === null)
            return;

        $this->ID = (int) $data['ID'];
        $this->Name = $data['Name'];
        $this->Quantity = (int) $data['Quantity'];
    }
}