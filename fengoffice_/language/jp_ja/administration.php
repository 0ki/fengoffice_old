<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'テストメールの設定',	 // 'Test mail settings'
    'administration tool desc test_mail_settings' => 'この簡単なツールを使用して、テストメールを送って、OpenGooメーラが動作するかどうかチェックしてください。', // 'Use this simple tool to send test emails to check if OpenGoo mailer is well configured'
    'administration tool name mass_mailer' => 'マスメーラ', // 'Mass mailer'
    'administration tool desc mass_mailer' => 'この簡単なツールはシステムに登録されているユーザのどのグループにもテキストメッセージを送信できます。', // 'Simple tool that let you send plain text messages to any group of users registered to the system'

    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => '環境設定', // 'Configuration'
    
    'mail transport mail()' => 'デフォルトのPHP設定', // 'Default PHP settings'
    'mail transport smtp' => 'SMTP サーバ', // 'SMTP server'
    
    'secure smtp connection no'  => 'いいえ', // 'No'
    'secure smtp connection ssl' => 'はい、SSLを使用する', // 'Yes, use SSL'
    'secure smtp connection tls' => 'はい、TLSを使用する', // 'Yes, use TLS'

    'file storage file system' => 'ファイルシステム', // 'File system'
    'file storage mysql' => 'データベース (MySQL)', // 'Database (MySQL)'
    
    // Categories
    'config category name general' => '一般', // 'General'
    'config category desc general' => 'OpenGooの一般設定', // 'General OpenGoo settings'
    'config category name mailing' => 'メール', // 'Mailing'
    'config category desc mailing' => 'この設定でOpenGooが使用するメールの送信方法を指定してください。 php.iniの設定かこの設定のいずれのオプションを選択できますので他のSMTPサーバも使用できます。', // 'Use this set of settings to set up how OpenGoo should handle email sending. You can use configuration options provided in your php.ini or set it so it uses any other SMTP server'

    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'サイト名', // 'Site name'
    'config option desc site_name' => 'サイト名はダッシュボードに表示されます。', // 'This value will be displayed as the site name on the Dashboard page'
    'config option name file_storage_adapter' => 'ファイルストレージ', // 'File storage'
    'config option desc file_storage_adapter' => '添付ファイル、アバダー、ロゴなどのアップロードしたファイルをどこに保存するか選択してください。 <strong>データベースのストレージがお薦めです</strong>.', // 'Select where you want to store uploaded documents. <strong>Switching storage will make all previuosly uploaded files unavailable </strong>.'
    'config option name default_project_folders' => 'デフォルトフォルダ', // 'Default folders'
    'config option desc default_project_folders' => 'ワークスペースが作成された時に自動的に作成されるフォルダ。 全てのフォルダは新規の行に作成されます。. 複製か空の名前は無視されます。', // 'Folders that will be created when workspace is created. Every folder name should be in a new line. Duplicate or empty lines will be ignored'
    'config option name theme' => 'テーマ', // 'Theme'
    'config option desc theme' => 'テーマを使用することでOpenGooのデザインを変更することができます。', // 'Using themes you can change the default look and feel of OpenGoo'
    
    'config option name upgrade_check_enabled' => 'アップグレードの確認を有効にする', // 'Enable upgrade check'
    'config option desc upgrade_check_enabled' => '有効にした場合には、1日に一度OpenGooの最新バージョンがあるか自動的に確認します。', // 'If Yes system will once a day check if there are new versions of OpenGoo available for download'

    // Mailing
    'config option name exchange_compatible' => 'Microsoft Exchange互換モード', // 'Microsoft Exchange compatibility mode'
    'config option desc exchange_compatible' => 'あなたがMicrosoft Exchange Serverを使用している場合には、既知の送信の問題を避けるためにこのオプションを選択してください。', // 'If you are using Microsoft Exchange Server set this option to yes to avoid some known mailing problems.'
    'config option name mail_transport' => 'メール転送', // 'Mail transport'
    'config option desc mail_transport' => 'PHPで設定したデフォルトのSMTPサーバを使用してメールを送信することができます。', // 'You can use default PHP settings for sending emails or specify SMTP server'
    'config option name smtp_server' => 'SMTP サーバ', // 'SMTP server'
    'config option name smtp_port' => 'SMTP ポート', // 'SMTP port'
    'config option name smtp_authenticate' => 'SMTP認証を使用する', // 'Use SMTP authentication'
    'config option name smtp_username' => 'SMTP ユーザ名', // 'SMTP username'
    'config option name smtp_password' => 'SMTP パスワード', // 'SMTP password'
    'config option name smtp_secure_connection' => 'セキュアなSMTP通信を使用する', // 'Use secure SMTP connection'
  
 	'can edit company data' => '会社情報を編集できる', // 'Can edit company data'
  	'can manage security' => 'セキュリティを管理できる', // 'Can manage security'
  	'can manage workspaces' => 'ワークスペースを管理できる', // 'Can manage workspaces'
  	'can manage configuration' => '環境設定を管理できる', // 'Can manage configuration'
  	'can manage contacts' => 'コンタクトを管理できる', // 'Can manage contacts'
  	'group users' => 'グループユーザ', // 'Group users'

  	
  	'user ws config category name dashboard' => 'ダッシュボードオプション', // 'Dashboard options'
  	'user ws config category name task panel' => 'タスクオプション', // 'Task options'
  	'user ws config option name show pending tasks widget' => '未完了のタスクウェジットの表示', // 'Show pending tasks widget'
  	'user ws config option name pending tasks widget assigned to filter' => '割り当てられたタスクウェジットの表示', // 'Show tasks assigned to'
  	'user ws config option name show late tasks and milestones widget' => '遅れているマイルストーンとタスクウェジットの表示', // 'Show late tasks and milestones widget'
  	'user ws config option name show messages widget' => 'メッセージウェジットの表示', // 'Show messages widget'
  	'user ws config option name show comments widget' => 'コメントウェジットの表示', // 'Show comments widget'
  	'user ws config option name show documents widget' => 'ドキュメントウェジットの表示', // 'Show documents widget'
  	'user ws config option name show calendar widget' => 'ミニカレンダーウェジットの表示', // 'Show mini calendar widget'
  	'user ws config option name show charts widget' => 'チャートウェジットの表示', // 'Show charts widget'
  	'user ws config option name show emails widget' => 'メールウェジットの表示', // 'Show emails widget'

  	'user ws config option name my tasks is default view' => '私のタスクをデフォルトビューにする', // 'Tasks assigned to me is the default view'
  	'user ws config option desc my tasks is default view' => '選択しなければ、タスクパネルのデフォルトビューには全てのタスクが表示されます。', // 'If no is selected, the default view of the task panel will show all tasks'
  	'user ws config option name show tasks in progress widget' => ' \'進行中のタスク\' ウェジットの表示', // 'Show \'Tasks in progress\' widget'
  	'user ws config option name can notify from quick add' => '通知用のチェックボックスを追加',	// 'Notification checkbox in quick add'
  	'user ws config option desc can notify from quick add' => 'このチェックボックスを選択すると、ユーザにアサインされたタスクが追加されたときに通知されます。', // 'A checkbox is enabled so assigned users can be notified after quick addition on a task'

  	'backup process desc' => 'バックアップは圧縮してフォルダに保存することでアプリケーション領域を節約します。 簡単にインストールしたOpenGooのバックアップをとるために使用できます。  <br> データベースとファイルシステム2、3秒でバックアップすることができます。 バックアップをとるためには次の3ステップ: <br>1.- バックアップの開始 <br>2.- バックアップのダウンロード. <br> 3.- バックアップを手動で削除することもできます。 <br> ', // 'A backup saves the current state of the whole application into a compressed folder. It can de used to easily backup an OpenGoo installation. <br> Generating a backup of the database and filesystem can last more than a couple of seconds, so making a backup is a process consisting on three steps: <br>1.- Launch a backup process, <br>2.- Download the backup. <br> 3.- Optionally, a backup can be manually deleted so that it is not available in the future. <br> '
  	'start backup' => 'バックアップの開始', // 'Launch backup process'
    'start backup desc' => 'バックアップを開始すると、以前のバックアップを削除して新しく作成します。', // 'Launching a backup process implies deleting previous backups, and generating a new one.'
  	'download backup' => 'バックアップのダウンロード', // 'Download backup'
    'download backup desc' => 'バックアップを作成すると、ダウンロードすることができます。', // 'To be able to download a backup you must first generate a backup.'
  	'delete backup' => 'バックアップの削除', // 'Delete backup'
    'delete backup desc' => 'ダウンロードのための最終のバックアップは削除されています。 ダウンロードの後にバックアップを削除するのは非常にお勧めです。', // 'Deletes the last backup so that it is not available for download. Deleting backups after download is highly recommended.'
    'backup' => 'バックアップ', // 'Backup'
    'backup menu' => 'バックアップメニュー', // 'Backup Menu'
   	'last backup' => '最終のバックアップ日付', // 'Last backup was created on'
   	'no backups' => 'ダウンロードするバックアップはありません。', // 'There are no backups to download'
   	
   	'user ws config option name always show unread mail in dashboard' => 'ダッシュボードにいつも未読メールを表示します。', // 'Always show unread email in dashboard'
   	'user ws config option desc always show unread mail in dashboard' => 'いいえが選択された場合には、アクティブなワークスペースからのメールは表示されます。', // 'When NO is chosen emails from the active workspace will be shown'
   	'workspace emails' => 'ワークスペースのメール', // 'Workspace Mails'
  	'user ws config option name tasksShowWorkspaces' => 'ワークスペースの表示', // 'Show workspaces'
  	'user ws config option name tasksShowTime' => '時間の表示', // 'Show time'
  	'user ws config option name tasksShowDates' => '日付の表示', // 'Show dates'
  	'user ws config option name tasksShowTags' => 'タグの表示', // 'Show tags'
  	'user ws config option name tasksGroupBy' => 'Group by', // 'Group by'
  	'user ws config option name tasksOrderBy' => 'Order by', // 'Order by'
  	'user ws config option name task panel status' => 'ステータス', // 'Status'
  	'user ws config option name task panel filter' => 'Filter by', // 'Filter by'
  	'user ws config option name task panel filter value' => 'フィルターの値', // 'Filter value'
    
  	// ENGLISH MISSING TRANSLATIONS
  	'config option name days_on_trash' => '日ゴミ箱に保存されている', // 'Days on trash',
    'config option desc days_on_trash' => 'ゴミ箱に保存されているオブジェクトを自動的に削除するまでに何日間保管しますか?もしも0日を指定した場合には、自動的にゴミ箱からは削除されません。警告:メール機能はベータ版です。エラーが発生する可能性がありますので、プロダクションでは使用しないでください。', // 'How many days a content object is kept in the trash before being automatically deleted. If 0, objects won\'t be deleted from trash. Warning: The Email module is in Beta state, and thus may contain errors that make it no suitable for production use.',
    'config option name enable_email_module' => 'メール機能を有効にする', // 'Enable Email Module',
    'config option desc enable_email_module' => 'メールタブがOpenGooで利用できるようにするかを決定します。', // 'Determines whether the Email Tab will be available in OpenGoo.',
    'config option name time_format_use_24' => '時刻表示に24時間表記を使用します。', // 'Use 24 hours format for time descriptions',
    'config option desc time_format_use_24' => 'もし時間表記を有効にした場合には、\'hh:mm\'として 00:00 から 23:59のように表示されます。無効の場合には時間は 1 から 12 のようになり、AM か PMも使用します。', // 'If enabled time descriptions will be shown as \'hh:mm\' from 00:00 to 23:59, if not hours will go from 1 to 12 using AM or PM.',
    'config option name work_day_start_time' => '勤務日の開始時間', // 'Work day start time',
    'config option desc work_day_start_time' => '勤務日の開始時間を指定します。', // 'Specifies the time when work day starts',
    'templates' => 'テンプレート', // 'Templates',
    'add template' => 'テンプレートの追加', // 'Add template',
    'confirm delete template' => '本当にこのテンプレートを削除しますか?', // 'Are you sure you want to delete this template?',
    'no templates' => '登録されているテンプレートはありません。', // 'There are no templates',
    'template name required' => 'テンプレート名は必須です。', // 'The template\'s name is required',
    'can manage templates' => 'テンプレートに対処できる', // 'Can manage templates',
    'new template' => '新しいテンプレート', // 'New template',
    'edit template' => 'テンプレートの編集', // 'Edit template',
    'template dnx' => '指定されたテンプレートは存在しません。', // 'The template does not exist',
    'success edit template' => 'テンプレートの更新が成功しました。', // 'Template modified successfully',
    'log add cotemplates' => '{0} 個の追加', // '{0} added',
    'log edit cotemplates' => '{0} 個の変更', // '{0} modified',
    'success delete template' => 'テンプレートの削除が成功しました。', // 'Template deleted successfully',
    'error delete template' => 'テンプレートの削除中のエラー', // 'Error deleting the template',
    'objects' => 'オブジェクト', // 'Objects',
    'objects in template' => 'テンプレート中のオブジェクト', // 'Objects in template',
    'no objects in template' => 'このテンプレートにオブジェクトはありません。', // 'There are no objects in this template',
    'add to a template' => 'テンプレートに追加', // 'Add to a template',
    'add an object to template' => 'このテンプレートにオブジェクトを追加', // 'Add an object to this template',
    'you are adding object to template' => 'テンプレートに {0} \'{1}\' を追加します。 この{0}のためにテンプレートを選択するか、新しいものを作成してください。.', // 'You are adding {0} \'{1}\' to a template. Choose a template below or create a new one for this {0}.',
    'success add object to template' => 'テンプレートにオブジェクトの追加が成功しました', // 'Object added to template successfully',
    'object type not supported' => 'このオブジェクトのタイプはテンプレートをサポートしていません。', // 'This object type is not supported for templates',
    'assign template to workspace' => 'ワークスペースにテンプレートをアサインする', // 'Assign template to workspace',
  	); // array

?>