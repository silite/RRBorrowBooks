<?php
    $OpenID = $_COOKIE['RRJSID'];
    $RENRENID = $_POST['RENRENID'];
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $where = "RENRENID='".$RENRENID."'";
    $change = 'BonusPoints';
    $connID->update('UserInfo', 'BonusPoints', $change , $where , '10');
    $connID->update('UserInfo', 'ModifyDate', 'NOW()' , $where );
    $arrayDataValue = array("ROW_ID"=> 'UUID()',
        "OpenID" => "'$OpenID'",
        "Detail" => "'1'",
        "ChangeDate" => 'NOW()'
        );
    $connID->insert('BPDetail',$arrayDataValue);
?>
