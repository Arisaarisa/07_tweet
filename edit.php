<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDatabase();
$sql = "select * from tweets where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$tweet = $stmt->fetch(PDO::FETCH_ASSOC);

// 存在しないidを指定された場合はindex.phpに飛ばす
if (!$tweet) {
  header('Location: index.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $content = $_POST['content'];
  $errors = [];

  // バリデーション
  if ($content == '') {
    $errors['content'] = '入力がされていません。';
  }

  if ($content === $tweet['content']) {
    $errors['uncanged'] = '内容が変更されていません。';
  }

  // バリデーション突破後
  if (empty($errors)) {
    $dbh = connectDatabase();
    // tweet内容も変更と同時に投稿時間も更新する
    $sql = "update tweets set content = :content, created_at = now() where id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":content", $content);
    $stmt->execute();
    header('Location: index.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>編集画面</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>tweetの編集</h1>
  <p><a href="index.php">戻る</a></p>
  <?php if ($errors) : ?>
    <ul class="error-list">
      <?php foreach ($errors as $error) : ?>
        <li>
          <?php echo h($error); ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <form action="" method="post">
    <p>
      <label for="content">本文</label><br>
      <textarea name="content" cols="30" rows="5"><?php echo h($tweet['content']); ?></textarea>
    </p>
    <p><input type="submit" value="編集する"></p>
  </form>
</body>

</html>