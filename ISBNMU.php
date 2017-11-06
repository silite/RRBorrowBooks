<?php
//  为将API返回结果存入库    返回ROW_ID为以后提供图片路径有关   图片名为BookInfo的ROW_ID
    $connID = Connect();
    $arrayDataValue = array("ROW_ID"=>"UUID()",
                            "LISBN"=>"'$temp_LISBN'",
                            "SISBN"=>"'$temp_SISBN'",
                            "Title"=>"'$temp_Title'",
                            "SubTitle"=>"'$temp_SubTitle'",
                            "Author"=>"'$temp_Author'",
                            "Translator"=>"'$temp_Translator'",
                            "Summary"=>"'$temp_Summary'",
                            "Price"=>"'$temp_Price'",
                            "Publisher"=>"'$temp_Publisher'",
                            "PublishDate"=>"'$temp_PublishDate'",
                            "Pages"=>"'$temp_Pages'",
                            "Binding"=>"'$temp_Binding'",
                            "LevelNum"=>"'$temp_LevelNum'");
        $connID->insert('BookInfo',$arrayDataValue);
    //      这里为了获取ROW_ID   目的是与图片名称绑定  读取数据时有用
        $query = "SELECT ROW_ID FROM BookInfo WHERE LISBN IN ('$ISBN');";
        $temp = $connID->query($query,'Row');
        $ROW_ID = $temp["ROW_ID"];
?>
