<?php
//   为用户点击书籍具体信息时查询ISBN的页面  目的提供API查询
		function GetISBN($url)
        {
//            $url = "https://book.douban.com/subject/" . "$isbn" . "/";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            //未设置UserAgent
            //curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            $data = curl_exec($curl);

            $book_ISBN = "/.span class=\"pl\">ISBN:.\/span> (.*?).br\/>/";

            preg_match_all($book_ISBN, $data, $matches_ISBN);
            $ISBN = $matches_ISBN[1][0];
            //调试输出
           return $ISBN;
        }

?>