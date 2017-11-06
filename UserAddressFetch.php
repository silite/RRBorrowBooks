<?php
    function UserAddressFetch($OpenID,$method){
	require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();

	$select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
        $result_rowid = $connID->query($select,'Row');
        $UserID = $result_rowid['ROW_ID'];

//        这里修改所查询的字段
        $select = "SELECT ROW_ID,DeleteMark,UserName,PhoneNumber,Province,City,Area,College,Address FROM UserAddress WHERE UserId IN ('$UserID') AND DeleteMark = '0';";
        $result = $connID->query($select,$method);
        return $result;
    }
?>
