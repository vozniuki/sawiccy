<?php
function access1($f)
 {
   for($i=0;$i<10;$i++)
    {
       if(flock($f,LOCK_EX)) break;
       else sleep(1);
    }

 }
//Настройки=================================
$i=0;
$strpath="user_count/admin/config/conf.txt";
$conf=file($strpath);

for($i=0; $i<count($conf);$i++) $conf[$i]=trim($conf[$i]);
//Текущая статистика=====================================================

//--------------Сегодня------------------------


    //Реферер
     $ref="";
     if(!empty($_SERVER['HTTP_REFERER']) && !strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])) $ref=$_SERVER['HTTP_REFERER'];
     else $ref='Закладка';

     // Определяем строку USER_AGENT

      $useragent = @$_SERVER['HTTP_USER_AGENT'];
      $browser = "";
      $bot = "";
      $search="";
      $os="";
      $quer="";
      $ip="";
      $ip=$_SERVER['REMOTE_ADDR'];

      //Поисковики
      if(strpos($ref,"webalta")) $search = 'webalta.ru';
      if(strpos($ref,"nigma.ru")) $search = 'nigma.ru';
      if(strpos($ref,"poisk.ru")) $search = 'poisk.ru';
      if(strpos($ref,"metabot")) $search = 'metabot.ru';
      if(strpos($ref,"go.km")) $search = 'go.km';
      if(strpos($ref,"mail.ru") && strpos($ref,"search"))   $search = 'Mail.ru';
      if(strpos($ref,"msn") && strpos($ref,"results"))   $search = 'MSN';
      if(strpos($ref,"rambler")) $search = 'Ремблер';
      if(strpos($ref,"aport"))   $search = 'Апорт';
      if(strpos($ref,"yahoo"))   $search = 'Yahoo';
      if(strpos($ref,"yandex"))  $search = 'Яндекс';
      if(strpos($ref,"google"))  $search = 'Google';
      if(strpos($ref,"go.km"))  $search = 'km.ru';

       $server_name = $_SERVER["SERVER_NAME"];
      if(substr($_SERVER["SERVER_NAME"],0,4) == "www.") $server_name = substr($_SERVER["SERVER_NAME"],4);
      if(strpos($ref,$server_name)) $search = 'own_site';
      //Поисковые запросы
      if(!empty($ref) && $search!="" && $search != "own_site")
    {
       switch($search)
       {

          case 'webalta':
         {
           eregi("q=([^&]*)", $ref."&", $query);
           $quer = utf8_win($query[1]);
            $quer.="&nbsp;&nbsp;<font color=#0080C0>webalta.ru&nbsp;&nbsp;".date("H:i")."</font>";
           break;
         }

         case 'nigma.ru':
         {
           eregi("s=([^&]*)", $ref."&", $query);
           $quer = utf8_win($query[1]);
            $quer.="&nbsp;&nbsp;<font color=#0080C0>nigma.ru&nbsp;&nbsp;".date("H:i")."</font>";
           break;
         }

        case 'poisk.ru':
         {
             eregi("text=([^&]*)", $ref."&", $query);
             $quer = $query[1];
             $quer=urldecode($quer);
             $quer.="&nbsp;&nbsp;<font color=#0080C0>poisk.ru&nbsp;&nbsp;".date("H:i")."</font>";
             break;
         }

         case 'metabot.ru':
         {
             eregi("st=([^&]*)", $ref."&", $query);
             $quer = $query[1];
             $quer=urldecode($quer);
             $quer.="&nbsp;&nbsp;<font color=#0080C0>metabot.ru&nbsp;&nbsp;".date("H:i")."</font>";
             break;
         }
          case 'go.km':
         {
             eregi("sq=([^&]*)", $ref."&", $query);
             $quer = $query[1];
             $quer=urldecode($quer);
             $quer.="&nbsp;&nbsp;<font color=#0080C0>go.km&nbsp;&nbsp;".date("H:i")."</font>";
             break;
         }
          case 'Yahoo':
         {
             eregi("p=([^&]*)", $ref."&", $query);
             $quer = utf8_win($query[1]);
             $quer.="&nbsp;&nbsp;<font color=#0080C0>Yahoo&nbsp;&nbsp;".date("H:i")."</font>";
             break;
         }

         case 'Яндекс':
         {
             eregi("text=([^&]*)", $ref."&", $query);
             $quer = utf8_win($query[1]);

               $quer.="&nbsp;&nbsp;<font color=#0080C0>Яндекс&nbsp;&nbsp;".date("H:i")."</font>";
           break;
         }
         case 'Ремблер':
         {
           eregi("words=([^&]*)", $ref."&", $query);
           $quer = $query[1];
           $quer=urldecode($quer);
           $quer.="&nbsp;&nbsp;<font color=#0080C0>Ремблер&nbsp;&nbsp;".date("H:i")."</font>";
           break;
         }
         case 'Mail.ru':
         {
           eregi("q=([^&]*)", $ref."&", $query);
           $quer = $query[1];
           $quer=urldecode($quer);
           $quer.="&nbsp;&nbsp;<font color=#0080C0>Mail.ru&nbsp;&nbsp;".date("H:i")."</font>";
           break;
         }
         case 'Google':
         {
           eregi("q=([^&]*)", $ref."&", $query);
           $quer = utf8_win($query[1]);
            $quer.="&nbsp;&nbsp;<font color=#0080C0>Google&nbsp;&nbsp;".date("H:i")."</font>";
           break;
         }
         case 'MSN':
         {
           eregi("q=([^&]*)", $ref."&", $query);
           $quer = utf8_win($query[1]);
           $quer.="&nbsp;&nbsp;<font color=#0080C0>MSN&nbsp;&nbsp;".date("H:i")."</font>";
           break;
         }
         case 'Апорт':
         {
           eregi("r=([^&]*)", $ref."&", $query);
           $quer = $query[1];
           $quer=urldecode($quer);
           $quer.="&nbsp;&nbsp;<font color=#0080C0>Апорт&nbsp;&nbsp;".date("H:i")."</font>";
           break;
         }
        }//конец для switch
        $symbols = array("\"", "'", "(", ")", "+", ",", "-");
        $quer = str_replace($symbols, " ", $quer);
        $quer = trim($quer);
        $quer = preg_replace('|[\s]+|',' ',$quer);
        $quer=rawurldecode($quer);
    }

      // Выясняем браузер
      if(strpos($useragent, "Mozilla") !== false) $browser = 'Mozilla';

      if(strpos($useragent, "MSIE")    !== false) $browser = 'MS Internet Explorer';
      if(strpos($useragent, "MSIE 7.0")    !== false) $browser = 'MS Internet Explorer 7.0';
      if(strpos($useragent, "MSIE 6.0")    !== false) $browser = 'MS Internet Explorer 6.0';
      if(strpos($useragent, "MSIE 5.5")    !== false) $browser = 'MS Internet Explorer 5.5';
      if(strpos($useragent, "MSIE 5.0" )    !== false) $browser = 'MS Internet Explorer 5.0';

      if(strpos($useragent, "MyIE")    !== false) $browser = 'Maxthon IE';
      if(strpos($useragent, "MyIE2")    !== false) $browser = 'Maxthon IE 2';
      if(strpos($useragent, "Maxthon")    !== false) $browser = 'Maxthon IE';

      if(strpos($useragent, "Opera")   !== false) $browser = 'Opera';
      if(strpos($useragent, "Opera/9.00")   !== false) $browser = 'Opera 9.0';
      if(strpos($useragent, "Opera/9.20")   !== false) $browser = 'Opera 9.20';
      if(strpos($useragent, "Opera/9.10")   !== false) $browser = 'Opera 9.10';
      if(strpos($useragent, "Opera/8.54")   !== false) $browser = 'Opera 8.54';

      if(strpos($useragent, "Netscape")!== false) $browser = 'Netscape';

      if(strpos($useragent, "Firefox") !== false) $browser = 'Firefox';
      if(strpos($useragent, "Firefox/2.0.0.3") !== false) $browser = 'Firefox 2.0.0.3';
      if(strpos($useragent, "Firefox/1.5.0.11") !== false) $browser = 'Firefox 1.5.0.11';
      if(strpos($useragent, "Firefox/1.0.2") !== false) $browser = 'Firefox 1.0.2';
      if(strpos($useragent, "Firefox/0.10") !== false) $browser = 'Firefox 0.10';
      if(strpos($useragent, "Firefox/2.0") !== false) $browser = 'Firefox 2.0';
      if(strpos($useragent, "Firefox/1.0.6") !== false) $browser = 'Firefox 1.0.6';

      if(strpos($useragent, "GranParadiso") !== false) $browser = 'GranParadiso';

      if ($browser=="")$browser="Неизвестно";
      // Выясняем операционную систему
      if(strpos($useragent, "Windows")!== false) $os = 'Windows';
      if(strpos($useragent, "Windows 95")!== false) $os = 'Windows 95';
      if(strpos($useragent, "Windows CE")!== false) $os = 'Windows CE';
      if(strpos($useragent, "Windows NT 6.0")!== false) $os = 'Windows Vista';
      if(strpos($useragent, "Windows NT 5.0")!== false) $os = 'Windows 2000';
      if(strpos($useragent, "Windows NT 5.1")!== false) $os = 'Windows XP';
      if(strpos($useragent, "Windows 98")!== false) $os = 'Windows 98';
      if(strpos($useragent, "Linux")    !== false
      || strpos($useragent, "Lynx")     !== false
      || strpos($useragent, "Unix")     !== false) $os = 'unix';
      if(strpos($useragent, "Macintosh")!== false) $os = 'macintosh';
      if(strpos($useragent, "PowerPC")  !== false) $os = 'macintosh';
      if ($os=="")$os="Неизвестно";




        // Выясняем принадлежность к поисковым роботам
      if(strpos($useragent, "StackRambler") !== false) $bot = 'Робот-поисковик Rambler';
      if(strpos($useragent, "Googlebot")    !== false) $bot = 'Робот-поисковик Google';
      if(strpos($useragent, "Mediapartners-Google")    !== false) $bot = 'Робот-поисковик Google';
      if(strpos($useragent, "Yandex")       !== false) $bot = 'Робот-поисковик Yandex';
      if(strpos($useragent, "Aport")        !== false) $bot = 'Робот-поисковик Aport';
      if(strpos($useragent, "msnbot")       !== false) $bot = 'Робот-поисковик MSN';
      if(strpos($useragent, "Mail.Ru")       !== false) $bot = 'Робот-поисковик Mail.ru ';
      if(strpos($useragent, "Yahoo!")       !== false) $bot = 'Робот-поисковик Yahoo';
      if(strpos($useragent, "OmniExplorer_Bot")       !== false) $bot = 'OmniExplorer_Bot';
      if(strpos($useragent, "WebAlta")       !== false) $bot = 'Робот-поисковик WebAlta';

      include('modul.php');

      //Записываем лог
      $log=time()."*".$ip."*".$useragent;
      //Определяем возможность неизвестного бота
      //Если ничего неизвестно, вероятно какой-то бот
      if(strpos($useragent, "bot")!== false && $bot=="" && $os=="Неизвестно" && $ref=="Закладка" && $browser=="Неизвестно")
      $bot="Неопознанная сканирующая программа";


       //Разрешён ли доступ
     if(file_exists("user_count/stop.txt"))
      {

       $stop_agent=file("user_count/stop.txt");
       $out=false;
       foreach($stop_agent as $line)
         {
         	$expl_agent=explode("|",$line);
            if($expl_agent[0]=="ip")
               if($ip==$expl_agent[1])
                 {
                 	$out=true;
                 	break;
                 }
             if($expl_agent[0]=="url")
               if($ref==$expl_agent[1])
                 {
                 	$out=true;
                 	break;
                 }
             if($expl_agent[0]=="id")
               if(strpos($useragent, $expl_agent[1])!== false)
                 {
                 	$out=true;
                 	break;
                 }
         }

         //Если нашли

         if($out)
           {
           	 $expl_agent[3]=trim($expl_agent[3]);
             if($expl_agent[3]=="stop")exit($expl_agent[2]);
             if($expl_agent[3]=="ref")
               {
                     echo "<meta http-equiv=refresh content='0; url=".$expl_agent[2]."'>";
                     exit();
               }
             if($expl_agent[3]=="return")
                if($ref!="Закладка")
                  {
                    echo "<meta http-equiv=refresh content='0; url=".$ref."'>";
                    exit();
                  }
                else
                  {
                  	exit();
                  }
           }


      }

      //Если с поисковиков-переделаем реф
      if(strpos($ref,"webalta"))$ref= "Запрос с <a href='http://www.webalta.ru'>webalta.ru</a>";
      if(strpos($ref,"nigma.ru"))$ref= "Запрос с <a href='http://www.nigma.ru'>nigma.ru</a>";
      if(strpos($ref,"poisk.ru"))$ref= "Запрос с <a href='http://www.poisk.ru'>poisk.ru</a>";
      if(strpos($ref,"metabot"))$ref= "Запрос с <a href='http://www.metabot.ru'>metabot.ru</a>";
      if(strpos($ref,"go.km"))$ref= "Запрос с <a href='http://www.go.km.ru'>go.km</a>";
      if(strpos($ref,"yandex"))$ref= "Запрос с <a href='http://www.yandex.ru'>Яндекс</a>";
      if(strpos($ref,"aport"))$ref= "Запрос с <a href='http://www.aport.ru'>Апорт</a>";
      if(strpos($ref,"rambler"))$ref= "Запрос с <a href='http://www.rambler.ru'>Ремблер</a>";
      if(strpos($ref,"mail.ru") && strpos($ref,"search"))$ref="Запрос с <a href='http://www.mail.ru'>Mail.ru</a>";
      if(strpos($ref,"msn") && strpos($ref,"results"))$ref= "Запрос с <a href='http://www.msn.com'>MSN</a>";
      if(strpos($ref,"yahoo"))$ref= "Запрос с <a href='http://www.yahoo.com'>Yahoo</a>";
      if(strpos($ref,"google"))$ref= "Запрос с <a href='http://www.google.com'>Google</a>";

