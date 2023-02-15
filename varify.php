<?php
    include 'connect.php';
    if(!isset($_SESSION['wrongtime'])){
        $_SESSION['wrongtime']=0;
    }
    if(!empty($_POST)){
        if($_GET['call']==1){
            $arr=mysqli_query($db,"SELECT * FROM `user` WHERE `user` LIKE '$_POST[id]'");
            if(mysqli_num_rows($arr)){
                $arr1=mysqli_query($db,"SELECT * FROM `user` WHERE `user` LIKE '$_POST[id]' AND `password` LIKE '$_POST[pwd]'");
                if(mysqli_num_rows($arr1)){
                    if($_POST['order']===$_POST['theordercode']){
                        mysqli_query($db,"INSERT INTO `user_web`(`user`, `action`, `time`, `sf`) VALUES ('$_POST[id]','登入','$time','成功')");
                        // mysqli_query($db,"INSERT INTO `user_web`(`user`, `action`, `time`, `sf`) VALUES ('$_POST[id]','登出','$time','暫時')");
                        echo "
                            <script>
                                alert('OK');
                            </script>
                        ";
                        $row=mysqli_fetch_array($arr1);
                        $url='Location:ver2.php?id='.$row['id'].'&rank='.$row['rank'];
                        header($url);
                    }else{
                        mysqli_query($db,"INSERT INTO `user_web`(`user`, `action`, `time`, `sf`) VALUES ('$_POST[id]','登入','$time','失敗')");
                        $_SESSION['wrongtime']++;
                        if($_SESSION['wrongtime']==3){
                            $_SESSION['wrongtime']=0;
                            header('Location:wrong.php');
                        }
                        echo "
                            <script>
                                alert('驗證碼錯誤');
                                location.href='index.php';
                            </script>
                        ";
                    }
                }else{
                    mysqli_query($db,"INSERT INTO `user_web`(`user`, `action`, `time`, `sf`) VALUES ('$_POST[id]','登入','$time','失敗')");
                    $_SESSION['wrongtime']++;
                    if($_SESSION['wrongtime']==3){
                        $_SESSION['wrongtime']=0;
                        header('Location:wrong.php');
                    }
                    echo "
                        <script>
                            alert('密碼錯誤');
                            location.href='index.php';
                        </script>
                    ";
                }
            }else{
                mysqli_query($db,"INSERT INTO `user_web`(`user`, `action`, `time`, `sf`) VALUES ('$_POST[id]','登入','$time','失敗')");
                $_SESSION['wrongtime']++;
                if($_SESSION['wrongtime']==3){
                    $_SESSION['wrongtime']=0;
                    header('Location:wrong.php');
                }
                echo "
                    <script>
                        alert('帳號錯誤');
                        location.href='index.php';
                    </script>
                ";
            }
        }
    }

?>
