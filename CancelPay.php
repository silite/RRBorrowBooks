<?php
//  allpay对应界面   若用户在订单页面提交时   点击了取消按钮或者是提交失败  将DeleteMark设置为0   可在待借订单中遍历输出  还需将ToBorrow中该对应OpenID和BookID删除
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $OrderNo = $_POST['OrderNo'];
    $OpenID = $_POST['OpenID'];

    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $result_rowid = $connID->query($select,'Row');
    $UserID = $result_rowid['ROW_ID'];

    $select_orderID = "SELECT ROW_ID FROM OrderInfo WHERE OrderNo IN (" . "'" . $OrderNo . "'" . ");";
    $result_orderID = $connID->query($select_orderID, 'Row');
    $OrderID = $result_orderID['ROW_ID'];
    $connID->update('ToPayOrder','DeleteMark',0,"OrderID='".$OrderID."'");
    $select_bookID = "SELECT BookID FROM ToPayOrder WHERE OrderID IN (" . "'" . $OrderID . "'" . ");";
    $result_bookID = $connID->query($select_bookID, 'All');
    $len_bookID = count($result_bookID);
    for($i = 0;$i<$len_bookID;$i++)
        $connID->update('ToBorrowBooks','DeleteMark',1,"BookID='".$result_bookID[$i]['BookID']."' AND UserID='".$UserID."'");
?>
