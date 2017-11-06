<?php
    require_once 'LimitVisit.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>吐槽</title>
</head>
<style>
*{
    margin: 0;
    padding: 0;
    font-family: "黑体";
}
body{
    background-color: #f6f6f6;
}
#header{
    margin: 3.3vw 7.6vw;
}
h4{
    color: #333;
    font-size: 4.8vw;
    height: 1.5em;
}
h5{
    color: #666;
    font-size: 3.73vw;
    line-height: 1.5em;
}
form{
    display: block;
    width: 94vw;
    margin: 0 auto;
    position: relative;
}
form textarea{
    display: block;
    width: 95%;
    height: 40vw;
    padding-left: 4vw;
    padding-top: 4vw;
    font-size: 3.2vw;
    border-radius: 1.6vw;
    border: 1px solid #ccc;
}
textarea:focus{
    outline: 0;
    border: 1px solid #4E8AEB;
}
form p{
    color: #999;
    position: absolute;
    right: 3vw;
    bottom: 3vw;
    font-size: 3.2vw;
}
#smtBox{
    width: 94vw;
    margin: 5.4vw auto;
}
#smt{
    display: block;
    float: right;
    width: 34.66vw;
    height: 10.66vw;
    font-size: 4.28vw;
    color: #fff;
    letter-spacing: 0.5em;
    background-color: #fb8a1c;
    border: 1px solid #ccc;
    border-radius: 1.6vw;
}
/*浮动造成清除浮动影响*/
</style>
<script src="../JS/JudgeInput.js"></script>
<body>
    <div id="header">
        <h4>关于吐槽</h4>
        <h5>亲爱的用户您好，欢迎来吐槽，如果吐槽完还不满意，你可以尝试下砸手机-。-</h5>
    </div>
    <form action="">
                            
        <textarea id="turnBack" placeholder="开始吐槽" maxlength="200"></textarea>  
        <p>还可输入<span id="ableNum"></span>/<span id="MLen"></span></p>
    </form>
    <div id="smtBox"><button id="smt">提交</button></div>
</body>
</html>
<script type="text/javascript" src="../JS/jquery-1.8.0.min.js"></script>
    <script>
        window.onload = function(){
                var tb = document.getElementById("turnBack"),
                num = document.getElementById("ableNum"),
                MLen = document.getElementById("MLen");
                MLen.innerHTML = tb.getAttribute("maxlength");
                num.innerHTML = MLen.innerHTML;
                var MLenNum = MLen.innerHTML;
                
                tb.oninput = function(){
                    num.innerHTML = parseInt(MLenNum) - parseInt(tb.value.length);
                }
            }
	$("#smtBox").click(function(){
		var text = $("#turnBack").val();
		$.ajax({
			url:'SubmitTaunt.php',
			type:"POST",
			data:{Content:text},
			success:function(){
				alert("提交成功");
		}
	});
	});	
    </script>
</body>
<html>
