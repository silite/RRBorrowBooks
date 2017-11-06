<?php


/*
File: CertVerify.php
Desc: Use for varify wechat certification
Auth: lyd
Date: 2017-07-30
=============================
Change History
=============================
*/


const APICLIENT_CERT = __DIR__.'/../../RRJS/Other/apiclient_cert.pem';
const APICLIENT_KEY = __DIR__.'/../../RRJS/Other/apiclient_key.pem';


/*
CURL使用SSL认证进行POST数据传输
参数：
    URL，需要进行认证的URL（证书为上方的两个CONST常量）
    数据，一个字符串，用来POST
    头数据，默认为空
    超时，默认为30秒，CURL超时值
*/
function CertVerify($a_url , $a_data , $a_header=array() , $a_timeout = 30) {
    $ch = curl_init();
    curl_setopt($ch , CURLOPT_URL , $a_url);
    curl_setopt($ch , CURLOPT_TIMEOUT , $a_timeout);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER , TRUE);
    curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , FALSE);
    curl_setopt($ch , CURLOPT_SSL_VERIFYHOST , FALSE);
    curl_setopt($ch , CURLOPT_SSLCERTTYPE , 'PEM');
    curl_setopt($ch , CURLOPT_SSLCERT , APICLIENT_CERT);
    curl_setopt($ch , CURLOPT_SSLKEYTYPE , 'PEM');
    curl_setopt($ch , CURLOPT_SSLKEY , APICLIENT_KEY);
    if(count($a_header) >= 1) {
        curl_setopt($ch , CURLOPT_HTTPHEADER , $a_header);
	}
    curl_setopt($ch , CURLOPT_POST , TRUE);
    curl_setopt($ch , CURLOPT_POSTFIELDS , $a_data);
    $data = curl_exec($ch);
	if($data) {
        curl_close($ch);
        return $data;
	}
	else { 
        $error = curl_errno($ch);
        curl_close($ch);
        return FALSE;
	}
}
