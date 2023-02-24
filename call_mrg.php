<?php
    include 'connect.php';
    if(!empty($_POST)){
        if($_GET['call']==0){
            $row=mysqli_query($db,"SELECT * FROM `user` WHERE `account` LIKE '$_POST[upl_act]'");
            if(mysqli_num_rows($row)){
                $row1=mysqli_query($db,"SELECT * FROM `user` WHERE `account` LIKE '$_POST[upl_act]' AND `password` LIKE '$_POST[upl_pwd]'");
                if(mysqli_num_rows($row1)){
                    if($_POST['code_sorted']==$_POST['code']){
                        $arr=mysqli_fetch_array($row1);
                        $_SESSION['wt']=0;
                        $_SESSION['user']=$_POST['upl_act'];
                        mysqli_query($db,"INSERT INTO `logact`(`account`, `action`, `time`, `TORF`) VALUES ('$_POST[upl_act]','登入','$time','成功')");
                        header("Location:sec_vrc.php?rk=".$arr['rank']);
                    }else{
                        mysqli_query($db,"INSERT INTO `logact`(`account`, `action`, `time`, `TORF`) VALUES ('$_POST[upl_act]','登入','$time','失敗')");
                        wrong("驗證碼錯誤");
                    }
                }else{
                    mysqli_query($db,"INSERT INTO `logact`(`account`, `action`, `time`, `TORF`) VALUES ('$_POST[upl_act]','登入','$time','失敗')");
                    wrong("密碼錯誤");
                }
            }else{
                mysqli_query($db,"INSERT INTO `logact`(`account`, `action`, `time`, `TORF`) VALUES ('$_POST[upl_act]','登入','$time','失敗')");
                wrong("帳號錯誤");
            }
        }
        if($_GET['call']==1){
            mysqli_query($db,"INSERT INTO `user`(`account`, `password`, `name`, `rank`) VALUES 
            ('$_POST[new_act]','$_POST[new_pwd]','$_POST[new_name]','$_POST[new_rank]')");
            header("Location:users_mrg.php");
        }
        if($_GET['call']==2){
            $row=mysqli_query($db,"SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`account` LIKE '%$_POST[kw]%') || (`password` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`rank` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[wh]` $_POST[ht]");
            while($arr=mysqli_fetch_array($row)){
                echo json_encode($arr)."(+)";
            }
        }
        if($_GET['call']==3){
            mysqli_query($db,"UPDATE `user` SET `account`='$_POST[edt_act]',`password`='$_POST[edt_pwd]',`name`='$_POST[edt_name]',`rank`='$_POST[edt_rank]' WHERE `id`LIKE'$_POST[edt_id]'");
            header("Location:users_mrg.php");
        }
        if($_GET['call']==4){
            $row=mysqli_query($db,"SELECT * FROM `type` WHERE `itext` LIKE '$_POST[itext]'");
            if(!mysqli_num_rows($row)){
                mysqli_query($db,"INSERT INTO `type`(`itext`, `ihtml`, `NEWOLD`) VALUES 
                ('$_POST[itext]','$_POST[ihtml]','N')");
            }
        }
        if($_GET['call']==5){
            mysqli_query($db,"INSERT INTO `shopdata`(`ihtml`, `img`, `name`, `intro`, `fee`, `link`, `time`) VALUES 
            ('$_POST[ihtml]','$_POST[img]','$_POST[name]','$_POST[intro]','$_POST[fee]','$_POST[link]','$time')");
        }
        if($_GET['call']==6){
            $row=mysqli_query($db,"SELECT * FROM `shopdata` WHERE ((`name` LIKE '%$_POST[kw]%') || (`intro` LIKE '%$_POST[kw]%') || (`fee` LIKE '%$_POST[kw]%') || (`link` LIKE '%$_POST[kw]%') || (`time` LIKE '%$_POST[kw]%'))");
            if($_POST['lp']=="" || $_POST['hp']==""){
                while($arr=mysqli_fetch_array($row)){
                    echo json_encode($arr)."(+)";
                }
            }else{
                if($_POST['lp']>=$_POST['hp']){
                    $temp=$_POST['lp'];
                    $_POST['lp']=$_POST['hp'];
                    $_POST['hp']=$temp;
                }
                while($arr=mysqli_fetch_array($row)){
                    if($arr['fee']>=$_POST['lp'] && $arr['fee']<=$_POST['hp']){
                        echo json_encode($arr)."(+)";
                    }
                }
            }
            
        }
        if($_GET['call']==7){
            mysqli_query($db,"UPDATE `shopdata` SET `ihtml`='$_POST[ihtml]',`img`='$_POST[img]',`name`='$_POST[name]',`intro`='$_POST[intro]',`fee`='$_POST[fee]',`link`='$_POST[link]'WHERE `id`LIKE'$_POST[id]'");
        }
    }else{
        if($_GET['call']==0){
            mysqli_query($db,"INSERT INTO `logact`(`account`, `action`, `time`, `TORF`) VALUES ('$_SESSION[user]','登出','$time','')");
            $_SESSION['user']="";
            header("Location:index.php");
        }
        if($_GET['call']==1){
            mysqli_query($db,"DELETE FROM `user` WHERE `id` LIKE '$_GET[id]'");
            header("Location:users_mrg.php");
        }
        if($_GET['call']==2){
            $row=mysqli_query($db,"SELECT * FROM `logact`");
            while($arr=mysqli_fetch_array($row)){
                echo json_encode($arr)."(+)";
            }
        }
        if($_GET['call']==3){
            $row=mysqli_query($db,"SELECT * FROM `type`");
            while($arr=mysqli_fetch_array($row)){
                echo json_encode($arr)."(+)";
            }
        }
    }