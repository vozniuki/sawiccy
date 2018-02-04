<?php
 session_start();
$strpath="config/log.txt";
@$f=fopen($strpath, "r");
@$content=file($strpath);
fclose($f);
$n=0;

for($i=0; $i<count($content);$i++)
 {

 	 $content[$i]=trim($content[$i]);
 }

if (session_id()!=$content[2])
 {

if(@$_POST['login']=="" && @$_POST['pasw']==""):
 echo "<meta http-equiv=refresh content='0; url=index.php'>";
 exit();
endif;



@$_POST['login']=trim(@$_POST['login']);
@$_POST['pasw']=trim(@$_POST['pasw']);

if((@$content[0]!=md5(@$_POST['login'])) || (@$content[1]!=md5(@$_POST['pasw'])))
 {

  echo "<meta http-equiv=refresh content='0; url=index.php'>";
  exit();
 }

if (session_id()!=@$_POST['id'])
 {

  echo "<meta http-equiv=refresh content='0; url=index.php'>";
  exit();
 }

//Сохраняем сессию в настройках

//Запись
@$f=fopen($strpath, "w");

fwrite($f,$content[0]."\r\n");
fwrite($f,$content[1]."\r\n");
fwrite($f,session_id());
fclose($f);
}



if(isset($_GET['obj']))$obj=$_GET['obj'];
else $obj=1;

if(isset($_GET['dat1']))$dat1=$_GET['dat1'];
else $dat1=1;

if(isset($_GET['dat2']))$dat2=$_GET['dat2'];
else $dat2=1;

if($obj==1 && $dat1==1 &&  $dat2==1)
exit("Иди погуляй!");

chdir("..");
$cap="";
$per="";
if($dat1==0 && $dat2==0)
  {
    $info=" весь период";
    $per="oll";
  }

if($dat1!=0 && $dat2==0)
   {
     $info=" $dat1 год";
     $per="year";
   }


if($dat1!=0 && $dat2!=0)
  {
    $info="$dat1 $dat2";
    $per="mon";
  }

switch($obj)
{
	case 'ip':
	      $cap="Полный список IP за $info";
	      break;
	case 'os':
	      $cap="Полный список OS за $info";
	      break;

	case 'browser':
	      $cap="Полный список браузеров за $info";
	      break;
	case 'bot':
	      $cap="Полный список сканирующих программ за $info";
	      break;

	case 'search':
	      $cap="Полный список поисковиков за $info";
	      break;

	case 'query':
	      $cap="Полный список ключевых слов за за $info";
	      break;

    case 'ref':
	      $cap="Полный список ссылающихся сайтов за за $info";
	      break;

	  case 'page':
	      $cap="Полный список просмотренных страниц за $info";
	      break;
}

echo "<style>
A:Link,A:Visited,A:Active { Color: #0073AA; Text-decoration: none;font-famili:serif; font-size:10pt }
A:Hover{ Color: #0073AA; Text-decoration: underline}
  table {
  	     font-family:'Arial', 'sans-serif';
 	     font-size:9pt;
         color:#696969;

        }
 </style>";
unset($content);
//Если за месяц
if($per=="mon")
  {

  	$content=file("stat/".$dat1."/".$dat2."/".$obj."/oll.txt");
  	if(file_exists("us/".$obj.".txt"))
  	   {$arr=file("us/".$obj.".txt");
  	     foreach($arr as $line)$content[]=$line;
  	   }
  }

//Если за год

if($per=="year")
 {
   $d=opendir("stat/$dat1");

   while(($mon=readdir($d))!=false)
    {
     unset($prom_arr);
     if($mon =="." || $mon ==".." ) continue;
     $prom_arr=file("stat/$dat1/$mon/$obj/oll.txt");
     foreach($prom_arr as $line)$content[]=$line;


    }
   closedir($d);

 }


//Если за весь период

 if($per=="oll")
 {
   $y=opendir("stat");
     while(($year=readdir($y))!=false)
   {
     if($year =="." || $year ==".." ) continue;
     $m=opendir("stat/$year");
     while(($mon=readdir($m))!=false)
      {
       unset($prom_arr);
       if($mon =="." || $mon ==".." ) continue;
       $prom_arr=file("stat/$year/$mon/$obj/oll.txt");
       foreach($prom_arr as $line)$content[]=$line;


      }
     closedir($m);

   }
   closedir($y);
 }

 //Обработка $ref
 if($obj=="ref")
  {
    $i=0;
    foreach($content as $line)
    {
  	 if($line=="Закладка" || strpos($line,"Робот")!==false)$line=$line;
     elseif(strpos($line,"Запрос")!==false)$line=$line;

     $content[$i]=$line;
     $i++;
    }
  }
 if($_GET['obj']=="query")
    {
    	 //Очищаем от даты
        $y=0;
        foreach($content as $line)
         {
            $stop=strlen($line);
            if(strpos($line,"<font color=#0080C0>")!==false)
               $stop=strpos($line,"<font color=#0080C0>");
         	$line=substr ($line,0,$stop);
         	$line=trim($line);
         	$content[$y]=$line;
         	$y++;
         }
    }
 $content=array_count_values($content);

echo "<center><b><font size=2 color=#0080C0>$cap всего ".count($content)." </font></b></center><p></p>";

echo"<div align=center><div style=\" background-color:#0080C0;  width:400px\">
<TABLE width=400px border=0 cellpadding=2  CELLSPACING=1>";


 arsort($content);
 foreach($content as $k=>$v)
  {
   if($obj=="ref")
     {   $k=trim($k);
         echo "<tr bgcolor=#ffffff>";
     	  if($k=="Закладка" || strpos($k,"Робот")!==false)echo "<td>$k</td>";
              elseif(strpos($k,"Запрос")!==false)echo "<td>$k</td>";
              else  echo "<td><a href=$k>$k</a></td>";
              echo"</td> <td>$v</td></tr>";
               echo "</tr>";
     }
   else
   echo "<tr bgcolor=#ffffff><td>$k </td> <td>$v</td></tr>";
  }

 echo "</table></div>";


?>