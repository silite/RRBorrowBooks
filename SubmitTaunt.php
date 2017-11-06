<?php
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $OpenID = $_COOKIE['RRJSID'];
    $Content = $_POST['Content']; 
    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $result_rowid = $connID->query($select,'Row');
    $UserID = $result_rowid['ROW_ID'];

    $arrayDataValue = array("ROW_ID"=> 'UUID()',
         "UserID" =>"'$UserID'",
	 "Content" => "'$Content'",
	 "FeedbackDate" =>'NOW()');
    $connID->insert('UserRetroaction',$arrayDataValue);
?>

