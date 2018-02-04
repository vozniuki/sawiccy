<?php
include('cap.php');
//=------------------------------------------------------------------------------


 if(@$_POST['go'])
   { //Тексты

   	 if(@$_POST['text_head']) $conf[0]=@$_POST['text_head'];
     else $conf[0]="Нет значения";

     if( @$_POST['head_int']) $conf[1]=1;
     else $conf[1]=0;

   	 if (@$_POST['text_oll']!="")$conf[2]=@$_POST['text_oll'];
   	 else $conf[2]="Нет значения";

   	 if(@$_POST['text_today']!="")$conf[3]=@$_POST['text_today'];
   	 else $conf[3]="Нет значения";

   	 if (@$_POST['text_online']!="")$conf[4]=@$_POST['text_online'];
     else $conf[4]="Нет значения";

     //Цвета надписей
     if(@$_POST['color_head'])$conf[5]=@$_POST['color_head'];
     else $conf[5]="#000000";

     if(@$_POST['color_oll']) $conf[6]=@$_POST['color_oll'];
     else $conf[6]="#000000";

     if (@$_POST['color_today'])$conf[7]=@$_POST['color_today'];
     else $conf[7]="#000000";

     if (@$_POST['color_online'])$conf[8]=@$_POST['color_online'];
     else $conf[8]="#000000";

     //Размер шрифтов
     $conf[9]= @$_POST['size_head'];
     $conf[10]=@$_POST['size_oll'];
     $conf[11]=@$_POST['size_today'];
     $conf[12]=@$_POST['size_online'];

     //Начертание
     $conf[13]=@$_POST['font_head'];
     $conf[14]=@$_POST['font_oll'];
     $conf[15]=@$_POST['font_today'];
     $conf[16]=@$_POST['font_online'];

      //Цвет фона
     if(@$_POST['color_fon'])$conf[17]= @$_POST['color_fon'];
     else @$conf[17]="#ffffff";

     //Вид рамки
     $conf[18]= @$_POST['border'];

     //ширина рамки
     $conf[19]= @$_POST['border_width'];

     //Цвет рамки
     if (@$_POST['border_left_color'])@$conf[20]= @$_POST['border_left_color'];
     else @$conf[20]="#000000";

     if(@$_POST['border_right_color'])@$conf[21]= @$_POST['border_right_color'];
     else @$conf[21]="#000000";

     if(@$_POST['border_top_color'])@$conf[22]= @$_POST['border_top_color'];
     else @$conf[22]="#000000";

     if(@$_POST['border_bottom_color'])@$conf[23]= @$_POST['border_bottom_color'];
     else @$conf[23]="#000000";

     //Картинки

     //Для заголовка
     if( @$_POST['img_head_on']) @$conf[24]=1;
     else @$conf[24]=0;
     @$conf[25]=@$_POST['usH'];


     //Для надписей
     if( @$_POST['img_on']) @$conf[26]=1;
     else @$conf[26]=0;
     @$conf[27]=@$_POST['us'];

     //Положение картинок

     $conf[28]=@$_POST['img_align_head'] ;
     $conf[29]=@$_POST['img_align'];

     $conf[30]= @$_POST['img_valign'];

      //Время

      $conf[31]= @$_POST['online_min'];

      // Перенос на строку

      if( @$_POST['stroc_today']) @$conf[32]=1;
      else @$conf[32]=0;

      if( @$_POST['stroc_online']) @$conf[33]=1;
      else @$conf[33]=0;

       if( @$_POST['width']) @$conf[34]=@$_POST['width'];
      else @$conf[34]=100;

        if( @$_POST['height']) @$conf[35]=@$_POST['height'];
      else @$conf[35]=100;

      $conf[36]=@$_POST['alignOll'];
      $conf[37]=@$_POST['alignToday'];
      $conf[38]=@$_POST['alignOnline'];


      //Обнуление

        if ( (!empty($_POST['stat_com'])) || (!empty($_POST['stat_today'])) || (!empty($_POST['stat_online'])) )
         {
           chdir("..");
       	   if (@$_POST['stat_com'])  if (file_exists("us/oll.txt")) unlink("us/oll.txt");

           if (@$_POST['stat_today']) if (file_exists("us/today.txt")) unlink("us/today.txt");

       	   if (@$_POST['stat_online']) if (file_exists("us/online.txt")) unlink("us/online.txt");
           chdir("./admin");


         }


        $strpath="config/conf.txt";
        @$f=fopen($strpath,w);
        foreach($conf as $line) fwrite($f, $line."\r\n");
        fclose($f);


        //Меняем пароль и логин----------------------------------
       if(@$_POST['login']!="" &&  @$_POST['pasw']!="")
        {
          @$_POST['login']=trim(@$_POST['login']);
          @$_POST['pasw']=trim(@$_POST['pasw']);
          $strpath="config/log.txt";
          @$f=fopen($strpath, "w");
          fwrite($f,md5($_POST['login'])."\r\n");
          fwrite($f,md5($_POST['pasw'])."\r\n");
          fwrite($f,session_id());
          fclose($f);

        }


   }



   //Проверка данных---------------------------------------


