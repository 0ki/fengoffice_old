<?php
	$dimensions_info = array();
	
	$dimensions = Dimensions::findAll();
	foreach ($dimensions as $dimension) {
		if (in_array($dimension->getCode(), array('feng_users', 'feng_persons'))) continue;
		if (!isset($dimensions_info[$dimension->getName()])) {
			$dimensions_info[$dimension->getName()] = array('id' => $dimension->getId(), 'members' => array());
		}
	}
	
	$members = $object->getMembers();
	foreach ($members as $member) {
		/* @var $member Member */
		$dimension = $member->getDimension();
		if (in_array($dimension->getCode(), array('feng_users', 'feng_persons'))) continue;
		
		if (!can_read(logged_user(), array($member), $object->getObjectTypeId())) continue;
		
		if (!isset($dimensions_info[$dimension->getName()])) {
			$dimensions_info[$dimension->getName()] = array('members' => array(), 'icon' => $member->getIconClass());
		}
		if (!isset($dimensions_info[$dimension->getName()]['icon'])) {
			$dimensions_info[$dimension->getName()]['icon'] = $member->getIconClass();
		}
		$parents = array_reverse($member->getAllParentMembersInHierarchy(true));
		foreach ($parents as $p) {
			$dimensions_info[$dimension->getName()]['members'][] = $p->getName();
		}
	}
	
	foreach ($dimensions_info as &$dim_info) {
		if (!isset($dim_info['icon'])) {
			$dots = DimensionObjectTypes::findAll(array('conditions' => 'dimension_id = '.$dim_info['id']));
			if (count($dots) > 0) {
				$ot = ObjectTypes::findById($dots[0]->getObjectTypeId());
				if ($ot instanceof ObjectType) $dim_info['icon'] = $ot->getIconClass();
			}
		}
	}
	
	if (count($dimensions_info) > 0) {
		ksort($dimensions_info, SORT_STRING);
?>
<div class="commentsTitle"><?php echo lang('related to')?></div>
	<div style="padding-bottom: 10px;">
<?php
		foreach ($dimensions_info as $dname => $dinfo) { ?>
			<div class="member-path-dim-block">
				<span class="dname coViewAction <?php echo array_var($dinfo, 'icon')?>"><?php echo $dname?>:&nbsp;</span>
		<?php
			if (count($dinfo['members']) == 0) {
				echo '<span class="desc">' . lang('not related') . '</span>';
			} else {
				$first = true;
				foreach ($dinfo['members'] as $mid => $mname) { ?>
					<span class="mname"><?php echo ($first ? "" : " - ") . $mname?></span><?php
					$first = false;
				}
			}
		?></div><?php
		}
	?></div><?php
	}