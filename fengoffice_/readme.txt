
    About OpenGoo 1.4 beta
    ======================

    OpenGoo is a free and open source WebOffice, project management and collaboration
    tool, licensed under the Affero GPL 3 license.

    visit:
        * http://www.opengoo.org/
        * http://forums.opengoo.org/
        * http://sourceforge.net/projects/opengoo

    contact:
        * contact@opengoo.org


    System requirements
    ===================

    OpenGoo requires a web server, PHP (5.0 or greater) and MySQL (InnoDB
    support recommended). The recommended web server is Apache.

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
    You can configure MySQL to support InnoDB by commenting or removing
    the line 'skip-innodb' in the file '<INSTALL_DIR>/etc/my.cnf'.

        * XAMPP  : http://www.apachefriends.org/en/xampp


    Installation
    ============

    1. Download OpenGoo - http://www.opengoo.org/
    2. Unpack and upload to your web server
    3. Direct your browser to the public/install directory and follow the installation
    procedure

    You should be finished in a matter of minutes.
    
    WARNING: Default memory limit por PHP is 8MB. As a new OpenGoo install consumes about 10 MB,
    administrators could get a message similar to "Allowed memory size of 8388608 bytes exhausted".
    This can be solved by setting "memory_limit=32" in php.ini.    


    Upgrade instructions
    ====================
    
    1. Backup you current installation (important!)
    2. Download OpenGoo 1.4 beta - http://www.opengoo.org/
    3. Unpack into your OpenGoo installation, overwriting your previous files and folders,
    	but keeping your config, upload and public/files folders.
    5. Go to <your_opengoo>/public/upgrade in your browser and choose to upgrade
    	from your current version to 1.4 beta
    6. Refresh your browser or clear its cache to load new javascript, css and images.   

    
	Open Source Libraries 
	=====================
	
	The following open source libraries and applications have been adapted to work with OpenGoo:
	- ActiveCollab 0.7.1 - http://www.activecollab.com
	- ExtJs - http://www.extjs.com
	- Reece Calendar - http://sourceforge.net/projects/reececalendar
	- Swift Mailer - http://www.swiftmailer.org
	- Open Flash Chart - http://teethgrinder.co.uk/open-flash-chart
	- Slimey - http://slimey.sourceforge.net
	- FCKEditor - http://www.fckeditor.net
	- JSSoundKit - http://jssoundkit.sourceforge.net
	- PEAR - http://pear.php.net


	Changelog
	=========

	Since 1.3.1
	-----------
	
	- feature: Custom properties per object type, used for extending the number of fields for each object type.
	- feature: Custom reports based on object types. Custom properties are also displayed and can be used in filtering and ordering criteria.
	- feature: References to external documents via urls can be added as documents in the upload file view.
	- feature: New "Getting started" widget displays information that helps new users in using the system
	- feature: Contextual help messages added in places throughout the system. 
	- feature: Workspace information widget improved, shows users and contacts assigned to the current workspace.
	- feature: Configurable date format.
	- feature: Allow to unclassify email.
	- feature: Notify an event creator when someone confirms assistance to an event.
	- feature: Calendar option - Start Week on Monday.
	- feature: Config option to automatically check out documents when editing online.
	- feature: Companies now have a field for adding notes on it.
	
	- administration: User password security and complexity options are now configurable
	- administration: Document revision comments can be set as required via a configuration option
	- administration: Billing currency symbol is now configurable
	- administration: New "Can manage reports" permission added to users and groups, allowing the creation, edition and deletion of custom reports.
	
	- usability: Three to four contacts / users are displayed in one column in the workspace info, which can be expanded to include all contacts / users
	- usability: Contacts can now be assigned to workspaces through the edit workspace view.
	- usability: "Checked out" icon displayed with documents in the documents widget
	- usability: "Checked out" information now displayed in the document view header and under the properties panel.
	- usability: Editable documents can be expanded to fill the whole page for easier viewing.
	- usability: Improved the reporting panel view. This panel will be displayed by default on new installations
	- usability: Added support for html help files in the right sidebar.
	- usability: Calendar, monthly view: Paint all events with workspace color
	- usability: Improved content of email notifications (more info and in user's language).

	- system: Initial loading time reduced by loading javascript files as they are needed.
	- system: Added new lang folder for plugin langs, which is loaded in filename order and after default OpenGoo lang files.
	- system: Added new lang folder for hel langs, displayed in the right sidebar of OpenGoo.
	- system: New hooks added.
	- system: Mail notifications can be sent through cron, so that user doesn't have to wait for it to send.
	- system: Slimey updated to 0.2. It is now translatable.
	
	- bugfix: Handle timezones correctly.
	- bugfix: Various issues with importing/exporting events.
	- bugfix: Bug when fetching imap folders with non-ascii characters.
	- bugfix: Calendar doesn't show milestones assigned to user, without tasks assigned to user.
	- bugfix: Calendar titles too high.
	- bugfix: Contact/User deletion.
	- bugfix: Company csv export puts values in different order than titles.
	- bugfix: Contact import crashes with chinese characters.
	- bugfix: Mail doesn't show images that are attachments.
	- bugfix: Minor CSS issue (email actions inherit CSS style from HTML emails).
	- bugfix: When editing an IMAP account, changing the IMAP data makes no effect.
	- bugfix: Assigning a role when editing a contact which already had a role would duplicate roles. 
