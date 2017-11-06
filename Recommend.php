<?php
require_once __DIR__.'/LimitVisit.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>推荐</title>
	<link rel="stylesheet" href="../CSS/recommendStyle.css">
	<link rel="stylesheet" href="../CSS/Footer.css">
</head>
<body>
    <div id="main">
        <h2 id="head">
            <span>●</span>
            推荐书籍
        </h2>

        <ul>
            <li class="noHave" style="background: url('../Imgs/推荐等待底图.png'); background-size: cover;">
                <h2 class="title">距离下本推荐书上线还有<span class="day">5</span>天</h2>
                <p class="intro">距离下本推荐书上线还有<span class="day">5</span>天</p>
                <img id="clock" src="../Imgs/推荐书籍-time-icon@3x.png">
                <p class="time">距离下本推荐书上线还有<span class="day">5</span>天
                </p>
            </li>
        </ul>


    </div>

	<!-- 下面是footer 导航栏部分 -->
	<div id="footer" >
		<ul>
			<li style="margin: 2.13vw 14% 1.06vw 11.3%; ">    <!--第一个-->
				<a href="../HTML/HomePage.php">
					<img src="../Imgs/FooterImages/首页-nor@3x.png"><br/>
					<span >首页</span>
				</a>
			</li>

			<li style="margin: 2.13vw 16% 1.06vw 0%">      <!--第二个-->
				<a href="" class="active">
					<img src="../Imgs/FooterImages/推荐-click@3x.png" ><br/>
					<span style="color: #f9b303">推荐</span>
				</a>
			</li>
			<li style="margin: 2.13vw 17% 1.06vw 0%">           <!--第三个-->
				<a href="1111.php">
					<img src="../Imgs/FooterImages/订单-nor-1@3x.png" ><br/>
					<span>订单</span>
				</a>
			</li>
			<li style="margin: 2.13vw 0 1.06vw 0">                <!--第四个-->
				<a href="PersonalCenter.php">
					<img src="../Imgs/FooterImages/我的-nor@3x.png" ><br/>
					<span>我的</span>
				</a>
			</li>
		</ul>
	</div>

	<!--滚动footer效果-->
	<script src="../JS/jquery.min.js"></script>
	<script src="../JS/footerAnimate.js"></script>
	<script> 
		$("#first").click(function(){
			location.href = 'TheThird.php?ISBN=9787539954707';
		});
	</script>
</body>
</html>
