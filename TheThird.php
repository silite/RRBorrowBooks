<?php
    require_once 'LimitVisit.php';
?>
<!doctype html>
<html>
<head>
<!--<script src="RRJS/Code/Lyj/JS/flexible.js"></script>-->
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=no"/>
    <title>书籍详情</title>
<style>
html{
	font-size: 62.5%;
	font-size: 16px;
}
*{
	padding: 0;
	margin: 0;
	border: 0;
}
body{
	position: relative;
}
.cover{
	padding-top:1.5rem;                         /**********/
	padding-bottom:1.5rem;                      /**********/
	border-bottom: 0.05rem solid #cccccc;
}
.covers{
	height: 26rem;                           /**********/
	width: 20rem;
}
.money{
	font-size:3.2rem;
	color:#fb8a13;
}
.text{
	font-size:2.8rem;
	text-indent:5.6rem;
}
.information{
	margin-top:1.5rem;
	padding-left:2.4rem;
	padding-right:2.4rem;
	padding-top:2.5rem;                    /**********/
	border-top: 0.05rem solid #cccccc;
	border-bottom: 0.05rem solid #cccccc;
}
.information2{
	color:#999;
	font-size:2rem;
}
td{
	width: 55%;
}
div{
	background-color:white;
}
body{
	background-color:#f6f6f6;
	position:relative;
	margin:0;
	padding:0;
	z-index: -1;
}
.brief_introduction{
	margin-top: 2rem;
	padding-left:2rem;
	padding-right:2rem;
	padding-top:2.4rem;
	border-top: 0.05rem solid #cccccc;
	border-bottom: 0.05rem solid #cccccc;
	margin-bottom: 9.75rem;
}
.buttons{
	display:block;
	bottom:0;
	height:8.5rem;
	position:fixed;
	background-color:white;
	text-align: center;

}
.one{
	
	left:0;
	width:26%;
	position:fixed;
	height: 8.5rem;
	color:#aaaaaa;
	font-size:1.5rem;
	background-color:white;
	border-top:0.05rem #ccc solid;	
}
.two{
	height: 8.5rem;
	background-color:#f7b321;
	color:white;
	font-size: 2.7rem;
	border-top: 0.05rem #cccccc solid;
	left:26%;
	width:37%;
	position:fixed;
	display: table-cell;
	line-height: 8.5rem;
}
.buttons .small{
	margin-top:1vw;
	height: 4rem;
	width: 4rem;
}
.triangle{
	position: absolute;
    border-top:1.33rem solid transparent;  
    border-bottom:1.33rem solid transparent;
    border-left:2rem solid #ffa42f;
    left: 2rem;
    margin-top: 2rem;
/*	left:1.2rem;
	top:4.33rem;*/
/*	background: transparent;*/
}
#forYourWish{
	display: none;
	width: 80%;
	height: 20rem;
	text-align: center;
	position: fixed;
	top: 32rem;
	left: 10%;
	background-color: #000;
	-moz-opacity:0.8;  opacity: 0.8;
	border-radius: 5rem;
	padding-top: 10rem;
}
#forYourWish div{
	width: 80%;
	height: 100%;
	margin: 0 auto;
	background-color: #000;
	-moz-opacity:0.8;  opacity: 0.8;
}
#forYourWish div img{
	float: left;
	margin-right: 2rem;
}
#forYourWish div h2{
	color: #fff;
	font-size: 3.2rem;
	font-family: "黑体";
	margin-left: 3rem;
	padding-top: 1rem;
	height: 4rem;
	line-height: 4rem;
}
/* 下  */
</style>
</head>

<body>
<?php
    session_start();
    require_once 'GetInfo.php';
    require_once 'JudgeAspirationBooks.php';
    require_once 'JudgeToBorrowBooks.php';
    require_once 'JudgeToPay.php';
    require_once 'JudgePend.php';

    $_SESSION['judge'] = true;
    $OpenID = $_COOKIE['RRJSID'];
    if(!isset($connID)){
	 require_once '../../RRJS/Other/MysqlConnect.php';
         $connID = Connect();
    }
    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $result_rowid = $connID->query($select,'Row');
    $UserID = $result_rowid['ROW_ID'];
    if(isset($either) && !$either)
        $result = AspirationJudge($temp_ROW_ID,$UserID);
    else{
        $result = ToBorrowBooksJudge($temp_ROW_ID,$UserID);
	$HaveToPay = JudgeHaveToPay($UserID,$temp_ROW_ID);
    }
    //    条件较多  可以优化
    if (empty($result))
        $result = 'empty';
    else
        if (!empty($result) && $result['DeleteMark'] == 0)
            $result = 'exist';
        else
            if (!empty($result) && $result['DeleteMark'] == 1)
                $result = 'falsity';

    $HavePend = JudgePend($temp_ROW_ID,$UserID);
?>

	<div class="cover">
		<div class="covers" style="position: relative; margin: 0 auto">
			<img src="<?php echo $temp_images_medium; ?>" style="width: 100%; height: 100%;">
            <?php
    $element0 = <<<'tar'
    <img src="../Imgs/none.png" style="position: absolute; top: -0.75rem; left: -0.75rem;">
