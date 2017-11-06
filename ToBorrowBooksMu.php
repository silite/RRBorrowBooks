<?php
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $OpenID = $_COOKIE['RRJSID'];
    $BookID = $_POST["temp_ROW_ID"];
    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $result_rowid = $connID->query($select,'Row');
    $UserID = $result_rowid['ROW_ID'];
    $result = $_POST['result'];
    if($_POST['flag'] == 1) {
        if ($result == 'empty') {
            $arrayDataValue = array("ROW_ID" => "UUID()",
                "UserID" => "'$UserID'",
                "BookID" => "'$BookID'");
            $connID->insert('ToBorrowBooks', $arrayDataValue);
        }
        if ($result == 'falsity')
            $connID->update('ToBorrowBooks', 'DeleteMark', '0', "BookID='" . $BookID . "'");
    }
    else
        $connID->update('ToBorrowBooks','DeleteMark','1',"BookID='".$BookID."'");
?>
