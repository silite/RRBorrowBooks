<?php
//  查询心愿书单   if语句为判断在TheThird页面的按钮显示效果
    function AspirationBooksFetch($OpenID,$J_delete){
        require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
	$select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
        $result_rowid = $connID->query($select,'Row');
	$UserID = $result_rowid['ROW_ID'];
        $select = "SELECT AspirationBooks.DeleteMark,
                                  BookInfo.ROW_ID,
                                  BookInfo.LISBN,
                                  BookInfo.Title,
                                  BookInfo.SubTitle FROM AspirationBooks JOIN BookInfo ON AspirationBooks.BookID = BookInfo.ROW_ID AND AspirationBooks.UserID = '$UserID' ";
        if($J_delete)
            $select = $select.'AND AspirationBooks.DeleteMark = 0;';
        else
            $select = $select.";";
        $result = $connID->query($select,'All');
        return $result;
    }
?>
