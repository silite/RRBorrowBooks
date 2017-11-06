<?php
    function firstPay($UserID,$OpenID)
    {
	require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
	
        $select = "SELECT InvitePeople FROM UserInfo WHERE OpenID = '".$OpenID."';";
        $InvitePeople = $connID->query($select,'Row');
        if(empty($InvitePeople))
            $whether_InvitePeople = false;
        else
            $whether_InvitePeople = true;

        $select = "SELECT PendDeliveryOrder.ROW_ID FROM PendDeliveryOrder JOIN OrderInfo ON OrderInfo.UserID = '".$UserID."' AND PendDeliveryOrder.OrderID = OrderInfo.ROW_ID;";

        $Payed = $connID->query($select,'Row');
        if(empty($Payed))
            $whether_Payed = true;
        else
            $whether_Payed = false;

        if($whether_Payed && $whether_InvitePeople)
        {
	    $select = "SELECT OpenID FROM UserInfo WHERE ROW_ID = '".$InvitePeople['InvitePeople']."'";
	    $OpenID = $connID->query($select,'Row');
	    $OpenID = $OpenID['OpenID'];

            $arrayDataValue = array("ROW_ID"=> 'UUID()',
                "OpenID" => "'$OpenID'",
                "ModifyM"=> "'150'",
                "Detail" => "'4'",
                "ChangeDate" => 'NOW()'
            );
            $connID->insert('BPDetail',$arrayDataValue);
	
	    $where = "OpenID = '".$OpenID."'";
	    $change = '+150';
    	    $connID->update('UserInfo', 'BonusPoints', 'BonusPoints' ,$where , $change);
        }

    }
?>
