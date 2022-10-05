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
  <title>Current book</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="./style.css" rel="stylesheet">

    
    
  </head>
  <style>
    .main-menu{
      display: flex;
      flex-direction: column;
      flex-wrap:wrap;
    }
  </style>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    
    <div class="main-menu">
      
      
    <?php

    function filelist_out_btn($fileList)
      {
        foreach($fileList as $filename){
         //display oinly folders in directory
          $cur="".$_GET['book']."/".basename($filename)."";
          $book_img="Content/".$cur."/".basename($filename).".jpg";
          $content= "
              <a href='textbooks.php?cbook=".$cur."'>
            <div class='block'>
                    <div class='img_block pull-left'>
                    <img src='".$book_img."' class='book_img'>
                    </div>
                    <div class='desc'>
                      <p>".basename($filename)."</p>
                      <p>
                      <b>Авторы:</b><span>asdas</span>
                      </p>
                      
                    </div>
                    
                  </div>
                  </a>
            
                      ";
         if (! is_file($filename)){
          if (count_of_files($filename)==0)
          {
            $cur="".$_GET['book']."/".basename($filename)."";
            
            
            
            echo $content;
          } 
          else
          {
            $cur="".$_GET['book']."/".basename($filename)."";
            echo $content;
          }
         }

      }
    }

    function filelist_out_chapter($fileList)
      {
        foreach($fileList as $filename){
         //display oinly folders in directory
         if (! is_file($filename)){
          if (count_of_files($filename)!=0)
          {
            $cur="".$_GET['cbook']."/".basename($filename)."";
              echo "
  <a class='btn btn-outline-secondary' data-bs-toggle='collapse' href='#".basename($filename)."'>
    ".basename($filename)."
  </a>";
            
          }  
         }
        $arr=glob("$filename/*");
        filelist_out_numbers($arr,basename($filename));
      }
    }


    function filelist_out_numbers($fileList,$id)
      {
        
        print "<div class='collapse' id='".$id."'>
  <div class='container'>";
        $arr=array();
        foreach($fileList as $filename){
         //display oinly folders in directory
         if (is_file($filename)){
          array_push($arr,basename($filename)); 
          //echo basename($filename);
         }
      }
        $arr = extractNum($arr);
        //print_r($arr);
        foreach($arr as $el){
          
          
          echo "<a  class='c-btn' href='textbooks.php?s_img=".$_GET['cbook']."/".$id."/".basename($el)."'>".basename($el)."</a>";
        }
        print "</div></div>";
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


    function Alg($t,$do,$val)
    {
        $t1= str_replace(".jpg","",$t);
        $t1 = explode("/",$t1);
        
        if($do=='+'){
        	$tmp= intval(end($t1))+$val;
            }
        if($do=='-'){
        	$tmp= intval(end($t1))-$val;
            } 
        
        
        	
        $str = '';
        for ($i = 0; $i < (count($t1)-1); $i++) {
            $str.=$t1[$i];
            $str.="/";
        }
        //$str=substr_replace($str ,"",-1);
        if($do!='dir')
        {
        	$str.="$tmp";
         }
        return $str;
    }


    function CNumber($t,$do,$val)
    {
        $t1= str_replace(".jpg","",$t);
        $t1 = explode("/",$t1);
        
        if($do=='+'){
            $tmp= intval(end($t1))+$val;  
            }
        if($do=='-'){
        	$tmp= intval(end($t1))-$val;
            }
        
        	
        
        return $tmp;
    }

    function extractNum($arr){
      $tmp = [];
      foreach($arr as $el)
      {
          $el=explode('_',$el);
          //echo $el[0];
          array_push($tmp,$el[0]);
       }
    
       $res=array_unique($tmp);
       sort($res);
       #print_r($res);
    
       return $res;
     }
    
    
    function GetImgsByNum($arr, $num){
    	$res=[];
    	foreach($arr as $el)
        {
        $target = "".$num."_";
        if(!(strpos($el,$target) === false))
        {
            //echo "".$el."<br>";
            array_push($res,$el);
        }
        
        }
        return $res;
    }

    function GetNormalChapterList($arr){ 
      function getNumOf($str){ 
          $res=end(explode("/",$str));
          $res = (int) filter_var($res, FILTER_SANITIZE_NUMBER_INT);   
          return $res; 
          } 
     
      $size = sizeof($arr)-1; 
     
      for ($i = $size; $i>=0; $i--) { 
        for ($j = 0; $j<=($i-1); $j++) 
          if (getNumOf($arr[$j])>getNumOf($arr[$j+1])) { 
            $k = $arr[$j]; 
            $arr[$j] = $arr[$j+1]; 
            $arr[$j+1] = $k; 
          } 
      } 
      return $arr; 
    } 

    if (isset($_GET['book'])) {
            echo "<h1> ".$_GET['book']." </h1>";
            $maindir='/root/GDZStoler-php/Content';
      
      
            $fileList = glob("$maindir/".$_GET['book']."/*");
            filelist_out_btn($fileList);
            
        }
      if (isset($_GET['cbook'])) {
            echo "<h1> ".$_GET['cbook']." </h1>";
            $maindir='/root/GDZStoler-php/Content';
      
      
            $fileList = glob("$maindir/".$_GET['cbook']."/*");
            $fileList = GetNormalChapterList($fileList);
            #print_r($fileList);
            filelist_out_chapter($fileList);
            
        }
        if (isset($_GET['img_book'])) {
            echo "<h1> ".$_GET['img_book']." </h1>";
            $maindir='/root/GDZStoler-php/Content';
      
            
            
            DisplayIMGS($_GET['img_book'],2);
            
        }
        if (isset($_GET['s_img'])) {
            echo "<h1> ".$_GET['s_img']." </h1>";
            $name=$_GET['s_img'];
            
            
            echo Alg($_GET['s_img'],"dir",0);

            $dname=Alg($_GET['s_img'],"+",1);
            //print($dname);
            
            
            DisplayIMGS("Content/".Alg($_GET['s_img']."","dir",0),basename($_GET['s_img']));
            //echo "<img src='".$_GET['s_img']."'>";
            echo "<div class='container'>";
          
              if (CNumber($_GET['s_img'],'-',2)>0){
              echo "<a  class='c-btn' href='textbooks.php?s_img=".Alg($_GET['s_img'],"-",2)."'>".CNumber($_GET['s_img'],'-',2)."</a>";
              }
              if (CNumber($_GET['s_img'],'-',1)>0){
              echo "<a  class='c-btn' href='textbooks.php?s_img=".Alg($_GET['s_img'],"-",1)."'>".CNumber($_GET['s_img'],'-',1)."</a>";
              }
              
              echo "<a  class='c-btn' href='textbooks.php?s_img=".Alg($_GET['s_img'],"+",1)."'>".CNumber($_GET['s_img'],'+',1)."</a>";
              echo "<a  class='c-btn' href='textbooks.php?s_img=".Alg($_GET['s_img'],"+",2)."'>".CNumber($_GET['s_img'],'+',2)."</a>
                  </div>";
         
            
        }
          
  ?>
    </div>
    
  </body>
</html>


<!--Display all images from $images Directory-->
    <?php
      function DisplayIMGS($_folder,$num){
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

          $tmp = explode('_',$image);
          if ($num==$tmp[0]){
              if(($imgFileType == 'jpg') || ($imgFileType == 'png') || ($imgFileType == 'JPG'))
        		{
              
        			echo "<img src='".$imagesDirectory."/".$image."' class='img_m'> ";
        		}
          }
      		
      		
          }
      	
          closedir($opendirectory);
      }
    }
    ?>