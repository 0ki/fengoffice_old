<?php

  /**
  * Error messages
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  * @czech translation Ludek Smolik <lu@wo.cz>
  */

  // Return langs
  return array(
  
    // General
    'invalid email address' => 'Formát e-mailové adresy není platný',
   
    // Company validation errors
    'company name required' => 'Je vyžadníván název společnosti / organizace',
    'company homepage invalid' => 'Domovská stránka nemá platné URL',
    
    // User validation errors
    'username value required' => 'Je vyžadováno uživatelské jméno',
    'username must be unique' => 'Litujeme, ale vybrané uživatelské jméno je již používáno',
    'email value is required' => 'Je vyžadována e-mailová adresa',
    'email address must be unique' => 'Litujeme, vybraná e-mailová adresa je již používána',
    'company value required' => 'Uživatel musí být součástí společnosti / organizace',
    'password value required' => 'Je vyžadováno heslo',
    'passwords dont match' => 'Hesla se neshodují',
    'old password required' => 'Je vyžadováno staré heslo',
    'invalid old password' => 'Staré heslo není správné',
    'users must belong to a company' => 'Aby bylo možné vytvořit uživatele, kontakt musí náležet ke společnosti',
    'contact linked to user' => 'Kontakt je spojen s uživatelem {0}',
    
    // Avatar
    'invalid upload type' => 'Neplatný typ souboru. Podporované typy jsou {0}',
    'invalid upload dimensions' => 'Neplatná velikost obrázku. Maximální velikost je {0}x{1} pixelů',
    'invalid upload size' => 'Neplatná velikost obrázku. Maximální velikost je {0}',
    'invalid upload failed to move' => 'Nepodařilo se přesunout nahraný soubor',
    
    // Registration form
    'terms of services not accepted' => 'Abyste mohli vytvořit účet, musíte nejprve číst a souhlasit s podmínkami využití služeb.',
    
    // Init company website
    'failed to load company website' => 'Načítání stránky se nezdařilo. Vlastník společnosti nebyl nalezen',
    'failed to load project' => 'Načtení aktivní pracovní plochy projektu se nezdařilo',
    
    // Login form
    'username value missing' => 'Prosím, zadejte Vaše uživatelské jméno',
    'password value missing' => 'Prosím, zadejte Vaše heslo',
    'invalid login data' => 'Vaše přihlášení se nezdařilo. Prosím, zkontrolujte Vaše přihlašovací údaje a zkuste to znovu',
    
    // Add project form
    'project name required' => 'Je vyžadován název pracovní plochy',
    'project name unique' => 'Název pracovní plochy musí být jedinečný',
    
    // Add message form
    'message title required' => 'Je vyžadován název hodnoty',
    'message title unique' => 'Název hodnoty musí být jedinečný pro tuto pracovní plochu.',
    'message text required' => 'Je vyžadována textová hodnota',
    
    // Add comment form
    'comment text required' => 'Je vyžadován text komentáře',
    
    // Add milestone form
    'milestone name required' => 'Je vyžadován název milníku',
    'milestone due date required' => 'Datum splatnosti milníku musí být zadáno',
    
    // Add task list
    'task list name required' => 'Název úkolu musí být zadán',
    'task list name unique' => 'Název úkolu v této pracovní ploše musí být jedinečný',
    'task title required' => 'Je vyžadován název úkolu',
  
    // Add task
    'task text required' => 'Je vyžadován text úkolu',
    
    // Add event
    'event subject required' => 'Je vyžadováno zadání předmětu události',
    'event description maxlength' => 'Popis musí míž méně než 3000 znaků',
    'event subject maxlength' => 'Předmět musí mít méně než 100 znaků',
    
    // Add project form
    'form name required' => 'Je vyžadován název formuláře',
    'form name unique' => 'Název formuláře musí být jedinečný',
    'form success message required' => 'Je vyžadována zpráva o úspěchu',
    'form action required' => 'Je vyžadována formulářová akce',
    'project form select message' => 'Prosím, vyberte poznámku',
    'project form select task lists' => 'Prosím, vyberte úkol',
    
    // Submit project form
    'form content required' => 'Prosím, vložte obsah do textového pole',
    
    // Validate project folder
    'folder name required' => 'Je vyžadován název adresáře',
    'folder name unique' => 'Název adresáře musí být pro tuto pracovní plochu jedinečný',
    
    // Validate add / edit file form
    'folder id required' => 'Prosím vyberte adresář',
    'filename required' => 'Název souboru je vyžadován',
    
    // File revisions (internal)
    'file revision file_id required' => 'Revize musí být připojena k souboru',
    'file revision filename required' => 'Je vyžadkován název souboru',
    'file revision type_string required' => 'Neznámý typ souboru',
    
    // Test mail settings
    'test mail recipient required' => 'Adresa příjemce je vyžadována',
    'test mail recipient invalid format' => 'Neplatný formát adresy příjemce',
    'test mail message required' => 'E-mailová zpráva je vyžadována',
    
    // Mass mailer
    'massmailer subject required' => 'Předmět zprávy je vyžadován',
    'massmailer message required' => 'Tělo zprávy je vyžadováno',
    'massmailer select recepients' => 'Prosím, vyberte uživatele pro které je určena tato e-mailová zpráva',
    
  	//Email module
  	'mail account name required' => 'Název účtu je vyžadován',
  	'mail account id required' => 'Je vyžadováno Id účtu',
  	'mail account server required' => 'Server je vyžadován',
  	'mail account password required' => 'Heslo je vyžadováno',	
  
  	'session expired error' => 'Sezení vypršelo díky neaktivitě uživatele. Prosím, přihlaste se znovu',
  	'unimplemented type' => 'Neimplementovaný typ',
  	'unimplemented action' => 'Neimplementovaná akce',
  
  	'workspace own parent error' => 'Tato plocha nemůže být vlastní rodičovskou plochou',
  	'task own parent error' => 'Tento úkol nemůže být vlastním rodičovským úkolem',
  	'task child of child error' => 'Tento úkol nemůže být dítětem jednoho ze svých potomků',
  
  	'chart title required' => 'Název grafu je vyžadován.',
  	'chart title unique' => 'Název grafu musí být jedinečný.',
    'must choose at least one workspace error' => 'Musíte vybrat nejméně jednu pracovní plochu na kterou umístíte objekt.',
    
    
    'user has contact' => 'Tomuto uživateli již byl přidán kontakt',
    
    'maximum number of users reached error' => 'Byl dosažen maximální počet uživatelů',
	'maximum number of users exceeded error' => 'Maximální počet uživatelů byl překročen. Aplikace nebude pracovat, dokud nebude tento problém vyřešen.',
	'maximum disk space reached' => 'Your disk quota is full. Please delete some object before trying to add new ones, or contact support to enable more users.',
	'error db backup' => 'Při vytváření zálohy databáze se vyskytla chyba. Zkontrolujte příkaz MYSQLDUMP_COMMAND.',
	'error create backup folder' => 'Chyba při vytváření záložního adresáře. Nemohu dokončit zálohu',
	'error delete backup' => 'Chyba při mazání zálohy databáze,',
	'success delete backup' => 'Záloha byla smazána',
    'name must be unique' => 'Litujeme, ale vybaný název je již používán',
   ); // array

?>
