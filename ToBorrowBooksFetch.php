<?php
    function ToBorrowBooksFetch($OpenID,$UserID){
	require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
        $select = "SELECT ToBorrowBooks.DeleteMark,
                                      BookInfo.ROW_ID,
                                      BookInfo.Price,
                                      BookInfo.Author,
                                      BookInfo.LISBN,
                                      BookInfo.Title,
                                      BookInfo.SubTitle FROM ToBorrowBooks JOIN BookInfo ON ToBorrowBooks.BookID = BookInfo.ROW_ID AND ToBorrowBooks.UserID = '".$UserID."';";
        $result = $connID->query($select,'All');
        return $result;
    }
?>
