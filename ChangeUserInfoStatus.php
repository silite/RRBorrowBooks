<?php


/*
File: ChangeUserInfoStatus.php
Desc: Provide function use for check for user subscribe or not Insert user info when user first subscribe 
Auth: lyd
Date: 2017-07-22
==============================
Change History
1,lyd,2017-07-22,Change download user head image from file_get_contents to curl fixed timeout at line 94
2,lyd,2017-07-26,Sava user location 0 , 0 to database when user first subscribe
==============================
*/


include_once __DIR__.'/../../RRJS/Const/MySQL.php';
include_once __DIR__.'/../Class/MyPDO.php';
include_once __DIR__.'/StringFilter.php';


/*
Parameters:
    an array content user info 
Return:
    Insert or update user info success or not
*/
//Main function
function Subscribe($user_info) {
    if (CheckSubscribed($user_info["openid"])) {
        $res = Resubscribe($user_info["openid"]);
    }   
    else {
        $res = FirstSubscribe($user_info);
    }   
    return $res;
}



/*
Parameters:
    user openid
return
    unpate success info or not
*/
//not delete user info in data base , set DeleteMark to 1
function Unsubscribe($open_id) {
    $pdo = new MyPDO('RRJS' , MYSQL_USER , MYSQL_PASSWORD);
    $update_result = $pdo->Update('UserInfo' ,
                                  array('DeleteMark' , ) ,
                                  array(1 , ) ,
                                  array('int' , ) ,
                                  array('OpenID' , ) ,
                                  array('=' ,) ,
                                  array($open_id , ) ,
                                  array('string' , ) ,
                                  array()
                                 );
    return $update_result;
}


/*
Parameters:
    user openid
return:
    subscribed us return TRUE , else return FALSE 
*/
function CheckSubscribed($open_id) {
    $pdo = new MyPDO('RRJS' , MYSQL_USER , MYSQL_PASSWORD);
    $result = $pdo->RowExists('UserInfo' ,
                              array('ROW_ID' , ) ,
                              array('OpenID' , ) ,
                              array('=' , ) ,
                              array($open_id , ) ,
                              array('string' , ) ,
                              array()
                             );
    return $result;
}


/*
Parameters:
    an array content user info 
Return:
    Insert success or not
*/
function FirstSubscribe($user_info) {
    $pdo = new MyPDO('RRJS' , MYSQL_USER , MYSQL_PASSWORD);
    if (!empty($pdo->GetErrorMessage())) {
        //connect to database error
        exit;
    }
    //could not use function file_get_contents , that will time out
    $curl_head_image = curl_init($user_info['headimgurl']);
    curl_setopt($curl_head_image , CURLOPT_RETURNTRANSFER , TRUE);
    $head_image = curl_exec($curl_head_image);
    curl_close($curl_head_image);
    file_put_contents(__DIR__.'/../Media/UserHeadImg/'.$user_info['openid'].'.jpg' , $head_image);
    $user_info["nickname"] = StringFilter($user_info["nickname"]);
    $insert_result = $pdo->Insert('UserInfo' ,
                                  array('OpenID' , 'Sex' , 'HeaderImg' , 'NickName' , 'Province' , 'City' , 'Longitude' , 'Latitude' , 'CreateDate' , 'BonusPoints') ,
                                  array($user_info["openid"] , $user_info["sex"] , $user_info["openid"].'.jpg' , $user_info["nickname"] , $user_info["province"] , $user_info["city"] , 0 , 0 , date('Y-m-d H:i:s') , 0) ,
                                  array('string' , 'int' , 'string' , 'string' , 'string' , 'string' , 'string' , 'string' , 'string' , 'int')
                                 );
    return $insert_result;
}


/*
Parameters:
    user openid
return
    unpate success info or not
*/
function Resubscribe($open_id) {
    $pdo = new MyPDO('RRJS' , MYSQL_USER , MYSQL_PASSWORD);
    $update_result = $pdo->Update('UserInfo' ,
                                  array('DeleteMark' , ) ,
                                  array(0 , ) , 
                                  array('int' , ) ,
                                  array('OpenID' , ) , 
                                  array('=' ,) ,
                                  array($open_id , ) , 
                                  array('string' , ) , 
                                  array()
                                 );  
    return $update_result;
}
