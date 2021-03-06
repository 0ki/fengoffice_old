
    About OpenGoo beta 0.6.6
    =========================

    OpenGoo is a free, web based WebOffice, project management and collaboration
    tool. For license details, see license.txt.

    OpenGoo is based on activecollab 0.7.1.

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
    
    
    Upgrade from 0.6.4
    ==================
    
    1. Download OpenGoo 0.6.6 - http://www.opengoo.org/
    2. Unpack and remove the following folders:
    	- cache
    	- config
    	- public/files
    	- tmp
    	- upload
    3. Move remaining files and folders to your OpenGoo installation, replacing all files.
    4. Direct your browser to the public/upgrade directory and follow the instructions.
    
    
	Changelog
	=========
	
	* Workspace hierarchy added
	* Search updated:
		- Added CO emails to the search
		- Added more fields such as tags and comments to the search
		- Updated the search results display, grouping results by object type
		- Added text search on opengoo-created documents
	* Upgrading shall henceforth be supported
	* Added due date and start date to tasks
	* Changed look and feel and organization of edition interfaces for all content objects
	* Solved bug that throwed Syntax Errors on PHP 5.1 and lower,
		by providning a default implementation for json_encode and json_decode functions
	* Changes in the group interface, missing translations and 'can manage contacts' bug
	* Unification of task edit and task list edit interfaces
	* Only parent tasks shown in overview and task listings
