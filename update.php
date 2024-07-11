<?php
// POSTデータ取得
$id = $_POST['id'];
$bookname = $_POST['bookname'];
$bookurl = $_POST['bookurl'];
$bookcomment = $_POST['bookcomment'];

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

    // データ更新SQL作成
    $sql = "UPDATE gs_bm_table SET bookname = :bookname, bookurl = :bookurl, bookcomment = :bookcomment WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);
    $stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);
    $stmt->bindValue(':bookcomment', $bookcomment, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // 更新後はselect.phpにリダイレクト
    header("Location: select.php");
    exit();

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    exit('DB_UPDATE_ERROR:' . $e->getMessage());
}
?>
