<?php

  /**
  * Array of messages file (error, success message, status...)
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  * @french release by Jean-Bernard François <jbf (at) infofiltrage (dot) com>
  */

  return array(
  
    // Empty, dnx et
    'no mail accounts set' => 'Il n\'y a pas de compte courriel pour envoyer ce message, alors veuillez d\'abord en créer un',
    'no mail accounts set for check' => 'Vous n\'avez pas de compte courriel pour envoyer ce message, alors veuillez d\'abord en créer un',
    'email dnx' => 'Le courriel demandé n\'existe pas',
  	'email dnx deleted' => 'Le courriel demandé a été effacé de la base de données',
    'project dnx' => 'Le contexte demandé n\'existe pas dans la base de données',
    'contact dnx' => 'Le contact demandé n\'existe pas dans la base de données',
    'company dnx' => 'La société demandée n\'existe pas dans la base de données',
    'message dnx' => 'La note demandée n\'existe pas',
    'no comments in message' => 'Il n\'y a pas de commentaire pour cette note',
    'no comments associated with object' => 'Il n\'y a pas de commentaire pour cet objet',
    'no messages in project' => 'Il n\'y a pas de notes pour ce contexte',
    'no subscribers' => 'Il n\'y a pas d\'utilisateurs qui ont souscrit à cet objet',
    'no activities in project' => 'Il n\'y a pas d\'activitée pour ce contexte',
    'comment dnx' => 'Le commentaire demandé n\'existe pas',
    'milestone dnx' => 'Le jalon demandé n\'existe pas',
    'task list dnx' => 'La tâche demandée n\'existe pas',
    'task dnx' => 'La tâche demandée n\'existe pas',
    'event type dnx' => 'Le type d\évènement demandé n\'existe pas',
    'no milestones in project' => 'Il n\'y a pas de jalon dans ce contexte',
    'no active milestones in project' => 'Il n\'y a pas de jalon actif ce contexte',
    'empty milestone' => 'Ce jalon est vide. Vous pouvez lui ajouter une <a class="internalLink" href="{1}">tâche</a> n\'importe quand',
    'no logs for project' => 'Il n\'y a pas  d\'entrée de suivi au sujet de ce contexte',
    'no recent activities' => 'Il n\'y a pas  d\'activité récente enregistré dans la base de données',
    'no open task lists in project' => 'Il n\'y a pas de tâche ouverte dans ce contexte',
    'no completed task lists in project' => 'Il n\'y a pas de tâche achevées dans ce contexte',
    'no open task in task list' => 'Il n\'y a pas de tâche ouverte dans cette liste',
    'no closed task in task list' => 'Il n\'y a pas de tâche fermée dans cette liste',
    'no open task in milestone' => 'Il n\'y a pas de tâche ouverte pour ce jalon',
    'no closed task in milestone' => 'Il n\'y a pas de tâche fermée pour ce jalon',
    'no projects in db' => 'Il n\'y a pas de contextes définis dans cette base de données',
    'no projects owned by company' => 'Il n\'y a pas de contextes appartenant à cette société',
    'no projects started' => 'Il n\'y a pas de contextes en cours',
    'no active projects in db' => 'Il n\'y a pas de contextes actifs',
    'no new objects in project since last visit' => 'Il n\'y a pas  d\'objets nouveaux dans ce contexte depuis votre dernière visite',
    'no clients in company' => 'Votre société n\'a aucun client enregistré',
    'no users in company' => 'Il n\'y a pas d\'utilistateur dans cette société',
    'client dnx' => 'Le client de cette société sélectionné n\'existe pas',
    'company dnx' => 'La société sélectionnée n\'existe pas',
    'user dnx' => 'L\'utilisateur demandé n\'existe pas dans la base de données',
    'avatar dnx' => 'L\'Avatar n\'existe pas',
    'no current avatar' => 'L\'Avatar n\'a pas été chargé',
    'picture dnx' => 'L\'image n\'existe pas',
    'no current picture' => 'L\'image n\'a pas été chargé',
    'no current logo' => 'Le logo n\'a pas été chargé',
    'user not on project' => 'L\'utilisateur sélectionné n\'est pas concerné par le contexte sélectionné',
    'company not on project' => 'La société sélectionnée n\'est pas concernée par le contexte sélectionné',
    'user cant be removed from project' => 'L\'utilisateur sélectionné ne peut être retiré du contexte',
    'tag dnx' => 'L\'étiquette demandée n\'existe pas',
    'no tags used on projects' => 'Aucune étiquette n\'est utilisée pour ce contexte',
    'no forms in project' => 'Il n\'y a pas de formulaire pour ce contexte',
    'project form dnx' => 'Le formulaire de contexte demandé n\'existe pas dans la base de données',
    'related project form object dnx' => 'Le formulaire concerné n\'existe pas dans la base de données',
    'no my tasks' => 'Aucune tâche ne vous est affectée',
    'no search result for' => 'Aucun objet ne correspond à "<strong>{0}</strong>"',
    'no files on the page' => 'Il n\'y a aucun fichier sur cette page',
    'folder dnx' => 'Le dossier demandé n\'existe pas dans la base de données',
    'define project folders' => 'Il n\'y a pas de dossiers dans ce contexte. Veuillez définir un dossier pour continuer',
    'file dnx' => 'Le fichier demandé n\'existe pas dans la base de données',
    'not s5 presentation' => 'Ne peut pas démarrer la présentation parce que ce fichier n\'est pas une présentation S5 valide',
    'file not selected' => 'Aucun fichier n\est sélectionné',
    'file revision dnx' => 'La révision demandée n\'existe pas dans la base de données',
    'no file revisions in file' => 'Fichier invalide - Aucune révision n\'est associée à ce fichier',
    'cant delete only revision' => 'Vous ne pouvez pas effacer cette révision. Chaque fichier doit avoir au moins une révision.',
    'config category dnx' => 'La catégorie de configuration demandée n\'existe pas',
    'config category is empty' => 'La catégorie de configuration sélectionnée est vide',
    'email address not in use' => '{0} n\'est pas utilisée',
    'no linked objects' => 'Aucun objet n\'est lié à cet objet',
    'object not linked to object' => 'Aucun lien n\'existe entre les objets sélectionnés',
    'no objects to link' => 'Veuillez sélectionner les objets à lier',
    'no administration tools' => 'Il n\'y a pas d\'outils d\'administration dans la base de données',
    'administration tool dnx' => 'Les outils d\'administration "{0}" n\'existent pas',
    
    // Success
    'success add contact' => 'Contact \'{0}\' a bien été créé',
    'success edit contact' => 'Contact \'{0}\' a bien été modifié',
    'success delete contact' => 'Contact \'{0}\' a bien été supprimé',
    'success edit picture' => 'L\'image a bien été modifiée',
    'success delete picture' => 'L\'image a bien été supprimée',
    
    'success add project' => 'Le contexte {0} a bien été ajouté',
    'success edit project' => 'Le contexte {0} a été modifié',
    'success delete project' => 'Le contexte {0} a été supprimé',
    'success complete project' => 'Le contexte {0} a été achevé',
    'success open project' => 'Le contexte {0} a été réouvert',
    
    'success add milestone' => 'Le jalon \'{0}\' a bien été créé',
    'success edit milestone' => 'Le jalon \'{0}\' a bien été modifié',
    'success deleted milestone' => 'Le jalon \'{0}\' a bien été supprimé',
    
    'success add message' => 'La note {0} a bien été ajoutée',
    'success edit message' => 'La note {0} a bien été modifiée',
    'success deleted message' => 'La note \'{0}\' et tous ses commentaires a bien été supprimée',
    
    'success add comment' => 'Le commentaire a bien été posté',
    'success edit comment' => 'Le commentaire a bien été modifié',
    'success delete comment' => 'Le commentaire a bien été supprimé',
    
    'success add task list' => 'La tâche \'{0}\' a été ajoutée',
    'success edit task list' => 'La tâche \'{0}\' a été modifiée',
    'success delete task list' => 'La tâche \'{0}\' a été supprimée',
    
    'success add task' => 'La tâche sélectionnée a été ajoutée',
    'success edit task' => 'La tâche sélectionnée a été modifiée',
    'success delete task' => 'La tâche sélectionnée a été supprimée',
    'success complete task' => 'La tâche sélectionnée a été achevée',
    'success open task' => 'La tâche sélectionnée a été réouverte',
    'success n tasks updated' => '{0} tâche modifiée',
	'success add mail' => 'Envoi de courriel réussi',
    
    'success add client' => 'Le client de la société {0} a été ajouté',
    'success edit client' => 'Le client de la société {0} a été modifié',
    'success delete client' => 'Le client de la société {0} a été supprimé',
    
    'success add group' => 'Le groupe {0} a été ajouté',
    'success edit group' => 'Le groupe {0} a été modifié',
    'success delete group' => 'Le groupe {0} a été supprimé',
    
    'success edit company' => 'Les données de la société ont été modifiées',
    'success edit company logo' => 'Le logo de la société a été modifié',
    'success delete company logo' => 'Le logo de la société a été supprimé',
    
    'success add user' => 'L\'utilisateur {0} a bien été ajouté',
    'success edit user' => 'L\'utilisateur {0} a bien été modifié',
    'success delete user' => 'L\'utilisateur {0} a bien été supprimé',
    
    'success update project permissions' => 'Les permissions du contexte ont bien été modifiées',
    'success remove user from project' => 'L\'utilisateur a bien été retiré du contexte',
    'success remove company from project' => 'La société a bien été retirée du contexte',
    
    'success update profile' => 'Le profil a été modifié',
    'success edit avatar' => 'L\'avatar a bien été modifié',
    'success delete avatar' => 'L\'avatar a bien été supprimé',
    
    'success hide welcome info' => 'Le message d\'accueil a bien été caché',
    
    'success complete milestone' => 'Le jalon \'{0}\' a été achevé',
    'success open milestone' => 'Le jalon \'{0}\' a été réouvert',
    
    'success subscribe to object' => 'Vous êtes bien abonné à cet objet',
    'success unsubscribe to object' => 'Vous êtes bien désabonné de cet objet',
    
    'success add project form' => 'Le formulaire \'{0}\' a été ajouté',
    'success edit project form' => 'Le formulaire \'{0}\' a été modifié',
    'success delete project form' => 'Le formulaire \'{0}\' a été supprimé',
    
    'success add folder' => 'Le dossier \'{0}\' a été ajouté',
    'success edit folder' => 'Le dossier \'{0}\' a été modifié',
    'success delete folder' => 'Le dossier \'{0}\' a été supprimé',
    
    'success add file' => 'Le fichier \'{0}\' a été ajouté',
	'success save file' => 'Le fichier \'{0}\' a été enregistré',
    'success edit file' => 'Le fichier \'{0}\' a été modifié',
    'success delete file' => 'Le fichier \'{0}\' a été supprimé',
    'success delete files' => '{0} fichier(s) ont été supprimé',
    'success tag files' => '{0} fichier(s) ont été marqué',
    'success tag contacts' => '{0} contact(s) ont été marqué',
    
    'success add handis' => 'Handins ont été modifié',
    
    'success add properties' => 'Les propriétés ont été modifiées',
    
    'success edit file revision' => 'La révision a été modifiée',
    'success delete file revision' => 'La révision du fichier a été supprimée',
    
    'success link objects' => '{0} objet(s) ont bien été liés',
    'success unlink object' => 'Les objet ont bien été déliés',
    
    'success update config category' => 'Les valeurs {0} de configuration ont été modifiées',
    'success forgot password' => 'Un nouveau mot-de-passe vous a été envoyé par courriel',
    
    'success test mail settings' => 'Un courriel de test a bien été envoyé',
    'success massmail' => 'Un courriel a été envoyé',
    
    'success update company permissions' => 'Les permissions de la société ont bien été modifiées. {0} enregistrements modifiés',
    'success user permissions updated' => 'Les permissions de l\'utilisateur ont été modifiées',
  
    'success add event' => 'L\'évènement a été ajouté',
    'success edit event' => 'L\'évènement a été modifié',
    'success delete event' => 'L\'évènement a été supprimé',
    
    'success add event type' => 'Le type d\'évènement a été ajouté',
    'success delete event type' => 'Le type d\'évènement a été supprimé',
    
    'success add webpage' => 'Le lien Web a été ajouté',
    'success edit webpage' => 'Le lien Web a été modifié',
    'success deleted webpage' => 'Le lien Web a été supprimé',
    
    'success add chart' => 'Le graphique a été ajouté',
    'success edit chart' => 'Le graphique a été modifié',
    'success delete chart' => 'Le graphique a été supprimé',
    'success delete charts' => 'Les graphiques sélectionnés ont bien été supprimés',
  
    'success delete contacts' => 'Les contacts sélectionnés ont bien été supprimés',
  
    'success classify email' => 'Le courriel a bien été classé',
    'success delete email' => 'Le courriel a été supprimé',
  
    'success delete mail account' => 'Le compte courriel a bien été supprimé',
    'success add mail account' => 'Le compte courriel a bien été créé',
    'success edit mail account' => 'Le compte courriel a bien été modifié',
  
    'success link object' => 'L\'objet a bien été lié',
  
  	'success check mail' => 'La relève du courriel est achevé: {0} courriels reçus.',
  	'success delete objects' => '{0} objet(s) ont bien été supprimés',
	'success tag objects' => '{0} Objet(s) ont bien été marqués ',
	'error delete objects' => 'Echec de suppression de(s) objet(s) {0} ',
	'error tag objects' => 'Echec de marquage de(s) objet(s) {0}',
	'success move objects' => 'Le(s) objet(s) {0} ont bien été déplacé',
	'error move objects' => 'Echec de déplacement de(s) objet(s) {0}',
    'success checkout file' => 'Fichier bien enregistré',
    'success checkin file' => 'Fichier bien vérifié',
  	'success undo checkout file' => 'La vérification du fichier a bien été annulée',
    
    // Failures
    'error edit timeslot' => 'Echec d\'enregistrement d\'un intervalle de temps',
  	'error delete timeslot' => 'Echec de suppression de l\'intervalle de temps',
  	'error add timeslot' => 'Echec d\'ajout de l\'intervalle de temps',
  	'error open timeslot' => 'Echec d\'ouverture de l\'intervalle de temps',
  	'error close timeslot' => 'Echec de fermeture de l\'ntervalle de temps',
    'error start time after end time' => 'Echec d\'enregistrement de l\'intervalle de temps : l\'heure de début doit être antérieure à l\'heure de fin.',
    'error form validation' => 'Echec d\'enregistrement de l\'object car certaines propriétés ne sont pas valides',
    'error delete owner company' => 'La société propriétaire ne peut pas être supprimée',
    'error delete message' => 'Echec de suppression de la note sélectionnée',
    'error update message options' => 'Echec de modification des options de la note',
    'error delete comment' => 'Echec de suppression des commentaires sélectionnés',
    'error delete milestone' => 'Echec de suppression du jalon sélectionné',
    'error complete task' => 'Echec d\'achèvement de la tâche sélectionnée',
    'error open task' => 'Echec de réouverture de la tâche sélectionnée',
    'error upload file' => 'Echec de chargement du fichier',
    'error delete project' => 'Echec de suppression du contexte sélectionné',
    'error complete project' => 'Echec d\'achèvement du contexte sélectionné',
    'error open project' => 'Echec de réouverture du contexte sélectionné',
    'error delete client' => 'Echec de suppression de la société cliente sélectionnée',
    'error delete group' => 'Echec de suppression du groupe sélectionné',
    'error delete user' => 'Echec de suppression de l\'utilisateur sélectionné',
    'error update project permissions' => 'Echec de modification des permissions du contexte',
    'error remove user from project' => 'Echec de suppression de l\'utilisateur du contexte',
    'error remove company from project' => 'Echec de suppression de la société du contexte',
    'error edit avatar' => 'Echec d\'édition de l\'avatar',
    'error delete avatar' => 'Echec de suppression de l\'avatar',
    'error edit picture' => 'Echec d\'édition de l\'image',
    'error delete picture' => 'Echec de suppression de l\'image',
    'error edit contact' => 'Echec d\'édition du contact',
    'error delete contact' => 'Echec de suppression du contact',
    'error hide welcome info' => 'Echec de dissimulation du message d\'accueil',
    'error complete milestone' => 'Echec d\'achèvement du jalon',
    'error open milestone' => 'Echec de réouverture du jalon sélectionné',
    'error file download' => 'Echec de téléchargement du fichier spécifié',
    'error link object' => 'Echec de liaison de l\'objet',
    'error edit company logo' => 'Echec de modification du logo de la société',
    'error delete company logo' => 'Echec de suppression du logo de la société',
    'error subscribe to object' => 'Echec de souscription à l\'objet sélectionné',
    'error unsubscribe to object' => 'Echec de désabonnement à l\'objet sélectionné',
    'error add project form' => 'Echec d\'ajout de formulaire de contexte',
    'error submit project form' => 'Echec de soumission de formulaire de contexte',
    'error delete folder' => 'Echec de suppression du dossier sélectionné',
    'error delete file' => 'Echec de suppression du fichier sélectionné',
    'error delete files' => 'Echec de suppression des fichiers {0}',
    'error tag files' => 'Echec de marquage des fichiers {0}',
    'error tag contacts' => 'Echec de marquage des contacts {0}',
    'error delete file revision' => 'Echec de suppresion de la révision de fichier',
    'error delete task list' => 'Echec de suppression de la tâche sélectionnée',
    'error delete task' => 'Echec de suppression de la tâche sélectionnée',
    'error check for upgrade' => 'Echec de vérification d\'une nouvelle version',
    'error link object' => 'Echec de liaison d\'objet(s)',
    'error unlink object' => 'Echec de déliaison d\'objet(s)',
    'error link objects max controls' => 'Ajout de liens impossible : la limite est de {0}',
    'error test mail settings' => 'Echec d\'envoi du message de test',
    'error massmail' => 'Echec d\'envoi du courriel',
    'error owner company has all permissions' => 'La société propriétaire a toute les permissions',
    'error while saving' => 'Une erreur est apparue en enregistrant le document',
    'error delete event type' =>'Echec de suppression du type d\'évènement',
    'error delete mail' => 'Une erreur est apparue en supprimant ce courriel',
    'error delete mail account' => 'Une erreur est apparue en supprimant ce compte courriel',
    'error delete contacts' => 'Une erreur est apparue en supprimant ces contacts',
  	'error check mail' => 'Une erreur est apparue en vérifiant le compte \'{0}\': {1}',
  	'error check out file' => 'Une erreur est apparue en contrôlant le fichier en utilisation exclusive',
    'error checkin file' => 'Une erreur est apparue en enregistrant le fichier',
    'error classifying attachment cant open file' => 'Une erreur est apparue en classant la pièce jointe : ouverture du fichier impossible',
  	'error contact added but not assigned' => 'Le contact \'{0}\' a été ajouté mais n\'a pas bien été affecté au contexte \'{1}\' à cause des droits d\'accès',
  	'error cannot set workspace as parent' => 'Ne peut basculer le contexte \'{0}\' comme parent, il y a trop de niveau de contextes',
  
    
    // Access or data errors
    'no access permissions' => 'Vous n\'avez pas les droits d\'accès à la page demandée',
    'invalid request' => 'Demande invalide !',
    
    // Confirmation
    'confirm cancel work timeslot' => 'Êtes-vous sûr de vouloir annuler l\'intervalle de temps en cours ?',
    'confirm delete mail account' => 'Attention : tous les courriels de ce compte seront aussi supprimés, êtes-vous sûr de vouloir supprimer ce compte courriel ?',
    'confirm delete message' => 'Êtes-vous sûr de vouloir supprimer cette note ?',
    'confirm delete milestone' => 'Êtes-vous sûr de vouloir supprimer ce jalon ?',
    'confirm delete task list' => 'Êtes-vous sûr de vouloir supprimer cette tâche et toutes ses sous-tâches ?',
    'confirm delete task' => 'Êtes-vous sûr de vouloir supprimer cette tâche ?',
    'confirm delete comment' => 'Êtes-vous sûr de vouloir supprimer ce commentaire ?',
    'confirm delete project' => 'Êtes-vous sûr de vouloir supprimer ce contexte et toutes ses données (notes, tâches, jalons, fichiers...)?',
    'confirm complete project' => 'Êtes-vous sûr de vouloir marquer ce contexte comme fermé ? Toutes les actions du contexte seront verrouillées',
    'confirm open project' => 'Êtes-vous sûr de vouloir marquer ce contexte comme ouvert ? Toutes les actions du contexte seront alors possibles',
    'confirm delete client' => 'Êtes-vous sûr de vouloir supprimer la société cliente sélectionnée et tous ses utilisateurs ? \nCette action supprimera aussi les contextes personnels des utilisateurs.',
    'confirm delete contact' => 'Êtes-vous sûr de vouloir supprimer le contact sélectionné ?',
    'confirm delete user' => 'Êtes-vous sûr de vouloir supprimer ce compte utilisateur ?\nCette action supprimera aussi le contexte personnel de l\\\'utilisateur.',

    'confirm reset people form' => 'Êtes-vous sûr de vouloir effacer ce formulaire ? Les modifications faites seront perdues !',
    'confirm remove user from project' => 'Êtes-vous sûr de vouloir retirer cet utilisateur de ce contexte ?',
    'confirm remove company from project' => 'Êtes-vous sûr de vouloir retirer cette société de ce contexte ?',
    'confirm logout' => 'Êtes-vous sûr de vouloir quitter ?',

    'confirm delete current avatar' => 'Êtes-vous sûr de vouloir supprimer cet avatar ?',
    'confirm unlink object' => 'Êtes-vous sûr de vouloir délier cet objet ?',
    'confirm delete company logo' => 'Êtes-vous sûr de vouloir supprimer ce logo ?',
    'confirm subscribe' => 'Êtes-vous sûr de vouloir vous abonner à cet objet ? Vous recevrez un courriel chaque fois que quelqu\'un postera un commentaire sur cet objet.',
    'confirm unsubscribe' => 'Êtes-vous sûr de vouloir vous désabonner ?',
    'confirm delete project form' => 'Êtes-vous sûr de vouloir supprimer ce formulaire ?',
    'confirm delete folder' => 'Êtes-vous sûr de vouloir supprimer ce dossier ?',
    'confirm delete file' => 'Êtes-vous sûr de vouloir supprimer ce fichier ?',
    'confirm delete revision' => 'Êtes-vous sûr de vouloir supprimer cette révision ?',
    'confirm reset form' => 'Êtes-vous sûr de vouloir effacer ce formulaire ?',
    'confirm delete contacts' => 'Êtes-vous sûr de vouloir supprimer ces contacts ?',
	'confirm delete group' => 'Êtes-vous sûr de vouloir supprimer ce groupe ?',
    
    // Errors...
    'system error message' => 'Désolé mais une erreur fatale empêche la réalisation de votre demande. Un rapport d\'erreur a été envoyé à l\'administrateur.',
    'execute action error message' => 'Désolé mais une erreur fatale empêche la réalisation de votre demande. Un rapport d\'erreur a été envoyé à l\'administrateur.',
    
    // Log
    'log add projectmessages' => '\'{0}\' ajouté',
    'log edit projectmessages' => '\'{0}\' modifié',
    'log delete projectmessages' => '\'{0}\' supprimé',
  
  	'log add projectevents' => '\'{0}\' ajouté',
    'log edit projectevents' => '\'{0}\' modifié',
    'log delete projectevents' => '\'{0}\' supprimé',
    
    'log add comments' => '{0} ajouté',
    'log edit comments' => '{0} modifié',
    'log delete comments' => '{0} supprimé',
    
    'log add projectmilestones' => '\'{0}\' ajouté',
    'log edit projectmilestones' => '\'{0}\' modifié',
    'log delete projectmilestones' => '\'{0}\' supprimé',
    'log close projectmilestones' => '\'{0}\' terminé',
    'log open projectmilestones' => '\'{0}\' réouvert',
    
    'log add projecttasklists' => '\'{0}\' ajouté',
    'log edit projecttasklists' => '\'{0}\' modifié',
    'log delete projecttasklists' => '\'{0}\' supprimé',
    'log close projecttasklists' => '\'{0}\' fermé',
    'log open projecttasklists' => '\'{0}\' ouvert',
    
    'log add projecttasks' => '\'{0}\' ajouté',
    'log edit projecttasks' => '\'{0}\' modifié',
    'log delete projecttasks' => '\'{0}\' supprimé',
    'log close projecttasks' => '\'{0}\' fermé',
    'log open projecttasks' => '\'{0}\' ouvert',
    
    'log add projectforms' => '\'{0}\' ajouté',
    'log edit projectforms' => '\'{0}\' modifié',
    'log delete projectforms' => '\'{0}\' supprimé',
    
    'log add projectfolders' => '\'{0}\' ajouté',
    'log edit projectfolders' => '\'{0}\' modifié',
    'log delete projectfolders' => '\'{0}\' supprimé',
    
    'log add projectfiles' => '\'{0}\' chargé',
    'log edit projectfiles' => '\'{0}\' modifié',
    'log delete projectfiles' => '\'{0}\' supprimé',
    
    'log edit projectfilerevisions' => '{0} modifié',
    'log delete projectfilerevisions' => '{0} supprimé',
    
    'log add projectwebpages' => '\'{0}\' ajouté',
    'log edit projectwebpages' => '\'{0}\' modifié',
    'log delete projectwebpages' => '\'{0}\' supprimé',
    
    'log add contacts' => '\'{0}\' affecté au contexte',
    'log edit contacts' => '\'{0}\' changé de rôle',
    'log delete contacts' => '\'{0}\' retiré du contexte',
  
  	'no contacts in company' => 'La société n\'a pas de contacts.',
  
  	'session expired error' => 'La session a expiré. Merci de recharger la page et de se reconnecter.',
  	'admin cannot be removed from admin group' => 'Le premier utilisateur ne peut être supprimé du groupe d\'Administrateurs',
  	'open this link in a new window' => 'Ouvrir le lien dans une nouvelle fenêtre',
  
  	'confirm delete template' => 'Êtes-vous sûr de vouloir supprimer ce modèle ?',
  	'success delete template' => 'Le modèle \'{0}\' a été supprimé',
  	'success add template' => 'Le modèle a été ajouté',
  
  	'log add companies' => '\'{0}\' ajouté',
  	'log edit companies' => '\'{0}\' modifié',
  	'log delete companies' => '\'{0}\' supprimé',
  
  	'log add mailcontents' => '\'{0}\' ajouté',
  	'log edit mailcontents' => '\'{0}\' modifié',
  	'log delete mailcontents' => '\'{0}\' supprimé',
  
  	'log open timeslots' => '\'{0}\' ouvert',
    'log close timeslots' => '\'{0}\' fermé',
    'log delete timeslots' => '\'{0}\' supprimé',
  	'error assign workspace' => 'Echec d\'affectation du modèle au contexte',
  	'success assign workspaces' => 'Affectation du modèle au contexte réussie',
  	'success update config value' => 'La valeur de configuration a bien été modifiée',
  	'view open tasks' => 'Tâches ouvertes',
  	'already logged in' => 'Vous êtes déjà connecté',
  
	'some tasks could not be updated due to permission restrictions' => 'Quelques tâches ne peut être modifiées à cause des restrictions de droits'
  ); // array

?>