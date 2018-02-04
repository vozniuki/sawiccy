<?php
include('cap.php');
?>

<script language='JavaScript1.1' type='text/javascript'>
<!--

  function op(obj,dat1,dat2)
  {

    var par=obj;
    mainwin=window.open('view1.php?obj='+par+'&dat1='+dat1+'&dat2='+dat2+'','',
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
Сводки за указанный период. В каждой таблице максимум 10 значений. Нажав на "Полный список", получим
остальную информацию.<br>
Нажмите на IP для просмотра посещений с этого адреса вашего сайта за указанный период.<br>
<b>Внимание!</b> Сегодняшней информации здесь нет. Информация за месяц появится на второй день и если в этот
день уже были посещения. Это касается также статистики за год и за всё время.

</td></tr>
<tr bgcolor=#E6E6E6><td valign=top>Статистика за&nbsp;
 <?php
 if (!@$_GET['q'])$action="admin2.php?sel3=selected&q=1";
else  $action="admin2.php?sel3=selected";

 chdir("..");

  if(@$_POST['list_year'])
     {
      $dat_year= $_POST['list_year'];
      $dat_mon= $_POST['list_mon'];
     }
   else
     {
     	$dat_year=date("Y");
     	$dat_mon= date("m");
     }

 switch(@$_POST['per'])
  {
  	case "per_mon":
  	      switch($dat_mon)
  	       {
  	       	 case "01":
  	       	 echo "январь $dat_year года";
  	       	 break;

  	       	  case "02":
  	       	 echo "февраль $dat_year года";
  	       	 break;

  	       	  case "03":
  	       	 echo "март $dat_year года";
  	       	 break;

  	       	  case "04":
  	       	 echo "апрель $dat_year года";
  	       	 break;

  	       	  case "05":
  	       	 echo "май $dat_year года";
  	       	 break;

  	       	  case "06":
  	       	 echo "июнь $dat_year года";
  	       	 break;

  	       	  case "07":
  	       	 echo "июль $dat_year года";
  	       	 break;

  	       	  case "08":
  	       	 echo "август $dat_year года";
  	       	 break;

  	       	  case "09":
  	       	 echo "сентябрь $dat_year года";
  	       	 break;

  	       	  case "10":
  	       	 echo "октябрь $dat_year года";
  	       	 break;

  	       	  case "11":
  	       	 echo "ноябрь $dat_year года";
  	       	 break;

  	       	  case "12":
  	       	 echo "декабрь $dat_year года";
  	       	 break;
  	       }
  	      break;
  	case "per_year":
  	      echo $dat_year." год.";
  	      break;
  	case "per_oll":
  	      echo "весь период.";
  	      break;
  	default:
  	      echo $dat_year." ".$dat_mon;
  	      break;
  }




  ?>
  </td>


<td align=right>

 <form name="frm" action=<? echo $action ?> method="post">



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


    if (@$_POST['per']=="per_mon" || empty($_POST['per']))$check[1]="checked";
    if (@$_POST['per']=="per_year" )$check[0]="checked";
     if (@$_POST['per']=="per_oll" )$check[2]="checked";

    echo "</select>&nbsp;&nbsp;<br>

    <input name='per' type='radio' value='per_year' ". @$check[0]."  onclick=\"frm.submit();\">&nbsp;год&nbsp;&nbsp;
    <input name='per' type='radio' value='per_mon' ". @$check[1]. " onclick=\"frm.submit();\">&nbsp;месяц
    &nbsp;&nbsp;<input name='per' type='radio' value='per_oll' ". @$check[2]. " onclick=\"frm.submit();\">&nbsp;всё";
if (@$_GET['q'])
    {
    	$action="admin2.php?sel2=selected";
    	echo "<script>frm.submit()</script>";
    }


?>

</form>

</td>

</tr>


</TABLE>

<?php
//Если есть хоть какая-то статистика

  if(file_exists("stat/".date("Y")) || file_exists("stat/".(date("Y")-1)))
   {
     //Если только загрузились


     if(!@$_POST['list_year'])
        {
         if(file_exists("stat/".date("Y")."/".date("m")."/ip/oll.txt"))
                            $ip=file("stat/".date("Y")."/".date("m")."/ip/oll.txt");
         if(file_exists("stat/".date("Y")."/".date("m")."/bot/oll.txt"))
                            $bot=file("stat/".date("Y")."/".date("m")."/bot/oll.txt");
         if(file_exists("stat/".date("Y")."/".date("m")."/search/oll.txt"))
                            $search=file("stat/".date("Y")."/".date("m")."/search/oll.txt");
         if(file_exists("stat/".date("Y")."/".date("m")."/query/oll.txt"))
                            $query=file("stat/".date("Y")."/".date("m")."/query/oll.txt");
         if(file_exists("stat/".date("Y")."/".date("m")."/os/oll.txt"))
                            $os=file("stat/".date("Y")."/".date("m")."/os/oll.txt");
         if(file_exists("stat/".date("Y")."/".date("m")."/browser/oll.txt"))
                            $browser=file("stat/".date("Y")."/".date("m")."/browser/oll.txt");
         if(file_exists("stat/".date("Y")."/".date("m")."/page/oll.txt"))
                            $page=file("stat/".date("Y")."/".date("m")."/page/oll.txt");
         if(file_exists("stat/".date("Y")."/".date("m")."/ref/oll.txt"))
                            $ref=file("stat/".date("Y")."/".date("m")."/ref/oll.txt");
        }

     //Выбрана статистика за месяц
     if(@$_POST['per']=='per_mon')
        {
         if(file_exists("stat/".$_POST['list_year']."/".$_POST['list_mon']."/ip/oll.txt"))
                            $ip=file("stat/".$_POST['list_year']."/".$_POST['list_mon']."/ip/oll.txt");
         if(file_exists("stat/".$_POST['list_year']."/".$_POST['list_mon']."/bot/oll.txt"))
                            $bot=file("stat/".$_POST['list_year']."/".$_POST['list_mon']."/bot/oll.txt");
         if(file_exists("stat/".$_POST['list_year']."/".$_POST['list_mon']."/search/oll.txt"))
                            $search=file("stat/".$_POST['list_year']."/".$_POST['list_mon']."/search/oll.txt");
         if(file_exists("stat/".$_POST['list_year']."/".$_POST['list_mon']."/query/oll.txt"))
                            $query=file("stat/".$_POST['list_year']."/".$_POST['list_mon']."/query/oll.txt");
         if(file_exists("stat/".$_POST['list_year']."/".$_POST['list_mon']."/os/oll.txt"))
                            $os=file("stat/".$_POST['list_year']."/".$_POST['list_mon']."/os/oll.txt");
         if(file_exists("stat/".$_POST['list_year']."/".$_POST['list_mon']."/browser/oll.txt"))
                            $browser=file("stat/".$_POST['list_year']."/".$_POST['list_mon']."/browser/oll.txt");
         if(file_exists("stat/".$_POST['list_year']."/".$_POST['list_mon']."/page/oll.txt"))
                            $page=file("stat/".$_POST['list_year']."/".$_POST['list_mon']."/page/oll.txt");
         if(file_exists("stat/".$_POST['list_year']."/".$_POST['list_mon']."/ref/oll.txt"))
                            $ref=file("stat/".$_POST['list_year']."/".$_POST['list_mon']."/ref/oll.txt");
        }

      //Статистка за год

        if(@$_POST['per']=='per_year')
        {

            //Открыли год
           if(file_exists("stat/$dat_year"))
           {
            $m=opendir("stat/$dat_year");
            while(($mon=readdir($m))!=false)
             {
                if($mon =="." || $mon =="..") continue;
              if(file_exists("stat/$dat_year/$mon/bot/oll.txt"))
               {
                  $arr1=open("bot",$mon,$dat_year);
                  foreach($arr1 as $line) $bot[]=$line;
               }
              if(file_exists("stat/$dat_year/$mon/browser/oll.txt"))
                {
                 $arr2=open("browser",$mon,$dat_year);
                 foreach($arr2 as $line) $browser[]=$line;
                }
              if(file_exists("stat/$dat_year/$mon/ip/oll.txt"))
                {
                 $arr3=open("ip",$mon,$dat_year);
                 foreach($arr3 as $line) $ip[]=$line;
                }
              if(file_exists("stat/$dat_year/$mon/os/oll.txt"))
                {
                 $arr4=open("os",$mon,$dat_year);
                 foreach($arr4 as $line) $os[]=$line;
                }
               if(file_exists("stat/$dat_year/$mon/page/oll.txt"))
                {
                 $arr5=open("page",$mon,$dat_year);
                 foreach($arr5 as $line) $page[]=$line;
                }
               if(file_exists("stat/$dat_year/$mon/query/oll.txt"))
                {
                 $arr6=open("query",$mon,$dat_year);
                 foreach($arr6 as $line) $query[]=$line;
                }
               if(file_exists("stat/$dat_year/$mon/ref/oll.txt"))
                {
                 $arr7=open("ref",$mon,$dat_year);
                 foreach($arr7 as $line) $ref[]=$line;
                }
               if(file_exists("stat/$dat_year/$mon/search/oll.txt"))
                {
                 $arr8=open("search",$mon,$dat_year);
                 foreach($arr8 as $line) $search[]=$line;
                }
             }
            closedir($m);
           }
        }

      //За весь период

       if(@$_POST['per']=='per_oll')
        {
          $y=opendir("stat");
           while(($year=readdir($y))!=false)
          {
            if($year =="." || $year =="..") continue;

            //Открыли год
            $m=opendir("stat/$year");
            while(($mon=readdir($m))!=false)
             {

                 if($mon =="." || $mon =="..") continue;
              if(file_exists("stat/$year/$mon/bot/oll.txt"))
               {
                  $arr1=open("bot",$mon,$year);
                  foreach($arr1 as $line) $bot[]=$line;
               }
              if(file_exists("stat/$year/$mon/browser/oll.txt"))
                {
                 $arr2=open("browser",$mon,$year);
                 foreach($arr2 as $line) $browser[]=$line;
                }
              if(file_exists("stat/$year/$mon/ip/oll.txt"))
                {
                 $arr3=open("ip",$mon,$year);
                 foreach($arr3 as $line) $ip[]=$line;
                }
              if(file_exists("stat/$year/$mon/os/oll.txt"))
                {
                 $arr4=open("os",$mon,$year);
                 foreach($arr4 as $line) $os[]=$line;
                }
               if(file_exists("stat/$year/$mon/page/oll.txt"))
                {
                 $arr5=open("page",$mon,$year);
                 foreach($arr5 as $line) $page[]=$line;
                }
               if(file_exists("stat/$year/$mon/query/oll.txt"))
                {
                 $arr6=open("query",$mon,$year);
                 foreach($arr6 as $line) $query[]=$line;
                }
               if(file_exists("stat/$year/$mon/ref/oll.txt"))
                {
                 $arr7=open("ref",$mon,$year);
                 foreach($arr7 as $line) $ref[]=$line;
                }
               if(file_exists("stat/$year/$mon/search/oll.txt"))
                {
                 $arr8=open("search",$mon,$year);
                 foreach($arr8 as $line) $search[]=$line;
                }
             }
            closedir($m);
          }
          closedir($y);
        }

     //Сортируем массивы

      if(count(@$bot))
       {
         $countbot=array_count_values($bot);
         arsort($countbot);
       	 $bot_value=count($countbot);

       }
      else $bot_value=0;

        $n=0;
      if(count(@$browser))
      {
        $countbrowser=array_count_values($browser);
         arsort($countbrowser);
       	 $browser_value=count($countbrowser);
      }
      else $browser_value=0;

       $n=0;
      if(count(@$ip))
      {
        $countip=array_count_values($ip);
        arsort($countip);
        $ip_value=count($countip);
      }
      else $ip_value=0;

       $n=0;
      if(count(@$os))
      {
        $countos=array_count_values($os);
         arsort($countos);
       	 $os_value=count($countos);

      }
      else $os_value=0;
       $n=0;

      if(count(@$page))
      {
        $countpage=array_count_values($page);
         arsort($countpage);
       	 $page_value=count($countpage);


      }
      else $page_value=0;

       $n=0;
     if(count(@$query))
      {
        //Очищаем от даты
        $y=0;
        foreach($query as $line)
         {
            $stop=strlen($line);
            if(strpos($line,"<font color=#0080C0>")!==false)
               $stop=strpos($line,"<font color=#0080C0>");
         	$line=substr ($line,0,$stop);
         	$line=trim($line);
         	$query[$y]=$line;
         	$y++;
         }
        $countquery=array_count_values($query);
         arsort($countquery);
       	 $query_value=count($countquery);
      }
      else $query_value=0;
       $n=0;

     if(count(@$ref))
     {
      $countref=array_count_values($ref);
         arsort($countref);
       	 $ref_value=count($countref);
     }
     else $ref_value=0;

       $n=0;
    if(count(@$search))
     {
      $countsearch=array_count_values($search);
         arsort($countsearch);
       	 $search_value=count($countsearch);
     }
     else $search_value=0;


     echo "<div align=center>
     <table border=0 width=900px>
     <tr valign=top>
       <td bgcolor=#F0F0F0>
        <div align=center style=\" background-color:#0080C0;  width:300px\">
        <TABLE width=300px border=0 cellpadding=2  CELLSPACING=1><tr>
        <td><font color=#ffffff><b>IP &nbsp;&nbsp;уникальных ".$ip_value."</b></font></td></tr>";

        //Определим параметры для полного списка
        if(empty($_POST['per']) || $_POST['per']=="per_mon")
           {
            $full_1= @$dat_year;
            $full_2= @$dat_mon;
           }
        elseif($_POST['per']=="per_year")
           {
           	 $full_1= @$dat_year;
             $full_2= 0;
           }
        else
           {
            $full_1= 0;
            $full_2= 0;
           }
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
                 <a href=# onClick=\"javascript:op('".$obj."','".$full_1."','".
                 $full_2."');\">Полный список
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
                 <a href=# onClick=\"javascript:op('".$obj."','".$full_1."','".
                 $full_2."');\">Полный список
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
                 <a href=# onClick=\"javascript:op('".$obj."','".$full_1."','".
                 $full_2."');\">Полный список
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
                 <a href=# onClick=\"javascript:op('".$obj."','".$full_1."','".
                 $full_2."');\">Полный список
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
                 <a href=# onClick=\"javascript:op('".$obj."','".$full_1."','".
                 $full_2."');\">Полный список
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
                 <a href=# onClick=\"javascript:op('".$obj."','".$full_1."','".
                 $full_2."');\">Полный список
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
                 <a href=# onClick=\"javascript:op('".$obj."','".$full_1."','".
                 $full_2."');\">Полный список
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
                 <a href=# onClick=\"javascript:op('".$obj."','".$full_1."','".
                 $full_2."');\">Полный список
                                 </a></td></tr>";
                	break;
                }

  	          echo "<tr bgcolor=#E6E6E6><td>$k </td> <td>$v</td></tr>";
              $stop++;
            }
       }
        echo"</table></div>
        </td></tr></table></div>";



chdir("admin");

}
else exit("<font size=2>Статистики пока нет</font>");
//Конец проверки на отсутствие статистики
function open($object,$mon,$dat_year)
 {
    $str="stat/$dat_year/$mon/$object/oll.txt";
    $prom=file($str);
    foreach($prom as $line)
      {
      	$arr[]=$line;
      }

     return $arr;
 }
?>
