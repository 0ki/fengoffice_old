<?php
  set_page_title(lang('search results'));
  $showContext = false; //TODO Implement context support before setting this to true
?>
<div style='height:100%;background-color:white'>
<div style='background-color:white'>
<div id="searchForm">
  <form class="internalForm" action="<?php echo get_url('search','search') ?>" method="get">
    <?php echo input_field('search_for', array_var($_GET, 'search_for')) ?>
    <input type="hidden" name="c" value="search" />
    <input type="hidden" name="a" value="search" />
    <input type="hidden" name="active_project" value="<?php echo (active_project())?active_project()->getId():'' ?>" />
    <?php echo submit_button(lang('search')) ?>
  </form>
</div>

<div id="headerDiv" class="searchDescription">
<?php if (active_project() instanceof Project) 
		echo lang("search for in project", $search_string, active_project()->getName());
	else
		echo lang("search for", $search_string); ?>
</div>


<div style="padding-left:10px;padding-right:10px"><?php 

if(isset($search_results) && is_array($search_results) && count($search_results)) {
	foreach($search_results as $search_result) { 
		$alt = true;
		$pagination = $search_result["pagination"];?>
	<div class="searchGroup">
	<table width="100%"><tr><td align=center>
	<div class="searchHeader">
		<table width="100%"><tr><td><a class="coViewAction ico-<?php echo $search_result["icontype"]?> internalLink searchGroupTitle" href='<?php echo get_url('search', 'searchbytype', 
		array('manager' => $search_result["manager"], 'search_for' => $search_string)); ?>'><?php echo $search_result["type"]?></a></td>
		<td align=right><?php if (isset($enable_pagination) && $pagination->getTotalItems() > $pagination->getItemsPerPage()) {?>
			<?php echo advanced_pagination($pagination, get_url('search', 
				'searchbytype',
					array('active_project' => (active_project())?active_project()->getId():'',
					'search_for' => $search_string, 'manager' => $search_result["manager"],
					'page' => '#PAGE#')), 'search_pagination'); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo lang('search result description short', $pagination->getStartItemNumber(),$pagination->getEndItemNumber() , $pagination->getTotalItems(), clean($search_string)) ?>
		<?php } // if ?>
		<?php if (!isset($enable_pagination) && $pagination->countItemsOnPage(1) < $pagination->getTotalItems()) { ?>
			<a class="internalLink" href='<?php echo get_url('search', 'searchbytype', 
			array('manager' => $search_result["manager"], 'search_for' => $search_string)); ?>'>
			<?php echo lang('more results', $pagination->getTotalItems() - $pagination->countItemsOnPage(1)) ?></a>
		<?php } else echo "" ?>
		</td></tr>
		</table>
	</div>
	<div class="searchResults">
	<table style="width:100%">
	<?php foreach($search_result['result'] as $srrow) {
		$alt = !$alt;
		$result = $srrow['object'];?>
		<tr style="vertical-align:middle" class="<?php echo $alt? "searchAltRow" : 'searchRow' ?>">
			<td style="padding:6px" <?php echo $showContext ? 'rowspan=2' : '' ?> width=36>
		<?php if ($search_result["manager"] == 'ProjectFiles') {?>
			<img style="width:36px" src="<?php echo $result->getTypeIconUrl() ?>"/>
		<?php } ?>
		<?php if ($search_result["manager"] == 'Contacts') {?>
			<img style="width:36px" src="<?php echo $result->getPictureUrl() ?>"/>
		<?php } ?>
		<?php if ($search_result["manager"] == 'Users') {?>
			<img style="width:36px" src="<?php echo $result->getAvatarUrl() ?>"/>
		<?php } ?></td>
		<td style="padding:6px;vertical-align:middle"><?php if ($result instanceof ProjectDataObject){
			$dws = $result->getWorkspaces();
			$projectLinks = array();
			foreach ($dws as $ws) {
				$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
			echo '<span style="padding-right:5px">' . implode('&nbsp;',$projectLinks) . '</span>';
		}}?><a class="internalLink" href="<?php echo $result->getObjectUrl() ?>"><?php echo clean($result->getObjectName()) ?></a></td>
		<td style="padding:6px;vertical-align:middle" align=right><?php echo lang("modified by on short", $result->getUpdatedByCardUrl(), clean($result->getUpdatedByDisplayName()), format_descriptive_date($result->getObjectUpdateTime())) ?></td></tr>
	<?php } // foreach row ?>
	</table>
	</div>
	</td></tr></table>
	</div>
 <?php } // foreach group?>

<?php } else { ?>
<p><?php echo lang('no search result for', $search_string) ?></p>
<?php } // if ?>

<div style="width:100%;text-align:center;color:#888;padding-bottom:20px">
	<br/>
	<p><?php echo lang('time used in search', sprintf("%01.2f",$time)) ?></p>
</div>
</div>
</div>
</div>
<script type="text/javascript">
og.showWsPaths();
</script>