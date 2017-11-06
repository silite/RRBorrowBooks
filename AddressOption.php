<?php
//site_.php  的地址操作功能     上面更新  下面新建   所有功能在父级中实现    require 'MysqlConnect.php';
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $OpenID = $_COOKIE['RRJSID'];

    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $result_rowid = $connID->query($select,'Row');
    $UserID = $result_rowid['ROW_ID'];

    $change_where =  "ROW_ID='".$_COOKIE['ROW_ID_change']."' AND UserID='".$UserID."'";

    if($_POST['method'] == 'change'){
        $connID->update('UserAddress','PhoneNumber',$_POST['PhoneNumber'],$change_where);
        $res = $connID->update('UserAddress','UserName',urldecode($_POST['UserName']),$change_where);
        $connID->update('UserAddress','Province',$_POST['cho_Province'],$change_where);
        $connID->update('UserAddress','City',$_POST['cho_City'],$change_where);
        $connID->update('UserAddress','Area',$_POST['cho_Area'],$change_where);
        $connID->update('UserAddress','Address',$_POST['Address'],$change_where);
        $connID->update('UserAddress','College',$_POST['cho_Insurer'],$change_where);
        setcookie('ROW_ID_change',"",time()-1);
    }
    if($_POST['method'] == 'modify')
    {
//        赋值意义为防止引号错误
        $UserName = $_POST['UserName'];
        $PhoneNumber = $_POST['PhoneNumber'];
        $Province = $_POST['cho_Province'];
        $City = $_POST['cho_City'];
        $Area = $_POST['cho_Area'];
        $Address = $_POST['Address'];
        $College = $_POST['cho_Insurer'];
        //  防止SQL注入

        $arrayDataValue = array("ROW_ID"=> 'UUID()',
	    "UserID" =>"'$UserID'",
            "Province"=>"'$Province'",
            "City"=>"'$City'",
            "Area"=>"'$Area'",
            "College"=>"'$College'",
            "Address"=>"'$Address'",
            "UserName"=>"'$UserName'",
            "PhoneNumber"=>"'$PhoneNumber'");
        $connID->insert('UserAddress',$arrayDataValue);
    }
?>
