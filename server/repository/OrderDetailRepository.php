<?php
declare(strict_types=1);

require_once "Repository.php";
require_once __DIR__."/../models/OrderDetail.php";


class OrderDetailRepository extends Repository {
    public function __construct() {
        parent::__construct(OrderDetail::class);
    }
}