$sess_search=false;
$strpath="user_count/us/today.txt";
//Если файл есть
  if (file_exists($strpath))
  {
    $arr_user_count=file($strpath);
    $n=0;
    $pos=0;
    $new_val="";
    foreach($arr_user_count as $line)
    {
      $line=trim($line);
      $arr_user_countexp=explode("|", $line);

      //Если уже завтра, переписываем файл
      $d=getdate( $arr_user_countexp[0]);
      //Если не равны-значит уже завтра
      if ($d['mday']!=date("j"))
         {
              //Формируем дату для копирования
              if(strlen($d["mon"])==1)$d["mon"]="0".$d["mon"];
             //Проверяем, есть ли папка с годом и месяцем
             //Если нет-создадим
             if(!file_exists("user_count/stat/".date("Y"))) mkdir("user_count/stat/".date("Y"));
             if(!file_exists("user_count/stat/".date("Y")."/".date("m")))
                {
                	 mkdir("user_count/stat/".date("Y")."/".date("m"));
                	 mkdir("user_count/stat/".date("Y")."/".date("m")."/page");
                	 mkdir("user_count/stat/".date("Y")."/".date("m")."/oll");
                	 mkdir("user_count/stat/".date("Y")."/".date("m")."/ip");
                	 mkdir("user_count/stat/".date("Y")."/".date("m")."/ref");
                	 mkdir("user_count/stat/".date("Y")."/".date("m")."/bot");
                	 mkdir("user_count/stat/".date("Y")."/".date("m")."/os");
                	 mkdir("user_count/stat/".date("Y")."/".date("m")."/search");
                	 mkdir("user_count/stat/".date("Y")."/".date("m")."/browser");
                     mkdir("user_count/stat/".date("Y")."/".date("m")."/query");
                     mkdir("user_count/stat/".date("Y")."/".date("m")."/log");
                }
             //Велась ли раньше статистика? Если нет-создаём каталоги
             if(!file_exists("user_count/stat/".$d["year"]."/".$d["mon"]."/oll"))
                {
                     mkdir("user_count/stat/".$d["year"]."/".$d["mon"]);
                	 mkdir("user_count/stat/".$d["year"]."/".$d["mon"]."/page");
                	 mkdir("user_count/stat/".$d["year"]."/".$d["mon"]."/oll");
                	 mkdir("user_count/stat/".$d["year"]."/".$d["mon"]."/ip");
                	 mkdir("user_count/stat/".$d["year"]."/".$d["mon"]."/ref");
                	 mkdir("user_count/stat/".$d["year"]."/".$d["mon"]."/bot");
                	 mkdir("user_count/stat/".$d["year"]."/".$d["mon"]."/os");
                	 mkdir("user_count/stat/".$d["year"]."/".$d["mon"]."/search");
                	 mkdir("user_count/stat/".$d["year"]."/".$d["mon"]."/browser");
                     mkdir("user_count/stat/".$d["year"]."/".$d["mon"]."/query");
                     mkdir("user_count/stat/".$d["year"]."/".$d["mon"]."/log");
                }

             //Копируем с полным отчётом
             copy($strpath,"user_count/stat/".$d["year"]."/".$d["mon"]."/oll/".$d['mday'].".txt");
             //Начинаем новую запись
         	 $f=fopen($strpath,'w+');
         	 access1($f);
         	 if($bot)fwrite($f,time()."|".$ip."|".$bot."|".""."|".""."|".$_SERVER['PHP_SELF']."|".time()."\r\n");
             else fwrite($f,time()."|".$ip."|".$ref."|".$browser."|".
             $os."|".$_SERVER['PHP_SELF']."|".time()."\r\n");
             flock($f,LOCK_UN);
             fclose($f);
             @$sess_search=true;
              //Общая статистика
             statist($obj="page",$dat=$d['mday'],$dat1=$d['mon'],$dat2=$d['year']);
             statist($obj="ip",$dat=$d['mday'],$dat1=$d['mon'],$dat2=$d['year']);
             statist($obj="ref",$dat=$d['mday'],$dat1=$d['mon'],$dat2=$d['year']);
             statist($obj="bot",$dat=$d['mday'],$dat1=$d['mon'],$dat2=$d['year']);
             statist($obj="browser",$dat=$d['mday'],$dat1=$d['mon'],$dat2=$d['year']);
             statist($obj="os",$dat=$d['mday'],$dat1=$d['mon'],$dat2=$d['year']);
             statist($obj="search",$dat=$d['mday'],$dat1=$d['mon'],$dat2=$d['year']);
             statist($obj="query",$dat=$d['mday'],$dat1=$d['mon'],$dat2=$d['year']);
             statist($obj="log",$dat=$d['mday'],$dat1=$d['mon'],$dat2=$d['year']);

          if($bot=="")
           {
             statist1($obj="page",$obj1=$_SERVER['PHP_SELF']);
             statist1($obj="ref",$obj1=$ref);
             statist1($obj="browser",$obj1=$browser);
             statist1($obj="os",$obj1=$os);
           }
             statist1($obj="ip",$obj1=$ip);
             statist1($obj="log",$obj1=$log);
            if($bot!="") statist1($obj="bot",$obj1=@$bot);

            if($search) statist1($obj="search",$obj1=@$search);
            if($quer )statist1($obj="query",$obj1=@$quer);
             break;
         }

      //Если ip есть, но прошло больше контрольного времени-
      //считаем за следующее посещение, меньше-дописываем страницы


        if ( ($arr_user_countexp[1]==$ip) && ( (time() - $arr_user_countexp[0]) < (60 *$conf[31]))   )
         {

           $pos=$n;
           @$sess_search=true;
           //Если не перегрузили страницу
           $arr_user_pageexp= explode("*",$arr_user_countexp[5]);

           if(trim($arr_user_pageexp[count($arr_user_pageexp)-1])!=$_SERVER['PHP_SELF'])
            {
              $arr_user_countexp[5].="*".$_SERVER['PHP_SELF'];
              $new_val=$arr_user_countexp[0]."|".$arr_user_countexp[1]."|".$arr_user_countexp[2]."|".$arr_user_countexp[3]."|".
              $arr_user_countexp[4]."|".$arr_user_countexp[5]."|".time();
              statist1($obj="page",$obj1=$_SERVER['PHP_SELF']);
            }
           break;

         }

         $n++;

    }

    //Дописываем, если $new_val инициализирован

     if($new_val!=="")
        {
          $n=0;
          @$f=fopen($strpath,'w+');
          access1($f);
           foreach($arr_user_count as $line)
            {
              if($n!=$pos)fwrite($f,$line);
              else fwrite($f,$new_val."\r\n");
              $n++;

            }
            flock($f,LOCK_UN);
            fclose($f);
        }

      //Если ip не найдено, записываем
      if (!$sess_search)
         {
         	 @$f=fopen($strpath,'a');
         	 access1($f);
         	 if($bot)fwrite($f,time()."|".$ip."|".$bot."|".""."|".""."|".$_SERVER['PHP_SELF']."|".time()."\r\n");
             else fwrite($f,time()."|".$ip."|".$ref."|".$browser."|".
             $os."|".$_SERVER['PHP_SELF']."|".time()."\r\n");
             flock($f,LOCK_UN);
             fclose($f);

            if($bot=="")
           {
             statist1($obj="page",$obj1=$_SERVER['PHP_SELF']);
             statist1($obj="ref",$obj1=$ref);
             statist1($obj="browser",$obj1=$browser);
             statist1($obj="os",$obj1=$os);
           }
             statist1($obj="ip",$obj1=$ip);
             statist1($obj="log",$obj1=$log);
            if($bot!="") statist1($obj="bot",$obj1=@$bot);

            if($search) statist1($obj="search",$obj1=@$search);
            if($quer )statist1($obj="query",$obj1=@$quer);
         }


  }

