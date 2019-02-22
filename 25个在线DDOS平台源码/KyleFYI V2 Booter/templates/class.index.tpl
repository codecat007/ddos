<br><br>
{section name=list loop=$iplogged} 
<center>
<b><font size="3">{$iplogged[list].subject}</font></b>
<br>
{$iplogged[list].message}<br>
Posted by <b>{$iplogged[list].username} </b> on <b>{$iplogged[list].date}</b><br><br></center>

{/section}