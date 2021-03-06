<div style="padding:10px">
<table id="dashTableDocuments" style="width:100%">
<?php $c = 0;
	foreach ($documents as $document){ $c++;?>
	<tr class="<?php echo $c % 2 == 1? '':'dashAltRow'; echo ' ' . ($c > 5? 'dashSMDC':''); ?>" style="<?php echo $c > 5? 'display:none':'' ?>">
	<td class="db-ico ico-unknown ico-<?php echo str_replace(".", "_", str_replace("/", "-", $document->getTypeString()))?>"></td>
	<td style="padding-left:5px">
	<?php 
		$dws = $document->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
		$projectLinks = array();
		foreach ($dws as $ws) {
			$projectLinks[] = $ws->getId();
		}
		echo '<div style="padding-right:10px;display:inline">' . '<span class="project-replace">' . implode(',',$projectLinks) . '</span></div>';?>
	<a class="internalLink" href="<?php echo get_url('files','file_details', array('id' => $document->getId()))?>"
		title="<?php echo lang('message posted on by linktitle', format_datetime($document->getCreatedOn()), clean($document->getCreatedByDisplayName())) ?>">
	<?php echo clean($document->getFilename())?>
	</a></td>
	<td style="text-align:right">
	<?php if ($document->isModifiable() && $document->canEdit(logged_user())){ ?>
		<a class="internalLink"  href="<?php echo $document->getModifyUrl()?>"><?php echo lang('edit') ?></a>
	<?php } ?></td></tr>
<?php } // foreach ?>
	<?php if ($c >= 10) {?>
		<tr class="dashSMDC" style="display:none"><td></td>
		<td style="text-align:right"><a href="#" onclick="Ext.getCmp('tabs-panel').activate('documents-panel');"><?php echo lang('show all') ?>...</a>
		</td></tr>
	<?php } ?>
</table>
<?php if ($c > 5) { ?>
<div id="dashSMDT" style="width:100%; text-align:right">
	<a href="#" onclick="og.hideAndShowByClass('dashSMDT', 'dashSMDC', 'dashTableDocuments'); return false;"><?php echo lang("show more amount", $c -5) ?>...</a>
</div>
<?php } // if ?>
</div>