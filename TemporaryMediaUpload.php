<?php


/*
File: TemporaryMediaUpload.php
Desc: Upload the temporary media file
Auth: lyd
Date: 2017-07-15
==============================
Change History
==============================
*/


include_once __DIR__.'/../../RRJS/Const/ConstValue.php';
include_once __DIR__.'/../Class/UseInterface.php';
include_once __DIR__.'/../Class/GetAccessToken.php';


//Add media url need type in the url end
const ADD_TEMPORARY_MEDIA_URL = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=';
const UPLOAD_DIR = '../Media/Upload/';


function CheckTemporaryFileType($media_type , $filename_extension) {
    switch ($media_type) {
        case 'image' :
            if (!in_array($filename_extension , array('jpg' , 'png' , 'jpeg' , 'gif'))) {
                echo 'Image just support format : jpg , png , jpeg , gif ';
                return FALSE;
            }
            break ;
        case 'voice' :
            if (!in_array($filename_extension , array('amr' , 'mp3'))) {
                echo 'Voice just support format : amr , mp3';
                return FALSE;
            }
            break ;
        case 'video' :
            if ($filename_extension != 'mp4') {
                echo 'Video just support format : mp4';
                return FALSE;
            }
            break ;
        case 'thumb' :
            if ($filename_extension != 'jpg') {
                echo 'Thumb just support format : jpg';
               return FALSE;
            }
            break ;
        default :
            echo "= = I don't know what media type you had select ... why could have this bug ????????? heirenwenhao";
            return FALSE;
    }
    return TRUE;
}


$access_token = new GetAccessToken();
$access_token = $access_token->Get();
$storage_time = $_POST['StorageTime'];
$media_type = strtolower($_POST['MediaType']);
$filename = strtolower($_FILES['MediaFile']['name']);
$filename_extension = explode('.' , $filename)[count(explode('.' , $filename)) - 1];
move_uploaded_file($_FILES['MediaFile']['tmp_name'] , UPLOAD_DIR.$filename);
if ($storage_time == 'Temporary') {
    $check_type_result = CheckTemporaryFileType($media_type , $filename_extension);
    if (!$check_type_result) {
        exit ;
    }
    $add_media = new UseInterface(ADD_TEMPORARY_MEDIA_URL.$access_token.'&type='.$media_type , ['file' => new CURLFile(realpath(UPLOAD_DIR.$filename)) , ]);
    $add_media_ret = $add_media->Run();
    if (!$add_media_ret) {
        exit ('<h1> Upload  error </h1>');
    }
    else {
        if ($add_media_ret['errcode']) {
            echo $add_media_ret['errmsg'];
        }
        else {
            //**********
            //save to date base
            //**********
            rename(UPLOAD_DIR.$filename , UPLOAD_DIR.$add_media_ret['media_id'].'.'.$filename_extension);
            echo 'Media ID : '.$add_media_ret['media_id'].'<br/><br/><br/>visit at : '.BASE_URL.'Media/Upload/'.$add_media_ret['media_id'].'.'.$filename_extension;
        }
    }
}
else {
    echo "..............................I don't know what happened , unknow storage time , are you come from https://renrenjieshu/HTML/TemporaryMediaUpload.html ? ";
}
