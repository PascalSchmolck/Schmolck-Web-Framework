## Schmolck Web Framework

Web framework based on PHP, HTML, JS and LESS.

# Changelog

2015.05.15
**********
[FRAMEWORK] clean up for upload to global repository
[PROJECT] integrate mobile contact form into generic contact page
[MOBILE] fix XML message feature
[MOBILE] integrate XML message for automatic lead management
[MOBILE] add request form to detail page
[PROJECT] embed contact form
[PROJECT] ignore host directory for sensible configuration data
[PROJECT] clean up obsolete cars module and corresponding files
[PROJECT] clean up obsolete www.schmolck.de project
[MOBILE] fix output for filter options for brand 'others'
[MOBILE] fix header output for JSON api

2015.05.12
**********
[MOBILE] add info pages for JSON and CALLER api 
[MOBILE] add CALLER api for external call with options 'brand' and 'model'
[MOBILE] add JSON api for retrieving filter options
[PROJECT] optimise .gitignore file
[PROJECT] add backup folder

2015.03.19
**********
[PROJECT] change pictures for contact (Emmendingen, Vogtsburg, Müllheim)
[PROJECT] fix wrong QR-Code placement print output
[PROJECT] fix wrong line separation within car description

2015.03.17
**********
[PROJECT] add url redirect if http://www.schmolck.de/cars has been called
[MOBILE] add url redirect if wrong www.cars... url has been called

2014.09.23
**********
[PROJECT] add robots.txt, browserconfig.xml and sitemap.xml for less log errors
[MOBILE] fix wrong MySQL statements for filtering car modells

2014.06.12
**********
[PROJECT] add new contact person "Benedikt Pohl"

2014.03.10
**********
[PROJECT] replace old "Vogtsburg" location image

2014.03.10
**********
[FRAMEWORK] renamed base folder lib/ to library/

2014.03.05
**********
[MOBILE] implement backup functionality for mobile upload file
[MOBILE] implement proper error message when update failed

2014.02.24
**********
[MOBILE] fix wrong evaluation of "Junge Sterne" attribute

2014.01.23
**********
[PROJECT] cleanup of obsolete cars module into cars.backup
[PROJECT] cleanup of obsolete data/images/ into images/ folder

2014.01.15
**********
[MOBILE] fix SQL escaping issue when importing media.zip file

2013.12.20
**********
[MOBILE] extend mobile database structure to current mobile.de format

2013.12.12
**********
[LAYOUT] update default styles to current status

2013.12.09
**********
[MOBILE] implement proper page title for contact sub-pages
[MOBILE] replace "Lieven van der Hoofd" by "Michael Berger"

2013.12.03
**********
[MOBILE] add "filter" to reset label
[MOBILE] fix description styling on detail page for screen and print
[MOBILE] implement switch for "Gebrauchtwagen" and "Junge Sterne"

2013.12.02
**********
[MOBILE] implement switch to new "mobile" database instead of "cars"

2013.11.27
**********
[MOBILE] add vehicle numbers to gallery view
[MOBILE] improve image scaling / compression on database overview
[MOBILE] fix "browser back issue" when returning from detail view
[MOBILE] improve module structure and stylesheet definition

2013.11.07
**********
[CARS] implement dynamic scaling of cars images

2013.10.31
**********
[MOBILE] fix non-working element updating on car filtering

2013.10.30
**********
[MOBILE] implement "transmission" filter within car filters
[MOBILE] add "PS" to car detail and list view

2013.10.29
**********
[MOBILE] improve cache handling by using date of zip backup
[MOBILE] implement test for "-" within Claris-Id
[MOBILE] improve page structure
[MOBILE] fix breaking import when encountering duplicates

2013.10.28
**********
[MOBILE] implement cache handling for better performance
[CARS] implement cache handling for better performance
[FRAMEWORK] implement SQL statement speed logging / debugging

2013.10.15
**********
[CARS] move contact images to proper path within images folder
[MOBILE] move contact images to proper path within images folder

2013.10.10
**********
[LAYOUT] fix navigation helper link for small screens

2013.10.09
**********
[PORTAL] modify location and contact page according to feature requests
[FRAMEWORK] increase time limit for cleaning temporary folder

2013.10.08
**********
[CARS] fix car image handling for new mobile module
[CARS] hide "1 EUR" entry from mobile price filter 
[PORTAL] fix missing favicon.ico and favicon.png
[PORTAL] adapt template to newly refined design
[FRAMEWORK] move module styles into dedicated "styles.module.less"
[PORTAL] remove obsolete imprint page (by redirection)

2013.10.07
**********
[CARS] fix temporarily missing www.cars.schmolck... host config
[CARS] fix utf8 encoding issue within car title

2013.08.28
**********
[PORTAL] fix obsolete exception messages for non-existing host
[PORTAL] fix obsolete exception messages for non-existing pages

2013.08.27
**********
[PORTAL] hide new portal and redirect to news.schmolck.de
[CARS] fix wrong home link
[PORTAL] implement Schmolck portal
[FRAMEWORK] improve database and error reporting handling
[FRAMEWORK] improve browser caching capabilities
[CARS] implement case-insensitive car image retrieval

