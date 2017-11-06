<?php
    function BPFetch()
    {
        $OpenID = $_COOKIE['RRJSID'];
        require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
        $select = "SELECT BonusPoints FROM UserInfo WHERE OpenID IN ('".$OpenID."');";
        $result = $connID->query($select, 'Row');
        return $result['BonusPoints'];
    }
?>
