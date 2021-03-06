<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Проверка настроек почты',
    'administration tool desc test_mail_settings' => 'Воспользуйтесь этой утилитой для проверки работоспособности почты OpenGoo',
    'administration tool name mass_mailer' => 'Почтовая рассылка',
    'administration tool desc mass_mailer' => 'Утилита для отправки сообщений любой группе пользователей, зарегистрированной в системе.',
  
    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Конфигурация',
    
    'mail transport mail()' => 'Настройки PHP',
    'mail transport smtp' => 'SMTP сервер',
    
    'secure smtp connection no'  => 'Нет',
    'secure smtp connection ssl' => 'Использовать SSL',
    'secure smtp connection tls' => 'Использовать TLS',
    
    'file storage file system' => 'Система (файлы)',
    'file storage mysql' => 'База данных (MySQL)',
    
    // Categories
    'config category name general' => 'Главное',
    'config category desc general' => 'Основные настройки OpenGoo',
    'config category name mailing' => 'Почта',
    'config category desc mailing' => 'Эти настройки определяют, как OpenGoo будет посылать почтовые сообщения. Вы можете использовать настройки, указанные в вашем файле php.ini или установить любой другой SMTP сервер',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Название сайта',
    'config option desc site_name' => 'Это значение будет показано, как название сайта на странице с панелью инструментов',
    'config option name file_storage_adapter' => 'Файловое хранилище',
    'config option desc file_storage_adapter' => 'Укажите, где Вы хотите хранить прикрепленные файлы, изображения и другие загружаемые документы. Желательно использование базы данных. Внимание! Изменение места хранения данных прекратит доступ ко всем ранее загруженным файлам.',
    'config option name default_project_folders' => 'Папки по умолчанию',
    'config option desc default_project_folders' => 'Папки, создаваемые при запуске нового проекта . По одному названию на каждой строке. Повторяющиеся и пустые строки будут проигнорированы',
    'config option name theme' => 'Тема',
    'config option desc theme' => 'Используя темы, Вы можете изменить внешний вид OpenGoo',
    
    'config option name upgrade_check_enabled' => 'Проверять наличие новой версии ',
    'config option desc upgrade_check_enabled' => 'Ежедневно запрашивать информацию о наличии новой версии OpenGoo',
    
    // Mailing
    'config option name exchange_compatible' => 'Режим совместимости с Microsoft Exchange',
    'config option desc exchange_compatible' => 'Если вы используете Microsoft Exchange Server (ну и ламеры) установите эту опцию для стабильной работы почтовой службы.',
    'config option name mail_transport' => 'Доставка почты',
    'config option desc mail_transport' => 'Вы можете использовать настройки PHP, установленные по умолчанию или указать SMTP сервер',
    'config option name smtp_server' => 'SMTP сервер',
    'config option name smtp_port' => 'SMTP порт',
    'config option name smtp_authenticate' => 'Использовать SMTP аутентификацию',
    'config option name smtp_username' => 'SMTP логин',
    'config option name smtp_password' => 'SMTP пароль',
    'config option name smtp_secure_connection' => 'Использовать безопасное SMTP соединение',
  
 	'can edit company data' => 'Редактирование информации о компании',
  	'can manage security' => 'Управление безопасностью',
  	'can manage workspaces' => 'Управление проектами',
  	'can manage configuration' => 'Настройка конфигурации',
  	'can manage contacts' => 'Управление контактами',
  	'group users' => 'Группы пользователей',
    
  	
  	'user ws config category name dashboard' => 'Настройки панели ',
  	'user ws config category name task panel' => 'Опции задач',
  	'user ws config option name show pending tasks widget' => 'Показывать предстоящую задачу',
  	'user ws config option name pending tasks widget assigned to filter' => 'Показывать задачу, присвоенную',
  	'user ws config option name show late tasks and milestones widget' => 'Показывать последние задачи и этапы',
  	'user ws config option name show messages widget' => 'Показывать сообщения',
  	'user ws config option name show comments widget' => 'Показывать комментарии',
  	'user ws config option name show documents widget' => 'Показывать документы',
  	'user ws config option name show calendar widget' => 'Показывать мини-календарь',
  	'user ws config option name show charts widget' => 'Показывать диаграммы',
  	'user ws config option name show emails widget' => 'Показывать электронную почту',
  	
  	'user ws config option name my tasks is default view' => 'Задачи, присвоенные мне, являются видом по умолчанию',
  	'user ws config option desc my tasks is default view' => 'Если выбрано "Нет", панель задач будет показывать все задачи',
  	  	'user ws config option name show tasks in progress widget' => 'Показывать \'Задача выполняется\'',
  	'user ws config option name can notify from quick add' => 'Уведомление при быстром добавлении',
  	'user ws config option desc can notify from quick add' => 'Пометить, чтобы после быстрого добавления задачи уведомлять пользователей, которым она присвоена',
 	
  	'backup process desc' => 'Резервная копия сохраняет текущее состояние всего приложения в сжатую папку. Эту опцию можно использовать, чтобы сохранить всю установку OpenGoo. <br> На создание резерва базы данных и файловой системы может потребоваться больше, чем пара секунд, поэтому процесс разделен на три этапа: <br>1.- Запуск, <br>2.- Загрузка резерва. <br> 3.- Также, резервную копию можно вручную удалить и она станет недоступна. <br> ',
  	'start backup' => 'Запустить создание резервной копии',
    'start backup desc' => 'Запуск процесса оздания резервной копии предполагает удаление предыдущих копий и создание новой.',
  	'download backup' => 'Скачать резервную копию',
    'download backup desc' => 'Чтобы загрузить резервную копию, нужно сначала ее создать.',
  	'delete backup' => 'Удалить резервную копию',
    'delete backup desc' => 'Удаляет последнюю резервную копию. Настоятельно рекомендуется удалить резервную копию после ее загрузки.',
    'backup' => 'Резервное копирование',
    'backup menu' => 'Меню резервного копирования',
   	'last backup' => 'Последняя резервная копия создана: ',
   	'no backups' => 'Резервные копии отсутствуют',
   	
   	'user ws config option name always show unread mail in dashboard' => 'Всегда показывать непрочтенную почту на панели инструментов',
   	'user ws config option desc always show unread mail in dashboard' => 'Когда выбрано "Нет", будут показаны почтовые сообщения из активного проекта',
   	'workspace emails' => 'Почтовые сообщения проекта',
  	'user ws config option name tasksShowWorkspaces' => 'Показывать проекты',
  	'user ws config option name tasksShowTime' => 'Показывать время',
  	'user ws config option name tasksShowDates' => 'Показывать даты',
  	'user ws config option name tasksShowTags' => 'Показывать теги',
  	'user ws config option name tasksGroupBy' => 'Группировать по',
  	'user ws config option name tasksOrderBy' => 'Сортировать по',
  	'user ws config option name task panel status' => 'Статус',
  	'user ws config option name task panel filter' => 'Фильтровать по',
  	'user ws config option name task panel filter value' => 'Маска фильтра',
  ); // array

?>