<?php $genid = gen_id();
	
?>

<form class="internalForm" action="<?php echo $timeslot_form_timeslot->getCloseUrl() ?>" method="post" enctype="multipart/form-data">

<div class="og-timeslot-work-started" style="margin-top:6px;"><?php echo lang('open timeslot message') ?><span id="<?php echo $genid ?>timespan"></span></div>
<script language="JavaScript">
	og.startClock('<?php echo $genid ?>', <?php echo $timeslot_form_timeslot->getSeconds() ?>);
</script>

  <div class="formAddCommentText">
  <?php echo label_tag(lang("end work description"),"closeTimeslotDescription",false) ?>
    <?php echo textarea_field("timeslot[description]", '', array('class' => 'short', 'id' => 'closeTimeslotDescription')) ?>
  </div>
<?php echo submit_button(lang('end work')) ?>
<?php echo submit_button(lang('cancel'),'',
	array('style' => 'margin-left:15px', 'onclick' => 'javascript:if(confirm("' . lang('confirm cancel work timeslot') . '")) {this.form.action += "&cancel=true"} else return false;')) ?>
</form>