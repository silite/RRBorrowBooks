<?php
include_once __DIR__.'/Set_RRJS_ID.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>我的</title>
<style>
*{
        margin: 0;
        font-family: heiti SC;
}
body{
        background-color:#f6f6f6;
}
a{
        text-decoration:none;
        background-color:white;
}
p{
        style: none;
}
.word{
        font-size: 4vw;
        color: #999999;
        position: relative;
        bottom: 0.5vw;
        left: 5vw;
}
.words{
        font-size: 4vw;
        color: #999999;
}
.Userpicture{
        border-radius: 50%;
        float: left;
        width: 18vw;
        height: 18vw;
}
.Username{
        font-size: 6vw;
        color: #333333;
}
.money{
	position:absolute;
	top:16vw;
        color: #999999;
        font-size: 4vw;
}
.information2{
        display: block;
        margin-left: 24vw;
}
.information{
        padding-top: 2vw;
        padding:4vw;
        padding-left: 5vw;
        background-color: white;
        height: 18vw;
}
.Id{
        position: absolute;
        top: 7vw;
        right: 6vw;
        text-align: center;
}
.ID{
        font-size: 4vw;
        color: #999999;
}
.list ul{
        width: 100vw;
        list-style: none;
        height: 18vw;
        margin-left: -10vw;
}
.list li{
        width: 33vw;
        float: left;
        text-align: center;
}
.list a{
        width: 100%;
}
.list p{
        height: 10vw;
}
.list{
        width: 100vw;
        padding-top: 1vw;
        border-top: 0.2vw solid #e5e5e5;
        background-color: white;
}
.numberone{
        font-size: 8vw;
        color: #ff9090;
}
.numbertwo{
        font-size: 8vw;
        color: #63a5f0;
}
.numberthree{
        font-size: 8vw;
        color: #f7b321;
}
.icon{
        width: 4.5vw;
        height: 4.5vw;
        padding-top: 3.5vw;
        padding-left: 3.5vw;
}
.qiandao{
        position: absolute;
        right: 5vw;
        bottom: 40vw;
        border-radius: 50%;
        width: 20vw;
        height: 20vw;
}
.two{
        margin-top: 2vw;
        height: 24vw;
        background-color: white;
}
.three{
        margin-top: 2vw;
        height: 24vw;
        background-color: white;
}
.four{
        margin-top: 2vw;
        height: 12vw;
        background-color: white;
}
.enter{
        padding-top: 3.5vw;
        padding-right: 4vw;
        float: right;
        width: 5vw;
        height: 5vw;
}
.hide{
        display: none;
}
.first{
        position: absolute;
        top: 0;
        z-index: 1;
        background:rgba(0,0,0,0.5);
        width: 100%;
        height: 100%;
}
.second{
        width: 100%;
        top: 0;
}
.third{
        position: absolute;
        top: 48vw;
        left: 35vw;
        width: 30vw;
        height: 30vw;
}
.forth{
        position: absolute;
        top:80vw;
        left: 30vw;
        color: #999999;
        font-size: 5vw;
}
.line1{
        position: absolute;
        height: 13vw;
        border-right: 0.1vw solid #e5e5e5;
        top: 29vw;
        left: 33vw;
}
.line2{
        position: absolute;
        height: 13vw;
        border-right: 0.1vw solid #e5e5e5;
        top: 29vw;
        right: 33vw;
}

/* footer部分 */
#footer{
    position: fixed;
    bottom: 0;
    height: 13.07vw;
    width: 100%;
    padding-bottom: 3vw;
    background-color: rgba(255,255,255,0.95);
    border-top: 0.5px solid #eee;
    z-index: 5;
}

#footer ul li{
    display: inline-block;
    text-align: center;
}
#footer ul li a{
    display: block;
    height: 100%;
    width: 100%;
    line-height: 4vw;
}
#footer ul li a img{
    width: 5.86vw;
    height: 5.86vw;
}
#footer ul li a span{
    color: #999;
    font-size: 2.66vw;
    text-align: center;
}
a.active span{
    color: #f9b303;
}
/* footer部分 */

</style>
</head>
<body>
<?php
        $OpenID = $_COOKIE['RRJSID'];
        require_once 'PersonalDetailsFetch.php';
	require_once 'GetDeposit.php';
        $result_Detail = PersonalDetailsFetch($OpenID);
        $get_old_header_image = 'ls '.__DIR__.'/../Media/UserHeadImg/ | grep '.$OpenID.'.*';
        $src = `$get_old_header_image`;
	$deposit = GetDeposit($OpenID);
