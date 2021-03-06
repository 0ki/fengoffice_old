
    About Feng Office 1.6.2
    =======================

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
    2. Download Feng Office 1.6.2 - http://fengoffice.com/web/community/
    3. Unpack into your Feng Office installation, overwriting your previous files and folders,
    	but keeping your config and upload folders.
    5. Go to <your_feng>/public/upgrade in your browser and choose to upgrade
    	from your current version to 1.6.2
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
	
	Since 1.6.1
	-----------
	
	feature: Apply a task's assignee to all subtasks.
	
	usability: Allow changing the maximum tasks display limit in the Tasks module.
	usability: Speeded up the quick mark as read (blue dots in listings).
	usability: Added actions in the email view to move to and out of the Junk folder and to mark as unread.
	usability: Allow to set a subtask's start and due date when adding it from the parent task's view.
	
	bugfix: When I'm editing a user, the user gains access to my personal workspace if I don't have access to his.
	bugfix: When editing a user's personal workspace you should be able to chose from all workspaces, not only yours.
	bugfix: Full search engine now matches words individually instead of matching the whole phrase.
	bugfix: White screen of death when downloading files added before version 1.4.
	bugfix: Week numbers for january were incorrect.
	bugfix: Error 500 when importing companies.
	bugfix: Some links in email didn't open in new windows.
	bugfix: When creating a contact, objects linked to the contact were ignored.
	bugfix: Escape invalid UTF8 characters before saving an email to avoid database errors.
	bugfix: Pick date widgets were not being shown full size on IE8.
	bugfix: Convert \n, \r, etc in vcard files when importing contacts.
	bugfix: Improved compatibility with RSS readers - changed the "pubdate" tag to "pubDate"
	bugfix: When checking email through cron, the "max spam level" user config option was disregarded.
	bugfix: The User column for emails in the Oveview List was the owner of the email account and not the user who wrote the email.
	bugfix: User with read access to an email account didn't view emails in the Overview List.
	bugfix: Missing lang 'success archive files'.
	bugfix: The string "None" was hardcoded in english in some fields of the time report.
	bugfix: User with permissions to edit owner company data cannot edit the logo.
	bugfix:  
	
	system: Request username when changing old password for increased security.
	

	Since 1.6
	---------
	
	feature: Allow changing a user's personal workspace.
	feature: Add comments to Contacts and Companies.
	
	bugfix: Email deleted from trash was being fetched again from server.
	bugfix: Delete mail from server was not working correctly. Could delete non-fetched emails.
	bugfix: Workspace description on dashboard was always being shown, despite of the "Show description" option in the workspace edit view.
	bugfix: Owner company's email showed a trailing double quote.
	bugfix: Unable to add new users under certain password configurations.
	bugfix: Added an option to reset user interface state.
	bugfix: An UID for sent emails is now generated when stored in the database.
	bugfix: Allow the plus sign in rendered URLs.
	bugfix: Added a missing config option to detect file types by extension.
	bugfix: Hide zip and unzip actions if Zip extension is not installed on server.
	bugfix: Users invited to an event were automatically subscribed. Now you can subscibe them by checking a check box.
	bugfix: Users invited to an event were not uninvited when editing an event and deselecting them.
	bugfix: Archived completed tasks and milestones were not shown in Archived Objects listing.
	bugfix: Clicking on a row in the Trash Can doesn't select the row.
	bugfix: Selecting a draft email and clicking on "Move to trash" didn't send it to the trash.
	bugfix: Drag and drop of tasks and milestones in calendar monthly view was not working.
	bugfix: Deleting tags in Overview / View as list was not working.
	bugfix: Unable to update a file if revision comments are mandatory.
	bugfix: Unable to classify emails with no attachments by using the Classify button.
	bugfix: <Hidden quoted text> message in emails is no longer shown for quoted text inside quoted text, only for the top level quoted text.
	bugfix: Added style to quoted text in sent emails (left border).
	
	
	Since 1.6-rc
	------------
	
	bugfix: Some widgets in the dashboard showed wrong icons when item spanned more than one line.
	bugfix: Template subtasks don't keep linked objects.
	bugfix: Query error when upgrading from 1.5.3.
	bugfix: Missing lang for archived objects in objects' history.
	bugfix: Don't allow trashing the owner company.
	bugfix: Feng Office stops working if owner company was trashed.
	bugfix: When discarding an email, two confirmation prompts pop up.
	bugfix: When clicking on print report, on time module, the active workspace should be set as the workspace for the report.
	bugfix: Linked "Weblink files" showed a "Download" shortcut instead of an "Open weblink" shortcut.
	bigfix: Importing calendar ics file wasn't working.
	bugfix: When editing a document, tags were lost.
	bugfix: Send email buttons unaligned on some languages.
	bugfix: Some contact websites were missing the "http://" in the contacts listing.
	bugfix: Fixed detection of autodetect timezone config option.
	bugfix: Repeating events a fixed number of times didn't show the last repetition.
	bugfix: Changed how quoted text is hidden.
	bugfix: Added a tabstop to HTML email composing.
	bugfix: Sorting emails by subject sorted by date.
	bugfix: Sometimes completed tasks were shown when filtering by "Pending" (completed_by_id was 0).

	
	Since 1.6-beta3
	---------------
	
	feature: User config option to hide quoted text added.
	feature: Added a cron event to clear tmp folder.
	
	usability: Added an icon for archived objects on the object's view, like there is for trashed objects.
	usability: When deleting a company warn about deleting users.
	
	bugfix: Displaying a document in IIS showed "Connection reset error".
	bugfix: Tags with accents don't filter correctly on IE.
	bugfix: '24 hour' / 'AM-PM' user config option not respected in listings.
	bugfix: Add user: billing category is mandatory, it shouldn't be mandatory.
	bugfix: Error importing companies when no workspace is selected.
	bugfix: If forwarding an email with attachments, saving a draft, and sending the email, an error pops up about not being able to attach.
	bugfix: When importing contacts from a vCard file, all contacts with no email were considered as the same contact.
	bugfix: Fixed several Errors and warnings logged in log.php.
	bugfix: Objects of archived workspaces were not being filtered out.
	bugfix: Archived documents and messages were not being filtered out of the Dashboard.
	bugfix: Search results were printed in reverse modified date order.
	bugfix: Contact birthdays were not being shown in the dashboard calendar.
	bugfix: When viewing a custom report, date parameters in conditions were shown as today's date.
	
	
	Since 1.6-beta2
	---------------
	
	usability: Added pagination to the Time module.
	usability: Show 'Archived by' in object properties if an object is archived.
	usability: Show read/unread status in Dahsboard/View as list.
	usability: Warn a user when replying or forwarding an email and a new email arrives at the conversation.
	usability: Add the magnifying glass to the email views.
	usability: Removed 'Account already being checked' error message.
	
	bugfix: An empty 'Custom properties' fieldset is shown in 'Update profile'.
	bugfix: Fix autodetect timezone with DST and enable by default.
	bugfix: Check mail doesn't refresh view if an error occurs in one account.
	bugfix: Filtering email conversations by tag is not working correctly. It should show a conversation if any one email in it is tagged.
	bugfix: If someone replies to an email but changes the subject the email should be put into a new conversation.
	bugfix: If you delete the newest email in a conversation, the conversation is no longer listed (when email is shown as conversation).
	bugfix: Notifications are not sent when subscribing from 'Modify subscribers'.
	bugfix: Put default repetition value for repeating events and tasks.
	bugfix: Remove illegal UTF-8 characters before saving an email.
	bugfix: Save custom fields when saving an email draft.
	bugfix: Sort emails by received date instead of sent date in email listing and in conversation listing (in email view).
	bugfix: Value for 'mail_drag_prompt' user config option is not loaded correctly.	
	bugfix: Wrap HTML emails in a div with CKEditor style.
	bugfix: Delete conversation after deleting last email in conversation.
	bugfix: An email's quoted reply is deleted when changing 'From' account.
	bugfix: Replying to an email, saving as draft, loading the draft and sending the email doesn't add the reply to the conversation.
	bugfix: Unauthenticated content warnings over SSL in FF 3.5.
	bugfix: User-type custom reports fail to execute.
	bugfix: When a file is downloaded it should be marked as read.
	bugfix: Wrong initial email filters for new installations.
	
	
	Since 1.6-beta
	--------------
	
	feature: Added an experimental new search mechanism. It can be much slower but finds more results.
	
	usability: Added description to system permissions
	usability: CKEditor is shown in user's language
	usability: Linked objects section in an object's view has no title telling what it is
		
	bugfix: Check write permissions for file installed_version.php when upgrading
	bugfix: CKEditor images should point to the actual image in Feng Office
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
	feature: Emails are sent asynchronously (you can continue working on Feng Office while an email is being sent)
	feature: Send emails as attachments from Feng Office
	feature: Create a task from an email.
	feature: Insert images into Feng Office documents and emails
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
	usability: "mailto" (email address) links open Feng Office's "add mail" dialog instead of the default mail client (if the user has an email account).
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
