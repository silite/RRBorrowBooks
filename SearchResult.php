<?php
    if(isset($_GET["searchInput"])) {
        $pending_search_name = $_GET["searchInput"];
        $_SESSION['book_name'] = $pending_search_name;
    }
    else
        $pending_search_name = $_SESSION['book_name'];
    $url = "https://api.douban.com/v2/book/search?q=".$pending_search_name."&start=".$_SESSION['start'];
    $result = json_decode(file_get_contents($url),true);
    if(count($result['books']) < 20)
        $name_len = count($result['books']);
    else
        $name_len = 20;
    $_SESSION['start'] += 20;
    if(empty($result['books']))
        $stop = 1;
    else
        $stop = 0;
?>
