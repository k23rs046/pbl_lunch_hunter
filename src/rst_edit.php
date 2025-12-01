<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Lunch Hunter - 店舗編集・削除</title>
    </head>
<body>
    <main>
        <button onclick="location.href='rst_detail.php'">店舗詳細</button>
        <h2>店舗詳細情報編集・削除</h2>
        
        <form action="edit_delete_store.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="store_id" value="<?php echo htmlspecialchars($store_data['id']); ?>">
            
            <section id="details">
                <div>
                    <label for="store_name">店舗名 *必須</label>
                    <input type="text" id="store_name" name="store_name" value="<?php echo htmlspecialchars($store_data['name']); ?>" required maxlength="30">
                </div>
                
                <div>
                    <label for="address">住所 *必須</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($store_data['address']); ?>" required>
                </div>

                <div>
                    <p>支払い方法 *必須</p>
                    <label><input type="checkbox" name="payment[]" value="cash" <?php echo in_array('cash', $store_data['payment']) ? 'checked' : ''; ?>> 現金</label>
                    <label><input type="checkbox" name="payment[]" value="card" <?php echo in_array('card', $store_data['payment']) ? 'checked' : ''; ?>> カード</label>
                    </div>
                
                <div>
                    <label for="photo">写真 (外部) #任意</label>
                    <input type="file" id="photo" name="photo">
                    </div>
            </section>
            
            <button type="submit" name="action" value="update">更新</button>
            
            <button type="submit" name="action" value="delete" onclick="return confirm('本当にこの店舗情報を削除しますか？');">削除</button>
        </form>
    </main>
</body>
</html>
<?php
require_once 'db_connect.php';

$store_id = $_GET['id'] ?? null;

$store_data = [
    'id' => '', 
    'name' => '', 
    'address' => '', 
    'payment' => []
];

if ($store_id) {
    $stmt = $pdo->prepare("SELECT * FROM stores WHERE id = ?");
    $stmt->execute([$store_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $store_data['id'] = $result['id'];
        $store_data['name'] = $result['name'];
        $store_data['address'] = $result['address'];
        $store_data['payment'] = explode(',', $result['payment_methods']);
    } else {
        header('Location: store_list.php?error=not_found');
        exit;
    }
}
?>
<?php
// ... データ取得・表示のPHPコードの後に続く ...

// フォームがPOST送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $store_id = $_POST['store_id'] ?? null;

    if (!$store_id) {
        // IDがない場合はエラー
        die("店舗IDが指定されていません。");
    }

    if ($action === 'update') {
        // 16. 更新処理
        
        // データの受け取りと検証
        $name = $_POST['store_name'] ?? '';
        $address = $_POST['address'] ?? '';
        $payment_array = $_POST['payment'] ?? []; // チェックボックスは配列で受け取る
        $payment_methods = implode(',', $payment_array); // DB保存用にカンマ区切り文字列に変換

        // TODO: ここで全ての必須項目のチェック、入力値のサニタイズ（安全な処理）を行う

        // データベースの更新
        try {
            $sql = "UPDATE stores SET 
                    name = ?, 
                    address = ?, 
                    payment_methods = ?
                    -- 他のフィールドも同様に追加
                    WHERE id = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $address, $payment_methods, $store_id]);

            // 更新成功後に店舗詳細画面や一覧画面へリダイレクト
            header('Location: store_list.php?message=updated');
            exit;

        } catch (PDOException $e) {
            $error_message = "更新中にエラーが発生しました: " . $e->getMessage();
            // $error_messageをHTML側に表示するなどの対応
        }

    } elseif ($action === 'delete') {
        // 17. 削除処理
        
        // データベースの削除
        try {
            // 削除確認のダイアログはHTML側の `onclick="return confirm(...)"` で対応
            $sql = "DELETE FROM stores WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$store_id]);

            // 削除成功後に店舗一覧画面へリダイレクト
            header('Location: store_list.php?message=deleted');
            exit;

        } catch (PDOException $e) {
            $error_message = "削除中にエラーが発生しました: " . $e->getMessage();
            // $error_messageをHTML側に表示するなどの対応
        }
    }
}
// ... HTMLの開始タグへ ...
?>