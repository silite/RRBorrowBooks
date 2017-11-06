<?php
//   此判断BookInfo中是否有此ISBN   没有访问API    有则读库
        function ISBNFetch($ISBN){
	require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
        $select = "SELECT ROW_ID,LISBN,Price,Title,Author,Publisher,Binding,PublishDate,Pages,Summary,SubTitle FROM BookInfo WHERE LISBN IN ($ISBN);";
        $result = $connID->query($select,'Row');
        return $result;
    }
?>
