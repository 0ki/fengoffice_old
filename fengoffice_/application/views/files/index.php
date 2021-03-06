
<?php
// Marcos Saiz 01/10/07
//CREDITS:
/***********************************************

* CSS Horizontal List Menu- by JavaScript Kit (www.javascriptkit.com)
* Menu interface credits: http://www.dynamicdrive.com/style/csslibrary/item/glossy-vertical-menu/ 
* This notice must stay intact for usage
* Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and 100s more

***********************************************/
// This one was taken from http://www.javascriptkit.com/script/script2/csstopmenu.shtml
/***********************************************
* Flip Menu- by Osem Websystems (http://www.osem.nl/)
* Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and 100s more
***********************************************/


  set_page_title(lang('documents'));
  //project_tabbed_navigation(PROJECT_TAB_FILES);
  $files_crumbs = array(
    0 => array(lang('files'), get_url('files'))
  ); // array
  if($current_folder instanceof ProjectFolder) {
    $files_crumbs[] = array($current_folder->getName(), $current_folder->getBrowseUrl($order));
  } // if
  $files_crumbs[] = array(lang('index'));
  
  project_crumbs($files_crumbs);
  add_javascript_to_page('file/filehorizontalmenu.js');
  add_javascript_to_page('file/filetreemenu.js');
  add_javascript_to_page('file/filesortablelist.js');
  add_stylesheet_to_page('file/filehorizontalmenu.css');
  add_stylesheet_to_page('file/filesortablelist.css');
  add_stylesheet_to_page('file/filetreemenu.css');
  add_stylesheet_to_page('file/files.css');
  add_stylesheet_to_page('project/files.css');

?>


<table id="files_layout" class="layout">
<tr><td colspan="2">
	<!-- horizontal menu -->
	<div class="horizontalcssmenu">
		<ul id="cssmenu1">
			<li>
				<a href="<?php echo get_url('files', 'add_document')?>">
					<img src="<?php echo get_image_url('filetypes/doc.png')?>" title="<?php echo  lang('new document');?>">
				</a>
			</li>
			<li>
				<a href="<?php echo get_url('files', 'add_spreadsheet')?>">
					<img src="<?php echo get_image_url('filetypes/sprd.png')?>" title="<?php echo  lang('new spreadsheet');?>">
				</a>
			</li>
			<li>
				<a href="<?php echo get_url('files', 'add_presentation')?>">
					<img src="<?php echo get_image_url('filetypes/prsn.png')?>" title="<?php echo  lang('new presentation');?>">
				</a>
			</li>
			<li>
				<a href="<?php echo get_url('files', 'add_file')?>"><?php echo lang('upload')?></a>
			</li>
			<li>
				<a href="#"><?php echo lang('tag')?></a>
				<ul>
					<?php if (count($tags) <= 0) { ?>
					<li>
						<i>No tags yet</i>
					</li>
					<?php } ?>
					<?php foreach($tags as $tag ) { ?>
					<?php $baseurl = get_url('files', 'tag_file');?>
					<li>
						<a href="javascript: tagFile('<?php  echo  $tag; ?>','<?php echo $baseurl?>');"><?php  echo  $tag; ?></a>
					</li>
					<?php } ?> 
					<?php $baseurl = get_url('files', 'tag_file');?>
					<li>
						<input id="newtag" type="text" value="new tag" onfocus="if (document.getElementById('newtag').value=='new tag') document.getElementById('newtag').value='';"
								onblur="if (document.getElementById('newtag').value=='') document.getElementById('newtag').value='new tag';"/>
						<input type="button" value="Add tag" name="addTag" id="addTag" onclick="tagFile(document.getElementById('newtag').value,'<?php echo $baseurl?>'); " />
					</li>
				</ul>
			</li>
			<?php $baseurl = get_url('files', 'delete_files');?>
			<li>
				<a href="javascript: if( confirm('<?php echo lang('confirm delete file')?>') ) deleteFiles('<?php echo $baseurl ?>');"><?php echo lang('delete')?></a>
			</li>
			<li>
				<a href="#"><?php echo lang('more')?></a>
				<ul>
					<li>
						<a href="javascript:slideshow('<?php echo get_url('files', 'slideshow') ?>')"><?php echo lang('slideshow')?></a>
					</li>
					<!--li><a href="#"><?php echo lang('sharing')?></a></li-->
					<li>
						<a href="javascript:goToProperties('<?php echo get_url('files', 'edit_file') ?>')"><?php echo lang('properties')?></a>
					</li>
					<li>
						<a href="javascript:revisions('<?php echo get_url('files', 'file_details') . ',' .   active_project()->getId() ?>')"><?php echo lang('revisions and comments')?></a>
					</li>
					<li>
						<a href="javascript:download('<?php echo get_url('files', 'download_file') . ',' .   active_project()->getId() ?>')"><?php echo lang('download')?></a>
					</li>
				</ul>
			</li>
		</ul>
		<br style="clear: left;" />
	</div>