//Если нет
else
 {
	 $f=fopen($strpath,'w+');
	 access1($f);
   if($bot)fwrite($f,time()."|".$ip."|".$bot."|".""."|".""."|".$_SERVER['PHP_SELF']."|".time()."\r\n");
    else fwrite($f,time()."|".$ip."|".$ref."|".$browser."|".
                $os."|".$_SERVER['PHP_SELF']."|".time()."\r\n");
     flock($f,LOCK_UN);
     fclose($f);
  if($bot=="")
           {
             statist1($obj="page",$obj1=$_SERVER['PHP_SELF']);
             statist1($obj="ref",$obj1=$ref);
             statist1($obj="browser",$obj1=$browser);
             statist1($obj="os",$obj1=$os);
           }
             statist1($obj="ip",$obj1=$ip);
             statist1($obj="log",$obj1=$log);
            if($bot!="") statist1($obj="bot",$obj1=@$bot);

            if($search) statist1($obj="search",$obj1=@$search);
            if($quer )statist1($obj="query",$obj1=@$quer);
 }
 unset($arr_user_count);
//-----ONLINE---------------------------------------------

//Регистрация: если файл есть, забираем в массив.
//Если ip такой есть, обновляем время в массиве,
//Если нет, добавляем в массив
$i=0;