$strpath="config/conf.txt";
@$f=fopen($strpath,r);
$conf=file($strpath);
fclose($f);

 for($i=0; $i<count($conf);$i++)
 {
 	 str_replace("\r\n", "",$conf[$i]);
 	 $conf[$i]=trim($conf[$i]);
 }

if (@$conf[1]==1)@$check_head_int='checked';
else @$check_head_int="";


for($i=10, $n=0; $n<6; $i+=2, @$n++)
 {
     if (@$conf[9]==$i)  @$check_size_head[$n]='selected';
     else @$check_size_head[$n]="";
 }

for($i=8,$n=0; $n<5; $i++, $n++)
 {
     if (@$conf[10]==$i)  @$check_size_oll[$n]='selected';
     else @$check_size_oll[$n]="";
 }


for($i=8,$n=0; $n<5; $i++, $n++)
 {
     if (@$conf[11]==$i)  @$check_size_today[$n]='selected';
     else @$check_size_today[$n]="";
 }

for($i=8,$n=0; $n<5; $i++, $n++)
 {
     if (@$conf[12]==$i)  @$check_size_online[$n]='selected';
     else @$check_size_online[$n]="";
 }

 //Начертание заголовка
 if (@$conf[13]=="normal") @$check_font_head[0]="selected";

 if (@$conf[13]=="italic") @$check_font_head[1]="selected";

 if (@$conf[13]=="bold") @$check_font_head[2]="selected";


 //Начертание всего
 if (@$conf[14]=="normal") @$check_font_oll[0]="selected";
 else @$check_font_oll[0]="";

 if (@$conf[14]=="italic") @$check_font_oll[1]="selected";


 if (@$conf[14]=="bold") @$check_font_oll[2]="selected";
 else @$check_font_oll[2]="1";

 //Начертание сегодня
 if (@$conf[15]=="normal") @$check_font_today[0]="selected";
 else @$check_font_today[0]="";

 if (@$conf[15]=="italic") @$check_font_today[1]="selected";
 else @$check_font_today[1]="";

 if (@$conf[15]=="bold") @$check_font_today[2]="selected";
 else @$check_font_today[2]="";

 //Начертание сейчас
 if (@$conf[16]=="normal") @$check_font_online[0]="selected";
 else @$check_font_online[0]="";

 if (@$conf[16]=="italic") @$check_font_online[1]="selected";
 else @$check_font_online[1]="";

 if (@$conf[16]=="bold") @$check_font_online[2]="selected";
 else @$check_font_online[2]="";

 //Рамка

 if(@$conf[18]=="none") @$check_border[0]="selected";
 if(@$conf[18]=="dotted") @$check_border[1]="selected";
 if(@$conf[18]=="dashed") @$check_border[2]="selected";
 if(@$conf[18]=="solid") @$check_border[3]="selected";
 if(@$conf[18]=="double") @$check_border[4]="selected";

 for($i=1; $i<6; $i++)
 {
     if (@$conf[19]==$i)  @$check_border_width[$i-1]='selected';
     else @$check_border_width[$i-1]="";
 }

if(@$conf[24]==1)@$check_img_head_on ="checked";
else @$check_img_head_on ="";

for($i=1; $i<13; $i++)
 {
 	if(@$conf[25]==$i) @$check_usH[$i]="checked";
    else  @$check_usH[$i]="";
 }

if(@$conf[26]==1)@$check_img_on ="checked";

for($i=1; $i<13; $i++)
 {
 	if(@$conf[27]==$i) @$check_us[$i]="checked";
    else @$check_us[$i]="";
 }

//Положение картинки

if (@$conf[28]=="right")@$check_img_align_head_right='checked';
if (@$conf[28]=="left")@$check_img_align_head_left='checked';

if (@$conf[29]=="right")@$check_img_align_right='checked';
if (@$conf[29]=="left")@$check_img_align_left='checked';

if (@$conf[30]=="top")@$check_img_valign_top='checked';
if (@$conf[30]=="bottom")@$check_img_valign_bottom='checked';
if (@$conf[30]=="center")@$check_img_valign_center='checked';

for($i=5; $i<60; $i+=5)
 {
 	if(@$conf[31]==$i) $check_online_min[$i]="selected";
 	else $check_online_min[$i]="1";

 }

