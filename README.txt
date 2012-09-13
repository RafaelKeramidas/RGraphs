RGraph - SA-MP Server Graphs

# ABOUT
RGraph is a free SA-MP Graph generator for your servers. Show other people how many players were on your server those last 24 hours !

@ Author
This project was developped by Rafael 'R@f' Keramidas <rafael@keramid.as>.

@ Donations
If you like this project or make a commercial use for it, please donate via paypal at rafael.keramidas@gmail.com. Of course you don't have to but it would be nice if you do :)

@ Credits/Thanks
pChart : An awesome chart generator for PHP http://pchart.sourceforge.net/

# LICENCE
This project is released under GPLv3. Read the GPLv3.txt for more information.

# REQUIRED
LibGD & Sockets for PHP. 

# INSTALL
1. Put all files in your web directory (except the "cron" folder).
2. Copy/Paste the content of rpgrah.sql in your MySQL Database.
3. Change the config file with your MySQL credentials (located at "includes/config.inc.php").
4. Setup a half-hourly (30 minutes) or hourly Cronjob or Scheduled Task on "cron/fetchstats.cron.php".
5. Add one or multiple servers and wait 24 hours to get the full stats.
6. Share you graphs !

# PREVIEW
Small chart : http://uppix.net/0/1/6/02453ab8b4ef2fd83e5b3b658e8f1.png
Big chart : http://uppix.net/c/a/9/3c35a92bf5dbda7855a3c8cc0bf9d.png

# SUPPORT
I don't give ANY support for the installation or usage of this script, so please don't contact me for that !!
If you found a bug, write me at rafael@keramid.as and don't forget to put "RGraph" in the subject.

If you need help with Cronjobs : http://www.cyberciti.biz/faq/how-do-i-add-jobs-to-cron-under-linux-or-unix-oses/
If you need help with Scheduled Tasks : http://www.hosting.com/support/windows-server-2008/create-a-scheduled-task-in-windows-server-2008

# CHANGELOG
@ V1.0 - 13th September 2012
- Initial release.
