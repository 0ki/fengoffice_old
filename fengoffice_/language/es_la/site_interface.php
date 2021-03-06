<?php

/**
 * Dashboard interface langs
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */

// Return langs
return array(
    'new OpenGoo version available' => 'Está disponible una nueva versión de OpenGoo. <a class="internalLink" href="{0}" onclick="{1}">Más detalles</a>.',

    'my tasks' => 'Mis tareas',
    'welcome back' => 'Bienvenido <strong>{0}</strong>',

    'online users' => 'Usuarios conectados',
    'online users desc' => 'Usuarios inactivos en los pasados 15 minutos:',

  	'charts' => 'Gráficos',
    'contacts' => 'Contactos',
    'dashboard' => 'Dashboard',
    'administration' => 'Administración',
    'my account' => 'Mi cuenta',
    'my documents' => 'Mis documentos',
	'documents' => 'Documentos',
    'my projects' => 'Mis espacios',
    'my projects archive desc' => 'Listado de espacios cerrados. Todas las acciones de estos espacios han sido bloqueadas, de todas formas podra verlas.',

    'company online' => 'Compañía en línea',

    'enable javascript' => 'Habilite JavaScript en su navegador para poder usar esta caracteristica',

    'user password generate' => 'Generar contraseña aleatoria',
    'user password specify' => 'Especifique contraseña',
    'is administrator' => 'Administrador',
    'is auto assign' => '¿Auto asignar a nuevos espacios?',
    'auto assign' => 'Auto asignar',
    'administrator update profile notice' => 'Opciones de administador (sólo disponibles para administradores!)',

    'project completed on by' => 'Completado el {0} de {1}',

    'im service' => 'Servicio',
    'primary im service' => 'IM primario',
    'primary im description' => 'Todas las direciones IM ingresadas serán listadas en su página de contactos. Sólo los IM primarios seran mostrados en otras páginas.',
    'contact online' => 'Contacto conectado',
    'contact offline' => 'Contacto no conectado',

    'avatar' => 'Imagen',
    'current avatar' => 'Imagen actual',
    'current logo' => 'Logo actual',
    'new avatar' => 'Imagen nueva',
    'new logo' => 'Nuevo logo',
    'new avatar notice' => 'Advertencia: la imagen nueva reemplazará la anterior borrándola permanentemente',
    'new logo notice' => 'Advertencia: el nuevo logo reemplazará al anterior borrándolo permanentemente',

    'days late' => '{0} días de atraso',
    'days left' => 'quedan {0} días ',

    'user card of' => 'Tarjeta del contacto: {0}',
    'company card of' => 'Tarjeta de la empresa: {0}',

// Upgrade
    'upgrade is not available' => 'No hay nuevas versiones de OpenGoo',
    'check for upgrade now' => 'Verificar ahora',

// Forgot password
    'forgot password' => 'Olvidó su contraseña',
    'email me my password' => 'Enviar contraseña',

// Complete installation
    'complete installation' => 'Completar la instalación',
    'complete installation desc' => 'Éste es el paso final del proceso de instalación, el cual le permitira crear una cuenta de administrador y proveer de una breve información sobre su empresa',

// Administration
    'welcome to administration' => 'Bienvenido',
    'welcome to administration info' => 'Bienvenido al panel de administración. Esta herramienta le permitirá administrar los datos de su empresa, sus miembros, clientes y los espacios a los cuales pertenece.',

    'send new account notification' => '¿Enviar notificación vía mail?',
    'send new account notification desc' => 'Si elige "Sí", el usuario recibirá un mensaje de bienvenida, vía mail, con los datos necesarios para iniciar (incluyendo la contraseña).',

// Tools
    'administration tools' => 'Herramientas',

    'test mail recepient' => 'Destinatario de prueba de mail',
    'test mail message' => 'Mensaje de prueba',
    'test mail message subject' => 'Asunto de prueba',

    'massmailer subject' => 'Asunto',
    'massmailer message' => 'Mensaje',
    'massmailer recipients' => 'Destinatarios',

// Dashboard ESTE ESTA BIEN

	'welcome to new account' => '{0}, Bienvenido a su nueva cuenta',
	'welcome to new account info' => 'A partir de ahora podrá acceder a su cuenta desde {0} (le recomendamos agregar este vínculo a marcadores).<br/> 
									Comience a utilizar Feng Office a través de las siguientes acciones:',
    
	'new account step1 owner' => 'Paso 1: Cree el perfil de su propia Empresa',
	'new account step1 owner info' => 'Ingrese los datos de su Empresa y agregue a sus miembros como usuarios desde la opción Administración que se encuentra arriba a la derecha de la pantalla.',
	
	'new account step update account' => 'Paso {0}: Actualice su cuenta personal y cambie su contraseña ',
    'new account step update account info' => 'Le recomendamos que cambie su contraseña. Para modificar sus datos siga la opción Cuenta ubicada arriba a la derecha junto a la de Administración.',
    
    'new account step add members' => 'Paso {0}: Agregar miembros del equipo',
	'new account step add members info' => 'Puedes <a class="internalLink" href="{0}">crear cuentas de usuario</a> para los miembros de tu equipo. Cada miembro obtendrá su nombre de usuario y contraseña, que podrán utilizar para acceder al sistema',
	
	'new account step start workspace' => 'Paso {0}: Comience a organizar su información; Cree un Espacio de trabajo',
	'new account step start workspace info' => 'Espacio de trabajo es el lugar donde se guarda y organiza toda la información de su empresa. Pueden estar divididos por Clientes, Proyectos, Departamentos de la empresa o cualquier otra forma de organizar la información.
												Siga {0} en el panel izquierdo para crear un nuevo espacio de trabajo.<br/>
												Automáticamente se crea un espacio personal para cada usuario ({1}). Este espacio solo será visto por su dueño.
											',
	
	'new account step configuration' => 'Paso {0}: Configuración',
	'new account step configuration info' => '<a class="internalLink" href="{0}">Maneje</a> la configuración general de opengoo, configuración de correo, habilite/deshabilite módulos, entre otras opciones',
	
	'new account step profile' => 'Paso {0}: Actualizar perfil',
	'new account step profile info' => 'Actualice su <a class="internalLink" href="{0}">perfil de usuario</a>',
	
	'new account step preferences' => 'Paso {0}: Actualice preferencias de usuario',
	'new account step preferences info' => 'Actualice sus <a class="internalLink" href="{0}">preferencias de usuario</a> tales como preferencias generales, opciones de panel principal y tareas',
	
	'new account step actions' => 'Paso {0}: Comience a gestionar su oficina online',
	'new account step actions info' => 'Seleccione el espacio de trabajo en el que quiera comenzar a trabajar y <b>Agregue</b>:<br/>',

	'new account step1' => 'Paso 1: Cree el perfil de su propia Empresa',
	'new account step1 info' => 'Ingrese los datos de su Empresa y agregue a sus miembros como usuarios desde la opción Administración que se encuentra arriba a la derecha de la pantalla.',

	'new account step2' => 'Paso 2: Agregue miembros a su equipo',
    'new account step2 info' => 'Usted puede <a class="internalLink" href="{0}">crear nuevas cuentas de usuarios</a> para todos los miembros de su equipo. Cada miembro obtendrá un nombre de usuario y una contraseña, que utilizará para acceder al sistema',
    
    'new account step3' => 'Paso 3: Agregue empresas clientes y sus miembros',
    'new account step3 info' => 'Ahora <a class="internalLink" href="{0}">defina una empresa cliente</a>. Al finalizar puede agregar sus miembros o dejar que el encargado de ese grupo se encargue. Estos miembros son muy similares a los de su empresa, sólo que tienen acceso limitado a algunos contenidos y funciones (pueden establecerse distintos niveles de acceso a cada espacio o miembro)',
    
    'new account step4' => 'Paso 4: Crear un espacio',
    'new account step4 info' => 'Definir un <a class="internalLink" href="{0}"> nuevo espacio</a> es muy fácil: establezca un nombre y descripción (opcional) e ingrese los datos. A continuación podrá establecer los permisos de los miembros de su equipo y sus cientes.',

// Application log
    'application log details column name' => 'Detalles',
    'application log project column name' => 'Espacio',
    'application log taken on column name' => 'Adoptadado en relación con',

// RSS
    'rss feeds' => 'Alimentación RSS',
    'recent activities feed' => 'Actividades recientes',
    'recent project activities feed' => 'Actividades recientes en el espacio {0}',

// Update company permissions
    'update company permissions hint' => 'Verficiar espacio para dar permisos a esta empresa. Tenga en cuenta que también deberá establecer los permisos para aquellos miembros de la compañía que desea tengan acceso al manejo de algunos espacios (esto puede ser realizado a través de la página de usuarios en el espacio, o a través de los perfiles).',

    'footer copy with homepage' => '&copy; {0} by <a class="internalLink" href="{1}">{2}</a>. Todos los derechos reservados.',
    'footer copy without homepage' => '&copy; {0} by {1}. Todos los derechos reservados',
    'footer powered' => 'Impulsado por <a target="_blank" href="{0}">{1}</a>',

// Menu
	'all documents' => 'Todos los documentos',
	'created by me' => 'Creado por mí',
	'by project' => 'Por espacio',
	'by tag' => 'Por etiqueta',
	'by type' => 'Por tipo',
	'recent documents' => 'Documentos recientes',
	'current project' => 'Espacio actual',
	'show hide menu' => 'Mostrar/esconder menú',
	'help' => 'Ayuda',

  	'confirm leave page' => 'Si abandona o carga nuevamente la página perderá los datos no cargados.',

//Contacts
  	'add contact' => 'Agregar contacto',
  	'edit contact' => 'Editar Contacto',
    'update contact' => 'Actualizar Contacto',
  	'update picture' => 'Actualizar Imagen',
  	'delete contact' => 'Eliminar contacto',
  	'contact card of' => 'Tarjeta de contacto de',
  	'email address 2' => 'Dirección de correo 2',
  	'email address 3' => 'Dirección de correo 3',
  	'website' => 'Sitio web',
  	'notes' => 'Notas',
  	'assigned user' => 'Usuario asignado',
  	'contact information' => 'Información de contacto',
    'first name' => 'Primer nombre',
  	'last name' => 'Apellido',
  	'middle name' => 'Segundo nombre',
  	'contact title' => 'Título de contacto',
  	'work information' => 'Información de trabajo',
  	'department' => 'Departamento',
  	'job title' => 'Título',
  	'location' => 'Ubicación',
    'phone number' => 'Número de teléfono',
    'phone number 2' => 'Número de teléfono 2',
    'fax number' => 'Número de fax',
    'assistant number' => 'Número de asistente',
    'callback number' => 'Número de respuesta',
    'pager number' => 'Pager',
    'mobile number' => 'Celular',
    'personal information' => 'Informacioó personal',
    'home information' => 'Información de casa',
    'other information' => 'Otra información',

    'email and instant messaging' => 'Correo electrónico y mensajes instántaneos',
    'no contacts in project' => 'No existen contactos en este espacio',
  	'picture' => 'Imagen',
    'current picture' => 'Foto actual',
    'delete current picture' => 'Eliminar foto actual',
    'confirm delete current picture' => '¿Realmente desea eliminar la foto actual?',
    'new picture' => 'Foto nueva',
    'new picture notice' => 'Advertencia: la foto actual será eliminada y reemplazada por una nueva',

  	'assign to project' => 'Asignar al espacio',
  	'role' => 'Rol',
    'contact projects' => 'Espacios del contacto',
    'contact identifier required' => 'Los contactos deben estar definidos al menos por un nombre, o apellido',
    'birthday' => 'Fecha de Nacimiento',
    'role in project' => 'Rol en este espacio \'{0}\'',
    'all contacts' => 'Todos los contactos',
    'project contacts' => 'Contactos en {0}', 
    'select' => 'Seleccione',

// Contact import
 	'import contacts from csv' => 'Importación de contactos desde archivos .csv',
	'import' => 'Importar',
 	'file not exists' => 'El archivo seleccionado no existe',
	'field delimiter' => 'Delimitador de campos (opcional)',
	'first record contains field names' => 'El primer registro contiene los nombres de los campos',
	'import contact success' => 'Importación de contactos exitosa.',
	'contact fields' => 'Campos de contactos',
	'fields from file' => 'Campos obtenidos del archivo',
	'you must match the database fields with file fields before executing the import process' => 'Debe asegurarse de que los campos de la base de datos coincidan con los campos especificados en el archivo.',  
	'import result' => 'Resultado de la importación',
	'contacts succesfully imported' => 'Contactos importados exitosamente',
	'contacts import fail' => 'Importación fallida para los contactos',
	'contacts import fail help' => 'El proceso de importación pudo haber fallado debido a datos existentes en la base de datos, como nombre, email, etc.',
	'import fail reason' => 'Motivo del fallo',
	'select a file in order to load its data' => 'Seleccione un archivo csv para poder cargar la información del mismo.',

// Contact export
  	'export contacts to csv' => 'Exportación de contactos a archivos .csv',
	'export' => 'Exportar',
	'fields to export' => 'Datos a exportar',
	'success export contacts' => 'Los contactos se han exportado existosamente',

// Company import/export
	'import companies from csv' => 'Importación de empresas desde archivos .csv',
	'company fields' => 'Campos de empresas',
	'companies succesfully imported' => 'Empresas importadas exitosamente',
	'companies import fail' => 'Importación fallida para las empresas',
	'export companies to csv' => 'Exportación de empresas a archivos .csv',
	'success export companies' => 'Las empresas se han exportado existosamente',

//Webpages
  'add webpage' => 'Agregar enlace web',
  'delete webpage' => 'Eliminar enlace web',
  'webpages' => 'Enlaces web',
  'private webpage' => 'Enlace web privada',
  'url' => 'Url',
  'no active webpages in project' => 'No se encontraron enlaces web en este espacio',
  'webpage list description' => 'Descripción',
  'edit webpage' => 'Editar enlace web',
  'webpage' => 'Enlace web',
  'webpage title required' => 'Título requerido para la pagina web',
  'webpage url required' => 'Es necesario ingresar la URL',

//Email
  'emails' => 'Correos',
  'add mail account' => 'Agregar cuenta de correo',
  'new mail account' => 'Nueva cuenta de correo',
  'no emails in this account' => 'No hay correos en esta cuenta',
  'server address' => 'Dirección del servidor',
  'mail account id' => 'Identificación de cuenta',
  'mail account name' => 'Nombre de la cuenta',
  'is imap' => 'Ésta es una cuenta IMAP',
  'incoming ssl' => 'Use SSL para conexiones de correo entrantes',
  'incoming ssl port' => 'Puerto SSL',
  'edit mail account' => 'Editar cuenta de correo',
  'delete mail account' => 'Eliminar cuenta de correo',
  'subject' => 'Asunto',
  'email' => 'Ver correo',
  'from' => 'De',
  'to' => 'Para',
  'date' => 'Fecha',
  'delete email' => 'Eliminar correo',
  'email message' => 'Correo',
  'imap' => 'IMAP',
  'pop3' => 'POP3',
  'email connection method' => 'Modo de conexión',
  'classify' => 'Clasificar',
  'classify email' => 'Clasificar correo',
  'classify email subject' => 'Clasificar correo: \'{0}\'',
  'unclassify' => 'Desclasificar',
  'add attachments to project' => 'Agregar un adjunto al espacio',
  'project emails' => '{0} correos',
  'edit email account' => 'Editar {0}',
  'no emails in this project' => 'No hay correos en este espacio',
  'mail content' => 'Correo',
  'mail account name description' => 'El nombre usado para identificar esta cuenta (ej. \'Cuenta personal\')',
  'mail account id description' => 'El nombre de usuario de la cuenta o identificación usada para conectarse al servidor (ej. \'juan@servidor.com\')',
  'mail account password description' => 'La contraseña requerida para conectarse a la cuenta',
  'mail account server description' => 'La dirección del serivdor de correo (ej. \'pop3.servidor.com\')',
  'folders to check' => 'Carpetas a verificar',
  'after' => 'luego de',
  'delete mails from server' => 'Eliminar correos del serviror',
  'mail account delete mails from server description' => 'Habilite esta opción para que los correos sean eliminados del servidor luego de cierto tiempo.',

//Checkout
  'checkout file' => 'Bloquear archivo',
  'checkin file' => 'Actualizar archivo',

  'new filename' => 'Nuevo nombre de archivo',
  'new weblink' => 'Nuevo enlace web',
  'add as revision' => 'Agregar como revision',
  'duplicate filename' => 'Duplicar nombre de archivo',
  'filename exists' => 'Ya existen archivos bajo ese nombre. Puede cambiar el nombre, o elegir entre las siguientes opciones',
  'filename exists edit' => 'Ya existe un archivo con ese nombre. Por favor, eliga un nuevo nombre.',
  'checking filename' => 'Verificando disponibilidad...',
  'check' => 'Verificar',
  'add file check in' => 'Actualizar como una nueva versión del archivo',
  'filters' => 'Filtros',

  'permissions for user' => 'Permisos para el usuario {0}',
  'can read messages' => 'Puede leer notas',
  'can write messages' => 'Puede escribir notas',
  'can read tasks' => 'Puede leer tareas',
  'can write tasks' => 'Puede escribir tareas',
  'can read milestones' => 'Puede leer hitos',
  'can write milestones' => 'Puede escribir hitos',
  'can read mails' => 'Puede leer correos',
  'can write mails' => 'Puede escribir correos',
  'can read comments' => 'Puede leer comentarios',
  'can write comments' => 'Puede escribir comentarios',
  'can read contacts' => 'Puede leer contactos',
  'can write contacts' => 'Puede escribir contactos',
  'can read weblinks' => 'Puede leer enlaces web',
  'can write weblinks' => 'Puede incorporar enlaces web',
  'can read files' => 'Puede leer archivos',
  'can write files' => 'Puede escribir archivos',
  'can read events' => 'Puede leer eventos',
  'can write events' => 'Puede escribir eventos',

  'new mail account' => 'Nueva cuenta de correo',
  'new company' => 'Nueva empresa',
  'add a new company' => 'Agregar una nueva empresa',
  'new workspace' => 'Nuevo espacio',
  'new task list' => 'Nueva tarea',
  'new event' => 'Nuevo evento',
  'new webpage' => 'Nueva pagina web',
  'new milestone' => 'Nuevo hito',
  'new message' => 'Nueva nota',
  'new group' => 'Grupo nuevo',
  'new user' => 'Usuario nuevo',
  'add tags' => 'Agregar etiquetas',
  'save changes' => 'Guardar cambios',
  'administrator options' => 'Opciones de Administrador',

  'system permissions' => 'Permisos del sistema',
  'project permissions' => 'Permisos del espacio',


/* Search */

  'actions' => 'Acciones',
  'edit properties' => 'Editar propiedades',
  'you' => 'Usted',
  'created by' => 'Creado por',
  'modified by' => 'Modificado por',
  'user date' => '<a class="internalLink" href="{0}" title="Ver perfil de {3}">{1}</a>, el {2}',
  'user date today at' => '<a class="internalLink" href="{0}" title="Ver perfil de {3}">{1}</a>, hoy a las {2}',
  'today at' => 'Hoy, a las {0}',
  'created by on' => 'Creado por <a class="internalLink" href="{0}">{1}</a> el {2}',
  'modified by on' => 'Modificado por <a class="internalLink" href="{0}">{1}</a> el {2}',
  'modified by on short' => '<a class="internalLink" href="{0}">{1}</a>, {2}',
  'created by on short' => '<a class="internalLink" href="{0}">{1}</a>, {2}',
  'time used in search' => 'La busqueda fue realizada en {0} segundos',
  'more results' => 'Hay otros {0} resultados...',


  'parent workspace' => 'Espacio padre',
  'close' => 'Cerrar',
  'all projects' => 'Todos los espacios',
  'view as list' => 'Ver como lista',
  'pending tasks' => 'Tareas pendientes',
  'my pending tasks' => 'Mis tareas pendientes',
  'messages' => 'Notas',
  'complete' => 'Completo',
  'incomplete' => 'Incompleto',
  'complete task' => 'Completar tarea',
  'complete milestone' => 'Completar hito',
  'subtask count all open' => '{0} subtareas, {1} aún abiertas',
  'due in x days' => 'Vence en {0} días',
  'overdue by x days' => 'Sobrepaso el límite {0} días',
  'due today' => 'A entregar hoy',

  'x years' => '{0} años',
  'x months' => '{0} meses',
  'x weeks' => '{0} semanas',
  'x days' => '{0} días',
  'x hours' => '{0} horas',
  'x minutes' => '{0} minutos',
  'x seconds' => '{0} segundos',
  '1 year' => '1 año',
  '1 month' => '1 mes',
  '1 week' => '1 semana',
  '1 day' => '1 día',
  '1 hour' => '1 hora',
  '1 minute' => '1 minuto',
  '1 second' => '1 segundo',

  'x ago' => 'pasados {0}',

  'object time slots' => 'Registro de tiempo de trabajo',
  'start work' => 'Comenzar trabajo',
  'end work' => 'Finalizar trabajo',
  'confirm delete timeslot' => '¿Está seguro de que desea eliminar este tiempo de trabajo?',
  'confirm cancel timeslot' => '¿Está seguro de que desea cancelar el actual tiempo de trabajo?',
  'success open timeslot' => 'Tiempo de trabajo abierto de forma satisfactoria',
  'success close timeslot' => 'Tiempo de trabajo cerrado de forma satisfactoria',
  'success cancel timeslot' => 'Tiempo de trabajo cancelado de forma satisfactoria',
  'success delete timeslot' => 'Tiempo de trabajo eliminado de forma satisfactoria',
  'success edit timeslot' => 'Tiempo de trabajo editado de forma satisfactoria',
  'open timeslot message' => 'Tiempo de trabajo realizado:',
  'success pause timeslot' => 'Tiempo de trabajo pausado de forma satisfactoria',
  'success resume timeslot' => 'Tiempo de trabajo retomado de forma satisfactoria',
  'paused timeslot message' => 'Tiempo de trabajo pausado, tiempo total: {0}',
  'time since pause' => 'Tiempo desde la pausa',
  'pause work' => 'Pausar',
  'resume work' => 'Retomar',
  'end work description' => 'Finalizar con la descripción del trabajo',
  'add timeslot' => 'Añadir tiempo de trabajo',
  'edit timeslot' => 'Editar tiempo de trabajo',
  'start date' => 'Fecha de comienzo',
  'start time' => 'Hora de comienzo',
  'end date' => 'Fecha de fin',
  'end time' => 'Hora de fin',

  'tasks in progress' => 'Tareas en progreso',
  'upcoming events milestones and tasks' => 'Próximos eventos, hitos y tareas',

  'undo checkout' => 'Deshacer bloqueo de archivo',

  'search for in project' => 'Buscar resultados para \'<i>{0}</i>\' en el espacio \'{1}\'',
  'search for' => 'Buscar resultados para \'{0}\' en todos los espacios',

  'workspace permamanent delete' =>  'Cuando un espacio es eliminado, la siguiente información es perdida de forma permanente</b>',
	'workspace permamanent delete messages'  => ' Todas las notas en el espacio',
 'workspace permamanent delete tasks' => ' Todas las tareas en el espacio',
 'workspace permamanent delete milestones' => ' Todos los hitos en el espacio',
 'workspace permamanent delete files' => ' Todos los archivos en el espacio',
 'workspace permamanent delete logs' => ' Todos los registros relacionados con el espacio',
 'workspace permamanent delete mails' => ' Todos los correos serán desasociados de este espacio, pero permanecerán en el sistema.',
  'sub-workspaces permament delete' => '<b>{0} sub espacio(s)</b> de {1} también serán eliminados, con todo su contenido.',
  'multiples workspace object permanent delete' => 'Aquellos objetos contenidos en más de un espacio no seran eliminados.',
  'cancel permanent delete' => 'Para cancelar la eliminacion presione "Volver", o cierre esta ventana.',
  'confirm permanent delete workspace' => 'Por favor, confirme su deseo de eliminar el espacio <b>{0}</b>',

  'latest user activity' => 'Última actividad del usuario',

  'hours' => 'Horas',
  'minutes' => 'Minutos',
  'seconds' => 'Segundos',
  'days' => 'Días',
  'time estimate' => 'Estimativo de tiempo',
  'work in progress' => 'Trabajo en progreso',
  'total time' => 'Tiempo total',

  'upload anyway' => 'Subir de todas formas',

  'print view' => 'Vista de impresión',
  'activity' => 'Actividad',
  'statistics' => 'Estadísticas',
  'time' => 'Tiempo',
  'task time report' => 'Tiempo total de ejecución',
  'new tasks by user' => 'Nuevas tareas por usuario',
  'generate report' => 'Generar reporte',
  'task title' => 'Título de la tarea',
  'total time' => 'Tiempo total',
  'include subworkspaces' => 'Incluir sub-espacios',
  'print' => 'Imprimir',
  'this week' => 'Esta semana',
  'last week' => 'Semana pasada',
  'this month' => 'Este mes',
  'last month' => 'Mes pasado',
  'select dates...' => 'Elegir fechas...',

  'task time report description' => 'Este reporte realiza un resumen del tiempo trabajado por tareas. Se especifica un rango de fechas, usuario (opcional) y espacio de trabajo.',
  'no data to display' => 'No hay datos para desplegar',

  'new company name' => 'Nombre de la nueva empresa',
  'checking' => 'Verificando',
  'country' => 'Pais',

  'email addresses' => 'Correo electrónico',
  'instant messaging' => 'Mensajería instantánea',
  'phone' => 'Tel.',
  'phone 2' => 'Tel. 2',
  'fax' => 'Fax',
  'assistant' => 'Asistente',
  'callback' => 'Callback',
  'mobile' => 'Celular',
  'pager' => 'Pager',

  'roles' => 'Roles',  
  'last updated by on' => '{0}, en {1}',
  'updated' => 'Actualizado',
  'group by' => 'Agrupar por',


  'enter tags desc' => 'Ingrese etiquetas separadas por coma ...',

  'user subscribed to object' => 'Está suscripto a este objeto.',
  'user not subscribed to object' => 'No está suscripto a este objeto.',

  'tasks updated' => 'Tareas(s) actualizadas exitosamente',
  'show image in new page' => 'Mostrar imagen en nueva página',
  'no tasks to display' => 'No hay tareas para mostrar',
  'total' => 'Total',
  'too many tasks to display' => 'Hay demasiadas tareas para mostrar, se despliegan las 500 tareas más recientes. Para mostrar las tareas y ocultar esta advertencia, por favor filtre las tareas por espacio, tag, estado o filtro.',
  'success create timeslot' => 'Tiempo de trabajo creado en forma satisfactoria',
  'do complete' => 'Completar',

  'task data' => 'Datos de tarea',
  'search in all workspaces' => 'Buscar en todos los espacios',

  'total pause time' => 'Tiempo total pausado',
  'pause time cannot be negative' => 'El tiempo de pausa no puede ser negativo',
  'pause time cannot exceed timeslot time' => 'El tiempo de pausa no puede exceder el tiempo total de trabajo',
  'timeslots' => 'Tiempos de trabajo',

  'task timeslots' => 'Tiempos de trabajo de tareas',
  'time timeslots' => 'Tiempos de trabajo generales',
  'all timeslots' => 'Todos los tiempos de trabajo',

  'print report' => 'Imprimir reporte',

  'all active tasks' => 'Todas las tareas activas',

  'unique id' => 'Id único',

  'my pending tasks' => 'Mis tareas pendientes',
  'pending tasks for' => 'Tareas pendientes de {0}',
  'my late milestones and tasks' => 'Mis hitos y tareas atrasadas',
  'late milestones and tasks for' => 'Hitos y tareas atrasadas de {0}',
  'my tasks in progress' => 'Mis tareas activas',
  'tasks in progress for' => 'Tareas activas de {0}',

  'edit picture' => 'Editar imágen',
  'deleted by' => 'Eliminado por',

  'time has to be greater than 0' => 'El tiempo tiene que ser mayor que 0',

  'release notes' => 'Notas de la versión',
  'remember last' => 'Recordar último',
  'auto' => 'Auto',
  'print all groups' => 'Imprimir todos los grupos',
  'shared with' => 'Compartido con',

  'share object desc' => 'Se enviará un correo invitando a cada persona.',
  'share with' => 'Compartir con',
  'allow people edit object' => 'Permitir editar el objeto',
  'must specify recipients' => 'Debe especificar al menos una dirección de correo',
  'share' => 'Compartir',
  'share this' => 'Compartir este',
  'success sharing object' => 'Objeto compartido exitosamente',
  'actually sharing with' => 'Ya está siendo compartido con',
  'share notification message desc' => '{1} lo ha invitado a ver/editar esta nota: {0}',
  'share notification event desc' => '{1} lo ha invitado a ver/editar este evento: {0}',
  'share notification task desc' => '{1} lo ha invitado a ver/editar esta tarea: {0}',
  'share notification document desc' => '{1} lo ha invitado a ver/editar este documento: {0}',
  'share notification contact desc' => '{1} lo ha invitado a ver/editar este contacto: {0}',
  'share notification company desc' => '{1} lo ha invitado a ver/editar esta empresa: {0}',
  'share notification emailunclassified desc' => '{1} lo ha invitado a ver/editar este correo: {0}',
  'share notification email desc' => '{1} lo ha invitado a ver/editar este correo: {0}',
  'new share notification message' => 'Nota \'{0}\' ha sido compartida',
  'new share notification event' => 'Evento \'{0}\' ha sido compartido',
  'new share notification task' => 'Tarea \'{0}\' ha sido compartida',
  'new share notification document' => 'Documento \'{0}\' ha sido compartido',
  'new share notification contact' => 'Contacto \'{0}\' ha sido compartido',
  'new share notification company' => 'Empresa \'{0}\' ha sido compartida',
  'new share notification emailunclassified' => 'Correo \'{0}\' ha sido compartido',
  'new share notification email' => 'Correo \'{0}\' ha sido compartido',

  'billing' => 'Facturacion',
  'category' => 'Categoría',
  'hourly rates' => 'Tarifas horarias',
  'origin' => 'Origen',
  'default hourly rates' => 'Tarifa horaria por defecto',
  'add billing category' => 'Agregar categoría de facturación',
  'new billing category' => 'Nueva categoría de facturación',
  'edit billing category' => 'Editar categoría de facturación',
  'report name' => 'Nombre a desplegar en reportes',
  'billing categories' => 'Categorías de facturación',
  'billing category' => 'Categoría de facturación',
  'select billing category' => '-- Seleccionar categoría de facturación --',
  'billing amount' => 'Monto',
  'hourly billing' => 'Facturación por hora',
  'fixed billing' => 'Facturación fija',
  'show billing information' => 'Mostrar información de facturación',
  'no billing categories' => 'No hay categorías de facturación.',
  'no billing categories desc' => 'Si desea habilitar el soporte para facturación basado en tiempos de trabajo, por favor ingrese una nueva categoría de facturación.',
  'billing support is enabled' => 'El soporte para facturación se encuentra habilitado',
  'BillingCategory default_value required' => 'Se necesita una tarifa horaria por defecto',
  'defined in a parent workspace' => 'Definido en un espacio anterior',
  'defined in the current workspace' => 'Definido en el espacio actual',
  'total billing by user' => 'Facturación total por usuario',
  'assign billing categories to users' => 'Asignar categorías de facturación a los usuarios',

  'new share notification file' => 'El archivo \'{0}\' ha sido compartido.',
  'new share notification milestone' => 'El hito \'{0}\' ha sido compartido.',
  'new share notification weblink' => 'El enlace web \'{0}\' ha sido compartido.',
  'new version notification title' => 'Nueva versión',
  'share notification file desc' => '{1} lo invitó a ver/editar este archivo: {0}',
  'share notification milestone desc' => '{1} lo invitó a ver/editar este hito: {0}',
  'share notification weblink desc' => '{1} lo invitó a ver/editar este enlace web: {0}',

  	'new share notification file' => 'El archivo \'{0}\' ha sido compartido.',
  	'new share notification milestone' => 'El hito \'{0}\' ha sido compartido.',
	'new share notification weblink' => 'El enlace web \'{0}\' ha sido compartido.',
	'new version notification title' => 'Nueva versión',
	

	'getting started' => 'Comenzando',
	'checked out by' => 'Bloqueado por',
	'workspace contacts' => 'Contactos',
	'search contact' => 'Buscar contacto',
	'add new contact' => 'Agregar nuevo contacto',
	'no contacts to display' => 'No hay contactos',
	'workspace info' => 'Información de área de trabajo',
	'workspace description' => 'Descripción de área de trabajo para \'{0}\'',
	'show all amount' => 'Mostrar todos ({0})',
	'searching' => 'Buscando',
	'weblink' => 'Enlace web',
	'add value' => 'Agregar valor',
	'remove value' => 'Quitar valor',

); // array

?>