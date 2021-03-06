<?php

  /**
  * Array of messages file (error, success message, status...)
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */

  return array(
  
    // Empty, dnx etc
    'project dnx' => 'Requested workspace does not exist in database',
    'message dnx' => 'Requested message does not exist',
    'no comments in message' => 'There are no comments on this message',
    'no comments associated with object' => 'There are no comments posted for this object',
    'no messages in project' => 'There are no messages in this workspace',
    'no subscribers' => 'There are no users subscribed to this message',
    'no activities in project' => 'There are no activities logged for this workspace',
    'comment dnx' => 'Requested comment does not exist',
    'milestone dnx' => 'Requested milestone does not exist',
    'task list dnx' => 'Requested task list does not exist',
    'task dnx' => 'Requested task does not exist',
    'event type dnx' => 'Requested event type does not exist',
    'no milestones in project' => 'There are no milestones in this workspace',
    'no active milestones in project' => 'There are no active milestones in this workspace',
    'empty milestone' => 'This milestone is empty. You can add a <a class="internalLink" href="{0}">message</a> or a <a class="internalLink" href="{1}">task list</a> to it at any time',
    'no logs for project' => 'There are no log entries related to this workspace',
    'no recent activities' => 'There are no recent activities logged in the database',
    'no open task lists in project' => 'There are no open task lists in this workspace',
    'no completed task lists in project' => 'There are no completed task lists in this workspace',
    'no open task in task list' => 'There are no tasks in this list',
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
    'email address not in use' => '%s is not in use',
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
    
    'success add message' => 'Message {0} has been added successfully',
    'success edit message' => 'Message {0} has been updated successfully',
    'success deleted message' => 'Message \'{0}\' and all of its comments has been deleted successfully',
    
    'success add comment' => 'Comment has been posted successfully',
    'success edit comment' => 'Comment has been updated successfully',
    'success delete comment' => 'Comment has been delete successfully',
    
    'success add task list' => 'Task list \'{0}\' has been added',
    'success edit task list' => 'Task list \'{0}\' has been updated',
    'success delete task list' => 'Task list \'{0}\' has been deleted',
    
    'success add task' => 'Selected task has been added',
    'success edit task' => 'Selected task has been updated',
    'success delete task' => 'Selected task has been deleted',
    'success complete task' => 'Selected task has been completed',
    'success open task' => 'Selected task has been reopened',
    'success n tasks updated' => '{0} tasks updated',
    
    'success add client' => 'Client company {0} has been added',
    'success edit client' => 'Client company {0} has been updated',
    'success delete client' => 'Client company {0} has been deleted',
    
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
    
    'success subscribe to message' => 'You have been successfully subscribed to this message',
    'success unsubscribe to message' => 'You have been successfully unsubscribed from this message',
    
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
    
    'success link objects' => '%s file(s) has been successfully linked',
    'success unlink object' => 'File(s) has been successfully unlinked',
    
    'success update config category' => '{0} configuration values have been updated',
    'success forgot password' => 'Your password has been emailed to you',
    
    'success test mail settings' => 'Test mail has been successfully sent',
    'success massmail' => 'Email has been sent',
    
    'success update company permissions' => 'Company permissions updated successfully. {0} records updated',
    'success user permissions updated' => 'User permissions have been updated',
  
    'success add event' => 'Event has been added',
    'success delete event' => 'Event has been deleted',
    
    'success add event type' => 'Event Type has been added',
    'success delete event type' => 'Event Type has been deleted',
    
    'success add webpage' => 'Weblink has been added',
    'success edit webpage' => 'Weblink has been updated',
    'success deleted webpage' => 'Weblink has been deleted',
  
    'success delete contacts' => 'The selected contacts have been deleted successfully',
  
    'success classify email' => 'Email classified successfully',
    'success delete email' => 'Email has been deleted',
  
    'success delete mail account' => 'Email account has been deleted successfully',
    'success add mail account' => 'Email account has been created successfully',
    'success edit mail account' => 'Email account has been updated successfully',
  
    'success link object' => 'Object has been linked successfully',
  
  	'success check mail' => 'Email retrieval complete: {0} emails received.',
  
	'success delete objects' => 'Object(s) deleted successfully',
	'success tag objects' => 'Object(s) tagged successfully',
	'error delete objects' => 'Failed to delete selected object(s)',
	'error tag objects' => 'Failed to tag selected object(s)',
    
    // Failures
    'error form validation' => 'Failed to save object because some of its properties are not valid',
    'error delete owner company' => 'Owner company can\'t be deleted',
    'error delete message' => 'Failed to delete selected message',
    'error update message options' => 'Failed to update message options',
    'error delete comment' => 'Failed to delete selected comment',
    'error delete milestone' => 'Failed to delete selected milestone',
    'error complete task' => 'Failed to complete selected task',
    'error open task' => 'Failed to reopen selected task',
    'error upload file' => 'Failed to upload file',
    'error delete project' => 'Failed to delete selected workspace',
    'error complete project' => 'Failed to complete selected workspace',
    'error open project' => 'Failed to reopen selected workspace',
    'error delete client' => 'Failed to delete selected client company',
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
    'error subscribe to message' => 'Failed to subscribe to selected message',
    'error unsubscribe to message' => 'Failed to unsubscribe from selected message',
    'error add project form' => 'Failed to add workspace form',
    'error submit project form' => 'Failed to submit workspace form',
    'error delete folder' => 'Failed to delete selected folder',
    'error delete file' => 'Failed to delete selected file',
    'error delete files' => 'Failed to delete {0} files',
    'error tag files' => 'Failed to tag {0} files',
    'error tag contacts' => 'Failed to tag {0} contacts',
    'error delete file revision' => 'Failed to delete file revision',
    'error delete task list' => 'Failed to delete selected task list',
    'error delete task' => 'Failed to delete selected task',
    'error check for upgrade' => 'Failed to check for a new version',
    'error link object' => 'Failed to link object(s)',
    'error unlink object' => 'Failed to unlink object(s)',
    'error link objects max controls' => 'You can not add more object links. Limit is %s',
    'error test mail settings' => 'Failed to send test message',
    'error massmail' => 'Failed to send email',
    'error owner company has all permissions' => 'Owner company has all permissions',
    'error while saving' => 'An error ocurred while saving the document',
    'error delete event type' =>'Failed to delete event type',
    'error delete mail' => 'An error ocurred while deleting this email',
    'error delete mail account' => 'An error ocurred while deleting this email account',
    'error delete contacts' => 'An error has ocurred while deleting these contacts',
  	'error check mail' => 'Error checking account \'{0}\': {1}',
    'error classifying attachment cant open file' => 'Error classifying attachment: can\'t open file',
  
    
    // Access or data errors
    'no access permissions' => 'You don\'t have permissions to access requested page',
    'invalid request' => 'Invalid request!',
    
    // Confirmation
    'confirm delete message' => 'Are you sure that you want to delete this message?',
    'confirm delete milestone' => 'Are you sure that you want to delete this milestone?',
    'confirm delete task list' => 'Are you sure that you want to delete this task lists and all of its tasks?',
    'confirm delete task' => 'Are you sure that you want to delete this task?',
    'confirm delete comment' => 'Are you sure that you want to delete this comment?',
    'confirm delete project' => 'Are you sure that you want to delete this workspace and all related data (messages, tasks, milestones, files...)?',
    'confirm complete project' => 'Are you sure that you want to mark this workspace as closed? All workspace actions will be locked',
    'confirm open project' => 'Are you sure that you want to mark this workspace as open? This will unlock all workspace actions',
    'confirm delete client' => 'Are you sure that you want to delete selected client company and all of its users?\nThis action will also delete the users\\\' personal projects.',
    'confirm delete contact' => 'Are you sure that you want to delete selected contact?',
    'confirm delete user' => 'Are you sure that you want to delete this user account?\nThis action will also delete the user\\\'s personal project.',
    'confirm reset people form' => 'Are you sure that you want to reset this form? All modifications you made will be lost!',
    'confirm remove user from project' => 'Are you sure that you want to remove this user from this workspace?',
    'confirm remove company from project' => 'Are you sure that you want to remove this company from this workspace?',
    'confirm logout' => 'Are you sure that you want to log out?',
    'confirm delete current avatar' => 'Are you sure that you want to delete this avatar?',
    'confirm unlink object' => 'Are you sure that you want to unlink this object?',
    'confirm delete company logo' => 'Are you sure that you want to delete this logo?',
    'confirm subscribe' => 'Are you sure that you want to subscribe to this message? You will receive an email everytime someone (except you) posts a comment on this message?',
    'confirm unsubscribe' => 'Are you sure that you want to unsubscribe?',
    'confirm delete project form' => 'Are you sure that you want to delete this form?',
    'confirm delete folder' => 'Are you sure that you want to delete this folder?',
    'confirm delete file' => 'Are you sure that you want to delete this file?',
    'confirm delete revision' => 'Are you sure that you want to delete this revision?',
    'confirm reset form' => 'Are you sure that you want to reset this form?',
    'confirm delete contacts' => 'Are you sure that you want to delete these contacts?',
    
    // Errors...
    'system error message' => 'We are sorry, but a fatal error prevented OpenGoo from executing your request. An Error Report has been sent to the administrator.',
    'execute action error message' => 'We are sorry, but OpenGoo is not currently able to execute your request. An Error Report has been sent to the administrator.',
    
    // Log
    'log add projectmessages' => '\'{0}\' added',
    'log edit projectmessages' => '\'{0}\' updated',
    'log delete projectmessages' => '\'{0}\' deleted',
    
    'log add comments' => '{0} added',
    'log edit comments' => '{0} updated',
    'log delete comments' => '{0} deleted',
    
    'log add projectmilestones' => '\'{0}\' added',
    'log edit projectmilestones' => '\'{0}\' updated',
    'log delete projectmilestones' => '\'{0}\' deleted',
    'log close projectmilestones' => '\'{0}\' finished',
    'log open projectmilestones' => '\'{0}\' reopened',
    
    'log add projecttasklists' => '\'{0}\' added',
    'log edit projecttasklists' => '\'{0}\' updated',
    'log delete projecttasklists' => '\'{0}\' deleted',
    'log close projecttasklists' => '\'{0}\' closed',
    'log open projecttasklists' => '\'{0}\' opened',
    
    'log add projecttasks' => '\'{0}\' added',
    'log edit projecttasks' => '\'{0}\' updated',
    'log delete projecttasks' => '\'{0}\' deleted',
    'log close projecttasks' => '\'{0}\' closed',
    'log open projecttasks' => '\'{0}\' opened',
    
    'log add projectforms' => '\'{0}\' added',
    'log edit projectforms' => '\'{0}\' updated',
    'log delete projectforms' => '\'{0}\' deleted',
    
    'log add projectfolders' => '\'{0}\' added',
    'log edit projectfolders' => '\'{0}\' updated',
    'log delete projectfolders' => '\'{0}\' deleted',
    
    'log add projectfiles' => '\'{0}\' uploaded',
    'log edit projectfiles' => '\'{0}\' updated',
    'log delete projectfiles' => '\'{0}\' deleted',
    
    'log edit projectfilerevisions' => '{0} updated',
    'log delete projectfilerevisions' => '{0} deleted',
    
    'log add projectwebpages' => '\'{0}\' uploaded',
    'log edit projectwebpages' => '\'{0}\' updated',
    'log delete projectwebpages' => '\'{0}\' deleted',
    
    'log add contacts' => '\'{0}\' assigned to project',
    'log edit contacts' => '\'{0}\' changed role',
    'log delete contacts' => '\'{0}\' removed from project',
  
  	'no contacts in company' => 'The company has no contacts.',
  
  ); // array

?>