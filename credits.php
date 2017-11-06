<?php
    require_once 'LimitVisit.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>我的积分</title>
	<style>
	*{
		margin:0;
		padding:0;
		list-style: none;
	}
	body{
		background-color:#f6f6f6;
	}
	a{
		text-decoration: none;
	}
	.wave{
		width: 43.2vw;
		height: 43.2vw;
		overflow: hidden;
		border-radius: 50%;
		background: #f9b303;
		margin: 100px auto;
		position: relative;
		text-align: center;
		display: table-cell;
		vertical-align: middle;
		left: 30vw;
		top: 10vw;
	}
	.wave span{
		display:inline-block;
		position:relative;
		z-index:2;
	}
	.wave canvas{
		position:absolute;
		left:0;
		top:0;
		z-index:1;
	}
	.wave-warp{
		position: relative;
		height: 60vw;
		width: 100%;
		background: url("../Imgs/pageImages/background.png");
		background-repeat: no-repeat;	
		background-size: cover;
	}
	.wave-number{
		font-size: 13.3vw;
		color: white;
	}
	.wave-character{
		font-size: 4.8vw;
		color: #8b6042;
	}
	.wave-warp a{
		display: inline;
		font-size: 3.47vw;
		color: #fff;
		letter-spacing: 0.2em;
		position: absolute;
		right: 5vw;
		bottom: 5vw;
	}
	#main-content{
		width: 93.6%;
		margin: 0 auto;
	}
	#title{
		margin-top: 8vw;
		margin-bottom: 2.67vw;
		vertical-align: middle;
	}
	#title img{
		width: 4vw;
		height: 4vw;
		line-height: 4vw;
	}
	#title span{
		display: inline-block;
		font-size: 4.27vw;
		padding-left: 1.07vw;
	}
	li{
		float: left;
	}
	li:nth-child(odd){
		margin-right: 2.93vw;
	}
	li a{
		display: block;
		width: 45.3vw;
		height: 24.8vw;
		
	}
	li .subTitle{
		font-size: 3.73vw;
		color: #333;
		margin-top: 2.66vw;
		margin-bottom: 1.93vw;
	}
	li .score{
		font-size: 3.2vw;
		color: #fb8a1c;
		margin-bottom: 2.67vw;

	}
	.oneWeek a{
		background: url("../Imgs/pageImages/oneX.png");
		background-size: cover;
		background-repeat: no-repeat;
	}
	.twoWeek a{
		background: url("../Imgs/pageImages/twoX.png");
		background-size: cover;
		background-repeat: no-repeat;
	}
	.noHave a{
		background: url("../Imgs/pageImages/noHave.png");
		background-size: cover;
		background-repeat: no-repeat;
		position: relative;
	}
	.noHave a span{
		font-size: 2.67vw;
		color: #fff;
		display: line-block;
		position: absolute;
		right: 2.67vw;
		bottom: 2.67vw;
	}
	</style>
	<script src="http://apps.bdimg.com/libs/jquery/1.6.4/jquery.js"></script>
</head>
<body>
<?php
    require_once 'BPFetch.php';
    $BP = BPFetch();
?>
	<div class="wave-warp">
		<div id="wave" class="wave">
			<span class="wave-number"><?php echo $BP; ?></span><br/>
			<span class="wave-character">账户总积分</span>
		</div>
		<a href="detailsForScore.php">积分明细</a>
	</div>
	<div id="main-content">
		<p id="title"><img src="../Imgs/pageImages/exchange.png"><span>积分兑换</span></p>
		

		<ul>
			<li class="oneWeek">
				<a href="detailsForExchange.php?add=one"></a>
				<p class="subTitle">一周免费借阅券</p>
				<p class="score">500积分</p>
			</li>

			<li class="twoWeek">
				<a href="detailsForExchange.php?add=two"></a>
				<p class="subTitle">两周免费借阅券</p>
				<p class="score">950积分</p>
			</li>

			<li class="noHave">
				<a><span>敬请期待</span></a>
				<p class="subTitle">即将上线的优惠券</p>
				<p class="score">???积分</p>
			</li>

		</ul>

	
	</div>
		


	<script src="../JS/animate.js"></script>
</body>
</html>
