<?php
    function ReturnOption($BookID,$UserID,$LocalID,$OrderNo,$DeleteMark){
        require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();

//      首先更新LocalBookInfo    $DeleteMark写入数据库
        $where_LocalBookInfo = "OrderInfo.OrderNo = '".$OrderNo."' 
                              AND OrderInfo.LocalID = '".$LocalID."' 
                              AND OrderInfo.UserID = '".$UserID."' 
                              AND LocalBookInfo.ROW_ID =  OrderInfo.LocalID;";

        $connID->update('LocalBookInfo,OrderInfo','LocalBookInfo.BorrowedMark','0',$where_LocalBookInfo);
        $connID->update('LocalBookInfo,OrderInfo','LocalBookInfo.DamagedMark',$DeleteMark,$where_LocalBookInfo);

//      再更新OrderBook
        $where_OrderBook = "OrderBook.BookID = '".$BookID."'. 
                           AND OrderInfo.OrderNo = '".$OrderNo."'
                           AND OrderInfo.ROW_ID = OrderBook.OrderID;";
        $connID->update('OrderBook','OrderBook.ReturnMark','1',$where_OrderBook);

////      写入已归还数据库 ReturnedBooks
//        $arrayDataValue = array("ROW_ID"=> 'UUID()',
//                                "BookID" => "'$BookID'",
//                                "UserID" => "'$UserID'",
//                                "EndDate" => 'NOW()');
//        $connID->insert('ReturnedBooks',$arrayDataValue);

    }
?>