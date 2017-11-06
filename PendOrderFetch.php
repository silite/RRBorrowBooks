<?php
//  待派送订单
function PendFetch($OpenID,$UserID){

    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $select = "SELECT PendDeliveryOrder.DeleteMark,
                                          OrderInfo.OrderNo,
                                          PendDeliveryOrder.InCome,
                                          BookInfo.ROW_ID,
                                          BookInfo.Author,
                                          BookInfo.LISBN,
                                          BookInfo.Title,
                                          BookInfo.SubTitle FROM (PendDeliveryOrder JOIN BookInfo ON PendDeliveryOrder.BookID = BookInfo.ROW_ID) 
                                          JOIN OrderInfo ON PendDeliveryOrder.OrderID = OrderInfo.ROW_ID AND OrderInfo.UserID = '$UserID';";
    $result = $connID->query($select,'All');
    return $result;
}
?>
