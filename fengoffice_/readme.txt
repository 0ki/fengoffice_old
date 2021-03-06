
    About OpenGoo 1.6 beta 2
    ========================

    OpenGoo is a free and open source WebOffice, project management and collaboration
    tool, licensed under the Affero GPL 3 license.

    visit:
        * http://www.opengoo.org/
        * http://forums.opengoo.org/
        * http://wiki.opengoo.org/
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
    
    4. Some functionality may require further configuration, like setting up a cron job.
    Check the wiki for more information: http://wiki.opengoo.org/doku.php/setup
    
    WARNING: Default memory limit por PHP is 8MB. As a new OpenGoo install consumes about 10 MB,
    administrators could get a message similar to "Allowed memory size of 8388608 bytes exhausted".
    This can be solved by setting "memory_limit=32" in php.ini.    


    Upgrade instructions
    ====================
    
    1. Backup you current installation (important!)
    2. Download OpenGoo 1.6 beta - http://www.opengoo.org/
    3. Unpack into your OpenGoo installation, overwriting your previous files and folders,
    	but keeping your config and upload folders.
    5. Go to <your_opengoo>/public/upgrade in your browser and choose to upgrade
    	from your current version to 1.6 beta
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
	
	Since 1.6-beta
	--------------
	
	feature: Added an experimental new search mechanism. It can be much slower but finds more results.
	
	usability: Added description to system permissions
	usability: CKEditor is shown in user's language
	usability: Linked objects section in an object's view has no title telling what it is
		
	bugfix: Check write permissions for file installed_version.php when upgrading
	bugfix: CKEditor images should point to the actual image in OpenGoo
	bugfix: Contact import from csv does not import contacts if user does not have 'can manage contacts' permission but has write permissions on the workspace.
	bugfix: Custom reports can only be printed once in Chrome.
	bugfix: Edit comment textbox is too small.
	bugfix: Email links are opened on the email's body when showing quoted text.
	bugfix: Error 500 when adding a file web link.
	bugfix: Forgot password token is always the same.
	bugfix: If I click on 'Print' when on 'Time' tab it should print by default 'General Timeslots' or 'All timeslots', not 'Task timeslots'.
	bugfix: If you delete a signature with images from the email's body, the images are sent anyway.
	bugfix: MySQL Error Message when adding a user and no data has been entered.	
	bugfix: Removed private milestone options.
	bugfix: Search ignores tags on newly uploaded files.
	bugfix: Show all linked objects pagination is not working correctly.
	bugfix: Show that an email has attachment on search results.
	bugfix: Changed all PHP 5.3 deprecated functions for non-depracated alternatives.
	bugfix: When printing reports: substitute true/false with yes/no.
	bugfix: When user does not have write contact permissions over a workspace, import from csv does not display errors.
	bugfix: HTML editor's height is not adjusted correctly when changing format in a new email.
	bugfix: Error when creating new user.
	bugfix: Error when adding a task.

	
	Since 1.5.3
	-----------

	feature: Archive objects and workspaces.
	feature: Mark as read/unread for all objects
	feature: Share mail accounts among several users.
	feature: Assign a workspace to a mail account to automatically classify email to that workspace
	feature: Group emails into conversations.
	feature: Email attachments from file system.
	feature: Email Junk folder (mail classified as spam by your mail server is sent to a "Junk" folder)
	feature: Emails are sent asynchronously (you can continue working on OpenGoo while an email is being sent)
	feature: Send emails as attachments from OpenGoo
	feature: Create a task from an email.
	feature: Insert images into OpenGoo documents and emails
	feature: Allow events to span more than one day and support drag and drop for these events and repeating events.
	feature: Upgraded document editor to CKEditor 3.0
	feature: Editing Concurrency: warn user if object being edited was edited by someone else.
	feature: Improved password recovery procedure.
	feature: Config option to detect mime type from extension
	feature: Option to autodetect timezone
	feature: New toolbar menu to remove tags
	feature: New type of parameter "User" for Templates.	
	feature: VCard Import
	
	usability: Improved workspace permissions edition
	usability: Display tags on events in the calendar
	usability: Don't shrink avatars and logos if the size is not too big. Let the browser shrink it.
	usability: Email listing: new "actions" column (reply, reply all and forward)	
	usability: Rearranged toolbar icons
	usability: Linked objects are now displayed the object's body.
	usability: Filter the Object Picker* by text (*control used to pick objects when linking)
	usability: "mailto" (email address) links open opengoo's "add mail" dialog instead of the default mail client (if the user has an email account).
	usability: Email filters are noew remembered.
	usability: Reporting: New control to select report columns, allow user to change column order.
	usability: Sent emails are now marked as read automatically
	usability: When changing subscribers or linked objects, do not reload the whole object view, only reload the object/user list that changed.	
	usability: When dragging objects to 'All' tag, remove all tags from the object (ask for confirmation first)
	usability: People invited to an event are subscribed.
	usability: Allow submitting form by pressing enter when saving a doc, quick adding a task, adding a timeslot
	usability: Paginated user listing in "Administration" / "Users".
	usability: Pre-configurations for known emails (GMail, Hotmail, Yahoo) when setting up an email account
	usability: Groups' user selection improved.	

	bugfix: File upload fails on Opera 10.
	bugfix: Fixed events "Holiday" repeating.
	bugfix: Forwarded emails are being truncated and attachments are being dropped.
	bugfix: Attachments were not saved in drafts.
	bugfix: Cannot send emails to addresses with apostrophes.
	bugfix: Fixed some issues about reminders in repetitive tasks and templates.
	bugfix: If I'm logged in as a user on one tab and login as another user on another tab, the first tab will show me as the first user but behave as if logged as the second user regarding permissions.
	bugfix: Repetitive tasks didn't behave correctly with subtasks' subtasks.
	bugfix: Received emails with account's email address as "From" were marked as read before being read.
	bugfix: Custom Properties: when a CP is deleted, it is not deleted from report columns and report conditions.
	bugfix: Don't show or send notifications to subscribers that don't have permissions.
	bugfix: In IE 7, the repetitive task icon and the add contact icon ('+' in mail view) are not shown.
	bugfix: Opera: Pressing enter on email autocomplete sends email.
	bugfix: Reporting: Company report with date condition = 30/07/09 shows correct results, but shows wrong condition 28/07/09 (Verision 1.4.2).
	bugfix: Reports does not works if there are 2 parametrizable conditions over the same custom property (e.g. Num > X and Num < Y)
	bugfix: Show email sent by me to me also in the Inbox.
	bugfix: Trashed objects are being shown in reports.
	bugfix: When selecting Milestone and checking 'Apply to subtasks' in quick edit view, the milestone is not updated for the subtasks, you have to refresh.
	bugfix: Removed Cache-Control and Pragma headers when downloading a file which caused errors on some configurations.
	bugfix: Unified nomenclature for companies for spanish.
	bugfix: User custom properties can't be edited, unless they are 'visible by default' or 'required'.
	bugfix: Weblink created yesterday 21:30, when viewing it today, it says 'created on: today at 21:30'.
	bugfix: When an administrator is removed from the owner company it should be removed from the 'administrators' group.
	bugfix: Background images are not blocked when viewing emails (background attibute must be removed from tags, in the same way as img tags).
	bugfix: Spaces should be ignored when setting values for a list-type custom property.
	bugfix: Custom properties of type "Memo" don't respect line breaks when shown.
