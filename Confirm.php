<?php
session_start();
$OpenID = $_COOKIE['RRJSID'];
require_once '../../RRJS/Other/MysqlConnect.php';
$connID = Connect();
$RRJS_cost = 0;
echo "Dwadawd";
$select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
$result_rowid = $connID->query($select,'Row');
$UserID = $result_rowid['ROW_ID'];
if (isset($_GET['add']) && $_GET['add'] == 'one_book') {
    $RRJS_cost = $_POST['RRJS_cost'];
    $DeliveredInfo = $_SESSION['address_ROW_ID'];
    $BookID = $_SESSION['temp_ROW_ID'];
    $day = $_POST['week'] * 7;
    date_default_timezone_set('prc');
    $EndDate = date('y-m-d h:i:s', strtotime('+' . $day . ' day'));

    //    第一步
    //    将address_ROW_ID 绑定至 OrderInfo 的DeleveredInfo
    //    将OpenID存入OrderInfo    总价存入InCome  将订单号存入
    //    第二步
    //    将订单号存入 OrderBook   从Submit进入要存入BookID   从订单总页面进去要遍历所有BookID
    $arrayDataValue_OrderInfo = array("ROW_ID" => 'UUID()',
        "OrderNo" => "'$OrderNo'",
        "UserID" => "'$UserID'",
        "StartDate" => 'NOW()',
        "InCome" => "'$RRJS_cost'",
        "DeliveredInfo" => "'$DeliveredInfo'");
    $connID->insert('OrderInfo', $arrayDataValue_OrderInfo);
    $select = "SELECT ROW_ID FROM OrderInfo WHERE OrderNo IN (" . "'" . $OrderNo . "'" . ");";
    $result = $connID->query($select, 'Row');
    $OrderID = $result['ROW_ID'];

    $arrayDataValue_OrderBook = array("ROW_ID" => 'UUID()',
        "OrderID" => "'$OrderID'",
        "BookID" => "'$BookID'",
        "EndDate" => "'$EndDate'",
        "InCome" => "'$RRJS_cost'");
    $connID->insert('OrderBook', $arrayDataValue_OrderBook);
    $arrayDataValue_ToPay = array("ROW_ID" => 'UUID()',
        "OrderID" => "'$OrderID'",
        "BookID" => "'$BookID'",
        "EndDate" => "'$EndDate'",
        "InCome" => "'$RRJS_cost'",
        "DeleteMark" => "1");
    $connID->insert('ToPayOrder', $arrayDataValue_ToPay);
}
?>
<script>
    $("#mmp").click(function () {
        var orderno = "<?php if (isset($_POST['OrderNo'])) echo $_POST['OrderNo']; else echo $OrderNo; ?>";
        var openid = "<?php echo $OpenID; ?>";
        $.ajax({
            url: 'CancelPay.php',
            data: {OrderNo: orderno,OpenID:openid},
            type: "POST",
            dataType: "TEXT",
            success: function () {
                history.go(-1);
            }
        });
        history.go(-1);
    });
    $("#mmp2").click(function () {
        var add = "<?php if (isset($_GET['add'])) echo $_GET['add']; ?>";
        var orderno = "<?php if (isset($_POST['OrderNo'])) echo $_POST['OrderNo']; else echo $OrderNo; ?>";
        var openid = "<?php echo $OpenID; ?>";
        $.ajax({
            url: 'SurePay.php',
            data: {OrderNo: orderno, OpenID: openid, method: add},
            type: "POST",
            dataType: "TEXT",
            success: function () {
                history.go(-1);
            }
        });
    });
</script>
