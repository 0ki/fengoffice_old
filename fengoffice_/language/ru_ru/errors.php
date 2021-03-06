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
    'invalid email address' => 'Формат адреса Email неверный',
   
    // Company validation errors
    'company name required' => 'Требуется имя компании или организации',
    'company homepage invalid' => 'Формат адреса домашней страницы неверный',
    
    // User validation errors
    'username value required' => 'Необходимо ввести имя пользователя',
    'username must be unique' => 'Извините, но выбранное имя пользователя уже существует',
    'email value is required' => 'Необходимо ввести адрес Email',
    'email address must be unique' => 'Извините, но выбранный адрес Email уже существует',
    'company value required' => 'Пользователь должен принадлежать какой-либо компании или организации',
    'password value required' => 'Необходимо ввести пароль',
    'passwords dont match' => 'Значения пароля не совпадают',
    'old password required' => 'Требуется старый пароль',
    'invalid old password' => 'Старый пароль неверен',
    'users must belong to a company' => 'Контакты должны принадлежать компании, чтобы создать пользователя',
    'contact linked to user' => 'Контакты связаны с пользователем {0}',
    
    // Avatar
    'invalid upload type' => 'Неверный тип файла. Допустимые типы файлов - {0}',
    'invalid upload dimensions' => 'Недопустимый размер изображения. Максимальный размер - {0}x{1} пикселей',
    'invalid upload size' => 'Недопустимый размер изображения. Максимальный размер - {0}',
    'invalid upload failed to move' => 'Не удалось переместить загруженный файл',
    
    // Registration form
    'terms of services not accepted' => 'Для того, чтобы создать счет, Вы должны прочитать и принять условия сервиса',
    
    // Init company website
    'failed to load company website' => 'Не удалось загрузить веб-сайт. Не найдена основная компания',
    'failed to load project' => 'Не удалось загрузить активный проект',
    
    // Login form
    'username value missing' => 'Пожалуйста, введите имя пользователя',
    'password value missing' => 'Пожалуйста, введите пароль',
    'invalid login data' => 'Не удалось войти в систему. Пожалуйста, проверьте имя пользователя и пароль и попробуйте снова',
    
    // Add project form
    'project name required' => 'Необходимо ввести имя проекта',
    'project name unique' => 'Имя проекта должно быть уникальным',
    
    // Add message form
    'message title required' => 'Необходимо ввести заголовок',
    'message title unique' => 'Заголовок не должен повторяться в одном проекте',
    'message text required' => 'Необходимо ввести текст',
    
    // Add comment form
    'comment text required' => 'Необходимо ввести текст комментария',
    
    // Add milestone form
    'milestone name required' => 'Необходимо ввести название этапа',
    'milestone due date required' => 'Необходимо ввести дату выполнения этапа',
    
    // Add task list
    'task list name required' => 'Необходимо ввести название задачи',
    'task list name unique' => 'Название задачи должно быть уникальным в проекте',
    'task title required' => 'Необходимо ввести заголовок задачи',
  
    // Add task
    'task text required' => 'Необходимо ввести текст задачи',
    
    // Add event
    'event subject required' => 'Необходимо ввести тему события',
    'event description maxlength' => 'Описание не должно превышать 3000 символов',
    'event subject maxlength' => 'Тема может содержать до 100 символов',
    
    // Add project form
    'form name required' => 'Необходимо ввести название формы',
    'form name unique' => 'Название формы должно быть уникальным',
    'form success message required' => 'Необходима отметка успешного выполнения',
    'form action required' => 'Необходимо указать действие формы',
    'project form select message' => 'Пожалуйста, выберите заметку',
    'project form select task lists' => 'Пожалуйста, выберите задачу',
    
    // Submit project form
    'form content required' => 'Пожалуйста, вставьте содержимое в текстовое поле',
    
    // Validate project folder
    'folder name required' => 'Необходимо указать имя папки',
    'folder name unique' => 'Имя папки должно быть уникальным в этом проекте',
    
    // Validate add / edit file form
    'folder id required' => 'Пожалуйста, выберите папку',
    'filename required' => 'Необходимо ввести имя файла',
    
    // File revisions (internal)
    'file revision file_id required' => 'Версия должна быть связана с файлом',
    'file revision filename required' => 'Необходимо ввести имя файла',
    'file revision type_string required' => 'Неизвестный тип файла',
    
    // Test mail settings
    'test mail recipient required' => 'Необходимо ввести адрес получателя',
    'test mail recipient invalid format' => 'Неверный формат адреса получателя',
    'test mail message required' => 'Необходимо ввести сообщение',
    
    // Mass mailer
    'massmailer subject required' => 'Необходимо ввести тему письма',
    'massmailer message required' => 'Необходимо ввести само сообщение',
    'massmailer select recepients' => 'Пожалуйста, выберите пользователей, которые получат Ваше сообщение',
    
  	//Email module
  	'mail account name required' => 'Необходимо ввести название учётной записи',
  	'mail account id required' => 'Необходимо ввести ID счета',
  	'mail account server required' => 'Требуется сервер',
  	'mail account password required' => 'Требуется пароль',	
  
  	'session expired error' => 'Сессия закрыта в связи с отсутствием активности пользователя. Пожалуйста, зайдите снова',
  	'unimplemented type' => 'Не использованный тип',
  	'unimplemented action' => 'Не использованное действие',
  
  	'workspace own parent error' => 'Проект не может быть источником самому себе',
  	'task own parent error' => 'Задача не может быть источником сама себе',
  	'task child of child error' => 'Задача не может быть потомком одного из своих потомков',
  
  	'chart title required' => 'Необходимо ввести заголовок диаграммы.',
  	'chart title unique' => 'Заголовок диаграммы должен быть неповторяющимся.',
    'must choose at least one workspace error' => 'Вы должны выбрать хотя бы один проект для помещения объекта в него.',
    
    
    'user has contact' => 'Контакт, присвоенный такому пользователю, уже существует',
    
    'maximum number of users reached error' => 'В системе зарегистрировано максимальное количество пользователей',
	'maximum number of users exceeded error' => 'Превышено максимально допустимое количество пользователей в системе. Приложение не сможет работать, пока Вы не исправите эту ситуацию.',
	'maximum disk space reached' => 'Ваша дисковая квота использована. Пожалуйста, удалите что-то, прежде чем добавлять новое, или обратитесь к администратору.',
	'error db backup' => 'Не удалось создать резервную копию базы данных. Проверьте константу MYSQLDUMP_COMMAND.',
	'error create backup folder' => 'Ошибка при создании папки для резерва. Не удалось осуществить резервное копирование',
	'error delete backup' => 'Ошибка при удалении резервной копии базы данных,',
	'success delete backup' => 'Резервная копия удалена',
   ); // array

?>