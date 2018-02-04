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



if(isset($_GET['ip']))$ip=$_GET['ip'];
else exit("Иди погуляй!");
chdir("..");
//Получаем информацию


  $i=0;
  $n=0;
  //Открыли stat
  $stat=opendir("stat");
  while(($year=readdir($stat))!=false)
   {
    if($year =="." || $year =="..") continue;
    //Открыли год
      $m=opendir("stat/$year");

      while(($mon=readdir($m))!=false)
       {

          if($mon =="." || $mon =="..") continue;
          //Открыли месяц
          $d=opendir("stat/$year/$mon/oll");
            while(($day=readdir($d))!=false)
             {
                if($day =="." || $day =="..") continue;
                $str= "stat/$year/$mon/oll/$day";
                $f=file($str);
                foreach($f as $line)
                 {
                    $line=trim($line);
                    $day=str_replace(".txt","",$day);
                 	$expl_ip=explode("|",$line);
                 	if($expl_ip[1]==$ip)$arr_ip[]=$line."|".$day.".".$mon.".".$year;
                 }
             }
           closedir($d);
       }
       closedir($m);

   }

   closedir($stat);
  //Сегодня
  if(file_exists("us/today.txt"))
   {
    $f=file("us/today.txt");
    foreach($f as $line)
                 {
                    $line=trim($line);
                 	$expl_ip=explode("|",$line);
                 	if($expl_ip[1]==$ip)$arr_ip[]=$line."|".date("j.m.Y");
                 }

   }
 if(@$_POST['search'])
  {
     echo "<b>Информацию предоставили сервера:</b><br>";
  	echo whois("whois.arin.net",$ip);


    $path="temp";
   if(file_exists($path))
   {
   @$f=fopen("temp",r);

   $stop=fread($f, filesize("temp"));
   fclose($f);

  $stop_list=explode("|", $stop);

    foreach ($stop_list as $line)
    {
      $line=trim($line);

      if(preg_match("|address:|i", $line)) $adr[]= str_replace("address:"," ",$line);
      if(preg_match("|e-mail:|i", $line)) $mail[]=str_replace("e-mail:"," ",$line);
      if(preg_match("|phone:|i", $line)) $phon[]=str_replace("phone:"," ",$line);
      if(preg_match("|netname:|i", $line)) $name[]=str_replace("netname:"," ",$line);
      if(preg_match("|abuse-mailbox:|i", $line)) $mail[]=str_replace("abuse-mailbox:"," ",$line);
      if(preg_match("|person:|i", $line)) $per[]=str_replace("person:"," ",$line);

    }

     echo "<b>Название</b><br>";
     if (count(@$name)!=0) foreach ($name as $line)echo $line."<br>";
     else echo "Нет данных<br>";

     echo "<br><b>Адреса</b><br>";
     if (count(@$adr)!=0) foreach ($adr as $line)echo $line."<br>";
     else echo "Нет данных<br>";

     echo "<br><b>Телефоны</b><br>";
     if (count(@$phon)!=0) foreach ($phon as $line) echo $line."<br>";
     else echo "Нет данных<br>";

     echo "<br><b>Контактные лица</b><br>";
     if (count(@$per)!=0) foreach ($per as $line) echo $line."<br>";
     else echo "Нет данных<br>";

     echo "<br><b>E-mail</b><br>";
     if (count(@$mail)!=0) foreach ($mail as $line)echo $line."<br>";
     else echo "Нет данных<br>";
    }
   else
   echo "Данных не получено";
  }

 function whois($url,$ip)
    {
    // Соединение с сокетом TCP, ожидающим на сервере "whois.arin.net" по
    // 43 порту. В результате возвращается дескриптор соединения $sock.
    $sock = fsockopen($url, 43, $errno, $errstr);
    if (!$sock) exit("$errno($errstr)");
    else
    {
      echo $url."<br>";
      // Записываем строку из переменной $_POST["ip"] в дескриптор сокета.
      fputs ($sock, $ip."\r\n");
      // Осуществляем чтение из дескриптора сокета.
      $text = "";
      while (!feof($sock))
      {
        $text .= fgets ($sock, 128)."<br>";

      }
      // закрываем соединение

        fclose ($sock);
        $str=str_replace("<br>","|",$text);
        @$f=fopen("temp","w+");
        fwrite($f,$str);
        fclose($f);

      // Ищем реферальный сервере
      $pattern = "|ReferralServer: whois://([^\n<:]+)|i";
      preg_match($pattern, $text, $out);
      if(!empty($out[1])) return whois($out[1], $ip);
     // else return $text;
    }
   }

