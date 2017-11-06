<?php
    require_once 'LimitVisit.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no"/>
<title>订单</title>
<style>
html{
	font-size: 62.5%;
}
*{/*?v=1450433481578*/
	padding: 0;
	margin: 0;
	font-family:heiti SC;
}
a{

	text-decoration:none;
	display:flex;
	background-color:white;
	color: #666666;
	flex-wrap: wrap;
}
body{ 
	background-color: white;
	overflow: scroll;
	overflow-x: hidden; 
}
.show{
		display: block;
}
.hide{
		display: none;
}
#nav{
	display:flex;
	position: fixed;
	height: 12rem;
	width: 100%;
	text-align: center;
	border-bottom: 0.05rem solid #eeeeee;
	z-index: 999;
}
#nav p{
	flex: 1;
	font-size: 4.5rem;
	display: table-cell;
	line-height: 12rem;
	width: 100%;
	position: relative;
	padding-bottom: 2.4rem;	
	border-bottom: 0.3rem solid white;
	background-color: white;
}
.BookName{
	font-size: 3.2rem;
	text-align: center;
}

.Two{
	position: relative;
	padding-left: 2rem;
	padding-top: 18rem;
	height: 120rem;
}
.Two:after{
	display: block;
	content: '';
	clear: both;
}
.Twos{
	margin-left: 2rem;
	margin-right: 2rem;
	margin-top: 1rem;
	margin-bottom: 2rem;
	width: 29%;
	float: left;
	position: relative;
}
.spanTwos{
	width: 100%;
}
.BookCover{
	width: 100%;
	height: 35rem;
}

.chooseImg{
	cursor: pointer;
	display: none;
	position: absolute;
	right: 0;
}

.button{
	background-color: white;
	width: 30%;
	height: 11rem;
	line-height: 11rem;
	position: fixed;
	bottom: 25rem;
	right: 5rem;
	box-shadow: 0 0 3rem #cccccc;
	text-align: center;
	display: inline-block;
	display: table-cell;
	vertical-align: middle;
	border-radius: 6rem;
	border: 0.6rem solid #ffffff;
	font-size: 4.5rem;
}
.blank{
	position: absolute;
	background-color: white;
	height: 67.7rem;
}
.input{
	border:0.1vw #ccc solid;
	display: flex;
	position: fixed;
	bottom: -20rem;
	/* bottom: 0rem; */
	height: 15rem;
	width: 100%;
	z-index: 999;
}
.input1{
	flex: 1;
	background-color: white;
	color: #999999;
	text-align: center;
	font-size: 5rem;
	display: inline-block;
	display: table-cell;
	vertical-align: middle;
	line-height: 15rem;
	height: 15rem;
}
.input2{
	flex: 1;
	background-color: #fb8a1c;
	color: white;
	text-align: center;
	font-size: 5rem;
	display: inline-block;
	display: table-cell;
	vertical-align: middle;
	line-height: 15rem;
	height: 15rem;
}

#nav p.active{
	color: #fb8a1c;
	border-bottom-color: #fb8a1c;
}
#return{
	padding-bottom: 35rem;
}

</style>
</head >	
<body>
<div id="nav">
<p class="active" id="borrowed">已借书单</p>
<p id="returned">归还书单</p>
<p id="wish">心愿书单</p>
</div>
	<div id="returnbook" class="show" name="page" >
        <div id="return" class="Two">
<?php
    $path = '../Media/BookPic/M_';
   
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect(); 
    $OpenID = $_COOKIE['RRJSID'];
    $select = "SELECT ROW_ID FROM UserInfo WHERE OpenID = '".$OpenID."';";
    $result_rowid = $connID->query($select,'Row');
    $UserID = $result_rowid['ROW_ID'];

    if(isset($_GET['id']))
        $id = $_GET['id'];
    require_once 'BorrowedFetch.php';
//    这里查找到ROW_ID 和始末时间
    $result_borrowed = BorrowedBBooksFetch($OpenID,false);
    $len_borrowed = count($result_borrowed);
    if(isset($_COOKIE['order']) && strlen($_COOKIE['order']) != 0)
    {
        $order = $_COOKIE['order'];
        $order = explode(",",$order);
        foreach ( $order as $item ) {
            $ID = $result_borrowed[$item]['ROW_ID'];
            $connID->update('BorrowedBooks','DeleteMark','1',"BookID='".$ID."' AND UserID = '".$UserID."'");
            $arrayDataValue = array("ROW_ID" => 'UUID()',
                "BookID"=>"'$ID'",
                "ReturnedDate"=>'NOW()',
                "UserID"=>"'$UserID'");
            $connID->insert('ReturnedBooks', $arrayDataValue);
        }
        setcookie("order","",time()-3600);
            echo '<script>  location.href = "Order.php?id=2"; </script>';
    }

