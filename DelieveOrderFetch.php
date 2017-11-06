<?php
    function DeliveredFetch($OpenID,$UserID){
 	require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
        $select = "SELECT DeliveredOrder.DeleteMark,
                                      DeliveredOrder.Income,
                                      DeliveredOrder.ROW_ID AS Delivered_ROW_ID,
                                      OrderInfo.OrderNo,
                                      BookInfo.ROW_ID,
                                      BookInfo.Author,
                                      BookInfo.LISBN,
                                      BookInfo.Title,
                                      BookInfo.SubTitle FROM (DeliveredOrder JOIN BookInfo ON DeliveredOrder.BookID = BookInfo.ROW_ID) 
                                      JOIN OrderInfo ON DeliveredOrder.OrderID = OrderInfo.ROW_ID AND OrderInfo.UserID = '$UserID';";
        $result = $connID->query($select,'All');
        return $result;
    }
?>
