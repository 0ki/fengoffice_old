<?php
	$comments = $__comments_object->getComments();
	$countComments = 0;
	if (is_array($comments) && count($comments))
		$countComments = count($comments);
	$random = rand();
?>
	<fieldset>
    	<legend class="<?php echo $countComments > 0? 'toggle_expanded': 'toggle_collapsed' ?>" onclick="og.toggle('<?php echo $random ?>objectComments',this)">
    	<?php echo $countComments > 0? lang('comments') . ' (' . $countComments .')': lang('comments') ?></legend>

		<div class="objectComments" id="<?php echo $random ?>objectComments" style="<?php echo $countComments > 0? '':'display:none'?>">
<?php
	if(is_array($comments) && count($comments)) {
		$counter = 0;
		foreach($comments as $comment) {
			$counter++;
			$options = array();
			if ($comment->canEdit(logged_user())) {
				$options[] = '<a class="internalLink" href="' . $comment->getEditUrl() . '">' . lang('edit') . '</a>';
				if ($comment->canLinkObject(logged_user(), $comment->getProject()))
					$options[] = render_link_to_object_2($comment,lang('link objects'));
			}
			if ($comment->canDelete(logged_user())) $options[] = '<a class="internalLink" href="' . $comment->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete comment') . '\')">' . lang('delete') . '</a>';
?>
			<div class="comment <?php echo $counter % 2 ? 'even' : 'odd' ?>" id="comment<?php echo $comment->getId() ?>">
		<?php if($comment->isPrivate()) { ?>
				<div class="private" title="<?php echo lang('private comment') ?>"><span><?php echo lang('private comment') ?></span></div>
		<?php } // if ?>
		
		<?php if($comment->getCreatedBy() instanceof User) { ?>
				<div class="commentHead">
					<table style="width:100%"><tr><td>
					<span><a class="internalLink" href="<?php echo $comment->getViewUrl() ?>" title="<?php echo lang('permalink') ?>">#<?php echo $counter ?></a>:
					</span> <?php echo lang('comment posted on by', format_datetime($comment->getUpdatedOn()), $comment->getCreatedByCardUrl(), $comment->getCreatedByDisplayName()) ?>
					</td>
		<td style="text-align:right">
		<?php if(count($options)) { ?>
				<div><?php echo implode(' | ', $options) ?></div>
		<?php } // if ?>
		</td></tr></table>
				</div>
		<?php } else { ?>
				<div class="commentHead"><span>
				<a class="internalLink" href="<?php echo $comment->getViewUrl() ?>" title="<?php echo lang('permalink') ?>">#<?php echo $counter ?></a>:
				</span> <?php echo lang('comment posted on', format_datetime($comment->getUpdatedOn())) ?>
				</div>
		<?php } // if ?>
		
				<div class="commentBody">
				<table style="width:100%"><tr>
		<?php if(($comment->getCreatedBy() instanceof User) && ($comment->getCreatedBy()->hasAvatar())) { ?>
					<td style="vertical-align:top;width:60px"><div class="commentUserAvatar"><img src="<?php echo $comment->getCreatedBy()->getAvatarUrl() ?>" alt="<?php echo clean($comment->getCreatedBy()->getDisplayName()) ?>" /></div></td>
		<?php } // if ?>
					<td style="text-align:left">
						<div class="commentText"><?php echo do_textile($comment->getText()) ?></div>
					</td><td style="width:173px">
						<?php echo render_object_links($comment, $comment->canEdit(logged_user()), true, false) ?>
					</td></tr></table>
				</div>
			</div>
		<?php } // foreach ?>
<?php } else { ?>
		<p><?php echo lang('no comments associated with object') ?></p>
<?php } // if ?>

<?php if($__comments_object->canComment(logged_user())) { ?>
	<?php echo render_comment_form($__comments_object) ?>
<?php } // if ?>

		</div>
	</fieldset>