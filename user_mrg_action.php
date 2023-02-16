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
        else if($_GET['call']==7){
            $itext=$_POST['itext'];
            $ihtml=$_POST['ihtml'];
            $itext1=str_replace(' ','',$itext);
            $row=mysqli_query($db,"SELECT * FROM `type` WHERE `itext` LIKE '$itext1'");
            if(mysqli_num_rows($row)==0){
                mysqli_query($db,"INSERT INTO `type`(`itext`, `ihtml`, `onw`) VALUES ('$itext1','$ihtml','n')");
                echo "版型已新增";
            }else{
                echo "版型已存在";
            }
        }
        else if($_GET['call']==9){
            mysqli_query($db,"INSERT INTO `items`(`img`, `name`, `intro`, `date`, `fee`, `link`, `type`) VALUES 
            ('$_POST[image]','$_POST[name]','$_POST[intro]','$time','$_POST[money]','$_POST[link]','$_POST[ihtml]')");
        }else if($_GET['call']==10){
            if($_POST['kw']==""){
                if($_POST['hp']==0){
                    $row=mysqli_query($db,"SELECT * FROM `items`");
                }else{
                    $row=mysqli_query($db,"SELECT * FROM `items` WHERE `fee`>$_POST[lp] AND `fee` < $_POST[hp]");
                }
            }else{
                if($_POST['hp']==0){
                    $row=mysqli_query($db,"SELECT * FROM `items` WHERE `name` LIKE '$_POST[kw]' || `intro` LIKE '$_POST[kw]' || `date` LIKE '$_POST[kw]' || `link` LIKE '$_POST[kw]'");
                }else{
                    $row=mysqli_query($db,"SELECT * FROM `items` WHERE (`name` LIKE '$_POST[kw]' || `intro` LIKE '$_POST[kw]' || `date` LIKE '$_POST[kw]' || `link` LIKE '$_POST[kw]') AND (`fee`>$_POST[lp] AND `fee` < $_POST[hp])");
                }
            }
            while($arr=mysqli_fetch_array($row)){
                echo json_encode($arr)."(+)";
            }
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
    if($_GET['call']==8){
        $row=mysqli_query($db,"SELECT * FROM `type` WHERE `onw` LIKE 'n'");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
?>