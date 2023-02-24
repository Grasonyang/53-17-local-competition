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
    <title>Document</title>
</head>
<style>
    .dp{
        height:70px;
        width: 280px;
        border:1px solid black;
        display:flex;
    }
</style>
<body>
    <h1>咖啡商品展示系統</h1>
    <form action="call_mrg.php?call=0" method="post" onsubmit="return code_sort()">
        <span>帳號</span><input type="text" name="upl_act" class="upl upl_act"><br>
        <span>密碼</span><input type="text" name="upl_pwd" class="upl upl_pwd"><br>
        <span>驗證碼</span>
        <div class="dp"></div>
        <div class="dp"></div>
        <input type="hidden" name="code" id="code"><input type="hidden" name="code_sorted" id="code_sorted">
        <button type="button" id="howsort" onclick="sort()">由小到大排列</button>
        <button type="button" onclick="code();">重新產生</button><br>
        <button type="button" onclick="$('.upl').val(''),code();">清除</button>
        <input type="submit" value="登入">
    </form>
</body>
<script>
    let call="";
    $(".dp").sortable({
        connectWith:".dp",
    });
    code();
    function code_sort(){
        // console.log($(".dp:eq(1)").children());
        // return false;
        if($(".dp:eq(1)").children().length==4){
            let codee="";   
            for(let i=0;i<4;i++){
                codee+=$(".dp:eq(1)").children()[i].id;
            }
            $("#code_sorted").val(codee);
            return true;
        }else{
            alert("請完整填寫驗證碼");
            return false;
        }
    }
    function code(){
        $.post({
            async:false,
            url:"code.php",
            success:function(e){
                call=e;
                $(".code_img").remove();
                for(let i=0;i<call.length;i++){
                    $(".dp:eq(0)").append(`
                        <div id="${e[i]}" class="code_img"><img style="height:70px;width:70px;" src="code_img.php?call=${e[i]}"></div>
                    `);
                }
                sort();
                sort();
            },
        });
    }
    function sort(){
        if($("#howsort").text()=="由小到大排列"){
            $("#howsort").text("由大到小排列");
            $("#code").val(call.split("").sort().join(""));
        }else{
            $("#howsort").text("由小到大排列");
            $("#code").val(call.split("").sort().reverse().join(""));
        }
    }
</script>
</html>