
    About Feng Office 2.0.0 - Beta
    ==============================
 
    Feng Office is a Collaboration Platform and Project Management System.
    It is licensed under the Affero GPL 3 license.
 
    For further information, please visit:
        * http://www.fengoffice.com/
        * http://fengoffice.com/web/forums/
        * http://fengoffice.com/web/wiki/
        * http://sourceforge.net/projects/opengoo
 
    Contact the Feng Office team at:
        * contact@fengoffice.com
 
 
    System requirements
    ===================
 
    Feng Office requires a running Web Server, PHP (5.0 or greater) and MySQL (InnoDB
    support recommended). The recommended Web Server is Apache.
 
    Feng Office is not PHP4 compatible and it will not run on PHP versions prior
    to PHP 5.
 
    Recommendations:

    PHP 5.2+
    MySQL 4.1+ with InnoDB support
    Apache 2.0+
 
        * PHP    : http://www.php.net/
        * MySQL  : http://www.mysql.com/
        * Apache : http://www.apache.org/
 
    Alternatively, if you just want to test Feng Office and you don't care about security
    issues with your files, you can download XAMPP, which includes all that is needed
    by Feng Office (Apache, PHP 5, MySQL) in a single download.
    You can configure MySQL to support InnoDB by commenting or removing
    the line 'skip-innodb' in the file '<INSTALL_DIR>/etc/my.cnf'.
 
        * XAMPP  : http://www.apachefriends.org/en/xampp
 
 
    Installation
    ============
 
    1. Download Feng Office - http://fengoffice.com/web/community/
    2. Unpack and upload to your web server
    3. Direct your browser to the public/install directory and follow the installation
    procedure
 
    You should be finished in a matter of minutes.
   
    4. Some functionality may require further configuration, like setting up a cron job.
    Check the wiki for more information: http://fengoffice.com/web/wiki/doku.php/setup
   
    WARNING: Default memory limit por PHP is 8MB. As a new Feng Office install consumes about 10 MB,
    administrators could get a message similar to "Allowed memory size of 8388608 bytes exhausted".
    This can be solved by setting "memory_limit=32" in php.ini.   
 
   
    Open Source Libraries
    =====================
   
    The following open source libraries and applications have been adapted to work with Feng Office:
    - ActiveCollab 0.7.1 - http://www.activecollab.com
    - ExtJs - http://www.extjs.com
    - jQuery - http://www.jquery.com
    - jQuery tools - http://flowplayer.org/tools/
    - jQuery Collapsible - http://phpepe.com/2011/07/jquery-collapsible-plugin.html
    - jQuery Scroll To - http://flesler.blogspot.com/2007/10/jqueryscrollto.html
    - jQuery ModCoder - http://modcoder.com/
    - H5F (HTML 5 Forms) - http://thecssninja.com/javascript/H5F
    - http://flowplayer.org/tools/
    - Reece Calendar - http://sourceforge.net/projects/reececalendar
    - Swift Mailer - http://www.swiftmailer.org
    - Open Flash Chart - http://teethgrinder.co.uk/open-flash-chart
    - Slimey - http://slimey.sourceforge.net
    - FCKEditor - http://www.fckeditor.net
    - JSSoundKit - http://jssoundkit.sourceforge.net
    - PEAR - http://pear.php.net
    - Gelsheet - http://www.gelsheet.org
 
 
    Changelog
    =========
 
    Since 1.7
    -----------
 
    system: Plugin Support
    system: Search Engine performance improved
    system: Multiple Dimensions - 'Workspaces' and 'Tags' generalization
    system: Database and Models structure changes - Each Content object identified by unique id 
    system: Email removed from core (Available as a plugin)
    system: User Profile System
    feature: PDF Quick View - View uploaded PDF's
    usability: Default Theme improved
    usability: Customizable User Interface

