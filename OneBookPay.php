<?php
    //    第一步
    //    将address_ROW_ID 绑定至 OrderInfo 的DeleveredInfo
    //    将OpenID存入OrderInfo    总价存入InCome  将订单号存入
    //    第二步
    //    将订单号存入 OrderBook   从Submit进入要存入BookID   从订单总页面进去要遍历所有BookID

    require_once '../../RRJS/Other/MysqlConnect.php';
    require_once 'JudgeLocalAdd.php';
    $connID = Connect();

    $HaveToPay = $_POST['HaveToPay'];
    $OrderNo = $_POST['OrderNo'];
    $UserID = $_POST['UserID'];
    $RRJS_cost = $_POST['RRJS_cost'];
    $DeliveredInfo = $_POST['DeliveredInfo'];
    $BookID = $_POST['BookID'];

    $day = $_POST['week'] * 7;

    date_default_timezone_set('prc');
    $EndDate = date('y-m-d h:i:s', strtotime('+' . $day . ' day'));
    $LocalID = JudgeLocalAdd($BookID,$DeliveredInfo);

    if($HaveToPay == 0) {
        $arrayDataValue_OrderInfo = array("ROW_ID" => 'UUID()',
            "OrderNo" => "'$OrderNo'",
            "UserID" => "'$UserID'",
            "StartDate" => 'NOW()',
            "InCome" => "'$RRJS_cost'",
            "DeliveredInfo" => "'$DeliveredInfo'");
        $connID->insert('OrderInfo', $arrayDataValue_OrderInfo);
        $select = "SELECT ROW_ID FROM OrderInfo WHERE OrderNo IN (" . "'" . $OrderNo . "'" . ");";
        $result = $connID->query($select, 'Row');
        $OrderID = $result['ROW_ID'];

        $arrayDataValue_OrderBook = array("ROW_ID" => 'UUID()',
	    "CreateDate" => 'NOW()',
            "OrderID" => "'$OrderID'",
            "BookID" => "'$BookID'",
	    "LocalID" => "'$LocalID'",
            "EndDate" => "'$EndDate'",
            "InCome" => "'$RRJS_cost'");
        $connID->insert('OrderBook', $arrayDataValue_OrderBook);
        $arrayDataValue_ToPay = array("ROW_ID" => 'UUID()',
            "OrderID" => "'$OrderID'",
            "BookID" => "'$BookID'",
            "EndDate" => "'$EndDate'",
            "InCome" => "'$RRJS_cost'",
            "DeleteMark" => "'1'");
        $connID->insert('ToPayOrder', $arrayDataValue_ToPay);
    }
    if($HaveToPay == 1){
	$where = "OrderInfo.UserID = '".$UserID."' AND OrderBook.BookID = '".$BookID."' AND OrderInfo.ROW_ID = OrderBook.OrderID";
	$where_2 = "OrderInfo.UserID = '".$UserID."' AND ToPayOrder.BookID = '".$BookID."' AND OrderInfo.ROW_ID = ToPayOrder.OrderID";
	$connID->update('OrderInfo,OrderBook','OrderInfo.OrderNo',$OrderNo,$where);
	$connID->update('OrderInfo,OrderBook','OrderInfo.InCome',$RRJS_cost,$where);
	$connID->update('OrderInfo,OrderBook','OrderInfo.StartDate',"NOW()",$where);
	$connID->update('OrderInfo,OrderBook','OrderInfo.DeliveredInfo',$DeliveredInfo,$where);
	$connID->update('OrderInfo,OrderBook','OrderBook.EndDate',$EndDate,$where);
	$connID->update('OrderInfo,OrderBook','OrderBook.InCome',$RRJS_cost,$where);
	$connID->update('ToPayOrder,OrderInfo','ToPayOrder.InCome',$RRJS_cost,$where_2); 
	$connID->update('ToPayOrder,OrderInfo','ToPayOrder.EndDate',$EndDate,$where_2);
    }
?>