//===========================================

$strpath="user_count/us/online.txt";
if (file_exists($strpath))
 {

   $arr_user_count=file($strpath);

   //Очищаем от старых ip и обновляем время
   foreach($arr_user_count as $line)
   {
     $dat_file=explode("|", @$line);
     if( ($dat_file[0]==$ip) || ($dat_file[1]< (time()-60 * $conf[31]) ) )continue;
     $online[$i]=$line;
     $i++;

   }

   //Добавляем новый ip
   $newip=$ip."|".time()."\r\n";
   $online[]=$newip;

   //Записываем
     $f=fopen($strpath,'w+');
     access1($f);
     foreach($online as $line)
     {
      fwrite($f,$line);
     }
      flock($f,LOCK_UN);
      fclose($f);
     $dbOnline=count($online);

 }
else
  {
      $f=fopen($strpath,'w+');
      access1($f);
      fwrite($f,$ip."|".time()."\r\n");
      flock($f,LOCK_UN);
      fclose($f);
      $dbOnline=1;
  }


//-----------------Общий файл------------------
$strpath="user_count/us/oll.txt";
if(filesize($strpath)==0)
 {
 	$f=fopen($strpath,"w");
 	fwrite($f,"0");
 	fclose($f);
 }

if (file_exists($strpath))
 {
     //Не был ли сегодня

     if (!$sess_search)
      {
      	 @$f=fopen($strpath,'r');
         $dbOll=fread($f, filesize($strpath));
         fclose($f);
         @$f=fopen($strpath,'w+');
         access1($f);
         fwrite($f,++$dbOll);
         flock($f,LOCK_UN);
         fclose($f);
      }

 }
