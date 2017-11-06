<?php
//  为心愿按钮的判断条件   结合AspirationFetch
function AspirationJudge($BookID,$UserID){
   // require_once '../../RRJS/Other/MysqlConnect.php';
    global $connID;
//    $connID = Connect();
    $select = "SELECT ROW_ID,DeleteMark FROM AspirationBooks WHERE BookID = '".$BookID."' AND UserID = '".$UserID."';";
    $result = $connID->query($select,'Row');
    return $result;
}
?>
