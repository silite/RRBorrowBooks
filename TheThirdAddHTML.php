<?php
    require_once 'JudgeToBorrowBooks.php';
    require_once 'JudgeToPay.php';
    require_once 'JudgePend.php';
    $OpenID = $_COOKIE['RRJSID'];
    if (!isset($connID)) {
        require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();
    }
    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '" . $OpenID . "';";
    $result_rowid = $connID->query($select, 'Row');
    $UserID = $result_rowid['ROW_ID'];
    $result = ToBorrowBooksJudge($_SESSION['temp_ROW_ID'], $UserID);
    $HaveToPay = JudgeHaveToPay($UserID, $_SESSION['temp_ROW_ID']);
    //    条件较多  可以优化
    if (empty($result))
        $result = 'empty';
    else
        if (!empty($result) && $result['DeleteMark'] == 0)
            $result = 'exist';
        else
            if (!empty($result) && $result['DeleteMark'] == 1)
                $result = 'falsity';

    $HavePend = JudgePend($_SESSION['temp_ROW_ID'], $UserID);
?>
