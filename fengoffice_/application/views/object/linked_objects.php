<?php 
require_javascript('og/modules/linkToObjectForm.js');
if (!isset($genid)) $genid = gen_id();

if (!is_array($objects) || count($objects) == 0) {
	echo '<div class="desc">' . lang('there are no linked objects yet') . '</div><br />';
}
?>
<a id="<?php echo $genid ?>before" href="#" onclick="App.modules.linkToObjectForm.pickObject(this)"><span class="action-ico ico-open-link"><?php echo lang('link object') ?></span></a>

<script>
<?php
if (is_array($objects)) {
	foreach ($objects as $o) {
		if (!$o instanceof ContentDataObject) continue;
?>
App.modules.linkToObjectForm.addObject(document.getElementById('<?php echo $genid ?>before'), {
	'object_id': <?php echo $o->getId() ?>,
	'type': '<?php echo $o->getObjectTypeName() ?>',
	'name': <?php echo json_encode($o->getObjectName()) ?>
});
<?php
	}
}
?>
</script>