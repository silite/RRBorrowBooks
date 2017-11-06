<?php


/*
File: Set_RRJS_ID.php
Desc: Use for get user's open id
Auth: lyd
Date: 2017-07-11
=============================
Change History
=============================
*/


include_once __DIR__.'/../../RRJS/Const/ImportantData.php';
$RRJSID = json_decode(file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APP_ID.'&secret='.APP_SECRET.'&code='.$_GET['code'].'&grant_type=authorization_code') , TRUE)['openid'];
$RRJSID = $RRJSID ? $RRJSID : $_COOKIE['RRJSID'];
if (!$RRJSID) {
    exit('<h1>Maybe you should open it in wechat ~</h1>');
}
setcookie("RRJSID" , $RRJSID , time() + 9999 * 9999 , "/" , "renrenjieshu.com");
