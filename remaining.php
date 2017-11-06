<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>我的余额</title>
	<style>
	*{
		margin:0;
		padding:0;
		list-style:none;
	}
	body
	{
		background-color:#f6f6f6;
	}
	.wave
	{
		width:40vw;
		height:40vw;
		overflow:hidden;
		border-radius:50%;
		background:#f27e84;
		margin:100px auto;
		position:relative;
		text-align:center;
		display:table-cell;
		vertical-align:middle;
		left: 30vw;
		top: 10vw;
	}
	.wave span
	{
		display:inline-block;
		position:relative;
		z-index:2;
	}
	.wave canvas
	{
		position:absolute;
		left:0;
		top:0;
		z-index:1;
	}
	.wave-warp
	{
		position: relative;
		background-color: #d4646a;
		height: 60vw;
		width: 100%;
		margin-bottom: 5vw;
	}
	.wave-number
	{
		font-size: 3em;
		color: white;
	}
	.number-sub
	{
		font-size:0.8em;
		color: white;
	}
	.wave-character
	{
		font-size: 1em;
		color: #8b6042;
	}
	.callour
	{
		position: absolute;
		bottom: 5%;
		right: 5%;
		color: white;
		text-decoration: none;
		font-size: 1em;
	}
	.money
	{
		height: 20vw;
		width: 100%;
		background-color: white;
		border-top:0.5px #ccc solid;
		border-bottom: 0.5px #ccc solid;
		margin-bottom: 3vw;
		color: #333;
		font-size: 1.1em;
	}
	.money div
	{
		text-align: center;
		float: left;
		width: 49.5%;
		height: 80%;
		margin: 2% 0;
	}
	.pledge
	{
		color: #ffa42f;
	}
	.cash
	{
		color: #e34337;
	}
	.bor-rig
	{
		border-right:0.5px #ccc solid;
	}
	.detail
	{
		height: 15vw;
		width: 100%;
		background-color: white;
		border-top:0.5px #ccc solid;
		border-bottom: 0.5px #ccc solid;
		font-size: 1.1em;
	}
	.detail >*
	{
		position: relative;
		top: 5%;
		height: 13.5vw;
		line-height: 13.5vw;
		width: 32%;
		display: inline-block;
		text-align: center;
		color: #555;
	}
	.detail div:first-child
	{
		border-right:0.5px #ccc solid;
	}
	.detail div:nth-child(2)
	{
		border-right:0.5px #ccc solid;
	}
	.minute
	{
		height: 12vw;
		width: 100%;
		background-color: white;
		border-bottom:0.5px #ccc solid;
		color: #999;
		font-size: 1em;
	}
	.minute>*
	{
		display: inline-block;
		width:32%;
		height: 12vw;
		line-height: 12vw; 
		text-align: center;
	}
		.add
	{
		color: #ff9090;
	}
	</style>
</head>
<body>
	<!-- 代码部分begin -->
	<div class="wave-warp">
		<div id="wave" class="wave">
		<span class="wave-number">53.00</span>
		<span class="number-sub">元</span><br>
		<span class="wave-character">账户余额</span></div>
		<a class="callour" href="">联系我们</a>
	</div>
	<div class="money">
		<div class="bor-rig"><span >押金余额(元)<span><br><span class="pledge">￥50.00</span></div>
		<div><span>可用余额(元)<span><br><span class="cash">￥3.00</span></div>
	</div>
	<div class="detail">
		<div>明细</div>
		<div>时间</div>
		<div>备注</div>
	</div>
	<div class="minute">
		<span>-53.00</span>
		<span>2017.01.22</span>
		<span>押金租金支出</span>
	</div>
	<div class="minute">
		<span class="add">+40.00</span>
		<span>2017.01.22</span>
		<span>押金返还</span>
	</div>
	<script>
	var wave = (function () {
	    var ctx;
	    var waveImage;
	    var canvasWidth;
	    var canvasHeight;
	    var needAnimate = false;

	    function init (callback) {
	        var wave = document.getElementById('wave');
	        var canvas = document.createElement('canvas');
	        if (!canvas.getContext) return;
	        ctx = canvas.getContext('2d');
	        canvasWidth = wave.offsetWidth;
	        canvasHeight = wave.offsetHeight;
	        canvas.setAttribute('width', canvasWidth);
	        canvas.setAttribute('height', canvasHeight);
	        wave.appendChild(canvas);
	        waveImage = new Image();
	        waveImage.onload = function () {
	            waveImage.onload = null;
	            callback();
	        }
	        waveImage.src = '../Imgs/white.png';
	    }

	    function animate () {
	        var waveX = 0;
	        var waveY = 0;
	        var waveX_min = -203;
	        var waveY_max = canvasHeight * 0.7;
	        var requestAnimationFrame = 
	            window.requestAnimationFrame || 
	            window.mozRequestAnimationFrame || 
	            window.webkitRequestAnimationFrame || 
	            window.msRequestAnimationFrame ||
	            function (callback) { window.setTimeout(callback, 1000 / 60); };
	        function loop () {
	            ctx.clearRect(0, 0, canvasWidth, canvasHeight);
	            if (!needAnimate) return;
	            if (waveY < waveY_max) waveY += 1.5;
	            if (waveX < waveX_min) waveX = 0; else waveX -= 3;
	            
	            ctx.globalCompositeOperation = 'source-over';
	            ctx.beginPath();
	            ctx.arc(canvasWidth/2, canvasHeight/2, canvasHeight/2, 0, Math.PI*2, true);
	            ctx.closePath();
	            ctx.fill();

	            ctx.globalCompositeOperation = 'source-in';
	            ctx.drawImage(waveImage, waveX, canvasHeight - waveY);
	            
	            requestAnimationFrame(loop);
	        }
	        loop();
	    }

	    function start () {
	        if (!ctx) return init(start);
	        needAnimate = true;
	        setTimeout(function () {
	            if (needAnimate) animate();
	        }, 500);
	    }
	    function stop () {
	        needAnimate = false;
	    }
	    return {start: start, stop: stop};
	}());
	wave.start();
	</script>
	<!-- 代码部分end -->
</body>
</html>