{"totalCount": "<?php echo $totalCount; ?>",
"project": "<?php echo $filters['project'] ?>",
"user": "<?php echo $filters['user'] ?>",
"tag": "<?php echo $filters['tag'] ?>",
"type": "<?php echo $filters['type'] ?>", 
"files": [
	<?php
	$coma = false;
	foreach($files as $file) {
			if ($coma) {
				echo ",";
			} else {
				$coma = true;
			}
	?>{"id": "<?php echo $file->getId() ?>",
	"name": "<?php echo $file->getFilename() ?>",
	"type": "<?php echo $file->getTypeString() ?>",
	"tags": "<?php echo str_replace('"', '\"', project_object_tags($file, $file->getProject(), true)) ?>",
	"createdBy": "<?php echo Users::findById($file->getCreatedById())->getUsername() ?>",
	"createdById": "<?php echo $file->getCreatedById() ?>",
	"dateCreated": "<?php echo $file->getCreatedOn()->getTimestamp() ?>",
	"updatedBy": "<?php echo Users::findById($file->getUpdatedById())->getUsername() ?>",
	"updatedById": "<?php echo $file->getUpdatedById() ?>",
	"dateUpdated": "<?php echo $file->getUpdatedOn()->getTimestamp() ?>",
	"icon": "<?php echo str_replace("&amp;", "&", $file->getTypeIconUrl()) ?>",
	"size": "<?php echo $file->getFileSize() ?>",
	"project": "<?php echo $file->getProject()->getName() ?>",
	"projectId": "<?php echo $file->getProjectId() ?>",
	"url": "<?php echo str_replace("&amp;", "&", $file->getOpenUrl()) ?>"}
	<?php } ?>
]}