<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDatabase();

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $good = $_POST['good'];
  if ($tweet['good'] === '0') {
    $sql = "update tweets set good = '1' where id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":id", $id);
  } else {
    $sql = "update tweets set good = '0' where id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":id", $id);
    // PDO処理
  }
  $stmt->execute();
  // 結果の受け取り
  $tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
header('Location: index.php');
exit;
