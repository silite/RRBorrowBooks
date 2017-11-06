<?php
    require_once 'LimitVisit.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单提交</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../CSS/Submit_style.css">
    <script type="text/javascript" src="../JS/jquery-1.8.0.min.js"></script>
    <style>
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
.setInput{/*     
    height: 8vw;
    line-height: 8vw;*/
    margin: 2.67vw 0;
    margin-bottom: 3px;
}

.setInput > span{
    display: inline-block;
    width: 14.93vw;
    vertical-align: middle;
    text-align: right;
}
.setInput input{
    width: 73vw;
    height: 8vw;
    line-height: 8vw;
    padding-left: 1.5vw;
    border: 1px solid #eee;
    border-radius: 5px;
    margin-left: 1vw;
}
#addAddress *{
    font-size: 3.73vw;
}
.infolist *{
    color: #000;
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
    width: 100%;
    height: 12vw;
    color: #fff;
    background-color: #fb8a1c;
    font-size: 4.27vw;
}
input[type=text]{
    -webkit-appearance: none;
    appearance: none;
}
.UserName
{
	position:absolute;
	left:10vw;
	top:3vw;
}
.PhoneNumber
{
	position:absolute;
	left:50vw;
	top:3vw;
}
.College
{
	position:absolute;
	left:10vw;
	top:10vw;
}
.Address
{
	position:absolute;
	left:50vw;
	top:10vw;
}
    </style>
</head>
<body>
<?php
    session_start();
    //    作为返回标志
    $_SESSION['judge'] = false;

    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();

    require_once 'UserAddressFetch.php';
    require_once 'JudgeToPay.php';
    require_once 'JudgePend.php';
    require_once 'JudgeLocalAdd.php';
    $OpenID = $_COOKIE['RRJSID'];

    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $select_BP_Card = "SELECT ROW_ID,ModifyM,ChangeDate,DeleteMark FROM BPDetail WHERE OpenID IN ('".$OpenID."') AND Detail = 2 AND DeleteMark = 0;";
    $select_book_price = "SELECT Price FROM BookInfo WHERE ROW_ID = '".$_SESSION['temp_ROW_ID']."';";
    $result_rowid = $connID->query($select,'Row');
    $BP_Card = $connID->query($select_BP_Card, 'All');
    $Price = $connID->query($select_book_price, 'Row');
    $Price = $Price['Price'];
    if($_SESSION['temp_ROW_ID'] == 'dd16cf33-9465-11e7-bb0f-00163e06cefc' || $_SESSION['temp_ROW_ID'] == '2a60374c-9466-11e7-bb0f-00163e06cefc' || $_SESSION['temp_ROW_ID'] == 'f0faf674-9464-11e7-bb0f-00163e06cefc' || $_SESSION['temp_ROW_ID'] == 'fec119a4-9461-11e7-bb0f-00163e06cefc' || $_SESSION['temp_ROW_ID'] == '45688bf9-9463-11e7-bb0f-00163e06cefc' || $_SESSION['temp_ROW_ID'] == '44dc55b6-9466-11e7-bb0f-00163e06cefc' || $_SESSION['temp_ROW_ID'] == '714370ec-9473-11e7-bb0f-00163e06cefc' ||  $_SESSION['temp_ROW_ID'] == '4be11fef-9473-11e7-bb0f-00163e06cefc' || $_SESSION['temp_ROW_ID'] == 'bd6d2bc1-9463-11e7-bb0f-00163e06cefc')
	$Price = 11;
    $len_BP_Card = count($BP_Card);
    $UserID = $result_rowid['ROW_ID'];
    $result = UserAddressFetch($OpenID,'All');

    if(!isset($_GET['AddOrder'])) {
        if (isset($_COOKIE['AddOrder']) && !empty($result[$_COOKIE['AddOrder']]))
            $AddOrder = $_COOKIE['AddOrder'];
        else
	    if(!empty($result[0]))
            	$AddOrder = 0;
    }
    else
        $AddOrder = $_GET['AddOrder'];
     setcookie("AddOrder",$AddOrder,time()+9999*9999);

