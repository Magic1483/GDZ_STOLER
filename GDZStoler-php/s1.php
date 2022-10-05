<?php
try{
  session_start();
  $db= new PDO('sqlite:test.db');

  //$db->exec("INSERT INTO users(id,username) VALUES (1,'h4rly stesh');");
  $db->exec("delete from users");
  unset($_SESSION['access']);
  print("deleted");
  
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
  ?>