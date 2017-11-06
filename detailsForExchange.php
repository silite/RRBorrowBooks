<?php
    require_once 'LimitVisit.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>兑换详情页</title>
	<style>
		*{
			margin: 0;
			padding: 0;
			list-style: none;
		}
		#header{
			width: 100%;
		}
		.title{
			font-size: 4.8VW;
			color: #333;
			letter-spacing: 0.1em;
			margin: 5.33vw 0 2.67vw 3.2vw;
		}
		.deadline{
			padding: 2.4vw 0;
		}
		.deadline .word{
			margin-right: 0.1em;
		}
		.score{
			margin-bottom: 6vw;
		}
		.score,.deadline{
			font-size: 3.2vw;
			color: #666;
			margin-left: 3.2vw;
		}
		#guide{
			width: 93.6vw;
			margin: 0 auto;
			margin-top: 6.66vw;
		}
		#guide .guideTitle{
			font-size: 4.8vw;
			color: #333;
			margin-bottom: 4vw;
			letter-spacing: 0.1em;
		}
		#guide li{
			font-size: 3.73vw;
			color: #999;
			height: 1.8em;
		}
		#btnGroup{
			width: 100%;
			padding-top: 4.13vw;
			padding-bottom: 4.13vw;
			box-shadow: 0 -0.4vw 1vw #aaa;
			position: fixed;
			bottom: 0;
		}
		button{
			display: block;
			width: 93.6vw;
			height: 11.86vw;
			margin: 0 auto;
			letter-spacing: 0.15em;
			font-size: 4.8vw;
			color: #fff;
			border: none;
			border-radius: 8px;
			vertical-align: middle;
		}
		button:focus{
			outline: none;
		}
		#less{
			background-color: #999;
		}
		#smt{
			background-color: #f9b303;
		}
	</style>
</head>
<body>
<?php
    require_once 'BPFetch.php';
    $BP = BPFetch();
    $OpenID = $_COOKIE['RRJSID'];
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $select = "SELECT RENRENID FROM UserInfo WHERE OpenID IN ('$OpenID');";
    $result = $connID->query($select, 'Row');
    $RENRENID = $result['RENRENID'];
?>
	<div id="header"><img src="../Imgs/pageImages/<?php if($_GET['add'] == 'one') echo 'oneWeek.png'; else echo 'twoWeek.png'; ?>" width="100%"></div>
	<div>
		<p class="title"><?php if($_GET['add'] == 'one') echo '一'; else echo '两'; ?>周免费借阅券</p>
		<p class="score"><?php if($_GET['add'] == 'one') echo '500'; else echo '950'; ?>积分</p>
		<hr/>
		<p class="deadline"><span class="word">有效期：</span><span class="num"><?php echo date('Y-m-d'); ?>至2018-01-10</span></p>
		<hr/>
	</div>
	<div id="guide">
		<p class="guideTitle">使用细则</p>
		<ul>
			<li>1丶用户兑换后在订单支付页面选择是否使用此优惠券</li>
			<li>2丶本券有效期内可正常使用，逾期将清零</li>
			<li>3丶如使用出现异常，请与客服人员联系</li>
		</ul>
	</div>

	<!-- PHP对用户的积分进行判断 分别输出不同标签  if..else. -->
	<div id="btnGroup">
	<?php
             if($_GET['add'] == 'one'){
     		   if($BP < 500){
     		       echo '<button id="less">积分不足</button>';
     		   }else{
     		       echo '<button  id="smt">立即兑换</button>';
     		   }
       	    }else {
       		   if ($BP < 950) {
        	       echo '<button id="less">积分不足</button>';
	          } else {
                       echo '<button  id="smt">立即兑换</button>';
       		 }
  	  }
	?>
	</div>
<script src="../JS/jquery.min.js"></script>
<script>
    var BP = "<?php if($_GET['add'] == 'one') echo '500'; else echo "950";?>",
	RENRENID = '<?php echo $RENRENID; ?>',
	OpenID = '<?php echo $OpenID; ?>';
    $("#smt").click(function () {
	$.ajax({
            url: 'Gift.php',
            type: "POST",
            data: {BP:BP,RENRENID:RENRENID,OpenID:OpenID},
	    success: function () {
                 alert("兑换成功");
		 location.href = 'credits.php';
            }
        });
    });
</script>
</body>
</html>