//    获得用户openID     判断库中是否有信息   没有的话执行此句
    if(empty($result)) {
        echo '<div class="site" id="site1">
            <div style="display: block; width: 100%;height: 100%">
                <p class="site-add"><span>+</span><span id="JudgeSubmit">添加收货地址</span></p>
            </div>
        </div>';
    }
    else{
        echo '<div class="site" id="site2">
            <a id="set_href" style="display: block; width: 100%;height: 100%">
		<img src="../Imgs/site.png" class="site-img"/>
                <div class="site-name"> <span class="UserName">'.$result[$AddOrder]['UserName'].'</span><span class="PhoneNumber">'.$result[$AddOrder]['PhoneNumber'].'</span><p><span class="College">'.$result[$AddOrder]['College'].'</span><span class="Address">'.$result[$AddOrder]['Address'].'</span></p></div>
            <veToPay = JudgeHaveToPay($UserID,$UserID);$HaveToPay = JudgeHaveToPay($UserID,$UserID);$HaveToPay = JudgeHaveToPay($UserID,$UserID);/a>
        </div>';
        $_SESSION['address_ROW_ID'] = $result[$AddOrder]['ROW_ID'];
   }

//地址存入操作
    if(isset($_GET['submitAddress']))
    {
        $UserName = $_GET['UserName'];
        $PhoneNumber = $_GET['PhoneNumber'];
	$College = '湖南科技大学';
        $Address = $_GET['Address'];

        $arrayDataValue = array("ROW_ID"=> 'UUID()',
	    "UserID" => "'$UserID'",
            "College"=>"'$College'",
	    "Address" => "'$Address'",
            "UserName"=>"'$UserName'",
            "PhoneNumber"=>"'$PhoneNumber'");
        $connID->insert('UserAddress',$arrayDataValue);
            echo"<script>alert('恭喜！您的信息提交成功！'); location.href = 'Submit.php' </script>";
    }

    include_once __DIR__.'/../Class/WXPay.php';
    $order = new WXPay($OpenID);
    $OrderNo = $order->GenerateOrderNumber();
    $DeliveredInfo = $_SESSION['address_ROW_ID'];
    $BookID = $_SESSION['temp_ROW_ID'];

    $HaveBook = JudgeLocalAdd($BookID,$DeliveredInfo);

    $HaveToPay = JudgeHaveToPay($UserID,$BookID);
    $HavePend = JudgePend($BookID,$UserID);
    
    $ip = $_SERVER['REMOTE_ADDR'];
    /*$TYXD = $order->TYXD(array('body' => 'Book' ,
                               'total_fee' => "1" ,
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
    //$js_timestamp = time();
    $js_timestamp = date('Y-m-d');
    $js_nonceStr = WXPay::GetNonceStr();
    $js_package = 'prepay_id='.$TYXD->prepay_id;
    $js_signType = 'MD5';
    $sign_array = array('appId'=>$js_appid , 'timeStamp'=>$js_timestamp , 'nonceStr'=>$js_nonceStr , 'package'=>$js_package , 'signType'=>$js_signType);
    $js_paySign = WXPay::GenerateSign($sign_array);
    $sign_array['paySign'] = $js_paySign;
    $js_sign_data = json_encode($sign_array);*/

    // 判断在订单中再下单出现OrderNo不一致
?>

<svg style="display: none;">
    <symbol id="ripply-scott" viewBox="0 0 100 100">
        <circle id="ripple-shape" cx="1" cy="1" r="1" />
    </symbol>
