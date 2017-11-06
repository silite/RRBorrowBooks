<?php
function JudgePend($BookID,$UserID){
    //require_once '../../RRJS/Other/MysqlConnect.php';
    //$connID = Connect();
    global $connID;
    $select = "SELECT PendDeliveryOrder.ROW_ID FROM PendDeliveryOrder JOIN OrderInfo ON PendDeliveryOrder.BookID = '".$BookID."' AND OrderInfo.UserID = '".$UserID."' AND PendDeliveryOrder.DeleteMark = '0' AND PendDeliveryOrder.OrderID = OrderInfo.ROW_ID";
    $result_Pend = $connID->query($select,'Row');
    $select = "SELECT DeliveredOrder.ROW_ID,DeliveredOrder.OrderID FROM DeliveredOrder JOIN OrderInfo ON DeliveredOrder.BookID = '".$BookID."' AND OrderInfo.UserID = '".$UserID."' AND DeliveredOrder.DeleteMark = '0' AND DeliveredOrder.OrderID = OrderInfo.ROW_ID";
    $result_Delivered = $connID->query($select,'Row');
    $OrderID = $result_Delivered['OrderID'];
		
    $select = "SELECT ROW_ID FROM OrderBook WHERE BookID = '".$BookID."' AND ReturnMark IS NULL AND OrderID = '".$OrderID."'";
    $result_orderbook = $connID->query($select,'Row');
    if(empty($result_Pend) && empty($result_orderbook))
	return 0;
    else return 1;
}
?>
