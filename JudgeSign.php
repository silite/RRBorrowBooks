<?php
    function JudgeSign(){
	$OpenID = $_COOKIE['RRJSID'];
	require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
	$select = "SELECT ModifyDate FROM UserInfo WHERE OpenID = '".$OpenID."';";
        $result = $connID->query($select,'Row');
        $ModifyDate = $result['ModifyDate'];
	return $ModifyDate;
    }
?>
