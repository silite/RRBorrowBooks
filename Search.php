<?php
    require_once 'LimitVisit.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>搜索图书</title>
    <link rel="stylesheet" href="../CSS/searchStyle.css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:600,300" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../CSS/loaders.css">
    <link rel="stylesheet" href="../CSS/weUI.css">
    <script src="../JS/jquery.min.js"></script>
</head>
<script src="../JS/JudgeInput.js"></script>
<script>
    function checkSubmit(){
        var searchVal = judge($("#searchInput").val());
        $("#searchInput").val(searchVal);
        if($("#searchInput").val() == "" || $("#searchInput").val() == "href"){
            alert("请输入合法字段");
            return false;
        }
        else{
            return true;
        }
    }
</script>
<body>
<!-- 搜索框组件 -->
	<div class="weui-search-bar" id="searchBar" style="background-color: #f6f6f6; width: 93.8%;margin: 2.67vw auto">
        <form class="weui-search-bar__form" action="Search.php" method="get" onsubmit="return checkSubmit()">
            <div class="weui-search-bar__box" >
                <i class="weui-icon-search" style="cursor: pointer; top:1px;" id="mmp1"></i>
                <input type="search" class="weui-search-bar__input" name="searchInput" id="searchInput"  required/>
                <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
            </div>
            <label class="weui-search-bar__label" id="searchText">
                <i class="weui-icon-search" id="mmp2"></i>
                <span id="mmp3">搜索</span>
            </label>
        </form>
        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel" style="color: #999; font-size: 14px;">
            取消
        </a>

    </div>
    <script src="../JS/we-ui-search-bar.js"></script>
	<!-- END____搜索框组件 -->

<div id="setOfBooks" >

    <?php
    $s_flag = true;
    session_start();
    $_SESSION['start'] = 0;
    require_once 'BookOutput.php';
    ?>
</div>
<div style="clear: both"></div>
<div id='mmp' style="visibility:visible; opacity: 0; position: relative; width: 100%; height: 40px; float: right">
    <div class="loader" style="width: 12%; margin: 0 auto;">
        <div class="loader-inner ball-scale-multiple" style="height: 100%">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('main').className += 'loaded';
    });
</script>
<script>
    //                小flag判断回调数据   大flag防止动画停止

    var flag = false,x,fin,
        big_flag = true;
    $(window).scroll(function () {
        if (( $(document).scrollTop() + $(window).height() >= $(document).height()) && big_flag == true) {


            big_flag = false;
            $("#mmp").css("visibility", "visible").animate({opacity: 1}, 1000);

            var div = $("<div></div>");
            div.load("BookOutput.php");
            setTimeout(function () {
                flag = true;
                if (flag == true) {
                    big_flag = true;
                    flag = false;
                    $("#setOfBooks").append(div);
                    $("#mmp").animate({opacity: 0}, 300, function () {
                        $("#mmp").css("visibility", "hidden");
                    });
		    
		    x = $(".judge_")[$(".judge_").length - 1];
                    fin = x.value;
                    if(fin == 1) {
                        big_flag = false;
                        $("#mmp").before("<div style='width: 100%; text-align: center;'><p style='color:grey; margin-top: 10px;'>已经到底了</p></div>");
                        $("#mmp").css("display", "none");
                    }

                }
            }, 2000);

        }
    });
</script>

</body>
</html>
