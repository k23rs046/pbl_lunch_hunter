<?php
require_once 'model.php'; // ここでデータベース接続やクラスを読み込み

$rst_id = $_GET['rst_id'] ?? null;
if (!$rst_id) {
    die("店舗IDが指定されていません");
}

$rst = new Restaurant();
$store_data = $rst->get_RstDetail(['rst_id' => $rst_id]); // ここでDBから取得

if (!$store_data) {
    die("該当する店舗データが見つかりません");
}

// チェックボックス用関数（ビットフラグ）
function is_checked($value, $flags)
{
    return ($flags & $value);
}

// チェックボックス用関数（配列）
function is_array_checked($value, $selected_array)
{
    return in_array($value, $selected_array);
}

// エラーメッセージ
$error = $_SESSION['error'] ?? false;
if (!empty($error)) {
    echo '<h2 style="color:red">必須項目が未入力です</h2>';
    unset($_SESSION['error']);
}

// 時間リスト生成関数
function generate_time_options($current_time)
{
    $options = '';
    $start = strtotime('0:00');
    $end = strtotime('24:00');
    for ($time = $start; $time <= $end; $time += 30 * 60) {
        $time_str = date('G:i', $time);
        $selected = ($time_str == $current_time) ? 'selected' : '';
        $options .= "<option value=\"{$time_str}\" {$selected}>{$time_str}</option>\n";
    }
    return $options;
}

$tel_parts = explode('-', $store_data['tel_num']);
$tel1 = $tel_parts[0] ?? '';
$tel2 = $tel_parts[1] ?? '';
$tel3 = $tel_parts[2] ?? '';

// ジャンル配列（DBに保存されている場合は適宜変換）
$genre = new Genre();
$genre_selected = $genre->getList("rst_id = {$rst_id}");

?>

<main>
    <h2>店舗詳細編集・削除</h2>

    <form action="?do=rst_save" method="post" enctype="multipart/form-data">
        <input type="hidden" name="mode" value="update">
        <input type="hidden" name="rst_id" value="<?= htmlspecialchars($rst_id) ?>">
        <input type="hidden" name="current_photo_path" value="<?= htmlspecialchars($store_data['photo1']) ?>">
        <input type="hidden" name="delete_photo_flag" id="deletePhotoFlag" value="0">

        <div class="registration-container">
            <div class="left-col">
                <!-- 店舗名 -->
                <div class="form-group">
                    <label for="store_name">店舗名</label>
                    <span class="required-star">*必須</span>
                    <input type="text" id="store_name" name="store_name" value="<?= htmlspecialchars($store_data['rst_name']) ?>" required>
                </div>

                <!-- 住所 -->
                <div class="form-group">
                    <label for="address">住所</label>
                    <span class="required-star">*必須</span>
                    <input type="text" id="address" name="address" value="<?= htmlspecialchars($store_data['rst_address']) ?>" required>
                </div>

                <!-- 定休日 -->
                <div class="form-group">
                    <label>定休日</label>
                    <span class="required-star">*必須</span><br>
                    <?php
                    $days = [1 => '日', 2 => '月', 4 => '火', 8 => '水', 16 => '木', 32 => '金', 64 => '土', 128 => '年中無休', 256 => '未定'];
                    foreach ($days as $val => $label) : ?>
                        <label>
                            <input type="checkbox" name="holiday[]" value="<?= $val ?>" <?= is_checked($val, $store_data['rst_holiday']) ? 'checked' : '' ?>>
                            <?= $label ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- 営業時間 -->
                <div class="form-group">
                    <label>営業時間</label>
                    <span class="required-star">*必須</span><br>
                    <select name="open_time" required><?= generate_time_options($store_data['start_time']) ?></select>
                    <select name="close_time" required><?= generate_time_options($store_data['end_time']) ?></select>
                </div>

                <!-- 電話番号 -->
                <div class="form-group">
                    <label>電話番号</label>
                    <span class="required-star">*必須</span><br>
                    <input type="tel" name="tel_part1" value="<?= htmlspecialchars($tel1) ?>" required> -
                    <input type="tel" name="tel_part2" value="<?= htmlspecialchars($tel2) ?>" required> -
                    <input type="tel" name="tel_part3" value="<?= htmlspecialchars($tel3) ?>" required>
                </div>

                <!-- ジャンル -->
                <div class="form-group">
                    <label>ジャンル</label>
                    <span class="required-star">*必須</span><br>
                    <?php
                    $genres = [
                        1 => 'うどん', 2 => 'ラーメン', 3 => 'その他麺類', 4 => '定食', 5 => 'カレー',
                        6 => 'ファストフード', 7 => 'カフェ', 8 => '和食', 9 => '洋食', 10 => '焼肉', 11 => '中華', 12 => 'その他'
                    ];
                    $selected_ids = [];
                    if (!empty($genre_selected)) {
                        foreach ($genre_selected as $g) {
                            $selected_ids[] = $g['genre_id'] ?? $g;
                        }
                    }
                    foreach ($genres as $val => $label) : ?>
                        <label>
                            <input type="checkbox" name="genre[]" value="<?= $val ?>" <?= in_array($val, $selected_ids) ? 'checked' : '' ?>>
                            <?= $label ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="right-col">
                <!-- 支払い方法 -->
                <div class="form-group">
                    <label>支払い方法</label>
                    <span class="required-star">*必須</span><br>
                    <?php
                    $payments = [1 => '現金', 2 => 'QRコード', 4 => '電子マネー', 8 => 'クレジットカード'];
                    foreach ($payments as $val => $label) : ?>
                        <label>
                            <input type="checkbox" name="payment[]" value="<?= $val ?>" <?= is_checked($val, $store_data['rst_pay']) ? 'checked' : '' ?>>
                            <?= $label ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- URL -->
                <div class="form-group">
                    <label for="url">URL</label>
                    <span class="optional-hash">#任意</span>
                    <input type="url" name="url" value="<?= htmlspecialchars($store_data['rst_info']) ?>">
                </div>

                <!-- 写真 -->
                <div class="form-group">
                    <label for="photo_file">写真</label>
                    <span class="optional-hash">#任意</span><br>
                    <input type="file" name="photo_file" accept="image/*">
                    <?php if (!empty($store_data['photo1'])) : ?>
                        <div id="photoPreviewWrapper" style="margin-top:10px;">
                            <img id="preview_img" src="<?= htmlspecialchars($store_data['photo1']) ?>" style="max-width:200px; border:1px solid #ccc;">
                            <button type="button" id="deletePhotoBtn">削除</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <button type="submit" name="update">更新</button>
    </form>
    <form action="?do=rst_save" method="post" id="deleteForm">
        <input type="hidden" name="mode" value="delete">
        <input type="hidden" name="rst_id" value="<?= htmlspecialchars($rst_id) ?>">
        <button type="submit" style="background-color:red; color:white;">削除</button>
    </form>
</main>