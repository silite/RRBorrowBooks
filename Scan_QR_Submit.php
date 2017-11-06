<?php
session_start();
include_once __DIR__.'/../PHP/Set_RRJS_ID.php';
include_once __DIR__.'/../Class/MyPDO.php';
include_once __DIR__.'/../../RRJS/Const/MySQL.php';
include_once __DIR__.'/../Class/MyLog.php';
//$book_id content ISBN 13 and book code
$book_id = $_GET['state'];
$pdo = new MyPDO('RRJS' , MYSQL_USER , MYSQL_PASSWORD);
$book_info = $pdo->Select('BookInfo' ,
                          array('ROW_ID' , 'Title' , 'SubTitle' , 'Author' , 'Price') ,
                          array('LISBN' , ) ,
                          array('=' , ) ,
                          array(substr($book_id , 0 , 13) , ) ,
                          array('string' , ) ,
                          array()
                         );
$book_info = $book_info[0];
if (!$book_info) {
    $log = new MyLog();
    $log->Log(2 , 'User scan a book but not identify it , book id :'.$book_id);
    exit('<h1>Something Error = =</h1>');
}
include_once __DIR__.'/../Class/WXPay.php';
$order = new WXPay($RRJSID);
$order_number = $order->GenerateOrderNumber();
$TYXD = $order->TYXD(array('body' => 'RRJS-BOOK' ,
		'total_fee' => '100' ,
		'spbill_create_ip' => $_SERVER['REMOTE_ADDR'] ,
		'notify_url' => 'https://renrenjieshu.com/PHP/ReceivePayAsyncNotify.php'
		)
	);

if ('SUCCESS' != $TYXD->return_code) {
	$log = new MyLog();
	$log->Log(2 , 'SUCCESS != $TYXD->return_code : '.var_export($TYXD ,TRUE));
	echo '~~~~~~~~~~~~~~~~~~~some thing error ~~~~~~~~~~~~~~~~~~~~~~~~';
}
$js_appid = APP_ID;
$js_timestamp = time();
$js_nonceStr = WXPay::GetNonceStr();
$js_package = 'prepay_id='.$TYXD->prepay_id;
$js_signType = 'MD5';
$sign_array = array('appId'=>$js_appid , 'timeStamp'=>$js_timestamp , 'nonceStr'=>$js_nonceStr , 'package'=>$js_package , 'signType'=>$js_signType);
$js_paySign = WXPay::GenerateSign($sign_array);
$sign_array['paySign'] = $js_paySign;
$js_sign_data = json_encode($sign_array);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../CSS/city.css">
    <script type="text/javascript" src="../JS/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="../JS/city4.city.js"></script>
    <script type="text/javascript" src="../JS/city4.js"></script>

<style>
*{
    margin: 0;
    padding: 0;
}
body
{
    background-color: #f6f6f6;
    overflow: hidden;
}
#main{
    z-index: 2;
}
#site
{
    height: 18vw;
    line-height: 18vw;
    font-size: 1rem;
    border-top:0.5px #ccc solid;
    border-bottom:0.5px #ccc solid;
    background-color: white;
}
#site a
{
    text-decoration: none;
    color: #555;
}
#site a p{
    margin-left: 3vw;
}
#site a span:first-child
{
    font-weight: 900;
}

#book-information
{
    position: relative;
    margin-top: 3vw;
    height: 40vw;
    background-color: white;
    border-top:0.5px #ccc solid;
    border-bottom:0.5px #ccc solid;
}
.book-imge
{
    position: absolute;
    height: 70%;
    width: 25%;
    left: 3%;
    top: 15%;
    float: left;
}
#book-information .book-name
{
    position: absolute;
    top: 15%;
    left:31%;
    letter-spacing: 2%;
    color: #333;
	font-size:1.2em;
	white-space: nowrap;
	overflow: hidden;
	-o-text-overflow: ellipsis;
	text-overflow: ellipsis;
	width: 50%;
}
#book-information .author
{
	position:absolute;
	top:35%;
	left:31%;
	color:#666;
	font-size:1em;
}
#book-information .cash
{
    position: absolute;
    bottom: 15%;
    left: 31vw;
    color: #999;
	font-size:1em;
}
#book-information .count
{
    position: absolute;
    bottom: 15%;
    right: 10%;
    color: #999;
	font-size:1em;
}
#table
{
    height: 52vw;
    width: 100%;
    background-color: white;
    border-top:0.5px #ccc solid;
    border-bottom:0.5px #ccc solid;
    margin-top: 3vw;
}
#table tr
{
    display:inline-block;
    border-bottom: 0.5px #ccc solid;
    width: 97%;
    padding: 2% 0 ;
    margin-left: 3%;
    color: #333;

}
#table td:nth-child(even)
{
    position: relative;
    text-align: center;
    width: 25vw;
    left: 34vw;
    /*padding: 4% 0;*/
    height: 8vw;
    margin: 0;
    color: #666;
}
#table span
{
    position: absolute;
    left: 86vw;
    color: #666;
}
 #table .end
{
    position: relative;
    left: 66vw;
    padding: 20vw auto;
}
#cashpledge
{
    border:0.5px #ccc solid;
}
#rentSum
{
     border:0.5px #ccc solid;
}
#table button
{
    background-color: white;
    font-size: 1rem;
    margin: 0;
}
#down
{
    width: 7vw;
    height: 8vw;
    color: #ccc;
    border:0.5px #ccc solid;
    border-right: none;
}
#table .out
{
    width: 7vw;
    height: 8vw;
    color: #666;
    border-color: #666;
}
#number 
{
    width: 10.5vw;
    height: 8vw;
    border:0.5px #666 solid;
}
#up
{
    width: 7vw;
    height: 8vw;
    border:0.5px #666 solid;
    border-left:none;
}
#table .hide
{
    width: 7vw;
    height: 8vw;
    color: #ccc;
    border-color:#ccc;
}
#buttons
{
    position: fixed;
    bottom: 0;
    height: 14vw;
    width: 100%;
}
#buttons>*
{
    height: 100%;
    width: 50%;
    border:none;
    float: left;
    text-decoration: none;
    font-size: 1.2rem;
}
#buttons .button1
{
    background-color: white;
    color: #999;
}
#buttons .button2
{
    background-color:#fb8a1c;
    color: white;
}
#grayBack{
    display: none;
    background-color: #000;
    -moz-opacity:0.6;opacity: 0.6;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 3;
}
#addAddress{
/*     display: none; */
    max-height: 566px;
    background-color: #fff;
    color: #000;
    position: fixed;
    left: 0;
    right: 0;
    bottom: -566px;
    z-index: 4;
    font-size: 3.73vw;
}
.setInput{
    height: 8vw;
    line-height: 8vw;
    margin: 2.67vw 0;
    margin-bottom: 3px;
}

