<?php
    require_once 'LimitVisit.php';
    $OpenID = $_COOKIE['RRJSID'];
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $select = "SELECT ROW_ID,ModifyM,ChangeDate,DeleteMark FROM BPDetail WHERE OpenID IN ('".$OpenID."') AND Detail = 2;";
    $result = $connID->query($select, 'All');
    $len = count($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>我的卡券</title>
	<style>
		*
		{
			padding: 0;
			margin: 0;
		}
		.nonecard/*无卡券状态样式*/
		{
			width: 100vw;
			text-align: center;
			font-size: 4vw;
			color: #666;
		}
		.nonepicture
		{	
			width: 34vw;
			height: 18vw;
			margin-top: 30vw;
			margin-bottom:5vw;
		}
		.word
		{
			font-size: 5vw;
			margin:5vw;
			margin-left: 4vw;
			margin-bottom: 2vw;
			color: #999;
		}
		.card
		{
			width: 44vw;
			height: 35vw;
			display: inline-block;
			margin-left: 4vw;
			margin-bottom: 5vw;
		}
		.picture
		{
			width: 44vw;
			height: 25vw;
			margin-bottom: 1vw;
		}
		.name
		{
			font-size: 4vw;
			color: #666;
			word-spacing: 1vw;
		}
		.time
		{
			font-size: 3vw;
			color: #999;
		}
	</style>
</head>
<body>
<?php
    if($len == 0){	
	echo '
	<div class="nonecard" id="none"><!--无卡券状态(有券时不显示)-->
		<img src="../Imgs/无卡券状态.png" class="nonepicture"><!--图片选择-->
		<div>当前没有可用的卡券</div>
		<div>可以在我的积分进行兑换</div><!--最终有效期-->
	</div>';
    }
    else{
	echo '<div class="have">
	         <div class="word">可用卡券</div>';
	for($i = 0;$i < $len;$i++)
        {
	if($result[$i]['DeleteMark'] == 1)
	    $used = true;
	else
	    $used = false;
	$date = substr($result[$i]['ChangeDate'],0,10);
	$date = date('Y-m-d',strtotime("$date +1 year"));
        if($result[$i]['ModifyM'] == '500'){
	echo '
                <div class="card">
                        <img src="../Imgs/一周借阅券.png" class="picture"><!--图片选择-->
                        <div class="name">一周免费借阅券';
	if($used)
	    echo '(已使用)';
	echo '</div>
                        <div class="time">有效期至：'.$date.'</div><!--最终有效期-->
                </div>';
	}
        else{
            echo '<div class="card">
                        <img src="../Imgs/二周借阅券.png" class="picture"><!--图片选择-->
                        <div class="name">二周免费借阅券';
	    if($used)
            echo '(已使用)';
	    echo '</div>
                        <div class="time">有效期至：'.$date.'</div><!--最终有效期-->
                </div>';
	}
        }
	echo '</div>';
	}
?>
</body>
</html>
