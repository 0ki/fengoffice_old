<div class="comment-unit">
	<a class="person" href="Javascript:;" onclick="og.openLink('<?php echo $comment->getCreatedBy()->getViewUrl(); ?>')"><?php echo $comment->getCreatedBy()->getDisplayName();?></a> -
	<em class="feed-date"><?php echo friendly_date($comment->getCreatedOn());?></em> 
	<p><?php echo $comment->getText(); ?></p>
</div>