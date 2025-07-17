<?php
declare(strict_types=1);

require_once "Repository.php";
require_once __DIR__."/../models/Order.php";


class OrderRepository extends Repository{
    public function __construct(){
        parent::__construct(Order::class);
    }

    public function getOrderReceipts() {
        return $this->queryObject("SELECT O.ID, O.TotalAmount, SUM(R.AmountPaid) as AmountPaid FROM orders O LEFT JOIN receipts R ON O.ID = R.OrderID
GROUP BY O.ID, O.TotalAmount;");
    }

    public function getTotalSales() {
        return $this->queryObject("SELECT SUM(TotalAmount) as TotalSales FROM orders;")[0]->TotalSales;
    }

    public function getTotalSalesToday() {
        $salesToday = $this->queryObject("SELECT SUM(TotalAmount) as TotalSales FROM orders O INNER JOIN claimslips CS ON O.ID = CS.OrderID 
WHERE DATE(CS.DateReceived) = CURDATE()");

        return !empty($salesToday) ? $salesToday[0]->TotalSales : 0;
    }

    public function getTotalSalesThisWeek() {
        $salesThisWeek = $this->queryObject("SELECT SUM(TotalAmount) as TotalSales FROM orders O INNER JOIN claimslips CS ON O.ID = CS.OrderID
WHERE DATE(CS.DateReceived) > DATE_ADD(CURDATE(), INTERVAL -1 WEEK);");
        
        return !empty($salesThisWeek) ? $salesThisWeek[0]->TotalSales : 0;
    }

    public function getRemainingBalance()
    {
        return $this->queryObject("SELECT ((SELECT SUM(TotalAmount) FROM orders) - (SELECT SUM(AmountPaid) FROM receipts)) AS RemainingBalance;")[0]->RemainingBalance;
    }

    public function getTotalAmountPaid()
    {
        return $this->queryObject("SELECT SUM(AmountPaid) As TotalAmountPaid FROM receipts;")[0]->TotalAmountPaid;
    }

    public function getMaxLoadCounttOrder()
    {
        return $this->queryObject("SELECT MAX(LoadCount) As LoadCount FROM Orders")[0]->LoadCount;
    }
}