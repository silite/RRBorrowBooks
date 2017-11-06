<?php
include_once __DIR__.'/../PHP/Set_RRJS_ID.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>首页</title>
	<link rel="stylesheet" href="../CSS/swiper-3.4.2.min.css">     <!--滑动-->
	<link rel="stylesheet" href="../CSS/homePageStyle.css">   <!--本页面的样式表-->
	<link rel="stylesheet" href="../CSS/formStyle.css">       <!--表单样式-->
	<link rel="stylesheet" href="../CSS/Footer.css">
	<link rel="stylesheet" href="../CSS/weUI.css">      <!--微信搜索API  css样式表-->
	<script src="../JS/jquery.min.js"></script>          <!--JQ框架-->
</head>
<body>
	<!-- banner部分 -->
	<a style="display: block" href="#" class="swiper-container" >
	  	<div class="swiper-wrapper" >
	  		<div class="swiper-slide" > <img src="../Imgs/BannerImgs/HomePage-banner_0.jpg" > </div>
	    	<div class="swiper-slide" > <img src="../Imgs/BannerImgs/HomePage-banner_1.jpg" > </div>
	   		<div class="swiper-slide" > <img src="../Imgs/BannerImgs/HomePage-banner_0.jpg" > </div>
		</div>
	</a>

	<!-- 搜索框 -->
    <div class="weui-search-bar" id="searchBar" style="width: 94%; margin: 0 auto;margin-bottom: -5vw;z-index: 1; ">
            <form class="weui-search-bar__form" action="../PHP/Search.php" method="get" >
                <div class="weui-search-bar__box" >
                    <i class="weui-icon-search" style="cursor: pointer; top:1px;" id="mmp1"></i>
                    <input type="search" class="weui-search-bar__input" name="searchInput" id="searchInput"  required/>
                    <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                </div>
                <label class="weui-search-bar__label" id="searchText">
                    <i class="weui-icon-search" id="mmp2"></i>
                    <span id="mmp3">请使劲往这里输入书名、作者</span>
                </label>
            </form>
            <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel" style="color: #999; font-size: 14px; padding-top: 10px;">
            	取消
            </a>
    </div>
    <!-- 引入微信搜索API  JS操作 -->
    <script src="../JS/we-ui-search-bar.js"></script>

	<div id="main-content" style="overflow: hidden; margin-bottom: 14vw;">
		<!--下面是一系列的书 -->   
		<ul class="book-set">
			<li class="one-book clear">
				<a href="#">
					<img class="book-img" src="../Imgs/PageImgs/pho1@3x.png">
					<h2 class="book-title">拍死前男友系列</h2>
					<p class="book-intro">让自己变得越来越丰富，后悔死他</p>
				</a>
			</li>
			<li class="one-book clear">
				<a href="#">
					<img class="book-img" src="../Imgs/PageImgs/pho2@3x.png">
					<h2 class="book-title">看完拍大腿叫好系列</h2>
					<p class="book-intro">看了一遍还想看第二遍</p>
				</a>
			</li>
			<li class="one-book clear">
				<a href="#">
					<img class="book-img" src="../Imgs/PageImgs/pho3@3x.png">
					<h2 class="book-title">控制不住计几想哭系列</h2>
					<p class="book-intro">温暖才是世界的本质</p>
				</a>
			</li>
			<li class="one-book clear">
				<a href="#">
					<img class="book-img" src="../Imgs/PageImgs/pho4@3x.png">
					<h2 class="book-title">体验学校外边的世界系列</h2>
					<p class="book-intro">你想知道未来发生的改变吗？</p>
				</a>
			</li>
			<li class="one-book clear">
				<a href="#">
					<img class="book-img" src="../Imgs/PageImgs/pho5@3x.png">
					<h2 class="book-title">改善拖延好动纠结易怒</h2>
					<p class="book-intro">人与人之间的本质差距是自控力</p>
				</a>
			</li>
			<li class="one-book clear">
				<a href="#">
					<img class="book-img" src="../Imgs/PageImgs/pho6@3x.png">
					<h2 class="book-title">热潮在手天下我有系列</h2>
					<p class="book-intro">嘤嘤嘤，人家娱乐修身两不误啦</p>
				</a>
			</li>
			<li class="one-book clear">
				<a href="#">
					<img class="book-img" src="../Imgs/PageImgs/pho7@3x.png">
					<h2 class="book-title">冷的不能在冷的冷门系列</h2>
					<p class="book-intro">就算冷得跟北极一个温度，也阻挡不了它得傲娇。</p>
				</a>
			</li>
		</ul>

	</div>
	
	
	<!-- 下面是footer 导航栏部分 -->
	<div id="footer" >
		<ul>
			<li style="margin: 2.13vw 14% 1.06vw 11.3%; ">    <!--第一个-->
				<a href="" class="active">
					<img src="../Imgs/FooterImgs/首页click@3x.png"><br/>
					<span style="color: #f9b303">首页</span>
				</a>
			</li>

			<li style="margin: 2.13vw 16% 1.06vw 0%">      <!--第二个-->
				<a href="../PHP/Recommend.php">
					<img src="../Imgs/FooterImgs/推荐-nor@3x.png" ><br/>
					<span>推荐</span>
				</a>
			</li>
			<li style="margin: 2.13vw 17% 1.06vw 0%">           <!--第三个-->
				<a href="../PHP/1111.php">
					<img src="../Imgs/FooterImgs/订单-nor-1@3x.png" ><br/>
					<span>订单</span>
				</a>
			</li>
			<li style="margin: 2.13vw 0 1.06vw 0">                <!--第四个-->
				<a href="../PHP/PersonalCenter.php">
					<img src="../Imgs/FooterImgs/我的-nor@3x.png" ><br/>
					<span>我的</span>
				</a>
			</li>
		</ul>		
	</div>


	<!--滚动footer效果-->
	<script src="../JS/footerAnimate.js"></script>

	<!-- 设置轮播 -->
	<script src="../JS/swiper-3.4.2.min.js"></script>
	<!-- 轮播初始化 -->
	<script> 
		var mySwiper = new Swiper('.swiper-container', {
			// 循环
			autoplay: 3000,
   			loop: true,
		});
	</script>
</body>
</html>
