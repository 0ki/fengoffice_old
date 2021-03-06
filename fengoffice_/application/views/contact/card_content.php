<?php $contact = $object; ?>
<table>
	 <tr><td>
  		<div class="cardData">
    
    <?php if ($contact->getDepartment() ||$contact->hasCompany() || $contact->getEmail() || $contact->getEmail2() || $contact->getEmail3()
    || is_array($im_values = $contact->getImValues()) && count($contact)) {?>
    <div class="cardBlock">
      
      <h2><?php echo lang('personal information') ?></h2>
      
      <?php if ($contact->hasCompany()) { ?>
      <div><a class="internalLink" href="<?php echo $contact->getCompany()->getCardUrl() ?>"><?php echo clean($contact->getCompany()->getName());?></a></div><?php } ?>
      
      <?php if ($contact->getDepartment()) { ?>
      <div><span><?php echo lang('department') ?>:</span> <?php echo clean($contact->getDepartment());?></div><?php } ?>
      
      <?php if ($contact->getJobTitle()) { ?>
      <div><span><?php echo lang('job title') ?>:</span> <?php echo clean($contact->getJobTitle());?></div><?php } ?>
      
      <h3><?php echo lang('contact online') ?></h3>
      <?php if ($contact->getEmail()) { ?>
      <div><span><?php echo lang('email address') ?>:</span> <a href="mailto:<?php echo clean($contact->getEmail());?>"><?php echo clean($contact->getEmail());?></a></div><?php } ?>
      <?php if ($contact->getEmail2()) { ?>
      <div><span><?php echo lang('email address 2') ?>:</span> <a href="mailto:<?php echo clean($contact->getEmail2());?>"><?php echo clean($contact->getEmail2());?></a></div><?php } ?>
      <?php if ($contact->getEmail3()) { ?>
      <div><span><?php echo lang('email address 3') ?>:</span> <a href="mailto:<?php echo clean($contact->getEmail3());?>"><?php echo clean($contact->getEmail3());?></a></div><?php } ?>
      <?php if ($contact->getOBirthday()) { ?>
      <div><span><?php echo lang('birthday') ?>:</span> <?php if ($contact->getOBirthday() instanceof DateTimeValue) echo clean($contact->getOBirthday()->format("D M j, Y"));?></div><?php } ?>
      <?php if(is_array($im_values = $contact->getImValues()) && count($contact)) { ?>
      <table class="imAddresses">
<?php foreach($im_values as $im_value) { ?>
<?php if($im_type = $im_value->getImType()) { ?>
        <tr>
          <td><img src="<?php echo $im_type->getIconUrl() ?>" alt="<?php echo $im_type->getName() ?>" /></td>
          <td><?php echo clean($im_value->getValue()) ?> <?php if($im_value->getIsDefault()) { ?><span class="desc">(<?php echo lang('primary im service') ?>)</span><?php } ?></td>
        </tr>
<?php } // if ?>
<?php } // foreach ?>
      </table>
<?php } // if ?>
    </div>
<?php } // if ?>
    
    
    <?php if($contact->getWAddress() || $contact->getWCity() || $contact->getWState() || $contact->getWWebPage() || $contact->getWZipcode() || $contact->getWCountry() || $contact->getWPhoneNumber() || $contact->getWPhoneNumber2() || $contact->getWFaxNumber() || $contact->getWAssistantNumber() || $contact->getWCallbackNumber()) {?>
    <div class="cardBlock">
      <h2><?php echo lang('work information') ?></h2>
      <?php if ($contact->getWAddress()) { ?>
      <div><span><?php echo lang('address') ?>:</span> <?php echo clean($contact->getWAddress());?></div><?php } ?>
      <?php if ($contact->getWCity()) { ?>
      <div><span><?php echo lang('city') ?>:</span> <?php echo clean($contact->getWCity());?></div><?php } ?>
      <?php if ($contact->getWState()) { ?>
      <div><span><?php echo lang('state') ?>:</span> <?php echo clean($contact->getWState());?></div><?php } ?>
      <?php if ($contact->getWZipcode()) { ?>
      <div><span><?php echo lang('zipcode') ?>:</span> <?php echo clean($contact->getWZipcode());?></div><?php } ?>
      <?php if ($contact->getWCountry()) { ?>
      <div><span><?php echo lang('country') ?>:</span> <?php echo clean($contact->getWCountry());?></div><?php } ?>
      <?php if($contact->getWPhoneNumber() || $contact->getWPhoneNumber2() || $contact->getWFaxNumber() || $contact->getWAssistantNumber() || $contact->getWCallbackNumber()) {?><br/><?php } ?>
    
      <?php if ($contact->getWPhoneNumber()) { ?>
      <div><span><?php echo lang('phone number') ?>:</span> <?php echo clean($contact->getWPhoneNumber());?></div><?php } ?>
      <?php if ($contact->getWPhoneNumber2()) { ?>
      <div><span><?php echo lang('phone number 2') ?>:</span> <?php echo clean($contact->getWPhoneNumber2());?></div><?php } ?>
      <?php if ($contact->getWFaxNumber()) { ?>
      <div><span><?php echo lang('fax number') ?>:</span> <?php echo clean($contact->getWFaxNumber());?></div><?php } ?>
      <?php if ($contact->getWAssistantNumber()) { ?>
      <div><span><?php echo lang('assistant number') ?>:</span> <?php echo clean($contact->getWAssistantNumber());?></div><?php } ?>
      <?php if ($contact->getWCallbackNumber()) { ?>
      <div><span><?php echo lang('callback number') ?>:</span> <?php echo clean($contact->getWCallbackNumber());?></div><?php } ?>
      <?php if ($contact->getWWebPage()) { ?>
      <br/><div><span><?php echo lang('website') ?>: </span><a href="<?php echo cleanUrl($contact->getWWebPage()) ?>" target="_blank" title="<?php echo lang('open this link in a new window') ?>"><?php echo clean($contact->getWWebPage()) ?></a></div><?php } ?>
    </div>  
<?php } // if ?>
    
    
    <?php if($contact->getHAddress() || $contact->getHCity() || $contact->getHState() || $contact->getHWebPage() || $contact->getHZipcode() || $contact->getHCountry() || $contact->getHPhoneNumber() || $contact->getHPhoneNumber2() || $contact->getHFaxNumber() || $contact->getHMobileNumber() || $contact->getHPagerNumber()) {?>
    <div class="cardBlock">
      <h2><?php echo lang('home information') ?></h2>
      <?php if ($contact->getHAddress()) { ?>
      <div><span><?php echo lang('address') ?>:</span> <?php echo clean($contact->getHAddress());?></div><?php } ?>
      <?php if ($contact->getHCity()) { ?>
      <div><span><?php echo lang('city') ?>:</span> <?php echo clean($contact->getHCity());?></div><?php } ?>
      <?php if ($contact->getHState()) { ?>
      <div><span><?php echo lang('state') ?>:</span> <?php echo clean($contact->getHState());?></div><?php } ?>
      <?php if ($contact->getHZipcode()) { ?>
      <div><span><?php echo lang('zipcode') ?>:</span> <?php echo clean($contact->getHZipcode());?></div><?php } ?>
      <?php if ($contact->getHCountry()) { ?>
      <div><span><?php echo lang('country') ?>:</span> <?php echo clean($contact->getHCountry());?></div><?php } ?>
      <?php if($contact->getHPhoneNumber() || $contact->getHPhoneNumber2() || $contact->getHFaxNumber() || $contact->getHMobileNumber() || $contact->getHPagerNumber()) {?><br/><?php } ?>
    
      <?php if ($contact->getHPhoneNumber()) { ?>
      <div><span><?php echo lang('phone number') ?>:</span> <?php echo clean($contact->getHPhoneNumber());?></div><?php } ?>
      <?php if ($contact->getHPhoneNumber2()) { ?>
      <div><span><?php echo lang('phone number 2') ?>:</span> <?php echo clean($contact->getHPhoneNumber2());?></div><?php } ?>
      <?php if ($contact->getHFaxNumber()) { ?>
      <div><span><?php echo lang('fax number') ?>:</span> <?php echo clean($contact->getHFaxNumber());?></div><?php } ?>
      <?php if ($contact->getHMobileNumber()) { ?>
      <div><span><?php echo lang('mobile number') ?>:</span> <?php echo clean($contact->getHMobileNumber());?></div><?php } ?>
      <?php if ($contact->getHPagerNumber()) { ?>
      <div><span><?php echo lang('pager number') ?>:</span> <?php echo clean($contact->getHPagerNumber());?></div><?php } ?>
      <?php if ($contact->getHWebPage()) { ?>
      <br/><div><span><?php echo lang('website') ?>:</span><a href="<?php echo cleanUrl($contact->getHWebPage()) ?>" target="_blank"><?php echo clean($contact->getHWebPage()) ?></a></div><?php } ?>
    </div> 
<?php } // if ?>
    
    <?php if($contact->getOAddress() || $contact->getOCity() || $contact->getOState() || $contact->getOZipcode() || $contact->getOCountry() || $contact->getOPhoneNumber() || $contact->getOPhoneNumber2() || $contact->getOFaxNumber()) {?>
    <div class="cardBlock">
      <h2><?php echo lang('other information') ?></h2>
      <?php if ($contact->getOAddress()) { ?>
      <div><span><?php echo lang('address') ?>:</span> <?php echo clean($contact->getOAddress());?></div><?php } ?>
      <?php if ($contact->getOCity()) { ?>
      <div><span><?php echo lang('city') ?>:</span> <?php echo clean($contact->getOCity());?></div><?php } ?>
      <?php if ($contact->getOState()) { ?>
      <div><span><?php echo lang('state') ?>:</span> <?php echo clean($contact->getOState());?></div><?php } ?>
      <?php if ($contact->getOZipcode()) { ?>
      <div><span><?php echo lang('zipcode') ?>:</span> <?php echo clean($contact->getOZipcode());?></div><?php } ?>
      <?php if ($contact->getOCountry()) { ?>
      <div><span><?php echo lang('country') ?>:</span> <?php echo clean($contact->getOCountry());?></div><?php } ?>
      <?php if($contact->getOPhoneNumber() || $contact->getOPhoneNumber2() || $contact->getOFaxNumber()) {?><br/><?php } ?>
    <?php if ($contact->getOPhoneNumber()) { ?>
      <div><span><?php echo lang('phone number') ?>:</span> <?php echo clean($contact->getOPhoneNumber());?></div><?php } ?>
      <?php if ($contact->getOPhoneNumber2()) { ?>
      <div><span><?php echo lang('phone number 2') ?>:</span> <?php echo clean($contact->getOPhoneNumber2());?></div><?php } ?>
      <?php if ($contact->getOFaxNumber()) { ?>
      <div><span><?php echo lang('fax number') ?>:</span> <?php echo clean($contact->getOFaxNumber());?></div><?php } ?>
    </div> 
<?php } // if ?>
    
    <?php if ($contact->getNotes()) {?>
    <div class="cardBlock">
      <h2><?php echo lang('notes') ?></h2>
      <div><?php echo clean($contact->getNotes()) ?></div>
    </div>
    <?php } ?>
    
    <?php
    	$roles = $contact->getRoles();
     if(!is_null($roles) && is_array($roles) && count($roles) > 0) {?>
    	<h2><?php echo lang('contact projects') ?></h2>
		<div class="cardBlock" style="margin-bottom: 0">
		<table>
		<?php foreach($roles as $role){
			if($role->getProject()){
			?>
			<tr><td style="text-align:right">
			<div><span><?php echo $role->getProject()->getName() ?> - </span> </div>
      </td><td><div><?php echo $role->getRole()? clean($role->getRole()) : lang('n/a') ?></div></td></tr>
		<?php 	} //if
			} //foreach ?>
      		</table>
		
		</div>
	<?php } //if ?>
	</div>
  </td>
  <td style="padding-left:40px">
    <?php if($contact->hasUser())
    {
    	?><h2><?php echo lang('assigned user') ?></h2>
    	<?php
    	$user = $contact->getUser();
    	tpl_assign('user',$user);
    	$this->includeTemplate(get_template_path('user_card', 'user'));
    }
    	  ?>
  </td>
  </tr>
  </table>