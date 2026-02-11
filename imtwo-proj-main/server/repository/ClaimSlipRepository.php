<?php
declare(strict_types=1);

require_once "Repository.php";
require_once __DIR__."/../models/ClaimSlip.php";


class ClaimSlipRepository extends Repository {
    public function __construct(){
        parent::__construct(ClaimSlip::class);
    }
}