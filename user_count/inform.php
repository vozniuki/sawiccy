<?

 $strpath="user_count/admin/config/conf.txt";
@$f=fopen($strpath,r);
$conf=file($strpath);
fclose($f);

for($i=0; $i<count($conf);$i++)
 {
 	 str_replace("\r\n", "",$conf[$i]);
 	 $conf[$i]=trim($conf[$i]);
 }

 echo"
  <table border=0>";
    //Если заголовок присутствует
            echo  "<tr><td id='headPar' colspan=2>";
         	//Если картинка разрешена и слева
         	if ($conf[1]==0)
              if ($conf[24]==1)
                   if ($conf[28]=='left')
                    echo "<img src=/user_count/admin/img/us".$conf[25].".png border=0 align=absmiddle> &nbsp;";
           if ($conf[0]!='Нет значения')
             if ($conf[1]==0)
               echo  $conf[0];

          //Если картинка установлена и справа
          if ($conf[1]==0)
            if ($conf[24]==1)
                   if ($conf[28]=='right')
                   echo "&nbsp;&nbsp;<img src=/user_count/admin/img/us".$conf[25].".png border=0 align=absmiddle> &nbsp;";
          echo   "</td></tr>";

      echo"<tr><td>";



         echo "<table border=0 width=100% id='userPar'><tr><td colspan=2>";

          //Если заголовок внутри информера, пишем то же.


                 if ($conf[1]==1)
                   if ($conf[24]==1)
                   if ($conf[28]=='left')
                    echo "<img src=/user_count/admin/img/us".$conf[25].".png border=0 align=absmiddle> &nbsp;";

          if ($conf[0]!='Нет значения')
           if ($conf[1]==1)

             echo  "<font id='headPar'>". $conf[0]."</font>";

          //Если картинка установлена и справа

          if ($conf[1]==1)
            if ($conf[24]==1)
                   if ($conf[28]=='right')
                   echo "&nbsp;&nbsp;<img src=/user_count/admin/img/us".$conf[25].".png border=0 align=absmiddle>";


        echo "</td></tr><tr>";
               //Записи, картинка
          if ($conf[26]==1)
                   if ($conf[29]=='left')
                    echo "<td valign=".$conf[30]." width=10% align=left><img src=/user_count/admin/img/us".$conf[27].".png border=0 ></td>";
          echo "<td>";

          if ($conf[2]!='Нет значения')
           {
              //Проверяем файл
       	       $strpath="user_count/us/oll.txt";
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
       	       $strpath="user_count/us/today.txt";

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
       	       $strpath="user_count/us/online.txt";
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
                    echo "<td valign=".$conf[30]." width=10% align=right>&nbsp;<img src=/user_count/admin/img/us".$conf[27].".png border=0 ></td>";




     echo "</tr></table>
     </td></tr></table>";

?>
