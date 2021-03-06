
    About OpenGoo 1.0 
    =================

    OpenGoo is a free, web based WebOffice, project management and collaboration
    tool. For license details, see license.txt.

    visit:
        * http://www.opengoo.org/
        * http://forums.opengoo.org/
        * http://sourceforge.net/projects/opengoo

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
	In order to upgrade to version 1.0 you must first upgrade to 0.9. 
	Example: Suppose you have OpenGoo 0.7, you should run the upgrade procedure 3 times.
	First time from 0.7 to 0.8, second time from 0.8 to 0.9 and finally from 0.9 to 1.0.
    
    
    Upgrade from 0.9.* and 1.0 RC*
    ==============================
    
    1. Backup you current installation (important !)
    2. Download OpenGoo 1.0 - http://www.opengoo.org/
    3. Unpack and remove the following folders:
    	- config (configuration options are stores here)
    	- upload (uploaded files are stored here)
    4. Move remaining files and folders to your OpenGoo installation, replacing all files.
    5. [if upgrading from 0.9.*] In your browser, go to <your_opengoo>/public/upgrade and choose to upgrade from 0.9 to 1.0.
    6. If necessary, refresh your browser or clear its cache so that the new javascript, css and images load.
    
    
	Open Source Libraries 
	=====================
	
	The following open source libraries and applications have been adapted to work with OpenGoo:

	- ActiveCollab 0.7.1 - http://www.activecollab.com
	- ExtJs - http://www.extjs.com
	- JQuery - http://www.jquery.com
	- Reece Calendar - http://sourceforge.net/projects/reececalendar
	- Swift Mailer - http://www.swiftmailer.org
	- Open Flash Chart - http://teethgrinder.co.uk/open-flash-chart
	- Slimey - http://slimey.sourceforge.net
	- FCKEditor - http://www.fckeditor.net
	- JSSoundKit - http://jssoundkit.sourceforge.net
	- Services_JSON - http://pear.php.net/pepr/pepr-proposal-show.php?id=198


	Changelog
	=========
	
	Since 1.0 RC3
	-------------

	- Bugfix: Trying adding an event in two weeks and a day would add it today.	
	- Bugfix: A user should always have permission to edit his preferences.		
	- Bugfix: Some calendar views aren't displayed correctly on Safari and Firefox 2
	- Bugfix: When entering data in the quick add task and then going to "All options" you lose what you have entered.
	- Bugfix: Some texts in the calendar weren't translatable.
	- Bugfix: It wasn't possible to delete mails from the mail view.
	- Bugfix: It wasn't possible to quickly add tasks in groups other than milestones.
	- Bugfix: Calendar tooltips weren't displayed correctly when the event description had line breaks.
	- The option to save a milestone as a template was removed.
	- The warning in the installation that said that the product is in beta was removed.
	- Bugfix: An event created for "All day" in the weekly view is always added today.
	- Bugfix: "unterminated string literal" when showing the monthly view in the calendar.
	- Bugfix: Changing a parent workspace would break the workspace hierarchy for the children.
	- Bugfix: Escape html entities on workspace path divs.
	- Several translations changed from "project" to "workspace" in en_us and from "proyecto" and "espacio" to "área de trabajo" in es_es.
	- Bugfix: invalid argument in foreach() in Comments::getSUbscriberComments()
	- Disabled by default the automatic upgrade check.
	
	Since 1.0 RC2
	-------------

	- Bugfix: allow a non admin user to link contacts that have an associated user.
	- Bugfix: contacts aren't displayed in alphabetical order	
	- Bugfix: 'show dates' doesn't work on tasks interface	
	- Missing lang: 'edit event details' for the calendar	
	- Missing lang: 'user ws config option name tasksGroupBy'	
	- Missing lang: 'user ws config option name tasksOrderBy'	
	- Use a DateField to choose the end date for repeating events.	
	- Bugfix: Adding an event on IE would return an error when reloading the weekly view	
	- Bugfix: It wasn't possible to instantiate task templates, even if it was assigned to the current workspace.	
	- Bugfix: When deleting a workspace it first returns a success message and then an error message.	
	- Bugfix: When changing workspace it always displayed the weekly view and not the currently selected view.	
	- Bugfix: When editing an event it is saved into the log as a new event action.	
	- Bugfix: Fix the workspace chooser on the quick add task interface.	
	- Remove unimplemented features from FCKEditor, like browsing the server.	
	- Bugfix: Searching emails doesn't work correctly	 	
	- Bugfx: CAL_ENDING_DATE_ERROR when trying to modify the date and time of an event	
	- Bugfix: CAL_ENDING_DATE_ERROR constant not defined	
	- Change the "More" category on the "New task" interface for something more descriptive	
	- Bugfix: Email, "Unread" is not translatable. 	
	- Bugfix: If DEBUG is defined as false and DEBUG_DB is true OpenGoo doesn't work.	
	- When adding an event, when unchecking "All day", the duration of the event is by default 0 hours. Change to 1 hour and change default time to 9 AM	.
	- Bugfix: when you can't manage contacts, contacts are listed on the Object Picker anyway	
	- When adding a subtask it should inherit the parent task's milestone. 	
	- The order of company_id:user_id when selecting a user or company from a combobox isn't consistent across the application.	
	- Bugfix: Current day is not displayed correctly on the calendar (October 31st is displayed as October 1st)	
	- Bugfix: The 'ungrouped' text in one of the upper comboboxes in the calendar view.	
	- Bugfix: The text that reads 'completo' should say 'completar' in spanish translations.	
	- Remove the feature that automatically completes a parent task when completing all subtasks.	
	- Bugfix: On IE, when saving an HTML document a message pops up asking if the user wants to leave the page.	
	- Bugfix: permission problems when linking a contact to a message.	
	- Bugfix: error 500 when trying to view an object's history	
	- estaba en vista semanal y le di para avanzar dos meses y termine en vista mensual dentro de tres meses	
	- Bugfix: IE throws several errors when starting OpenGoo.	
	- Bugfix: IE throws an error when hovering workspace choosers 	
	- Improve the workspace chooser to resemble a combobox.	
	- Improve the format of notification emails.	
	- Missing lang: view milestone.	
	- Missing langs in tasks (es_es)	
	- Bugfix: the 'quick assign to' is not working in Chrome	
	- Bugfix: search for file content is not working.	
	- Bugfix: The invitations panel isn't visible in Chrome	
	- Sort alphabetically the 'assigned to' of the 'quick add' 	
	- Make the 'assigned to' combobox the same value as the current tasks filter 'assigned to' when adding a task from the tasks interface.	
	- Don't notify myself by default when creating or editing an event.
	- Don't show template subtasks when listing task templates.		
	- Don't display 'notify by mail' when assigning a task to a company.	
	- Bugfix: A user with read permissions can delete documents and weblinks
	- Fix the upgrade notification mechanism	
	- Mail notification's subject is 'Agregar Comentario' instead of 'Comentario agregado' in spanish translations.	
	- 'Vincular estos objetos' doesn't seem the right translation.	
	- Bugfix: Tooltips in calendar duplicate when moving the mouse.	
	- Wrong translations on repeating events: Days/Weeks/Months/Years
	
	Since 1.0 RC1
	-------------
	
	- Bugfix: Some workspaces in the workspace panel remained highlighted after the mouse left the panel.
	- Bugfix: Telephone numbers weren't shown on a Company's view.	
	- Bugfix: Removed some duplicate http get paremeters in urls.	
	- Allow to edit the role of a contact in the current workspace when editing the contact.	
	- Localization of the datepicker	
	- Bugfix: Email addresses were displayed incorrectly on emails. 	
	- Bugfix: Calendar scrolls screen down, leaving the header of the page inaccessible	
	- Bugfix: When deleting an object in listsings, the checkbox for the next object is checked.	
	- Allow me to see only stuff related to me in the dashboard.	
	- added 'email' in the 'new' menu in the 'view as list' dashboard.	
	- Bugfix: Error 500 when going to 'More'->'Properties' in 'Documents'	
	- Aesthetically improved some ugly interfaces, most in 'administration'	
	- Bugfix: When editing a company's permissions the workspaces that the company can access aren't shown as checked.	
	- Bugfix: In the calendar, the weekly view's title says "From X/Y to (X+7)/Y" but it should say "From X/Y to (X+6)/Y"	
	- Bugfix: Event editions are saved as event creations on the history.	
	- Bugfix: An event from 10 am to 11 am and an event from 11 am to 12 pm are both split in half even though there's no need to do so.	
	- Bugfix: Search doesn't find events.	
	- Bugfix: When entering data to the quick add event and then going to "Edit event details" the entered data isn't kept.	
	- Bugfix: New events are notified as Changed.	
	- Bugfix: The date in the "pick a date" menu should be synchronized wuth the currently selected date/view.	
	- Bugfix: Combobox to confirm attendance to an event doesn't work on Chrome.	
	- Warn the user when he tries to set a task's due date later than the start date.
	- Bugfix: When a filename contains non-ascii characters the name checking priort to uploading a file doesn't work.	
	- Bugfix: In the dashboard's calendar, events are always added "today"	
	- Bugfix: adding an event 12 am adds it at 12 pm	
	- Bugfix: Firefox doesn't show correctly the green progress bars in milestones	
	- Bugfix: IE 7 doesn't display user accounts when editing a workspace's permissions unless you scroll down. 	
	
	Since 0.9.2
	-----------

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
	- Easily backup your OpenGoo installation from the Administration panel.
	- Several configuration options added, accessible through Account / Edit preferences, including for example, choosing
		what widgets you see on the dashboard and choosing whether to show information about all users or only you.
	- Improved workspace selection controls throughout OpenGoo.
	- Improved date selection controls throughout OpenGoo.
	- Improved the tag input control.
	- Images are now displayed in the CO view.
	- Bugfix: Emails are listed correctly on the Emails panel.
	- Bugfix: Editing Company details would make the user not able to log in.
	- Bugfix: Total task time report fixed.
	- Bugfix: Adding users on PHP lower than 5.2 fixed.
	- Bugfix: Editing a user without changing his workspace permissions would take away all his workspace permissions.
	- Bugfix: Assigning a task template to a workspace fixed.
	- Bugfix: It is not checked whether a contact is already assigned to a workspace.	
	- Bugfix: If a document contains inline CSS it corrupts OpenGoo's style when viewing the document's view.	
	- Bugfix: ObjectPicker resizes wrongly.	
	- Clicking a workspace in search results selects it.
	- When assigning a task to a user assign also its subtasks.	
	- Bugfix: Refreshing tags would leave the "loading" sign after fetching the tags.	
	- Bugfix: Some objects didn't appear when linking objects.	
	- A big preview of an image is shown on the image's view.	
	- Bugfix: search results showed HTML code when there were no results.	
	- Confirm before leaving a presentation with changes.	
	- Changed the class used for encoding/decoding JSON in PHP lower than 5.2	
	- Warn about memory usage	
	- Bugfix: several issues with the tasks time report.	
	- The email dashboard widget now only shows email from the currently selected workspace.		
	