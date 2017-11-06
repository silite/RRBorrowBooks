<?php
    require_once 'LimitVisit.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单</title>
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../CSS/1111.css">
    <link rel="stylesheet" href="../CSS/Footer.css">
</head>
<body>
<?php
$path = '../Media/BookPic/M_';
$OpenID = $_COOKIE['RRJSID'];
?>
<div id="header">
    <span class="active">待借书</span>
    <span>待支付</span>
    <span>待派送</span>
    <span>已送达</span>
</div>

<div id="table" style="margin-bottom: 18vw;">
    <section id="borrowpage" style="margin-bottom: 33vw;" name="page" class="show">
        <?php
	include_once __DIR__.'/../Class/WXPay.php';
        $order = new WXPay($OpenID);
	require_once '../../RRJS/Other/MysqlConnect.php';
        $connID = Connect();	
	
        require_once 'UserAddressFetch.php';
        if(isset($_COOKIE["AddOrder"]))
            $AddOrder = $_COOKIE["AddOrder"];
        else
            $AddOrder = 0;
        $result = UserAddressFetch($OpenID,'All');
        $AddressID = $result[$AddOrder]['ROW_ID'];

	$select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
        $result_rowid = $connID->query($select,'Row');
        $UserID = $result_rowid['ROW_ID'];

        $OrderNo = $order->GenerateOrderNumber();
        require_once 'ToBorrowBooksFetch.php';
        $result_to_borrow = ToBorrowBooksFetch($OpenID,$UserID);
        $len_to_borrow = count($result_to_borrow);
        $element_to_borrow1 = <<<'tar'
<div class="parent">
				<span class="hr1"></span>
                <span class="choose1-a"><img src="../Imgs/o.png" style="width: 100%;height: 100%"></span>
				<img  class="bookImge-a" src="
tar;
        //   这里有封面
        $element_to_borrow2 = <<<'tar'
"/>
				<span class="bookName-a">
tar;
        //   这里有书名
        $element_to_borrow3 = <<<'tar'
</span>
				<span class="author-a">
tar;
        //   这里有作者
        $element_to_borrow4 = <<<'tar'
</span>
			<span class="cash-a">
tar;
        //   这里有押金
        $element_to_borrow5 = <<<'tar'
</span>
				<span class="rent-a" data-consume="
tar;
	$element_to_borrow5_ = <<<'tar'
" data-cash="
tar;
        $element_to_borrow6 = <<<'tar'
">租金：￥
tar;
	$element_to_borrow6_ = <<<'tar'
</span>
				<span class="buttons-a">
		<button id="down-a" class="down-a" data-down-time="1">-</button><button id="number-a" class="number-a">1</button><button id="up-a" class="up-a" data-up-time="1">+</button>
				</span>
				<span class="weak-a">周</span>
				<span class="delete-a delete" data-rowid="
tar;
        $element_to_borrow7 = <<<'tar'
" data-delete="ToBorrowBooks" data-price="
tar;
	$element_to_borrow8 = <<<'tar'
"></span>
				<span class="hr2"></span>
			</div>
