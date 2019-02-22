
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Login</title>

<link href="includes/style.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>


</head>
<body>
<table align="center" style="width:700">
	<tr>
	  <td style="width:100%; height="337">			
			<table width="750" align="center">
				<tr>
				  <td height="40" valign="top" >&nbsp;</td>
			  </tr>
				<tr>
					<td width="750" height="178" valign="top" >
					<table width="417" align="center" class="table">
                      <tbody>
                        <tr>
                          <td colspan="3" width="413" height="21" valign="middle" class="head">
                            <div align="center">Login</div></td>
                        </tr>
                            <form id="loginForm" name="loginForm" method="post" action="login-exec.php">
                                <tr>
                                  <td colspan="2" class="cell"><div align="right">User Name</div></td>
                                  <td class="cell"><input name="login" type="text" class="entryfield" id="login2" /></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cell"><div align="right">Password</div></td>
                                  <td class="cell"><input name="password" type="password" class="entryfield" id="password" /></td>
                                </tr>
                                <tr >
                                  <td colspan="3" class="cell" align="right"><input name="Submit" class="button" id="input3" type="submit" value="Login" /></td>
                                </tr>
                          </form>
                      </tbody>
                    </table></td>
				</tr>
			</table>				
	  </td>
	</tr>
</table>
</body>
</html>