2013.08.07
**********
[ ] [MOBILE] test CSV loading with different failure options
[MOBILE] fix image overlapping in list and gallery view of result set
[MOBILE] fix CSV loading failure on production environment
[MOBILE] improve database debugging for CSV loading failures

2013.07.30
**********
[MOBILE] adapt configuration to productive "media.zip" file and test

2013.07.26
**********
[FRAMEWORK] prevent unnecessary style and script compilation on development
[MOBILE] merge configuration from localhost to production server file
[ ] [MOBILE] extend mobile database table columns and detail view informations
[MOBILE] fix missing translations
[MOBILE] impelement duplicate import prevention
[MOBILE] implement import cleaning of obsolete files
[MOBILE] implement dynamic car image file detection
[MOBILE] improve method naming within mobile helper class and do cleanup

2013.07.25
**********
[MOBILE] extend CSV import functionality by "length" checks
[MOBILE] fix strangely formatted "Bemerkungen" in detail view
[MOBILE] change "mobile" module to use newly introduced database table

2013.07.23
**********
[FRAMEWORK] improve debugging by adding handling for arrays

2013.07.22
**********
[MOBILE] extend "mobile" module helper by CSV import functionality
[MOBILE] re-arrange contact persons according to request
[FRAMEWORK] improve layout handling for AJAX calls
[MOBILE] extend ZIP-handler by image copy functionality

2013.07.11
**********
[?] [MOBILE] create database table creation sheet for mobile.de format
[MOBILE] implement ZIP-handler for ftp sync folder (csv & images)
[MOBILE] duplicate cars module for upcoming development

2013.06.24
**********
[CARS] improve layout of search results for smaller screens
[CONTACT] fix Windows Phone error showing duplicate contact form
[CONTACT] fix Windows Phone error with submitting contact form
[LAYOUT] create minimal navigation link for smaller screens

2013.06.21
**********
[LAYOUT] remove scrollup image button due to Windows Phone issues
[LAYOUT] add scrollup image button 
[CARS] add new contact person "Jürgen Rinkenauer"
[LAYOUT] add new favicon according to logo

2013.06.18
**********
[CARS] fix missing car names for foreign brands

2013.06.17
**********
[CONTACT] move images to proper data/contact folder

2013.06.06
**********
[CARS] implement dummy feature for data/cars/images/sync folder

2013.06.05
**********
[CARS] move cars images into data/cars/images folder
[CARS] use new FTP locations for images and update file

2013.05.16
**********
[LAYOUT] separate styles into 'default' and 'layout' for better portability

2013.05.13
**********
[LAYOUT] improve new layout for all Apple device screen sizes
[LAYOUT] improve new layout for all common screen sizes
[CARS] hide cars with price tag 0€

2013.05.08
**********
[PORTAL] change e-mail address for "Vogtsburg-Bischoffingen"
[LAYOUT] fix logo (screen vs. print) problem on IE8 and lower
[LAYOUT] make new layout compatible to small screens (320x240)
[LAYOUT] make new layout compatible to small screens (480x320)
[LAYOUT] prevent contact print footer on contact pages
[LAYOUT] create two logos (screen and print)
[LAYOUT] create new layout similar to print media

2013.04.24
**********
[CARS] optimize look'n'feel regarding layout
[PORTAL] optimize look'n'feel regarding colors and fonts

2013.04.23
**********
[CARS] add "Vogtsburg" to contact page, location page and print view
[CARS] remove "Jahreswagen" information in all views
[CARS] add contact person "Lieven van der Hoofd" with picture
[CARS] add tax note to all price labels
[?] [CARS] add model separation into gallery view
[CARS] add search filter "Modell"
[CARS] hide search filters "Art", "Erstzulassung" and "Kilometer"

2013.04.22
**********
[PORTAL] add contact address into template for print view
[CARS] show contact hint if search gave no results

2013.04.18
**********
[CARS] implement EZ filter selection
[FRAMEWORK] move module helper class from library to module folder

2013.04.15
**********
[FRAMEWORK] implement highlighting menu items when active
[PORTAL] remove contact sidebar from cars overview page
[PORTAL] fix navigation layout for 1024px displays
[PORTAL] improve logo rendering for IE

2013.04.13
**********
[PORTAL] implement tab/carousel based contact and location sub-pages
[CARS] remove "Sven Schoner" contact person as requested by BSC
[CARS] remove brand "Volkswagen" as requested by BSC

2013.04.01
**********
[LAYOUT] implement graphical show/hide-button for the menu

2013.03.29
**********
[ ] [DEVELOPMENT] find proper way of keeping FTP server in sync
[CARS] implement graphical list and gallery buttons
[FRAMEWORK] include CSSgrid styles into framework styles
[FRAMEWORK] optimization and cleanup of wrong method names
[FRAMEWORK] optimize LESS compilation (JS -> PHP)

2013.03.22
**********
[ ] [CARS] implement graphical forward button on detail view
[CARS] implement graphical back button on detail view
[ ] [CARS] implement graphical hint for more car pictures
[CARS] implement immediate loading of filtered cars

