<?php
declare(strict_types=1);

class Status {
    public string $TableNameAlias = "status";

    public int $ID;
    public string $Name;

    public function __construct(array $data = null)
    {
        if ($data === null)
            return;

        $this->ID = (int) $data['ID'];
        $this->Name = $data['Name'];
    }
}