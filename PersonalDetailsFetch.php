<?php
function PersonalDetailsFetch($OpenID){
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $select = "SELECT NickName,RENRENID FROM UserInfo WHERE OpenID IN ('".$OpenID."');";
    $result = $connID->query($select,"Row");
    return $result;
}
?>
