# <div align='cetner'>Pollster</div>

The sexiest Voting Web App! Ever!

## Features 

<ul>
	<li>Completely Responsive Design</li>
	<li>Fluid User Interface</li>
	<li>Inbuilt Theme Editor</li>
	<li>Complete User Management Module</li>
	<li>Restricted Access to major parts of the UI</li>
	<li>Fully Functional Administator Control Panel</li>
	<li></li>
</ul>

## Pre - Requisites

The following aspects need to be pre installed on any system for the script to run : 

<ul>
	<li>A Web Server that is capable of running PHP.</li>
	<li>PHP (5+)</li>
	<li>MySQL</li>
	<li>Preferrably a MySQL Control Panel such as PHPMyAdmin.</li>
</ul>

## Download and Installation

The script can be downloaded either by downloading it as a Zip from the Github Repository, or downloaded as a project from the Git Command Line using the following commands.

```git
git clone https://github.com/deve-sh/Pollster.git
cd Pollster
```

After the script has successfully downloaded, start the web server that contains the folder and head over to the web server in your browser. The Script will automatically redirect you to the Installation Page.

<b>Only MySQL Improved Databases are supported.</b>

## Editing Features

The Script on a whole is customisable upto an extent. Install the script, and head over to the Administrator Section to view the different options you may have.

The Script has an inbuilt Theme Editor using which you may customise the style of your Web App Upto a high amount.

## Turning Error Reporting On

<b>This requires file writing and reading privileges.</b>
Something not all the Hosting Users have.

Error Reporting is disabled by default in the script, but if you want to use a safer version of the Script; you can turn the Error Reporting On.

Just go to the two files <b>config.php</b> in the <b>inc/</b> folder and the <b>adminconfig.php</b> file in the <b>admin/</b> folder. Change/Remove the following line : 

```php
error_reporting(0);
```

## License and Support

The Script is Licensed under the <a href='https://github.com/deve-sh/Pollster/blob/master/LICENSE' target="_blank">MIT License</a>.

For any Support, feel free to create an issue or contact me at devesh2027@gmail.com.
