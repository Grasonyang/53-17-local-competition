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
<body>
    
    <button onclick="$('.place:eq(0)').dialog('open')">新增帳號</button>
    <div class="place">
        <form action="user_mrg_action.php?call=1" method="post">
            帳號: <input type="text" name="id"><br>
            密碼: <input type="text" name="pwd"><br>
            姓名: <input type="text" name="name"><br>
            權限: <select name="rk">
                    <option value="1">一般使用者</option>
                    <option value="2">管理者</option>
                </select><br>
            <input type="submit">
        </form>
    </div>
    <div class="place">
        <form action="user_mrg_action.php?call=4" method="post">
            <input type="hidden" name="f2trueid" id="f2trueid">
            帳號: <input type="text" id="f2id" name="id"><br>
            密碼: <input type="text" id="f2pwd" name="pwd"><br>
            姓名: <input type="text" id="f2name" name="name"><br>
            權限: <select name="rk">
                    <option value="1" id='f2u1'>一般使用者</option>
                    <option value="2" id='f2u2'>管理者</option>
                </select><br>
            <input type="submit">
        </form>
    </div>
    <div class="all_user">
        <div>
            <input type="text" id="wh" placeholder="關鍵字">
            <select id="whitem">
                <option value="id" id="uuu">使用者編號</option>
                <option value="user">帳號</option>
                <option value="password">密碼</option>
                <option value="name">姓名</option>
                <option value="rank">權限</option>
            </select>
            <select id="whsort">
                <option value="ASC" id="AAA">升冪</option>
                <option value="DESC">降冪</option>
            </select>
            <button type="button" onclick='code()'>搜尋</button>
        </div>
        <table border=1 class="alluser">
            <tr>
                <td>使用者編號</td>
                <td>帳號</td>
                <td>密碼</td>
                <td>姓名</td>
                <td>權限</td>
                <td>操作</td>
            </tr>
        </table>
        <table border=1 class="useraction">
            <tr>
                <td>使用者</td>
                <td>時間</td>
                <td>動作</td>
                <td>成功/失敗</td>
            </tr>
        </table>
    </div>
</body>
<script>
    code();
    acc();
    // let nn=60;
    // timmer();
    // function timmer(){
    //     let aa=setInterval(() => {
    //         $(".lattime").text(nn);
    //         nn--;
    //         if(nn<=0){
    //             clearInterval(aa);
    //             let nnn=5;
    //             confirm('是否繼續?');
    //             setInterval(() => {
    //                 aa--;
    //             }, 1000);
    //             if(confirm('是否繼續?')){

    //             }else{
                    
    //             }
                
    //         }
    //     }, 1000);
    // };
    $(".place").dialog({
        autoOpen:false,
    });
    function del(num){
        $.post({
            async:false,
            url:"user_mrg_action.php?call=3",
            data:{
                id:$('.item_'+num+':eq(0)').text(),
            },
            success:function(e){
                code();
            },
        });
        
    }
    function edi(num){
        $(".place:eq(1)").dialog("open");
        if($('.item_'+num+':eq(4)').text()=='1'){
            $("#f2u1").attr('selected',true);
        }else{
            $("#f2u2").attr('selected',true);
        }
        $("#f2trueid").val($('.item_'+num+':eq(0)').text());
        $("#f2id").val($('.item_'+num+':eq(1)').text());
        $("#f2pwd").val($('.item_'+num+':eq(2)').text());
        $("#f2name").val($('.item_'+num+':eq(3)').text());
    }
    function acc(){
        $.post({
            async:false,
            url:"user_mrg_action.php?call=6",
            success:function(e){
                $('.rowacc').remove();
                let list=e.split('(+)');
                list.pop();
                for(let i=0;i<list.length;i++){
                   let arr=JSON.parse(list[i]);
                    $('.useraction').append(`
                        <tr class='rowacc'>
                            <td class='acc_${i}'>${arr['user']}</td>
                            <td class='acc_${i}'>${arr['time']}</td>
                            <td class='acc_${i}'>${arr['action']}</td>
                            <td class='acc_${i}'>${arr['sf']}</td>
                        </tr>
                    `);
                }
            },
        });
    }
    function code(){
        $.post({
            async:false,
            url:"user_mrg_action.php?call=2",
            data:{
                kew:$('#wh').val(),
                whitem:$('#whitem').val(),
                whsort:$('#whsort').val(),
            },
            success:function(e){
                $("#wh").val("");
                $("#uuu").attr('selected',true);
                $("#AAA").attr('selected',true);
                $('.rows').remove();
                let list=e.split('(+)');
                list.pop();
                for(let i=0;i<list.length;i++){
                   let arr=JSON.parse(list[i]);
                    $('.alluser').append(`
                        <tr class='rows row${i}'>
                            <td class='item_${i}'>${arr['id']}</td>
                            <td class='item_${i}'>${arr['user']}</td>
                            <td class='item_${i}'>${arr['password']}</td>
                            <td class='item_${i}'>${arr['name']}</td>
                            <td class='item_${i}'>${arr['rank']}</td>
                        </tr>
                    `);
                    if(arr['id']!='0000'){
                        $(".row"+i).append(`
                            <td class='item_${i}'>
                                <button type="button" onclick='del(${i})'>刪除</button>
                                <button type="button" onclick='edi(${i})'>修改</button>
                            </td>
                        `);
                    }else{
                        $(".row"+i).append(`
                            <td class='item_${i}'>
                            </td>
                        `);
                    }
                }
            },
        });
    }
</script>
</html>