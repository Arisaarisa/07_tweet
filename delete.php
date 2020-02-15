<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDatabase();
$sql = "select * from tweets where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$tweet = $stmt->fetch();

// $tweetがみつからないときはindex.phpに飛ばす
if (!$tweet) {
  header('Location: index.php');
  exit;
}

$sql_delete = "delete from tweets where id = :id";
$stmt_delete = $dbh->prepare($sql_delete);
$stmt_delete->bindParam(":id", $id);
$stmt_delete->execute();

header('Location: index.php');
exit;
