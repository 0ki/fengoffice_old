<?php
function render_contact_data_tab($genid, $contact, $renderContext, $contact_data, $renderAddCompany = true){
	$object = $contact;
	// telephone types
	$all_telephone_types = TelephoneTypes::getAllTelephoneTypesInfo();
	tpl_assign('all_telephone_types', $all_telephone_types);
	include get_template_path("tabs/contact_data","contact");
}

function render_company_data_tab($genid, $company, $renderContext, $company_data){	
	$object = $company;
	
	// telephone types
	$all_telephone_types = TelephoneTypes::getAllTelephoneTypesInfo();
	
	// address types
	$all_address_types = AddressTypes::getAllAddressTypesInfo();
	
	// webpage types
	$all_webpage_types = WebpageTypes::getAllWebpageTypesInfo();
	
	// email types
	$all_email_types = EmailTypes::getAllEmailTypesInfo();
		
	include get_template_path("tabs/company_data","contact");
}