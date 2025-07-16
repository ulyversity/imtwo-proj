<?php
declare(strict_types=1);

require_once "Repository.php";
require_once __DIR__."/../models/OrderDetail.php";


class OrderDetailRepository extends Repository {
    public function __construct() {
        parent::__construct(OrderDetail::class);
    }

    public function getOrderDetails()
    {
        $query = "SELECT O.ID as OrderID, CONCAT(CS.FirstName, ' ', CS.LastName) As Customer, CS.PhoneNumber AS CustomerNumber, S.Name AS Status, O.LoadCount AS LoadCount, O.TotalAmount AS Total, (TotalAmount - SUM(R.AmountPaid)) AS RemainingBalance, ST.Name AS Services, CONCAT(U.FirstName, ' ', U.LastName) AS Staff, CS.DateDue AS DateDue FROM `orders` O 
INNER JOIN claimslips CS ON O.ID = CS.OrderID 
INNER JOIN status S ON S.ID = O.StatusID 
INNER JOIN servicetypes ST ON ST.ID = O.ServiceTypeID
INNER JOIN users U ON U.ID = O.StaffID
LEFT JOIN receipts R ON O.ID = R.OrderID
GROUP BY OrderID, Customer, CustomerNumber, Status, LoadCount, Total, Services, Staff, DateDue
ORDER BY O.ID;";
        $result = $this->ConnectionDB->query($query);

        $orderDetailList = array();

        while($row = $result->fetch_assoc()) {
            $current = new OrderDetail($row);
            array_push($orderDetailList, $current);
        }
        return $orderDetailList;
    }
}