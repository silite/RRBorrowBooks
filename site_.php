<?php
    require_once 'LimitVisit.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="telephone=no" name="format-detection">
	<title>地址管理</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <script type="text/javascript" src="../JS/jquery-1.8.0.min.js"></script>
		<style>
	*{
		padding: 0;
		margin:0;
	}
	body
	{
		background-color: #f6f6f6;
		overflow-y: hidden;
	}
	#add
	{
		position: fixed;
		bottom: 3vw;
		height: 10vw;
		width: 70%;
		left: 15%;
		font-size: 1em;
		border:none;
		background-color: #fb8a1c;
		border-radius: 12px/12px;
		color: white;
	}
    #main{
        overflow: hidden;
    }
    /*以上*/
	.consignee
	{
        display: block;
        -webkit-transform: translateX(0px);
        /*以上*/
		position: relative;
		margin-bottom: 2vw;
		height: 25vw;
		/*width: 125vw;*/
		border-top:0.5px #ccc solid;
		border-bottom:0.5px #ccc solid;
		background-color: white;	
	}
	.choose-imge1
	{
		position: absolute;
		height: 100%;
		width: 15%;
		background-image: url("../Imgs/Y.png");
		background-repeat: no-repeat;
		background-position: center;
		background-size: 45% 27%;
		-webkit-tap-highlight-color:rgba(0,0,0,0);
	}
	.choose-imge2
	{
		position: absolute;
		height: 100%;
		width: 15%;
		background-image: url("../Imgs/Ya.png");
		background-repeat: no-repeat;
		background-position: center;
		background-size: 45% 27%;
		-webkit-tap-highlight-color:rgba(0,0,0,0);
	}
	.name
	{
		position: absolute;
		left: 15%;
		top: 10%;
		font-size:1.2em;
	}
	.number
	{
		position: absolute;
		top: 10%;
		left: 40%;
		font-family: heiti SC;
		font-size: 1.2em;
	}
	.site
	{
		position: absolute;
		top: 65%;
		left: 15%;
		font-size: 1em;
		color: #ccc;
	}
	.amend
	{
		position: absolute;
		right: 0;
		width: 15%;
		height: 100%;
		background-image: url("../Imgs/X.png");
		background-repeat: no-repeat;
		background-position: center;
		background-size: 33% 20%;
		-webkit-tap-highlight-color:rgba(0,0,0,0);/*除去点击阴影效果*/
	}
	#grayBack{
    display: none;
    background-color: #000;
    -moz-opacity:0.6;opacity: 0.6;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 3;
}

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
.setInput{
    height: 8vw;
    line-height: 8vw;
    margin: 2.67vw 0;
    margin-bottom: 3px;
}

