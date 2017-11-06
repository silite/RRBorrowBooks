<?php
//  判断本地是否有此书   为显示图书暂无和心愿按钮功能   在TheThird页面具体判断
    function Judge($ROW_ID){
 	//require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
        $select = "SELECT LocalBookInfo.BookID FROM LocalBookInfo JOIN BookInfo ON LocalBookInfo.BookID = '$ROW_ID';";
        $result = $connID->query($select,'Row');
        if(empty($result))
            return false;
        else
            return true;
    }
?>
