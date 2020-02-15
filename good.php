<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDatabase();

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $good = $_POST['good'];
  if ($good === '0') {

    $good_value = '1';
    // $sql1 = "update tweets set good = :good where id = :id";
    // $stmt = $dbh->prepare($sql1);
    // $stmt->bindParam(":good", $good_value);
    // $stmt->bindParam(":id", $id);
  } 
  if ($good === '1') {
    $good_value = '0';
    // $sql2 = "update tweets set good = :good where id = :id";
    // $stmt = $dbh->prepare($sql2);
    // $stmt->bindParam(":good", $good_value);
    // $stmt->bindParam(":id", $id);
  }
$sql = "update tweets set good = :good where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":good", $good_value);
$stmt->bindParam(":id", $id);
$stmt->execute();

}
header('Location: index.php');
exit;
