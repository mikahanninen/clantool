clantool
========

World of Tanks clan tool for managing clan wars

Now working features
* Retrieving clan members
* Retrieving all clan member vehicles (all vehicles above Tier 8, all SPG's above tier 6 and all light tanks above tier 4)
* Uploading (completed) replays
* Retrieving data out of replays
* All relevent data is stored in a MySQL database
* Members page will show :
* Name
* Position
* Calculated CW battle data :
* Total battles fought
* Total victories
* Total deaths
* Total frags
* Date of last battle fought
* Member since
* Left clan on (calculated with last_update)
* Vehicles page will show :
* Membername
* A "." for all vehicles that member possesses
* If a vehicle is locked the "." will be replaced by the duration that vehicles will be locked.

What is needed to run this tool :

* Apache and MySQL. I have used Xampp (Portable lite) : http://www.apachefri...g/en/xampp.html
* Jquery. http://jquery.com/download/
* Jquery-UI. http://jqueryui.com/download
* Datatables Jquery plugin. http://datatables.net/download/
Also from the above downloadlink :
* ColVis
* FixedColumns
* Uploadify. http://www.uploadify.com/download/
* ClanManagement Database (SQL is in the zip file that will setup up basic structure)

All files are in the attached rar. Be aware that somehow Jquery 1.8.2 doesnt work properly with DataTables. So dont update unless you know what you are doing.
I have updated Jquery to version 1.8.2 / Jquery UI to version 1.8.24 / DataTables to version 1.9.4 and now it all seems to be working. New rar attached


- Setup Apache
* Copy all files in rar in a folder in htdocs
- Setup MySQL
* Create account in MySQL for data access.
* Run SQL to create structure
- Edit line 526 in 'functions.php' to match credentials for MySQL account

* Access webpage and try to update to test if data retrieval is possible.