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
    .type1{
        /* max-width:340px;
        height:auto;
        display:grid;
        grid-template-columns:170px 170px;
        grid-template-rows:30px 100px 20px 30px; */
        max-width:340px;
    height:auto;
    display:grid;
    grid-template-columns:170px 170px;
    grid-template-rows:30px 100px 20px 30px auto;
    grid-auto-flow:dense;
    }
    .type2{
        max-width:340px;
        height:auto;
        display:grid;
        grid-template-columns:170px 170px;
        grid-template-rows:30px 100px 20px 30px;
    }

</style>
<body>
    <button type="button" onclick="location.href='user_mrg_action.php?call=5&id=<?php echo $_GET['id']; ?>'">登出</button>
    <button type="button" onclick='location.href="user_mrg.php"'>會員管理</button>
    <button type="button" onclick='$(".place:eq(0)").dialog("open")'>上架商品</button>
    <form action="" method="post">
        <input type="text" name="findd">
        <button type="submit">搜尋</button>
    </form>
    <div class="place">
        <button type="button" onclick='$(".in_place").dialog("close"),$(".in_place:eq(0)").dialog("open")'>選擇版型</button>
        <button type="button" onclick='$(".in_place").dialog("close"),$(".in_place:eq(1)").dialog("open")'>填寫資料</button>
        <button type="button" onclick='$(".in_place").dialog("close"),$(".in_place:eq(2)").dialog("open")' id="look">預覽</button>
        <button type="button" onclick=''>確定送出</button>    
    </div>
    <div class="in_place">
        <input type="hidden" id="type"><br>
        <div class="type1 types">
        <div style="border:1px solid black;grid-column:auto;grid-row:auto;" class='img'>圖片</div>
        <div style="border:1px solid black;grid-column:2/3;grid-row:1/2;" class='name'>商品名稱</div>
        <div style="border:1px solid black;grid-column:2/3;grid-row:2/3;" class='intro'>商品簡介</div>
        <div style="border:1px solid black;grid-column:2/3;grid-row:3/4;" class='date'>發布日期</div>
        <div style="border:1px solid black;grid-column:1/2;grid-row:auto;" class='link'>相關連結</div>
        <div style="border:1px solid black;grid-column:2/3;grid-row:auto;" class='fee'>費用</div>
            <!-- <div style="gird-column:1/2;grid-row:1/4;border:1px solid black" class='img'>圖片</div>
            <div style="gird-column:2/3;grid-row:1/2;border:1px solid black" class='name'>商品名稱</div>
            <div style="gird-column:2/3;grid-row:2/3;border:1px solid black" class='intro'>商品簡介</div>
            <div style="gird-column:2/3;grid-row:3/4;border:1px solid black" class='date'>發布日期</div>
            <div style="gird-column:1/2;grid-row:4/5;border:1px solid black" class='link'>相關連結</div>
            <div style="gird-column:2/3;grid-row:4/5;border:1px solid black" class='fee'>費用</div>     -->
        </div><br>
        <div class="type2 types">
            <div style="gird-column:1/2;grid-row:1/2;border:1px solid black" class='name'>商品名稱</div>
            <div style="gird-column:2/3;grid-row:1/2;border:1px solid black" class='fee'>費用</div>
            <div style="gird-column:1/2;grid-row:2/5;border:1px solid black" class='img'>圖片</div> 
            <div style="gird-column:2/3;grid-row:2/3;border:1px solid black" class='intro'>商品簡介</div>
            <div style="gird-column:2/3;grid-row:3/4;border:1px solid black" class='date'>發布日期</div>
            <div style="gird-column:2/3;grid-row:4/5;border:1px solid black" class='link'>相關連結</div>
        </div>
    </div>
    <div class="in_place">
        <input type="file" accept='image/png,image/jpeg' id='image_upl'><br>
        <input type="text" placeholder='商品名稱' id='name_upl'><br>
        <input type="text" placeholder='商品簡介' id='intro_upl'><br>
        <input type="text" placeholder='費用' id='money_upl'><br>
        <input type="text" placeholder='相關連結' id='link_upl'><br>
    </div>
    <div class="in_place">
        
    </div>
</body>
<script>
    $(".place").dialog({
        autoOpen:false,
        width:700,
    });
    $(".in_place").dialog({
        autoOpen:false,
        width:700,
    });
    $("#look").on('click',function(){
        if($("#type").val()==""){
            $("#type").val("1");
        }

        let aaa=$("#type").val();
        let typee=$(".type"+aaa)[0];
        $(".in_place:eq(2)").append(typee);
        
        console.log($("#image_upl")[0].value)
    });
</script>
</html>