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
    <button onclick="location.href='test_p5.php'">返回</button>
    <div>
        <button onclick="$('.areas').hide(),$('.areas:eq(0)').show()">選擇版型</button>
        <button onclick="$('.areas').hide(),$('.areas:eq(1)').show()">填寫資料</button>
        <button onclick="$('.areas').hide(),$('.areas:eq(2)').show()">預覽</button>
        <button onclick="data_send()">確定送出</button>
        <div class="areas">
            <input type="hidden" id="type" value="0">
            <button onclick="$('.place:eq(0)').dialog('open')">新增版型</button>
            <div class="rows A1">
                <div class="row">
                    <div class="type_name">商品名稱</div>
                    <div class="type_img">圖片</div>
                </div>
                <div  class="row">
                    <div class="type_money">費用</div>
                    <div class="type_intro">商品簡介</div>
                    <div class="type_date">發布日期</div>
                    <div class="type_link">相關連結</div>
                </div>
            </div><br>
            <div class="rows A2">
                <div class="row">
                    <div class="type_img">圖片</div>
                    <div class="type_link">相關連結</div>
                </div>
                <div  class="row">
                    <div class="type_name">商品名稱</div>
                    <div class="type_intro">商品簡介</div>
                    <div class="type_date">發布日期</div>
                    <div class="type_money">費用</div>
                </div>
            </div>
        </div>
        <div class="areas">
            圖片:<input type="file" id="upl_image" accept="image/png,image/jpeg"><br>
            商品名稱:<input type="text" id="upl_name"><br>
            商品簡介:<input type="text" id="upl_intro"><br>
            相關連結:<input type="text" id="upl_link"><br>
            費用:<input type="text" id="upl_money"><br>
        </div>
        <div class="areas">
            
        </div>
    </div>
    <div class="place">
        <div class="rows test">
            <div class="row">
                <div class="type_name">商品名稱</div>
                <div class="type_img">圖片</div>
            </div>
            <div  class="row">
                <div class="type_money">費用</div>
                <div class="type_intro">商品簡介</div>
                <div class="type_date">發布日期</div>
                <div class="type_link">相關連結</div>
            </div>
        </div>
        <button onclick="typesend('test')">送出</button>
    </div>
</body>
<script>
    let upl_image="未填寫";
    let upl_name="未填寫";
    let upl_intro="未填寫";
    let upl_link="未填寫";
    let upl_money="未填寫";
    $(document).ready(function(){
        typecode();
        $(".areas").hide();
        $(".areas:eq(0)").show();
        $(".test .row").sortable().disableSelection();
        // typesend('A1');
        // typesend('A2');
        $(".place").dialog({
            autoOpen:false,
            height:500,
            width:380,
        });
        $("#upl_image").on('change',function(){
            upl_image=this.files[0].name;
            datalook();
        });
        $("#upl_name").on('change',function(){
            upl_name=this.value;
            datalook();
        });
        $("#upl_intro").on('change',function(){
            upl_intro=this.value;
            datalook();
        });
        $("#upl_link").on('change',function(){
            upl_link=this.value;
            datalook();
        });
        $("#upl_money").on('change',function(){
            upl_money=this.value;
            datalook();
        });
        $(".rows").on('click',function(){
            let thiss=$(this)[0].innerHTML;
            $(".lookk").remove();
            $(".areas:eq(2)").append(`
                <div class="rows lookk"></div>
            `);
            $(".lookk").append(thiss);
            datalook();
        });
    });
    function data_send(){
        console.log($(".lookk")[0].innerHTML);
        if(upl_image!="未填寫" || 
        upl_name!="未填寫" || 
        upl_intro!="未填寫" || 
        upl_link!="未填寫" || 
        upl_money!="未填寫"){
            $.post({
                async:false,
                url:"user_mrg_action.php?call=9",
                data:{
                    image:upl_image,
                    name:upl_name,
                    intro:upl_intro,
                    link:upl_link,
                    money:upl_money,
                    ihtml:$(".lookk")[0].innerHTML,
                },
                success:function(e){
                    alert('新增成功')
                },
            });
        }else{
            alert('請填寫');
        }
    }
    function datalook(){
        $(".lookk .row .type_img").text("");
        $(".lookk .row .type_name").text("");
        $(".lookk .row .type_intro").text("");
        $(".lookk .row .type_link").text("");
        $(".lookk .row .type_money").text("");
        $(".lookk .row .type_img").append(`<img src='${upl_image}' alt="未上傳">`);
        $(".lookk .row .type_name").append(`商品名稱:${upl_name}`);
        $(".lookk .row .type_intro").append(`商品簡介:${upl_intro}`);
        $(".lookk .row .type_link").append(`相關連結:${upl_link}`);
        $(".lookk .row .type_money").append(`費用:${upl_money}`);
    }
    function typesend(text){
        $.post({
            async:false,
            url:"user_mrg_action.php?call=7",
            data:{
                itext:$("."+text)[0].innerText,
                ihtml:$("."+text)[0].innerHTML,
            },
            success:function(e){
                typecode();
            },
        });
    }
    function typecode(){
        $.post({
            async:false,
            url:"user_mrg_action.php?call=8",
            success:function(e){
                $(".elsetype").remove();
                // console.log(e);
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".areas:eq(0)").append(`
                        <br><div class="rows elsetype elsetype${i}"></div>
                    `);
                    $(".elsetype"+i).append(arr['ihtml']);
                    console.log(arr['ihtml'])
                }
            },
        });
    }
</script>
</html>