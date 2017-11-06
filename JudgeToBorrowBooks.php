<?php
    function ToBorrowBooksJudge($BookID,$UserID){
	//require_once '../../RRJS/Other/MysqlConnect.php';
        //$connID = Connect();
	if(isset($connID))
	    global $connID;
	else{
	require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
	}
        $select = "SELECT ROW_ID,DeleteMark FROM ToBorrowBooks WHERE BookID = '".$BookID."' AND UserID = '".$UserID."';";
        $result = $connID->query($select,'Row');
        return $result;
    }
?>
