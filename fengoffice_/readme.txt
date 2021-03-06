
    About OpenGoo 1.2 beta 2 
    ========================

    OpenGoo is a free WebOffice, project management and collaboration
    tool. For license details, see license.txt.

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
    
    1. Backup you current installation (important !)
    2. Download OpenGoo 1.2 beta 2 - http://www.opengoo.org/
    3. Unpack into your OpenGoo installation, overwriting your previous files and folders,
    	but keeping your config and upload folders.
    5. In your browser, go to <your_opengoo>/public/upgrade and choose to upgrade from your current version to 1.2.
    6. If necessary, refresh your browser or clear its cache so that the new javascript, css and images load.   

    
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
	- Services_JSON - http://pear.php.net/pepr/pepr-proposal-show.php?id=198


	Changelog
	=========
	
	Since 1.2 beta
	--------------
	
	usability: Allow to hide filtering panels on the object picker.
	bugfix: Trashed email was incorrectly sorted.
	bugfix: Email widget showed trashed email.
	bugfix: Fixed a problem when downloading a backup.
	bugfix: Error when checking in files "There is no session matching this name".
	bugfix: Following a link from an email notification to a content object would show the dashboard.
	bugfix: Email with trailing whitespace was not being considered valid.
	bugfix: Missing langs on notifications.
	bugfix: Invalid controller action when viewing a webpage.
	bugfix: Email notifications for object editions or deletions showed a wrong user.
	bugfix: Couldn't upload files with unknown extensions.
	bugfix: Couldn't link objects or invite users to an event.
	bugfix: Error when filtering by a tag overview / list files or contacts.
	bugfix: Backup command failed but a success message was being shown.
	
	Since 1.1
	---------
	
	feature: Importing and Exporting:
		- Import/Export support for iCalendar files.
		- Import company info from CSV files in addition to the exiting contact import.
		- Export contacts and companies to CSV files.
	feature: Improved Email module:
		- Added support for SSL connections
		- Partial support for IMAP (now you can fetch emails using IMAP protocol)
		- Assign email to more than one workspace.
		- Comments for emails.
		- Autocomplete email addresses.
		- Email accounts configuration option to delete emails from the server after N days
	feature: Spreadsheets integration - An alpha version of the Spreadsheets module of OpenGoo.
	feature: Automatize OpenGoo upgrade - OpenGoo's upgrade now can download and install new versions with just one click. (Your webserver needs write permission on all OpenGoo files and folders).
	feature: Cron events - Some common procedures like checking email or backing up OpenGoo can be configured to be done by a cron job so that you don't have to do them manually saving you time and improving the user experience (just refresh the email panel to get new email).
	feature: Improved Content Object subscriptions - Now you can subscribe other users and you will be notified when the object is created, modified, commented on or deleted.
	feature: Enhanced custom properties - Now you can add an unlimited amount of custom properties and you can see them on the object's view, as well as search them.
	feature: Copy documents - You can now create copies of a document.
	feature: New system configuration options:
		- Show/hide modules (notes, contacts, email, etc.)
	feature: New user configuration options
		- Allow to remember graphical interface state
		- Choose initially selected workspace or remember last viewed workspace	
		- 12/24 hour format
		- Start of work time
		- User language
		- Enable/Disable 'send email notification' checkbox for tasks.
	feature: Files massive upload as a zip file - Upload a zip containing multiple files and extract it inside OpenGoo.
	feature: Zip files in OpenGoo to ease download.
	feature: Sort tags by name or number of occurences (including tag count).
	feature: Edit timeslots.
	feature: Improved Content Objects' history - Now it includes tagging, commenting, etc.
	feature: Indexing of .doc and .ppt when using filesystem storage and the 'catdoc' and 'catppt' commands are present.
	
	usability: When deleting an email account it now asks you whether you want to delete all its emails (by default it won't).
	usability: URLs in Content Objects' descriptions are shown as links.
	usability: When adding a milestone to a template, all of its tasks are now (implicitly) added.
	usability: Emails now display the local time instead of the time of origin.
	usability: Events displayed in the calendar now have a minimum height so that it is always correctly visible, even if it is 15 minutes or less.
	usability: A user is now always able to edit its associated contact data.
	usability: 'Created by' and 'Mofified by' properties are now displayed on the workspace's edit view.
	usability: 'Anyone' was removed from list of possible people to assign a task to.
	usability: There's a new warning that passwords are sent as plain text when creating a user.
	usability: When linking objects, selecting multiple objects now links all of them.
	usability: Improved display for: Edit comments & change password.
	usability: Localized date format in time reports.
	usability: The expanding workspace label now floats when expanded instead of displacing the rest of the content.
	usability: When an administrator is editing permissions for a user, all system workspaces are shown.
	
	system: Implemented an og.OpenGooProxy that extends Ext.data.DataProxy for listings.
	system: Changed POP3 backend to improve email checking reliability.
	
	bugfix: Comments with non ASCII characters could break Overview, because of the use of substr function to truncate the description. Fixed this all around by using mb_substr instead of substr.
	bugfix: Tags with single quotes would give an error when filtering by it.
	bugfix: Linking an object in an edit view would refresh the view. It now works like when in the create view.
	bugfix: Fixed a time report error: unknown column 'deleted_by'.
	bugfix: Timezones would only go up to 9.9, so timezones with two digits (+12, -10, etc.) wouldn't work.
	bugfix: Trashed comments were being displayed on the dashboard.
	bugfix: When an admin edited another user's personal workspace he would get permissions to the workspace.
	bugfix: When editing a task/milestone in an OpenGoo translated to french, the date changed the month for the day.
	bugfix: A user could change another user's attendance to an event.
	bugfix: An email with an attachment with no name couldn't be classified.
	bugfix: Several bugs while checking mail were fixed.
	bugfix: Dates in listings weren't localized.
	bugfix: Some emails were being displayed incorrectly.
	bugfix: Errors with UTF-8 codification on emails.php.
	bugfix: Mail drafts had two scrollbars.
	bugfix: Mail drafts: an error prevented the editor from being displayed.
	bugfix: Mail without body is showing all the original content.
	bugfix: Tasks interface: Selection for 'Assigned to' filter was lost when changing workspace.
	bugfix: When editing an event, the invited user list was being taken from the selected workspace and not from the event's workspace.
	bugfix: Tasks added with due date = tomorrow, and in overview it appeared as overdued.
	bugfix: Error undefined property Timeslot:$workspaces.
	bugfix: Apply to all when unassigning permissions left some ticks that shouldn't be there.
	bugfix: Completed deleted tasks weren't shown on the trash.
	bugfix: File upload: when clicking on the submit button before the name textbox loses focus the file wasn't being uploaded.
	bugfix: Performing a search from the search form of a search results view didn't take into account the active workspace. It searched on the same workspace as the search result.
	bugfix: Search for documents and presentations content was not working correctly.
	bugfix: Search: Contacts were not searchable, problems with ProjectDataObject inheritance.
	bugfix: Tasks and Time panels: For date displays, when the year is different than the current year, it is now displayed (e.g. Jan 12, 2007).
	bugfix: Tasks panel: When selecting a filter that does not return any tasks, when changing group criteria the tasks from the previous filter condition were redrawn.
	bugfix: Tasks: Solved issues with actions involving 2 or more levels of subtasks (getSubtasks gets only the first level of subtasks).
	bugfix: Tasks: When moving to trash a parent task that has subtasks, the subtasks were also removed from the main view, but when refreshing the tasks panel they were back.
	bugfix: Tasks: When there's no filter applied, New->New Task didn't work.
	bugfix: The green progress bar on milestones counted trashed tasks.
	bugfix: The trash workspace's name is now translatable. It was hardcoded to 'Trash'.	
	bugfix: When selecting a workspace in page 2 of contacts, and workspace had only one page of contacts, no contacts are seen (panel is still in page 2).
	bugfix: If there are corrupt files (e.g. because the filesystem backend was changed) now you are allowed to delete the file anyway. Before you would get an error.
	bugfix: Solved some 'memory exhausted' errors when downloading big files from the file system (OpenGoo files, backups, etc.). Not fixed for database file storage.
	bugfix: A problem with Calendar in Russian language.
	bugfix: Could not edit permissions on client users (Administration)
	bugfix: ',' support when adding fractional time worked hours to a task (tasks panel, edit task, task view).
	bugfix: Assigning 'none' to task milestone in edit on tasks panel wouldn't work.
