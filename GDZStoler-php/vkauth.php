<?php
session_start();

function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}


function insertToDb($id,$name){
  $db= new PDO('sqlite:test.db');
  
  $userID=$db->query("SELECT id from users where id=".$id."");
  $value = $userID->fetch();
  //echo $value[0];
  echo "<h2 class='login'>ID: ".$value[0]."</h2>";
  $date=date("Y-m-d");
  
  //
  if(!$value[0])
  {
    try
    {
    $db= new PDO('sqlite:test.db');
    
    $db->exec("INSERT INTO users(id,username,access) VALUES ($id,'$name','$date');");
    echo "try to insertd";
  
  
    }catch(PDOException $e){
      echo $e->getMessage();
      echo "failed";
    }
  }
  //IF user is exist!!
  else{
    echo '
    <br/><h2 class="login">ID was exist</h2>';
    $userACCESS=$db->query("SELECT access from users where id=".$id."");
    $value = $userACCESS->fetch();
    #echo "<br/><br/>".var_dump(DateEquals($value[0]))."";
    if(DateEquals($value[0]))
    {
      echo "<br/><h2 class='login'>U is VIP</h2>";
      $_SESSION["access"]=True;
    }
    //Проверить премиум доступ и записать в SESSION
  }
}

function DateEquals($date)
  {
    $today = new DateTime("today");
    $date1= new DateTime($date);
    if ($date1>$today)
    {
      return True;
    }
    else
    {
      return False;
    }
    
  }




$client_id = 51415040; // ID приложения
$client_secret = 'f8lPzcuIlEzpFxz8Ll3U'; // Защищённый ключ
$redirect_uri = 'http://45.147.230.250:8000/vkauth.php'; // Адрес сайта

// Формируем ссылку для авторизации
$params = array(
	'client_id'     => $client_id,
	'redirect_uri'  => $redirect_uri,
	'response_type' => 'code',
	'v'             => '5.131', // (обязательный параметр) версия API, которую Вы используете https://vk.com/dev/versions
 
	// Права доступа приложения https://vk.com/dev/permissions
	// Если указать "offline", полученный access_token будет "вечным" (токен умрёт, если пользователь сменит свой пароль или удалит приложение).
	// Если не указать "offline", то полученный токен будет жить 12 часов.
	'scope'         => 'photos,offline',
);
 
// Выводим на экран ссылку для открытия окна диалога авторизации
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<link href="./style.css" rel="stylesheet">
<div class="main-menu" style="margin-top: 20%;align-items: center;">
<a href="http://oauth.vk.com/authorize?' . http_build_query( $params ) . '" class="login_link" style="text-align: center;margin-bottom: 5%;">Авторизация через ВКонтакте</a>
';


if ( isset( $_GET['code']  ) ){
  
  

  $url = "https://oauth.vk.com/access_token?client_id=" . $client_id . "&client_secret=" . $client_secret . "&redirect_uri=" . $redirect_uri . "&code=" .  $_GET["code"];
	
  $response = json_decode(url_get_contents($url), true);


  $params = array(
		  'v'            => '5.131',
			'uids'         => $response['user_id'],
			'access_token' => $response['access_token'],
			'fields'       => 'photo_big',
	);
  
  $info =url_get_contents('https://api.vk.com/method/users.get?' .   urldecode(http_build_query($params)));
  $info= json_decode($info,true);

  
  
  
  $userID= $response["user_id"];
  

  //echo var_dump($info);
  //echo var_dump($info);
  $first_name= strval($info["response"][0]["first_name"]);
  $last_name = strval($info["response"][0]["last_name"]);

  $username="".$first_name." ".$last_name."";
  //echo "$username";
  $_SESSION["username"] = "$username";
  echo "<h2 class='login'>".$_SESSION["username"]."</h2>";

  if($userID)
  {
    insertToDb($userID,$username);
  }
  
  echo "<br/><a href='/content.php' class='login_link'>Go 2 main page</a></div>";
  

}