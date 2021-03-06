<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Test mail settings',
    'administration tool desc test_mail_settings' => 'Use this simple tool to send test emails to check if OpenGoo mailer is well configured',
    'administration tool name mass_mailer' => 'Mass mailer',
    'administration tool desc mass_mailer' => 'Simple tool that let you send plain text messages to any group of users registered to the system',
  
    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Configuration',
    
    'mail transport mail()' => 'Default PHP settings',
    'mail transport smtp' => 'SMTP server',
    
    'secure smtp connection no'  => 'No',
    'secure smtp connection ssl' => 'Yes, use SSL',
    'secure smtp connection tls' => 'Yes, use TLS',
    
    'file storage file system' => 'File system',
    'file storage mysql' => 'Database (MySQL)',
    
    // Categories
    'config category name general' => 'General',
    'config category desc general' => 'General OpenGoo settings',
    'config category name mailing' => 'Mailing',
    'config category desc mailing' => 'Use this set of settings to set up how OpenGoo should handle email sending. You can use configuration options provided in your php.ini or set it so it uses any other SMTP server',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Site name',
    'config option desc site_name' => 'This value will be displayed as the site name on the Dashboard page',
    'config option name file_storage_adapter' => 'File storage',
    'config option desc file_storage_adapter' => 'Select where you want to store uploaded documents. <strong>Switching storage will make all previuosly uploaded files unavailable </strong>.',
    'config option name default_project_folders' => 'Default folders',
    'config option desc default_project_folders' => 'Folders that will be created when workspace is created. Every folder name should be in a new line. Duplicate or empty lines will be ignored',
    'config option name theme' => 'Theme',
    'config option desc theme' => 'Using themes you can change the default look and feel of OpenGoo',
    
    'config option name upgrade_check_enabled' => 'Enable upgrade check',
    'config option desc upgrade_check_enabled' => 'If Yes system will once a day check if there are new versions of OpenGoo available for download',
    
    // Mailing
    'config option name exchange_compatible' => 'Microsoft Exchange compatibility mode',
    'config option desc exchange_compatible' => 'If you are using Microsoft Exchange Server set this option to yes to avoid some known mailing problems.',
    'config option name mail_transport' => 'Mail transport',
    'config option desc mail_transport' => 'You can use default PHP settings for sending emails or specify SMTP server',
    'config option name smtp_server' => 'SMTP server',
    'config option name smtp_port' => 'SMTP port',
    'config option name smtp_authenticate' => 'Use SMTP authentication',
    'config option name smtp_username' => 'SMTP username',
    'config option name smtp_password' => 'SMTP password',
    'config option name smtp_secure_connection' => 'Use secure SMTP connection',
  
 	'can edit company data' => 'Can edit company data',
  	'can manage security' => 'Can manage security',
  	'can manage workspaces' => 'Can manage workspaces',
  	'can manage configuration' => 'Can manage configuration',
  	'can manage contacts' => 'Can manage contacts',
  	'group users' => 'Group users',
    
  	
  	'user ws config category name dashboard' => 'Dashboard options',
  	'user ws config category name task panel' => 'Task options',
  	'user ws config option name show pending tasks widget' => 'Show pending tasks widget',
  	'user ws config option name pending tasks widget assigned to filter' => 'Show tasks assigned to',
  	'user ws config option name show late tasks and milestones widget' => 'Show late tasks and milestones widget',
  	'user ws config option name show messages widget' => 'Show notes widget',
  	'user ws config option name show comments widget' => 'Show comments widget',
  	'user ws config option name show documents widget' => 'Show documents widget',
  	'user ws config option name show calendar widget' => 'Show mini calendar widget',
  	'user ws config option name show charts widget' => 'Show charts widget',
  	'user ws config option name show emails widget' => 'Show emails widget',
  	
  	'user ws config option name my tasks is default view' => 'Tasks assigned to me is the default view',
  	'user ws config option desc my tasks is default view' => 'If no is selected, the default view of the task panel will show all tasks',
  	'user ws config option name show tasks in progress widget' => 'Show \'Tasks in progress\' widget',
  	'user ws config option name can notify from quick add' => 'Notification checkbox in quick add',
  	'user ws config option desc can notify from quick add' => 'A checkbox is enabled so assigned users can be notified after quick addition on a task',
 	
  	'backup process desc' => 'A backup saves the current state of the whole application into a compressed folder. It can de used to easily backup an OpenGoo installation. <br> Generating a backup of the database and filesystem can last more than a couple of seconds, so making a backup is a process consisting on three steps: <br>1.- Launch a backup process, <br>2.- Download the backup. <br> 3.- Optionally, a backup can be manually deleted so that it is not available in the future. <br> ',
  	'start backup' => 'Launch backup process',
    'start backup desc' => 'Launching a backup process implies deleting previous backups, and generating a new one.',
  	'download backup' => 'Download backup',
    'download backup desc' => 'To be able to download a backup you must first generate a backup.',
  	'delete backup' => 'Delete backup',
    'delete backup desc' => 'Deletes the last backup so that it is not available for download. Deleting backups after download is highly recommended.',
    'backup' => 'Backup',
    'backup menu' => 'Backup Menu',
   	'last backup' => 'Last backup was created on',
   	'no backups' => 'There are no backups to download',
   	
   	'user ws config option name always show unread mail in dashboard' => 'Always show unread email in dashboard',
   	'user ws config option desc always show unread mail in dashboard' => 'When NO is chosen emails from the active workspace will be shown',
   	'workspace emails' => 'Workspace Mails',
  	'user ws config option name tasksShowWorkspaces' => 'Show workspaces',
  	'user ws config option name tasksShowTime' => 'Show time',
  	'user ws config option name tasksShowDates' => 'Show dates',
  	'user ws config option name tasksShowTags' => 'Show tags',
  	'user ws config option name tasksShowGroupBy' => 'Group by',
  	'user ws config option name tasksShowOrderBy' => 'Order by',
  	'user ws config option name task panel status' => 'Status',
  	'user ws config option name task panel filter' => 'Filter by',
  	'user ws config option name task panel filter value' => 'Filter value',
  	); // array

?>