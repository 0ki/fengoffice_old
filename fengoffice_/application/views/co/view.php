<?php 
	$coId = $object->getId() . get_class($object->manager()); 
	if (!isset($iconclass))
		$iconclass = "ico-large-" . $object->getObjectTypeName();
?>

<table style="width:100%"><tr>
<td>
	<table style="width:100%"><tr>
		<td class="coViewIcon" colspan=2 rowspan=2>
			<?php if (isset($image)) { echo $image; } else {?>
			<div id="<?php echo $coId; ?>_iconDiv" class="coViewIconImage <?php echo $iconclass ?>"></div>
			<?php } ?>
		</td>
		
		<td class="coViewHeader" rowspan=2>
			<div class="coViewTitle">
				<table><tr><td>
				<?php if($object instanceof ProjectDataObject && $object->isPrivate()) { ?>
    				<div class="private" title="<?php echo lang('private ' . $object->getObjectTypeName()) ?>"><span><?php echo lang('private message') ?></span></div>
				<?php } // if ?>
				<?php echo isset($title)? $title : lang($object->getObjectTypeName()) . ": " . $object->getObjectName() ?>
				</td>
				
				</tr></table>
			</div>
			<div>
				<?php if (isset($description)) echo $description ;?>
			</div>
			
			<a class="internalLink" href="#" onclick="og.closeView(); return false;" title="<?php echo lang('close') ?>" ><div class="coViewClose">x</div></a>
		</td>
		
		<td class="coViewTopRight"></td></tr>
		<tr><td class="coViewRight" rowspan=2></td></tr>
		
		<tr><td class="coViewBody" colspan=3>
			<div style="padding-bottom:15px">
			<?php 
			if (isset($content_template) && is_array($content_template)){
				tpl_assign('object', $object);
				if (isset($variables))
					tpl_assign('variables', $variables);
				$this->includeTemplate(get_template_path($content_template[0], $content_template[1]));
			}
			else
				if (isset($content)) echo $content;
			?>
			</div>
			<?php if (isset($internalDivs)){
				foreach ($internalDivs as $idiv)
					echo $idiv;
			}
			if ($object instanceof ProjectDataObject && $object->isCommentable())
				echo render_object_comments($object, $object->getViewUrl());
			?>
		</td>
		
		<tr><td class="coViewBottomLeft"></td>
		<td class="coViewBottom" colspan=2></td>
		<td class="coViewBottomRight"></td></tr>
	</table>
</td>


<!-- Actions Panel -->
<td style="width:250px; padding-left:10px">
<table style="width:100%">
	<col width=12/><col width=226/><col width=12/>
	<tr><td class="coViewHeader" colspan=2 rowspan=2><div class="coViewPropertiesHeader"><?php echo lang("actions") ?></div></td>
	<td class="coViewTopRight"></td></tr>
		
	<tr><td class="coViewRight" rowspan=2></td></tr>
	<tr><td class="coViewBody" colspan=2>
		<?php if(count(PageActions::instance()->getActions()) > 0 ) {?>
			<div>
			<?php
				$pactions = PageActions::instance()->getActions();
				foreach ($pactions as $action) { 
					if ($action->getTarget() != '') {
					?>
					<a style="display:block" class="coViewAction <?php echo $action->getName()?>" href="<?php echo $action->getURL()?>" target="<?php echo $action->getTarget()?>">
					<?php } else { ?>
					<a style="display:block" class="internalLink coViewAction <?php echo $action->getName()?>" href="<?php echo $action->getURL()?>">
				<?php } echo $action->getTitle() ?></a>
			<?php } ?>
			</div>
		<?php } ?>
	</td></tr>
	
	<tr><td class="coViewBottomLeft"></td>
	<td class="coViewBottom"></td>
	<td class="coViewBottomRight"></td></tr>
</table>



<!-- Properties Panel -->
<table style="width:100%">
	<col width=12/><col width=226/><col width=12/>
	<tr><td class="coViewHeader" colspan=2 rowspan=2><div class="coViewPropertiesHeader"><?php echo lang("properties") ?></div></td>
	<td class="coViewTopRight"></td></tr>
		
	<tr><td class="coViewRight" rowspan=2></td></tr>
	<tr><td class="coViewBody" colspan=2>
	<?php if ($object instanceof ProjectDataObject && $object->getProject() instanceof Project) { ?>
		<div class="prop-col-div"><span style="color:333333;font-weight:bolder;"><?php echo lang('workspace') ?>:</span>
			<?php echo $object->getProject()->getName()?>
		</div>
	<?php } ?>
	
	<?php if ($object->isTaggable()) {?>
		<div class="prop-col-div"><span style="color:333333;font-weight:bolder;"><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($object) ?></div>
	<?php } ?>
	
	<?php if($object->isLinkableObject()) { ?>
		<div class="prop-col-div"><?php echo render_object_links($object, $object->canEdit(logged_user()))?></div>
	<?php } ?>

	<div class="prop-col-div" style="border:0px">
    	<?php if($object->getCreatedBy() instanceof User) { ?>
    		<span style="color:#333333;font-weight:bolder;">
    			<?php echo lang('created by') ?>:
			</span><br/>
			<?php 
				if ($object->getObjectCreationTime() && $object->getCreatedOn()->isToday())
					$datetime = format_time($object->getCreatedOn());
				else
					$datetime = format_date($object->getCreatedOn());
					
				if (logged_user()->getId() == $object->getCreatedBy()->getId())
					$username = lang('you');
				else
					$username = clean($object->getCreatedBy()->getDisplayName());
			echo lang('user date', $object->getCreatedBy()->getCardUrl(), $username, $datetime) ?><br/>
    	<?php } // if ?>
    	
    	<?php if($object->getObjectUpdateTime() && $object->getUpdatedBy() instanceof User && $object->getCreatedOn() != $object->getUpdatedOn()) { ?>
    		<span style="color:#333333;font-weight:bolder;">
    			<?php echo lang('modified by') ?>:
			</span><br/>
			<?php 
				if ($object->getUpdatedOn()->isToday())
					$datetime = format_time($object->getUpdatedOn());
				else
					$datetime = format_date($object->getUpdatedOn());
					
				if (logged_user()->getId() == $object->getUpdatedBy()->getId())
					$username = lang('you');
				else
					$username = clean($object->getUpdatedBy()->getDisplayName());
			echo lang('user date', $object->getUpdatedBy()->getCardUrl(), $username, $datetime) ?><br/>
		<?php } // if ?>
	</div>
	</td></tr>
	
	<tr><td class="coViewBottomLeft"></td>
	<td class="coViewBottom"></td>
	<td class="coViewBottomRight"></td></tr>
	</table>
</td>
</tr></table>
