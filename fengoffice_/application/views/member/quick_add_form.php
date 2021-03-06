<?php if (isset($error_msg)) {
	echo "<div class='quick-form-error'>$error_msg</div>";
	return ;
}?>

<form action="<?php echo $form_action ?>" method="post" >
	<h2><?php echo  ($object_type_name) ? lang("new ".$object_type_name) : lang("new") ?></h2>
	<label for="member-name" ><?php echo lang("name")?>:</label>
	<input type="text" required="required" autofocus id="member-name" name="member[name]" /> 
	<input type="hidden" id="dim_id" name="member[dimension_id]" value = "<?php echo $dimension_id ?>" />
	<input type="hidden" id="dim_id" name="member[parent_member_id]" value = "<?php echo $parent_member_id ?>" />
<?php if ($object_type):?>
	<input type="hidden" id="dim_id" name="member[object_type_id]" value = "<?php echo $object_type->getObjectTypeId() ?>" />
<?php else: ?>
	<div class="field" >
		<label><?php echo lang('type') ?>:</label>
		<select name="member[object_type_id]" >
			<?php foreach ($object_types as $dot): /* @var $dot DimensionObjectType */ ?>
			<option  value="<?php echo $dot->getObjectTypeId()?>" >
				<?php echo $dot->getObjectType()->getName()?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
<?php endif;?>

	<div class="action">
		<input type="submit" class="submit" value="<?php echo lang("save")?>" />
		<a href="<?php echo ($object_type) ? $editUrls[$object_type->getObjectTypeId()] : "#" ?>" class="more" ><?php echo lang ('more') ?>>> </a>
	</div>
</form>

<script>
	$( function() {
		
		// To make ajax submit:
		og.captureLinks("quick-form");
		
		// Auto focus member name:
		$("#quick-form #member-name").focus();

		// "more" link
		
		$("#quick-form .more").click(function(){
			$("#quick-form").slideUp();
			//og.openLink(og.getUrl('member', 'add',{dim_id: <?php echo $dimension_id ?>} ));
		});
		

		// After sumbmit hide form 
		$("#quick-form form").submit(function(a){
			$("#quick-form").slideUp();
		});

		// Fire submit on 'enter'
		$('#quick-form #member-name').keypress(function(e){
			if(e.which == 13){
				$('#quick-form .submit').click();
				e.preventDefault();
				return false ;
			}
	    });
				
		// TODO Handle submit / response here
	});
</script>