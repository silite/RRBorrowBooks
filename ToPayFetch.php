<?php
function ToPayFetch($OpenID,$UserID)
{
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $select = "SELECT ToPayOrder.DeleteMark,
                                          OrderInfo.OrderNo,
                                          ToPayOrder.InCome,
                                          BookInfo.ROW_ID,
                                          BookInfo.Author,
                                          BookInfo.LISBN,
                                          BookInfo.Title,
                                          BookInfo.SubTitle FROM (ToPayOrder JOIN BookInfo ON ToPayOrder.BookID = BookInfo.ROW_ID) 
                                          JOIN OrderInfo ON ToPayOrder.OrderID = OrderInfo.ROW_ID AND OrderInfo.UserID = '$UserID';";
    $result = $connID->query($select, 'All');
    return $result;
}

?>