if(@$conf[32]==1)@$check_stroc_today="checked";
else @$check_stroc_today="";
if(@$conf[33]==1)@$check_stroc_online="checked";
else @$check_stroc_online="";

if(@$conf[36]=='left')@$check_align_oll[0]="selected";
if(@$conf[36]=='center')@$check_align_oll[1]="selected";
if(@$conf[36]=='right')@$check_align_oll[2]="selected";

if(@$conf[37]=='left')@$check_align_today[0]="selected";
if(@$conf[37]=='center')@$check_align_today[1]="selected";
if(@$conf[37]=='right')@$check_align_today[2]="selected";

if(@$conf[38]=='left')@$check_align_online[0]="selected";
if(@$conf[38]=='center')@$check_align_online[1]="selected";
if(@$conf[38]=='right')@$check_align_online[2]="selected";

?>

<html>
<head>
  <style>



table  {

 	         font-size:10pt;
       }
h1   {
	     font-size:18pt;
	     color:   #408080
      }
h2   {
	     font-size:15pt;
	     color:   #408080
      }
h3   {
	     font-size:11pt;

      }


#headPar    {
             color:<?echo $conf[5] ?>;
             font:<?echo $conf[13]." ".  $conf[9]."pt" ?>;
             font-family:"Times New Roman", "serif";
             text-align:left;
             vertical-align:top;
            }

 #ollPar    {
             color:<?echo $conf[6] ?>;
             font:<?echo $conf[14]." ".  $conf[10]."pt" ?>;
             text-align:left;
             font-family:"Times New Roman", "serif";
            }

 #todayPar    {
             color:<?echo $conf[7] ?>;
             font:<?echo $conf[15]." ".  $conf[11]."pt" ?>;
             font-family:"Times New Roman", "serif";
            }

 #onlinePar    {
             color:<?echo $conf[8] ?>;
             font:<?echo $conf[16]." ".  $conf[12]."pt" ?>;
             font-family:"Times New Roman", "serif";
            }


 #userPar {

             border-style:<?echo $conf[18] ?>;
             border-width: <?echo $conf[19] ?>px;
             border-top-color:<?echo $conf[22] ?>;
             border-bottom-color:<?echo $conf[23] ?>;
             border-left-color:<?echo $conf[20] ?>;
             border-right-color:<?echo $conf[21] ?>;
             background-color:<?echo $conf[17] ?>;
             width:<?echo $conf[34] ?>px;
             height:<?echo $conf[35] ?>px;
             text-align:left;
             vertical-align:top;
            }

</style>

 <TITLE>Администрирование</TITLE>
</head>
<BODY BGCOLOR='#E6E6E6'>

