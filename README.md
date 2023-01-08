# moviesite
TMDB based movie site

*****************************************
Dynamic website for viewing top rated movies on TMDB
*****************************************
Languages:
PHP - Backend
MySQL - Database
Javascript - Client side functions
HTML/CSS - Front-end

PHP was used as the backend due to its versatility and being able to easily integrate  with javascript. PHP also boasts some safety features such as not being readible by browser source code viewers to prevent any sensitive user data from being seen.
Javascript is suitable to perform actions on DOM elements.

***************************************
Set-up process:
Within a WAMP stack, create a folder in the "www" folder of your wamp directory and dump all the scripts in this new folder. The folder may then be accessed by visiting the localhost/foldername/script.php. 
For a XAMP stack, create a folder in Htdocs folder and access via the same process above.
Please note that the movielist_v2.php script is the main script. The login check has been averted by setting the session variable for the sake of easy demonstration.

***************************************
Script explanation:
log_page.php is the login page. Due to the stipulation of using specific login details the javascript input verification of passwords has been limited.
movielist_v2.php is the main page that displays the interactive screens
connection.php is the database connection script that connects to the MySQL database
search.php is the script used to perform searches and show search suggestions - searching is done using similar name entries
fav.php is the script used to handle adding and removing favorites
favpage.php serves the favorites page to the user
script.js is the script that handles asynchronous comms
style.css is the style sheet fot the main page
**************************************
Database:
Database uses an auto increment primary key
innoDB is the chosen engine

