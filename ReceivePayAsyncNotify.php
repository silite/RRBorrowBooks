<?php


/*
File: ReceivePayAsyncNotify.php
Desc: Use for async receive wechat notify
Auth: lyd
Date: 2017-07-30
=============================
Change History
=============================
*/


include_once __DIR__.'/../Class/MyLog.php';
include_once __DIR__.'/../../RRJS/Const/Pay.php';


$xml_data = file_get_contents("php://input");
$data = json_decode(json_encode(simplexml_load_string($xml_data , 'SimpleXMLElement' , LIBXML_NOCDATA)) , TRUE);


if ((!array_key_exists('return_code' , $data)) || 'SUCCESS' != $data['return_code']) {
    // pay error or malicious request , deal with it
    $log = new MyLog();
    if (!array_key_exists('return_code' , $data)) {
        $log->Log(1 , 'have no return_code , may be is a malicious request , user address : '.$_SERVER['REMOTE_ADDR']);
        echo '<xml>
              <return_code><![CDATA[FAIL]]></return_code>
              <return_msg><![CDATA[NoReturnCode]]></return_msg>
              </xml>';
        exit;
    }
    else {
        $log->Log(1 , 'return_code is FAIL or other , error code : '.$data['return_code']." error message : ".$data['return_msg']);
        echo '<xml>
              <return_code><![CDATA[FAIL]]></return_code>
              <return_msg><![CDATA[CommunityError]]></return_msg>
              </xml>';
        //exit script
        exit;
    }
    exit;
}


//return code is SUCCESS , generate signature
$data_str = '';
ksort($data , SORT_STRING);
foreach($data as $key => $value) {
    if (empty($value) || 'sign' == $key) {
        continue;
    }
    $data_str .= $key.'='.$value.'&';
}
$data_str .= 'key='.MERCHANT_PASSWORD;
$sign = strtoupper(md5($data_str));


if ($sign != $data['sign']) {
    echo '<xml>
          <return_code><![CDATA[FAIL]]></return_code>
          <return_msg><![CDATA[SignError]]></return_msg>
          </xml>';
    $log = new MyLog();
    $log->Log(1 , 'Check sign error , user address : '.$_SERVER['REMOTE_ADDR'].'  Other info :'.var_export($data , TRUE));
    exit;
}


// check success
echo '<xml>
      <return_code><![CDATA[SUCCESS]]></return_code>
      <return_msg><![CDATA[OK]]></return_msg>
      </xml>';


// now update databases  :  if $data['result_code'] == 'SUCCESS' , user pay success , else pay Failure ; $data['out_trade_no'] is our order number ; $data['transaction_id'] is wechat order number ;
/***************************************************************************************************************************************************************************************************/




if ($data['result_code'] == 'SUCCESS') {
    exit('<xml>
      <return_code><![CDATA[SUCCESS]]></return_code>
      <return_msg><![CDATA[OK]]></return_msg>
      </xml>');
}
else {
    file_put_contents(__DIR__.'/../../RRJS/Log/MaliciousOrder.txt' , date("Y-m-d H:i:s").'    '.$data['out_trade_no']."\n" , FILE_APPEND);
}
