
<?php
function JudgeLocalAdd($BookID,$AddressID){
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();	
    $select_add = "SELECT College FROM UserAddress WHERE ROW_ID = '".$AddressID."';";
    $result_add = $connID->query($select_add,'Row');
    $College = $result_add['College'];
    $select = "SELECT LocalBookInfo.ROW_ID FROM LocalBookInfo JOIN BookStore ON LocalBookInfo.BookID = '".$BookID."' AND BookStore.StoreName = '".$College."' AND LocalBookInfo.BookStoreID = BookStore.ROW_ID AND LocalBookInfo.BorrowedMark = 0;";
    $result = $connID->query($select,'Row');
    if(empty($result))
        return 0;
    else
        return $result['ROW_ID'];
}
?>
