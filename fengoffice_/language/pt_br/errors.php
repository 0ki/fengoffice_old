<?php

  // Return langs
  
  return array(
  
    // General
    'invalid email address' => 'Endereço de email inválido',
   
    // Company validation errors
    'company name required' => 'Nome da organização é requerido',
    'company homepage invalid' => 'Site com URL inválida',
    
    // User validation errors
    'username value required' => 'Login requerido',
    'username must be unique' => 'Login já utilizado',
    'email value is required' => 'Endereço de email requerido',
    'email address must be unique' => 'Endereço de email já utilizado',
    'company value required' => 'Usuário deve ser de alguma organização',
    'password value required' => 'Senha requerida',
    'passwords dont match' => 'Confirme a senha. Senha não coincide.',
    'old password required' => 'Senha antiga requerida',
    'invalid old password' => 'Senha antiga inválida',
    'users must belong to a company' => 'Os contatos devem pertencer à uma empresa para poder criar um usuário',
    'contact linked to user' => 'O contato introduzido está vinculado ao usuário {0}',
    
    // Avatar
    'invalid upload type' => 'Tipo de arquivo inválido. Tipos permitidos são {0}',
    'invalid upload dimensions' => 'Dimensões das imagens inválidas. O tamanho máximo é {0} x {1} pixels',
    'invalid upload size' => 'Tamanho da imagem inválida. O tamanho máximo é {0}',
    'invalid upload failed to move' => 'Falha ao carregar arquivo',
    
    // Registration form
    'terms of services not accepted' => 'Para criar uma conta você necessita ler e aceitar nosso termo de serviço',
    
    // Init company website
    'failed to load company website' => 'Falha ao carregar o site. Organização proprietária não encontrada',
    'failed to load project' => 'Falha ao carregar projeto ativo',
    
    // Login form
    'username value missing' => 'Insira seu login',
    'password value missing' => 'Insira sua senha',
    'invalid login data' => 'O login falhou. verifique seus dados e tente novamente',
    
    // Add project form
    'project name required' => 'O nome do projeto é requerido',
    'project name unique' => 'O nome do projeto deve ser único',
    
    // Add message form
    'message title required' => 'Título requerido',
    'message title unique' => 'O título deve ser único no projeto',
    'message text required' => 'Texto requerido',
    
    // Add comment form
    'comment text required' => 'O texto do comentário é requerido',
    
    // Add milestone form
    'milestone name required' => 'Nome do milestone requerido',
    'milestone due date required' => 'O prazo do milestone é requerido',
    
    // Add task list
    'task list name required' => 'O nome da lista de tarefas é requerido',
    'task list name unique' => 'O nome da lista de tarefas deve ser único no projeto',
    'task title required' => 'Título de tarea no ingresado, intente nuevamente',
    
    // Add task
    'task text required' => 'O texto da tarefa é requerido',
    
    // Add event
    'event subject required' => 'Assunto do evento é requerido',
    'event description maxlength' => 'A descrição é limitada a 3.000 caracteres',
    'event subject maxlength' => 'O assunto é limitado à 100 caracteres',
    
    // Add project form
    'form name required' => 'O nome do formulário é requerido',
    'form name unique' => 'O nome do formulário deve ser único',
    'form success message required' => 'A mensagem de sucesso é requerida',
    'form action required' => 'A ação do formulário é requerida',
    'project form select message' => 'Selecione a mensagem',
    'project form select task lists' => 'Selecione a lista de tarefas',
    
    // Submit project form
    'form content required' => 'Insira o conteúdo no campo de texto',
    
    // Validate project folder
    'folder name required' => 'O nome da pasta é requerido',
    'folder name unique' => 'O nome da pasta deve ser única no projeto',
    
    // Validate add / edit file form
    'folder id required' => 'Selecione uma pasta',
    'filename required' => 'Nome do arquivo requerido',
    
    // File revisions (internal)
    'file revision file_id required' => 'A revisão necessita ser relacionada com um arquivo',
    'file revision filename required' => 'Nome do arquivo requerido',
    'file revision type_string required' => 'Tipo de arquivo desconhecido',
    
    // Test mail settings
    'test mail recipient required' => 'Destinatário requerido',
    'test mail recipient invalid format' => 'Formato inválido do endereço do destinatário',
    'test mail message required' => 'Mensagem requerida',
    
    // Mass mailer
    'massmailer subject required' => 'Assunto da mensagem requerida',
    'massmailer message required' => 'Corpo da mensagem requerido',
    'massmailer select recepients' => 'Selecione os usuários que receberão esta mensagem',
    
  	//Email module
  	'mail account name required' => 'Nome da conta de email é requerido',
  	'mail account id required' => 'Identificação da da conta de email é requerido',
  	'mail account server required' => 'Servidor é requerido',
  	'mail account password required' => 'Senha é requerida',	
  
  	'session expired error' => 'Sessão encerrada por inatividade prolongada',
  	'unimplemented type' => 'Tipo não implementado',
  	'unimplemented action' => 'Ação não implementada',
  
  	'workspace own parent error' => 'Uma área de trabalho não pode ser pai de si mesma',
  	'task own parent error' => 'Uma tarefa não pode ser pai de si mesma',
  	'task child of child error' => 'Uma tarefa não pode ser filha de uma de suas tarefas filhas',
  
  	'chart title required' => 'Título do gráfico é requerido.',
  	'chart title unique' => 'Título do gráfico deve ser único.',
    'must choose at least one workspace error' => 'Deve escolher ao menos uma Área de Trabalho para colocar o objeto.',
    
    'user has contact' => 'Existe um contato atribuído a este usuario',
  
  	'maximum number of users reached error' => 'Número máximo de usuários atingido',
	'maximum number of users exceeded error' => 'Número máximo de usuários excedido. O sistema não voltará a funcionar até que este problema tenha sido resolvido.',
	'maximum disk space reached' => 'Your disk quota is full. Please delete some object before trying to add new ones, or contact support to enable more users.',
	'error db backup' => 'Error while creating database backup. Check MYSQLDUMP_COMMAND constant.',
	'error create backup folder' => 'Error while creating backup folder. Cannot complete backup',
	'error delete backup' => 'Error while deleting database backup,',
	'success delete backup' => 'Backup was deleted',
  ); // array

?>
