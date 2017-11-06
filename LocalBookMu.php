<?php
//  将BookInfo的信息录入LocalBookInfo
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $ISBN = $_POST['ISBN'];
    $select = "SELECT ROW_ID FROM BookInfo WHERE LISBN IN ('".$ISBN."');";
    $result = $connID->query($select,'Row');
    $BookID = $result["ROW_ID"];
    $arrayDataValue = array("ROW_ID"=>"UUID()",
        "BookID"=>"'$BookID'");
    $connID->insert('LocalBookInfo',$arrayDataValue);
?>