tar;
            if(isset($either) && !$either)
                echo $element0;
            ?>

		</div>
	</div>

	<div class="information">
		<span style="font-size:3.4rem;font-weight:500" id="biaoti1" data-ROW_ID="<?php echo $temp_ROW_ID;?>"><?php echo $temp_Title; ?></span><br/>
		<span style="font-size:2.4rem" id="biaoti2"><?php echo $temp_SubTitle; ?></span><br/>
		<p style="font-size: 0.2rem">&nbsp;</p>
		<span class="money" id="money">押金：<?php if($temp_Price != '0') echo round($temp_Price*0.75)."元"; else echo '待定';?></span><br/>
		<p style="font-size: 0.5rem">&nbsp;</p>
		<table class="information2">
			<tr>
				<td>作者：<?php echo $temp_Author; ?></td>
				<td>出版发行：<?php echo $temp_Publisher; ?></td>
			</tr>
			<tr>	
				<td>装帧：<?php echo  $temp_Binding; ?></td>
				<td>版次：<?php echo $temp_PublishDate; ?></td>
			</tr>
			<tr>
				<td>页数：<?php echo $temp_Pages; ?></td>
				<td>ISBN： <?php echo $temp_LISBN; ?></td>

			</tr>
		</table>
		<br/>
	</div>

	<div class="brief_introduction">
		<!-- <div class="triangle"></div> -->
		<p style="font-size:3.2rem;padding-left: 2.5rem">
			<span class="triangle"></span>&nbsp;内容简介
		</p>
		<p class="text" style="padding-bottom:2rem">
            <?php echo $temp_Summary; ?>
		</p>
	</div>


    <div class="buttons">
        <a class="one" onClick="window.location.href='../HTML/HomePage.php'" >
            <img src="../Imgs/FirstPage.png" class="small"/>
            <p>首页</p>
        </a>
    

<?php
    $element1 = <<<'tar'
    <a class="two" id="ToBorrowBooks">加入借书单</a>
    <a class="two" onClick="window.location.href='Submit.php?ISBN=
tar;
    $element1_5 = <<<'tar'
'" style="left: 63%;background-color: #fb8a1c;">立即借阅</a>
tar;

    $element2 = <<<'tar'
    <a class="two" id="addWish">加入愿望单</a>
    <a class="two" onClick="window.location.href='Taunt.php'" style="left: 63%;background-color: #333;">开始吐槽</a>
tar;


    if(isset($either) && $either)
        echo $element1.$temp_LISBN.$element1_5;
    else
        echo $element2;
?>
      </div>

	<div id="forYourWish">
		<div>
			<img src="../Imgs/smile@3x.png">
			<h2>小借君会努力帮你找到这本书的</h2>
		</div>
	</div>
	

	<script src="../JS/jquery.min.js"></script>
	<script>
	var HaveToPay = '<?php if(isset($HaveToPay)) echo $HaveToPay; else echo ''; ?>';
        var x = $("#biaoti1").attr("data-ROW_ID");
        var result = '<?php echo $result; ?>';
        var isbn = '<?php echo $temp_LISBN; ?>';
        var to_borrow_flag = true;
        var HavePend = '<?php echo $HavePend; ?>';
        $("#ToBorrowBooks").click(function () {
            if(HavePend == 1)
                alert("一本书只能同时借一次");
            else
                {
                    if (to_borrow_flag) {
                        if (HaveToPay == 1)
                            alert("此书待付款");
                        else {
                            if (result == 'exist')
                                alert("已在待借书");
                            else
                                $.ajax({
                                    url: "ToBorrowBooksMu.php",
                                    data: {temp_ROW_ID: x, result: result, flag: 1},
                                    type: "POST",
                                    dataType: "TEXT",
                                    success: function () {
                                        to_borrow_flag = false;
                                        alert("已加入");
                                    }
                                });
                        }
                    }
                    else
                        $.ajax({
                            url: "ToBorrowBooksMu.php",
                            data: {temp_ROW_ID: x, result: result, flag: 0},
                            type: "POST",
                            dataType: "TEXT",
                            success: function () {
                                to_borrow_flag = true;
                                alert("已移除");
                            }
                        });
                }
        });

        if(result == 'exist') {
            $("#addWish").css({"background-color": "#ccc", "color": "#999"});
            $("#addWish").text("已加入愿望单");
        }
        else
        {
            $("#addWish").text("加入愿望单");
            $("#addWish").css({"background-color":"#f7b321","color":"#fff"});
        }
        
		$("#addWish").click(function(){
            if($(this).text() == "加入愿望单"){
				$(this).text("已加入愿望单");
				$(this).css({"background-color":"#ccc","color":"#999"});
				$("#forYourWish").fadeIn(1000);
				$("#forYourWish").fadeOut();
                $.ajax({
                    url:"AspirationMu.php",
                    data:{temp_ROW_ID:x,result:result,flag:1},
                    type:"POST",
                    dataType:"TEXT"
                });
            }
			else{
                $.ajax({
                    url:"AspirationMu.php",
                    data:{temp_ROW_ID:x,result:result,flag:0},
                    type:"POST",
                    dataType:"TEXT"
                });
				$(this).text("加入愿望单");
				$(this).css({"background-color":"#f7b321","color":"#fff"});
				$("#forYourWish").stop();
//				需要后期优化返回
				location.href = 'TheThird.php?ISBN='+isbn;
			}
		})
	</script>
</body>
</html>
