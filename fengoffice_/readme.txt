
    About OpenGoo 1.0 RC3 
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
    
    
    Upgrade from 0.9.X
    ==================
    
    1. Backup you current installation (important !)
    2. Download OpenGoo 1.0 RC1 - http://www.opengoo.org/
    3. Unpack and remove the following folders:
    	- cache (cache files)
    	- config (configuration options are stores here)
    	- public/files (avatars are stored here)
    	- tmp (temporary files)
    	- upload (uploaded files are stored here)
    4. Move remaining files and folders to your OpenGoo installation, replacing all files.
    5. In your browser, go to <your_opengoo>/public/upgrade and choose to upgrade from 0.9 to 1.0.
    6. If necessary, refresh your browser or clear its cache so that the new javascript, css and images load.
    
    
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
    
	Changelog (since 0.1.0 RC1)
	===========================

	- Bugfix: allow a non admin user to link contacts that have an associated user.
	- Bugfix: contacts aren't displayed in alphabetical order	
	- Bugfix: 'show dates' doesn't work on tasks interface	
	- Missing lang: 'edit event details' for the calendar	
	- Missing lang: 'user ws config option name tasksGroupBy'	
	- Missing lang: 'user ws config option name tasksOrderBy'	
	- Use a DateField to choose the end date for repeating events.	
	- Bugfix: Adding an event on IE would return an error when reloading the weekly view	
	- Bugfix: It wasn't possible to instantiate task templates, even if it was assigned to the current workspace.	
	- When deleting an event warn that you are deleting all invitations	
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
	- Bugfix: Trying adding an event in two weeks and a day would add it today.	
	- Bugfix: A user should always have permission to edit his preferences.		
	- Bugfix: Some calendar views aren't displayed correctly on Safari and Firefox 2
