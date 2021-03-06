<?php
  set_page_title(lang('search results'));
?>

<div id="searchForm">
  <form class="internalForm" action="<?php echo get_url('search','search') ?>" method="get">
    <?php echo input_field('search_for', array_var($_GET, 'search_for')) ?>
    <input type="hidden" name="c" value="search" />
    <input type="hidden" name="a" value="search" />
    <input type="hidden" name="active_project" value="<?php echo (active_project())?active_project()->getId():'' ?>" />
    <?php echo submit_button(lang('search')) ?>
  </form>
</div>

<div class="searchGroup">
<?php if(isset($search_results) && is_array($search_results) && count($search_results)) { ?>
<?php foreach($search_results as $search_result) { 
	$pagination = $search_result["pagination"];?>
<br/>
	<table style="width:100%"><tr>
		<td><div class="searchTopLeft">
			<table><tr><td><div class="db-ico ico-<?php echo $search_result["icontype"]?>"></div></td>
			<td style="padding-left:5px">
			<h2><a class="internalLink" href='<?php echo get_url('search', 'searchbytype', 
			array('manager' => $search_result["manager"], 'search_for' => $search_string)); ?>'><?php echo $search_result["type"]?></a></h2>
			</td></tr></table>
		</div></td>
	<td><div class="searchTopRight">
	<?php if (isset($enable_pagination) && $pagination->getTotalItems() > $pagination->getItemsPerPage()) {?>
		<?php echo advanced_pagination($pagination, get_url('search', 
			'searchbytype',
				array('active_project' => (active_project())?active_project()->getId():'',
				'search_for' => $search_string, 'manager' => $search_result["manager"],
				'page' => '#PAGE#')), 'search_pagination'); ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php } // if ?>
	<?php echo lang('search result description short', $pagination->getStartItemNumber(),$pagination->getEndItemNumber() , $pagination->getTotalItems(), clean($search_string)) ?>
	</div></td></tr>
	<tr><td><div class="searchBottomLeft">
	
	<ul>
	<?php foreach($search_result['result'] as $result) { ?>
		 <li><a class="internalLink" href="<?php echo $result->getObjectUrl() ?>"><?php echo clean($result->getObjectName()) ?></a></li>
	<?php } // foreach ?>
	</ul>
	</div>
	</td><td><div class="searchBottomRight">
		<ul>
		<?php foreach($search_result['result'] as $result) { ?>
		 <li><?php echo lang("created by on short", $result->getCreatedByCardUrl(), $result->getCreatedByDisplayName(), format_descriptive_date($result->getObjectCreationTime())) ?></li>
		<?php } // foreach ?>
		</ul>
		
		<div style="height:20px;padding-top:5px">
		<?php if (!isset($enable_pagination) && $pagination->countItemsOnPage(1) < $pagination->getTotalItems()) { ?>
			<a class="internalLink" href='<?php echo get_url('search', 'searchbytype', 
			array('manager' => $search_result["manager"], 'search_for' => $search_string)); ?>'>
			<?php echo lang('more results', $pagination->getTotalItems() - $pagination->countItemsOnPage(1)) ?></a>
		<? } else echo "" ?> &nbsp;
		</div>
	</div></td></tr></table>
 <?php } // foreach ?>

<?php } else { ?>
<p><?php echo lang('no search result for', $search_string) ?></p>
<?php } // if ?>

<div style="width:100%;text-align:center">
	<p><?php echo lang('time used in search', sprintf("%01.2f",$time)) ?></p>
</div>
</div>