tar;
        for ($i = 0; $i < $len_to_borrow; $i++)
            if ($result_to_borrow[$i]['DeleteMark'] == 0){
                echo $element_to_borrow1 . $path . $result_to_borrow[$i]['ROW_ID'] . '.jpg' . $element_to_borrow2 . $result_to_borrow[$i]['Title'] . $element_to_borrow3 . $result_to_borrow[$i]['Author'] . $element_to_borrow4 ;
    if($result_to_borrow[$i]['ROW_ID'] != '08f1874b-9471-11e7-bb0f-00163e06cefc')
	echo '押金：￥' .'25'. $element_to_borrow5 .round(floor($result_to_borrow[$i]['Price']*9)/10)/10 .$element_to_borrow5_.'25';
    else
	echo '押金：￥' .'60'. $element_to_borrow5 .round(floor($result_to_borrow[$i]['Price']*9)/10)/10 .$element_to_borrow5_.'60';
// 为租金一元活动
if($result_to_borrow[$i]['ROW_ID'] == 'dd16cf33-9465-11e7-bb0f-00163e06cefc' || $result_to_borrow[$i]['ROW_ID'] == '2a60374c-9466-11e7-bb0f-00163e06cefc' || $result_to_borrow[$i]['ROW_ID'] == 'f0faf674-9464-11e7-bb0f-00163e06cefc' || $result_to_borrow[$i]['ROW_ID'] == 'fec119a4-9461-11e7-bb0f-00163e06cefc' || $result_to_borrow[$i]['ROW_ID'] == '45688bf9-9463-11e7-bb0f-00163e06cefc' || $result_to_borrow[$i]['ROW_ID'] == '44dc55b6-9466-11e7-bb0f-00163e06cefc' || $result_to_borrow[$i]['ROW_ID'] == '714370ec-9473-11e7-bb0f-00163e06cefc' || $result_to_borrow[$i]['ROW_ID'] == '4be11fef-9473-11e7-bb0f-00163e06cefc' || $result_to_borrow[$i]['ROW_ID'] == 'bd6d2bc1-9463-11e7-bb0f-00163e06cefc')                                                                  $result_to_borrow[$i]['Price'] = 11;
     echo $element_to_borrow6 .round(floor($result_to_borrow[$i]['Price']*9)/10)/10 .$element_to_borrow6_ . $result_to_borrow[$i]['ROW_ID'] . $element_to_borrow7;
    echo $result_to_borrow[$i]['Price']. $element_to_borrow8;
}


    $ip = $_SERVER['REMOTE_ADDR'];
    /*$TYXD = $order->TYXD(array('body' => 'Book' ,
                               'total_fee' => '1' ,
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
    $js_timestamp = date('Y-m-d');
    $js_nonceStr = WXPay::GetNonceStr();
    $js_package = 'prepay_id='.$TYXD->prepay_id;
    $js_signType = 'MD5';
    $sign_array = array('appId'=>$js_appid , 'timeStamp'=>$js_timestamp , 'nonceStr'=>$js_nonceStr , 'package'=>$js_package , 'signType'=>$js_signType);
    $js_paySign = WXPay::GenerateSign($sign_array);
    $sign_array['paySign'] = $js_paySign;
    $js_sign_data = json_encode($sign_array);*/

?>
        <form id="bot-a">
            <span class="allimg-a" id="fullchange"></span>
            <span class="all-a" id="changename">全选</span>
            <span class="total-a">合计金额：</span>
            <span class="money-a" id="sum"></span>
            <input type="hidden" name="RRJS_cost" id="add_sum" value="">
            <input type="hidden" name="dic" id="dic" value="">
            <input type="hidden" name="OrderNo" value="<?php echo $OrderNo; ?>">
            <button class="pay-a" id="pay" type="button">支付</button>
        </form>
    </section>

    <section id="paypage" name="page" class="hide">
        <?php
        require_once 'ToPayFetch.php';
        $result_to_pay = ToPayFetch($OpenID,$UserID);
        $len_to_pay = count($result_to_pay);
        $element_to_pay1 = <<<'tar'
    <div>
				<span class="serialNumber">订单编号: 
tar;
        //    这里有订单
        $element_to_pay2 = <<<'tar'
</span>
				<span class="state">待支付</span>
				<p class="hr1"></p>
				<img class="bookImge" src="
tar;
        //    这里有图片
        $element_to_pay3 = <<< 'tar'
" />
				<span class="bookName">
tar;
        //这里有书名
        $element_to_pay4 = <<<'tar'
</span>
				<span class="author">
tar;
        //这里有作者
        $element_to_pay5 = <<<'tar'
</span>
				<p class="hr2"></p>
				<span class="totalMoney">合计金额： ￥
tar;
        //    这里有价钱
        $element_to_pay6 = <<<'tar'
</span>
                <button class="cancelButton delete" data-delete="ToPayOrder" data-rowid="
tar;
        //    这里又ROW_ID
        $element_to_pay7 = <<<'tar'
">取消订单</button>
                <button id="now_pay"  class="payButton">马上支付</button>
		<input type="hidden" class="now_pay_date" date-no="
tar;
	$element_to_pay8 = <<<'tar'
" date-bookid = "
tar;
	$element_to_pay9 = <<<'tar'
" />
			</div>
tar;

        for ($i = 0; $i < $len_to_pay; $i++) {
            if ($result_to_pay[$i]['DeleteMark'] == 0)
                echo $element_to_pay1 . $result_to_pay[$i]['OrderNo'] . $element_to_pay2 . $path . $result_to_pay[$i]['ROW_ID'] . '.jpg' . $element_to_pay3 . $result_to_pay[$i]['Title'] . $element_to_pay4 . $result_to_pay[$i]['Author'] . $element_to_pay5 . $result_to_pay[$i]['InCome'] . $element_to_pay6 . $result_to_pay[$i]['ROW_ID'] . $element_to_pay7.$result_to_pay[$i]['OrderNo'].$element_to_pay8.$result_to_pay[$i]['ROW_ID'].$element_to_pay9;
        }
        ?>
    </section>

    <section id="sendpage" name="page" class="hide">
        <?php
        require_once 'PendOrderFetch.php';
        $result_pend = PendFetch($OpenID,$UserID);
        $len_pend = count($result_pend);
        $element_pend1 = <<<'tar'
