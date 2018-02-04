<?php
include('cap.php');

?>

<script language='JavaScript1.1' type='text/javascript'>
<!--

  function op(obj,dat1,dat2,dat3)
  {

    var par=obj;
    mainwin=window.open('view.php?obj='+par+'&dat1='+dat1+'&dat2='+dat2+'&dat3='+dat3+'','',
   'Width=900, height=600,status=yes,toolbar=no,menubar=no,scrollbars=yes,resizeable=yes');

  }

   function ip(obj)
  {

    mainwin=window.open('ip.php?ip='+obj+'','',
   'Width=900, height=600,status=yes,toolbar=no,menubar=no,scrollbars=yes,resizeable=yes');

  }

//-->
</script>



<TABLE width=900px border=0 cellpadding=2  CELLSPACING=1 align=center>
<tr bgcolor=#E6E6E6><td colspan=2>
Статистика одного дня. Выбрать дату можно из раскрывающегося списка. Выберите также нужное вам представление
статистики. Нажмите на ip для подробной информации.<br>
<b>Внимание!</b> Статистика предыдущего дня появится, если кто-то уже зашёл на ваш сайт. Если сегодня посещений не было,
не будет статистики за сегодняшний и предыдущий дни!<br>
<?php
 if((empty($_POST['view']) || $_POST['view']=="Таблица")&& empty($_POST['add_go']))
    {
      echo "Представление 'Таблица'. Одна строка-одно посещение ";
    }
 elseif(@$_POST['view']=="Сводка")
    {
    	echo " Представление 'Сводка'. Данные одного дня помещены в восемь таблиц.";
    }
 elseif(@$_POST['view']=="Лог" || @$_POST['add_go']!="")
    {
    	echo "Представление 'Лог'. Время, IP, User Agent посещения. В сомнительных случаях поможет определить
    	такие параметры, как ОС и браузер. Здесь можно обучить программу узнавать новые боты, браузеры и пр.
    	Подробнее читайте в справке.";
    }


?>

</td></tr>
<tr bgcolor=#E6E6E6><td valign=top><b>Текущая статистика за
 <?php
 chdir("..");
  if(@$_POST['list_year'])
  {


    if($_POST['list_year']==date("Y") &&
       $_POST['list_mon']==date("m")  &&
       @$_POST['list_day']==date("j"))  echo date("j m Y");
    else
  	echo @$_POST['list_day']." ".$_POST['list_mon']." ".$_POST['list_year'];


  }
 else echo date("j m Y");
echo "</b>";
 //Обучение
 if(@$_POST['add_go'])
   {
    $s[2]='selected';

    if(!empty($_POST['add_ident']) && !empty($_POST['add_obj']))
     {
       $_POST['add_ident']=trim($_POST['add_ident']);
       $_POST['add_obj']=trim($_POST['add_obj']);
       //А не задействован ли этот иденитификатор
       $dataY=false;
       if(file_exists("modul.txt"))
          {
            $data= file("modul.txt");
            foreach($data as $line)
                {
                	$data_expl=explode("|",$line);
                	if($_POST['add_ident']==$data_expl[1])
                	   {
                	     $dataY=true;
                         break;
                       }
                }

          }
       if(!$dataY)
       {

       $str="if(strpos(\$useragent,'".$_POST['add_ident']."') !== false)$".$_POST['obj']." ='".$_POST['add_obj']."';";
       $f=fopen("modul.php","r");
       $repl=fread($f,filesize("modul.php"));
       fclose($f);
       $repl=str_replace("<?php\r\n","",$repl);
       $repl=str_replace("?>","",$repl);
       $repl=trim($repl);
       $f=fopen("modul.php","w+");
       fwrite($f,"<?php\r\n");
       fwrite($f,$repl."\r\n".$str."\r\n?>");
       fclose($f);
       //Сохраняем в файл
       $f=fopen("modul.txt","a+");
       fwrite($f,$_POST['obj']."|".$_POST['add_ident']."|".$_POST['add_obj']."\r\n");
       fclose($f);
       }
       else echo "<P><font color=red>Идентификатор $_POST[add_ident] уже задействован.<br>
       Если вы ввели его по ошибке-удалите на странице 'Узнаваемые агенты'</font>";

     }
    else echo "<P><font color=red>Данные введите полностью!</font>";

   }

