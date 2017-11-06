<?php
require_once 'LimitVisit.php';
include_once __DIR__.'/../Class/WXPay.php';
include_once __DIR__.'/../Class/GetAccessToken.php';
include_once __DIR__.'/../Class/GetJSApiTicket.php';
include_once __DIR__.'/../../RRJS/Const/ImportantData.php';
if (!($ticket = ((new GetJSApiTicket())->Get()))) {
    exit('Something Error(1)');
}
$app_id = APP_ID;
$time_stamp = time();
if (FALSE == ($nonce_str = WXPay::GetNonceStr())){
    exit('Something Error(2)');
}
$data = array('timestamp' => $time_stamp , 'noncestr' => $nonce_str , 'jsapi_ticket' => $ticket , 'url' => 'https://renrenjieshu.com/PHP/PersonInformation.php');
ksort($data , SORT_STRING);
$data_str = '';
foreach ($data as $key => $value) {
    $data_str .= $key.'='.$value.'&';
}
$data_str = substr($data_str , 0 , strlen($data_str) - 1);
$sign = sha1($data_str);
?>


<!doctype html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>个人信息</title>
<style>
*{
	margin: 0;
	padding: 0;
	font-family: heiti SC;
}
body{
	background-color: #f6f6f6;
	height: 603px;
	margin-top: 8%; 
}
div{
	background-color: white;
	border-top: 0.5px solid #cccccc;
	height: 7.2%;
}
.text{
	font-size: 1.07em;
	color: #333333;
}
.username{
	font-size: 1em;
	color: #999999;
	position:absolute;
	right:10vw;
}
.userpicture{
	position:absolute;
	right:5vw;
	border-radius: 50%;
}
.phonenumber{
	position:absolute;
	right:10vw;
}
.sex{
	position:absolute;
	right:10vw;
}
.block{
	position:relative;
	padding-top: 4%;
	padding-right: 4%;
	padding-left: 4%;
}
.block2{
	position: relative;
	padding-top: 4.5%;
	padding-right: 4%;
	padding-left: 4%;
}
.block3{
	position:relative;
	padding-top: 4.5%;
	padding-right: 4%;
	padding-left: 4%;
}
.block4{
	position:relative;
	padding-top: 4.5%;
	padding-right: 4%;
	padding-left: 4%;
	border-bottom: 0.5px solid #cccccc;
}
.button{
	width: 94%;
	left: 3%;
	text-align: center;
	background-color: #fb8a1c;
	border-radius:0.5em/0.5em;
	display: table-cell;
	line-height: 100%;
	padding-top: 4%;
	padding-bottom: 4%;
	position: absolute;
}
a{
	text-decoration:none;
	display:flex;
	color: white;
	flex-wrap: wrap;
}
.input{
	width:40vw;
	outline: none;
	border: none;
	text-align: right;
	color: #999999;
	font-size: 1em;
}
.select{
	border: none;
	color: #999999;
	font-size: 1em;
	-webkit-appearance: none;
	appearance: none;
	-moz-appearance: none;
	background: transparent;
	direction: rtl;
}
.back{
	background: #f6f6f6;
	border: 0;
	margin-top: 5%;
	position: relative;
}
</style>

</head>

<body>
<?php
    $OpenID = $_COOKIE['RRJSID'];
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $select = "SELECT NickName,Sex,PhoneNumber FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $result = $connID->query($select,'Row');
    $get_old_header_image = 'ls '.__DIR__.'/../Media/UserHeadImg/ | grep '.$OpenID.'.*';
    $src = `$get_old_header_image`;
?>

<div class="block">
<span class="text">用户头像:</span><span class="userpicture"><img id="headImg" src="<?php echo '../Media/UserHeadImg/'.$src;?>" width="36px" height="36px" class="userpicture"></span>
</div>

<div class="block2">
<span class="text">用户昵称:</span><span class="username"><input type="text" class="input" value="<?php echo $result['NickName']; ?>"></span>
</div>

<div class="block3">
<span class="text">选择性别:</span>
<span class="sex">
<select name="性别" class="select">
<option value="未知" <?php if($result['Sex'] == 0) echo 'selected'; ?>>未知</option>
<option value="男" <?php if($result['Sex'] == 1) echo 'selected'; ?>>男</option>
<option value="女" <?php if($result['Sex'] == 2) echo 'selected'; ?> >女</option>
</select>
</span>
</div>

<div class="block4">
<span class="text">联系电话:</span><span class="phonenumber"><input type="text" class="input" value="<?php if(empty($result['PhoneNumber'])) echo ""; else echo $result['PhoneNumber']; ?>"></span>
</div>
<div class="back">
<a href="PersonalCenter.php" class="button"><span>保存</span></a>
</div>
        <script src="../JS/jquery.min.js"></script>
        <script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
        <script >
                var localIds = {},
                    serverId = '';

                wx.config({
                    appId: '<?php echo $app_id ?>',
                    timestamp: <?php echo $time_stamp ?>,
                    nonceStr: '<?php echo $nonce_str ?>',
                    signature: '<?php echo $sign ?>',
                    jsApiList: ['chooseImage','uploadImage'] 
                });

                $('#headImg').click(function(){
                        wx.chooseImage({
                            count: 1,
                            sizeType: ['original', 'compressed'],
                            sourceType: ['album', 'camera'],
                            success: function (res) {
                                localIds = res.localIds;
                                $('#headImg').attr('src',localIds);
                            
                                
                               wx.uploadImage({
                                 localId: localIds.toString(), 
                                 isShowProgressTips: 1, 
                                 success: function (res){
                                      serverId = res.serverId;
                                      $.post('ChangeHeadImage.php',{'openId': '<?php echo $_COOKIE['RRJSID']?>','serverId': serverId});
                                 }
                               });
                            }
                        });
                 })
        </script>
</body>

</html>
