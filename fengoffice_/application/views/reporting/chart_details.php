<?php
if($chart->canDelete(logged_user())) {
    add_page_action(lang('delete chart'),  "javascript:if(confirm(lang('confirm delete chart'))) og.openLink('" . $chart->getDeleteUrl() . "');", 'ico-delete');
  }
  if ($chart->canEdit(logged_user())){
    add_page_action(lang('edit chart'), $chart->getEditUrl(), 'ico-edit');
  }
  $c = 0;
?>

<div style="padding:7px">
<div class="chart">

	<?php $description = 'pepe';
		tpl_assign("title", $chart->getTitle());
		tpl_assign("iconclass", 'ico-large-chart');
		tpl_assign("content", $chart->Draw());
		tpl_assign("object", $chart);
		
		$this->includeTemplate(get_template_path('view', 'co'));
	?>
</div>
</div>
