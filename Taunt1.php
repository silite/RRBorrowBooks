<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>开始吐槽</title>
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        .block1{
            /*-webkit-appearance:none;*/
            border:0.5px #cccccc solid;
            position: absolute;
            top: 22%;
            height: 28%;
            width: 96%;
            background-color: white;
            font-size: 3em;
            left: 2%;
            border-radius: 12px/12px;

        }
        .block2{
            position: absolute;
            top: 52%;
            left: 63%;
            height: 8%;
            width: 35%;
            font-size: 3em;
            color: white;
            background-color: #fb8a1c;
            border:none;
            border-radius:12px/12px;
        }
    </style>
</head>
<body style="background-color: #f6f6f6; height: 603px;">
    <p style="position: absolute;left: 2%;top: 3%;font-size: 4em;">关于吐槽</p>
    <p style="position: absolute;top: 11%;font-size: 2.5em;color: #666666;padding: 2%;">亲爱的用户您好，欢迎您前来吐槽，我们将<wr/>会及时处理您反馈的信息O(∩_∩)O~~</p>
    <form action="" method="post">
        <input placeholder="开始吐槽" class="block1" name="content" />
        <input class="block2" type="submit" name="submit" ></input>
    </form>

<?php
    date_default_timezone_set("Etc/GMT-8");
    if(isset($_POST['submit'])) {
        $content = $_POST['content'];
        $time = date("y-m-d H:i:s");
        require_once 'MysqlConnect.php';
        $connID = Connect();
        $arrayDataValue = array("ROW_ID" => 'UUID()',
            "Content" => "'$content'",
            "FeedbackDate" => "'$time'");
        $connID->insert('UserRetroaction', $arrayDataValue);
        echo "<script>alert('提交成功!'); history.go(-1)</script>";
    }
?>

</body>
</html>