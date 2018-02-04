<?php
include('cap.php');
chdir("..");

 if(@$_POST['ident'])
   {
   	 switch($_POST['ident'])
   	 {
   	  case "ip":
   	     {
   	       $chek[0]='checked';
   	       break;
   	     }

   	   case "url":
   	     {
   	       $chek[1]='checked';
   	       break;
   	     }

   	    case "id":
   	     {
   	       $chek[2]='checked';
   	       break;
   	     }
      }

      switch($_POST['go'])
   	 {
   	  case "return":
   	     {
   	       $chek1[0]='checked';
   	       break;
   	     }

   	   case "ref":
   	     {
   	       $chek1[1]='checked';
   	       break;
   	     }

   	    case "stop":
   	     {
   	       $chek1[2]='checked';
   	       break;
   	     }
      }
   }
  else
   {
   	  $chek[0]='checked';
   	  $chek1[0]='checked';
   }


if(isset($_POST['del']))
  {
   $modul_file=file("stop.txt");

   for($i=0; $i< count($modul_file);$i++)
    {
      if(@$_POST['del'][$i]=="Удалить")
        {

        	$f=fopen("stop.txt","w+");
            foreach($modul_file as $line)
             {
             	$data_expl=explode("|",$line);
             	if($_POST['identif'][$i]==$data_expl[1]) continue;
             	fwrite($f,$line);
             }
            fclose($f);

        }

    }
  }

?>

<TABLE width=900px border=0 cellpadding=2  CELLSPACING=1 align=center>
<TR >
 	<td colspan=2 >Здесь вы можете запретить посещение вашего сайта с отдельного ip, с ссылающегося сайта,
 	или какой-либо программе (браузер, бот, ОС). Под строкой "Нежилательный агент" выберите тип посетителя:
 	<b>ip</b> -сетевой адрес, <b>url</b> -ссылающийся сайт, <b>идентификатор</b>- идентификатор программы (возмите из лога).<br>
 	Под строкой "Действия" выберите способ воздействия на посетителя: <b>отправить обратно</b> -как только посетитель
 	попадёт к вам на страницу-его переправят на сайт, с которого он пришёл. Если такого сайта нет,
 	откроется пустая страница. <b>Отправить на адрес</b> - какой-либо адрес в интернете, нужно вести в строке. <b>Показать
 	надпись</b>-введите надпись, которую пользователь увидет вместо вашей страницы.
 	Подробнее читайте в справке.

    <?php
     if(@$_POST['add'])
   {
   	  //Корректность
       if($_POST['agent']=="")echo "<p></p><font color=red>Вы ввели не все данные!</font>";
       elseif ($_POST['info']=="" && $_POST['go']!="return")echo "<p></p><font color=red>Вы ввели не все данные!</font>";
       else
        {
           $_POST['ident']=trim($_POST['ident']);
           $_POST['agent']=trim($_POST['agent']);
           //Не введён ли такой
         $dataY=false;
         if (file_exists("stop.txt"))
           {
           	 $dat=file("stop.txt");
           	 foreach($dat as $line)
           	  {
           	  	$dat_expl=explode("|",$line);
           	  	if($_POST['agent']==$dat_expl[1])
           	  	   {
           	  	   	$dataY=true;
           	  	   	break;
           	  	   }
           	  }
           }
          if(!$dataY)
           {

        	 $f=fopen("stop.txt","a+");
        	 fwrite($f,$_POST['ident']."|".$_POST['agent']."|".$_POST['info']."|".$_POST['go']."\r\n");
             fclose($f);
           }
          else  echo "<p></p><font color=red>Агент $_POST[agent] уже введён!</font>";
        }

   }


  if(@$_POST['list_view'])
   {
     if($_POST['list_view']=="list_oll")$sel[0]='selected';
     if($_POST['list_view']=="list_ip")$sel[1]='selected';
     if($_POST['list_view']=="list_url")$sel[2]='selected';
     if($_POST['list_view']=="list_id")$sel[3]='selected';

   }
   ?>
 	 <p></p>

 	  </td>