<TABLE width=80% CELLPADDING=7 CELLSPACING=0 border=0 align=center>
<form name="" action="" method="post">

    <tr><td align=right colspan=2 valign=top>

    <?
     echo "<table border=0>";
    //Если заголовок присутствует
            echo  "<tr><td id='headPar' colspan=2>";
         	//Если картинка разрешена и слева
         	if ($conf[1]==0)
              if ($conf[24]==1)
                   if ($conf[28]=='left')
                    echo "<img src=img/us".$conf[25].".png border=0 align=absmiddle> &nbsp;";
           if ($conf[0]!='Нет значения')
             if ($conf[1]==0)
               echo  $conf[0];

          //Если картинка установлена и справа
          if ($conf[1]==0)
            if ($conf[24]==1)
                   if ($conf[28]=='right')
                   echo "&nbsp;&nbsp;<img src=img/us".$conf[25].".png border=0 align=absmiddle> &nbsp;";
          echo   "</td></tr>";

      echo"<tr><td>";



         echo "<table border=0 width=100% id='userPar'><tr><td colspan=2>";

          //Если заголовок внутри информера, пишем то же.


                 if ($conf[1]==1)
                   if ($conf[24]==1)
                   if ($conf[28]=='left')
                    echo "<img src=img/us".$conf[25].".png border=0 align=absmiddle> &nbsp;";

          if ($conf[0]!='Нет значения')
           if ($conf[1]==1)

             echo  "<font id='headPar'>". $conf[0]."</font>";

          //Если картинка установлена и справа

          if ($conf[1]==1)
            if ($conf[24]==1)
                   if ($conf[28]=='right')
                   echo "&nbsp;&nbsp;<img src=img/us".$conf[25].".png border=0 align=absmiddle>";


        echo "</td></tr><tr>";
               //Записи, картинка
          if ($conf[26]==1)
                   if ($conf[29]=='left')
                    echo "<td valign=".$conf[30]." width=10% align=left><img src=img/us".$conf[27].".png border=0 ></td>";
          echo "<td>";
           chdir("..");
          if ($conf[2]!='Нет значения')
           {
              //Проверяем файл
       	       $strpath="us/oll.txt";
               if (file_exists($strpath))
                {
 	              @$f=fopen($strpath,'r');
                  $dbOll=fread($f, filesize($strpath));
                  fclose($f);
                }
                else $dbOll=0;
                //Ищем и заменяем 0
                $text_dbOll=str_replace("0",$dbOll,$conf[2]);

                if ($conf[32]==1) echo "<div align=".$conf[36].">";
                echo "<font id='ollPar'> &nbsp;".@$text_dbOll."</font>";
                if ($conf[32]==1) echo "</div>";

           }

            if ($conf[3]!='Нет значения')
           {
              //Проверяем файл
       	        $strpath="us/today.txt";

               if (file_exists($strpath))
                {
 	              $arrToday=file($strpath);
 	              $today=0;
 	              //Исключаем из показателя боты
 	              foreach($arrToday as $line)
 	               {
 	               	 $line=trim($line);
 	               	 $explToday=explode("|",$line);
 	               	 if($explToday[3]!="")$today++;
 	               }
                  $dbToday=$today;

                }
                else $dbToday=0;
                //Ищем и заменяем 0
                $text_dbToday=str_replace("0",$dbToday,$conf[3]);
                if ($conf[33]==1) echo "<div align=".$conf[37].">";
                echo "<font id='todayPar'> &nbsp;".@$text_dbToday."</font>";
                if ($conf[33]==1) echo "</div>";

           }

            if ($conf[4]!='Нет значения')
           {
              //Проверяем файл
       	       $strpath="us/online.txt";
               if (file_exists($strpath))
                {
 	              @$f=fopen($strpath,'r');
                  $arrOnline=file($strpath);
                  $dbOnline=count($arrOnline);
                  fclose($f);
                }
                else $dbOnline=0;
                //Ищем и заменяем 0
                $text_dbOnline=str_replace("0",$dbOnline,$conf[4]);
                 if ($conf[33]==1) echo "<div align=".$conf[38].">";
                echo "<font id='onlinePar'> &nbsp;".@$text_dbOnline."</font>";
                if ($conf[33]==1) echo "</div>";

           }

           echo "</td>";
              if ($conf[26]==1)
                   if ($conf[29]=='right')
                    echo "<td valign=".$conf[30]." width=10% align=right>&nbsp;<img src=img/us".$conf[27].".png border=0 ></td>";

              chdir("./admin");


     echo "</tr></table>
     </td></tr></table>";

     ?>
     </td>
	</tr>

         <tr bgcolor=#F0F0F0 valign=top>
		<TD width=30%><h3>Заголовок</h3>
		 Например <i>Кто на сайте</i><br>
		 Если не хотите заголовок, оставьте пустым окно.  <br>
		 Если вы хотите установить заголовок внутри прямоугольной
		 области со значениями, поставьте галочку.
		</td>
		<td><input name="text_head" type="text"  size=60 value="<? echo @$conf[0] ?>"><br>
		<input name="head_int" type="checkbox"<? echo $check_head_int; ?> value="1" >&nbsp;&nbsp;
		Расположить внутри информера.
</td>
</tr>

		<tr  valign=top>
		<TD width=30%><h3>Надписи</h3>
		Надпись может быть произвольной, вместо количества посетителей
		поставьте <font color=#0080FF>0</font> (нуль)<br>Например <i>Нас просматривают <font color=#0080FF>0</font> посетителей<br>
		На сайте <font color=#0080FF>0</font> гостей<br>
		<font color=#0080FF>0</font> посетителей на сайте</i><br>и так далее.<br>Можете оставить просто 0(нуль),
		тогда будет только число.<br>
		Оставьте пустым окошко, если не хотите, чтобы это значение отображалось.
		</td>
		<td>Всего<br>
		<input name="text_oll" type="text"  size=60 value="<? echo @$conf[2]; ?>"> <br>


		Всего сегодня<br>
		<input name="text_today" type="text"  size=60 value="<? echo @$conf[3]; ?>"><br>
		В данный момент<br>
		<input name="text_online" type="text"  size=60 value="<? echo @$conf[4]; ?>" >
		</td>
		</tr>

		 <tr  valign=top bgcolor=#F0F0F0>
		<TD width=30%><h3>Цвета</h3>
		Можете проставить буквенное значение, напр. blue, red,
		или в кодах
		</td>
		<td>
		<table>
		<tr>
		<td>Заголовок</td>
		<td><input name="color_head" type="text" size=10  value="<? echo @$conf[5]; ?>" ></td><td><b><big><font color= <? echo @$conf[5]; ?> > тест
		</font></big></b></td>
		</tr>
		<tr>
		<td>Всего</td>
		<td><input name="color_oll" type="text"  size=10 value="<? echo @$conf[6]; ?>"></td><td><b><big><font color= <? echo @$conf[6]; ?> > тест
		</font></big></b></td>
		</tr>
		<tr><td>
		Всего сегодня</td>
		<td><input name="color_today" type="text"  size=10 value="<? echo @$conf[7]; ?>" ></td><td><b><big><font color= <? echo @$conf[7]; ?> > тест
		</font></big></b></td>

		<tr>
		<td>В данный момент</td>
		<td><input name="color_online" type="text"  size=10 value="<? echo @$conf[8]; ?>" ></td><td><b><big><font color= <? echo @$conf[8]; ?> > тест
		</font></big></b></td>
		</tr>
		</table>
		</tr>

		 <tr  valign=top >
		<TD width=30%><h3>Размер шрифта</h3>
        Определён в пунктах. В пунктах измеряется размер шрифтов в Word
		</td>
		<td>
		<table>
		<tr>
		<td>Заголовок</td>
		<td> <SELECT NAME="size_head">
