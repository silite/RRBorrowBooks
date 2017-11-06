<?php


/*
*/


include_once __DIR__.'/../Class/WXPay.php';
include_once __DIR__.'/../Class/MyLog.php';


$order_no = $_POST['OrderNo'];
$total_fee = $_POST['TotalFee'] * 100;
//$total_fee = 1;
$ip = $_POST['IP'];
$open_id = $_COOKIE['RRJSID'];



$order = new WXPay($open_id);
//$OrderNo = $order->GenerateOrderNumber();
$order->SetOrderNumber($order_no);
$TYXD = $order->TYXD(array('body' => 'Book' ,
                           'total_fee' => $total_fee ,
                           'spbill_create_ip' => $ip ,
                           'notify_url' => 'https://renrenjieshu.com/PHP/ReceivePayAsyncNotify.php'
                          )
                    );
if ('SUCCESS' != $TYXD->return_code) {
    $log = new MyLog();
    $log->Log(2 , 'SUCCESS != $TYXD->return_code : '.var_export($order->Debug() ,TRUE));
}
$js_appid = APP_ID;
$js_timestamp = date('Y-m-d');
$js_nonceStr = WXPay::GetNonceStr();
$js_package = 'prepay_id='.$TYXD->prepay_id;
$js_signType = 'MD5';
$sign_array = array('appId'=>$js_appid , 'timeStamp'=>$js_timestamp , 'nonceStr'=>$js_nonceStr , 'package'=>$js_package , 'signType'=>$js_signType);
$js_paySign = WXPay::GenerateSign($sign_array);
$sign_array['paySign'] = $js_paySign;
$js_sign_data = json_encode($sign_array);
echo $js_sign_data;
