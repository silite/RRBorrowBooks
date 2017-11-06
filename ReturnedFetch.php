<?php
//  以还书单配置
    function ReturnedBooksFetch($OpenID,$J_delete){
	require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
	$select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
        $result_rowid = $connID->query($select,'Row');
        $UserID = $result_rowid['ROW_ID'];

        $select = "SELECT ReturnedBooks.ReturnedDate,
                              ReturnedBooks.DeleteMark,
                              BookInfo.ROW_ID,
                              BookInfo.LISBN,
                              BookInfo.Title FROM ReturnedBooks JOIN BookInfo ON ReturnedBooks.BookID = BookInfo.ROW_ID AND ReturnedBooks.UserID = '".$UserID."' ";
        if($J_delete)
            $select = $select.'AND ReturnedBooks.DeleteMark = 0;';
        else
            $select = $select.";";
        $result = $connID->query($select,'All');
        return $result;
    }
?>
