
    About OpenGoo 1.5 beta
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
    2. Download OpenGoo 1.4 beta 2 - http://www.opengoo.org/
    3. Unpack into your OpenGoo installation, overwriting your previous files and folders,
    	but keeping your config, upload and public/files folders.
    5. Go to <your_opengoo>/public/upgrade in your browser and choose to upgrade
    	from your current version to 1.4 beta 2
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

	Since 1.4.2
	-----------
	
	- feature: Email improved.
		- Email attachments as links or in case of files optionally attach the content.
		- Email text signature.
		- Email checking improved.
		- Autosave email drafts
		- When replying or forwarding an email use the same account as the 'To' address. If the 'To' is not a user account use the default account chosen by the user.
		- Allow to see emails from deleted accounts.
		- Classify mail attachments generates a new revision if filename already exists.
		- Config option to block images on emails enabled by default. When images are blocked allow to choose to show them temporarily for that email.
		- Toolbar improved (selection menu, filters)
	- feature: Drag and drop
		- Move objects to other workspaces by dragging it from a listing into a workspace.
		- Apply tags to an object by dragging an object into a tag.
		- Change an event, task or milestone dates by dragging it in the calendar.
		- Change the duration of an event by dragging its bottom edge.
		- Sort emails by title and date.
	- feature: Multiple workspaces for Events and Weblinks.
	- feature: Calendar toolbar improved (tag, edit and trash actions).
	- feature: Event selection by checking a checkbox in events' box.
	- feature: Recurrent tasks.
		- Define periodic tasks based on start or due date.
		- Once you complete a task the next task is shown.
		- You can instantiate an occurrence of the recurrent task to edit it individually.
	- feature: Filter custom reports by workspace and tag.
	- feature: Templates improved.
		- Define parameters for a template that you can fill in when creating the objects.
		- Parameters can be text or dates.
		- This allows you to define templates with tasks or milestones whose dates depend on each others'.
	- feature: Set default values for user config options.
	- feature: Action to empty trash can.
	- feature: Config option to ask for password when accessing the admin panel (disabled by default).
	- feature: log user login with IP on the application log and show in user history	
	- feature: Choose a personal workspace when for a user when creating it.
	- feature: Allow setting workspace permissions for groups. This permissions apply to all users in the group.
	
	- usability: Now you can select events and perform actions on the selected events like on all other modules.
	- usability: Tasks on the calendar are shown one time for the start time and one time for the due date.
	- usability: Popup messages are now smaller.
	- usability: Change the user's language in the login interface.
	- usability: Only show most common actions on object's view and show the rest when pressing More...
	- usability: Choose parent task with an ObjectPicker that shows only tasks in a task's view.
	- usability: Confirm dialog when editing repeating events (warn user that all past and future events will be edited).
	- usability: Show a Save button on top on all edition screens.
	- usability: Improved user selection interfaces to select subscribers.
	- usability: Subscribe users on object's view (without going to the edit view).
	- usability: Sort users alphabetically when selecting subscribers, event invititions, milestone assign to.
	- usability: Add 'Confirm' and 'Reject' links to event invitation mails.
	- usability: Custom property fields are longer when viewing an object.
	- usability: Dashboard: Config option to show a two week calendar.
	- usability: Dashboard: Late milestones and tasks are sorted by due date.
	- usability: Limited amount of information displayed in the dashboard to improve loading time.
	- usability: Changed action 'Properties' or 'Edit file properties' in files for 'Update file'.
	- usability: Links in mail are opened in a new window or tab.
	- usability: Only a configurable amount of linked objects are shown and the rest can be seen in a 'View all linked objects' link.
	- usability: Removed padding from context help containers and put margin to its children.
	- usability: Removed workspace crumbs from name in contacts tab, add a new column with the workspaces.
	- usability: Set user as administrator option is no longer shown when its company is not the owner company.
	- usability: Timeslots now clearly show how much of the time is pause time, how much is active time, and dates of start and finish.
	- usability: Timeslots now show last edition time and user.
	- usability: The workspaces popup that showed when hovering the workspace name on the top left is now only shown when clicking it.
	- usability: Improved display of workspaces on Administration -> Workspaces.
	- usability: Adding work hours now accepts the format 'Hours:Minutes'.
	- usability: Improved 'create user from contact' functionality.
	
	- system: Add PHPUTF8 lib to OpenGoo to handle UTF8 when mbstring module is not available.
	- system: Country codes updated for Zaire and East Timor
	- system: Fixed a performance issue when there are too many workspaces.
	- system: Image spriting is now used to load initial images.
	- system: Public files are now saved using the file repository (database or filesystem depending on configuration).
	- system: Updated FCKEditor to latest version.
	
	- bugfix: Error when adding a workspace with a custom property.
	- bugfix: IE error in task drag and drop: scrolling did not scroll task rows.
	- bugfix: When editing events of last day of month the date shown was the first day of that month.
	- bugfix: 'Set number of tasks shown as default' config option was not working
	- bugfix: Bug with boolean custom properties.
	- bugfix: CC was not shown when viewing mail content.
	- bugfix: Checking email through imap sometimes saved emails with no subject, sender or body.
	- bugfix: Download a document failed in IE, when 'Checkout notification dialog for documents' was enabled.
	- bugfix: Event import did not import first event in file.
	- bugfix: Problem with timezone when exporting events to Ical.
	- bugfix: Image Transparency patch added for avatars, logos and pictures.
	- bugfix: Couldn't delete reports by clicking the delete button.
	- bugfix: Now you can only assign to a task milestones on the same workspace as the task.
	- bugfix: Latest comments widget context help was always being shown.
	- bugfix: Milestones completed tasks bar counted trashed tasks, and did not always refresh.
	- bugfix: Problem with permissions in tasks with non admin users.
	- bugfix: Reminders showed up inmediately after adding an event in Chrome.
	- bugfix: Some reporting errors.
	- bugfix: Task drag & drop did not work in IE.
	- bugfix: Task list did not scroll properly in IE.
	- bugfix: Time panel, button add was over description field.
	- bugfix: View task displayed start date equal to due date.
	- bugfix: When updating an image the image preview wasn't being updated.
	- bugfix: In IE the Tasks toolbar buttons were enabled/disabled when the checkboxes lost focus, and not when they were checked/unchecked.
	
	- security: Don't allow a non-admin user to edit another user's comments