2013.03.21
**********
[FRAMEWORK] fix wrong image paths in styles
[FRAMEWORK] convert line breaks into <br> in contact mails
[FRAMEWORK] implement overall usable mail template 
[FRAMEWORK] implement globally usable mail sender
[PORTAL] fix testing mail addresses for production server
[FRAMEWORK] fix mysql_escape issue on production server
[FRAMEWORK] enable logging into tmp/error.log
[PORTAL] remove work-intensive mails from imprint page
[FRAMEWORK] fix showstopping url parameter issues
[PORTAL] fix obsolete links to content/static/*
[FRAMEWORK] fix exception bug on production server
[?] [FRAMEWORK] fix duplicate recipient in contact form e-mails
[FRAMEWORK] fix contact subject line 
[FRAMEWORK] fix absolute url issue within api helper
[PORTAL] create cars.schmolck.de production settings 
[FRAMEWORK] fix case-issue when loading classes from library
[PORTAL] include Piwik Web Analytic for production environment
[PORTAL] cleanup and optimise exception page
[PORTAL] cleanup and optimise module names / structure
[PORTAL] cleanup obsolete start page and establish redirections 
[FRAMEWORK] add an e-mail link to exception page

2013.03.20
**********
[ ] [PORTAL] optimize cache handling by reducing time limit
[CARS] implement sorting selection
[FRAMEWORK] implement mailto: obfuscator
[FRAMEWORK] fix multiple helper instances issue

2013.03.19
**********
[CARS] implement dummy for non-existing images
[CARS] implement dedicated cars contact element
[CARS] implement gallery view for search results
[CARS] implement slideshow in detail view
[CARS] display contact persons on detail view
[CARS] implement filter reset functionality
[CARS] implement price filter

2013.03.18
**********
[CARS] implement type filter
[CARS] implement brand filter for 'others'
[FRAMEWORK] optimize special api inclusion feature
[CARS] implement filter box for list view
[CARS] optimize image loading from www.schmolck.de
[CARS] optimize database loader (update only once per hour)
[CARS] save scroll position when opening detail view

2013.03.12
**********
[FRAMEWORK] optimize caching and compression of scripts and styles
[FRAMEWORK] implement host routing for using the same application
[CARS] implement detail view id check
[CARS] implement list view partial loading

2013.03.08
**********
[FRAMEWORK] implement image app for automatic image resizing
[CARS] implement database structure
[CARS] implement database loader (CSV->DB)
[CARS] implement list view
[CARS] implement detail view
[ ] [CARS] implement statistic 

2013.02.28
**********
[CONTACT] implement contact form

2013.02.28
**********
[FRAMEWORK] enable IDE autocompletion for core helpers
[FRAMEWORK] extend core helper by class memory feature
[FRAMEWORK] implement AJAX helper and move corresponding core code
[FRAMEWORK] implement fully working GUI language switcher 
[FRAMEWORK] implement core memory functionality

2013.02.27
**********
[FRAMEWORK] add special AJAX functionality to GUI class

2013.02.26
**********
[FRAMEWORK] cleanup and improve core init process
[FRAMEWORK] add database helper class and settings

2013.02.22
**********
[FRAMEWORK] add translation capability
[FRAMEWORK] create html demo page for easier styling

2013.01.10
**********
[FRAMEWORK] optimize mod folder structure for better maintainability
[FRAMEWORK] throw an exception if CSS or JS registration fails
[FRAMEWORK] include LESS for better maintainability of CSS code
[FRAMEWORK] optimize library structure (integrate view output into PHP file)
[FRAMEWORK] integrate LESS functionality into library framework
[FRAMEWORK] cleanup integration of LESS and JS into template
[FRAMEWORK] implement multiple templates per host by adding to settings
[FRAMEWORK] cleanup integration of PHP code into template by separate init/exit files
[FRAMEWORK] replace <?php by <?= within template phtml file

2013.01.09
**********
[?] [PERFORMANCE] enable gzip compression for JS output
[?] [PERFORMANCE] enable gzip compression for CSS output
[PROJECT] add a license to the project
[PERFORMANCE] remove obsolete tmp files (e.g. older than 1 hour)

2012.02.29
**********
[PROJECT] re-naming into php.framework.schmolck
[PERFORMANCE] implement compiled JS & CSS loading instead of single files

2012.02.29
**********
[PROJECT] creating data/ folder for images, files, etc.

2012.02.25
**********
[PROJECT] changing naming convention ("name.php", "name.phtml", "name.css", "name.js")
[SAFETY] handling / redirection for exception
[PROJECT] inclusion of layout styles
[PROJECT] simplify attribute retrieval for gui objects with magic __get() method
[PROJECT] PHPdoc comments on every class, method, ...

2012.02.02
**********
[PROJECT] changing naming convention ("name.class.php") for better usability

2012.01.24
**********
[TESTING] testing of layout switch (JavaScript) for mobile / tablet / desktop browser
[PROJECT] method to switch of the layout rendering for AJAX requests
[PROJECT] handling for missing action / controller / module within URL
[PROJECT] layout subfolders for different browser (desktop, mobile, tablet, ...)