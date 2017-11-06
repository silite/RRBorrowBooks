<?php


/*
File: ReceiveRefundResult.php
Desc: Use for receive wechat notify refund result
Auth: lyd
Date: 2017-07-31
=============================
Change History
=============================
*/


include_once __DIR__.'/../Class/MyLog.php';
include_once __DIR__.'/../../RRJS/Const/Pay.php';
include_once __DIR__.'/../../RRJS/Const/ImportantData.php';


$xml_data = file_get_contents("php://input");
$data = json_decode(json_encode(simplexml_load_string($xml_data , 'SimpleXMLElement' , LIBXML_NOCDATA)) , TRUE);


if ((!array_key_exists('return_code' , $data)) || 'SUCCESS' != $data['return_code']) {
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
    $log->Log(2 , 'Seems something error , (!array_key_exists("return_code" , $data)) || "SUCCESS" != $data["return_code"] , but not match any one');
    exit;
}


if ($data['appid'] != APP_ID || $data['mch_id'] != MERCHANT_NUMBER) {
    $log = new MyLog();
    $log->Log(2 , 'seems something error , message contents appid : '.$data['appid'].' merchant number : '.$data['mch_id']);
    echo '<xml>
          <return_code><![CDATA[FAIL]]></return_code>
          <return_msg><![CDATA[AppidOrMerchantNumberError]]></return_msg>
          </xml>';
    exit;
}


if ((!array_key_exists('req_info' , $data)) || empty($data['req_info'])) {
    $log = new MyLog();
    $log->Log(2 , 'no req_info');
    echo '<xml>
          <return_code><![CDATA[FAIL]]></return_code>
          <return_msg><![CDATA[ReqInfoError]]></return_msg>
          </xml>';
    exit;
}


// check success
echo '<xml>
      <return_code><![CDATA[SUCCESS]]></return_code>
      <return_msg><![CDATA[OK]]></return_msg>
      </xml>';


// check success , decrypt message now
if ('MERCHANT_PASSWORD' == MERCHANT_PASSWORD) {
    $log = new MyLOg();
    $log->Log(1 , 'file include error , req info : '.$data['req_info']);
    echo '<xml>
          <return_code><![CDATA[SUCCESS]]></return_code>
          <return_msg><![CDATA[OK]]></return_msg>
          </xml>';
    exit;
}
$dec_str = openssl_decrypt($data['req_info'] , 'aes-256-ecb' , md5(MERCHANT_PASSWORD));
$req_data = json_decode(json_encode(simplexml_load_string($dec_str , 'SimpleXMLElement' , LIBXML_NOCDATA)) , TRUE);


// decrypt success , deal with message , $req_data['out_trade_no'] is our order number , $req_data['transaction_id'] is wechat order number , $req_data['out_refund_no'] is our refund number , $req_data['refund_id'] is wechat refund number , $req_data['total_fee'] is total fee (if settlement_total_fee have , don't use this), $req_data['settlement_total_fee'] settlement total fee which user real pay , $req_data['settlement_refund_fee'] is real refund fee


file_put_contents(__DIR__.'/log.txt' , var_export($req_data , TRUE) , FILE_APPEND);


echo '<xml>
      <return_code><![CDATA[SUCCESS]]></return_code>
      <return_msg><![CDATA[OK]]></return_msg>
      </xml>';
exit;
