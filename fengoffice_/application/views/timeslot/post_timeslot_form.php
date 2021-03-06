<?php $genid = gen_id(); ?>
<table><tr><td style="padding-right:15px" id="<?php echo $genid?>tdstartwork">
<form class="internalForm" action="<?php echo Timeslot::getOpenUrl($timeslot_form_object) ?>" method="post" enctype="multipart/form-data">
<?php echo submit_button(lang('start work')) ?>
</form>
</td><td>
<form class="internalForm" action="<?php echo Timeslot::getAddTimespanUrl($timeslot_form_object) ?>" method="post" enctype="multipart/form-data">
<button id="<?php echo $genid?>buttonAddWork" type="button" class="submit" onclick="addWork('<?php echo $genid?>')"><?php echo lang('add work') ?></button>

<div id="<?php echo $genid?>addwork" style="display:none">
<table><tr><td>
	<?php echo label_tag(lang("end work description"), $genid . "closeTimeslotDescription", false) ?>
        <?php echo textarea_field("timeslot[description]", '', array('class' => 'short', 'id' => $genid . 'closeTimeslotDescription', 'tabstop' => '100')) ?>
</td><td style="padding-left:10px">
	<?php echo label_tag(lang('total time'), "closeTimeslotTotalTime", false) ?>
        <table>
		<tr>
			<td align="right"><?php echo lang("hours") ?>:&nbsp;</td>
			<td align='left'><?php echo text_field("timeslot[hours]", '', array('style' => 'width:30px', 'tabindex' => '80')) ?></td>
			<td align="right" style="padding-left:10px"><?php echo lang("minutes") ?>:&nbsp;</td>
			<td align='left'><select name="timeslot[minutes]" size="1" tabindex="85">
			<?php
				$minuteOptions = array(0,5,10,15,20,25,30,35,40,45,50,55);
				for($i = 0; $i < 12; $i++) {
					echo "<option value=\"" . $minuteOptions[$i] . "\"";					
					echo ">" . $minuteOptions[$i] . "</option>\n";
				}
			?></select>
			</td>
		</tr>
        </table>
</td></tr></table>

<?php echo submit_button(lang('add work')) ?>
<button class="submit" style="margin-left:15px" id="buttonAddWorkCancel" type="button" onclick="cancleWork('<?php echo $genid?>')"><?php echo lang('cancel') ?></button>
</div>

</form>
</td></tr></table>

<script>
    function addWork(genid){
        document.getElementById(genid + 'addwork').style.display = 'inline';
        document.getElementById(genid + 'buttonAddWork').style.display = 'none';
        document.getElementById(genid + 'tdstartwork').style.display = 'none';
        document.getElementById(genid + 'closeTimeslotDescription').focus();
        return false;
    }
    
    function cancleWork(genid){
        document.getElementById(genid + 'addwork').style.display = 'none';
        document.getElementById(genid + 'buttonAddWork').style.display = 'inline';
        document.getElementById(genid + 'tdstartwork').style.display = '';
        return false;
    }
    
</script>