<?php


function StringFilter($str){
    $str = preg_replace_callback('/./u' , 
                                 function (array $match) {
                                    return strlen($match[0]) >= 4 ? '' : $match[0];
                                 } ,
                                 $str);

     return $str;
}
