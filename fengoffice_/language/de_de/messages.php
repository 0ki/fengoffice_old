<?php

  /**
  * Array of messages file (error, success message, status...)
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */

  return array(
  
    // Empty, dnx et
    'no mail accounts set' => 'There are no email accounts through which to send an email, please create an email account first',
    'no mail accounts set for check' => 'You have no email accounts, please create an email account first',
    'email dnx' => 'Requested email does not exist',
  	'email dnx deleted' => 'Requested email was deleted from database',
    'project dnx' => 'Requested workspace does not exist in database',
    'contact dnx' => 'Requested contact does not exist in database',
    'company dnx' => 'Requested company does not exist in database',
    'message dnx' => 'Requested note does not exist',
    'no comments in message' => 'There are no comments on this note',
    'no comments associated with object' => 'There are no comments posted for this object',
    'no messages in project' => 'There are no notes in this workspace',
    'no subscribers' => 'There are no users subscribed to this object',
    'no activities in project' => 'There are no activities logged for this workspace',
    'comment dnx' => 'Requested comment does not exist',
    'milestone dnx' => 'Requested milestone does not exist',
    'task list dnx' => 'Requested task does not exist',
    'task dnx' => 'Requested task does not exist',
    'event type dnx' => 'Requested event type does not exist',
    'no milestones in project' => 'There are no milestones in this workspace',
    'no active milestones in project' => 'There are no active milestones in this workspace',
    'empty milestone' => 'This milestone is empty. You can add a <a class="internalLink" href="{1}">task</a> to it at any time',
    'no logs for project' => 'There are no log entries related to this workspace',
    'no recent activities' => 'There are no recent activities logged in the database',
    'no open task lists in project' => 'There are no open task in this workspace',
    'no completed task lists in project' => 'There are no completed task in this workspace',
    'no open task in task list' => 'There are no open tasks in this list',
    'no closed task in task list' => 'There are no open tasks in this list',
    'no open task in milestone' => 'There are no open tasks in this milestone',
    'no closed task in milestone' => 'There are no closed tasks in this milestone',
    'no projects in db' => 'There are no defined workspaces in database',
    'no projects owned by company' => 'There are no workspaces owned by this company',
    'no projects started' => 'There are no started workspaces',
    'no active projects in db' => 'There are no active workspaces',
    'no new objects in project since last visit' => 'There are no new objects in this workspace since your last visit',
    'no clients in company' => 'Your company does not have any registered clients',
    'no users in company' => 'There are no users in this company',
    'client dnx' => 'Selected client company does not exist',
    'company dnx' => 'Selected company does not exist',
    'user dnx' => 'Requested user does not exist in database',
    'avatar dnx' => 'Avatar does not exist',
    'no current avatar' => 'Avatar is not uploaded',
    'picture dnx' => 'Picture does not exist',
    'no current picture' => 'Picture is not uploaded',
    'no current logo' => 'A logo is not uploaded',
    'user not on project' => 'Selected user is not involved in selected workspace',
    'company not on project' => 'Selected company is not involved in selected workspace',
    'user cant be removed from project' => 'Selected user can\'t be removed from workspace',
    'tag dnx' => 'Requested tag does not exist',
    'no tags used on projects' => 'There are no tags used on this workspace',
    'no forms in project' => 'There are no forms in this workspace',
    'project form dnx' => 'Requested workspace form does not exist in database',
    'related project form object dnx' => 'Related form object does not exist in database',
    'no my tasks' => 'There are no tasks assigned to you',
    'no search result for' => 'There are no objects that match "<strong>{0}</strong>"',
    'no files on the page' => 'There are no files on this page',
    'folder dnx' => 'Folder you have requested does not exist in database',
    'define project folders' => 'There are no folders in this workspace. Please define folders in order to continue',
    'file dnx' => 'Requested file does not exists in the database',
    'not s5 presentation' => 'Cannot start slideshow because the file is not a valid S5 presentation',
    'file not selected' => 'There is no selected file',
    'file revision dnx' => 'Requested revision does not exists in the database',
    'no file revisions in file' => 'Invalid file - there are no revisions associated with this file',
    'cant delete only revision' => 'You can\'t delete this reivion. Every file need to have at least one revision posted',
    'config category dnx' => 'Configuration category you requested does not exists',
    'config category is empty' => 'Selected configuration category is empty',
    'email address not in use' => '{0} is not in use',
    'no linked objects' => 'There are no objects linked to this object',
    'object not linked to object' => 'No link exists between the selected object',
    'no objects to link' => 'Please select objects that need to be linked',
    'no administration tools' => 'There are no registered administration tools in the database',
    'administration tool dnx' => 'Administration tool "{0}" does not exists',
    
    // Success
    'success add contact' => 'Contact \'{0}\' has been created successfully',
    'success edit contact' => 'Contact \'{0}\' has been updated successfully',
    'success delete contact' => 'Contact \'{0}\' has been deleted successfully',
    'success edit picture' => 'Picture has been updated successfully',
    'success delete picture' => 'Picture has been deleted successfully',
    
    'success add project' => 'Workspace {0} has been added successfully',
    'success edit project' => 'Workspace {0} has been updated',
    'success delete project' => 'Workspace {0} has been deleted',
    'success complete project' => 'Workspace {0} has been completed',
    'success open project' => 'Workspace {0} has been reopened',
    
    'success add milestone' => 'Milestone \'{0}\' has been created successfully',
    'success edit milestone' => 'Milestone \'{0}\' has been updated successfully',
    'success deleted milestone' => 'Milestone \'{0}\' has been deleted successfully',
    
    'success add message' => 'Note {0} has been added successfully',
    'success edit message' => 'Note {0} has been updated successfully',
    'success deleted message' => 'Note \'{0}\' and all of its comments has been deleted successfully',
    
    'success add comment' => 'Comment has been posted successfully',
    'success edit comment' => 'Comment has been updated successfully',
    'success delete comment' => 'Comment has been deleted successfully',
    
    'success add task list' => 'Task \'{0}\' has been added',
    'success edit task list' => 'Task \'{0}\' has been updated',
    'success delete task list' => 'Task \'{0}\' has been deleted',
    
    'success add task' => 'Selected task has been added',
    'success edit task' => 'Selected task has been updated',
    'success delete task' => 'Selected task has been deleted',
    'success complete task' => 'Selected task has been completed',
    'success open task' => 'Selected task has been reopened',
    'success n tasks updated' => '{0} tasks updated',
	'success add mail' => 'Email sent successfully',
    
    'success add client' => 'Client company {0} has been added',
    'success edit client' => 'Client company {0} has been updated',
    'success delete client' => 'Client company {0} has been deleted',
    
    'success add group' => 'Group {0} has been added',
    'success edit group' => 'Group {0} has been updated',
    'success delete group' => 'Group {0} has been deleted',
    
    'success edit company' => 'Company data has been updated',
    'success edit company logo' => 'Company logo has been updated',
    'success delete company logo' => 'Company logo has been deleted',
    
    'success add user' => 'User {0} has been added successfully',
    'success edit user' => 'User {0} has been updated successfully',
    'success delete user' => 'User {0} has been deleted successfully',
    
    'success update project permissions' => 'Workspace permissions have been updated successfully',
    'success remove user from project' => 'User has been successfully removed from the workspace',
    'success remove company from project' => 'Company has been successfully removed from the workspace',
    
    'success update profile' => 'Profile has been updated',
    'success edit avatar' => 'Avatar has been updated successfully',
    'success delete avatar' => 'Avatar has been deleted successfully',
    
    'success hide welcome info' => 'Welcome info box has been successfully hidden',
    
    'success complete milestone' => 'Milestone \'{0}\' has been completed',
    'success open milestone' => 'Milestone \'{0}\' has been reopened',
    
    'success subscribe to object' => 'You have been successfully subscribed to this object',
    'success unsubscribe to object' => 'You have been successfully unsubscribed from this object',
    
    'success add project form' => 'Form \'{0}\' has been added',
    'success edit project form' => 'Form \'{0}\' has been updated',
    'success delete project form' => 'Form \'{0}\' has been deleted',
    
    'success add folder' => 'Folder \'{0}\' has been added',
    'success edit folder' => 'Folder \'{0}\' has been updated',
    'success delete folder' => 'Folder \'{0}\' has been deleted',
    
    'success add file' => 'File \'{0}\' has been added',
	'success save file' => 'File \'{0}\' has been saved',
    'success edit file' => 'File \'{0}\' has been updated',
    'success delete file' => 'File \'{0}\' has been deleted',
    'success delete files' => '{0} file(s) have been deleted',
    'success tag files' => '{0} file(s) have been tagged',
    'success tag contacts' => '{0} contact(s) have been tagged',
    
    'success add handis' => 'Handins have been updated',
    
    'success add properties' => 'Properties have been updated',
    
    'success edit file revision' => 'Revision has been updated',
    'success delete file revision' => 'File revision has been deleted',
    
    'success link objects' => '{0} object(s) has been successfully linked',
    'success unlink object' => 'Object has been successfully unlinked',
    
    'success update config category' => '{0} configuration values have been updated',
    'success forgot password' => 'Your password has been emailed to you',
    
    'success test mail settings' => 'Test mail has been successfully sent',
    'success massmail' => 'Email has been sent',
    
    'success update company permissions' => 'Company permissions updated successfully. {0} records updated',
    'success user permissions updated' => 'User permissions have been updated',
  
    'success add event' => 'Event has been added',
    'success edit event' => 'Event has been updated',
    'success delete event' => 'Event has been deleted',
    
    'success add event type' => 'Event Type has been added',
    'success delete event type' => 'Event Type has been deleted',
    
    'success add webpage' => 'Web link has been added',
    'success edit webpage' => 'Web link has been updated',
    'success deleted webpage' => 'Web link has been deleted',
    
    'success add chart' => 'Chart has been added',
    'success edit chart' => 'Chart has been updated',
    'success delete chart' => 'Chart has been deleted',
    'success delete charts' => 'The selected charts have been deleted successfully',
  
    'success delete contacts' => 'The selected contacts have been deleted successfully',
  
    'success classify email' => 'Email classified successfully',
    'success delete email' => 'Email has been deleted',
  
    'success delete mail account' => 'Email account has been deleted successfully',
    'success add mail account' => 'Email account has been created successfully',
    'success edit mail account' => 'Email account has been updated successfully',
  
    'success link object' => 'Object has been linked successfully',
  
  	'success check mail' => 'Email retrieval complete: {0} emails received.',
  
	'success delete objects' => '{0} Object(s) deleted successfully',
	'success tag objects' => '{0} Object(s) tagged successfully',
	'error delete objects' => 'Failed to delete {0} object(s)',
	'error tag objects' => 'Failed to tag {0} object(s)',
	'success move objects' => '{0} Object(s) moved successfully',
	'error move objects' => 'Failed to move {0} object(s)',
  
    'success checkout file' => 'File checked out successfully',
    'success checkin file' => 'File checked in successfully',
  	'success undo checkout file' => 'File checkout canceled successfully',
    
    // Failures
    'error edit timeslot' => 'Failed to save timeslot',
  	'error delete timeslot' => 'Failed to delete the selected timeslot',
  	'error add timeslot' => 'Failed to add timeslot',
  	'error open timeslot' => 'Failed to open timeslot',
  	'error close timeslot' => 'Failed to close timeslot',
    'error start time after end time' => 'Failed to save timeslot: the start time must happen before the end time',
    'error form validation' => 'Failed to save object because some of its properties are not valid',
    'error delete owner company' => 'Owner company can\'t be deleted',
    'error delete message' => 'Failed to delete selected note',
    'error update message options' => 'Failed to update note options',
    'error delete comment' => 'Failed to delete selected comment',
    'error delete milestone' => 'Failed to delete selected milestone',
    'error complete task' => 'Failed to complete selected task',
    'error open task' => 'Failed to reopen selected task',
    'error upload file' => 'Failed to upload file',
    'error delete project' => 'Failed to delete selected workspace',
    'error complete project' => 'Failed to complete selected workspace',
    'error open project' => 'Failed to reopen selected workspace',
    'error delete client' => 'Failed to delete selected client company',
    'error delete group' => 'Failed to delete selected group',
    'error delete user' => 'Failed to delete selected user',
    'error update project permissions' => 'Failed to update workspace permissions',
    'error remove user from project' => 'Failed to remove user from workspace',
    'error remove company from project' => 'Failed to remove company from workspace',
    'error edit avatar' => 'Failed to edit avatar',
    'error delete avatar' => 'Failed to delete avatar',
    'error edit picture' => 'Failed to edit picture',
    'error delete picture' => 'Failed to delete picture',
    'error edit contact' => 'Failed to edit contact',
    'error delete contact' => 'Failed to delete contact',
    'error hide welcome info' => 'Faled to hide welcome info',
    'error complete milestone' => 'Failed to complete selected milestone',
    'error open milestone' => 'Failed to reopen selected milestone',
    'error file download' => 'Failed to download specified file',
    'error link object' => 'Failed to link object',
    'error edit company logo' => 'Failed to update company logo',
    'error delete company logo' => 'Failed to delete company logo',
    'error subscribe to object' => 'Failed to subscribe to selected object',
    'error unsubscribe to object' => 'Failed to unsubscribe from selected object',
    'error add project form' => 'Failed to add workspace form',
    'error submit project form' => 'Failed to submit workspace form',
    'error delete folder' => 'Failed to delete selected folder',
    'error delete file' => 'Failed to delete selected file',
    'error delete files' => 'Failed to delete {0} files',
    'error tag files' => 'Failed to tag {0} files',
    'error tag contacts' => 'Failed to tag {0} contacts',
    'error delete file revision' => 'Failed to delete file revision',
    'error delete task list' => 'Failed to delete selected task',
    'error delete task' => 'Failed to delete selected task',
    'error check for upgrade' => 'Failed to check for a new version',
    'error link object' => 'Failed to link object(s)',
    'error unlink object' => 'Failed to unlink object(s)',
    'error link objects max controls' => 'You can not add more object links. Limit is {0}',
    'error test mail settings' => 'Failed to send test message',
    'error massmail' => 'Failed to send email',
    'error owner company has all permissions' => 'Owner company has all permissions',
    'error while saving' => 'An error occurred while saving the document',
    'error delete event type' =>'Failed to delete event type',
    'error delete mail' => 'An error occurred while deleting this email',
    'error delete mail account' => 'An error occurred while deleting this email account',
    'error delete contacts' => 'An error has occurred while deleting these contacts',
  	'error check mail' => 'Error checking account \'{0}\': {1}',
  	'error check out file' => 'Error while checking out file for exclusive use',
    'error checkin file' => 'Error while checking in file',
    'error classifying attachment cant open file' => 'Error classifying attachment: can\'t open file',
  	'error contact added but not assigned' => 'The contact \'{0}\' was added but not assigned successfully to workspace \'{1}\' due to access permissions',
  	'error cannot set workspace as parent' => 'Cannot set workspace \'{0}\' as parent, too many workspace levels or circular reference',
  
    
    // Access or data errors
    'no access permissions' => 'You don\'t have permissions to access requested page',
    'invalid request' => 'Invalid request!',
    
    // Confirmation
    'confirm cancel work timeslot' => "Are you sure you want to cancel the current timeslot?",
    'confirm delete mail account' => 'Warning: All emails belonging to this account will be deleted as well, are you sure that you want to delete this mail account?',
    'confirm delete message' => 'Are you sure that you want to delete this note?',
    'confirm delete milestone' => 'Are you sure that you want to delete this milestone?',
    'confirm delete task list' => 'Are you sure that you want to delete this task and all of its sub tasks?',
    'confirm delete task' => 'Are you sure that you want to delete this task?',
    'confirm delete comment' => 'Are you sure that you want to delete this comment?',
    'confirm delete project' => 'Are you sure that you want to delete this workspace and all related data (notes, tasks, milestones, files...)?',
    'confirm complete project' => 'Are you sure that you want to mark this workspace as closed? All workspace actions will be locked',
    'confirm open project' => 'Are you sure that you want to mark this workspace as open? This will unlock all workspace actions',
    'confirm delete client' => 'Are you sure that you want to delete selected client company and all of its users?\nThis action will also delete the users\\\' personal workspaces.',
    'confirm delete contact' => 'Are you sure that you want to delete selected contact?',
    'confirm delete user' => 'Are you sure that you want to delete this user account?\nThis action will also delete the user\\\'s personal workspace.',
    'confirm reset people form' => 'Are you sure that you want to reset this form? All modifications you made will be lost!',
    'confirm remove user from project' => 'Are you sure that you want to remove this user from this workspace?',
    'confirm remove company from project' => 'Are you sure that you want to remove this company from this workspace?',
    'confirm logout' => 'Are you sure that you want to log out?',
    'confirm delete current avatar' => 'Are you sure that you want to delete this avatar?',
    'confirm unlink object' => 'Are you sure that you want to unlink this object?',
    'confirm delete company logo' => 'Are you sure that you want to delete this logo?',
    'confirm subscribe' => 'Are you sure that you want to subscribe to this object? You will receive an email everytime someone (except you) posts a comment on this object.',
    'confirm unsubscribe' => 'Are you sure that you want to unsubscribe?',
    'confirm delete project form' => 'Are you sure that you want to delete this form?',
    'confirm delete folder' => 'Are you sure that you want to delete this folder?',
    'confirm delete file' => 'Are you sure that you want to delete this file?',
    'confirm delete revision' => 'Are you sure that you want to delete this revision?',
    'confirm reset form' => 'Are you sure that you want to reset this form?',
    'confirm delete contacts' => 'Are you sure that you want to delete these contacts?',
	'confirm delete group' => 'Are you sure that you want to delete this group?',
    
    // Errors...
    'system error message' => 'We are sorry, but a fatal error prevented OpenGoo from executing your request. An Error Report has been sent to the administrator.',
    'execute action error message' => 'We are sorry, but OpenGoo is not currently able to execute your request. An Error Report has been sent to the administrator.',
    
    // Log
    'log add projectmessages' => '\'{0}\' added',
    'log edit projectmessages' => '\'{0}\' updated',
    'log delete projectmessages' => '\'{0}\' deleted',
  	'log trash projectmessages' => '\'{0}\' moved to trash',
  	'log untrash projectmessages' => '\'{0}\' restored from trash',
  
  	'log add projectevents' => '\'{0}\' added',
    'log edit projectevents' => '\'{0}\' updated',
    'log delete projectevents' => '\'{0}\' deleted',
  	'log trash projectevents' => '\'{0}\' moved to trash',
  	'log untrash projectevents' => '\'{0}\' restored from trash',
    
    'log add comments' => '{0} added',
    'log edit comments' => '{0} updated',
    'log delete comments' => '{0} deleted',
  	'log trash comments' => '\'{0}\' moved to trash',
  	'log untrash comments' => '\'{0}\' restored from trash',
    
    'log add projectmilestones' => '\'{0}\' added',
    'log edit projectmilestones' => '\'{0}\' updated',
    'log delete projectmilestones' => '\'{0}\' deleted',
    'log close projectmilestones' => '\'{0}\' finished',
    'log open projectmilestones' => '\'{0}\' reopened',
  	'log trash projectmilestones' => '\'{0}\' moved to trash',
  	'log untrash projectmilestones' => '\'{0}\' restored from trash',
    
    'log add projecttasklists' => '\'{0}\' added',
    'log edit projecttasklists' => '\'{0}\' updated',
    'log delete projecttasklists' => '\'{0}\' deleted',
    'log close projecttasklists' => '\'{0}\' closed',
    'log open projecttasklists' => '\'{0}\' opened',
  	'log trash projecttasklists' => '\'{0}\' moved to trash',
  	'log untrash projecttasklists' => '\'{0}\' restored from trash',
    
    'log add projecttasks' => '\'{0}\' added',
    'log edit projecttasks' => '\'{0}\' updated',
    'log delete projecttasks' => '\'{0}\' deleted',
    'log close projecttasks' => '\'{0}\' closed',
    'log open projecttasks' => '\'{0}\' opened',
  	'log trash projecttasks' => '\'{0}\' moved to trash',
  	'log untrash projecttasks' => '\'{0}\' restored from trash',
    
    'log add projectforms' => '\'{0}\' added',
    'log edit projectforms' => '\'{0}\' updated',
    'log delete projectforms' => '\'{0}\' deleted',
  	'log trash projectforms' => '\'{0}\' moved to trash',
  	'log untrash projectforms' => '\'{0}\' restored from trash',
    
    'log add projectfolders' => '\'{0}\' added',
    'log edit projectfolders' => '\'{0}\' updated',
    'log delete projectfolders' => '\'{0}\' deleted',
    
    'log add projectfiles' => '\'{0}\' uploaded',
    'log edit projectfiles' => '\'{0}\' updated',
    'log delete projectfiles' => '\'{0}\' deleted',
  	'log trash projectfiles' => '\'{0}\' moved to trash',
  	'log untrash projectfiles' => '\'{0}\' restored from trash',
    
    'log edit projectfilerevisions' => '{0} updated',
    'log delete projectfilerevisions' => '{0} deleted',
  	'log trash projectfilerevisions' => '\'{0}\' moved to trash',
  	'log untrash projectfilerevisions' => '\'{0}\' restored from trash',
    
    'log add projectwebpages' => '\'{0}\' added',
    'log edit projectwebpages' => '\'{0}\' updated',
    'log delete projectwebpages' => '\'{0}\' deleted',
  	'log trash projectwebpages' => '\'{0}\' moved to trash',
  	'log untrash projectwebpages' => '\'{0}\' restored from trash',
    
  	'log trash contacts' => '\'{0}\' moved to trash',
  	'log untrash contacts' => '\'{0}\' restored from trash',
  
  	'no contacts in company' => 'The company has no contacts.',
  
  	'session expired error' => 'The session has expired. Please, refresh the page and login again.',
  	'admin cannot be removed from admin group' => 'First user cannot be deleted from Administrators group',
  	'open this link in a new window' => 'Open this link in a new window',
  
  	'confirm delete template' => 'Are you sure that you want to delete this template?',
  	'success delete template' => 'Template \'{0}\' has been deleted',
  	'success add template' => 'Template has been added',
  
  	'log add companies' => '\'{0}\' added',
  	'log edit companies' => '\'{0}\' updated',
  	'log delete companies' => '\'{0}\' deleted',
  	'log trash companies' => '\'{0}\' moved to trash',
  	'log untrash companies' => '\'{0}\' restored from trash',
  
  	'log add mailcontents' => '\'{0}\' added',
  	'log edit mailcontents' => '\'{0}\' updated',
  	'log delete mailcontents' => '\'{0}\' deleted',
  	'log trash mailcontents' => '\'{0}\' moved to trash',
  	'log untrash mailcontents' => '\'{0}\' restored from trash',
  
  	'log open timeslots' => '\'{0}\' opened',
    'log close timeslots' => '\'{0}\' closed',
    'log delete timeslots' => '\'{0}\' deleted',
  	'log trash timeslots' => '\'{0}\' moved to trash',
  	'log untrash timeslots' => '\'{0}\' restored from trash',
  	'error assign workspace' => 'Failed to assign template to workspace',
  	'success assign workspaces' => 'Succeeded to assign template to workspace',
  	'success update config value' => 'Configuration values updated',
  	'view open tasks' => 'Open tasks',
  	'already logged in' => 'You are already logged in',
  
	'some tasks could not be updated due to permission restrictions' => 'Some tasks could not be updated due to permission restrictions',
  
  	'success trash object' => 'Object moved to trash successfully',
  	'error trash object' => 'Failed to move object to trash',
	'success untrash object' => 'Object restored from trash successfully',
  	'error untrash object' => 'Failed to restore object from trash',
  	'success trash objects' => '{0} objects moved to trash successfully',
  	'error trash objects' => 'Failed to move {0} objects to trash',
	'success untrash objects' => '{0} objects restored from trash successfully',
  	'error untrash objects' => 'Failed to restore {0} objects from trash',
	'success delete object' => 'Object deleted successfully',
  	'error delete object' => 'Failed to delete object',
  	
    'log add contacts' => '\'{0}\' added',
    'log edit contacts' => '\'{0}\' updated',
    'log delete contacts' => '\'{0}\' deleted',

  ); // array

?>