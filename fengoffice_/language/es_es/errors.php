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
    'invalid email address' => 'La dirección de correo introduccida no es válida',
   
    // Company validation errors
    'company name required' => 'El campo correspondiente al nombre de la empresa/organización  es obligatorio y no fue introducido',
    'company homepage invalid' => 'La dirección de la página web introducida no es una URL válida',
    
    // User validation errors
    'username value required' => 'Nombre de usuario no introducido, inténtelo de nuevo',
    'username must be unique' => 'El nombre de usuario seleccionado ya está en uso',
    'email value is required' => 'Dirección de correo electrónico no introduccida, inténtelo de nuevo',
    'email address must be unique' => 'La dirección de correo ya está en uso, inténtelo con una distinta',
    'company value required' => 'El usuario debe pertenecer a una empresa/organización',
    'password value required' => 'Contraseña no introduccida, inténtelo de nuevo',
    'passwords dont match' => 'Las contraseñas introduccidas no coinciden, inténtelo de nuevo',
    'old password required' => 'Debe introducir la contraseña anterior',
    'invalid old password' => 'La contraseña anterior no es válida',
    'users must belong to a company' => 'Los contactos deben pertenecer a una empresa para poder crear un usuario',
    'contact linked to user' => 'El contacto introducido está vinculado con el usuario {0}',
    
    // Avatar
    'invalid upload type' => 'Tipo de archivo no válido. Son válidos {0}',
    'invalid upload dimensions' => 'La dimensión de la imagen no es válida. El valor máximo admitido es {0}x{1} píxeles',
    'invalid upload size' => 'La dimensión de la imagen no es válida. El valor máximo admitido es {0}',
    'invalid upload failed to move' => 'No se pudo mover el archivo cargado',
    
    // Registration form
    'terms of services not accepted' => 'Para poder crear una cuenta debe leer y aceptar los términos y condiciones de nuestros servicios',
    
    // Init company website
    'failed to load company website' => 'No se pudo cargar el sitio web. La compañía no fue encontrada',
    'failed to load project' => 'El sistema falló al cargar el área de trabajo',
    
    // Login form
    'username value missing' => 'Por favor, introduzca el nombre de usuario',
    'password value missing' => 'Por favor, introduzca su contraseña',
    'invalid login data' => 'El nombre de usuario o la contraseña son incorrectas, por favor, inténtelo de nuevo',
    
    // Add project form
    'project name required' => 'Nombre de área de trabajo no ingresado, inténtelo de nuevo',
    'project name unique' => 'El nombre de área de trabajo seleccionado ya está en uso, inténtelo con uno distinto',   
    // Add message form
    'message title required' => 'Título no introducido, inténtelo de nuevo',
    'message title unique' => 'El título introducido ya existe, inténtelo introduciendo uno distinto',
    'message text required' => 'Nota no introducida, inténtelo de nuevo',
    
    // Add comment form
    'comment text required' => 'Texto no introducido, inténtelo de nuevo',
    
    // Add milestone form
    'milestone name required' => 'Nombre del hito no introducido, inténtelo de nuevo',
    'milestone due date required' => 'Fecha de límite del hito es obligatoria',
    
    // Add task list
    'task list name required' => 'Nombre de tarea no introducido, inténtelo de nuevo',
    'task list name unique' => 'El nombre de tarea seleccionado ya existe, intente nuevamente ingresando uno distinto',
    'task title required' => 'Título de tarea no ingresado, intente nuevamente',
  
    // Add task
    'task text required' => 'Texto de tarea no introducido, inténtelo de nuevo',
    
    // Add event
    'event subject required' => 'El asunto del evento debe ser introducido, inténtelo de nuevo',
    'event description maxlength' => 'La descripción no debe pasar de 3.000 caracteres',
    'event subject maxlength' => 'El asunto no depe pasar de 100 caracteres',
    
    // Add project form
    'form name required' => 'Nombre de formulario no introducido, inténtelo de nuevo',
    'form name unique' => 'El nombre de formulario debe ser único, inténtelo de nuevo',
    'form success message required' => 'Mensaje de aprobación es obligatorio',
    'form action required' => 'Debe seleccionar una acción para el formulario',
    'project form select message' => 'Debe elegir una nota',
    'project form select task lists' => 'Debe elegir una tarea',
    
    // Submit project form
    'form content required' => 'Por favor, inserte el contenido en campo de texto',
    
    // Validate project folder
    'folder name required' => 'Nombre de carpeta obligatorio, inténtelo de nuevo',
    'folder name unique' => 'El nombre de carpeta debe ser único, inténtelo de nuevo con uno distinto',
    
    // Validate add / edit file form
    'folder id required' => 'Debe elegir una carpeta',
    'filename required' => 'Nombre de archivo obligatorio, inténtelo de nuevo',
    
    // File revisions (internal)
    'file revision file_id required' => 'La revisión debe estar conectada con un archivo',
    'file revision filename required' => 'Nombre de archivo obligatorio, inténtelo de nuevo',
    'file revision type_string required' => 'Tipo de archivo desconocido',
    
    // Test mail settings
    'test mail recipient required' => 'Debe introducir un destinatario',
    'test mail recipient invalid format' => 'La dirección del destinatario no es válida',
    'test mail message required' => 'Mensaje de mail requerido, inténtelo de nuevo',
    
    // Mass mailer
    'massmailer subject required' => 'Asunto del mensaje obligatorio, inténtelo de nuevo',
    'massmailer message required' => 'Cuerpo del mensaje obligatorio, inténtelo de nuevo',
    'massmailer select recepients' => 'Debe seleccionar destinatarios',
    
  	//Email module
  	'mail account name required' => 'Nombre de cuenta obligatorio, inténtelo de nuevo',
  	'mail account id required' => 'Identificación de cuenta obligatoria, inténtelo de nuevo',
  	'mail account server required' => 'Servidor obligatorio, inténtelo de nuevo',
  	'mail account password required' => 'Contraseña obligatoria, inténtelo de nuevo',	
  
  	'session expired error' => 'Sesión cerrada debido a su inactividad por tiempo prolongado',
  	'unimplemented type' => 'Tipo no implementado',
  	'unimplemented action' => 'Acción no implementada',
  
  	'workspace own parent error' => 'Un área de trabajo (no) puede ser su propio padre',
  	'task own parent error' => 'Una tarea (no) puede ser su propio padre',
  	'task child of child error' => 'Una tarea (no) puede ser hija de una de sus herederas',
  
  	'chart title required' => 'Se requiere el título de la gráfica.',
  	'chart title unique' => 'El título de la gráfica debe ser único.',
    'must choose at least one workspace error' => 'Debe elegir al menos un área de trabajo donde colocar el objeto.',
    
    'user has contact' => 'Ya hay un contacto asigando a este usuario',
  
  	'maximum number of users reached error' => 'El número máximo de usuarios ha sido alcanzado',
	'maximum number of users exceeded error' => 'El número máximo de usuarios ha sido sobrepasado. El sistema no volverá a funcionar hasta que este problema haya sido resuelto.',
	'maximum disk space reached' => 'Ha utilizado la totalidad del espacio en disco asignado. Borre objetos antes de ingresar nuevos, o contacte a soporte para que autorice más usuarios.'  ,
	'error db backup' => 'Error al crear respaldo de la base de datos. Verificar constante MYSQLDUMP_COMMAND.',
	'error create backup folder' => 'Error al crear carpeta de respaldo. No se puede completar el respaldo',
	'error delete backup' => 'Error al borrar el ultimo respaldo',
	'success delete backup' => 'Respaldo borrado',
    'name must be unique' => 'El nombre del contacto ya está en uso',
  ); // array

?>