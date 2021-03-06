<?php
class ProjectEclipseNoHang extends Project {
/**
	 * Returns an array with a list of values and information about where they were obtained from
	 *
	 * @param array $billing_categories
	 */
	function getBillingAmounts($billing_categories = null){
		if(!$billing_categories){
			$billing_categories = BillingCategories::findAll();
		}
		
		if ($billing_categories && count($billing_categories) > 0){
			$result = array();
			$billing_category_ids = array();
			foreach ($billing_categories as $category)
				$billing_category_ids[] = $category->getId();
			
			$wsBillingCategories = WorkspaceBillings::findAll(
				array('conditions' => 'project_id = ' . $this->getId() . ' and billing_id in (' . implode($billing_category_ids) . ')'));
			if ($wsBillingCategories){
				foreach ($wsBillingCategories as $wsCategory){
					for ($i = 0; $i < count($billing_categories); $i++){
						if ($billing_categories[$i]->getId() == $wsCategory->getBillingId()){
							$result[] = array('category' => $billing_categories[$i], 'value' => $wsCategory->getValue(), 'origin' => $this->getId());
							array_splice($billing_categories,$i,1);
							array_splice($billing_category_ids,$i,1);
							break;
						}
					}
				}
			}
			if (count($billing_categories) > 0){
				if ($this->getParentWorkspace() instanceof Project){
					$resultToConcat = $this->getParentWorkspace()->getBillingAmounts($billing_categories);
					foreach ($resultToConcat as $resultValue){
						$result[] = array('category' => $resultValue['category'], 
							'value' => $resultValue['value'], 
							'origin' => (($resultValue['origin'] == 'default')? 'default':'inherited'));
					}
				} else {
					foreach ($billing_categories as $category){
						$result[] = array('category' => $category,'value' => $category->getDefaultValue(), 'origin' => 'default');
					}
				}
			}
		} else return null;
	}
	
	function getBillingTotal(User $user){
		$project_ids = $this->getAllSubWorkspacesCSV($user);
		
		$user_cond = '';
		if (isset($user_id))
			$user_cond = ' AND timeslots.user_id = ' . $user_id;
		
		$row = DB::executeOne('SELECT SUM(timeslots.fixed_billing) as total_billing from ' . Timeslots::instance()->getTableName() . ' as timeslots, ' . ProjectTasks::instance()->getTableName() .
			' as tasks WHERE ((tasks.project_id = ' . $this->getId() . ' AND timeslots.object_id = tasks.id AND timeslots.object_manager = \'ProjectTasks\')' .
			' OR (timeslots.object_manager = \'Project\' AND timeslots.object_id = ' . $this->getId() . '))' . $user_cond);
		
		return array_var($row, 'total_billing', 0);
	}
	
	function getBillingTotalByUsers(User $user, $user_id = null){
		$project_ids = $this->getAllSubWorkspacesCSV($user);
		
		$user_cond = '';
		if (isset($user_id))
			$user_cond = ' AND timeslots.user_id = ' . $user_id;
		
		$rows = DB::executeAll('SELECT SUM(timeslots.fixed_billing) as total_billing, timeslots.user_id as user from ' . Timeslots::instance()->getTableName() . ' as timeslots, ' . ProjectTasks::instance()->getTableName() .
			' as tasks WHERE ((tasks.project_id = ' . $this->getId() . ' AND timeslots.object_id = tasks.id AND timeslots.object_manager = \'ProjectTasks\')' .
			' OR (timeslots.object_manager = \'Project\' AND timeslots.object_id = ' . $this->getId() . '))' . $user_cond . ' GROUP BY user');
		
		if(!is_array($rows) || !count($rows)) 
			return null;
		else
			return $rows;
	}
}
?>