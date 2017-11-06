<?php
    $OpenID = $_COOKIE['RRJSID'];
    $RENRENID = $_POST['RENRENID'];
	$Change_BP = $_POST['BP'];
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $where = "RENRENID='".$RENRENID."'";
    $change = '-'.$Change_BP;
    $connID->update('UserInfo', 'BonusPoints', 'BonusPoints' , $where , $change);
	
	$arrayDataValue = array("ROW_ID"=> 'UUID()',
        "OpenID" => "'$OpenID'",
	"ModifyM"=> "'$Change_BP'",
        "Detail" => "'2'",
        "ChangeDate" => 'NOW()'
        );
    $connID->insert('BPDetail',$arrayDataValue);
?>
