<?php
//  查询已借图书页    if语句可重置优化
    function BorrowedBBooksFetch($OpenID,$J_delete){
	if(!isset($connID)){
        require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();}

	$select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
        $result_rowid = $connID->query($select,'Row');
        $UserID = $result_rowid['ROW_ID'];

        $select = "SELECT BorrowedBooks.StartDate,
                              BorrowedBooks.EndDate,
                              BorrowedBooks.DeleteMark,
                              BookInfo.ROW_ID,
                              BookInfo.LISBN,
                              BookInfo.Title,
                              BookInfo.SubTitle FROM BorrowedBooks JOIN BookInfo ON BorrowedBooks.BookID = BookInfo.ROW_ID AND BorrowedBooks.UserID = '".$UserID."' ";
        if($J_delete)
            $select = $select.'AND BorrowedBooks.DeleteMark = 0;';
        else
            $select = $select.";";
        $result = $connID->query($select,'All');
        return $result;
    }
?>
