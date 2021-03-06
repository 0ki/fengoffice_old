<?php

  /**
  * Array of messages file (error, success message, status...)
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */

  return array(
  
    // Empty, dnx et
    'no mail accounts set' => 'メールを送信するためのアカウントがありません。最初にメールアカウントを作成してください。', // 'There are no email accounts through which to send an email, please create an email account first'
    'no mail accounts set for check' => 'メールアカウントがありません。最初にメールアカウントを作成してください。', // 'You have no email accounts, please create an email account first'
    'email dnx' => '要求されたメールはありません', // 'Requested email does not exist'
  	'email dnx deleted' => '要求されたメールはデータベースから削除されました。', // 'Requested email was deleted from database'
    'project dnx' => '要求されたワークスペースはデータベースにはありません。', // 'Requested workspace does not exist in database'
    'contact dnx' => '要求されたコンタクトはデータベースにはありません。', // 'Requested contact does not exist in database'
    'company dnx' => '要求された会社はデータベースにはありません。', // 'Requested company does not exist in database'
    'message dnx' => '要求されたノートはデータベースにはありません。', // 'Requested note does not exist'
    'no comments in message' => 'このノートにコメントはありません。', // 'There are no comments on this note'
    'no comments associated with object' => 'このオブジェクトに投稿されたコメントはありません。', // 'There are no comments posted for this object'
    'no messages in project' => 'このワークスペースにノートはありません。', // 'There are no notes in this workspace'
    'no subscribers' => 'このオブジェクトを購読しているユーザはいません。', // 'There are no users subscribed to this object'
    'no activities in project' => 'このワークスペースには活動報告はありません。', // 'There are no activities logged for this workspace'
    'comment dnx' => '要求されたコメントはありません。', // 'Requested comment does not exist'
    'milestone dnx' => '要求されたマイルストーンはありません。', // 'Requested milestone does not exist'
    'task list dnx' => '要求されたタスクはありません。', // 'Requested task does not exist'
    'task dnx' => '要求されたタスクはありません。', // 'Requested task does not exist'
    'event type dnx' => '要求されたイベントタイプはありません。', // 'Requested event type does not exist'
    'no milestones in project' => 'このワークスペースにマイルストーンはありません。', // 'There are no milestones in this workspace'
    'no active milestones in project' => 'このワークスペースに活動中のマイルストーンはありません。', // 'There are no active milestones in this workspace'
    'empty milestone' => 'マイルストーンはありません。<a class="internalLink" href="{1}">タスク</a>を追加できます。', // 'This milestone is empty. You can add a <a class="internalLink" href="{1}">task</a> to it at any time'
    'no logs for project' => 'このワークスペースに関連しているログはありません。', // 'There are no log entries related to this workspace'
    'no recent activities' => 'データベースには登録された最近の活動はありません。', // 'There are no recent activities logged in the database'
    'no open task lists in project' => 'このワークスペースにはオープンされているタスクはありません。', // 'There are no open task in this workspace'
    'no completed task lists in project' => 'このワークスペースに完了したタスクはありません。', // 'There are no completed task in this workspace'
    'no open task in task list' => 'このリストにオープンになっているタスクはありません。', // 'There are no open tasks in this list'
    'no closed task in task list' => 'このリストにオープンになっているタスクはありません。', // 'There are no open tasks in this list'
    'no open task in milestone' => 'このマイルストーンにオープンしているタスクはありません。', // 'There are no open tasks in this milestone'
    'no closed task in milestone' => 'このマイルストーンにクローズしたタスクはありません。', // 'There are no closed tasks in this milestone'
    'no projects in db' => 'データベースに定義されたワークスペースはありません。', // 'There are no defined workspaces in database'
    'no projects owned by company' => 'この会社のワークスペースはありません。', // 'There are no workspaces owned by this company'
    'no projects started' => '開始されたワークスペースはありません。', // 'There are no started workspaces'
    'no active projects in db' => '活動中のワークスペースはありません', // 'There are no active workspaces'
    'no new objects in project since last visit' => '前回のアクセスからこのワークスペースには新しいオブジェクトはありません。', // 'There are no new objects in this workspace since your last visit'
    'no clients in company' => 'あなたの会社には登録された顧客企業はありません。', // 'Your company does not have any registered clients'
    'no users in company' => 'この会社にはユーザがありません。', // 'There are no users in this company'
    'client dnx' => '選択した顧客企業はありません。', // 'Selected client company does not exist'
    'company dnx' => '選択した会社はありません。', // 'Selected company does not exist'
    'user dnx' => '選択した会社はデータベースにはありません。', // 'Selected company does not exist'
    'avatar dnx' => 'アバターはありません', // 'Avatar does not exist'
    'no current avatar' => 'アバターはアップロードされていません', // 'Avatar is not uploaded'
    'picture dnx' => 'ピクチャはありません', // 'Picture does not exist'
    'no current picture' => 'ピクチャはアップロードされていません', // 'Picture is not uploaded'
    'no current logo' => 'ロゴはアップロードされていません', // 'A logo is not uploaded'
    'user not on project' => '選択したユーザは選択されたワークスペースには関連がありません。', // 'Selected user is not involved in selected workspace'
    'company not on project' => '選択した会社は選択されたワークスペースには関連がありません。', // 'Selected company is not involved in selected workspace'
    'user cant be removed from project' => '選択したユーザは選択されたワークスペースから取り除けません。', // 'Selected user can\'t be removed from workspace'
    'tag dnx' => '要求されたタグはありません。', // 'Requested tag does not exist'
    'no tags used on projects' => 'このワークスペースに使用されたタグはありません。', // 'There are no tags used on this workspace'
    'no forms in project' => 'このワークスペースにフォームはありません。', // 'There are no forms in this workspace'
    'project form dnx' => '要求されたワークスペースはデータベースにはありません。', // 'Requested workspace form does not exist in database'
    'related project form object dnx' => '関連されたフォームオブジェクトはデータベースにはありません。', // 'Related form object does not exist in database'
    'no my tasks' => 'あなたにアサインされたタスクはありません。', // 'There are no tasks assigned to you'
    'no search result for' => '"<strong>{0}</strong>" にマッチするオブジェクトはありません。', // 'There are no objects that match "<strong>{0}</strong>"'
    'no files on the page' => 'このページにファイルはありません。', // 'There are no files on this page'
    'folder dnx' => '要求されたフォルダはデータベースにはありません。', // 'Folder you have requested does not exist in database'
    'define project folders' => 'このワークスペースにフォルダはありません。処理を続けるためにフォルダを設定してください。', // 'There are no folders in this workspace. Please define folders in order to continue'
    'file dnx' => '要求されたファイルはデータベースにはありません。', // 'Requested file does not exists in the database'
    'not s5 presentation' => 'ファイルが有効なS5プレゼンテーションでないので、スライドショーを始めることができません。', // 'Cannot start slideshow because the file is not a valid S5 presentation'
    'file not selected' => '選択されたファイルはありません。', // 'There is no selected file'
    'file revision dnx' => '要求されたリビジョンはデータベースにはありません。', // 'Requested revision does not exists in the database'
    'no file revisions in file' => '不正なファイル - このファイルに関連しているリビジョンはありません。', // 'Invalid file - there are no revisions associated with this file'
    'cant delete only revision' => 'リビジョンを削除できません。 全てのファイルには最新の投稿されたリビジョンのファイルは必要です。', // 'You can\'t delete this reivion. Every file need to have at least one revision posted'
    'config category dnx' => '要求された設定カテゴリはありません。', // 'Configuration category you requested does not exists'
    'config category is empty' => '選択された設定カテゴリは空です。', // 'Selected configuration category is empty'
    'email address not in use' => '{0} は未使用です。', // '{0} is not in use'
    'no linked objects' => 'このオブジェクトはリンクされていません。', // 'There are no objects linked to this object'
    'object not linked to object' => '選択されたオブジェクトにはリンクはありません。', // 'No link exists between the selected object'
    'no objects to link' => 'リンクするオブジェクトを選択してください。', // 'Please select objects that need to be linked'
    'no administration tools' => '登録された管理者ツールはデータベースにはありません。', // 'There are no registered administration tools in the database'
    'administration tool dnx' => '管理ツール "{0}" はありません。', // 'Administration tool "{0}" does not exists'
    
    // Success
    'success add contact' => 'コンタクト \'{0}\' は正常に作成されました。', // 'Contact \'{0}\' has been created successfully'
    'success edit contact' => 'コンタクト \'{0}\' は正常に更新されました。', // 'Contact \'{0}\' has been updated successfully'
    'success delete contact' => 'コンタクト \'{0}\' は正常に削除されました。', // 'Contact \'{0}\' has been deleted successfully'
    'success edit picture' => 'ピクチャは正しく更新されました。', // 'Picture has been updated successfully'
    'success delete picture' => 'ピクチャは正しく削除されました。', // 'Picture has been deleted successfully'
    
    'success add project' => 'ワークスペース {0} は正常に追加されました。', // 'Workspace {0} has been added successfully'
    'success edit project' => 'ワークスペース {0} は正常に更新されました。', // 'Workspace {0} has been updated'
    'success delete project' => 'ワークスペース {0} は正常に削除されました。', // 'Workspace {0} has been updated'
    'success complete project' => 'ワークスペース {0} は完了しました。', // 'Workspace {0} has been completed'
    'success open project' => 'ワークスペース {0} は再オープンされました。', // 'Workspace {0} has been reopened'
    
    'success add milestone' => 'マイルストーン \'{0}\' は正常に作成されました。', // 'Milestone \'{0}\' has been created successfully'
    'success edit milestone' => 'マイルストーン \'{0}\' は正常に更新されました。', // 'Milestone \'{0}\' has been updated successfully'
    'success deleted milestone' => 'マイルストーン \'{0}\' は正常に削除されました。', // 'Milestone \'{0}\' has been deleted successfully'
    
    'success add message' => 'ノート {0} は正常に追加されました。', // 'Note {0} has been added successfully'
    'success edit message' => 'ノート {0} は正常に更新されました。', // 'Note {0} has been updated successfully'
    'success deleted message' => 'ノート \'{0}\' とその全てのコメントは正常に削除されました。', // 'Note \'{0}\' and all of its comments has been deleted successfully'
    
    'success add comment' => 'コメントは正常に投稿されました。', // 'Comment has been posted successfully'
    'success edit comment' => 'コメントは正常に更新されました。', // 'Comment has been updated successfully'
    'success delete comment' => 'コメントは正常に削除されました。', // 'Comment has been deleted successfully'
    
    'success add task list' => 'タスク \'{0}\' は追加されました。', // 'Task \'{0}\' has been added'
    'success edit task list' => 'タスク \'{0}\' は更新されました。', // 'Task \'{0}\' has been updated'
    'success delete task list' => 'タスク \'{0}\' は削除されました。', // 'Task \'{0}\' has been deleted'
    
    'success add task' => '選択したタスクは追加されました。', // 'Selected task has been added'
    'success edit task' => '選択したタスクは更新されました。', // 'Selected task has been updated'
    'success delete task' => '選択したタスクは削除されました。', // 'Selected task has been deleted'
    'success complete task' => '選択したタスクは完了しました。', // 'Selected task has been completed'
    'success open task' => '選択したタスクを再オープンにしました。', // 'Selected task has been reopened'
    'success n tasks updated' => '{0} タスクを更新しました。', // '{0} tasks updated'
	'success add mail' => 'メールは正常に送信されました。', // 'Email sent successfully'
    
    'success add client' => '顧客企業 {0} は追加されました。', // 'Client company {0} has been added'
    'success edit client' => '顧客企業 {0} は更新されました。', // 'Client company {0} has been updated'
    'success delete client' => '顧客企業 {0} は削除されました。', // 'Client company {0} has been deleted'
    
    'success add group' => 'グループ {0} は追加されました。', // 'Group {0} has been added'
    'success edit group' => 'グループ {0} は更新されました。', // 'Group {0} has been updated'
    'success delete group' => 'グループ {0} は削除されました。', // 'Group {0} has been deleted'
    
    'success edit company' => '会社情報を更新しました。', // 'Company data has been updated'
    'success edit company logo' => '会社のロゴを更新しました。', // 'Company logo has been updated'
    'success delete company logo' => '会社のロゴを削除しました。', // 'Company logo has been deleted'
    
    'success add user' => 'ユーザ {0} は正常に追加されました。', // 'User {0} has been added successfully'
    'success edit user' => 'ユーザ {0} は正常に更新されました。', // 'User {0} has been updated successfully'
    'success delete user' => 'ユーザ {0} は正常に削除されました。', // 'User {0} has been deleted successfully'
    
    'success update project permissions' => 'ワークスペースのパーミションは正常に更新されました。', // 'Workspace permissions have been updated successfully'
    'success remove user from project' => 'ユーザは正常にワークスペースから除かれました。', // 'User has been successfully removed from the workspace'
    'success remove company from project' => '会社は正常にワークスペースから除かれました。', // 'Company has been successfully removed from the workspace'
    
    'success update profile' => 'プロフィールを更新しました。', // 'Profile has been updated'
    'success edit avatar' => 'アバターは正常に更新されました。', // 'Avatar has been updated successfully'
    'success delete avatar' => 'アバターは正常に削除されました。', // 'Avatar has been deleted successfully'
    
    'success hide welcome info' => 'ようこそメッセージを正常に非表示にしました。', // 'Welcome info box has been successfully hidden'
    
    'success complete milestone' => 'マイルストーン \'{0}\' を完了にしました。', // 'Milestone \'{0}\' has been completed'
    'success open milestone' => 'マイルストーン \'{0}\' を再オープンにしました。', // 'Milestone \'{0}\' has been reopened'
    
    'success subscribe to object' => 'このオブジェクトを正常に購読しました。', // 'You have been successfully subscribed to this object'
    'success unsubscribe to object' => 'このオブジェクトを正常に非購読しました。', // 'You have been successfully unsubscribed from this object'
    
    'success add project form' => 'フォーム \'{0}\' を追加しました。', // 'Form \'{0}\' has been added'
    'success edit project form' => 'フォーム \'{0}\' を更新しました。', // 'Form \'{0}\' has been updated'
    'success delete project form' => 'フォーム \'{0}\' を削除しました。', // 'Form \'{0}\' has been deleted'
    
    'success add folder' => 'フォルダ \'{0}\' を追加しました。', // 'Folder \'{0}\' has been added'
    'success edit folder' => 'フォルダ \'{0}\' を更新しました。', // 'Folder \'{0}\' has been updated'
    'success delete folder' => 'フォルダ \'{0}\' を削除しました。', // 'Folder \'{0}\' has been deleted'
    
    'success add file' => 'フォルダ \'{0}\' を追加しました。', // 'File \'{0}\' has been added'
	'success save file' => 'フォルダ \'{0}\' を保存しました。', // 'File \'{0}\' has been saved'
    'success edit file' => 'フォルダ \'{0}\' を更新しました。', // 'File \'{0}\' has been updated'
    'success delete file' => 'フォルダ \'{0}\' を削除しました。', // 'File \'{0}\' has been deleted'
    'success delete files' => '{0} 個のファイルを削除しました。', // '{0} file(s) have been deleted'
    'success tag files' => '{0} 個のファイルにタグを設定しました。', // '{0} file(s) have been tagged'
    'success tag contacts' => '{0} 個のコンタクトにタグを設定しました。', // '{0} contact(s) have been tagged'
    
    'success add handis' => 'Handinsを更新しました。', // 'Handins have been updated'
    
    'success add properties' => 'プロパティを更新しました。', // 'Properties have been updated'
    
    'success edit file revision' => 'リビジョンを更新しました。', // 'Revision has been updated'
    'success delete file revision' => 'ファイルのリビジョンを更新しました。', // 'File revision has been deleted'
    
    'success link objects' => '{0} 個のオブジェクトを正常にリンクしました。', // '{0} object(s) has been successfully linked'
    'success unlink object' => 'オブジェクトのリンクを正常に解除しました。', // 'Object has been successfully unlinked'
    
    'success update config category' => '{0} 個の設定値を更新しました。', // '{0} configuration values have been updated'
    'success forgot password' => 'パスワードをメールで送信しました。', // 'Your password has been emailed to you'
    
    'success test mail settings' => 'テストメールは正常に送信されました。', // 'Test mail has been successfully sent'
    'success massmail' => 'メールを送信しました。', // 'Email has been sent'
    
    'success update company permissions' => '会社のパーミションは正常に更新されました。 {0} 件の更新', // 'Company permissions updated successfully. {0} records updated'
    'success user permissions updated' => 'ユーザのパーミションは正常に更新されました。', // 'User permissions have been updated'
  
    'success add event' => 'イベントを追加しました。', // 'Event has been added'
    'success edit event' => 'イベントを更新しました。', // 'Event has been updated'
    'success delete event' => 'イベントを削除しました。', // 'Event has been deleted'
    
    'success add event type' => 'イベントタイプを追加しました。', // 'Event Type has been added'
    'success delete event type' => 'イベントタイプを削除しました。', // 'Event Type has been deleted'
    
    'success add webpage' => 'ウェブリンクを追加しました。', // 'Web link has been added'
    'success edit webpage' => 'ウェブリンクを更新しました。', // 'Web link has been updated'
    'success deleted webpage' => 'ウェブリンクを削除しました。', // 'Web link has been deleted'
    
    'success add chart' => 'チャートを追加しました。', // 'Chart has been added'
    'success edit chart' => 'チャートを更新しました。', // 'Chart has been updated'
    'success delete chart' => 'チャートを削除しました。', // 'Chart has been deleted'
    'success delete charts' => '選択したチャートを正常に削除しました。', // 'The selected charts have been deleted successfully'
  
    'success delete contacts' => '選択したコンタクトを正常に削除しました。', // 'The selected contacts have been deleted successfully'
  
    'success classify email' => 'メールを分類しました。', // 'Email classified successfully'
    'success delete email' => 'メールを削除しました。', // 'Email has been deleted'
  
    'success delete mail account' => 'メールアカウントは正常に削除されました。', // 'Email account has been deleted successfully'
    'success add mail account' => 'メールアカウントは正常に作成されました。', // 'Email account has been created successfully'
    'success edit mail account' => 'メールアカウントは正常に更新されました。', // 'Email account has been updated successfully'
  
    'success link object' => 'オブジェクトは正常にリンクされました。', // 'Object has been linked successfully'
  
  	'success check mail' => 'メールの受信が完了しました: {0} 件のメール.', // 'Email retrieval complete: {0} emails received.'
  
	'success delete objects' => '{0} オブジェクトは正常に削除されました。', // '{0} Object(s) deleted successfully'
	'success tag objects' => '{0} オブジェクトは正常にタグがつけられました。', // '{0} Object(s) tagged successfully'
	'error delete objects' => '{0} 個のオブジェクトの削除が失敗しました。', // 'Failed to delete {0} object(s)'
	'error tag objects' => ' {0} 個のオブジェクトのタグをつけるのが失敗しました。', // 'Failed to tag {0} object(s)'
	'success move objects' => '{0} 個のオブジェクトは正常に移動しました。', // '{0} Object(s) moved successfully'
	'error move objects' => ' {0} 個のオブジェクトの移動が失敗しました。', // 'Failed to move {0} object(s)'
  
    'success checkout file' => 'ファイルのチェックアウトが成功しました。', // 'File checked out successfully'
    'success checkin file' => 'ファイルのチェックインが成功しました。', // 'File checked in successfully'
  	'success undo checkout file' => 'ファイルのチェックインのキャンセルが成功しました。', // 'File checkout canceled successfully'
    
    // Failures
    'error edit timeslot' => '時間割の保存に失敗しました。', // 'Failed to save timeslot'
  	'error delete timeslot' => '選択された時間割の削除に失敗しました。', // 'Failed to delete the selected timeslot'
  	'error add timeslot' => '時間割の追加に失敗しました。', // 'Failed to add timeslot'
  	'error open timeslot' => '時間割のオープンに失敗しました。', // 'Failed to open timeslot'
  	'error close timeslot' => '時間割のクローズに失敗しました。', // 'Failed to close timeslot'
    'error start time after end time' => '時間割の保存に失敗しました: 開始時間は終了時間より以前である必要があります。', // 'Failed to save timeslot: the start time must happen before the end time'
    'error form validation' => 'プロパティの値に不正がありオブジェクトの保存に失敗しました。', // 'Failed to save object because some of its properties are not valid'
    'error delete owner company' => 'オーナー会社は削除できません。', // 'Owner company can\'t be deleted'
    'error delete message' => '選択したノートの削除に失敗しました。', // 'Failed to delete selected note'
    'error update message options' => 'ノートのオプションの更新に失敗しました。', // 'Failed to update note options'
    'error delete comment' => '選択されたコメントの削除に失敗しました。', // 'Failed to delete selected comment'
    'error delete milestone' => '選択されたマイルストーンの削除に失敗しました。', // 'Failed to delete selected milestone'
    'error complete task' => '選択されたタスクの完了に失敗しました。', // 'Failed to complete selected task'
    'error open task' => '選択されたタスクの再オープンに失敗しました。', // 'Failed to reopen selected task'
    'error upload file' => 'ファイルのアップロードに失敗しました。', // 'Failed to upload file'
    'error delete project' => '選択されたワークスペースの削除に失敗しました。', // 'Failed to delete selected workspace'
    'error complete project' => '選択されたワークスペースの完了に失敗しました。', // 'Failed to complete selected workspace'
    'error open project' => '選択されたワークスペースの再オープンに失敗しました。', // 'Failed to reopen selected workspace'
    'error delete client' => '選択された会社の削除に失敗しました。', // 'Failed to delete selected client company'
    'error delete group' => '選択されたグループの削除に失敗しました。', // 'Failed to delete selected group'
    'error delete user' => '選択されたユーザの削除に失敗しました。', // 'Failed to delete selected user'
    'error update project permissions' => 'ワークスペースのパーミションの更新に失敗しました。', // 'Failed to update workspace permissions'
    'error remove user from project' => 'ワークスペースからユーザを除くのに失敗しました。', // 'Failed to remove user from workspace'
    'error remove company from project' => 'ワークスペースから会社を除くのに失敗しました。', // 'Failed to remove company from workspace'
    'error edit avatar' => 'アバターの編集に失敗しました。', // 'Failed to edit avatar'
    'error delete avatar' => 'アバターの削除に失敗しました。', // 'Failed to delete avatar'
    'error edit picture' => 'ピクチャの編集に失敗しました。', // 'Failed to edit picture'
    'error delete picture' => 'ピクチャの削除に失敗しました。', // 'Failed to delete picture'
    'error edit contact' => 'コンタクトの編集に失敗しました。', // 'Failed to edit contact'
    'error delete contact' => 'コンタクトの削除に失敗しました。', // 'Failed to delete contact'
    'error hide welcome info' => 'ようこそメッセージの非表示に失敗しました。', // 'Faled to hide welcome info'
    'error complete milestone' => '選択されたマイルストーンの完了に失敗しました。', // 'Failed to complete selected milestone'
    'error open milestone' => '選択されたマイルストーンの再オープンに失敗しました。', // 'Failed to reopen selected milestone'
    'error file download' => '指定されたファイルのダウンロードに失敗しました。', // 'Failed to download specified file'
    'error link object' => 'オブジェクトのリンクに失敗しました。', // 'Failed to link object'
    'error edit company logo' => '会社のロゴの更新に失敗しました。', // 'Failed to update company logo'
    'error delete company logo' => '会社のロゴの削除に失敗しました。', // 'Failed to delete company logo'
    'error subscribe to object' => '選択されたオブジェクトの購読に失敗しました。', // 'Failed to subscribe to selected object'
    'error unsubscribe to object' => '選択されたオブジェクトの非購読に失敗しました。', // 'Failed to unsubscribe from selected object'
    'error add project form' => 'ワークスペースのフォームの追加に失敗しました。', // 'Failed to add workspace form'
    'error submit project form' => 'ワークスペースのフォームの送信に失敗しました。', // 'Failed to submit workspace form'
    'error delete folder' => '選択されたフォルダの削除に失敗しました。', // 'Failed to delete selected folder'
    'error delete file' => '選択されたファイルの削除に失敗しました。', // 'Failed to delete selected file'
    'error delete files' => ' {0} 個のファイルの削除に失敗しました。', // 'Failed to delete {0} files'
    'error tag files' => ' {0} 個のファイルのタグ付けに失敗しました。', // 'Failed to tag {0} files'
    'error tag contacts' => ' {0} 個のコンタクトのタグ付けに失敗しました。', // 'Failed to tag {0} contacts'
    'error delete file revision' => 'ファイルのリビジョンの削除に失敗しました。', // 'Failed to delete file revision'
    'error delete task list' => '選択されたタスクの削除に失敗しました。', // 'Failed to delete selected task'
    'error delete task' => '選択されたタスクの削除に失敗しました。', // 'Failed to delete selected task'
    'error check for upgrade' => '新しいバージョンの確認に失敗しました。', // 'Failed to check for a new version'
    'error link object' => 'オブジェクトのリンクに失敗しました。', // 'Failed to link object(s)'
    'error unlink object' => 'オブジェクトのリンクの解除に失敗しました。', // 'Failed to unlink object(s)'
    'error link objects max controls' => 'オブジェクトのリンクを作成できませんでした。 最大は {0} 個です。', // 'You can not add more object links. Limit is {0}'
    'error test mail settings' => 'テストメールの送信に失敗しました。', // 'Failed to send test message'
    'error massmail' => 'メールの送信に失敗しました。', // 'Failed to send email'
    'error owner company has all permissions' => 'オーナー会社は全てのパーミションを持っています。', // 'Owner company has all permissions'
    'error while saving' => 'ドキュメントの保存でエラーが発生しました。', // 'An error ocurred while saving the document'
    'error delete event type' =>'イベントのタイプの削除に失敗しました。', // 'Failed to delete event type'
    'error delete mail' => 'メールの削除でエラーが発生しました。', // 'An error ocurred while deleting this email'
    'error delete mail account' => 'メールアカウントの削除でエラーが発生しました。', // 'An error ocurred while deleting this email account'
    'error delete contacts' => 'コンタクトの削除でエラーが発生しました。', // 'An error has ocurred while deleting these contacts'
  	'error check mail' => 'アカウントの確認でエラーが発生しました \'{0}\': {1}', // 'Error checking account \'{0}\': {1}'
  	'error check out file' => 'ファイルのチェックアウトでエラーが発生しました。', // 'Error while checking out file for exclusive use'
    'error checkin file' => 'ファイルのチェックインでエラーが発生しました。', // 'Error while checking in file'
    'error classifying attachment cant open file' => '添付の分類エラー: ファイルを開けません', // 'Error classifying attachment: can\'t open file'
  	'error contact added but not assigned' => 'コンタクト \'{0}\' は追加されましたが \'{1}\' ワークスペースへのパーミションによりアサインに失敗しました。', // 'The contact \'{0}\' was added but not assigned successfully to workspace \'{1}\' due to access permissions'
  	'error cannot set workspace as parent' => ' \'{0}\' を親のワークスペースに設定できませんでした。 ワークスペースのレベルが多すぎます。', // 'Cannot set workspace \'{0}\' as parent, too many workspace levels'
  
    
    // Access or data errors
    'no access permissions' => '要求されたページへのパーミションがありません。', // 'You don\'t have permissions to access requested page'
    'invalid request' => '不正な要求です', // 'Invalid request!'
    
    // Confirmation
    'confirm cancel work timeslot' => "個の時間割を本当にキャンセルしても良いですか?", // "Are you sure you want to cancel the current timeslot?"
    'confirm delete mail account' => '警告: 個のアカウントを削除すると全てのメールが削除されます。このメールアカウントを本当に削除しても良いですか', // 'Warning: All emails belonging to this account will be deleted as well, are you sure that you want to delete this mail account?'
    'confirm delete message' => 'このノートを本当に削除しても良いですか?', // 'Are you sure that you want to delete this note?'
    'confirm delete milestone' => 'このマイルストーンを本当に削除しても良いですか?', // 'Are you sure that you want to delete this milestone?'
    'confirm delete task list' => 'このタスクと全てのサブタスクを本当に削除しても良いですか?', // 'Are you sure that you want to delete this task and all of its sub tasks?'
    'confirm delete task' => 'このタスクを本当に削除しても良いですか?', // 'Are you sure that you want to delete this task?'
    'confirm delete comment' => 'このコメントを本当に削除しても良いですか?', // 'Are you sure that you want to delete this comment?'
    'confirm delete project' => 'このワークスペースト関連づけられている全てのデータ(ノート, タスク, マイルストーン, ファイル...)を本当に削除しても良いですか?', // 'Are you sure that you want to delete this workspace and all related data (notes, tasks, milestones, files...)?'
    'confirm complete project' => 'このワークスペースを本当にクローズにマークしても良いですか? 全てのワークスペースのアクションはロックされます。', // 'Are you sure that you want to mark this workspace as closed? All workspace actions will be locked'
    'confirm open project' => 'このワークスペースを本当にオープンにマークしても良いですか? 全てのワークスペースのアクションのロックは解除されます。', // 'Are you sure that you want to mark this workspace as open? This will unlock all workspace actions'
    'confirm delete client' => '顧客企業とそのユーザを本当に削除しても良いですか?\nこの操作はユーザの個人のワークスペースも削除します。', // 'Are you sure that you want to delete selected client company and all of its users?\nThis action will also delete the users\\\' personal workspaces.'
    'confirm delete contact' => '選択されたコンタクトを本当に削除しても良いですか?', // 'Are you sure that you want to delete selected contact?'
    'confirm delete user' => 'このユーザアカウントを本当に削除しても良いですか?\nこの操作はユーザの個人のワークスペースも削除します。', // 'Are you sure that you want to delete this user account?\nThis action will also delete the user\\\'s personal workspace.'
    'confirm reset people form' => 'このフォームを本当に初期化しても良いですか? あなたが変更した全ての修正がなくなります。', // 'Are you sure that you want to reset this form? All modifications you made will be lost!'
    'confirm remove user from project' => 'このユーザを本当にこのワークスペースから除きますか?', // 'Are you sure that you want to remove this user from this workspace?'
    'confirm remove company from project' => 'この会社を本当にこのワークスペースから除きますか?', // 'Are you sure that you want to remove this company from this workspace?'
    'confirm logout' => '本当にログアウトしますか?', // 'Are you sure that you want to log out?'
    'confirm delete current avatar' => 'このアバターを本当に削除しますか?', // 'Are you sure that you want to delete this avatar?'
    'confirm unlink object' => 'このオブジェクトのリンクを本当に解除しますか?', // 'Are you sure that you want to unlink this object?'
    'confirm delete company logo' => 'このロゴを本当に削除しますか?', // 'Are you sure that you want to delete this logo?'
    'confirm subscribe' => 'このオブジェクトを本当に購読しますか? 購読するとこのオブジェクトにあなた以外がコメントを投稿した時にメールが届きます.', // 'Are you sure that you want to subscribe to this object? You will receive an email everytime someone (except you) posts a comment on this object.'
    'confirm unsubscribe' => 'このオブジェクトを本当に非購読にしますか?', // 'Are you sure that you want to unsubscribe?'
    'confirm delete project form' => 'このフォームを本当に削除しますか?', // 'Are you sure that you want to delete this form?'
    'confirm delete folder' => 'このフォルダを本当に削除しますか?', // 'Are you sure that you want to delete this folder?'
    'confirm delete file' => 'このファイルを本当に削除しますか?', // 'Are you sure that you want to delete this file?'
    'confirm delete revision' => 'このリビジョンを本当に削除しますか?', // 'Are you sure that you want to delete this revision?'
    'confirm reset form' => 'このフォームを本当に初期化しますか?', // 'Are you sure that you want to reset this form?'
    'confirm delete contacts' => 'このコンタクトを本当に削除しますか?', // 'Are you sure that you want to delete these contacts?'
	'confirm delete group' => 'このグループを本当に削除しますか?', // 'Are you sure that you want to delete this group?'
    
    // Errors...
    'system error message' => '申し訳ございませんが、致命的なエラーによってOpenGooがあなたの要求を実行できませんでした。 エラーレポートを管理者に送りました。', // 'We are sorry, but a fatal error prevented OpenGoo from executing your request. An Error Report has been sent to the administrator.'
    'execute action error message' => '申し訳ございませんが、OpenGooがあなたの要求を実行できませんでした。 エラーレポートを管理者に送りました。', // 'We are sorry, but OpenGoo is not currently able to execute your request. An Error Report has been sent to the administrator.'
    
    // Log
    'log add projectmessages' => '\'{0}\' を追加しました', // '\'{0}\' added'
    'log edit projectmessages' => '\'{0}\' を更新しました', // '\'{0}\' updated'
    'log delete projectmessages' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
  
  	'log add projectevents' => '\'{0}\' を追加しました', // '\'{0}\' added'
    'log edit projectevents' => '\'{0}\' を更新しました', // '\'{0}\' updated'
    'log delete projectevents' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
    
    'log add comments' => '{0} を追加しました', // '{0} added'
    'log edit comments' => '{0} を更新しました', // '{0} updated'
    'log delete comments' => '{0} を削除しました', // '{0} deleted'
    
    'log add projectmilestones' => '\'{0}\' を追加しました', // '\'{0}\' added'
    'log edit projectmilestones' => '\'{0}\' を更新しました', // '\'{0}\' updated'
    'log delete projectmilestones' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
    'log close projectmilestones' => '\'{0}\' を終了しました', // '\'{0}\' finished'
    'log open projectmilestones' => '\'{0}\' を再開しました', // '\'{0}\' reopened'
    
    'log add projecttasklists' => '\'{0}\' を追加しました', // '\'{0}\' added'
    'log edit projecttasklists' => '\'{0}\' を更新しました', // '\'{0}\' updated'
    'log delete projecttasklists' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
    'log close projecttasklists' => '\'{0}\' をクローズしました', // '\'{0}\' closed'
    'log open projecttasklists' => '\'{0}\' をオープンしました', // '\'{0}\' opened'
    
    'log add projecttasks' => '\'{0}\' を追加しました', // '\'{0}\' added'
    'log edit projecttasks' => '\'{0}\' を更新しました', // '\'{0}\' updated'
    'log delete projecttasks' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
    'log close projecttasks' => '\'{0}\' をクローズしました', // '\'{0}\' closed'
    'log open projecttasks' => '\'{0}\' をオープンしました', // '\'{0}\' opened'
    
    'log add projectforms' => '\'{0}\' を追加しました', // '\'{0}\' added'
    'log edit projectforms' => '\'{0}\' を更新しました', // '\'{0}\' updated'
    'log delete projectforms' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
    
    'log add projectfolders' => '\'{0}\' を追加しました', // '\'{0}\' added'
    'log edit projectfolders' => '\'{0}\' を更新しました', // '\'{0}\' updated'
    'log delete projectfolders' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
    
    'log add projectfiles' => '\'{0}\' をアップロードしました', // '\'{0}\' uploaded'
    'log edit projectfiles' => '\'{0}\' を更新しました', // '\'{0}\' updated'
    'log delete projectfiles' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
    
    'log edit projectfilerevisions' => '{0} を更新しました', // '{0} updated'
    'log delete projectfilerevisions' => '{0} を削除しました', // '{0} deleted'
    
    'log add projectwebpages' => '\'{0}\' を追加しました', // '\'{0}\' added'
    'log edit projectwebpages' => '\'{0}\' を更新しました', // '\'{0}\' updated'
    'log delete projectwebpages' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
    
    'log add contacts' => '\'{0}\' をワークスペースにアサインしました', // '\'{0}\' assigned to workspace'
    'log edit contacts' => '\'{0}\' のロールを変更しました', // '\'{0}\' changed role'
    'log delete contacts' => '\'{0}\' をワークスペースから除きました', // '\'{0}\' removed from workspace'
  
  	'no contacts in company' => 'この会社にはコンタクトはありません。', // 'The company has no contacts.'
  
  	'session expired error' => 'セッションの期限が切れました。ページを再描画して、もう一度ログインしてください。', // 'The session has expired. Please, refresh the page and login again.'
  	'admin cannot be removed from admin group' => '最初のユーザは管理者グループから削除できません。', // 'First user cannot be deleted from Administrators group'
  	'open this link in a new window' => 'このリンクを新しいウィンドウで開きます。', // 'Open this link in a new window'
  
  	'confirm delete template' => 'このテンプレートを本当に削除しても良いですか?', // 'Are you sure that you want to delete this template?'
  	'success delete template' => 'テンプレート \'{0}\' は削除されました。', // 'Template \'{0}\' has been deleted'
  	'success add template' => 'テンプレートは追加されました。', // 'Template has been added'
  
  	'log add companies' => '\'{0}\' を追加しました', // '\'{0}\' added'
  	'log edit companies' => '\'{0}\' を更新しました', // '\'{0}\' updated'
  	'log delete companies' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
  
  	'log add mailcontents' => '\'{0}\' を追加しました', // '\'{0}\' added'
  	'log edit mailcontents' => '\'{0}\' を更新しました', // '\'{0}\' updated'
  	'log delete mailcontents' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
  
  	'log open timeslots' => '\'{0}\' をオープンしました', // '\'{0}\' opened'
    'log close timeslots' => '\'{0}\' をクローズしました', // '\'{0}\' closed'
    'log delete timeslots' => '\'{0}\' を削除しました', // '\'{0}\' deleted'
  	'error assign workspace' => 'テンプレートをこのワークスペースにアサインするのを失敗しました。', // 'Failed to assign template to workspace'
  	'success assign workspaces' => 'テンプレートをこのワークスペースにアサインするのを成功しました。', // 'Succeeded to assign template to workspace'
  	'success update config value' => 'おめでとうございます、設定値は更新されました。', // 'Configuration values updated'
  	'view open tasks' => 'オープンタスク', // 'Open tasks'
  	'already logged in' => 'すでにログインしています', // 'You are already logged in'
  
	'some tasks could not be updated due to permission restrictions' => 'パーミションの制限のためいくつかのタスクをアップデートできませんでした。', // 'Some tasks could not be updated due to permission restrictions'
    
  	// ENGLISH MISSING TRANSLATIONS
  	'log trash projectmessages' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash projectmessages' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash projectevents' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash projectevents' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash comments' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash comments' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash projectmilestones' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash projectmilestones' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash projecttasklists' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash projecttasklists' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash projecttasks' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash projecttasks' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash projectforms' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash projectforms' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash projectfiles' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash projectfiles' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash projectfilerevisions' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash projectfilerevisions' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash projectwebpages' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash projectwebpages' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash contacts' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash contacts' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash companies' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash companies' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash mailcontents' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash mailcontents' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'log trash timeslots' => '\'{0}\'をゴミ箱に移動しました。', // '\'{0}\' moved to trash',
    'log untrash timeslots' => '\'{0}\'をゴミ箱から戻しました。', // '\'{0}\' restored from trash',
    'success trash object' => 'ゴミ箱へオブジェクトの移動が成功しました。', // 'Object moved to trash successfully',
    'error trash object' => 'ゴミ箱へオブジェクトの移動が失敗しました。', // 'Failed to move object to trash',
    'success untrash object' => 'ゴミ箱からオブジェクトを戻すことに成功しました。', // 'Object restored from trash successfully',
    'error untrash object' => 'ゴミ箱からオブジェクトを戻すことに失敗しました。', // 'Failed to restore object from trash',
    'success trash objects' => 'ゴミ箱へ{0}オブジェクトの移動が成功しました。', // '{0} objects moved to trash successfully',
    'error trash objects' => 'ゴミ箱へ{0}オブジェクトの移動が失敗しました。', // 'Failed to move {0} objects to trash',
    'success untrash objects' => 'ゴミ箱から{0}オブジェクトを戻すことに成功しました。', // '{0} objects restored from trash successfully',
    'error untrash objects' => 'ゴミ箱から{0}オブジェクトを戻すことに失敗しました。', // 'Failed to restore {0} objects from trash',
    'success delete object' => 'オブジェクトの削除が成功しました。', // 'Object deleted successfully',
    'error delete object' => 'オブジェクトの削除が失敗しました。', // 'Failed to delete object',
  ); // array

?>