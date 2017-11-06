<?php
    require_once 'LimitVisit.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta content="telephone=no" name="format-detection">
	<title>订单详情</title>
	<style>
		*
		{
			margin: 0;
			padding: 0;
			font-family: heiti SC;
		}
		body
		{
			background-color: #ccc;
		}
		#site
		{
			position: relative;
			height: 18vw;
			font-size: 4vw;
			background-color: white;
			border-bottom: 0.1vw #ccc solid;
		}
		.siteimg
		{
			position: absolute;
			left: 3vw;
			width: 5vw;
			height: 5vw;
			bottom: 3vw;
		}
		.name
		{
			position: absolute;
			left: 10vw;
			top: 3vw;
		}
		.phoneNumber
		{
			position: absolute;
			left: 50vw;
			top: 3vw;
		}
		.college
		{
			position: absolute;
			left: 10vw;
			bottom: 3vw;
		}
		.dormitory
		{
			position: absolute;
			left: 50vw;
			bottom: 3vw;
		}
		#bookInformation
		{
			position: relative;
			margin-top: 3vw;
			height: 40vw;
			background-color: white;
			width: 100vw;
			border-top:0.1vw #ccc solid;
   		    border-bottom:0.1vw #ccc solid;
   		    margin-bottom: 3vw;
		}
		.bookimg
		{
			position: absolute;
			width: 22vw;
			height: 32vw;
			left: 3vw;
			top: 4vw;
		}
		.bookname
		{
			position: absolute;
			left: 28vw;
			top: 4vw;
			font-size: 4vw;
		}
		.author
		{
			position: absolute;
			left: 28vw;
			top: 11vw;
			font-size: 3.5vw;
		}
		#over
		{
			background-color: white;
			margin-top: 3vw;
			border-top: 0.1vw #ccc solid;
			border-bottom: 0.1vw #ccc solid;
		}
		#over>*
		{
			position: relative;
			margin-left: 3vw;
			line-height: 11vw;
			clear: both;
			height: 11vw;
			width: 97vw;
			border-bottom: 0.1vw #ccc solid;
			background-color: white;
			font-size: 3.5vw;
		}
		.right
		{
				position: absolute;
				right: 5vw;
				color: #666;
		}
		.all
		{
			position: absolute;
			right: 5vw;
			color: #fb8a1c;
		}
	</style>
</head>
<?php
    $OrderNo = $_GET['OrderNo'];
    $OpenID = $_COOKIE['RRJSID'];
    $BookID = $_GET['BookID'];
    require_once '../../RRJS/Other/MysqlConnect.php';
    $connID = Connect();
    $select_DeliveredInfo = "SELECT ROW_ID,DeliveredInfo,StartDate FROM OrderInfo WHERE OrderNo = '".$OrderNo."';";
    $result_DeliveredInfo = $connID->query($select_DeliveredInfo,'Row');
    $AddressID = $result_DeliveredInfo['DeliveredInfo'];
    $select_AddressInfo = "SELECT UserName,PhoneNumber,College,Address FROM UserAddress WHERE ROW_ID = '".$AddressID."';";
    $result_address = $connID->query($select_AddressInfo,'Row');
    //地址搜索结束
    $select_BookInfo = "SELECT Title,Author FROM BookInfo WHERE ROW_ID = '".$BookID."'";
    $result_BookInfo = $connID->query($select_BookInfo,'Row');
    //图书搜索结束
    $select_OrderBookInfo = "SELECT InCome,EndDate FROM OrderBook WHERE OrderID = '".$result_DeliveredInfo['ROW_ID']."'";
    $result_OrderBookInfo = $connID->query($select_OrderBookInfo,'Row');

    $EndDate = strtotime($result_OrderBookInfo['EndDate']) - strtotime($result_DeliveredInfo['StartDate']);
   $EndDate = round($EndDate / 604800);

?>
<body>
     <div id="site"><!--地址不可更改，这里不可以点击-->
        <img src="../Imgs/site.png" class="siteimg"/><!--这个图数据库里面有，名字是一样的-->
     	<span class="name"><?php echo $result_address['UserName']; ?></span>
     	<span class="phoneNumber"><?php echo $result_address['PhoneNumber']; ?></span>
     	<span class="college"><?php echo $result_address['College']; ?></span>
     	<span class="dormitory"><?php echo $result_address['Address']; ?></span>
     </div>
     <div id="bookInformation">
     	<img src="<?php echo '../Media/BookPic/M_'.$BookID.'.jpg'; ?>" class="bookimg"></img><!--书籍图片-->
     	<span class="bookname"><?php echo $result_BookInfo['Title']; ?></span>
     	<span class="author"><?php echo $result_BookInfo['Author']; ?></span>
     </div>
     <div id="over">
	 <div><span>借书时长:</span><span class="right"><?php echo $EndDate; ?>周</span></div>
	 <div><span>押金合计:</span><span class="right">￥<?php if($BookID != '08f1874b-9471-11e7-bb0f-00163e06cefc') echo '25'; else echo '60'; ?></span></div>
     <div><span>租金合计:</span><span class="right">￥<?php 
if($BookID != '08f1874b-9471-11e7-bb0f-00163e06cefc') $sub = 25; else $sub = 60;
echo $result_OrderBookInfo['InCome'] - $sub; 
?></span></div>
	 <div><span>已用卡券:</span><span class="right">无</span></div>
	 <div><span class="all">合计金额： ￥<?php echo $result_OrderBookInfo['InCome']; ?>元</span></div>
     </div>
</body>
</html>
