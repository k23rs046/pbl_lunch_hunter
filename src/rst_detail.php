<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
-->
<style>
.rating {
    display: flex;
    flex-direction: row-reverse; /* 右から左へ並べる */
    justify-content: flex-start;
    width: 300px;
}

/* ラジオボタンは非表示 */
.rating input {
    display: none;
}

/* 星のスタイル */
.rating label {
    font-size: 30px;      
    color: #ccc;          /* 初期は灰色 */
    cursor: pointer;
    padding: 5px;
    transition: color 0.2s;
}

/* チェックされた星（★）から左側を黄色にする */
.rating input:checked ~ label {
    color: gold;
}

.big-textarea {
    width: 500px;    /* 幅を指定 */
    height: 200px;   /* 高さを指定 */
    font-size: 16px; /* 文字サイズも調整可 */
}

body {
    font-size: 20px;
}
.danger-btn {
    color: #fff;
    font-weight: bold;
}

.link-white {
    color: #fff !important;       /* 青を上書きして白にする */
    font-weight: bold;            /* 太字 */
    text-decoration: none !important; /* 下線消す */
}
</style>
<?php
require_once('model.php');
$user = new User();
$restaurant = new Restaurant();
$review = new Review();

//レビューをリンクから取得
$rst_id = ['rst_id' => $_GET['rst_id']];
$rstdata = $restaurant -> get_RstDetail($rst_id);
print_r($rstdata);
//$rst_holiday = 
//$rst_pay =
?>
<h1 style="text-align:center;">店舗詳細</h1>
<div>
    <a href="">戻る(店舗一覧)</a>
    <?php
    if($_SESSION['usertype_id']==1){
        if($_SESSION['user_id']==$rstdata['user_id']){  
            echo '<a href="?do=rst_edit&rst_id='.$rst_id['rst_id'].'" class=btn>編集</a>';
        }
        echo '<button>お気に入り</button>';
    }elseif($_SESSION['usertype_id']==9){  }
    ?>
    
</div>
<br>
<div class="shopinfo">
    <h3><?php echo $rstdata['rst_name']; ?></h3>
    <table border="1">
        <tr>
            <td><div>住所</div></td>
            <td><?php echo $rstdata['rst_address']?></td>
        </tr>
        <tr>
            <td><div>電話番号</div></td>
            <td><?php echo $rstdata['tel_num']?></td>
        </tr>
        <tr>
            <td><div>店休日</div></td>
            <td>
                <?php
                foreach($rstdata['holidays']  as $h){
                    echo $h.' ';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><div>営業時間</div></td>
            <td><?php echo $rstdata['start_time'].'~'.$rstdata['end_time'] ?></td>
        </tr>
        <tr>
            <td><div>ジャンル</div></td>
            <td>
                <?php
                foreach($rstdata['rst_genre']  as $rg){
                    echo $rg['genre'].' ';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><div>支払方法</div></td>
            <td>
                <?php
                foreach($rstdata['pays']  as $p){
                    echo $p.' ';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><div>URL</div></td>
            <td><?php echo $rstdata['rst_info']; ?></td>
        </tr>
        
    </table>
    <div class="shop-phot">
        <img src="" alt="未登録">
    </div>
</div>

<div class="shop-point">
    <form action="?do=rst_detail_rvsave" method="post">
    <h3>評価</h3>
    <div>総評価人数</div>
    <ul class="gurafu">
        <li>1</li>
        <li>2</li>
        <li>3</li>
        <li>4</li>
        <li>5</li>
    </ul>
    <div>総評価平均 4.2</div>
    <div>★★★★</div>
    <div class="kuchikomi">
        <div>
            <h4>評価</h4>
            <div class="rating">
                <!-- 星は右から並べる -->
                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5">★</label>

                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4">★</label>

                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3">★</label>

                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2">★</label>

                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1">★</label>
            </div>
            <textarea name="comment" class="big-textarea" placeholder="コメントを入力してください"></textarea>
        </div>
        <div class="phot">
            <!-- 1枚目 -->
            <input type="file" id="imageInput0" accept="image/*">
            <div id="previewArea0" style="margin-top:10px; display:none;">
                <img id="previewImage0" src="" style="max-width:200px;"><br>
                <button id="deleteBtn0">選択解除</button>
            </div><br>
            <!-- 2枚目 -->
            <input type="file" id="imageInput1" accept="image/*">
            <div id="previewArea1" style="margin-top:10px; display:none;">
                <img id="previewImage1" src="" style="max-width:200px;"><br>
                <button id="deleteBtn1">選択解除</button>
            </div><br>
            <!-- 3枚目 -->
            <input type="file" id="imageInput2" accept="image/*">
            <div id="previewArea2" style="margin-top:10px; display:none;">
                <img id="previewImage2" src="" style="max-width:200px;"><br>
                <button id="deleteBtn2">選択解除</button>
            </div><br>
            <input type="submit" value="登録" class="btn btn-primary link-white">
            </form>
            <?php
            
            ?>
            <a href="?do=rst_detail_rvsave" class="btn btn-danger link-white">削除</a>
        </div>
    </div>

    <div>
        <h2>口コミ</h2>
        <section>
            <div>名前</div>
            <div>評価</div>
            <div>コメント一部</div>
            <button>詳細</button>
        </section>
    </div>

    <script>
    // 画像3つ分をまとめて処理
    for (let i = 0; i < 3; i++) {

        const input = document.getElementById(`imageInput${i}`);
        const area = document.getElementById(`previewArea${i}`);
        const img = document.getElementById(`previewImage${i}`);
        const del = document.getElementById(`deleteBtn${i}`);

        // プレビュー表示
        input.addEventListener("change", function () {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    img.src = e.target.result;
                    area.style.display = "block";
                };

                reader.readAsDataURL(file);
            }
        });

        // 削除ボタン
        del.addEventListener("click", function () {
            img.src = "";
            area.style.display = "none";
            input.value = ""; // 選択解除
        });
    }
    </script>