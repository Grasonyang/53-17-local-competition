<?php
    session_start();
    $db=mysqli_connect("localhost","admin","1234","53_1");
    $time=date("h:i:s Y/m/d");
    function coderand(){
        $s="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        return $s[rand(0,strlen($s)-1)].$s[rand(0,strlen($s)-1)].$s[rand(0,strlen($s)-1)].$s[rand(0,strlen($s)-1)];
    }
?>