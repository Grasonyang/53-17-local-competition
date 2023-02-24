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
    <link rel="stylesheet" href="type.css">
    <title>Document</title>
</head>
<style>
    .actbut{
        display:flex;
    }
</style>
<body>
    <button type="button" onclick="location.href='call_mrg.php?call=0'">登出</button>
    <!-- <button type="button" onclick="location.href='users_mrg.php'">會員管理</button>
    <button type="button" onclick="alltypedata(),$('.place:eq(0)').dialog('open')">上架商品</button> -->
    <button type="button" onclick="$('.ser').dialog('open')">查尋</button>
    <div class="place place1">
        <div class="actbut">
        <button type="button" onclick="$('.place').dialog('close'),$('.place1').dialog('open')">選擇版型</button>
        <button type="button" onclick="$('.place').dialog('close'),$('.place2').dialog('open')">填寫資料</button>
        <button type="button" onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open')">預覽</button>
        <button type="button" onclick="send(1)" class="firmsend">確定送出</button><br>
        </div>
        <button type="button" onclick="$('.testt').dialog('open')">新增版型</button>

    </div>
    <div class="place place2">
        <div class="actbut">
        <button type="button" onclick="$('.place').dialog('close'),$('.place1').dialog('open')">選擇版型</button>
        <button type="button" onclick="$('.place').dialog('close'),$('.place2').dialog('open')">填寫資料</button>
        <button type="button" onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open')">預覽</button>
        <button type="button" onclick="send(1)" class="firmsend">確定送出</button><br>
        </div>
        <div>
            圖片:   <input type="file" name="" id="new_img" accept="image/png"><br>
            商品名稱:   <input type="text" name="" id="new_name"><br>
            商品簡介:   <input type="text" name="" id="new_intro"><br>
            費用:   <input type="text" name="" id="new_fee"><br>
            相關連結:   <input type="text" name="" id="new_link"><br>
        </div>
    </div>
    <div class="place place3">
        <div class="actbut">
        <button type="button" onclick="$('.place').dialog('close'),$('.place1').dialog('open')">選擇版型</button>
        <button type="button" onclick="$('.place').dialog('close'),$('.place2').dialog('open')">填寫資料</button>
        <button type="button" onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open')">預覽</button>
        <button type="button" onclick="send(1)" class="firmsend">確定送出</button><br>
        </div>
        <div class="look">
        </div>
    </div>
    <div class="testt">
        <div class="test">
            <div class="rows">
                <div class="type_img">圖片</div>
                <div class="type_link">相關連結</div>
            </div>
            <div class="rows">
                <div class="type_name">商品名稱</div>
                <div class="type_intro">商品簡介</div>
                <div class="type_date">發布日期</div>
                <div class="type_fee">費用</div>
            </div>
        </div>
        <button type="button" onclick="newtype()">送出</button>
    </div>
    <div class="ser">
        關鍵字: <input type="text" name="" id="fi_kw"><br>
        價格: <input type="number" name="" id="fi_Lp">~<input type="number" name="" id="fi_Hp"><br>
        <button type="button" onclick="findkw()">搜尋</button>
    </div>
    <div class="allshopdata"></div>
