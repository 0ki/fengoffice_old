<?php
	$genid = gen_id();
  set_page_title(lang('update permissions'));
  
  if($user->canUpdateProfile(logged_user())) {
	add_page_action(lang('update profile'), $user->getEditProfileUrl(), 'ico-edit');
	add_page_action(lang('update avatar'), $user->getUpdateAvatarUrl(), 'ico-picture');
	add_page_action(lang('change password'),$user->getEditPasswordUrl(), 'ico-password');
  } // if
  
?>
<script type="text/javascript">
function expandCollapse(obj, id, textX, textC) {
	var div = document.getElementById(id);
	if (div.style.display == 'none') {
		div.style.display = 'block';
		obj.innerHTML = textC;
	} else {
		div.style.display = 'none';
		obj.innerHTML = textX;
	}
}

function checkUncheck(me, id) {
	var div = Ext.get('div' + id);
	var checkboxes = div.select('input.checkbox');
	var count = 0;
	checkboxes.each(function() {
		this.dom.checked = me.checked;
		this.dom.value = me.value;
		count++;
	});
	if (me.checked) {
		Ext.getDom('count'+id).innerHTML = count + "/" + count;
	} else {
		Ext.getDom('count'+id).innerHTML = "0/" + count;
	}
}

function checkUncheckSingle(me, id) {
	var c = Ext.getDom('count'+id);
	var vals = c.innerHTML.split("/");
	if (me.checked) {
		c.innerHTML = (parseInt(vals[0]) + 1) + "/" + vals[1];
		if (vals[0] == 0) {
			Ext.getDom(id).checked = true;
		}
	} else {
		c.innerHTML = (vals[0] - 1) + "/" + vals[1];
		if (vals[0] == 1) {
			Ext.getDom(id).checked = false;
		}
	}
}

</script>
<form action="<?php echo get_url("account", "update_permissions", array("id" => $user->getId())) ?>" class="internalForm" method="POST">
<div class="adminClients">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang("permissions for user", $user->getUsername()) ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
<input name="submitted" type="hidden" value="submitted" />
<?php echo submit_button(lang('update permissions'));?>

<fieldset class=""><legend class="toggle_expanded" onclick="og.toggle('<?php echo $genid ?>userSystemPermissions',this)"><?php echo lang("system permissions") ?></legend>
	<div id="<?php echo $genid ?>userSystemPermissions" style="display:block">
		<div>
	      <?php echo checkbox_field('user[can_edit_company_data]',array_var($user_data,'can_edit_company_data'), array('id' => 'user[can_edit_company_data]' )) ?> 
	      <label for="<?php echo 'user[can_edit_company_data]' ?>" class="checkbox"><?php echo lang('can edit company data') ?></label>
	    </div>    
	    <div>
	      <?php echo checkbox_field('user[can_manage_security]', array_var($user_data,'can_manage_security'), array('id' => 'user[can_manage_security]' )) ?> 
	      <label for="<?php echo 'user[can_manage_security]' ?>" class="checkbox"><?php echo lang('can manage security') ?></label>
	    </div>  
	    <div>
	      <?php echo checkbox_field('user[can_manage_workspaces]', array_var($user_data,'can_manage_workspaces'), array('id' => 'user[can_manage_workspaces]' )) ?> 
	      <label for="<?php echo 'user[can_manage_workspaces]' ?>" class="checkbox"><?php echo lang('can manage workspaces') ?></label>
	    </div>  
	    <div>
	      <?php echo checkbox_field('user[can_manage_configuration]', array_var($user_data,'can_manage_configuration'), array('id' => 'user[can_manage_configuration]' )) ?> 
	      <label for="<?php echo 'user[can_manage_configuration]' ?>" class="checkbox"><?php echo lang('can manage configuration') ?></label>
	    </div>  
	    <div>
	      <?php echo checkbox_field('user[can_manage_contacts]', array_var($user_data,'can_manage_contacts'), array('id' => 'user[can_manage_contacts]' )) ?> 
	      <label for="<?php echo 'user[can_manage_contacts]' ?>" class="checkbox"><?php echo lang('can manage contacts') ?></label>
	    </div>  
	</div>
</fieldset>



<fieldset class=""><legend class="toggle_expanded" onclick="og.toggle('<?php echo $genid ?>userProjectPermissions',this)"><?php echo lang("project permissions") ?></legend>
	<div id="<?php echo $genid ?>userProjectPermissions" style="display:block">
<?php
foreach ($projects as $project) {
	$id = 'project_permissions_' . $project->getId();
	$relation = ProjectUsers::findById(array(
		'project_id' => $project->getId(),
		'user_id' => $user->getId()
	));
	$amount = 0; $total = 0;
	foreach ($permissions as $k => $p) {
		if ($relation instanceof ProjectUser && $relation->getColumnValue($k)) {
			$amount++;
		}
		$total++;
	}
	echo "<div class=\"permissionHeader\">";
	echo "<input class=\"checkbox\" type=\"checkbox\" " . ($amount > 0?"checked=\"checked\"":"") . " id=\"$id\" name=\"".$id."\"onclick=\"checkUncheck(this, '$id')\" />";
	echo "<label class=\"checkbox\" for=\"$id\">".$project->getName()."</label>";
	echo "<span id=\"count$id\" class=\"count\">$amount/$total</span>";
	echo "<a href=\"#\" onclick=\"expandCollapse(this, 'div$id', '".lang('more')."', '".lang('hide')."')\">";
	echo lang('more');
	echo "</a>";
	echo "<div id=\"div$id\" style=\"display:none\" class=\"permissionMore\">";
	echo "<table>";
	$i = 1; $cols = 2;
	foreach ($permissions as $k => $p) {
		if ($i == 1) {
			echo "<tr>";
		}
		echo "<td>";
		echo "<input class=\"checkbox\" type=\"checkbox\" id=\"".$id."_".$k."\" name=\"".$id."_".$k."\" ".($relation instanceof ProjectUser && $relation->getColumnValue($k)?"checked=\"checked\"":"")."\" onclick=\"checkUncheckSingle(this, '$id')\" />";
		echo "<label class=\"checkbox\" for=\"".$id."_".$k."\">$p</label>";
		echo "</td>";
		if ($i == $cols) {
			$i = 0;
			echo "</tr>";
		}
		$i++;
	}
	echo "</table>";
	echo "</div>";
	echo "</div>";
} ?></div></fieldset>
<?php echo submit_button(lang('update permissions'));?>
</div>
</form>