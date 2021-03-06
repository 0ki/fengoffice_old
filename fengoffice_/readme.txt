
    About OpenGoo beta 0.5.2
    =========================

    OpenGoo is a free, web based WebOffice, project management and collaboration
    tool. For license details, see license.txt.

    OpenGoo is based on activecollab 0.71.

    Note: OpenGoo is under heavy development and is currently on an beta stage.
    This means that it still lacks much of its desired functionality and it may
    contain lots of bugs. This release of OpenGoo is intended for testing and
    previewing and not for production use. If you find a bug and want to
    collaborate with the project please report it here:

        https://sourceforge.net/tracker/?func=add&group_id=191520&atid=937707

    visit:
        * http://www.opengoo.org/
        * http://forum.opengoo.org/
        * http://sourceforge.net/opengoo

    other links:
        * http://www.activecollab.com/
        * http://www.activecollab.com/forums
        * http://www.fckeditor.net/


    contact:
        * info@opengoo.org


    System requirements
    ===================

    OpenGoo requires a web server, PHP (5.0 or greater) and MySQL with InnoDB
    support. The recommended web server is Apache.

    OpenGoo is not PHP4 compatible and it will not run on PHP versions prior
    to PHP5.

    Recommended:

    PHP 5.1+
    MySQL 4.1+ with InnoDB support
    Apache 2.0+

        * PHP    : http://www.php.net/
        * MySQL  : http://www.mysql.com/
        * Apache : http://www.apache.org/

    Alternatively, if you just want to test OpenGoo and you don't care about security
    issues with your files, you can download XAMPP, which includes all that is needed
    by OpenGoo (Apache, PHP 5, MySQL) in a single download.
    You will need to configure MySQL to support InnoDB, which is done by commenting
    the line 'skip-innodb' in the file '<INSTALL_DIR>/etc/my.cnf'.

        * XAMPP  : http://www.apachefriends.org/en/xampp


    Installation
    ============

    1. Download OpenGoo - http://www.opengoo.org/
    2. Unpack and upload to your web server
    3. Direct your browser to the public/install directory and follow the installation
    procedure

    You should be finished in a matter of minutes.
    
    Upgrade from 0.5 or 0.5.1
    =========================
    
    Extract the following files and folders of this zip file to the root of your installation:
		* opengoo/application
		* opengoo/environment
		* opengoo/help
		* opengoo/language
		* opengoo/library
		* opengoo/public (keep your previous opengoo/public/files)
		* opengoo/index.php
		* opengoo/init.php
		* opengoo/version.php
		* opengoo/readme.txt

	Changelog 0.5.2
	===============

	* Fixes some bugs introduced by the new features in 0.5.1:
		* Tasks interface now works correctly
		* Uploading an avatar now works correctly
		* A bug that kept firefox showing the 'loading' cursor after uploading a file
		* The confirmation dialog before exiting or reloading OpenGoo was removed.
		It turned out to be too annoying. Will be replaced in the future with more 
		intelligent checks.