if (!@$_GET['q'])$action="admin1.php?sel2=selected&q=1";
elseif(@$_GET['q']==1)  $action="admin1.php?sel2=selected&q=2";
elseif(@$_GET['q']==2)  $action="admin1.php?sel2=selected";

  ?>
  </td>


<td align=right>

 <form name="frm" action=<? echo $action ?> method="post">
<?php
 if(@$_POST['view'])
   {
   	 switch($_POST['view'])
   	 {
   	  case "Таблица":
   	     {
   	       $s[0]='selected';
   	       break;
   	     }

   	   case "Сводка":
   	     {
   	       $s[1]='selected';
   	       break;
   	     }

   	    case "Лог":
   	     {
   	       $s[2]='selected';
   	       break;
   	     }
      }
   }

?>
 <select  name="view" onchange="frm.submit();">
  <option value="Таблица" <?echo @$s[0]?> >Таблица</option>
  <option value="Сводка" <?echo @$s[1]?> >Сводка</option>
  <option value="Лог" <?echo @$s[2]?> >Лог</option>
</select> &nbsp;&nbsp;

<?php


  //Годы
  echo"<select name='list_year' onchange=\"frm.submit();\">";
   $year_dir[0]=date("Y");
  $d=opendir("stat");
  //Название файлов в массив

  while(($e=readdir($d))!=false)
   {
    if($e =="." || $e ==".." || $e ==date("Y") ) continue;
    @$year_dir[]=$e;

   }
  closedir($d);

  if(count($year_dir))
  {
   rsort($year_dir);

   $num_year=0;
   $sel="";
   foreach($year_dir as $line)
   {
       if (@$_POST['list_year']==$line) $sel='selected';
       else $sel="";
       echo "<option value=".$line." ". @$sel.">$line</option>";

    }

  }

  echo "</select>&nbsp;&nbsp;
  <select name='list_mon' onchange=\"frm.submit();\">";
 if(!@$_POST['list_mon'] || @$_POST['list_year']==date("Y")) $mon_dir[0]=date("m");

  //Месяцы
  if(count($year_dir))
    {
     if(@$_POST['list_year'])
      {
        if(file_exists("stat/".$_POST['list_year']))
                 $d=opendir("stat/".$_POST['list_year']);
      }
     else
      {
         if(file_exists("stat/".$year_dir[0]))
                   $d=opendir("stat/".$year_dir[0]);
      }
       //Название файлов в массив
       while(($e=readdir($d))!=false)
        {
         if($e =="." || $e ==".." || $e==date("m")) continue;
         @$mon_dir[]=$e;

        }
      closedir($d);

    }


  if(count($mon_dir))
  {
   //Сортировка========================

   rsort($mon_dir);
   foreach($mon_dir as $line)
    {
      if (@$_POST['list_mon']==$line) @$sel='selected';
      else $sel="";
  	  echo "<option value=".$line." ". @$sel.">$line</option>";
    }
  }

    echo "</select>&nbsp;&nbsp;";

   //Дни
  echo "<select name=list_day onchange=\"frm.submit();\">";
if(!@$_POST['list_day'] || @$_POST['list_mon']==date("m")) $day_dir[0]=date("j");

  if(count($mon_dir))
    {
  	  if(@$_POST['list_mon'])
  	     {
  	     	$strdir= "stat/".$_POST['list_year']."/".$_POST['list_mon']."/oll";

  	     	$d=opendir("stat/".$_POST['list_year']."/".$_POST['list_mon']."/oll");

  	     }
  	  else
         {

         	$d=opendir("stat/$year_dir[0]/$mon_dir[0]/oll");

         }

       //Название файлов в массив
       while(($e=readdir($d))!=false)
        {
         if($e =="." || $e ==".." || $e==date("j")) continue;
         @$day_dir[]=$e;

        }
      closedir($d);

    }


  if(count($day_dir))
  {
   //Сортировка========================
   $n=0;
   foreach($day_dir as $line)
    {
    	$day_dir[$n]=str_replace(".txt","",$line);
    	$n++;
    }

   rsort($day_dir);
   $n=0;
    foreach($day_dir as $line)
    {
    	$day_dir[$n]=$line.".txt";
    	$n++;
    }
   //===================================

   foreach($day_dir as $line)
    {
      $line=str_replace(".txt","",$line);
       if(isset($_POST['list_day']))
         if (@$_POST['list_day']==$line)
           {
         	  $sel='selected';
           }
         else
           {
         	  $sel="";
           }
  	  echo "<option value=".$line." ". @$sel.">$line</option>";

    }
  }

   echo "</select>&nbsp;&nbsp;";

 if (@$_GET['q']==1  )echo "<script>frm.submit()</script>";
 if (@$_GET['q']==2  )echo "<script>frm.submit()</script>";

