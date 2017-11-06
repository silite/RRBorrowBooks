<?php
    function hyperlink(){
        $hyperlink1 = 'S2.php';
        $cookie_name = 'renrenjieshu';
        date_default_timezone_set("Etc/GMT-8");
        if (!isset($_COOKIE["$cookie_name"])) {
            setcookie("$cookie_name",1,teme()+36*36);
            return $hyperlink1;
        } else {
//            setcookie("$cookie_name", date("y-m-d H:i:s",teme()+36*36));             //不设置expire   则cookies会永久有效
            return $hyperlink1;
        }
    }
?>
