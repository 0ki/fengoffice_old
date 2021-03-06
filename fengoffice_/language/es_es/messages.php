<?php

  /**
  * Array of messages file (error, success message, status...)
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */

  return array(
  
    // Empty, dnx et
    'no mail accounts set' => 'No existen cuentas de correo electrónico.  Por favor, cree una primero',
    'no mail accounts set for check' => 'No existen cuentas de correo electrónico para comprobar. Por favor, cree una primero',
    'email dnx' => 'Dirección de correo electrónico no existe',
  	'email dnx deleted' => 'El correo electrónico que solicitó fue eliminado de la base de datos',
    'project dnx' => 'El área de trabajo solicitada no existe en la base de datos',
    'contact dnx' => 'El contacto solicitado no existe en la base de datos',
    'company dnx' => 'La empresa solicitada no existe en la base de datos',
    'message dnx' => 'La nota solicitada no existe en la base de datos',
    'no comments in message' => 'Esta nota no tiene comentarios',
    'no comments associated with object' => 'No se han introducido comentarios para este objeto',
    'no messages in project' => 'No hay notas en esta área de trabajo',
    'no subscribers' => 'No hay usuarios suscritos a este objeto',
    'no activities in project' => 'No hay actividades en esta área de trabajo',
    'comment dnx' => 'El comentario requerido no existe',
    'milestone dnx' => 'El hito solicitado no existe',
    'task list dnx' => 'La tarea solicitada no existe',
    'task dnx' => 'La tarea solicitada no existe',
    'event type dnx' => 'El evento solicitado no existe',
    'no milestones in project' => 'No hay hitos en esta área de trabajo',
    'no active milestones in project' => 'No hay hitos activos en esta área de trabajo',
    'empty milestone' => 'El hito esta vacío. Es posible añadir una <a class="internalLink" href="{1}">tarea</a> al hito cuando así lo desee',
    'no logs for project' => 'No existen entradas relacionadas con esta área de trabajo',
    'no recent activities' => 'No se han introducido nuevas actividades en la base de datos',
    'no open task lists in project' => 'esta área de trabajo no tiene tareas abiertas',
    'no completed task lists in project' => 'No hay tareas completadas en esta área de trabajo',
    'no open task in task list' => 'No hay tareas abiertas en la lista',
    'no closed task in task list' => 'No hay tareas cerradas en la lista',
    'no open task in milestone' => 'No hay tareas abiertas en el hito',
    'no closed task in milestone' => 'No hay tareas cerradas en el hito',
    'no projects in db' => 'No se han definido áreas de trabajo en la base de datos',
    'no projects owned by company' => 'La empresa no tiene un área de trabajo asignada',
    'no projects started' => 'No hay áreas de trabajos iniciadas',
    'no active projects in db' => 'No hay áreas de trabajos activas',
    'no new objects in project since last visit' => 'No hay nuevos objetos en su área de trabajo desde su última visita',
    'no clients in company' => 'Su empresa aun no ha registrado clientes',
    'no users in company' => 'No existen usuarios de esta empresa',
    'client dnx' => 'El cliente seleccionado no existe',
    'company dnx' => 'La empresa seleccionada no existe',
    'user dnx' => 'El usuario solicitado no existe en la base de datos',
    'avatar dnx' => 'Imagen inexistente',
    'no current avatar' => 'Imagen no cargada',
    'picture dnx' => 'Foto inexistente',
    'no current picture' => 'Foto no cargada',
    'no current logo' => 'Logo no cargado',
    'user not on project' => 'El usuario seleccionado no esta realacionado con el área de trabajo seleccionada',
    'company not on project' => 'La empresa seleccionada no esta relacionada con el área de trabajo seleccionada',
    'user cant be removed from project' => 'El usuario seleccionado (no) puede ser eliminado del área de trabajo',
    'tag dnx' => 'Etiqueta seleccionada no existente',
    'no tags used on projects' => 'No se usaron etiquetas en las áreas de trabajo',
    'no forms in project' => 'No se han ingresado formularios en esta área de trabajo',
    'project form dnx' => 'El formulario seleccionado no existe en la base de datos',
    'related project form object dnx' => 'El formulario no existe en la base de datos',
    'no my tasks' => 'No hay tareas asignadas',
    'no search result for' => 'No hay objetos que coinciden con "<strong>{0}</strong>"',
    'no files on the page' => 'No hay archivos en esta página',
    'folder dnx' => 'La carpeta seleccionada no existe en la base de datos',
    'define project folders' => 'No hay carpetas en el área de trabajo. Por favor, defina una para poder continuar',
    'file dnx' => 'El archivo seleccionado no existe en la base de datos',
    'not s5 presentation' => 'No se puede iniciar la presentación ya que el archivo no es una presentación slimey',
    'file not selected' => 'No ha seleccionado ningún archivo',
    'file revision dnx' => 'La revisión requerida no existe',
    'no file revisions in file' => 'Archivo no valido - no hay revisiones asociadas a este archivo',
    'cant delete only revision' => 'No puede eliminar esta revisión. Cada archivo debe tener, al menos, una revisión',
    'config category dnx' => 'La configuración de la categoría que seleccionó no existe',
    'config category is empty' => 'La configuración de la categoría no fue introducida',
    'email address not in use' => '%s no está siendo usada',
    'no linked objects' => 'No hay objetos vinculados con este objeto',
    'object not linked to object' => 'No existen vínculos entre los objetos seleccionados',
    'no objects to link' => 'Por favor, seleccione los objetos que deben vincularse',
    'no administration tools' => 'No se han registrado herramientas de administración en la base de datos',
    'administration tool dnx' => 'La herramienta de administración "{0}" no existe',
    
    // Success
    'success add contact' => 'El contacto \'{0}\' ha sido creado satisfactoriamente',
    'success edit contact' => 'El contacto \'{0}\' ha sido editado satisfactoriamente',
    'success delete contact' => 'El contacto \'{0}\' ha sido eliminado satisfactoriamente',
    'success edit picture' => 'Foto se ha cargado satisfactoriamente',
    'success delete picture' => 'Foto eliminada satisfactoriamente',
    
    'success add project' => 'El área de trabajo {0} ha sido añadida satisfactoriamente',
    'success edit project' => 'El área de trabajo {0} ha sido editada satisfactoriamente',
    'success delete project' => 'El área de trabajo {0} ha sido eliminada satisfactoriamente',
    'success complete project' => 'El área de trabajo {0} ha sido completada satisfactoriamente',
    'success open project' => 'El área de trabajo {0} ha sido reabierta satisfactoriamente',
    
    'success add milestone' => 'El hito \'{0}\' ha sido creado satisfactoriamente',
    'success edit milestone' => 'El hito \'{0}\' ha sido editado satisfactoriamente',
    'success deleted milestone' => 'El hito \'{0}\' ha sido eliminado satisfactoriamente',
    
    'success add message' => 'La nota {0} ha sido añadido satisfactoriamente',
    'success edit message' => 'La nota {0} ha sido editado satisfactoriamente',
    'success deleted message' => 'La nota \'{0}\' y todos sus comentarios fueron eliminados de forma existosa',
    
    'success add comment' => 'El comentario ha sido añadido satisfactoriamente',
    'success edit comment' => 'El comentario ha sido editado satisfactoriamente',
    'success delete comment' => 'El comentario ha sido eliminado satisfactoriamente',
    
    'success add task list' => 'La tarea \'{0}\' ha sido añadida satisfactoriamente',
    'success edit task list' => 'La tarea \'{0}\' ha sido editada satisfactoriamente',
    'success delete task list' => 'La tarea \'{0}\' ha sido eliminada satisfactoriamente',
    
    'success add task' => 'La tarea seleccionada ha sido añadida satisfactoriamente',
    'success edit task' => 'La tarea seleccionada ha sido editada satisfactoriamente',
    'success delete task' => 'La tarea seleccionada ha sido eliminada satisfactoriamente',
    'success complete task' => 'La tarea seleccionada ha sido completada satisfactoriamente',
    'success open task' => 'La tarea seleccionada ha sido reabierta satisfactoriamente',
    'success n tasks updated' => '{0} tareas editadas satisfactoriamente',
	'success add mail' => 'Correo electrónico enviado satisfactoriamente',
    
    'success add client' => 'El cliente {0} ha sido añadido satisfactoriamente',
    'success edit client' => 'El cliente {0} ha sido editado satisfactoriamente',
    'success delete client' => 'El cliente {0} ha sido eliminado satisfactoriamente',
    
    'success add group' => 'El grupo {0} ha sido añadido satisfactoriamente',
    'success edit group' => 'El grupo {0} ha sido añadido satisfactoriamente',
    'success delete group' => 'El grupo {0} ha sido añadido satisfactoriamente',
    
    'success edit company' => 'Datos de la empresa modificados y guardados satisfactoriamente',
    'success edit company logo' => 'El logo de la empresa ha sido modificado satisfactoriamente',
    'success delete company logo' => 'El logo de la empresa ha sido eliminado satisfactoriamente',
    
    'success add user' => 'El usuario {0} ha sido añadido satisfactoriamente',
    'success edit user' => 'El usuario {0} ha sido editado satisfactoriamente',
    'success delete user' => 'El usuario {0} ha sido eliminado satisfactoriamente',
    
    'success update project permissions' => 'Permisos del área de trabajo modificados satisfactoriamente',
    'success remove user from project' => 'Usuario eliminado del área de trabajo satisfactoriamente',
    'success remove company from project' => 'Empresa eliminada del área de trabajo satisfactoriamente',
    
    'success update profile' => 'Nuevo perfil guardado satisfactoriamente',
    'success edit avatar' => 'Nueva imagen guardada satisfactoriamente',
    'success delete avatar' => 'Imagen eliminada satisfactoriamente',
    
    'success hide welcome info' => 'Campo de información de bienvenida ocultado satisfactoriamente',
    
    'success complete milestone' => 'Hito \'{0}\' completado',
    'success open milestone' => 'Hito \'{0}\' reabierto',
    
    'success subscribe to object' => 'Suscripción al objeto satifactoria',
    'success unsubscribe to object' => 'Suscripción al objeto ha quedado sin efecto',
    
    'success add project form' => 'Formulario \'{0}\' añadido',
    'success edit project form' => 'Formulario \'{0}\' modificado',
    'success delete project form' => 'Formlario \'{0}\' eliminado',
    
    'success add folder' => 'Carpeta \'{0}\' añadido',
    'success edit folder' => 'Carpeta \'{0}\' modificado',
    'success delete folder' => 'Carpeta \'{0}\' eliminado',
    
    'success add file' => 'Archivo \'{0}\' añadido',
	'success save file' => 'Archivo \'{0}\' guardado',
    'success edit file' => 'Archivo \'{0}\' modificado',
    'success delete file' => 'Archivo \'{0}\' eliminado',
    'success delete files' => '{0} archivo(s) eliminado(s)',
    'success tag files' => '{0} archivos(s) etiquetado(s)',
    'success tag contacts' => '{0} contacto(s) etiquetado(s)',
    
    'success add handis' => 'Entregables añadidos',
    
    'success add properties' => 'Propiedades añadidas',
    
    'success edit file revision' => 'Revisiones editadas',
    'success delete file revision' => 'Revision de archivo eliminados',
    
    'success link objects' => '%s objecto(s) vinculados',
    'success unlink object' => 'Este objeto dejó de estar vinculado',
    
    'success update config category' => '{0} valores de configuración modificados y guardados',
    'success forgot password' => 'Su contraseña fue enviada a su correo electrónico',
    
    'success test mail settings' => 'Correo de prueba enviado satisfactoriamente',
    'success massmail' => 'Correo enviado',
    
    'success update company permissions' => 'Permisos de la empresa modificados satisfactoriamente. {0} registros modificados',
    'success user permissions updated' => 'Permisos de usuarios modificados',
  
    'success add event' => 'Evento añadido',
    'success edit event' => 'Evento editado',
    'success delete event' => 'Evento eliminado',
    
    'success add event type' => 'Nuevo tipo de evento añadido',
    'success delete event type' => 'Tipo de evento eliminado',
    
    'success add webpage' => 'Enlace web añadido',
    'success edit webpage' => 'Enlace web modificado',
    'success deleted webpage' => 'Enlace web eliminado',
    
    'success add chart' => 'Tabla añadida',
    'success edit chart' => 'Tabla editada',
    'success delete chart' => 'Tabla eliminada',
    'success delete charts' => 'Las tablas seleccionadas fueron eliminadas',
  
    'success delete contacts' => 'Contactos eliminados',
  
    'success classify email' => 'Correo clasificado',
    'success delete email' => 'Correo eliminado',
  
    'success delete mail account' => 'Cuenta de correo electrónico eliminada satisfactoriamente',
    'success add mail account' => 'Cuenta de correo electrónico creada satisfactoriamente',
    'success edit mail account' => 'Cuenta de correo electrónico modificada y guardada satisfactoriamente',
  
    'success link object' => 'Objeto vinculado satisfactoriamente',
  
  	'success check mail' => 'Correo electrónico recibido satisfactoriamente: {0} correos recibidos.',
  
	'success delete objects' => '{0} Objecto(s) eliminados satisfactoriamente',
	'success tag objects' => '{0} Objecto(s) etiquetados satisfactoriamente',
	'error delete objects' => 'No fue posible eliminar {0} objecto(s)',
	'error tag objects' => 'No fue posible etiquetar {0} objecto(s)',
	'success move objects' => '{0} Objecto(s) tranferidos satisfactoriamente',
	'error move objects' => 'No fue posible transferir {0} objecto(s)',
  
    'success checkout file' => 'Archivo bloqueado para edición satisfactoriamente',
    'success checkin file' => 'Archivo devuelto satisfactoriamente',
  	'success undo checkout file' => 'Bloqueo para edición del archivo cancelado satisfactoriamente',
	'success extracting files' => '{0} Archivos fueron extraidos',
	'success compressing files' => 'Archivos comprimidos satisfactoriamente',
      
    // Failures
    'error checkin file' => 'Ha ocurrido un error al devolver el archivo',
    'error edit timeslot' => 'Ha ocurrido un error al guardar el tiempo de trabajo',
  	'error delete timeslot' => 'Ha ocurrido un error al eliminar el tiempo de trabajo',
  	'error add timeslot' => 'Ha ocurrido un error al añadir el tiempo de trabajo',
  	'error open timeslot' => 'Ha ocurrido un error al abrir el tiempo de trabajo',
  	'error close timeslot' => 'Ha ocurrido un error al cerrar el tiempo de trabajo',
    'error start time after end time' => 'No se pudo guardar horario: el horario de comienzo debe ocurrir antes del horario de finalización',
    'error form validation' => 'Ha ocurrido un error al guardar el ojecto debido a que sus propiedades no son válidas',
    'error delete owner company' => 'El dueño de la empresa no puede ser eliminado',
    'error delete message' => 'Ha ocurrido un error al eliminar la nota seleccionada',
    'error update message options' => 'Ocurrió un error mientras se ponían al día las opciones de la nota',
    'error delete comment' => 'Ha ocurrido un error al eliminar el comentario seleccionado',
    'error delete milestone' => 'Ha ocurrido un error al eliminar el hito seleccionado',
    'error complete task' => 'Ocurrió un error mientras se completaba la tarea',
    'error open task' => 'Ha ocurrido un error al reabrir tarea',
    'error upload file' => 'Ha ocurrido un error al subir el archivo',
    'error delete project' => 'Ha ocurrido un error al eliminar el área de trabajo seleccionada',
    'error complete project' => 'Ha ocurrido un error al completar el área de trabajo deseada',
    'error open project' => 'Ha ocurrido un error al reabrir el área de trabajo seleccionada',
    'error delete client' => 'Ha ocurrido un error al eliminar el cliente de la empresa seleccionado',
    'error delete group' => 'Ha ocurrido un error al eliminar el grupo seleccionado',
    'error delete user' => 'Ha ocurrido un error al eliminar el usuario seleccionado',
    'error update project permissions' => 'Ocurrió un error mientras se ponían al día los permisos del área de trabajo',
    'error remove user from project' => 'Ha ocurrido un error al eliminar usuario del área de trabajo',
    'error remove company from project' => 'Ha ocurrido un error al eliminar empresa del área de trabajo',
    'error edit avatar' => 'Ha ocurrido un error al editar la imagen',
    'error delete avatar' => 'Ha ocurrido un error al eliminar la imagen',
    'error edit picture' => 'Ha ocurrido un error al editar la foto',
    'error delete picture' => 'Ha ocurrido un error al eliminar la foto',
    'error edit contact' => 'Ha ocurrido un error al editar contacto',
    'error delete contact' => 'Ha ocurrido un error al eliminar contacto',
    'error hide welcome info' => 'Ha ocurrido un error al ocultar la información de bienvenida',
    'error complete milestone' => 'Ha ocurrido un error al completar el hito seleccionado',
    'error open milestone' => 'Ha ocurrido un error al abrir el hito seleccionado',
    'error file download' => 'Ha ocurrido un error al descargar el archivo',
    'error link object' => 'Ha ocurrido un error al crear un vínculo a este objeto',
    'error edit company logo' => 'Ha ocurrido un error al editar el logo de la empresa',
    'error delete company logo' => 'Ha ocurrido un error al eliminar el logo de la empresa',
    'error subscribe to object' => 'Ha ocurrido un error al suscribirse al objeto seleccionado',
    'error unsubscribe to object' => 'Ha ocurrido un error al intentar dejar sin efecto la suscripción al objeto seleccionado',
    'error add project form' => 'Ha ocurrido un error al añadir el formulario del área de trabajo',
    'error submit project form' => 'Ha ocurrido un error al ingresar el formulario del área de trabajo',
    'error delete folder' => 'Ha ocurrido un error al eliminar la carpeta seleccionada',
    'error delete file' => 'Ha ocurrido un error al eliminar el archivo',
    'error delete files' => 'Ha ocurrido un error al eliminar {0} archivos',
    'error tag files' => 'Ha ocurrido un error al etiquetar {0} contactos',
    'error tag contacts' => 'Ha ocurrido un error al etiquetar {0} contactos',
    'error delete file revision' => 'Ha ocurrido un error al eliminar la revisión de archivos',
    'error delete task list' => 'Ha ocurrido un error al eliminar las tareas',
    'error delete task' => 'Ha ocurrido un error al eliminar la tarea',
    'error check for upgrade' => 'El sistema falló al buscar una nueva versión',
    'error link object' => 'No se pudo vincular objeto(s)',
    'error unlink object' => 'No se pudo romper el vínculo entre objeto(s)',
    'error link objects max controls' => 'No se pueden añadir más vínculos. El máximo es %s',
    'error test mail settings' => 'No se pudo enviar mensaje de texto',
    'error massmail' => 'No se pudo enviar correo',
    'error owner company has all permissions' => 'El dueño de la empresa tiene todos los permisos',
    'error while saving' => 'Ha ocurrido un error al guardar',
    'error delete event type' =>'El programa falló al tratar de eliminar este tipo de eventos',
    'error delete mail' => 'Ha ocurrido un error al eliminar este correo',
    'error delete mail account' => 'Ha ocurrido un error al eliminar esta cuenta de correo',
    'error delete contacts' => 'Ha ocurrido un error al eliminar estos contactos',
  	'error check mail' => 'En la cuenta \'{0}\' se encontraron : {1} errores',
  	'error check out file' => 'Error al bloquear el archivo para uso exclusivo',
    'error classifying attachment cant open file' => 'Error al clasificar el adjunto. No se pudo abrir el archivo',
  	'error contact added but not assigned' => 'El contacto \'{0}\' fue añadido, pero pero no se le asignó satisfactoriamente el área de trabajo \'{1}\' ya que hubo problemas con los permisos',
  
    
    // Access or data errors
    'no access permissions' => 'No tiene acceso para acceder a la página solicitada',
    'invalid request' => '¡Petición no válida!',
    
    // Confirmation
    'confirm cancel work timeslot' => "Está seguro que desea cancelar el tiempo de trabajo?",
    'confirm delete mail account' => 'Advertencia: Todos los correos electrónicos pertenecientes a esta cuenta serán eliminados también, ¿está seguro de querer eliminar esta cuenta de correo electrónico?',
    'confirm delete message' => '¿Realmente quiere eliminar esta nota?',
    'confirm delete milestone' => '¿Realmente quiere eliminar este hito?',
    'confirm delete task list' => '¿Realmente quiere eliminar esta tarea y todas las sub-tareas?',
    'confirm delete task' => '¿Realmente quiere eliminar esta tarea',
    'confirm delete comment' => '¿Realmente quiere eliminar este comentario?',
    'confirm delete project' => '¿Realmente quiere eliminar esta área de trabajo y todos los datos relacionados (notas, tareas, hitos, archivos...)?',
    'confirm complete project' => '¿Realmente quiere marcar esta área de trabajo como completada? Esto bloqueará todas las acciones del área de trabajo',
    'confirm open project' => '¿Realmente quiere marcar esta área de trabajo como abierta? Esto desbloqueará todas las acciones del área de trabajo',
    'confirm delete client' => '¿Realmente quiere eliminar el cliente de la empresa y todos sus usuarios?\nEsta acción también eliminará el área de trabajo personal de cada usuario.',
    'confirm delete contact' => '¿Realmente quiere eliminar este contacto?',
    'confirm delete user' => '¿Realmente quiere eliminar esta cuenta?\nEsta acción también eliminará el área de trabajo personal del usuario.',
    'confirm reset people form' => '¿Realmente quiere reiniciar este formulario? Todas las modificaciones que fueron hechas se perderán!',
    'confirm remove user from project' => '¿Realmente quiere eliminar este usuario de del área de trabajo?',
    'confirm remove company from project' => '¿Realmente quiere eliminar esta empresa del área de trabajo?',
    'confirm logout' => '¿Realmente quiere desconectarse?',
    'confirm delete current avatar' => '¿Realmente quiere eliminar esta imagen?',
    'confirm unlink object' => '¿Realmente quiere romper el vínculo con este objeto?',
    'confirm delete company logo' => '¿Realmente quiere eliminar el logo actual de la empresa?',
    'confirm subscribe' => '¿Realmente quiere subscribirse a este objeto? Recibirá un correo cada vez que alguien publique un comentario sobre el objeto',
    'confirm unsubscribe' => '¿Realmente quiere dejar de estar suscripto?',
    'confirm delete project form' => '¿Realmente quiere eliminar este formulario?',
    'confirm delete folder' => '¿Realmente quiere eliminar esta carpeta?',
    'confirm delete file' => '¿Realmente quiere eliminar este archivo?',
    'confirm delete revision' => '¿Realmente quiere eliminar esta revisión?',
    'confirm reset form' => '¿Realmente quiere reiniciar este formulario?',
    'confirm delete contacts' => '¿Realmente desea eliminar estos contactos?',
	'confirm delete group' => '¿Realmente desea eliminar este grupo?',
    
    // Errors...
    'system error message' => 'Lo lamentamos, pero ha ocurrido un error fatal y OpenGoo no fue capaz de ejecutar su petición. Un informe de lo sucedido ha sido enviado al administrador.',
    'execute action error message' => 'Lo lamentamos, pero OpenGoo no es capaz de ejecutar su petición. Un informe de lo sucedido ha sido enviado al administrador.',
    
    // Log
    'log add projectmessages' => '\'{0}\' añadido',
    'log edit projectmessages' => '\'{0}\' editado',
    'log delete projectmessages' => '\'{0}\' eliminado',
    
    'log add comments' => '{0} añadido',
    'log edit comments' => '{0} editado',
    'log delete comments' => '{0} eliminado',
    
    'log add projectmilestones' => '\'{0}\' añadido',
    'log edit projectmilestones' => '\'{0}\' editado',
    'log delete projectmilestones' => '\'{0}\' eliminado',
    'log close projectmilestones' => '\'{0}\' terminado',
    'log open projectmilestones' => '\'{0}\' reabierto',
    
    'log add projecttasklists' => '\'{0}\' añadida',
    'log edit projecttasklists' => '\'{0}\' editada',
    'log delete projecttasklists' => '\'{0}\' eliminada',
    'log close projecttasklists' => '\'{0}\' cerrada',
    'log open projecttasklists' => '\'{0}\' abierta',
    
    'log add projecttasks' => '\'{0}\' añadida',
    'log edit projecttasks' => '\'{0}\' editada',
    'log delete projecttasks' => '\'{0}\' eliminada',
    'log close projecttasks' => '\'{0}\' cerrada',
    'log open projecttasks' => '\'{0}\' abierta',
    
    'log add projectforms' => '\'{0}\' añadido',
    'log edit projectforms' => '\'{0}\' editado',
    'log delete projectforms' => '\'{0}\' eliminado',
    
    'log add projectfolders' => '\'{0}\' añadido',
    'log edit projectfolders' => '\'{0}\' editado',
    'log delete projectfolders' => '\'{0}\' eliminado',
    
    'log add projectfiles' => '\'{0}\' añadido',
    'log edit projectfiles' => '\'{0}\' editado',
    'log delete projectfiles' => '\'{0}\' eliminado',
    
    'log edit projectfilerevisions' => '{0} editada',
    'log delete projectfilerevisions' => '{0} eliminada',
    
    'log add projectwebpages' => '\'{0}\' añadida',
    'log edit projectwebpages' => '\'{0}\' editada',
    'log delete projectwebpages' => '\'{0}\' eliminada',
    
    'log add contacts' => '\'{0}\' agregado',
    'log edit contacts' => '\'{0}\' editado',
    'log delete contacts' => '\'{0}\' eliminado',
  
  	'no contacts in company' => 'La empresa no tiene contactos.',
  
  	'session expired error' => 'Su sesión expiró. Por favor, inicie su sesión (conéctese) nuevamente.',
  	'admin cannot be removed from admin group' => 'Un administrador no puede ser eliminado del grupo de administadores',
  	'open this link in a new window' => 'Abrir vínculo en una nueva ventana',
  
    'confirm delete template' => '¿Realmente desea eliminar esta plantilla?',
  	'success delete template' => 'Plantilla \'{0}\' ha sido borrada',
  	'success add template' => 'La plantilla ha sido añadida',
  
  	'log add companies' => '\'{0}\' añadida',
  	'log edit companies' => '\'{0}\' editada',
  	'log delete companies' => '\'{0}\' eliminada',
  
  	'log add mailcontents' => '\'{0}\' añadido',
  	'log edit mailcontents' => '\'{0}\' editado',
  	'log delete mailcontents' => '\'{0}\' eliminado',
  	
  	'log open timeslots' => '\'{0}\' abierto',
    'log close timeslots' => '\'{0}\' cerrado',
    'log delete timeslots' => '\'{0}\' eliminado',
  
  	'error assign workspace' => 'Error al asignar plantilla a un área de trabajo',
  	'success assign workspaces' => 'Plantilla asignada a área de trabajo correctamente',
  	'success update config value' => 'Valores de configuración actualizados',
  	'view open tasks' => 'Tareas no completadas' ,
  
	'error cannot set workspace as parent' => 'No se puede establecer el área de trabajo \'{0}\' como padre, demasiados niveles o referencia circular',
    'log add projectevents' => '\'{0}\' añadido',
    'log edit projectevents' => '\'{0}\' editado',
    'log delete projectevents' => '\'{0}\' eliminado',
 	'already logged in' => 'Usted ya había iniciado la sesión',
  
	'some tasks could not be updated due to permission restrictions' => 'Algunas tareas no pudieron ser actualizadas debido a restricciones de permisos',
    'log trash projectmessages' => '\'{0}\' enviado a la papelera',
    'log untrash projectmessages' => '\'{0}\' restaurado de la papelera',
    'log trash projectevents' => '\'{0}\' enviado a la papelera',
    'log untrash projectevents' => '\'{0}\' restaurado de la papelera',
    'log trash comments' => '\'{0}\' enviado a la papelera',
    'log untrash comments' => '\'{0}\' restaurado de la papelera',
    'log trash projectmilestones' => '\'{0}\' enviado a la papelera',
    'log untrash projectmilestones' => '\'{0}\' restaurado de la papelera',
    'log trash projecttasklists' => '\'{0}\' enviado a la papelera',
    'log untrash projecttasklists' => '\'{0}\' restaurado de la papelera',
    'log trash projecttasks' => '\'{0}\' enviado a la papelera',
    'log untrash projecttasks' => '\'{0}\' restaurado de la papelera',
    'log trash projectforms' => '\'{0}\' enviado a la papelera',
    'log untrash projectforms' => '\'{0}\' restaurado de la papelera',
    'log trash projectfiles' => '\'{0}\' enviado a la papelera',
    'log untrash projectfiles' => '\'{0}\' restaurado de la papelera',
    'log trash projectfilerevisions' => '\'{0}\' enviado a la papelera',
    'log untrash projectfilerevisions' => '\'{0}\' restaurado de la papelera',
    'log trash projectwebpages' => '\'{0}\' enviado a la papelera',
    'log untrash projectwebpages' => '\'{0}\' restaurado de la papelera',
    'log trash contacts' => '\'{0}\' enviado a la papelera',
    'log untrash contacts' => '\'{0}\' restaurado de la papelera',
    'log trash companies' => '\'{0}\' enviado a la papelera',
    'log untrash companies' => '\'{0}\' restaurado de la papelera',
    'log trash mailcontents' => '\'{0}\' enviado a la papelera',
    'log untrash mailcontents' => '\'{0}\' restaurado de la papelera',
    'log trash timeslots' => '\'{0}\' enviado a la papelera',
    'log untrash timeslots' => '\'{0}\' restaurado de la papelera',
    'success trash object' => 'Objeto enviado a la papelera exitosamente',
    'error trash object' => 'Error al enviar el objeto a la papelera',
    'success untrash object' => 'Objeto restaurado de la papelera exitosamente',
    'error untrash object' => 'Error al restaurar el objeto de la papelera',
    'success trash objects' => '{0} objetos enviado a la papelera exitosamente',
    'error trash objects' => 'Error al enviar {0} objetos a la papelera',
    'success untrash objects' => '{0} objetos restaurado de la papelera exitosamente',
    'error untrash objects' => 'Error al restaurar {0} objetos de la papelera',
  	'success delete object' => 'Objeto eliminado exitosamente',
  	'error delete object' => 'Error al eliminar objeto',
  
	'check file name advice' => 'Luego de cambiar el nombre presione TAB para realizar el control de nombres y habilitar el botón Guardar.',
	'filename already exists' => 'El nombre de archivo está siendo utilizado por otro documento',
  
  	'log comment projectmessages' => 'Comentario en \'{0}\'',
    'log subscribe projectmessages' => 'Suscrito a \'{0}\'',
    'log unsubscribe projectmessages' => 'Desuscrito de \'{0}\'',
    'log tag projectmessages' => '\'{0}\' etiquetado',
    'log link projectmessages' => '\'{0}\' vinculado',
    'log unlink projectmessages' => '\'{0}\' desvinculado',
    'log tag projectmessages data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link projectmessages data' => '\'{0}\' vinculado a {1}',
    'log unlink projectmessages data' => '\'{0}\' desvinculado de {1}',
    'log comment projectevents' => 'Comentario en \'{0}\'',
    'log subscribe projectevents' => 'Suscrito a \'{0}\'',
    'log unsubscribe projectevents' => 'Desuscrito de \'{0}\'',
    'log tag projectevents' => '\'{0}\' etiquetado',
    'log link projectevents' => '\'{0}\' vinculado',
    'log unlink projectevents' => '\'{0}\' desvinculado',
    'log tag projectevents data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link projectevents data' => '\'{0}\' vinculado a {1}',
    'log unlink projectevents data' => '\'{0}\' desvinculado de {1}',
    'log comment comments' => 'Comentario en \'{0}\'',
    'log subscribe comments' => 'Suscrito a \'{0}\'',
    'log unsubscribe comments' => 'Desuscrito de \'{0}\'',
    'log tag comments' => '\'{0}\' etiquetado',
    'log link comments' => '\'{0}\' vinculado',
    'log unlink comments' => '\'{0}\' desvinculado',
    'log tag comments data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link comments data' => '\'{0}\' vinculado a {1}',
    'log unlink comments data' => '\'{0}\' desvinculado de {1}',
    'log comment projectmilestones' => 'Comentario en \'{0}\'',
    'log subscribe projectmilestones' => 'Suscrito a \'{0}\'',
    'log unsubscribe projectmilestones' => 'Desuscrito de \'{0}\'',
    'log tag projectmilestones' => '\'{0}\' etiquetado',
    'log link projectmilestones' => '\'{0}\' vinculado',
    'log unlink projectmilestones' => '\'{0}\' desvinculado',
    'log tag projectmilestones data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link projectmilestones data' => '\'{0}\' vinculado a {1}',
    'log unlink projectmilestones data' => '\'{0}\' desvinculado de {1}',
    'log comment projecttasklists' => 'Comentario en \'{0}\'',
    'log subscribe projecttasklists' => 'Suscrito a \'{0}\'',
    'log unsubscribe projecttasklists' => 'Desuscrito de \'{0}\'',
    'log tag projecttasklists' => '\'{0}\' etiquetado',
    'log link projecttasklists' => '\'{0}\' vinculado',
    'log unlink projecttasklists' => '\'{0}\' desvinculado',
    'log tag projecttasklists data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link projecttasklists data' => '\'{0}\' vinculado a {1}',
    'log unlink projecttasklists data' => '\'{0}\' desvinculado de {1}',
    'log comment projecttasks' => 'Comentario en \'{0}\'',
    'log subscribe projecttasks' => 'Suscrito a \'{0}\'',
    'log unsubscribe projecttasks' => 'Desuscrito de \'{0}\'',
    'log tag projecttasks' => '\'{0}\' etiquetado',
    'log link projecttasks' => '\'{0}\' vinculado',
    'log unlink projecttasks' => '\'{0}\' desvinculado',
    'log tag projecttasks data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link projecttasks data' => '\'{0}\' vinculado a {1}',
    'log unlink projecttasks data' => '\'{0}\' desvinculado de {1}',
    'log comment projectforms' => 'Comentario en \'{0}\'',
    'log subscribe projectforms' => 'Suscrito a \'{0}\'',
    'log unsubscribe projectforms' => 'Desuscrito de \'{0}\'',
    'log tag projectforms' => '\'{0}\' etiquetado',
    'log link projectforms' => '\'{0}\' vinculado',
    'log unlink projectforms' => '\'{0}\' desvinculado',
    'log tag projectforms data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link projectforms data' => '\'{0}\' vinculado a {1}',
    'log unlink projectforms data' => '\'{0}\' desvinculado de {1}',
    'log comment projectfolders' => 'Comentario en \'{0}\'',
    'log subscribe projectfolders' => 'Suscrito a \'{0}\'',
    'log unsubscribe projectfolders' => 'Desuscrito de \'{0}\'',
    'log tag projectfolders' => '\'{0}\' etiquetado',
    'log link projectfolders' => '\'{0}\' vinculado',
    'log unlink projectfolders' => '\'{0}\' desvinculado',
    'log tag projectfolders data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link projectfolders data' => '\'{0}\' vinculado a {1}',
    'log unlink projectfolders data' => '\'{0}\' desvinculado de {1}',
    'log comment projectfiles' => 'Comentario en \'{0}\'',
    'log subscribe projectfiles' => 'Suscrito a \'{0}\'',
    'log unsubscribe projectfiles' => 'Desuscrito de \'{0}\'',
    'log tag projectfiles' => '\'{0}\' etiquetado',
    'log link projectfiles' => '\'{0}\' vinculado',
    'log unlink projectfiles' => '\'{0}\' desvinculado',
    'log tag projectfiles data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link projectfiles data' => '\'{0}\' vinculado a {1}',
    'log unlink projectfiles data' => '\'{0}\' desvinculado de {1}',
    'log comment projectfilerevisions' => 'Comentario en \'{0}\'',
    'log subscribe projectfilerevisions' => 'Suscrito a \'{0}\'',
    'log unsubscribe projectfilerevisions' => 'Desuscrito de \'{0}\'',
    'log tag projectfilerevisions' => '\'{0}\' etiquetado',
    'log link projectfilerevisions' => '\'{0}\' vinculado',
    'log unlink projectfilerevisions' => '\'{0}\' desvinculado',
    'log tag projectfilerevisions data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link projectfilerevisions data' => '\'{0}\' vinculado a {1}',
    'log unlink projectfilerevisions data' => '\'{0}\' desvinculado de {1}',
    'log comment projectwebpages' => 'Comentario en \'{0}\'',
    'log subscribe projectwebpages' => 'Suscrito a \'{0}\'',
    'log unsubscribe projectwebpages' => 'Desuscrito de \'{0}\'',
    'log tag projectwebpages' => '\'{0}\' etiquetado',
    'log link projectwebpages' => '\'{0}\' vinculado',
    'log unlink projectwebpages' => '\'{0}\' desvinculado',
    'log tag projectwebpages data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link projectwebpages data' => '\'{0}\' vinculado a {1}',
    'log unlink projectwebpages data' => '\'{0}\' desvinculado de {1}',
    'log comment contacts' => 'Comentario en \'{0}\'',
    'log subscribe contacts' => 'Suscrito a \'{0}\'',
    'log unsubscribe contacts' => 'Desuscrito de \'{0}\'',
    'log tag contacts' => '\'{0}\' etiquetado',
    'log link contacts' => '\'{0}\' vinculado',
    'log unlink contacts' => '\'{0}\' desvinculado',
    'log tag contacts data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link contacts data' => '\'{0}\' vinculado a {1}',
    'log unlink contacts data' => '\'{0}\' desvinculado de {1}',
    'log comment companies' => 'Comentario en \'{0}\'',
    'log subscribe companies' => 'Suscrito a \'{0}\'',
    'log unsubscribe companies' => 'Desuscrito de \'{0}\'',
    'log tag companies' => '\'{0}\' etiquetado',
    'log link companies' => '\'{0}\' vinculado',
    'log unlink companies' => '\'{0}\' desvinculado',
    'log tag companies data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link companies data' => '\'{0}\' vinculado a {1}',
    'log unlink companies data' => '\'{0}\' desvinculado de {1}',
    'log comment mailcontents' => 'Comentario en \'{0}\'',
    'log subscribe mailcontents' => 'Suscrito a \'{0}\'',
    'log unsubscribe mailcontents' => 'Desuscrito de \'{0}\'',
    'log tag mailcontents' => '\'{0}\' etiquetado',
    'log link mailcontents' => '\'{0}\' vinculado',
    'log unlink mailcontents' => '\'{0}\' desvinculado',
    'log tag mailcontents data' => '\'{0}\' etiquetado como \'{1}\'',
    'log link mailcontents data' => '\'{0}\' vinculado a {1}',
  	'log unlink mailcontents data' => '\'{0}\' desvinculado de {1}',
    'copied from file' => 'Copied from file {0} ({1})',
    'success purging trash' => '{0} objects deleted.',
    'success sending reminders' => '{0} reminders sent.',
	'failed to assign contact due to permissions' => 'No tiene permisos para escribir contactos en los siguientes espacios: {0}',  
  ); // array

?>