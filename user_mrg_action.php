<?php
    include 'connect.php';
    if(!empty($_POST)){
        if($_GET['call']==1){
            mysqli_query($db,"INSERT INTO `user`(`user`, `name`, `password`, `rank`) VALUES 
            ('$_POST[id]','$_POST[name]','$_POST[pwd]','$_POST[rk]')");
            header('Location:user_mrg.php');
        }else if($_GET['call']==2){
            if($_POST['kew']!=''){
                $arr=mysqli_query($db,"SELECT * FROM `user` WHERE `$_POST[whitem]` LIKE '$_POST[kew]' ORDER BY `user`.`$_POST[whitem]` $_POST[whsort]");
            }else{
                $arr=mysqli_query($db,"SELECT * FROM `user` ORDER BY `user`.`$_POST[whitem]` $_POST[whsort]");
            }
            while($row=mysqli_fetch_array($arr)){
                echo json_encode($row)."(+)";
            }
        }else if($_GET['call']==3){
            mysqli_query($db,"DELETE FROM `user` WHERE `id` LIKE '$_POST[id]'");
        }else if($_GET['call']==4){
            mysqli_query($db,"UPDATE `user` SET `user`='$_POST[id]',`name`='$_POST[name]',`password`='$_POST[pwd]',`rank`='$_POST[rk]' WHERE `id` LIKE '$_POST[f2trueid]'");
            header('Location:user_mrg.php');
        }
    }
    if($_GET['call']==5){
        mysqli_query($db,"INSERT INTO `user_web`(`user`, `action`, `time`, `sf`) VALUES ('$_GET[id]','登出','$time','成功')");
        header('Location:index.php');
    }
    if($_GET['call']==6){
        $row=mysqli_query($db,"SELECT * FROM `user_web`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
?>