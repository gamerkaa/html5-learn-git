<?php

require_once('config.php');
require_once('Model.php');

$channel = 'mstbl_' . $_POST['channel'];
if (isset($_POST['jsondata'])) $jsonData = str_replace("'", "''", $_POST['jsondata']);
$method = $_POST['method'];
$user = str_replace("'", "''", $_POST['user']);

if ($method === 'sent') {
  $db = new Model();
  $id = 0;
  $rowcount = 0;
  $db->query("SELECT id FROM mstbl_users WHERE user = :user AND channel = :channel");
  $db->bind(':user', $user);
  $db->bind(':channel', $channel);
  if ($rows = $db->resultSet()) {
    foreach($rows as $row) {
      $id = $row['id'];
      ++$rowcount;
    }
  }

  if ($id == 0 && $rowcount == 0) {
    $db->query("INSERT INTO mstbl_users (id,user,channel) VALUES(0,:user,:channel)");
    $db->bind(':user', $user);
    $db->bind(':channel', $channel);
    $db->execute();
  }

  $db->query("INSERT INTO " . $channel . " (user,jsondata) VALUES(:user,:jsondata)");
  $db->bind(':user', $user);
  $db->bind(':jsondata', $jsonData);
  $db->execute();
  if (!$db->lastInsertId())
  {
    $db->query("CREATE TABLE " . $channel . " (id BIGINT AUTO_INCREMENT UNIQUE, user VARCHAR(50) NOT NULL, jsondata VARCHAR(2000) NOT NULL)");
    $db->execute();

    $db->query("INSERT INTO " . $channel . " (user,jsondata) VALUES(:user,:jsondata)");
    $db->bind(':user', $user);
    $db->bind(':jsondata', $jsonData);
    if ($db->single()) {
      foreach($rows as $row) $id = $row['id'];
    }
  }
} else if ($method === 'get') {
  $db = new Model();
  $id = 0;
  $rowcount = 0;
  $db->query("SELECT id FROM mstbl_users WHERE user = :user AND channel = :channel");
  $db->bind(':user', $user);
  $db->bind(':channel', $channel);
  if ($rows = $db->resultSet()) {
    foreach($rows as $row) {
      $id = $row['id'];
      ++$rowcount;
    }
  }

  if ($id == 0 && $rowcount == 0) {
    $db->query("INSERT INTO mstbl_users (id,user,channel) VALUES(0,:user,:channel)");
    $db->bind(':user', $user);
    $db->bind(':channel', $channel);
    $db->execute();
  }

  $db->query("SELECT id, jsondata FROM " .$channel ." WHERE id > :id ORDER BY id ASC");
  $db->bind(':id', $id);
  if ($rows = $db->resultSet())
  {
    $printcomma = false;
    $lastid = 0;
    echo '[';
    foreach ($rows as $row)
    {
      if ($printcomma) { echo ','; }
      else $printcomma = true;
      echo str_replace("''", "'", $row['jsondata']);
      $lastid = $row['id'];
    }
    echo ']';
    
    $db->query("UPDATE mstbl_users SET id = :id WHERE user = :user AND channel = :channel");
    $db->bind(':id', $lastid);
    $db->bind(':user', $user);
    $db->bind(':channel', $channel);
    $db->execute();
  } else {
    http_response_code(404);
    return;
  }
} else if ($method == 'delete') {
  $db = new Model();
  $db->query("DELETE FROM mstbl_users WHERE user = :user AND channel = :channel");
  $db->bind(':user', $user);
  $db->bind(':channel', $channel);
  $db->execute();

  $db->query("SELECT COUNT(*) AS usercount FROM mstbl_users WHERE channel = :channel");
  $db->bind(':channel', $channel);
  $usercount = $db->single()['usercount'];
  if ($usercount == 0) {
    $db->query("DROP TABLE `" . $channel . "`");
    $db->execute();
  }
}