<OPTION value="10" <?  echo @$check_size_head[0]; ?>>10</option>
<OPTION value="12" <?  echo @$check_size_head[1]; ?>>12</option>
<OPTION value="14" <? echo @$check_size_head[2]; ?>>14</option>
<OPTION value="16" <? echo @$check_size_head[3]; ?>>16</option>
<OPTION value="18" <? echo @$check_size_head[4]; ?>>18</option>
<OPTION value="20" <? echo @$check_size_head[5]; ?>>20</option>
</SELECT>&nbsp;&nbsp;pt</td>
		</tr>
		<tr>
		<td>Всего</td>
		<td> <SELECT NAME="size_oll">
<OPTION value="8" <?  echo @$check_size_oll[0]; ?>>8</option>
<OPTION value="9" <? echo  @$check_size_oll[1]; ?>>9</option>
<OPTION value="10" <? echo @$check_size_oll[2]; ?>>10</option>
<OPTION value="11" <? echo @$check_size_oll[3]; ?>>11</option>
<OPTION value="12" <? echo @$check_size_oll[4]; ?>>12</option>
</SELECT>&nbsp;&nbsp;pt</td>
		</tr>
		<tr><td>
		Всего сегодня</td>
		<td> <SELECT NAME="size_today">
<OPTION value="8" <?  echo @$check_size_today[0]; ?>>8</option>
<OPTION value="9" <?  echo @$check_size_today[1]; ?>>9</option>
<OPTION value="10" <? echo @$check_size_today[2]; ?>>10</option>
<OPTION value="11" <? echo @$check_size_today[3]; ?>>11</option>
<OPTION value="12" <? echo @$check_size_today[4]; ?>>12</option>
</SELECT>&nbsp;&nbsp;pt</td>

		<tr>
		<td>В данный момент</td>
		<td> <SELECT NAME="size_online">
<OPTION value="8" <?  echo @$check_size_online[0]; ?>>8</option>
<OPTION value="9" <? echo  @$check_size_online[1]; ?>>9</option>
<OPTION value="10" <? echo @$check_size_online[2]; ?>>10</option>
<OPTION value="11" <? echo @$check_size_online[3]; ?>>11</option>
<OPTION value="12" <? echo @$check_size_online[4]; ?>>12</option>
</SELECT>&nbsp;&nbsp;pt</td>
		</tr>
		</table>
		</tr>
     <tr  valign=top bgcolor=#F0F0F0>
      <td>
        <h3>Начертание шрифта</h3>
     </td>
     <td>

     <table>
		<tr>
		<td>Заголовок</td>
		<td><SELECT NAME="font_head">
<OPTION value="normal" <?  echo @$check_font_head[0]; ?> >Нормальный</option>
<OPTION value="italic" <?  echo @$check_font_head[1]; ?> >Наклонный</option>
<OPTION value="bold" <? echo @$check_font_head[2]; ?> >Жирный</option>
</SELECT></td>
		</tr>
		<tr>
		<td>Всего</td>
		<td><SELECT NAME="font_oll">
<OPTION value="normal" <?  echo @$check_font_oll[0]; ?>>Нормальный</option>
<OPTION value="italic" <?  echo @$check_font_oll[1]; ?>>Наклонный</option>
<OPTION value="bold"<? echo @$check_font_oll[2]; ?>>Жирный</option>
</SELECT></td>
		</tr>
		<tr><td>
		Всего сегодня</td>
		<td><SELECT NAME="font_today">
