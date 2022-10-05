<?php
session_start();



if (!isset($_SESSION["access"])||!isset($_SESSION["username"]))
{
    echo '
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="./style.css" rel="stylesheet">

    <div class="main-menu" style="margin-top: 20%;align-items: center;">
    <h2 class="login">Go away fuckin BUM</h2>
    <a href="/vkauth.php" class="login_link">Go login</a>
    
    <br/>
    </div>';
    
    exit(0);
}

?>


<html>
  <head>
    <title>PHP Test</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="./style.css" rel="stylesheet">
    <script
      type="text/javascript"
      src="https://vk.com/js/api/openapi.js?168"
      charset="windows-1251"
    ></script>
    <script type="text/javascript">
      VK.init({ apiId: 51415040 });
    </script>
  </head>
  <body >
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>


    
  <div class="main-menu">
  
    <h2>Main page</h2>


    <?php
      $maindir='/root/GDZStoler-php/Content';
      
      
      $fileList = glob("$maindir/*");
      filelist_out_btn($fileList,"");
    ?>
  
  </div>
    
    <h3 style="color:indigo-600"> list of accessible image directories </h3>
  
  

    
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
            $ff=explode("/home/runner/PHP-7410-Cusom",$filename);
            //echo $ff[1];
            $url="https://php-test.sashafurancev.repl.co/?key1=".$ff[1]."";
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



    function filelist_out_btn($fileList)
      {
        foreach($fileList as $filename){
         //display oinly folders in directory
         if (! is_file($filename)){
          if (count_of_files($filename)==0)
          {
              echo "
  <a class='btn btn-outline-secondary' data-bs-toggle='collapse' href='#".basename($filename)."'>
    ".basename($filename)."
  </a>";
          }  
         }

      $arr=glob("$filename/*");
      filelist_out_dropdown($arr,basename($filename));
      }
    }

    function filelist_out_dropdown($fileList,$id)
      {
        print "<div class='collapse' id='".$id."'>
  <div class='card card-body'>";
        $arr=array();
        foreach($fileList as $filename){
         //display oinly folders in directory
         if (! is_file($filename)){
          array_push($arr,$filename); 
          //echo basename($filename);
         }
      }
        foreach($arr as $el){
          
          
          echo "<a href='textbooks.php?book=".$id."/".basename($el)."'>".basename($el)."</a>";
        }
        print "</div></div>";
      }
      
    



    if (isset($_GET['key1'])) {
        echo "<h1> ".$_GET['key1']." </h1>";
        //DisplayIMGS($_GET['key1']);
        //var_dump($_GET['key1']); 
        
    }
    else {
      echo "<h1> folder not found </h1>";
    }

    if (isset($_GET['uid']) and isset($_GET['first_name']) and isset($_GET['last_name']) and isset($_GET['photo'])) {
        echo "<h1> ".$_GET['uid']." </h1>";
        echo "<h1> ".$_GET['first_name']." </h1>";
        echo "<h1> ".$_GET['last_name']." </h1>";
        echo "<img src=".$_GET['photo'].">";
        //DisplayIMGS($_GET['key1']);
        //var_dump($_GET['key1']); 
        
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


    

  </body>
</html>