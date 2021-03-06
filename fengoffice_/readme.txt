
    About OpenGoo beta 0.9 RC2
    ==========================

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
    
    
    Upgrade from 0.7 and older
    ==========================
	In order to update to version 0.9 you must first update to 0.8. 
	Example: Suppose you have OpenGoo 0.6.6, you should run the upgrade procedure 3 times.
	First time from 0.6.6 to 0.7, second time from 0.7 to 0.8 and finally from 0.8 to 0.9.
    
    
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
    
    
	Changelog (since 0.8)
	=====================

	- Added message "Click to remove" to error messages.
	- Descriptive dates are written in the language of the localization.
	- Fixed get user and company in DashboarController, in option "show pending task widget"
	- Time tracking enabled
	- Formatted emails:  Fulano de tal <maildefulano@mail.com>
	- Reply to all Mail Action
	- Forward Mail Action
	- Html emails Mail Action using FCK Editor
	- Mail drafts
	- Read/unread mails
	- CC and BCC now work properly
	- Body os sent emails is saved correctly
	- When APOP protocol fails, plain POP is attempted	
	- Calendar bug: all day is not default when adding an evento in weekly view
	- Calendar Visualization bugs
	- Added time display animation (timers) for tasks in progress
	- Improved display format for system response emails
	- Added an unread emails widget on the dashboard
	- Dashboard can now be configured to show the desired widgets (via account settings)
	- Pending tasks widget can now be filtered by "assigned to" filter
	- "Assigned to" filter now includes unassigned tasks
	- Workspace labels now expand to show the full workspace path
	- Added three "group by" levels to the "total task execution time" report
	- Improved "Total task execution time" report display format
	- Added system restriction: Workspaces can be nested up to 10 levels in depth for performance issues
	- Improved url construction (removed incorrect & symbols and unnecesary parameter values)
	- Fixed dashboard is loaded 3 times when user logs in
	- Fixed comment view space is too short
	- Improved & fixed bugs in search result display format
	- Fixed various errors & format in event edit display
	- Dashboard now shows workspace description when "show description on workspace overview page" is checked
	- Unclassified emails now appear on search
	- Event tooltips now show as header background color the event's workspace colors
	- Added user option support
	- Options for hiding dashboard widgets
	- Options for default view in task panel
	- Fixed group permissions bug
	- Fixed various Internet Explorer bugs
	- Administrator can now have its permissions per workspace set
	- es_uy/emails.php had incorrect encoding
	- solved gmt bug for installation on Debian
	- Fixed bug in calendar read only permissions
	- Fidelity in visualization of texts improved
	- Improved company picker while adding a contact
	- Various fields added to search index
	- Administration/User now lists all system users
	- Tag list is now updated correctly on tag remove
	- Improved compatibility with proxy servers
	- Improved refresh of workspaces tree
	- Prevention of Duplicated filenames
	- Cannot set a wrokspace as parent of himself
	- Improved notifications
	- Enabled RSS suscription
	- Task asigner is saved
	- Lots of en_us, es_uy and es_es langs were added
	- Added workspace templates
	- Added administrative interface to assign task templates to workspaces
	- Fixed Safari and Google Chrome issues
	- Improved compatibility with non ASCII characters
	- Added "unasigned tasks" as a filter for the task panel
	- Added icons to administration panel
	- Created javascript user permissions control (add new user, account permissions)
	- Fixed bug in "Web links" view where page change overrides the active workspace settings (Web links for all workspaces are displayed)
	- Added more options to the "add task" action in the tasks tab main panel. A timeslot can now be added directly to the task from this view.
	- Added the "add work" option to the timeslots view (enables adding a specific timeslot directly).
	- Added "Cancel" buttons to the timeslots view.
	- Fixed pagination bug: in all grids (Overview, messages, etc..) when standing in the last page and switching to a workspace with less pages, the panel stays on the same (invalid) page and does not load any data.
	- All tasks are now shown in tasks panel view
	- Fixed bug: when writing html tags in comments and other places, these are not properly escaped when shown and break page layouts.
	- And tons more ...