<OPTION value="normal" <?  echo @$check_font_today[0]; ?>>Нормальный</option>
<OPTION value="italic" <?  echo @$check_font_today[1]; ?>>Наклонный</option>
<OPTION value="bold"<? echo @$check_font_today[2]; ?>>Жирный</option>
</SELECT></td>

		<tr>
		<td>В данный момент</td>
		<td><SELECT NAME="font_online">
<OPTION value="normal" <?  echo @$check_font_online[0]; ?>>Нормальный</option>
<OPTION value="italic" <?  echo @$check_font_online[1]; ?>>Наклонный</option>
<OPTION value="bold"<? echo @$check_font_online[2]; ?>>Жирный</option>
</SELECT></td>
		</tr>
		</table>

     </td>

     </tr>
	 <tr  valign=top >
		<TD width=30%><h3>Цвет фона</h3>
		Это цвет прямоугольной области с надписью.<br>
		Можете проставить буквенное значение, напр. blue, red,
		или в кодах
		</td>
		<td><input name="color_fon" type="text"  size=10 value="<? echo @$conf[17]; ?>" >&nbsp;&nbsp;<b><big><font color= <? echo @$conf[17]; ?> > тест
		</font></big></b></td>
		</tr>

	 <tr  valign=top bgcolor=#F0F0F0>
		<TD width=30%><h3>Рамка</h3>
        Рамка вокуг прямоугольной области с надписью.<br>
        Определите внешний вид и цвет с четырёх сторон.<br>
        <b>Внимание!</b> При выборе значения 'Двойная', ширину нужно выставить
        не менее 3
		</td>
		<td>
		Вид&nbsp;&nbsp;
		<SELECT NAME="border">
<OPTION value="none" <?  echo @$check_border[0]; ?>>Нет</option>
<OPTION value="dotted" <?  echo @$check_border[1]; ?>>Точки</option>
<OPTION value="dashed" <? echo @$check_border[2]; ?>>Пунктир</option>
<OPTION value="solid" <? echo @$check_border[3]; ?>>Сплошная</option>
<OPTION value="double" <? echo @$check_border[4]; ?>>Двойная</option>
</SELECT>&nbsp;&nbsp;

Ширина в пикселах&nbsp;&nbsp;
		<SELECT NAME="border_width">
<OPTION value="1" <?  echo @$check_border_width[0]; ?>>1</option>
<OPTION value="2" <?  echo @$check_border_width[1]; ?>>2</option>
<OPTION value="3" <?  echo @$check_border_width[2]; ?>>3</option>
<OPTION value="4" <?  echo @$check_border_width[3]; ?>>4</option>
<OPTION value="5" <?  echo @$check_border_width[4]; ?>>5</option>
</SELECT>&nbsp;&nbsp;px<br><br>

<b>Цвет</b><br>
Слева&nbsp;&nbsp;&nbsp;&nbsp;<input name="border_left_color" type="text"  size=10 value="<? echo @$conf[20]; ?>">&nbsp;&nbsp;<b><big><font color= <? echo @$conf[20]; ?> > тест
		</font></big></b>&nbsp;&nbsp;
Справа&nbsp;&nbsp;<input name="border_right_color" type="text" value="<? echo @$conf[21]; ?>" size=10>&nbsp;&nbsp;<b><big><font color= <? echo @$conf[21]; ?> > тест
		</font></big></b><br>
Сверху&nbsp;&nbsp;<input name="border_top_color" type="text" value="<? echo @$conf[22]; ?>" size=10>&nbsp;&nbsp;<b><big><font color= <? echo @$conf[22]; ?> > тест
		</font></big></b>&nbsp;&nbsp;
Снизу&nbsp;&nbsp;&nbsp;&nbsp;<input name="border_bottom_color" type="text" value="<? echo @$conf[23]; ?>" size=10>&nbsp;&nbsp;<b><big><font color= <? echo @$conf[23]; ?> > тест
		</font></big></b>&nbsp;&nbsp;

</td>
</tr>

