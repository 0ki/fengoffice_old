<?php
  add_stylesheet_to_page('project/comments.css');
?>
	<fieldset>
    	<legend class="toggle_collapsed" onclick="og.toggle('objectComments',this)"><?php echo lang('comments') ?></legend>

		<div id="objectComments" style="display:none">
<?php
	$comments = $__comments_object->getComments();
	if(is_array($comments) && count($comments)) {
		$counter = 0;
		foreach($comments as $comment) {
			$counter++;
?>
			<div class="comment <?php echo $counter % 2 ? 'even' : 'odd' ?>" id="comment<?php echo $comment->getId() ?>">
		<?php if($comment->isPrivate()) { ?>
				<div class="private" title="<?php echo lang('private comment') ?>"><span><?php echo lang('private comment') ?></span></div>
		<?php } // if ?>
		<?php if($comment->getCreatedBy() instanceof User) { ?>
				<div class="commentHead"><span><a class="internalLink" href="<?php echo $comment->getViewUrl() ?>" title="<?php echo lang('permalink') ?>">#<?php echo $counter ?></a>:</span> <?php echo lang('comment posted on by', format_datetime($comment->getUpdatedOn()), $comment->getCreatedByCardUrl(), $comment->getCreatedByDisplayName()) ?>:</div>
		<?php } else { ?>
				<div class="commentHead"><span><a class="internalLink" href="<?php echo $comment->getViewUrl() ?>" title="<?php echo lang('permalink') ?>">#<?php echo $counter ?></a>:</span> <?php echo lang('comment posted on', format_datetime($comment->getUpdatedOn())) ?>:</div>
		<?php } // if ?>
				<div class="commentBody">
		<?php if(($comment->getCreatedBy() instanceof User) && ($comment->getCreatedBy()->hasAvatar())) { ?>
					<div class="commentUserAvatar"><img src="<?php echo $comment->getCreatedBy()->getAvatarUrl() ?>" alt="<?php echo clean($comment->getCreatedBy()->getDisplayName()) ?>" /></div>
		<?php } // if ?>
					<div class="commentText"><?php echo do_textile($comment->getText()) ?></div>
<?php
			$options = array();
			if ($comment->canEdit(logged_user())) $options[] = '<a class="internalLink" href="' . $comment->getEditUrl() . '">' . lang('edit') . '</a>';
			if ($comment->canDelete(logged_user())) $options[] = '<a class="internalLink" href="' . $comment->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete comment') . '\')">' . lang('delete') . '</a>';
?>
					<div class="clear"></div>
		<?php echo render_object_links($comment, $comment->canEdit(logged_user())) ?>
				</div>
		<?php if(count($options)) { ?>
				<div class="options"><?php echo implode(' | ', $options) ?></div>
		<?php } // if ?>
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