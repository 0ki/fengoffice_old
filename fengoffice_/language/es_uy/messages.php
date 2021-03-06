<?php

  /**
  * Array of messages file (error, success message, status...)
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */

  return array(
  
    // Empty, dnx et
    'no mail accounts set' => 'No existen casillas de correo,  por favor cree una primero',
    'no mail accounts set for check' => 'No existen casillas de correo, por favor cree una primero',
    'email dnx' => 'Dirección de correo no existente',
  	'email dnx deleted' => 'El correo que solicitó fue eliminado de la base de datos',
    'project dnx' => 'El espacio requerido no existe en la base de datos',
    'contact dnx' => 'El contacto requerido no existe en la base de datos',
    'company dnx' => 'La empresa requerida no existe en la base de datos',
    'message dnx' => 'El mensaje requerido no eexiste en la base de datos',
    'no comments in message' => 'Este mensaje no tiene comentarios',
    'no comments associated with object' => 'No se han ingresado comentarios para este objeto',
    'no messages in project' => 'No hay mensajes en este espacio',
    'no subscribers' => 'No hay usuarios inscriptos a este mensaje',
    'no activities in project' => 'No hay actividades en este espacio',
    'comment dnx' => 'El comentario requerido no existe',
    'milestone dnx' => 'El hito requerido no existe',
    'task list dnx' => 'La tarea requerida no existe',
    'task dnx' => 'La tarea requerida no existe',
    'event type dnx' => 'El evento requerido no existe',
    'no milestones in project' => 'No hay hitos en este espacio',
    'no active milestones in project' => 'No hay hitos activos en este espacio',
    'empty milestone' => 'El hito esta vacío. Es posible agregar una <a class="internalLink" href="{1}">tarea</a> al hito cuando así lo desee',
    'no logs for project' => 'No existen entradas relacionadas a este espacio',
    'no recent activities' => 'No se han ingresado nuevas actividades a la base de datos',
    'no open task lists in project' => 'Este espacio no tiene tareas abiertas',
    'no completed task lists in project' => 'No hay tareas completadas en el espacio',
    'no open task in task list' => 'No hay tareas abiertas en la lista',
    'no closed task in task list' => 'No hay tareas cerradas en la lista',
    'no open task in milestone' => 'No hay tareas abiertas en el hito',
    'no closed task in milestone' => 'No hay tareas cerradas en el hito',
    'no projects in db' => 'No se han definido espacios en la base de datos',
    'no projects owned by company' => 'La empresa no tiene un espacio asignado',
    'no projects started' => 'No hay espacios iniciados',
    'no active projects in db' => 'No hay espacios activos',
    'no new objects in project since last visit' => 'No hay nuevos objetos en su espacio desde su última visita',
    'no clients in company' => 'Su empresa aun no ha registrado clientes',
    'no users in company' => 'No existen usuarios de esta empresa',
    'client dnx' => 'El cliente seleccionado no existe',
    'company dnx' => 'La empresa seleccionada no existe',
    'user dnx' => 'El usuario requerido no existe en la base de datos',
    'avatar dnx' => 'Imagen inexistente',
    'no current avatar' => 'Imagen no cargada',
    'picture dnx' => 'Foto inexistente',
    'no current picture' => 'Foto no cargada',
    'no current logo' => 'Logo no cargado',
    'user not on project' => 'El usuario seleccionado no esta realacionado con el espacio seleccionado',
    'company not on project' => 'La empresa seleccionada no esta relacionada con el espacio seleccionado',
    'user cant be removed from project' => 'El usuario seleccionado (no) puede ser eliminado del espacio',
    'tag dnx' => 'Etiqueta seleccionada no existente',
    'no tags used on projects' => 'No se usaron etiquetas en el espacio',
    'no forms in project' => 'No se han ingresado formularios en este espacio',
    'project form dnx' => 'El formulario seleccionado no existe en la base de datos',
    'related project form object dnx' => 'El formulario no existe en la base de datos',
    'no my tasks' => 'No hay tareas asignadas',
    'no search result for' => 'No hay objetos que coinciden con "<strong>{0}</strong>"',
    'no files on the page' => 'No hay archivos en esta página',
    'folder dnx' => 'La carpeta seleccionada no existe en la base de datos',
    'define project folders' => 'No hay carpetas en el espacio. Por favor defina una para poder continuar',
    'file dnx' => 'El archivo seleccionado no existe en la base de datos',
    'not s5 presentation' => 'No se puede iniciar la presentación ya que el archivo no es una presentación slimey',
    'file not selected' => 'No ha seleccionado ningún archivo',
    'file revision dnx' => 'La revisión requerida no existe',
    'no file revisions in file' => 'Archivo invalido - no hay revisiones asociadas a este archivo',
    'cant delete only revision' => 'No puede eliminar esta revisión. Cada archivo debe tener, al menos, una revisión',
    'config category dnx' => 'La configuración de la categoría que seleccionó no existe',
    'config category is empty' => 'La configuración de la categoría no fue ingresada',
    'email address not in use' => '%s no está siendo usada',
    'no linked objects' => 'No hay objetos vinculados con este objeto',
    'object not linked to object' => 'No existen vinculos entre los objetos seleccionados',
    'no objects to link' => 'Por favor, seleccione los objetos que deben vincularse',
    'no administration tools' => 'No se han registrado herramientas de administración en la base de datos',
    'administration tool dnx' => 'La herramienta de administración "{0}" no existe',
    
    // Success
    'success add contact' => 'El contacto \'{0}\' ha sido creado de forma exitosa',
    'success edit contact' => 'El contacto \'{0}\' ha sido editado de forma exitosa',
    'success delete contact' => 'El contacto \'{0}\' ha sido eliminado de forma exitosa',
    'success edit picture' => 'Foto cargada de forma exitosa',
    'success delete picture' => 'Foto eliminada satisfactoriamente',
    
    'success add project' => 'El espacio {0} ha sido agregado de forma exitosa',
    'success edit project' => 'El espacio {0} ha sido editado de forma exitosa',
    'success delete project' => 'El espacio {0} ha sido eliminado de forma exitosa',
    'success complete project' => 'El espacio {0} ha sido completado de forma exitosa',
    'success open project' => 'El espacio {0} ha sido reabierto de forma exitosa',
    
    'success add milestone' => 'El hito \'{0}\' ha sido creado de forma exitosa',
    'success edit milestone' => 'El hito \'{0}\' ha sido editado de forma exitosa',
    'success deleted milestone' => 'El hito \'{0}\' ha sido eliminado de forma exitosa',
    
    'success add message' => 'El mensaje {0} ha sido agregado de forma exitosa',
    'success edit message' => 'El mensaje {0} ha sido editado de forma exitosa',
    'success deleted message' => 'El mensaje \'{0}\' y todos sus comentarios fueron eliminados de forma existosa',
    
    'success add comment' => 'Comentario agregado de forma satisfactoria',
    'success edit comment' => 'Comentario editado de forma satisfactoria',
    'success delete comment' => 'Comentario eliminado de forma satisfactoria',
    
    'success add task list' => 'La tarea \'{0}\' ha sido agregada',
    'success edit task list' => 'La tarea \'{0}\' ha sido editada',
    'success delete task list' => 'La tarea \'{0}\' ha sido eliminada',
    
    'success add task' => 'La tarea seleccionada ha sido agregada',
    'success edit task' => 'La tarea seleccionada ha sido editada',
    'success delete task' => 'La tarea seleccionada ha sido eliminada',
    'success complete task' => 'La tarea seleccionada ha sido completada',
    'success open task' => 'La tarea seleccionada ha sido reabierta',
    'success n tasks updated' => '{0} tareas editadas',
	'success add mail' => 'Correo enviado de forma satisfactoria',
    
    'success add client' => 'El cliente {0} ha sido agregado',
    'success edit client' => 'El cliente {0} ha sido editado',
    'success delete client' => 'El cliente {0} ha sido eliminado',
    
    'success add group' => 'El grupo {0} ha sido agregado',
    'success edit group' => 'El grupo {0} ha sido agregado',
    'success delete group' => 'El grupo {0} ha sido agregado',
    
    'success edit company' => 'Datos de la empresa modificados y guardados',
    'success edit company logo' => 'Logo de la empresa modificado',
    'success delete company logo' => 'Logo de la empresa eliminado',
    
    'success add user' => 'El usuario {0} ha sido agregado',
    'success edit user' => 'El usuario {0} ha sido editado',
    'success delete user' => 'El usuario {0} ha sido eliminado',
    
    'success update project permissions' => 'Permisos del espacio modificados',
    'success remove user from project' => 'Usuario eliminado del espacio',
    'success remove company from project' => 'Empresa eliminada del espacio',
    
    'success update profile' => 'Nuevo perfil guardado',
    'success edit avatar' => 'Nueva imagen guardada',
    'success delete avatar' => 'Imagen eliminada',
    
    'success hide welcome info' => 'Campo de información de bienvenida oculto',
    
    'success complete milestone' => 'Hito \'{0}\' completado',
    'success open milestone' => 'Hito \'{0}\' reabierto',
    
    'success subscribe to message' => 'Suscripción al mensaje satifactoria',
    'success unsubscribe to message' => 'Suscripción al mensaje ha quedado sin efecto',
    
    'success add project form' => 'Formulario \'{0}\' agregado',
    'success edit project form' => 'Formulario \'{0}\' modificado',
    'success delete project form' => 'Formlario \'{0}\' eliminado',
    
    'success add folder' => 'Carpeta \'{0}\' agregado',
    'success edit folder' => 'Carpeta \'{0}\' modificado',
    'success delete folder' => 'Carpeta \'{0}\' eliminado',
    
    'success add file' => 'Archivo \'{0}\' agregado',
	'success save file' => 'Archivo \'{0}\' guardado',
    'success edit file' => 'Archivo \'{0}\' modificado',
    'success delete file' => 'Archivo \'{0}\' eliminado',
    'success delete files' => '{0} archivo(s) eliminado(s)',
    'success tag files' => '{0} archivos(s) etiquetado(s)',
    'success tag contacts' => '{0} contacto(s) etiquetado(s)',
    
    'success add handis' => 'Entregables agregados',
    
    'success add properties' => 'Propiedades agregadas',
    
    'success edit file revision' => 'Revisiones editadas',
    'success delete file revision' => 'Revision de archivo eliminados',
    
    'success link objects' => '%s objecto(s) vinculados',
    'success unlink object' => 'Este objeto dejó de estar vinculado',
    
    'success update config category' => '{0} valores de configuración modificados y guardados',
    'success forgot password' => 'Su contraseña fue enviada a su correo electrónico',
    
    'success test mail settings' => 'Correo de prueba enviado de forma satisfactoria',
    'success massmail' => 'Correo enviado',
    
    'success update company permissions' => 'Permisos de la empresa modificados satisfactoriamente. {0} registros modificados',
    'success user permissions updated' => 'Permisos de usuarios modificados',
  
    'success add event' => 'Evento agregado',
    'success edit event' => 'Evento editado',
    'success delete event' => 'Evento eliminado',
    
    'success add event type' => 'Nuevo tipo de evento agregado',
    'success delete event type' => 'Tipo de evento eliminado',
    
    'success add webpage' => 'Web link agregado',
    'success edit webpage' => 'Web link modificado',
    'success deleted webpage' => 'Web link eliminado',
    
    'success add chart' => 'Tabla agregada',
    'success edit chart' => 'Tabla editada',
    'success delete chart' => 'Tabla eliminada',
    'success delete charts' => 'Las tablas seleccionadas fueron eliminadas',
  
    'success delete contacts' => 'Contactos eliminados satisfactoriamente',
  
    'success classify email' => 'Correo clasificado de forma satisfactoria',
    'success delete email' => 'Correo eliminado',
  
    'success delete mail account' => 'Cuenta de correo eliminada satisfactoriamente',
    'success add mail account' => 'Cuenta de correo creada satisfactoriamente',
    'success edit mail account' => 'Cuenta de correo modificada y guardada satisfactoriamente',
  
    'success link object' => 'Objeto vinculado satisfactoriamente',
  
  	'success check mail' => 'Correo recibido satisfactoriamente: {0} correos recibidos.',
  
	'success delete objects' => '{0} Objecto(s) eliminados satisfactoriamente',
	'success tag objects' => '{0} Objecto(s) etiquetados satisfactoriamente',
	'error delete objects' => 'No fue posible eliminar {0} objecto(s)',
	'error tag objects' => 'No fue posible etiquetar {0} objecto(s)',
	'success move objects' => '{0} Objecto(s) tranferidos satisfactoriamente',
	'error move objects' => 'No fue posible transferir {0} objecto(s)',
  
    'success checkout file' => 'Archivo bloqueado para edición en forma exitosa',
    'success checkin file' => 'Archivo devuelto en forma exitosa',
  	'success undo checkout file' => 'Bloqueo para edición del archivo cancelado en forma exitosa',
    
    // Failures
    'error edit timeslot' => 'Ha ocurrido un error al guardar el tiempo de trabajo',
  	'error delete timeslot' => 'Ha ocurrido un error al eliminar el tiempo de trabajo',
  	'error add timeslot' => 'Ha ocurrido un error al agregar el tiempo de trabajo',
  	'error open timeslot' => 'Ha ocurrido un error al abrir el tiempo de trabajo',
  	'error close timeslot' => 'Ha ocurrido un error al cerrar el tiempo de trabajo',
    'error start time after end time' => 'No se pudo guardar horario: el horario de comienzo debe ocurrir antes del horario de finalización',
    'error form validation' => 'Ha ocurrido un error al guardar el ojecto debido a que sus propiedades no son válidas',
    'error delete owner company' => 'El dueño de la empresa no puede ser eliminado',
    'error delete message' => 'Ha ocurrido un error al eliminar el mensaje seleccionado',
    'error update message options' => 'Ocurrió un error mientras se ponían al día las opciones del mensaje',
    'error delete comment' => 'Ha ocurrido un error al eliminar el comentario seleccionado',
    'error delete milestone' => 'Ha ocurrido un error al eliminar el hito seleccionado',
    'error complete task' => 'Ocurrió un error mientras se completaba la tarea',
    'error open task' => 'Ha ocurrido un error al reabrir tarea',
    'error upload file' => 'Ha ocurrido un error al subir el archivo',
    'error delete project' => 'Ha ocurrido un error al eliminar el espacio seleccionado',
    'error complete project' => 'Ha ocurrido un error al completar el espacio deseado',
    'error open project' => 'Ha ocurrido un error al reabrir el espacio seleccionado',
    'error delete client' => 'Ha ocurrido un error al eliminar el cliente de la empresa seleccionado',
    'error delete group' => 'Ha ocurrido un error al eliminar el grupo seleccionado',
    'error delete user' => 'Ha ocurrido un error al eliminar el usuario seleccionado',
    'error update project permissions' => 'Ocurrió un error mientras se ponían al día los permisos del espacio',
    'error remove user from project' => 'Ha ocurrido un error al eliminar usuario del espacio',
    'error remove company from project' => 'Ha ocurrido un error al eliminar empresa del espacio',
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
    'error subscribe to message' => 'Ha ocurrido un error al suscribirse al mensaje seleccionado',
    'error unsubscribe to message' => 'Ha ocurrido un error al intentar dejar sin efecto la suscripción al mensaje seleccionado',
    'error add project form' => 'Ha ocurrido un error al agregar el formulario del espacio',
    'error submit project form' => 'Ha ocurrido un error al ingresar el formulario del espacio',
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
    'error link objects max controls' => 'No se pueden agregar más vínculos. El máximo es %s',
    'error test mail settings' => 'No se pudo enviar mensaje de texto',
    'error massmail' => 'No se pudo enviar correo',
    'error owner company has all permissions' => 'El dueño de la empresa tiene todos los permisos',
    'error while saving' => 'Ha ocurrido un error al guardar',
    'error delete event type' =>'El programa falló al tratar de eliminar este tipo de eventos',
    'error delete mail' => 'Ha ocurrido un error al eliminar este correo',
    'error delete mail account' => 'Ha ocurrido un error al eliminar esta cuenta de correo',
    'error delete contacts' => 'Ha ocurrido un error al eliminar estos contactos',
  	'error check mail' => 'En la cuenta \'{0}\' se encontraron : {1} errores',
    'error classifying attachment cant open file' => 'Error al clasificar el attachment. No se pudo abrir el archivo',
  	'error contact added but not assigned' => 'El contacto \'{0}\' fue agregado, pero pero no se le asignó correctamente el espacio de trabajo \'{1}\' ya que hubo problemas con los permisos',
  
    
    // Access or data errors
    'no access permissions' => 'No tiene accesos para acceder a la página solicitada',
    'invalid request' => 'Petición inválida!',
    
    // Confirmation
    'confirm delete mail account' => 'Advertencia: Todos los correos pertenecientes a esta cuenta serán eliminados también, ¿está seguro de querer eliminar esta cuenta de correo?',
    'confirm delete message' => '¿Realmente quiere eliminar este mensaje?',
    'confirm delete milestone' => '¿Realmente quiere eliminar este hito?',
    'confirm delete task list' => '¿Realmente quiere eliminar esta tarea y todas las sub tareas?',
    'confirm delete task' => '¿Realmente quiere eliminar esta tarea',
    'confirm delete comment' => '¿Realmente quiere eliminar este comentario?',
    'confirm delete project' => '¿Realmente quiere eliminar este espacio y todos los datos relacionados (mensajes, tareas, hitos, archivos...)?',
    'confirm complete project' => '¿Realmente quiere marcar este espacio como cerrado? Esto bloqueará todas las acciones del espacio',
    'confirm open project' => '¿Realmente quiere marcar este espacio como abierto? Esto desbloqueara todas las acciones del espacio',
    'confirm delete client' => '¿Realmente quiere eliminar el cliente de la empresa y todos sus usuarios?\nEsta acción también eliminará el espacio personal de cada usuario.',
    'confirm delete contact' => '¿Realmente quiere eliminar este contacto?',
    'confirm delete user' => '¿Realmente quiere eliminar esta cuenta?\nEsta acción también eliminará el espacio personal del usuario.',
    'confirm reset people form' => '¿Realmente quiere reiniciar este formulario? Todas las modificaciones que fueron hechas se perderán!',
    'confirm remove user from project' => '¿Realmente quiere eliminar este usuario de su espacio?',
    'confirm remove company from project' => '¿Realmente quiere eliminar esta empresa de su espacio?',
    'confirm logout' => '¿Realmente quiere cerrar su sesión?',
    'confirm delete current avatar' => '¿Realmente quiere eliminar esta imagen?',
    'confirm unlink object' => '¿Realmente quiere romper el vínculo de este objeto?',
    'confirm delete company logo' => '¿Realmente quiere eliminar el logo actual de la empresa?',
    'confirm subscribe' => '¿Realmente quiere subscribirse a este mensaje? Recibirá un mensaje cada vez que alguien publique un comentario sobre el mensaje',
    'confirm unsubscribe' => '¿Realmente quiere dejar de estar suscripto?',
    'confirm delete project form' => '¿Realmente quiere eliminar este formulario?',
    'confirm delete folder' => '¿Realmente quiere eliminar esta carpeta?',
    'confirm delete file' => '¿Realmente quiere eliminar este archivo?',
    'confirm delete revision' => '¿Realmente quiere eliminar esta revisión?',
    'confirm reset form' => '¿Realmente quiere reiniciar este formulario?',
    'confirm delete contacts' => '¿Realmente desea eliminar estos contactos?',
	'confirm delete group' => '¿Realmente desea eliminar este grupo?',
    
    // Errors...
    'system error message' => 'Lo lamentamos, pero ha ocurrido un error fatal y OpenGoo no fue capaz de ejecutar su pedido. Un informe de lo sucedido ha sido enviado al administrador.',
    'execute action error message' => 'Lo lamentamos, pero OpenGoo no es capaz de ejecutar su pedido. Un informe de lo sucedido ha sido enviado al administrador.',
    
    // Log
    'log add projectmessages' => '\'{0}\' agregado',
    'log edit projectmessages' => '\'{0}\' modificado',
    'log delete projectmessages' => '\'{0}\' eliminado',
    
    'log add comments' => '{0} agregado',
    'log edit comments' => '{0} modificado',
    'log delete comments' => '{0} eliminado',
    
    'log add projectmilestones' => '\'{0}\' agregado',
    'log edit projectmilestones' => '\'{0}\' modificado',
    'log delete projectmilestones' => '\'{0}\' eliminado',
    'log close projectmilestones' => '\'{0}\' terminado',
    'log open projectmilestones' => '\'{0}\' reabierto',
    
    'log add projecttasklists' => '\'{0}\' agregada',
    'log edit projecttasklists' => '\'{0}\' modificada',
    'log delete projecttasklists' => '\'{0}\' eliminada',
    'log close projecttasklists' => '\'{0}\' cerrada',
    'log open projecttasklists' => '\'{0}\' abierta',
    
    'log add projecttasks' => '\'{0}\' agregada',
    'log edit projecttasks' => '\'{0}\' modificada',
    'log delete projecttasks' => '\'{0}\' eliminada',
    'log close projecttasks' => '\'{0}\' cerrada',
    'log open projecttasks' => '\'{0}\' abierta',
    
    'log add projectforms' => '\'{0}\' agregado',
    'log edit projectforms' => '\'{0}\' modificado',
    'log delete projectforms' => '\'{0}\' eliminado',
    
    'log add projectfolders' => '\'{0}\' agregado',
    'log edit projectfolders' => '\'{0}\' modificado',
    'log delete projectfolders' => '\'{0}\' eliminado',
    
    'log add projectfiles' => '\'{0}\' subido',
    'log edit projectfiles' => '\'{0}\' modificado',
    'log delete projectfiles' => '\'{0}\' eliminado',
    
    'log edit projectfilerevisions' => '{0} actualizada',
    'log delete projectfilerevisions' => '{0} eliminada',
    
    'log add projectwebpages' => '\'{0}\' agregada',
    'log edit projectwebpages' => '\'{0}\' modificada',
    'log delete projectwebpages' => '\'{0}\' eliminada',
    
    'log add contacts' => '\'{0}\' asignado al espacio',
    'log edit contacts' => '\'{0}\' cambió su rol',
    'log delete contacts' => '\'{0}\' eliminado del espacio',
  
  	'no contacts in company' => 'La empresa no tiene contactos.',
  
  	'session expired error' => 'Su sesión expiro. Por favor, inicie su sesión nuevamente.',
  	'admin cannot be removed from admin group' => 'Un administrador no puede ser eliminado del grupo de administadores',
  	'open this link in a new window' => 'Abrir vínculo en una nueva ventana',
  
    'confirm delete template' => '¿Realmente desea eliminar esta plantilla?',
  	'success delete template' => 'Plantilla \'{0}\' ha sido borrada',
  	'success add template' => 'La plantilla ha sido agregada',
  
  	'log add companies' => '\'{0}\' agregada',
  	'log edit companies' => '\'{0}\' modificada',
  	'log delete companies' => '\'{0}\' eliminada',
  
  	'log add mailcontents' => '\'{0}\' agregado',
  	'log edit mailcontents' => '\'{0}\' modificado',
  	'log delete mailcontents' => '\'{0}\' eliminado',
  ); // array

?>