<tr  valign=top >
		<TD width=30%><h3>Картинки</h3>
		Поставьте галочку, если хотите, чтобы картинка изображалась около
		заголовка и (или) надписи и выберите картинку.
		</td>
		<td>

		 <table widnh=100% border=0><tr>
		  <td></td>
          <td><img src="img/us1.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us2.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us3.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us4.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us5.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us6.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us7.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us8.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us9.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us10.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us11.png"  alt="" border="0" align=absmiddle></td>
          <td><img src="img/us12.png"  alt="" border="0" align=absmiddle></td>
           </tr>
           <tr align=center>
           <td><input name="img_head_on" type="checkbox" value="1" <?echo @$check_img_head_on ?> ></td>

           <td><input name="usH" type="radio" value="1" <? echo $check_usH[1] ?> ></td>
           <td><input name="usH" type="radio" value="2" <? echo $check_usH[2] ?>></td>
           <td><input name="usH" type="radio" value="3" <? echo $check_usH[3] ?>></td>
           <td><input name="usH" type="radio" value="4" <? echo $check_usH[4] ?>></td>
           <td><input name="usH" type="radio" value="5" <? echo $check_usH[5] ?>></td>
           <td><input name="usH" type="radio" value="6" <? echo $check_usH[6] ?>></td>
           <td><input name="usH" type="radio" value="7" <? echo $check_usH[7] ?>></td>
           <td><input name="usH" type="radio" value="8" <? echo $check_usH[8] ?>></td>
           <td><input name="usH" type="radio" value="9" <? echo $check_usH[9] ?>></td>
           <td><input name="usH" type="radio" value="10" <? echo $check_usH[10] ?>></td>
           <td><input name="usH" type="radio" value="11" <? echo $check_usH[11] ?>></td>
           <td><input name="usH" type="radio" value="12" <? echo $check_usH[12] ?>> </td>
           </tr>
           <tr align=center>
           <td><input name="img_on" type="checkbox" value="1" <?echo @$check_img_on ?>></td>
           <td><input name="us" type="radio" value="1" <? echo $check_us[1] ?> ></td>
           <td><input name="us" type="radio" value="2" <? echo $check_us[2] ?>></td>
           <td><input name="us" type="radio" value="3" <? echo $check_us[3] ?>></td>
           <td><input name="us" type="radio" value="4" <? echo $check_us[4] ?>></td>
           <td><input name="us" type="radio" value="5" <? echo $check_us[5] ?>></td>
           <td><input name="us" type="radio" value="6" <? echo $check_us[6] ?>></td>
           <td><input name="us" type="radio" value="7" <? echo $check_us[7] ?>></td>
           <td><input name="us" type="radio" value="8" <? echo $check_us[8] ?>></td>
           <td><input name="us" type="radio" value="9" <? echo $check_us[9] ?>></td>
           <td><input name="us" type="radio" value="10" <? echo $check_us[10] ?>></td>
           <td><input name="us" type="radio" value="11" <? echo $check_us[11] ?>></td>
           <td><input name="us" type="radio" value="12" <? echo $check_us[12] ?>> </td>
           </tr>




</td>
</tr>

           </table>

		</td>
		</tr>

        <tr bgcolor=#F0F0F0 valign=top>
		<TD><h3>Положение картинки</h3>
		Определите положение картинки рядом с заголовком
		и в прямоугольной области со значениями.
		</td>
		<td>
		К заголовку<br>Справа&nbsp;&nbsp;
		<input name="img_align_head" type="radio" value="right" <?echo @$check_img_align_head_right; ?> >&nbsp;&nbsp;
		Слева&nbsp;&nbsp;
		<input name="img_align_head" type="radio" value="left" <?echo @$check_img_align_head_left; ?>><br><br>
		В области значений<br><br> По горизонтали <br>
        Справа&nbsp;&nbsp;
		<input name="img_align" type="radio" value="right" <?echo @$check_img_align_right; ?>>&nbsp;&nbsp;
		Слева&nbsp;&nbsp;
		<input name="img_align" type="radio" value="left" <?echo @$check_img_align_left; ?>><br><br>

        По вертикали <br>
        Верх&nbsp;&nbsp;
		<input name="img_valign" type="radio" value="top" <?echo @$check_img_valign_top; ?>>&nbsp;&nbsp;
		Низ&nbsp;&nbsp;
		<input name="img_valign" type="radio" value="bottom" <?echo @$check_img_valign_bottom; ?>>&nbsp;&nbsp;
        Центр&nbsp;&nbsp;
		<input name="img_valign" type="radio" value="center" <?echo @$check_img_valign_center; ?>>


         <tr valign=top>
		<TD width=30%><h3>Расположение надписей</h3>
		 Заголовок и запись об общем количестве посещений расположены
		 на разных строках, определите расположение записей о сегодняших посещениях
		 и посетителей online. <br>
		 Определите выравнивание записей в информере.
		</td>
		<td>
          <input name="stroc_today" type="checkbox" value="1" <?echo @$check_stroc_today ?> >&nbsp;&nbsp;
          Перенести запись о посетителей сегодня на другую строку<br>
          <input name="stroc_online" type="checkbox" value="1" <?echo @$check_stroc_online ?>>&nbsp;&nbsp;
          Перенести запись о посетителей online на другую строку<br><br>
          Посещений всего&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<SELECT NAME="alignOll">
<OPTION value="left" <?  echo @$check_align_oll[0]; ?>>Слева</option>
<OPTION value="center" <?  echo @$check_align_oll[1]; ?>>В центре</option>
<OPTION value="right" <? echo @$check_align_oll[2]; ?>>Справа</option>
</SELECT><br><br>

 Посещений сегодня&nbsp;&nbsp;<SELECT NAME="alignToday">
