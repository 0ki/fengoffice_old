
    About OpenGoo beta 0.6.0
    =========================

    OpenGoo is a free, web based WebOffice, knowledge management and collaboration tool. For license details, see license.txt.

    OpenGoo's architecture is based on activecollab 0.7.1.

    Note: OpenGoo is under heavy development and is currently on an pre-beta stage.
    This means that it still lacks much of its desired functionality and it may
    contain lots of bugs. This release of OpenGoo is intended for testing and
    previewing and not for production use. If you find a bug and want to
    collaborate with the project please report it here:

        https://sourceforge.net/tracker/?func=add&group_id=191520&atid=937707

    visit:
        * http://www.opengoo.org/
        * http://forums.opengoo.org/
        * http://sourceforge.net/projects/opengoo/

    other links:
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
    
    Upgrade from 0.5
    ================
    
    Major changes have happened since previous versions, and the upgrade script is still
    a work in progress.

	Changelog
	=========
	
	* Lots more AJAX features
		- new filters by workspace, tag and type of object
	* Events, mails, webpages and lots of other features have been added.