.setInput > span{
    display: inline-block;
    width: 14.93vw;
    text-align: right;
}
.setInput input{
    width: 73vw;
    height: 100%;
    padding-left: 1.5vw;
    border: 1px solid #eee;
    border-radius: 5px;
    margin-left: 1vw;
}
#addAddress *{
    font-size: 3.73vw;
}
#contentAddress{
    width: 95%;
    margin: 0 auto;
    position: relative;
}
#submitAddress{
    display: block;
    /* position: fixed;
    bottom: -100px; */
    border: none;
    border-radius: 4px;
    width: 94%;
    height: 8vw;
    color: #fff;
    background-color: #fb8a1c;
    margin: 0 auto 1.5vw;
    font-size: 4.27vw;
}
/* 下面是点击效果的button样式 */
.button {
    margin: 0;
    position: relative;
    /* min-width: 1vm; */
    display: inline-block;
    color: #555;
}
.button.styl-material:focus{
    outline: none;
}
.ripple-obj {
    height: 100%;
    pointer-events: none;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 0;
    width: 100%;
    fill: #999;
}

</style>
</head>
<body>
    <svg style="display: none;">
        <symbol id="ripply-scott" viewBox="0 0 100 100">
            <circle id="ripple-shape" cx="1" cy="1" r="1" />
        </symbol>
    </svg>
    <form id="main" action="PHP/index.php" method="get">
        <div id="site">
            <a href="#" style="display: block; width: 100%;height: 100%">
                <p><span>+</span><span>添加收货地址</span></p>
            </a>
        </div>

        <div id="book-information">
            <img class="book-imge" src="<?php  echo '../Media/BookPic/M_'.$book_info['ROW_ID'].'.jpg' ?>" />
            <p class="book-name"><?php echo $book_info['Title'] ?></p>
			<p class="author"><?php echo $book_info['Author'] ?></p>
            <p class="cash">押金:<?php echo $cash_pledge = ((floor((float)($book_info['Price']) * RATIO) == 0) ? 30 : (floor((float)($book_info['Price']) * RATIO))) ?>元/本</p>
            <p class="count">数量:x1</p>
        </div>

        <table id="table">
                <tr>
                    <td>借书时长<span>周</span></td>
                    <td class="choose-buttons">
                        <button type="button" id="down">-</button><button type="button" id="number">1</button><button type="button" id="up">+</button>    <!--表单元素-->
                    </td>
                </tr>
                <tr>
                    <td>押金合计<span>元</span></td>
                    <td id="cashpledge"><?php echo $cash_pledge ?></td>
                </tr>
                <tr>
                    <td>租金合计<span>元</span></td>
                    <td id="rentSum">1</td>
                </tr>
                <tr style="border:none;">
                    <td class="end">共计：<b id="sumMoney">1</b>元</td><td></td>               <!--表单元素-->
                </tr>
        </table>

            <div id="buttons">
                <button type="button" id="js-ripple-btn" class="button styl-material" style="background-color: #fff">取消
                    <svg class="ripple-obj" id="js-ripple">
                        <use height="100" width="100" xlink:href="#ripply-scott" class="js-ripple"></use>
                    </svg>
                </button>
                <button type="button" id="smt" style="background-color: #fb8a1c; color: #333">提交</button>
            </div>

        </div>
    </div>

    <div id="grayBack"></div>

    <div id="addAddress">
        <div id="contentAddress">
            <div class="setInput">
                <span>收书人:</span> 
                <input type="text" placeholder="请输入收书人姓名">            <!--表单元素-->
            </div>
            <div class="setInput">
                <span>手机号:</span>
                <input type="text" placeholder="请输入收书人手机号码">          <!--表单元素-->
            </div>
            <!-- start 高校选择器 -->
            <div class="infolist" style="padding: 0; float: left;">
                <div class="liststyle">
                        <p style="display: inline-block;width: 14.93vw; text-align: right; margin-right: 1vw">地&nbsp;&nbsp;&nbsp;区:</p>
                        <span id="Province" >
                            <i>省份</i>
                            <ul style="max-height: 80px; width: 100%; overflow-y: scroll;">
                                <li><a href="javascript:void(0)" alt="省份">省份</a></li>
                            </ul>
                            <input type="hidden" name="cho_Province" value="省份" >           <!--表单元素-->
                        </span>
                        <span id="City">
                            <i>城市</i>
                            <ul style="max-height: 80px; width: 100%; overflow-y: scroll;">
                                <li><a href="javascript:void(0)" alt="城市">城市</a></li>
                            </ul> 
                            <input type="hidden" name="cho_City" value="城市">           <!--表单元素-->
                        </span>
                        <span id="Area">
                            <i>地区</i>
                            <ul style="max-height: 80px; width: 100%; overflow-y: scroll;">
                                <li><a href="javascript:void(0)" alt="地区">地区</a></li>
                            </ul>
                            <input type="hidden" name="cho_Area" value="地区">         <!--表单元素-->
                        </span><br>
                        
                        
                        <p style="display: inline-block;width: 14.93vw; text-align: right; margin-right: 1vw">高&nbsp;&nbsp;&nbsp;校:</p>
                        <span id="Insurer">
                            <i>高校</i>
                            <ul style="max-height: 80px; width: 100%; overflow-y: scroll;">
                                <li><a href="javascript:void(0)" alt="高校">高校</a></li>
                            </ul>
                            <input type="hidden" name="cho_Insurer" value="高校">    <!--表单元素-->
                        </span>
                </div>
                <div class="setInput" style="margin-top: 0;">
                    <span>详&nbsp;&nbsp;&nbsp;址:</span>
                    <input type="text" placeholder="请精确到宿舍号以方便送书">   <!--表单元素-->
                </div>
            </div>
        <!-- end 高校选择器 -->
            
            <button type="button" id="submitAddress">添加地址</button>
        </div>
    </div>

    <script>

                var smt = document.getElementById("smt");
                function jsApiCall()
                {
                        WeixinJSBridge.invoke(
                                'getBrandWCPayRequest',
                                <?php echo $js_sign_data ?>,
                                function(res){     
                                if(res.err_msg == "get_brand_wcpay_request:ok" ){
                                        location.href = "turn_to.php";
                                }
                                /*else{
                                        alert("支付失败:"+res.err_code + res.err_desc + res.err_msg);
                                } */     
                        }
                        );
                }

                function callpay()
                {
                        if (typeof WeixinJSBridge == "undefined"){
                            if( document.addEventListener ){
                                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
				}else if (document.attachEvent){
                                document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
                                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                            }
                        }else{
                            jsApiCall();
                        }
                }

                smt.onclick = callpay;

    sumMoney.innerHTML=parseInt(cashpledge.innerHTML)+parseInt(rentSum.innerHTML);
        down.onclick = function(){
            up.className="out";
            if(parseInt(number.innerHTML)==2)
                down.className="hide";
            if(parseInt(number.innerHTML) > 1){
                number.innerHTML--;
                rentSum.innerHTML--;
                sumMoney.innerHTML=parseInt(cashpledge.innerHTML)+parseInt(rentSum.innerHTML);
            }
        }
        up.onclick = function(){
            down.className="out";
            if(parseInt(number.innerHTML)==7)
                up.className="hide";
            if(parseInt(number.innerHTML) < 8){
                number.innerHTML++;
                rentSum.innerHTML++;
                sumMoney.innerHTML=parseInt(cashpledge.innerHTML)+parseInt(rentSum.innerHTML);
            }
        }
    </script>
    <script src="http://www.bitstorm.org/jquery/color-animation/jquery.animate-colors-min.js"></script>
    <script>
        $(function(){
            function turnTo(){
                $("#addAddress").animate({bottom: "0"},500)
                $("#submitAddress").animate({bottom: "0"},500);
                $("#grayBack").fadeIn(500);
            }
            function turnToBack(){
                $("#addAddress").animate({bottom: "-566px"},500);
                $("#submitAddress").animate({bottom: "-100px"},500);
                $("#grayBack").fadeOut(500);
            }
            $("#js-ripple-btn").click(function(){
                setTimeout(function(){
                    location.href = "http://www.baidu.com";           //指定跳转
                },200);
            });
            $("#site").click(turnTo);
            $("#grayBack").click(turnToBack);
        })
    </script>
    <script src="../JS/TweenMax.min.js"></script>
    <script src="../JS/ripple-config.js"></script>
</body>
</html>
