<?php
    require_once '../../RRJS/Other/MysqlConnect.php';
    require_once 'ScanCodePay.php';

    $connID = Connect();
    $UserID = $_POST['UserID'];
    $OrderNo = $_POST['OrderNo'];
    $UseCard = $_POST['UseCard'];
    $OpenID = $_COOKIE['RRJSID'];
    $connID->update('OrderInfo','OrderState',1,"OrderNo='".$OrderNo."'");
    $select = "SELECT ROW_ID FROM OrderInfo WHERE OrderNo IN ('" . $OrderNo . "');";
    $result = $connID->query($select, 'Row');
    $OrderID = $result['ROW_ID'];
    $AddressID = $_POST['AddressID'];
    firstPay($UserID,$OpenID);

    $select_BookID = "SELECT BookID,EndDate,InCome,LocalID FROM OrderBook WHERE OrderID IN (" . "'" . $OrderID . "'" . ");";
    $result = $connID->query($select_BookID, 'All');
    $len = count($result);

    if($_POST['method'] == 'now_pay')
    {
	$EndDate = $result[0]['EndDate'];
	$InCome = $result[0]['InCome'];
	$BookID = $_POST['now_BookID'];
	$LocalID = $result[0]['LocalID'];
	$connID->update('ToPayOrder','DeleteMark',1,"OrderID='".$OrderID."' AND BookID = '".$BookID."'");
        $arrayDataValue_Pend = array("ROW_ID" => 'UUID()',
            "OrderID" => "'$OrderID'",
            "BookID" => "'$BookID'",
            "EndDate" => "'$EndDate'",
            "InCome" => "'$InCome'"
        );
	$connID->insert('PendDeliveryOrder', $arrayDataValue_Pend);
	$connID->update('LocalBookInfo','BorrowedMark','1',"ROW_ID = '".$LocalID."'");
    }
    else{
    $connID->update('ToPayOrder','DeleteMark',1,"OrderID='".$OrderID."'");
    for($i = 0; $i < $len;$i++) {
        $sql = "BookID='" . $result[$i]['BookID'] . "' AND UserID = '" . $UserID . "'";
        $connID->update('ToBorrowBooks', 'DeleteMark', 1, $sql);
    }
    for($i = 0; $i < $len;$i++) {
        $BookID = $result[$i]['BookID'];
        $EndDate = $result[$i]['EndDate'];
        $InCome = $result[$i]['InCome'];
        $arrayDataValue_Pend = array("ROW_ID" => 'UUID()',
            "OrderID" => "'$OrderID'",
            "BookID" => "'$BookID'",
            "EndDate" => "'$EndDate'"
        , "InCome" => "'$InCome'"
        );
        $connID->insert('PendDeliveryOrder', $arrayDataValue_Pend);

	$LocalID =  $result[$i]['LocalID'];
	$connID->update('LocalBookInfo','BorrowedMark','1',"ROW_ID = '".$LocalID."'");
    }
}

	//为卡券使用功能
	if($UseCard == 1)
	{
	    $select = "SELECT ROW_ID FROM BPDetail WHERE OpenID = '".$OpenID."' AND DeleteMark = 0 AND ModifyM = 500";
	    $result = $connID->query($select, 'Row');
	    $ROW_ID = $result['ROW_ID'];
	    $connID->update('BPDetail','DeleteMark','1',"ROW_ID = '".$ROW_ID."'");
	}
	if($UseCard == 2)
	{
	    $select = "SELECT ROW_ID FROM BPDetail WHERE OpenID = '".$OpenID."' AND DeleteMark = 0 AND ModifyM = 950";
            $result = $connID->query($select, 'Row');
            $ROW_ID = $result['ROW_ID'];
            $connID->update('BPDetail','DeleteMark','1',"ROW_ID = '".$ROW_ID."'");
	}
?>
