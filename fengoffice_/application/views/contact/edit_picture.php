<?php
  if (!isset($genid)) $genid = gen_id();
  set_page_title(lang('edit picture'));

  $action = $contact->getUpdatePictureUrl();
  if (isset($reload_picture) && $reload_picture) {
  	$action .= "&reload_picture=$reload_picture";
  }
  if (isset($new_contact) && $new_contact) {
  	$action .= "&new_contact=$new_contact";
  }

  ajx_set_no_toolbar();
?>
<div class="coInputHeader" style="margin-top:20px;">
  <div class="coInputHeaderUpperRow">
	<div class="coInputTitle">
		<?php echo lang('update avatar') ?>
	</div>
  </div>
</div>
<div id="<?php echo $genid?>current_picture" style="float:left; padding-right:20px; border-right: 1px dotted #999;">
	
	<div style="padding:10px;">
<?php if($contact->hasPicture()) { ?>
    <img src="<?php echo $contact->getPictureUrl() ?>" alt="<?php echo clean($contact->getObjectName()) ?> picture" />
    <p><a class="internalLink link-ico ico-delete" href="<?php echo $contact->getDeletePictureUrl() ?>" onclick="return confirm('<?php echo escape_single_quotes(lang('confirm delete current picture')) ?>')"><?php echo lang('delete current picture') ?></a></p>
<?php } else { ?>
    <?php echo lang('no current picture') ?>
<?php } // if ?>
	</div>
</div>



<div style="float: left;" id="<?php echo $genid?>uploadPreviewContainer">
	<!-- image preview area-->
	<img id="<?php echo $genid?>uploadPreview" style="display:none;"/>
</div>
<div style="float: left;padding:10px; margin-left: 20px;">
	<h1><?php echo lang('new picture')?></h1>
	<div class="desc"><?php echo lang('new picture notice')?></div>
	<div style="margin-top:20px;">
	<!-- image uploading form -->
	  <form action="<?php echo $action ?>" method="post" enctype="multipart/form-data" onsubmit="og.beforePictureSubmit();return og.submit(this)" target="_blank">
		<?php echo file_field('new picture', null, array('id' => $genid.'uploadImage')) ?>
		<div><?php echo submit_button(lang('save'), 's', array('id' => $genid.'submit_btn')) ?>
		<?php echo button(lang('back'), 'b', array('id' => $genid.'back_btn', 'onclick' => "og.beforePictureSubmit();og.goback(this);")) ?></div>

		<!-- hidden inputs -->
		<input type="hidden" id="<?php echo $genid?>x" name="x" />
		<input type="hidden" id="<?php echo $genid?>y" name="y" />
		<input type="hidden" id="<?php echo $genid?>w" name="w" />
		<input type="hidden" id="<?php echo $genid?>h" name="h" />
	  </form>
	</div>
</div>
<script>
	
	var genid = '<?php echo $genid?>';

	og.setPictureInfo = function(i, e) {
		$('#'+genid+'x').val(e.x1);
		$('#'+genid+'y').val(e.y1);
		$('#'+genid+'w').val(e.width);
		$('#'+genid+'h').val(e.height);
	}

	og.beforePictureSubmit = function() {
		$(".imgareaselect-selection").parent().remove();
		$(".imgareaselect-outer").remove();
	}


	og.tmpPictureFileUpload = function(genid, config) {
		var fileInput = document.getElementById(genid + 'uploadImage');
		var fileParent = fileInput.parentNode;
		fileParent.removeChild(fileInput);
		var form = document.createElement('form');
		form.method = 'post';
		form.enctype = 'multipart/form-data';
		form.encoding = 'multipart/form-data';
		form.action = og.getUrl('contact', 'tmp_picture_file_upload', {'id': genid});
		form.style.display = 'none';
		form.appendChild(fileInput);
		document.body.appendChild(form);

		og.submit(form, {
			callback: function(d) {
				form.removeChild(fileInput);
				fileParent.appendChild(fileInput);
				document.body.removeChild(form);
				if (typeof config.callback == 'function') {
					config.callback.call(config.scope, d);
				}
			}
		});
	}

	$(document).ready(function() {
		var p = $("#"+genid+"uploadPreview");
		//p.focus();
		
		// implement imgAreaSelect plug in (http://odyniec.net/projects/imgareaselect/)
		og.area_sel = $('img#'+genid+'uploadPreview').imgAreaSelect({
			aspectRatio: '1:1',
			handles: true,
			instance: true,
			onSelectEnd: og.setPictureInfo
		});

		// prepare instant preview
		$("#"+genid+"uploadImage").change(function(){
			// fadeOut or hide preview
			p.fadeOut();

			$("#"+genid+"current_picture").hide();

			// For browsers with HTML5 compatibility
			if (window.FileReader) {
				var fr = new FileReader();
				fr.readAsDataURL(document.getElementById(genid+"uploadImage").files[0]);
	
				fr.onload = function (fevent) {
			   		p.attr('src', fevent.target.result).fadeIn();
				};
				
				setTimeout(function() {
					og.area_sel.setSelection(0,0,200,200,true);
					og.area_sel.setOptions({show: true});
					og.area_sel.update();
				}, 500);
			} else {
				// For old browsers (IE 9 or older)
				og.tmpPictureFileUpload(genid, {
					callback: function(data) {
						$("#"+genid+"uploadPreview").attr('src', data.url).fadeIn();

						og.area_sel = $('img#'+genid+'uploadPreview').imgAreaSelect({
							aspectRatio: '1:1',
							handles: true,
							instance: true,
							onSelectEnd: og.setPictureInfo
						});
						
						setTimeout(function() {
							og.area_sel.setSelection(0,0,200,200,true);
							og.area_sel.setOptions({show: true});
							og.area_sel.update();
						}, 500);
					}
				});
			}
		});

	});
</script>