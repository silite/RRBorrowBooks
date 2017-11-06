<?php
//  获得图书具体信息页   首次为显示API返回结果   以后为显示数据库中的结果   查询语句不同  不能封装
//  这里为相对路径    重要
    $path = '../Media/BookPic/';
    require_once 'ISBNFetch.php';
    require_once 'JudgeLocal.php';
    if(isset($_GET['ISBN'])) {
        $ISBN = $_GET['ISBN'];
    }
    else
	$ISBN = '';
    $result = ISBNFetch($ISBN);
//    二者存储结构不一样    要讨论读取或存储
    if(!empty($result)) {
//        防止后退访问数据库并增加访问量
        if($_SESSION['judge']) {
	    require_once '../../RRJS/Other/MysqlConnect.php';
            $connID = Connect();
            $connID->update('BookInfo', 'SearchCounts', 'SearchCounts', "LISBN = $ISBN",'1');
        }
        $temp_ROW_ID = $result['ROW_ID'];
        $either = Judge($temp_ROW_ID);
        $temp_LISBN = $result["LISBN"];
        $temp_Price = $result["Price"];
        $temp_Title = $result["Title"];
        $temp_Author = $result["Author"];
        $temp_Publisher = $result["Publisher"];
        $temp_Binding = $result["Binding"];
        $temp_PublishDate = $result["PublishDate"];
        $temp_Pages = $result["Pages"];
        $temp_Summary = $result["Summary"];
        $temp_SubTitle = $result["SubTitle"];
        $temp_images_medium = $path.'M_'.$temp_ROW_ID.'.jpg';
    }
    else {
//        入库和存储图片
        require_once 'BookInfo.php';
        $temp = GetBookInfo($ISBN);
        $either = false;
        if ($temp["reason"] != '未找到相关数据信息') {
            $temp_LISBN = $temp["result"]["isbn13"];
            $temp_SISBN = $temp["result"]["isbn10"];
            $temp_Title = $temp["result"]["title"];
            $temp_Author = $temp["result"]["author"];
            $temp_Translator = $temp["result"]["translator"];
            $temp_Pages = $temp["result"]["pages"];
            $temp_Summary = $temp["result"]["summary"];
            $temp_images_large = $temp["result"]["images_large"];
            $temp_images_medium = $temp["result"]["images_medium"];
            $temp_Binding = $temp["result"]["binding"];
            $temp_PublishDate = $temp["result"]["pubdate"];
            $temp_Publisher = $temp["result"]["publisher"];
            $temp_Price = (float)$temp["result"]["price"];
            $temp_LevelNum = (float)$temp["result"]["levelNum"];
            $temp_SubTitle = $temp["result"]["subtitle"];
//          这里else内执行首次搜索结果存入操作

            require_once 'ISBNMU.php';
            $temp_ROW_ID = $ROW_ID;
            GetImage($temp_images_medium, '1',$ROW_ID);
            $ImageName = GetImage($temp_images_large, '2',$ROW_ID);
        }
    }
//    这里可以将会话保留到提交页面    也可以保证在提交页面后退时不会进行读库操作
    $_SESSION['temp_LISBN'] = $temp_LISBN;
    $_SESSION['temp_Pages'] = $temp_Pages;
    $_SESSION['temp_PublishDate'] = $temp_PublishDate;
    $_SESSION['temp_Publisher'] = $temp_Publisher;
    $_SESSION['temp_Binding'] = $temp_Binding;
    $_SESSION['temp_Author'] = $temp_Author;
    $_SESSION['temp_Title'] = $temp_Title;
    $_SESSION['temp_SubTitle'] = $temp_SubTitle;
    $_SESSION['temp_images_medium'] = $temp_images_medium;
    $_SESSION['temp_Price'] = $temp_Price;
    $_SESSION['temp_Summary'] = $temp_Summary;
    $_SESSION['temp_ROW_ID'] = $temp_ROW_ID;
?>
