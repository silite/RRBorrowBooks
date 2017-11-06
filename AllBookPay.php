<?php
//  allpay   在订单页面多本包括单本选择时提交订单实现
//  首先保证多本订单的订单号在数据库OederInfo中只存入一次
//  凡是点击提交  所有选定的书绑定OrderNo入OrderBook   ToPayBook   因为多本书遍历ajax较繁琐
//  默认将ToPayOrder的设为1   若用户提交订单   不对此数据库操作   若取消  将DeleteMark设置为0   在订单页面遍历    require_once 'MysqlConnect.php';
    require_once '../../RRJS/Other/MysqlConnect.php';
    require_once 'JudgeLocalAdd.php';

    $DeliveredInfo = $_POST['DeliveredInfo'];
    $connID = Connect();
    $OpenID = $_POST['OpenID'];
    
    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $result_rowid = $connID->query($select,'Row');
    $UserID = $result_rowid['ROW_ID'];

    $BookID = $_POST['BookID'];
    $day = $_POST['week'] * 7;
    $OrderNo = $_POST['OrderNo'];
    $AllInCome = $_POST["AllInCome"];

    $HaveBook = JudgeLocalAdd($BookID,$DeliveredInfo);
    $LocalID = $HaveBook;
    $select_Title = "SELECT Title FROM BookInfo WHERE ROW_ID = '".$BookID."';";
    $Title = $connID->query($select_Title,'Row');
    $Title = $Title['Title'];
    if($HaveBook != '0') {
        //单次
        $select_order = "SELECT ROW_ID FROM OrderInfo WHERE OrderNo IN (" . "'" . $OrderNo . "'" . ");";
        $result_order = $connID->query($select_order, 'Row');
        if (empty($result_order)) {
            $arrayDataValue_OrderInfo = array("ROW_ID" => 'UUID()',
                "OrderNo" => "'$OrderNo'",
                "UserID" => "'$UserID'",
                "StartDate" => 'NOW()',
                "DeliveredInfo" => "'$DeliveredInfo'",
                "InCome" => "'$AllInCome'");
            $connID->insert('OrderInfo', $arrayDataValue_OrderInfo);
        }
        $result_order = $connID->query($select_order, 'Row');
        $OrderID = $result_order['ROW_ID'];

        $select_bookPrice = "SELECT Price FROM BookInfo WHERE ROW_ID IN (" . "'" . $BookID . "'" . ");";
        $result_bookPrice = $connID->query($select_bookPrice, 'Row');
        $InCome = round($result_bookPrice['Price'] * 0.75) + $_POST['week'];

        date_default_timezone_set('prc');
        $EndDate = date('y-m-d h:i:s', strtotime('+' . $day . ' day'));
        $arrayDataValue = array("ROW_ID" => 'UUID()',
	    "LocalID" => "'$LocalID'",
	    "CreateDate" => 'NOW()',
            "OrderID" => "'$OrderID'",
            "BookID" => "'$BookID'",
            "EndDate" => "'$EndDate'",
            "InCome" => "'$InCome'");
        $connID->insert('OrderBook', $arrayDataValue);
        $arrayDataValue_to_pay = array("ROW_ID" => 'UUID()',
            "OrderID" => "'$OrderID'",
            "BookID" => "'$BookID'",
            "EndDate" => "'$EndDate'",
            "DeleteMark" => "'1'",
            "InCome" => "'$InCome'");
        $connID->insert('ToPayOrder', $arrayDataValue_to_pay);
	echo '1';
    }
    else
	echo $Title;
?>

