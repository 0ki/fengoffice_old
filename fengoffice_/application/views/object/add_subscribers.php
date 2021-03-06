<?php
require_javascript('og/modules/addMessageForm.js'); 
?>

<div class="og-add-subscribers">
<?php
	if (!is_array($subscriberIds)) $subscriberIds = array(logged_user()->getId());
	if (!isset($workspaces)) $workspaces = array(active_or_personal_project());
	if (!isset($genid)) $genid = gen_id();
?>
<?php
	// get users with permissions
	if ($type == 'Contacts') {
		$users = Users::getContactManagers();
	} else {
		$users = array();
		foreach ($workspaces as $ws) {
			$someUsers = $ws->getUsers(false);
			foreach ($someUsers as $u) {
				// see if user can read type of object in the workspace
				$canRead = can_manage_type($type, ProjectUsers::getByUserAndProject($ws, $u), ACCESS_LEVEL_READ);
				if ($canRead) {
					$users["u".$u->getId()] = $u;
				}
			}
		}
		$users = array_values($users);
	}
	$grouped = array();
	foreach($users as $user) {
		if(!isset($grouped[$user->getCompanyId()]) || !is_array($grouped[$user->getCompanyId()])) {
			$grouped[$user->getCompanyId()] = array();
		} // if
		$grouped[$user->getCompanyId()][] = $user;
	} // foreach
	$companyUsers = $grouped;
?>
<div id="<?php echo $genid ?>notify_companies">

<?php foreach($companyUsers as $companyId => $users) { ?>

<div id="<?php echo $companyId?>" class="company-users" <?php echo is_array($users) == true? 'style ="margin-bottom: 10px;"' : '' ?>>

	<?php if(is_array($users) && count($users)) { ?>
		<div onclick="og.subscribeCompany(this)"  class="container-div company-name" onmouseout="og.rollOut(this,true)" onmouseover="og.rollOver(this)">
		<?php $theCompany = Companies::findById($companyId) ?>
			<label for="<?php echo $genid ?>notifyCompany<?php echo $theCompany->getId() ?>" style="background: url('<?php echo $theCompany->getLogoUrl() ?>') no-repeat;">
				<span class="ico-company link-ico"><?php echo clean($theCompany->getName()) ?></span>
			</label>
		</div>
		<div style="padding-left:10px;">
		<?php foreach($users as $user) { ?>
				<?php
					$checked = in_array($user->getId(), $subscriberIds);
				?>
				<div id="<?php echo $user->getDisplayName() ?>" class="container-div <?php echo $checked==true? 'checked-user':'user-name' ?>" onmouseout="og.rollOut(this,false <?php echo $checked==true? ',true':',false' ?>)" onmouseover="og.rollOver(this)" onclick="og.checkUser(this)">
					<input id="hiddenUser<?php echo $user->getDisplayName()?>" type="hidden" name="<?php echo 'subscribers[user_'.$user->getId() .']' ?>" value="<?php echo $checked == true? 'checked': '' ?>" />
					<label for="<?php echo $genid ?>notifyUser<?php echo $user->getId() ?>" style=" width: 120px; overflow:hidden; background:url('<?php echo $user->getAvatarUrl() ?>') no-repeat;">
						<span class="ico-user link-ico"><?php echo clean($user->getDisplayName()) ?></span>
						<br>
						<span style="color:#888888;font-size:90%;font-weight:normal;"> <?php echo $user->getEmail()  ?> </span>
					</label>
				</div>
			
		<?php } // foreach ?>
		<div style="clear:both;"></div>
		</div>
	<?php } // if ?>
</div>	
<?php } // foreach ?>

</div>
</div>