ScreenBin
==========
short URLs for screenshots @ [screenb.in](http://screenb.in/)

Requirements
---------------------
* [CakePHP](http://cakephp.org/)
* MySQL
* Amazon S3

Setup
---------------------
1. Get CakePHP
2. Hook up a MySQL database to your cake in [app/Config/database.php](https://github.com/dqian/screen-bin/blob/master/app/Config/database.php) (lines 62-69)
3. Import [screenshots.sql](https://github.com/dqian/screen-bin/blob/master/screenshots.sql) into your MySQL database
4. Get an Amazon AWS account
5. Add your S3 keys to [vendors/S3.php](https://github.com/dqian/screen-bin/blob/master/vendors/S3.php) (line 58) and [vendors/SimpleImage.php](https://github.com/dqian/screen-bin/blob/master/vendors/SimpleImage.php) (lines 48/49)

Notes
---------------------
* only able to paste into Chrome browsers

About
---------------------
Created at the Rice Summer Hackathon 2012 held at the [STARTHouston](http://starthouston.com) co-working space.