?>
<div>
<div class="information">
<img src="<?php echo '/../Media/UserHeadImg/'.$src; ?>" class="Userpicture">
<div class="information2">
<p class="Username"><?php echo $result_Detail['NickName']; ?></p>
<p class="money">押金&yen;<span class="moneys"><?php echo $deposit; ?></span></p>
</div>
<span class="Id"><img src="../Imgs/ID@3x.png" width="30px" height="30px"><p class="ID"><?php echo $result_Detail['RENRENID']; ?></p></span>
<?php
    //  这里order为读取数据库第i+1个地址    可以优化
    if(!isset($_GET['AddOrder'])) {
        if (isset($_COOKIE['AddOrder']))
            $AddOrder = $_COOKIE['AddOrder'];
        else
            $AddOrder = 0;
    }
    else
        $AddOrder = $_GET['AddOrder'];
    //    建立cookie的目的为了让site_.php页面的地址高亮
    setcookie("AddOrder",$AddOrder,time()+9999*9999);

    require_once 'BorrowedFetch.php';
    require_once 'ReturnedFetch.php';
    require_once 'AspirationFetch.php';
    require_once 'JudgeSign.php';
    $ModifyDate = JudgeSign();
    $ModifyDate = explode(' ',$ModifyDate);
    $now =  date('Y-m-d');
    if($now == $ModifyDate[0])
        $JudgeSign = 0;
    else
        $JudgeSign = 1;
    $result_borrowed = BorrowedBBooksFetch($OpenID,true);
    $len_borrowed = count($result_borrowed);
    $result_returned = ReturnedBooksFetch($OpenID,true);
    $len_returned = count($result_returned);
    $result_aspiration = AspirationBooksFetch($OpenID,true);
    $len_aspiration = count($result_aspiration);
?>
</div>
<div class="list">
<ul>
<a href="Order.php?id=1"><li><p class="numberone"><?php echo $len_borrowed ?></p><p class="words">已借书单</p></li></a>
<a href="Order.php?id=2"><li><p class="numbertwo"><?php echo $len_returned ?></p><p class="words">归还书单</p></li></a>
<a href="Order.php?id=3"><li style="border: none;"><p class="numberthree"><?php echo $len_aspiration ?></p><p class="words">心愿书单</p></li></a>
</ul>
</div>
</div>


<div class="two">
<a href="PersonInformation.php"><p style="height: 50%;"><img src="../Imgs/个人信息icon@3x.png" class="icon"><span class="word">个人信息</span><img src="../Imgs/arrow_right@3x.png" class="enter"></p></a>
<a href="site_.php?add=personal"><p style="border-top: 0.2vw solid #eeeeee"><img src="../Imgs/地址管理.png" class="icon"><span class="word">地址管理</span><img src="../Imgs/arrow_right@3x.png" class="enter"></p></a>
</div>

<div class="three">
<a href="credits.php"><p style="height: 50%"><img src="../Imgs/积分兑换.png" class="icon"><span class="word">积分兑换</span><img src="../Imgs/arrow_right@3x.png" class="enter"></p></a>
<a href="Wdkq.php"><p style="border-top: 0.2vw solid #eeeeee"><img src="../Imgs/我的卡券.png" class="icon"><span class="word">我的卡券</span><img src="../Imgs/arrow_right@3x.png" class="enter"></p></a>
</div>

<a href="Taunt.php"><div class="four">
<p><img src="../Imgs/意见反馈.png" class="icon"><span class="word">意见反馈</span><img src="../Imgs/arrow_right@3x.png" class="enter"></p>
</div></a>

<?php 
if (0 != $JudgeSign) {
echo '<div>
<img id="sign" src="../Imgs/签到@3x.png" class="qiandao">
</div>';
}
?>

<div class="hide" id="qian" onclick="hidd()">
<img src="../Imgs/签到弹出@3x.png" class="second">
<img src="../Imgs/签到积分图标@3x.png" class="third">
<p class="forth">日常签到+10积分</p>
</div>
<!-- 下面是footer 导航栏部分 -->
<div id="footer" >
    <ul style="padding-left: 0">
        <li style="margin: 2.13vw 14% 1.06vw 11.3%; ">    <!--第一个-->
            <a href="../HTML/HomePage.php" >
                <img src="../Imgs/FooterImgs/首页-nor@3x.png"><br/>
                <span>首页</span>
            </a>
        </li>

        <li style="margin: 2.13vw 16% 1.06vw 0%">      <!--第二个-->
            <a href="Recommend.php">
                <img src="../Imgs/FooterImgs/推荐-nor@3x.png" ><br/>
                <span>推荐</span>
            </a>
        </li>
        <li style="margin: 2.13vw 17% 1.06vw 0%">           <!--第三个-->
            <a href="1111.php">
                <img src="../Imgs/FooterImgs/订单-nor-1@3x.png" ><br/>
                <span>订单</span>
            </a>
        </li>
        <li style="margin: 2.13vw 0 1.06vw 0" class="active">                <!--第四个-->
            <a href="">
                <img src="../Imgs/FooterImgs/我的-click@3x.png" ><br/>
                <span style="color: #f9b303">我的</span>
            </a>
        </li>
    </ul>
</div>

<div class="line1"></div>
<div class="line2"></div>

<script src="../JS/jquery.min.js"></script>

<script>
function hidd(){
	var b = document.getElementById("qian");
	b.className = "hide";
	location.href = 'PersonalCenter.php';
}
	$("#sign").click(function(){
        var RENRENID = <?php echo $result_Detail['RENRENID']; ?>;
        var JudgeSign = <?php echo $JudgeSign; ?>;
       if(JudgeSign==0)
	alert("每天只能签到一次～");
        else{
        $.ajax({
            url:'BP.php',
            type:"POST",
            data:{RENRENID:RENRENID},
            success:function(){
					var a = document.getElementById("qian");
					a.className = "first";
            }
        });
		}
    });
</script>
</body>

</html>
