<?php
    include 'connect.php';
    if(!isset($_SESSION['wrongtime'])){
        $_SESSION['wrongtime']=0;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.3.min.js"></script>
    <script src="jquery-ui.js"></script>
    <link rel="stylesheet" href="jquery-ui.css">
    <link rel="shortcut icon" href="#">
    <title>Document</title>
</head>
<style>
    .square{
        height:100px;
        width:100px;
        background-color:white;
        border:1px solid black;
        border-radius:5%;
    }
    .changecolor{
        height:100px;
        width:100px;
        background-color:red;
        border:1px solid black;
        border-radius:5%;
    }
</style>
<body>
<div style="display:flex">
        <div class='square'></div>
        <div class='square'></div>
    </div>
    <div style="display:flex">
        <div class='square'></div>
        <div class='square'></div>
    </div>
    <button onclick='countif()'>確定</button>
</body>
<script>
    let squares=document.querySelectorAll('.square');
    squares.forEach(square=>{
        square.addEventListener('click',function(e){
            this.classList.toggle('changecolor');
        });
    });
    function countif(){
        if(($(".square:eq(0)").css('background-color')=='rgb(255, 255, 255)' && $(".square:eq(1)").css('background-color')=='rgb(255, 255, 255)') || 
        ($(".square:eq(0)").css('background-color')=='rgb(255, 255, 255)' && $(".square:eq(2)").css('background-color')=='rgb(255, 255, 255)') || 
        ($(".square:eq(3)").css('background-color')=='rgb(255, 255, 255)' && $(".square:eq(1)").css('background-color')=='rgb(255, 255, 255)') ||
        ($(".square:eq(3)").css('background-color')=='rgb(255, 255, 255)' && $(".square:eq(2)").css('background-color')=='rgb(255, 255, 255)')){
            alert('ok');
            if(<?php echo $_GET['rank']; ?>=='3'){
                location.href='coffee_mrg.php?id=<?php echo $_GET['id']; ?>'
            }
        }else{
            alert('no');
        }
    }
</script>
</html>