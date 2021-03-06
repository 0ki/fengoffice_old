<?php
  add_stylesheet_to_page('project/link_objects.css');
?>
<?php if(isset($linked_objects) && is_array($linked_objects) && count($linked_objects)) { ?>
<div class="objectFiles">
  <div class="objectFilesTitle"><span><?php echo lang('linked objects') ?>:</span></div>
  <ul>
<?php 	foreach($linked_objects as $linked_object) { ?>
<?php 		if($linked_object->isPrivate() && !logged_user()->isMemberOfOwnerCompany()) continue; ?>
    <li>
<?php
  			$linked_object_options = array();
 			$linked_object_options[] = '<a class="internalLink" href="' . $linked_object->getObjectUrl() . '">' . lang('file details') . '</a>';
 			if($linked_objects_object->canUnlinkObject(logged_user(), $linked_object)) $linked_object_options[] = '<a class="internalLink" href="' . $linked_objects_object->getUnlinkObjectUrl($linked_object) . '" onclick="return confirm(\'' . lang('confirm unlink object') . '\')">' . lang('unlink object') . '</a>';
?>
<?php if(get_class($linked_object)=='ProjectFile'){ ?>
      <a target="_blank" href="<?php echo $linked_object->getDownloadUrl() ?>">
      <span><?php echo clean($linked_object->getFilename()) ?></span> 
      (<?php echo format_filesize($linked_object->getFilesize()) ?>)</a> <i><?php echo clean($linked_object->getObjectTypeName()) ?></i> | <?php echo implode(' | ', $linked_object_options) ?>
<?php } 
	  else 
	  { 	  	
?>      <a class="internalLink" href="<?php echo $linked_object->getObjectUrl() ?>">
      <span><?php echo clean($linked_object->getObjectName()) ?></span> </a> <i><?php echo clean($linked_object->getObjectTypeName()) ?></i> 
<?php      if($linked_objects_object->canUnlinkObject(logged_user(), $linked_object)) echo '<a class="internalLink" href="' . $linked_objects_object->getUnlinkObjectUrl($linked_object) . '" onclick="return confirm(\'' . lang('confirm unlink object') . '\')">' . lang('unlink object') . '</a>';
	  	
	  }
	  ?>
    </li>
<?php 	} // foreach ?>
  </ul>
<?php 		if($linked_objects_object->canLinkObject(logged_user(), $linked_objects_object->getProject())) { ?>
  <p><?php echo render_link_to_object($linked_objects_object,lang('link more objects')); ?> </p>
  <!--a class="internalLink" href="<?php echo $linked_objects_object->getLinkObjectUrl() ?>">&raquo; <?php echo lang('link more objects') ?></a-->
<?php 		} // if ?>
</div>
<?php } else { ?>  

   <?php echo lang('no linked objects') ?>. 
  
<?php 		if((!($linked_objects_object->isNew())) && $linked_objects_object->canLinkObject(logged_user(), $linked_objects_object->getProject())) { ?>
  <p><?php echo render_link_to_object($linked_objects_object,lang('link more objects')); ?> </p>
  <!--a class="internalLink" href="<?php echo $linked_objects_object->getLinkObjectUrl() ?>">&raquo; <?php echo lang('link objects') ?></a-->
<?php 		} // if ?>



<?php 	  } // if ?>
<?php //} // if ?>