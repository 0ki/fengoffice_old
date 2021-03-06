<?php 
	if($object instanceof ProjectDataObject && $object->canView(logged_user())) 	{
		add_page_action(lang('view history'),$object->getViewHistoryUrl(),'ico-history');
	}
	$coId = $object->getId() . get_class($object->manager()); 
	if (!isset($iconclass))
		$iconclass = "ico-large-" . $object->getObjectTypeName();
		
	$genid = gen_id();
?>

<table style="width:100%" id="<?php echo $genid ?>-co"><tr>
<td>
	<table style="width:100%">
		<col width="12px"/><col width="60px"/>
		<tr>
		<td class="coViewIcon" colspan=2 rowspan=2>
			<?php if (isset($image)) { echo $image; } else {?>
			<div id="<?php echo $coId; ?>_iconDiv" class="coViewIconImage <?php echo $iconclass ?>"></div>
			<?php } ?>
		</td>
		
		<td class="coViewHeader" rowspan=2>
			<div class="coViewTitle">
				<table><tr><td>
				<?php echo isset($title)? $title : lang($object->getObjectTypeName()) . ": " . clean($object->getObjectName()) ?>
				</td>
				
				</tr></table>
			</div>
			<div>
				<?php if (isset($description)) echo $description ;?>
			</div>
			
			<a class="internalLink" href="#" onclick="og.closeView(); return false;" title="<?php echo lang('close') ?>" ><div class="coViewClose" style="cursor:pointer"><?php echo lang('close') ?>&nbsp;&nbsp;X</div></a>
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
			if ($object instanceof ProjectDataObject && $object->allowsTimeslots())
				echo render_object_timeslots($object, $object->getViewUrl());
			
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
					<a style="display:block" class="<?php $attribs = $action->getAttributes(); echo $attribs["download"] ? '':'internalLink' ?> coViewAction <?php echo $action->getName()?>" href="<?php echo $action->getURL()?>">
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
	
	<div class="prop-col-div" style="width:200;">
		<span style="color:333333;font-weight:bolder;"><?php echo lang('unique id') ?>:&nbsp;</span><?php echo $object->getUniqueObjectId() ?>
	</div>
		
	<?php 
	$has_wss = $object instanceof ProjectDataObject && (is_array($object->getWorkspaces()) && count($object->getWorkspaces()) > 0);
	if ($has_wss) { ?>
		<div class="prop-col-div"><span style="color:333333;font-weight:bolder;"><?php echo lang('workspace') ?>:</span>
			<?php
				$wsl = $object->getWorkspaces();
				if (is_array($wsl) && count($wsl) > 0){
					$projectLinks = array();
					foreach ($wsl as $ws) {
						$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
					}
					echo '<br/>' . implode('<br/>',$projectLinks);
				}
	}
				?>
				
		<?php if ($object->isTaggable()) {
			$tags = project_object_tags2($object);
			if ($tags != '--'){
			?>
		<br/>
		<div style="color:333333;font-weight:bolder;"><?php echo lang('tags') ?>:</div><?php echo $tags ?>
		<?php }} ?>
	<?php if($has_wss){?>
		</div>
	<?php } ?>
	
	
	
	<?php if($object->isLinkableObject() && !$object->isTrashed()) { ?>
		<div class="prop-col-div" style="width:200;"><?php echo render_object_links($object, $object->canEdit(logged_user()))?></div>
	<?php } ?>
	<?php if ($object instanceof ProjectDataObject) { ?>
		<div class="prop-col-div" style="width:200;"><?php echo render_object_subscribers($object)?></div>
	<?php } ?>

	<div class="prop-col-div" style="border:0px;width:200;">
    	<?php if($object->getCreatedBy() instanceof User) { ?>
    		<span style="color:#333333;font-weight:bolder;">
    			<?php echo lang('created by') ?>:
			</span><br/><div style="padding-left:10px">
			<?php 
			if ($object->getCreatedBy() instanceof User){
				if (logged_user()->getId() == $object->getCreatedBy()->getId())
					$username = lang('you');
				else
					$username = clean($object->getCreatedBy()->getDisplayName());
					
				if ($object->getObjectCreationTime() && $object->getCreatedOn()->isToday()){
					$datetime = format_time($object->getCreatedOn());
					echo lang('user date today at', $object->getCreatedBy()->getCardUrl(), $username, $datetime, clean($object->getCreatedBy()->getDisplayName()));
				} else {
					$datetime = format_datetime($object->getCreatedOn(), lang('date format'), logged_user()->getTimezone());
					echo lang('user date', $object->getCreatedBy()->getCardUrl(), $username, $datetime, clean($object->getCreatedBy()->getDisplayName()));
				}
			} ?></div>
    	<?php } // if ?>
    	
    	<?php if($object->getObjectUpdateTime() && $object->getUpdatedBy() instanceof User && $object->getCreatedOn() != $object->getUpdatedOn()) { ?>
    		<span style="color:#333333;font-weight:bolder;">
    			<?php echo lang('modified by') ?>:
			</span><br/><div style="padding-left:10px">
			<?php 
			if ($object->getUpdatedBy() instanceof User){
					
				if (logged_user()->getId() == $object->getUpdatedBy()->getId())
					$username = lang('you');
				else
					$username = clean($object->getUpdatedBy()->getDisplayName());

				if ($object->getUpdatedOn()->isToday()){
					$datetime = format_time($object->getUpdatedOn());
					echo lang('user date today at', $object->getUpdatedBy()->getCardUrl(), $username, $datetime, clean($object->getUpdatedBy()->getDisplayName()));
				} else {
					$datetime = format_datetime($object->getUpdatedOn(), lang('date format'), logged_user()->getTimezone());
					echo lang('user date', $object->getUpdatedBy()->getCardUrl(), $username, $datetime, clean($object->getUpdatedBy()->getDisplayName()));
				}
			}
			 ?></div>
		<?php } // if ?>
		
		<?php
		if ($object instanceof ProjectDataObject && $object->isTrashable() && $object->getTrashedById() != 0) { ?>
    		<span style="color:#333333;font-weight:bolder;">
    			<?php echo lang('deleted by') ?>:
			</span><br/><div style="padding-left:10px">
			<?php
			$trash_user = Users::findById($object->getTrashedById());
			if ($trash_user instanceof User){
				if (logged_user()->getId() == $trash_user->getId())
					$username = lang('you');
				else
					$username = clean($trash_user->getDisplayName());

				if ($object->getTrashedOn()->isToday()){
					$datetime = format_time($object->getTrashedOn());
					echo lang('user date today at', $trash_user->getCardUrl(), $username, $datetime, clean($trash_user->getDisplayName()));
				} else {
					$datetime = format_datetime($object->getTrashedOn(), lang('date format'), logged_user()->getTimezone());
					echo lang('user date', $trash_user->getCardUrl(), $username, $datetime, clean($trash_user->getDisplayName()));
				}
			}
			 ?></div>
		<?php } // if ?>
	</div>
	
	<?php if ($object instanceof ProjectDataObject) { ?>
	<div class="prop-col-div" style="width:200;">
		<?php echo render_custom_properties($object) ?>
	</div>
	<?php } ?>
	
	</td></tr>
	
	<tr><td class="coViewBottomLeft"></td>
	<td class="coViewBottom"></td>
	<td class="coViewBottomRight"></td></tr>
	</table>
</td>
</tr></table>
<script type="text/javascript">
og.showWsPaths('<?php echo $genid ?>-co',null,true);
</script>
