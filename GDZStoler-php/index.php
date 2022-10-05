<?php
session_start();


function getSubscribe($id,$date)
  {
    try{
      $db= new PDO('sqlite:test.db');
      $tm=strtotime($date);
      $tm=date("Y-m-d", strtotime('+ 1 month',$tm));
      $db->exec("UPDATE users SET access = '$tm' where id=$id;");
      echo "succesfull update";
    }
    catch(PDOException $e){
      echo $e->getMessage(); 
      echo "failed to update";
    }
  }


function DateEquals($date)
  {
    $today = new DateTime("today");
    $date1= new DateTime($date);
    if ($date1>$today)
    {
      return "True";
    }
    else
    {
      return "False";
    }
    
  }

try{
  $db= new PDO('sqlite:test.db');

  //$db->exec("INSERT INTO users(id,username) VALUES (1,'h4rly stesh');");
  //$db->exec("INSERT INTO users(id,username) VALUES (2,'lexi.i52');");
  
  $res= $db->query('SELECT * from users');

  
  print "<table border=1>";
  
  foreach($res as $row){
    print "<tr><td>".$row['id']."</td>";
    print "<td>".$row['username']."</td>";
    print "<td>".$row['access']."</td>";
    $url="?subs=true&id=".$row['id']."&date=".$row['access']."";
    print "<td>".DateEquals($row['access'])."</td>";
    print "<td><a href='$url'>get subscribe + month</a></td></tr>";
  }

  print "</table>";
  
}catch(PDOException $e){
  echo $e->getMessage(); 
}

if (isset($_GET['id'])) {
    //echo "yes";
    //echo $_GET["id"];
    //echo $_GET["date"];
    getSubscribe($_GET['id'],$_GET["date"]);   
}


 




?>

