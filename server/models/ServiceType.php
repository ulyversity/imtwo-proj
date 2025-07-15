<?php
declare(strict_types=1);

class Supply {
    public int $ID;
    public string $Name;
    public float $ValuePerKG;

    public function __construct(array $data = null)
    {
        if ($data === null)
            return;

        $this->ID = (int) $data['ID'];
        $this->Name = $data['Name'];
        $this->ValuePerKG = (float) $data['ValuePerKG'];
    }
}