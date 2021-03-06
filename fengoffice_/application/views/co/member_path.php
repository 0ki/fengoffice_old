<?php
	$dimensions_info = array();
	$members = $object->getMembers();
	foreach ($members as $member) {
		$dimension = $member->getDimension();
		if (in_array($dimension->getCode(), array('feng_users', 'feng_persons'))) continue;
		
		if (!isset($dimensions_info[$dimension->getName()])) {
			$dimensions_info[$dimension->getName()] = array('members' => array(), 'icon' => $member->getIconClass());
		}
		$dimensions_info[$dimension->getName()]['members'][$member->getId()] = $member->getName();
	}
	
	if (count($dimensions_info) > 0) {
		ksort($dimensions_info, SORT_STRING);
?>
<div class="commentsTitle"><?php echo lang('vinculated to')?></div>
	<div style="padding-bottom: 10px;">
<?php
		foreach ($dimensions_info as $dname => $dinfo) { ?>
			<div class="member-path-dim-block">
				<span class="dname coViewAction <?php echo $dinfo['icon']?>"><?php echo $dname?>:&nbsp;</span>
		<?php
			$first = true;
			foreach ($dinfo['members'] as $mid => $mname) { ?>
				<span class="mname"><?php echo ($first ? "" : ", ") . $mname?></span><?php
				$first = false;
			}
		?></div><?php
		}
	?></div><?php
	}