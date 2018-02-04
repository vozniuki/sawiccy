<?PHP
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

if (@$_POST['list']=='1')  echo "<meta http-equiv=refresh content='0; url=admin.php?sel1=selected'>";
if (@$_POST['list']=='2') echo "<meta http-equiv=refresh content='0; url=admin1.php?sel2=selected'>";
if (@$_POST['list']=='3')  echo "<meta http-equiv=refresh content='0; url=admin2.php?sel3=selected'>";
if (@$_POST['list']=='4')  echo "<meta http-equiv=refresh content='0; url=admin3.php?sel4=selected'>";
if (@$_POST['list']=='5')  echo "<meta http-equiv=refresh content='0; url=admin4.php?sel5=selected'>";



 //Определим ссылку для справки
 if (empty($_GET) || isset($_GET['sel1']))$link="help_admin.html#options";
 if (isset($_GET['sel2']))$link="help_admin.html#stat1";
 if (isset($_GET['sel3']))$link="help_admin.html#stat2";
 if (isset($_GET['sel4']))$link="help_admin.html#agent";
 if (isset($_GET['sel5']))$link="help_admin.html#nonagent";



?>
<HTML>
<head>

 <script language='JavaScript1.1' type='text/javascript'>
<!--

  function help(link)
  {
    mainwin=window.open(link,'',
   'Width=800, height=600,status=yes,toolbar=no,menubar=no,scrollbars=yes,resizeable=yes');

  }


//-->
</script>

 <style>
A:Link,A:Visited,A:Active { Color: ".@$cont[0]."; Text-decoration: none}
A:Hover{ Color: ".@$cont[0]."; Text-decoration: none}
table {

 	     font-size:10pt;
      }
</style>



<TITLE>Администрирование</TITLE>
</head>
<BODY BGCOLOR='#E6E6E6'>
<CENTER><table border=0 CELLPADDING=0 CELLSPACING=0  width=70%><tr><td >

<IMG SRC='img/log.png' ALIGN='center' >&nbsp&nbsp&nbsp&nbsp
<font size=+3 color=#408080 ><b><tt>Администрирование</tt></b></font></td>
<td align=right>
<form  action='cap.php' method='post' name='cap'>

<select  name="list" onchange="cap.submit();">
<OPTION value="1" <? echo @$_GET['sel1']; ?> >Информер- внешний вид </option>
<OPTION value="2" <? echo @$_GET['sel2']; ?>   >Текущая статистика</option>
<OPTION value="3" <? echo @$_GET['sel3']; ?>  >Общая статистика</option>
<OPTION value="4" <? echo @$_GET['sel4']; ?>  >Узнаваемые агенты</option>
<OPTION value="5" <? echo @$_GET['sel5']; ?>  >Нежелательные агенты</option>
</SELECT>&nbsp;&nbsp;

</form>

<?php

 echo "<a href=# onClick=\"javascript:help('".@$link."');\">
 <img src='img/help.png' alt='Контекстная справка' border=0></a>&nbsp;&nbsp;";
//Ссылка для возврата
echo "<a href=http://".$_SERVER['SERVER_NAME']."><img src='img/exit.png' alt='На главную страницу' border=0></a>";


?>
</td></tr>
</table></CENTER><p>