</tr>
<tr><td align=right colspan=2>
<form name="view" action="admin4.php?sel5=selected" method="post">
<select name='list_view' onchange="view.submit();">
  <option value="list_oll" <? echo @$sel[0] ?>>Всё</option>
  <option value="list_ip" <? echo @$sel[1] ?>>Запрещённые IP</option>
  <option value="list_url" <? echo @$sel[2] ?>>Запрещённые ссылки</option>
  <option value="list_id" <? echo @$sel[3] ?>>Запрещённые сканирующие программы</option>

</select>
</form>
</td></tr>

<tr><td>
<form name="frm" action="admin4.php?sel5=selected" method="post">
<b>Нежелательный агент</b><p></p>
Введите ip или url или идентификатор<br>
  <input name="agent" size=60 type="text" value="<? echo @$_POST[agent] ?>"><br>
  ip&nbsp;<input name="ident" type="radio" value="ip" <? echo @$chek[0] ?>>&nbsp;&nbsp;
  url&nbsp;<input name="ident" type="radio" value="url" <? echo @$chek[1] ?>>&nbsp;&nbsp;
  идентификатор&nbsp; <input name="ident" type="radio" value="id" <? echo @$chek[2] ?>>

</td>
<td>
  <b>Действия</b><p></p>
 Введите адрес или надпись<br>
 <input name="info" size=60 type="text" value="<? echo @$_POST[info] ?>"><br>
 Отправить обратно&nbsp;<input name="go" type="radio" value="return" <? echo @$chek1[0] ?>>&nbsp;&nbsp;
  Отправить на адрес&nbsp;<input name="go" type="radio" value="ref" <? echo @$chek1[1] ?>>&nbsp;&nbsp;
  Показать надпись&nbsp; <input name="go" type="radio" value="stop" <? echo @$chek1[2] ?>>
 </td></tr>
 <tr><td colspan=2><input type="submit" value="Добавить" name="add"><p></p>


</td>
</tr>
</TABLE>

<div align=center><div style="background-color:#0080C0;  width:900px">
<TABLE width=900px border=0 cellpadding=2  CELLSPACING=1>
<TR >
    <td><b><font color=#ffffff>Тип</font></b></td>
 	<td><b><font color=#ffffff>Агент</font></b></td>
 	<td><b><font color=#ffffff>Действие</font></b> </td>
    <td></td>
</tr>
<?php
if(file_exists("stop.txt"))
   {
     $arr_file=file("stop.txt");
   	 $i=0;
     if(!@$_POST['list_view'] || @$_POST['list_view']=='list_oll')
     {

   	  foreach($arr_file as $line)
   	   {
         $expl=explode("|",$line);
         $expl[3]=trim($expl[3]);
         if($expl[3]=="return")$loc="Отправить обратно";
         if($expl[3]=="ref")$loc="Отправить на адрес ".$expl[2];
         if($expl[3]=="stop")$loc="Показать надпись ".$expl[2];
       	 echo "<tr bgcolor=#E6E6E6>
       	          <td>$expl[0]</td>
       	          <td>$expl[1]</td>
       	          <td>$loc</td>
       	          <input name='identif[$i]' type='hidden' value='$expl[1]'>
       	           <td align=right><input type='submit' name='del[$i]' value='Удалить'>
       	          </td></tr>";
       	  $i++;
   	   }

     }
     else
     {
        if(@$_POST['list_view']=="list_id") $obj="id";
        if(@$_POST['list_view']=="list_ip") $obj="ip";
        if(@$_POST['list_view']=="list_url") $obj="url";
     	foreach($arr_file as $line)
   	   {
   	     $expl=explode("|",$line);
   	     if($expl[0]!=$obj)continue;
         $expl[3]=trim($expl[3]);
         if($expl[3]=="return")$loc="Отправить обратно";
         if($expl[3]=="ref")$loc="Отправить на адрес ".$expl[2];
         if($expl[3]=="stop")$loc="Показать надпись ".$expl[2];
       	 echo "<tr bgcolor=#E6E6E6>
       	          <td>$expl[0]</td>
       	          <td>$expl[1]</td>
       	          <td>$loc</td>
       	          <input name='identif[$i]' type='hidden' value='$expl[1]'>
       	           <td align=right><input type='submit' name='del[$i]' value='Удалить'>
       	          </td></tr>";
       	  $i++;
   	   }
     }

   }
?>


</form>
</table></div>

