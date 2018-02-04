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

if(isset($_GET['dat3']))$dat3=$_GET['dat3'];
else $dat3=1;

if($obj==1 && $dat1==1 &&  $dat2==1 && $dat3==1)
exit("Иди погуляй!");
chdir("..");
$cap="";
switch($obj)
{
	case 'ip':
	      $cap="Полный список IP за ".$dat1." ".$dat2." ".$dat3;
	      break;
	case 'os':
	      $cap="Полный список OS за ".$dat1." ".$dat2." ".$dat3;
	      break;

	case 'browser':
	      $cap="Полный список браузеров за ".$dat1." ".$dat2." ".$dat3;
	      break;
	case 'bot':
	      $cap="Полный список сканирующих программ за ".$dat1." ".$dat2." ".$dat3;
	      break;

	case 'search':
	      $cap="Полный список поисковиков за ".$dat1." ".$dat2." ".$dat3;
	      break;

	case 'query':
	      $cap="Полный список ключевых слов за ".$dat1." ".$dat2." ".$dat3;
	      break;

    case 'ref':
	      $cap="Полный список ссылающихся сайтов за ".$dat1." ".$dat2." ".$dat3;
	      break;

	  case 'page':
	      $cap="Полный список просмотренных страниц за ".$dat1." ".$dat2." ".$dat3;
	      break;
}
//Сегодня
echo "<style>
A:Link,A:Visited,A:Active { Color: #0073AA; Text-decoration: none;font-famili:serif; font-size:10pt }
A:Hover{ Color: #0073AA; Text-decoration: underline}
  table {
  	     font-family:'Arial', 'sans-serif';
 	     font-size:9pt;
         color:#696969;

        }
 </style>";

$today=false;
if($dat1==date("Y") && $dat2==date("m") && $dat3==date("j") ) $today=true;
if($today) 	$strpath="us/".$obj.".txt";
else $strpath="stat/".$dat1."/".$dat2."/".$obj."/".$dat3.".txt";
echo "<center><b><font size=2 color=#0080C0>$cap</font></b></center><p></p>";
$content=file($strpath);
echo"<div align=center><div style=\" background-color:#0080C0;  width:400px\">
<TABLE width=400px border=0 cellpadding=2  CELLSPACING=1>";

 $content=array_count_values($content);
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