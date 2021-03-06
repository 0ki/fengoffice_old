<?php return array(
	'administration tool name test_mail_settings' => 'Comprobar las configuraciones del correo electrónico',
	'administration tool desc test_mail_settings' => 'Use esta herramienta para enviar correos electrónicos de prueba y comprobar que el correo electrónico de Feng Office está bien configurado',
	'administration tool name mass_mailer' => 'Envío masivo',
	'administration tool desc mass_mailer' => 'Herramienta que permite enviar mensajes a cualquier grupo registrado en el sistema',
	'configuration' => 'Configuración',
	'mail transport mail()' => 'Configuración de PHP',
	'mail transport smtp' => 'Servidor SMTP',
	'secure smtp connection no' => 'No',
	'secure smtp connection ssl' => 'Sí, use SSL',
	'secure smtp connection tls' => 'Sí, use TLS',
	'file storage file system' => 'Archivo de sistema',
	'file storage mysql' => 'Base de datos (MySQL)',
	'config category name general' => 'General',
	'config category desc general' => 'Configuraciones generales de Feng Office',
	'config category name mailing' => 'Envío por correo electrónico',
	'config category desc mailing' => 'Use estas configuraciones para cambiar la forma en que Feng Office maneja el envío de correos electrónicos. Pueden usarse configuraciones provistas en su php.ini o establecer cualquier otro servidor SMTP.',
	'config category name passwords' => 'Contraseñas',
	'config category desc passwords' => 'Use estas configuraciones para manejar las opciones de contraseñas.',
	'config option name site_name' => 'Nombre del sitio',
	'config option desc site_name' => 'Este valor va a ser desplegado como el nombre del sitio en la página Panel principal',
	'config option name file_storage_adapter' => 'Almacenamiento de archivos',
	'config option desc file_storage_adapter' => 'Elija dónde guardar documentos cargados en la página. El motor de almacenamiento en la base de datos es recomendable.',
	'config option name default_project_folders' => 'Carpetas creadas por defecto',
	'config option desc default_project_folders' => 'Carpetas que van a ser creadas cuando se cree el área de trabajo. El nombre de cada carpeta debera aparecer en una línea. Las líneas duplicadas o vacías no van a ser tenidas en cuenta',
	'config option name theme' => 'Tema',
	'config option desc theme' => 'Usando temas puede cambiar el aspecto de Feng Office',
	'config option name work_day_start_time' => 'Hora de inicio de la jornada laboral',
	'config option desc work_day_start_time' => 'Especifica la hora de comienzo de la jornada laboral',
	'config option name time_format_use_24' => 'Utilizar formato de 24 horas',
	'config option desc time_format_use_24' => 'Si está habilitado el formato de hora será \'hh:mm\' desde 00:00 hasta 23:59, sino las horas se utilizarán desde 1 a 12 utilizando AM o PM.',
	'config option name file_revision_comments_required' => 'Comentarios obligatorios para las revisiones de documentos',
	'config option desc file_revision_comments_required' => 'Cada vez que se añade una nueva revisión de un documento se requiere ingresar un comentario.',
	'config option name checkout_notification_dialog' => 'Diálogo de notificación para documentos',
	'config option desc checkout_notification_dialog' => 'Al descargar un documento, preguntar al usuario si bloquea el documento o es solamente para lectura',
	'config option name currency_code' => 'Moneda',
	'config option desc currency_code' => 'Símbolo de la moneda',
	'config option name upgrade_check_enabled' => 'Habilitar comprobación de actualizaciones',
	'config option desc upgrade_check_enabled' => 'Si escoge esta opción el sistema comprobará una vez al día si hay nuevas versiones disponibles de Feng Office',
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
	'config option name min_password_length' => 'Tamaño mínimo de la contraseña',
	'config option desc min_password_length' => 'Cantidad mínima de caracteres requerida para la contraseña',
	'config option name password_numbers' => 'Números en la contraseña',
	'config option desc password_numbers' => 'Cantidad de caracteres numéricos requeridos para la contraseña',
	'config option name password_uppercase_characters' => 'Mayúsculas en la contraseña',
	'config option desc password_uppercase_characters' => 'Cantidad de caracteres en mayúsculas requeridos para la contraseña',
	'config option name password_metacharacters' => 'Metacaracteres en la contraseña',
	'config option desc password_metacharacters' => 'Cantidad de metacaracteres requeridos para la contraseña(e.g.: ., $, *)',
	'config option name password_expiration' => 'Expiración de la contraseña (días)',
	'config option desc password_expiration' => 'Cantidad de días en los cuales la contraseña es válida (0 para deshabilitar esta opción)',
	'config option name password_expiration_notification' => 'Notificación de expiración de contraseña (días antes)',
	'config option desc password_expiration_notification' => 'Cantidad de días para notificar al usuario antes de la expiración de su contraseña (0 para deshabilitar esta opción)',
	'config option name account_block' => 'Bloquear cuenta cuando expira la contraseña',
	'config option desc account_block' => 'Bloquear la cuenta del usuario cuando expire su contraseña (solo el administrador puede habilitar la cuenta nuevamente)',
	'config option name new_password_char_difference' => 'Validar la diferencia de caracteres en la contraseña contra el historial de contraseñas',
	'config option desc new_password_char_difference' => 'Validar que la nueva contraseña difiera en por lo menos 3 caracteres con respecto a las últimas 10 contraseñas utilizadas por el usuario',
	'config option name validate_password_history' => 'Validar historial de contraseñas',
	'config option desc validate_password_history' => 'Validar que la nueva contraseña no coincida con ninguna de las últimas 10 contraseñas utilizadas por el usuario',
	'config option name detect_mime_type_from_extension' => 'Detectar tipo mime a partir de la extensión',
	'config option desc detect_mime_type_from_extension' => 'Si se habilita, el tipo mime de los archivos es generado a partir de la extensión del archivo.',
	'can edit company data' => 'Puede modificar los datos de la empresa propietaria',
	'can manage security' => 'Puede modificar configuraciones de seguridad',
	'can manage workspaces' => 'Puede modificar configuraciones de áreas de trabajo',
	'can manage configuration' => 'Puede modificar las configuraciones',
	'can manage contacts' => 'Puede modificar todos los contactos',
	'group users' => 'Usuarios del grupo',
	'user ws config category name dashboard' => 'Opciones del panel de resumen',
	'user ws config category name task panel' => 'Opciones del panel de tareas',
	'user ws config category name calendar panel' => 'Opciones del Calendario',
	'user ws config category name mails panel' => 'Opciones del módulo de Email',
	'user ws config option name show pending tasks widget' => 'Mostrar widget de tareas pendientes',
	'user ws config option name pending tasks widget assigned to filter' => 'Mostrar tareas asignadas a',
	'user ws config option name show late tasks and milestones widget' => 'Mostrar widget de hitos y tareas atrasadas',
	'user ws config option name show messages widget' => 'Mostrar widget notas',
	'user ws config option name show comments widget' => 'Mostrar widget comentarios',
	'user ws config option name show documents widget' => 'Mostrar widget de documentos',
	'user ws config option name show calendar widget' => 'Mostrar widget de calendario',
	'user ws config option name show charts widget' => 'Mostrar widget de graficas',
	'user ws config option name show emails widget' => 'Mostrar widget de emails',
	'user ws config option name show dashboard info widget' => 'Mostrar widget de información del espacio',
	'user ws config option name my tasks is default view' => 'La vista por defecto muestra sólo las tareas asignadas a mi',
	'user ws config option desc my tasks is default view' => 'Si se selecciona no, se mostrarán todas las tareas del área de trabajo y sus subáreas',
	'user ws config option name show tasks in progress widget' => 'Mostrar widget de tareas en progreso',
	'user ws config option name can notify from quick add' => 'Checkbox de notificación chequeado por defecto',
	'user ws config option desc can notify from quick add' => 'El checkbox de notificación permite la opción de notificar a los usuarios asignados luego de añadir o modificar una tarea',
	'user ws config option name date_format' => 'Formato de fecha',
	'user ws config option desc date_format' => 'Formato en que se muestran las fechas. Códigos: d = Día (2 dígitos, con ceros), D = Nombre del día (tres letras), j = Día, l = Nombre del día completo, m = Mes (con ceros), M = Nombre del mes (tres letras), n = Mes, F = Nombre del mes completo, Y = Año (4 dígitos), y = Año (2 dígitos). Debe recargar la página para aplicar los cambios.',
	'user ws config option name descriptive_date_format' => 'Formato de fecha descriptivo',
	'user ws config option desc descriptive_date_format' => 'Formato utilizado para las fechas, con descripción. Códigos: Idem a \'Formato de fecha\'. Debe recargar la página para aplicar los cambios.',
	'user ws config option name show_context_help' => 'Mostrar ayuda contextual',
	'user ws config option desc show_context_help' => 'Puede seleccionar mostrar siempre la ayuda, no mostrarla nunca, o mostrar cada recuadro hasta que sea cerrado.',
	'user ws config option name view deleted accounts emails' => 'Ver correos de cuentas eliminadas',
	'user ws config option desc view deleted accounts emails' => 'Permite ver los correos electrónicos de las cuentas de correo eliminadas (al eliminar una cuenta no se deben eliminar sus correos para poder utilizar esta opción)',
	'user ws config option name block_email_images' => 'Bloquear imágenes en emails',
	'user ws config option desc block_email_images' => 'No se muestran las imágenes pertenecientes al contenido de los emails.',
	'user ws config option name draft_autosave_timeout' => 'Intervalo para el autoguardado de borradores',
	'user ws config option desc draft_autosave_timeout' => 'Cantidad de segundos entre cada autoguardado (0 para deshabilitar)',
	'show context help always' => 'Siempre',
	'show context help never' => 'Nunca',
	'show context help until close' => 'Hasta cerrar',
	'user ws config option name always show unread mail in dashboard' => 'Siempre mostrar correo no leído en la vista de resumen',
	'user ws config option desc always show unread mail in dashboard' => 'Al seleccionar NO sólo se mostraran los correos del área de trabajo activa',
	'workspace emails' => 'Correos del área de trabajo',
	'user ws config option name tasksShowWorkspaces' => 'Mostrar áreas de trabajo',
	'user ws config option name tasksShowTime' => 'Mostrar tiempo',
	'user ws config option name tasksShowDates' => 'Mostrar fechas',
	'user ws config option name tasksShowTags' => 'Mostrar etiquetas',
	'user ws config option name tasksGroupBy' => 'Agrupar por',
	'user ws config option name tasksOrderBy' => 'Ordenar por',
	'user ws config option name task panel status' => 'Estado',
	'user ws config option name task panel filter' => 'Filtrar por',
	'user ws config option name task panel filter value' => 'Valor del filtro',
	'user ws config option name start_monday' => 'Empezar la semana desde el Lunes',
	'user ws config option desc start_monday' => 'Las vistas del calendario mostrarán el lunes como primer día de la semana (debe actualizar la página para aplicar los cambios)',
	'user ws config option name show_week_numbers' => 'Mostrar los números de semana',
	'user ws config option desc show_week_numbers' => 'Muestra los números de semana en la vista mensual y semanal.',
	'config option name days_on_trash' => 'Días en la papelera',
	'config option desc days_on_trash' => 'Cuántos días un objeto es almacenado en la papelera antes de ser eliminado automáticamente. Si es 0, los objetos no serán eliminados de la papelera.',
	'templates' => 'Plantillas',
	'add template' => 'Agregar plantilla',
	'confirm delete template' => 'Está seguro de que desea borrar esta plantilla?',
	'no templates' => 'No hay plantillas',
	'template name required' => 'El nombre de la plantilla es requerido',
	'can manage templates' => 'Puede manejar plantillas',
	'can manage time' => 'Puede manejar Tiempo',
	'can add mail accounts' => 'Puede agregar cuentas de correo',
	'new template' => 'Nueva plantilla',
	'edit template' => 'Editar plantilla',
	'template dnx' => 'La plantilla no existe',
	'success edit template' => 'Plantilla modificada correctamente',
	'log add cotemplates' => '{0} agregado',
	'log edit cotemplates' => '{0} modificado',
	'success delete template' => 'Plantilla borrada correctamente',
	'error delete template' => 'Error al borrar la plantilla',
	'objects' => 'Objetos',
	'objects in template' => 'Objectos en la plantilla',
	'no objects in template' => 'No hay objetos en la plantilla',
	'add to a template' => 'Agregar a plantilla',
	'add an object to template' => 'Agregar un objeto a esta plantilla',
	'you are adding object to template' => 'Está agregando {0} \'{1}\' a una plantilla. Elija una plantilla o cree una nueva.',
	'success add object to template' => 'Objeto correctamente agregado a template',
	'object type not supported' => 'Este tipo de objeto no está soportado para plantillas',
	'assign template to workspace' => 'Asignar template a espacio de trabajo',
	'config option name enable_email_module' => 'Habilitar Módulo de Correo',
	'config category name modules' => 'Módulos',
	'config category desc modules' => 'Utilice estas opciones para habilitar o deshabilitar módulos. Deshabilitar un módulo sólo lo esconderá de la interfaz gráfica. No se alterarán los permisos de los usuarios sobre los objetos.',
	'config option name enable_notes_module' => 'Habilitar módulo de notas',
	'config option name enable_contacts_module' => 'Habilitar módulo de contactos',
	'config option name enable_calendar_module' => 'Habilitar módulo de calendario',
	'config option name enable_documents_module' => 'Habilitar módulo de documentos',
	'config option name enable_tasks_module' => 'Habilitar módulo de tareas',
	'config option name enable_weblinks_module' => 'Habilitar módulo de enlaces web',
	'config option name enable_time_module' => 'Habilitar módulo de horas',
	'config option name enable_reporting_module' => 'Habilitar módulo de reportes',
	'user ws config category name general' => 'General',
	'user ws config option name localization' => 'Localización',
	'user ws config option desc localization' => 'Textos y fechas serán desplegados según está opción. Necesita refrescar para que haga efecto.',
	'user ws config option name initialWorkspace' => 'Área de trabajo inicial',
	'user ws config option desc initialWorkspace' => 'Esta opción le permite escoger cuál será el área de trabajo seleccionado cuando inicia, o puede escoger recordar la última área de trabajo visto.',
	'user ws config option name rememberGUIState' => 'Recordar el estado de la interfaz gráfica',
	'user ws config option desc rememberGUIState' => 'Esto permite que se mantenga el estado de la interfaz gráfica (tamaño de paneles, paneles colapsados/expandidos, etc) entre distintas sesiones. Advertencia: Esta funcionalidad está en estado BETA.',
	'user ws config option name time_format_use_24' => 'Usar formato de 24 horas',
	'user ws config option desc time_format_use_24' => 'Si está habilitado el formato de hora será \'hh:mm\' desde 00:00 hasta 23:59, sino las horas se utilizarán desde 1 a 12 utilizando AM o PM.',
	'user ws config option name work_day_start_time' => 'Hora de inicio de la jornada laboral',
	'user ws config option desc work_day_start_time' => 'Especifica la hora de comienzo de la jornada laboral',
	'cron events' => 'Eventos de Cron',
	'about cron events' => 'Aprenda sobre eventos de Cron...',
	'cron events info' => 'Los eventos de Cron le permiten ejecutar tareas periódicamente, sin necesidad de iniciar una sesión. Para habilitar eventos de Cron necesita previamente configurar un \'cron job\' que periódicamente ejecute el archivo "cron.php", ubicado en la raíz de su instalación de Feng Office. La periodicidad a la que ejecute el \'cron job\' determinará la granularidad a la que podrá ejecutar estos eventos de Cron. Por ejemplo, si el \'cron job\' ejecuta cada cinco minutos y usted configura un evento de Cron para ejecutar cada un minuto, sólo podrá ejecutar cada cinco minutos. Para aprender cómo configurar un \'cron job\' consulte con su administrador de sistema o su proveedor de hosting.',
	'cron event name check_mail' => 'Recibir correos',
	'cron event desc check_mail' => 'Este evento de Cron chequea todas las cuentas de e-mail del sistema en busca de nuevos correos.',
	'cron event name purge_trash' => 'Vaciar Papelera',
	'cron event desc purge_trash' => 'Este evento de Cron elimina de la papelera los objetos cuya antiguedad sea mayor a la cantidad de días especificada según la opción de configuración \'Días en la papelera\'.',
	'cron event name send_reminders' => 'Envío de recordatorios',
	'cron event desc send_reminders' => 'Este evento de Cron envía los recordatorios definidos.',
	'cron event name check_upgrade' => 'Verificar actualizaciones',
	'cron event desc check_upgrade' => 'Este evento de Cron verifica la existencia de nuevas versiones de Feng Office.',
	'next execution' => 'Próxima ejecución',
	'delay between executions' => 'Período entre ejecuciones',
	'enabled' => 'Habilitado',
	'no cron events to display' => 'No hay eventos para mostrar',
	'success update cron events' => 'Eventos de Cron modificados existosamente.',
	'manual upgrade' => 'Actualización manual',
	'manual upgrade desc' => 'To manually upgrade Feng Office you have to download the new version of Feng Office, extract it to the root of your installation and then go to \'public/upgrade\' in your browser to run the upgrade process.',
	'automatic upgrade' => 'Actualización automática',
	'automatic upgrade desc' => 'La actualización automática descarga e instala la nueva versión, y ejecuta el proceso de actualización.',
	'start automatic upgrade' => 'Comenzar la actualización automática',
	'config option name use_minified_resources' => 'Utilizar recursos minimizados',
	'config option desc use_minified_resources' => 'Utiliza Javascript y CSS comprimido para mejorar el rendimiento. Deberá recomprimir JS y CSS si los modifica, utilizando public/tools.',
	'config option name checkout_for_editing_online' => 'Bloquear automáticamente cuando se edita en línea',
	'config option desc checkout_for_editing_online' => 'Cuando un usuario edita el documento en línea se bloquea para que nadie pueda editarlo al mismo tiempo',
	'can manage reports' => 'Permitir la modificación de la configuración de reportes',
	'user ws config option name show getting started widget' => 'Mostrar el widget comenzando',
	'user ws config option name show_tasks_context_help' => 'Mostrar ayuda contextual para tareas',
	'user ws config option desc show_tasks_context_help' => 'Si está habilitada, un panel de ayuda contextual será mostrado en el panel de tareas',
	'cron event name send_notifications_through_cron' => 'Enviar notificaciones a través de cron',
	'cron event desc send_notifications_through_cron' => 'Si este evento está habilitado notificaciones de correo serán enviadas a través del cron y no al ser generadas por Feng Office.',
	'select object type' => 'Seleccione un tipo de objeto',
	'select one' => 'Seleccione',
	'email type' => 'Correo electrónico',
	'custom properties updated' => 'Propiedades personalizadas actualizadas',
	'config option name show_feed_links' => 'Mostrar enlaces a suscripciones',
	'config option desc show_feed_links' => 'Esta opción le permite mostrar o ocultar enlaces a suscripciones de RSS o iCal al usuario conectado. ADVERTENCIA: Estos enlaces contienen información necesaria para iniciar la sesión del usuario. Si el usuario comparte estos enlaces podría estar comprometiendo toda su información.',
	'config option name ask_administration_autentification' => 'Autentificar la Administración',
	'config option desc ask_administration_autentification' => 'Indica si se debe desplegar un dialogo de autentificacion mediante contraseña antes de ingresar al panel de administracion. ',
	'config option name user_email_fetch_count' => 'Límite de correos a obtener',
	'config option desc user_email_fetch_count' => 'Cuántos correos obtener cuando el usuario hace clic en el botón "Verificar cuentas de correo". Si usa un valor muy grande puede causar errores de interrupción al usuario. Use 0 para no limitar la cantidad de correos a buscar. Nota, esta opción no afecta correo obtenido por cron.',
	'user ws config option name noOfTasks' => 'Número de tareas mostradas por defecto',
	'autentify password title' => 'Autentificar Contraseña',
	'autentify password desc' => 'Has solicitado ingresar al panel de administración.<br/> Por favor ingresa tu contraseña nuevamente',
	'user ws config option name amount_objects_to_show' => 'Número de Objetos Vinculados',
	'user ws config option desc amount_objects_to_show' => 'Configura el número de Objetos Vinulados a desplegarse en la vista de cada objeto.',
	'user ws config option name show_two_weeks_calendar' => 'Mostrar dos semanas en Calendario',
	'user ws config option desc show_two_weeks_calendar' => 'Determina la cantidad de semanas a mostrarse en el widget de calendario en dos',
	'user ws config option name attach_docs_content' => 'Adjuntar el contenido de archivos',
	'user ws config option desc attach_docs_content' => 'Cuando esta opcioón está habilitada, los archivos van a ser adjuntados de manera usual. Sino se adjunta un link al archivo.',
	'user ws config option name max_spam_level' => 'Máximo nivel para Spam',
	'user ws config option desc max_spam_level' => 'Al verificar el correo, los mensajes cuya evaluación de spam sea mayor que este valor serán enviados a la carpeta "Basura". Valor = 0 para un máximo filtrado, 10 sin filtro. Esta opción solo funcionará si en su servidor se encuentra instalada na herrmaienta para el filtro de Spam.',
	'edit default user preferences' => 'Editar preferencias de usuario por defecto',
	'default user preferences' => 'Preferencias de usuario por defecto',
	'default user preferences desc' => 'Determine los valores por defecto de las preferencias de usuario. Estos valores se aplicarán mientras el usuario no determine los valores sus preferencias.',
	'add a parameter to template' => 'Agregar un parámetro a esta plantilla',
	'parameters' => 'Parámetros',
	'config option name smtp_address' => 'Dirección SMTP',
	'config option desc smtp_address' => 'Opcional. Algunos servidores requieren que los correos enviados tengan una dirección de correo del servidor. Dejar en blanco para usar la dirección de correo del usuario que envía el correo.',
	'mail accounts' => 'Cuentas de correo',
	'incoming server' => 'Servidor entrante',
	'outgoing server' => 'Servidor saliente',
	'no email accounts' => 'No hay cuentas de correo',
	'user ws config option name create_contacts_from_email_recipients' => 'Crear contactos de destinatarios de correo',
	'user ws config option desc create_contacts_from_email_recipients' => 'Si esta opción está en "Sí" se creará automáticamente un contacto por cada dirección a la que envía un correo. Necesita el permiso "Puede modificar todos los contactos".',
	'user ws config option name drag_drop_prompt' => 'Acción a tomar al arrastrar a un área de trabajo',
	'user ws config option desc drag_drop_prompt' => 'Escoja qué acción tomar al arrastrar un objeto a un área de trabajo.',
	'drag drop prompt option' => 'Prgeuntar al usuario',
	'drag drop move option' => 'Mover a la nueva área de trabajo y quitar de las anteriores.',
	'drag drop keep option' => 'Agregar a la nueva área de trabajo preservando las anteriores.',
	'user ws config option name mail_drag_drop_prompt' => 'Clasificar adjuntos al arrastrar un correo?',
	'user ws config option desc mail_drag_drop_prompt' => 'Escoja qué hacer con los adjuntos de un correo al arrastrarlo a un área de trabajo.',
	'mail drag drop prompt option' => 'Preguntar al usuario',
	'mail drag drop classify option' => 'Clasificar los adjuntos',
	'mail drag drop dont option' => 'No clasificar los adjuntos',
	'user ws config option name show_emails_as_conversations' => 'Mostrar correos como conversaciones',
	'user ws config option desc show_emails_as_conversations' => 'Si está habilitado los correos se agruparan en conversaciones en el listado de correos, mostrando los correos relacionados como una única entrada.',
	'user ws config option name autodetect_time_zone' => 'Autodetectar zona horaria',
	'user ws config option desc autodetect_time_zone' => 'Cuando esta opción está habilitada la zona horaria del usuario se detectará automáticamente desde el navegador.',
	'user ws config option name search_engine' => 'Motor de búsquedas',
	'user ws config option desc search_engine' => 'Escoja qué motor de búsquedas usar. "Completa" hará una búsqueda más exhaustiva pero tomará más tiempo que "Rápida".',
	'search engine mysql like' => 'Completa',
	'search engine mysql match' => 'Rápida',
	'user ws config option name hide_quoted_text_in_emails' => 'Ocultar texto citado al ver correos',
	'user ws config option desc hide_quoted_text_in_emails' => 'Si se habilita, los correos se mostraran sin texto citado. Habrá una opción para podrá mostrar el texto citado en la vista del correo.',
	'user ws config option name task_display_limit' => 'Número máximo de tareas a desplegar',
	'user ws config option desc task_display_limit' => 'Por motivos de agilidad, este número no debe ser muy grande. Use 0 para no limitar.',
); ?>
