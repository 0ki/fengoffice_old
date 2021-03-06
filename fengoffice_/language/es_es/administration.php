<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Comprobar las configuraciones del correo electrónico',
    'administration tool desc test_mail_settings' => 'Use esta herramienta para enviar correos electrónicos de prueba y comprobar que el correo electrónico de OpenGoo está bien configurado',
    'administration tool name mass_mailer' => 'Envío masivo',
    'administration tool desc mass_mailer' => 'Herramienta que permite enviar mensajes a cualquier grupo registrado en el sistema',
  
    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Configuración',
    
    'mail transport mail()' => 'Configuración de PHP',
    'mail transport smtp' => 'Seridor SMTP',
    
    'secure smtp connection no'  => 'No',
    'secure smtp connection ssl' => 'Sí, use SSL',
    'secure smtp connection tls' => 'Sí, use TLS',
    
    'file storage file system' => 'Archivo de sistema',
    'file storage mysql' => 'Base de datos (MySQL)',
    
    // Categories
    'config category name general' => 'General',
    'config category desc general' => 'Configuraciones generales de OpenGoo',
    'config category name mailing' => 'Envío por correo electrónico',
    'config category desc mailing' => 'Use estas configuraciones para cambiar la forma en que OpenGoo maneja el envío de correos electrónicos. Pueden usarse configuraciones provistas en su php.ini o establecer cualquier otro servidor SMTP.',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Nombre del sitio',
    'config option desc site_name' => 'Este valor va a ser desplegado como el nombre del sitio en la página Panel principal',
    'config option name file_storage_adapter' => 'Almacenamiento de archivos',
    'config option desc file_storage_adapter' => 'Elija dónde guardar documentos cargados en la página. <strong>El motor de almacenamiento en la base de datos es recomendable</strong>.',
    'config option name default_project_folders' => 'Carpetas creadas por defecto',
    'config option desc default_project_folders' => 'Carpetas que van a ser creadas cuando se cree el proyecto. El nombre de cada carpeta debera aparecer en una línea. Las líneas duplicadas o vacías no van a ser tenidas en cuenta',
    'config option name theme' => 'Tema',
    'config option desc theme' => 'Usando temas puede cambiar el aspecto de OpenGoo',
    
    // OpenGoo.org
    'config option name upgrade_check_enabled' => 'Habilitar comprobación de actualizaciones',
    'config option desc upgrade_check_enabled' => 'Si escoge esta opción el sistema comprobará una vez al día si hay nuevas versiones disponibles de OpenGoo',
    
    // Mailing
    'config option name exchange_compatible' => 'Modo compatibilidad con Microsoft Exchange',
    'config option desc exchange_compatible' => 'Si utiliza el servidor Microsoft Exchange, elija esta opción para evitar algunos problemas conocidos de envío por correo electrónico.',
    'config option name mail_transport' => 'Transporte de correo',
    'config option desc mail_transport' => 'Puede usar las configuraciones PHP establecidas por defecto para el envío de correos electrónicos o especificar un servidor SMTP',
    'config option name smtp_server' => 'Servidor SMTP',
    'config option name smtp_port' => 'Puerto SMTP',
    'config option name smtp_authenticate' => 'Use la autenticación SMTP',
    'config option name smtp_username' => 'Nombre de usuario SMTP',
    'config option name smtp_password' => 'Contraseña SMTP',
    'config option name smtp_secure_connection' => 'Use la conexión segura SMTP',
  
 	'can edit company data' => 'Puede modificar los datos de la compañía',
  	'can manage security' => 'Puede modificar configuraciones de seguridad',
  	'can manage workspaces' => 'Puede modificar configuraciones de áreas de trabajo',
  	'can manage configuration' => 'Puede modificar las configuraciones',
  	'can manage contacts' => 'Puede modificar y editar contactos',
  	'group users' => 'Agrupar usuarios',
    
  	'user ws config category name dashboard' => 'Opciones del panel de resumen',
  	'user ws config category name task panel' => 'Opciones del panel de tareas',
  	'user ws config option name show pending tasks widget' => 'Mostrar widget de tareas pendientes',
  	'user ws config option name pending tasks widget assigned to filter' => 'Mostrar tareas asignadas a',
  	'user ws config option name show late tasks and milestones widget' => 'Mostrar widget de hitos y tareas atrasadas',
  	'user ws config option name show messages widget' => 'Mostrar widget notas',
  	'user ws config option name show comments widget' => 'Mostrar widget comentarios',
  	'user ws config option name show documents widget' => 'Mostrar widget de documentos',
  	'user ws config option name show calendar widget' => 'Mostrar widget de calendario',
  	'user ws config option name show charts widget' => 'Mostrar widget de graficas',
  	'user ws config option name show emails widget' => 'Mostrar widget de emails',
  	
 	'user ws config option name my tasks is default view' => 'La vista por defecto muestra sólo las tareas asignadas a mi',
  	'user ws config option desc my tasks is default view' => 'Si se selecciona no, se mostrarán todas las tareas del espacio y sus subespacios',
  	'user ws config option name show tasks in progress widget' => 'Mostrar widget de tareas en progreso',
  	'user ws config option name can notify from quick add' => 'Checkbox de notificación en vista de ingreso rápido',
  	'user ws config option desc can notify from quick add' => 'Se habilita un checkbox para poder notificar al usuario asignado cuando se usa el formulario de ingreso rápido de tareas',
    
  	'backup process desc' => 'Un respaldo almacena el estado de toda la aplicación en un archivo comprimido. Pretende ser una forma rápida de obtener un respaldo de una instalación de OpenGoo. <br> Generar un respaldo puede demorar más que unos segundos, por lo que el proceso de respaldo consiste en 3 pasos: <br>1.- Iniciar un proceso de respaldo, <br>2.- Desargar el respaldo. <br> 3.- Opcional. Eliminar el respaldo del servidor. <br> ',
  	'start backup' => 'Iniciar proceso de respaldo',
    'start backup desc' => 'Iniciar un proceso de respaldo implica eliminar respaldos anteriores y generar uno nuevo.',
  	'download backup' => 'Descargar respaldo',
    'download backup desc' => 'Para poder descargar un respaldo es necesario iniciar el proceso primero.',
  	'delete backup' => 'Borrar respaldo',
    'delete backup desc' => 'Elimina el ultimo respaldo, para que no este disponible para descarga. Se recomienda borrar los respaldos luego de descargarlos.',
    'backup' => 'Respaldo',
    'backup menu' => 'Menú de respaldos',
   	'last backup' => 'El ultimo respaldo fue creado en',
   	'no backups' => 'No hay respaldos para descargar',
   	'user ws config option name always show unread mail in dashboard' => 'Siempre mostrar correo no leído en la vista de resumen',
   	'user ws config option desc always show unread mail in dashboard' => 'Al seleccionar NO sólo se mostraran los correos del espacio de trabajo activo',
  	'workspace emails' => 'Correos del espacio de trabajo',
  	'user ws config option name tasksShowWorkspaces' => 'Mostrar espacios',
  	'user ws config option name tasksShowTime' => 'Mostrar tiempo',
  	'user ws config option name tasksShowDates' => 'Mostrar fechas',
  	'user ws config option name tasksShowTags' => 'Mostrar etiquetas',
  	'user ws config option name tasksShowGroupBy' => 'Agrupar por',
  	'user ws config option name tasksShowOrderBy' => 'Ordenar por',
  	'user ws config option name task panel status' => 'Estado',
  	'user ws config option name task panel filter' => 'Filtrar por',
  	'user ws config option name task panel filter value' => 'Valor del filtro',
  ); // array

?>