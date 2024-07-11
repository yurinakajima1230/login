<?php
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
    $sql = "SELECT * FROM gs_bm_table";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<title>ブックマーク一覧</title>
<link rel="stylesheet" href="css/bookmark.css">
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: pink;
    margin: 0;
    padding: 20px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  th {
    background-color: #f2f2f2;
  }
</style>
</head>
<body>

<!-- ヘッダー -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <p>ブックマーク一覧</p>
      </div>
    </div>
  </nav>
</header>

<!-- メインコンテンツ -->
<div class="container jumbotron">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>書籍名</th>
        <th>書籍URL</th>
        <th>コメント</th>
        <th>登録日時</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($values)): ?>
        <?php foreach($values as $value): ?>
          <tr>
            <td><?= $value["id"] ?></td>
            <td><?= $value["bookname"] ?></td>
            <td><?= $value["bookurl"] ?></td>
            <td><?= $value["bookcomment"] ?></td>
            <td><?= $value["indate"] ?></td>
            <td><a href="detail.php?id=<?= $value['id'] ?>">更新</a></td> <!-- 更新リンク -->
            <td><a href="delete.php?id=<?= $value['id'] ?>" onclick="return confirm('本当に削除しますか？')">削除</a></td> <!-- 削除リンク -->
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">データがありません</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- フッター -->
<footer>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">登録</a>
      </div>
    </div>
  </nav>
</footer>

</body>
</html>
