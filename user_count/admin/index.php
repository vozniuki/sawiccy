<?php
session_start();

echo  "<html>
<body>

<table CELLPADDING=10 CELLSPACING=10 width=25% align=center><tr><td >
<font color=#C0C0C0
 size=5>Информер</font>
</td></tr>
<td>&nbsp</td></tr><tr><td></td></tr>
<tr><td bgcolor=#FFFFE8 ><h3><font color=#408080> Авторизация</font></h3>
<FORM ACTION='admin.php' METHOD='POST'>
<tt><font color=#408080> Имя</font></tt><br>
<INPUT TYPE='text' NAME='login' SIZE='30'  ><p>
<tt><font color=#408080> Пароль</font></tt><br>
<INPUT TYPE='password' NAME='pasw' SIZE='30'  ><p>
<INPUT TYPE='hidden' NAME='id' value=". session_id(). "   >
<INPUT TYPE='submit' VALUE='Вход'>
</form><tr><td >";

echo  " </td></tr>
</td></tr>
</table>

</body>
</html>";


?>