</body>
<script>
    let typehtml="";
    let img="";
    let name="";
    let intro="";
    let fee="";
    let link="";
    let id="";
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".place1").dialog({
        title:"選擇版型",
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".place2").dialog({
        title:"填寫資料",
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".place3").dialog({
        title:"預覽",
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".testt").dialog({
        title:"新增版型",
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".ser").dialog({
        title:"搜尋",
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".test").sortable();
    $(".test .rows").sortable();
    $(document).on('click',".row",function(){
        typehtml=$(this)[0].innerHTML;
    });
    $("#new_img").on('change',function(){
        img=this.files[0].name;
    });
    $("#new_name").on('change',function(){
        name=$(this).val();
    });
    $("#new_intro").on('change',function(){
        intro=$(this).val();console.log(intro);
    });
    $("#new_fee").on('change',function(){
        fee=$(this).val();
    });
    $("#new_link").on('change',function(){
        link=$(this).val();
    });
    $(document).on('click',".ui-icon-closethick",function(){
        closee();
    });
    alltypedata();
    findkw();
    function edt(text){
        $(".firmsend").remove();
        $(".firmedt").remove();
        $(".actbut").append(`
        <button type="button" onclick="send(2)" class="firmedt">修改</button><br>
        `);
        typehtml=$(".row"+text).data('type');
        img=$(".row"+text).data('img');
        name=$(".row"+text).data('name');
        intro=$(".row"+text).data('intro');
        fee=$(".row"+text).data('fee');
        link=$(".row"+text).data('link');
        id=$(".row"+text).data('id');
        $("#new_name").val(name);
        $("#new_intro").val(intro);
        $("#new_fee").val(fee);
        $("#new_link").val(link);
        $(".place1").dialog('open');
    }
    function findkw(){
        $.post({
            async:false,
            url:"call_mrg.php?call=6",
            data:{
                kw:$("#fi_kw").val(),
                lp:$("#fi_Lp").val(),
                hp:$("#fi_Hp").val(),
            },
            success:function(e){
                // console.log(e)
                $(".allshopdata .row").remove();
                $(".ofofj").remove();
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".allshopdata").append(`
                        <div class="row row${i}">
                            ${arr['ihtml']}
                            
                        </div>
                    `);
                    $(".row"+i+" .rows .type_img").text("");
                    $(".row"+i+" .rows .type_img").append(`
                        <img src="cript/${arr['img']}">
                    `);
                    $(".row"+i+" .rows .type_name").append(`
                        ${arr['name']}
                    `);
                    $(".row"+i+" .rows .type_intro").append(`
                        ${arr['intro']}
                    `);
                    $(".row"+i+" .rows .type_fee").append(`
                        ${arr['fee']}
                    `);
                    $(".row"+i+" .rows .type_link").append(`
                        ${arr['link']}
                    `);
                    $(".row"+i+" .rows .type_date").append(`
                        ${arr['time']}
                    `);
                    $(".row"+i).data('id',arr['id']);
                    $(".row"+i).data('type',arr['ihtml']);
                    $(".row"+i).data('img',arr['img']);
                    $(".row"+i).data('name',arr['name']);
                    $(".row"+i).data('intro',arr['intro']);
                    $(".row"+i).data('fee',arr['fee']);
                    $(".row"+i).data('link',arr['link']);
                    // console.log($(".row"+i).data('name'));
                }
            },
        });
    }
    function closee(){
        $(".place").dialog("close");
        $(".firmsend").remove();
        $(".firmedt").remove();
        $(".actbut").append(`
        <button type="button" onclick="send(1)" class="firmsend">確定送出</button><br>
        `);
        id="";
        typehtml="";
        img="";
        name="";
        intro="";
        fee="";
        link="";
        $(".look .rows").remove();
        $("#new_img").val("");
        $("#new_name").val("");
        $("#new_intro").val("");
        $("#new_fee").val("");
        $("#new_link").val("");
    }
    function send(text){
        if(text==1){
            if(typehtml=="" || 
            img=="" || 
            name=="" || 
            intro=="" || 
            fee=="" || 
            link==""){
                alert("請填寫完整");
            }else{
               if(confirm('確定送出?')){
                    $.post({
                        async:false,
                        url:"call_mrg.php?call=5",
                        data:{
                            ihtml:typehtml,
                            img:img,
                            name:name,
                            intro:intro,
                            fee:fee,
                            link:link,
                        },
                        success:function(e){
                            closee();
                            findkw();
                        },
                    });
                } 
            }
            
        }
        if(text==2){
            if(typehtml=="" || 
            img=="" || 
            name=="" || 
            intro=="" || 
            fee=="" || 
            link==""){
                alert("請填寫完整");
            }else{
               if(confirm('確定送出?')){
                    $.post({
                        async:false,
                        url:"call_mrg.php?call=7",
                        data:{
                            id:id,
                            ihtml:typehtml,
                            img:img,
                            name:name,
                            intro:intro,
                            fee:fee,
                            link:link,
                        },
                        success:function(e){
                            closee();
                            findkw();
                            // alltypedata();
                        },
                    });
                } 
            }
            
        }
    }
    function look(){
        $(".look .rows").remove();
        $(".look").append(`${typehtml}`);
        $(".look .rows .type_img").text("");
        $(".look .rows .type_img").append(`
            <img src="cript/${img}">
        `);
        $(".look .rows .type_name").append(`
            ${name}
        `);
        $(".look .rows .type_intro").append(`
            ${intro}
        `);
        $(".look .rows .type_fee").append(`
            ${fee}
        `);
        $(".look .rows .type_link").append(`
            ${link}
        `);
    }
    function alltypedata(){
        $.post({
            async:false,
            url:"call_mrg.php?call=3",
            success:function(e){
                // console.log(e)
                $(".aaaaaaaa").remove();
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    if(arr['3']=='A'){
                        typehtml=arr['ihtml'];
                    }
                    $(".place1").append(`
                        <div class="row aaaaaaaa">
                            ${arr['ihtml']}
                        </div>
                    `);
                }
            },
        });
    }
    function newtype(){
        $.post({
            async:false,
            url:"call_mrg.php?call=4",
            data:{
                itext:$(".test")[0].innerText,
                ihtml:$(".test")[0].innerHTML,
            },
            success:function(e){
                alltypedata();
                $(".testt").dialog("close");
            },
        });
    }
</script>
</html>