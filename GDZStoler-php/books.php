<?php
session_start();



if (!isset($_SESSION["access"])||!isset($_SESSION["username"]))
{
    echo 'Go away fuckin BUM<br/>';
    echo "<a href='/vkauth.php'>Go login</a>";
    exit(0);
}

?>

<html>
  <head>
    <title>PHP Test</title>
    <link rel="stylesheet" href="./style.css">
  </head>
  <body >


    <h2>Current user is:<?php
      echo $_SESSION["username"];
      ?>
    </h2>
    <br/>
  
  <h3> list of accessible image directories </h3>
  
  <list>
    <?php
      $maindir='/home/runner/PHP-7410-Cusom/Content';
      
      
      $fileList = glob("$maindir/*");
      filelist_out($fileList,"");
      
    ?>
  </list>

    
    <?php
    
    
    
    //Get a list of file paths using the glob function.
    
    function count_of_folders($filename)
      {
        $arr=glob("$filename/*");
        $count=0;
        
        foreach ($arr as $el)
          {
            if(! is_file($el))
            {
              $count++;
            }
          }
         return $count;
      }

      function count_of_files($filename)
        {
          $arr=glob("$filename/*");
          $count=0;
          
          foreach ($arr as $el)
            {
              if(is_file($el))
              {
                $count++;
              }
            }
           return $count;
        }
    
    //Loop through the array that glob returned.
    function filelist_out($fileList,$tabs)
      {foreach($fileList as $filename){
         //display oinly folders in directory
         if (! is_file($filename)){
          $st_cont=substr_count($filename,"/");
          $st_cont-=3;
          for($i=1 ;$i<$st_cont;$i++)
              {
                
                $tabs.="......";
              }

          if (count_of_files($filename)==0)
          {
            echo "$tabs".basename($filename)."";
            echo "</br>";
            $tabs="";
          }
            
          else{
            $ff=explode("/home/runner/PHP-7410-Cusom/Content",$filename);
            //echo $ff[1];
            $url="https://PHP-7410-Cusom.sashafurancev.repl.co/books.php?key1=Content".$ff[1]."";
            echo "$tabs<a href=".$url.">".basename($filename)."</a> </br>";
            $tabs="";
          }

          if (count_of_folders($filename)!=0)
          {
            $arr=glob("$filename/*");
            filelist_out($arr,$tabs);
          }
           

          
          
          //filelist_out(glob($filename));
           //echo basename($filename), '<br>'; 
           //$url="https://php-test.sashafurancev.repl.co/?key1=".basename($filename)."";
           //echo "<a href=".$url.">".basename($filename)."</a> </br>";
         }
      }}
    
    if (isset($_GET['key1'])) {
        echo "<h1> ".$_GET['key1']." </h1>";
        //DisplayIMGS($_GET['key1']);
        //var_dump($_GET['key1']); 
        
    }
    else {
      echo "<h1> folder not found </h1>";
    }

    ?>

<div class="img1"><?php
  DisplayIMGS($_GET['key1']);
  ?>
</div>
    
    <!--Display all images from $images Directory-->
    <?php
      function DisplayIMGS($_folder){
      $imagesDirectory = "".$_folder."/";
     
      if(is_dir($imagesDirectory))
      {
      	$opendirectory = opendir($imagesDirectory);
        
          while (($image = readdir($opendirectory)) !== false)
      	{
      		if(($image == '.') || ($image == '..'))
      		{
      			continue;
      		}
      		
      		$imgFileType = pathinfo($image,PATHINFO_EXTENSION);
      		
      		if(($imgFileType == 'jpg') || ($imgFileType == 'png') || ($imgFileType == 'JPG'))
      		{
      			echo "<img src='".$imagesDirectory."/".$image."' class='img_m'> ";
      		}
          }
      	
          closedir($opendirectory);
      }
    }
    ?>


    
    
    

    <!--
    This script places a badge on your repl's full-browser view back to your repl's cover
    page. Try various colors for the theme: dark, light, red, orange, yellow, lime, green,
    teal, blue, blurple, magenta, pink!
    -->
    <script src="https://replit.com/public/js/replit-badge.js" theme="pink" defer></script> 
  </body>
</html>