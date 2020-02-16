<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDatabase();

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $good = $_GET['good'];

  if ($good == "1") {
    $good_value = 1;
  } else {
    $good_value = 0;
  }

  $sql = "update tweets set good = :good where id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":good", $good_value);
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  header('Location: index.php');
  exit;
}
