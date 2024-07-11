<?php
// GETパラメータからidを取得する
$id = $_GET['id'];

// 本番環境データベース接続情報
$prod_db = "";
$prod_host = "";
$prod_id = "";
$prod_pw = "";

try {
    // PDOインスタンスの作成
    $pdo = new PDO('mysql:dbname='.$prod_db.';host='.$prod_host.';charset=utf8', $prod_id, $prod_pw);
    // エラーモードの設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データ削除SQL作成
    $sql = "DELETE FROM gs_bm_table WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // 削除後はselect.phpにリダイレクト
    header("Location: select.php");
    exit();

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    exit('DB_DELETE_ERROR:' . $e->getMessage());
}
?>
