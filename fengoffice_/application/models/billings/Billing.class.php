<?php

/**
 * Billing class
 *
 * @author Diego Castiglioni <diego20@gmail.com>
 */
class Billing extends BaseBilling {

	protected $billing_category;
	
	function getBillingCategory(){
		if(is_null($this->billing_category)) {
			$this->billing_category = BillingCategories::findById($this->getBillingId());
		} // if
		return $this->billing_category;
	}
} // Billing

?>