$element1 = <<<'tar'
			<a href="TheThird.php?ISBN=
tar;

//    这里加ISBN
        $element2 = <<<'tar'
" class="Twos"  data-order="
tar;
        $element3 = <<<'tar'
">
				<span class="spanTwos">
					<p>
						<img src="
tar;
//        这里有图片
        $element4 = <<<'tar'
" class="BookCover pageOneBookCover"><p><p class="BookName">
tar;
//		这里有书名
        $element5 = <<<'tar'
        </p>
				</span>
				<span class="rTime" style="display: block;position: absolute; font-size:2.5rem;left: 0;right: 0;bottom: 4.5rem; z-index: 11;text-align: center;background-color: #fb8a1c;color: white;width: 100%" left_sec="
tar;
//        这里有时间
        $element6 = <<<'tar'
"></span>
				<img class="chooseImg" src="../Imgs/selector-icon@3x.png" >
			</a>
tar;

for($i = 0;$i < $len_borrowed;$i++) {
    if($result_borrowed[$i]['DeleteMark'] == 0){
    $left_data =strtotime($result_borrowed[$i]['EndDate']) - strtotime("now");
    echo $element1 . $result_borrowed[$i]['LISBN'] . $element2 . $i . $element3 . $path . $result_borrowed[$i]['ROW_ID'] . '.jpg' . $element4 . $result_borrowed[$i]['Title'] .$element5.$left_data.$element6;
}
}

?>
        </div>
		<div>
			<a class="button" id="editBook" style="z-index: 999"><span>编辑还书</span></a>
		</div>

		<div class="input">
			<a href="#" class="input1" id="cancel">取消</a>
			<a href="#" class="input2" id="submit_books">提交还书</a>
		</div>
		
	</div>


	<div id="returnedbook" class="hide" name="page">
		<div id="returned" class="Two">
<?php
    $element7 = <<<'tar'
<a href="TheThird.php?ISBN=
tar;
//这里有ISBN
    $element8 = <<<'tar'
" class="Twos">
				<span class="spanTwos">
					<p>
						<img src="
tar;
//    这里有图片
    $element9 = <<<'tar'
" class="BookCover"><p><p class="BookName">
tar;
//这里有书名
    $element10 = <<<'tar'
</p>
				</span>
			</a>
tar;
    require_once 'ReturnedFetch.php';
    $result_returned = ReturnedBooksFetch($OpenID,false);
    $len_returned = count($result_returned);
    for($i = 0;$i < $len_returned;$i++) {
        if ($result_returned[$i]['DeleteMark'] == 0)
            echo $element7.$result_returned[$i]['LISBN'].$element8. $path . $result_returned[$i]['ROW_ID'] . '.jpg'.$element9.$result_returned[$i]['Title'].$element10;
    }
?>
		</div>

		<div>
			<a href="#" class="button" id="addBook"  style="z-index: 998"><span>添加书籍</span></a> 
		</div>
		
	</div>

	<div id="wannabook" name="page" class="hide">
		<div id="wanna" class="Two">
            <?php
            $element11 = <<<'tar'
<a href="TheThird.php?ISBN=
tar;
//         这里有ISBN
            $element12 = <<<'tar'
" class="Twos" style="position: relative">
				<span class="spanTwos" >
					<p class="noBook">
						<img src="
tar;
//这里有图片
            $element13 = <<<'tar'
" class="BookCover">
tar;
//            元素14为判断输出暂无标签
            $element14 = <<<'tar'
<img src="../Imgs/none.png"  style="width: 8rem; height: 8rem;position: absolute; top: -0.8rem; left: -0.9rem;">
tar;
            $element15 = <<<'tar'
</p>
					<p class="BookName">
tar;
//这里有书名
            $element16 = <<<'tar'
</p>
				</span>
			</a>
tar;
            require_once 'AspirationFetch.php';
            $result_aspiration = AspirationBooksFetch($OpenID,false);
            $len_aspiration = count($result_aspiration);
            for($i = 0;$i < $len_aspiration;$i++) {
                if ($result_aspiration[$i]['DeleteMark'] == 0)
                    echo $element11.$result_aspiration[$i]['LISBN'].$element12.$path . $result_aspiration[$i]['ROW_ID'] . '.jpg'.$element13.$element14.$element15.$result_aspiration[$i]['Title'].$element16;
            }
            ?>

		</div>
	</div>