?>

</form>

</td>

</tr>


</TABLE>

<?php
//Табличный вид========================================================
if((empty($_POST['view']) || $_POST['view']=="Таблица")&& empty($_POST['add_go']))
  {
 echo
"<div align=center><div style=\" background-color:#0080C0;  width:900px\">
<TABLE width=900px border=0 cellpadding=2  CELLSPACING=1>

	<TR >

 	<td><b><font color=#ffffff>Время</font></b></td> <td><b><font color=#ffffff>IP</font></b> </td>
 	 <td><b><font color=#ffffff>Ссылающиеся сайты</font></b></td>
 	<td><b><font color=#ffffff>Браузер</font></b></td><td><b><font color=#ffffff>OS</font></b></td>
 	<td><b><font color=#ffffff>Страницы</font></b></td>

 	</tr>";



$today=false;
//Какой день показывать
if(@$_POST['list_year'])
  {

    if($_POST['list_year']==date("Y") &&
     $_POST['list_mon']==date("m") &&
     @$_POST['list_day']==date("j"))
     {
     	  $strpath="us/today.txt";
     	  $today=true;
     }
    else
    {
  	    $strpath="stat/".$_POST['list_year']."/".$_POST['list_mon']."/oll/".@$_POST['list_day'].".txt";
    }

  }
 else
  {
  	 $strpath="us/today.txt";
     $today=true;
  }



  if(!file_exists($strpath))exit("</table></div><font size=2>Данных пока нет. Возможно скрипт только что установлен и на ваш сайт
  никто не успел зайти</font>");
  $content=file($strpath);
  arsort($content);
foreach($content as $line)
 {
  echo"<tr bgcolor=#E6E6E6>";
  $line=trim($line);
  $expl=explode("|",$line);
  $expl_page=explode("*",$expl[5]);
  $n=0;
   foreach($expl as $line1)
    {
        $d=getdate($expl[0]);
        if ($d['mday']!=date("j") && $today==true )
        exit('</tr></table></div><font size=2>Данные за сегодняшний и вчерашний день пока не сформированы.
        Возможно сегодня на сайте не было посещений. <br>Вы можете просмотреть их позже</font>');
        if($n==6)break;
    	if ($n==0)
       {
        $time_out="";
        if(isset($expl[6]))
           {
           	  $get_date1=getdate($expl[6]);
              //Изменяем время
              if(strlen($get_date1['hours'])==1)$get_date1['hours']="0".$get_date1['hours'];
              if(strlen($get_date1['minutes'])==1)$get_date1['minutes']="0".$get_date1['minutes'];
              $time_out=" - $get_date1[hours]:$get_date1[minutes]";
           }
        $get_date=getdate($expl[0]);
        //Изменяем время
        if(strlen($get_date['hours'])==1)$get_date['hours']="0".$get_date['hours'];
        if(strlen($get_date['minutes'])==1)$get_date['minutes']="0".$get_date['minutes'];
        echo "<td>".$get_date['hours'].":".$get_date['minutes'].@$time_out."</td>";

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

       elseif($n==1)
       {
       	 echo "<td>
                 <a href=# onClick=\"javascript:ip('".$expl[1]."');\">$expl[1]
                                 </a></td>";
       }
       elseif($n==2)
       {
         if($expl[2]=="Закладка" || strpos($expl[2],"Робот")!==false ||
         $expl[2]=="Неопознанная сканирующая программа")echo "<td>$expl[2]</td>";
         elseif(strpos($expl[2],"Запрос")!==false)echo "<td>$expl[2]</td>";
         else  echo "<td><a href=$expl[2]>$expl[2]</a></td>";
       }


       else
        {
        echo "<td>$expl[$n]</td>";
        }
    	$n++;
    }

 }
    echo "</tr></TABLE></div>";
 }
 //Сводка=================================================================

 elseif(@$_POST['view']=="Сводка")
 {

        $today=false;
        if($_POST['list_year']==date("Y") &&
            $_POST['list_mon']==date("m") &&
            $_POST['list_day']==date("j"))
         {
     	   $strpath="us/";
     	   $today=true;
         }
        else
        {
  	       $strpath="stat/".$_POST['list_year']."/".$_POST['list_mon']."/";
        }

       //Есть ли данные за сегодня
       if($today)
         {
         	if(!file_exists($strpath."/today.txt"))exit("<font size=2>Данных нет.
         	Возможно вы только что установили скрипт
         	и на сайте не было посещений</font>");

         	$test=file($strpath."/today.txt");
         	$expl_test=explode("|",$test[0]);
         	$d=getdate( $expl_test[0]);

            if ($d['mday']!=date("j"))exit("<font size=2>Данных за сегодняшний день пока нет</font>");

         }
     //Забираем данные
     if($today)
       {
         if(file_exists($strpath."bot.txt")) $bot=file($strpath."bot.txt");
         if(file_exists($strpath."browser.txt"))$browser=file($strpath."browser.txt");
         if(file_exists($strpath."ip.txt"))$ip=file($strpath."ip.txt");
         if(file_exists($strpath."os.txt"))$os=file($strpath."os.txt");
         if(file_exists($strpath."page.txt"))$page=file($strpath."page.txt");
         if(file_exists($strpath."query.txt"))$query=file($strpath."query.txt");
         if(file_exists($strpath."ref.txt"))$ref=file($strpath."ref.txt");
         if(file_exists($strpath."search.txt"))$search=file($strpath."search.txt");
       }
       else
       {
       	 if(file_exists($strpath."bot/".$_POST['list_day'].".txt"))$bot=file($strpath."bot/".$_POST['list_day'].".txt");
         if(file_exists($strpath."browser/".$_POST['list_day'].".txt"))$browser=file($strpath."browser/".$_POST['list_day'].".txt");
         if(file_exists($strpath."ip/".$_POST['list_day'].".txt"))$ip=file($strpath."ip/".$_POST['list_day'].".txt");
         if(file_exists($strpath."os/".$_POST['list_day'].".txt"))$os=file($strpath."os/".$_POST['list_day'].".txt");
         if(file_exists($strpath."page/".$_POST['list_day'].".txt"))$page=file($strpath."page/".$_POST['list_day'].".txt");
         if(file_exists($strpath."query/".$_POST['list_day'].".txt"))$query=file($strpath."query/".$_POST['list_day'].".txt");
         if(file_exists($strpath."ref/".$_POST['list_day'].".txt"))$ref=file($strpath."ref/".$_POST['list_day'].".txt");
         if(file_exists($strpath."search/".$_POST['list_day'].".txt"))$search=file($strpath."search/".$_POST['list_day'].".txt");
       }


       if(count(@$bot))
       {
         $countbot=array_count_values($bot);
         arsort($countbot);
       	 $bot_value=count($countbot);

       }
      else $bot_value=0;


      if(count(@$browser))
      {
        $countbrowser=array_count_values($browser);
         arsort($countbrowser);
       	 $browser_value=count($countbrowser);

      }
      else $browser_value=0;


      if(count(@$ip))
      {
        $countip=array_count_values($ip);
        arsort($countip);
        $ip_value=count($countip);

      }
      else $ip_value=0;


      if(count(@$os))
      {
        $countos=array_count_values($os);
         arsort($countos);
       	 $os_value=count($countos);

      }
      else $os_value=0;


      if(count(@$page))
      {
        $countpage=array_count_values($page);
         arsort($countpage);
       	 $page_value=count($countpage);

      }
      else $page_value=0;


     if(count(@$query))
      {
        $countquery=array_count_values($query);
         arsort($countquery);
       	 $query_value=count($countquery);
      }
      else $query_value=0;


     if(count(@$ref))
     {
      $countref=array_count_values($ref);
      arsort($countref);
      $ref_value=count($countref);
     }
     else $ref_value=0;


    if(count(@$search))
     {
      $countsearch=array_count_values($search);
      arsort($countsearch);
      $search_value=count($countsearch);

     }
     else $search_value=0;

     if(!isset($ip))$col_ip=0;
     else $col_ip=count($ip);

      if(!isset($bot))$col_bot=0;
     else $col_bot=count($bot);

     echo "<div align=center>
     <table border=0 width=900px><tr><td colspan=3>
      Всего ".$col_ip." посещений.<br>Из них посетителей ".($col_ip-$col_bot)."<br>
      Сканирующих программ ".$col_bot."</td></tr>
     <tr valign=top>
       <td bgcolor=#F0F0F0>
        <div align=center style=\" background-color:#0080C0;  width:300px\">
        <TABLE width=300px border=0 cellpadding=2  CELLSPACING=1><tr>
        <td colspan=2><font color=#ffffff><b>IP
        &nbsp;&nbsp;уникальных ".$ip_value."</b></font></td></tr>";
       //IP ===========================================================
       if(count(@$ip))
        {
          $obj="ip";

          $stop=0;
           foreach($countip as $k=>$v)
            {
              $k=trim($k);
              if($stop==10)
                {
                	echo "<tr bgcolor=#E6E6E6><td colspan=2>
                 <a href=# onClick=\"javascript:op('".$obj."','".$_POST['list_year']."','".
                 $_POST['list_mon']."','".$_POST['list_day']."');\">Полный список
                                 </a></td></tr>";
                	break;
                }

  	          echo "<tr bgcolor=#E6E6E6><td> <a href=# onClick=\"javascript:ip('".$k."');\">$k
                                 </a> </td> <td>$v</td></tr>";
  	          $stop++;
            }
        }

        echo"</table></div></td>";

      echo"<td bgcolor=#F0F0F0>
        <div align=center style=\" background-color:#0080C0;  width:300px\">
        <TABLE width=300px border=0 cellpadding=2  CELLSPACING=1><tr>
        <td colspan=2><font color=#ffffff><b>Операционные системы
        &nbsp;&nbsp;уникальных ".$os_value."</b></font></td></tr>";

        //OS ===========================================================
        if(count(@$os))
        {
         $stop=0;
         $obj="os";

           foreach($countos as $k=>$v)
            {
               $k=trim($k);
               if($stop==10)
                {
                	echo "<tr bgcolor=#E6E6E6><td colspan=2>
                 <a href=# onClick=\"javascript:op('".$obj."','".$_POST['list_year']."','".
                 $_POST['list_mon']."','".$_POST['list_day']."');\">Полный список
                                 </a></td></tr>";
                	break;
                }
  	          echo "<tr bgcolor=#E6E6E6><td>$k </td> <td>$v</td></tr>";
  	          $stop++;
            }
         }
        echo"</table></div>
        </td>";


      echo"<td bgcolor=#F0F0F0>
        <div align=center style=\" background-color:#0080C0;  width:300px\">
        <TABLE width=300px border=0 cellpadding=2  CELLSPACING=1><tr>
        <td colspan=2><font color=#ffffff><b>Браузеры
        &nbsp;&nbsp;уникальных ".$browser_value."</b></font></td></tr>";
        if(count(@$browser))
        {

         $obj="browser";
         $stop=0;

           foreach($countbrowser as $k=>$v)
            {
               $k=trim($k);
               if($stop==10)
                {
                	echo "<tr bgcolor=#E6E6E6><td colspan=2>
                 <a href=# onClick=\"javascript:op('".$obj."','".$_POST['list_year']."','".
                 $_POST['list_mon']."','".$_POST['list_day']."');\">Полный список
                                 </a></td></tr>";
                	break;
                }
  	          echo "<tr bgcolor=#E6E6E6><td>$k </td> <td>$v</td></tr>";
  	          $stop++;
            }
        }
        echo"</table></div>
        </td></tr><tr><td colspan=3>&nbsp;</td</tr>
       <tr valign=top > <td bgcolor=#F0F0F0>
          <div align=center style=\" background-color:#0080C0;  width:300px\">
        <TABLE width=300px border=0 cellpadding=2  CELLSPACING=1><tr>
        <td colspan=2><font color=#ffffff><b>Поисковые системы
        &nbsp;&nbsp;уникальных ".$search_value."</b></font></td></tr>";

        //Поисковики ===========================================================
        if(count(@$search))
        {
         $stop=0;
         $obj="search";

           foreach($countsearch as $k=>$v)
            {
               $k=trim($k);
               if($stop==10)
                {
                	echo "<tr bgcolor=#E6E6E6><td colspan=2>
                 <a href=# onClick=\"javascript:op('".$obj."','".$_POST['list_year']."','".
                 $_POST['list_mon']."','".$_POST['list_day']."');\">Полный список
                                 </a></td></tr>";
                	break;
                }
  	          echo "<tr bgcolor=#E6E6E6><td>$k </td> <td>$v</td></tr>";
              $stop++;
            }
        }
        echo"</table></div>
         </td>
         <td bgcolor=#F0F0F0>

        <div align=center style=\" background-color:#0080C0;  width:300px\">
        <TABLE width=300px border=0 cellpadding=2  CELLSPACING=1><tr>
        <td colspan=2><font color=#ffffff><b>Сканирующие программы
        &nbsp;&nbsp;уникальных ".$bot_value."</b></font></td></tr>";

       //Боты ===========================================================
       if(count(@$bot))
       {
        $obj="bot";
        $stop=0;

           foreach($countbot as $k=>$v)
            {
               $k=trim($k);
               if($stop==10)
                {
                	echo "<tr bgcolor=#E6E6E6><td colspan=2>
                 <a href=# onClick=\"javascript:op('".$obj."','".$_POST['list_year']."','".
                 $_POST['list_mon']."','".$_POST['list_day']."');\">Полный список
                                 </a></td></tr>";
                	break;
                }
  	          echo "<tr bgcolor=#E6E6E6><td>$k </td> <td>$v</td></tr>";
              $stop++;
            }
       }
        echo"</table></div>
        </td> ";
        echo"<td bgcolor=#F0F0F0>
        <div style=\" background-color:#0080C0;  width:300px\">
        <TABLE width=300px border=0 cellpadding=2  CELLSPACING=1><tr>
        <td colspan=2><font color=#ffffff><b>Страницы
        &nbsp;&nbsp;уникальных ".$page_value."</b></font></td></tr>";

       //Страницы ===========================================================
       if(count(@$page))
       {
        $obj="page";
        $stop=0;

           foreach($countpage as $k=>$v)
            {
               $k=trim($k);
               if($stop==10)
                {
                	echo "<tr bgcolor=#E6E6E6><td colspan=2>
                 <a href=# onClick=\"javascript:op('".$obj."','".$_POST['list_year']."','".
                 $_POST['list_mon']."','".$_POST['list_day']."');\">Полный список
                                 </a></td></tr>";
                	break;
                }
  	          echo "<tr bgcolor=#E6E6E6><td>$k </td> <td>$v</td></tr>";
               $stop++;
            }
       }
        echo"</table></div>
        </td>";

       //===========================================================================
       echo"</tr><tr><td colspan=3 >&nbsp;</td</tr><tr valign=top>";
            echo"<td bgcolor=#F0F0F0 colspan=3>
        <div  style=\" background-color:#0080C0;\">
        <TABLE width=100% border=0 cellpadding=2  CELLSPACING=1><tr>
        <td colspan=2><font color=#ffffff><b>Ссылающиеся сайты
        &nbsp;&nbsp;уникальных ".$ref_value."</b></font></td></tr>";

        //Рефы ===========================================================
        if(count(@$ref))
        {
         $obj="ref";
         $stop=0;

           foreach($countref as $k=>$v)
            {
              $k=trim($k);
              if($stop==10)
                {
                	echo "<tr bgcolor=#E6E6E6><td colspan=2>
                 <a href=# onClick=\"javascript:op('".$obj."','".$_POST['list_year']."','".
                 $_POST['list_mon']."','".$_POST['list_day']."');\">Полный список
                                 </a></td></tr>";
                	break;
                }
  	          echo "<tr bgcolor=#E6E6E6>";
  	          if($k=="Закладка" || strpos($k,"Робот")!==false)echo "<td>$k</td>";
             elseif(strpos($k,"Запрос")!==false)echo "<td>$k</td>";
             else  echo "<td><a href=$k>$k</a></td>";
  	          echo"<td>$v</td></tr>";
  	          $stop++;
            }
        }
       echo "</table></div></td>";

       echo"</tr><tr><td colspan=3 >&nbsp;</td</tr><tr valign=top>";
            echo"<td bgcolor=#F0F0F0 colspan=3>

        <div align=center style=\" background-color:#0080C0;\">
        <TABLE width=100% border=0 cellpadding=2  CELLSPACING=1><tr>
        <td colspan=2><font color=#ffffff><b>Ключевые слова
        &nbsp;&nbsp;уникальных ".$query_value."</b></font></td></tr>";

       //Ключевые слова ===========================================================
       if(count(@$query))
       {
        $obj="query";
        $stop=0;

           foreach($countquery as $k=>$v)
            {
               $k=trim($k);
               if($stop==10)
                {
                	echo "<tr bgcolor=#E6E6E6><td colspan=2>
                 <a href=# onClick=\"javascript:op('".$obj."','".$_POST['list_year']."','".
                 $_POST['list_mon']."','".$_POST['list_day']."');\">Полный список
                                 </a></td></tr>";
                	break;
                }


  	          echo "<tr bgcolor=#E6E6E6><td>$k </td> <td>$v</td></tr>";
              $stop++;
            }
       }
        echo"</table></div>
        </td></tr></table></div>";

 }


 //Лог====================================================================
 elseif(@$_POST['view']=="Лог" || @$_POST['add_go']!="")
  {
        $today=false;

        if ($_POST['list_year']==date("Y") &&
            $_POST['list_mon']==date("m") &&
            $_POST['list_day']==date("j"))
         {
     	   $strpath="us/log.txt";
          $today=true;
         }
        else
        {
  	       $strpath="stat/".$_POST['list_year']."/".$_POST['list_mon']."/log/".$_POST['list_day'].".txt";
        }

         echo
"<TABLE width=900px border=0 cellpadding=2  CELLSPACING=1 align=center>
 <tr><td colspan=3>
    <form name='add' action='admin1.php?sel2=selected' method='post'>
     Идентификатор&nbsp;<input name='add_ident' type='text'>&nbsp;&nbsp;
     Объект <input name='add_obj' type='text'>&nbsp;&nbsp;
     <input name='list_year' type='hidden' value=".$_POST['list_year'].">
     <input name='list_mon' type='hidden' value=".$_POST['list_mon'].">
     <input name='list_day' type='hidden' value=".$_POST['list_day'].">
     <input type='submit' value='Добавить' name='add_go'><br>
     Браузер
     <input name='obj' type='radio' value='browser' checked>&nbsp;&nbsp;
     Бот
     <input name='obj' type='radio' value='bot'>&nbsp;&nbsp;
     OS
     <input name='obj' type='radio' value='os' >&nbsp;&nbsp;
    </form>

    </td></tr>
</table>
<div align=center><div style=\" background-color:#0080C0;  width:900px\">
<TABLE width=900px border=0 cellpadding=2  CELLSPACING=1>

	<TR >

 	<td width=10%><b><font color=#ffffff>Время</font></b></td>
 	<td><b><font color=#ffffff>IP</font></b> </td>
    <td><b><font color=#ffffff>UserAgent</font></b> </td>
 	</tr>";

 	 //Есть ли данные за сегодня
       if($today)
         {
         	if(!file_exists("us/today.txt"))exit("</table></div><font size=2>Данных нет.
         	Возможно вы только что установили скрипт
         	и на сайте не было посещений</font>");

         	$test=file("us/today.txt");
         	$expl_test=explode("|",$test[0]);
         	$d=getdate( $expl_test[0]);

            if ($d['mday']!=date("j"))exit("</table></div><font size=2>Данных за сегодняшний день пока нет></font>");

         }
        if(file_exists($strpath))
          {
             $log=file($strpath);
             $log=array_reverse($log);

             foreach($log as $line)
              {
              	$expl=explode("*",$line);
              	$expl[0]=getdate($expl[0]);
              	if(strlen($expl[0]['hours'])==1)$expl[0]['hours']="0".$expl[0]['hours'];
              	if(strlen($expl[0]['minutes'])==1) $expl[0]['minutes']="0".$expl[0]['minutes'];
              	$expl[0]=$expl[0]['hours'].":".$expl[0]['minutes'];



              	echo "<tr bgcolor=#E6E6E6><td>$expl[0]</td><td>
              	<a href=# onClick=\"javascript:ip('".$expl[1]."');\">$expl[1]</a>
              	</td>";
              	if(isset($expl[2]))echo "<td>$expl[2]</td>";
              	else echo "<td></td>";
              	echo"</tr>";
                $n++;
              }
          }

     echo "</table></div>";
  }
chdir("admin");
?>

