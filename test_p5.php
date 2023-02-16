<?php
include 'connect.php';
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
    img{
        width:170px;
        height:160px;
    }
    .rows{
        display:flex;
        width:344px;
        height:208px;
        border:1px solid black;
    }
    .type_name{
        width:170px;
        height:40px;
        border:1px solid black;
        overflow:auto;
    }
    .type_img{
        width:170px;
        height:160px;
        border:1px solid black;
        border-bottom-width: 5px;
    }
    .type_money{
        width:170px;
        height:40px;
        border:1px solid black;
        overflow:auto;
    }
    .type_intro{
        width:170px;
        height:80px;
        border:1px solid black;
        overflow:auto;
    }
    .type_date{
        width:170px;
        height:40px;
        border:1px solid black;
        overflow:auto;
    }
    .type_link{
        width:170px;
        height:40px;
        border:1px solid black;
        overflow:auto;
    }
</style>
<body>
    <button onclick="location.href='on_shop.php'">上架商品</button>
    <button onclick='$(".place:eq(0)").dialog("open")'>查詢</button>
    <div class="place">
        <input type="text" placeholder="關鍵字" id="kw"><br>
        <input type="number" id="LP" placeholder="價格">~<input type="number" id="HP" placeholder="價格"><br>
        <button onclick='code()'>查詢</button>
    </div>
    <div class="allt"></div>
</body>
<script>

    code();
    $(".place").dialog({
        autoOpen:false,
        width:500,
    });
    function code(){
        let hp=0;hp+=$("#HP").val();
        let lp=0;lp+=$("#LP").val();
        if(hp<lp){
            let temp=hp;
            hp=lp;
            lp=temp;
        }
        console.log(lp,hp)
        $.post({
            async:false,
            url:"user_mrg_action.php?call=10",
            data:{
                kw:$("#kw").val(),
                hp:hp,
                lp:lp,
            },
            success:function(e){
                $(".rows").remove();

                console.log(e);
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".allt").append(`
                        <div class="rows rows${i}"></div>
                    `);
                    $(".rows"+i).append(arr['type']);
                    $(".rows"+i+" .row .type_date").append(`:${arr['date']}`);
                }
            },
        });
    }
</script>
</html>