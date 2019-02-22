1-You will need to edit the following files with your database info in them!

dbc.php
shellcounter.php
includes/ezSQL.php ( line 44, 71 and 101 )

2-Now upload inside the folder "Source" all the files on your host.

3-You will then need to run the SQL in the localhost.sql in phpmyadmin.

4-Then you need to go http://YOURWEBSITE/register.php and make an account.

5-You will then need to go back into phpmyadmin and put 1 for activated and 5 for admin

----------------------------------------

Ranks

5 - admin
4 - staff
1 - customer

----------------------------------------
Things to edit:

-If you want to edit the contact info of your booter => footer1.php
-If you want to edit the music player of your booter => footer.php => http://www.playlist.com/

-Ip grabber note: 
The link that you need to send to people for grab their ips is:
http://YOURBOOTERLINK.com/ips2.php 
Then once a people cliked on this link, a folder named "log.txt" will be automaticly created. For the log.txt appear on the ipgrabber.php, you wil need to edit the line 239 (ipgrabber.php. This : http://**********/ips2.php for http://YOURBOOTER/ips2.php

NOTE: PUT 777 for the right of /ips2.php because some host denied the permission.

---------------------------------------

CHAT Box
For make your own chat, go to : http://www.chatango.com/creategroup

--------------------------------------

You have 2 psd for 
banner.psd, you need to save it as banner.jpg and put it in the /images/ directory.
logo.psd, you need to save it as logo.jpg and put it in the /images/ directory.