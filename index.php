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
    .codeimg{
        height: 70px;
        width: 70px;
    }
</style>
<body>
    <div>
        <h1></h1>
        <form action="varify.php?call=1" method="post" onsubmit="return codecount()">
            <div style="display:flex">
                <span style="width:120px;">帳號</span>
                <input type="text" name="id" id="id">
            </div>
            <div style="display:flex">
                <span style="width:120px;">密碼</span>
                <input type="text" name="pwd" id="pwd">
            </div>
            <div style="display:flex">
                <span style="width:120px;">驗證碼</span>
                <div style="display:flex;height:70px;width:280px;background-color:black" id="dp1" class="dragplace">
                    
                </div>
                <button type="button" onclick="code_apr()">重新產生</button>
            </div>
            <div style="display:flex">
                <button type="button" style="width:120px;" class="whtype" onclick="click_whtype()">由小到大</button>
                <input type="hidden" name="whtype" class="whtype">
                <div style="display:flex;height:70px;width:280px;background-color:black" id="dp2" class="dragplace">
                    
                </div>
                <input type="hidden" name="order" class="order">
            </div>
            <input type="hidden" name="theordercode" class="theordercode">
            <button type="button" onclick="code_apr(),$('#id').val(''),$('#pwd').val('');">清除</button>
            <button type="submit">送出</button>
        </form>
    </div>
</body>
<script>
    let randcode="";
    code_apr();
    $("#dp1,#dp2").sortable({
        connectWith:".dragplace",
    }).disableSelection;
    function codecount(){
        if($("#dp2").children().length==4){
            let orderr="";
            for(let i=0;i<4;i++){
                orderr+=$(".codeimg:eq("+i+")").attr('data-value');
            }
            $(".order").val(orderr);
            return true;
        }else{
            alert('請完整回答驗證碼');
            return false;
        }
    }
    function click_whtype(){
        if($(".whtype")[0].innerText=="由小到大"){
            $(".theordercode").val(randcode.split("").sort().reverse().join(""));
            $(".whtype")[0].innerText="由大到小";
            $(".whtype")[1].value="1";
        }else{
            $(".theordercode").val(randcode.split("").sort().join(""));
            $(".whtype")[1].value="0";
            $(".whtype")[0].innerText="由小到大";
        }
    }
    function code_apr(){
        randcode="";
        $(".codeimg").remove();
        let ss="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        for(let i=0;i<4;i++){
            randcode+=ss[Math.floor(Math.random()*ss.length)];
            $("#dp1").append(`
                <img src="code.php?call=${randcode[i]}" data-value="${randcode[i]}" alt="A${i}" class="codeimg">
            `);
        }
        click_whtype();
        click_whtype();
        
    };
</script>
</html>