?>

<form action="ip.php?ip=<? echo $_GET['ip'] ?>" method="post">
     <input type="submit" value="Найти провайдера" name='search'>
</form>
<html>
<body>
<h3><font color=#0073AA >Информация по IP <?php echo $ip; ?></font> </h3>

<?php
echo "<font size=2><b>";
if(!count(@$arr_ip)) echo "Всего посещений 0";
else echo "Всего посещений ".count($arr_ip);
echo "</b></font>";
?>
<style>
A:Link,A:Visited,A:Active { Color: #0073AA; Text-decoration: none;font-famili:serif; font-size:10pt }
A:Hover{ Color: #0073AA; Text-decoration: underline}
  table {
  	     font-family:'Arial', 'sans-serif';
 	     font-size:9pt;
         color:#696969;

        }
 </style>


<div style="background-color:#0080C0;  width:800px">
<TABLE width=800px border=0 cellpadding=2  CELLSPACING=1>
<TR >

 	<td ><b><font color=#ffffff>Дата</font></b></td>
 	 <td><b><font color=#ffffff>Ссылающиеся сайты</font></b></td>
 	<td><b><font color=#ffffff>Браузер</font></b></td><td><b><font color=#ffffff>OS</font></b></td>
 	<td><b><font color=#ffffff>Страницы</font></b></td>

 	</tr>
<?php
if(!count(@$arr_ip)) exit("</table></div>Данных нет");
  foreach($arr_ip as $line)
   {
      echo"<tr bgcolor=#ffffff>";

  $expl=explode("|",$line);
  $expl_page=explode("*",$expl[5]);
  $n=0;
   foreach($expl as $line1)
    {

        if($n==6)break;
    	if ($n==0)
       {
        $time_out="";
        if(isset($expl[7]))
           {
           	  $get_date1=getdate($expl[6]);
              //Изменяем время
              if(strlen($get_date1['hours'])==1)$get_date1['hours']="0".$get_date1['hours'];
              if(strlen($get_date1['minutes'])==1)$get_date1['minutes']="0".$get_date1['minutes'];
              $time_out=" - $get_date1[hours]:$get_date1[minutes]";
              $d=$expl[7];
           }
          else $d=$expl[6];
        $get_date=getdate($expl[0]);
        //Изменяем время
        if(strlen($get_date['hours'])==1)$get_date['hours']="0".$get_date['hours'];
        if(strlen($get_date['minutes'])==1)$get_date['minutes']="0".$get_date['minutes'];
        echo "<td>".$d."<br>".$get_date['hours'].":".$get_date['minutes'].@$time_out."</td>";

       }
       elseif($n==5)
       {
       	 $expl1=explode("*",$expl[5]);
       	 echo "<td>";
       	 foreach($expl1 as $line2)
       	  {
       	  	echo "$line2<br>";
       	  }

       	 echo "</td>";
       }


       elseif($n==2)
       {
         if($expl[2]=="Закладка" || strpos($expl[2],"Робот")!==false ||
         $expl[2]=="Неопознанная сканирующая программа")echo "<td>$expl[2]</td>";
         elseif(strpos($expl[2],"yandex"))echo "<td>Запрос с <a href='http://www.yandex.ru'>Яндекс</a></td>";
         elseif(strpos($expl[2],"aport"))echo "<td>Запрос с <a href='http://www.aport.ru'>Апорт</a></td>";
         elseif(strpos($expl[2],"rambler"))echo "<td>Запрос с <a href='http://www.rambler.ru'>Ремблер</a></td>";
         elseif(strpos($expl[2],"mail") && strpos($expl[2],"search"))echo
          "<td>Запрос с <a href='http://www.mail.ru'>Mail.ru</a></td>";
         elseif(strpos($expl[2],"msn") && strpos($expl[2],"results"))echo "<td>Запрос с <a href='http://www.msn.com'>MSN</a></td>";
         elseif(strpos($expl[2],"yahoo"))echo "<td>Запрос с <a href='http://www.yahoo.com'>Yahoo</a></td>";
         elseif(strpos($expl[2],"google"))echo "<td>Запрос с <a href='http://www.google.com'>Google</a></td>";

         else  echo "<td><a href=$expl[2]>$expl[2]</a></td>";
       }


       elseif($n==3 || $n==4)
        {
        echo "<td>$expl[$n]</td>";
        }
    	$n++;
    }


 }
echo "</tr>";
?>

</table></div>
</body>
</html>