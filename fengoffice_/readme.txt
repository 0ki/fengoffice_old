
    About OpenGoo 1.0 RC1 
    =======================

    OpenGoo is a free, web based WebOffice, project management and collaboration
    tool. For license details, see license.txt.

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
    
    Warning: Default memory limit por PHP is 8MB. As a new opengoo install consumes about 10 MB,
    administrators could get a message similar to "Allowed memory size of 8388608 bytes exhausted".
    This can be solved by setting "memory_limit=32" in php.ini.    
    
    
    Upgrade from 0.8 and older
    ==========================
	In order to update to version 0.9 you must first update to 0.8. 
	Example: Suppose you have OpenGoo 0.6.6, you should run the upgrade procedure 3 times.
	First time from 0.6.6 to 0.7, second time from 0.7 to 0.8 and finally from 0.8 to 0.9.
    
    
    Upgrade from 0.9.2
    ================
    
    1. Backup you current installation (important !)
    2. Download OpenGoo 1.0 RC1 - http://www.opengoo.org/
    3. Unpack and remove the following folders:
    	- cache (cache files)
    	- config (configuration options are stores here)
    	- public/files (avatars are stored here)
    	- tmp (temporary files)
    	- upload (uploaded files are stored here)
    4. Move remaining files and folders to your OpenGoo installation, replacing all files.
    5. If necessary, refresh your browser or clear its cache so that the new javascript, css and images load.
    
    
	Open Source Libraries 
	=====================
	
	The following open source libraries and applications have been adapted to work with OpenGoo:
	- ActiveCollab 0.7.1
	- ExtJs
	- JQuery
	- Reece Calendar
	- Lucene
	- Swift
	- Open Flash Chart
    
	Changelog (since 0.9.2)
	=====================

	- Greatly improved tasks module.
		- Better organization
			- Now you can filter tasks not only by assignee but also by assigner, priority, milestone,
				creator or completer as well as completness status.
			- Besides filtering your tasks you can also group them by milestone, priority, workspace, assignee,
				due date, start date, create date, cretor, completer, status and tag. Once grouped you can choose
				to hide all groups but one, so that you can better focus in what you are working on.
			- Finally, to further organize your tasks, you can also order them by priority, workspace, name,
				due date, create date, assignee and start date.
		- More information
			- You can now see much more information about your tasks on a single view. Tags, workspaces,
				time tracking, dates, all of them displayed on the same view. Is this too much information? Don't
				worry, you can easily configure what you see and what you don't in the toolbar.
		- More usable
			- The left checkbox of the tasks module is now used for selecting tasks rather than completing them,
				to match the criteria used in other listings. This also allows you to select many tasks and tag,
				delete, or complete them with just one click. Also assigning, time tracking and adding subtasks
				is easier than before with shortcuts for it on every task.
		- Better look and feel
			- The tasks module now looks much nicer and better ressembles the look and feel of the rest of OpenGoo.
	- Also improved the calendar module.
		- It now fits more space. Actions were moved to the top toolbar.
		- You can now invite users to events and confirm assistance to an event.
		- The default view is the "My calendar" view, that shows you only events related to you.
		- You can also filter by event state and by users or just show all events.
	- Messages are now called Notes.
	- Object Subscriptions
		- Now you can subscribe to Documents, Notes, Contacts and all Content Objects (COs) so that you are notified by
			email when a comment is posted on that CO. This allows you to easily trace conversations within your team
			related to a CO. You are automatically subscribed to every CO you create but can easily unsubscribe if you
			widh in the CO's view.
		- Besides receiving an email, you can also see the newest comments listed in your Overview panel.
	- When your session expires you can now easily log back in with a popup dialog that prompts you for your username
		and password, without the need to refresh the page. This allows you to comfortably continue working in OpenGoo
		as if your session had never expired.
	- Easy backup your OpenGoo installation from the Administration panel.
	- Several configuration options added, accessible through Account / Edit preferences, including for example, choosing
		what widgets you see on the dashboard and choosing whether to show information about all users or only you.
	- Improved workspace selection controls throughout OpenGoo.
	- Improved date selection controls throughout OpenGoo.
	- Improved the tag input control.
	- Images are now displayed in the CO view.
	- Bugfixes
		- Bugfix: Emails are listed correctly on the Emails panel.
 		- Bugfix: Editing Company details would make the user not able to log in.
		- Bugfix: Total task time report fixed.
		- Bugfix: Adding users on PHP lower than 5.2 fixed.
		- Bugfix: Editing a user without changing his workspace permissions would take away all his workspace permissions.
		- Bugfix: Assigning a task template to a workspace fixed.
		- Some smaller bugfixes.