<script src="../JS/jquery.min.js"></script>
<script>
        var order = [];
		var nav=document.getElementById("nav"),
			opt=nav.getElementsByTagName("p"),
			page=document.getElementsByName("page"),
			choseImgFlag = false;

		function canChoose(){
			$(".chooseImg").show();
		}

        setInterval(function () {
            $(".rTime").each(function () {
                var left_date = $(this).attr("left_sec");
                left_date--;
                $(this).attr("left_sec",left_date);
                var left_day = Math.floor(left_date / 86400);
                var temp_left = left_date % 86400;
                var left_hours = Math.floor(temp_left / 3600);
                var temp_left = temp_left % 3600;
                var left_min = Math.floor(temp_left /60);
                var left_sec = temp_left % 60;
                var left_date = left_day+"天"+left_hours+"时"+left_min+"分"+left_sec+"秒";
                $(this).html(left_date);
            });
        },1000);

        function submitBarIn(){             //Bar in   执行回调函数
			choseImgFlag = true;
			canChoose();
			$(".input").animate({
				bottom: "0"
			});
			$("#editBook").fadeOut();
			$("#return a").each(function(){
                $(this).attr("data-href",$(this).attr("href"));
			    $(this).removeAttr("href");
            })
		}

		function submitBarOut(){						//Bar out
			choseImgFlag = false;
			$(".input").animate({
				bottom: "-20rem"
			});
			$("#editBook").fadeIn();
			$("a").each(function () {
                $(this).attr("href",$(this).attr("data-href"));
            });
		}
		
		$(".button").click(submitBarIn);          //两个页面点击都  Bar In
		

		for(var i = 0;i < opt.length;i++){                  //点击切换"页面"事件
			(function(i){
				opt[i].index = i;
				opt[i].onclick =  function(){                 //点击切换"页面"事件  核心函数
					if(i != '0'){                          //重点
						submitBarOut();
						$(".chooseImg").hide();
					}
					for(var j = 0;j<opt.length;j++){
						opt[j].className="";
					}
					this.className="active";
					for(var k = 0; k < page.length; k++){
		                page[k].className = "hide";
		            }
		            page[this.index].className = "show";
				};
			})(i)
		}

		//归还书籍的添加书单按钮
		document.getElementById("addBook").onclick = function(){     
			for(var j = 0;j<opt.length;j++){
						opt[j].className="";
			}
			opt[0].className="active";
			for(var k = 0; k < page.length; k++) {
	            page[k].className = "hide";
	        }
	        page[opt[0].index].className = "show";
		}


		// 点击选择切换图片
		// 	第一种方法切换图片
		$(".chooseImg").click(function(){
			if($(this).attr("src") == "../Imgs/selector-icon1@3x.png" ){
                $(this).attr("src", "../Imgs/selector-icon@3x.png");               //弄成未选中

                order.splice(order.indexOf( $(this).parent().attr("data-order") ),1);

            }
			else {
                $(this).attr("src", "../Imgs/selector-icon1@3x.png");             //选中

                order.push($(this).parent().attr("data-order"));

            }
		});
			//第二种方法切换图片
		$(".pageOneBookCover").click(function(){
			if(choseImgFlag){
				var choseImg = $(this).parents("a").find(".chooseImg");
				// console.log(choseImg);
				if(choseImg.attr("src") == "../Imgs/selector-icon1@3x.png" ) {
                    choseImg.attr("src", "../Imgs/selector-icon@3x.png");

                    order.splice(order.indexOf( $(this).parents("a").attr("data-order") ),1);
                }
				else {
                    choseImg.attr("src", "../Imgs/selector-icon1@3x.png");

                    order.push($(this).parents("a").attr("data-order"));
                }
			}
		});



		//点击取消   造成已经选择书籍变未选
		$("#cancel").click(function(){
		    order = [];
			$(".chooseImg").hide();
			$(".chooseImg").each(function(){
				if($(this).attr("src") == "../Imgs/selector-icon1@3x.png" )
					$(this).attr("src","../Imgs/selector-icon@3x.png");
			});
			submitBarOut();
		})
        var id = '<?php if(isset($id)) echo $id; else echo "0"; ?>';
        if(id == 1)
            $("#borrowed").trigger('click');
        if(id == 2)
            $("#returned").trigger('click');
        if(id == 3)
            $("#wish").trigger('click');
        $("#submit_books").click(function () {
           document.cookie = "order="+order;
           location.href = "Order.php";
        });

</script>
</body>
</html>