</td></tr>
<tr>
<td id="files_layout_left">

	<!-- Tree -->
	<div align="left">
		<ul class="flipMenu" id="flipMenu">
			<li>
				<a href="<?php echo get_url('files', 'index') ?>"><?php echo lang('all elements')?></a>
				<!--<ul>
					<li style="list-style-image: url(flip_google.gif)"><a href="#">Created by me</a></li>
					<li><a href="#">Flagged</a></li>
					<li><a href="#">Hidden</a></li>
					<li><a href="#">Trash</a></li>
					<li><a href="#">Editable</a></li>
					<li><a href="#">Non-editable</a></li>
				</ul>-->
			</li>
			<li>
				<a href="#"><?php echo lang('tags')?></a>
				<ul>
					<?php if (count($tags) <= 0) { ?>
					<li>
						<i>No tags yet</i>
					</li>
					<?php } ?>
					<?php foreach($tags as $tag ) { ?>
					<li>
						<a href="<?php echo get_url('files', 'index',array ('tagfilter' => $tag )) ?>"><?php  echo $tag ; ?></a>
					</li>
					<?php } ?>
				</ul>
			</li>
			<li>
				<a href="#">By Type</a>
				<ul>
					<li><a href="<?php echo get_url('files', 'index', array ('typefilter' => 'txt' )) ?>">Document</a></li>
					<li><a href="<?php echo get_url('files', 'index', array ('typefilter' => 'sprd' )) ?>" >Spreadsheet</a></li>
					<li><a href="<?php echo get_url('files', 'index', array ('typefilter' => 'prsn' )) ?>">Presentation</a></li>
					<li><a href="<?php echo get_url('files', 'index') ?>">All</a></li>
				</ul>
			</li>
			<li>
				<a href="#">Shared with</a>
				<ul>
					<li>
						<a href="#"><i>None</i></a>
					</li>
				</ul>
			</li>
		</ul>
		<!--a href="javascript:closeAllFlips()"><?php echo lang('collapse all')?></a>
		<a href="javascript:openAllFlips()"><?php echo lang('expand all')?></a-->
	</div>

</td><td>

	<!-- Document displaying grid -->
	<div>
		<table class="sortable" id="files_table">
		<!-- Add class="unsortable" to a th tag and you will not be able to sort it -->
		<tr>
			<th class="unsortable" width="15">&nbsp;</th>
			<th><?php echo lang('name') ?></th>
			<th><?php  echo lang('tags') ?></th>
			<th><?php  echo lang('users') ?></th>
			<th><?php  echo lang('last modification') ?></th>
		</tr>

		<?php $counter = 0; ?>
		<?php foreach($files as $group_by => $grouped_files) { ?>
		<!--
		Grouping
		<tr><td colspan="4" class="groupBy" style="background-color: #888888;"><?php //echo clean($group_by) ?></td></tr>-->
			<?php foreach($grouped_files as $file) { 
			$counter +=1; 
			?>

			<!--
			Private: Rather do it like Google (Owner / Collaborators / Viewers)
			   <div class="stub_check" style="float:left;">//chck</div>
				<div class="stub_important" style="float:left;">//!!</div> -->

		<tr>
		<td>
			<input type="checkbox" id="selected" name="selected" value="<?php  echo $file->getId(); ?>" style="width:15px;"/>
		</td>
		<td onclick="gotoURL('<?php echo $file->getModifyUrl() ?>');">
			<div class="fileIcon" style="display: inline">
				<img height="10" src="<?php echo $file->getTypeIconUrl() ?>" alt="<?php echo $file->getFilename() ?>" />
			</div>
			<b><?php echo clean($file->getFilename()) ?></b>
		</td>
		<td><?php echo project_object_tags($file, $file->getProject(),true) ?></td>
		<td><?php echo lang('version') . ': ' . $file->getLastRevision()->getRevisionNumber()?> </td>
		<td><?php echo format_descriptive_date($file->getCreatedOn()) ?> by  <?php echo $file->getLastRevision()->getCreatedBy()->getDisplayName() ?>  </td>
		</tr>
			<?php } // foreach ?>
		<?php } // foreach ?>

		<tr class="sortbottom">
		<td></td>	
		<td>Showing: <?php echo $counter; ?> files</td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		</table>
	</div>

</td></tr>
<tr><td colspan="2">

<?php if(isset($files) && is_array($files) && count($files)) { ?>
<div id="files">
<?php $this->includeTemplate(get_template_path('order_and_pagination', 'files')) ?>

</div>
<?php } else { ?>
<p><?php echo lang('no files on the page') ?></p>
<?php } // if ?>

</td></tr></table>