<?php
session_start();
$db=mysqli_connect("localhost","admin","1234","53_2");
$time=date("h:i:s Y/m/d");
if(!isset($_SESSION['wt'])){
    $_SESSION['wt']=0;
}
if(!isset($_SESSION['user'])){
    $_SESSION['user']="";
}
function wrong($text){
    $_SESSION['wt']++;
    if($_SESSION['wt']>=3){
        $_SESSION['wt']=0;
        echo "
            <script>
                alert('$text');
                location.href='wrong.php';
            </script>
        ";
    }else{
        echo "
            <script>
                alert('$text');
                location.href='index.php';
            </script>
        ";
    }
}
