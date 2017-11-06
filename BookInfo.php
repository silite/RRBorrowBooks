<?php
//   获取API返回的数据   以及存入API返回的图片
    //  图片抓取
    function GetImage($url,$judge,$filename){
    //      选择相对路径作为抓取图片路径
        $root_dir = __DIR__.'/../Media/BookPic/';
        $temp = explode('/',$url);
        if($judge == '1') $filename = $root_dir.'M_'.$filename.'.jpg';
        if($judge == '2') $filename = $root_dir.'L_'.$filename.'.jpg';
        chdir($root_dir);
        $ext = strrchr($url,'.');
        if($ext != '.jpg')
            return 0;
        file_put_contents($filename , file_get_contents($url));
    }

    //    上个页面的     $ISBN = $_POST['my'];
    function GetBookInfo($ISBN){
        $key = "b2bffac7b85cb7829475a39fcbb169ab";
        $url = "http://feedback.api.juhe.cn/ISBN?sub=" . $ISBN . "&key=" . $key;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        //curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($curl);

        $temp = json_decode($data, true);
        return $temp;
    }
?>
