<?php if(isset($user) && ($user instanceof User)) { ?>
<div class="card">
  <div class="cardIcon"><img src="<?php echo $user->getAvatarUrl() ?>" alt="<?php echo clean($user->getDisplayName()) ?> avatar" /></div>
  <div class="cardData">
  
    <h2><?php echo clean($user->getDisplayName()) ?></h2>
    
    <div class="cardBlock">
    <div>
    <span><?php echo lang('user title') ?>:</span> <?php echo $user->getTitle() ? clean($user->getTitle()) : lang('n/a') ?></div>

      <div><span><?php echo lang('company') ?>:</span> <a class="internalLink" href="<?php echo $user->getCompany()->getCardUrl() ?>"><?php echo clean($user->getCompany()->getName()) ?></a></div>
    </div>
    
    <h2><?php echo lang('contact online') ?></h2>
    
    <div class="cardBlock">
      <div><span><?php echo lang('email address') ?>:</span> <a href="mailto:<?php echo clean($user->getEmail()) ?>">
      <?php echo clean($user->getEmail()) ?></a></div>
      

    </div>
    
  
  </div>
</div>




<?php if (false && isset($logs)){ 
	$genid = gen_id();
	?>
	<fieldset><legend class="toggle_expanded" onclick="og.toggle('<?php echo $genid ?>user_activity',this)"><?php echo lang('latest user activity') ?></legend>
<div id="<?php echo $genid ?>user_activity"><table><col/><col style="padding-left:10px;"/><col style="padding-left:10px"/>
		<?php foreach ($logs as $log) {
			$log_object = $log->getObject();
			if ($log_object instanceof ApplicationDataObject){?>
			<tr><td><?php 
				if ($log->getCreatedOn()->isToday()){
					$datetime = format_time($log->getCreatedOn());
					echo lang('today at', $datetime);
				} else {
					echo format_date($log->getCreatedOn());
				}?></td>
			<td><div class="db-ico ico-<?php echo $log_object->getObjectTypeName() ?>"></div></td>
			<td><a class='internalLink' href='<?php echo $log_object->getObjectUrl() ?>'><?php echo $log_object->getObjectName() ?></a></td>
			<td><?php echo $log->getText() ?></td>
			</tr>
			
		<?php } // if
			} //foreach ?>
		</table></div>
	</fieldset><br/>
<?php } //if ?>
<?php } // if ?>







