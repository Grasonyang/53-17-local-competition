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
</style>
<body>
    <span class="timer">60</span>
    <input type="text" placeholder="修改時間" id="edttime">
    <button onclick="$('.timer').text($('#edttime').val()),timer=$('#edttime').val()">修改</button>
    <br>
    <button type="button" onclick="$('.place:eq(0)').dialog('open')">新增使用者帳號</button>
    <button onclick="inout()">登入登出紀錄</button>
    <select name="sortwh" class="sortwh">
        <option value="id">使用者編號</option>
        <option value="account">帳號</option>
        <option value="name">姓名</option>
    </select>
    <select name="htsort" class="htsort">
        <option value="ASC">升冪</option>
        <option value="DESC">降冪</option>
    </select>
    <input type="text" placeholder="關鍵字" class="kw">
    <button type="button" onclick="getsers()">查詢</button>
    <div class="place">
        <form action="call_mrg.php?call=1" method="post"><br>
            帳號: <input type="text" name="new_act" class="new_act"><br>
            密碼: <input type="text" name="new_pwd" class="new_pwd"><br>
            姓名: <input type="text" name="new_name" class="new_name"><br>
            權限: <select name="new_rank" class="new_rank">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit" value="新增">
        </form>
    </div>
    <div class="place">
        <form action="call_mrg.php?call=3" method="post"><br>
            <input type="hidden" name="edt_id" class="edt_id"><br>
            帳號: <input type="text" name="edt_act" class="edt_act"><br>
            密碼: <input type="text" name="edt_pwd" class="edt_pwd"><br>
            姓名: <input type="text" name="edt_name" class="edt_name"><br>
            權限: <select name="edt_rank" class="edt_rank">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit" value="修改">
        </form>
    </div>
    <div class="place">
        <h1>是否繼續</h1>
        <button type="button" onclick="location.href='users_mrg.php'">是</button>
        <button type="button" onclick="location.href='call_mrg.php?call=0'">否</button>
        
    </div>
    <div>
        <table class="user_table" border="1">
            <tr>
                <td>使用者編號</td>
                <td>帳號</td>
                <td>密碼</td>
                <td>姓名</td>
                <td>權限</td>
                <td>刪除/修改</td>
            </tr>
        </table>
        <table class="act_table" border="1">

        </table>
    </div>
</body>
<script>
    let timer=60;
    let lastime=setInterval(() => {
        timer--;
        $(".timer").text(timer);
        if(timer<=0){
            timer=0;
            clearInterval(lastime);
            $(".place:eq(2)").dialog("open");
            setInterval(() => {
                location.href='call_mrg.php?call=0';
            }, 5000);
        }
    }, 1000);
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    getsers();
    function del(text){
        location.href="call_mrg.php?call=1&id="+text;
    }
    function edt(text){
        $(".place:eq(1)").dialog("open");
        $(".edt_id").val($(".tu"+text+":eq(0)").text());
        $(".edt_act").val($(".tu"+text+":eq(1)").text());
        $(".edt_pwd").val($(".tu"+text+":eq(2)").text());
        $(".edt_name").val($(".tu"+text+":eq(3)").text());
        $(".edt_rank").val($(".tu"+text+":eq(4)").text());
    }
    function inout(){
        $(".act_table").append(`
            <tr class="tarow">
                <td>帳號</td>
                <td>時間</td>
                <td>動作</td>
                <td>成功/失敗</td>
            </tr>
        `);
        $.post({
            async:false,
            url:"call_mrg.php?call=2",
            success:function(e){
                // console.log(e)
                let list=e.split("(+)");
                list.pop();
                $(".tarow").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".act_table").append(`
                        <tr class="tarow">
                            <td class="ta${i}">${arr['account']}</td>
                            <td class="ta${i}">${arr['time']}</td>
                            <td class="ta${i}">${arr['action']}</td>
                            <td class="ta${i}">${arr['TORF']}</td>
                        </tr>
                    `);
                }
            },
        });
    }
    function getsers(){
        $.post({
            async:false,
            url:"call_mrg.php?call=2",
            data:{
                wh:$(".sortwh").val(),
                ht:$(".htsort").val(),
                kw:$(".kw").val(),
            },
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".turow").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    if(arr['name']=="超級管理者"){
                        $(".user_table").append(`
                            <tr class="turow">
                                <td class="tu${i}">${arr['id']}</td>
                                <td class="tu${i}">${arr['account']}</td>
                                <td class="tu${i}">${arr['password']}</td>
                                <td class="tu${i}">${arr['name']}</td>
                                <td class="tu${i}">${arr['rank']}</td>
                                <td class="tu${i}"></td>
                            </tr>
                        `);
                    }else{
                        $(".user_table").append(`
                            <tr class="turow">
                                <td class="tu${i}">${arr['id']}</td>
                                <td class="tu${i}">${arr['account']}</td>
                                <td class="tu${i}">${arr['password']}</td>
                                <td class="tu${i}">${arr['name']}</td>
                                <td class="tu${i}">${arr['rank']}</td>
                                <td class="tu${i}">
                                    <button type="but   ton" onclick="del('${arr['id']}')">刪除</button>
                                    <button type="button" onclick="edt(${i})">修改</button>
                                </td>
                            </tr>
                        `);
                    }
                }
            },
        });
    }
</script>
</html>