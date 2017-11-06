<?php
    function GetDeposit(){
        $OpenID = $_COOKIE['RRJSID'];
        require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();

        $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
        $result_rowid = $connID->query($select,'Row');
        $UserID = $result_rowid['ROW_ID'];

        $select = "SELECT OrderBook.BookID FROM OrderInfo JOIN OrderBook ON OrderInfo.UserID = '".$UserID."' AND OrderInfo.OrderState <> 0 AND OrderBook.ReturnMark IS NULL AND OrderBook.DeleteMark = 0 AND OrderInfo.ROW_ID = OrderBook.OrderID;";
        $result = $connID->query($select,'All');
        $len = count($result);
        $total = 0;
        for($i=0;$i<$len;$i++){
	    if($result[$i]['BookID'] != '08f1874b-9471-11e7-bb0f-00163e06cefc')
            	$total += 25;
	    else
		$total += 60;
        }
        return $total;
    }
?>
