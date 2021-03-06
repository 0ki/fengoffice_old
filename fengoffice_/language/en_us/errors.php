<?php

  /**
  * Error messages
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */

  // Return langs
  return array(
  
    // General
    'invalid email address' => 'Email address format is not valid',
   
    // Company validation errors
    'company name required' => 'Company / organization name is required',
    'company homepage invalid' => 'Homepage value is not a valid URL',
    
    // User validation errors
    'username value required' => 'Username value is required',
    'username must be unique' => 'Sorry, but selected username is already taken',
    'email value is required' => 'Email address value is required',
    'email address must be unique' => 'Sorry, selected email address is already taken',
    'company value required' => 'User must be part of company / organization',
    'password value required' => 'Password value is required',
    'passwords dont match' => 'Passwords don\'t match',
    'old password required' => 'Old password value is required',
    'invalid old password' => 'Old password is not valid',
    'users must belong to a company' => 'Contacts must belong to a company in order to generate a user',
    'contact linked to user' => 'Contact is linked to user {0}',
    
    // Avatar
    'invalid upload type' => 'Invalid file type. Allowed types are {0}',
    'invalid upload dimensions' => 'Invalid image dimensions. Max size is {0}x{1} pixels',
    'invalid upload size' => 'Invalid image size. Max size is {0}',
    'invalid upload failed to move' => 'Failed to move uplaoded file',
    
    // Registration form
    'terms of services not accepted' => 'In order to create an account you need to read and accept our terms of services',
    
    // Init company website
    'failed to load company website' => 'Failed to load website. Owner company not found',
    'failed to load project' => 'Failed to load active workspace',
    
    // Login form
    'username value missing' => 'Please insert your username',
    'password value missing' => 'Please insert your password',
    'invalid login data' => 'Failed to log you in. Please check your login data and try again',
    
    // Add project form
    'project name required' => 'Workspace name value is required',
    'project name unique' => 'Workspace name must be unique',
    
    // Add message form
    'message title required' => 'Title value is required',
    'message title unique' => 'Title value must be unique in this workspace',
    'message text required' => 'Text value is required',
    
    // Add comment form
    'comment text required' => 'Text of the comment is required',
    
    // Add milestone form
    'milestone name required' => 'Milestone name value is required',
    'milestone due date required' => 'Milestone due date value is required',
    
    // Add task list
    'task list name required' => 'Task name value is required',
    'task list name unique' => 'Task name must be unique in workspace',
    'task title required' => 'Task title is required',
  
    // Add task
    'task text required' => 'Task text is required',
    
    // Add event
    'event subject required' => 'Event subject is required',
    'event description maxlength' => 'Description must be under 3000 characters',
    'event subject maxlength' => 'Subject must be under 100 characters',
    
    // Add project form
    'form name required' => 'Form name is required',
    'form name unique' => 'Form name must be unique',
    'form success message required' => 'Success message is required',
    'form action required' => 'Form action is required',
    'project form select message' => 'Please select message',
    'project form select task lists' => 'Please select task',
    
    // Submit project form
    'form content required' => 'Please insert content into text field',
    
    // Validate project folder
    'folder name required' => 'Folder name is required',
    'folder name unique' => 'Folder name need to be unique in this workspace',
    
    // Validate add / edit file form
    'folder id required' => 'Please select folder',
    'filename required' => 'Filename is required',
    
    // File revisions (internal)
    'file revision file_id required' => 'Revision needs to be connected with a file',
    'file revision filename required' => 'Filename required',
    'file revision type_string required' => 'Unknown file type',
    
    // Test mail settings
    'test mail recipient required' => 'Recipient address is required',
    'test mail recipient invalid format' => 'Invalid recipient address format',
    'test mail message required' => 'Mail message is required',
    
    // Mass mailer
    'massmailer subject required' => 'Message subject is required',
    'massmailer message required' => 'Message body is required',
    'massmailer select recepients' => 'Please select users that will receive this email',
    
  	//Email module
  	'mail account name required' => 'Account name required',
  	'mail account id required' => 'Account Id required',
  	'mail account server required' => 'Server required',
  	'mail account password required' => 'Password required',	
  
  	'session expired error' => 'Session expired due to user inactivity. Please login again',
  	'unimplemented type' => 'Unimplemented type',
  	'unimplemented action' => 'Unimplemented action',
  
  	'workspace own parent error' => 'A workspace can\'t be its own parent',
  	'task own parent error' => 'A task can\'t be its own parent',
  	'task child of child error' => 'A task can\'t be child of one of its descendants',
  
  	'chart title required' => 'Chart title is required.',
  	'chart title unique' => 'Chart title must be unique.',
    'must choose at least one workspace error' => 'You must choose at least one workspace where to put the object.',
    
    
    'user has contact' => 'There is a contact already assigned to this user',
  ); // array

?>