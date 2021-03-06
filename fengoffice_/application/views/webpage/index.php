<?php
  set_page_title(lang('webpages'));
  if(!active_project() || ProjectWebpage::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add webpage'), get_url('webpage', 'add'));
  } // if

if($webpages) { ?>

<div id="webpages">
<table>
<tr>
	<th style="width:150px"><?php echo lang('url') ?></th>
	<th style="width:350px"><?php echo lang('description') ?></th>
	<th style="width:24px"><?php echo lang('edit') ?></th>
</tr>
<?php foreach($webpages as $webpage) { ?> 
	<tr>
		<td style="padding-left:4px">
    		<a href="" onclick="window.open('<?php echo $webpage->getUrl() ?>');return false;"><?php echo clean($webpage->getTitle()) ?></a>
    	</td>
        <td>
        	<div><?php echo clean($webpage->getDescription()) ?></div>
        </td>
        <td style="text-align:right">
          	<a class="internalLink" href="<?php echo $webpage->getEditURL() ?>"><?php echo lang('edit') ?></a>
        </td>
    </tr>
<?php } // foreach ?>
</table>
  </div>
<?php } else { ?>
<p><?php echo clean(lang('no active webpages in project')) ?></p>
<?php } // if ?>