<OPTION value="left" <?  echo @$check_align_today[0]; ?>>Слева</option>
<OPTION value="center" <?  echo @$check_align_today[1]; ?>>В центре</option>
<OPTION value="right" <? echo @$check_align_today[2]; ?>>Справа</option>
</SELECT><br><br>

Посещений сейчас&nbsp;&nbsp;&nbsp;&nbsp;<SELECT NAME="alignOnline">
<OPTION value="left" <?  echo @$check_align_online[0]; ?>>Слева</option>
<OPTION value="center" <?  echo @$check_align_online[1]; ?>>В центре</option>
<OPTION value="right" <? echo @$check_align_online[2]; ?>>Справа</option>
</SELECT>

        </td>
        </tr>

         <tr valign=top bgcolor=#F0F0F0 >
		<TD width=30%><h3>Размер информера</h3>
		 Определите ширину и высоту информера
		</td>
		<td>
          Ширина&nbsp;&nbsp;
          <input name="width" type="text"  size=10 value="<?echo @$conf[34] ?>">&nbsp;px&nbsp;&nbsp;
           Высота&nbsp;&nbsp;
          <input name="height" type="text"  size=10 value="<?echo @$conf[35] ?>">&nbsp;px
        </td>
        </tr>

		<TR><td colspan=2><font size=4 color=#408080 ><h2>Система</h2></td></tr>
       <tr valign=top>
       <td>
          <h3>Время неактивности.</h3>
          Когда посетитель заходит на очередную страницу вашего сайта,
          скрипт регистрирует его присутствие, но если какое-то время посетитель не
          подаёт признаков жизни, он считается ушедшим с сайта.
          Это время вам предлагается определить самим. Оно зависит от содержимого сайта.<br>
          Если он рекламного или презинтационного характера, 5-10 мин хватит. Если у вас статьи, книги,
          программы, можно выставить до 30 мин. Однако не увлекайтись большими интервалами, т.к. в онлайне
          мало кто так долго изучает одну страницу, а если посетитель загрузит очередную страницу, т.е. проявит активность,
           данные о нём обновятся.

       </td>
       <td>
       <SELECT NAME="online_min">
<OPTION value=5 <?  echo @$check_online_min[5]; ?>>5</option>
<OPTION value=10 <? echo @$check_online_min[10]; ?>>10</option>
<OPTION value=15 <? echo @$check_online_min[15]; ?>>15</option>
<OPTION value=20 <? echo @$check_online_min[20]; ?>>20</option>
<OPTION value=25 <? echo @$check_online_min[25]; ?>>25</option>
<OPTION value=30 <? echo @$check_online_min[30]; ?>>30</option>
<OPTION value=35 <? echo @$check_online_min[35]; ?>>35</option>
<OPTION value=40 <? echo @$check_online_min[40]; ?>>40</option>
<OPTION value=45 <? echo @$check_online_min[45]; ?>>45</option>
<OPTION value=50 <? echo @$check_online_min[50]; ?>>50</option>
<OPTION value=55 <? echo @$check_online_min[55]; ?>>55</option>
<OPTION value=60 <? echo @$check_online_min[60]; ?>>60</option>
</SELECT>&nbsp;&nbsp;минут
       </td>
       </tr>

       <tr valign=top bgcolor=#F0F0F0>
		<TD width=30%><h3>Статистика</h3>
		 Вы можете обнулить счётчики и статистика будет вестись заново. &nbsp;
		</td>
		<td>
		<table><tr>
		<td >Обнулить общий счётчик посетителей&nbsp;</td>
		<td><input name="stat_com" type="checkbox" value="1"></td></tr>
		<tr>
		<td >Обнулить счётчик посетителей за сегодня&nbsp;</td>
		<td><input name="stat_today" type="checkbox" value="1"></td></tr>
		<tr>
		<td >Обнулить счётчик посетителей на данный момент</td>
		<td><input name="stat_online" type="checkbox" value="1"></td></tr>
		</table>
</td>
</tr>

 <tr valign=top >
		<TD width=30%><h3>Логин, пароль</h3>
		 Изменить логин и пароль для входа в панель управления
		</td>
		<td>
          Логин&nbsp;&nbsp;
          <input name="login" type="text"  size=10>
           Пароль&nbsp;&nbsp;
          <input name="pasw" type="text"  size=10 >
        </td>
        </tr>

 <TR  bgcolor=#F0F0F0><td colspan=2><input type="submit" value="Сохранить" name=go></td></tr>
 </form>
 </table>
</body>
</html>