<?php

// 設定ファイルと関数ファイルの読み込み
require_once('config.php');
require_once('functions.php');


// データベース接続
$dbh = connectDatabase();
// SQLの準備
// SQL後半の'order by updated_at desc'というのは「更新日時が新しい順」という意味
$sql = "select * from tweets order by created_at desc";
// プリペアードステートメントの準備
$stmt = $dbh->prepare($sql);
// プリペアードステートメントの実行
$stmt->execute();
// $tweetsに連想配列の形式で記事データを格納する
$tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
// 新規タスク
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // フォームに入力されたデータ
  $content = $_POST['content'];
  $errors = [];

  if ($content == '') {
    $errors['content'] = 'ツイート内容を入力してください。';
  }

  // バリデーションを突破したあとの処理 "もし空っぽだったら↓"
  // 時間を日本の正しい時間にしたいが
  if (empty($errors)) {
    // function created_at() {
    //   date_default_timezone_set('Asia/Tokyo');
    //   $created_at = date("y/m/d H:i:s");
    //   return $created_at;
    // } 

    // データを追加する
    $sql = "insert into tweets (content, created_at) values (:content, now())";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":content", $content);
    $stmt->execute();
    // index.phpに戻る
    header('Location: index.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Tweet</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>新規Tweet</h1>
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
      <label for="content">ツイート内容</label><br>
      <textarea name="content" cols="30" rows="5" placeholder="いまどうしてる？"></textarea>
    </p>
    <p><input type="submit" value="投稿する"></p>
  </form>

  <h2>Tweet一覧</h2>
  <!-- 投稿の下に一覧を表示 -->
  <!-- もし$tweetsにデータが設定されていたら (if)-->
  <?php if (count($tweets)) : ?>
    <ul class="tweet-list">
      <!-- foreachで出力 -->
      <?php foreach ($tweets as $tweet) : ?>
        <li>
          <!-- お気に入り -->
          <!-- 投稿はアンカータグでshow.phpへ飛ぶ -->
          <a href="show.php?id=<?php echo h($tweet['id']); ?>"><?php echo h($tweet['content']); ?></a><br>
          投稿日時: <?php echo h($tweet['created_at']); ?>
          <?php if ($tweet['good'] === '0') : ?>
            <a href="good.php?id=<?php echo h($tweet['id']) . "&good=1"; ?>" class="good-link"><?php echo '☆'; ?></a>
          <?php else : ?>
            <a href="good.php?id=<?php echo h($tweet['id']) . "&good=0"; ?>" class="bad-link"><?php echo '★'; ?></a>
          <?php endif; ?>
          <hr>
        </li>
      <?php endforeach; ?>
    </ul>
    <!-- もし$tweetsにデータが設定されていなかったら(else) -->
  <?php else : ?>
    <p>投稿されたtweetはありません</p>
  <?php endif; ?>

</body>

</html>