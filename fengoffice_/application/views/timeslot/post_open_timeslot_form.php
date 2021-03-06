
<form class="internalForm" action="<?php echo $timeslot_form_timeslot->getCloseUrl() ?>" method="post" enctype="multipart/form-data">


<div class="og-timeslot-work-started" style="margin-top:6px;">
	<?php echo lang('open timeslot message', DateTimeValue::FormatTimeDiff($timeslot_form_timeslot->getStartTime(), null, "hm", 60)) ?>
</div>

  <div class="formAddCommentText">
  <?php echo label_tag(lang("end work description"),"closeTimeslotDescription",false) ?>
    <?php echo textarea_field("timeslot[description]", '', array('class' => 'short', 'id' => 'closeTimeslotDescription')) ?>
  </div>
<?php echo submit_button(lang('end work')) ?>
</form>