<div>
				<span class="serialNumber">订单编号: 
tar;
        //这里有订单编号
        $element_pend2 = <<<'tar'
</span>
				<span class="state">待派送</span>
				<p class="hr1"></p>
				<img class="bookImge" src="
tar;
        //这里有封面
        $element_pend3 = <<<'tar'
" />
				<span class="bookName">
tar;
        //这里有书名
        $element_pend4 = <<<'tar'
</span>
				<span class="author">
tar;
        //    作者
        $element_pend5 = <<<'tar'
</span>
				<p class="hr2"></p>
				<span class="totalMoney">合计金额： ￥
tar;
        //金额
        $element_pend6 = <<<'tar'
</span>
				<button class="details">订单详情</button>
			</div>
tar;
        for ($i = 0; $i < $len_pend; $i++)
            if ($result_pend[$i]['DeleteMark'] == 0)
                echo $element_pend1 . $result_pend[$i]['OrderNo'] . $element_pend2 . $path . $result_pend[$i]['ROW_ID'] . '.jpg' . $element_pend3 . $result_pend[$i]['Title'] . $element_pend4 . $result_pend[$i]['Author'] . $element_pend5 . $result_pend[$i]['InCome'] . $element_pend6;
        ?>
    </section>
    <section id="reachpage" name="page" class="hide">
        <?php
        require_once 'DelieveOrderFetch.php';
        $result_delivered = DeliveredFetch($OpenID,$UserID);
        $len_delivered = count($result_delivered);
        $element_delivered1 = <<<'tar'
<div > 
				<span class="serialNumber ">订单编号:
tar;
        //    这里有订单号
        $element_delivered2 = <<<'tar'
</span>
				<span class="deleteImge delete"  data-rowid="
tar;
        $element_delivered3 = <<<'tar'
" data-delete = "DeliveredOrder"
tar;

        $element_delivered4 = <<<'tar'
></span>
				<img class="postmark" src="../Imgs/postmark.png"/>
				<p class="hr1"></p>
				<img class="bookImge" src="
tar;

        //   这里有封面
        $element_delivered5 = <<<'tar'
" />
				<span class="bookName">
tar;
        //   这里有书名
        $element_delivered6 = <<<'tar'
</span>
				<span class="author">
tar;
        //  这里有作者
        $element_delivered7 = <<<'tar'
</span>
				<p class="hr2"></p>
				<span class="totalMoney">合计金额： ￥  
tar;
        //这里有订单金额
        $element_delivered8 = <<<'tar'
</span>
				<span class="arrive">已送达</span>
			</div>
tar;
        for ($i = 0; $i < $len_delivered; $i++)
            if ($result_delivered[$i]['DeleteMark'] == 0)
                echo $element_delivered1 . $result_delivered[$i]['OrderNo'] . $element_delivered2 . $result_delivered[$i]['Delivered_ROW_ID'] . $element_delivered3 . $element_delivered4 . $path . $result_delivered[$i]['ROW_ID'] . '.jpg' . $element_delivered5 . $result_delivered[$i]['Title'] . $element_delivered6 . $result_delivered[$i]['Author'] . $element_delivered7 . $result_delivered[$i]['Income'] . $element_delivered8;
        ?>
    </section>
</div>


<div id="footer">
    <ul>
        <li style="margin: 2.13vw 14% 1.06vw 11.3%; ">
            <a href="../HTML/HomePage.php" class="active">
                <img src="../Imgs/FooterImgs/首页-nor@3x.png"><br/>
                <span>首页</span>
            </a>
        </li>

        <li style="margin: 2.13vw 16% 1.06vw 0%">
            <a href="Recommend.php">
                <img src="../Imgs/FooterImgs/推荐-nor@3x.png"><br/>
                <span>推荐</span>
            </a>
        </li>
        <li style="margin: 2.13vw 17% 1.06vw 0%">
            <a href="">
                <img src="../Imgs/FooterImgs/订单-click@3x.png"><br/>
                <span style="color: #f9b303">订单</span>
            </a>
        </li>
        <li style="margin: 2.13vw 0 1.06vw 0">
            <a href="PersonalCenter.php">
                <img src="../Imgs/FooterImgs/我的-nor@3x.png"><br/>
                <span>我的</span>
            </a>
        </li>
    </ul>