else
 {
     @$f=fopen($strpath,'w+');
     access1($f);
     fwrite($f,'1');
     flock($f,LOCK_UN);
     fclose($f);
     $dbOll=1;
 }


function statist($obj,$dat,$dat1,$dat2)
 {
   $i=0;
   if(strlen($dat1)==1)$dat1="0".$dat1;
   $strpath="user_count/us/".$obj.".txt";
  if (file_exists($strpath))
   {

      //Копируем для отчёта на день
      copy($strpath,"user_count/stat/".$dat2."/".$dat1."/".$obj."/".$dat.".txt");

      if($obj!="log")
     {
      //Перегружаем в общий файл
      $arr_page=file($strpath);
      if(file_exists("user_count/stat/".$dat2."/".$dat1."/".$obj."/oll.txt"))
        {

          $f=fopen("user_count/stat/".$dat2."/".$dat1."/".$obj."/oll.txt","a");
          access1($f);
        }
      else
        {
       	  $f=fopen("user_count/stat/".$dat2."/".$dat1."/".$obj."/oll.txt","w+");
          access1($f);
        }

       foreach($arr_page as $line)
           {

           	fwrite($f,$line);

           }
          flock($f,LOCK_UN);
          fclose($f);
     }
          unlink($strpath);


   }

 }

