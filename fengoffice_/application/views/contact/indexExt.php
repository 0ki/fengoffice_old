<?php 
	add_javascript_to_page('og/ContactManager.js');
 ?>
<div id="contact-manager"></div>

<script type="text/javascript">
	var fm = new og.ContactManager({
		<?php if ($projectParam) echo "project: " . $projectParam . "," ?>
		<?php if ($userParam) echo "user: " . $userParam . "," ?>
		<?php if ($typeParam) echo "type: ''" . $typeParam . "'," ?>
		<?php if ($tagParam) echo "tag: ''" . $tagParam . "'," ?>
		nada: true
	});
	fm.setHeight(400);
	fm.render('contact-manager');
</script>