</svg>
<form>
    <div id="book-information">
        <img class="book-imge" src="<?php echo $_SESSION['temp_images_medium'] ?>" />
        <p class="book-name"><?php echo $_SESSION['temp_Title']; ?></p>
        <p class="author"><?php echo $_SESSION['temp_Author']; ?></p>
        <p class="cash">押金:<?php if(!$_SESSION['temp_Price'] == '0') echo round($_SESSION['temp_Price']*0.6);?>元/本</p>
        <p class="count">数量:x1</p>
    </div>
    <table id="table">
        <tr>
            <td>借书时长<span>周</span></td>
            <td class="choose-buttons">
                <button type="button" id="down">-</button><button type="button" id="number">1</button><button type="button" id="up">+</button>    <!--表单元素-->
                <input type="hidden" id="week" name="week" value="1">
            </td>
        </tr>
        <tr>
            <td>押金合计<span>元</span></td>
            <td id="cashpledge"><?php if(!$_SESSION['temp_Price'] == '0') echo round($_SESSION['temp_Price']*0.6);?></td>
        </tr>
        <tr>
            <td>租金合计<span>元</span></td>
            <td id="rentSum"><?php echo round(floor($Price*9)/10)/10; ?></td>
        </tr>
	<tr id="useCardTr" style="height: 8vw; line-height: 8vw;">   <!--PHP进行判断，判断是否有卡券，对下面的span进行处理
									如果有，id="canUse",   内容:"点击使用卡券 &gt;"
									反之，  id="",         内容:"暂无可用卡券 &gt;" --> 
						       
    <?php
	if($len_BP_Card == 0)   //left:74.5
	    echo '<td>可用卡券<span id="" style="left: 61vw; color: #999">暂无可用卡券</span></td>';
	else
	    echo '<td>可用卡券<span id="canUse" style="left: 61vw;  color: #999">点击使用卡券 &gt;&gt;</span></td>';
    ?>
            
        </tr>
        <tr style="border:none;">
            <td class="end" style="left: 57vw;">共计：
                <b id="sumMoney">
                </b>元
            </td>
            <td>
            </td>               <!--表单元素-->
        </tr>
    </table>
    
    <div id="useCard">
	<p>可用卡券</p>                <!--PHP判断，data-card为周数-->
	<div id="cardInfo">
	<?php
	    for($i = 0;$i < $len_BP_Card;$i++)
	    {
		if($BP_Card[$i]['ModifyM'] == '500')
		    echo '<div data-card="1">
               	       	      <img src="../Imgs/1周券券@3x.png" />
               		      <img class="selector" src="../Imgs/selector-icon@3x.png" />
            		  </div>';
		else
		    echo '<div data-card="2">
                	      <img src="../Imgs/2周券券@3x.png" />
                	      <img class="selector"  src="../Imgs/selector-icon@3x.png" />
            		 </div>';
	    }
	?>
	</div>
	<button type="button">返回</button>
    </div>

    <div id="buttons">
        <button type="button" id="js-ripple-btn" class="button styl-material" style="background-color: #fff">取消
            <svg class="ripple-obj" id="js-ripple">
                <use height="100" width="100" xlink:href="#ripply-scott" class="js-ripple"></use>
            </svg>
        </button>
        <button type="button" id="mmp1" style="background-color: #fb8a1c; color: white">提交</button>
    </div>
</form>
<form id="main" onsubmit="return checkInput()" name="addForm">
     <div id="grayBack"></div>
     <div id="addAddress">
        <div id="contentAddress">
            <div class="setInput">
                <span>收书人:</span>
                <input id="receive" name="UserName" type="text" placeholder="请输入收书人姓名">            <!--表单元素-->
            </div>
            <div class="setInput">
                <span>手机号:</span>
                <input id="phone-number" name="PhoneNumber"  type="text" placeholder="请输入收书人手机号码">          <!--表单元素-->
            </div>
            <div class="setInput">
                <span>高 校:</span>
                <input  type="text" align="center"  name="cho_Insurer" id="cho_Insurer" value="湖南科技大学" disabled>          <!--表单元素-->
            </div>
            <div class="setInput" style="padding-bottom: 1.8vw;" >
                <span>详&nbsp;址:</span>
                <input id="dormitory" name="Address" type="text" placeholder="请精确到宿舍号以方便送书">   <!--表单元素-->
            </div>
        </div>
        <button name="submitAddress"  type="submit" id="submitAddress" value="mmp">保存并使用</button>
    </div>
