<!-- detail.php -->
<?php
// GETパラメータからidを取得する
$id = $_GET['id'];

// 本番環境データベース接続情報
$prod_db = "gs-oyuri_php_kadai2";
$prod_host = "mysql648.db.sakura.ne.jp";
$prod_id = "gs-oyuri";
$prod_pw = "yuri_2406";

try {
    // PDOインスタンスの作成
    $pdo = new PDO('mysql:dbname='.$prod_db.';host='.$prod_host.';charset=utf8', $prod_id, $prod_pw);
    // エラーモードの設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データ取得SQL作成
    $sql = "SELECT * FROM gs_bm_table WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $value = $stmt->fetch(PDO::FETCH_ASSOC);

    // データが存在しない場合はエラー表示
    if (!$value) {
        exit('データが見つかりません');
    }

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    exit('DB_CONNECT_ERROR:' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマーク更新</title>
<link rel="stylesheet" href="css/bookmark.css">
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 20px;
  }
  .container {
    max-width: 600px;
    margin: auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }
  input[type="text"], textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: right;
  }
</style>
</head>
<body>

<div class="container">
  <h2>ブックマーク更新</h2>
  <form method="POST" action="update.php">
    <input type="hidden" name="id" value="<?= $value['id'] ?>">
    <label>書籍名：<input type="text" name="bookname" value="<?= $value['bookname'] ?>"></label><br>
    <label>書籍URL：<input type="text" name="bookurl" value="<?= $value['bookurl'] ?>"></label><br>
    <label>コメント：<textarea name="bookcomment" rows="4"><?= $value['bookcomment'] ?></textarea></label><br>
    <input type="submit" value="更新">
  </form>
</div>

</body>
</html>
