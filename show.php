  <?php

  require_once('config.php');
  require_once('functions.php');

  $id = $_GET['id'];

  $dbh = connectDatabase();
  $sql = "select * from tweets where id = :id ";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  $tweet = $stmt->fetch(PDO::FETCH_ASSOC);

  ?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <title>tweet</title>
  </head>

  <body>
    <h1><?php echo h($tweet['content']); ?></h1>
    <a href="index.php">戻る</a>
    <ul class="tweet-list">
      <li>
        [#<?php echo h($tweet['id']); ?>]
        @<?php echo h($tweet['content']); ?><br>
        投稿日時: <?php echo h($tweet['created_at']); ?>
        <a href="edit.php?id=<?php echo h($tweet['id']); ?>">[編集]</a>
        <a href="delete.php?id=<?php echo h($tweet['id']); ?>">[削除]</a>
        <hr>
      </li>
    </ul>
  </body>

  </html>