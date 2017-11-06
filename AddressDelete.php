<?php
//个人中心删除地址功能
    $ROW_ID = $_POST['ROW_ID'];
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $connID->update('UserAddress', 'DeleteMark', '1', "ROW_ID='" . $ROW_ID . "'");
?>
