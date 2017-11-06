<?php
    require_once 'LimitVisit.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>积分明细</title>
	<style>
		*{
			margin: 0;
			padding: 0;
		}
		body{
			background-color: #F6F6F6; 
		}
		ul{
			list-style: none;
		}
		/*header*/
		#header{
			width: 100%;
			margin: 2.67vw 0;
		}
		#header:after{
			display: block;
			content: '';
			clear: both;
		}
		#header li{
			float: left;
			width: 33vw;
			height: 12vw;
			line-height: 12vw;
			text-align: center;
			color: #333;
			font-size: 3.73vw;
			letter-spacing: 0.2em;
			background-color: #fff;
			border-right: 1px solid #ccc;
		}
		/*列表*/
			/*一般地...*/
		p{	
			color: #666;
			font-size: 3.73vw;
			height: 10.67vw;
			line-height: 10.67vw;
			border-top: 1px solid #ccc;
			background-color: #fff;
			
		}
		
		p span{
			font-size: 3.73vw;
			width: 33.33vw;
			display: inline-block;
			text-align: center;
		}

		/*特殊化...*/
		p.first{
			border: none;
		}
		p span:nth-child(2){
			color: #999;
		}
		p span:nth-child(3){
			color: #666;
		}
		p span.up{
			color: #fb8a1c;
		}
		p span.down{
			color: #666;
		}
	</style>
</head>
<body>
	<ul id="header">
		<li>变更</li>
		<li>明细</li>
		<li style="border: none">时间</li>
	</ul>
	
<!--	<p><span class="up">+150</span><span>推荐用户下单</span><span>2010.05.06</span></p>
	<p><span class="up">+50</span><span>推荐用户扫码</span><span>2010.05.06</span></p>

-->
<?php
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $OpenID = $_COOKIE['RRJSID'];
    $select = "SELECT ModifyM,Detail,ChangeDate,DeleteMark FROM BPDetail WHERE OpenID IN ('$OpenID') ORDER BY ChangeDate DESC;";
    $result = $connID->query($select, 'All');
    $len = count($result);
    for($i = 0;$i < $len;$i++)
    {
	$date = substr($result[$i]['ChangeDate'],0,10);
        if($result[$i]['Detail'] == 1)
            echo '<p><span class="up">+10</span><span>日常登陆</span><span>'.$date.'</span></p>';
        if($result[$i]['Detail'] == 2)
            echo '<p class="first exchange"><span>-'.$result[$i]['ModifyM'].'</span><span>积分兑换</span><span>'.$date.'</span></p>';
	if($result[$i]['Detail'] == 3)
            echo '<p><span class="up">+50</span><span>推荐用户扫码</span><span>'.$date.'</span></p>';
        if($result[$i]['Detail'] == 4)
            echo '<p><span class="up">+150</span><span>推荐用户下单</span><span>'.$date.'</span></p>';
    }
?>

</body>
</html>
