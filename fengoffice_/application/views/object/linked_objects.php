<!-- <?php if(!$linked_objects_js_included) { ?>
<?php add_stylesheet_to_page('project/linked_objects.css'); ?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/linkObjects.js') ?>"></script>
<?php } // if ?>
-->
<fieldset id="linkObjects_<?php echo $linked_objects_id ?>" class="linkObjects">
  <legend><?php echo lang('link objects') ?></legend>
  <div id="linkObjectsControls_<?php echo $linked_objects_id ?>">
    <div id="linkObjects_<?php echo $linked_objects_id ?>_1"><?php echo file_field($linked_objects_prefix . '1') ?></div>
  </div>
</fieldset>

<script type="text/javascript">
  App.modules.linkObjects.initialize(<?php echo $linked_objects_max_controls ?>, '<?php echo lang('add linked object control') ?>', '<?php echo lang('remove linked object control') ?>', '<?php echo lang('error linked object max controls', $linked_objects_max_controls) ?>');
  App.modules.linkObjects.initSet(1, '<?php echo $linked_objects_prefix ?>');
</script>