</form>
    <script src="../JS/JudgeInput.js"></script>
    <script>
	var step = '<?php echo round(floor($Price*9)/10)/10; ?>';
	function checkInput(){
	    var phone = judge($("#phone-number").val()),
                    recv = judge($("#receive").val()),
                    dmt = judge($("#dormitory").val());
                $("#phone-number").val(phone);
                $("#receive").val(recv);
                $("#dormitory").val(dmt);

                if($("#receive").val() == "" || $("#phone-number").val().length != 11 || isNaN($("#phone-number").val()) || $("#dormitory").val() == ""){
                    alert("请填写正确信息!");
		    return false;
		}
		else {
		    return true;
		}
	}
        $("#week").val("1");
        var HaveToPay = '<?php echo $HaveToPay ?>';
        var OrderNo = '<?php echo $OrderNo ?>';
        var UserID = '<?php echo $UserID ?>';
        var DeliveredInfo = '<?php echo $DeliveredInfo ?>';
        var BookID= '<?php echo $BookID ?>';
	var First_click = true;
	var HavePend = '<?php echo $HavePend; ?>';
	var HaveBook = '<?php if($HaveBook == '0') echo $HaveBook; else echo '1'; ?>';
	var IP = '<?php echo $ip; ?>';
	var js_sign_data = '';

        
	function convertData(){
               var x = $("#sumMoney").html();
	       //alert(x);
	       var week = $("#rentSum").html() / step;
		week = Math.round(week);
	       if(First_click)
		   First_click = false;
	       else
		   HaveToPay = 1;
	   
               if(HavePend == 0 && HaveBook == 1){
	          $.ajax({
                      url: 'GenerateOrder.php',
                      type: "POST",
                      async: false,
                      cache: false,
                      data:{ OrderNo: OrderNo, TotalFee: x, IP:IP},
                      complete:function(info){
                          var p = info.responseText;
		          js_sign_data = p;
			  //alert(p);
                      }
                  });
                  $.ajax({
                      url:"OneBookPay.php",
		      type:"POST",
                      data:{HaveToPay:HaveToPay,OrderNo:OrderNo,UserID:UserID,RRJS_cost:x,DeliveredInfo:DeliveredInfo,BookID:BookID,week:week}
                  });
	       }
        }
           
        var isbn = '<?php if(isset($_GET['ISBN'])) echo $_GET['ISBN']; else echo "";?>';
        $("#set_href").attr("href","site_.php?ISBN="+isbn);
	sumMoney.innerHTML=Number(cashpledge.innerHTML)+Number(rentSum.innerHTML);
	function Down(){
            up.className="out";
            if(parseInt(number.innerHTML)==2)// && number.innerHTML == count)
              down.className="hide";
            if(parseInt(number.innerHTML) > 1){
                number.innerHTML--;
	 	rentSum.innerHTML = (Number(rentSum.innerHTML) - Number(step)).toFixed(1);
		if(rentSum.innerHTML == 0) rentSum.innerHTML = 0;
		if(rentSum.innerHTML < 0) rentSum.innerHTML = 0;
                $("#week").val(Number(rentSum.innerHTML));
                sumMoney.innerHTML = (Number(cashpledge.innerHTML)+Number(rentSum.innerHTML)).toFixed(1);
            }
        }
	function Up(){
            down.className="out";
            if(parseInt(number.innerHTML)==7)
                up.className="hide";
            if(parseInt(number.innerHTML) < 8){
                number.innerHTML++;
		rentSum.innerHTML = (Number(step) + Number(rentSum.innerHTML)).toFixed(1);
		if(rentSum.innerHTML == 0) rentSum.innerHTML = 0;
		if($("#useCardTr").text().substr(7, 1) == 2 && number.innerHTML == 2) rentSum.innerHTML = 0; 
                $("#week").val(Number(rentSum.innerHTML));
                sumMoney.innerHTML= (Number(cashpledge.innerHTML)+Number(rentSum.innerHTML)).toFixed(1);
            }
        }
	down.onclick = Down;
    	up.onclick = Up;
    </script>
    <script src="http://www.bitstorm.org/jquery/color-animation/jquery.animate-colors-min.js"></script>
    <script>
	var count = 0;
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
		    if(isbn != '')
                        location.href="TheThird.php?ISBN="+isbn;
		    else
			location.href="../HTML/HomePage.php";
                },500);
            });
            $("#site1").click(function(){
		turnTo();
		$("#grayBack").click(turnToBack);
	    });
	    

	    $("#canUse").click(function(){
		$("#grayBack").fadeIn(500);
		$("#useCard").animate({bottom: "0"});	

		//count早已初始化为0	
		$(".selector").unbind("click").click(function(event){//
                        if($(this).attr("src") == "../Imgs/selector-icon@3x.png"){     //如果点击效果为：选中
                            $(".selector").attr("src","../Imgs/selector-icon@3x.png");
                            $(this).attr("src","../Imgs/selector-icon1@3x.png");
                            $("#useCard button").html("确认");
                            count = parseInt( $(this).parent().attr("data-card") );   //点击用券，则记为 count（多少元）
                            //alert(count);
                        } else {                                                     //如果点击效果为：取消选中
                            $(this).attr("src","../Imgs/selector-icon@3x.png");
                            $("#useCard button").html("返回");
                            count = 0;                                         //取消选中用券，则记为0
                        }
		
		});

		$("#useCard button").unbind("click").click(function(){
		  if($(this).html() == "确认"){
		      var cfm = confirm("用了不能反悔了哦*^_^*");
		      if(cfm){
			  $("#useCardTr").html("<td>可用卡券<span style=\"left: 61vw; width: 30vw; color: #999\">已使用" + count + "周券 </span></td>");
			  var x = rentSum.innerHTML;
			  var y = sumMoney.innerHTML;
			  x -= Number(count * step);
			  y -= Number(count * step);
			  if(x < 0) {x = 0; y += Number(step);}
			  rentSum.innerHTML = x.toFixed(1);
			  if(x == 0) rentSum.innerHTML = 0;
			  sumMoney.innerHTML = y.toFixed(1);
		      }
		  }
		  $("#useCard").animate({bottom: "-500px"});
		  $("#grayBack").fadeOut(500);
		})
	    }) 
        })
    </script>
    <script>
        var mmp1 = document.getElementById("mmp1");
        var openid = "<?php echo $OpenID; ?>";
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                $.parseJSON(js_sign_data),
                function(res){
		    //WeixinJSBridge.log(res.err_msg);
		    //alert(res.err_code + res.err_desc + res.err_msg);
		    if(res.err_msg == "get_brand_wcpay_request:ok" ){
			var use_card = $("#useCardTr").text().substr(7, 1);
			$.ajax({
          		       url: 'SurePay.php',
          		       data: {OrderNo: OrderNo, OpenID: openid,UserID:UserID,AddressID:DeliveredInfo,UseCard:use_card},
         		       type: "POST",
         		       dataType: "TEXT",
        		       success: function () {
				   location.href = '1111.php';
        		         }
       			      });
                    }
                    else{
			$.ajax({
                		 url: 'CancelPay.php',
                		 data: {OrderNo: OrderNo,OpenID:openid},
                 	         type: "POST",
		                 dataType: "TEXT",
    				 success:function(){
					alert("支付失败,可在订单页面查看待支付订单");
					location.href = "Submit.php";
				 }
             		      });
                     }
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
	if((HavePend == 0) && (HaveBook == 1) && ($("#JudgeSubmit").html() != '添加收货地址'))
	{
      	    $("#mmp1").click(function(){
		convertData();
		callpay();
	    });
	}
	else{
	    $("#mmp1").click(function(){
		if($("#JudgeSubmit").html() == '添加收货地址')
		    alert("请填写收货地址");
		else if(HavePend == 1)
		    alert("一本书同时只能购买一次");
		else if(HaveBook == 0)
		    alert("此大学借书点暂无此书");
	   });
	}
    </script>
    <script src="../JS/TweenMax.min.js"></script>
    <script src="../JS/ripple-config.js"></script>
</body>
</html>