.setInput > span{
    display: inline-block;
    width: 14.93vw;
    text-align: right;
}
.setInput input{
    width: 73vw;
    height: 100%;
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
	</style>
</head>
<body>
	<div id="main">
		<!-- 主页面 -->
<?php
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    require_once 'UserAddressFetch.php';
    $OpenID = $_COOKIE['RRJSID'];
    $result = UserAddressFetch($OpenID,'All');
    $element0 = <<<'tar'
<p class="consignee" data-back="">

<span style="display: block; position: absolute;left: 15%; width:70%;height: 25vw;z-index: 999;  "></span>

<span name="modify" class="amend"></span>
		<span class="choose-imge2" name="check"></span>
			<span class="name">
tar;
        $element1 = <<<'tar'
</span>
			<span class="number">
tar;
        $element2 = <<<'tar'
</span>
			<span class="site">
tar;
        $element3 = <<<'tar'
</span>

<span class="btn-delete" style="background-color: #fb8a1c;letter-spacing: 0.2em;color: #eee;text-align:center;display: block;position: absolute; top: 0; right: -50px; width:50px; height: 25vw;line-height: 25vw; ">删除</span>

<input type="hidden" class="ROW_ID_change" value="
tar;
        $element4 = <<<'tar'
">
	</p>
tar;
        $len = count($result);
        for($i = 0;$i<$len;$i++)
            if($result[$i]['DeleteMark'] == 0)
                echo $element0.$result[$i]['UserName'].$element1.$result[$i]['PhoneNumber'].$element2.$result[$i]['College']."&nbsp;&nbsp;&nbsp;"."<span class='add'>".$result[$i]['Address']."</span>".$element3.$result[$i]['ROW_ID'].$element4;
echo '<div style="height: 600px;width: 100%;" id="judge_back"></div>';
?>
	</div>
	<button id="add">+ 新建地址</button>
	<!-- 添加按钮 -->
	<div id="grayBack"></div>
	<!-- 灰度块 -->

    <div id="addAddress">
        <div id="contentAddress">
            <div class="setInput">
                <span>收书人:</span>
                <input id="receive" type="text" placeholder="请输入收书人姓名">            <!--表单元素-->
            </div>
            <div class="setInput">
                <span>手机号:</span>
                <input id="phone-number"  type="text" placeholder="请输入收书人手机号码">          <!--表单元素-->
            </div>
            <!-- start 高校选择器 -->
            <div class="setInput">
                <span>高 校:</span>
                <input  type="text" align="center"  name="cho_Insurer" id="cho_Insurer" value="湖南科技大学" disabled>          <!--表单元素-->
            </div>          
	    <div class="setInput" style="margin-bottom: 5vw;" >
                <span>详&nbsp;址:</span>
                <input id="dormitory"type="text" placeholder="请精确到宿舍号以方便送书">   <!--表单元素-->
            </div>
            <!-- end 高校选择器 -->
        </div>
	<button type="submit" id="submitAddress" value="mmp">保存并使用</button>
    </div>

<?php
    if(isset($_COOKIE['AddOrder'])  && !empty($result) )
        $AddOrder = $_COOKIE['AddOrder'];
?>
<!-- 弹窗 -->
    <script src="../JS/JudgeInput.js"></script>
	<script>
        var click_judge = '';
        var isbn = '<?php if(isset($_GET['ISBN'])) echo $_GET['ISBN']; else echo "";?>';
        var add = '<?php if(isset($_GET['add'])) echo $_GET['add']; else echo ""; ?>';

		$(function(){
				// 弹窗弹出与收回
            function turnTo(){
                $("#addAddress").animate({bottom: "0"},500);
                $("#submitAddress").animate({bottom: "0"},500);
                $("#grayBack").fadeIn(500);
            }
            function turnToBack(){
                $("#addAddress").animate({bottom: "-566px"},500);
                $("#submitAddress").animate({bottom: "-100px"},500);
                $("#grayBack").fadeOut(500);
            }

			var img1=document.getElementsByName("check");

            var AddOrder = "<?php if (isset($AddOrder)) echo $AddOrder; else echo 'mmp'; ?>";
            if(AddOrder != 'mmp')
                img1[AddOrder].className="choose-imge1";


            for(var i=0;i<img1.length;i++){
				change(img1[i],i);
			}

			function change(obj,i){
				//勾选
				obj.onclick = function(){
					for(var j=0;j<img1.length;j++){
                        img1[j].className="choose-imge2";
                    }
					obj.className="choose-imge1";
                    if(add == 'personal')
                        location.href= "PersonalCenter.php?"+"AddOrder="+i;
                    else
                        location.href= "Submit.php?"+"AddOrder="+i+"&ISBN="+isbn;
				}
			}

            $("#add").click(function () {
                turnTo();
                click_judge = 'add_address';
                $("#receive").removeAttr("value");
                $("#phone-number").removeAttr("value");
                $("#dormitory").removeAttr("value");
            });
            $("#grayBack").click(turnToBack);
            $("#submitAddress").click(function () {

                var phone = judge($("#phone-number").val()),
                    recv = judge($("#receive").val()),
                    dmt = judge($("#dormitory").val());
                $("#phone-number").val(phone);
                $("#receive").val(recv);
                $("#dormitory").val(dmt);

                if($("#receive").val() == "" || $("#phone-number").val().length != 11 || isNaN($("#phone-number").val()) || $("#dormitory").val() == ""){
                    alert("请填写正确信息!");
                }else {
                    var submit_this = $(this);
                    var a = submit_this.parent().find("#receive");
                    var b = submit_this.parent().find("#phone-number");
                    var c = submit_this.parent().find("#dormitory");
                    var d = submit_this.parent().find("#cho_Province");
                    var e = submit_this.parent().find("#cho_City");
                    var f = submit_this.parent().find("#cho_Area");
                    var g = submit_this.parent().find("#cho_Insurer");
                    turnToBack();
                    if (click_judge == 'mod_address') {
                        $.ajax({
                            url: 'AddressOption.php',
                            data: {
                                PhoneNumber: b.val(),
                                UserName: a.val(),
                                cho_Province: d.val(),
                                cho_City: e.val(),
                                cho_Area: f.val(),
                                cho_Insurer: g.val(),
                                Address: c.val(),
                                method: "change"
                            },
                            type: "POST",
                            dataType: "TEXT",
                            success: function () {
                                click_judge = '';
                                alert("修改成功");
                                history.go(0);
                            }
                        });
                    }
                    if (click_judge == 'add_address') {
                        $.ajax({
                            url: 'AddressOption.php',
                            data: {
                                PhoneNumber: b.val(),
                                UserName: a.val(),
                                cho_Province: d.val(),
                                cho_City: e.val(),
                                cho_Area: f.val(),
                                cho_Insurer: g.val(),
                                Address: c.val(),
                                method: "modify"
                            },
                            type: "POST",
                            dataType: "TEXT",
                            success: function () {
                                click_judge = '';
                                alert("添加成功");
                                history.go(0);
                            }
                        });
                    }
                }
            });

            $("span[name='modify']").click(function () {
                turnTo();
                click_judge = 'mod_address';
                var a = $(this).parent().find(".name").text();
                var b = $(this).parent().find(".number").text();
                var c = $(this).parent().find(".add").text();
                var d = $(this).parent().find(".ROW_ID_change").val();
                document.cookie = "ROW_ID_change="+d;
                $("#receive").attr("value",a);
                $("#phone-number").attr("value",b);
                $("#dormitory").attr("value",c);
            });
		});
	</script>

    <script>
        
        $(".btn-delete").each(function () {
            var btn_this = $(this);
            btn_this.click(function () {
                var judge_delete = confirm("是否删除~");
                if(!judge_delete)
                    $(".consignee").css("transform", "translateX(0px)");
                else{
                    var ROW_ID = $(this).next().val();
                    $.ajax({
                        url:'AddressDelete.php',
                        type:'POST',
                        data:{ROW_ID:ROW_ID},
                        dataType:'TEXT',
                        success:function () {
                            btn_this.parent().css("display","none");
                        }
                    });
                }
            });
        });
        
        if(add == 'personal') {
	    alert("右滑可删除地址");
            $("#judge_back").click(function () {
                $(".consignee").css("transform", "translateX(0px)");
            });
            var initX; //触摸位置
            var moveX; //滑动时的位置
            var X = 0; //移动距离
            var objX = 0; //目标对象位置

            window.addEventListener('touchstart', function (event) {
                var obj = event.target.parentNode;
                if (obj.className == "consignee") {
                    initX = event.targetTouches[0].pageX;
                    objX = (obj.style.WebkitTransform.replace(/translateX\(/g, "").replace(/px\)/g, "")) * 1;
                }
                if (objX == 0) {
                    window.addEventListener('touchmove', function (event) {
                        var obj = event.target.parentNode;
                        if (obj.className == "consignee") {
                            moveX = event.targetTouches[0].pageX;
                            X = moveX - initX;
                            if (X >= 0) {
                                obj.style.WebkitTransform = "translateX(" + 0 + "px)";
                            } else if (X < 0) {
                                var l = Math.abs(X);
                                obj.style.WebkitTransform = "translateX(" + -l + "px)";
                                if (l > 50) {
                                    l = 50;
                                    obj.style.WebkitTransform = "translateX(" + -l + "px)";
                                }
                            }
                        }
                    });
                } else if (objX < 0) {
                    window.addEventListener('touchmove', function (event) {
                        var obj = event.target.parentNode;
                        if (obj.className == "consignee") {
                            moveX = event.targetTouches[0].pageX;
                            X = moveX - initX;
                            if (X >= 0) {
                                var r = -50 + Math.abs(X);
                                obj.style.WebkitTransform = "translateX(" + r + "px)";
                                if (r > 0) {
                                    r = 0;
                                    obj.style.WebkitTransform = "translateX(" + r + "px)";
                                }
                            } else { //向左滑动
                                obj.style.WebkitTransform = "translateX(" + -50 + "px)";
                            }
                        }
                    });
                }
            })
            window.addEventListener('touchend', function (event) {
                $(".consignee").each(function () {
                    if ($(this).css("transform") == 'matrix(1, 0, 0, 1, -50, 0)')
                        $(this).attr("data-back", "1");
                    else
                        $(this).attr("data-back", "0");
                    $(this).click(function () {
                        if ($(this).attr("data-back") != "1")
                            $(".consignee").css("transform", "translateX(0px)");
                    });
                });
                var obj = event.target.parentNode;
                if (obj.className == "consignee") {
                    objX = (obj.style.WebkitTransform.replace(/translateX\(/g, "").replace(/px\)/g, "")) * 1;
                    if (objX > -25) {
                        obj.style.WebkitTransform = "translateX(" + 0 + "px)";
                        objX = 0;
                    } else {
                        obj.style.WebkitTransform = "translateX(" + -50 + "px)";
                        objX = -50;
                    }
                }
            });
        }
        else{
            var one_time = true;
            window.addEventListener('touchstart', function (event) {
                var obj = event.target.parentNode;
                if (obj.className == "consignee") {
                    initX = event.targetTouches[0].pageX;
                    objX = (obj.style.WebkitTransform.replace(/translateX\(/g, "").replace(/px\)/g, "")) * 1;
                }
                if (objX == 0) {
                    window.addEventListener('touchmove', function (event) {
                        var obj = event.target.parentNode;
                        if (obj.className == "consignee") {
                            moveX = event.targetTouches[0].pageX;
                            X = moveX - initX;
                            if (X < 0) {
                                var l = Math.abs(X);
                                if (l > 100 && one_time) {
                                    one_time = false;
                                    alert("请在个人中心管理地址");
                                }
                            }
                        }
                    });
                    one_time = true;
                }
            })
        }

    </script>
</body>
</html>
