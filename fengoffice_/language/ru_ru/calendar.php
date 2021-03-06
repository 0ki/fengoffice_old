<?php

  return array(
	// ########## QUERY ERRORS ###########
	"CAL_QUERY_GETEVENT_ERROR" => "Ошибка базы данных: не удалось найти событие по ID",
	"CAL_QUERY_SETEVENT_ERROR" => "Ошибка базы данных: не удалось записать данные события",
	// ########## SUBMENU ITEMS ###########
	"CAL_SUBM_LOGOUT" => "Выйти",
	"CAL_SUBM_LOGIN" => "Зайти",
	"CAL_SUBM_ADMINPAGE" => "Страница администратора",
	"CAL_SUBM_SEARCH" => "Поиск",
	"CAL_SUBM_BACK_CALENDAR" => "Назад к календарю",
	"CAL_SUBM_VIEW_TODAY" => "Смотреть сегодняшние события",
	"CAL_SUBM_ADD" => "Добавить событие сегодня",
	// ########## NAVIGATION MENU ITEMS ##########
	"CAL_MENU_BACK_CALENDAR" => "Назад к календарю",
	"CAL_MENU_NEWEVENT" => "Новое событие",
	"CAL_MENU_BACK_EVENTS" => "Назад к событиям",
	"CAL_MENU_GO" => "Вперед",
	"CAL_MENU_TODAY" => "Сегодня",
	// ########## USER PERMISSION ERRORS ##########
	"CAL_NO_READ_PERMISSION" => "У вас нет полномочий просматривать это событие.",
	"CAL_NO_WRITE_PERMISSION" => "У вас нет полномочий добавлять или редактировать события.",
	"CAL_NO_EDITOTHERS_PERMISSION" => "У вас нет полномочий редактировать события других пользователей.",
	"CAL_NO_EDITPAST_PERMISSION" => "У вас нет полномочий добавлять или редактировать прошедшие события.",
	"CAL_NO_ACCOUNTS" => "Этот календарь не допускает модификации, вход только для администратора.",
	"CAL_NO_MODIFY" => "невозможно изменить",
	"CAL_NO_ANYTHING" => "У вас нет полномочий  делать что-либо на этой странице",
	"CAL_NO_WRITE", "У вас нет полномочий создавать новые события",
	// ############ DAYS ############
	"CAL_MONDAY" => "Понедельник",
	"CAL_TUESDAY" => "Вторник",
	"CAL_WEDNESDAY" => "Среда",
	"CAL_THURSDAY" => "Четверг",
	"CAL_FRIDAY" => "Пятница",
	"CAL_SATURDAY" => "Суббота",
	"CAL_SUNDAY" => "Воскресенье",
	"CAL_SHORT_MONDAY" => "Пон",
	"CAL_SHORT_TUESDAY" => "Вт",
	"CAL_SHORT_WEDNESDAY" => "Ср",
	"CAL_SHORT_THURSDAY" => "Чтв",
	"CAL_SHORT_FRIDAY" => "Птн",
	"CAL_SHORT_SATURDAY" => "Суб",
	"CAL_SHORT_SUNDAY" => "Вск",
	// ############ MONTHS ############
	"CAL_JANUARY" => "Январь",
	"CAL_FEBRUARY" => "Февраль",
	"CAL_MARCH" => "Март",
	"CAL_APRIL" => "Апрель",
	"CAL_MAY" => "Май",
	"CAL_JUNE" => "Июнь",
	"CAL_JULY" => "Июль",
	"CAL_AUGUST" => "Август",
	"CAL_SEPTEMBER" => "Сентябрь",
	"CAL_OCTOBER" => "Октябрь",
	"CAL_NOVEMBER" => "Ноябрь",
	"CAL_DECEMBER" => "Декабрь",
	
	
	
	
	
	
	// SUBMITTING/EDITING EVENT SECTION TEXT (event.php)
	"CAL_MORE_TIME_OPTIONS" => "Дополнительные настройки времени",
	"CAL_REPEAT" => "Повторять",
	"CAL_EVERY" => "Каждый",
	"CAL_REPEAT_FOREVER" => "Повторять всегда",
	"CAL_REPEAT_UNTIL" => "Повторять до",
	"CAL_TIMES" => "Времена",
	"CAL_HOLIDAY_EXPLAIN" => "Событие будет повторяться каждый",
	"CAL_DURING" => "Во время",
	"CAL_EVERY_YEAR" => "Каждый год",
	"CAL_HOLIDAY_EXTRAOPTION" => "Или, поскольку событие попадает на последнюю неделю месяца, пометьте здесь, чтобы оно было записано ПОСЛЕДНИМ",
	"CAL_IN" => "в",
	"CAL_PRIVATE_EVENT_EXPLAIN" => "Это частное событие",
	"CAL_SUBMIT_ITEM" => "Утвердить пункт",
	"CAL_MINUTES" => "Минут", 
	"CAL_MINUTES_SHORT" => "мин",
	"CAL_TIME_AND_DURATION" => "Дата, время и длительность",
	"CAL_REPEATING_EVENT" => "Повторяющееся событие",
	"CAL_EXTRA_OPTIONS" => "Доролнительные настройки",
	"CAL_ONLY_TODAY" => "Только в этот день",
	"CAL_DAILY_EVENT" => "Повторять ежедневно",
	"CAL_WEEKLY_EVENT" => "Повторять еженедельно",
	"CAL_MONTHLY_EVENT" => "Повторять ежемесячно",
	"CAL_YEARLY_EVENT" => "Повторять ежегодно",
	"CAL_HOLIDAY_EVENT" => "Повторять по выходным",
	"CAL_UNKNOWN_TIME" => "Время начала неизвестно",
	"CAL_ADDING_TO" => "Добавлено к",
	"CAL_ANON_ALIAS" => "Псевдоним",
	"CAL_EVENT_TYPE" => "Тип события",
		
	// MULTI-SECTION RELATED TEXT (used by more than one section, but not everwhere)
	"CAL_DESCRIPTION" => "Описание", // (search, view date, view event)
	"CAL_DURATION" => "Длительность", // (view event, view date)
	"CAL_DATE" => "Дата", // (search, view date)
	"CAL_NO_EVENTS_FOUND" => "Событий не найдено", // (search, view date)
	"CAL_NO_SUBJECT" => "Нет темы", // (search, view event, view date, calendar)
	"CAL_PRIVATE_EVENT" => "Частное событие", // (search, view event)
	"CAL_DELETE" => "Удалить", // (view event, view date, admin)
	"CAL_MODIFY" => "Изменить", // (view event, view date, admin)
	"CAL_NOT_SPECIFIED" => "Не определено", // (view event, view date, calendar)
	"CAL_FULL_DAY" => "Весь день", // (view event, view date, calendar, submit event)
	"CAL_HACKING_ATTEMPT" => "Попытка взлома - IP адрес записан", // (delete)
	"CAL_TIME" => "Время", // (view date, submit event)
	"CAL_HOURS" => "Часы", // (view event, submit event)
	"CAL_HOUR" => "Час", // (view event, submit event)
	"CAL_ANONYMOUS" => "Анонимно", // (view event, view date, submit event),
			
	'CAL_SELECT_TIME' => "Выбрать время начала",
	
	'event invitations' => 'Приглашения на участие',
	'event invitations desc' => 'Пригласить выбранных людей участвовать в этом событии',
	'send new event notification' => 'Послать уведомление по почте',
	'new event notification' => 'Добавлены новые события',
  'change event notification' => 'Событие изменено',
	'deleted event notification' => 'Событие удалено',
	'attendance' => 'Вы будете участвовать?',
  'confirm attendance' => 'Подтвердить присутствие',
  'maybe' => 'Может быть',
  'decide later' => 'Решить позже',
  'view event' => 'Посмотреть событие',
	'new event created' => 'Создано новое событие',
	'event changed' => 'Событие изменено',
 	'event deleted' => 'Событие удалено',
	'calendar of' => '{0}\' календарь',
	'all users' => 'Все пользователи',
  'error delete event' => 'Ошибка удаления события',  
	
	'days' => "дни",
	'weeks' => "недели",
	'months' => "месяцы",
	'years' => "годы",

  ); // array
?>