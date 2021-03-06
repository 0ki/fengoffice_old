
    About Feng Office 1.7
    =====================

    Feng Office is a free and open source Web Office, project management
    and collaboration tool, licensed under the Affero GPL 3 license.

    visit:
        * http://www.fengoffice.com/
        * http://fengoffice.com/web/forums/
        * http://fengoffice.com/web/wiki/
        * http://sourceforge.net/projects/opengoo

    contact:
        * contact@fengoffice.com


    System requirements
    ===================

    Feng Office requires a web server, PHP (5.0 or greater) and MySQL (InnoDB
    support recommended). The recommended web server is Apache.

    Feng Office is not PHP4 compatible and it will not run on PHP versions prior
    to PHP5.

    Recommended:

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


    Upgrade instructions
    ====================
    
    1. Backup you current installation (important!)
    2. Download Feng Office 1.7 - http://fengoffice.com/web/community/
    3. Unpack into your Feng Office installation, overwriting your previous files and folders,
    	but keeping your config and upload folders.
    5. Go to <your_feng>/public/upgrade in your browser and choose to upgrade
    	from your current version to 1.7
    6. Refresh your browser or clear its cache to load new javascript, css and images.   

    
	Open Source Libraries 
	=====================
	
	The following open source libraries and applications have been adapted to work with Feng Office:
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
	
	
	Since 1.7-rc
	------------
	
	usability: Unclassify emails by dragging them to 'All'.
	
	bugfix: Calendar export was exporting events that the logged user was not invited to.
	bugfix: Event invitations: showing "no invitations sent" when user has permissions by group over the event.
	bugfix: Milestone selector loads data two times in task quick add.
	bugfix: Edit company action (at column in the listing) goes to edit contact.
	bugfix: Activity widget does not loads all the information.
	bugfix: ical sync stopped working after 1.7x upgrade.
	bugfix: Search finds workspaces without permissions.
	bugfix: Task dates 1 day before in task list.
	bugfix: 'Failed to upload file' when dragging an email with attachment and classifying it. 
	bugfix: Internal server error when trying to reply email without a configured account.
	bugfix: Bug with group users and subscribers.
	bugfix: Internal server error" when adding/modifying workspaces.
	bugfix: Calendar export timezone offset format for timezones > 0.
	bugfix: Error when listing files created/modified by a deleted user.
	bugfix: Download / trash revision icons are not shown in IE.
	bugfix: Workspace selector isn't drawn in workspace conditions for custom reports.
	bugfix: 'Error when ordering email reports by 'Updated by'
	bugfix: Workspace-group permissions not loaded when editing a workspace
	bugfix: Custom reports don't filter contacts correctly by workspace.
	bugfix: A type with only one custom property of type boolean cannot unset its value.
	bugfix: Custom reports cannot be filtered by more than one tag or workspace condition. Only the last one works.
	bugfix: Add/Edit workspace: Contacts show all fields as 'undefined'
	bugfix: Email auto refresh always loads page 1.
	bugfix: Clicking on 'Send Mail' when a draft is being saved doesn't send the email
	bugfix: Clicking on Search, Administration or Account or performing a search when it is already open doesn't bring it up.
	bugfix: Duplicate email messages.
	bugfix: A due date is allowed to be earlier than a start date in tasks.	
	bugfix: Forgot password doesn't work correctly when password has expired.
	bugfix: Revision required when classifying an email.
	bugfix: SQL error in calendar with MySQL older lower 5.0.
	bugfix: Event invitations are not shown correctly if the invited users are not directly assigned to the event's workspace.
	bugfix: Milestone dates are one day off if timezone is greater than GMT.
	bugfix: Duplicate title column in reports (replaced with an icon and removed in print view).
	
	system: Some language fixes
	system: Cleared non critical logged warnings
	system: Performance tweaks for object picker queries.
	
	
	Since 1.7-beta2
	---------------
	
	usability: Forwarded emails are linked to the original email.

	bugfix: when importing contacts from csv or vcard add them to the selected workspace
	bugfix: improved compatibility with vcard
	bugfix: When sending several emails, an error in one email will not stop the rest of being sent.
	bugfix: removed export buttons for task times report
	bugfix: archived milestones were still being shown
	bugfix: set the can_manage_time permission by default when creating a user
	bugfix: set all permissions when the user type is 'admin'
	bugfix: Error when sending email reminders (function 'html_to_text')
	bugfix: delete references to workspaces when deleting a group
	bugfix: Popup calendar was sometimes not displayed
	bugfix: Object picker doesn't filter correctly by type
	bugfix: Tabs are sometimes switched abruptly when content is loaded into a panel.
	
	system: small performance tweaks for listings
	system: limit the amount of reminders to send at once
	
	
	Since 1.7-beta
	--------------
	
	bugfix: Error when deleting an email from the trash.
	bugfix: Improved the workspace filter's performance
	bugfix: Missing lang: log comment projectfiles data
	bugfix: Tags of objects without workspaces were not being shown.
	bugfix: Permissions are now better considered when listing tags. (type permissions are taken into account)	
	bugfix: Error whgen editting workspace permissions assigned to a group.
	bugfix: Error when adding a subtask from the task's view
	bugfix: Current time marker in 5 day view is one day ahead.	
	bugfix: Task list view shows date one day ahead on some timezones
	usability: Don't ask whether to keep workspaces when dragging an email to a workspace if the email has no workspaces.
	
	Since 1.6.2
	-----------
	
	feature: "Latest activity" widget in dashboard.
	feature: Object views are logged and shown in the object's history.
	feature: HTML email notifications.
	feature: Added a Help panel.
	feature: Added a 5 day view for the calendar.
	feature: Export reports to CSV or PDF.
	feature: Guest Users added (read only users).
	feature: LDAP support.
	
	usability: Added an Urgent priority level for milestones.
	usability: Added an action in the emails toolbar to mark as SPAM all selected emails.		
	usability: Allow to define date properties for milestones in templates.
	usability: When sending linked attachments to an email address not belonging to a user, a guest user is created for that email address.
	usability: Email functions like Trashing, Classifying, Tagging, Archiving, Marking as Read/Unread are now snappier.	
	usability: Email listing is periodically auto refreshed.
	usability: Date format user preference is now chosen from a combobox, to avoid invalid formats.
	usability: Added versioning for file weblinks.
	
	system: Email data is stored on a separate database table to speed up email queries.
	
	bugfix: Some events were shown at the following day in the calendar, even though in the dashboard it was shown in the correct day.	
	bugfix: Some events were not being shown.
	bugfix: Event notifications arrive incorrectly.
	bugfix: A user assigned to a task could edit the task even without write permission for tasks. Now it can only complete it.	
	bugfix: Email content was not being indexed for search.
	bugfix: In some places users from a client company could see users from other client companies even if they shouldn't.	
	bugfix: Online documento content was not being indexed.
	bugfix: Forwarding an email would sometimes remove it from Inbox.	
	bugfix: In search results, dates from the previous year didn't include the year.
	bugfix: Email notifications showed wrong dates.			
	bugfix: IE8 pressing enter on quick add task adds two tasks.		
	bugfix: Other company users are not shown in filters when a user is allowed to assign tasks to external company users.	
	bugfix: Login screen looks bad in IE	
	bugfix: When adding or editing a group, all users are selected always
	bugfix: Sometimes after leaving email compose view it would refresh the whole page			
	bugfix: Drag and drop of tasks (milestones? contacts?) in monthly view not working	
	bugfix: Email To, CC and BCC autocomplete fields should not show any resulsts if there's no text after the last comma			
	bugfix: Repeating event daily X times shows X-1 repetitions.	
	bugfix: User passwords were not being deleted form the database after deleting a user.
	