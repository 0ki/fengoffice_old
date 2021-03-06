<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Comprobar las configuraciones del mail',
    'administration tool desc test_mail_settings' => 'Use esta herramienta para enviar mails de prueba y comprobar que el mail de OpenGoo está bien configurado',
    'administration tool name mass_mailer' => 'Mass mailer',
    'administration tool desc mass_mailer' => 'Herramienta que permite enviar mensages a cualquier grupo registrado en el sistema',
  
    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Configuración',
    
    'mail transport mail()' => 'Configuración de PHP',
    'mail transport smtp' => 'Servidor SMTP',
    
    'secure smtp connection no'  => 'No',
    'secure smtp connection ssl' => 'Si, use SSL',
    'secure smtp connection tls' => 'Si, use TLS',
    
    'file storage file system' => 'Archivo de sistema',
    'file storage mysql' => 'Base de datos (MySQL)',
    
    // Categories
    'config category name general' => 'General',
    'config category desc general' => 'Configuraciones generales OpenGoo',
    'config category name mailing' => 'Mailing',
    'config category desc mailing' => 'Use estas configuraciones para cambiar la forma en que OpenGoo maneja el envío de mails. Pueden usarse configuraciones provistas en su php.ini o establecer cualquier otro servidor SMTP.',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Nombre del sitio',
    'config option desc site_name' => 'Este valor va a ser desplegado como el nombre del sitio en la página Dashboard',
    'config option name file_storage_adapter' => 'Almacenamiento de archivos',
    'config option desc file_storage_adapter' => 'Elija donde guardar adjuntos, imágenes, logos y cualquier otro tipo de documentos subidos a la página. Se recomiendo el almacenamiento en la base de datos. <strong>Cambiar el tipo de almacenamiento causará que los archivos ingresados previamente dejen de estar disponibles</strong>.',
    'config option name default_project_folders' => 'Carpetas creadas por defecto',
    'config option desc default_project_folders' => 'Carpetas que van a ser creadas cuando se cree el espacio. El nombre de cada carpeta debera aparecer en una línea. Las líneas duplicadas o vacías no van a ser tenidas en cuenta',
    'config option name theme' => 'Tema',
    'config option desc theme' => 'Usando temas puede cambiar el aspecto de OpenGoo',
    
    'config option name upgrade_check_enabled' => 'Habilitar chequeo de actualizaciones',
    'config option desc upgrade_check_enabled' => 'Si escoge esta opción el sistema corroborara una vez al día si hay nuevas versiones disponibles de OpenGoo',
    
    // Mailing
    'config option name exchange_compatible' => 'Modo compatibilidad con Microsoft Exchange',
    'config option desc exchange_compatible' => 'Si utiliza el servidor Microsoft Exchange, elija esta opción para evitar algunos conocidos problemas de mailing.',
    'config option name mail_transport' => 'Transporte de correo',
    'config option desc mail_transport' => 'Puede usar las configuraciones PHP establecidas por defecto para el envío de mails o especificar un servidor SMTP',
    'config option name smtp_server' => 'Servidor SMTP',
    'config option name smtp_port' => 'Puerto SMTP',
    'config option name smtp_authenticate' => 'Use la autenticación SMTP',
    'config option name smtp_username' => 'Nombre de usuario SMTP',
    'config option name smtp_password' => 'Contraseña SMTP',
    'config option name smtp_secure_connection' => 'Use la conexión segura SMTP',
  
 	'can edit company data' => 'Puede modificar los datos de la compañía',
  	'can manage security' => 'Puede modificar configuraciones de seguridad',
  	'can manage workspaces' => 'Puede modificar configuraciones de espacios',
  	'can manage configuration' => 'Puede modificar las configuraciones',
  	'can manage contacts' => 'Puede modificar y editar contactos',
  	'group users' => 'Agrupar usuarios',
    
  	'user ws config category name dashboard' => 'Opciones del panel de visión',
  	'user ws config category name task panel' => 'Opciones del panel de tareas',
  	'user ws config option name show pending tasks widget' => 'Mostrar widget de tareas pendientes',
  	'user ws config option name pending tasks widget assigned to filter' => 'Mostrar tareas asignadas a',
  	'user ws config option name show late tasks and milestones widget' => 'Mostrar widget de hitos y tareas atrasadas',
  	'user ws config option name show messages widget' => 'Mostrar widget mensajes',
  	'user ws config option name show documents widget' => 'Mostrar widget de documentos',
  	'user ws config option name show calendar widget' => 'Mostrar widget de calendario',
  	'user ws config option name show charts widget' => 'Mostrar widget de graficas',
  	'user ws config option name show emails widget' => 'Mostrar widget de emails',
  	
 	'user ws config option name my tasks is default view' => 'La vista por defecto muestra sólo las tareas asignadas a mi',
  	'user ws config option desc my tasks is default view' => 'Si se selecciona no, se mostrarán todas las tareas del espacio y sus subespacios',

  ); // array

?>