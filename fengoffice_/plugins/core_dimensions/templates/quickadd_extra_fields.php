<div class="field">
	<label><?php echo lang("email")?></label>
	<input class="quick-form-mail" type="email" name="contact[email]" />
</div>
<?php 
	tpl_display(get_template_path("add_contact/access_data","contact"));
?>

<script>
	$(function(){
		$(".quick-add-object-type").closest(".field").hide();
		$(".extra-fields").closest("form").find("a.more").remove();
		og.checkEmailAddress(".quick-form-mail");
		H5F.setup($("#quick-form form"));
	});
</script>