</div>

<script src="../JS/jquery.min.js"></script>
<!--    <script src="../JS/footerAnimate.js"></script>-->

<script>
//    四个页面  整合删除功能
    $(".delete").click(function () {
        var judge_delete = confirm("是否删除~");
        if (judge_delete) {
            $this = $(this);
            var delete_name = $(this).attr("data-delete");
            var ROW_ID = $(this).attr("data-rowid");
            $.ajax({
                url: 'OrderDelete.php',
                data: {ROW_ID: ROW_ID, delete_name: delete_name},
                type: "POST",
                dataType: "TEXT",
                success: function () {
                    $this.parent().remove();
                }
            });
        }
    });
</script>
<script>
    //        先初始化字典     多本书遍历提交ajax

    var week_dic = new Array();
    var OrderNo = '<?php echo $OrderNo; ?>';
    var OpenID = '<?php echo $OpenID; ?>';
    var UserID = '<?php echo $UserID; ?>';
    var AddressID = '<?php echo $AddressID ?>';
    var first_pay = true;
    var IP = '<?php echo $ip; ?>';
    var js_sign_data = '';
    $(".choose1-a").click(function () {
        $(".choose1-a img").each(function () {
            if ($(this).attr("src") == "../Imgs/Y.png") {
                var rowid = $(this).parent().parent().find(".delete").attr("data-rowid");
                var week = $(this).parent().parent().find(".number-a").html();
                week_dic[rowid] = week;
            }
            if ($(this).attr("src") == "../Imgs/o.png") {
                var rowid = $(this).parent().parent().find(".delete").attr("data-rowid");
                delete(week_dic[rowid]);
            }
        });
    });
    //        再动态赋值
    $(".buttons-a").click(function () {
        $(".choose1-a img").each(function () {
            if ($(this).attr("src") == "../Imgs/Y.png") {
                var rowid = $(this).parent().parent().find(".delete").attr("data-rowid");
                var week = $(this).parent().parent().find(".number-a").html();
                week_dic[rowid] = week;
            }
            if ($(this).attr("src") == "../Imgs/o.png") {
                var rowid = $(this).parent().parent().find(".delete").attr("data-rowid");
                delete(week_dic[rowid]);
            }
        });
    });


     function convertData(position){
	       if(position == "Left"){
	      	    var x = $("#sum").text();
               	    x = x.slice(1);
		} else {
		    x = position.parent().find(".totalMoney").text().substr(7);
		}
               //alert(x);
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
     }



