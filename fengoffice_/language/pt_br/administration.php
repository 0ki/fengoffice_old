<?php

	return array(

    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------

    'administration tool name test_mail_settings' => 'Teste das configurações do email',
    'administration tool desc test_mail_settings' => 'Use esta ferramenta para enviar emails de testes para checar se o OpenGoo está corretamente configurado',
	'administration tool name mass_mailer' => 'Mensagens em massa',
    'administration tool desc mass_mailer' => 'Ferramenta que permite enviar mensagens a qualquer grupo de usuários registrados no sistema',

    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------

    'configuration' => 'Configuração',
    'mail transport mail()' => 'Configurações padrões do PHP',
    'mail transport smtp' => 'Servidor de SMTP',
    'secure smtp connection no'  => 'Não',
    'secure smtp connection ssl' => 'Sim, use SSL',
    'secure smtp connection tls' => 'Sim, use TLS',
    'file storage file system' => 'Sistema de arquivos',
    'file storage mysql' => 'Base de dados (MySQL)',

    // Categories
    'config category name general' => 'Geral',
    'config category desc general' => 'Configurações gerais do OpenGoo',
    'config category name mailing' => 'Mailing',
    'config category desc mailing' => 'Use este conjunto de configurações para que o OpenGoo possa enviar email. Você pode usar as opções de configuração fornecidas pelo seu php.ini ou configurá-lo para usar um outro servidor SMTP',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------

    // General
    'config option name site_name' => 'Nome do site',
    'config option desc site_name' => 'O nome do site será apresentado no Painel Principal',
    'config option name file_storage_adapter' => 'Armazenamento de arquivos',
    'config option desc file_storage_adapter' => 'Selecione onde você deseja armazenar os anexos, avatars, logotipos e qualquer outro documento carregado. <strong>A base de dados é recomendada</strong>.',
    'config option name default_project_folders' => 'Pastas padrões',
    'config option desc default_project_folders' => 'Pastas que serão criadas quando o projeto é criado. Um nome de pasta por linha. Linhas duplicadas ou vazias serão ignoradas',
    'config option name theme' => 'Tema',
    'config option desc theme' => 'Usando temas você pode alterar a aparência padrão do OpenGoo',
    // OpenGoo.org
    'config option name upgrade_check_enabled' => 'Permitir a verificação de atualizações',
    'config option desc upgrade_check_enabled' => 'Se "Sim" o sistema vai buscar uma vez por dia se há novas versões do OpenGoo disponível para download',


    // Mailing
    'config option name exchange_compatible' => 'Modo de compatibilidade com o Microsoft Exchange',
    'config option desc exchange_compatible' => 'Se você estiver usando o Microsoft Exchange Server e marcar esta opção com "Sim" evitará problemas conhecidos.',
    'config option name mail_transport' => 'Transporte de email',
    'config option desc mail_transport' => 'Você pode usar as configurações do PHP para enviar mensagens ou especificar um servidor SMTP',
    'config option name smtp_server' => 'Servidor SMTP',
    'config option name smtp_port' => 'Porta SMTP',
    'config option name smtp_authenticate' => 'Usar autenticação SMTP',
    'config option name smtp_username' => 'Login do SMTP',
    'config option name smtp_password' => 'Senha do SMTP',
    'config option name smtp_secure_connection' => 'Use conexão SMTP segura',
 	'can edit company data' => 'Permitir editar dados da Empresa',
  	'can manage security' => 'Permitir editar configurações de seguranca',
  	'can manage workspaces' => 'Permitir editar configurações da Area de Trabalho',
  	'can manage configuration' => 'Permitir editar configurações',
  	'can manage contacts' => 'Permitir editar contatos',
  	'group users' => 'Agrupar usuarios',
  	'user ws config category name dashboard' => 'Opções do Painel Principal',
  	'user ws config category name task panel' => 'Opções do Painel de tarefas',
  	'user ws config option name show pending tasks widget' => 'Mostrar quadro de tarefas pendentes',
  	'user ws config option name pending tasks widget assigned to filter' => 'Mostrar tarefas atribuidas a',
  	'user ws config option name show late tasks and milestones widget' => 'Mostrar quadro de marcos e tarefas atrasadas',
  	'user ws config option name show messages widget' => 'Mostrar quadro mensagens',
  	'user ws config option name show comments widget' => 'Mostrar quadro de comentários',
  	'user ws config option name show documents widget' => 'Mostrar quadro de documentos',
  	'user ws config option name show calendar widget' => 'Mostrar quadro de calendário',
  	'user ws config option name show charts widget' => 'Mostrar quadro de gráficos',
  	'user ws config option name show emails widget' => 'Mostrar quadro de emails',

 	'user ws config option name my tasks is default view' => 'Visão padrão exibe apenas as tarefas a mim atribuídas',
  	'user ws config option desc my tasks is default view' => 'Se selecionar não, então exibe todas as tarefas',
  	'user ws config option name show tasks in progress widget' => 'Show \'Tasks in progress\' widget',
  	'user ws config option name can notify from quick add' => 'Notification checkbox in quick add',
  	'user ws config option desc can notify from quick add' => 'A checkbox is enabled so assigned users can be notified after quick addition on a task',
 	
  	'backup process desc' => 'A backup saves the current state of the whole application into a compressed folder. It can de used to easily backup an OpenGoo installation. <br> Generating a backup of the database and filesystem can last more than a couple of seconds, so making a backup is a process consisting on three steps: <br>1.- Launch a backup process, <br>2.- Download the backup. <br> 3.- Optionally, a backup can be manually deleted so that it is not available in the future. <br> ',
  	'start backup' => 'Launch backup process',
    'start backup desc' => 'Launching a backup process implies deleting previous backups, and generating a new one.',
  	'download backup' => 'Download backup',
    'download backup desc' => 'To be able to download a backup you must first generate a backup.',
  	'delete backup' => 'Delete backup',
    'delete backup desc' => 'Deletes the last backup so that it is not available for download. Deleting backups after download is highly recommended.',
    'backup' => 'Backup',
    'backup menu' => 'Backup Menu',
   	'last backup' => 'Last backup was created on',
   	'no backups' => 'There are no backups to download',
   	
   	'user ws config option name always show unread mail in dashboard' => 'Always show unread email in dashboard',
   	'user ws config option desc always show unread mail in dashboard' => 'When NO is chosen emails from the active workspace will be shown',
   	'workspace emails' => 'Workspace Mails',
  	'user ws config option name tasksShowWorkspaces' => 'Exibir Espaços de Trabalho',
  	'user ws config option name tasksShowTime' => 'Exibir horas',
  	'user ws config option name tasksShowDates' => 'Exibir datas',
  	'user ws config option name tasksShowTags' => 'Exibir Tags',
  	'user ws config option name tasksGroupBy' => 'Grupar por',
  	'user ws config option name tasksOrderBy' => 'Ordenar por',
  	'user ws config option name task panel status' => 'Status',
  	'user ws config option name task panel filter' => 'Filtrar por',
  	'user ws config option name task panel filter value' => 'Valor do Filtro',
	); // array
?>