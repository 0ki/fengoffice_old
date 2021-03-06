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
    'invalid email address' => 'メールアドレスの形式が不正です。', // 'Email address format is not valid'
   
    // Company validation errors
    'company name required' => '会社名と組織名は必須です。', // 'Company / organization name is required'
    'company homepage invalid' => 'ホームページのurlが不正です。', // 'Homepage value is not a valid URL'
    
    // User validation errors
    'username value required' => 'ユーザ名は必須です。', // 'Username value is required'
    'username must be unique' => '選択したユーザ名はすでに使用されています。', // 'Sorry, but selected username is already taken'
    'email value is required' => 'メールアドレスは必須です。', // 'Email address value is required'
    'email address must be unique' => '選択したメールアドレスはすでに使用されています。', // 'Sorry, selected email address is already taken'
    'company value required' => 'ユーザは会社か組織に所属する必要があります。', // 'User must be part of company / organization'
    'password value required' => 'パスワードは必須です。', // 'Password value is required'
    'passwords dont match' => 'パスワードがマッチしません', // 'Passwords don\'t match'
    'old password required' => '古いパスワードは必須です。', // 'Old password value is required'
    'invalid old password' => '古いパスワードが不正です。', // 'Old password is not valid'
    'users must belong to a company' => 'コンタクトは作成したユーザに所属しなければなりません。', // 'Contacts must belong to a company in order to generate a user'
    'contact linked to user' => '{0} ユーザにコンタクトがリンクされました。', // 'Contact is linked to user {0}'
    
    // Avatar
    'invalid upload type' => 'ファイルタイプが不正です。使用できるファイルタイプは {0} です。', // 'Invalid file type. Allowed types are {0}'
    'invalid upload dimensions' => '画像のピクセルが大きすぎます。最大のサイズは {0}x{1} ピクセルです。', // 'Invalid image dimensions. Max size is {0}x{1} pixels'
    'invalid upload size' => '画像のファイルサイズが大きすぎます。最大のサイズは {0} です。', // 'Invalid image size. Max size is {0}'
    'invalid upload failed to move' => 'アップロードされたファイルの移動でエラーが発生しました。', // 'Failed to move uplaoded file'
    
    // Registration form
    'terms of services not accepted' => 'アカウントを作成するためには、利用規約を読んで、許諾する必要があります。', // 'In order to create an account you need to read and accept our terms of services'
    
    // Init company website
    'failed to load company website' => 'ウェブサイトが読み込めませんでした。オーナー会社が見つかりません。', // 'Failed to load website. Owner company not found'
    'failed to load project' => 'アクティブなワークスペースが読み込めませんでした。', // 'Failed to load active workspace'
    
    // Login form
    'username value missing' => 'ユーザ名を入力してください。', // 'Please insert your username'
    'password value missing' => 'パスワードを入力してください。', // 'Please insert your password'
    'invalid login data' => 'ログインしませんでした。 ログイン内容を確認して、再試行してください。', // 'Failed to log you in. Please check your login data and try again'
    
    // Add project form
    'project name required' => 'ワークスペース名は必須です。', // 'Workspace name value is required'
    'project name unique' => 'ワークスペース名はユニークである必要があります。', // 'Workspace name must be unique'
    
    // Add message form
    'message title required' => 'タイトルは必須です。', // 'Title value is required'
    'message title unique' => 'タイトルはこのワークスペース内ではユニークである必要があります。', // 'Title value must be unique in this workspace'
    'message text required' => 'テキストは必須です。', // 'Text value is required'
    
    // Add comment form
    'comment text required' => 'コメントのテキストは必須です。', // 'Text of the comment is required'
    
    // Add milestone form
    'milestone name required' => 'マイルストーン名は必須です。', // 'Milestone name value is required'
    'milestone due date required' => 'マイルストーンの期日は必須です。', // 'Milestone due date value is required'
    
    // Add task list
    'task list name required' => 'タスク名は必須です。', // 'Task name value is required'
    'task list name unique' => 'タスク名はこのワークスペース内ではユニークである必要があります。', // 'Task name must be unique in workspace'
    'task title required' => 'タスクのタイトルは必須です。', // 'Task title is required'
  
    // Add task
    'task text required' => 'タスクのテキストは必須です。', // 'Task text is required'
    
    // Add event
    'event subject required' => 'イベントの件名は必須です。', // 'Event subject is required'
    'event description maxlength' => '説明は3,000文字以内で入力してください。', // 'Description must be under 3000 characters'
    'event subject maxlength' => '件名は100文字以内で入力してください。', // 'Subject must be under 100 characters'
    
    // Add project form
    'form name required' => 'フォーム名は必須です。', // 'Form name is required'
    'form name unique' => 'フォーム名はユニークである必要があります。', // 'Form name must be unique'
    'form success message required' => 'サクセスノートは必須です。', // 'Success note is required'
    'form action required' => 'フォームアクションは必須です。', // 'Form action is required'
    'project form select message' => 'ノートを選択してください。', // 'Please select note'
    'project form select task lists' => 'タスクを選択してください。', // 'Please select task'
    
    // Submit project form
    'form content required' => 'テキストフィールドに内容を入力してください。', // 'Please insert content into text field'
    
    // Validate project folder
    'folder name required' => 'フォルダ名は必須です。', // 'Folder name is required'
    'folder name unique' => 'フォルダ名はこのワークスペース内ではユニークである必要があります。', // 'Folder name need to be unique in this workspace'
    
    // Validate add / edit file form
    'folder id required' => 'フォルダを選択してください。', // 'Please select folder'
    'filename required' => 'ファイル名を選択してください。', // 'Filename is required'
    
    // File revisions (internal)
    'file revision file_id required' => 'リビジョンはファイルに接続される必要があります。', // 'Revision needs to be connected with a file'
    'file revision filename required' => 'ファイル名は必須です。', // 'Filename required'
    'file revision type_string required' => 'ファイルタイプが不正です。', // 'Unknown file type'
    
    // Test mail settings
    'test mail recipient required' => '受信者アドレスは必須です。', // 'Recipient address is required'
    'test mail recipient invalid format' => '受信者アドレスのフォーマットが不正です。', // 'Invalid recipient address format'
    'test mail message required' => 'メールメッセージは必須です。', // 'Mail message is required'
    
    // Mass mailer
    'massmailer subject required' => '件名は必須です。', // 'Message subject is required'
    'massmailer message required' => '本文は必須です。', // 'Message body is required'
    'massmailer select recepients' => 'メールを受信するユーザを選択してください。', // 'Please select users that will receive this email'
    
  	//Email module
  	'mail account name required' => 'アカウント名は必須です。', // 'Account name required'
  	'mail account id required' => 'アカウントIDは必須です。', // 'Account Id required'
  	'mail account server required' => 'サーバ必須です。', // 'Server required'
  	'mail account password required' => 'パスワードは必須です。', // 'Password required'
  
  	'session expired error' => 'セッションがタイムアウトしました。もう一度ログインしてください。', // 'Session expired due to user inactivity. Please login again'
  	'unimplemented type' => 'サポートされていないタイプ', // 'Unimplemented type'
  	'unimplemented action' => 'サポートされていないアクション', // 'Unimplemented action'
  
  	'workspace own parent error' => 'ワークスペースはそれ自身を親にすることはできません。', // 'A workspace can\'t be its own parent'
  	'task own parent error' => 'タスクはそれ自身を親にすることはできません。', // 'A task can\'t be its own parent'
  	'task child of child error' => 'タスクはその孫の子供になることはできません。', // 'A task can\'t be child of one of its descendants'
  
  	'chart title required' => 'チャートのタイトルは必須です。', // 'Chart title is required.'
  	'chart title unique' => 'チャートのタイトルはユニークである必要があります。', // 'Chart title must be unique.'
    'must choose at least one workspace error' => 'あなたは、オブジェクトを置くために少なくとも1つのワークスペースを選ばなければなりません。', // 'You must choose at least one workspace where to put the object.'
    
    
    'user has contact' => 'コンタクトはすでにこのユーザにアサインされています。', // 'There is a contact already assigned to this user'
    
    'maximum number of users reached error' => 'ユーザの最大数に達しました。', // 'The maximum number of users has been reached'
	'maximum number of users exceeded error' => 'ユーザの最大数は超えられています。 この問題が解決されるまで、アプリケーションはそれ以上動作しません。', // 'The maximum number of users has been exceeded. The application will not work anymore until this issue is resolved.'
	'maximum disk space reached' => 'あなたのディスクはいっぱいです。 新しいものを加えようとする前に、いくつかのオブジェクトを削除するか、またはサポートに連絡して、より多くのユーザを有効にしてください。', // 'Your disk quota is full. Please delete some object before trying to add new ones, or contact support to enable more users.'
	'error db backup' => 'データベースのバックアップの作成でエラーが発生しました。MYSQLDUMP_COMMANDを確認してください。', // 'Error while creating database backup. Check MYSQLDUMP_COMMAND constant.'
	'error create backup folder' => 'バックアップフォルダーの作成でエラーが発生しました。バックアップを完了できません。', // 'Error while creating backup folder. Cannot complete backup'
	'error delete backup' => 'バックアップの削除でエラーが発生しました。', // 'Error while deleting database backup,'
	'success delete backup' => 'バックアップを削除しました', // 'Backup was deleted'
  	
  	// ENGLISH MISSING TRANSLATIONS
  	'name must be unique' => 'Sorry, but selected name is already taken',
   ); // array

?>