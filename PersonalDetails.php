<?php
function PersonalDetailsFetch($OpenID){
    require_once 'MysqlConnect.php';
    $connID = Connect();
    $select = "SELECT NickName FROM UserInfo WHERE OpenID IN ('".$OpenID."');";
    $result = $connID->query($select,"Row");
    return $result;
}
?>