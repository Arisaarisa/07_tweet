<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDatabase();

// index.phpから該当のレコードidを使用
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // フォームに入力されたデータの受け取り
  $good = $_GET['good'];

  if ($good == "1") {
    $good_value = 1;
  } else {
    $good_value = 0;
  }

  // データを更新する処理
  $sql = "update tweets set good = :good where id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":good", $good_value);
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  header('Location: index.php');
  exit;
}
