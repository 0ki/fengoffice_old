
    About OpenGoo beta 0.9 RC2
    ======================

    OpenGoo is a free, web based WebOffice, project management and collaboration
    tool. For license details, see license.txt.

    OpenGoo is based on activecollab 0.7.1.

    Note: OpenGoo is under heavy development and is currently on an beta stage.
    This means that it still lacks much of its desired functionality and it may
    contain lots of bugs. This release of OpenGoo is intended for testing and
    previewing and not for production use. If you find a bug and want to
    collaborate with the project please report it here:

        http://forum.opengoo.org/

    visit:
        * http://www.opengoo.org/
        * http://forum.opengoo.org/
        * http://sourceforge.net/projects/opengoo

    other links:
        * http://www.activecollab.com/forums
        * http://www.fckeditor.net/
        * http://sourceforge.net/projects/reececalendar


    contact:
        * contact@opengoo.org


    System requirements
    ===================

    OpenGoo requires a web server, PHP (5.0 or greater) and MySQL with InnoDB
    support. The recommended web server is Apache.

    OpenGoo is not PHP4 compatible and it will not run on PHP versions prior
    to PHP5.

    Recommended:

    PHP 5.2+
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
    
    
    Upgrade from 0.8
    ================
    
    1. Backup you current installation (important !)
    2. Download OpenGoo 0.9 - http://www.opengoo.org/
    3. Unpack and remove the following folders:
    	- cache
    	- config
    	- public/files
    	- tmp
    	- upload
    4. Move remaining files and folders to your OpenGoo installation, replacing all files.
    5. Direct your browser to the public/upgrade directory and follow the instructions.
    
    
	Changelog
	=========

	.