function statist1($obj,$obj1)
 {
   $strpath="user_count/us/".$obj.".txt";
   if(!file_exists($strpath))$f=fopen($strpath,"w+");
   else $f=fopen($strpath,"a");
   access1($f);
   fwrite($f,$obj1."\r\n");
   flock($f,LOCK_UN);
   fclose($f);

 }

function utf8_win($s)
{
    $s=str_replace("%D0%B0","а",$s);  $s=str_replace("%D0%90","А",$s);
    $s=str_replace("%D0%B1","б",$s);  $s=str_replace("%D0%91","Б",$s);
    $s=str_replace("%D0%B2","в",$s);  $s=str_replace("%D0%92","В",$s);
    $s=str_replace("%D0%B3","г",$s);  $s=str_replace("%D0%93","Г",$s);
    $s=str_replace("%D0%B4","д",$s);  $s=str_replace("%D0%94","Д",$s);
    $s=str_replace("%D0%B5","е",$s);  $s=str_replace("%D0%95","Е",$s);
    $s=str_replace("%D1%91","ё",$s);  $s=str_replace("%D0%81","Ё",$s);
    $s=str_replace("%D0%B6","ж",$s);  $s=str_replace("%D0%96","Ж",$s);
    $s=str_replace("%D0%B7","з",$s);  $s=str_replace("%D0%97","З",$s);
    $s=str_replace("%D0%B8","и",$s);  $s=str_replace("%D0%98","И",$s);
    $s=str_replace("%D0%B9","й",$s);  $s=str_replace("%D0%99","Й",$s);
    $s=str_replace("%D0%BA","к",$s);  $s=str_replace("%D0%9A","К",$s);
    $s=str_replace("%D0%BB","л",$s);  $s=str_replace("%D0%9B","Л",$s);
    $s=str_replace("%D0%BC","м",$s);  $s=str_replace("%D0%9C","М",$s);
    $s=str_replace("%D0%BD","н",$s);  $s=str_replace("%D0%9D","Н",$s);
    $s=str_replace("%D0%BE","о",$s);  $s=str_replace("%D0%9E","О",$s);
    $s=str_replace("%D0%BF","п",$s);  $s=str_replace("%D0%9F","П",$s);
    $s=str_replace("%D1%80","р",$s);  $s=str_replace("%D0%A0","Р",$s);
    $s=str_replace("%D1%81","с",$s);  $s=str_replace("%D0%A1","С",$s);
    $s=str_replace("%D1%82","т",$s);  $s=str_replace("%D0%A2","Т",$s);
    $s=str_replace("%D1%83","у",$s);  $s=str_replace("%D0%A3","У",$s);
    $s=str_replace("%D1%84","ф",$s);  $s=str_replace("%D0%A4","Ф",$s);
    $s=str_replace("%D1%85","х",$s);  $s=str_replace("%D0%A5","Х",$s);
    $s=str_replace("%D1%86","ц",$s);  $s=str_replace("%D0%A6","Ц",$s);
    $s=str_replace("%D1%87","ч",$s);  $s=str_replace("%D0%A7","Ч",$s);
    $s=str_replace("%D1%88","ш",$s);  $s=str_replace("%D0%A8","Ш",$s);
    $s=str_replace("%D1%89","щ",$s);  $s=str_replace("%D0%A9","Щ",$s);
    $s=str_replace("%D1%8A","ъ",$s);  $s=str_replace("%D0%AA","Ъ",$s);
    $s=str_replace("%D1%8B","ы",$s);  $s=str_replace("%D0%AB","Ы",$s);
    $s=str_replace("%D1%8C","ь",$s);  $s=str_replace("%D0%AC","Ь",$s);
    $s=str_replace("%D1%8D","э",$s);  $s=str_replace("%D0%AD","Э",$s);
    $s=str_replace("%D1%8E","ю",$s);  $s=str_replace("%D0%AE","Ю",$s);
    $s=str_replace("%D1%8F","я",$s);  $s=str_replace("%D0%AF","Я",$s);
    return $s;
}
$i=0;
echo "<style>

#headPar    {
             color:$conf[5];
             font-style:$conf[13];
             font-size:$conf[9]pt;
             font-family:Times New Roman, serif;
             text-align:left;
             vertical-align:top;
            }

 #ollPar    {
             color:$conf[6];
             font-style:$conf[14];
             font-size:$conf[10]pt;
             font-family:Times New Roman, serif;
             text-align:left;
            }

 #todayPar    {
             color:$conf[7];
             font-style:$conf[15];
             font-size:$conf[11]pt;
             font-family:Times New Roman, serif;
            }

 #onlinePar    {
             color:$conf[8];
             font-style:$conf[16];
             font-size:$conf[12]pt;
             font-family:Times New Roman, serif;
            }


 #userPar {

             border-style:".$conf[18].";
             border-width:".$conf[19]."px;
             border-top-color:".$conf[22].";
             border-bottom-color:".$conf[23].";
             border-left-color:".$conf[20].";
             border-right-color:".$conf[21].";
             background-color:".$conf[17].";
             width:".$conf[34]."px;
             height:".$conf[35]."px;
             text-align:left;
             vertical-align:top;
            }

</style>";


?>