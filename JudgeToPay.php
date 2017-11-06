<?php
    function JudgeHaveToPay($UserID,$BookID){
        global $connID;
        $select = "SELECT ToPayOrder.ROW_ID FROM ToPayOrder JOIN OrderInfo ON ToPayOrder.BookID = '".$BookID."' AND OrderInfo.UserID = '".$UserID."' AND ToPayOrder.DeleteMark = '0' AND ToPayOrder.OrderID = OrderInfo.ROW_ID";
        $result = $connID->query($select,'Row');
        if(empty($result))
            return 0;
        else
            return 1;
    }
?>