//提交




    $(".payButton").click(function(){
        var this_ = $(this);
        var now_pay_no = this_.parent().find(".now_pay_date").attr('date-no');
        var now_pay_bookid = this_.parent().find(".now_pay_date").attr('date-bookid');
	
	convertData($(this));
        callpay();
        function jsApiCall() {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                $.parseJSON(js_sign_data),
                function (res) {
                    if (res.err_msg == "get_brand_wcpay_request:ok") {
                        $.ajax({
                            url: 'SurePay.php',
                            data: {OpenID:OpenID,OrderNo:now_pay_no,now_BookID:now_pay_bookid,method:'now_pay'},
                            type: "POST",
                            dataType: "TEXT",
                            success: function () {
                                location.href = '1111.php';
                            }
                        });
                    }
                    else{
                        alert("支付失败");
			location.href = '1111.php';
                   }
		}
            );
        }
        function callpay() {
            if (typeof WeixinJSBridge == "undefined") {
                if (document.addEventListener) {
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                } else if (document.attachEvent) {
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            } else {
                jsApiCall();
            }
        }
    });

    $("#pay").click(function () {
	    if($("#sum").text() == '￥0')
                alert("还没有选择书籍");
	    else {
            var x = $("#sum").text();
            x = x.slice(1);
            $("#add_sum").val(x);
            for (var key in week_dic) {
               $.ajax({
                    url: 'AllBookPay.php',
                    type: "POST",
		    async: false,
		    cache: false,
                    data: {
                        OpenID: OpenID,
                        OrderNo: OrderNo,
                        BookID: key,
                        week: week_dic[key],
                        AllInCome: x,
                        DeliveredInfo: AddressID
                    },
                    complete: function (info) {
			var p = info.responseText;
		    if(p != 1)
			alert("暂无"+p);
		    else
			{
                        var pay = document.getElementById("pay");
                        function jsApiCall() {
                            WeixinJSBridge.invoke(
                                'getBrandWCPayRequest',
                                $.parseJSON(js_sign_data),
                                function (res) {
                                    if (res.err_msg == "get_brand_wcpay_request:ok") {
                                        $.ajax({
                                            url: 'SurePay.php',
                                            data: {OrderNo: OrderNo, OpenID: OpenID, UserID: UserID},
                                            type: "POST",
                                            dataType: "TEXT",
                                            success: function () {
                                                location.href = '1111.php';
                                            }
                                        });
                                    }
                                    else {
                                        $.ajax({
                                            url: 'CancelPay.php',
                                            data: {OrderNo: OrderNo, OpenID: OpenID},
                                            type: "POST",
                                            dataType: "TEXT",
                                            success: function () {
                                                alert("支付失败,可在订单页面查看待支付订单");
                                                location.href = '1111.php';
                                            }
                                        });
                                    }
                                }
                            );
                        }
                        function callpay() {
                            if (typeof WeixinJSBridge == "undefined") {
                                if (document.addEventListener) {
                                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                                } else if (document.attachEvent) {
                                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                                }
                            } else {
                                jsApiCall();
                            }
                        }
                        if ($("#sum").text() != '￥0' && first_pay)
                            { convertData("Left");  callpay(); first_pay = false;}
        		}
	            }
                    
                });
            }
        }
    });

    //			这里全部是勾选效果

    var rent = '租金：￥';
    $(".down-a").click(function () {
        var down_this = $(this);
        var now = parseInt(down_this.next(".number-a").html());
	var book_deposit = down_this.parent().next().next().attr("data-price");
        if (now > 1) {
            down_this.next(".number-a").html(now - 1);
	    //这里是当前租金显示
            now--;
	    book_deposit = now * Math.round(parseInt(Number(book_deposit)*9)/10)/10;
	    //这里是将租金放在data-consume里
            down_this.parent().prev(".rent-a").attr("data-consume", book_deposit);
            down_this.parent().prev(".rent-a").html(rent + book_deposit);
        }
        if (now == 1)
            down_this.css("background-color", "#eee");
        $(this).parent().find(".up-a").css("backgroundColor", "#fff");
    });
    $(".up-a").click(function () {
        var up_this = $(this);
        var now = parseInt(up_this.prev(".number-a").html());
	var book_deposit = up_this.parent().next().next().attr("data-price");
        if (now < 8) {
            up_this.prev(".number-a").html(now + 1);
            now++;
	    book_deposit = now * Math.round(parseInt(Number(book_deposit)*9)/10)/10;
            up_this.parent().prev(".rent-a").attr("data-consume",book_deposit);
            up_this.parent().prev(".rent-a").html(rent + book_deposit);
        }

        if (now == 8)
            $(this).parent().find(".up-a").css("backgroundColor", "#eee");
        $(this).parent().find(".down-a").css("backgroundColor", "#fff");
    });

    window.onload = function () {
        var head = document.getElementById("header");
        var pageButton = head.getElementsByTagName("span");
        var tab = document.getElementById("table");
        var di = tab.getElementsByTagName("section");
        for (var i = 0; i < pageButton.length; i++) {
            pageButton[i].index = i;
            pageButton[i].onclick = function () {
                for (var j = 0; j < pageButton.length; j++) {
                    pageButton[j].className = "";
                }
                this.className = "active";
                for (var j = 0; j < di.length; j++) {
                    di[j].className = "hide";
                }
                di[this.index].className = "show";
            }
        }
        $("#sum").text("￥0");
        var cash = 0;
	$(".choose1-a img").click(function () {
            var full_judge = true;
            var empty_judge = true;
            if ($(this).attr("src") == "../Imgs/Y.png") {
                cash = $("#sum").text();
                cash = cash.slice(1);
                cash -= Number(Math.round($(this).parent().parent().find(".rent-a").attr("data-cash"))) + Number($(this).parent().parent().find(".rent-a").attr("data-consume"));
                $("#sum").text("￥" + cash.toFixed(1));
                $(this).attr("src", "../Imgs/o.png");
            }
            else {
                cash = $("#sum").text();
                cash = Number(cash.slice(1));
                cash += Number(Math.round($(this).parent().parent().find(".rent-a").attr("data-cash"))) + Number($(this).parent().parent().find(".rent-a").attr("data-consume"));
                $("#sum").text("￥" + cash.toFixed(1));
                $(this).attr("src", "../Imgs/Y.png");
            }
            $(".choose1-a img").each(function () {
                if ($(this).attr("src") != "../Imgs/Y.png")
                    full_judge = false;
                else empty_judge = false;
            });
            if (full_judge) {
                $("#fullchange").css('background-image', 'url(../Imgs/Y.png)');
                $("#changename").text("反选");
            }
            if (empty_judge) {
                $("#fullchange").css('background-image', 'url(../Imgs/o.png)');
                $("#changename").text("全选");
            }
        });	

	$(".choose1-a img").click(function () {
            var change = $(this).parent().parent().find(".number-a");
            if(change.html() == 1)
                change.prev(".down-a").attr("data-down-time","0");
  	    if(change.html() == 8)
                change.next(".up-a").attr("data-up-time","0");
        });
       
	$(".buttons-a").children(".down-a").click(function () {
	    // 这里是选中时减少
            var num_this = $(this);
            num_this.parent().find(".up-a").attr("data-up-time","1");
            var down_time = num_this.parent().find(".down-a").attr("data-down-time");
            if ((num_this.parent().parent().find(".choose1-a img").attr("src") == '../Imgs/Y.png') && down_time != '0') {
                if (num_this.next(".number-a").html() == 1)
                    num_this.parent().find(".down-a").attr("data-down-time","0");
                var now_sum = $("#sum").text();
		var book_deposit = num_this.parent().next().next().attr("data-price");
		// 只算一次做优化
		book_deposit = Math.round(parseInt(Number(book_deposit)*9)/10)/10;
                now_sum = Number(now_sum.slice(1));
                now_sum -= book_deposit;
		now_sum = now_sum.toFixed(1);
                $("#sum").text("￥" + now_sum);
            }
        });
        $(".buttons-a").children(".up-a").click(function () {
            var num_this = $(this);
            num_this.parent().find(".down-a").attr("data-down-time","1");
            var up_time = num_this.parent().find(".up-a").attr("data-up-time");
            if ((num_this.parent().parent().find(".choose1-a img").attr("src") == '../Imgs/Y.png') && up_time != '0') {
                if (num_this.prev(".number-a").html() == 8)
                    num_this.parent().find(".up-a").attr("data-up-time","0");
                var now_sum = $("#sum").text();
		var book_deposit = num_this.parent().next().next().attr("data-price");
                book_deposit = Math.round(parseInt(Number(book_deposit)*9)/10)/10;
                now_sum = Number(now_sum.slice(1));
                now_sum += book_deposit;
		now_sum = now_sum.toFixed(1);
                $("#sum").text("￥" + now_sum);
            }
        });
 
        $("#fullchange").click(function () {
            if ($("#changename").text() == '全选') {
		//全选支付 全部放入字典
		$(".choose1-a img").each(function(){
		    var rowid = $(this).parent().parent().find(".delete").attr("data-rowid");
                    var week = $(this).parent().parent().find(".number-a").html();
                    week_dic[rowid] = week;
		});
		//下为效果
                cash = 0;
                $(".rent-a").each(function () {
                    cash += Number($(this).attr("data-cash")) + Number($(this).attr("data-consume"));
                });
                $("#sum").text("￥" + cash.toFixed(1));
                $(".choose1-a img").attr("src", "../Imgs/Y.png");
                $("#fullchange").css('background-image', 'url(../Imgs/Y.png)');
                $("#changename").text("反选");
            }
            else {
		//反选清除
		$(".choose1-a img").each(function(){
		    var rowid = $(this).parent().parent().find(".delete").attr("data-rowid");
                    delete(week_dic[rowid]);
		});
		//下为效果
                $("#sum").text("￥0");
                cash = 0;
                $(".choose1-a img").attr("src", "../Imgs/o.png");
                $("#fullchange").css('background-image', 'url(../Imgs/o.png)');
                $("#changename").text("全选");
            }
        });
    }
    // 订单详情功能
    $(".details").click(function(){
	var No = $(this).parent().find(".serialNumber").text();
	var Book = $(this).parent().find(".bookImge").attr("src");
	No = No.substr(6,32);
	Book = Book.substr(19,36);
	location.href = 'Ddxq.php?OrderNo='+No+'&BookID='+Book;
    });
</script>
</body>
</html>
