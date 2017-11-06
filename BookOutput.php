<?php
if(!isset($s_flag))
        session_start();
    //      作用是不是从第二个网页进来的不添加访问次数
    $_SESSION['judge'] = true;

        require 'SearchResult.php';

    $discount = 0.75;

    $element0 = <<<'tar'
        <a class="oneBook" href="
tar;
// 这里有超链接   $matches_name[1][$i]
    $element1 = <<<'tar'
    ">           
tar;
//    这里有 $img
    $element2 = <<<'tar'
        <h3>
tar;
//    这里有title
    $element3 = <<<'tar'
            </h3>
            <p>
tar;
//     这里有押金
    $element4 = <<<'tar'
        </p></a>
tar;

    for($i = 0;$i<$name_len;$i++) {
        if (!empty($result['books'][$i]['price'])) {
            $pay = round($result['books'][$i]['price'] * $discount);
        } else
            $pay = '待定';
        $img = "<img src='".$result['books'][$i]['images']['large']."'>";
        $title = $result['books'][$i]['title'];
        echo $element0 . "TheThird.php"."?ISBN=".$result['books'][$i]['isbn13']. $element1 . $img . $element2 . $title . $element3 . '押金:' . $pay . $element4;
    }

?>
<input class="judge_" type="hidden" value="<?php echo $stop;  ?>">
