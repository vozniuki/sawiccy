<?php
include('cap.php');

if(@$_POST['list_view'])
   {
     if($_POST['list_view']=="oll")$sel[0]='selected';
     if($_POST['list_view']=="browser")$sel[1]='selected';
     if($_POST['list_view']=="os")$sel[2]='selected';
     if($_POST['list_view']=="bot")$sel[3]='selected';

   }
?>



<TABLE width=900px border=0 cellpadding=2  CELLSPACING=1 align=center>

<TR >

 	<td>Список браузеров, операционных систем и сканирующих программ, узнавать которые вы научили скрипт за
 	время пользования.<br> Это обучение нужно для более тонкой настройки т.к.  постоянно появляются новые
 	операционные системы, браузеры, безчисленное количество ботов и пр. Без обучения скрипт умеет раличать
 	основные ОС, браузеры, роботы-пауки поисковиков <p></p>  </td>
</tr>



<tr><td align=right>
<form name="view" action="admin3.php?sel4=selected" method="post">
<select name='list_view' onchange="view.submit();">
  <option value="oll" <? echo @$sel[0] ?>>Всё</option>
  <option value="browser" <? echo @$sel[1] ?>>Браузеры</option>
  <option value="os" <? echo @$sel[2] ?>>Операционные системы</option>
  <option value="bot" <? echo @$sel[3] ?>>Сканирующие программы</option>

</select>
</form>
</td></tr>
</TABLE>


<div align=center><div style="background-color:#0080C0;  width:900px">
<TABLE width=900px border=0 cellpadding=2  CELLSPACING=1>
 <TR >

 	<td width=10%><b><font color=#ffffff>Тип</font></b></td>
 	<td><b><font color=#ffffff>Идентификатор</font></b> </td>
    <td><b><font color=#ffffff>Название</font></b> </td><td></td>
</tr>
 <form name="frm" action="admin3.php?sel4=selected" method="post">
<?php



chdir("..");
if(isset($_POST['del']))
  {
   $modul_file=file("modul.txt");
   $modulPHP_file=file("modul.php");

   for($i=0; $i< count($modul_file);$i++)
    {
      if(@$_POST['del'][$i]=="Удалить")
        {
            //Текстовый файл
        	$f=fopen("modul.txt","w+");
            foreach($modul_file as $line)
             {
             	$data_expl=explode("|",$line);
             	if($_POST['ident'][$i]==$data_expl[1]) continue;
             	fwrite($f,$line);
             }
            fclose($f);

            //PHP файл
            $f=fopen("modul.php","w+");

            foreach($modulPHP_file as $line)
             {
                if(strpos($line, $_POST['ident'][$i])!== false) continue;
             	fwrite($f,$line);
             }
            fclose($f);
            break;
        }

    }
  }



if(file_exists("modul.txt"))
  {

    $arr_file=file("modul.txt");
    if(!@$_POST['list_view'] || @$_POST['list_view']=='oll')
    {

     $i=0;
     foreach($arr_file as $line)
       {
       	 $expl=explode("|",$line);
       	 echo "<tr bgcolor=#E6E6E6>
       	          <td>$expl[0]</td>
       	          <td>$expl[1]</td>
       	          <td>$expl[2]</td>
       	          <input name='ident[$i]' type='hidden' value='$expl[1]'>
       	           <td align=right><input type='submit' name='del[$i]' value='Удалить'>
       	          </td></tr>";
       	 $i++;
       }
    }
    else
    {
      $i=0;
     foreach($arr_file as $line)
       {
       	 $expl=explode("|",$line);
       	 if($expl[0]==$_POST['list_view'])
       	   {
       	    echo "<tr bgcolor=#E6E6E6>
       	          <td>$expl[0]</td>
       	          <td>$expl[1]</td>
       	          <td>$expl[2]</td>
       	          <input name='ident[$i]' type='hidden' value='$expl[1]'>
       	           <td align=right><input type='submit' name='del[$i]' value='Удалить'>
       	          </td></tr>";
       	    $i++;
       	   }
       }
    }

  }


?>
</form>
</table></div>

