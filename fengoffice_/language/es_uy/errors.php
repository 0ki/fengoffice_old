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
    'invalid email address' => 'La dirección de correo ingresada es inválida',
   
    // Company validation errors
    'company name required' => 'El campo correspondiente al nombre de la Empresa / organización  es obligatorio y no fue ingresado',
    'company homepage invalid' => 'El nombre del sitio web ingresado no es una URL válida',
    
    // User validation errors
    'username value required' => 'Nombre de usuario no ingresado, intente nuevamente',
    'username must be unique' => 'El Nombre de usuario seleccionado ya esta en uso',
    'email value is required' => 'Dirección de correo electrónico no ingresada, intente nuevamente',
    'email address must be unique' => 'La dirección de correo ya esta en uso, intente con una distinta',
    'company value required' => 'El usuario debe pertenecer a una empresa / organización',
    'password value required' => 'Contraseña no ingresada, inténtelo nuevamente',
    'passwords dont match' => 'Las contraseñas ingresadas no coinciden, intente nuevamente',
    'old password required' => 'Debe ingresar la contraseña anterior',
    'invalid old password' => 'La contraseña anterior es inválida',
    'users must belong to a company' => 'Los contactos deben pertenecer a una empresa para poder crear un usuario',
    'contact linked to user' => 'El contacto ingresado está vinculado con el usuario {0}',
    
    // Avatar
    'invalid upload type' => 'Tipo de archivo inválido. Son válidos {0}',
    'invalid upload dimensions' => 'La dimensión de la imagen es inválida. El valor máximo admitido es {0}x{1} píxeles',
    'invalid upload size' => 'La dimensión de la imagen es inválida. El valor máximo admitido es {0}',
    'invalid upload failed to move' => 'No se pudo mover el archivo cargado',
    
    // Registration form
    'terms of services not accepted' => 'Para poder crear una cuenta debe leer y aceptar los términos y condiciones de nuestros servicios',
    
    // Init company website
    'failed to load company website' => 'No se pudo cargar el sitio web. La compañía no fue encontrada',
    'failed to load project' => 'El sistema falló al cargar el espacio',
    
    // Login form
    'username value missing' => 'Por favor, ingrese el nombre de usuario',
    'password value missing' => 'Por favor, ingrese su contraseña',
    'invalid login data' => 'El nombre de usuario o la contraseña son incorrectas, por favor inténtelo nuevamente',
    
    // Add project form
    'project name required' => 'Nombre de espacio no ingresado, intente nuevamente',
    'project name unique' => 'El nombre de espacio seleccionado ya está en uso, inténtelo con uno distinto',   
    // Add message form
    'message title required' => 'Título no ingresado, intente nuevamente',
    'message title unique' => 'El título ingresado ya existe, intente ingresar uno distinto',
    'message text required' => 'Nota no ingresada, intente nuevamente',
    
    // Add comment form
    'comment text required' => 'Texto no ingresado, intente nuevamente',
    
    // Add milestone form
    'milestone name required' => 'Nombre del hito no ingresado, intente nuevamente',
    'milestone due date required' => 'Fecha de límite del hito requerida',
    
    // Add task list
    'task list name required' => 'Nombre de tarea no ingresado, intente nuevamente',
    'task list name unique' => 'El nombre de tarea seleccionado ya existe, intente nuevamente ingresando uno distinto',
    'task title required' => 'Título de tarea no ingresado, intente nuevamente',
  
    // Add task
    'task text required' => 'Texto de tarea no ingresado, intente nuevamente',
    
    // Add event
    'event subject required' => 'El asunto del evento debe ser ingresado, intente nuevamente',
    'event description maxlength' => 'La descripción no debe pasar los 3000 caracteres',
    'event subject maxlength' => 'El asunto no depe pasar los 100 caracteres',
    
    // Add project form
    'form name required' => 'Nombre de formulario no ingresado, intente nuevamente',
    'form name unique' => 'El nombre de formulario debe ser único, intente nuevamente',
    'form success message required' => 'Mensaje de aprobación requerido',
    'form action required' => 'Debe seleccionar una acción para el formulario',
    'project form select message' => 'Debe elegir un mensaje',
    'project form select task lists' => 'Debe elegir una tarea',
    
    // Submit project form
    'form content required' => 'Por favor, inserte el contenido en campo de texto',
    
    // Validate project folder
    'folder name required' => 'Nombre de carpeta requerido, intente nuevamente',
    'folder name unique' => 'El nombre de carpeta debe ser único en este espacio, intente nuevamente con uno distinto',
    
    // Validate add / edit file form
    'folder id required' => 'Debe elegir una carpeta',
    'filename required' => 'Nombre de archivo requerido, intente nuevamente',
    
    // File revisions (internal)
    'file revision file_id required' => 'La revisión debe estar conectada con un archivo',
    'file revision filename required' => 'Nombre de archivo requerido, inténtelo nuevamente',
    'file revision type_string required' => 'Tipo de archivo desconocido',
    
    // Test mail settings
    'test mail recipient required' => 'Debe ingresar un destinatario',
    'test mail recipient invalid format' => 'La dirección del destinatario es inválida',
    'test mail message required' => 'Mensaje de mail requerido, intente nuevamente',
    
    // Mass mailer
    'massmailer subject required' => 'Asunto del mensaje requerido, intente nuevamente',
    'massmailer message required' => 'Cuerpo del mensaje requerido, intente nuevamente',
    'massmailer select recepients' => 'Debe seleccionar destinatarios',
    
  	//Email module
  	'mail account name required' => 'Nombre de cuenta requerido, intente nuevamente',
  	'mail account id required' => 'Identificación de cuenta requerido, intente nuevamente',
  	'mail account server required' => 'Servidor requerido, intente nuevamente',
  	'mail account password required' => 'Contraseña requerida, intente nuevamente',	
	'send mail error' => 'Ha ocurrido un error al enviar el correo.',
    'email address already exists' => 'Ya existe una cuenta creada con esa dirección de correo.',

  	'session expired error' => 'Sesión cerrada debido a su inactividad por tiempo prolongado',
  	'unimplemented type' => 'Tipo no implementado',
  	'unimplemented action' => 'Acción no implementada',
  
  	'workspace own parent error' => 'Un espacio (no) puede ser su propio padre',
  	'task own parent error' => 'Una tarea (no) puede ser su propio padre',
  	'task child of child error' => 'Una tarea (no) puede ser hija de una de sus herederas',
  
  	'chart title required' => 'Se requiere el título del gráfico.',
  	'chart title unique' => 'El título del gráfico debe ser único.',
    'must choose at least one workspace error' => 'Debe elegir al menos un espacio donde colocar el objeto.',
    
    'user has contact' => 'Ya hay un contacto asigando a este usuario',
  
  	'maximum number of users reached error' => 'El número máximo de usuarios ha sido alcanzado',
	'maximum number of users exceeded error' => 'El número máximo de usuarios ha sido sobrepasado. El sistema no volverá a funcionar hasta que este problema haya sido resuelto.',
	'maximum disk space reached' => 'Ha utilizado la totalidad del espacio en disco asignado. Borre objetos antes de ingresar nuevos, o contacte a soporte para que autorice más usuarios.'  ,
 	'error db backup' => 'Error al crear respaldo de la base de datos. {0}',
	'error create backup folder' => 'Error al crear carpeta de respaldo. No se puede completar el respaldo',
	'error delete backup' => 'Error al borrar el ultimo respaldo',
	'success delete backup' => 'Respaldo borrado',
    'name must be unique' => 'El nombre del contacto ya está en uso',
  	'not implemented' => 'No implementado',
  	'success db backup' => 'Respaldo creado exitosamente.',
  
	'backup command failed' => 'Error al ejecutar el comando de respaldo. Verificar constante MYSQLDUMP_COMMAND.',
  	'return code' => 'Código de retorno: {0}',
  
 ); // array

?>