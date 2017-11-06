<?php
//  订单删除页面   在1111.php中具体判断 ROW_ID为BookID
    $table = $_POST['delete_name'];
    $ROW_ID = $_POST['ROW_ID'];
    $OpenID = $_COOKIE['RRJSID'];

    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $result_rowid = $connID->query($select,'Row');
    $UserID = $result_rowid['ROW_ID'];
    $select = "SELECT OrderBook.OrderID FROM OrderBook JOIN OrderInfo WHERE OrderBook.BookID = '".$ROW_ID."' AND OrderInfo.UserID = '".$UserID."';";
    $result = $connID->query($select, 'Row');
    $OrderID = $result['OrderID'];

    if($table == 'DeliveredOrder')
        $connID->update($table,'DeleteMark','1',"ROW_ID='".$ROW_ID."' AND OrderID = '".$OrderID."'");
    else
        if($table == 'ToBorrowBooks')
            $connID->update($table,'DeleteMark','1',"BookID='".$ROW_ID."' AND UserID = '".$UserID."'");
        else
            if($table == 'ToPayOrder') {
                $connID->update($table, 'DeleteMark', '1', "BookID='" . $ROW_ID . "' AND OrderID = '".$OrderID."'");
                $connID->update('OrderBook', 'DeleteMark', '1', "BookID='" . $ROW_ID . "' AND OrderID = '".$OrderID."'");
                $connID->update('OrderInfo', 'DeleteMark', '1', "ROW_ID='" . $OrderID . "'");
            }
?>
