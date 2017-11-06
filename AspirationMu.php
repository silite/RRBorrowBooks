<?php
//  心愿书单存入   empty  首次存入   falsity   用户存入后删除   此操作只将DeleteMark值设为0即可    删除功能一样
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $BookID = $_POST["temp_ROW_ID"];
    $result = $_POST['result'];
    $OpenID = $_COOKIE['RRJSID'];
    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $result_rowid = $connID->query($select,'Row');
    $UserID = $result_rowid['ROW_ID'];
    if($_POST['flag'] == 1) {
        if ($result == 'empty') {
            $arrayDataValue = array("ROW_ID" => "UUID()",
                "UserID" => "'$UserID'",
                "BookID" => "'$BookID'",
		"CreateUserID" => "'$OpenID'");
            $connID->insert('AspirationBooks', $arrayDataValue);
        }
        if ($result == 'falsity')
            $connID->update('AspirationBooks', 'DeleteMark', '0', "BookID='" . $BookID . "'");
    }
    else
        $connID->update('AspirationBooks','DeleteMark','1',"BookID='".$BookID."'");
?>
