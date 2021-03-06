
    About OpenGoo 1.5
    =================

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
    2. Download OpenGoo 1.5 - http://www.opengoo.org/
    3. Unpack into your OpenGoo installation, overwriting your previous files and folders,
    	but keeping your config, upload and public/files folders.
    5. Go to <your_opengoo>/public/upgrade in your browser and choose to upgrade
    	from your current version to 1.5
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
	
	Since 1.5 RC
	------------
	- usability: Email autocomplete didn't show company emails.
	- usability: When selecting a task's milestone, milestones from the parent workspaces are also shown.
	- usability: Ctrl + S to save documents.
	
	- bugfix: Calendar's current-time bar went too fast.
	- bugfix: Deleting a user didn't delete it from the group.
	- bugfix: Email autocomplete did not filter by email.
	- bugfix: Dashboard didn't show unread classified emails when filtering by workspace.
	- bugfix: Error importing contacts with an apostrophe in the name.
	- bugfix: Some emails lost the last three characters.
	- bugfix: Filtering by tag was not working on the Email module.
	- bugfix: POP3 email checking missed some emails.
	- bugfix: Default value for date format and some other user configurations was being ignored.
	- bugfix: Could not download email attachments.
	- bugfix: Added SMTP "from" address config option for system email.
	- bugfix: Fixed filtering by email account when "show deleted emails" was enabled.
	- bugfix: Could not subscribe user to contact unless it had the "Can manage all contacts" permission.
	- bugfix: Slimey didn't show bullets in bullet lists (not fixed for IE6)
	- bugfix: Could not add images to a presentation
	- bugfix: Now you need "Can manage time" permission to view a task's timeslots.
	- bugfix: Fixed issues with GooPlayer: could not load playlist and could not queue tracks.
	- bugfix: Fixed problem while fetching IMAP folders without SSL.
	- bugfix: Now the language name is shown instead of the language code when choosing localization.
	- bugfix: All default value for user preferences are now respected (e.g. date format).
	
	- system: Backup is no longer included by default with OpenGoo. It is available as a separate plugin.


	Since 1.5-beta3
	---------------
	
	- bugfix: Filtering the ObjectPicker by web links was not working.
	- bugfix: Opening a weblink through a linked object was not working.
	- bugfix: Editing a message through the dashboard would return to the message's edit view.
	- bugfix: Permissions weren't removed from client company users when the company was unchecked in the workspace's edit view.
	- bugfix: IMAP email check skipped first email.
	- bugfix: System email through SMTP uses the SMTP username as "from" address, but if it doesn't have a domain part some servers complain.
	- bugfix: Contact export did not prompt to download the file in IE.
	- bugfix: Event export was not filtering by WS and tags.
	- bugfix: Export contacts had two problems: 1) Ignored workspace filter 2) Ignored user's permissions.
	- bugfix: Ical event export did not work fine with events whose description had line breaks, only the first line was taken from the client.
	- bugfix: ICal-Import incorect specialchars.
	- bugfix: MySQL Error: Primary key too long.
	- bugfix: Task quick-add did not work, button 'Add task' did nothing.
	- bugfix: When quick editing a task, milestones combobox is now reloaded to show only valid milestones.
	- bugfix: Time bar in calendar didn't respect timezone and was hidden by events.
	- bugfix: When full-editing a task, the parent task wasn't displayed.
	 

	Since 1.5-beta2
	---------------
	
	- feature: Show current hour line at week and daily view
	- feature: Permission to access Time module (can_manage_time).
	- feature: Link objects to an email when attaching object links
	- feature: Added a checkbox, to tasks workspace and milestone selection, to apply it to all subtasks
	
	- usability: Added a drag and drop icon for listings
	- usability: To drag a row from a grid to a ws, you had to select it first.
	- usability: ObjectPicker now sorts by lastUpdate by default
	- usability: Tasks and events added through quickadd should have the default reminder and the default reminder should apply to all subscribers
	
	- bugfix: Fixed delete from server after X days (only delete fetched emails older than x days)
	- bugfix: Fixed error when downloading revisions
	- bugfix: Contact's workspaces were not being shown
	- bugfix: Custom properties on users were not being shown when updating a user's profile.
	- bugfix: Dashboard - view as list drag and drop allowed events and tasks to have more than one workspace
	- bugfix: Dashboard - view as list was not listing documents
	- bugfix: Dashboard _ view as list wasn't showing email user
	- bugfix: Sometimes 'Modify subscribers' showed no users to subscribe.
	- bugfix: Email sender was sometimes not being displayed
	- bugfix: Errors when using PDO Backend
	- bugfix: Event email reminders are not being sent
	- bugfix: Events that end at or after midnight are not drew correctly (week and day view)
	- bugfix: Javascript error when viewing all linked objecs of an object whose name has quotes
	- bugfix: "Modify subscribers" link shouldn't be shown when user has no write permission over the object
	- bugfix: Filtering Object Picker and Dashboard list view by workspace showed incorrect contacts
	- bugfix: Problems with group permissions (workspaces didn't load and object listings didn't list files in group workspaces)
	- bugfix: Reports weren't being sorted correctly
	- bugfix: Reports only printed first page
	- bugfix: Search wasn't opening on a new panel
	- bugfix: When editing an object with a list-type custom property with multiple values selected, not all were being shown as selected.
	- bugfix: When viewing all linked objects of an email, the email icon at toolbar was not being shown.
	
	- lang: Added ext language files
	- lang: Link to OpenGoo wiki can be localized in translation files (to point to another language if available)

	Since 1.5-beta
	--------------
	
	- bugfix: Checking email on a new email account would delete emails from server (the delete emails from server was being stored incorrectly)
	- bugfix: Cannot send email on new 1.5 beta installations. `content` column was missing in `mail_contents` table.
	- bugfix: Error when executing the "Total task execution time" report.
	- langs: Updated french, portuguese and spanish and added a missing key in Slimey. 

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
