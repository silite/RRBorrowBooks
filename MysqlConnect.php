<?php
    function Connect(){
        require_once '../Class/MyPDOConnect.php';
        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPasswd = 'silite';
        $dbName = 'Rong';
        $dbCharset = 'utf8';
        $connID = MyPDOConnect::getInstance($dbHost,$dbUser,$dbPasswd,$dbName,$dbCharset);
        return $connID;
    }
?>